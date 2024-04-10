@props([
    "openIcon",
    "closeIcon",
])

<div
    x-data="{open: false, expand(){
        this.open = true;
        active = $id('accordion-item');
        {{$attributes->get('onopen')}}
    }, collapse() {
        this.open = false;
        if(active == $id('accordion-item')){
            active = null
        }
        {{$attributes->get('onclose')}}
    }, toggle(){
        this.open ? this.collapse() : this.expand()
    }}"
    x-id="['accordion-item']"
    $id('accordion-item')
    x-effect="active != $id('accordion-item') ? collapse() : expand()"
    {{ $attributes->merge(['class' => " w-full scroll-smooth py-3 px-4"])}}
>
    <button class="w-full" @click="toggle()">
        <div {{$title->attributes->class(['my-1 font-semibold flex items-center justify-between w-full text-left select-none group-hover:underline'])}}>
            <div>
                {{$title}}
            </div>
            <div>
                <div x-show="!open" @isset($openIcon) {{$openIcon->attributes}} @endisset>
                    @if(isset($openIcon))
                        {{$openIcon}}
                    @else
                        <span class="text-xl">+</span>
                    @endif
                </div>
                <div x-show="open" @isset($closeIcon) {{$closeIcon->attributes}} @endisset>
                    @if(isset($closeIcon))
                        {{$closeIcon}}
                    @else
                        <span class="text-xl">-</span>
                    @endif
                </div>
            </div>
        </div>
    </button>
    @isset($body)
        <div x-show="active == $id('accordion-item')"
            x-collapse.duration.300ms
            x-cloak
            {{$body->attributes}}
        >
            {{$body}}
        </div>
    @endisset
</div>
