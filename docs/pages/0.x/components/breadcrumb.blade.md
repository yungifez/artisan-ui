---
view: components.docs-layout
title: Breadcrumb
description: Displays the path to the current resource using a hierarchy of links.
---

<x-component-preview component="previews.breadcrumb-demo"></x-component-preview>

## Custom Separator

You can use a custom item as `separator` for `breadcrumb-separator`.
<x-component-preview component="previews.breadcrumb-custom-separator-demo"></x-component-preview>

## Dropdown

You can compose `breadcrumb-item` with a `dropdown-menu` to create a dropdown in the breadcrumb.
<x-component-preview component="previews.breadcrumb-dropdown-demo"></x-component-preview>

## Collapsed

We provide a `breadcrumb-elipsis` component to show a collapsed state when the breadcrumb is too long.
<x-component-preview component="previews.breadcrumb-collapsed-demo"></x-component-preview>

<x-publish-command :views="['breadcrumb', 'breadcrumb-item', 'breadcrumb-link', 'breadcrumb-separator', 'breadcrumb-page', 'breadcrumb-elipsis']"/>
