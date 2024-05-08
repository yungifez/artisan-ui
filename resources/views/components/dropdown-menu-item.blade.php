<div>
    <button {{$attributes->class(["relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm
        outline-none transition-colors focus:bg-accent focus:text-accent-foreground w-full"])}} role="menu-item"
        x-bind="menuItem">
        {{$slot}}
    </button>
</div>
