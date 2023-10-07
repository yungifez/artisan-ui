@props(['title', 'icon' => 'fa fa-ban','stackIcons' => [] , 'color' => 'bg-red-200 border-red-700 border text-red-700', 'class' => '', 'id' => 'alert', 'timeout' => '5000', 'show' => true, 'canDismiss' => true, 'dismissOnTimeout' => false])

<div @class(["$color $class p-3 rounded w-full"]) aria-role="alert" x-data="{'showAlert' : {{$show}}}" x-show="showAlert" x-transition id="{{$id}}" {{$attributes}} style="display:none">
    <div class="flex gap-3 justify-between">
        <div class="flex gap-3 items-center">
            @if (!empty($stackIcons))
                <span class="fa-stack">
                    @foreach ($stackIcons as $stackIcon)
                        <i class="{{$stackIcon}} fa-stack-{{$loop->iteration}}x"></i>
                    @endforeach
                </span>
            @else
                <i class="text-xl {{$icon}}"></i>
            @endif
            <p class="text-xl">
                {{$title}}
            </p>
        </div>
        
        @if ($dismissOnTimeout == true && $canDismiss == true)
            <span x-init="setTimeout(() => { showAlert = false }, {{$timeout}});"></span>
        @endif
        
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
    <div class="p-3">
        {{$slot}}
    </div>
</div>