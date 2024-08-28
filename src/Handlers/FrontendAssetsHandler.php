<?php

namespace Yungifez\ArtisanUI\Handlers;

use Illuminate\Support\Facades\Blade;

class FrontendAssetsHandler
{
    public function boot()
    {
        $distPath = __DIR__.'/../../dist/';
        $manifest = file_get_contents($distPath.'manifest.json');
        $manifestHashes = json_decode($manifest, true);

        Blade::directive('artisanStyles', function () use ($manifestHashes) {
            $html = '';
            if (config('app.debug') == 'true') {
                $html = "<?php echo '<link rel=\"stylesheet\" href=\"".route('artisan-ui.artisan.css').'?ver='.$manifestHashes['/artisan.css']."\">' ; ?>";
            } else {
                $html = "<?php echo '<link rel=\"stylesheet\" href=\"".route('artisan-ui.artisan.min.css').'?ver='.$manifestHashes['/artisan.css']."\">' ; ?>";
            }

            return $html;
        });

        Blade::directive('artisanScripts', function () use ($manifestHashes)  {
            $html = '';
            if (config('app.debug') == 'true') {
                $html = "<?php echo '<script src=\"".route('artisan-ui.artisan.js').'?ver='.$manifestHashes['/artisan.js']."\"></script>' ; ?>";
            } else {
                $html = "<?php echo '<script src=\"".route('artisan-ui.artisan.min.js').'?ver='.$manifestHashes['/artisan.js']."\"></script>' ; ?>";
            }

            return $html;
        });

    }
}
