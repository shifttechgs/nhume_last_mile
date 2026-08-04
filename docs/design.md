# Nhume — Design System

## Design Inspiration

**Primary reference:** [BobGo](https://www.bobgo.co.za/) — a South African logistics SaaS platform.
Clean, modern, professional. Trust-first. Lots of whitespace. Statistics-led social proof. Clear CTAs.

Adapted for Nhume's market: Zimbabwe-focused, community-driven, marketplace model (not SaaS).

---

## Brand

- **Name:** Nhume (Ndebele/Shona for "messenger / one who carries")
- **Tagline:** "Moving parcels with journeys already in motion."
- **Personality:** Trustworthy, Modern, Fast, Accessible, African, Community-driven

---

## Color Palette

Inspired by BobGo's orange-blue-green tri-color system, adapted with an African warmth.

```css
/* Primary — deep indigo blue (trust, technology, logistics) */
--color-primary:        #2563EB;   /* blue-600 */
--color-primary-dark:   #1D4ED8;   /* blue-700 */
--color-primary-light:  #DBEAFE;   /* blue-100 */

/* Accent — warm amber/orange (energy, movement, African warmth) */
--color-accent:         #F59E0B;   /* amber-500 */
--color-accent-dark:    #D97706;   /* amber-600 */
--color-accent-light:   #FEF3C7;   /* amber-100 */

/* Semantic */
--color-success:        #10B981;   /* emerald-500 */
--color-warning:        #F59E0B;   /* amber-500 */
--color-danger:         #EF4444;   /* red-500 */
--color-info:           #3B82F6;   /* blue-500 */

/* Surfaces */
--color-background:     #F9FAFB;   /* gray-50  — page background */
--color-surface:        #FFFFFF;   /* white    — cards, modals */
--color-border:         #E5E7EB;   /* gray-200 — dividers, card borders */
--color-muted:          #6B7280;   /* gray-500 — secondary text */
--color-text:           #111827;   /* gray-900 — primary text */
```

**Tailwind mapping in `tailwind.config.js`:**
```js
colors: {
  primary:  { DEFAULT: '#2563EB', dark: '#1D4ED8', light: '#DBEAFE' },
  accent:   { DEFAULT: '#F59E0B', dark: '#D97706', light: '#FEF3C7' },
}
```

---

## Typography

**Font:** Inter (Google Fonts — same clean sans-serif family BobGo uses)

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
```

```css
font-family: 'Inter', system-ui, sans-serif;
```

### Scale

| Role            | Size        | Weight | Tailwind           |
|-----------------|-------------|--------|--------------------|
| Display hero    | 48–56px     | 800    | `text-5xl font-extrabold` |
| Section heading | 32–36px     | 700    | `text-4xl font-bold` |
| Card heading    | 20–24px     | 600    | `text-xl font-semibold` |
| Body            | 16px        | 400    | `text-base` |
| Small / meta    | 14px        | 400–500| `text-sm` |
| Label           | 12px        | 500    | `text-xs font-medium uppercase tracking-wide` |

---

## Layout & Spacing

- **Max content width:** `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8`
- **Section vertical padding:** `py-16` (64px) standard, `py-24` (96px) for hero
- **Card gap in grids:** `gap-6` or `gap-8`
- **Card padding:** `p-6` or `p-8`

---

## Components

### Navigation (BobGo-style)

Sticky top nav, white background, border-bottom separator.

```
[Logo]  Solutions  Journeys  Transporters  Pricing  FAQs  |  Login  [Get Started →]
```

- Logo: left-aligned, brand name in bold primary color
- Nav links: `text-gray-600 hover:text-gray-900 text-sm font-medium`
- Divider before auth buttons
- `Get Started`: primary filled button (rounded-lg, blue-600)
- `Login`: ghost/text button

### Hero Section (BobGo "Run your store" style)

Full-width, white or very light gray background. Centered or left-aligned.

```
[eyebrow label — small caps, accent color]
Big bold headline — 2–3 lines max
Subheading — one sentence, muted gray, text-lg
[Primary CTA]  [Secondary CTA — ghost]
Social proof bar: "500+ parcels moved · 20 verified transporters · Harare–Bulawayo daily"
```

### Stats Bar (BobGo social proof style)

3–4 stats in a horizontal strip, light gray background.

```
[ 500+         ] [ 20           ] [ 4            ] [ 99%          ]
[ Parcels moved] [ Transporters ] [ Active routes] [ On-time rate ]
```
- Numbers: `text-3xl font-bold text-primary`
- Labels: `text-sm text-gray-500`

### Cards

```css
/* Journey card, transporter card */
rounded-2xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md transition-shadow
```

**Journey card anatomy:**
- Route badge: `Harare → Bulawayo` (primary-light bg, primary text)
- Departure date + time
- Transporter name + trust badge
- Available space indicator
- Price estimate
- `[Book space →]` button

**Transporter card anatomy:**
- Avatar / vehicle photo
- Name, vehicle type
- Trust tier badge (see below)
- Route coverage
- Rating (future)
- `[View journeys]` link

### Trust Tier Badges (core Nhume differentiator)

```
Unverified       →  gray ring,   "Unverified"       text-gray-500
ManuallyReviewed →  blue ring,   "Nhume Reviewed"   text-blue-600   (show shield icon)
IdSubmitted      →  amber ring,  "ID Submitted"     text-amber-600
Verified         →  green ring,  "Verified ✓"       text-emerald-600
```

Tailwind pattern:
```html
<span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium
             bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20">
  ✓ Verified
</span>
```

### Buttons

| Variant   | Style |
|-----------|-------|
| Primary   | `bg-primary text-white hover:bg-primary-dark rounded-lg px-5 py-2.5 font-semibold text-sm` |
| Secondary | `border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 rounded-lg px-5 py-2.5` |
| Accent    | `bg-accent text-white hover:bg-accent-dark rounded-lg px-5 py-2.5` |
| Ghost     | `text-primary hover:underline font-medium` |
| Danger    | `bg-red-600 text-white hover:bg-red-700 rounded-lg px-5 py-2.5` |

No pill shapes (too informal). Consistent `rounded-lg` (8px) across all buttons.

### Forms

- Input: `rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary focus:border-primary`
- Label above input, `text-sm font-medium text-gray-700 mb-1`
- Error state: red border + red helper text below
- Select: same style as input + chevron icon right-aligned

### "How It Works" Section (BobGo pattern)

3-step numbered flow, horizontal on desktop, vertical on mobile.

```
[1]                    [2]                    [3]
Post your parcel  →  Match a journey     →  Delivered
Short description      Short description      Short description
```

Steps connected by a subtle dashed line or arrow on desktop.

### Section with Background (alternating)

- White sections and `bg-gray-50` sections alternate
- Never use heavy color backgrounds in body sections — save strong color for the hero or CTA strips

### CTA Strip (bottom of page, BobGo-style)

Full-width band, primary blue background:
```
"Ready to send your first parcel?"
[Start for free]  [Talk to us]
```

### Footer (BobGo 4-column pattern)

```
[Logo + tagline + socials]  |  Platform  |  Support  |  Company
                            |  Journeys  |  FAQs     |  About
                            |  Pricing   |  Contact  |  Safety
                            |  How it    |           |  Blog
                              works
© 2025 Nhume · Terms · Privacy · Safety Policy
```

---

## Iconography

Use [Heroicons](https://heroicons.com/) (outline style, 24px) — consistent with Tailwind ecosystem.

Key icons:
- `TruckIcon` — journeys
- `PackageIcon` → `CubeIcon` — parcels
- `ShieldCheckIcon` — trust / verification
- `MapPinIcon` — routes
- `ClockIcon` — departure time
- `CheckCircleIcon` — confirmed/delivered
- `StarIcon` — ratings (future)

---

## Page-Specific Design Notes

### `/` Landing
- Hero: left-aligned text, right-side illustration or photo of a Zimbabwe city/vehicle
- Stats bar immediately below hero
- "How it works" — 3 steps
- "Trusted transporters" — sample transporter cards with trust badges
- CTA strip

### `/journeys`
- Filter bar top: origin city, destination city, date picker
- Card grid: 3 cols desktop, 1 col mobile
- Each card shows route, departure, transporter trust badge, available space, price

### `/dashboard` (role-aware)
- Sender: active bookings, track parcel status, post new parcel
- Transporter: upcoming journeys, booking requests, earnings summary
- Admin: transporter trust tier table, journey management, metrics

### `/admin`
- Clean data tables, no heavy styling
- Trust tier management: change tier, add notes, reviewer + timestamp
- Journey source labels visible (Admin Seeded vs Transporter Direct)

---

## Responsive Strategy

- Mobile-first Tailwind classes
- Navigation collapses to hamburger on mobile
- Cards stack to single column on `sm` and below
- Stats bar wraps to 2×2 grid on mobile
- Hero headline drops from `text-5xl` to `text-3xl` on mobile

---

## No Dark Mode (MVP)

Dark mode deferred. Focus on polished light mode first. Can be added in a later phase.
