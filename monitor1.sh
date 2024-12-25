#!/usr/bin/env bash

if [[ $# -lt 2 ]]; then
  echo "Penggunaan: $0 <domain> <direktori1> [<direktori2> ...]"
  exit 1
fi

DOMAIN="$1"
shift
MONITOR_DIRS=("$@")
for dir in "${MONITOR_DIRS[@]}"; do
  if [[ ! -d "$dir" ]]; then
    echo "Direktori tidak valid: $dir"
    exit 1
  fi
done

TELEGRAM_BOT_TOKEN="6598877714:AAFGR7OVC1YchGkhP8WrVinz4wwLAyVMSh8"
TELEGRAM_CHAT_ID="-1002152193505"
INTERVAL=30

declare -A PREV_FILES

detect_changes() {
  declare -A CURRENT_FILES

  for dir in "${MONITOR_DIRS[@]}"; do
    find "$dir" -type f | while IFS= read -r file; do
      CURRENT_FILES["$file"]=1

      if [[ -z "${PREV_FILES["$file"]}" ]]; then
        send_telegram_message "[MONITOR] File baru ditemukan di ${DOMAIN}: $file"
      fi
    done
  done

  for file in "${!PREV_FILES[@]}"; do
    if [[ -z "${CURRENT_FILES["$file"]}" ]]; then
      send_telegram_message "[MONITOR] File terhapus di ${DOMAIN}: $file"
    fi
  done

  PREV_FILES=()
  for file in "${!CURRENT_FILES[@]}"; do
    PREV_FILES["$file"]=1
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
      PREV_FILES["$file"]=1
    done
  done
}

init_monitor

while true; do
  detect_changes
  sleep "$INTERVAL"
done
