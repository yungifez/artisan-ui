---
view: components.docs-layout
title: Attachment
description: Displays a file or image attachment with media, metadata, state, and actions.
---

<x-component-preview component="previews.attachment-demo"></x-component-preview>

Use named slots for the attachment media, content, and actions. Use `attachment-action` for each repeatable action and `attachment-group` when displaying multiple attachments.

<x-code-block-wrapper language="blade">
@verbatim
<april:attachment state="done">
    <slot:media><x-lucide-file-text /></slot:media>
    <slot:content>
        <p class="font-medium">report.pdf</p>
        <p class="text-sm text-muted-foreground">PDF · 2.4 MB</p>
    </slot:content>
    <slot:actions>
        <april:attachment-action aria-label="Remove report">
            <x-lucide-x />
        </april:attachment-action>
    </slot:actions>
</april:attachment>
@endverbatim
</x-code-block-wrapper>

Supported states are `done`, `uploading`, `processing`, and `error`. Set `orientation="vertical"` to stack the media above the metadata.

<x-publish-command :views="['attachment', 'attachment-action', 'attachment-group']" />
