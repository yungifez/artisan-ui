<?php

namespace Yungifez\ArtisanUI\Handlers;

use Illuminate\Support\Facades\Blade;

class FrontendAssetsHandler {
    public function boot() {
        Blade::directive('artisanStyles', function () {
            $html = '';
            if (config('app.debug') == 'true') {
                $html = "<?php echo '<link rel=\"stylesheet\" href=\"".route('artisan-ui.artisan.css')."\">' ; ?>";
            } else {
                $html = "<?php echo '<link rel=\"stylesheet\" href=\"".route('artisan-ui.artisan.min.css')."\">' ; ?>";
            }

            return  $html;
        });


        Blade::directive('artisanScripts', function () {
            $html = '';
            if (config('app.debug') == 'true') {
                $html = "<?php echo '<script src=\"".route('artisan-ui.artisan.js')."\"></script>' ; ?>";
            } else {
                $html = "<?php echo '<script src=\"".route('artisan-ui.artisan.min.js')."\"></script>' ; ?>";
            }

            return  $html;
        });
    }
}

