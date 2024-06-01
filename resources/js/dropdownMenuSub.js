export default () => ({
    'subOpen': false,
    'subPreview': false,
    root: {
        ['@keydown.escape']() {
            return this.close();
        },
        ['@keydown.right']() {
            return this.open();
        },
        ['@keydown.left']() {
            return this.close();
        },
        ['@click.outside']() {
            return this.close();
        },
        [':aria-expanded']() {
            return this.subOpen;
        },
    },
    trigger: {
        ['@click']() {
            return this.toggle();
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
