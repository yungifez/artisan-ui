<div x-data="{value: []}" class="max-w-72">
    <april:calendar class="rounded-md border" mode="range" :selected="['from' => now(), 'to' => now()->addDays(14)]"
        max="15" min="6" @value-change="
            value = []
            value['from'] = $event.detail.value.from
            value['to'] = $event.detail.value.to
        " />
    <p x-text="'Selected range is from '+value['from']+' to '+value['to']" class="my-2 wrap-break-word"></p>
</div>
