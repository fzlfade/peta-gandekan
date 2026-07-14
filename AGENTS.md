# AGENTS.md — KKN-Gandekan

## Stack

- **Framework:** Laravel ^13.8 (PHP 8.3+)
- **Frontend:** TailwindCSS 4 + Vite (via `laravel-vite-plugin`)
- **Database:** PostgreSQL (dev, see `.env`), SQLite `:memory:` (tests)
- **Queue/Session/Cache:** `database` driver

## Commands

| Purpose | Command |
|---|---|
| Setup (fresh) | `composer setup` |
| Dev (server + queue + logs + Vite) | `composer dev` |
| Run ALL tests | `composer test` — runs `php artisan config:clear` then `php artisan test` |
| Run single test file | `php artisan test --filter=Tests\\Feature\\ExampleTest` |
| Lint | `./vendor/bin/pint` (Laravel Pint, PSR-12) |
| Build assets | `npm run build` |

> `composer test` **must** be used instead of bare `phpunit` — Laravel 13 requires `php artisan config:clear` before the test suite. The `--filter` flag works with artisan test.

## Testing quirks

- **Database:** Feature tests use `RefreshDatabase` trait if you need a fresh DB per test. The in-memory SQLite is already configured in `phpunit.xml`.
- **Unit tests** extend `PHPUnit\Framework\TestCase` (no app boot).
- **Feature tests** extend `Tests\TestCase` (app boot, HTTP assertions).

## Architecture

- **Entry point:** `public/index.php` → `bootstrap/app.php` → routes in `routes/web.php`.
- **No API routes yet** — `routes/api.php` doesn't exist. `bootstrap/app.php` checks `request->is('api/*')` for JSON rendering however.
- **Models** use PHP 8 attributes: `#[Fillable]`, `#[Hidden]` (Laravel 13 convention).
- **Only provider:** `App\Providers\AppServiceProvider`.
- **Only model:** `App\Models\User`.

## Config quirks

- `.npmrc` has `ignore-scripts=true` — npm lifecycle scripts won't run.
- Vite dev server ignores `storage/framework/views/**` for file watching.
- `SESSION_DRIVER=database`, `CACHE_STORE=database`, `QUEUE_CONNECTION=database` — these require the `sessions` / `cache` / `jobs` tables from the stock migrations.
