export default (show, dismissable) => ({
    show: show,
    dismissable: dismissable,
    close() {
        this.show = false;
    },
    open() {
        this.show = true;
    },
    root: {
        [':data-state']() {
            return this.show ? 'open' : 'closed';
        },
        ['x-id']() {
            return ['dialog'];
        },
        ['x-on:keydown.esc.window.stop']() {
            if (this.dismissable) {
                return this.close();
            }
        },
    },
    trigger: {
        [':data-state']() {
            return this.show ? 'open' : 'closed';
        },
        ['@click']() {
            return this.open();
        },
        [':id']() {
            return this.$id('dialog') + '-trigger';
        },
    },
    overlay: {
        [':data-state']() {
            return this.show ? 'open' : 'closed';
        },
        ['@click']() {
            if (this.dismissable) {
                return this.close();
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
        ['x-transition.opacity.duration.300ms']() {
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
            return this.$id('dialog') + '-title';
        },
        [':aria-describedby']() {
            return this.$id('dialog') + '-description';
        },
        [':aria-modal']() {
            return this.show;
        },
    },
    title: {
        [':id']() {
            return this.$id('dialog') + '-title';
        },
    },
    description: {
        [':id']() {
            return this.$id('dialog') + '-description';
        },
    },
    closeButton: {
        ['@click']() {
            if (this.dismissable) {
                return this.close();
            }
        },
    }
})
