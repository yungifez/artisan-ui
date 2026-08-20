<april:calendar class="rounded-md border" mode="single" :disabled="[
        ['before' => now()->subDays(10), 'after' => now()->addDays(10)],
        ['dates' => [now(), now()->subDays(1)]],
        ['dayOfWeek' => 3],
        ['dayOfWeek' => 5]
    ]" />
