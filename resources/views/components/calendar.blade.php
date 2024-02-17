@props([ 'value' => '', 'format' => 'M d, h', 'onselect' => '', "max" => "", "min" => "" ])
<div
x-data="{
      calendarValue: '{{$value}}',
      calendarFormat: '{{$format}}',
      max: '{{$max}}',
      min: '{{$min}}',
      calendarMonth: '',
      calendarYear: '',
      calendarDay: '',
      calendarDaysInMonth: [],
      calendarPreBlankDaysInMonth: [],
      calendarPostBlankDaysInMonth: [],
      calendarMonthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      calendarDays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
      selected(){
        {{$onselect}}
      },

      calendarDayClicked(day) {
        let selectedDate = new Date(this.calendarYear, this.calendarMonth, day);
        this.calendarDay = day;
        this.calendarValue = this.calendarFormatDate(selectedDate);
        this.calendarIsSelectedDate(day);
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
        for (var i = 0; i <= dayOfWeek; i++) {
            preBlankdaysArray.push(daysInPreviousMonth - i);
        }
        //if the length of the preblank arrays is a multiple of the week, it is considered an entire week
        preBlankdaysArray = preBlankdaysArray.reverse();
        let postBlankdaysArray = [];
        for (var i = 1; i <= (42 - (preBlankdaysArray.length + daysInMonth)); i++) {
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
    }"
    x-init="
        currentDate = new Date();
        if (calendarValue) {
            currentDate = new Date(Date.parse(calendarValue));
        }
        calendarMonth = currentDate.getMonth();
        calendarYear = currentDate.getFullYear();
        calendarDay = currentDate.getDay();
        calendarValue = calendarFormatDate( currentDate );
        selected()
        calendarCalculateDays();
    "
    x-transition
    x-modelable="calendarValue"
    class=" top-0 left-0 max-w-lg p-4 antialiased bg-white dark:bg-black border rounded-lg shadow w-[17rem] border-neutral-200/70">
    <div class="flex items-center justify-between mb-3">
        <button @click="calendarPreviousMonth()" type="button" class="border inline-flex p-1 transition duration-100 ease-in-out rounded-lg cursor-pointer focus:outline-none focus:shadow-outline hover:bg-gray-100 dark:hover:bg-opacity-10">
            <svg class="inline-flex w-6 h-6 text-gray-400 dark:text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </button>
        <div>
            <span x-text="calendarMonthNames[calendarMonth]" class="text-lg font-bold text-gray-800 dark:text-gray-100"></span>
            <span x-text="calendarYear" class="ml-1 text-lg font-normal text-gray-600 dark:text-gray-100"></span>
        </div>
        <button @click="calendarNextMonth()" type="button" class="border inline-flex p-1 transition duration-100 ease-in-out rounded-lg cursor-pointer focus:outline-none focus:shadow-outline hover:bg-gray-100 dark:hover:bg-opacity-10" >
            <svg class="inline-flex w-6 h-6 text-gray-400 dark:text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </button>
    </div>
    <div class="grid grid-cols-7 mb-3">
        <template x-for="(day, index) in calendarDays" :key="index">
            <div class="px-0.5">
                <div x-text="day" class="text-xs font-medium text-center text-gray-800 dark:text-gray-100"></div>
            </div>
        </template>
    </div>
    <div class="grid grid-cols-7">
        <template x-for="blankDay in calendarPreBlankDaysInMonth">
                <div
                    x-text="blankDay"
                    class="text-gray-400 flex items-center justify-center text-sm leading-none text-center rounded-md cursor-pointer h-7 w-7"></div>
            </div>
        </template>
        <template x-for="(day, dayIndex) in calendarDaysInMonth" :key="dayIndex">
            <div class="px-0.5 mb-1 aspect-square">
                <div
                    x-text="day"
                    @click="isDateOutsideRange(new Date(calendarYear, calendarMonth, day)) || calendarDayClicked(day); selected()"
                    :class="{
                        'bg-neutral-200 dark:bg-neutral-200': calendarIsToday(day) == true && !isDateOutsideRange(new Date(calendarYear, calendarMonth, day)),
                        'text-gray-600 dark:text-gray-200 hover:bg-neutral-200 dark:hover:text-gray-900': calendarIsToday(day) == false && calendarIsSelectedDate(day) == false && !isDateOutsideRange(new Date(calendarYear, calendarMonth, day)),
                        'bg-neutral-800 dark:text-gray-500 dark:bg-white text-white hover:bg-opacity-75': calendarIsSelectedDate(day) == true && !isDateOutsideRange(new Date(calendarYear, calendarMonth, day)),
                        'text-gray-400': isDateOutsideRange(new Date(calendarYear, calendarMonth, day))
                    }"
                    class="flex items-center justify-center text-sm leading-none text-center rounded-md cursor-pointer h-7 w-7"></div>
            </div>
        </template>
        <template x-for="blankDay in calendarPostBlankDaysInMonth">
                <div
                    x-text="blankDay"
                    class="mb-1 text-gray-400 flex items-center justify-center text-sm leading-none text-center rounded-md cursor-pointer h-7 w-7"></div>
            </div>
        </template>
    </div>
</div>
