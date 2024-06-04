@props([
'name' => '',
'errorBag' => 'default',
'errorName',
'oldName' => '',
'label'
])

@php
$errorName = $errorName ?? $name;
$oldName = $oldName ?? $name;
$displayErrors = $errors->$errorBag->has($errorName) && !$attributes->has("prevent-errors");
@endphp

<div class="flex flex-col">
    @isset ($label)
    <label for="{{$attributes->get('id')}}" @if ($label instanceof Illuminate\View\ComponentSlot)
        {{$label->attributes->class(['font-semibold my-2'])}} @else class="font-semibold my-2" @endif
        >
        {{$label}}
    </label>
    @endisset
    {{--select--}}
    <div x-data="select({{$attributes->has('multiple') ? 'true' : 'false'}}, {{$attributes->has('disabled') ? 'true' : 'false'}})"
        x-bind="root">
        <select class="hidden" {{$attributes->except(['class'])}}>
            {{$slot}}
        </select>

        <div class="w-full relative">
            {{--secretly use inputs for form submission--}}
            <template x-for="selectedItem in selected ">
                <input type="hidden" name="{{$name}}" :value="options[selectedItem].value">
            </template>
            <button x-bind="trigger" @class(["flex min-h-10 w-full items-center justify-between rounded-md border
                bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground
                focus:outline-none focus:ring-2 focus:ring-ring disabled:cursor-not-allowed
                disabled:opacity-50", "border-input "=> !$displayErrors,
                'border-destructive' => $displayErrors]) x-ref="select" type="button">
                <div class="flex flex-auto flex-wrap gap-y-1">
                    {{--display selected single items--}}
                    <template x-if="!multiple && selected.length > 0">
                        <p class="cursor-default" x-text="options[selected[selected.length - 1]].text">
                        </p>
                    </template>
                    {{--display selected multiple items--}}
                    <template x-if="multiple">
                        <template x-for="(option,index) in selected" :key="options[option].value">
                            <div class="bg-muted flex mx-1">
                                <p class="text-xs font-normal leading-none max-w-full flex-initial pl-1 py-1 "
                                    x-model="options[option]" x-text="options[option].text"></p>
                                <div class="flex flex-auto flex-row-reverse">
                                    <button x-on:click="remove(index,option)" class="px-2 py-1" type="button">
                                        <x-aui::x class="fill-foreground h-2" />
                                    </button>
                                </div>
                            </div>
                        </template>
                    </template>
                    {{--display when no items are selected --}}
                    <p class="text-xs" x-show="selected.length  == 0">
                        {{$attributes->get('placeholder') ?? "Select Options"}}
                    </p>
                </div>
                <div class="w-6 pl-3 flex items-center">
                    <x-aui::angle-down class="w-8/12 transition text-center fill-foreground"
                        ::class="{'-rotate-180' : isOpen()}" />
                </div>
            </button>
            <div x-bind="optionList"
                class="absolute shadow top-100 border-input bg-background z-20 w-full rounded border max-h-80 overflow-y-scroll">
                <div class="flex flex-col w-full">
                    <template x-for="(option,index) in options" :key="index">
                        <button
                            class="cursor-pointer rounded-t outline-none flex w-full items-center py-1 relative hover:bg-accent/60 hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground"
                            @click="select(index,$event)" type="button">
                            <div class="w-full items-center flex">
                                <div class="ml-2 w-3">
                                    <svg x-show="options[index].selected" class="fill-foreground" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                    </svg>
                                </div>
                                <div class="ml-3 leading-6 text-sm" x-model="option" x-text="option.text"></div>
                            </div>
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>
    @if($displayErrors)
    @error($errorName, $errorBag)
    <p class="text-destructive text-sm mt-2 order-3 basis-full">{{$message}}</p>
    @enderror
    @endif
</div>
