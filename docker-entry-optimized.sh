#!/bin/sh
set -e

APP_ENV=${APP_ENV:-production}
APP_SITE=${APP_SITE:-main}
OCTANE_PORT=${OCTANE_PORT:-8000}

echo "🚀 Starting Laravel Octane container"
echo "Environment: $APP_ENV"
echo "Site: $APP_SITE"
echo "Port: $OCTANE_PORT"

# Ensure storage directories exist and have correct permissions
mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views
chmod -R 775 storage bootstrap/cache

# Cache configuration for production
if [ "$APP_ENV" = "production" ]; then
    echo "📦 Optimizing for production..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan event:cache
fi

# Run database migrations if needed (optional, can be done in deployment)
if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    echo "🗄️  Running database migrations..."
    php artisan migrate --force
fi

# Build Octane command based on environment
if [ "$APP_ENV" = "production" ]; then
    # Production: optimized settings
    OCTANE_CMD="php artisan octane:start --server=swoole --host=0.0.0.0 --port=$OCTANE_PORT --workers=4 --task-workers=8 --max-requests=500"
else
    # Development: fewer resources
    OCTANE_CMD="php artisan octane:start --server=swoole --host=0.0.0.0 --port=$OCTANE_PORT --workers=2 --task-workers=4 --max-requests=100"
fi

echo "🎯 Starting Octane with command: $OCTANE_CMD"

# Handle graceful shutdown
trap 'echo "🛑 Shutting down gracefully..."; kill -TERM $PID; wait $PID' TERM INT

# Start Octane in background and wait
eval $OCTANE_CMD &
PID=$!
wait $PID