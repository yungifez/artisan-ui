<div x-data="{value: []}" class="max-w-72">
    <april:calendar class="rounded-md border" mode="multiple"
        :selected="[now(), now()->addDays(2),  now()->addDays(14)]" @value-change="
            value = []
            $event.detail.value.forEach(
                element => value.push(element)
            )
        " />
    <p x-text="'Selected dates are '+value.toString()" class="my-2 wrap-break-word"></p>
</div>
