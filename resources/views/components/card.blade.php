@props(['title' => '', 'description' => ''])

<div class="flex flex-col border rounded-lg shadow">
    <div class="p-6">
        <h4 class="font-semibold text-lg mb-1">{{$title}}</h4>
        <h5 class="text-gray-700 text-sm">{{$description}}</h5>
    </div>
    <div class="p-6 pt-0">
        {{$slot}}
    </div>
    <div class="p-6 pt-0">
        {{$footer}}
    </div>
</div>
