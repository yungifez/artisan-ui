export default class SingleModeHandler {
    constructor(value) {
        if (value == null) {
           return;
        }
        if (typeof value == "string") {
            this.value = this.createDateWithoutTime(value)
        } else if (typeof value == 'date') {
            this.value = value
        }else{
            console.error('Selected type supplied to calendar with mode single is not a string or Javascript date')
        }
    }

    dayClicked(date) {
        this.value = date
        return true
    }

    isSelectedDay(date) {
        return this.value?.getTime() === date.getTime();
    }

    isDisabled(date){
        return false;
    }

    createDateWithoutTime(value) {
        let date = new Date(value)
        date.setHours(0,0,0,0);

        return date;
    }
}
