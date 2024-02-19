@props(
    [
        'id' => '',
        'name' => '',
        'label' => '',
        'value' => null,
        'class' => '',
        'groupClass' => 'my-3',
        'labelClass' => '',
        'errorBag' => 'default',
        'errorName' => '',
        'oldName' => '',

        'color' => 'bg-[color:var(--select-bg-color)] dark:bg-[color:var(--select-dark-bg-color)] text-[color:var(--select-text-color)] dark:text-[color:var(--select-dark-text-color)] border-[color:var(--select-border-color)] dark:border-[color:var(--select-dark-border-color)] placeholder-[color:var(--select-placeholder-color)] dark:placeholder-[var(--select-dark-placeholder-color)] focus:ring-[var(--select-accent-color)] dark:focus:ring-[color:var(--select-dark-accent-color)]',

        'labelColor' => 'text-[var(--select-text-color)] dark:text-[var(--select-dark-text-color)]',

        'defaultClass' => 'flex py-3 px-4 rounded-md border border-input px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50'
    ]
)

@php($errorName = $errorName == $errorName ?? $name)
@php($oldName = $oldName == '' ? $oldName : $name)

<div class="{{$groupClass}} my-2 flex flex-col" x-data="{'oldValue' : '{{old($name) ?? null }}'}">
    @isset($label)
        <label for="{{$id}}" @class(["$labelClass font-semibold text-gray-700 dark:text-gray-200 cursor-pointer my-2"])>{{$label}}</label>
    @endisset
    @if (!$attributes->has('multiple'))
        <select name="{{$name}}" id="{{$id}}" @class(["$color $class $defaultClass", 'border-red-500' => $errors->has($name)]) {{$attributes}} @if(old($name) != null) x-model="oldValue" @endif x-init="oldValue !== '' && $dispatch('change', oldValue)">
            {{$slot}}
        </select>
    @else
        <div x-data="
        {
            options: [],
            selected: [],
            show: false,
            open() { this.show = true },
            close() { this.show = false },
            isOpen() { return this.show === true },
            select(index, event) {
            if (!this.options[index].selected) {
                this.options[index].selected = true;
                this.options[index].element = event.target;
                this.selected.push(index);

            } else {
                this.selected.splice(this.selected.lastIndexOf(index), 1);
                this.options[index].selected = false
            }
            },
            remove(index, option) {
                this.options[option].selected = false;
                this.selected.splice(index, 1);
            },
            loadOptions() {
                const options = $root.childNodes[1].options;
                for (let i = 0; i < options.length; i++) {
                    this.options.push({
                        value: options[i].value,
                        text: options[i].innerText,
                        selected: options[i].getAttribute('selected') != null  ? true && this.selected.push(i)  : false
                    });
                }
            },
            selectedValues(){
                return this.selected.map((option)=>{
                    return this.options[option].value;
                })
            }
        }
        " >
            <select class="hidden" id="{{$id}}">
                {{$slot}}
            </select>

            <div  x-init="loadOptions()" class="">
                <div  x-data="{ allSelected : selected }">
                    <template x-for="selected in allSelected ">
                        <input type="hidden" name="{{$name}}" :value="options[selected].value">
                    </template>
                </div>
                    <div class="flex flex-col items-center relative w-full">
                        <div x-on:click="open" class="w-full focus:border-2 ">
                            <div class="{{$color}} {{$defaultClass}}">
                                <div class="flex flex-auto flex-wrap">
                                    {{--display selected items--}}
                                    <template x-for="(option,index) in selected" :key="options[option].value">
                                        <div class="flex justify-center dark:text-gray-200 items-center font-medium p-2 rounded-full text-inherit bg-inherit border border-gray-400 ">
                                            <div class="text-xs font-normal leading-none max-w-full flex-initial" x-model="options[option]" x-text="options[option].text"></div>
                                            <div class=" px-1 flex flex-auto flex-row-reverse">
                                                <button x-on:click="remove(index,option)" class="">
                                                    <x-artisan-ui::x/>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                    {{--display when no items are selected --}}
                                    <div x-show="selected.length  == 0" class="flex-1 justify-self-center" >
                                       <p class="bg-transparent cursor-default pr-2 appearance-none outline-none h-full w-full text-gray-800 dark:text-gray-400" :value="selectedValues()">
                                            {{$attributes->get('placeholder') ?? "Select Options"}}
                                        </p>
                                    </div>
                                </div>
                            <div class="border-[color:var(--select-border-color)] dark:border-[color:var(--select-dark-border-color)]  w-8 pl-4 border-l flex items-center  ">
                                <div class="cursor-pointer text-[var(--primary-text-color)] dark:text-[var(--dark-primary-text-color)] fill-[var(--primary-text-color)] dark:fill-[var(--dark-primary-text-color)] " >
                                    <svg :class="{'rotate-180' : isOpen()}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024" class="w-8/12 transition text-center" version="1.1">
                                        <path d="M903.232 256l56.768 50.432L512 768 64 306.432 120.768 256 512 659.072z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full">
                        <div x-show.transition.origin.top="isOpen()" class="absolute -translate-y-1 shadow top-100 border-[color:var(--select-border-color)] dark:border-[color:var(--select-dark-border-color)] bg-[color:var(--primary-bg-color)] dark:bg-[color:var(--dark-primary-bg-color)] text-[var(--primary-text-color)] dark:text-[color:var(--dark-primary-text-color)] z-20 w-full rounded border max-h-60 overflow-y-scroll beautify-scrollbar" x-on:click.away="close">
                            <div class="flex flex-col w-full">
                                <template x-for="(option,index) in options" :key="index">
                                    <div>
                                        <div class="cursor-pointer w-full border-gray-100 rounded-t hover:bg-neutral-300 dark:hover:bg-white dark:hover:bg-opacity-10 hover:text-white bg-opacity-25" @click="select(index,$event)">
                                            <div :class="(option.selected) ? 'bg-neutral-400 dark:bg-neutral-800 text-white' : ''" class="flex w-full items-center py-1 relative">
                                                <div class="w-full items-center flex">
                                                    <div class="ml-3 leading-6 text-sm" x-model="option" x-text="option.text"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    @endif
    @error($name)
        <p class="text-red-700 my-2">{{$message}}</p>
    @enderror
</div>
