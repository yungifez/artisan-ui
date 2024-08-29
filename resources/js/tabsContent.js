export default (value) => ({
    value: value,
    root: {
        ['x-show']() {
            return this.value == this.$data.active;
        },
        [':tabindex']() {
            return this.$data.active == this.value ? 0 : -1;
        },
        ['x-cloak']() {
            return this.value == this.$data.active;
        },
    },
})
