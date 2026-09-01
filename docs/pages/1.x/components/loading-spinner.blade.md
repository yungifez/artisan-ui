---
view: components.docs-layout
title: Loading Spinner
description: Indicates that an operation is in progress.
---

<x-component-preview component="previews.loading-spinner-demo"></x-component-preview>

Use the default size for inline loading states and `size="lg"` for a larger surface. The spinner includes an accessible loading label for screen readers.

<x-code-block-wrapper language="blade">
@verbatim
<april:loading-spinner />
<april:loading-spinner size="lg" />
@endverbatim
</x-code-block-wrapper>

Pass classes such as `text-primary` to set the spinner color.

<x-publish-command view="loading-spinner" />
