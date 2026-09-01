export default (value = '', disabled = false) => ({
    keyword: '',
    value,
    get selectedValue() {
        return this.value;
    },
    set selectedValue(value) {
        this.value = value;
    },
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
            if (! this.$refs.trigger?.contains(this.$event.target) && ! this.$refs.content?.contains(this.$event.target)) {
                this.close();
            }
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
        ['x-model']: 'keyword',
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
            if (this.focusedOption) {
                this.select(this.focusedOption.dataset.value);
            }
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
        [':style']() {
            const width = this.$refs.trigger?.getBoundingClientRect().width;

            return width ? { '--combobox-trigger-width': `${width}px` } : {};
        },
        ['x-anchor.bottom-start.offset.2']() {
            return this.$refs.trigger;
        },
        [':id']() {
            return this.$id('combobox') + '-content';
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
        this.$watch('value', () => this.$nextTick(() => this.focusedOption = null));
    },
    matches(option) {
        const label = option.textContent ?? option.innerText ?? '';

        return this.keyword === '' || label.toLowerCase().includes(this.keyword.toLowerCase());
    },
    isSelectedValue(value) {
        return String(this.value ?? '') === String(value ?? '');
    },
    noMatches() {
        return this.optionElements()
            .every((option) => !this.matches(option));
    },
    optionElements() {
        return [...(this.$refs.content ?? this.$root).querySelectorAll('[data-slot="combobox-option"]')];
    },
    focus(direction) {
        const options = this.optionElements()
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
        this.value = value;
        const detail = { value };

        this.$dispatch('value-change', detail);
        // Keep the native-style event available for existing listeners.
        this.$dispatch('change', detail);
        this.close();
    },
    selectedLabel() {
        return this.optionElements()
            .map((option) => ({
                option,
                label: (option.textContent ?? option.innerText ?? '').trim(),
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
