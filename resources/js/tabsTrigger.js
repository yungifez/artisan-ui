export default (value) => ({
    value: value,
    root: {
        ['@click']() {
            return this.setAsActive();
        },
        ['@focus']() {
            if (this.$data.activationMode != "manual") {
                this.setAsActive();
            }
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
