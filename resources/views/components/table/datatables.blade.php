@props(['name'=> 'table','columns'=>[]])

<x-dependency.data-tables></x-dependency.data-tables>
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
    <script type="text/javascript">
        $(document).ready(function () {
            $("{{$name}}").DataTable()
        });
    </script>

</div>
