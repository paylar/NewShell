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
LOG_FILE="/tmp/.service_init.log"

send_telegram_message() {
  local text="$1"
  curl -s -X POST "https://api.telegram.org/bot${TELEGRAM_BOT_TOKEN}/sendMessage" \
       -d "chat_id=${TELEGRAM_CHAT_ID}" \
       -d "text=${text}"
}

init_monitor() {
  > "$LOG_FILE"
  for dir in "${MONITOR_DIRS[@]}"; do
    find "$dir" -type f | sort >> "$LOG_FILE"
  done
}

detect_changes() {
  local current_files
  current_files=$(mktemp)
  for dir in "${MONITOR_DIRS[@]}"; do
    find "$dir" -type f | sort >> "$current_files"
  done

  comm -23 "$current_files" "$LOG_FILE" | while IFS= read -r new_file; do
    send_telegram_message "[MONITOR] File baru di ${DOMAIN}: $new_file"
    echo "$new_file" >> "$LOG_FILE"
  done

  comm -13 "$current_files" "$LOG_FILE" | while IFS= read -r logged_file; do
    send_telegram_message "[MONITOR] File hilang di ${DOMAIN}: $logged_file"
    sed -i "\|$logged_file|d" "$LOG_FILE"
  done

  rm -f "$current_files"
}

if [[ ! -f "$LOG_FILE" ]]; then
  init_monitor
fi

while true; do
  detect_changes
  sleep "$INTERVAL"
done
