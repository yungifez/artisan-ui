export default (orientation = 'horizontal', loop = true) => ({
    orientation,
    loop,
    current: 0,
    count: 0,
    slides: [],
    root: {
        ['x-id']() {
            return ['carousel'];
        },
        ['@keydown.left.prevent']() {
            this.previousSlide();
        },
        ['@keydown.right.prevent']() {
            this.nextSlide();
        },
    },
    viewport: {
        ['x-ref']() {
            return 'viewport';
        },
    },
    track: {
        ['x-ref']() {
            return 'track';
        },
        ['x-bind:style']() {
            const property = this.orientation === 'vertical' ? 'translateY' : 'translateX';

            return `transform: ${property}(-${this.current * 100}%);`;
        },
    },
    previous: {
        ['x-on:click']() {
            this.previousSlide();
        },
        ['x-bind:disabled']() {
            return !this.loop && this.current === 0;
        },
    },
    next: {
        ['x-on:click']() {
            this.nextSlide();
        },
        ['x-bind:disabled']() {
            return !this.loop && this.current === this.count - 1;
        },
    },
    init() {
        this.slides = Array.from(this.$root.querySelectorAll('[data-slot="carousel-item"]'));
        this.count = this.slides.length;
        this.updateSlides();
    },
    updateSlides() {
        this.slides.forEach((slide, index) => {
            slide.setAttribute('aria-hidden', index === this.current ? 'false' : 'true');
        });
    },
    goTo(index) {
        if (!this.count) {
            return;
        }

        if (this.loop) {
            this.current = (index + this.count) % this.count;
        } else {
            this.current = Math.max(0, Math.min(index, this.count - 1));
        }

        this.updateSlides();
    },
    previousSlide() {
        this.goTo(this.current - 1);
    },
    nextSlide() {
        this.goTo(this.current + 1);
    },
});
