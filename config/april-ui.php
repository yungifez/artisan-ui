<?php

// config for Yungifez/AprilUi
return [
    /*
    |--------------------------------------------------------------------------
    | Tailwind merge
    |--------------------------------------------------------------------------
    |
    | April UI merges the Tailwind classes of a component with the classes you
    | pass to it. These options configure that merge. Change them only if you
    | use a custom Tailwind config.
    |
    */

    'tailwind_merge' => [
        /*
         | The prefix of your Tailwind classes, if you use one.
         */
        'prefix' => null,

        /*
         | Number of merge results to keep in memory. Set to 0 to disable.
         */
        'cacheSize' => 500,

        /*
         | Extra class groups. Use this when a custom Tailwind value does not
         | merge correctly. For example, a custom font size of 'very-large':
         |
         | 'classGroups' => [
         |     'font-size' => [
         |         ['text' => ['very-large']],
         |     ],
         | ],
         */
        'classGroups' => [],
    ],
];
