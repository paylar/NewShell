#!/usr/bin/env bash

if [[ $# -lt 2 ]]; then
  echo "Penggunaan: $0 <domain> <direktori1> [<direktori2> ...]"
  exit 1
fi

DOMAIN="$1"
shift
MONITOR_DIRS=("$@")

# Periksa validitas direktori
for dir in "${MONITOR_DIRS[@]}"; do
  if [[ ! -d "$dir" ]]; then
    echo "Direktori tidak valid: $dir"
    exit 1
  fi
done

TELEGRAM_BOT_TOKEN="6598877714:AAFGR7OVC1YchGkhP8WrVinz4wwLAyVMSh8"
TELEGRAM_CHAT_ID="-1002152193505"
INTERVAL=30
LOG_FILE="file_monitor.log"

send_telegram_message() {
  local text="$1"
  curl -s -X POST "https://api.telegram.org/bot${TELEGRAM_BOT_TOKEN}/sendMessage" \
       -d "chat_id=${TELEGRAM_CHAT_ID}" \
       -d "text=${text}"
}

init_monitor() {
  > "$LOG_FILE"  # Hapus isi file log sebelumnya
  for dir in "${MONITOR_DIRS[@]}"; do
    find "$dir" -type f | while IFS= read -r file; do
      echo "$file" >> "$LOG_FILE"
    done
  done
}

detect_changes() {
  local current_files="$(mktemp)"
  local new_files="$(mktemp)"

  # Scan ulang semua file saat ini
  for dir in "${MONITOR_DIRS[@]}"; do
    find "$dir" -type f >> "$current_files"
  done

  # Deteksi file baru
  comm -13 "$LOG_FILE" "$current_files" > "$new_files"
  while IFS= read -r new_file; do
    send_telegram_message "[MONITOR] File baru di ${DOMAIN}: $new_file"
    echo "$new_file" >> "$LOG_FILE"
  done < "$new_files"

  # Deteksi file yang dihapus
  while IFS= read -r logged_file; do
    if ! grep -Fxq "$logged_file" "$current_files"; then
      send_telegram_message "[MONITOR] File hilang di ${DOMAIN}: $logged_file"
      sed -i "\|$logged_file|d" "$LOG_FILE"
    fi
  done < "$LOG_FILE"

  rm -f "$current_files" "$new_files"
}

# Inisialisasi monitoring
init_monitor

# Jalankan loop untuk mendeteksi perubahan
while true; do
  detect_changes
  sleep "$INTERVAL"
done
