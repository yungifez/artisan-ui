<?php

namespace Yungifez\ArtisanUI;


class ArtisanBladeCompiler
{
      public function __construct(
        protected ArtisanComponentTagCompiler $tagCompiler
    ) {}

    public function compile(string $value): string
    {
        return $this->tagCompiler->compile($value);
    }
}
