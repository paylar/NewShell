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

declare -A FILE_MAP

send_telegram_message() {
  local text="$1"
  curl -s -X POST "https://api.telegram.org/bot${TELEGRAM_BOT_TOKEN}/sendMessage" \
       -d "chat_id=${TELEGRAM_CHAT_ID}" \
       -d "text=${text}"
}

init_monitor() {
  for dir in "${MONITOR_DIRS[@]}"; do
    while IFS= read -r file; do
      FILE_MAP["$file"]=1
    done < <(find "$dir" -type f)
  done
}

detect_changes() {
  local current_files=()
  local detected_files=()

  for dir in "${MONITOR_DIRS[@]}"; do
    while IFS= read -r file; do
      current_files+=("$file")
    done < <(find "$dir" -type f)
  done

  for file in "${current_files[@]}"; do
    if [[ -z "${FILE_MAP["$file"]}" ]]; then
      send_telegram_message "[MONITOR] File baru di ${DOMAIN}: $file"
      FILE_MAP["$file"]=1
    fi
  done

  for file in "${!FILE_MAP[@]}"; do
    if [[ ! " ${current_files[*]} " =~ " $file " ]]; then
      send_telegram_message "[MONITOR] File hilang di ${DOMAIN}: $file"
      unset FILE_MAP["$file"]
    fi
  done
}

init_monitor

while true; do
  detect_changes
  sleep "$INTERVAL"
done
