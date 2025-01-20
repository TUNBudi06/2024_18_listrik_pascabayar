<div>
    @assets
    <!-- toast CSS -->
    <link href="{{asset('assets/node_modules/toast-master/css/jquery.toast.css')}}" rel="stylesheet">
    @endassets

    @pushonce('scripts')
    <script src="{{asset('assets/node_modules/toast-master/js/jquery.toast.js')}}"></script>
    @endpushonce

    @script
    <script>
        let option = {
            position: 'top-right',
            loaderBg:'#17bfdc',
            hideAfter: 3000,
            stack: 6,
        }

        $wire.on('alertSelf',function (arr) {
            option.heading = arr[0].heading
            option.text = arr[0].message
            option.icon = arr[0].icon
            if(arr[0].nextLink){
                option.afterHidden = function () {
                    window.location.href = arr[0].nextLink
                }
            }
            console.log(option)
            $.toast(option)
        })
    </script>
    @endscript
</div>
