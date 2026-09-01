# April UI agent guide

April UI is a Laravel Blade component library. Keep changes Blade-first and
preserve Laravel conventions.

## Repository scope

- Change components, Alpine behavior, package assets, tests, docs, and previews in this repository.
- Keep interactive behavior in the component JavaScript files.
- Use Alpine data factories that return `root`, slot bindings, `init`, and public methods.
- Load optional dependencies only on pages that use them. TipTap is the current example.
- Put static layout and visual styles in Tailwind classes in the component view.
- Keep CSS selectors for generated markup, pseudo-elements, or behavior that Tailwind cannot express clearly.
- Preserve attribute forwarding and `twMerge` behavior.
- Do not edit `vendor/` files in the docs repository.

## Contribution workflow

1. Inspect the current worktree before editing.
2. Create a short-lived branch from `main`.
3. Change the component view, behavior, tests, and package docs together.
4. Build assets after changing JavaScript or CSS.
5. Run the focused tests, then run the full checks before opening a pull request.

Use these commands:

```sh
composer install
npm ci
npm run build
npm run test:browser -- --workers=1
vendor/bin/phpstan analyse --no-progress
vendor/bin/pest --no-coverage
```

Use Conventional Commits:

- `fix:` creates a patch release.
- `feat:` creates a minor release.
- `feat!:` creates a major release.
- `docs:`, `test:`, and `chore:` do not create a release.

Use an imperative subject under 50 characters. Add tests for behavior changes.

## Release workflow

1. Push the completed change to `main`.
2. GitHub Actions runs the checks and Release Please.
3. Release Please opens or updates the release pull request.
4. Review the version, changelog, package assets, and checks.
5. Merge the release pull request.
6. Release Please creates the tag and GitHub release.
7. Dependabot updates the published docs site to the new package version.

Do not edit the package version, tag, or changelog by hand during a normal
release. Do not run the manual release workflow while a Release Please pull
request is pending for the same changes.

Release Please reads commit types. Non-conventional commits remain in the
package code but do not appear in the changelog or trigger a version bump.
Use `fix:` or `feat:` when a code change must ship in a release.

Use the manual `Release` workflow only when the automated release process is
blocked or a recovery release is required.

## Docs repositories

The published docs repository uses released Composer packages. The local docs
checkout uses a Composer path repository and symlinks to `../april-ui`.

When testing package changes in the local docs checkout:

```sh
cd ../april-ui-docs-local
git switch local-april-ui
composer update yungifez/april-ui --with-dependencies
npm run build
```

Do not push the local docs branch. Push published docs changes only from the
stable docs repository.
