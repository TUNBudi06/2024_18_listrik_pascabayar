@props(['messages'=>  null,'value'=>'','name'=>'','label'=>'', 'wireModel'=>null])


<div class="form-group @error($wireModel) has-danger @enderror">
    <label class="form-label" for="{{$name}}">{{$label}}</label>
    <textarea id="{{$name}}" name="{{$name}}" class="form-control form-control-danger"
              @if($wireModel) wire:model="{{$wireModel}}" @endif>{{$value}}</textarea>
    @error($wireModel)
    <small class="form-control-feedback"> {{$message}}</small>
    @enderror
</div>

