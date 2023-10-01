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
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" class="w-3 h-3 ml-1" version="1.1" viewBox="0 0 460.775 460.775" xml:space="preserve" >
                        <path d="M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55  c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55  c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505  c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55  l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719  c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z"/>
                    </svg>
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