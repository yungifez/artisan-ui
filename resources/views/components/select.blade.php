@props([
'name' => '',
'trigger'
])

<div x-data="select({{$attributes->has('multiple') ? 'true' : 'false'}}, {{$attributes->has('disabled') ? 'true' : 'false'}})"
    x-bind="root" x-modelable="selectedValues" {{$attributes->twMerge(['relative'])}}>
    <select class="hidden">
        {{$slot}}
    </select>
    {{--secretly use inputs for form submission--}}
    <template x-if="!multiple">
        <input type="hidden" name="{{$name}}" :value="selectedValues">
    </template>
    <template x-if="multiple">
        <template x-for="selectedItem in selectedValues">
            <input type="hidden" name="{{$name}}" :value="selectedItem">
        </template>
    </template>
    <div class="grid grid-cols-1 grid-rows-1">
        <button x-bind="trigger" x-ref="select" type="button" :class="{'border-muted' : disabled}" class="flex min-h-10 row-start-1 col-start-1
        w-full h-full items-center justify-between rounded-md border bg-background px-3 py-2 text-sm ring-offset-background
        placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring disabled:cursor-not-allowed
        disabled:opacity-50 {{(isset($trigger) ? $trigger?->attributes?->get('class') : '' )}}">
            <div class=" flex flex-auto gap-y-1">
                {{--display selected single items--}}
                <template x-if="!multiple && selected.length > 0">
                    <p class="cursor-default" x-text="options[selected[selected.length - 1]].text">
                    </p>
                </template>
                {{--display when no items are selected --}}
                <p class="text-xs" x-show="selected.length == 0">
                    @isset($trigger)
                    {{$trigger?->attributes->get('placeholder') ?? "Select Options"}}
                    @else
                    {{$attributes->get('placeholder') ?? "Select Options"}}
                    @endisset
                </p>
            </div>
            <div class="w-6 pl-3 flex items-center">
                <x-aui::angle-down class="w-8/12 transition text-center fill-foreground"
                    ::class="{'-rotate-180' : isOpen()}" />
            </div>
        </button>
        <div class="row-start-1 col-start-1 w-fit flex mr-9 flex-1 gap-y-1 flex-wrap mx-2 my-3">
            {{--display selected multiple items--}}
            <template x-if="multiple">
                <template x-for="(index) in selected" :key="options[index].value">
                    <div class="bg-muted flex mx-1">
                        <p class="text-xs font-normal leading-none max-w-full flex-initial pl-1 py-1 "
                            x-text="options[index].text"></p>
                        <div class="flex flex-auto flex-row-reverse">
                            <button x-on:click="remove(index)" class="px-2 py-1" type="button">
                                <x-aui::x class="fill-foreground h-2" />
                            </button>
                        </div>
                    </div>
                </template>
            </template>
        </div>
    </div>
    <div x-bind="optionList"
        class="absolute shadow top-100 border-input bg-background z-20 w-full rounded border max-h-80 overflow-y-auto">
        <div class="flex flex-col w-full">
            <template x-for="(option,index) in options" :key="index">
                <button
                    class="cursor-pointer rounded-t outline-none flex w-full items-center py-1 relative disabled:text-muted-foreground hover:bg-accent/60 hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground"
                    @click="select(index)" type="button" :disabled="options[index].disabled">
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
