@props(['messages'=>  null,'value'=>'','name'=>'','label'=>'','type'=>'text', 'wireModel'=>null])


@php
    $placeholder = $placeholder ?? " ";
@endphp

@if($messages)
    <div class="form-group has-danger">
        @if($label)
            <label class="form-label" for="{{$name}}">{{$label}}</label>
        @endif
        <input type="{{$type}}" id="{{$name}}" name="{{$name}}"
               {{$attributes->merge(['class'=>'form-control form-control-danger'])}}
               @if($wireModel) wire:model="{{$wireModel}}" @endif placeholder="{{$placeholder}}">
        <small class="form-control-feedback"> {{$messages}}</small>
    </div>
@else
    <div class="form-group">
        @if($label)
            <label class="form-label" for="{{$name}}">{{$label}}</label>
        @endif
        <input type="{{$type}}" id="{{$name}}" name="{{$name}}"
               {{$attributes->merge(['class'=>'form-control'])}} @if($wireModel) wire:model="{{$wireModel}}"
               @endif placeholder="{{$placeholder}}">
    </div>
@endif
