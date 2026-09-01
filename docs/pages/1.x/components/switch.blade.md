---
view: components.docs-layout
title: Switch
description:  A control that allows the user to toggle between checked and not checked.
---

<x-component-preview component="previews.switch-demo"></x-component-preview>

Use `x-model` for the checked value. The component dispatches `checked-change` with `{ detail: { value } }`; the legacy `checkedChange` event remains available.

<x-publish-command view="switch" />
