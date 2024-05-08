@props([ 'value' => '', 'format' => 'M d, h', 'onselect' => '', "max" => "", "min" => "" ])
<div x-data="calendar('{{$value}}', '{{$format}}', '{{$min}}', '{{$max}}')" x-bind="root" {{$attributes->class([' p-4
    antialiased bg-background border-input border rounded-lg shadow w-[17rem]'])}}
    >
    <div class="flex items-center justify-between mb-3">
        <button x-bind="previousMonthTrigger" type="button"
            class="border dark:border-input inline-flex p-1 transition duration-100 ease-in-out rounded-lg focus:shadow-outline hover:bg-gray-100 dark:hover:bg-opacity-10">
            <x-aui::angle-down class="inline-flex w-6 h-6 fill-foreground rotate-90" />
        </button>
        <div>
            <span x-bind="monthLabel" class="text-lg font-bold text-gray-800 dark:text-gray-100"></span>
            <span x-bind="yearLabel" class="ml-1 text-lg font-normal text-gray-600 dark:text-gray-100"></span>
        </div>
        <button x-bind="nextMonthTrigger" type="button"
            class="border dark:border-border inline-flex p-1 transition duration-100 ease-in-out rounded-lg focus:shadow-outline hover:bg-gray-100 dark:hover:bg-opacity-10">
            <x-aui::angle-down class="inline-flex w-6 h-6 fill-foreground -rotate-90" />
        </button>
    </div>
    {{--display days of the week--}}
    <div class="grid grid-cols-7 mb-3">
        <template x-for="(day, index) in calendarDays">
            <div class="px-0.5">
                <div x-text="day" class="text-xs font-medium text-center text-gray-800 dark:text-gray-100"></div>
            </div>
        </template>
    </div>
    <div class="grid grid-cols-7">
        <template x-for="blankDay in calendarPreBlankDaysInMonth">
            <div x-text="blankDay"
                x-effect="focusedDay == blankDay && ($root.contains($focus.focused())) && $el.focus({preventScroll: true})"
                class="text-muted-foreground opacity-50 aria-selected:bg-accent/50 aria-selected:text-muted-foreground aria-selected:opacity-30 flex items-center justify-center text-sm leading-none text-center rounded-md cursor-pointer h-8 w-8">
            </div>
        </template>
        <template x-for="(day, dayIndex) in calendarDaysInMonth" :key="dayIndex">
            <button tabindex="-1"
                x-effect="focusedDay == day && ($root.contains($focus.focused()))  && $el.focus({preventScroll: true})"
                x-text="day"
                @click="isDateOutsideRange(new Date(calendarYear, calendarMonth, day)) || calendarDayClicked(day); selected()"
                :class="{
                        'bg-accent text-accent-foreground': calendarIsToday(day) == true && calendarIsSelectedDate(day) == false && !isDateOutsideRange(new Date(calendarYear, calendarMonth, day)),
                        'text-foreground hover:bg-accent': calendarIsToday(day) == false && calendarIsSelectedDate(day) == false && !isDateOutsideRange(new Date(calendarYear, calendarMonth, day)),
                        'bg-primary text-primary-foreground hover:bg-primary hover:text-primary-foreground focus:bg-primary focus:text-primary-foreground' : calendarIsSelectedDate(day) == true && !isDateOutsideRange(new Date(calendarYear, calendarMonth, day)),
                        'text-muted-foreground opacity-50 aria-selected:bg-accent/50 aria-selected:text-muted-foreground aria-selected:opacity-30': isDateOutsideRange(new Date(calendarYear, calendarMonth, day)),
                        'border-black dark:border-white' : calendarIsFocusedDate(day)
                    }"
                class="flex items-center justify-center text-sm leading-none text-center rounded-md cursor-pointer px-0.5 aspect-square h-8 w-8 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring focus-visible:ring-offset-1">
            </button>
        </template>
        <template x-for="blankDay in calendarPostBlankDaysInMonth">
            <div x-text="blankDay"
                x-effect="focusedDay == blankDay && ($root.contains($focus.focused())) && $el.focus({preventScroll: true})"
                class="day-outside text-muted-foreground opacity-50 aria-selected:bg-accent/50 aria-selected:text-muted-foreground aria-selected:opacity-30 flex items-center justify-center text-sm leading-none text-center rounded-md cursor-pointer h-8 w-8">
            </div>
        </template>
    </div>
</div>
