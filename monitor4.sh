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

declare -A PREV_HASHES
function get_md5() {
  local file_path="$1"
  if [[ -f "$file_path" ]]; then
    md5sum "$file_path" | awk '{print $1}'
  else
    echo "MISSING"
  fi
}

function send_telegram_message() {
  local text="$1"
  curl -s -X POST "https://api.telegram.org/bot${TELEGRAM_BOT_TOKEN}/sendMessage" \
       -d "chat_id=${TELEGRAM_CHAT_ID}" \
       -d "text=${text}"
}

function init_hashes() {
  for dir in "${MONITOR_DIRS[@]}"; do
    find "$dir" -type f | while read -r file; do
      PREV_HASHES["$file"]="$(get_md5 "$file")"
    done
  done
}

function check_changes() {
  declare -A CURRENT_HASHES

  for dir in "${MONITOR_DIRS[@]}"; do
    find "$dir" -type f | while read -r file; do
      current_md5="$(get_md5 "$file")"
      CURRENT_HASHES["$file"]="$current_md5"

      if [[ -z "${PREV_HASHES[$file]}" ]]; then
        send_telegram_message "[MONITOR] File baru ditemukan di ${DOMAIN}: $file"
      elif [[ "${PREV_HASHES[$file]}" != "$current_md5" ]]; then
        if [[ "$current_md5" == "MISSING" ]]; then
          send_telegram_message "[MONITOR] File terhapus di ${DOMAIN}: $file"
        else
          send_telegram_message "[MONITOR] File berubah di ${DOMAIN}: $file"
        fi
      fi
    done
  done

  for file in "${!PREV_HASHES[@]}"; do
    if [[ -z "${CURRENT_HASHES[$file]}" ]]; then
      send_telegram_message "[MONITOR] File dihapus di ${DOMAIN}: $file"
    fi
  done

  PREV_HASHES=("${CURRENT_HASHES[@]}")
}

init_hashes
while true; do
  check_changes
  sleep "$INTERVAL"
done
