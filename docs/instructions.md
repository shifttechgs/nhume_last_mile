# Nhume — Development Instructions

## Environment Setup

```bash
# Install dependencies
composer install
npm install

# Copy environment file
cp .env.example .env
php artisan key:generate

# Run migrations with seed data
php artisan migrate:fresh --seed

# Start dev server (two terminals)
php artisan serve
npm run dev
```

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 12, PHP 8.4 |
| Frontend | Blade, Livewire 3, AlpineJS |
| Styling | Tailwind CSS 4, Vite |
| Database | SQLite (dev), MySQL (prod) |
| Auth | Laravel Breeze (Blade stack) |

**Never use:** React, Vue, Bootstrap, Inertia.js, or any JS framework beyond AlpineJS.

## Architecture Rules

- **Controllers are thin.** One responsibility: receive HTTP, delegate, return response.
- **Business logic lives in `app/Services/` and `app/Actions/`.** Services orchestrate. Actions are single-purpose.
- **`app/DTOs/`** — typed data transfer between layers. Use PHP 8.4 readonly properties.
- **`app/Repositories/`** — all Eloquent queries go here, never in controllers or views.
- **`app/ViewModels/`** — shape data for Blade views. Never pass raw Eloquent models to views.
- **`app/Enums/`** — all status fields are backed enums, never raw strings.
- **Strong typing everywhere.** Return types, parameter types, no mixed.

## Key Commands

```bash
php artisan serve          # Start dev server
npm run dev                # Build assets (watch)
php artisan migrate:fresh --seed  # Reset and reseed database
php artisan test           # Run test suite
php artisan make:livewire  # Create Livewire component
```

## Folder Conventions

```
app/Actions/        # Single-purpose action classes
app/DTOs/           # Readonly PHP 8.4 data classes
app/Enums/          # All backed enums
app/Repositories/   # All Eloquent queries
app/Services/       # Business logic orchestration
app/ViewModels/     # Data shaping for Blade views
app/Livewire/       # Livewire components (Parcel/ Journey/ Transporter/ Shared/)
```

## MVP Scope

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
