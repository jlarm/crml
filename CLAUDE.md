# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Development Commands

### Composer Scripts
- `composer run dev` - Runs the full development environment with concurrent processes (server, queue, logs, vite)
- `composer run test` - Clears config cache and runs all tests
- `php artisan test` - Run tests using Artisan
- `vendor/bin/pest` - Run Pest tests directly

### NPM Scripts  
- `npm run dev` - Start Vite development server for asset compilation
- `npm run build` - Build assets for production

### Code Quality
- `vendor/bin/pint` - Laravel Pint code formatter (PSR-12)
- Tests use Pest framework (configured in `tests/Pest.php`)

### Artisan Commands
Standard Laravel commands plus:
- `php artisan serve` - Start development server
- `php artisan queue:listen --tries=1` - Process queue jobs
- `php artisan pail --timeout=0` - Real-time log monitoring

## Architecture Overview

This is a Laravel 12 application using the **Laravel Livewire Starter Kit** with:

### Core Stack
- **Laravel 12** with PHP 8.2+
- **Livewire Volt** for component-based interactivity  
- **Flux UI** components library
- **Pest** for testing instead of PHPUnit
- **Tailwind CSS 4** with Vite
- **SQLite** database (development)

### Directory Structure
- `app/Livewire/` - Livewire components organized by feature:
  - `Actions/` - Action components
  - `Auth/` - Authentication components  
  - `Settings/` - Settings components
- `resources/views/` - Blade templates with dedicated subdirectories:
  - `flux/` - Flux UI component templates
  - `livewire/` - Livewire component views
  - `components/` - Reusable Blade components
  - `partials/` - Partial templates

### Key Technologies
- **Livewire Volt**: Single-file components mixing PHP logic with Blade templates
- **Flux**: Modern UI component library for consistent design
- **Pest**: Modern PHP testing framework with expressive syntax
- **Vite + Tailwind**: Asset bundling with utility-first CSS

### Database
- Uses SQLite for development (`database/database.sqlite`)
- Standard Laravel migrations in `database/migrations/`
- Factories and seeders in respective directories

## Development Workflow

### Starting Development
Use `composer run dev` to start all services concurrently:
- Laravel development server
- Queue worker  
- Log monitoring (Pail)
- Vite asset compilation

### Testing
- Primary test framework: **Pest** (not PHPUnit)
- Test configuration in `tests/Pest.php`
- Feature tests in `tests/Feature/`
- Unit tests in `tests/Unit/`
- Use `composer run test` for full test suite

### Asset Compilation
- Entry points: `resources/css/app.css` and `resources/js/app.js`
- Tailwind CSS 4 with Vite plugin
- Hot reload enabled in development