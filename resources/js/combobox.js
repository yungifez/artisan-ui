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
    },
    option: {
        ['x-show']() {
            return this.matches(this.$el);
        },
        [':aria-selected']() {
            return this.selectedValue === this.$el.dataset.value;
        },
        [':aria-disabled']() {
            return this.$el.dataset.disabled === 'true';
        },
        [':data-selected']() {
            return this.selectedValue === this.$el.dataset.value;
        },
        [':data-active']() {
            return this.matches(this.$el);
        },
        [':id']() {
            return this.$id('combobox') + '-option-' + this.$el.dataset.value;
        },
        ['@click']() {
            if (this.$el.dataset.disabled !== 'true') {
                this.select(this.$el.dataset.value);
            }
        },
    },
    init() {
        this.$nextTick(() => this.focus(1));
    },
    matches(option) {
        return this.keyword === '' || option.innerText.toLowerCase().includes(this.keyword.toLowerCase());
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
        return this.$root.querySelector(`[data-slot="combobox-option"][data-value="${CSS.escape(this.selectedValue)}"]`)?.innerText.trim() ?? '';
    },
    close() {
        this.open = false;
    },
    toggle() {
        if (!this.disabled) {
            this.open = !this.open;
        }
    },
});
