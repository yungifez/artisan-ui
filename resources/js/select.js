export default (multiple, disabled) => ({
    options: [],
    selected: [],
    value: [],
    get selectedValues() {
        return this.value;
    },
    set selectedValues(value) {
        this.value = value;
    },
    multiple: multiple,
    disabled: disabled,
    show: false,
    root: {
        [':data-state']() {
            return this.show ? 'open' : 'closed';
        },
        [':data-disabled']() {
            return this.disabled || null;
        },
        ['x-id']() {
            return ['select'];
        },
        ['x-on:keydown.tab']() {
            return this.close();
        },
        ['@click.outside.capture']() {
            return this.close();
        },
        ['x-on:keydown.escape']() {
            return this.close();
        },
    },
    trigger: {
        [':data-state']() {
            return this.show ? 'open' : 'closed';
        },
        ['@click']() {
            return this.toggle();
        },
        ['@keypress.enter']() {
            return this.open();
        },
        [':disabled']() {
            return this.disabled;
        },
        [':aria-expanded']() {
            return this.show;
        },
        [':aria-haspopup']() {
            return 'listbox';
        },
        [':aria-controls']() {
            return this.$id('select') + '-list';
        },
    },
    optionList: {
        [':data-state']() {
            return this.show ? 'open' : 'closed';
        },
        ['x-show.transition.scale.origin.top']() {
            return this.show;
        },
        ['x-trap.noscroll']() {
            return this.show;
        },
        ['x-anchor']() {
            return this.$refs.select;
        },
        ['x-on:keydown.up.prevent']() {
            return this.$focus.wrap().previous();
        },
        ['x-on:keydown.down.prevent']() {
            return this.$focus.wrap().next();
        },
        [':id']() {
            return this.$id('select') + '-list';
        },
    },
    init() {
        this.loadOptions();

        this.$watch('value', (values) => {
            if (this.hasModelBinding()) this.syncOptionsToValues(values)
        });

        this.$nextTick(() => {
            if (this.hasModelBinding()) {
                this.syncOptionsToValues(this.value)
            } else {
                this.setSelectedValues()
            }
        });
    },
    open() {
        if (!this.disabled) {
            this.show = true
        }
    },
    isOpen() {
        return this.show
    },
    close() {
        this.show = false
    },
    toggle() {
        this.show ? this.close() : this.open()
    },
    select(index) {
        if(!!this.options[index].disabled){
            return;
        }
        if (!this.options[index].selected || !this.multiple) {
            if (!this.multiple) {
                for (let i = 0; i < this.selected.length; i++) {
                    this.options[this.selected[i]].selected = false;
                }
                this.selected.length = 0;
            }
            this.options[index].selected = true;
            this.selected.push(index);
        } else {
            this.selected.splice(this.selected.lastIndexOf(index), 1);
            this.options[index].selected = false
        }

        this.setSelectedValues()
        this.dispatchChange()
        if (!this.multiple) {
            this.close()
        }
    },
    dispatchChange() {
        this.$nextTick(() => {
            const detail = {
                value: this.multiple
                    ? this.selected.map((el) => this.options[el].value)
                    : this.options[this.selected[0]].value,
            };

            this.$dispatch('value-change', detail);
            // Keep the native-style event available for existing listeners.
            this.$dispatch('change', detail);
        })
    },
    remove(index) {
        const idx = this.selected.indexOf(index);

        if (idx !== -1) {
            this.selected.splice(idx, 1);
            this.options[index].selected = false;
        } else {
            console.warn(`Option not found.`);
        }

        this.setSelectedValues()
        this.dispatchChange()
    },
    loadOptions() {
        const options = this.$root.childNodes[1].options;
        let lastSelected = 0;
        for (let i = 0; i < options.length; i++) {
            this.options.push({
                value: options[i].value,
                text: options[i].innerText,
                disabled: options[i].disabled,
                selected: options[i].getAttribute('selected') != null || (i == 0 && !this.multiple) ? true && this.selected.push(i) : false,
            });
            if (!this.multiple && options[i].getAttribute('selected') != null) {
                this.options[lastSelected].selected = false;
                lastSelected = i;
            }
        }
    },
    hasModelBinding() {
        return !!this.$root._x_model;
    },
    syncOptionsToValues(values) {
        const selectedValues = this.multiple
            ? (Array.isArray(values) ? values : (values == null || values === '' ? [] : [values]))
            : (values == null || values === '' ? [] : [values]);

        // An empty bound value still needs a usable single-select value. Pick
        // the first enabled option and write it back through x-modelable so
        // Livewire receives the same value the user sees in the trigger.
        if (!this.multiple && selectedValues.length === 0) {
            const firstAvailable = this.options.findIndex((option) => !option.disabled);

            this.options.forEach((option) => option.selected = false);
            this.selected = [];

            if (firstAvailable !== -1) {
                this.options[firstAvailable].selected = true;
                this.selected.push(firstAvailable);
                this.setSelectedValues();
            }

            return;
        }

        const selectedValueSet = new Set(selectedValues.map((value) => String(value)));

        this.selected = [];
        this.options.forEach((option, index) => {
            option.selected = selectedValueSet.has(String(option.value));
            if (option.selected && (this.multiple || this.selected.length === 0)) {
                this.selected.push(index);
            } else if (!this.multiple) {
                option.selected = false;
            }
        });
    },
    setSelectedValues() {
        this.value = this.multiple
            ? this.selected.map((option) => this.options[option].value)
            : (this.selected.length > 0 ? this.options[this.selected[0]].value : '');
    }
})
