export default (value) => ({
    value: value,
    root: {
        [':data-state']() {
            return this.$data.active == this.value ? 'active' : 'inactive';
        },
        ['@click']() {
            return this.setAsActive();
        },
        ['@focus']() {
            if (this.$data.activationMode != "manual") {
                this.setAsActive();
            }
        },
        [':aria-selected']() {
            return this.value == this.$data.active;
        },
        [':tabindex']() {
            return this.$data.active == this.value ? 0 : -1;
        },
        [':class']() {
            return { 'bg-background text-foreground shadow-sm': this.$data.active == this.value };
        },
    },
    setAsActive() {
        this.$data.active = this.value;
    }
})
