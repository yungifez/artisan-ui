<?php

namespace Yungifez\AprilUI;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Yungifez\AprilUI\Handlers\FrontendAssetsHandler;

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
        // $this->app->extend('blade.compiler', function ($blade, $app) {
        //
        //     $april = new AprilBladeCompiler(
        //         $app['files'],
        //         $app['config']['view.compiled']
        //     );
        //
        //     $april->setExtensions($blade->getExtensions());
        //     $april->setCompiledPath($blade->getCompiledPath());
        //
        //     return $april;
        // });
        Blade::precompiler(function ($str) {
            return app('\Yungifez\AprilUI\AprilBladeCompiler')->compile($str);
        });

    }
}
