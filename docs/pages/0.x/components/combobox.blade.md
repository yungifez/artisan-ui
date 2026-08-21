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

The selected value is submitted under the `name` attribute and a `change` event is dispatched with the selected value.

<x-publish-command :views="['combobox', 'combobox-option']" />
