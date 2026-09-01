<april:combobox name="framework" placeholder="Select a framework" class="max-w-sm" x-teleport="body">
    <slot:empty>No framework found.</slot:empty>
    <april:combobox-option value="laravel">Laravel</april:combobox-option>
    <april:combobox-option value="livewire">Livewire</april:combobox-option>
    <april:combobox-option value="alpine">Alpine.js</april:combobox-option>
    <april:combobox-option value="tailwind">Tailwind CSS</april:combobox-option>
</april:combobox>
