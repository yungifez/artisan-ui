export default (delayDuration, skipDelayDuration, defaultOpen) => ({
    delayDuration: delayDuration,
    skipDelayDuration: skipDelayDuration,
    tooltipOpened: defaultOpen,
    debounceTimeout: null,
    trigger: {
        ['@mouseover']() {
            clearTimeout(this.debounceTimeout)
            this.debounceTimeout = setTimeout(() => {
                this.open()
            }, this.delayDuration)
        },
        ['@mouseout']() {
            setTimeout(() => {
                clearTimeout(this.debounceTimeout)
                this.close()
            }, this.delayDuration)
        }
    },
    content: {
        ['x-show']() {
            return this.tooltipOpened
        },
        ['x-anchor.top.center.offset.10']() {
            return this.$refs.trigger
        }
    },
    open() {
        this.tooltipOpened = true;
    },
    close() {
        this.tooltipOpened = false;
    }
})
