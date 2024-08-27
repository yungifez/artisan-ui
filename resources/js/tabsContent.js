export default (value) => ({
    value: value,
    root: {
        ['x-show']() {
            return this.value == this.$data.active;
        },
        ['x-cloak']() {
            return this.value == this.$data.active;
        },
    },
})
