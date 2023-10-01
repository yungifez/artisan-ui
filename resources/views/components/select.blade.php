@props(['id' => '', 'name' => '', 'label' => '', 'value' => null, 'class' => '', 'groupClass' => 'my-3', 'labelClass' => '', 'errorBag' => 'default', 'errorName' => '', 'oldName' => '', 'inputBlockClass' => '', 'defaultClass' => 'border border-gray-500 p-3 rounded disabled:bg-gray-50'])

@php($isCheckbox = in_array($attributes->get('type'), [ 'checkbox', 'radio'])  )
@php($errorName = $errorName == $errorName ?? $name)
@php($oldName = $oldName == '' ? $oldName : $name)

<div class="{{$groupClass}} my-2 flex flex-col" x-data="{'oldValue' : '{{old($name) ?? null }}'}">
    @isset($label) 
        <label for="{{$id}}" class="my-3 font-semibold text-gray-700">{{$label}}</label>
    @endisset
    @if (!$attributes->has('multiple'))
        <select name="{{$name}}" id="{{$id}}" @class(["$class $defaultClass", 'border-red-500' => $errors->has($name)]) {{$attributes}} @if(old($name) != null) x-model="oldValue" @endif x-init="oldValue !== '' && $dispatch('change', oldValue)">
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
                            <div class="mb-1 p-2 flex border border-gray-400 bg-white rounded" :class="{'border-blue-500' : isOpen() == true}">
                                <div class="flex flex-auto flex-wrap">
                                    {{--display selected items--}}
                                    <template x-for="(option,index) in selected" :key="options[option].value">
                                        <div class="flex justify-center items-center m-1 font-medium py-1 px-2 rounded-full text-inherit bg-inherit border border-gray-400 ">
                                            <div class="text-xs font-normal leading-none max-w-full flex-initial" x-model="options[option]" x-text="options[option].text"></div>
                                            <div class="flex flex-auto flex-row-reverse">
                                                <button x-on:click="remove(index,option)">
                                                    {{--x svg--}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" class="w-3 h-3 ml-1" version="1.1" viewBox="0 0 460.775 460.775" xml:space="preserve">
                                                        <path d="M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55  c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55  c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505  c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55  l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719  c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                    {{--display when no items are selected --}}
                                    <div x-show="selected.length  == 0" class="flex-1" >
                                        <p class="bg-transparent cursor-default p-1 px-2 appearance-none outline-none h-full w-full text-gray-800" :value="selectedValues()">
                                            {{$attributes->get('placeholder') ?? "Select Options"}}
                                        </p>
                                    </div>
                                </div>
                            <div class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-400 ">
                                <button type="button" x-show="isOpen() === true" x-on:click="open" class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none" >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024" class="w-8/12 text-center" version="1.1"><path d="M903.232 256l56.768 50.432L512 768 64 306.432 120.768 256 512 659.072z" fill="#000000"/></svg>
                                        <path id="XMLID_224_" d="M325.606,229.393l-150.004-150C172.79,76.58,168.974,75,164.996,75c-3.979,0-7.794,1.581-10.607,4.394  l-149.996,150c-5.858,5.858-5.858,15.355,0,21.213c5.857,5.857,15.355,5.858,21.213,0l139.39-139.393l139.397,139.393  C307.322,253.536,311.161,255,315,255c3.839,0,7.678-1.464,10.607-4.394C331.464,244.748,331.464,235.251,325.606,229.393z"/>
                                        </svg>
                                </button>
                                <button type="button" x-show="isOpen() === false" @click="close" class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" class="w-8/12 text-center" version="1.1" id="Layer_1" viewBox="0 0 330 330" xml:space="preserve">
                                        <path id="XMLID_224_" d="M325.606,229.393l-150.004-150C172.79,76.58,168.974,75,164.996,75c-3.979,0-7.794,1.581-10.607,4.394  l-149.996,150c-5.858,5.858-5.858,15.355,0,21.213c5.857,5.857,15.355,5.858,21.213,0l139.39-139.393l139.397,139.393  C307.322,253.536,311.161,255,315,255c3.839,0,7.678-1.464,10.607-4.394C331.464,244.748,331.464,235.251,325.606,229.393z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="w-full">
                        <div x-show.transition.origin.top="isOpen()" class="absolute -translate-y-1 shadow top-100 bg-white z-30 w-full rounded border max-h-60 overflow-y-scroll beautify-scrollbar" x-on:click.away="close">
                            <div class="flex flex-col w-full">
                                <template x-for="(option,index) in options" :key="index">
                                    <div>
                                        <div class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-gray-500 hover:text-white bg-opacity-25" @click="select(index,$event)">
                                            <div :class="(option.selected) ? 'bg-gray-400 text-white' : ''" class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative">
                                                <div class="w-full items-center flex">
                                                    <div class="mx-2 leading-6" x-model="option" x-text="option.text"></div>
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