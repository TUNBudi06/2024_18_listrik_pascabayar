@props(['name'=> 'table','columns'=>[]])

<div class="table-responsive m-t-40">
    <table id="{{$name}}" class="display nowrap table table-hover table-striped border">
        <thead>
        <tr>
            @foreach($columns as $index => $column)
                <th>{{$column}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        {{$slot}}
        </tbody>
    </table>
    @script
    <script type="text/javascript">
        $(document).ready(function () {
            $("#{{$name}}").DataTable()
        });
    </script>
    @endscript
</div>
