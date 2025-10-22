# NovaBio

Multi-tenant Link-in-Bio SaaS with Ad-Space Marketplace

## Architecture

- **Frontend**: Next.js 15 + React 19 + TypeScript (`apps/web`)
- **Backend**: Laravel 11 + Octane (`apps/api`)
- **Database**: PostgreSQL 16
- **Cache/Queue**: Redis 7
- **Storage**: MinIO (S3-compatible)
- **Search**: Meilisearch
- **Payments**: Mercado Pago

## Development

```bash
# Start all services
docker compose up -d

# Web: http://localhost:3000
# API: http://localhost:8000
# Mailpit: http://localhost:8025
# MinIO Console: http://localhost:9001
```

## Testing

```bash
# Web tests
cd apps/web && npm test

# API tests
cd apps/api && php artisan test
```

## CI/CD

GitHub Actions runs on push:
- Lint, typecheck, test, build for both apps
- Docker image builds
- Staging deploy on main branch
