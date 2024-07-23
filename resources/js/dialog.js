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
        ['x-on:keydown.esc.window']() {
            if (this.dismissable) {
                return this.close();
            }
        },
    },
    trigger: {
        ['@click']() {
            return this.open();
        },
    },
    overlay: {
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
        ['x-transition.opacity.duration.150ms']() {
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
