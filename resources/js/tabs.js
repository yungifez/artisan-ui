export default (defaultValue, activationMode) => ({
    active: defaultValue,
    activationMode: activationMode,
    tabsList: {
        ['x-on:keydown.left.prevent']() {
            return this.$focus.wrap().previous();
        },
        ['x-on:keydown.right.prevent']() {
            return this.$focus.wrap().next();
        },
    }
})
