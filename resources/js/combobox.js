export default (value = '', disabled = false) => ({
    keyword: '',
    selectedValue: value,
    disabled,
    open: false,
    focusedOption: null,
    root: {
        [':data-state']() {
            return this.open ? 'open' : 'closed';
        },
        [':data-disabled']() {
            return this.disabled || null;
        },
        [':aria-disabled']() {
            return this.disabled;
        },
        ['x-id']() {
            return ['combobox'];
        },
        ['@click.outside']() {
            this.close();
        },
        ['@keydown.escape']() {
            this.close();
        },
    },
    trigger: {
        [':data-state']() {
            return this.open ? 'open' : 'closed';
        },
        [':aria-expanded']() {
            return this.open;
        },
        [':aria-controls']() {
            return this.$id('combobox') + '-list';
        },
        [':aria-haspopup']() {
            return 'listbox';
        },
        [':disabled']() {
            return this.disabled;
        },
        ['@click']() {
            this.toggle();
        },
        [':id']() {
            return this.$id('combobox') + '-trigger';
        },
        ['@keydown.enter.prevent']() {
            this.openMenu();
        },
        ['@keydown.space.prevent']() {
            this.openMenu();
        },
        ['@keydown.down.prevent']() {
            this.openMenu();
        },
    },
    input: {
        [':id']() {
            return this.$id('combobox') + '-input';
        },
        [':aria-controls']() {
            return this.$id('combobox') + '-list';
        },
        [':aria-activedescendant']() {
            return this.focusedOption?.id ?? null;
        },
        [':aria-expanded']() {
            return this.open;
        },
        ['x-model']() {
            return 'keyword';
        },
        ['@input']() {
            this.focusedOption = null;
        },
        ['@keydown.down.prevent']() {
            this.focus(1);
        },
        ['@keydown.up.prevent']() {
            this.focus(-1);
        },
        ['@keydown.enter.prevent']() {
            this.focusedOption?.click();
        },
        ['@keydown.escape.stop.prevent']() {
            this.close();
            this.$nextTick(() => this.$refs.trigger?.focus());
        },
    },
    content: {
        [':data-state']() {
            return this.open ? 'open' : 'closed';
        },
        [':id']() {
            return this.$id('combobox') + '-content';
        },
        ['x-show']() {
            return this.open;
        },
        ['x-trap.noscroll']() {
            return this.open;
        },
        ['x-transition']() {
            return true;
        },
    },
    list: {
        [':id']() {
            return this.$id('combobox') + '-list';
        },
        [':aria-labelledby']() {
            return this.$id('combobox') + '-trigger';
        },
    },
    option: {
        ['x-show']() {
            return this.matches(this.$el);
        },
        [':aria-selected']() {
            return this.isSelectedValue(this.$el.dataset.value);
        },
        [':aria-disabled']() {
            return this.$el.dataset.disabled === 'true';
        },
        [':data-selected']() {
            return this.isSelectedValue(this.$el.dataset.value);
        },
        [':data-active']() {
            return this.focusedOption === this.$el;
        },
        [':id']() {
            return this.$id('combobox') + '-option-' + encodeURIComponent(this.$el.dataset.value);
        },
        ['@click']() {
            if (this.$el.dataset.disabled !== 'true') {
                this.select(this.$el.dataset.value);
            }
        },
    },
    init() {
        this.$watch('selectedValue', () => this.$nextTick(() => this.focusedOption = null));
    },
    matches(option) {
        const label = option.innerText ?? option.textContent ?? '';

        return this.keyword === '' || label.toLowerCase().includes(this.keyword.toLowerCase());
    },
    isSelectedValue(value) {
        return String(this.selectedValue ?? '') === String(value ?? '');
    },
    noMatches() {
        return [...this.$root.querySelectorAll('[data-slot="combobox-option"]')]
            .every((option) => !this.matches(option));
    },
    focus(direction) {
        const options = [...this.$root.querySelectorAll('[data-slot="combobox-option"]')]
            .filter((option) => option.dataset.disabled !== 'true' && this.matches(option));

        if (options.length === 0) {
            this.focusedOption = null;
            return;
        }

        const current = options.indexOf(this.focusedOption);
        const index = current < 0 ? (direction > 0 ? 0 : options.length - 1) : (current + direction + options.length) % options.length;
        this.focusedOption = options[index];
        this.focusedOption.scrollIntoView({ block: 'nearest' });
    },
    select(value) {
        this.selectedValue = value;
        this.$dispatch('change', { value });
        this.close();
    },
    selectedLabel() {
        return [...this.$root.querySelectorAll('[data-slot="combobox-option"]')]
            .map((option) => ({
                option,
                label: (option.innerText ?? option.textContent ?? '').trim(),
            }))
            .find(({ option }) => this.isSelectedValue(option.dataset.value))?.label ?? '';
    },
    openMenu() {
        if (this.disabled) {
            return;
        }

        this.open = true;
        this.$nextTick(() => {
            this.$refs.input?.focus();
            this.focus(1);
        });
    },
    close() {
        this.open = false;
        this.keyword = '';
        this.focusedOption = null;
    },
    toggle() {
        if (!this.disabled) {
            this.open ? this.close() : this.openMenu();
        }
    },
});
