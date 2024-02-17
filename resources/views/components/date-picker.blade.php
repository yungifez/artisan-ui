@props(['label' => '', 'id' => '', 'labelClass' => '', 'open' => "true", 'value' => "", "format" => "", "max" => "", "min" => ""])
<div
    x-data="{
        datePickerOpen: {{$open}},
        value: '{{$value}}',
    }"
>
    <div class="container py-2 mx-auto w-full">
        <div class="w-full mb-5" >
            @if (!empty($label))
                <label for="{{$id}}" @class(["$labelClass font-semibold dark:text-gray-200 text-gray-700 my-2"])>{{$label}}</label>
            @endif
            <div class="relative w-full"
                    x-ref="datePickerInput" >
                <x-artisan-ui::input
                    {{$attributes}}
                    type="text"
                    @click="datePickerOpen=!datePickerOpen"
                    x-model="value"
                    x-on:keydown.escape="datePickerOpen=false"
                    readonly
                />
                <div @click="datePickerOpen=!datePickerOpen; if(datePickerOpen){ $refs.datePickerInput.focus() }" class="absolute top-0 right-0 px-3 py-2 cursor-pointer text-neutral-400 hover:text-neutral-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <div x-show="datePickerOpen" @click.away="datePickerOpen = false" x-anchor.bottom-start.offset.2="$refs.datePickerInput">
                    <x-artisan-ui::calendar
                        :value="$value"
                        :format="$format"
                        :max="$max"
                        :min="$min"
                        x-cloak
                        onselect="value = this.calendarValue"
                    />
                </div>
            </div>
        </div>
    </div>
</div>
