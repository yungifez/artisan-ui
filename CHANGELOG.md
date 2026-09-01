# Changelog

All notable changes to `april-ui` will be documented in this file.

## April UI v1.0.0 - 2026-09-01

The first stable release of April UI. Includes Laravel Blade components with Alpine and Livewire support, package-first view loading, Artisan discovery and diagnostics, local MCP tooling, accessible browser-tested behavior, and complete public component documentation.

## Unreleased

- Keep avatars and vertical carousels within their preview bounds.
- Correct banner positioning and transition classes.
- Normalize server ISO timestamps to the visitor's local calendar day.
- Dispatch initial calendar values to same-element Alpine listeners.
- Repair the multiple and range calendar examples.
- Keep dropdown calendars with week numbers within narrow containers.
- Keep single-month calendar widths stable and reset incomplete ranges when selecting an earlier date.
- Anchor combobox and date-picker panels to their triggers, including a CSS fallback when Alpine Anchor is unavailable.
- Load TipTap through an optional editor asset and give editor controls inline word-processor icons.
- Support opt-in x-teleport for combobox and date-picker panels.
- Keep data-table pagination readable on narrow screens.

## [1.0.19](https://github.com/yungifez/april-ui/compare/v1.0.18...v1.0.19) (2026-09-01)


### Bug Fixes

* align release tags with package tags ([05092f1](https://github.com/yungifez/april-ui/commit/05092f15ac55ce4052ef4a5e96a5bc6b54baa38d))

## v1.0.0 - 2026-08-31

The first stable release of April UI.

- Laravel Blade components with Alpine and Livewire support.
- Package-first view loading with explicit vendor publishing and update checks.
- Artisan component discovery, diagnostics, and local MCP tooling.
- Responsive, accessible component behavior covered by PHP and browser tests.
- Documentation and examples for the complete public component set.

## v0.0.1 prima emissio - 2024-07-24

I thought making a UI library was easy, I was wrong
