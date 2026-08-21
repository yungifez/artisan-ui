export default (value) => ({
    value: value,
    root: {
        [':data-state']() {
            return this.$data.active == this.value ? 'active' : 'inactive';
        },
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
