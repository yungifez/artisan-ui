@props([
    'id' => null,
    'name' => null,
    'labelCheckedText' => null,
    'labelUncheckedText' => null,
    'groupClass' => null,
    'color' => 'peer-checked:bg-green-600 text-white peer-focus:ring-green-300',
])
<div class="{{ $groupClass }}">
    <label class=" inline-flex items-center cursor-pointer" x-data="{'checked' : '{{$attributes->has('checked') && $attributes->get('checked') != false ? true : false}}' ?? false, 'labelText' : null}" x-modelable="checked" @if ($attributes->has('x-model')) x-model="{{$attributes->get('x-model')}}" @endif x-effect="checked == true ? labelText =  '{{$labelCheckedText}}' : labelText =  '{{$labelUncheckedText}}'">
        <div class="relative">
        <input type="hidden" name="{{$name}}" :value="checked == true ? '1' : '0'">
        <input type="checkbox" class="sr-only peer" {{$attributes}} id="{{$id}}" x-model="checked"/>
            <div class="{{$color}} w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
        </div>
        <span class="ml-3 text-sm font-medium text-gray-900" x-text="labelText"></span>
    </label>  
</div>