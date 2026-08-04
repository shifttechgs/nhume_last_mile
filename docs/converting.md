# Nhume — High-Conversion Landing Page Blueprint

## Conversion Strategy

### Two goals, one page
Nhume is a two-sided marketplace. The landing page must convert **two distinct visitors**:

| Visitor | Job to be done | Primary CTA |
|---------|---------------|-------------|
| **Sender** | "I need this parcel in Bulawayo today, not tomorrow" | Send a parcel → |
| **Transporter** | "I'm driving to Bulawayo anyway — I could earn from the empty space" | Earn with your vehicle → |

**Rule:** The sender conversion is primary. Transporters are acquired via a secondary path lower on the page. Never split the hero 50/50 — sender wins the hero.

### Conversion hierarchy
1. Primary: sender posts a parcel (top of funnel, low friction)
2. Secondary: transporter registers (longer journey, different CTA colour)
3. Tertiary: newsletter / "notify me" for routes not yet active

### Friction reduction principles
- Never ask for an account before showing value
- "Check journeys" before "Create account"
- Show real data: actual routes, actual departures, actual transporter names
- One question at a time on any form
- Mobile thumb-zone CTAs always

---

## Page Sections (in order)

---

### 01 — Navigation

**Layout:** Sticky top bar, white bg, 1px bottom border `border-gray-200`

```
[Nhume logo]    How it works    Journeys    For Transporters    Pricing    |    Login    [Send a parcel →]
```

- Logo: wordmark "Nhume" in `font-bold text-primary`
- Nav links: `text-sm font-medium text-gray-600 hover:text-gray-900`
- `Send a parcel →`: `bg-primary text-white rounded-lg px-4 py-2 text-sm font-semibold`
- Mobile: hamburger collapses all nav links, keeps `[Send a parcel →]` visible at all times

**Conversion note:** The primary CTA is always visible on scroll. Do not hide it behind a hamburger on mobile.

---

### 02 — Hero

**Goal:** Stop the scroll. Make the sender feel understood in under 3 seconds.

**Background:** White. No gradients, no hero images that slow load. One strong illustration or a real photo of a Zimbabwe vehicle/route on the right.

**Layout:** Left-aligned text (60%), right illustration (40%). Full-width on mobile.

---

#### Eyebrow label
```
🇿🇼  Zimbabwe's parcel network — now moving
```
`text-xs font-semibold uppercase tracking-widest text-accent`

#### Headline
```
Your parcel shouldn't wait
for tomorrow's courier truck.
```
`text-5xl font-extrabold text-gray-900 leading-tight`  (mobile: `text-3xl`)

**Why this headline works:**
- Opens with the sender's exact frustration
- Implies the solution without stating it yet (curiosity gap)
- "Tomorrow's courier truck" is a specific, recognisable pain — not abstract

#### Subheading
```
Nhume matches your parcel with verified transporters
already travelling to your destination — today.
```
`text-lg text-gray-500 mt-4 max-w-lg`

#### CTA pair
```
[  Send a parcel →  ]     [  See how it works  ]
```
- Primary: `bg-primary text-white rounded-lg px-6 py-3 text-base font-semibold shadow-sm hover:bg-primary-dark`
- Secondary: `text-primary font-semibold underline-offset-2 hover:underline`

**Microcopy below CTAs:**
```
No account needed to browse journeys.
```
`text-xs text-gray-400 mt-2`

**Conversion note:** "No account needed to browse" removes the single biggest friction point for first-time visitors. Let them see journeys before asking for signup.

---

### 03 — Live Urgency Strip

**Goal:** Create real urgency with actual data. Not fake countdown timers.

**Background:** `bg-primary` (blue). Full width. Single line.

```
🚌  14 journeys departing today  ·  Harare → Bulawayo  ·  Harare → Mutare  ·  Harare → Gweru  ·  Next departure in 47 min
```

`text-sm text-white font-medium text-center py-2.5`

**Conversion note:** This strip is seeded with real (admin-seeded) journeys from day one. It creates credibility and urgency without being dishonest. The "next departure in X min" is calculated from actual departure_at fields in the DB.

---

### 04 — The Problem (make them feel it)

**Goal:** The sender should read this and think "yes, exactly."

**Background:** `bg-gray-50`

**Section heading:**
```
Sound familiar?
```
`text-3xl font-bold text-gray-900 text-center`

**3-column pain cards:**

| Card 1 | Card 2 | Card 3 |
|--------|--------|--------|
| 🕐 | 📦 | 💸 |
| **"The truck leaves tonight."** | **"Delivery will be tomorrow."** | **"That'll be $12 for 2-day delivery."** |
| You need it there today. Three buses have already left. The space was there — just not connected to you. | Your parcel sits in a depot overnight. The recipient waits. The opportunity passes. | Standard courier pricing built for bulk, not for one parcel between two people. |

Cards: `bg-white rounded-2xl p-6 border border-gray-100 shadow-sm`

**Section close line:**
```
The problem isn't a lack of transport.
It's that transport and parcels aren't connected.
```
`text-xl font-semibold text-gray-700 text-center mt-10`

---

### 05 — The Solution (the flip)

**Goal:** The transition from problem to solution. Short, punchy.

**Background:** White

**Heading:**
```
Nhume connects them.
```
`text-4xl font-extrabold text-gray-900 text-center`

**Subheading:**
```
Every day, hundreds of vehicles travel between Zimbabwe's cities with empty space.
Nhume lets that space carry your parcel.
```
`text-lg text-gray-500 text-center max-w-2xl mx-auto mt-4`

**Visual:** A simple route map illustration — dots for Harare, Bulawayo, Mutare, Gweru, connected by route lines with moving vehicle icons. Animated if possible (subtle CSS animation). This is the brand hero visual.

---

### 06 — How It Works (for senders)

**Goal:** Remove confusion. Make the process feel obvious and easy.

**Background:** `bg-gray-50`

**Heading:**
```
Send a parcel in 3 steps
```

**Steps:**

```
[1]                          [2]                          [3]
Post your parcel        →    Choose a journey        →    Done.
                             
Tell us: what, where,        Browse verified                The transporter picks
from, to. Takes 60           transporters already           up your parcel and
seconds.                     heading your way.              delivers it. You track
                             Pick the one that fits.        every step.
```

- Step numbers: large `text-5xl font-extrabold text-primary-light` (decorative, not dominant)
- Step title: `text-xl font-semibold text-gray-900`
- Step description: `text-sm text-gray-500`
- Arrow connectors between steps on desktop (hidden on mobile, vertical flow instead)

**CTA below steps:**
```
[  Post a parcel now — it's free  →  ]
```
`bg-primary text-white rounded-lg px-8 py-3 font-semibold mt-10 mx-auto block w-fit`

---

### 07 — Social Proof Stats Bar

**Goal:** Build credibility with specific, believable numbers.

**Background:** White, thin top/bottom border

**4 stats in a row** (2×2 on mobile):

```
[ 500+            ]  [ 20               ]  [ 4                ]  [ < 6 hrs          ]
[ Parcels moved   ]  [ Verified          ]  [ Active routes    ]  [ Avg delivery     ]
[                 ]  [ transporters      ]  [                  ]  [ Harare–Bulawayo  ]
```

- Number: `text-4xl font-extrabold text-primary`
- Label: `text-sm text-gray-500 mt-1`

**Conversion note:** Start with real, achievable numbers even if small. "500+" is credible on day 30. "50,000+" is not. Specific believable numbers convert better than inflated unbelievable ones. Update these as the platform grows.

---

### 08 — Featured Journeys (live social proof)

**Goal:** Show real journeys, real transporters. Convert browsers into bookers.

**Background:** `bg-gray-50`

**Heading:**
```
Journeys leaving soon
```
`text-3xl font-bold text-gray-900`

**Subheading:**
```
These transporters are already heading there — book the space.
```
`text-gray-500`

**3 journey cards** (horizontally scrollable on mobile):

```
┌─────────────────────────────────────────┐
│  Harare → Bulawayo              TODAY   │
│  Departing 14:00                        │
│                                         │
│  [Avatar]  Tendai M.   🔵 Nhume Reviewed│
│  Toyota Quantum · Space for 4 parcels   │
│                                         │
│  From $3 / parcel                       │
│                        [Book space →]   │
└─────────────────────────────────────────┘
```

Card: `bg-white rounded-2xl border border-gray-200 p-6 shadow-sm`
Route: `text-lg font-semibold text-gray-900`
Trust badge: blue pill, `bg-blue-50 text-blue-700 text-xs font-medium px-2.5 py-0.5 rounded-full`
CTA: `text-primary font-semibold text-sm hover:underline`

**Below cards:**
```
[  Browse all journeys  →  ]
```

---

### 09 — Trust Section (the Nhume Reviewed explanation)

**Goal:** Explain the trust system. This is Nhume's key differentiator. Senders need to know their parcel is safe.

**Background:** White

**Heading:**
```
Every transporter on Nhume is reviewed before they carry your parcel.
```
`text-3xl font-bold text-gray-900 text-center max-w-3xl mx-auto`

**4 trust tier cards** in a horizontal row:

```
[ ○ Unverified    ]  [ 🔵 Nhume Reviewed ]  [ 🟡 ID Submitted  ]  [ ✅ Verified       ]
[ Registered but  ]  [ Our team has      ]  [ Documents        ]  [ Fully background  ]
[ not yet checked ]  [ spoken to this    ]  [ uploaded and     ]  [ checked. Our      ]
[                 ]  [ transporter       ]  [ under review     ]  [ highest tier.     ]
[                 ]  [ personally.       ]  [                  ]  [                   ]
```

**Highlight "Nhume Reviewed" as the minimum bar:**
```
We only list transporters who are at minimum Nhume Reviewed.
No anonymous drivers. No unverified strangers.
```
`text-sm text-gray-500 text-center mt-6`

**Conversion note:** The trust section answers the #1 objection: "How do I know my parcel is safe?" Address it directly, don't bury it in FAQs.

---

### 10 — For Transporters (secondary audience)

**Goal:** Recruit transporters without confusing senders who are scrolling past.

**Background:** `bg-primary` (dark blue band — visually distinct, signals a different audience)

**Layout:** Left text, right illustration of a vehicle with earning graphic.

**Eyebrow:**
```
For transport operators
```
`text-xs font-semibold uppercase tracking-widest text-blue-200`

**Heading:**
```
You're already making the trip.
Get paid for the space you're not using.
```
`text-4xl font-extrabold text-white`

**3 benefit bullets:**
```
✓  Zero deadhead kilometres — earn on every journey you're already taking
✓  You set your price and availability — full control, no commitment
✓  Nhume handles the matching — you focus on driving
```
`text-sm text-blue-100`

**CTA:**
```
[  Register as a transporter  →  ]
```
`bg-white text-primary rounded-lg px-6 py-3 font-semibold`  (inverted colours on dark bg)

**Microcopy:**
```
Free to join. No monthly fees. Commission only when you earn.
```
`text-xs text-blue-200 mt-2`

---

### 11 — Routes We Cover

**Goal:** Reassure visitors that their specific corridor is active.

**Background:** `bg-gray-50`

**Heading:**
```
Active routes
```

**Route pills in a flex-wrap grid:**

```
[  Harare → Bulawayo  ]  [  Harare → Mutare  ]  [  Harare → Gweru  ]
[  Bulawayo → Victoria Falls  ]  [  + More routes coming  ]
```

Pill style: `bg-white border border-gray-200 rounded-full px-4 py-2 text-sm font-medium text-gray-700 shadow-sm`

"More routes coming" pill: `bg-primary-light text-primary border border-primary/20 ...`

**Below:**
```
Don't see your route?
[  Request a route  ]  — we'll notify you when a transporter registers.
```
`text-sm text-gray-500 text-center mt-6`

---

### 12 — Testimonials / Social Proof Quotes

**Goal:** Real voices. Even one real testimonial beats ten statistics.

**Background:** White

**Heading:**
```
What people are saying
```

**For MVP launch (before real reviews):** Use the journey itself as the testimonial. Frame actual completed bookings as the proof.

```
"Sent documents from Harare to Bulawayo. Arrived in 5 hours.
I didn't have to go anywhere — the transporter picked them up."
— Ruvimbo T., Harare
```

Card: `bg-gray-50 rounded-2xl p-6 border-l-4 border-primary italic text-gray-700`

**Conversion note:** Collect real testimonials from the first 10 completed bookings. Offer a discount on the next booking in exchange for a review. Get the name, city, and what they sent — specifics build credibility.

---

### 13 — FAQ (objection handler)

**Goal:** Surface and neutralise the top 6 objections before the visitor leaves.

**Background:** `bg-gray-50`

**Heading:**
```
Common questions
```

**Q&A pairs (accordion on mobile, visible on desktop):**

---

**Q: Is my parcel insured?**
A: Every booking on Nhume includes basic parcel cover. For high-value items, you can declare the value and add extended cover at checkout.

---

**Q: What if the transporter doesn't show up?**
A: You pay only after the transporter confirms pickup. If they cancel, you get a full refund instantly. We also have backup transporter options on popular routes.

---

**Q: How are transporters verified?**
A: All transporters are at minimum "Nhume Reviewed" — our team speaks to every transporter before they go live. Higher tiers require ID submission and background checks.

---

**Q: What can I send?**
A: Documents, clothing, electronics, food items, small household goods. No hazardous materials, no live animals, no illegal items. Max parcel size is calculated at checkout.

---

**Q: How does the transporter pick up my parcel?**
A: You and the transporter agree on a pickup point — usually a central, public location in your city. Details are confirmed via the platform once you book.

---

**Q: Do I need an account to book?**
A: You can browse journeys without an account. You'll create a free account only when you're ready to book — takes under 60 seconds.

---

**Conversion note:** The FAQ is a conversion tool, not a support dump. Every question here is a reason someone *didn't* book. Write answers that remove the blocker, not just answer the question.

---

### 14 — Final CTA Strip

**Goal:** Catch the visitor who scrolled all the way down without converting.

**Background:** `bg-primary`

**Heading:**
```
Your parcel could be there today.
```
`text-4xl font-extrabold text-white text-center`

**Subheading:**
```
Browse journeys leaving now — no account required.
```
`text-lg text-blue-100 text-center mt-3`

**CTA pair:**
```
[  Browse journeys  →  ]     [  Post a parcel  ]
```
- Primary: `bg-white text-primary rounded-lg px-8 py-3 font-semibold`
- Secondary: `border border-white text-white rounded-lg px-8 py-3 font-semibold`

---

### 15 — Footer

**Layout:** 4 columns + bottom bar

```
[Nhume logo]                 Platform        Support          Company
"Moving parcels with         How it works    FAQ              About
 journeys already            Send a parcel   Contact us       Safety policy
 in motion."                 Browse journeys Report an issue  Become a partner
                             For transporters                 Blog
[LinkedIn] [Facebook]        Pricing

──────────────────────────────────────────────────────────────────────
© 2025 Nhume · Terms of Service · Privacy Policy · Cookie Policy
```

Footer bg: `bg-gray-900` text: `text-gray-400` headings: `text-white`

---

## Full Page Section Order Summary

```
01  Navigation (sticky)
02  Hero
03  Urgency strip (live journeys count)
04  The Problem
05  The Solution
06  How It Works (3 steps)
07  Social Proof Stats
08  Featured Journey Cards
09  Trust / Nhume Reviewed explanation
10  For Transporters (dark blue band)
11  Routes We Cover
12  Testimonials
13  FAQ
14  Final CTA Strip
15  Footer
```

---

## CTA Strategy

| Section | CTA | Goal |
|---------|-----|------|
| Nav (sticky) | Send a parcel → | Always visible conversion |
| Hero primary | Send a parcel → | Main conversion path |
| Hero secondary | See how it works | Engage the unconvinced |
| Below hero | No account needed to browse | Remove friction |
| How it works | Post a parcel now — it's free → | Mid-page catch |
| Journey cards | Book space → | Transactional, high intent |
| For transporters | Register as a transporter → | Secondary audience |
| Routes | Request a route | Low-friction email capture |
| Final strip | Browse journeys → / Post a parcel | Last-chance catch |

**Rule:** There is always a CTA visible within one screen-height of any section. Never let the visitor go 800px without a next step.

---

## Copy Principles

**1. Outcome language, not feature language**
- ❌ "Our matching algorithm connects you with transporters"
- ✅ "Your parcel reaches Bulawayo today"

**2. Specificity builds trust**
- ❌ "Fast delivery"
- ✅ "Harare to Bulawayo in under 6 hours"

**3. Acknowledge the risk, then dissolve it**
- ❌ (ignoring the safety objection)
- ✅ "Every transporter is reviewed by our team before they carry a single parcel"

**4. Zimbabwe-native language**
- Use city names the market knows: Harare, Bulawayo, Mutare, Gweru
- Reference "Toyota Quantum" not "minibus" — it's what people know
- "Courier depot" language resonates — people have experienced this pain

**5. Loss aversion over FOMO**
- ❌ "Others are already saving money!"
- ✅ "14 vehicles are heading to Bulawayo today. Your parcel could be on one of them."

---

## Mobile Optimisation

- Hero CTA: minimum 48px tap target, full-width button on small screens
- Journey cards: horizontally scrollable carousel, not grid
- Stats bar: 2×2 grid, not 4-across
- FAQ: accordion (tap to open)
- Nav: sticky bottom bar on mobile with `[Browse] [Send] [Sign in]` — more accessible than top nav
- Urgency strip: scrolling marquee on mobile to fit without truncation
- Transporter section: stack vertically, keep CTA button full-width

---

## Page Performance Rules

- Largest Contentful Paint (LCP) target: under 2.5s
- No hero video autoplay
- Hero illustration: SVG preferred, PNG max 80KB
- Defer all non-critical JS
- Lazy-load journey cards (below fold)
- Preconnect to Google Fonts: `<link rel="preconnect" href="https://fonts.googleapis.com">`
- Use Vite for asset bundling (already in stack)

---

## A/B Tests to Run (post-launch)

| Test | Variant A | Variant B | Metric |
|------|-----------|-----------|--------|
| Hero headline | "Your parcel shouldn't wait for tomorrow's courier truck." | "Send a parcel to Bulawayo — today." | CTA click rate |
| Hero CTA | "Send a parcel →" | "Browse journeys →" | Signup rate |
| Trust section | Trust tier explanation | Transporter face photos + name | Booking rate |
| Urgency strip | "14 journeys departing today" | "Next departure: 47 min" | Session duration |
| Primary CTA colour | `bg-primary` (blue) | `bg-accent` (amber) | Click-through |

---

## Metrics to Track

| Metric | Target | Tool |
|--------|--------|------|
| Hero CTA click rate | > 8% of visitors | Laravel + custom events |
| Browse → Book conversion | > 15% of browsers | Session tracking |
| Time on page | > 90 seconds | Analytics |
| Scroll depth | 60%+ reach "How it works" | Analytics |
| Bounce rate | < 55% | Analytics |
| Mobile vs desktop split | Track both separately | Analytics |
| Transporter signup rate | > 2% of all visitors | Funnel tracking |
