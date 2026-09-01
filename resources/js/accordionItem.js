export default () => ({
    root: {
        [':data-state']() {
            return this.$data.value.includes(this.$id('accordion-item')) ? 'open' : 'closed';
        },
        ['x-id']() {
            return ['accordion-item'];
        },
    },
    trigger: {
        [':data-state']() {
            return this.$data.value.includes(this.$id('accordion-item')) ? 'open' : 'closed';
        },
        [':data-disabled']() {
            return this.$data.disabled || null;
        },
        ['@click']() {
            return this.toggle();
        },
        [':aria-expanded']() {
            return this.$data.value.includes(this.$id('accordion-item'));
        },
        [':aria-controls']() {
            return this.$id('accordion-item') + '-content';
        },
        [':id']() {
            return this.$id('accordion-item') + '-trigger';
        },
        [':disabled']() {
            return this.$data.disabled;
        },
    },
    icon: {
        [':class']() {
            return { '-rotate-180': this.$data.value.includes(this.$id('accordion-item')) }
        }
    },
    content: {
        [':data-state']() {
            return this.$data.value.includes(this.$id('accordion-item')) ? 'open' : 'closed';
        },
        [':id']() {
            return this.$id('accordion-item') + '-content';
        },
        [':aria-labelledby']() {
            return this.$id('accordion-item') + '-trigger';
        },
        ['x-show']() {
            return this.$data.value.includes(this.$id('accordion-item'));
        },
        ['x-collapse.duration.300ms']() {
            return true;
        },
    },
    expand() {
        if (this.type == 'single') {
            this.$data.value = this.$id('accordion-item')
        } else {
            let index = this.$data.value.indexOf(this.$id('accordion-item'))
            if (index < 0) {
                this.$data.value.push(this.$id('accordion-item'))
            }
        }
        this.$nextTick(() => {
            const detail = { value: this.$data.value };

            this.$dispatch('value-change', detail);
            // Keep the original event name available for existing listeners.
            this.$dispatch('valueChange', detail);
        })
    },
    collapse() {
        if (this.type == 'single' && this.collapsible) {
            this.$data.value = ''
        } else {
            let index = this.$data.value.indexOf(this.$id('accordion-item'))
            if (index >= 0) {
                this.$data.value.splice(index, 1)
            }
        }
        this.$nextTick(() => {
            const detail = { value: this.$data.value };

            this.$dispatch('value-change', detail);
            // Keep the original event name available for existing listeners.
            this.$dispatch('valueChange', detail);
        })
    },
    toggle() {
        this.$data.value.includes(this.$id('accordion-item')) ? this.collapse() : this.expand()
    }
})
