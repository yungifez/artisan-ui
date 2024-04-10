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

<div class="flex flex-col my-3" x-data="{'oldValue' : '{{old($name) ?? null }}'}">
    @isset ($label)
        <label
            for="{{$attributes->get('id')}}"
            @if ($label instanceof Illuminate\View\ComponentSlot) {{$label->attributes->class(['font-semibold my-2'])}} @else class="font-semibold my-2" @endif
            >
                {{$label}}
        </label>
    @endisset
    {{--select--}}
    <div x-data="
        {
            options: [],
            selected: [],
            multiple: {{$attributes->has('multiple') ? 'true' : 'false'}},
            disabled: {{$attributes->has('disabled') ? 'true' : 'false'}},
            show: false,
            open(){
                if(!this.disabled){
                    this.show = true
                }
            },
            close(){
                this.show = false
            },
            isOpen(){
                return this.show === true
            },
            select(index, event) {
                if (!this.options[index].selected || !this.multiple) {
                    if(!this.multiple){
                        for(i = 0; i < this.selected.length; i++){
                            this.options[this.selected[i]].selected = false;
                        }
                        this.selected.length = 0;
                    }
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
                let lastSelected = 0;
                for (let i = 0; i < options.length; i++) {
                    this.options.push({
                        value: options[i].value,
                        text: options[i].innerText,
                        selected: options[i].getAttribute('selected') != null || i == 0 ? true && this.selected.push(i)  : false,
                    });
                    if(!this.multiple && options[i].getAttribute('selected') != null){
                        this.options[lastSelected].selected = false;
                        lastSelected = i;
                    }
                }
            },
            selectedValues(){
                return this.selected.map((option)=>{
                    return this.options[option].value;
                })
            }
        }
        "
        x-on:keydown.tab="close()"
        x-on:keydown.escape="close()"
    >
        <select class="hidden" {{$attributes->except(['class'])}}>
            {{$slot}}
        </select>

        <div
        x-init="loadOptions()"
        class="w-full relative"
        >
            {{--secretly use inputs for form submission--}}
            <div x-data="{ allSelected : selected }">
                <template x-for="selected in allSelected ">
                    <input type="hidden" name="{{$name}}" :value="options[selected].value">
                </template>
            </div>
            <button x-on:click="open" :disabled="disabled" @class(["flex min-h-10 w-full items-center justify-between rounded-md border bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring disabled:cursor-not-allowed disabled:opacity-50", "border-input " => !$displayErrors, 'border-destructive' => $displayErrors]) x-ref="select" type="button">
                <div class="flex flex-auto flex-wrap gap-y-1">
                    {{--display selected single items--}}
                    <template x-if="!multiple && selected.length > 0">
                        <p class="cursor-default" x-text="options[selected[selected.length - 1]].text" >
                        </p>
                    </template>
                    {{--display selected multiple items--}}
                    <template x-if="multiple">
                        <template x-for="(option,index) in selected" :key="options[option].value">
                            <div
                                class="bg-muted flex mx-1">
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
                    <p x-show="selected.length  == 0">
                        {{$attributes->get('placeholder') ?? "Select Options"}}
                    </p>
                </div>
                <div class="w-6 pl-3 flex items-center">
                    <svg :class="{'rotate-180' : isOpen()}" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 1024 1024" class="w-8/12 transition text-center fill-foreground" version="1.1">
                        <path d="M903.232 256l56.768 50.432L512 768 64 306.432 120.768 256 512 659.072z" />
                    </svg>
                </div>
            </button>
            <div x-show.transition.scale.origin.top="isOpen()"
                class="absolute shadow top-100 border-input bg-background z-20 w-full rounded border max-h-80 overflow-y-scroll"
                x-on:click.away="close()"
                x-trap.noscroll="isOpen()"
                x-anchor="$refs.select"
                x-on:keydown.up.prevent="$focus.wrap().previous()"
                x-on:keydown.down.prevent="$focus.wrap().next()"
            >
                <div class="flex flex-col w-full">
                    <template x-for="(option,index) in options" :key="index">
                        <button
                            class="cursor-pointer rounded-t outline-none flex w-full items-center py-1 relative hover:bg-accent/60 hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground"
                            @click="select(index,$event)"
                            type="button"
                        >
                            <div class="w-full items-center flex">
                                <div class="ml-2 w-3">
                                    <svg x-show="options[index].selected" class="fill-foreground" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/></svg>
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
