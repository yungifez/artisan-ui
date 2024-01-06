<div x-data="{open: false, index: (Math.random() + 1).toString(36).substring(7)" x-effect="active != index ? open = false : open = true" class="w-full">
    <div :class="{'w-full', 'my-3 rounded' : groupTogether == false, 'border-b border-x border-gray-300' : groupTogether == true}" @click="open = true; active = index" :class="{'active:ring-4 active:ring-gray-400' : open}">
        <div :class="'flex justify-between p-4','rounded-t-lg' : groupTogether == true, 'bg-gray-100 border-b cursor' : open, 'cursor-pointer' : open == false}">
            <h3 class="text-2xl">{{$title}}</h3>
            <button x-text="open == false ? '+' : '-'" class="text-2xl"></button>
        </div>
        <div x-show="open"
        x-transition:enter="transition ease-linear  duration-100"
        x-transition:enter-start=" height-0"
        x-transition:enter-end=""
        class=" p-4 text-gray-500">
            {{$slot}}
        </div>
    </div>
</div>
