@props([
'label' => '',
'open' => false,
'value' => "",
'mode' => 'single',
'format' => 'MM/dd/yyyy',
'fromName',
'toName',
])
<div x-data='datePicker(@json($open), @json($mode), @json($format), @json($value))' x-bind="root"
    class="w-full mb-5 min-w-96">
    @isset ($label)
    <label for="{{$attributes->get('id')}}" @if ($label instanceof Illuminate\View\ComponentSlot)
        {{$label->attributes->class(['font-semibold my-2'])}} @else class="font-semibold my-2" @endif
        >
        {{$label}}
    </label>
    @endisset
    <div class="relative w-full" x-ref="datePickerInput">
        <x-aui::button type="button" x-bind="trigger" variant="outline"
            :attributes="$attributes->class(['justify-start min-h-10 w-full h-fit text-left flex-wrap font-normal'])->except('type')">
            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <template x-if="mode != 'multiple' && mode != 'range'">
                <span>
                    <span x-text="value == null ? 'Pick a date' : formatDate(value)"></span>
                    <input type="hidden" {{$attributes}} :value="value" />
                </span>
            </template>
            <template x-if="mode == 'multiple'">
                <template x-if="!value">
                    <span>Select date(s)</span>
                </template>
                <template x-if="value">
                    <template x-for="(item, index) in value">
                        <span>
                            <span x-text="formatDate(item)" class="text-sm border-border mr-1"></span>
                            <input type="hidden" {{$attributes}} :value="item.toISOString().split('T')[0]" />
                        </span>
                    </template>
                </template>
            </template>
            <template x-if="mode == 'range'">
                <span class="min-h-5">
                    <template x-if="!value?.from && !value?.to">
                        <span>Pick a range of dates</span>
                    </template>
                    <template x-if="value?.from">
                        <span x-text="formatDate(value.from)"></span>
                    </template>
                    <template x-if="value?.to">
                        <span x-text="' - ' + formatDate(value.to)"></span>
                    </template>
                    <input type="hidden" name="{{$fromName ??  $attributes->get('name').'[\'from\']'}}" {{$attributes}}
                        :value="value?.from?.toISOString().split('T')[0]" />
                    <input type="hidden" name="{{$toName ??  $attributes->get('name').'[\'to\']'}}" {{$attributes}}
                        :value="value?.to?.toISOString().split('T')[0]" />
                </span>
            </template>
        </x-aui::button>
        <div x-bind="calendar" x-cloak class="z-10">
            <x-aui::calendar :required="$attributes->get('required')" :mode="$mode" :selected="$value" tabindex="0"
                class="outline-none" />
        </div>
    </div>
</div>
