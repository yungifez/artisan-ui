<april:dialog dismissable x-teleport="body">
    <slot:trigger>
        <april:button variant="outline">
            Edit Profile
        </april:button>
    </slot:trigger>
    <slot:content class="sm:max-w-[425px]">
        <april:dialog-header>
            <slot:title>
                Edit profile
            </slot:title>
            <slot:description>
                Make changes to your profile here. Click save when you're done.
            </slot:description>
        </april:dialog-header>
        <div class="grid gap-4 py-4">
            <div class="grid grid-cols-4 items-center gap-4">
                <april:label for="name-3" class="text-right">Name</april:label>
                <april:input id="name-3" value="Pedro Duarte" class="col-span-3" />
            </div>
            <div class="grid grid-cols-4 items-center gap-4">
                <april:label class="text-right" for="username-3" class="text-right">Username</april:label>
                <april:input class="col-span-3" id="username-3" value="@peduarte" />
            </div>
        </div>
        <april:dialog-footer>
            <april:button class="justify-center">Save changes</april:button>
        </april:dialog-footer>
    </slot:content>
</april:dialog>
