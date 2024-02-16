@props(['themeColor' =>  'bg-black-700', 'parentClass' => '','title' => '', 'footer' => '', 'icon' => '', 'popupButtonClass' => 'Popup', 'button', 'size' => 'base', 'popupButtonText' => 'Open', 'closeButton' => 'true'])
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
            "sm" => "h-[30%] w-11/12 lg:w-5/12 xl:w-4/12" ,
        }
    @endphp

    <div class=" w-screen h-screen fixed inset-0 z-50 bg-black dark:bg-white dark:bg-opacity-5 bg-opacity-80 flex items-center justify-center" @click="modal = false" x-show="modal" style="display: none" x-transition.opacity {{$attributes}}>
        <div class="{{$sizeClass}} flex justify-between flex-col bg-white dark:bg-black dark:text-gray-200 dark:borders-gray-500 rounded-xl border p-4 overflow-y-scroll" @click.stop>
            <div class="{{$themeColor}} h-16 md:h-20 rounded-t-xl flex justify-between p-2 items-center">
                <div class="flex gap-4 overflow-y-scroll beautify-scrollbar">
                    <i class="{{$icon}} text-2xl" aria-hidden="true" ></i>
                    <h4 class="text-2xl font-semibold">{{$title}}</h4>
                </div>
            </div>
            <div class="">
                {{$slot}}
            </div>
            <div class=" flex gap-2 flex-col md:flex-row md:justify-end items-center p-2">
                @if ($closeButton != false && $closeButton != "false" )
                    <x-artisan-ui::button label="Cancel" class="w-full md:w-auto bg-white text-black border-gray-300 border" color="" @click="modal = false"/>
                @endif
                {{$footer}}
            </div>
        </div>
    </div>
</div>
