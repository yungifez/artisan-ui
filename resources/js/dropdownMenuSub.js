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
        ['@click']() {
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
        ['@focus']() {
            this.$el.setAttribute('tabindex', 0)
        },
        ['@focusout']() {
            this.$el.setAttribute('tabindex', -1)
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
        ['x-trap']() {
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
            return this.$focus.within(this.$el).wrap().next();
        },
        ['@keydown.up.prevent']() {
            return this.$focus.within(this.$el).wrap().previous();
        },
        ['@keydown.left.stop']() {
            return this.close();
        },
    },
    menuItem: {
        ['@click']() {
            return this.close();
        },
        ['@mouseover']() {
            return this.$focus.focus(this.$el);
        },
        [':tabindex']() {
            this.subOpen && this.$el.isEqualNode(this.$root.querySelectorAll('button')[2]) ? 0 : -1
        },
        ['@focus']() {
            this.$el.setAttribute('tabindex', 0)
        },
        ['@focusout']() {
            this.$el.setAttribute('tabindex', -1)
        },
        ['@keydown.tab']() {
            this.close()
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
