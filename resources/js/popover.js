export default () => ({
    popover: false,
    root: {
        ['x-id']() {
            return ['popover'];
        },
        ['@click.outside.capture']() {
            return this.close();
        },
    },
    trigger: {
        ['@click']() {
            return this.toggle();
        },
        [':id']() {
            return this.$id('popover') + '-trigger';
        },
        [':aria-controls']() {
            return this.$id('popover') + '-content';
        },
        ['@keydown.esc.window']() {
            return this.close();
        },
    },
    content: {
        ['x-anchor.offset.4']() {
            return this.$refs.trigger;
        },
        ['x-trap']() {
            return this.popover;
        },
        ['x-show']() {
            return this.popover;
        },
        ['x-transition']() {
            return true;
        },
        [':id']() {
            return this.$id('popover') + '-content';
        },
        [':aria-labelledby']() {
            return this.$id('popover-menu') + '-trigger';
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
