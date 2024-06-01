export default (dismissOnTimeout, timeout) => ({
    'visible': true,
    'dismissOnTimeout': dismissOnTimeout,
    'timeout': timeout,
    root: {
        ['x-show']() {
            return this.visible;
        },
        ['x-cloak']() {
            return true;
        },
        ['x-transition']() {
            return true;
        },
    },
    dismissTrigger: {
        ['@click']() {
            return this.dismiss();
        },
    },
    init() {
        if (this.dismissOnTimeout) {
            setTimeout(() => { this.dismiss() }, this.timeout);
        }
    },
    dismiss() {
        this.visible = false;
    }
})
