const number = (value) => {
    const result = Number(value);

    return Number.isFinite(result) ? result : 0;
};

const humanize = (value) => String(value)
    .replace(/([a-z])([A-Z])/g, '$1 $2')
    .replace(/[-_]/g, ' ')
    .replace(/^./, (letter) => letter.toUpperCase());

const escape = (value) => String(value).replace(/[&<>"']/g, (character) => ({
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;',
}[character]));

export default (data = [], config = {}, type = 'bar', xKey = '', height = 240) => ({
    data: Array.isArray(data) ? data : [],
    config: config && typeof config === 'object' ? config : {},
    type: ['bar', 'line', 'area'].includes(type) ? type : 'bar',
    xKey: xKey || '',
    height: Math.max(160, number(height)),
    width: 640,
    activeIndex: null,
    resizeObserver: null,

    root: {
        ['@keydown.right.prevent']() {
            this.moveActive(1);
        },
        ['@keydown.left.prevent']() {
            this.moveActive(-1);
        },
        ['@keydown.home.prevent']() {
            this.setActive(0);
        },
        ['@keydown.end.prevent']() {
            this.setActive(this.data.length - 1);
        },
    },

    svg: {
        [':viewBox']() {
            return `0 0 ${this.width} ${this.height}`;
        },
        [':aria-label']() {
            return this.accessibleLabel;
        },
        ['@mousemove'](event) {
            this.activateFromPointer(event);
        },
        ['@mouseleave']() {
            this.activeIndex = null;
        },
    },

    init() {
        this.measure();

        if ('ResizeObserver' in window) {
            this.resizeObserver = new ResizeObserver(() => this.measure());
            this.resizeObserver.observe(this.$refs.chartContent);
        }
    },

    destroy() {
        this.resizeObserver?.disconnect();
    },

    measure() {
        const width = this.$refs.chartContent?.clientWidth;

        if (width) {
            this.width = Math.max(320, Math.round(width));
        }
    },

    get hasData() {
        return this.data.length > 0 && this.series.length > 0;
    },

    get categoryKey() {
        if (this.xKey) {
            return this.xKey;
        }

        const first = this.data[0] ?? {};

        return Object.keys(first).find((key) => ! Number.isFinite(Number(first[key]))) ?? Object.keys(first)[0] ?? '';
    },

    get series() {
        const configured = Object.keys(this.config).filter((key) => this.data.some((item) => Number.isFinite(Number(item?.[key]))));

        if (configured.length) {
            return configured.map((key, index) => this.seriesDefinition(key, index));
        }

        const first = this.data[0] ?? {};

        return Object.keys(first)
            .filter((key) => key !== this.categoryKey && Number.isFinite(Number(first[key])))
            .map((key, index) => this.seriesDefinition(key, index));
    },

    seriesDefinition(key, index) {
        const definition = this.config[key] ?? {};
        const theme = definition.theme ?? {};
        const color = definition.color
            ?? (document.documentElement.classList.contains('dark') ? theme.dark : theme.light)
            ?? `var(--chart-${(index % 5) + 1})`;

        return {
            key,
            label: definition.label ?? humanize(key),
            color,
        };
    },

    get plot() {
        return {
            left: 42,
            right: 12,
            top: 12,
            bottom: 30,
            width: Math.max(1, this.width - 54),
            height: Math.max(1, this.height - 42),
        };
    },

    get maximum() {
        const maximum = Math.max(0, ...this.data.flatMap((item) => this.series.map((series) => number(item?.[series.key]))));

        return maximum || 1;
    },

    get ticks() {
        const count = 4;

        return Array.from({ length: count + 1 }, (_, index) => {
            const value = (this.maximum / count) * index;

            return {
                value,
                label: this.formatValue(value),
                y: this.y(value),
            };
        });
    },

    get gridMarkup() {
        return this.ticks.map((tick) => `
            <line x1="${this.plot.left}" x2="${this.plot.left + this.plot.width}" y1="${tick.y}" y2="${tick.y}"
                stroke="hsl(var(--border))" stroke-dasharray="3 3" />
            <text x="${this.plot.left - 8}" y="${tick.y + 4}" text-anchor="end" fill="hsl(var(--muted-foreground))" font-size="10">${escape(tick.label)}</text>
        `).join('');
    },

    get labelsMarkup() {
        return this.data.map((item, index) => `
            <text x="${this.x(index)}" y="${this.height - 8}" text-anchor="middle" fill="hsl(var(--muted-foreground))" font-size="10">${escape(this.category(index))}</text>
        `).join('');
    },

    get geometryMarkup() {
        if (this.type === 'bar') {
            return this.bars.map((bar) => `
                <rect x="${bar.x}" y="${bar.y}" width="${bar.width}" height="${bar.height}" rx="4" fill="${escape(bar.color)}">
                    <title>${escape(`${this.category(bar.itemIndex)} — ${bar.label}: ${this.formatValue(bar.value)}`)}</title>
                </rect>
            `).join('');
        }

        const areas = this.type === 'area'
            ? this.series.map((series) => `<path d="${this.linePath(series, true)}" fill="${escape(series.color)}" fill-opacity="0.2" />`).join('')
            : '';
        const lines = this.series.map((series) => `<path d="${this.linePath(series)}" fill="none" stroke="${escape(series.color)}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />`).join('');
        const points = this.data.flatMap((item, index) => this.series.map((series) => `
            <circle cx="${this.x(index)}" cy="${this.y(item?.[series.key])}" r="4" fill="${escape(series.color)}" stroke="hsl(var(--background))" stroke-width="2">
                <title>${escape(`${this.category(index)} — ${series.label}: ${this.formatValue(item?.[series.key])}`)}</title>
            </circle>
        `)).join('');

        return `${areas}${lines}${points}`;
    },

    get bars() {
        const groupWidth = this.plot.width / Math.max(1, this.data.length);
        const gap = Math.min(8, groupWidth * 0.18);
        const width = Math.max(2, (groupWidth - gap) / Math.max(1, this.series.length));

        return this.data.flatMap((item, itemIndex) => this.series.map((series, seriesIndex) => {
            const value = number(item?.[series.key]);
            const height = (value / this.maximum) * this.plot.height;

            return {
                ...series,
                itemIndex,
                value,
                x: this.plot.left + (itemIndex * groupWidth) + (gap / 2) + (seriesIndex * width),
                y: this.plot.top + this.plot.height - height,
                width: Math.max(1, width - 1),
                height,
            };
        }));
    },

    x(index) {
        const step = this.plot.width / Math.max(1, this.data.length);

        return this.plot.left + (step * index) + (step / 2);
    },

    y(value) {
        return this.plot.top + this.plot.height - ((number(value) / this.maximum) * this.plot.height);
    },

    linePath(series, area = false) {
        if (! this.data.length) {
            return '';
        }

        const points = this.data.map((item, index) => `${this.x(index)},${this.y(item?.[series.key])}`);
        const line = `M ${points.join(' L ')}`;

        if (! area) {
            return line;
        }

        return `${line} L ${this.x(this.data.length - 1)},${this.plot.top + this.plot.height} L ${this.x(0)},${this.plot.top + this.plot.height} Z`;
    },

    formatValue(value) {
        return new Intl.NumberFormat(undefined, { maximumFractionDigits: 1, notation: value >= 1000 ? 'compact' : 'standard' }).format(value);
    },

    category(index) {
        const value = this.data[index]?.[this.categoryKey];

        return value == null ? String(index + 1) : String(value);
    },

    get activeDatum() {
        return this.activeIndex === null ? null : this.data[this.activeIndex] ?? null;
    },

    get tooltipRows() {
        if (! this.activeDatum) {
            return [];
        }

        return this.series.map((series) => ({
            ...series,
            value: number(this.activeDatum[series.key]),
        }));
    },

    get tooltipStyle() {
        if (this.activeIndex === null) {
            return {};
        }

        return { left: `${(this.x(this.activeIndex) / this.width) * 100}%` };
    },

    get accessibleLabel() {
        if (! this.activeDatum) {
            return 'Use the left and right arrow keys to inspect chart values.';
        }

        return `${this.category(this.activeIndex)}. ${this.tooltipRows.map((row) => `${row.label}: ${this.formatValue(row.value)}`).join('. ')}.`;
    },

    activateFromPointer(event) {
        const bounds = this.$refs.chart?.getBoundingClientRect();

        if (! bounds) {
            return;
        }

        const x = ((event.clientX - bounds.left) / bounds.width) * this.width;
        const index = Math.floor(((x - this.plot.left) / this.plot.width) * this.data.length);

        this.setActive(index);
    },

    setActive(index) {
        this.activeIndex = Math.max(0, Math.min(this.data.length - 1, index));
    },

    moveActive(offset) {
        this.setActive((this.activeIndex ?? -1) + offset);
    },
});
