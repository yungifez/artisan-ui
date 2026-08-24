export default class Matcher {
    constructor(rule) {
        this.type = this.determineMatcherType(rule)
        this.rule = rule;
    }

    passes(date) {
        date = this.createDateWithoutTime(date)
        if (!date || !this.rule || typeof this.rule === 'function') {
            return typeof this.rule === 'function' ? !!this.rule(date) : false
        }
        if (this.type == 'dates') {
            const dates = Array.isArray(this.rule) ? this.rule : (this.rule.dates ? this.rule.dates : [this.rule])
            return dates.some(element => {
                const candidate = this.createDateWithoutTime(element)
                return candidate && date.getTime() == candidate.getTime()
            });
        } else if (this.type == 'range') {
            if (this.rule.before != null && date.getTime() < this.createDateWithoutTime(this.rule.before).getTime()) {
                return true
            }
            if (this.rule.after != null && date.getTime() > this.createDateWithoutTime(this.rule.after).getTime()) {
                return true
            }

            return false
        } else if (this.type == 'dayOfWeek') {
            if (typeof this.rule.dayOfWeek == 'number') {
               return date.getDay() == this.rule.dayOfWeek
            }else{
                return this.rule.dayOfWeek.includes(date.getDay())
            }
        }

        return false
    }

    determineMatcherType(rule) {
        if (typeof rule === 'function') return 'function'
        if (typeof rule === 'string' || rule instanceof Date) return 'dates'
        if (!rule || typeof rule !== 'object') return undefined
        if (Array.isArray(rule)) return 'dates'
        if (rule.dates != undefined && Array.isArray(rule.dates)) {
            return "dates"
        } else if (rule.before != undefined || rule.after != undefined) {
            return "range"
        } else if (rule.dayOfWeek != undefined) {
            return "dayOfWeek"
        }
    }

    createDateWithoutTime(value) {
        if (value == null || value === '') return null
        let date = typeof value === 'string' && /^\d{4}-\d{2}-\d{2}/.test(value)
            ? new Date(Number(value.slice(0, 4)), Number(value.slice(5, 7)) - 1, Number(value.slice(8, 10)))
            : new Date(value)
        date.setHours(0,0,0,0);

        return Number.isNaN(date.getTime()) ? null : date;
    }
}
