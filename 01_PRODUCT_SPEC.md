# 01_PRODUCT_SPEC.md
Title: NovaBio — Multi-tenant Link-in-Bio SaaS with Ad-Space Marketplace

## 0. Non-Negotiable Build Rules (Anti-Hallucination Protocol)
- Ground truth = this spec. No silent scope changes. Any delta must append to “Changelog” and reference an issue ID.
- Every feature ships with: schema, API contract, UI states, analytics events, permissions, tests, and monitoring.
- Each task has acceptance criteria (AC), test cases (TC), and a rollback plan (RB).
- Use deterministic scaffolds and codegen where possible. Lock library versions. No “TODO later”.
- All flows documented as state machines. No hidden states.
- Definition of Done (DoD) applies per component and per flow.

## 1. Mission
Create a zero-friction, production-grade, multi-tenant Link-in-Bio platform where creators build profile microsites and monetize ad “slots” in their bios. Includes a marketplace for buying, selling, or swapping slots. Targets BRL with Mercado Pago for PIX and cards. Ships dark and light themes. Ready for scale. Not an MVP.

## 2. Personas
- Super Admin (Owner): runs the SaaS, billing, compliance, abuse, payouts, feature flags.
- Workspace Owner (Creator): manages one or more “Sites” (bio pages), sells ad slots, buys slots, custom domain, analytics.
- Collaborator (Manager/Guest): limited access to specific sites for editing, scheduling, marketplace management.
- Visitor/Buyer: views bio pages, clicks links, buys or bids for ad slots, follows CTAs.

## 3. Core Capabilities
- Multi-tenancy: orgs (“Workspaces”) with Sites; each Site has a public URL: `app.tld/u/{username}` or `{username}.app.tld` or custom domain.
- Zero-friction onboarding: username availability check on landing. Passwordless email (magic link + 6-digit code). Optional OAuth later.
- WYSIWYG bio builder: block-based, real-time preview, inline editing, drag and drop, version history, undo/redo.
- Templates and themes: curated templates; theme tokens; dark/light; per-block style presets.
- Marketplace for ad slots: list slots with audience metrics; sell, auction, or barter; escrow and scheduled placements; ratings and proofs.
- Payments: Mercado Pago (PIX, credit/debit) for subscriptions, one-offs, escrow, platform fee.
- Subscriptions and plans: tiered features, metering, seat limits, usage add-ons, coupon codes, proration, dunning.
- Analytics: clicks, CTR, conversions, top referrers, UTM, geo (country/city), device, A/B tests for link order and CTAs.
- Collaborators: invite by email with role scopes per site. Audit log.
- Domains: subdomain + path + custom domain with DNS verification and auto-TLS (ACME). 1-click connect via TXT/CNAME.
- Compliance: LGPD/GDPR basics, cookie banner, data export/delete, ToS/PP versioning.
- Observability: logs, traces, metrics, alerting, SLOs.

## 4. Product Surface (Pages and Exact Contents)

### 4.1 Public Marketing Site
- **Home (hero)**: username availability search; instant feedback; CTA “Create my Bio”.
- **How it works**: 3-step diagram (claim name → design → monetize).
- **Templates gallery**: live previews, filters, “Use this template”.
- **Pricing**: Free, Pro, Business; features matrix; BRL; taxes note; FAQ; legal links.
- **Marketplace (browse)**: search slots; filters by category, followers, traffic, price, dates; cards with metrics; “Request placement”.
- **Status**: component showing uptime; link to detailed status page.
- **Docs**: product docs and API reference.
- **Auth**: Magic link + 6-digit code screen; re-send; device trust explanation.
- **Legal**: ToS, Privacy, DPA, Cookies.

### 4.2 Super Admin Dashboard
- **Overview**: MRR, ARR, churn, LTV, ARPA, active workspaces, active sites, marketplace GMV, payouts pending, incidents. Time filters. Download CSV.
- **Tenants**: list, search; view org details, seats, plan, invoices, usage, flags; impersonate; suspend/reactivate.
- **Billing ops**: platform fees, tax settings, payout cadence; refund tool; invoice viewer.
- **Marketplace ops**: disputes queue, arbitration tools, abuse flags, takedown actions; slot policy editor.
- **Templates/Themes**: CRUD templates; versioning; “promote to default”.
- **Feature flags**: staged rollout per plan or cohort; kill switches.
- **Moderation**: content review queue; ML suggestions; blocklists; rate-limit overrides.
- **Developers**: API keys, webhook endpoints list, logs, retry; schema explorer; changelog.
- **System health**: error rate, p95 latency, queue depths, job failures, storage usage; alerts.
- **Audit log**: all privileged actions with actor, target, IP, user agent.

### 4.3 Workspace Owner Dashboard
- **Home**: snapshot for all sites; clicks, CTR, top links, marketplace revenue, active placements, dunning alerts.
- **Sites**:
  - List sites; create site (choose template, name, domain).
  - **Site → Builder**:
    - Canvas preview; device toggles.
    - Left panel: Blocks library:
      - Profile block (avatar, name, bio, verified badge).
      - Link block (title, URL, icon, description, UTM).
      - Social grid (auto-fetch counts).
      - Media block (image/video/embed).
      - Newsletter signup (native + webhook).
      - Product block (title, price, checkout).
      - Rich text, divider, carousel, countdown, badge/pill.
      - **Ad Slot block** (see Marketplace).
    - Right panel: Styles (theme tokens, fonts, spacing, radius), SEO/Open Graph, favicon, custom code per plan.
    - Toolbar: undo/redo, version history with diffs, publish, preview, share draft link.
  - **Site → Analytics**:
    - Overview: sessions, clicks, CTR, conversion events; UTM breakdown; geo heatmap; device/browser; top links; anomalies; compare period; export CSV.
    - Experiments: AB tests for order/labels; significance auto-calc; promote winner.
  - **Site → Marketplace**:
    - My Slots: define blocks as sellable slots; set inventory windows, placement rules (position, duration), base prices, auction rules, barter preferences.
    - My Buyers: requests, bids, messages, calendar; accept/reject/counter; escrow status; proofs.
    - Earnings: balance, upcoming payouts, fees; export statements.
  - **Site → Domains**:
    - Subpath, subdomain, custom domain; DNS verify; TLS status; redirect rules.
  - **Site → Settings**: SEO, OG, robots, sitemap, cookie banner, languages, accessibility checks.
- **Marketplace (global)**: browse others’ slots; filters; watchlist; negotiation chat; booking calendar; escrow flow.
- **Billing**: plan, add-ons, usage; change plan; invoices; payment methods; dunning status; cancel schedule; data retention.
- **Team**: invite collaborators; roles (Owner, Admin, Editor, Marketplace, Billing, Read-only). Per-site scopes. Pending invites.
- **Integrations**: Google Analytics/Tag, Meta Pixel, TikTok, Zapier/n8n webhooks, Discord/Telegram alerts, Mail providers.
- **Automation**: simple rules (if link CTR drops 30% week-over-week → notify; if slot expires → auto-relist).
- **Security**: sessions, devices, 2FA optional, API keys per workspace; IP allowlist.
- **Audit log**: all workspace actions.

### 4.4 Collaborator Dashboard
- Assigned Sites list.
- Limited Builder per scope.
- Marketplace tab if enabled.
- Activity feed and tasks.

### 4.5 Public Site (Viewer)
- Fast, cached, SSR/edge with hydration.
- Accessible, SEO’d, semantic.
- Structured data for profile.
- Consent banner.
- Link clicks tracked with first-party endpoint, no third-party beacons.
- If slot is active ad: disclosure badge, countdown, “Advertise here” CTA.

### 4.6 Developer/Docs Portal
- REST + Webhook reference with OpenAPI.
- Events catalog (site.published, slot.booked, payment.succeeded, etc.).
- Example payloads, signatures, retries, idempotency.
- SDK snippets TS/PHP.

## 5. Architecture and Stack
- **Frontend**: Next.js 15 App Router, React 19, TypeScript 5, shadcn/ui, Tailwind CSS, Radix UI. Edge-ready pages where possible.
- **Backend (Core API + Admin)**: Laravel 11 (PHP 8.3), Octane (RoadRunner), PostgreSQL 16, Redis 7, MinIO/S3, Meilisearch (or OpenSearch) for search, Mailer (Postmark/SES), Queue workers.
- **BFF**: Next.js server actions calling Laravel API via internal network. Zod contracts mirrored to backend (OpenAPI codegen).
- **Auth**: Passwordless email magic link + one-time code. Device trust cookie. Optional OAuth later. JWT short-lived + rotating refresh. CSRF for web.
- **Multi-tenancy**: single DB with `tenant_id` across tables + RLS-like enforcement in app layer; domain router maps hostname/path to tenant + site. Optional per-tenant schema if needed later.
- **Payments**: Mercado Pago v2:
  - Subscriptions: plans, preapproval, webhooks: `authorized_payment`, `cancelled`, `paused`.
  - One-offs: preferences, PIX and card.
  - Marketplace/escrow: platform fees, split where supported; otherwise settlement via scheduled transfer.
  - Webhooks signed + idempotency keys + retries with exponential backoff.
- **Marketplace Escrow**: hold buyer funds until placement proof windows elapse; auto-release or dispute path.
- **CDN/Edge**: Cloudflare for DNS, CDN, WAF, rate limits. Image optimization via Next Image + sharp.
- **Observability**: OpenTelemetry traces; Sentry errors; Prometheus metrics; Grafana dashboards; alert rules.
- **Infra**: Docker Compose (dev), Kubernetes (prod) with Traefik or NGINX Ingress, cert-manager for ACME, HorizontalPodAutoscaler, backups to S3 with lifecycle.

## 6. Data Model (key entities, required fields)
- `tenants` (id, name, slug, plan_id, seats, status, created_at)
- `users` (id, email, name, role_global, status)
- `memberships` (tenant_id, user_id, role_tenant, invited_by, state)
- `sites` (id, tenant_id, handle, title, description, theme_id, status, visibility)
- `site_versions` (id, site_id, json_blocks, theme_tokens, created_by, label)
- `domains` (id, site_id, type[subpath|subdomain|custom], host, status, acme_status, verified_at)
- `links` (id, site_id, type[link|social|media|product|ad_slot], order, config_json, active)
- `ad_slots` (id, site_id, block_id, position_hint, rules_json, audience_metrics_json)
- `ad_listings` (id, ad_slot_id, type[fixed|auction|barter], price, min_bid, barter_rules, schedule_windows[])
- `ad_orders` (id, listing_id, buyer_tenant_id, status[pending|escrow|active|completed|disputed|refunded], schedule, proofs[], rating)
- `payments` (id, tenant_id, provider[mercadopago], kind[subscription|oneoff|escrow], amount, currency, provider_refs, status)
- `subscriptions` (id, tenant_id, plan_id, status, started_at, current_period_end, dunning_state)
- `plans` (id, code, name, price, currency, features_json, limits_json)
- `invoices` (id, tenant_id, period, amount, status, pdf_url)
- `analytics_events` (id, site_id, type[view|click|conversion], utm_json, geo_ip, ua, ts)
- `experiments` (id, site_id, hypothesis, variants, metrics, status)
- `webhooks` (id, tenant_id, url, secret, events[], status)
- `audit_logs` (id, actor_user_id, actor_tenant_id, action, target_type, target_id, diff_json, ip, ua, ts)

All tables include `created_at`, `updated_at`. PII follows encryption at rest where applicable.

## 7. State Machines
- **Subscription**: trialing → active → past_due → dunning[N] → cancelled or active; webhooks drive transitions.
- **Ad order**: pending → escrow → scheduled → active → completed → payout_pending → paid; branches for dispute/refund.
- **Invite**: pending → accepted → expired → revoked.

## 8. Security and Compliance
- RBAC: global vs tenant vs site scopes; policy checks at controller + middleware.
- Rate limits per IP, per tenant, per user; higher for internal workers.
- Secrets via Vault/KMS. Rotate keys. Webhook HMAC verification.
- Content moderation queue; blocklist patterns; image scanning optional.
- LGPD/GDPR: data export, delete, data map, DPA. Cookie consent with granular toggles.
- Backups nightly, PITR on Postgres; encrypted; restore drills quarterly.

## 9. Performance Budgets
- First contentful under 1.2s on 4G mid-tier devices for public sites.
- Dashboard p95 API < 300ms. Builder interactions < 50ms reactivity.
- All pages pass Lighthouse 90+ perf/seo/a11y/best-practices.

## 10. Analytics Events (examples)
- `site_published`, `link_clicked`, `slot_listed`, `slot_booked`, `slot_live`, `slot_completed`, `subscription_updated`, `payment_failed`, `invite_sent`, `invite_accepted`.

## 11. Emails and Notifications
- Transactional: magic link, verification code, invite, payment receipts, dunning, slot booking updates, payout notifications.
- Digest: weekly site performance, marketplace watchlist changes.

## 12. Testing Strategy
- Unit: domain logic 90%+.
- Contract: OpenAPI schema tests, mock Mercado Pago webhooks.
- E2E: critical paths (signup, builder publish, buy slot, escrow release).
- Load: k6 scenarios for public site traffic spikes.
- Chaos: random worker restarts; ensure idempotency.

## 13. Rollout
- Seed templates, demo data, sandbox Mercado Pago keys.
- Canary for 5% tenants with feature flags.
- SLO: 99.9% public site availability, 99.5% dashboard.

## 14. Changelog
- A1: Initial monorepo with Next.js 15 + Laravel 11, Docker Compose, CI/CD pipeline — [8bc5fec](https://github.com/ashio-git/novabio/commit/8bc5fec)
- v1.0.0: initial complete release as per spec.