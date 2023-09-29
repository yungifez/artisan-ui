<?php

namespace Yungifez\ArtisanUi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Yungifez\ArtisanUi\ArtisanUi
 */
class ArtisanUi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Yungifez\ArtisanUi\ArtisanUi::class;
    }
}
