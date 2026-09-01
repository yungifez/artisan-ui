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

Use a conventional commit prefix when the change should appear in the next release:

- `fix:` for a bug fix and a patch release.
- `feat:` for a backwards-compatible feature and a minor release.
- `feat!:` for a breaking change and a major release.

Keep each pull request focused. Add tests for behavior changes and include Laravel version details when a change affects framework integration.

## Releases

Pushes to `main` run Release Please. It opens or updates a release pull request with the next version and changelog. After the release pull request passes the normal checks and is merged, Release Please creates the semantic version tag and GitHub release.

The manual `Release` workflow remains available for recovery releases. Do not run it while a Release Please pull request is pending for the same changes. The docs site then updates its package constraint and receives the matching release tag.
