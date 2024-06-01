export default class MultipleModeHandler {
    constructor(values, min, max) {
        this.min = min
        this.max = max
        this.values = [];
        if (!Array.isArray(values)) {
            console.warn('Selected type supplied to calendar in multiple mode is not an array')
        } else {
            values.forEach(value => {
                value = this.createDateWithoutTime(value)
                if (this.isSelectedDay(value)) {
                    return;
                }

                return this.values.push(value)
            });
        }
    }

    isDisabled(date){
        if (this.max <= this.values.length) {
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
        let index = this.indexOfDateInValue(this.values, date)
        if (index >= 0) {
            this.values.splice(index, 1);
        } else {
            this.values.push(date)
        }
    }

    isSelectedDay(date) {
        return this.indexOfDateInValue(this.values, date) >= 0;
    }

    get value(){
        return this.values
    }

    createDateWithoutTime(value) {
        let date = new Date(value)
        date.setHours(0,0,0,0);

        return date;
    }
}
