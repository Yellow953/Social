# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**ESIB Social** is an academic learning platform for students at ESIB. It provides course materials, video recordings, and academic resources with a subscription-based access model.

## Commands

### Development
```bash
composer dev          # Start all services concurrently: PHP server, queue worker, pail log viewer, and Vite
```

### Individual services
```bash
php artisan serve     # PHP dev server only
npm run dev           # Vite dev server only
php artisan queue:listen --tries=1  # Queue worker
```

### Setup (first time)
```bash
composer setup        # Install deps, generate key, migrate, npm install, build
php artisan db:seed   # Seed super_admin user
php artisan storage:link  # Link storage for file serving
```

### Testing
```bash
composer test                              # Run all tests (clears config first)
php artisan test --filter=TestClassName    # Run a single test class
php artisan test --filter=test_method_name # Run a single test method
```

### Linting & formatting
```bash
./vendor/bin/pint     # Laravel Pint (PHP code style fixer)
```

### Database
```bash
php artisan migrate          # Run migrations
php artisan migrate:fresh --seed  # Wipe and reseed (dev only)
```

### Assets
```bash
npm run build         # Production build
```

## Architecture

### Stack
- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: React 19 + Inertia.js 2 (no separate REST API — Inertia bridges PHP controllers directly to React components)
- **CSS**: Tailwind CSS 4 + Bootstrap 5 + Bootstrap Icons
- **Animations**: Framer Motion
- **Build**: Vite with `laravel-vite-plugin`
- **Database**: MySQL; sessions, cache, and queue all stored in the database
- **PDF generation**: `setasign/fpdf`

### How Inertia works here
Controllers return `Inertia::render('PageName', $props)` instead of views. React components in `resources/js/Pages/` are the "views". Shared global data (auth user, etc.) flows through `HandleInertiaRequests` middleware.

The JS alias `@` maps to `resources/js/`.

### Public multi-page layout
The public site (`/`, `/about`, `/academique`, `/calculatrice`) is served by a **single Inertia page** `resources/js/Pages/Welcome.jsx`. The backend passes a `page` prop that controls which sub-component renders: `resources/js/components/pages/` (HomePage, AboutPage, AcademiquePage, CalculatricePage).

### Auth & access control flow
1. **Registration → email verification** (link-based, `MustVerifyEmail`)
2. **Login** → optional **2FA via OTP** email code
3. **Single-device enforcement** via `SingleDeviceLogin` middleware (keyed by `md5(userAgent + IP)`)
4. **Subscription gate**: the `subscription` middleware (`CheckSubscription`) blocks access to locked materials without an active subscription

### User roles
- `user` — standard student
- `admin` — can manage content and approve subscriptions
- `super_admin` — can also manage admins; `isAdmin()` returns true for both admin levels

### Subscription model
Subscriptions require manual admin approval (`status: pending → approved`). They optionally expire (`expires_at`). Access to locked materials checks `User::hasActiveSubscription()`.

### Content hierarchy
```
Course (major, year, semester)
  └── Material (type: cours | tp | video_recording; watermark_type: none | full | logo_only | username_only)
        └── MaterialMedia (ordered by `order` column; type, file_path, is_locked)
```

Both `Material` and `MaterialMedia` have independent `is_locked` flags. Media locking requires a subscription even if the parent material is unlocked.

### Admin panel
All admin routes are under `/admin` with the `admin` middleware. Key areas:
- `/admin/dashboard` — overview
- `/admin/users` — user management (CRUD + quick subscription creation)
- `/admin/courses` — course CRUD
- `/admin/materials` — material CRUD with file upload (Dropzone), temp upload, PDF conversion, lock toggle
- `/admin/subscriptions` — approve/reject subscription requests
- `/admin/content-management` — manage homepage slideshow slides (`HomepageSlide` model, ordered by `order` column)
- `/admin/analytics` — usage analytics
- `/admin/access-logs` — material access audit log

### File serving
Media files are stored in Laravel's `storage/` and served through `MediaController` (with streaming support for video). Watermarks are applied server-side when serving PDFs.

### Key middleware
| Alias | Class | Purpose |
|-------|-------|---------|
| `single.device` | `SingleDeviceLogin` | Enforce one active device per user |
| `subscription` | `CheckSubscription` | Gate locked materials behind active subscription |
| `admin` | `AdminMiddleware` | Restrict routes to admin/super_admin roles |
| `verified` | Laravel built-in | Require verified email |
