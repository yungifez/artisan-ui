<april:accordion type="single" collapsible class="w-full md:w-[70%]">
    <april:accordion-item>
        <slot:trigger>What is April UI</slot:trigger>
        <slot:content>
            April UI is a set of styled laravel blade components
            that takes inspiration from shadCN.
        </slot:content>
    </april:accordion-item>
    <april:accordion-item>
        <slot:trigger>What Technology is it built with?</slot:trigger>
        <slot:content>
            It is built using Laravel blade, tailwind CSS, and alpine JS.
        </slot:content>
    </april:accordion-item>
    <april:accordion-item>
        <slot:trigger>Did any other library inspire this project?</slot:trigger>
        <slot:content>
            Yes. A lot of code was borrowed from Pines UI, and some
            ideas were gotten from Mary UI.
        </slot:content>
    </april:accordion-item>
</april:accordion>
