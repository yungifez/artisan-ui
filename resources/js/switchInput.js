export default (checked, disabled) => ({
    switchOn: checked,
    disabled: disabled,
    input: {
        ['x-model']() {
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
    toggle() {
        if (this.disabled) {
            return;
        }
        this.switchOn = !this.switchOn;
        this.$dispatch('checkedChange');
    }
})
