---
view: components.docs-layout
title: Collapsible
description: An interactive component which expands and collapses a panel.
---

<x-component-preview component="previews.collapsible-demo"></x-component-preview>

## Usage

Use `slot:trigger` for the control and `slot:content` for the panel. The panel stays hidden until the trigger is activated.

<x-code-block-wrapper language="blade">
@verbatim
<april:collapsible>
    <slot:trigger>
        <april:button variant="outline">Can I use this in my project?</april:button>
    </slot:trigger>
    <slot:content>
        Yes. April UI is free to use for personal and commercial projects.
    </slot:content>
</april:collapsible>
@endverbatim
</x-code-block-wrapper>

## Composition

The component has two named slots:

```text
april:collapsible
├── slot:trigger
└── slot:content
```

Keep the trigger and content in the same `april:collapsible` component. The component connects them with `id`, `aria-controls`, and `aria-labelledby` attributes.

## Controlled state

Use `open` to start expanded. Use `x-model` or `wire:model` when another state owns the value.

<x-code-block-wrapper language="blade">
@verbatim
<div x-data="{ detailsOpen: false }">
    <april:collapsible x-model="detailsOpen">
        <slot:trigger>
            <april:button variant="outline">Toggle details</april:button>
        </slot:trigger>
        <slot:content>These details follow the Alpine state.</slot:content>
    </april:collapsible>
</div>

<april:collapsible wire:model="detailsOpen">
    <slot:trigger><april:button>Toggle details</april:button></slot:trigger>
    <slot:content>These details follow the Livewire property.</slot:content>
</april:collapsible>
@endverbatim
</x-code-block-wrapper>

The component exposes its state through `x-modelable="open"`, so Alpine and Livewire can update the same value.

## Disabled

Set `disabled` to prevent the trigger from changing the panel state.

<x-code-block-wrapper language="blade">
@verbatim
<april:collapsible disabled>
    <slot:trigger>
        <april:button variant="outline">Unavailable details</april:button>
    </slot:trigger>
    <slot:content>This panel cannot be opened.</slot:content>
</april:collapsible>
@endverbatim
</x-code-block-wrapper>

## Nested panels

Place another `april:collapsible` in the content slot to create a nested panel.

<x-code-block-wrapper language="blade">
@verbatim
<april:collapsible>
    <slot:trigger><april:button variant="ghost">Project details</april:button></slot:trigger>
    <slot:content>
        <p>Project description.</p>

        <april:collapsible>
            <slot:trigger><april:button variant="ghost">Advanced details</april:button></slot:trigger>
            <slot:content>Advanced project settings.</slot:content>
        </april:collapsible>
    </slot:content>
</april:collapsible>
@endverbatim
</x-code-block-wrapper>

## API reference

### Props

| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `open` | `boolean` | `false` | Starts the panel in the open state. |
| `disabled` | `boolean` | `false` | Prevents the trigger from changing the state. |

### Slots

| Slot | Description |
| --- | --- |
| `trigger` | The button or control that toggles the panel. |
| `content` | The panel content. |

The root, trigger, and content expose `data-state="open"` or `data-state="closed"` for styling. The root exposes `data-disabled` when the component is disabled.

Press Enter or Space on the trigger to toggle the panel.

<x-publish-command view="collapsible" />
