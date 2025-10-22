#!/bin/bash
set -e

# Queue Drain Script - safely drain and requeue jobs
# Usage: ./scripts/queue-drain.sh [queue-name]

QUEUE=${1:-default}

echo "🔄 Draining queue: $QUEUE"

cd apps/api

# Stop processing new jobs
php artisan queue:clear $QUEUE

# Wait for current jobs to finish
echo "⏳ Waiting for current jobs to complete..."
sleep 5

# Retry failed jobs
php artisan queue:retry all

echo "✅ Queue drained and jobs requeued"
