export default () => ({
    loadError: false,
    image: {
        ['x-show']() {
            return !this.loadError;
        },
        ['x-cloak']() {
            return true;
        },
        ['x-on:error']() {
            return this.loadError = true;
        },
    },
    fallback: {
        ['x-show']() {
            return this.loadError;
        },
        ['x-cloak']() {
            return true;
        },
    }
})
