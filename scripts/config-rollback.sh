#!/bin/bash
set -e

# Config Rollback Script
# Usage: ./scripts/config-rollback.sh [backup-timestamp]

BACKUP_DIR=".config-backups"
TIMESTAMP=${1:-$(ls -t $BACKUP_DIR | head -1)}

if [ -z "$TIMESTAMP" ]; then
  echo "❌ No backup found"
  exit 1
fi

echo "🔄 Rolling back to config: $TIMESTAMP"

if [ -f "$BACKUP_DIR/$TIMESTAMP/web.env" ]; then
  cp "$BACKUP_DIR/$TIMESTAMP/web.env" apps/web/.env
  echo "✅ Restored apps/web/.env"
fi

if [ -f "$BACKUP_DIR/$TIMESTAMP/api.env" ]; then
  cp "$BACKUP_DIR/$TIMESTAMP/api.env" apps/api/.env
  echo "✅ Restored apps/api/.env"
fi

echo "✅ Rollback complete"
