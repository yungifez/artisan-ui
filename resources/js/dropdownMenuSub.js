export default () => ({
    subOpen: false,
    subPreview: false,
    root: {
        ['@keydown.escape']() {
            return this.close();
        },
        ['@click.outside']() {
            return this.close();
        },
        ['@keydown.right']() {
            return this.open();
        },
        [':aria-expanded']() {
            return this.subOpen;
        },
    },
    trigger: {
        ['@click']() {
            return this.open();
        },
        ['@mouseover']() {
            this.$el.focus();
            this.openPreview();
        },
        ['@mouseout']() {
            this.$el.focus();
            this.closePreview();
        },
    },
    template: {
        ['x-if']() {
            return this.subOpen || this.subPreview;
        },
    },
    content: {
        ['x-anchor.left-start.right-start']() {
            return this.$refs.subTrigger;
        },
        ['x-trap.noscroll']() {
            return this.subOpen;
        },
        ['x-show']() {
            return this.subOpen || this.subPreview;
        },
        ['x-transition']() {
            return true;
        },
        ['x-cloak']() {
            return true;
        },
        ['@keydown.down.prevent']() {
            return this.$focus.wrap().next();
        },
        ['@keydown.up.prevent']() {
            return this.$focus.wrap().previous();
        },
        ['@keydown.left.stop']() {
            return this.close();
        },
    },
    open() {
        this.subOpen = true
    },
    close() {
        this.subOpen = false
    },
    toggle() {
        this.subOpen == true ? this.close() : this.open()
    },
    openPreview() {
        this.subPreview = true;
    },
    closePreview() {
        this.subPreview = false;
    }
})
