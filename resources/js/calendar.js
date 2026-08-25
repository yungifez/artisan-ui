import Matcher from "./Calendar/Matcher"
import MultipleModeHandler from "./Calendar/ModeHandlers/MultipleModeHandler"
import RangeModeHandler from "./Calendar/ModeHandlers/RangeModeHandler"
import SingleModeHandler from "./Calendar/ModeHandlers/SingleModeHandler"

const dateWithoutTime = (value) => {
    if (value == null || value === '') return null
    if (value instanceof Date) {
        const date = new Date(value.getTime())
        date.setHours(0, 0, 0, 0)
        return Number.isNaN(date.getTime()) ? null : date
    }
    if (typeof value === 'string' && /^\d{4}-\d{2}-\d{2}/.test(value)) {
        const [year, month, day] = value.slice(0, 10).split('-').map(Number)
        return new Date(year, month - 1, day)
    }
    const date = new Date(value)
    date.setHours(0, 0, 0, 0)
    return Number.isNaN(date.getTime()) ? null : date
}

const dateKey = (date) => {
    const normalized = dateWithoutTime(date)
    if (!normalized) return ''
    const year = normalized.getFullYear()
    const month = String(normalized.getMonth() + 1).padStart(2, '0')
    const day = String(normalized.getDate()).padStart(2, '0')
    return `${year}-${month}-${day}`
}

export default (selected, mode, disabled, min, max, required, options = {}) => ({
    focusedDay: '',
    focusedDate: '',
    mode: ['single', 'multiple', 'range'].includes(mode) ? mode : 'single',
    max,
    min,
    month: '',
    year: '',
    daysInMonth: [],
    preBlankDaysInMonth: [],
    postBlankDaysInMonth: [],
    modeHandler: null,
    disabled: [],
    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
    dayNames: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
    days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
    showOutsideDays: options.showOutsideDays !== false,
    fixedWeeks: options.fixedWeeks !== false,
    showWeekNumber: options.showWeekNumber === true,
    captionLayout: options.captionLayout || 'label',
    numberOfMonths: Math.min(12, Math.max(1, Number(options.numberOfMonths) || 1)),
    pagedNavigation: options.pagedNavigation === true,
    weekStartsOn: Math.min(6, Math.max(0, Number(options.weekStartsOn) || 0)),
    hideNavigation: options.hideNavigation === true,
    fromYear: options.fromYear == null ? null : Number(options.fromYear),
    toYear: options.toYear == null ? null : Number(options.toYear),
    fromMonth: options.fromMonth || options.startMonth || null,
    toMonth: options.toMonth || options.endMonth || null,
    defaultMonth: options.defaultMonth || null,
    root: {
        ['@keydown.left.prevent']() { this.focusAdd(-1) },
        ['@keydown.right.prevent']() { this.focusAdd(1) },
        ['@keydown.up.prevent']() { this.focusAdd(-7) },
        ['@keydown.down.prevent']() { this.focusAdd(7) },
        ['@keydown.home.prevent']() { this.focusAdd(-this.dayOfWeek(this.focusedDate)) },
        ['@keydown.end.prevent']() { this.focusAdd(6 - this.dayOfWeek(this.focusedDate)) },
        ['@keydown.page-up.prevent']() { this.moveMonth(-1) },
        ['@keydown.page-down.prevent']() { this.moveMonth(1) },
        ['x-transition']() { return true },
    },
    previousMonthTrigger: {
        [':disabled']() { return this.isNavigationDisabled('previous') },
        ['@click']() { this.previousMonth() },
    },
    nextMonthTrigger: {
        [':disabled']() { return this.isNavigationDisabled('next') },
        ['@click']() { this.nextMonth() },
    },
    yearLabel: { ['x-text']() { return this.year } },
    monthLabel: { ['x-text']() { return this.monthNames[this.month] } },
    init() {
        if (this.mode === 'single') {
            this.modeHandler = new SingleModeHandler(selected, required)
        } else if (this.mode === 'multiple') {
            this.modeHandler = new MultipleModeHandler(selected, required, min, max)
        } else {
            this.modeHandler = new RangeModeHandler(selected || {}, required, min, max)
        }

        const rules = Array.isArray(disabled) ? disabled : (disabled == null ? [] : [disabled])
        this.disabled = rules.map((rule) => new Matcher(rule))

        const initialDate = this.initialDate()
        this.month = initialDate.getMonth()
        this.year = initialDate.getFullYear()
        this.updateFocusedDate(initialDate)
        this.calculateDays()

        if (selected) this.dispatchChange()
    },
    initialDate() {
        return dateWithoutTime(this.defaultMonth) || this.selectedDate() || new Date()
    },
    selectedDate() {
        if (this.mode === 'multiple') return dateWithoutTime(Array.isArray(selected) ? selected[0] : null)
        if (this.mode === 'range') return dateWithoutTime(selected?.from)
        return dateWithoutTime(selected)
    },
    dispatchChange() {
        this.$nextTick(() => {
            const detail = { value: this.modeHandler.value }
            this.$dispatch('change', detail)
            this.$dispatch('select', detail)
        })
    },
    dayClicked(date) {
        const selectedDate = dateWithoutTime(date)
        if (!selectedDate || this.isDisabled(selectedDate)) return

        this.updateFocusedDate(selectedDate)
        if (!this.isDateInView(selectedDate)) {
            this.month = selectedDate.getMonth()
            this.year = selectedDate.getFullYear()
            this.calculateDays()
        }
        if (this.modeHandler.dayClicked(selectedDate)) this.dispatchChange()
    },
    updateFocusedDate(date) {
        const normalized = dateWithoutTime(date)
        this.focusedDate = dateKey(normalized)
        this.focusedDay = normalized?.getDate() || ''
    },
    focusAdd(value) {
        const current = dateWithoutTime(this.focusedDate) || new Date(this.year, this.month, this.focusedDay || 1)
        current.setDate(current.getDate() + value)
        this.updateFocusedDate(current)
        if (!this.isDateInView(current)) {
            this.month = current.getMonth()
            this.year = current.getFullYear()
            this.calculateDays()
        }
    },
    dayOfWeek(value) { return dateWithoutTime(value)?.getDay() || 0 },
    isDateInView(date) {
        const normalized = dateWithoutTime(date)
        if (!normalized) return false

        const first = new Date(this.year, this.month, 1)
        const last = new Date(this.year, this.month + this.numberOfMonths, 0)

        return normalized >= first && normalized <= last
    },
    moveMonth(amount) {
        const step = this.pagedNavigation ? this.numberOfMonths : 1
        const target = new Date(this.year, this.month + (amount * step), 1)
        const end = new Date(target.getFullYear(), target.getMonth() + this.numberOfMonths - 1, 1)
        if (target < this.firstAllowedMonth() || end > this.lastAllowedMonth()) return
        this.month = target.getMonth()
        this.year = target.getFullYear()
        this.calculateDays()
    },
    previousMonth() { this.moveMonth(-1) },
    nextMonth() { this.moveMonth(1) },
    setViewMonth(month) { this.month = Number(month); this.calculateDays() },
    setViewYear(year) {
        const nextYear = Number(year)
        if (this.yearOptions().includes(nextYear)) {
            this.year = nextYear
            this.calculateDays()
        }
    },
    isNavigationDisabled(direction) {
        const step = this.pagedNavigation ? this.numberOfMonths : 1
        const target = new Date(this.year, this.month + (direction === 'previous' ? -step : step), 1)
        const end = new Date(target.getFullYear(), target.getMonth() + this.numberOfMonths - 1, 1)
        return target < this.firstAllowedMonth() || end > this.lastAllowedMonth()
    },
    firstAllowedMonth() {
        const configured = dateWithoutTime(this.fromMonth)
        const year = this.fromYear == null ? new Date(-8640000000000000) : new Date(this.fromYear, 0, 1)
        return configured && configured > year ? new Date(configured.getFullYear(), configured.getMonth(), 1) : year
    },
    lastAllowedMonth() {
        const configured = dateWithoutTime(this.toMonth)
        const year = this.toYear == null ? new Date(8640000000000000) : new Date(this.toYear, 11, 1)
        return configured && configured < year ? new Date(configured.getFullYear(), configured.getMonth(), 1) : year
    },
    isSelectedDay(day) { return this.isSelectedDate(new Date(this.year, this.month, day)) },
    isSelectedDate(date) { return this.modeHandler?.isSelectedDay(dateWithoutTime(date)) || false },
    isFocusedDate(date) { return this.focusedDate === dateKey(date) },
    isToday(date) {
        const today = dateWithoutTime(new Date())
        const current = dateWithoutTime(date)
        return !!today && !!current && today.getTime() === current.getTime()
    },
    calculateDays() {
        const view = this.monthData(this.year, this.month)
        const first = new Date(this.year, this.month, 1)
        const last = new Date(this.year, this.month + 1, 0)
        this.daysInMonth = view.cells.filter((cell) => !cell.outside).map((cell) => cell.day)
        this.preBlankDaysInMonth = view.cells.filter((cell) => cell.outside && cell.date < first).map((cell) => cell.day)
        this.postBlankDaysInMonth = view.cells.filter((cell) => cell.outside && cell.date > last).map((cell) => cell.day)
        this.days = view.weekdays
    },
    get monthViews() {
        return Array.from({ length: this.numberOfMonths }, (_, index) => {
            const date = new Date(this.year, this.month + index, 1)
            return this.monthData(date.getFullYear(), date.getMonth())
        })
    },
    monthData(year, month) {
        const daysInMonth = new Date(year, month + 1, 0).getDate()
        const firstDay = new Date(year, month, 1).getDay()
        const leading = (firstDay - this.weekStartsOn + 7) % 7
        const weekCount = this.fixedWeeks ? 6 : Math.ceil((leading + daysInMonth) / 7)
        const cells = []

        for (let index = 0; index < weekCount * 7; index++) {
            const date = new Date(year, month, 1 - leading + index)
            cells.push({ date, day: date.getDate(), outside: date.getMonth() !== month, key: dateKey(date) })
        }

        const weeks = []
        for (let index = 0; index < cells.length; index += 7) {
            const week = cells.slice(index, index + 7)
            weeks.push({ cells: week, weekNumber: this.weekNumber(week[0].date) })
        }

        return {
            key: `${year}-${month}`,
            label: `${this.monthNames[month]} ${year}`,
            weekdays: this.dayNames.slice(this.weekStartsOn).concat(this.dayNames.slice(0, this.weekStartsOn)),
            cells,
            weeks,
        }
    },
    weekNumber(date) {
        const current = new Date(dateWithoutTime(date))
        current.setDate(current.getDate() + 4 - (current.getDay() || 7))
        const yearStart = new Date(current.getFullYear(), 0, 1)
        return Math.ceil((((current - yearStart) / 86400000) + 1) / 7)
    },
    yearOptions() {
        const start = this.fromYear ?? this.year - 100
        const end = this.toYear ?? this.year + 100
        return Array.from({ length: Math.max(1, end - start + 1) }, (_, index) => start + index)
    },
    isDisabled(date) {
        const normalized = dateWithoutTime(date)
        return !normalized || this.disabled.some((rule) => rule.passes(normalized)) || !!this.modeHandler?.isDisabled(normalized)
    },
    isRangeMiddle(date) {
        const normalized = dateWithoutTime(date)
        const from = this.modeHandler?.value?.from
        const to = this.modeHandler?.value?.to
        return this.mode === 'range' && !!from && !!to && normalized > from && normalized < to
    },
    isRangeStart(date) { return this.mode === 'range' && this.modeHandler?.value?.from?.getTime() === dateWithoutTime(date)?.getTime() },
    isRangeEnd(date) { return this.mode === 'range' && this.modeHandler?.value?.to?.getTime() === dateWithoutTime(date)?.getTime() },
    formatAriaDate(date) {
        return dateWithoutTime(date)?.toLocaleDateString(undefined, { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' }) || 'Invalid date'
    },
})
