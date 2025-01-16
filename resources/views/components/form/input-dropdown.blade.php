@props(['messages'=>  null,'value'=>'','name'=>'','label'=>'', 'wireModel'=>null])

<div class="form-group has-danger">
    <label class="form-label" for="{{$name}}">{{$label}}</label>
    <select class="form-control form-select" id="{{$name}}" name="{{$name}}" @isset($wireModel) wire:model="{{$wireModel}}" @endisset>
        <option value="" selected hidden> Select your {{$label}}</option>
        {{$slot}}
    </select>
    @isset($messages)
        <small class="form-control-feedback"> {{$messages}}</small>
    @endisset
</div>
