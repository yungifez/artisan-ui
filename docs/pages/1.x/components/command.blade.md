---
view: components.docs-layout
title: Command
description: Fast, composable, styled command menu.
---
<x-component-preview component="previews.command-demo"></x-component-preview>

The command input is modelable as `value` and dispatches `value-change` with `{ detail: { value } }`. The legacy `valueChange` event remains available.

<x-callout>
    This command component was inspired by the [CMDK react component](https://cmdk.paco.me/)
</x-callout>

## Dialog
<x-component-preview component="previews.command-dialog-demo"></x-component-preview>


<x-publish-command :views="['command', 'command-group', 'command-item', 'command-separator', 'command-shortcut', 'command-dialog']"/>
