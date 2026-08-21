const MOBILE_BREAKPOINT = 768

// A cookie, not localStorage, so the server can render the state it left in.
// Pass the cookie back as the layout's defaultOpen to avoid a flash on load.
export const SIDEBAR_STATE_COOKIE = 'sidebar_state'
const ONE_YEAR_IN_SECONDS = 60 * 60 * 24 * 365

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
        this.isMobile ? (this.openMobile = !this.openMobile) : this.setOpen(!this.open)
    },
    show() {
        this.isMobile ? (this.openMobile = true) : this.setOpen(true)
    },
    close() {
        this.isMobile ? (this.openMobile = false) : this.setOpen(false)
    },
    // The mobile panel is deliberately not stored. It is a drawer, not a layout
    // choice, and it must never come back open on the next page.
    setOpen(open) {
        this.open = open
        this.persist()
    },
    persist() {
        try {
            document.cookie = SIDEBAR_STATE_COOKIE + '=' + (this.open ? 'true' : 'false')
                + '; path=/; max-age=' + ONE_YEAR_IN_SECONDS + '; samesite=lax'
        } catch (error) {
            // A browser that refuses cookies just loses the stored state.
        }
    },
})
