@php
    $data = [
        ['month' => 'Jan', 'desktop' => 186, 'mobile' => 80],
        ['month' => 'Feb', 'desktop' => 305, 'mobile' => 200],
    ];

    $config = [
        'desktop' => ['label' => 'Desktop', 'color' => 'var(--chart-1)'],
        'mobile' => ['label' => 'Mobile', 'color' => 'var(--chart-2)'],
    ];
@endphp

<april:chart label="Monthly visitors" :data="$data" :config="$config" xKey="month">
    <slot:header>
        <h3>Monthly visitors</h3>
    </slot:header>
</april:chart>
