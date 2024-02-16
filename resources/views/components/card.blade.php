@props(['title' => '', 'description' => ''])

<div class="dark:text-gray-200 flex flex-col border dark:border-gray-500 rounded-lg shadow">
    <div class="p-6">
        <h4 class="font-semibold text-gray-100 text-lg mb-1">{{$title}}</h4>
        <h5 class="text-gray-700 dark:text-gray-200 text-sm">{{$description}}</h5>
    </div>
    <div class="p-6 pt-0">
        {{$slot}}
    </div>
    <div class="p-6 pt-0">
        {{$footer}}
    </div>
</div>
