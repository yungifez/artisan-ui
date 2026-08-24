<?php

namespace Yungifez\AprilUI\Livewire;

use Illuminate\Support\ServiceProvider;

class AprilLivewireServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'april-livewire');
    }
}
