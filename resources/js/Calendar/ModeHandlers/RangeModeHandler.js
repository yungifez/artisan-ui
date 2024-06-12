export default class RangeModeHandler {
    constructor(values,required, min, max) {
        this.min = min
        this.max = max
        this.required = !!required;
        this.values = { from: null, to: null };
        if (typeof values.from == 'undefined' || typeof values.to == 'undefined') {
            console.warn('Selected type supplied to calendar in range mode is not an object with from and to values')
        } else {
            if (typeof values.from == "string") {
                this.values.from = this.createDateWithoutTime(values.from)
            } else if (typeof values.from == 'date') {
                this.values.from = values.from
            } else {
                console.warn('Item is not date or date string, skipping')
            }

            if (typeof values.to == "string") {
                this.values.to = this.createDateWithoutTime(values.to)
            } else if (typeof values.to == 'date') {
                this.values.to = values.to
            } else {
                console.warn('Item is not date or date string, skipping')
            }
        }
    }

    dayClicked(date) {
        if (this.values.from == null || (this.values.to != null && this.values.to.getTime() == date.getTime())) {
            this.values.from = date
            this.values.to = null
            return true;
        }

        if (this.values.from.getTime() > date.getTime()) {
            this.values.from = date
            return true;
        }

        if (this.values.from.getTime() == date.getTime()) {
            this.values.from = null
            this.values.to = null
            return true;
        }

        this.values.to = date
        return true;
    }

    isSelectedDay(date) {
        if (this.values.from == null) {
            return false;
        }

        if (this.values.to == null) {
            return this.values.from.getTime() == date.getTime()
        }

        return date.getTime() == this.values.from.getTime() || date.getTime() == this.values.to.getTime()
    }

    get value() {
        return this.values
    }


    isDisabled(date) {
        if (this.values.from) {
            let daysBetween = Math.abs(this.getNumberOfDaysBetweenDates(this.values.from, date))
            return (((this.min && daysBetween < this.min) || (this.max && daysBetween > this.max)) && daysBetween != 0)
        }
    }

    isRangeMiddle(date) {
        if (this.values.from && this.values.to && date.getTime() >= this.values.from.getTime() && date.getTime() <= this.values.to.getTime()) {
            return true
        }

        return false
    }

    createDateWithoutTime(value) {
        let date = new Date(value)
        date.setHours(0, 0, 0, 0);

        return date;
    }

    getNumberOfDaysBetweenDates(date1, date2) {
        return Math.round((date1.getTime() - date2.getTime()) / (1000 * 3600 * 24));
    }
}
