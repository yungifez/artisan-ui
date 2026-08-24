export default class MultipleModeHandler {
    constructor(selected, required, min, max) {
        this.min = min
        this.max = max
        this._value = [];
        this.required = !!required;

        if (selected && Array.isArray(selected)) {
            selected.forEach(element => {
                const date = this.createDateWithoutTime(element)
                if (date) this.dayClicked(date)
            });
        }
    }

    get value() {
        return this._value
    }

    set value(value) {
        if (!Array.isArray(value)) {
            console.warn('Selected type supplied to calendar in multiple mode is not an array')
            return
        }
        value.forEach(item => {
            const processDate = (input) => {
                if (input == null) return null;
                if (typeof input === "string") return this.createDateWithoutTime(input);
                if (input instanceof Date) return this.createDateWithoutTime(input);
                console.warn("Item is not a date or date string, skipping");
                return null;
            };
            item = processDate(item)
            if (!item) return
            if (this.isSelectedDay(item)) {
                return;
            }

            this._value.push(item)
        });
    }

    isDisabled(date) {
        if (this.max && this.max <= this._value.length) {
            return !this.isSelectedDay(date)
        }
    }

    indexOfDateInValue(array, value) {
        for (let index = 0; index < array.length; index++) {
            const date = array[index];

            if (date.getTime() === value.getTime()) {
                return index;
            }
        }

        return -1;
    }

    dayClicked(date) {
        if (!date) return false
        let index = this.indexOfDateInValue(this._value, date)
        if (index >= 0) {
            this._value.splice(index, 1);
        } else {
            this._value.push(date)
        }

        return true;
    }

    isSelectedDay(date) {
        return this.indexOfDateInValue(this._value, date) >= 0;
    }

    createDateWithoutTime(value) {
        if (value == null || value === '') return null
        let date = typeof value === 'string' && /^\d{4}-\d{2}-\d{2}/.test(value)
            ? new Date(Number(value.slice(0, 4)), Number(value.slice(5, 7)) - 1, Number(value.slice(8, 10)))
            : new Date(value)
        date.setHours(0, 0, 0, 0);

        return Number.isNaN(date.getTime()) ? null : date;
    }
}
