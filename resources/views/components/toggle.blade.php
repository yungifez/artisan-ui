@props([
    'id' => null,
    'name' => null,
    'labelChecked' => null,
    'labelUnchecked' => null,
    'groupClass' => null,
    'color' => 'peer-checked:bg-black text-white peer-focus:ring-gray-400',
])
<div class="{{ $groupClass }}">
    <label
        class=" inline-flex items-center cursor-pointer"
        x-data="{
            'checked' : '{{$attributes->has('checked') && $attributes->get('checked') != false ? true : false}}' ?? false,
            'labelText' : null
        }"
        x-modelable="checked"
        @if ($attributes->has('x-model'))
            x-model="{{$attributes->get('x-model')}}"
        @endif
        x-effect="checked == true ? labelText =  '{{$labelChecked}}' : labelText =  '{{$labelUnchecked}}'"
    >
        <div class="relative">
            <input type="hidden" name="{{$name}}" :value="checked == true ? '1' : '0'">
            <input type="checkbox" class="sr-only peer" {{$attributes}} id="{{$id}}" x-model="checked"/>
            <div class="{{$color}} w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
        </div>
        <span class="ml-3 text-sm font-medium text-gray-900" x-text="labelText"></span>
    </label>
</div>
