export default (delayDuration, skipDelayDuration, defaultOpen, disabled = false) => ({
    delayDuration: delayDuration,
    skipDelayDuration: skipDelayDuration,
    tooltipOpened: defaultOpen,
    // A silenced tooltip keeps its markup and its trigger. Bind this to turn
    // a tooltip off for part of the time, such as a sidebar label that only
    // helps while the sidebar shows icons.
    tooltipDisabled: disabled,
    debounceTimeout: null,
    root: {
        ['x-id']() {
            return ['tooltip'];
        },
    },
    trigger: {
        [':data-state']() {
            return this.tooltipOpened ? 'open' : 'closed';
        },
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
        ['@focus']() {
            this.open();
        },
        ['@blur']() {
            this.close();
        },
        [':aria-describedby']() {
            return this.$id('tooltip') + '-content';
        },
    },
    svg: {
        ['x-show']() {
            return this.tooltipOpened && ! this.tooltipDisabled
        },
        ['x-anchor.bottom.center.offset.-6']() {
            return this.$refs.content
        },
        ['x-transition']() {
            return true
        },
    },
    content: {
        [':data-state']() {
            return this.tooltipOpened ? 'open' : 'closed';
        },
        [':id']() {
            return this.$id('tooltip') + '-content';
        },
        ['x-show']() {
            return this.tooltipOpened && ! this.tooltipDisabled
        },
        ['x-anchor.top.center.offset.10']() {
            return this.$refs.trigger
        },
        ['x-transition']() {
            return true
        },
    },
    open() {
        if (this.tooltipDisabled) {
            return;
        }

        this.tooltipOpened = true;
    },
    close() {
        this.tooltipOpened = false;
    }
})
