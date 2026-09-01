export default () => ({
    open: false,
    x: 0,
    y: 0,
    root: {
        [':data-state']() {
            return this.open ? 'open' : 'closed';
        },
        ['x-id']() {
            return ['context-menu'];
        },
        ['@click.outside']() {
            this.close();
        },
        ['@keydown.escape.window']() {
            this.close();
        },
    },
    trigger: {
        [':aria-expanded']() {
            return this.open;
        },
        [':aria-haspopup']() {
            return 'menu';
        },
        [':aria-controls']() {
            return this.$id('context-menu') + '-content';
        },
        ['@contextmenu.prevent']($event) {
            this.openAt($event);
        },
    },
    content: {
        [':data-state']() {
            return this.open ? 'open' : 'closed';
        },
        [':id']() {
            return this.$id('context-menu') + '-content';
        },
        [':style']() {
            return {
                left: `${this.x}px`,
                top: `${this.y}px`,
            };
        },
        ['x-show']() {
            return this.open;
        },
        ['x-trap.noscroll']() {
            return this.open;
        },
        ['x-transition']() {
            return true;
        },
        ['@keydown.down.prevent']() {
            this.$focus.within(this.$el).wrap().next();
        },
        ['@keydown.up.prevent']() {
            this.$focus.within(this.$el).wrap().previous();
        },
    },
    menuItem: {
        ['@click']() {
            this.close();
        },
        ['@mouseenter']() {
            this.$focus.focus(this.$el);
        },
    },
    openAt(event) {
        this.x = Math.min(event.clientX, window.innerWidth - 220);
        this.y = Math.min(event.clientY, window.innerHeight - 180);
        this.open = true;
        this.$nextTick(() => this.$focus.focus(this.$refs.content?.querySelector('[role="menuitem"]')));
        this.$nextTick(() => setTimeout(() => {
            const content = this.$refs.content;

            if (content) {
                content.style.left = `${this.x}px`;
                content.style.top = `${this.y}px`;
            }
        }, 200));
    },
    close() {
        this.open = false;
    },
});
