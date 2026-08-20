export default (dismissOnTimeout, timeout, startTimeoutOnIntersect) => ({
    'visible': true,
    'dismissOnTimeout': dismissOnTimeout,
    'startTimeoutOnIntersect': startTimeoutOnIntersect,
    'timeout': timeout,
    root: {
        [':data-state']() {
            return this.visible ? 'open' : 'closed';
        },
        ['x-show']() {
            return this.visible;
        },
        ['x-cloak']() {
            return true;
        },
        ['x-transition']() {
            return true;
        },
        ['x-intersect']() {
            if (this.dismissOnTimeout && this.startTimeoutOnIntersect) {
                return setTimeout(() => { this.dismiss() }, this.timeout);
            }
        },
    },
    dismissTrigger: {
        ['@click']() {
            return this.dismiss();
        },
    },
    init() {
        if (this.dismissOnTimeout && !this.startTimeoutOnIntersect) {
            setTimeout(() => { this.dismiss() }, this.timeout);
        }
    },
    dismiss() {
        this.visible = false;
    }
})
