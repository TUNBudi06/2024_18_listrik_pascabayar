@props(['messages'=>  null,'value'=>'','name'=>'','label'=>'', 'wireModel'=>null,'selected'=>null])

@php
    Debugbar::info($errors);
@endphp

<div class="form-group @error($wireModel) has-danger @enderror">
    <label class="form-label" for="{{$name}}">{{$label}}</label>
    <select class="form-control form-select" {{$attributes}} id="{{$name}}" name="{{$name}}"
            @isset($wireModel) wire:model="{{$wireModel}}" @endisset>
        @if(is_null($selected))
            <option selected hidden> Select your {{$label}}</option>
        @endif
        {{$slot}}
    </select>
    @error($wireModel)
    <small class="form-control-feedback"> {{$message}}</small>
    @enderror
</div>
