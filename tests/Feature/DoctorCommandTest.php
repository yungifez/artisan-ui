<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

describe('the April UI doctor command', function () {
    it('reports buttons inside forms that have no explicit type', function () {
        $path = sys_get_temp_dir().'/april-doctor-'.uniqid('', true);
        File::makeDirectory($path, 0755, true);
        File::put($path.'/checkout.blade.php', <<<'BLADE'
<form>
    <april:button>Submit order</april:button>
</form>
BLADE);

        try {
            $exitCode = Artisan::call('april:doctor', ['path' => $path, '--compiled' => $path.'/missing-compiled']);
            $output = Artisan::output();

            expect($exitCode)->toBe(1)
                ->and($output)->toContain('button inside a form has no type', 'checkout.blade.php');
        } finally {
            File::deleteDirectory($path);
        }
    });

    it('accepts explicit types and interactive button handlers', function () {
        $path = sys_get_temp_dir().'/april-doctor-'.uniqid('', true);
        File::makeDirectory($path, 0755, true);
        File::put($path.'/safe.blade.php', <<<'BLADE'
{{-- <form><april:button>commented out</april:button></form> --}}
<form>
    <april:button type="submit">Submit order</april:button>
    <april:button @click="save">Save draft</april:button>
</form>
BLADE);

        try {
            $exitCode = Artisan::call('april:doctor', ['path' => $path, '--compiled' => $path.'/missing-compiled']);
            $output = Artisan::output();

            expect($exitCode)->toBe(0)
                ->and($output)->toContain('No April UI integration problems found.');
        } finally {
            File::deleteDirectory($path);
        }
    });

    it('detects unresolved April tags in compiled views', function () {
        $path = sys_get_temp_dir().'/april-doctor-'.uniqid('', true);
        $compiled = $path.'/compiled';
        File::makeDirectory($compiled, 0755, true);
        File::put($path.'/safe.blade.php', '<div>safe</div>');
        File::put($compiled.'/view.php', '<april:button>still unresolved</april:button>');

        try {
            $exitCode = Artisan::call('april:doctor', [
                'path' => $path,
                '--compiled' => $compiled,
            ]);
            $output = Artisan::output();

            expect($exitCode)->toBe(1)
                ->and($output)->toContain('an April tag reached compiled output', 'view.php');
        } finally {
            File::deleteDirectory($path);
        }
    });

    it('fails clearly when the scan directory does not exist', function () {
        $path = sys_get_temp_dir().'/april-doctor-missing-'.uniqid('', true);

        expect(Artisan::call('april:doctor', ['path' => $path]))->toBe(1)
            ->and(Artisan::output())->toContain('Not a directory');
    });
});
