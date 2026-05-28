# code-snippet-laravel

> A production-ready Laravel admin panel featuring authentication, user management, and role-based permissions - designed as the kind of backend foundation most real-world internal tools and client dashboards need before business-specific features are added.

---

## About This Project

This project is a full-stack Laravel 9 admin application built with real-world development practices in mind - not just another basic CRUD demo.

It includes a complete authentication flow, an admin dashboard, user management powered by DataTables, role and permission handling, profile settings, and password reset functionality, all organized with a clean and maintainable architecture.

The application runs entirely in Docker using Nginx, PHP-FPM, and MySQL, making local setup simple and consistent across environments without the usual PHP version conflicts or manual setup headaches.

---

## Table of Contents

1. [What Problem This Solves](#what-problem-this-solves)
2. [Who This Helps](#who-this-helps)
3. [Features](#features)
4. [Tech Stack](#tech-stack)
5. [Architecture Overview](#architecture-overview)
6. [Project Structure](#project-structure)
7. [Getting Started](#getting-started)
8. [Environment Variables](#environment-variables)
9. [Default Login](#default-login)
10. [Testing](#testing)
11. [Security Notes](#security-notes)
12. [Common Issues](#common-issues)

---

## What Problem This Solves

Every admin panel project starts the same way. Before you build invoices, reports, or whatever the product actually does, you need:

- Someone to log in
- A way to manage users
- Roles that control who sees what
- Password reset when someone locks themselves out
- A layout and navigation that does not fall apart on the first feature add

That boilerplate takes days - sometimes weeks - and it is easy to get wrong. Login without rate limiting. Permissions hard-coded in controllers. Mass-assignment bugs on profile update. Reset tokens that never expire.

This snippet handles that foundation so you can skip straight to domain work.

| Problem | How this project handles it |
|--------|-----------------------------|
| Controllers grow fat with SQL and validation | Thin controllers + `UserService`, `RoleService`, `RegisterUserService` |
| "Can this user do X?" scattered everywhere | Database-driven permissions registered as Laravel Gates |
| Admin UI needs lists with search and pagination | Yajra DataTables on the user index |
| Auth flows are repetitive and easy to misconfigure | Dedicated FormRequests + middleware (`auth`, `account.approved`) |
| Docker setups rot when base images go EOL | PHP 8.1 on Debian Bookworm, MySQL 8, documented `.env` for containers |

---

## Who This Helps

- **Backend developers** picking up Laravel who want to see services, FormRequests, and middleware used consistently - not mixed into 200-line controllers.
- **Teams bootstrapping an internal admin** for support, ops, or content - clone, rebrand, add your modules.
- **Freelancers** who need a defensible RBAC base for client projects without building permissions from scratch each time.
- **Learners** comparing how Laravel handles auth, policies/gates, and layered architecture compared to Node or React-only stacks in this repo.

---

## Features

### Authentication
- Login with email and password (rate-limited)
- User registration with phone, email, and password rules
- Forgot password → email link → reset with expiring, hashed tokens
- Account must be approved (`status = 1`) before accessing the admin area

### Users
- List users with server-side pagination (DataTables)
- Create, edit, view, and delete users via modals
- Toggle user status (enabled / disabled)
- Filter and search support through query filters

### Roles & permissions
- Create roles and attach permission checkboxes
- Edit role permissions in one save
- Permissions stored in DB and exposed as Gates (`user_listing`, `roles_create`, etc.)
- Admin role gets all permissions; user role gets a limited set

### Account
- Update name and profile photo (base64 upload with type whitelist)
- Change password from account settings

### Dashboard
- User count for admins with listing permission

---

## Tech Stack

| Layer | Choice |
|-------|--------|
| Framework | Laravel 9.x |
| PHP | 8.1+ |
| Database | MySQL 8 |
| Auth | Session-based (web guard) |
| Tables | Yajra Laravel DataTables |
| Frontend | Blade templates, jQuery, Bootstrap-style admin UI |
| Containers | Docker Compose - nginx, PHP-FPM, MySQL, phpMyAdmin |

---

## Architecture Overview

Requests flow through middleware first, then into thin controllers, then into services that talk to Eloquent models.

```
Browser
   │
   ▼
nginx (:7200)
   │
   ▼
PHP-FPM (Laravel)
   │
   ├── Middleware ── auth, account.approved, throttle
   │
   ├── Controllers ── validate via FormRequest, delegate to Service
   │
   ├── Services ── UserService, RoleService, RegisterUserService
   │
   ├── Models + Traits ── User, Role, HasPermissionsTrait
   │
   └── Gates ── registered from permission_lists (cached)
```

**Permission check path:** On boot, `PermissionsServiceProvider` reads `permission_lists` and defines a Gate per slug. When a controller calls `$user->can('user_edit')`, the Gate asks `HasPermissionsTrait` whether the user's role has that permission in `role_permissions`.

**Why services accept `Request` objects:** Controllers stay thin; services pull what they need. For a larger app you'd swap Request for DTOs - here the pattern is clear enough to extend.

**Transactions:** User and role saves that touch multiple tables run inside `DB::transaction()` so you do not end up with half-written role permissions.

---

## Project Structure

```
code-snippet-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Dashboard, users, roles, account
│   │   │   └── Auth/           # Login, register, forgot password
│   │   ├── Middleware/         # Admin, role, account approval
│   │   └── Requests/           # Form validation per endpoint
│   ├── Services/
│   │   ├── Admin/              # UserService, RoleService
│   │   └── Auth/               # RegisterUserService
│   ├── Models/                 # User, Role, PermissionList, LoginOtp, …
│   ├── DataTables/             # UserDataTable (Yajra)
│   ├── Mail/                   # ForgetPassword, SendCodeMail
│   ├── Providers/              # PermissionsServiceProvider (Gates + cache)
│   ├── Traits/                 # HasPermissionsTrait, Filterable
│   └── Rules/                  # PasswordFormat
├── database/
│   ├── migrations/
│   └── seeders/                # Roles, admin user, permissions
├── resources/views/
│   ├── admin/                  # Dashboard, users, roles, account
│   ├── auth/                   # Login, register, reset password
│   └── layouts/                # Admin + auth layouts
├── routes/
│   ├── admin.php               # All /admin/* routes
│   └── web.php                 # Register + redirect
├── docker/
│   └── entrypoint.sh           # Fixes storage permissions on start
├── docker-compose.yaml
├── Dockerfile
└── tests/Feature/              # Login, register, reset, upload, …
```

---

## Getting Started

You need **Docker** and **Docker Compose** installed.

### 1. Clone and configure

```bash
cd code-snippet-laravel
cp .env.example .env
```

Edit `.env` for Docker:

```env
APP_URL=http://localhost:7200

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret

ADMIN_EMAIL=admin@admin.com
ADMIN_PASSWORD=YourSecurePassword123!
MYSQL_ROOT_PASSWORD=root_secret_different
```

`DB_HOST` must be `mysql` inside Docker - not `127.0.0.1`.

### 2. Start containers

```bash
docker compose up -d --build
docker compose ps
```

All four services should be up: `laravel_snippet`, `mysql_admin_users`, `nginx_admin_users`, `phpmyadmin_admin_users`.

### 3. Install Laravel and seed the database

```bash
docker exec laravel_snippet composer install
docker exec laravel_snippet php artisan key:generate
docker exec laravel_snippet php artisan migrate
docker exec laravel_snippet php artisan db:seed
docker exec laravel_snippet php artisan storage:link
docker exec laravel_snippet php artisan cache:clear
```

Run `cache:clear` after seeding so permission Gates register correctly.

### 4. Open the app

| Page | URL |
|------|-----|
| Admin login | http://localhost:7200/admin |
| Register | http://localhost:7200/register |
| phpMyAdmin | http://127.0.0.1:7100 |

---

## Environment Variables

| Variable | Purpose |
|----------|---------|
| `APP_URL` | Base URL (use `http://localhost:7200` for local Docker) |
| `DB_HOST` | `mysql` in Docker; `127.0.0.1` if running PHP on host |
| `DB_DATABASE` / `DB_USERNAME` / `DB_PASSWORD` | MySQL credentials (must match `docker-compose` / MySQL init) |
| `ADMIN_EMAIL` | Seeded super-admin email |
| `ADMIN_PASSWORD` | Seeded super-admin password - set before `db:seed` |
| `MYSQL_ROOT_PASSWORD` | Separate root password for MySQL container |

---

## Default Login

After seeding (with the example `.env` above):

- **Email:** `admin@admin.com`
- **Password:** whatever you set in `ADMIN_PASSWORD`

The seeded admin has the `admin` role with all permissions.

---

## Testing

Automated tests use SQLite in memory - no MySQL needed for the test suite.

```bash
# Inside Docker
docker exec laravel_snippet php artisan test

# Or on host (requires pdo_sqlite)
composer install
php artisan test
```

Coverage includes login, registration (including blocked ID override), password reset expiry, rate limiting, profile image validation, OTP hashing, and HTML sanitization.

CI runs on GitHub Actions: `composer install`, `composer audit`, `php artisan test`.

---

## Security Notes

This snippet has been hardened across several audit cycles. Highlights:

- Login and password reset routes are rate-limited
- Reset tokens are hashed at rest and expire after 60 minutes
- Profile image uploads whitelist file types (no arbitrary extensions)
- Modal view names are whitelisted (no user-controlled Blade paths)
- Registration rejects a client-supplied `id` field
- Email HTML is sanitized with `voku/anti-xss`
- OTP codes are hashed in the database

Run `composer audit` before deploying and keep dependencies updated.

---

## Common Issues

**"You are not authorized" on dashboard after login**  
Permission cache was likely built before seeding. Run:

```bash
docker exec laravel_snippet php artisan cache:clear
```

Then refresh the page.

**Permission denied on `storage/logs`**  
The Docker entrypoint fixes this on container start. If it persists:

```bash
docker exec -u root laravel_snippet chown -R www-data:www-data storage bootstrap/cache
docker exec -u root laravel_snippet chmod -R 775 storage bootstrap/cache
```

**Database connection refused**  
Check `DB_HOST=mysql` in `.env` and restart: `docker compose restart`.

**Docker build fails with "no space left on device"**  
Free disk space: `docker system prune -af`

**Login fails after seed**  
Confirm `ADMIN_PASSWORD` was set in `.env` before running `php artisan db:seed`, or re-seed after setting it.

---

## Requirements

- PHP 8.1+ (8.1 in Docker image)
- Composer 2.x
- MySQL 8
- Docker & Docker Compose (recommended)

For local PHP without Docker: match extensions in `composer.json`, point `DB_HOST` to your MySQL instance, and follow the same artisan commands on your machine.
