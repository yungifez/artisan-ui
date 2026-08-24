@php
    $activity = [
        ['month' => 'Jan', 'desktop' => 186, 'mobile' => 80],
        ['month' => 'Feb', 'desktop' => 305, 'mobile' => 200],
        ['month' => 'Mar', 'desktop' => 237, 'mobile' => 120],
        ['month' => 'Apr', 'desktop' => 73, 'mobile' => 190],
        ['month' => 'May', 'desktop' => 209, 'mobile' => 130],
        ['month' => 'Jun', 'desktop' => 214, 'mobile' => 140],
    ];

    $activityConfig = [
        'desktop' => ['label' => 'Desktop', 'color' => 'var(--chart-1)'],
        'mobile' => ['label' => 'Mobile', 'color' => 'var(--chart-2)'],
    ];
@endphp

<div class="grid gap-6 lg:grid-cols-2">
    <april:chart label="Monthly visitors" :data="$activity" :config="$activityConfig" xKey="month">
        <slot:header>
            <h3 class="font-semibold">Monthly visitors</h3>
            <p class="text-sm text-muted-foreground">Desktop and mobile visitors for the last six months.</p>
        </slot:header>
    </april:chart>

    <april:chart label="Visitor trend" :data="$activity" :config="$activityConfig" xKey="month" type="area" class="bg-muted/30">
        <slot:header>
            <h3 class="font-semibold">Visitor trend</h3>
            <p class="text-sm text-muted-foreground">The same data, displayed as an area chart.</p>
        </slot:header>
    </april:chart>
</div>
