<ul class="nav nav-aside">
    <li class="nav-label">Dashboard</li>
    <li class="nav-item"><a href="dashboard-one.html" class="nav-link"><i data-feather="shopping-bag"></i> <span>Sales Monitoring</span></a></li>
    <li class="nav-item"><a href="dashboard-two.html" class="nav-link"><i data-feather="globe"></i> <span>Website Analytics</span></a></li>
    <li class="nav-item"><a href="dashboard-three.html" class="nav-link"><i data-feather="pie-chart"></i> <span>Cryptocurrency</span></a></li>
    <li class="nav-item"><a href="dashboard-four.html" class="nav-link"><i data-feather="life-buoy"></i> <span>Helpdesk Management</span></a></li>
    <li class="nav-label mg-t-25">Web Apps</li>
    <li class="nav-item"><a href="app-calendar.html" class="nav-link"><i data-feather="calendar"></i> <span>Calendar</span></a></li>
    <li class="nav-item"><a href="app-chat.html" class="nav-link"><i data-feather="message-square"></i> <span>Chat</span></a></li>
    <li class="nav-item"><a href="app-file-manager.html" class="nav-link"><i data-feather="file-text"></i> <span>File Manager</span></a></li>
    <li class="nav-item"><a href="app-mail.html" class="nav-link"><i data-feather="mail"></i> <span>Mail</span></a></li>

    <li class="nav-label mg-t-25">Root</li>
    <li class="nav-item {{ App\Helpers\Util::sa('user') }} "><a href="{{ url('user') }}" class="nav-link {{ App\Helpers\Util::sa('user') }} "><i data-feather="users"></i> <span>Users</span></a></li>
    <li class="nav-item {{ App\Helpers\Util::sa('role') }} "><a href="{{ url('role') }}" class="nav-link {{ App\Helpers\Util::sa('role') }} "><i data-feather="user-check"></i> <span>User Roles</span></a></li>
    {{--<li class="nav-item with-sub">--}}
        {{--<a href="" class="nav-link"><i data-feather="user"></i> <span>User Pages</span></a>--}}
        {{--<ul>--}}
            {{--<li><a href="page-profile-view.html">View Profile</a></li>--}}
            {{--<li><a href="page-connections.html">Connections</a></li>--}}
            {{--<li><a href="page-groups.html">Groups</a></li>--}}
            {{--<li><a href="page-events.html">Events</a></li>--}}
        {{--</ul>--}}
    {{--</li>--}}
    {{--<li class="nav-item with-sub">--}}
        {{--<a href="" class="nav-link"><i data-feather="file"></i> <span>Other Pages</span></a>--}}
        {{--<ul>--}}
            {{--<li><a href="page-timeline.html">Timeline</a></li>--}}
        {{--</ul>--}}
    {{--</li>--}}
    {{--<li class="nav-label mg-t-25">User Interface</li>--}}
    {{--<li class="nav-item"><a href="../../components" class="nav-link"><i data-feather="layers"></i> <span>Components</span></a></li>--}}
    {{--<li class="nav-item"><a href="../../collections" class="nav-link"><i data-feather="box"></i> <span>Collections</span></a></li>--}}
</ul>
