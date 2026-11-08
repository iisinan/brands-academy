#!/bin/sh
set -e

echo "=== Brands Academy Nigeria Foundation Entrypoint ==="

# ── Ensure storage and cache directories exist ──
mkdir -p /app/storage/framework/views \
         /app/storage/framework/cache/data \
         /app/storage/framework/sessions \
         /app/storage/logs \
         /app/storage/app/public \
         /app/bootstrap/cache
chmod -R 775 /app/storage /app/bootstrap/cache
chown -R www-data:www-data /app/storage /app/bootstrap/cache 2>/dev/null || true

# ── Ensure .env exists ──
touch /app/.env

# ── Clear stale cached bootstrap files ──
rm -f /app/bootstrap/cache/config.php \
      /app/bootstrap/cache/routes.php \
      /app/bootstrap/cache/services.php \
      /app/bootstrap/cache/packages.php 2>/dev/null || true

# ── APP_KEY check ──
if [ -z "$APP_KEY" ]; then
    echo "APP_KEY missing — generating..."
    php artisan key:generate --force
fi

# ── Clear artisan caches ──
php artisan config:clear || true
php artisan route:clear  || true
php artisan view:clear   || true

# ── PostgreSQL Schema Isolation ──
# CRITICAL: Ensures we NEVER touch other applications' tables in Postgres-HZsb!
if [ -n "$DB_SCHEMA" ] && [ "$DB_SCHEMA" != "public" ]; then
    echo "=== Ensuring PostgreSQL schema '$DB_SCHEMA' exists in database ==="
    php artisan tinker --execute="DB::statement('CREATE SCHEMA IF NOT EXISTS \"' . env('DB_SCHEMA') . '\"');" || echo "WARN: Schema check/create handled or failed"
fi

# ── Run Migrations ──
echo "=== Running Database Migrations ==="
php artisan migrate --force || echo "WARN: Migrations failed — check DB connection"

# ── Seed Default Data if Users table is empty ──
echo "=== Checking & Seeding Initial Data ==="
php artisan tinker --execute="if (\App\Models\User::count() === 0) { \Artisan::call('db:seed', ['--force' => true]); echo \Artisan::output(); }" || echo "WARN: Seeding skipped or failed"

# ── Symlink public storage ──
php artisan storage:link --force || true

# ── Production Caches ──
echo "=== Warming Production Caches ==="
php artisan config:cache || echo "WARN: Config cache failed"
php artisan route:cache  || echo "WARN: Route cache failed"
php artisan view:cache   || echo "WARN: View cache failed"

# ── Start Caddy + FrankenPHP Server ──
export PORT="${PORT:-8080}"
echo "=== Starting FrankenPHP Server on port $PORT ==="
exec frankenphp run --config /app/Caddyfile
