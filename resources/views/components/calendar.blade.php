@props([
    'selected' => '',
    'mode' => 'single',
    'max' => null,
    'min' => null,
    'disabled' => null,
    'required' => false,
    'captionLayout' => 'label',
    'showOutsideDays' => true,
    'fixedWeeks' => true,
    'showWeekNumber' => false,
    'weekStartsOn' => 0,
    'numberOfMonths' => 1,
    'pagedNavigation' => false,
    'hideNavigation' => false,
    'fromYear' => null,
    'toYear' => null,
    'fromMonth' => null,
    'toMonth' => null,
    'startMonth' => null,
    'endMonth' => null,
    'defaultMonth' => null,
])

@php
    $calendarMonths = max(1, min(12, (int) $numberOfMonths));
    $calendarWidth = $calendarMonths > 1
        ? 'w-full max-w-full sm:w-[min(38rem,100%)]'
        : 'w-[19rem] max-w-full';
    $calendarMonthWidth = $calendarMonths > 2 ? 'sm:min-w-[19rem]' : '';
    $calendarMonthsOverflow = $calendarMonths > 1 ? 'sm:overflow-x-auto' : '';

    $calendarOptions = [
        'captionLayout' => $captionLayout,
        'showOutsideDays' => filter_var($showOutsideDays, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) ?? true,
        'fixedWeeks' => filter_var($fixedWeeks, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) ?? true,
        'showWeekNumber' => filter_var($showWeekNumber, FILTER_VALIDATE_BOOL),
        'weekStartsOn' => (int) $weekStartsOn,
        'numberOfMonths' => (int) $numberOfMonths,
        'pagedNavigation' => filter_var($pagedNavigation, FILTER_VALIDATE_BOOL),
        'hideNavigation' => filter_var($hideNavigation, FILTER_VALIDATE_BOOL),
        'fromYear' => $fromYear,
        'toYear' => $toYear,
        'fromMonth' => $fromMonth ?: $startMonth,
        'toMonth' => $toMonth ?: $endMonth,
        'defaultMonth' => $defaultMonth,
    ];
@endphp

<div data-slot="calendar" data-calendar-months="{{ $calendarMonths }}" role="grid" aria-label="Calendar" tabindex="{{ $attributes->get('tabindex', 0) }}"
    x-data="calendar({{ \Illuminate\Support\Js::from($selected) }}, {{ \Illuminate\Support\Js::from($mode) }}, {{ \Illuminate\Support\Js::from($disabled) }}, {{ \Illuminate\Support\Js::from($min) }}, {{ \Illuminate\Support\Js::from($max) }}, {{ \Illuminate\Support\Js::from($required) }}, {{ \Illuminate\Support\Js::from($calendarOptions) }})"
    x-bind="root" {{ $attributes->except('tabindex')->twMerge([
        "p-4 antialiased bg-background border-input border rounded-lg shadow {$calendarWidth} min-w-0 min-h-[19rem] overflow-hidden",
    ]) }} x-modelable="value">
    <div data-slot="calendar-caption" class="flex min-w-0 items-center justify-between gap-1 mb-3 max-[360px]:grid max-[360px]:grid-cols-[auto_minmax(0,1fr)_auto] max-[360px]:gap-2">
        <button x-bind="previousMonthTrigger" x-show="!hideNavigation" type="button" aria-label="Previous month"
            class="border dark:border-input inline-flex shrink-0 p-2 sm:p-3 transition duration-100 ease-in-out rounded-lg focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring hover:bg-accent disabled:pointer-events-none disabled:opacity-50 max-[360px]:col-start-1 max-[360px]:row-start-2">
            <april:angle-down class="inline-flex h-5 w-5 sm:h-6 sm:w-6 fill-foreground rotate-90" />
        </button>

        <div class="flex min-w-0 flex-1 items-center justify-center gap-1 max-[360px]:col-span-3 max-[360px]:row-start-1 max-[360px]:w-full">
            <span x-show="numberOfMonths === 1 && (captionLayout === 'label' || captionLayout === 'dropdown-years')" x-bind="monthLabel"
                class="cursor-default select-none text-lg font-bold text-gray-800 dark:text-gray-100"></span>
            <span x-show="numberOfMonths === 1 && (captionLayout === 'label' || captionLayout === 'dropdown-months')" x-bind="yearLabel"
                class="ml-1 cursor-default select-none text-lg font-normal text-gray-600 dark:text-gray-100"></span>

            <select x-show="captionLayout === 'dropdown' || captionLayout === 'dropdown-months'"
                :value="month" @change="setViewMonth($event.target.value)" aria-label="Select month"
                class="h-9 min-w-0 max-w-full rounded-md border border-input bg-background px-1 text-xs font-medium focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring max-[360px]:w-0 max-[360px]:flex-1 sm:px-2 sm:text-sm">
                <template x-for="(name, index) in monthNames" :key="index">
                    <option :value="index" x-text="name"></option>
                </template>
            </select>
            <select x-show="captionLayout === 'dropdown' || captionLayout === 'dropdown-years'"
                :value="year" @change="setViewYear($event.target.value)" aria-label="Select year"
                class="h-9 min-w-0 max-w-full rounded-md border border-input bg-background px-1 text-xs font-medium focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring max-[360px]:w-0 max-[360px]:flex-1 sm:px-2 sm:text-sm">
                <template x-for="option in yearOptions()" :key="option">
                    <option :value="option" x-text="option"></option>
                </template>
            </select>
        </div>

        <button x-bind="nextMonthTrigger" x-show="!hideNavigation" type="button" aria-label="Next month"
            class="border dark:border-border inline-flex shrink-0 p-2 sm:p-3 transition duration-100 ease-in-out rounded-lg focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring hover:bg-accent disabled:pointer-events-none disabled:opacity-50 max-[360px]:col-start-3 max-[360px]:row-start-2 max-[360px]:justify-self-end">
            <april:angle-down class="inline-flex h-5 w-5 sm:h-6 sm:w-6 fill-foreground -rotate-90" />
        </button>
    </div>

    <div data-slot="calendar-months" class="flex flex-col gap-4 sm:flex-row {{ $calendarMonthsOverflow }}">
        <template x-for="monthView in monthViews" :key="monthView.key">
            <section data-slot="calendar-month" :aria-label="monthView.label" class="min-w-0 flex-1 space-y-2 {{ $calendarMonthWidth }}">
                <h3 x-show="numberOfMonths > 1" x-text="monthView.label"
                    class="text-sm font-medium text-center text-foreground"></h3>
                <div :class="showWeekNumber ? 'grid grid-cols-8' : 'grid grid-cols-7'" role="row">
                    <template x-if="showWeekNumber">
                        <div class="px-0.5" role="columnheader">
                            <div class="text-xs font-medium text-center text-muted-foreground">Wk</div>
                        </div>
                    </template>
                    <template x-for="(day, index) in monthView.weekdays" :key="index">
                        <div class="px-0.5" role="columnheader">
                            <div x-text="day" class="text-xs font-medium text-center text-muted-foreground"></div>
                        </div>
                    </template>
                </div>

                <div role="rowgroup" class="space-y-1">
                    <template x-for="(week, weekIndex) in monthView.weeks" :key="`${monthView.key}-${weekIndex}`">
                        <div :class="showWeekNumber ? 'grid grid-cols-8' : 'grid grid-cols-7'" role="row">
                            <template x-if="showWeekNumber">
                                <div role="rowheader" class="flex items-center justify-center text-xs text-muted-foreground"
                                    x-text="week.weekNumber"></div>
                            </template>
                            <template x-for="cell in week.cells" :key="cell.key">
                                <div class="contents">
                                    <div x-show="cell.outside && !showOutsideDays" aria-hidden="true" class="aspect-square"></div>
                                    <button type="button" role="gridcell"
                                        x-show="!cell.outside || showOutsideDays"
                                        :tabindex="isFocusedDate(cell.date) ? 0 : -1"
                                        :aria-selected="isSelectedDate(cell.date)"
                                        :aria-current="isToday(cell.date) ? 'date' : null"
                                        :aria-label="formatAriaDate(cell.date)" :data-day="cell.day"
                                        :data-outside="cell.outside ? '' : null" :disabled="isDisabled(cell.date)"
                                        @click="dayClicked(cell.date)"
                                        x-effect="isFocusedDate(cell.date) && ($root.contains($focus.focused())) && $el.focus({preventScroll: true})"
                                        x-text="cell.day" :class="{
                                            'text-muted-foreground opacity-50': cell.outside,
                                            'bg-accent text-accent-foreground': isToday(cell.date) && !isSelectedDate(cell.date) && !isDisabled(cell.date),
                                            'text-foreground hover:bg-accent': !isToday(cell.date) && !isSelectedDate(cell.date) && !isDisabled(cell.date),
                                            'bg-primary text-primary-foreground hover:bg-primary focus:bg-primary': isSelectedDate(cell.date) && !isDisabled(cell.date),
                                            'opacity-50 cursor-not-allowed': isDisabled(cell.date),
                                            'ring-1 ring-ring': isFocusedDate(cell.date),
                                            'bg-accent text-accent-foreground': isRangeMiddle(cell.date),
                                            'rounded-l-md': isRangeStart(cell.date),
                                            'rounded-r-md': isRangeEnd(cell.date),
                                        }"
                                        class="flex items-center justify-center text-sm leading-none text-center rounded-md cursor-pointer px-0.5 aspect-square w-auto focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring focus-visible:ring-offset-1 disabled:pointer-events-none">
                                    </button>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </section>
        </template>
    </div>
</div>
