# Our Gym App

Gym management app. Laravel 13 REST API in `backend/`, React SPA in `frontend/` (planned).
Everything in English: code, commits, issues, PRs, docs.

## Commands (from `backend/`)
- Start: `vendor/bin/sail up -d`
- Tests: `vendor/bin/sail artisan test`
- All checks (same as CI): `vendor/bin/grumphp run`. Runs on the host against Sail's PostgreSQL, so Sail must be up and the host PHP needs `pdo_pgsql`

## Principles
- Solve the issue with the minimum code needed. Minimum means no speculative features or unused abstractions, not fewer lines: readability wins over compact tricks (nested ternaries, clever one-liners).
- Apply SOLID whenever it fits.
- Before creating something, check whether it already exists.

## Architecture (backend)
These are team decisions; some are not in the code yet. Follow them when an issue first needs them.

Hexagonal, organised by bounded context. Namespace `OurGym\` maps to `src/`:
- `src/<Context>/Domain`: entities, value objects, repository interfaces, domain exceptions. No Laravel.
- `src/<Context>/Application`: one service per use case.
- `src/<Context>/Infrastructure`: Eloquent repositories. Eloquent models never leave this layer.
- `app/Http`: thin controllers, FormRequests for input validation, API Resources for output. No business logic.
- Bind interfaces in `AppServiceProvider`. Map domain exceptions to HTTP codes in `bootstrap/app.php`; no try/catch in controllers.
- Authentication: Sanctum in SPA mode (cookie-based sessions).

## Testing
- Unit: application services and domain, repositories mocked. No database.
- Integration: HTTP endpoints against the PostgreSQL `testing` database, using `RefreshDatabase`.
- Naming: `given<Context>Returns<Result>`, `#[Test]` attribute.

## Conventions
- No comments in code; use naming.
- Branch: `<issue>-short-description`. Commit and PR title: `[#<issue>] - Description`.
- Squash merge only; the PR title becomes the commit.
- PHPStan level max must pass; don't add ignores.
