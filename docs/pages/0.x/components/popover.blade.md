---
view: components.docs-layout
title: Popover
description: Displays rich content in a portal, triggered by a button. 
---

<x-component-preview component="previews.popover-demo"></x-component-preview>

Use the generic `trigger` and `content` slots. The older `popover-trigger` and `popover-content` names remain supported.

## Breaking out of parent context

To avoid Z-Index and other bizarre CSS issues, the `popover` component supports x-teleport provided by Alpine, you however do not need to wrap the dialog in a `template` element.

<x-component-preview component="previews.popover-teleport-demo"></x-component-preview>

<x-publish-command view="popover" />
