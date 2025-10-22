#!/bin/bash
set -e

# Config Backup Script
# Usage: ./scripts/config-backup.sh

BACKUP_DIR=".config-backups"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
BACKUP_PATH="$BACKUP_DIR/$TIMESTAMP"

mkdir -p "$BACKUP_PATH"

if [ -f "apps/web/.env" ]; then
  cp apps/web/.env "$BACKUP_PATH/web.env"
  echo "✅ Backed up apps/web/.env"
fi

if [ -f "apps/api/.env" ]; then
  cp apps/api/.env "$BACKUP_PATH/api.env"
  echo "✅ Backed up apps/api/.env"
fi

echo "✅ Backup saved to: $BACKUP_PATH"

# Keep only last 10 backups
ls -t $BACKUP_DIR | tail -n +11 | xargs -I {} rm -rf "$BACKUP_DIR/{}"
