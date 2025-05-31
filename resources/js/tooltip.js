export default (delayDuration, skipDelayDuration, defaultOpen) => ({
    delayDuration: delayDuration,
    skipDelayDuration: skipDelayDuration,
    tooltipOpened: defaultOpen,
    debounceTimeout: null,
    trigger: {
        ['@mouseover']() {
            clearTimeout(this.mouseoutTimeout);
            clearTimeout(this.debounceTimeout);

            this.debounceTimeout = setTimeout(() => {
                this.open();
            }, this.delayDuration);
        },
        ['@mouseout']() {
            clearTimeout(this.mouseoutTimeout);
            this.mouseoutTimeout = setTimeout(() => {
                clearTimeout(this.debounceTimeout);
                this.close();
            }, this.skipDelayDuration);
        },
    },
    svg: {
        ['x-show']() {
            return this.tooltipOpened
        },
        ['x-anchor.bottom.center.offset.-6']() {
            return this.$refs.content
        },
        ['x-transition']() {
            return true
        },
    },
    content: {
        ['x-show']() {
            return this.tooltipOpened
        },
        ['x-anchor.top.center.offset.10']() {
            return this.$refs.trigger
        },
        ['x-transition']() {
            return true
        },
    },
    open() {
        this.tooltipOpened = true;
    },
    close() {
        this.tooltipOpened = false;
    }
})
