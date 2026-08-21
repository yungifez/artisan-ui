export default (side) => {
    const offsets = {
        top: '-translate-y-full',
        bottom: 'translate-y-full',
        left: '-translate-x-full',
        right: 'translate-x-full',
    };
    const offset = offsets[side] ?? offsets.right;

    return {
        side: side,
        root: {
            [':id']() {
                return this.$id('dialog') + '-content';
            },
            [':aria-labelledby']() {
                return this.$id('dialog') + '-title';
            },
            [':aria-describedby']() {
                return this.$id('dialog') + '-description';
            },
            [':aria-modal']() {
                return true;
            },
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
                return "transition-transform ease-in-out duration-500";
            },
            ['x-transition:enter-start']() {
                return offset;
            },
            ['x-transition:enter-end']() {
                return "translate-x-0 translate-y-0";
            },
            ['x-transition:leave']() {
                return "transition-transform ease-in-out duration-300";
            },
            ['x-transition:leave-start']() {
                return "translate-x-0 translate-y-0";
            },
            ['x-transition:leave-end']() {
                return offset;
            },
        },
        title: {
            [':id']() {
                return this.$id('dialog') + '-title';
            },
        },
        description: {
            [':id']() {
                return this.$id('dialog') + '-description';
            },
        },
    };
};
