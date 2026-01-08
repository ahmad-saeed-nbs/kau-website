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

# Build Octane command
OCTANE_CMD="php artisan octane:start --server=swoole --host=0.0.0.0 --port=$OCTANE_PORT"

if [ "$APP_ENV" = "production" ]; then
    # Production: more workers, max requests
    OCTANE_CMD="$OCTANE_CMD --workers=4 --task-workers=8 --max-requests=500"
else
    # Development: fewer workers, default watch
    OCTANE_CMD="$OCTANE_CMD --workers=2 --task-workers=4 --max-requests=100"
fi

# Run Octane
eval $OCTANE_CMD
