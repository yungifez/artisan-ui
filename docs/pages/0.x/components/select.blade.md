---
view: components.docs-layout
title: Select
description: Displays a list of options for the user to pick from—triggered by a button. 
---

<x-component-preview component="previews.select-demo"></x-component-preview>

## Multiple Select

The component also supports multiple select

<x-component-preview component="previews.select-multiple-demo"></x-component-preview>

## Options

You can write plain `option` tags, as above. You can also use the `select-option` component, which gives you
`value`, `selected` and `disabled` as attributes.

<x-component-preview component="previews.select-option-demo"></x-component-preview>

## Native Select
You can optionally use the native brwoser select

<x-component-preview component="previews.native-select-demo"></x-component-preview>

<x-publish-command :views="[ 'select', 'select-option', 'native-select' ]" />
