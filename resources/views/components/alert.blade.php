@props(['title', 'icon' => 'fa fa-ban','stackIcons' => [] , 'color' => 'border-gray-300 dark:border-gray-500 dark:text-gray-200', 'class' => '', 'id' => 'alert', 'timeout' => '5000', 'show' => true, 'canDismiss' => false, 'dismissOnTimeout' => false])

<div @class(["$color $class border my-2  p-3 rounded w-full"]) aria-role="alert" x-data="{'showAlert' : {{$show}}}" x-show="showAlert" x-transition id="{{$id}}" {{$attributes}} style="display:none">
    <div class="flex gap-x-3 ">
        @isset($icon)
            <div class="flex gap-3 items-center">
            </div>
        @endisset

        @if ($dismissOnTimeout == true && $canDismiss == true)
            <span x-init="setTimeout(() => { showAlert = false }, {{$timeout}});"></span>
        @endif

        <div class="w-full">
            <h5 class="font-semibold capitalize">
                {{$title}}
            </h5>
            <div>
                {{$slot}}
            </div>
        </div>
        <div>
            @if ($canDismiss == true)
                <button @click="showAlert = false">
                    <x-artisan-ui::x/>
                </button>
                <p class="sr-only">Close Alert</p>
                </i>
            @endif
        </div>
    </div>
</div>
