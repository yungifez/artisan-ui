export default (disabled) => ({
    switchOn: false,
    disabled: disabled,
    input: {
        ['x-model.boolean']() {
            return "switchOn";
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
        this.$dispatch('checkedChange');
    },
    toggle() {
        this.switchOn = this.setSwitchState(!this.switchOn);
    }
})
