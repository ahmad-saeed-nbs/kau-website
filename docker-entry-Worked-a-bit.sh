#!/bin/bash
set -e

# Default environment
APP_ENV=${APP_ENV:-development}
APP_SITE=${APP_SITE:-main}

# Automatic port assignment
if [ "$APP_SITE" = "main" ]; then
    if [ "$APP_ENV" = "production" ]; then
        OCTANE_PORT=8000
    else
        OCTANE_PORT=8080
    fi
elif [ "$APP_SITE" = "faculty" ]; then
    if [ "$APP_ENV" = "production" ]; then
        OCTANE_PORT=8001
    else
        OCTANE_PORT=8081
    fi
else
    # Fallback
    OCTANE_PORT=8000
fi

echo "Starting container for APP_SITE=$APP_SITE in $APP_ENV mode on port $OCTANE_PORT"

# Install dev dependencies if needed
if [ "$APP_ENV" = "development" ]; then
    if [ ! -d "vendor" ]; then
        echo "Installing composer dependencies..."
        composer install
    fi
fi

# Ensure log directory exists
mkdir -p /var/log/octane

# Start Octane
if [ "$APP_ENV" = "production" ]; then
    php artisan octane:start \
        --server=swoole \
        --host=0.0.0.0 \
        --port=$OCTANE_PORT \
        --workers=4 \
        --task-workers=8 \
        --max-requests=500 \
        --watch=false \
        --log=/var/log/octane/octane.log
else
    php artisan octane:start \
        --server=swoole \
        --host=0.0.0.0 \
        --port=$OCTANE_PORT \
        --workers=2 \
        --task-workers=4 \
        --max-requests=100
fi
