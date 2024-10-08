export default () => ({
    subOpen: false,
    subPreview: false,
    root: {
        ['@keydown.escape']() {
            return this.closeSub();
        },
        ['@click.outside']() {
            return this.closeSub();
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
            return this.$focus.wrap().next();
        },
        ['@keydown.up.prevent']() {
            return this.$focus.wrap().previous();
        },
        ['@keydown']($event) {
            if ($event.key =='Home') {
                return this.$focus.wrap().first();
            }
            if ($event.key =='End') {
                return this.$focus.wrap().last();
            }
        },
        ['@keydown.left.stop']() {
            return this.closeSub();
        },
    },
    menuItem: {
        ['@click']() {
            this.closeSub();
            this.$data.close()
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
            this.closeSub()
        },
    },
    open() {
        this.subOpen = true
    },
    closeSub() {
        this.subOpen = false
    },
    toggle() {
        this.subOpen == true ? this.closeSub() : this.open()
    },
    openPreview() {
        this.subPreview = true;
    },
    closePreview() {
        this.subPreview = false;
    }
})
