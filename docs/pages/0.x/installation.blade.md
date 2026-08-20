---
view: components.docs-layout
title: Installation
description: How to install the project.
---

## Requirements

To install this project, you need:

- A Laravel app with version 11 and above
- PHP 8.2 and above
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
