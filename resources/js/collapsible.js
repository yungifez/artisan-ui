export default (open = false, disabled = false) => ({
    open,
    disabled,
    root: {
        [':data-state']() {
            return this.open ? 'open' : 'closed';
        },
        [':data-disabled']() {
            return this.disabled || null;
        },
        ['x-id']() {
            return ['collapsible'];
        },
    },
    trigger: {
        [':data-state']() {
            return this.open ? 'open' : 'closed';
        },
        [':aria-expanded']() {
            return this.open;
        },
        [':aria-controls']() {
            return this.$id('collapsible') + '-content';
        },
        [':aria-disabled']() {
            return this.disabled;
        },
        [':disabled']() {
            return this.disabled;
        },
        ['@click']() {
            if (!this.disabled) {
                this.open = !this.open;
            }
        },
        ['@keydown.enter.prevent']() {
            if (!this.disabled) {
                this.open = !this.open;
            }
        },
        ['@keydown.space.prevent']() {
            if (!this.disabled) {
                this.open = !this.open;
            }
        },
        [':id']() {
            return this.$id('collapsible') + '-trigger';
        },
    },
    content: {
        [':data-state']() {
            return this.open ? 'open' : 'closed';
        },
        [':id']() {
            return this.$id('collapsible') + '-content';
        },
        [':aria-labelledby']() {
            return this.$id('collapsible') + '-trigger';
        },
        ['x-show']() {
            return this.open;
        },
        ['x-collapse.duration.200ms']() {
            return true;
        },
    },
});
