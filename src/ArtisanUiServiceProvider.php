<?php

namespace Yungifez\ArtisanUi;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Yungifez\ArtisanUi\Commands\ArtisanUiCommand;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ArtisanUiServiceProvider extends PackageServiceProvider
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
            ->hasViews("artisan-ui")
            ->hasCommand(ArtisanUiCommand::class);
    }
}
