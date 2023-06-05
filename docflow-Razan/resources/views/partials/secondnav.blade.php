<?php
use App\Helpers\Util;
?>

@if($section == 'users')

<div class="pd-b-10 pd-x-10">
    <nav class="nav nav-sidebar tx-13">
        <a href="{{ url('user') }}" class="nav-link {{ App\Helpers\Util::sa('user') }} "><i data-feather="users"></i> <span>All Users</span></a>
        <a href="{{ url('member') }}" class="nav-link {{ App\Helpers\Util::sa('member') }} "><i data-feather="users"></i> <span>Members</span></a>
        <a href="{{ url('employee') }}" class="nav-link {{ App\Helpers\Util::sa('employee') }} "><i data-feather="users"></i> <span>Employees</span></a>
        <a href="{{ url('role') }}" class="nav-link {{ App\Helpers\Util::sa('role') }} "><i data-feather="user-check"></i> <span>Roles / Groups</span></a>
        <a href="{{ url('deleteduser') }}" class="nav-link"><i data-feather="trash"></i> <span>Deleted</span></a>
    </nav>
</div>
@elseif( $section == 'magazine' )

@endif

{{--<div class="pd-10">--}}
    {{--<label class="tx-sans tx-uppercase tx-medium tx-10 tx-spacing-1 tx-color-03 pd-l-10">Label</label>--}}
    {{--<nav class="nav nav-sidebar tx-13">--}}
        {{--<a href="" class="nav-link"><i data-feather="folder"></i> <span>Social</span></a>--}}
        {{--<a href="" class="nav-link"><i data-feather="folder"></i> <span>Promotions</span></a>--}}
        {{--<a href="" class="nav-link"><i data-feather="folder"></i> <span>Updates</span></a>--}}
        {{--<a href="" class="nav-link"><i data-feather="folder"></i> <span>Business</span></a>--}}
        {{--<a href="" class="nav-link"><i data-feather="folder"></i> <span>Finance</span></a>--}}
    {{--</nav>--}}
{{--</div>--}}

{{--<div class="pd-y-15 pd-x-10">--}}
    {{--<label class="tx-sans tx-uppercase tx-medium tx-10 tx-spacing-1 tx-color-03 pd-l-10">Tags</label>--}}
    {{--<nav class="nav nav-sidebar tx-13">--}}
        {{--<a href="" class="nav-link"><i data-feather="tag"></i> <span>Facebook</span></a>--}}
        {{--<a href="" class="nav-link"><i data-feather="tag"></i> <span>Twitter</span></a>--}}
    {{--</nav>--}}
{{--</div>--}}
