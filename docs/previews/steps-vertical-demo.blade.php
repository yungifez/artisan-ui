@php
    $steps = [
        ['value' => 1, 'label' => 'Account', 'description' => 'Create your account', 'href' => '#account'],
        ['value' => 2, 'label' => 'Profile', 'description' => 'Add your details'],
        ['value' => 3, 'label' => 'Preferences', 'description' => 'Choose your settings'],
        ['value' => 4, 'label' => 'Review', 'description' => 'Confirm your choices'],
    ];
@endphp

<april:steps orientation="vertical" :items="$steps" current="2" />
