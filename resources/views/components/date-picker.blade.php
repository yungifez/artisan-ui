@props([
'label' => '',
'open' => false,
'value' => "",
"format" => "",
"max" => "",
"min" => ""
])
<div x-data="datePicker({{$open ? 'true' : 'false'}}, {{$value}})" x-bind="root" class="w-full mb-5">
    @isset ($label)
    <label for="{{$attributes->get('id')}}" @if ($label instanceof Illuminate\View\ComponentSlot)
        {{$label->attributes->class(['font-semibold my-2'])}} @else class="font-semibold my-2" @endif
        >
        {{$label}}
    </label>
    @endisset
    <div class="relative w-full" x-ref="datePickerInput">
        <x-aui::input {{$attributes}} type="text" x-bind="input" readonly />
        <div class="absolute top-0 right-0 px-3 py-2 cursor-pointer text-neutral-400 hover:text-neutral-500">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        <div x-bind="calendar">
            <x-aui::calendar :value="$value" :format="$format" :max="$max" :min="$min" tabindex="0"
                class="outline-none" />
        </div>
    </div>
</div>
