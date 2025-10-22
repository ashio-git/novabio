#!/bin/bash
set -e

# Database Migration Rollback Script
# Usage: ./scripts/db-rollback.sh [steps]

STEPS=${1:-1}

echo "🔄 Rolling back $STEPS migration step(s)..."

cd apps/api

php artisan migrate:rollback --step=$STEPS

echo "✅ Rollback complete"
