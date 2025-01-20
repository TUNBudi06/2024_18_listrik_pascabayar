<div>
    @assets
    <!-- toast CSS -->
    <link href="{{asset('assets/node_modules/toast-master/css/jquery.toast.css')}}" rel="stylesheet">
    @endassets

    @pushonce('scripts')
        <script src="{{asset('assets/node_modules/toast-master/js/jquery.toast.js')}}"></script>
    @endpushonce
</div>
