@props(['contentClass' => 'waves-effect waves-dark'])

<!-- ============================================================== -->
<!-- Comment -->
<!-- ============================================================== -->
<div class="nav-item dropdown">
    <a class="nav-link dropdown-toggle {{$contentClass}}" href="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ti-email"></i>
        <livewire:navbar.bills-notify/>
    </a>
    <div class="dropdown-menu dropdown-menu-end mailbox animated bounceInDown">
        <ul>
            <li>
                <div class="drop-title">Bills Information</div>
            </li>
            <li>
                <livewire:navbar.bill-list lazy/>
            </li>
            <li>
                <a class="nav-link text-center link" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
            </li>
        </ul>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Comment -->
<!-- ============================================================== -->
