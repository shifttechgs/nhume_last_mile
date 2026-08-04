# Nhume — Design System

## Brand

- **Name:** Nhume
- **Tagline:** "Moving parcels with journeys already in motion."
- **Personality:** Modern, Trustworthy, Simple, Fast, African, Community-driven

## Design Inspiration

Linear, Stripe, Notion — minimal, premium, lots of whitespace.

## Color Tokens

```css
--color-primary        /* brand blue/indigo */
--color-secondary      /* warm accent */
--color-success
--color-warning
--color-danger
--color-background
--color-surface
--color-card
```

## Visual Style

- Rounded cards
- Glassmorphism accents on hero sections
- Smooth transitions
- Dark mode support (Tailwind class strategy)

## Typography

- Clean sans-serif
- Strong hierarchy: large display headings, comfortable body size
- Generous line-height

## Component Patterns

### Cards
Rounded (`rounded-2xl`), subtle shadow, white/surface background, padding generous.

### Buttons
Primary: filled brand color, slightly rounded.
Secondary: outlined or ghost.
Destructive: red tones, only where needed.

### Badges / Trust Signals
`Nhume Reviewed` badge — shown on transporter cards for `ManuallyReviewed` and above trust tier.
Color-coded by tier: gray (unverified), blue (reviewed), amber (ID submitted), green (verified).

### Forms
Floating labels or clear label-above-input. Generous input padding. Clear validation states.

## Route-Specific Notes

- `/` Landing: Hero with tagline, how it works preview, CTA buttons
- `/journeys` Browse: Card grid, filter sidebar, trust badge visible
- `/dashboard` Role-aware: different views for sender, transporter, admin
- `/admin` Admin dashboard: clean data tables, trust tier management

## Dark Mode

Use Tailwind's `dark:` classes. Default to light mode. Toggle stored in localStorage.
