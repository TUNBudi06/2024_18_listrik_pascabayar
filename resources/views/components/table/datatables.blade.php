@props(['name'=> 'table','data'=>[],'columns'=>[],'delete'=>null,'edit'=>null])

<x-dependency.data-tables></x-dependency.data-tables>
<div class="table-responsive m-t-40">
    <table id="{{$name}}" class="display nowrap table table-hover table-striped border">
        <thead>
            @foreach($columns as $index => $column)
                <th>{{$index}}</th>
            @endforeach
        </thead>
    </table>
</div>
