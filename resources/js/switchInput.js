export default (disabled) => ({
    switchOn: false,
    disabled: disabled,
    input: {
        ['x-model.boolean']() {
            return "switchOn";
        },
        [':disabled']() {
            return this.disabled;
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
    setSwitchState(value){
        if (this.disabled) {
            return;
        }

        this.switchOn = value;
        this.$refs.input.checked = value;
        this.$dispatch('checkedChange');
    },
    toggle() {
        this.setSwitchState(!this.switchOn);
    }
})
