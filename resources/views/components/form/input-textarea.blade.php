@props(['messages'=>  null,'value'=>'','name'=>'','label'=>'', 'wireModel'=>null])


@if($messages)
    <div class="form-group has-danger">
        <label class="form-label" for="{{$name}}">{{$label}}</label>
        <textarea id="{{$name}}" name="{{$name}}" class="form-control form-control-danger" @if($wireModel) wire:model="{{$wireModel}}" @endif>{{$value}}</textarea>
        <small class="form-control-feedback"> {{$messages}}</small>
    </div>
@else
    <div class="form-group">
        <label class="form-label" for="{{$name}}">{{$label}}</label>
        <textarea id="{{$name}}" name="{{$name}}" class="form-control" @if($wireModel) wire:model="{{$wireModel}}" @endif>{{$value}}</textarea>
    </div>
@endif
