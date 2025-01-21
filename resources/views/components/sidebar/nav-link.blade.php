@props(['icon','title','route'=>null])

<?php
    $title = $title ?? false;
    $classes = (request()->routeIs($route) ?? false)  ? "active" : "";
?>

@if($title)
    <li class="nav-small-cap">{{$title}}</li>
@endif
<li class="{{$classes}}">
    <a {{$attributes->merge(['class'=>$classes])}} href="{{$route ? route($route) : '#'}}" aria-expanded="false">
        <i class="{{$icon}}"></i>
        <span class="hide-menu">{{$slot}}</span>
    </a>
</li>
