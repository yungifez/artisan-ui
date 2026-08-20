<?php

function composerJson(): array
{
    return json_decode(file_get_contents(__DIR__.'/../../composer.json'), true);
}

describe('the package manifest', function () {
    it('is valid json', function () {
        expect(composerJson())->toBeArray();
    });

    it('requires the maintained tailwind merge package', function () {
        expect(composerJson()['require'])->toHaveKey('tales-from-a-dev/tailwind-merge-php');
    });

    it('does not require the abandoned fork', function () {
        expect(composerJson()['require'])
            ->not->toHaveKey('gehrisandro/tailwind-merge-laravel')
            ->not->toHaveKey('gehrisandro/tailwind-merge-php');
    });

    it('resolves every dependency from packagist', function () {
        expect(composerJson())->not->toHaveKey('repositories');
    });

    it('only accepts stable dependencies', function () {
        expect(composerJson()['minimum-stability'])->toBe('stable');
    });

    it('pins no dependency to a development branch', function () {
        foreach (composerJson()['require'] as $package => $constraint) {
            expect($constraint)->not->toStartWith('dev-', "{$package} is pinned to a branch.");
        }
    });

    it('autoloads the global helper file', function () {
        expect(composerJson()['autoload']['files'])->toContain('src/helpers.php');
    });

    it('registers the service provider for package discovery', function () {
        expect(composerJson()['extra']['laravel']['providers'])
            ->toContain('Yungifez\\AprilUI\\AprilUIServiceProvider');
    });
});
