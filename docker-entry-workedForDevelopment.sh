#!/bin/bash
set -e

APP_ENV=${APP_ENV:-production}
APP_SITE=${APP_SITE:-main}

OCTANE_PORT=8000   # Internal container port

echo "Starting container for APP_SITE=$APP_SITE in $APP_ENV mode on port $OCTANE_PORT"

# Install dependencies if not already installed (mainly for local dev)
if [ "$APP_ENV" != "production" ] && [ ! -d "vendor" ]; then
    echo "Installing composer dependencies..."
    composer install
fi

# Ensure log directory exists
mkdir -p /var/log/octane

# Start Laravel Octane
php artisan octane:start \
    --server=swoole \
    --host=0.0.0.0 \
    --port=$OCTANE_PORT \
    --workers=$([ "$APP_ENV" = "production" ] && echo 4 || echo 2) \
    --task-workers=$([ "$APP_ENV" = "production" ] && echo 8 || echo 4) \
    --max-requests=$([ "$APP_ENV" = "production" ] && echo 500 || echo 100) \
    $( [ "$APP_ENV" = "production" ] && echo "--watch=false --log=/var/log/octane/octane.log" )
