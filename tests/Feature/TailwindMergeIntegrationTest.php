<?php

use Illuminate\View\ComponentAttributeBag;
use TalesFromADev\TailwindMerge\TailwindMerge;
use TalesFromADev\TailwindMerge\TailwindMergeInterface;
use Yungifez\AprilUI\Support\TailwindMerger;

describe('container bindings', function () {
    it('binds the merge contract', function () {
        expect(app(TailwindMergeInterface::class))->toBeInstanceOf(TailwindMerge::class);
    });

    it('shares one merge instance', function () {
        expect(app(TailwindMergeInterface::class))->toBe(app(TailwindMergeInterface::class));
    });

    it('shares one merger instance', function () {
        expect(app(TailwindMerger::class))->toBe(app(TailwindMerger::class));
    });

    it('reads the prefix from the package config', function () {
        config()->set('april-ui.tailwind_merge.prefix', 'tw');
        app()->forgetInstance(TailwindMergeInterface::class);

        expect(twMerge('tw:p-2', 'tw:p-4'))->toBe('tw:p-4');
    });

    it('reads custom class groups from the package config', function () {
        config()->set('april-ui.tailwind_merge.classGroups', [
            'font-size' => [['text' => ['very-large']]],
        ]);
        app()->forgetInstance(TailwindMergeInterface::class);

        expect(twMerge('text-sm', 'text-very-large'))->toBe('text-very-large');
    });

    it('ships a config file with a tailwind merge section', function () {
        expect(config('april-ui.tailwind_merge'))
            ->toBeArray()
            ->toHaveKeys(['prefix', 'cacheSize', 'classGroups']);
    });
});

describe('the twMerge helper', function () {
    it('is registered globally', function () {
        expect(function_exists('twMerge'))->toBeTrue();
    });

    it('merges conflicting classes', function () {
        expect(twMerge('p-2', 'p-4'))->toBe('p-4');
    });

    it('accepts an array', function () {
        expect(twMerge(['flex', 'p-2', 'p-4']))->toBe('flex p-4');
    });

    it('resolves through the container', function () {
        expect(twMerge('text-sm'))->toBe(app(TailwindMerger::class)->merge('text-sm'));
    });
});

describe('the twMerge attribute bag macro', function () {
    it('is registered on the attribute bag', function () {
        expect(ComponentAttributeBag::hasMacro('twMerge'))->toBeTrue();
    });

    it('lets a user class win over the component default', function () {
        $bag = (new ComponentAttributeBag(['class' => 'p-8']))->twMerge(['p-2']);

        expect($bag->get('class'))->toBe('p-8');
    });

    it('keeps the component default when the user passes no class', function () {
        $bag = (new ComponentAttributeBag)->twMerge(['rounded-md border']);

        expect($bag->get('class'))->toBe('rounded-md border');
    });

    it('keeps non conflicting user classes alongside the default', function () {
        $bag = (new ComponentAttributeBag(['class' => 'shadow-lg']))->twMerge(['rounded-md']);

        expect(classesOf($bag->toHtml()))
            ->toContain('rounded-md')
            ->toContain('shadow-lg');
    });

    it('returns the attribute bag so calls can be chained', function () {
        $bag = new ComponentAttributeBag(['class' => 'p-8', 'id' => 'demo']);

        expect($bag->twMerge(['p-2']))->toBeInstanceOf(ComponentAttributeBag::class);
    });

    it('preserves the other attributes', function () {
        $bag = (new ComponentAttributeBag(['id' => 'demo', 'data-state' => 'open']))
            ->twMerge(['p-2']);

        expect($bag->get('id'))->toBe('demo')
            ->and($bag->get('data-state'))->toBe('open');
    });

    it('supports the conditional array syntax', function () {
        $bag = (new ComponentAttributeBag)->twMerge(['p-2', 'hidden' => false, 'flex' => true]);

        expect(classesOf($bag->toHtml()))
            ->toContain('flex')
            ->not->toContain('hidden');
    });

    it('accepts several arguments', function () {
        $bag = (new ComponentAttributeBag)->twMerge('p-2', 'p-4');

        expect($bag->get('class'))->toBe('p-4');
    });

    it('renders a class attribute into the html', function () {
        $bag = (new ComponentAttributeBag(['id' => 'demo']))->twMerge(['p-2']);

        expect($bag->toHtml())
            ->toContain('class="p-2"')
            ->toContain('id="demo"');
    });

    it('produces an empty class list when nothing is given', function () {
        $bag = (new ComponentAttributeBag)->twMerge([]);

        expect($bag->get('class'))->toBe('');
    });

    it('works inside a rendered component', function () {
        $html = renderComponent('skeleton', 'class="rounded-none h-4"');

        expect(classesOf($html))
            ->toContain('rounded-none')
            ->toContain('h-4')
            ->toContain('animate-pulse')
            ->not->toContain('rounded-md');
    });
});
