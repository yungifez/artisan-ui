<?php

use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

describe('accordion', function () {
    it('is driven by the accordion behaviour', function () {
        expect(renderComponent('accordion'))->toContain('x-data="accordion(');
    });

    it('allows several open items by default', function () {
        expect(renderComponent('accordion'))->toContain("accordion('multiple'");
    });

    it('takes a single item type', function () {
        expect(renderComponent('accordion', 'type="single"'))->toContain("accordion('single'");
    });

    it('tells the behaviour that items can collapse', function () {
        expect(renderComponent('accordion', 'collapsible'))->toContain("'multiple', true,");
    });

    it('tells the behaviour that the accordion is disabled', function () {
        expect(renderComponent('accordion', 'disabled'))->toContain('false, true)');
    });

    it('renders its slot', function () {
        expect(renderComponent('accordion', '', 'items'))->toContain('items');
    });

    it('renders an item trigger in a heading', function () {
        $html = render('<april:accordion-item><x-slot:trigger>Question</x-slot:trigger></april:accordion-item>');

        expect($html)->toContain('<h3')->toContain('Question')->toContain('x-bind="trigger"');
    });

    it('renders an item content region', function () {
        $html = render('<april:accordion-item><x-slot:content>Answer</x-slot:content></april:accordion-item>');

        expect($html)->toContain('role="region"')->toContain('Answer');
    });

    it('adds a default chevron to the trigger', function () {
        $html = render('<april:accordion-item><x-slot:trigger>Question</x-slot:trigger></april:accordion-item>');

        expect($html)->toContain('<svg')->toContain('x-bind="icon"');
    });

    it('takes a custom trigger icon', function () {
        $html = render('<april:accordion-item><x-slot:trigger>Q</x-slot:trigger><x-slot:icon>+</x-slot:icon></april:accordion-item>');

        expect($html)->toContain('+')->not->toContain('x-bind="icon"');
    });
});

describe('tabs', function () {
    it('is driven by the tabs behaviour', function () {
        expect(renderComponent('tabs'))->toContain('x-data="tabs(');
    });

    it('passes the default value to the behaviour', function () {
        expect(renderComponent('tabs', 'default-value="account"'))->toContain("tabs('account'");
    });

    it('passes the activation mode to the behaviour', function () {
        expect(renderComponent('tabs', 'activation-mode="manual"'))->toContain("'manual')");
    });

    it('still accepts the camel case attribute names', function () {
        expect(renderComponent('tabs', 'defaultValue="account" activationMode="manual"'))
            ->toContain("tabs('account', 'manual')");
    });

    it('activates automatically by default', function () {
        expect(renderComponent('tabs'))->toContain("tabs('', 'automatic')");
    });

    it('does not leak the prop attributes into the html', function () {
        expect(renderComponent('tabs', 'default-value="account" activation-mode="manual"'))
            ->not->toContain('default-value=')
            ->not->toContain('activation-mode=');
    });

    it('renders the tabs list slot with the tablist role', function () {
        $html = render('<april:tabs><x-slot:tabsList>triggers</x-slot:tabsList></april:tabs>');

        expect($html)->toContain('role="tablist"')->toContain('triggers');
    });

    it('renders its slot', function () {
        expect(renderComponent('tabs', '', 'panels'))->toContain('panels');
    });

    it('renders a trigger with the tab role', function () {
        $html = renderComponent('tabs-trigger', 'value="account"', 'Account');

        expect($html)->toContain('role="tab"')
            ->toContain('aria-controls="tab-')
            ->toContain("tabsTrigger('account')")
            ->toContain('Account');
    });

    it('renders content with the tabpanel role', function () {
        $html = renderComponent('tabs-content', 'value="account"', 'Panel');

        expect($html)->toContain('role="tabpanel"')
            ->toContain('aria-labelledby="tab-')
            ->toContain("tabsContent('account')")
            ->toContain('Panel');
    });
});

describe('command', function () {
    it('is driven by the command behaviour', function () {
        expect(renderComponent('command'))->toContain("x-data='command(");
    });

    it('renders a combobox input', function () {
        expect(renderComponent('command'))->toContain('role="combobox"');
    });

    it('offers a default search icon', function () {
        expect(renderComponent('command'))->toContain('lucide-search');
    });

    it('takes a custom icon', function () {
        $html = render('<april:command><x-slot:icon>find</x-slot:icon></april:command>');

        expect($html)->toContain('find')->not->toContain('lucide-search');
    });

    it('labels the input for screen readers', function () {
        expect(renderComponent('command', 'label="Search commands"'))
            ->toContain('sr-only')
            ->toContain('Search commands');
    });

    it('renders the list slot as a listbox', function () {
        $html = render('<april:command><x-slot:list>items</x-slot:list></april:command>');

        expect($html)->toContain('role="listbox"')->toContain('items');
    });

    it('renders the empty message', function () {
        $html = render('<april:command empty="No results"><x-slot:list>items</x-slot:list></april:command>');

        expect($html)->toContain('No results');
    });

    it('renders a group with its heading', function () {
        expect(renderComponent('command-group', 'heading="Suggestions"'))
            ->toContain('Suggestions')
            ->toContain('role="group"');
    });

    it('renders an item', function () {
        expect(renderComponent('command-item', '', 'Calendar'))->toContain('Calendar');
    });

    it('renders a shortcut', function () {
        expect(renderComponent('command-shortcut', '', 'Ctrl+K'))->toContain('Ctrl+K');
    });

    it('renders a separator', function () {
        expect(renderComponent('command-separator'))->toContain('<div');
    });

    it('renders the dialog wrapper', function () {
        expect(renderComponent('command-dialog'))->toContain('x-data');
    });
});

describe('collapsible', function () {
    it('is driven by the collapsible behaviour', function () {
        expect(renderComponent('collapsible'))->toContain('x-data="collapsible(false, false)"');
    });

    it('passes the initial open and disabled states', function () {
        expect(renderComponent('collapsible', 'open disabled'))
            ->toContain('x-data="collapsible(true, true)"')
            ->toContain('x-modelable="open"');
    });

    it('renders trigger and content slots', function () {
        $html = render('<april:collapsible><x-slot:trigger>Details</x-slot:trigger><x-slot:content>More information</x-slot:content></april:collapsible>');

        expect($html)
            ->toContain('data-slot="collapsible-trigger"')
            ->toContain('Details')
            ->toContain('data-slot="collapsible-content"')
            ->toContain('More information')
            ->toContain('x-cloak');
    });
});

describe('combobox', function () {
    it('is driven by the combobox behaviour', function () {
        expect(renderComponent('combobox'))->toContain('x-data="combobox(\'\', false)"');
    });

    it('supports modelable values and named form submission', function () {
        $html = renderComponent('combobox', 'name="framework" :value="\'laravel\'"');

        expect($html)
            ->toContain('x-modelable="selectedValue"')
            ->toContain('type="hidden"')
            ->toContain('name="framework"')
            ->toContain('x-cloak');
    });

    it('does not render an empty named field', function () {
        expect(renderComponent('combobox'))->not->toContain('name=""');
    });

    it('renders options as listbox options', function () {
        $html = render('<april:combobox><april:combobox-option value="laravel">Laravel</april:combobox-option></april:combobox>');

        expect($html)
            ->toContain('role="listbox"')
            ->toContain('role="option"')
            ->toContain('data-value="laravel"')
            ->toContain('Laravel');
    });

    it('keeps only the focused option active', function () {
        $source = file_get_contents(__DIR__.'/../../../resources/js/combobox.js');

        expect($source)
            ->toContain('return this.focusedOption === this.$el;')
            ->toContain('String(this.selectedValue ?? \'\') === String(value ?? \'\')');
    });

    it('uses static Alpine visibility and transition directives for the panel', function () {
        $html = renderComponent('combobox');
        $source = file_get_contents(__DIR__.'/../../../resources/js/combobox.js');

        expect($html)
            ->toContain('x-show="open"')
            ->toContain('x-trap.noscroll="open"')
            ->toContain('x-transition');

        expect($source)->not->toContain("['x-transition']");
    });
});

describe('editor', function () {
    it('is driven by the editor behaviour', function () {
        expect(renderComponent('editor'))->toContain('x-data="editor(');
    });

    it('supports modelable values and named form submission', function () {
        $html = renderComponent('editor', 'name="content" value="<p>Hello</p>"');

        expect($html)
            ->toContain('x-modelable="value"')
            ->toContain('type="hidden"')
            ->toContain('name="content"')
            ->toContain('Hello');
    });

    it('renders the default toolbar controls', function () {
        $html = renderComponent('editor');

        expect($html)
            ->toContain('x-on:click="run(\'bold\')"')
            ->toContain('x-on:click="run(\'bulletList\')"')
            ->toContain('x-on:click="run(\'undo\')"');
    });

    it('supports individual toolbar props', function () {
        $html = renderComponent('editor', 'bold="false" :italic="true"');

        expect($html)
            ->not->toContain('run(\'bold\')')
            ->toContain('run(\'italic\')');
    });

    it('supports an array toolbar configuration', function () {
        $html = render('<april:editor :buttons="[\'bold\', \'undo\']" />');

        expect($html)
            ->toContain('run(\'bold\')')
            ->toContain('run(\'undo\')')
            ->not->toContain('run(\'italic\')');
    });

    it('renders an editable content region', function () {
        expect(renderComponent('editor', 'placeholder="Write your notes"'))
            ->toContain('data-slot="editor-content"')
            ->toContain('data-placeholder="Write your notes"');
    });
});

describe('select', function () {
    it('is driven by the select behaviour', function () {
        expect(renderComponent('select'))->toContain('x-data="select(');
    });

    it('is a single select by default', function () {
        expect(renderComponent('select'))->toContain('select(false, false)');
    });

    it('takes a multiple select', function () {
        expect(renderComponent('select', 'multiple'))->toContain('select(true, false)');
    });

    it('takes a disabled select', function () {
        expect(renderComponent('select', 'disabled'))->toContain('select(false, true)');
    });

    it('submits its value through a hidden input', function () {
        expect(renderComponent('select', 'name="country"'))
            ->toContain('type="hidden"')
            ->toContain('name="country"');
    });

    it('keeps a native select in the markup for progressive enhancement', function () {
        expect(renderComponent('select'))->toContain('<select class="hidden">');
    });

    it('renders a trigger button', function () {
        expect(renderComponent('select'))->toContain('x-bind="trigger"');
    });

    it('renders its options into the hidden native select', function () {
        $html = render('<april:select><april:select-option value="ng">Nigeria</april:select-option></april:select>');

        expect($html)->toContain('<option')->toContain('value="ng"')->toContain('Nigeria');
    });

    it('initializes from the bound model before option defaults', function () {
        $source = file_get_contents(__DIR__.'/../../../resources/js/select.js');

        expect($source)
            ->toContain('if (this.hasModelBinding()) this.syncOptionsToValues(values)')
            ->toContain('if (this.hasModelBinding()) {')
            ->toContain('this.setSelectedValues()');
    });

    it('uses the first enabled option when a bound value is empty', function () {
        $source = file_get_contents(__DIR__.'/../../../resources/js/select.js');

        expect($source)
            ->toContain('if (!this.multiple && selectedValues.length === 0)')
            ->toContain('const firstAvailable = this.options.findIndex((option) => !option.disabled);')
            ->toContain('this.setSelectedValues();');
    });
});

describe('select option', function () {
    it('renders an option element', function () {
        expect(renderComponent('select-option', 'value="ng"', 'Nigeria'))
            ->toContain('<option')
            ->toContain('value="ng"')
            ->toContain('Nigeria');
    });

    it('is enabled and unselected by default', function () {
        expect(renderComponent('select-option', 'value="ng"'))
            ->not->toContain('disabled')
            ->not->toContain('selected');
    });

    it('can be disabled', function () {
        expect(renderComponent('select-option', 'value="ng" :disabled="true"'))->toContain('disabled');
    });

    it('can be selected', function () {
        expect(renderComponent('select-option', 'value="ng" :selected="true"'))->toContain('selected');
    });

    it('forwards any other attribute', function () {
        expect(renderComponent('select-option', 'value="ng" data-region="west"'))
            ->toContain('data-region="west"');
    });
});

describe('calendar', function () {
    it('is driven by the calendar behaviour', function () {
        expect(renderComponent('calendar'))->toContain('x-data="calendar(');
    });

    it('uses the single mode by default', function () {
        expect(renderComponent('calendar'))->toContain("calendar('', 'single'");
    });

    it('takes a range mode', function () {
        expect(renderComponent('calendar', 'mode="range"'))->toContain("calendar('', 'range'");
    });

    it('renders month and year labels', function () {
        expect(renderComponent('calendar'))
            ->toContain('x-bind="monthLabel"')
            ->toContain('x-bind="yearLabel"');
    });

    it('renders the month navigation', function () {
        expect(renderComponent('calendar'))
            ->toContain('x-bind="previousMonthTrigger"')
            ->toContain('x-bind="nextMonthTrigger"');
    });

    it('keeps each cell loop to a single Alpine root', function () {
        $html = renderComponent('calendar');

        preg_match_all(
            '/<template x-for="cell in week\.cells"[^>]*>(.*?)<\/template>/s',
            $html,
            $matches,
        );

        expect($matches[1])->not->toBeEmpty();

        foreach ($matches[1] as $template) {
            expect(preg_match_all('/<div class="contents">/', $template))->toBe(1);
            expect($template)->not->toContain('x-if=');
        }
    });

    it('supports shadcn-style calendar options', function () {
        expect(renderComponent('calendar', 'captionLayout="dropdown" :showWeekNumber="true" :showOutsideDays="false" :numberOfMonths="2"'))
            ->toContain('captionLayout')
            ->toContain('showWeekNumber')
            ->toContain('monthViews')
            ->toContain('Select month')
            ->toContain('Select year');
    });

    it('lets a user class win over the default width', function () {
        expect(classesOf(renderComponent('calendar', 'class="w-full"')))
            ->toContain('w-full')
            ->not->toContain('w-[19rem]');
    });

    it('gives multiple months enough room to render side by side', function () {
        $html = renderComponent('calendar', ':numberOfMonths="2"');

        expect($html)
            ->toContain('data-calendar-months="2"')
            ->toContain('x-text="monthView.label"')
            ->toContain('numberOfMonths > 1');

        expect(classesOf($html))
            ->toContain('w-full')
            ->toContain('max-w-full')
            ->not->toContain('w-[19rem]');
    });

    it('keeps a selected date within a multi-month view anchored', function () {
        $source = file_get_contents(__DIR__.'/../../../resources/js/calendar.js');

        expect($source)
            ->toContain('if (!this.isDateInView(selectedDate))')
            ->toContain('isDateInView(date)');
    });
});

describe('date picker', function () {
    it('is driven by the date picker behaviour', function () {
        expect(renderComponent('date-picker'))->toContain("x-data='datePicker(");
    });

    it('uses the default date format', function () {
        expect(renderComponent('date-picker'))->toContain('MM\/dd\/yyyy');
    });

    it('takes a custom date format', function () {
        expect(renderComponent('date-picker', 'format="yyyy-MM-dd"'))->toContain('yyyy-MM-dd');
    });

    it('shows a placeholder until a date is picked', function () {
        expect(renderComponent('date-picker'))->toContain('Pick a date');
    });

    it('renders a trigger button', function () {
        expect(renderComponent('date-picker'))->toContain('x-bind="trigger"');
    });

    it('submits its value through a hidden input', function () {
        expect(renderComponent('date-picker', 'name="due_at"'))
            ->toContain('type="hidden"')
            ->toContain('name="due_at"');
    });
});

describe('input group', function () {
    it('renders a label and an input together', function () {
        $html = render('<april:input-group name="email"><x-slot:label>Email</x-slot:label></april:input-group>');

        expect($html)->toContain('<label')->toContain('Email')->toContain('<input');
    });

    it('names the input', function () {
        expect(renderComponent('input-group', 'name="email"'))->toContain('name="email"');
    });

    it('renders input attributes only once', function () {
        $html = renderComponent('input-group', 'name="email" id="email" autocomplete="email"');

        expect(substr_count($html, 'id="email"'))->toBe(1)
            ->and(substr_count($html, 'autocomplete="email"'))->toBe(1);
    });

    it('stacks the label above the input by default', function () {
        expect(renderComponent('input-group', 'name="email"'))->toContain('flex-col');
    });

    it('lays a choice input out inline', function () {
        expect(renderComponent('input-group', 'name="terms" type="checkbox"'))->toContain('flex-row');
    });

    it('uses the normal border when the field is valid', function () {
        expect(renderComponent('input-group', 'name="email"'))->toContain('border-input');
    });

    it('marks the field when it has a validation error', function () {
        View::share('errors', tap(new ViewErrorBag)->put('default', new MessageBag([
            'email' => ['The email is invalid.'],
        ])));

        expect(renderComponent('input-group', 'name="email"'))->toContain('border-destructive');
    });

    it('can be told to ignore validation errors', function () {
        View::share('errors', tap(new ViewErrorBag)->put('default', new MessageBag([
            'email' => ['The email is invalid.'],
        ])));

        expect(renderComponent('input-group', 'name="email" prevent-errors'))
            ->not->toContain('border-destructive');
    });

    it('reads from a named error bag', function () {
        View::share('errors', tap(new ViewErrorBag)->put('signup', new MessageBag([
            'email' => ['The email is invalid.'],
        ])));

        expect(renderComponent('input-group', 'name="email" error-bag="signup"'))
            ->toContain('border-destructive');
    });
});
