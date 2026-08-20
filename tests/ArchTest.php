<?php

arch('does not leave debug calls in the source')
    ->expect(['dd', 'dump', 'var_dump', 'ray', 'die', 'exit'])
    ->not->toBeUsed();

arch('keeps the source in the package namespace')
    ->expect('Yungifez\AprilUI')
    ->toOnlyBeUsedIn('Yungifez\AprilUI');

arch('keeps handlers in the handler namespace')
    ->expect('Yungifez\AprilUI\Handlers')
    ->toHaveSuffix('Handler');

arch('does not depend on the old tailwind merge fork')
    ->expect('TailwindMerge')
    ->not->toBeUsed();
