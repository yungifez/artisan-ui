@props([
"openIcon",
"closeIcon",
])

<div x-data="{open: false}" x-id="['accordion-item']" $id('accordion-item')
    x-effect="active != $id('accordion-item') ? open = false : open = true"
    {{ $attributes->only('groupClass')->merge(['class' => " w-full scroll-smooth py-3 px-4"])}}
    {{ $attributes->whereStartsWith("group") }}
>
    <button class="w-full" @click="
            if(open){
                open = false;
                active = null;
            }else {
                open = true;
                active = $id('accordion-item');
            }
        ">
        <div class="my-1 flex items-center justify-between w-full text-left select-none group-hover:underline" {{$attributes->whereStartsWith("title")}}>
            <div>
                {{$title}}
            </div>
            <div>
                <div x-show="!open">
                    @if(isset($openIcon))
                        {{$openIcon}}
                    @else
                        <span class="text-xl">+</span>
                    @endif
                </div>
                <div x-show="open">
                    @if(isset($closeIcon))
                        {{$closeIcon}}
                    @else
                        <span class="text-xl">-</span>
                    @endif
                </div>
            </div>
        </div>
    </button>
    <div x-show="active == $id('accordion-item')"
        {{ $attributes->only('bodyClass')->merge(['class' => "opacity-70"])}}
        x-collapse.duration.300ms
        x-cloak
        {{$attributes->whereStartsWith("body")}}
    >
        {{$slot}}
    </div>
</div>
