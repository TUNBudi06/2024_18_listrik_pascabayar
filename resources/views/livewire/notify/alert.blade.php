<div>
    <x-dependency.alert-toast></x-dependency.alert-toast>

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
