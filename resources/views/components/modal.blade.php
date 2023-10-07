@props(['themeColor' =>  'bg-blue-700', 'parentClass' => 'text-white','title' => '', 'footer' => '', 'icon' => '', 'popupButtonClass' => 'Popup', 'button', 'size' => 'base', 'popupButtonText' => 'Open', 'closeButton' => 'true'])

<div x-data="{modal : false}" class="{{$parentClass}}">
    
    @isset($button)
        {{$button}}
    @else
        <x-artisan-ui::button type="button" class="{{$themeColor}} {{$popupButtonClass}} rounded" icon="{{$icon}}" @click="modal = true">
            {{$popupButtonText}}
        </x-artisan-ui::button>
    @endisset

    @php
        $sizeClass = match ($size) {
            "base" => "h-[50%] md:h-[60%] w-11/12 md:w-10/12 lg:w-8/12 xl:w-6/12",
            default => "h-[50%] md:h-[60%] w-11/12 md:w-10/12 lg:w-8/12 xl:w-6/12",
            "lg" => "h-[90%] w-11/12 lg:w-9/12 xl:w-7/12" ,
        }
    @endphp

    <div class=" w-screen h-screen fixed inset-0 z-50 bg-black bg-opacity-70 flex items-center justify-center" @click="modal = false" x-show="modal" style="display: none" x-transition {{$attributes}}>
        <div class="{{$sizeClass}} flex justify-between flex-col bg-white rounded-xl border" @click.stop>
            <div class="{{$themeColor}} h-16 md:h-20 rounded-t-xl flex justify-between  items-center p-4">
                <div class="flex gap-4 overflow-y-scroll beautify-scrollbar">
                    <i class="{{$icon}} text-2xl" aria-hidden="true" ></i>
                    <h4 class="text-2xl font-semibold">{{$title}}</h4>
                </div>
                <button @click="modal = false" aria-role="button" aria-hidden="true">
                    <x-artisan-ui::x />
                    <p class="sr-only">Close Modal</p>
                </button>
            </div>
            <div class="flex justify-center items-center flex-col overflow-y-scroll beautify-scrollbar text-black">
                {{$slot}}
            </div>
            <div class="border-t h-16 md:h-20 flex justify-between items-center p-4">
                @if ($closeButton != false && $closeButton != "false" )
                    <x-artisan-ui::button label="Close" class="bg-gray-600 text-white" colour="" @click="modal = false"/>
                @endif
                <div>
                    {{$footer}}
                </div>
            </div>
        </div>
    </div>
</div>