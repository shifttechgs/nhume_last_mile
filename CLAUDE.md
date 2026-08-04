# Nhume — Project Intelligence

## What This Is

Nhume is a two-sided logistics marketplace that matches parcel senders with transporters already travelling to the destination. Think: Airbnb for empty vehicle space on existing journeys.

**Business model:** Commission per successful booking.
**Stage:** MVP shell — validating demand before building features.
**Primary market:** Zimbabwe (Harare↔Bulawayo), expanding to SA corridor.

---

## Tech Stack (Hard Requirements — Do Not Deviate)

| Layer | Technology |
|---|---|
| Backend | Laravel 12, PHP 8.4 |
| Frontend | Blade, Livewire 3, AlpineJS |
| Styling | Tailwind CSS 4, Vite |
| Database | SQLite (dev), MySQL (prod) |
| Auth | Laravel Breeze (Blade stack) |

**Never suggest:** React, Vue, Bootstrap, Inertia.js, or any JS framework beyond AlpineJS.

---

## Architecture Rules

- **Controllers are thin.** One responsibility: receive HTTP, delegate, return response.
- **Business logic lives in `app/Services/` and `app/Actions/`.** Services orchestrate. Actions are single-purpose.
- **`app/DTOs/`** — typed data transfer between layers. Use PHP 8.4 readonly properties.
- **`app/Repositories/`** — all Eloquent queries go here, never in controllers or views.
- **`app/ViewModels/`** — shape data for Blade views. Never pass raw Eloquent models to views.
- **`app/Enums/`** — all status fields are backed enums, never raw strings.
- **Strong typing everywhere.** Return types, parameter types, no mixed.

---

## Critical Architectural Decisions (Read Before Any Schema Work)

### Problem 1: Cold-Start Liquidity

The `journeys` table MUST have a `source` enum field:
```php
// JourneySource enum
Admin_Seeded  // Nhume staff posted on behalf of a transporter
TransporterDirect  // Transporter posted themselves
Import  // Bulk imported
```

Without this, you cannot distinguish organic supply growth from admin-propped metrics.
Journeys must also support an `admin_draft` status so staff can stage journeys before a transporter activates them.

### Problem 2: Trust Before Verification

The `transporter_profiles` table MUST have a trust tier from day one:
```php
// TrustTier enum
Unverified        // Just signed up
ManuallyReviewed  // Nhume team has spoken to this person offline
IdSubmitted       // Documents uploaded, pending review
Verified          // Fully checked
```

This allows Nhume to operate as a hybrid marketplace: manually vet the first 20 transporters, mark them `ManuallyReviewed`, display a "Nhume Reviewed" badge. Senders see trust signals without automated verification existing yet.

Required columns on `transporter_profiles`:
- `trust_tier` (enum)
- `trust_notes` (text, nullable)
- `reviewed_by` (FK to users)
- `reviewed_at` (timestamp, nullable)

---

## Folder Structure

```
app/
  Actions/           # Single-purpose action classes (CreateJourneyAction, etc.)
  DTOs/              # Readonly PHP 8.4 data classes
  Enums/             # All backed enums (JourneyStatus, TrustTier, UserRole, etc.)
  Events/
  Jobs/
  Models/            # Eloquent models (thin, no business logic)
  Policies/          # Authorization
  Repositories/      # All Eloquent queries
  Services/          # Business logic orchestration
  Traits/
  ViewModels/        # Data shaping for Blade views
  Livewire/
    Parcel/
    Journey/
    Transporter/
    Shared/

resources/views/
  layouts/           # app.blade.php, guest.blade.php, dashboard.blade.php
  components/        # Reusable Blade components
    landing/
    journeys/
    parcels/
    dashboard/
  pages/             # Full page views
  emails/

routes/
  web.php
  api.php

database/
  migrations/
  seeders/
  factories/
```

---

## User Roles

```php
enum UserRole: string {
    case Admin = 'admin';
    case Sender = 'sender';
    case TransportPartner = 'transport_partner';
    case Business = 'business';
}
```

---

## Models Reference

| Model | Table | Key Notes |
|---|---|---|
| User | users | Has role enum, morphs to profiles |
| TransporterProfile | transporter_profiles | Has trust_tier enum |
| Vehicle | vehicles | Belongs to TransporterProfile |
| Route | routes | City pairs (Harare → Bulawayo) |
| Journey | journeys | Has source enum, belongs to Route |
| Parcel | parcels | Posted by Sender |
| Booking | bookings | Links Parcel to Journey |
| Review | reviews | Polymorphic |
| Payment | payments | |
| Commission | commissions | |
| StatusHistory | status_histories | Polymorphic audit trail |
| Notification | notifications | Laravel default + custom |

---

## Design System

**Inspired by:** Linear, Stripe, Notion — minimal, premium, lots of whitespace.

**Brand:**
- Name: Nhume
- Tagline: "Moving parcels with journeys already in motion."
- Personality: Modern, Trustworthy, Simple, Fast, African, Community-driven

**Tailwind theme tokens to define:**
- `--color-primary` — brand blue/indigo
- `--color-secondary` — warm accent
- `--color-success/warning/danger`
- `--color-background/surface/card`
- Rounded cards, glassmorphism accents, smooth transitions
- Dark mode support (class strategy)

---

## Route Map

```
GET  /                          # Landing page
GET  /how-it-works              # Explainer
GET  /send                      # Post a parcel
GET  /journeys                  # Browse journeys
GET  /become-a-transporter      # Transporter onboarding
GET  /dashboard                 # Authenticated user dashboard (role-aware)
GET  /admin                     # Admin dashboard
GET  /login
GET  /register
GET  /contact
GET  /about
GET  /pricing
GET  /safety
GET  /faqs
GET  /privacy
GET  /terms
GET  /coming-soon
```

---

## MVP Scope (Strictly No Feature Creep)

**Build now:** Shell, layouts, components, migrations, seeders, routes, dashboard skeletons.

**Do NOT build yet:**
- Parcel matching engine
- Live tracking / maps
- WhatsApp notifications
- Payments / escrow
- Automated driver verification
- AI route optimization
- Mobile apps
- Cross-border customs workflows
- Commission calculation engine

---

## Seeder Data Guidelines

Make seeder data realistic for Zimbabwe:
- Routes: Harare → Bulawayo, Harare → Mutare, Harare → Gweru, Bulawayo → Victoria Falls
- Transporter names that feel local
- Mix of trust tiers in the 20 seeded transporters
- Parcel types: clothing, electronics, documents, food

---

## Commands

```bash
# Start dev server
php artisan serve

# Build assets
npm run dev

# Run migrations with fresh seed
php artisan migrate:fresh --seed

# Run tests
php artisan test
```