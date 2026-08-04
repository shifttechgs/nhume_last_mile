# Nhume Platform Architecture & Product Vision

> **Version:** 1.0
> **Project:** Nhume
> **Author:** Founder Vision
> **Status:** MVP Planning

---

# Vision

Nhume is a logistics platform that makes moving parcels simple across Zimbabwe and Southern Africa.

We are **not** building another courier company.

We are building the technology layer that connects people, transport providers, businesses and logistics services into one seamless platform.

Our mission is to become the trusted logistics operating system for Zimbabwe.

---

# The Problem

## Local Logistics

Today, sending a parcel within Zimbabwe is inconvenient.

A customer typically:

- Goes to a bus terminus
- Calls multiple transport companies
- Negotiates pricing
- Hands parcels to unknown drivers
- Phones the recipient
- Hopes everything arrives safely

Traditional couriers operate on fixed dispatch schedules.

Sometimes transport is already heading to the destination, but customers have no easy way of finding or booking it.

There is no central platform where customers can:

- Compare transport options
- Book online
- Track deliveries
- Receive delivery updates
- View transporter ratings
- Pay securely

---

## Cross-Border Logistics

Zimbabweans buy thousands of products from South African stores every day.

Examples include:

- Takealot
- Makro
- Builders Warehouse
- Game
- Checkers
- Facebook Marketplace
- Instagram Businesses

The challenges are:

- Stores don't deliver to Zimbabwe
- Customers don't have a South African address
- Cross-border shipping is confusing
- Customs are difficult to understand
- Customers don't know which courier to trust

---

# Our Solution

Nhume consists of two products running on one platform.

---

# Product One: Nhume Local

**Tagline:** Move parcels anywhere in Zimbabwe.

## What it does

Nhume Local connects customers with verified transport providers travelling between Zimbabwean cities.

Customers can:

- Book parcel deliveries
- Compare transport options
- Track parcels
- Receive delivery notifications
- Schedule pickups
- Manage deliveries online

Transport providers earn additional income while customers enjoy a better booking experience.

## Future Partners

- Bus operators
- Shuttle services
- Courier companies
- Fleet operators
- Last-mile drivers
- Logistics companies

## Revenue

- Commission per shipment
- Business subscriptions
- Premium delivery
- Home collection
- Last-mile delivery

---

# Product Two: Nhume CrossBorder

**Tagline:** Shop South Africa. Deliver to Zimbabwe.

## What it does

Every customer receives a unique South African delivery address.

Customers can purchase from any South African retailer.

Instead of shipping directly to Zimbabwe, parcels are delivered to Nhume's warehouse.

Nhume then transports the parcel into Zimbabwe.

Customers can choose:

- Home delivery
- Collection point
- Business delivery

## Customer Journey

**Step 1** — Shop online (Takealot, Makro, Builders Warehouse, Game, Facebook Marketplace)

**Step 2** — Use your unique Nhume Address during checkout:
```
John Doe
NHM-20481
Nhume Logistics
Johannesburg
South Africa
```

**Step 3** — Upload receipt, invoice, and tracking number

**Step 4** — Nhume receives the parcel. Warehouse staff scan, photograph, verify weight, measure dimensions, store safely.

**Step 5** — Customer receives notification: "Your parcel has arrived."

**Step 6** — Customer selects delivery option: home delivery, collection point, or express delivery.

**Step 7** — Nhume transports parcel into Zimbabwe.

## Revenue

- Shipping fees
- Parcel consolidation
- Storage
- Buy For Me service
- Customs handling
- Insurance
- Home delivery

---

# One Platform

Both products share the same system.

There should NOT be two separate applications.

Everything should live under one Laravel application.

---

# Shared Modules

## Authentication
Users · Businesses · Transport Partners · Warehouse Staff · Drivers · Admins

## Customer Profiles
Addresses · Saved Recipients · Phone Numbers · Preferences

## Parcel Management
Create Parcel · Labels · Tracking · Timeline · Photos · QR Codes · Status Updates · History

## Tracking States
Collected → In Transit → Arrived → Ready for Collection → Out for Delivery → Delivered → Cancelled → Returned

## Payments
Quotes · Invoices · Receipts · Refunds · Wallet (Future)

## Notifications
Email · SMS · WhatsApp · Push Notifications (Future)

## Customer Dashboard
My Parcels · Track Parcel · Invoices · Saved Addresses · Support · Settings

---

# Local Modules

Journey Marketplace · Transport Partners · Routes · Bookings · Driver Assignments · Collections · Pricing

---

# CrossBorder Modules

South African Address · Warehouse Receiving · Parcel Check-in · Storage · Consolidation · Customs · Border Shipments · Collection Points

---

# Admin Modules

Dashboard · Users · Parcels · Transporters · Warehouses · Drivers · Collection Points · Routes · Pricing · Payments · Reports · Analytics · Notifications · Settings · Audit Logs · Support Tickets

---

# Database Schema

## Core Tables

| Table | Notes |
|-------|-------|
| `users` | All user types |
| `parcels` | Unified — supports both Local and CrossBorder via `service_type` |
| `journeys` | Local marketplace journeys |
| `bookings` | Links parcels to journeys |
| `routes` | City pairs |
| `transporters` | Transporter profiles |
| `vehicles` | Belongs to transporter |
| `warehouses` | CrossBorder receiving |
| `warehouse_receipts` | Parcel check-in records |
| `collection_points` | Pickup locations |
| `addresses` | Customer addresses |
| `parcel_events` | Audit trail / tracking timeline |
| `payments` | Payment records |
| `invoices` | Invoice records |
| `notifications` | Notification log |
| `reviews` | Polymorphic reviews |
| `support_tickets` | Customer support |
| `roles` / `permissions` | RBAC |
| `audit_logs` | System audit trail |

## Unified Parcel Table

One `parcels` table supports both products:

```php
// Key fields
service_type        // LOCAL | CROSS_BORDER
pickup_country      // ZW | ZA
delivery_country    // ZW | ZA
tracking_number     // Generated: NHM-XXXXX
status              // Via ParcelStatus enum
customer_id         // FK users
weight
dimensions          // JSON
declared_value
pickup_address_id   // FK addresses
delivery_address_id // FK addresses
```

---

# User Roles

| Role | Description |
|------|-------------|
| `guest` | Unauthenticated visitor |
| `customer` | Parcel sender |
| `business` | SME with multiple shipments |
| `transport_partner` | Driver / fleet operator |
| `warehouse_staff` | CrossBorder receiving |
| `driver` | Last-mile delivery |
| `support_agent` | Customer support |
| `admin` | Platform admin |
| `super_admin` | Full access |

---

# Landing Page Vision

The homepage must clearly communicate both services.

**Hero:**
> "Moving Parcels Made Simple"

**Primary CTA:** Send a Parcel

**Secondary CTA:** Get Your SA Address

**Service Cards:**

📦 **Nhume Local** — Fast parcel delivery across Zimbabwe.

🛍️ **Nhume CrossBorder** — Shop anywhere in South Africa and deliver to Zimbabwe.

---

# Design Principles

Modern · Minimal · Premium · Fast · Accessible · Mobile-first · Trustworthy · Clean · Friendly · Professional

Avoid generic courier website designs.

---

# Technology Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 12, PHP 8.4 |
| Frontend | Blade, Livewire 3, AlpineJS |
| Styling | Tailwind CSS 4, Vite |
| Database | SQLite (dev), MySQL (prod) |
| Cache/Queue | Redis |
| Real-time | Laravel Reverb (future) |

---

# Architecture Principles

- Controllers must remain **thin** — receive HTTP, delegate, return response
- Business logic belongs in **Services** and **Actions**
- Use **DTOs** for typed data transfer between layers
- Use **Repositories** for all Eloquent queries
- Use **Events and Listeners** for side effects
- Strong typing throughout — return types, parameter types, no mixed
- Reusable Blade components
- Feature-based folder organisation
- Prepare for future APIs and mobile applications

---

# Future Roadmap

**Do NOT build these for MVP:**

- Live GPS Tracking
- AI Route Matching
- Mobile Apps (iOS / Android)
- Digital Wallet
- Escrow Payments
- Automated Driver Verification
- Insurance
- Customs Automation
- E-commerce Integrations (Shopify, WooCommerce plugins)
- WhatsApp Bot
- Route Optimisation
- Business Portal
- Fleet Management
- International Expansion beyond SA–ZW corridor

---

# MVP Success Metrics

The MVP should validate that customers are willing to:

1. Book parcel deliveries online
2. Trust a digital logistics platform
3. Use a South African delivery address
4. Track shipments digitally

The system must be built with scalability in mind, allowing new logistics services to be added without major architectural changes.
