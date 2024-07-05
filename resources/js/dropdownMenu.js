export default () => ({
    dropdownMenu: false,
    root: {
        ['@click.outside']() {
            return this.close();
        },
    },
    trigger: {
        ['@click']() {
            return this.toggle();
        },
        ['@keydown.esc.window']() {
            return this.close();
        },
    },
    content: {
        ['x-anchor.offset.4']() {
            return this.$refs.trigger;
        },
        ['@keydown.down.prevent']() {
            return this.$focus.wrap().next();
        },
        ['@keydown.up.prevent']() {
            return this.$focus.wrap().previous();
        },
        ['x-trap.noscroll']() {
            return this.dropdownMenu;
        },
        ['x-show']() {
            return this.dropdownMenu;
        },
        ['x-transition']() {
            return true;
        },
    },
    menuItem: {
        ['@click']() {
            return this.close();
        },
        ['@mouseover']() {
            return this.$focus.focus(this.$el);
        },
    },
    close() {
        this.dropdownMenu = false;
    },
    open() {
        this.dropdownMenu = true;
    },
    toggle() {
        this.dropdownMenu ? this.close() : this.open()
    }
})
