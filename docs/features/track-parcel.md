# Track Parcel — Feature Documentation

## Overview

The Track Parcel feature lets anyone with an order number look up the real-time status and full details of a delivery. No authentication is required — the order number itself is the access credential.

---

## User Flow

```
GET /track                     → landing state (search form)
GET /track/{orderNumber}       → found or not-found state
GET /track/nhm-20260814-8e5h   → auto-uppercased by controller

Three render states:
  ├─ No order number    → search form UI (enter your number)
  ├─ Number given, no match → "Order not found" card
  └─ Match found        → two-card layout: status + timeline | order details
```

---

## Architecture

### Entry Point
| Layer | File | Responsibility |
|---|---|---|
| Route | `routes/web.php` | `GET /track/{orderNumber?} → TrackController@show` |
| Controller | `app/Http/Controllers/TrackController.php` | Fetches task via repository, returns view |
| Repository | `app/Repositories/TaskRepository.php` | `findByOrderNumber()` — single Eloquent query |
| View | `resources/views/pages/track.blade.php` | Server-rendered; three conditional states |

### Request Flow

```
GET /track/{orderNumber?}
  │
  └─ TrackController::show(?string $orderNumber)
       ├─ null → view('pages.track', [orderNumber: null, task: null])
       │
       └─ string → strtoupper + trim
            └─ TaskRepository::findByOrderNumber(string)
                 └─ Task::where('order_number', $number)->first()
                      ├─ null  → view with task: null  (not found)
                      └─ Task  → view with full task   (found)
```

### Controller

```php
final class TrackController extends Controller
{
    public function __construct(
        private readonly TaskRepository $tasks,
    ) {}

    public function show(?string $orderNumber = null): View
    {
        if ($orderNumber === null) {
            return view('pages.track', ['orderNumber' => null, 'task' => null]);
        }

        $orderNumber = strtoupper(trim($orderNumber));

        return view('pages.track', [
            'orderNumber' => $orderNumber,
            'task'        => $this->tasks->findByOrderNumber($orderNumber),
        ]);
    }
}
```

---

## View States

### State 1 — Landing (no order number)
- Shown at `GET /track` with no slug
- Displays a search form: input + "Track" button
- Submits to `GET /track/{number}` via JS redirect
- Also accessible via the "Track" button in the nav (opens the track modal on any page)

### State 2 — Not Found
- Order number provided but no `Task` matches
- Shows the order number that was searched
- CTA: "Send a parcel"

### State 3 — Found
Two side-by-side cards (mirrors the send page card layout):

**Left card — Delivery Progress**
- Status badge (brand-coloured pill: `TaskStatus::label()`)
- Status description as the card title (`TaskStatus::description()`)
- Order number in monospace + copy-to-clipboard button
- Vertical timeline of all `TaskStatus::timeline()` steps:
  - `done` — green dot + check mark, muted label
  - `cur` — forest dot + white inner circle, full description in a bordered card with left accent
  - `fut` — small hollow dot, dimmed label, dashed connector line
  - `canc` — red dot + X mark, cancelled description

**Right card — Order Summary**
- Sections: Journey, Parcel, Recipient
- Price breakdown footer: base delivery + estimated total
- CTAs: "Send another parcel" → `/send`, "Back to home" → `/`

---

## Status Timeline

Defined by `TaskStatus::timeline()` static method:

```
Posted → Assigned → InProgress → Delivered
```

`Cancelled` is handled separately — replaces the timeline with a single cancelled step.

Each `TaskStatus` case has:
- `label()` — short name shown in the badge and done/future steps ("Order Received")
- `description()` — one-sentence explanation shown in the current step card ("We've received your order and are finding a driver")

---

## Order Number Normalisation

The controller always `strtoupper(trim($orderNumber))` before querying. This means:
- `nhm-20260814-8e5h` → finds `NHM-20260814-8E5H`
- `  NHM-20260814-8E5H  ` → correctly trimmed

---

## Database

Read-only. Single query:

```sql
SELECT * FROM tasks WHERE order_number = ? LIMIT 1
```

Columns read for display:

| Column | Used for |
|---|---|
| `order_number` | Display + copy button |
| `status` | Timeline position, badge colour |
| `created_at` | "Placed on" timestamp |
| `pickup_type` | "Pickup" row in Journey section |
| `pickup_address` | "From" row |
| `dropoff_address` | "To" row |
| `scheduled_at` | "When" row |
| `package_category` | Category row |
| `weight_kg` | Weight row |
| `is_fragile` | Fragile badge |
| `notes` | Notes row |
| `recipient_name` | Name row |
| `recipient_phone` | Phone row |
| `price_estimate` | Estimated total |

---

## Track Modal

The nav's "Track" button (present on all pages) opens `<x-landing.track-modal>` — an AlpineJS overlay with the same search input that redirects to `/track/{number}`. It is a separate UI entry point to the same controller.

---

## What's Not Built Yet

- Live status polling / WebSocket updates
- Transporter name + ETA display (requires a matched `Booking`)
- Map / route visualisation
- Push / SMS status notifications
- Per-user order history (authenticated tracking dashboard)
- Status history log with timestamps (the `status_histories` table exists but is not written to yet)
