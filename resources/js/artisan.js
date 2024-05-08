document.addEventListener('alpine:init', () => {

    /*
     *  Accordion
    */
    Alpine.data('accordion', () => ({
        active: 2
    }))

    /*
     *  Accordion Item
    */
    Alpine.data('accordionItem', () => ({
        open: false,
        root: {
            ['x-id'](){
                return ['accordion-item'];
            },
            ['x-effect'](){
                return this.$data.active != this.$id('accordion-item') ? this.collapse() : this.expand();
            },
        },
        trigger: {
            ['@click'](){
                return this.toggle();
            },
        },
        icon: {
            [':class'](){
                return {'-rotate-180' : this.open}
            }
        },
        content: {
            ['x-show'](){
                return this.$data.active == this.$id('accordion-item');
            },
            ['x-cloak'](){
                return true;
            },
            ['x-collapse.duration.300ms'](){
                return true;
            },
        },
        expand(){
            this.open = true;
            this.$data.active = this.$id('accordion-item');
        },
        collapse() {
            this.open = false;
            if(this.$data.active == this.$id('accordion-item')){
                this.$data.active = null
            }
        },
        toggle(){
            this.open ? this.collapse() : this.expand()
        }
    }))

    /*
     *  Alert
    */
    Alpine.data('alert', (dismissOnTimeout, timeout) => ({
        'visible' : true,
        'dismissOnTimeout': dismissOnTimeout,
        'timeout': timeout,
        root: {
            ['x-show'](){
                return this.visible;
            },
            ['x-cloak'](){
                return true;
            },
            ['x-transition'](){
                return true;
            },
        },
        dismissTrigger: {
            ['@click'](){
                return this.dismiss();
            },
        },
        init(){
            if (this.dismissOnTimeout) {
                setTimeout(() => { this.dismiss() }, this.timeout);
            }
        },
        dismiss(){
            this.visible = false;
        }
    }))

    /*
     *  Avatar
    */
    Alpine.data('avatar', () => ({
        loadError: false,
        image: {
            ['x-show'](){
                return !this.loadError;
            },
            ['x-cloak'](){
                return true;
            },
            ['x-on:error'](){
                return this.loadError = true;
            },
        },
        fallback: {
            ['x-show'](){
                return this.loadError;
            },
            ['x-cloak'](){
                return true;
            },
        }
    }))

    /*
     *  Banner
    */
    Alpine.data('banner', (displayAfter, transitionEnterStart,transitionEnterEnd,transitionLeaveStart,transitionLeaveEnd) => ({
        visible: false,
        displayAfter: displayAfter,
        transitionEnterStart: transitionEnterStart,
        transitionEnterEnd: transitionEnterEnd,
        transitionLeaveStart: transitionLeaveStart,
        transitionLeaveEnd: transitionLeaveEnd,
        root: {
            ['x-show'](){
                return this.visible;
            },
            ['x-cloak'](){
                return true;
            },
            ['x-transition:enter'](){
                return "transition ease-out duration-500";
            },
            ['x-transition:enter-start'](){
                return this.transitionEnterStart;
            },
            ['x-transition:enter-end'](){
                return this.transitionEnterEnd;
            },
            ['x-transition:leave'](){
                return "transition ease-in duration-300";
            },
            ['x-transition:leave-start'](){
                return this.transitionLeaveStart;
            },
            ['x-transition:leave-end'](){
                return this.transitionLeaveEnd;
            },
        },
        dismissTrigger: {
            ['@click'](){
                return this.dismiss();
            },
        },
        init(){
            setTimeout(()=>{ this.display() }, this.displayAfter);
        },
        display(){
            this.visible = true;
        },
        dismiss(){
            this.visible = false;
        }
    }))


    /*
     *  Calendar
    */
    Alpine.data('calendar', (value, format, max, min) => ({
        calendarValue: value,
        focusedDay: '',
        calendarFormat: format,
        max: max,
        min: min,
        calendarMonth: '',
        calendarYear: '',
        calendarDay: '',
        calendarDaysInMonth: [],
        calendarPreBlankDaysInMonth: [],
        calendarPostBlankDaysInMonth: [],
        calendarMonthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        calendarDays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        root: {
            ['x-init'](){
                let currentDate = new Date();
                if (this.calendarValue) {
                    currentDate = new Date(Date.parse(calendarValue));
                }
                this.calendarMonth = currentDate.getMonth();
                this.calendarYear = currentDate.getFullYear();
                this.calendarDay = currentDate.getDay();
                this.calendarValue = this.calendarFormatDate( currentDate );
                this.focusedDay = currentDate.getDate();
                this.calendarCalculateDays();
                this.selected();
            },
            ['@keydown.left.prevent'](){
                this.calendarFocusAdd(-1)
            },
            ['@keydown.right.prevent'](){
                this.calendarFocusAdd(1)
            },
            ['@keydown.up.prevent'](){
                this.calendarFocusAdd(-this.calendarDays.length)
            },
            ['@keydown.down.prevent'](){
                this.calendarFocusAdd(this.calendarDays.length)
            },
            ['x-transition'](){
                return true;
            },
        },
        previousMonthTrigger: {
            ['@click'](){
                this.calendarPreviousMonth()
            },
        },
        nextMonthTrigger: {
            ['@click'](){
                this.calendarNextMonth()
            }
        },
        yearLabel: {
            ['x-text'](){
                return this.calendarYear
            }
        },
        monthLabel: {
            ['x-text'](){
                return this.calendarMonthNames[this.calendarMonth]
            }
        },
        selected(){
            this.$nextTick(() => {this.$dispatch('selected', {value: this.calendarValue})})
        },
        calendarDayClicked(day) {
            let selectedDate = new Date(this.calendarYear, this.calendarMonth, day);
            this.calendarDay = day;
            this.focusedDay = day;
            this.calendarValue = this.calendarFormatDate(selectedDate);
            this.calendarIsSelectedDate(day);
        },

        calendarFocusAdd(value){
            if(!Number.isInteger(this.focusedDay)){
                this.focusedDay = (new Date(this.calendarYear, this.calendarMonth, day)).getDate();
            }
            this.focusedDay = this.focusedDay + value;
            if(this.focusedDay > this.calendarDaysInMonth.length){
                this.focusedDay = this.focusedDay - this.calendarDaysInMonth.length;
                this.calendarNextMonth();
            }
            else if(this.focusedDay <= 0){
                this.calendarPreviousMonth();
                this.focusedDay = this.calendarDaysInMonth.length + this.focusedDay
            }
        },
        calendarPreviousMonth(){
            if (this.calendarMonth == 0) {
                this.calendarYear--;
                this.calendarMonth = 12;
            }
            this.calendarMonth--;
            this.calendarCalculateDays();
        },
        calendarNextMonth(){
            if (this.calendarMonth == 11) {
                this.calendarMonth = 0;
                this.calendarYear++;
            } else {
                this.calendarMonth++;
            }
            this.calendarCalculateDays();
        },
        calendarIsSelectedDate(day) {
            const d = new Date(this.calendarYear, this.calendarMonth, day);
            return this.calendarValue === this.calendarFormatDate(d) ? true : false;
        },
        calendarIsFocusedDate(day) {
            return this.focusedDay === day ? true : false;
        },
        calendarIsToday(day) {
            const today = new Date();
            const d = new Date(this.calendarYear, this.calendarMonth, day);
            return today.toDateString() === d.toDateString() ? true : false;
        },
        calendarCalculateDays() {
            let daysInMonth = new Date(this.calendarYear, this.calendarMonth + 1, 0).getDate();
            let daysInPreviousMonth = new Date(this.calendarYear, this.calendarMonth, 0).getDate();
            // find where to start calendar day of week
            let dayOfWeek = new Date(this.calendarYear, this.calendarMonth).getDay();
            let preBlankdaysArray = [];
            for (var i = 1; i <= dayOfWeek; i++) {
                preBlankdaysArray.push(daysInPreviousMonth - i);
            }
            //if the length of the preblank arrays is a multiple of the week, it is considered an entire week
            preBlankdaysArray = preBlankdaysArray.reverse();
            let postBlankdaysArray = [];
            // always display 6 rows
            for (var i = 1; i <= (this.calendarDays.length*6 - (preBlankdaysArray.length + daysInMonth)); i++) {
                postBlankdaysArray.push(i);
            }
            let daysArray = [];
            for (var i = 1; i <= daysInMonth; i++) {
                daysArray.push(i);
            }
            this.calendarPreBlankDaysInMonth = preBlankdaysArray;
            this.calendarPostBlankDaysInMonth = postBlankdaysArray;
            this.calendarDaysInMonth = daysArray;
        },

        isMaxValid(){
            return !isNaN(Date.parse(this.max))
        },

        isMinValid(){
            return !isNaN(Date.parse(this.min))
        },

        isDateOutsideRange(day){

            if(this.isMaxValid() && Date.parse(this.max) < day){
                return true;
            }

            if(this.isMinValid() && Date.parse(this.min) > day ){
                return true;
            }

            return false;
        },

      calendarFormatDate(date) {
        let formattedDay = this.calendarDays[date.getDay()];
        let formattedDate = ('0' + date.getDate()).slice(-2); // appends 0 (zero) in single digit date
        let formattedMonth = this.calendarMonthNames[date.getMonth()];
        let formattedMonthShortName = this.calendarMonthNames[date.getMonth()].substring(0, 3);
        let formattedMonthInNumber = ('0' + (parseInt(date.getMonth()) + 1)).slice(-2);
        let formattedYear = date.getFullYear();

        if (this.calendarFormat === 'M d, Y') {
          return `${formattedMonthShortName} ${formattedDate}, ${formattedYear}`;
        }
        if (this.calendarFormat === 'MM-DD-YYYY') {
          return `${formattedMonthInNumber}-${formattedDate}-${formattedYear}`;
        }
        if (this.calendarFormat === 'DD-MM-YYYY') {
          return `${formattedDate}-${formattedMonthInNumber}-${formattedYear}`;
        }
        if (this.calendarFormat === 'YYYY-MM-DD') {
          return `${formattedYear}-${formattedMonthInNumber}-${formattedDate}`;
        }
        if (this.calendarFormat === 'D d M, Y') {
          return `${formattedDay} ${formattedDate} ${formattedMonthShortName} ${formattedYear}`;
        }

        return `${formattedMonth} ${formattedDate}, ${formattedYear}`;
      },
    }))

    /*
     *  Date Picker
    */
    Alpine.data('datePicker', (open, value) => ({
        open: open,
        value: value,
        root: {
            ['x-on:keydown.esc'](){
                return this.closePicker();
            },
            ['x-cloak'](){
                return true;
            },
        },
        input: {
            ['@click'](){
                return this.togglePicker();
            },
            ['@keypress.esc'](){
                return this.closePicker();
            },
            ['@keypress.space'](){
                return this.togglePicker();
            },
            ['x-model'](){
                // wacky
                return () => this.value;
            },
        },
        calendar: {
            ['x-show'](){
                return this.open;
            },
            ['x-cloak'](){
                return true;
            },
            ['x-transition'](){
                return true;
            },
            ['@click.away'](){
                return this.closePicker();
            },
            ['x-anchor.bottom-start.offset.3'](){
                return this.$refs.datePickerInput;
            },
            ['x-trap'](){
                return this.open;
            },
            ['@selected'](){
                return this.value = this.$event.detail.value;
            },
        },
        openPicker(){
            this.open = true
        },
        closePicker(){
            this.open = false
        },
        togglePicker(){
            this.open ? this.closePicker() : this.openPicker()
        },
    }))

    /*
     *  Dialog
    */
    Alpine.data('dialog', (show, dismissable) => ({
        show : show,
        dismissable: dismissable,
        close(){
            this.show = false;
        },
        open(){
            this.show = true;
        },
        root: {
            ['x-on:keydown.esc'](){
                if (this.dismissable) {
                    return this.close();
                }
            },
        },
        trigger: {
            ['@click'](){
                return this.open();
            },
        },
        overlay: {
            ['@click'](){
                if (this.dismissable) {
                    return this.close();
                }
            },
            ['x-show'](){
                return this.show;
            },
            ['x-cloak'](){
                return true;
            },
            ['x-trap.noscroll'](){
                return this.show;
            },
            ['x-transition.opacity'](){
                return true;
            },
        },
        dialog: {
            ['@click.stop'](){
                return true;
            },
        },
        closeButton: {
            ['@click'](){
                if (this.dismissable) {
                    return this.close();
                }
            },
        }
    }))

    /*
     *  Dropdown Menu
    */
    Alpine.data('dropdownMenu',() => ({
        dropdownMenu : false,
        trigger: {
            ['@click'](){
                return this.toggle();
            },
            ['@keydown.escape'](){
                return this.close();
            },
        },
        content: {
            ['x-anchor.offset.4'](){
                return this.$refs.trigger;
            },
            ['@keydown.down.prevent'](){
                return this.$focus.next();
            },
            ['@keydown.up.prevent'](){
                return this.$focus.previous();
            },
            ['@keydown.tab.prevent'](){
                return this.close();
            },
            ['x-trap'](){
                return this.dropdownMenu;
            },
            ['@click.outside'](){
                return this.close();
            },
            ['x-show'](){
                return this.dropdownMenu;
            },
            ['x-transition'](){
                return true;
            },
        },
        menuItem: {
            ['@click'](){
                return this.close();
            },
            ['@mouseover'](){
                return this.$focus.focus(this.$el);
            },
        },
        close(){
            this.dropdownMenu = false;
        },
        open(){
            this.dropdownMenu = true;
        },
        toggle(){
            this.dropdownMenu ? this.close() : this.open()
        }
    }))

    /*
     *  Dropdown Menu Sub Menu
    */
    Alpine.data('dropdownMenuSub',() => ({
        'subOpen' : false,
        'subPreview' : false,
        root: {
            ['@keydown.escape'](){
                return this.close();
            },
            ['@keydown.right'](){
                return this.open();
            },
            ['@keydown.left'](){
                return this.close();
            },
            ['@click.outside'](){
                return this.close();
            },
            [':aria-expanded'](){
                return this.subOpen;
            },
        },
        trigger: {
            ['@click'](){
                return this.toggle();
            },
            ['@mouseover'](){
                this.$el.focus();
                this.openPreview();
            },
            ['@mouseout'](){
                this.$el.focus();
                this.closePreview();
            },
        },
        content: {
            ['x-anchor.left-start.right-start'](){
                return this.$refs.subTrigger;
            },
            ['x-trap.noscroll'](){
                return this.subOpen;
            },
            ['x-show'](){
                return this.subOpen || this.subPreview;
            },
            ['x-transition'](){
                return true;
            },
            ['x-cloak'](){
                return true;
            },
        },
        open(){
            this.subOpen = true
        },
        close(){
            this.subOpen = false
        },
        toggle(){
            this.subOpen == true ? this.close() : this.open()
        },
        openPreview(){
            this.subPreview = true;
        },
        closePreview(){
            this.subPreview = false;
        }
    }))

    /*
     *  Popover
    */
    Alpine.data('popover',() => ({
        popover : false,
        trigger: {
            ['@click'](){
                return this.toggle();
            },
            ['@keydown.escape'](){
                return this.close();
            },
        },
        content: {
            ['x-anchor.offset.4'](){
                return this.$refs.trigger;
            },
            ['@keydown.tab.prevent'](){
                return this.close();
            },
            ['x-trap.noscroll'](){
                return this.popover;
            },
            ['@click.outside'](){
                return this.close();
            },
            ['x-show'](){
                return this.popover;
            },
            ['x-transition'](){
                return true;
            },
        },
        close(){
            this.popover = false;
        },
        open(){
            this.popover = true;
        },
        toggle(){
            this.popover == true ? this.close() : this.open()
        }
    }))

    /*
     *  Select
    */
    Alpine.data('select',(multiple, disabled) => ({
        options: [],
        selected: [],
        multiple: multiple,
        disabled: disabled,
        show: false,
        root: {
            ['x-on:keydown.tab'](){
                return this.close();
            },
            ['x-on:keydown.escape'](){
                return this.close();
            },
        },
        trigger: {
            ['@click'](){
                return this.open();
            },
            [':disabled'](){
                return this.disabled;
            },
        },
        optionList: {
            ['x-show.transition.scale.origin.top'](){
                return this.show;
            },
            ['x-on:click.away'](){
                return this.close();
            },
            ['x-trap.noscroll'](){
                return this.show;
            },
            ['x-anchor'](){
                return this.$refs.select;
            },
            ['x-on:keydown.up.prevent'](){
                return this.$focus.wrap().previous();
            },
            ['x-on:keydown.down.prevent'](){
                return this.$focus.wrap().next();
            },
        },
        init(){
            this.loadOptions();
        },
        open(){
            if(!this.disabled){
                this.show = true
            }
        },
        isOpen(){
            return this.show
        },
        close(){
            this.show = false
        },
        select(index, event) {
            if (!this.options[index].selected || !this.multiple) {
                if(!this.multiple){
                    for(let i = 0; i < this.selected.length; i++){
                        this.options[this.selected[i]].selected = false;
                    }
                    this.selected.length = 0;
                }
                this.options[index].selected = true;
                this.options[index].element = event.target;
                this.selected.push(index);
            } else {
                this.selected.splice(this.selected.lastIndexOf(index), 1);
                this.options[index].selected = false
            }
        },
        remove(index, option) {
            this.options[option].selected = false;
            this.selected.splice(index, 1);
        },
        loadOptions() {
            const options = this.$root.childNodes[1].options;
            let lastSelected = 0;
            for (let i = 0; i < options.length; i++) {
                this.options.push({
                    value: options[i].value,
                    text: options[i].innerText,
                    selected: options[i].getAttribute('selected') != null || i == 0 ? true && this.selected.push(i)  : false,
                });
                if(!this.multiple && options[i].getAttribute('selected') != null){
                    this.options[lastSelected].selected = false;
                    lastSelected = i;
                }
            }
        },
        selectedValues(){
            return this.selected.map((option)=>{
                return this.options[option].value;
            })
        }
    }))

    /*
     *  Switch
    */
    Alpine.data('switchInput', (checked, disabled ,checkedLabelText, uncheckedLabelText) => ({
        switchOn: checked,
        labelText: null,
        disabled: disabled,
        input: {
            [':checked'](){
                return this.switchOn;
            },
        },
        trigger: {
            ['@click'](){
                return this.toggle()
            },
            ['x-cloak'](){
                return true;
            },
        },
        label: {
            ['@click'](){
                this.$refs.trigger.click();
                this.$refs.trigger.focus()
            },
            ['x-cloak'](){
                return true;
            },
            ['x-effect'](){
                return this.switchOn ? this.labelText =  checkedLabelText : this.labelText = uncheckedLabelText ;
            },
            ['x-text'](){
                return this.labelText;
            },
        },
        toggle(){
            if (this.disabled) {
                return;
            }
            return this.switchOn = !this.switchOn;
        }
    }))
})
