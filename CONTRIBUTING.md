# Contributing to April UI

April UI is a Laravel Blade component library. Keep changes close to Laravel conventions and keep the package workflow simple.

## Branches

Use `main` as the stable development branch.

Create short-lived branches from `main`:

- `feature/<name>` for a new component or feature.
- `fix/<name>` for a bug fix.
- `docs/<name>` for documentation-only changes.
- `chore/<name>` for maintenance and dependency work.

Maintainers can use `release/<version>` for release checks. Do not use release branches for normal development.

## Development

Install the PHP and JavaScript dependencies:

```sh
composer install
npm ci
```

Build the package assets and run the checks before you open a pull request:

```sh
npm run build
npm run test:browser -- --workers=1
vendor/bin/phpstan analyse --no-progress
vendor/bin/pest --no-coverage
```

Add or update the component documentation when you change a public component. Keep component views, previews, and documentation in the package repository.

## Pull requests

Open pull requests against `main`. Use an imperative commit title under 50 characters. Explain the change, the reason for the change, and the checks that you ran.

Keep each pull request focused. Add tests for behavior changes and include Laravel version details when a change affects framework integration.

## Releases

Maintainers update `CHANGELOG.md`, run the full test matrix, and create a semantic version tag such as `v1.0.0`. The docs site then updates its package constraint and receives the matching release tag.
