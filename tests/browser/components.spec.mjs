import { expect, test } from '@playwright/test';

test.beforeEach(async ({ page }) => {
    await page.goto('/');
    await expect(page.locator('body')).toHaveAttribute('data-ready', 'true');
});

test('accordion changes the visible panel and enforces single selection', async ({ page }) => {
    const firstTrigger = page.locator('[data-test="accordion-first-trigger"]');
    const secondTrigger = page.locator('[data-test="accordion-second-trigger"]');
    const firstContent = page.locator('[data-test="accordion-first-content"]');
    const secondContent = page.locator('[data-test="accordion-second-content"]');

    await firstTrigger.click();
    await expect(firstContent).toBeVisible();
    await expect(firstTrigger).toHaveAttribute('aria-expanded', 'true');
    await expect(page.locator('body')).toHaveAttribute('data-accordion-value', /accordion-item/);

    await secondTrigger.click();
    await expect(firstContent).toBeHidden();
    await expect(secondContent).toBeVisible();
    await expect(secondTrigger).toHaveAttribute('aria-expanded', 'true');

    await secondTrigger.click();
    await expect(secondContent).toBeHidden();
});

test('tabs activate the clicked panel and update keyboard state', async ({ page }) => {
    const billing = page.locator('[data-test="tab-billing"]');

    await expect(page.locator('[data-test="panel-account"]')).toBeVisible();
    await expect(page.locator('[data-test="panel-billing"]')).toBeHidden();

    await billing.click();

    await expect(page.locator('[data-test="panel-account"]')).toBeHidden();
    await expect(page.locator('[data-test="panel-billing"]')).toBeVisible();
    await expect(billing).toHaveAttribute('aria-selected', 'true');
    await expect(billing).toHaveAttribute('tabindex', '0');
});

test('tabs move focus with arrow keys', async ({ page }) => {
    const account = page.locator('[data-test="tab-account"]');
    const billing = page.locator('[data-test="tab-billing"]');

    await account.focus();
    await account.press('ArrowRight');
    await expect(billing).toBeFocused();

    await billing.press('ArrowLeft');
    await expect(account).toBeFocused();
});

test('switch toggles both the semantic state and form control state', async ({ page }) => {
    const root = page.locator('#switch');
    const input = page.locator('[data-test="switch-input"]');

    await expect(root).toHaveAttribute('aria-checked', 'false');
    await expect(input).not.toBeChecked();

    await page.locator('[data-test="switch-trigger"]').click();

    await expect(root).toHaveAttribute('aria-checked', 'true');
    await expect(root).toHaveAttribute('data-state', 'checked');
    await expect(input).toBeChecked();
    await expect(page.locator('body')).toHaveAttribute('data-switch-value', 'true');
    await expect.poll(() => page.locator('#switch').evaluate((element) => Alpine.$data(element).value)).toBe(true);
});

test('disabled switches remain unchanged and expose disabled semantics', async ({ page }) => {
    const root = page.locator('#disabled-switch');
    const trigger = page.locator('[data-test="disabled-switch-trigger"]');

    await expect(root).toHaveAttribute('data-disabled', 'true');
    await expect(trigger).toBeDisabled();
    await expect(root).toHaveAttribute('aria-checked', 'false');

    await trigger.click({ force: true });

    await expect(root).toHaveAttribute('aria-checked', 'false');
    await expect(page.locator('[data-test="disabled-switch-input"]')).not.toBeChecked();
});

test('combobox filters options and commits the selected value', async ({ page }) => {
    await page.locator('[data-test="combobox-trigger"]').click();
    await expect(page.locator('[data-test="combobox-content"]')).toBeVisible();

    await page.locator('[data-test="combobox-input"]').fill('live');
    await expect(page.locator('[data-value="laravel"]')).toBeHidden();
    await expect(page.locator('[data-value="livewire"]')).toBeVisible();

    await page.locator('[data-value="livewire"]').click();

    await expect(page.locator('[data-test="combobox-content"]')).toBeHidden();
    await expect(page.locator('[data-test="combobox-label"]')).toHaveText('Livewire');
    await expect(page.locator('#preferences')).toHaveAttribute('data-state', 'closed');
    await expect.poll(() => page.locator('#preferences').evaluate((element) => Alpine.$data(element).value)).toBe('livewire');
});

test('combobox hover moves the active option', async ({ page }) => {
    await page.locator('[data-test="combobox-trigger"]').click();

    const firstOption = page.locator('[data-value="laravel"]');
    const secondOption = page.locator('[data-value="livewire"]');

    await expect(firstOption).toHaveAttribute('data-active', 'true');
    await secondOption.hover();
    await expect(firstOption).not.toHaveAttribute('data-active');
    await expect(secondOption).toHaveAttribute('data-active', 'true');
    await expect(page.locator('[data-test="combobox-input"]')).toHaveAttribute('aria-activedescendant', /option-livewire/);
});

test('combobox keyboard navigation selects an option and submits its value', async ({ page }) => {
    const trigger = page.locator('[data-test="combobox-trigger"]');

    await trigger.press('ArrowDown');
    await expect(page.locator('[data-test="combobox-input"]')).toHaveAttribute('aria-activedescendant', /option-laravel/);
    await page.locator('[data-test="combobox-input"]').dispatchEvent('keydown', { key: 'Enter' });
    await expect(page.locator('[data-test="combobox-label"]')).toHaveText('Laravel');

    await page.locator('[data-test="preferences-submit"]').click();
    await expect(page.locator('body')).toHaveAttribute('data-submitted-framework', 'laravel');
});

test('disabled comboboxes do not open', async ({ page }) => {
    const root = page.locator('#disabled-combobox');
    const trigger = page.locator('[data-test="disabled-combobox-trigger"]');

    await expect(root).toHaveAttribute('data-disabled', 'true');
    await expect(trigger).toBeDisabled();
    await trigger.click({ force: true });
    await expect(page.locator('[data-test="disabled-combobox-content"]')).toBeHidden();
});

test('collapsible controls support click and keyboard toggles', async ({ page }) => {
    const trigger = page.locator('[data-test="collapsible-trigger"]');
    const content = page.locator('[data-test="collapsible-content"]');

    await expect(content).toBeHidden();
    await trigger.press('Enter');
    await expect(content).toBeVisible();
    await trigger.press('Space');
    await expect(content).toBeHidden();
});

test('disabled collapsibles cannot be opened', async ({ page }) => {
    const trigger = page.locator('[data-test="disabled-collapsible-trigger"]');

    await expect(trigger).toBeDisabled();
    await trigger.press('Enter');
    await expect(page.locator('[data-test="disabled-collapsible-content"]')).toBeHidden();
});

test('dialog opens, wires accessible labels, and closes on escape or close action', async ({ page }) => {
    const dialog = page.locator('[data-test="dialog-content"]');
    const overlay = page.locator('[data-test="dialog-overlay"]');

    await page.locator('[data-test="dialog-trigger"]').click();
    await expect(dialog).toBeVisible();
    await expect(dialog).toHaveAttribute('aria-modal', 'true');
    await expect(dialog).toHaveAttribute('aria-labelledby', /-title$/);
    await expect(dialog).toHaveAttribute('aria-describedby', /-description$/);

    await page.keyboard.press('Escape');
    await expect(overlay).toBeHidden();

    await page.locator('[data-test="dialog-trigger"]').click();
    await page.locator('[data-test="dialog-close"]').click();
    await expect(overlay).toBeHidden();
});

test('popover opens and closes when focus leaves its content', async ({ page }) => {
    const trigger = page.locator('[data-test="popover-trigger"]');
    const content = page.locator('[data-test="popover-content"]');

    await trigger.click();
    await expect(content).toBeVisible();
    await expect(trigger).toHaveAttribute('aria-expanded', 'true');

    await page.locator('[data-test="dialog-trigger"]').click();
    await expect(content).toBeHidden();
});

test('date picker toggles its calendar popup and closes with escape', async ({ page }) => {
    const trigger = page.locator('[data-test="date-picker-trigger"]');
    const calendar = page.locator('[data-test="date-picker-calendar"]');

    await expect(calendar).toBeHidden();
    await trigger.click();
    await expect(calendar).toBeVisible();
    await expect(page.locator('#date-picker')).toHaveAttribute('data-state', 'open');

    await page.keyboard.press('Escape');
    await expect(calendar).toBeHidden();
});

test('calendar selects dates, disables configured dates, and navigates months', async ({ page }) => {
    const selected = page.locator('[data-test="calendar-day"][data-day="15"]');
    const disabled = page.locator('[data-test="calendar-day"][data-day="20"]');

    await expect(page.locator('[data-test="calendar-month"]')).toHaveText('January');
    await expect(selected).toHaveAttribute('aria-selected', 'true');
    await expect(disabled).toBeDisabled();

    await page.locator('[data-test="calendar-day"][data-day="16"]').click();
    await expect(page.locator('[data-test="calendar-value"]')).toHaveText('2024-01-16');
    await expect(page.locator('[data-test="calendar-day"][data-day="16"]')).toHaveAttribute('aria-selected', 'true');
    await expect.poll(() => page.locator('#calendar').evaluate((element) => Alpine.$data(element).value?.toISOString().slice(0, 10)))
        .toBe('2024-01-16');

    await page.locator('[data-test="calendar-next"]').click();
    await expect(page.locator('[data-test="calendar-month"]')).toHaveText('February');
    await expect(page.locator('[data-test="calendar-previous"]')).toBeEnabled();
});

test('alerts dismiss through their action binding', async ({ page }) => {
    const alert = page.locator('#alert');

    await expect(alert).toBeVisible();
    await page.locator('[data-test="alert-dismiss"]').click();
    await expect(alert).toBeHidden();
    await expect(alert).toHaveAttribute('data-state', 'closed');
});

test('alert dialogs close from both cancel and confirm actions', async ({ page }) => {
    const trigger = page.locator('[data-test="alert-dialog-trigger"]');
    const overlay = page.locator('[data-test="alert-dialog-overlay"]');

    await trigger.click();
    await expect(page.locator('[data-test="alert-dialog-content"]')).toBeVisible();
    await page.locator('[data-test="alert-dialog-cancel"]').click();
    await expect(overlay).toBeHidden();

    await trigger.click();
    await page.locator('[data-test="alert-dialog-action"]').click();
    await expect(overlay).toBeHidden();
});

test('carousel moves between non-looping slides and disables its bounds', async ({ page }) => {
    const first = page.locator('[data-test="carousel-first"]');
    const second = page.locator('[data-test="carousel-second"]');
    const next = page.locator('[data-test="carousel-next"]');
    const previous = page.locator('[data-test="carousel-previous"]');

    await expect(first).toHaveAttribute('aria-hidden', 'false');
    await expect(previous).toBeDisabled();
    await next.click();
    await expect(first).toHaveAttribute('aria-hidden', 'true');
    await expect(second).toHaveAttribute('aria-hidden', 'false');
    await previous.click();
    await expect(first).toHaveAttribute('aria-hidden', 'false');

    await page.locator('#carousel').focus();
    await page.keyboard.press('ArrowRight');
    await expect(second).toHaveAttribute('aria-hidden', 'false');
});

test('vertical carousel keeps the final slide within the viewport', async ({ page }) => {
    const root = page.locator('#carousel-vertical');
    const next = page.locator('[data-test="carousel-vertical-next"]');
    const last = page.locator('[data-test="carousel-vertical-third"]');

    await next.dispatchEvent('click');
    await next.dispatchEvent('click');
    await expect(last).toHaveAttribute('aria-hidden', 'false');
    await page.waitForFunction(() => {
        const viewport = document.querySelector('[data-test="carousel-vertical-viewport"]');
        const last = document.querySelector('[data-test="carousel-vertical-third"]');
        const viewportBounds = viewport.getBoundingClientRect();
        const lastBounds = last.getBoundingClientRect();

        return Math.abs(lastBounds.top - viewportBounds.top) < 1
            && Math.abs(lastBounds.bottom - viewportBounds.bottom) < 1;
    });

    const bounds = await page.evaluate(() => {
        const viewport = document.querySelector('[data-test="carousel-vertical-viewport"]');
        const last = document.querySelector('[data-test="carousel-vertical-third"]');

        return {
            viewport: viewport.getBoundingClientRect().toJSON(),
            last: last.getBoundingClientRect().toJSON(),
        };
    });

    expect(bounds.last.top).toBeGreaterThanOrEqual(bounds.viewport.top - 1);
    expect(bounds.last.bottom).toBeLessThanOrEqual(bounds.viewport.bottom + 1);
    await expect(root.locator('[data-test="carousel-vertical-next"]')).toBeDisabled();
});

test('command filters items and moves its active item with the keyboard', async ({ page }) => {
    const input = page.locator('[data-test="command-input"]');
    const first = page.locator('[data-test="command-first"]');
    const second = page.locator('[data-test="command-second"]');

    await input.fill('set');
    await expect(first).toBeHidden();
    await expect(second).toBeVisible();
    await expect(page.locator('body')).toHaveAttribute('data-command-value', 'set');
    await expect.poll(() => page.locator('#command').evaluate((element) => Alpine.$data(element).value)).toBe('set');
    await input.press('ArrowDown');
    await expect(second).toHaveAttribute('aria-selected', 'true');
    await input.press('Home');
    await expect(second).toHaveAttribute('tabindex', '0');
});

test('context menus open at the pointer and close after choosing an item', async ({ page }) => {
    const trigger = page.locator('[data-test="context-trigger"]');
    const content = page.locator('[data-test="context-content"]');

    await page.evaluate(() => {
        document.querySelector('[data-test="context-trigger"]').dispatchEvent(
            new MouseEvent('contextmenu', { bubbles: true, cancelable: true, clientX: 30, clientY: 20 }),
        );
    });
    await expect(content).toBeVisible();
    await expect(content).toHaveAttribute('data-state', 'open');
    await expect.poll(async () => content.evaluate((element) => ({ left: element.style.left, top: element.style.top })))
        .toEqual({ left: '30px', top: '20px' });
    await page.locator('[data-test="context-first"]').click();
    await expect(content).toBeHidden();
});

test('data tables search, sort, select rows, and paginate', async ({ page }) => {
    const rows = page.locator('[data-test="table-row"]');

    await expect(rows).toHaveCount(2);
    await page.locator('[data-test="table-row-select"]').first().check();
    await expect(rows.first()).toHaveAttribute('data-state', 'selected');
    await page.locator('[data-test="table-sort-score"]').click();
    await expect(rows.first().locator('[data-test="table-name"]')).toHaveText('Grace');
    await page.locator('[data-test="table-search"]').fill('lin');
    await expect(rows).toHaveCount(1);
    await expect(rows.first().locator('[data-test="table-name"]')).toHaveText('Linus');
    await page.locator('[data-test="table-search"]').fill('');
    await page.locator('[data-test="table-next"]').click();
    await expect(page.locator('[data-test="table-page"]')).toHaveText('2');
    await expect(page.locator('[data-test="table-previous"]')).toBeEnabled();
    await page.locator('[data-test="table-previous"]').click();
    await page.evaluate(() => window.dispatchEvent(new CustomEvent('data-table:sync', {
        detail: { data: [{ id: 4, name: 'Turing', score: 40 }] },
    })));
    await expect(rows).toHaveCount(1);
    await expect(rows.first().locator('[data-test="table-name"]')).toHaveText('Turing');
});

test('editor exposes editable content and updates its document through a toolbar command', async ({ page }) => {
    const content = page.locator('[data-test="editor-content"] .ProseMirror');

    await expect(content).toHaveAttribute('contenteditable', 'true');
    await expect(content).toContainText('Hello');
    await content.click();
    await content.focus();
    await content.press('Control+a');
    await page.locator('[data-test="editor-bold"]').click();
    await expect(content.locator('strong')).toHaveText('Hello');
});

test('select opens, commits an option, and keeps disabled options unavailable', async ({ page }) => {
    const trigger = page.locator('[data-test="select-trigger"]');

    await trigger.click();
    await expect(page.locator('[data-test="select-options"]')).toBeVisible();
    await expect(page.locator('[data-test="select-option"]').nth(2)).toBeDisabled();
    await page.locator('[data-test="select-option"]').nth(1).click();
    await expect(trigger).toContainText('Two');
    await expect(page.locator('[data-test="select-options"]')).toBeHidden();
    await expect.poll(() => page.locator('#select').evaluate((element) => Alpine.$data(element).value)).toBe('two');
});

test('select tells a screen reader it is a select and which list it opens', async ({ page }) => {
    const trigger = page.locator('[data-test="select-trigger"]');
    const options = page.locator('[data-test="select-options"]');

    await expect(trigger).toHaveAttribute('aria-expanded', 'false');
    await expect(trigger).toHaveAttribute('aria-haspopup', 'listbox');

    const controls = await trigger.getAttribute('aria-controls');
    expect(controls).toBeTruthy();
    await expect(options).toHaveAttribute('id', controls);
    await expect(options).toHaveAttribute('aria-labelledby', await trigger.getAttribute('id'));
    await expect(options).toHaveAttribute('aria-multiselectable', 'false');

    await trigger.click();
    await expect(trigger).toHaveAttribute('aria-expanded', 'true');
});

test('sidebar toggles its public state and responds to the keyboard shortcut', async ({ page }) => {
    const panel = page.locator('[data-test="sidebar-panel"]');

    await expect(panel).toHaveAttribute('data-state', 'expanded');
    await page.locator('[data-test="sidebar-toggle"]').click();
    await expect(panel).toHaveAttribute('data-state', 'collapsed');
    await page.keyboard.press('Control+b');
    await expect(panel).toHaveAttribute('data-state', 'expanded');
});

test('tooltips open on focus and close on blur', async ({ page }) => {
    const trigger = page.locator('[data-test="tooltip-trigger"]');
    const content = page.locator('[data-test="tooltip-content"]');

    await trigger.focus();
    await expect(content).toBeVisible();
    await expect(trigger).toHaveAttribute('aria-describedby', /tooltip/);
    await trigger.blur();
    await expect(content).toBeHidden();
});

test('avatars switch from fallback to image after a successful load', async ({ page }) => {
    const image = page.locator('[data-test="avatar-image"]');
    const fallback = page.locator('[data-test="avatar-fallback"]');

    await expect(fallback).toBeVisible();
    await expect(image).toBeHidden();
    await image.dispatchEvent('load');
    await expect(image).toBeVisible();
    await expect(fallback).toBeHidden();
});

test('banners display after their delay and dismiss through the action', async ({ page }) => {
    const banner = page.locator('#banner');

    await expect(banner).toBeVisible();
    await expect(banner).toHaveAttribute('data-state', 'open');
    await page.locator('[data-test="banner-dismiss"]').click();
    await expect(banner).toBeHidden();
    await expect(banner).toHaveAttribute('data-state', 'closed');
});

test('charts expose accessible data and update the active datum with keyboard input', async ({ page }) => {
    const chart = page.locator('#chart');

    await expect(page.locator('[data-test="chart-svg"] rect')).toHaveCount(2);
    await expect(page.locator('[data-test="chart-svg"] title').first()).toHaveText('Jan — Sales: 10');
    await expect(page.locator('[data-test="chart-label"]')).toContainText('Use the left and right arrow keys');
    await chart.focus();
    await page.keyboard.press('Home');
    await expect(page.locator('[data-test="chart-label"]')).toHaveText(/Jan.*Sales: 10/);
    await page.keyboard.press('ArrowRight');
    await expect(page.locator('[data-test="chart-label"]')).toHaveText(/Feb.*Sales: 20/);
});

test('dropdown menus open, move focus, and close after choosing an item', async ({ page }) => {
    const trigger = page.locator('[data-test="dropdown-trigger"]');
    const content = page.locator('[data-test="dropdown-content"]');

    await trigger.click();
    await expect(content).toBeVisible();
    await trigger.press('ArrowDown');
    await expect(page.locator('[data-test="dropdown-first"]')).toBeFocused();
    await page.locator('[data-test="dropdown-first"]').click();
    await expect(content).toBeHidden();
});

test('dropdown submenus open and close their nested menu', async ({ page }) => {
    const trigger = page.locator('[data-test="submenu-trigger"]');
    const content = page.locator('[data-test="submenu-content"]');

    await trigger.click();
    await expect(content).toBeVisible();
    await expect(page.locator('#dropdown-submenu')).toHaveAttribute('data-state', 'open');
    await page.locator('[data-test="submenu-item"]').click();
    await expect(content).toBeHidden();
});

test('sheets expose the configured side and follow their open state', async ({ page }) => {
    const content = page.locator('[data-test="sheet-content"]');

    await expect(content).toBeHidden();
    await page.locator('[data-test="sheet-trigger"]').click();
    await expect(content).toBeVisible();
    await expect(content).toHaveAttribute('aria-modal', 'true');
    await expect(content).toHaveAttribute('data-state', 'open');
    await page.locator('[data-test="sheet-close"]').click();
    await expect(content).toBeHidden();
});

test('calendar multiple mode toggles dates and enforces its selection limit', async ({ page }) => {
    const days = page.locator('[data-test="multiple-day"]');

    await days.filter({ hasText: '10' }).click();
    await days.filter({ hasText: '11' }).click();
    await expect(page.locator('[data-test="multiple-value"]')).toHaveText('2');
    await expect(days.filter({ hasText: '12' })).toBeDisabled();
    await days.filter({ hasText: '10' }).click();
    await expect(page.locator('[data-test="multiple-value"]')).toHaveText('1');
    await expect(days.filter({ hasText: '12' })).toBeEnabled();
});

test('calendar range mode completes a range after two date selections', async ({ page }) => {
    const days = page.locator('[data-test="range-day"]');

    await expect(page.locator('[data-test="range-value"]')).toHaveText('incomplete');
    await days.filter({ hasText: '10' }).click();
    await expect(page.locator('[data-test="range-value"]')).toHaveText('incomplete');
    await days.filter({ hasText: '15' }).click();
    await expect(page.locator('[data-test="range-value"]')).toHaveText('complete');
    await expect(days.filter({ hasText: '10' })).toHaveAttribute('aria-selected', 'true');
    await expect(days.filter({ hasText: '15' })).toHaveAttribute('aria-selected', 'true');

    await page.locator('#calendar-range [data-test="range-day"][data-day="8"]').click();
    await expect(page.locator('[data-test="range-value"]')).toHaveText('incomplete');
    await expect(page.locator('#calendar-range [data-test="range-day"][data-day="8"]')).toHaveAttribute('aria-selected', 'true');
    await expect(days.filter({ hasText: '15' })).not.toHaveAttribute('aria-selected', 'true');
});

test('modelable controls synchronize with the Livewire wire contract', async ({ page }) => {
    const bridge = page.locator('#livewire-bridge');

    await bridge.locator('[data-test="bridge-trigger"]').click();
    await expect(page.locator('body')).toHaveAttribute('data-wire-value', 'true');
    await expect(bridge).toHaveAttribute('data-state', 'open');

    await page.evaluate(() => {
        const current = document.querySelector('#livewire-bridge');
        window.Livewire.__state.open = false;
        current.outerHTML = current.outerHTML.replace('data-state="open"', 'data-state="closed"');
        const replacement = document.querySelector('#livewire-bridge');
        window.Alpine.initTree(replacement);
        window.Livewire.__hooks['morph.updated']({ el: replacement });
    });

    await expect(page.locator('[data-test="bridge-content"]')).toBeHidden();
    await expect(bridge).toHaveAttribute('data-state', 'closed');
});

test('the Livewire bridge ignores native wire model controls', async ({ page }) => {
    const input = page.locator('[data-test="native-model-input"]');

    await expect(input).not.toHaveAttribute('data-april-wire-model-bound', 'true');
    await expect.poll(() => page.evaluate(() => window.Livewire.__setCalls.native || 0)).toBe(0);
});

test('the Livewire bridge hydrates custom selects before syncing changes', async ({ page }) => {
    const select = page.locator('#livewire-select');

    await expect(page.locator('[data-test="livewire-select-value"]')).toHaveText('second');
    await expect.poll(() => page.evaluate(() => window.Livewire.__setCalls.select || 0)).toBe(0);

    await select.locator('[data-test="livewire-select-trigger"]').click();
    await select.locator('[role="option"]').first().click();

    await expect(page.locator('[data-test="livewire-select-value"]')).toHaveText('first');
    await expect.poll(() => page.evaluate(() => window.Livewire.__setCalls.select || 0)).toBe(1);
});
