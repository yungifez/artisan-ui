export default (side) => ({
    side: side,
    root: {
        [':data-state']() {
            return this.$data['show'] ? 'open' : 'closed';
        },
        ['x-show']() {
            return this.$data['show'];
        },
        ['@click.stop']() {
            return true;
        },
        ['x-cloak']() {
            return true;
        },
        ['x-transition:enter']() {
            return "transition-opacity ease-in-out duration-500";
        },
        ['x-transition:enter-start']() {
            return "opacity-0";
        },
        ['x-transition:enter-end']() {
            return "opacity-100";
        },
        ['x-transition:leave']() {
            return "transition-opacity ease-in-out duration-300";
        },
        ['x-transition:leave-start']() {
            return "opacity-100";
        },
        ['x-transition:leave-end']() {
            return "opacity-0";
        },
    },
})
