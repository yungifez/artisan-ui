<april:card class="md:w-[350px]">
    <slot:title class="mt-0">Create project</slot:title>
    <slot:description>Deploy your new project in one-click.</slot:description>
    <slot:content>
        <form>
            <div class="grid w-full items-center gap-4">
                <div class="flex flex-col space-y-1.5">
                    <april:label for="name">Name</april:label>
                    <april:input id="name" label="Name" placeholder="Name of your project" />
                </div>
                <div class="flex flex-col space-y-1.5">
                    <april:label for="library">Library</april:label>
                    <april:select id="library" label="Library">
                        <option>April UI</option>
                        <option>Filament PHP</option>
                        <option>Mary UI</option>
                        <option>Pines UI</option>
                    </april:select>
                </div>
            </div>
        </form>
    </slot:content>
    <slot:footer class="flex justify-between">
        <april:button variant="outline">Cancel</april:button>
        <april:button>Deploy</april:button>
    </slot:footer>
</april:card>
