@props([
'label' => '',
'color' => 'text-[var(--primary-accent-text-color)] dark:text-[var(--dark-primary-accent-text-color)]
bg-[color:var(--primary-accent-color)] dark:bg-[color:var(--dark-primary-accent-color)]',
])
@php
$class = "inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors
focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2";

$class .= match($attributes->get("variant")){
default => "border-transparent bg-primary text-primary-foreground hover:bg-primary/80",
'destructive' => "border-transparent bg-destructive text-destructive-foreground hover:bg-destructive/80",
'outline' => "text-foreground",
'secondary' => "border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80",
"none" => "",
};
@endphp

<div {{$attributes->twMerge([$class])}}>{{$slot}}</div>
