<?php

namespace Yungifez\ArtisanUi\Commands;

use Illuminate\Console\Command;

class ArtisanUiCommand extends Command
{
    public $signature = 'artisan-ui';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
