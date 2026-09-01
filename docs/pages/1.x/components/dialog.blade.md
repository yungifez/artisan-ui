---
view: components.docs-layout
title: Dialog
description: A window overlaid on either the primary window or another dialog window, rendering the content underneath inert.
---

<x-component-preview component="previews.dialog-demo"></x-component-preview>

## Custom close button
<x-component-preview component="previews.dialog-custom-close-demo"></x-component-preview>

## Breaking out of parent context

To avoid Z-Index and other bizarre CSS issues (looking at you `backdrop-filter:blur`), the `dialog` component supports x-teleport provided by Alpine, you however do not need to wrap the dialog in a `template` element.

<x-component-preview component="previews.dialog-teleport-demo"></x-component-preview>

<x-publish-command :views="['dialog', 'dialog-header', 'dialog-footer']"/>
