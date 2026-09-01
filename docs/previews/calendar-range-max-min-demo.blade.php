<div x-data="{ value: { from: null, to: null } }" @value-change="value = $event.detail.value" class="flex w-full max-w-72 flex-col items-center">
    <april:calendar class="rounded-md border" mode="range" :selected="['from' => now(), 'to' => now()->addDays(14)]"
        max="15" min="6" />
    <p x-text="'Selected range is from '+value['from']+' to '+value['to']" class="my-2 wrap-break-word"></p>
</div>
