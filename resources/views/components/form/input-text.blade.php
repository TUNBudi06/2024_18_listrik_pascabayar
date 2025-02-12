@props(['messages'=>  null,'value'=>'','name'=>'','label'=>'','type'=>'text', 'wireModel'=>null])


@php
    $placeholder = $placeholder ?? " ";
@endphp

<div class="form-group @error($wireModel) has-danger @enderror">
    @if($label)
        <label class="form-label" for="{{$name}}">{{$label}}</label>
    @endif
    <input type="{{$type}}" id="{{$name}}" name="{{$name}}"
           {{$attributes->merge(['class'=>'form-control form-control-danger'])}}
           @if($wireModel) wire:model="{{$wireModel}}" @endif placeholder="{{$placeholder}}">
    @error($wireModel)
    <small class="form-control-feedback"> {{$message}}</small>
    @enderror
</div>
