#!/bin/bash

# Konfigurasi
USERNAME="toku"
PASSWORD="toku123Haxor#"
VPS_IP="109.105.194.190"
TTYD_PORT=1337
FILEBROWSER_PORT=1339

# Fungsi untuk mengecek apakah perintah berhasil dijalankan
check_command() {
    if [ $? -ne 0 ]; then
        echo "Error: Gagal menjalankan perintah terakhir"
        exit 1
    fi
}

# Update sistem dan instal dependensi
echo "Memperbarui sistem dan menginstal dependensi..."
sudo apt-get update -y
sudo apt-get upgrade -y
sudo apt-get install -y nginx wget curl unzip

# Instal ttyd (web terminal)
echo "Menginstal ttyd..."
wget https://github.com/tsl0922/ttyd/releases/latest/download/ttyd.x86_64 -O ttyd
check_command
chmod +x ttyd
sudo mv ttyd /usr/local/bin/

# Buat service ttyd
echo "Membuat service ttyd..."
sudo tee /etc/systemd/system/ttyd.service > /dev/null <<EOL
[Unit]
Description=ttyd Service
After=network.target

[Service]
User=$USERNAME
ExecStart=/usr/local/bin/ttyd -p $TTYD_PORT -c $USERNAME:$PASSWORD bash
Restart=always

[Install]
WantedBy=multi-user.target
EOL

# Instal FileBrowser
echo "Menginstal FileBrowser..."
FB_VERSION=$(curl -s https://api.github.com/repos/filebrowser/filebrowser/releases/latest | grep tag_name | cut -d '"' -f 4)
wget "https://github.com/filebrowser/filebrowser/releases/download/${FB_VERSION}/linux-amd64-filebrowser.tar.gz"
check_command
tar -xzf linux-amd64-filebrowser.tar.gz
chmod +x filebrowser
sudo mv filebrowser /usr/local/bin/

# Setup FileBrowser
echo "Menyiapkan FileBrowser..."
sudo mkdir -p /etc/filebrowser
sudo filebrowser config init -d /etc/filebrowser/filebrowser.db
sudo filebrowser config set -d /etc/filebrowser/filebrowser.db --address 0.0.0.0 --port $FILEBROWSER_PORT
sudo filebrowser users update admin --username $USERNAME --password $PASSWORD -d /etc/filebrowser/filebrowser.db

# Buat service FileBrowser
echo "Membuat service FileBrowser..."
sudo tee /etc/systemd/system/filebrowser.service > /dev/null <<EOL
[Unit]
Description=FileBrowser Service
After=network.target

[Service]
User=$USERNAME
ExecStart=/usr/local/bin/filebrowser -d /etc/filebrowser/filebrowser.db
Restart=always

[Install]
WantedBy=multi-user.target
EOL

# Setup Nginx sebagai reverse proxy
echo "Mengatur Nginx..."
sudo tee /etc/nginx/sites-available/web-console > /dev/null <<EOL
server {
    listen 80;
    server_name $VPS_IP;

    location / {
        root /var/www/html;
        index index.html;
    }

    location /terminal {
        proxy_pass http://127.0.0.1:$TTYD_PORT;
        proxy_set_header Host \$host;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
    }

    location /files {
        proxy_pass http://127.0.0.1:$FILEBROWSER_PORT;
        proxy_set_header Host \$host;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
    }
}
EOL

# Buat halaman utama sederhana
echo "Membuat halaman utama..."
sudo mkdir -p /var/www/html
sudo tee /var/www/html/index.html > /dev/null <<EOL
<!DOCTYPE html>
<html>
<head>
    <title>VPS Management Console</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; }
        h1 { color: #333; }
        .container { max-width: 800px; margin: 0 auto; }
        .button {
            display: inline-block;
            padding: 1rem 2rem;
            margin: 0.5rem;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>VPS Management Console</h1>
        <a href="/terminal" class="button">Web Terminal</a>
        <a href="/files" class="button">File Manager</a>
    </div>
</body>
</html>
EOL

# Aktifkan konfigurasi Nginx
sudo ln -sf /etc/nginx/sites-available/web-console /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default

# Restart layanan
echo "Me-restart layanan..."
sudo systemctl daemon-reload
sudo systemctl enable ttyd filebrowser nginx
sudo systemctl restart ttyd filebrowser nginx

# Setup firewall jika UFW aktif
if command -v ufw &> /dev/null; then
    echo "Mengatur firewall..."
    sudo ufw allow 80/tcp
    sudo ufw allow 22/tcp
    sudo ufw reload
fi

echo "Setup selesai!"
echo "Akses melalui:"
echo "http://$VPS_IP"
echo "Username: $USERNAME"
echo "Password: $PASSWORD"