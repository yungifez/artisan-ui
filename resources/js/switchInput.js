export default (checked, disabled, checkedLabelText, uncheckedLabelText) => ({
    switchOn: checked,
    labelText: null,
    disabled: disabled,
    input: {
        [':checked']() {
            return this.switchOn;
        },
    },
    trigger: {
        ['@click']() {
            return this.toggle()
        },
        ['x-cloak']() {
            return true;
        },
    },
    label: {
        ['@click']() {
            this.$refs.trigger.click();
            this.$refs.trigger.focus()
        },
        ['x-cloak']() {
            return true;
        },
        ['x-effect']() {
            return this.switchOn ? this.labelText = checkedLabelText : this.labelText = uncheckedLabelText;
        },
        ['x-text']() {
            return this.labelText;
        },
    },
    toggle() {
        if (this.disabled) {
            return;
        }
        return this.switchOn = !this.switchOn;
    }
})
