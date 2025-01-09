@props(['active','icon','title','href'])

<?php
    $title = $title ?? false;
    $classes = ($active ?? false) ? "active" : "";
?>

@if($title)
    <li class="nav-small-cap">{{$title}}</li>
@endif
<li>
    <a class="waves-effect waves-dark" href="{{$href}}" aria-expanded="false">
        <i class="{{$icon}}"></i>
        <span class="hide-menu">{{$slot}}</span>
    </a>
</li>
