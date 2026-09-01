---
view: components.docs-layout
title: Starter kits
description: Start a Laravel application with April UI.
---

April UI provides two starter kits. Both keep Laravel's normal application structure and use April UI for the presentation layer.

## Blade starter kit

Use this kit when you want standard Laravel controllers, HTTP forms, redirects, and server-rendered Blade views:

<x-code-block-wrapper language="bash">
    laravel new my-app --using=yungifez/april-ui-blade-starter-kit
</x-code-block-wrapper>

The Blade kit includes Fortify authentication, Alpine for small browser interactions, a responsive application shell, account settings, and April UI components. It does not install Livewire.

## Livewire starter kit

Use this kit when you want Livewire page components and server-side interactions:

<x-code-block-wrapper language="bash">
    laravel new my-app --using=yungifez/april-ui-starter-kit
</x-code-block-wrapper>

The Livewire kit includes Livewire 4, Fortify authentication, the same application shell, and the same April UI component API.

## Customize components

Both kits keep April UI as a Composer dependency. Publish only the components that your application owns:

<x-code-block-wrapper language="bash">
    php artisan april:list
    php artisan april:publish button
</x-code-block-wrapper>

Published files go to `resources/views/vendor/april/components`. Laravel's normal vendor view lookup rules then override the matching package view. This lets package upgrades remain safe while keeping application-specific markup in the application.

## Local development

After the Laravel installer creates the project, start the application with:

<x-code-block-wrapper language="bash">
    composer dev
</x-code-block-wrapper>

Run the test suite and frontend build before committing changes:

<x-code-block-wrapper language="bash">
    composer test
    npm run build
</x-code-block-wrapper>
