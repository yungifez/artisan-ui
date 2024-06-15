<?php

namespace Yungifez\ArtisanUI;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Yungifez\ArtisanUI\Handlers\FrontendAssetsHandler;

class ArtisanUIServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('artisan-ui')
            ->hasConfigFile()
            ->hasRoute('assets')
            ->hasViews('aui');

    }

    public function packageBooted()
    {
        app(FrontendAssetsHandler::class)->boot();
    }
}
