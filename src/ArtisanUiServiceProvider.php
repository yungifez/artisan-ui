<?php

namespace Yungifez\ArtisanUi;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Yungifez\ArtisanUi\Commands\ArtisanUiCommand;

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
            ->hasViews('aui')
            ->hasCommand(ArtisanUiCommand::class);
    }
}
