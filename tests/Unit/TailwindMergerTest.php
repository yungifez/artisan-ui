<?php

use TalesFromADev\TailwindMerge\Support\Config;
use TalesFromADev\TailwindMerge\TailwindMerge;
use TalesFromADev\TailwindMerge\TailwindMergeInterface;
use Yungifez\AprilUI\Support\TailwindMerger;

function merger(array $config = []): TailwindMerger
{
    return new TailwindMerger(new TailwindMerge($config));
}

describe('conflict resolution', function () {
    it('keeps the last of two conflicting classes', function () {
        expect(merger()->merge('p-2', 'p-4'))->toBe('p-4');
    });

    it('keeps classes that do not conflict', function () {
        expect(merger()->merge('flex items-center', 'p-4'))
            ->toBe('flex items-center p-4');
    });

    it('treats a breakpoint variant as its own group', function () {
        expect(merger()->merge('p-2 md:p-4', 'p-6'))->toBe('md:p-4 p-6');
    });

    it('resolves conflicting colours', function () {
        expect(merger()->merge('text-red-500', 'text-blue-500'))->toBe('text-blue-500');
    });

    it('resolves an arbitrary value against a named value', function () {
        expect(merger()->merge('h-10', 'h-[3.5rem]'))->toBe('h-[3.5rem]');
    });

    it('resolves classes separated by newlines', function () {
        expect(merger()->merge("flex p-2\n   md:p-4\n p-6"))->toBe('flex md:p-4 p-6');
    });

    it('leaves an unknown class untouched', function () {
        expect(merger()->merge('checkbox-clip-path', 'p-2'))
            ->toBe('checkbox-clip-path p-2');
    });

    it('resolves padding shorthand against a single side', function () {
        expect(merger()->merge('px-3 py-2', 'p-6'))->toBe('p-6');
    });

    it('does not merge a single side into a shorthand', function () {
        expect(merger()->merge('p-6', 'px-3'))->toBe('p-6 px-3');
    });
});

describe('argument shapes', function () {
    it('accepts a list of strings', function () {
        expect(merger()->merge('flex', 'p-2', 'p-4'))->toBe('flex p-4');
    });

    it('accepts an array of classes', function () {
        expect(merger()->merge(['flex', 'p-2'], 'p-4'))->toBe('flex p-4');
    });

    it('flattens nested arrays', function () {
        expect(merger()->merge([['flex', ['p-2']], 'p-4']))->toBe('flex p-4');
    });

    it('uses a string key as the class when the value is truthy', function () {
        expect(merger()->merge(['flex' => true, 'hidden' => false]))->toBe('flex');
    });

    it('mixes positional classes with conditional keys', function () {
        expect(merger()->merge(['rounded-md', 'rounded-full' => true]))
            ->toBe('rounded-full');
    });

    it('drops a conditional class when the condition is falsy', function () {
        expect(merger()->merge(['p-2', 'p-4' => false]))->toBe('p-2');
    });

    it('skips null values', function () {
        expect(merger()->merge('flex', null, 'p-4'))->toBe('flex p-4');
    });

    it('skips false values', function () {
        expect(merger()->merge('flex', false, 'p-4'))->toBe('flex p-4');
    });

    it('skips empty strings', function () {
        expect(merger()->merge('', 'flex', ''))->toBe('flex');
    });

    it('returns an empty string when given nothing', function () {
        expect(merger()->merge())->toBe('');
    });

    it('returns an empty string when every argument is empty', function () {
        expect(merger()->merge('', null, false, []))->toBe('');
    });
});

describe('configuration', function () {
    it('honours a class prefix', function () {
        expect(merger(['prefix' => 'tw'])->merge('tw:p-2', 'tw:p-4'))->toBe('tw:p-4');
    });

    it('honours a custom class group', function () {
        $merger = merger([
            'classGroups' => [
                'font-size' => [['text' => ['very-large']]],
            ],
        ]);

        expect($merger->merge('text-sm', 'text-very-large'))->toBe('text-very-large');
    });

    it('is unaffected by a later instance built with other configuration', function () {
        $prefixed = merger(['prefix' => 'tw']);
        merger();

        expect($prefixed->merge('tw:p-2', 'tw:p-4'))->toBe('tw:p-4');
    });
});

afterEach(fn () => Config::reset());

it('implements merging through the library contract', function () {
    expect(new TailwindMerge)->toBeInstanceOf(TailwindMergeInterface::class);
});
