<?php

namespace Yungifez\AprilUI;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Yungifez\AprilUI\Handlers\FrontendAssetsHandler;
use Illuminate\Support\Facades\File;

class AprilUIServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('april-ui')
            ->hasConfigFile()
            ->hasRoute('assets')
            ->hasViews('april');
    }

    public function packageBooted()
    {
        app(FrontendAssetsHandler::class)->boot();

        // publish individual views
        $basePath = __DIR__ . '/../resources/views/components';

        foreach (File::allFiles($basePath) as $file) {

            if (!str_ends_with($file->getFilename(), '.blade.php')) {
                continue;
            }

            $path = $file->getPathname();
            $relative = str_replace($basePath . '/', '', $path);

            $this->publishes([
                $path => resource_path("views/vendor/april/components/{$relative}"),
            ], 'april-view-' . str_replace(['/', '.blade.php'], ['-', ''], $relative));
        }

        // allow support for <aui:component syntax
        Blade::precompiler(function ($str) {
            return app(\Yungifez\AprilUI\AprilBladeCompiler::class)->compile($str);
        });
    }
}
