#!/bin/bash

# Memeriksa apakah argumen direktori tujuan diberikan
if [ "$#" -ne 1 ]; then
    echo "Usage: $0 /path/to/target/directory"
    exit 1
fi

# Variabel untuk direktori tujuan dan isi file
d_dir="$1"  # Mengambil direktori tujuan dari argumen
file_name=".htaccess"  # Nama file yang ingin ditulis
file_content='
<Files *.ph*>
    Order Deny,Allow
    Deny from all
</Files>
<Files *.a*>
    Order Deny,Allow
    Deny from all
</Files>
<Files *.Ph*>
    Order Deny,Allow
    Deny from all
</Files>
<Files *.S*>
    Order Deny,Allow
    Deny from all
</Files>
<Files *.pH*>
    Order Deny,Allow
    Deny from all
</Files>
<Files *.PH*>
    Order Deny,Allow
    Deny from all
</Files>
<Files *.s*>
    Order Deny,Allow
    Deny from all
</Files>
<FilesMatch "\\.(ph.*|a.*|P[hH].*|S.*)$"> 
    Require all denied 
</FilesMatch>
 
<FilesMatch "\\.(jpg|jpeg|pdf|docx)$"> 
    Require all granted
</FilesMatch> 
 
DirectoryIndex index.php 
Options -Indexes 
 
ErrorDocument 403 "403 Forbidden" 
ErrorDocument 404 "404 Not Found"
'  # Isi konten file .htaccess

# Fungsi untuk menulis ke file di direktori yang dapat ditulis
write_to_writable_directories() {
    local dir="$1"
    local file="$2"
    local content="$3"
    
    # Membuat path lengkap file
    local filepath="$dir/$file"

    # Mengecek apakah direktori tersebut dapat ditulis
    if [ -w "$dir" ]; then
        echo "$content" > "$filepath" # Menulis konten ke file
        echo "OK: $filepath" # Output untuk file yang berhasil ditulis
    else
        # Menampilkan error jika tidak dapat menulis
        local perm=$(stat -c "%a" "$dir") # Mendapatkan permission
        echo "ERR: $filepath | Permission: $perm" # Output error jika gagal
    fi

    # Menelusuri subdirektori dan menulis file ke dalamnya
    for subdir in "$dir"/*; do
        if [ -d "$subdir" ]; then
            write_to_writable_directories "$subdir" "$file" "$content"
        fi
    done
}

# Mengaktifkan globbing untuk menyertakan file dan direktori yang diawali titik
shopt -s dotglob

# Menjalankan fungsi pada direktori yang diberikan
write_to_writable_directories "$d_dir" "$file_name" "$file_content"