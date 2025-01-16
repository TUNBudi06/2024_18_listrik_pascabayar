@props(['name'=>'','value'=>false,'wireModel'=>null])

<div class="form-check">
    <input type="checkbox" class="form-check-input" @if($wireModel) wire:model="{{$wireModel}}" @endif id="{{$name}}">
    <label class="form-check-label" id="{{$name}}" for="{{$name}}">{{$slot}}</label>
</div>
