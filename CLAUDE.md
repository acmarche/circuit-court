# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**Circuit Court Marche-en-Famenne** — A local/short-circuit commerce directory for the municipality of Marche-en-Famenne (Belgium). It showcases local shops ("acteurs"), browsable by interactive map, category ("filière"), and locality ("localité").

## Tech Stack

- **Laravel 12** (streamlined structure) with **PHP 8.2+**
- **Livewire 4** + **Alpine.js** for reactive UI
- **Tailwind CSS 4** for styling
- **Leaflet.js** for interactive maps with marker clustering
- **Pest 4** for testing
- **Laravel Pint** for code formatting (Laravel preset)
- **Vite 7** for asset bundling
- **MariaDB** (database name: `bottin`)

## Common Commands

```bash
composer setup          # Full initial setup (install, .env, key, migrate, npm install, build)
composer dev            # Dev mode: concurrent server + queue + pail logs + npm dev
composer test           # Clear config, lint check, run tests
composer lint           # Fix code style with Pint
composer lint:check     # Check code style without fixing
npm run dev             # Vite dev server
npm run build           # Production build
```

Run a single test:
```bash
php artisan test --compact --filter=testName
```

After modifying PHP files, run Pint:
```bash
vendor/bin/pint --dirty --format agent
```

## Architecture

### Domain Model

The core entity is **Shop** (`app/Models/Shop.php`) — a business/shop profile with address, coordinates, contact info, social media, and feature flags (PMR, click & collect, ecommerce). Key relationships:

- **Shop** belongsToMany **Category** (hierarchical, self-referential tree via parent_id)
- **Shop** belongsToMany **Tag** (grouped by **TagGroup** — these are "filières"/sectors)
- **Shop** hasMany **Media**, **Schedule**; belongsTo **Address**, **Locality**, **PointOfSale**
- **Token** belongsTo **Shop** (merchant authentication for Filament panel)

### Routing & Pages

All public routes are prefixed `/circuit-court/` (defined in `routes/web.php`). The root `/` redirects to `/circuit-court`.

Livewire page components live in `app/Livewire/CircuitCourt/`:

| Component | Route | Purpose |
|-----------|-------|---------|
| `MapPage` | `/circuit-court` | Interactive Leaflet map with tag/locality filtering |
| `ActeurIndex` | `/circuit-court/acteurs` | Shop list view with filtering |
| `ActeurShow` | `/circuit-court/acteurs/{slug}` | Shop detail page |
| `FiliereIndex` | `/circuit-court/filieres` | Tag/category listing with shop counts |
| `FiliereShow` | `/circuit-court/filieres/{slug}` | Shops in a given tag |
| `LocaliteIndex` | `/circuit-court/localites` | Locality listing with shop counts |
| `LocaliteShow` | `/circuit-court/localites/{slug}` | Shops in a given locality |
| `AboutPage` | `/circuit-court/a-propos` | Static about page |

All components use `#[Layout('layouts.circuit-court')]` and share URL-based filtering via `#[Url]` attributes.

### Views

- Layout: `resources/views/layouts/circuit-court.blade.php`
- Page views: `resources/views/livewire/circuit-court/`
- Shared partials: `resources/views/livewire/circuit-court/partials/` (filters-sidebar, filters-mobile, shop-preview, shop-card)

### Frontend

- Custom CSS theme tokens in `resources/css/app.css`: colors (`carto-main`, `carto-pink`, `carto-green`), fonts (Lobster Two for branding, Roboto for body)
- Map interaction handled via Alpine.js directives in Blade templates
- OpenStreetMap tiles as map background

### Testing

- PHPUnit config in `phpunit.xml` with SQLite in-memory database
- Test suites: Unit (`tests/Unit`) and Feature (`tests/Feature`)
- Uses Pest 4 syntax

## Domain Terminology

- **Acteur** = Shop/business profile
- **Filière** = Product/service category (implemented as Tag + TagGroup)
- **Localité** = City/locality
- **Circuit court** = Short-circuit/local commerce

## Conventions

- Follow existing code patterns — check sibling files before creating new ones
- Use `php artisan make:` commands for new files (pass `--no-interaction`)
- Prefer Eloquent relationships over raw queries; avoid `DB::` facade
- Use constructor property promotion (PHP 8 style)
- Always use explicit return types and parameter type hints
- Code style: Laravel Pint with `laravel` preset (`pint.json`)