---
view: components.docs-layout
title: Input Group
description: Groups a native input, label, and validation message.
---

<x-component-preview component="previews.input-group-demo"></x-component-preview>

Use `input-group` when a form control needs a label and Laravel validation errors in one unit. The group reads the field name from `name` and uses the matching error key by default.

<x-code-block-wrapper language="blade">
@verbatim
<april:input-group
    name="email"
    id="email"
    type="email"
    label="Email address"
    placeholder="you@example.com"
    required
/>
@endverbatim
</x-code-block-wrapper>

Pass `error-name` or `error-bag` when the validation key differs. Use `inline` for compact controls such as checkboxes, radios, and range inputs. Add `prevent-errors` when the group should not render validation output.

<x-publish-command view="input-group" />
