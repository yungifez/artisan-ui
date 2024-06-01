export default (open, value) => ({
    open: open,
    value: value,
    root: {
        ['x-on:keydown.esc']() {
            return this.closePicker();
        },
        ['x-cloak']() {
            return true;
        },
    },
    input: {
        ['@click']() {
            return this.togglePicker();
        },
        ['@keypress.esc']() {
            return this.closePicker();
        },
        ['@keypress.space']() {
            return this.togglePicker();
        },
        ['x-model']() {
            // wacky
            return () => this.value;
        },
    },
    calendar: {
        ['x-show']() {
            return this.open;
        },
        ['x-cloak']() {
            return true;
        },
        ['x-transition']() {
            return true;
        },
        ['@click.away']() {
            return this.closePicker();
        },
        ['x-anchor.bottom-start.offset.3']() {
            return this.$refs.datePickerInput;
        },
        ['x-trap']() {
            return this.open;
        },
        ['@selected']() {
            return this.value = this.$event.detail.value;
        },
    },
    openPicker() {
        this.open = true
    },
    closePicker() {
        this.open = false
    },
    togglePicker() {
        this.open ? this.closePicker() : this.openPicker()
    },
})
