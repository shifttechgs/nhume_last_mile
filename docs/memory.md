# Nhume — Project Memory

## Critical Architectural Decisions

### Cold-Start Liquidity Problem

The `journeys` table has a `source` enum field (`JourneySource`):
- `admin_seeded` — Nhume staff posted on behalf of a transporter
- `transporter_direct` — Transporter posted themselves
- `import` — Bulk imported

Journeys also support an `admin_draft` status so staff can stage journeys before a transporter activates them.

**Why this matters:** Without this, you cannot distinguish organic supply growth from admin-propped metrics.

### Trust Before Verification Problem

The `transporter_profiles` table has `TrustTier` enum from day one:
- `unverified` — Just signed up
- `manually_reviewed` — Nhume team has spoken to this person offline
- `id_submitted` — Documents uploaded, pending review
- `verified` — Fully checked

Required columns: `trust_tier`, `trust_notes`, `reviewed_by` (FK to users), `reviewed_at`.

**Why this matters:** Allows Nhume to operate as a hybrid marketplace. Manually vet the first 20 transporters, mark them `manually_reviewed`, display "Nhume Reviewed" badge. Senders see trust signals without automated verification.

## Go-to-Market

- **Primary corridor:** Harare ↔ Bulawayo
- **Phase 1:** Manual matching, validate demand
- **Phase 2:** Self-service journey posting, online booking, digital payments
- **Phase 3:** Automated matching, live tracking, SA expansion, mobile apps

## Seeder Data Context

Zimbabwe-realistic data:
- Routes: Harare→Bulawayo, Harare→Mutare, Harare→Gweru, Bulawayo→Victoria Falls
- 20 seeded transporters with mixed trust tiers
- Parcel types: clothing, electronics, documents, food

## What NOT to Build (MVP)

- Parcel matching engine
- Live tracking / maps
- WhatsApp notifications
- Payments / escrow
- Automated driver verification
- AI route optimization
- Mobile apps
- Cross-border customs workflows
- Commission calculation engine
