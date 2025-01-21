@props(['exportable' => null])

<div>
    {{-- Include JavaScript assets --}}
    @pushonce('scripts')
        <script src="{{ asset('assets/node_modules/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>

        @if($exportable)
            <script src="{{ asset('assets/node_modules/datatables.net/lib/buttons.flash.min.js') }}"></script>
            <script src="{{ asset('assets/node_modules/datatables.net/lib/buttons.html5.min.js') }}"></script>
            <script src="{{ asset('assets/node_modules/datatables.net/lib/vfs_fonts.js') }}"></script>
            <script src="{{ asset('assets/node_modules/datatables.net/lib/pdfmake.min.js') }}"></script>
            <script src="{{ asset('assets/node_modules/datatables.net/lib/jszip.min.js') }}"></script>
            <script src="{{ asset('assets/node_modules/datatables.net/lib/dataTables.buttons.min.js') }}"></script>
            <script src="{{ asset('assets/node_modules/datatables.net/lib/buttons.print.min.js') }}"></script>
        @endif
    @endpushonce
</div>
