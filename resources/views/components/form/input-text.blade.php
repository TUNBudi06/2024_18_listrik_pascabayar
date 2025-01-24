@props(['messages'=>  null,'value'=>'','name'=>'','placeholder'=>'','label'=>'','type'=>'text', 'wireModel'=>null])


@if($messages)
    <div class="form-group has-danger">
        <label class="form-label" for="{{$name}}">{{$label}}</label>
        <input type="{{$type}}" id="{{$name}}" name="{{$name}}"
               {{$attributes->merge(['class'=>'form-control form-control-danger'])}}
               @if($wireModel) wire:model="{{$wireModel}}" @endif placeholder="{{$placeholder}}">
        <small class="form-control-feedback"> {{$messages}}</small>
    </div>
@else
    <div class="form-group">
        <label class="form-label" for="{{$name}}">{{$label}}</label>
        <input type="{{$type}}" id="{{$name}}" name="{{$name}}"
               {{$attributes->merge(['class'=>'form-control'])}} @if($wireModel) wire:model="{{$wireModel}}"
               @endif placeholder="John doe">
    </div>
@endif
