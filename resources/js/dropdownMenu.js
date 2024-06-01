export default () => ({
    dropdownMenu: false,
    trigger: {
        ['@click']() {
            return this.toggle();
        },
        ['@keydown.escape']() {
            return this.close();
        },
    },
    content: {
        ['x-anchor.offset.4']() {
            return this.$refs.trigger;
        },
        ['@keydown.down.prevent']() {
            return this.$focus.next();
        },
        ['@keydown.up.prevent']() {
            return this.$focus.previous();
        },
        ['@keydown.tab.prevent']() {
            return this.close();
        },
        ['x-trap']() {
            return this.dropdownMenu;
        },
        ['@click.outside']() {
            return this.close();
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
