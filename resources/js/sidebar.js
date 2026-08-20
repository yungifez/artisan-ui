const MOBILE_BREAKPOINT = 768

export default (defaultOpen = true) => ({
    open: defaultOpen,
    openMobile: false,
    isMobile: false,
    root: {
        ['@keydown.ctrl.b.window.prevent']() {
            return this.toggle()
        },
        ['@keydown.meta.b.window.prevent']() {
            return this.toggle()
        },
        ['@resize.window.debounce']() {
            return this.readViewport()
        },
    },
    init() {
        this.readViewport()
    },
    readViewport() {
        this.isMobile = window.innerWidth < MOBILE_BREAKPOINT

        // The mobile panel must not stay open behind a desktop layout.
        if (!this.isMobile) {
            this.openMobile = false
        }
    },
    // The state that the components read to pick their classes.
    get state() {
        return this.open ? 'expanded' : 'collapsed'
    },
    isOpen() {
        return this.isMobile ? this.openMobile : this.open
    },
    toggle() {
        this.isMobile ? (this.openMobile = !this.openMobile) : (this.open = !this.open)
    },
    show() {
        this.isMobile ? (this.openMobile = true) : (this.open = true)
    },
    close() {
        this.isMobile ? (this.openMobile = false) : (this.open = false)
    },
})
