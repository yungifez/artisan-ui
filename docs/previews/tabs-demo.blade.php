<april:tabs defaultValue="account" class="w-[400px]">
    <slot:tabs-list class="w-full">
        <april:tabs-trigger value="account" class="w-full">Account</april:tabs-trigger>
        <april:tabs-trigger value="password" class="w-full">Password</april:tabs-trigger>
    </slot:tabs-list>
    <april:tabs-content value="account">
        <april:card>
            <slot:title>Account</slot:title>
            <slot:description>
                Make changes to your account here. Click save when you're done.
            </slot:description>
            <slot:content class="space-y-2">
                <div class="space-y-1">
                    <april:label for="name">Name</april:label>
                    <april:input id="name" value="Pedro Duarte" class="w-full" />
                </div>
                <div class="space-y-1">
                    <april:label htmlFor="username">Username</april:label>
                    <april:input id="username" value="@peduarte" class="w-full" />
                </div>
            </slot:content>
            <slot:footer>
                <april:button>Save changes</april:button>
            </slot:footer>
        </april:card>
    </april:tabs-content>
    <april:tabs-content value="password">
        <april:card>
            <slot:title>Password</slot:title>
            <slot:description>
                Change your password here. After saving, you'll be logged out.
            </slot:description>
            <slot:content class="space-y-2">
                <div class="space-y-1">
                    <april:label htmlFor="current">Current password</april:label>
                    <april:input id="current" type="password" class="w-full" />
                </div>
                <div class="space-y-1">
                    <april:label htmlFor="new">New password</april:label>
                    <april:input id="new" type="password" class="w-full" />
                </div>
            </slot:content>
            <slot:footer>
                <april:button>Save password</april:button>
            </slot:footer>
        </april:card>
    </april:tabs-content>
</april:tabs>
