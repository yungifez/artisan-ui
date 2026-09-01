<div x-data="{ value: [] }" @value-change="value = $event.detail.value" class="flex max-w-72 flex-col items-center">
    <april:calendar class="rounded-md border" mode="multiple" max="5"
        :selected="[now(), now()->addDays(2), now()->addDays(14)]"
        />
    <p x-text="'Selected dates are '+value.toString()" class="my-2 wrap-break-word"></p>
</div>
