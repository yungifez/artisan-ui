@props([
'label' => '',
'open' => false,
'value' => null,
'mode' => 'single',
'format' => 'MM/dd/yyyy',
'fromName',
'toName',
'parentClass' => ''
])
<div x-ref="datePickerInput" x-modelable="value"
    x-data='datePicker(@json($open), @json($value), @json($mode), @json($format))' x-bind="root" {{$attributes->
    class(['relative'])}}>
    <x-aui::button class="justify-start min-h-10 w-full h-fit text-left flex-wrap font-normal" type="button"
        x-bind="trigger" variant="outline">
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
            <span>
                <template x-if="!value">
                    <span>Select date(s)</span>
                </template>
                <template x-if="value">
                    <template x-for="(item, index) in value">
                        <span>
                            <span x-text="formatDate(item)" class="text-sm border-border mr-1"></span>
                            <input type="hidden" {{$attributes}}
                                :value="(new Date(item))?.toISOString().split('T')[0]" />
                        </span>
                    </template>
                </template>
            </span>
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
                    :value="(new Date(value))?.from?.toISOString().split('T')[0]" />
                <input type="hidden" name="{{$toName ??  $attributes->get('name').'[\'to\']'}}" {{$attributes}}
                    :value="(new Date(value))?.to?.toISOString().split('T')[0]" />
            </span>
        </template>
    </x-aui::button>
    <div x-bind="calendar" x-cloak class="z-10">
        <x-aui::calendar :required="$attributes->get('required')" :mode="$mode" :selected="$value" x-model="value"
            tabindex="0" class="outline-none" />
    </div>
</div>
