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

declare -A TRACKED_FILES

detect_deleted_files() {
  declare -A CURRENT_FILES

  # Scan ulang semua file saat ini
  for dir in "${MONITOR_DIRS[@]}"; do
    find "$dir" -type f | while IFS= read -r file; do
      CURRENT_FILES["$file"]=1
    done
  done

  # Periksa file yang hilang
  for file in "${!TRACKED_FILES[@]}"; do
    if [[ -z "${CURRENT_FILES["$file"]}" ]]; then
      send_telegram_message "[MONITOR] File hilang di ${DOMAIN}: $file"
      unset TRACKED_FILES["$file"]
    fi
  done

  # Perbarui daftar file yang dilacak
  TRACKED_FILES=()
  for file in "${!CURRENT_FILES[@]}"; do
    TRACKED_FILES["$file"]=1
  done
}

send_telegram_message() {
  local text="$1"
  curl -s -X POST "https://api.telegram.org/bot${TELEGRAM_BOT_TOKEN}/sendMessage" \
       -d "chat_id=${TELEGRAM_CHAT_ID}" \
       -d "text=${text}"
}

init_monitor() {
  for dir in "${MONITOR_DIRS[@]}"; do
    find "$dir" -type f | while IFS= read -r file; do
      TRACKED_FILES["$file"]=1
    done
  done
}

# Inisialisasi monitoring
init_monitor

# Jalankan loop untuk mendeteksi perubahan
while true; do
  detect_deleted_files
  sleep "$INTERVAL"
done
