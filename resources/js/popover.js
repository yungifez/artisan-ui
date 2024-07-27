export default () => ({
    popover: false,
    trigger: {
        ['@click']() {
            return this.toggle();
        },
        ['@keydown.escape']() {
            return this.close();
        },
    },
    content: {
        ['x-anchor.offset.4']() {
            return this.$refs.trigger;
        },
        ['@keydown.tab.prevent']() {
            return this.close();
        },
        ['x-trap.noscroll']() {
            return this.popover;
        },
        ['@click.outside.capture']() {
            return this.close();
        },
        ['x-show']() {
            return this.popover;
        },
        ['x-transition']() {
            return true;
        },
    },
    close() {
        this.popover = false;
    },
    open() {
        this.popover = true;
    },
    toggle() {
        this.popover == true ? this.close() : this.open()
    }
})
