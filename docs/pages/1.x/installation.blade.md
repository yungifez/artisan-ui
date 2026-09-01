---
view: components.docs-layout
title: Installation
description: How to install the project.
---

## Requirements

To install this project, you need:

- A Laravel 12 app
- PHP 8.3 and above
- Tailwind CSS (v4)
- Alpine JS
- A cool project idea

## Installation

To set up the project:

<ul class="flex flex-col gap-5">
    <li>
        Install the package using Composer
        <x-code-block-wrapper language="bash">
            composer require yungifez/april-ui
        </x-code-block-wrapper>
    </li>
    <li>
    In your CSS file, import the project's CSS file
    <x-code-block-wrapper title="app.css" language="css">
        @import "../../vendor/yungifez/april-ui/resources/css/april.css";
    </x-code-block-wrapper>
    </li>
    <li>
    In your JS file, import the project's Javascript file
    <x-code-block-wrapper title="app.js" language="js">
        import '/vendor/yungifez/april-ui/dist/april.js'
    </x-code-block-wrapper>
    Or you could use the blade directive
    <x-code-block-wrapper title="layout.blade.php" language="js">
        @verbatim
            @aprilScripts
        @endverbatim
    </x-code-block-wrapper>
    </li>
    <li>
    Test the setup was successful
    <x-code-block-wrapper title="index.blade.php" language="blade">
        @verbatim
        <april:button>Hello There Youtube!</april:button>
        @endverbatim
    </x-code-block-wrapper>
    </li>
</ul>

<x-callout>

**Upgrading from an earlier version?** April UI used to need two `repositories` entries in your `composer.json` for a
fork of `tailwind-merge`. You can delete them. The package now uses
[tales-from-a-dev/tailwind-merge-php](https://github.com/tales-from-a-dev/tailwind-merge-php), which comes straight
from Packagist.

</x-callout>

## Configuration

The package works without any config. If you use a custom Tailwind setup, publish the config file:

<x-code-block-wrapper language="bash">
    php artisan vendor:publish --tag=april-ui-config
</x-code-block-wrapper>

The `tailwind_merge` section controls how a component merges its own classes with the classes you pass to it:

<x-code-block-wrapper title="config/april-ui.php" language="php">
'tailwind_merge' => [
    // The prefix of your Tailwind classes, if you use one.
    'prefix' => null,

    // Number of merge results to keep in memory. Set to 0 to disable.
    'cacheSize' => 500,

    // Extra class groups, for a custom Tailwind value that does not merge correctly.
    'classGroups' => [],
],
</x-code-block-wrapper>

## Package views and publishing

April UI uses the package views by default. This keeps upgrades simple and follows Laravel's package conventions.

List the available components and their dependencies:

<x-code-block-wrapper language="bash">
    php artisan april:list
</x-code-block-wrapper>

If you need to change a component, publish it to Laravel's normal vendor override path:

<x-code-block-wrapper language="bash">
    php artisan april:publish button
</x-code-block-wrapper>

The published file is copied to `resources/views/vendor/april/components/button.blade.php`. Laravel loads this copy
before the package view. Publish every component with `php artisan april:publish --all`.

Review published components against the package version with:

<x-code-block-wrapper language="bash">
    php artisan april:update --diff
</x-code-block-wrapper>

Use `--dry-run` to inspect changes without writing files. Use `php artisan april:doctor` to find common Blade issues,
such as a typeless button inside a form.

## Optional JavaScript entry points

The `@aprilScripts` directive is the easiest setup. If you manage your JavaScript bundle yourself, the package exposes
separate entry points:

<x-code-block-wrapper title="resources/js/app.js" language="js">
import { registerApril } from 'april-ui/core'
import { registerLivewireBridge } from 'april-ui/livewire'

document.addEventListener('alpine:init', () => {
    registerApril(window.Alpine)
    registerLivewireBridge(window.Alpine)
})
</x-code-block-wrapper>

The default April UI bundle includes both entry points and keeps the existing `window.April` API.

## MCP server

April UI includes a small local MCP server for component discovery and publishing. Start it over standard input and
output when your MCP client launches it:

<x-code-block-wrapper language="json">
{
  "command": "php",
  "args": ["artisan", "april:mcp"]
}
</x-code-block-wrapper>

The server can list, search, and publish components. Publishing still writes to Laravel's normal
`resources/views/vendor/april/components` path.
