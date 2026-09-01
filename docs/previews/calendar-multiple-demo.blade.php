<div x-data="{ value: [] }" class="flex max-w-72 flex-col items-center">
    <april:calendar class="rounded-md border" mode="multiple"
        :selected="[now(), now()->addDays(2), now()->addDays(14)]"
        @value-change="value = $event.detail.value" />
    <p x-text="'Selected dates are '+value.toString()" class="my-2 wrap-break-word"></p>
</div>
