# Copilot Instructions for Bali Zoo Laravel Project

## Project Overview
- This is a Laravel-based web application for Bali Zoo, using PHP, Blade templates, and Livewire for dynamic UI components.
- The architecture follows standard Laravel conventions: MVC structure, service providers, middleware, and Eloquent ORM for database access.
- Key directories:
  - `app/Models/`: Eloquent models for core entities (Product, Cart, User, etc.)
  - `app/Http/Controllers/`: Route controllers for web/API endpoints
  - `app/Livewire/`: Livewire components for interactive UI
  - `resources/views/`: Blade templates for frontend rendering
  - `database/migrations/`, `factories/`, `seeders/`: Database schema, test data, and seeding
  - `routes/`: Route definitions (`web.php`, `api.php`, `console.php`)

## Developer Workflows
- **Local development:**
  - Use [Laragon](https://laragon.org/) for local environment (Windows)
  - Start server: `php artisan serve`
  - Hot reload assets: `npm run dev` (uses Vite)
- **Database:**
  - SQLite by default (`database/database.sqlite`)
  - Migrate: `php artisan migrate`
  - Seed: `php artisan db:seed`
- **Testing:**
  - Run tests: `php artisan test` or `vendor/bin/phpunit`
  - Feature and unit tests in `tests/Feature/` and `tests/Unit/`
- **Build assets:**
  - JS/CSS: Vite config in `vite.config.js`, entry points in `resources/js/` and `resources/css/`
  - PostCSS config: `postcss.config.mjs`

## Project-Specific Patterns
- **Livewire:**
  - Interactive components in `app/Livewire/`, e.g., `Products.php`, `UpdateAddress.php`
  - Blade views use `<livewire:... />` tags
- **Custom Actions:**
  - Business logic in `app/Actions/` (Fortify, Jetstream)
- **Policies:**
  - Authorization logic in `app/Policies/`
- **Providers:**
  - Service registration in `app/Providers/`
- **Config:**
  - Project settings in `config/` (auth, cache, mail, etc.)

## Integration Points
- **External packages:**
  - Composer dependencies in `composer.json` (Laravel, Livewire, etc.)
  - NPM dependencies in `package.json` (Vite, frontend tooling)
- **Storage:**
  - Public assets in `public/assets/`, storage in `public/storage/`
- **Authentication:**
  - Uses Laravel Fortify and Jetstream for user auth and session management

## Conventions & Tips
- Use Eloquent relationships for model associations (see `app/Models/`)
- Blade templates are in `resources/views/`; use `@include`, `@extends`, and custom components in `View/Components/`
- Route model binding is common in controllers
- For new features, add migrations, models, controllers, and Blade views as needed
- Use environment variables via `.env` for config

## Example: Adding a Product
1. Create migration in `database/migrations/`
2. Add model in `app/Models/Product.php`
3. Add controller logic in `app/Http/Controllers/`
4. Add Blade view in `resources/views/`
5. Register route in `routes/web.php`

---
For more details, see the Laravel [documentation](https://laravel.com/docs) and project README.
