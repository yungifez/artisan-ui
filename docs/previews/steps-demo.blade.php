@php
    $steps = [
        ['value' => 1, 'label' => 'Account', 'description' => 'Create your account'],
        ['value' => 2, 'label' => 'Profile', 'description' => 'Add your details'],
        ['value' => 3, 'label' => 'Review', 'description' => 'Confirm your choices'],
    ];
@endphp

<april:steps :items="$steps" current="2" />
