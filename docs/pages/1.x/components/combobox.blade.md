---
view: components.docs-layout
title: Combobox
description: An input with a searchable list of selectable options.
---

<x-component-preview component="previews.combobox-demo"></x-component-preview>

Each option is a child component because a combobox can contain multiple options. The default slot holds those options, while `empty` provides the empty-state message.

<x-code-block-wrapper language="blade">
@verbatim
<april:combobox name="framework" placeholder="Select a framework">
    <slot:empty>No framework found.</slot:empty>
    <april:combobox-option value="laravel">Laravel</april:combobox-option>
    <april:combobox-option value="livewire">Livewire</april:combobox-option>
</april:combobox>
@endverbatim
</x-code-block-wrapper>

The selected value is submitted under the `name` attribute. The component dispatches `value-change` with `{ detail: { value } }`; the existing `change` event remains available.

The panel stays in the component flow by default. Use `x-teleport="body"` when the panel must escape an overflow or
stacking context, just like the other April overlay components.

Use `value` for the initial selection or `wire:model` for a Livewire-bound value. Values are compared as strings so numeric model IDs work with option values rendered in HTML. The trigger supports Enter, Space, and Arrow Down; the search field supports Arrow Up, Arrow Down, Enter, and Escape.

## Accessibility

The search field carries `role="combobox"`. It reports its state through
`aria-expanded`, names its list through `aria-controls`, and names the option
under the keyboard through `aria-activedescendant`. The trigger reports the
same state and carries `aria-haspopup="listbox"`. The list carries
`role="listbox"` and points back at the trigger with `aria-labelledby`.

<x-publish-command :views="['combobox', 'combobox-option']" />
