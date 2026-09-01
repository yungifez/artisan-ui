export default (disabled, value = false) => ({
    value: Boolean(value),
    get switchOn() {
        return this.value;
    },
    set switchOn(value) {
        this.value = value;
    },
    disabled: disabled,
    root: {
        [':data-state']() {
            return this.switchOn ? 'checked' : 'unchecked';
        },
        [':data-disabled']() {
            return this.disabled || null;
        },
        [':aria-checked']() {
            return this.switchOn;
        },
        [':aria-labelledby']() {
            if (this.$refs.input?.labels[0]?.id ?? false) {
                return this.$refs.input.labels[0].id;
            }
        },
        [':aria-label']() {
            if (this.$refs.input?.labels?.[0]?.innerText ?? false) {
                return this.$refs.input.labels[0].innerText;
            }
        },
    },
    input: {
        ['x-model.boolean']: 'switchOn',
        ['x-ref']() {
            return "input";
        },
        [':disabled']() {
            return this.disabled;
        },
    },
    trigger: {
        [':data-state']() {
            return this.switchOn ? 'checked' : 'unchecked';
        },
        [':data-disabled']() {
            return this.disabled || null;
        },
        [':aria-disabled']() {
            return this.disabled;
        },
        [':disabled']() {
            return this.disabled;
        },
        ['@click']() {
            return this.toggle()
        },
        ['x-cloak']() {
            return true;
        },
    },
    setSwitchState(value) {
        if (this.disabled) {
            return;
        }

        this.switchOn = value;
        this.$refs.input.checked = value;
        const detail = { value };

        this.$dispatch('checked-change', detail);
        // Keep the original event name available for existing listeners.
        this.$dispatch('checkedChange', detail);
    },
    toggle() {
        this.setSwitchState(!this.switchOn);
    }
})
