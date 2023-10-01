@props(['items' => []])

<div x-data="{active: 1}" class="w-full">
    @foreach ($items as $item)
        <div x-data="{open: false, index: {{$loop->iteration}}}" x-effect="active != index ? open = false : open = true" class="w-full">
            <div class="border my-3 rounded p-3 bg-black bg-opacity-10 w-full" @click="open = true; active = index" :class="{'cursor-pointer' : open == false}">
                <div class="flex justify-between">
                    <h3 class="text-2xl">{{$item['title']}}</h3>
                    <p x-text="open ? '+' : '-'" class="text-2xl"></p>
                </div>
                <div x-show="open" 
                x-transition:enter="transition ease-linear  duration-100"
                x-transition:enter-start="opacity-0 height-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-linear duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0 height-0">{{$item['body']}}</div>
            </div>
        </div>
    @endforeach
</div>