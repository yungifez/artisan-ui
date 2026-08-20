@props([
'value' => '',
'disabled' => false,
'selected' => false,
])

{{--
    The select behaviour reads these options from the hidden native select and
    rebuilds them as buttons. Keep this a plain option element.
--}}
<option data-slot="select-item" value="{{$value}}" @disabled($disabled) @selected($selected) {{$attributes}}>{{$slot}}</option>
