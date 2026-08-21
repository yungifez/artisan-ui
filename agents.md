# Agent guidance

## Blade component content

- Use the default `{{$slot}}` when the content is the main part of a component and the component accepts one item. For example, a button's label belongs in `<april:button>Inside</april:button>`.
- Use a named slot for one auxiliary item that is not the component's main content, such as a dialog's `title` or a card's `footer`.
- When a region can contain multiple related items, create a dedicated child component for that collection and compose those children through the parent's default slot. Do not encode a list as a named slot.

## Sidebar

- `sidebar-trigger` uses its default slot for a custom trigger icon because the icon is the trigger's primary content. It falls back to the standard icon when the default slot is empty.
- `sidebar` accepts named `header`, `content`, and `footer` slots for its layout regions. Keep the sidebar rail and other single structural parts in the default slot.
- Sidebar menu collections use child components through the `content` slot. Use `sidebar-menu`, `sidebar-menu-item`, and the other sidebar parts for repeated content.
