# April UI
This is still a work in progress

## Introudction

April UI is a component library that aims to bring the elegance of ShadCN to laravel. It is built using tailwind, alpine JS, and laravel blade.

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
