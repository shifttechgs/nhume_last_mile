#!/bin/sh
set -e

cd /var/www/html

echo "==> Writing .env"
cat > .env << EOF
APP_NAME="Nhume"
APP_ENV=production
APP_KEY=${APP_KEY:-}
APP_DEBUG=false
APP_URL=${APP_URL:-http://localhost:10000}

LOG_CHANNEL=stderr
LOG_LEVEL=error

DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false

CACHE_STORE=file

QUEUE_CONNECTION=sync

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local

MAIL_MAILER=log
MAIL_FROM_ADDRESS="hello@nhume.co.zw"
MAIL_FROM_NAME="Nhume"
EOF

echo "==> Creating SQLite database"
touch database/database.sqlite

echo "==> Generating app key"
php artisan key:generate --force

echo "==> Discovering packages"
php artisan package:discover --ansi

echo "==> Running migrations and seeding"
php artisan migrate:fresh --seed --force

echo "==> Linking storage"
php artisan storage:link --force 2>/dev/null || true

echo "==> Caching config, routes, views"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Starting server on port ${PORT:-10000}"
exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
