---
view: components.docs-layout
title: Sidebar
description: A composable, collapsible sidebar for application layouts.
---

<x-component-preview component="previews.sidebar-demo"></x-component-preview>

The sidebar is not one component. It is a set of parts you put together, so you can build the layout your app needs
instead of the one I guessed you needed.

## Anatomy

Wrap everything in `sidebar-layout`. It holds the open state, so the sidebar, the trigger and the page content all
agree on whether the sidebar is open.

<x-code-block-wrapper title="layout.blade.php" language="blade">
@verbatim
<april:sidebar-layout>
    <april:sidebar>
        <slot:header>...</slot:header>
        <slot:content>
            <april:sidebar-group>
                <april:sidebar-group-label>Platform</april:sidebar-group-label>
                <april:sidebar-group-content>
                    <april:sidebar-menu>
                        <april:sidebar-menu-item>
                            <april:sidebar-menu-button-link href="/inbox">Inbox</april:sidebar-menu-button-link>
                        </april:sidebar-menu-item>
                    </april:sidebar-menu>
                </april:sidebar-group-content>
            </april:sidebar-group>
        </slot:content>
        <slot:footer>...</slot:footer>
        <april:sidebar-rail />
    </april:sidebar>

    <april:sidebar-inset>
        <april:sidebar-trigger />
        {{ $slot }}
    </april:sidebar-inset>
</april:sidebar-layout>
@endverbatim
</x-code-block-wrapper>

<x-callout>
Put `sidebar-inset` next to the sidebar, not inside it. It holds your page content and shifts as the sidebar opens
and closes.
</x-callout>

---

## Menus

A menu is a list. Use `sidebar-menu-button-link` for a link and `sidebar-menu-button` for a button. Mark the current
page with `:active="true"`.

Add a badge for a count, an action for a row menu, and a submenu for children. The skeleton is there for while your
data loads.

<x-component-preview component="previews.sidebar-menu-demo"></x-component-preview>

<x-callout>
`sidebar-menu-action` is hidden until you hover the row when you pass `:show-on-hover="true"`.
</x-callout>

---

## Collapsible

The `collapsible` attribute decides what happens when the sidebar closes. It takes three values.

### Offcanvas

The default. The sidebar slides off the screen.

<x-component-preview component="previews.sidebar-collapsible-icon-demo"></x-component-preview>

---

### Icon

The sidebar shrinks to icon width and keeps the icons visible. Labels, badges, actions and submenus hide themselves.

<x-code-block-wrapper language="blade">
@verbatim
<april:sidebar collapsible="icon">...</april:sidebar>
@endverbatim
</x-code-block-wrapper>

---

### None

The sidebar never collapses. Use it when you want a plain, always open panel.

<x-code-block-wrapper language="blade">
@verbatim
<april:sidebar collapsible="none">...</april:sidebar>
@endverbatim
</x-code-block-wrapper>

---

## Side

Use the `side` attribute to put the sidebar on the right. The border, the rail and the mobile panel all follow.

<x-component-preview component="previews.sidebar-side-demo"></x-component-preview>

---

## Variants

The `variant` attribute takes `sidebar`, `floating` or `inset`. `floating` rounds the panel and gives it a border.
`inset` pulls the page content in and rounds it instead.

<x-component-preview component="previews.sidebar-variant-demo"></x-component-preview>

---

## Search

`sidebar-input` is the input component with the sidebar sizing already applied.

<x-component-preview component="previews.sidebar-search-demo"></x-component-preview>

---

## Opening and closing

Three things toggle the sidebar:

- `sidebar-trigger`, a button you can put anywhere inside the layout
- `sidebar-rail`, the thin strip along the sidebar edge
- <kbd>Ctrl</kbd> + <kbd>B</kbd>, or <kbd>Cmd</kbd> + <kbd>B</kbd> on a Mac

On a screen narrower than `768px` the sidebar becomes a panel that slides in over the page. The same three things
still open it.

Start the sidebar closed with `:default-open="false"`.

<x-code-block-wrapper language="blade">
@verbatim
<april:sidebar-layout :default-open="false">...</april:sidebar-layout>
@endverbatim
</x-code-block-wrapper>

---

## Persisting state

To keep the sidebar open or collapsed across page loads, pass `x-persist` with a unique key. The component applies the
`x-persist` directive to both the desktop and mobile sidebars for you.

<x-code-block-wrapper language="blade">
@verbatim
<april:sidebar x-persist="app-sidebar">...</april:sidebar>
@endverbatim
</x-code-block-wrapper>

---

## Width

The sidebar reads three CSS variables. Set them on `sidebar-layout` to change the width for one sidebar:

<x-code-block-wrapper language="blade">
@verbatim
<april:sidebar-layout width="20rem" width-icon="4rem">...</april:sidebar-layout>
@endverbatim
</x-code-block-wrapper>

Or set them in your CSS to change every sidebar:

<x-code-block-wrapper title="app.css" language="css">
:root {
    --sidebar-width: 16rem;
    --sidebar-width-icon: 3rem;
    --sidebar-width-mobile: 18rem;
}
</x-code-block-wrapper>

---

## Styling from your own CSS

Every part carries a `data-slot` attribute, and the sidebar carries its state. You can style any part without
touching the markup:

<x-code-block-wrapper title="app.css" language="css">
/* The menu button of the current page */
[data-slot="sidebar-menu-button"][data-active="true"] {
    font-weight: 600;
}

/* Only while the sidebar is collapsed */
[data-slot="sidebar"][data-state="collapsed"] [data-slot="sidebar-header"] {
    justify-content: center;
}
</x-code-block-wrapper>

See [Data attributes](/docs/1.x/data-attributes) for the full list.

<x-publish-command :views="[
    'sidebar-layout',
    'sidebar',
    'sidebar-trigger',
    'sidebar-rail',
    'sidebar-inset',
    'sidebar-input',
    'sidebar-separator',
    'sidebar-group',
    'sidebar-group-label',
    'sidebar-group-action',
    'sidebar-group-content',
    'sidebar-menu',
    'sidebar-menu-item',
    'sidebar-menu-button',
    'sidebar-menu-button-link',
    'sidebar-menu-action',
    'sidebar-menu-badge',
    'sidebar-menu-skeleton',
    'sidebar-menu-sub',
    'sidebar-menu-sub-item',
    'sidebar-menu-sub-button',
]" />
