# April UI

April UI is a Laravel Blade component library with Tailwind CSS and Alpine JS. It keeps the Laravel component workflow:
use package views by default and publish application overrides only when you need to change markup.

## Install

```sh
composer require yungifez/april-ui
```

Add `@aprilStyles` and `@aprilScripts` to your layout, then use the components:

```blade
<april:button>Save changes</april:button>
```

April UI keeps components in `vendor/` by default. Use the package commands when you need more control:

```sh
php artisan april:list
php artisan april:publish button
php artisan april:update --diff
php artisan april:doctor
```

`april:publish` delegates to Laravel's vendor publishing system. Published views go to
`resources/views/vendor/april/components`, where Laravel loads them as overrides. Use `php artisan april:publish --all`
to publish every component.

## MCP server

Run `php artisan april:mcp` as a local MCP server. It exposes component listing, search, source resources, and
vendor-path publishing over newline-delimited JSON-RPC.

## Official website

You can find the official docs on the [April UI website](https://aprilui.dev).

## Livewire data tables

The Livewire adapter ships with April UI. Install April UI and Livewire in your Laravel application:

```sh
composer require yungifez/april-ui livewire/livewire
```

Then extend `Yungifez\\AprilUI\\Livewire\\DataTableComponent`, provide a query builder, and define columns with `Yungifez\\AprilUI\\Livewire\\Columns\\Column`. The adapter adds server-side search, sorting, pagination, URL state, and row selection while the base `april:data-table` component remains usable without Livewire.

## Follow me

[@yungifez](https://x.com/yungifez)
