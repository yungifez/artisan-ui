---
view: components.docs-layout
title: Sheet
description:  Extends the Dialog component to display content that complements the main content of the screen.
---

<x-component-preview component="previews.sheet-demo"></x-component-preview>

## Side

Use the side attribute in the `sheet` slot to indicate the edge of the screen where the component will appear. The values can be top, right, bottom or left.

<x-component-preview component="previews.sheet-side-demo"></x-component-preview>

<x-publish-command :views="[
    'sheet',
    'sheet-header',
    'sheet-footer'
]" />
