export default () => ({
    popover: false,
    root: {
        [':data-state']() {
            return this.popover ? 'open' : 'closed';
        },
        ['x-id']() {
            return ['popover'];
        },
    },
    trigger: {
        [':data-state']() {
            return this.popover ? 'open' : 'closed';
        },
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
        [':data-state']() {
            return this.popover ? 'open' : 'closed';
        },
        ['@click.outside.capture']() {
            if (!this.$refs.trigger.contains(this.$event.target)) {
                return this.close();
            }
        },
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
