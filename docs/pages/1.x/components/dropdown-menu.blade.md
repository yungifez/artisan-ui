---
view: components.docs-layout
title: Dropdown Menu
description: Displays a menu to the user — such as a set of actions or functions — triggered by a button.
---

<x-component-preview component="previews.dropdown-menu-demo"></x-component-preview>

## Breaking out of parent context

To avoid Z-Index and other bizarre CSS issues, the component supports x-teleport provided by Alpine, you however do not need to wrap the dialog in a `template` element.

<x-component-preview component="previews.dropdown-menu-teleport-demo"></x-component-preview>

<x-publish-command :views="[ 'dropdown-menu', 'dropdown-menu-group', 'dropdown-menu-item', 'dropdown-menu-label', 'dropdown-menu-separator', 'dropdown-menu-shortcut', 'dropdown-menu-sub' ]" />
