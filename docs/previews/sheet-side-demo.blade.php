<div class="grid grid-cols-2 gap-2">
    <april:sheet dismissable>
        <slot:trigger>
            <april:button class="w-full justify-center" variant="outline">
                Top
            </april:button>
        </slot:trigger>
        <slot:content side="top">
            <april:sheet-header>
                <slot:title>
                    Edit profile
                </slot:title>
                <slot:description>
                    Make changes to your profile here. Click save when you're done.
                </slot:description>
            </april:sheet-header>
            <div class="grid gap-4 py-4">
                <div class="grid grid-cols-4 items-center gap-4">
                    <april:label for="name-1-top" class="text-right">Name</april:label>
                    <april:input id="name-1-top" value="Pedro Duarte" class="col-span-3" />
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <april:label class="text-right" for="username-1-top" class="text-right">Username</april:label>
                    <april:input class="col-span-3" id="username-1-top" value="@peduarte" />
                </div>
            </div>
            <april:sheet-footer>
                <april:button class="justify-center">Save changes</april:button>
            </april:sheet-footer>
        </slot:content>
    </april:sheet>
    <april:sheet dismissable>
        <slot:trigger>
            <april:button class="w-full justify-center" variant="outline">
                Right
            </april:button>
        </slot:trigger>
        <slot:content side="right">
            <april:sheet-header>
                <slot:title>
                    Edit profile
                </slot:title>
                <slot:description>
                    Make changes to your profile here. Click save when you're done.
                </slot:description>
            </april:sheet-header>
            <div class="grid gap-4 py-4">
                <div class="grid grid-cols-4 items-center gap-4">
                    <april:label for="name-1-right" class="text-right">Name</april:label>
                    <april:input id="name-1-right" value="Pedro Duarte" class="col-span-3" />
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <april:label class="text-right" for="username-1-right" class="text-right">Username</april:label>
                    <april:input class="col-span-3" id="username-1-right" value="@peduarte" />
                </div>
            </div>
            <april:sheet-footer>
                <april:button class="justify-center">Save changes</april:button>
            </april:sheet-footer>
        </slot:content>
    </april:sheet>
    <april:sheet dismissable>
        <slot:trigger>
            <april:button class="w-full justify-center" variant="outline">
                Bottom
            </april:button>
        </slot:trigger>
        <slot:content side="bottom">
            <april:sheet-header>
                <slot:title>
                    Edit profile
                </slot:title>
                <slot:description>
                    Make changes to your profile here. Click save when you're done.
                </slot:description>
            </april:sheet-header>
            <div class="grid gap-4 py-4">
                <div class="grid grid-cols-4 items-center gap-4">
                    <april:label for="name-1-bottom" class="text-right">Name</april:label>
                    <april:input id="name-1-bottom" value="Pedro Duarte" class="col-span-3" />
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <april:label class="text-right" for="username-1-bottom" class="text-right">Username</april:label>
                    <april:input class="col-span-3" id="username-1-bottom" value="@peduarte" />
                </div>
            </div>
            <april:sheet-footer>
                <april:button class="justify-center">Save changes</april:button>
            </april:sheet-footer>
        </slot:content>
    </april:sheet>
    <april:sheet dismissable>
        <slot:trigger>
            <april:button class="w-full justify-center" variant="outline">
                Left
            </april:button>
        </slot:trigger>
        <slot:content side="left">
            <april:sheet-header>
                <slot:title>
                    Edit profile
                </slot:title>
                <slot:description>
                    Make changes to your profile here. Click save when you're done.
                </slot:description>
            </april:sheet-header>
            <div class="grid gap-4 py-4">
                <div class="grid grid-cols-4 items-center gap-4">
                    <april:label for="name-1-left" class="text-right">Name</april:label>
                    <april:input id="name-1-left" value="Pedro Duarte" class="col-span-3" />
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <april:label class="text-right" for="username-1-left" class="text-right">Username</april:label>
                    <april:input class="col-span-3" id="username-1-left" value="@peduarte" />
                </div>
            </div>
            <april:sheet-footer>
                <april:button class="justify-center">Save changes</april:button>
            </april:sheet-footer>
        </slot:content>
    </april:sheet>
</div>
