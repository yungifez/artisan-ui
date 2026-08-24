export default class SingleModeHandler {
    constructor(selected, required) {
        this.required = !!required;

        const date = this.createDateWithoutTime(selected)
        if (date) this.dayClicked(date)
    }

    get value() {
        return this._value
    }

    set value(value) {
        const processDate = (input) => {
            if (input == null) return null;
            if (typeof input === "string") return this.createDateWithoutTime(input);
            if (input instanceof Date) return this.createDateWithoutTime(input);
            console.warn("Item is not a date or date string, skipping");
            return null;
        };
        this._value = processDate(value)
    }

    dayClicked(date) {
        if (!date) return false
        if (this._value != null && this._value.getTime() == date.getTime() && !this.required) {
            this._value = null
        } else {
            this._value = date
        }
        return true
    }

    isSelectedDay(date) {
        return this._value?.getTime() === date.getTime();
    }

    isDisabled(date) {
        return false;
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
