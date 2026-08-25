---
view: components.docs-layout
title: Collapsible
description: An interactive panel that can be expanded or collapsed.
---

<x-component-preview component="previews.collapsible-demo"></x-component-preview>

The trigger and content are named slots because each is a single structural region. The content is hidden until the trigger is activated.

<x-code-block-wrapper language="blade">
@verbatim
<april:collapsible>
    <slot:trigger><april:button>Show details</april:button></slot:trigger>
    <slot:content>Additional details go here.</slot:content>
</april:collapsible>
@endverbatim
</x-code-block-wrapper>

Set `open` to start expanded or `disabled` to prevent changes.

The component exposes `open` as Alpine state, so it also works with `wire:model` when the open state belongs to a Livewire property. Press Enter or Space on the trigger to toggle the panel.

<x-publish-command view="collapsible" />
