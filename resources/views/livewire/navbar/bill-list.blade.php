<div class="message-center">
    <!-- Message -->
    @foreach($bills as $index => $bill)
        <a href="javascript:void(0)">
            <div class="btn btn-danger btn-circle text-white"><i class="{{$bill['status'] ? ' fas fa-calendar-check' : 'fas fa-calendar-times'}}"></i></div>
            <div class="mail-contnet">
                <h5>{{$bill['status'] ? 'Paid!' : 'Unpaid!'}}</h5> <span class="mail-desc">Payment for {{$bill['bulan']}} {{$bill['tahun']}}</span> <span class="time">9:30 AM</span> </div>
        </a>
    @endforeach
</div>
