---
view: components.docs-layout
title: Steps
description: Shows progress through a sequence of tasks with completed, active, and inactive states.
---

<x-component-preview component="previews.steps-demo"></x-component-preview>

## Usage

Pass an array of steps and the active step to the component. Numeric values are used by default to derive the state:
steps before the active step are completed, the active step is highlighted, and later steps are inactive.

```blade
@php
    $steps = [
        ['value' => 1, 'label' => 'Account'],
        ['value' => 2, 'label' => 'Profile'],
        ['value' => 3, 'label' => 'Review'],
    ];
@endphp

<april:steps :items="$steps" current="2" />
```

## Step data

Each step accepts a `value`, `label`, optional `description`, and optional `href`. A completed step with an `href` is rendered as a link.
Use `state` when the state does not follow the numeric order. Supported values are `completed`, `active`, and `inactive`.

## Vertical steps

Set `orientation` to `vertical` for a stacked layout. This works well when each step has a description or when the available width is limited.

<x-component-preview component="previews.steps-vertical-demo"></x-component-preview>

```blade
<april:steps orientation="vertical" :items="$steps" current="2" />
```

<x-publish-command :views="['steps']" />
