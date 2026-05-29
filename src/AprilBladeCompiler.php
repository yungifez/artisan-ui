<?php

namespace Yungifez\AprilUI;

<<<<<<< HEAD:src/ArtisanBladeCompiler.php
class ArtisanBladeCompiler
{
    public function __construct(
        protected ArtisanComponentTagCompiler $tagCompiler
=======

class AprilBladeCompiler
{
      public function __construct(
        protected AprilComponentTagCompiler $tagCompiler
>>>>>>> 197f1a7 (Rename Artisan UI to April UI):src/AprilBladeCompiler.php
    ) {}

    public function compile(string $value): string
    {
        return $this->tagCompiler->compile($value);
    }
}
