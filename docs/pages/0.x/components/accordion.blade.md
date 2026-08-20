---
view: components.docs-layout
title: Accordion
description: A vertically stacked set of interactive headings that each reveal a section of content.
---
<x-component-preview component="previews.accordion-demo"></x-component-preview>

When `type` attribute is set to `single`, the collapsible attribute allows the currently opened accordion item to be closed

When the `type` attribute is set to multiple, multiple items can be opened at once. 

<x-component-preview component="previews.accordion-multiple-demo"></x-component-preview>

You can listen for the `valueChanged` event containing with the current active value in `$event.detail.value`, which is an array when type is multiple and a string when type is single. The value of an accordion item is `accordion-item-{index}`

<x-publish-command :views="['accordion', 'accordion-item']"/>
