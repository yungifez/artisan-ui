<?php

namespace Yungifez\AprilUI;

class AprilBladeCompiler
{
    public function __construct(
        protected AprilComponentTagCompiler $tagCompiler
    ) {}

    public function compile(string $value): string
    {
        return $this->tagCompiler->compile($value);
    }
}
