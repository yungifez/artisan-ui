<?php

declare(strict_types=1);

namespace Yungifez\AprilUI\Handlers;

use Illuminate\View\ComponentAttributeBag;
use Yungifez\AprilUI\Support\TailwindMerger;

/**
 * Registers the Blade integration for Tailwind class merging.
 *
 * The upstream library is framework agnostic, so April UI supplies the
 * attribute bag macro and the Blade directive itself.
 */
class TailwindMergeHandler
{
    public function boot(): void
    {
        $this->registerAttributeBagMacro();
    }

    /**
     * Add the twMerge macro to the component attribute bag.
     *
     * The classes given by the component are merged first. The classes already
     * on the attribute bag are merged last, so a class passed by the user wins
     * over the component default.
     */
    protected function registerAttributeBagMacro(): void
    {
        if (ComponentAttributeBag::hasMacro('twMerge')) {
            return;
        }

        ComponentAttributeBag::macro('twMerge', function (...$args): ComponentAttributeBag {
            /** @var ComponentAttributeBag $this */
            $merged = app(TailwindMerger::class)->merge($args, $this->get('class', ''));

            $this->offsetSet('class', $merged);

            return $this;
        });
    }
}
