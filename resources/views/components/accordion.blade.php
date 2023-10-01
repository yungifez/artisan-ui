@props(['items' => [], 'groupTogether' => false])

<div x-data="{active: 1}" class="w-full">
    @foreach ($items as $item)
        <div x-data="{open: false, index: {{$loop->iteration}}}" x-effect="active != index ? open = false : open = true" class="w-full">
            <div @class([" p-3 bg-black bg-opacity-10 w-full", 'my-3 rounded' => $groupTogether == false, 'border-b border-x border-gray-500' => $groupTogether == true ,'rounded-t border-t' => $groupTogether == true && $loop->first, 'rounded-b' => $groupTogether == true && $loop->last]) class="" @click="open = true; active = index" : open == false}">
                <div class="flex justify-between">
                    <h3 class="text-2xl">{{$item['title']}}</h3>
                    <button x-text="open == false ? '+' : '-'" class="text-2xl"></button>
                </div>
                <div x-show="open" 
                x-transition:enter="transition ease-linear  duration-100"
                x-transition:enter-start=" height-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-linear duration-100"
                x-transition:leave-start=""
                x-transition:leave-end=" height-0">{{$item['body']}}</div>
            </div>
        </div>
    @endforeach
</div>