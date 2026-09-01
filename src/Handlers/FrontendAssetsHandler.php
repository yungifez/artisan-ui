<?php

namespace Yungifez\AprilUI\Handlers;

use Illuminate\Support\Facades\Blade;

class FrontendAssetsHandler
{
    public function boot()
    {
        $distPath = __DIR__.'/../../dist/';
        $manifest = file_get_contents($distPath.'manifest.json');
        $manifestHashes = json_decode($manifest, true);

        Blade::directive('aprilStyles', function () use ($manifestHashes) {
            $html = '';
            if (config('app.debug') == 'true') {
                $html = "<?php echo '<link rel=\"stylesheet\" href=\"".route('april-ui.april.css').'?ver='.$manifestHashes['/april.css']."\">' ; ?>";
            } else {
                $html = "<?php echo '<link rel=\"stylesheet\" href=\"".route('april-ui.april.min.css').'?ver='.$manifestHashes['/april.css']."\">' ; ?>";
            }

            return $html;
        });

        Blade::directive('aprilScripts', function () use ($manifestHashes) {
            $html = '';
            if (config('app.debug') == 'true') {
                $html = "<?php echo '<script src=\"".route('april-ui.april.js').'?ver='.$manifestHashes['/april.js']."\"></script>' ; ?>";
            } else {
                $html = "<?php echo '<script src=\"".route('april-ui.april.min.js').'?ver='.$manifestHashes['/april.js']."\"></script>' ; ?>";
            }

            return $html;
        });

        Blade::directive('aprilEditorScripts', function () use ($manifestHashes) {
            $html = '';
            $manifestHash = $manifestHashes['/editor.js'] ?? '';

            if (config('app.debug') == 'true') {
                $html = "<?php echo '<script src=\"".route('april-ui.editor.js').'?ver='.$manifestHash."\"></script>' ; ?>";
            } else {
                $html = "<?php echo '<script src=\"".route('april-ui.editor.min.js').'?ver='.$manifestHash."\"></script>' ; ?>";
            }

            return $html;
        });

    }
}
