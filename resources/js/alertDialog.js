export default (show = false, dismissable = false) => ({
    show,
    dismissable,
    root: {
        [':data-state']() {
            return this.show ? 'open' : 'closed';
        },
        ['x-id']() {
            return ['alert-dialog'];
        },
        ['x-on:keydown.esc.window.stop']() {
            if (this.dismissable) {
                this.close();
            }
        },
    },
    trigger: {
        [':data-state']() {
            return this.show ? 'open' : 'closed';
        },
        ['@click']() {
            this.open();
        },
        [':id']() {
            return this.$id('alert-dialog') + '-trigger';
        },
        [':aria-expanded']() {
            return this.show;
        },
        [':aria-haspopup']() {
            return 'dialog';
        },
        [':aria-controls']() {
            return this.$id('alert-dialog') + '-content';
        },
    },
    overlay: {
        [':data-state']() {
            return this.show ? 'open' : 'closed';
        },
        ['@click']() {
            if (this.dismissable) {
                this.close();
            }
        },
        ['x-show']() {
            return this.show;
        },
        ['x-cloak']() {
            return true;
        },
        ['x-trap.noscroll.inert']() {
            return this.show;
        },
        ['x-transition.opacity.duration.200ms']() {
            return true;
        },
    },
    dialog: {
        [':data-state']() {
            return this.show ? 'open' : 'closed';
        },
        ['@click.stop']() {
            return true;
        },
        [':aria-labelledby']() {
            return this.$id('alert-dialog') + '-title';
        },
        [':aria-describedby']() {
            return this.$id('alert-dialog') + '-description';
        },
        [':aria-modal']() {
            return this.show;
        },
        [':id']() {
            return this.$id('alert-dialog') + '-content';
        },
    },
    title: {
        [':id']() {
            return this.$id('alert-dialog') + '-title';
        },
    },
    description: {
        [':id']() {
            return this.$id('alert-dialog') + '-description';
        },
    },
    closeButton: {
        ['@click']() {
            this.close();
        },
    },
    action: {
        ['@click']() {
            this.close();
        },
    },
    open() {
        this.show = true;
    },
    close() {
        this.show = false;
    },
});
