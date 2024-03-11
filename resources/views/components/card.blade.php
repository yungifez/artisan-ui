@props(['title' => '', 'description' => '', "footer"])

<div class="bg-[color:var(--card-bg-color)] dark:bg-[color:var(--card-dark-bg-color)] text-[var(--card-text-color)] dark:text-[var(--card-dark-text-color)] flex flex-col border border-[color:var(--card-border-color)] dark:border-[color:var(--card-dark-border-color)] rounded-lg shadow">
    <div class="p-6">
        <h4 class="font-semibold text-lg mb-1">{{$title}}</h4>
        <h5 class="opacity-70 text-sm">{{$description}}</h5>
    </div>
    <div class="p-6 pt-0">
        {{$slot}}
    </div>
    @isset($footer)
        <div class="p-6 pt-0">
            {{$footer}}
        </div>
    @endisset
</div>
