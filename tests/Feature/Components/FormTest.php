<?php

describe('input', function () {
    it('renders an input element', function () {
        expect(renderComponent('input'))->toContain('<input');
    });

    it('uses the text type by default', function () {
        expect(renderComponent('input'))->toContain('type="text"');
    });

    it('applies the type', function (string $type) {
        expect(renderComponent('input', "type=\"{$type}\""))->toContain("type=\"{$type}\"");
    })->with(['email', 'password', 'number', 'date', 'file', 'search']);

    it('styles a text input as a field', function () {
        expect(classesOf(renderComponent('input')))
            ->toContain('h-10')
            ->toContain('rounded-md')
            ->toContain('border-input');
    });

    it('styles a checkbox as a choice input', function () {
        expect(classesOf(renderComponent('input', 'type="checkbox"')))
            ->toContain('checkbox-clip-path')
            ->toContain('cursor-pointer')
            ->not->toContain('h-10');
    });

    it('styles a radio as a choice input', function () {
        expect(classesOf(renderComponent('input', 'type="radio"')))
            ->toContain('radio-clip-path')
            ->not->toContain('h-10');
    });

    it('lets the caller force the choice input styles', function () {
        expect(classesOf(renderComponent('input', 'type="text" :is-choice-input="true"')))
            ->toContain('appearance-none')
            ->not->toContain('h-10');
    });

    it('forwards a name attribute', function () {
        expect(renderComponent('input', 'name="email"'))->toContain('name="email"');
    });

    it('forwards a placeholder', function () {
        expect(renderComponent('input', 'placeholder="you@example.com"'))
            ->toContain('placeholder="you@example.com"');
    });

    it('lets a user class win over the default', function () {
        expect(classesOf(renderComponent('input', 'class="h-14"')))
            ->toContain('h-14')
            ->not->toContain('h-10');
    });
});

describe('checkbox', function () {
    it('renders a checkbox input', function () {
        expect(renderComponent('checkbox'))
            ->toContain('<input')
            ->toContain('type="checkbox"');
    });

    it('applies the checked state colours', function () {
        expect(classesOf(renderComponent('checkbox')))->toContain('checked:bg-primary');
    });

    it('forwards a name attribute', function () {
        expect(renderComponent('checkbox', 'name="terms"'))->toContain('name="terms"');
    });
});

describe('slider', function () {
    it('renders a range input', function () {
        expect(renderComponent('slider'))
            ->toContain('<input')
            ->toContain('type="range"');
    });

    it('removes the field border', function () {
        expect(classesOf(renderComponent('slider')))->toContain('border-none');
    });

    it('forwards min and max attributes', function () {
        expect(renderComponent('slider', 'min="0" max="100"'))
            ->toContain('min="0"')
            ->toContain('max="100"');
    });
});

describe('textarea', function () {
    it('renders a textarea element', function () {
        expect(renderComponent('textarea'))->toContain('<textarea');
    });

    it('applies a minimum height', function () {
        expect(classesOf(renderComponent('textarea')))->toContain('min-h-[80px]');
    });

    it('forwards a rows attribute', function () {
        expect(renderComponent('textarea', 'rows="6"'))->toContain('rows="6"');
    });
});

describe('label', function () {
    it('renders a label element with its slot', function () {
        expect(renderComponent('label', '', 'Email'))
            ->toContain('<label')
            ->toContain('Email');
    });

    it('forwards a for attribute', function () {
        expect(renderComponent('label', 'for="email"'))->toContain('for="email"');
    });

    it('dims the label when the field is disabled', function () {
        expect(classesOf(renderComponent('label')))->toContain('peer-disabled:opacity-70');
    });
});

describe('native select', function () {
    it('renders a select element with its options', function () {
        $html = renderComponent('native-select', '', '<option value="1">One</option>');

        expect($html)->toContain('<select')->toContain('<option value="1">One</option>');
    });

    it('forwards a name attribute', function () {
        expect(renderComponent('native-select', 'name="country"'))->toContain('name="country"');
    });

    it('styles the select like the text input', function () {
        expect(classesOf(renderComponent('native-select')))
            ->toContain('h-10')
            ->toContain('rounded-md')
            ->toContain('border-input');
    });
});

describe('switch', function () {
    it('renders a switch role', function () {
        expect(renderComponent('switch'))->toContain('role="switch"');
    });

    it('is driven by the alpine behaviour', function () {
        expect(renderComponent('switch'))->toContain('x-data="switchInput(');
    });

    it('holds the value in a hidden checkbox', function () {
        expect(renderComponent('switch'))->toContain('type="checkbox"');
    });

    it('moves the name onto the hidden checkbox', function () {
        $html = renderComponent('switch', 'name="notify"');

        expect($html)->toContain('name="notify"')
            ->and(classesOf($html))->not->toContain('name');
    });

    it('marks the hidden checkbox as checked', function () {
        expect(renderComponent('switch', 'checked'))->toContain('checked');
    });

    it('tells the behaviour that the switch is disabled', function () {
        expect(renderComponent('switch', 'disabled'))->toContain('switchInput(true)');
    });

    it('tells the behaviour that the switch is enabled', function () {
        expect(renderComponent('switch'))->toContain('switchInput(false)');
    });
});

describe('input group', function () {
    it('renders without a validation error', function () {
        expect(renderComponent('input-group', 'name="email"'))->toBeString()->not->toBeEmpty();
    });
});
