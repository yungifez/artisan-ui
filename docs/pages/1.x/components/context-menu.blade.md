---
view: components.docs-layout
title: Context Menu
description: Displays a menu of actions at the user's pointer position.
---

<x-component-preview component="previews.context-menu-demo"></x-component-preview>

Put the context-menu target in the named `trigger` slot. Put the repeatable menu items in the named `content` slot. The default slot remains supported for existing code.

<x-code-block-wrapper language="blade">
@verbatim
<april:context-menu>
    <slot:trigger><div class="p-8">Right-click here</div></slot:trigger>
    <slot:content>
        <april:context-menu-item>Copy</april:context-menu-item>
        <april:context-menu-item>Paste</april:context-menu-item>
    </slot:content>
</april:context-menu>
@endverbatim
</x-code-block-wrapper>

Use `context-menu-label` and `context-menu-separator` to organize larger menus. The menu closes after an item is selected, when Escape is pressed, or when the user clicks elsewhere.

<x-publish-command :views="['context-menu', 'context-menu-item', 'context-menu-label', 'context-menu-separator']" />
