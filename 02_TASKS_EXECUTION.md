# 02_TASKS_EXECUTION.md
Title: NovaBio — End-to-End Build Tasks with AC/TC/RB

## A. Project Bootstrap
- [x] A1 Repo, CI/CD, environments  —  2025-10-22T20:58:00Z  —  sha:8bc5fec
  - AC: mono-repo with `apps/web` (Next.js) and `apps/api` (Laravel), Dockerized, CI runs tests, lint, typecheck, build.
  - TC: push triggers pipeline; images built; staging deploy works.
  - RB: revert to previous image; rollout paused via flag.
- [x] A2 Config management  —  2025-10-22T21:02:00Z  —  sha:63da815
  - AC: `.env.example` complete; secrets via Vault; env validation on boot.
  - TC: invalid config halts boot with clear message.
  - RB: fallback to last known good config.

## B. Data Layer
- [ ] B1 Postgres schema + migrations
  - AC: entities from spec created; foreign keys; indexes; unique constraints; soft delete where needed.
  - TC: migration up/down works; seed data loads.
  - RB: roll back migration safely.
- [ ] B2 Redis + queues
  - AC: named queues; backoff; dead-letter.
  - TC: simulate failure; job retried; dead-letter visible.
  - RB: drain/requeue script exists.

## C. Auth & Tenancy
- [ ] C1 Passwordless auth
  - AC: magic link and 6-digit code; device trust cookie; replay-safe tokens.
  - TC: link reuse denied; code expiry enforced.
  - RB: revoke tokens; force logout all sessions.
- [ ] C2 Tenant routing
  - AC: map host/path → tenant/site; middleware enforces `tenant_id`.
  - TC: cross-tenant access blocked; 403 with audit entry.
  - RB: global maintenance mode switch.

## D. Payments (Mercado Pago)
- [ ] D1 Provider integration
  - AC: sandbox + prod keys; health check endpoint; HMAC verification; idempotency keys.
  - TC: webhook replay processed once; signature failure rejected.
  - RB: disable webhook consumers; hold new charges.
- [ ] D2 Subscriptions
  - AC: create plans, subscribe, upgrade/downgrade, proration, dunning states, invoices PDF.
  - TC: simulate failed payment → dunning email; recovery success resumes.
  - RB: cancel subscription, credit memo issued.
- [ ] D3 One-off + PIX/card
  - AC: create preference; PIX QR and copy-paste code; card checkout; attach metadata (tenant/site/order).
  - TC: end-to-end success; refunds; partial refunds.
  - RB: cancel preference; reverse payment if unsettled.
- [ ] D4 Marketplace escrow
  - AC: funds held until placement complete; auto-release; dispute path with timers.
  - TC: buyer/seller timelines honored; logs show transitions.
  - RB: admin manual release tool.

## E. Builder & Publishing
- [ ] E1 Block system
  - AC: normalized schema; JSON blocks validated; drag-drop ordering; inline editing.
  - TC: create/edit/delete blocks; version history; diff works.
  - RB: restore previous version.
- [ ] E2 Themes & tokens
  - AC: light/dark; typography scale; spacing; radius; color tokens; per-block overrides.
  - TC: switch themes without layout shift; AA contrast.
  - RB: revert to default theme.
- [ ] E3 Publish pipeline
  - AC: publish generates immutable artifact; cache headers; CDN purge; preview links.
  - TC: TTI under budget on staging; SEO tags present.
  - RB: roll back to last artifact.

## F. Marketplace
- [ ] F1 Slot definition
  - AC: mark any block as sellable slot; rules (position, min/max duration, creative specs); inventory windows.
  - TC: invalid windows rejected; conflict detection works.
  - RB: disable slot; notify watchers.
- [ ] F2 Listing types
  - AC: fixed price, auction, barter; min bid; reserve; bartering preferences.
  - TC: auction ends on schedule; tie rules applied.
  - RB: cancel listing; auto-refund pending bids.
- [ ] F3 Orders and proofs
  - AC: negotiation chat; booking calendar; asset upload; placement proofs; acceptance flow.
  - TC: unresponsive seller triggers auto-cancel with refund.
  - RB: escalate to admin dispute.
- [ ] F4 Payouts
  - AC: payout schedule; platform fee; statements; CSV export.
  - TC: simulate payout failure → retry/backoff.
  - RB: manual payout with reason logged.

## G. Analytics & Experiments
- [ ] G1 Event pipeline
  - AC: first-party endpoint; queue; schema; bot filtering; privacy rules.
  - TC: high-volume test; no data loss.
  - RB: disable ingestion; buffer on edge.
- [ ] G2 Dashboards
  - AC: charts for sessions, clicks, CTR, UTM, geo, devices; compare periods; CSV export.
  - TC: empty-state and large-data tests.
  - RB: hide widgets on failure.
- [ ] G3 A/B testing
  - AC: variants for link order and labels; stats engine; promote winner.
  - TC: sample ratio mismatch detection.
  - RB: auto-stop and revert to control.

## H. Domains & Delivery
- [ ] H1 Custom domains
  - AC: DNS TXT/CNAME verification; ACME certs; auto-renew; redirect builder.
  - TC: invalid DNS shows actionable error; cert issuance within SLA.
  - RB: fallback to subdomain.
- [ ] H2 CDN/Edge
  - AC: caching rules; stale-while-revalidate; image optimization.
  - TC: cache hit ratio target met; purge on publish.
  - RB: global purge script.

## I. Team & Permissions
- [ ] I1 Roles & scopes
  - AC: Owner, Admin, Editor, Marketplace, Billing, Read-only; per-site scopes.
  - TC: permission matrix test suite passes.
  - RB: emergency admin elevation script.
- [ ] I2 Invites
  - AC: email invite with expiry; resend; revoke.
  - TC: expired invite blocked.
  - RB: regenerate token.

## J. Integrations
- [ ] J1 Pixels and tags
  - AC: GA4/GTM, Meta, TikTok; consent gating.
  - TC: tags fire only after consent.
  - RB: disable per-site.

## K. Super Admin Ops
- [ ] K1 Moderation
  - AC: queue with filters; actions (mask, takedown, suspend); ML suggestions.
  - TC: audit for each action.
  - RB: undo with reason.
- [ ] K2 Feature flags
  - AC: cohorting; gradual rollout; instant kill.
  - TC: 1%, 10%, 50% staged test.
  - RB: kill switch verified.
- [ ] K3 System health
  - AC: dashboards; alerts; runbooks.
  - TC: synthetic checks assert SLIs.
  - RB: incident mode banner + status page update.

## L. Compliance & Security
- [ ] L1 LGPD/GDPR
  - AC: export/delete; privacy controls; cookie banner.
  - TC: request completes within SLA.
  - RB: abort with user notice and support link.
- [ ] L2 Rate limits & WAF
  - AC: IP/user/tenant throttles; attack patterns blocked.
  - TC: flood test; errors < 1%.
  - RB: auto-unban rules.

## M. Docs & DevEx
- [ ] M1 Developer portal
  - AC: OpenAPI, examples, SDK snippets, webhooks, test payloads.
  - TC: quickstart completes in <10 minutes.
  - RB: versioned docs rollback.

## N. QA Gates (per release)
- [ ] N1 Accessibility AA
- [ ] N2 Perf budgets met
- [ ] N3 Security scan clean
- [ ] N4 Backup/restore drill
- [ ] N5 Runbook updated
- [ ] N6 Changelog appended

## O. Launch Checklist
- [ ] Domain and SSL live
- [ ] Templates seeded
- [ ] Pricing live and tested
- [ ] Support and legal pages final
- [ ] Status page public
- [ ] Observability alerts enabled
- [ ] Sandbox keys rotated to prod

## P. Post-Launch
- [ ] Monitor SLOs
- [ ] Collect NPS
- [ ] Backlog grooming from telemetry