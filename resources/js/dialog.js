export default (show, dismissable) => ({
    show: show,
    dismissable: dismissable,
    close() {
        this.show = false;
    },
    open() {
        this.show = true;
    },
    trigger: {
        ['@click']() {
            return this.open();
        },
    },
    overlay: {
        ['x-on:keydown.esc']() {
            if (this.dismissable) {
                return this.close();
            }
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
        ['x-trap.noscroll']() {
            return this.show;
        },
        ['x-transition.opacity']() {
            return true;
        },
    },
    dialog: {
        ['@click.stop']() {
            return true;
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
