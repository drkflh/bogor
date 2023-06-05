@extends($layout??'layouts.dashforge')

@section('content')

    @if(env('DEFAULT_LAYOUT') == 'layouts.codebase' || env('DEFAULT_LAYOUT') == 'layouts.app.dms.codebase')
        <div class="row invisible" data-toggle="appear">
            <!-- Row #5 -->
            <div class="col-6 col-md-4 col-xl-2">
                <a class="block block-link-shadow text-center" href="{{ url('dms/repository') }}">
                    <div class="block-content ribbon ribbon-bookmark ribbon-success ribbon-left">
                        <div class="ribbon-box">15</div>
                        <p class="mt-5">
                            <img style="width: 45px;" src="{{ url('images/icons/yellow-file.png') }}" />
                        </p>
                        <p class="font-w600">Repository</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <a class="block block-link-shadow text-center" href="{{ url('dms/dispatch') }}">
                    <div class="block-content">
                        <p class="mt-5">
                            <img style="width: 55px;" src="{{ url('images/icons/file-delivery.png') }}" />
                        </p>
                        <p class="font-w600">Dispatch</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <a class="block block-link-shadow text-center" href="{{ url('dms/dispose') }}">
                    <div class="block-content ribbon ribbon-bookmark ribbon-primary ribbon-left">
                        <div class="ribbon-box">3</div>
                        <p class="mt-5">
                            <img style="width: 55px;" src="{{ url('images/icons/delete.png') }}" />
                        </p>
                        <p class="font-w600">Dispose</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <a class="block block-link-shadow text-center" href="be_pages_generic_search.html">
                    <div class="block-content">
                        <p class="mt-5">
                            <img style="width: 55px;" src="{{ url('images/icons/binoculars.png') }}" />
                        </p>
                        <p class="font-w600">Search</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <a class="block block-link-shadow text-center" href="{{ url('profile') }}">
                    <div class="block-content">
                        <p class="mt-5">
                            <img style="width: 65px;" src="{{ url('images/icons/yellow-star.png') }}" />
                        </p>
                        <p class="font-w600">User Profile</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <a class="block block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content">
                        <p class="mt-5">
                            <img style="width: 55px;" src="{{ url('images/icons/customize-view.png') }}" />
                        </p>
                        <p class="font-w600">Settings</p>
                    </div>
                </a>
            </div>
            <!-- END Row #5 -->
        </div>
        <div class="row invisible" data-toggle="appear">
            <!-- Row #4 -->
            <div class="col-md-6">
                <a class="block block-link-shadow overflow-hidden" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <img style="width: 45px;" src="{{ url('images/icons/combo-chart.png') }}" />
                        <div class="row py-20">
                            <div class="col-3 text-right ">
                                <div class="invisible" data-toggle="appear" data-class="animated fadeInLeft">
                                    <div class="font-size-h3 font-w600">6000</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted">Records</div>
                                </div>
                            </div>
                            <div class="col-3 text-right border-r">
                                <div class="invisible" data-toggle="appear" data-class="animated fadeInLeft">
                                    <div class="font-size-h3 font-w600">33%</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted">Active</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="invisible" data-toggle="appear" data-class="animated fadeInRight">
                                    <div class="font-size-h3 font-w600">47%</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted">Non Active</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="invisible" data-toggle="appear" data-class="animated fadeInRight">
                                    <div class="font-size-h3 font-w600">40%</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted">Disposed</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a class="block block-link-shadow overflow-hidden" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="text-right">
                            <img style="width: 45px;" src="{{ url('images/icons/user-male.png') }}" />
                        </div>
                        <div class="row py-20">
                            <div class="col-6 text-right border-r">
                                <div class="invisible" data-toggle="appear" data-class="animated fadeInLeft">
                                    <div class="font-size-h3 font-w600 text-info">63250</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted">Accounts</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="invisible" data-toggle="appear" data-class="animated fadeInRight">
                                    <div class="font-size-h3 font-w600 text-success">97%</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted">Active</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- END Row #4 -->
        </div>

        <div class="row invisible" data-toggle="appear">
            <!-- Row #1 -->
            <div class="col-6 col-xl-3">
                <a class="block block-link-shadow text-right" href="javascript:void(0)">
                    <div class="float-left mt-10 d-none d-sm-block">
                        <img style="width: 45px;" src="{{ url('images/icons/calendar.png') }}" />
                    </div>
                    <div class="block-content block-content-full clearfix">
                        <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="1500">0</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">New Entry</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-3">
                <a class="block block-link-shadow text-right" href="javascript:void(0)">
                    <div class="float-left mt-10 d-none d-sm-block">
                        <img style="width: 45px;" src="{{ url('images/icons/calendar.png') }}" />
                    </div>
                    <div class="block-content block-content-full clearfix">
                        <div class="font-size-h3 font-w600">$<span data-toggle="countTo" data-speed="1000" data-to="780">0</span></div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Delete</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-3">
                <a class="block block-link-shadow text-right" href="javascript:void(0)">
                    <div class="float-left mt-10 d-none d-sm-block">
                        <img style="width: 45px;" src="{{ url('images/icons/calendar.png') }}" />
                    </div>
                    <div class="block-content block-content-full clearfix">
                        <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="15">0</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Dispatch</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-3">
                <a class="block block-link-shadow text-right" href="javascript:void(0)">
                    <div class="float-left mt-10 d-none d-sm-block">
                        <img style="width: 45px;" src="{{ url('images/icons/calendar.png') }}" />
                    </div>
                    <div class="block-content block-content-full clearfix">
                        <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="4252">0</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Dispose</div>
                    </div>
                </a>
            </div>
            <!-- END Row #1 -->
        </div>

    @else

        <div class="row invisible" data-toggle="appear">
            <!-- Row #5 -->
            <div class="col-6 col-md-4 col-xl-2">
                <a class="block block-link-shadow text-center" href="be_pages_generic_inbox.html">
                    <div class="block-content ribbon ribbon-bookmark ribbon-success ribbon-left">
                        <div class="ribbon-box">15</div>
                        <p class="mt-5">
                            <i class="si si-envelope-letter fa-3x"></i>
                        </p>
                        <p class="font-w600">Inbox</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <a class="block block-link-shadow text-center" href="be_pages_generic_profile.html">
                    <div class="block-content">
                        <p class="mt-5">
                            <i class="si si-user fa-3x"></i>
                        </p>
                        <p class="font-w600">Profile</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <a class="block block-link-shadow text-center" href="be_pages_forum_categories.html">
                    <div class="block-content ribbon ribbon-bookmark ribbon-primary ribbon-left">
                        <div class="ribbon-box">3</div>
                        <p class="mt-5">
                            <i class="si si-bubbles fa-3x"></i>
                        </p>
                        <p class="font-w600">Forum</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <a class="block block-link-shadow text-center" href="be_pages_generic_search.html">
                    <div class="block-content">
                        <p class="mt-5">
                            <i class="si si-magnifier fa-3x"></i>
                        </p>
                        <p class="font-w600">Search</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <a class="block block-link-shadow text-center" href="be_comp_charts.html">
                    <div class="block-content">
                        <p class="mt-5">
                            <i class="si si-bar-chart fa-3x"></i>
                        </p>
                        <p class="font-w600">Live Stats</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <a class="block block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content">
                        <p class="mt-5">
                            <i class="si si-settings fa-3x"></i>
                        </p>
                        <p class="font-w600">Settings</p>
                    </div>
                </a>
            </div>
            <!-- END Row #5 -->
        </div>
        <div class="row invisible" data-toggle="appear">
            <!-- Row #4 -->
            <div class="col-md-6">
                <a class="block block-link-shadow overflow-hidden" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <i class="si si-briefcase fa-2x text-body-bg-dark"></i>
                        <div class="row py-20">
                            <div class="col-6 text-right border-r">
                                <div class="invisible" data-toggle="appear" data-class="animated fadeInLeft">
                                    <div class="font-size-h3 font-w600">16</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted">Projects</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="invisible" data-toggle="appear" data-class="animated fadeInRight">
                                    <div class="font-size-h3 font-w600">2</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted">Active</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a class="block block-link-shadow overflow-hidden" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="text-right">
                            <i class="si si-users fa-2x text-body-bg-dark"></i>
                        </div>
                        <div class="row py-20">
                            <div class="col-6 text-right border-r">
                                <div class="invisible" data-toggle="appear" data-class="animated fadeInLeft">
                                    <div class="font-size-h3 font-w600 text-info">63250</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted">Accounts</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="invisible" data-toggle="appear" data-class="animated fadeInRight">
                                    <div class="font-size-h3 font-w600 text-success">97%</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted">Active</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- END Row #4 -->
        </div>
        <div class="row invisible" data-toggle="appear">
            <!-- Row #1 -->
            <div class="col-6 col-xl-3">
                <a class="block block-link-shadow text-right" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-left mt-10 d-none d-sm-block">
                            <i class="si si-bag fa-3x text-body-bg-dark"></i>
                        </div>
                        <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="1500">0</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Sales</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-3">
                <a class="block block-link-shadow text-right" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-left mt-10 d-none d-sm-block">
                            <i class="si si-wallet fa-3x text-body-bg-dark"></i>
                        </div>
                        <div class="font-size-h3 font-w600">$<span data-toggle="countTo" data-speed="1000" data-to="780">0</span></div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Earnings</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-3">
                <a class="block block-link-shadow text-right" href="javascript:void(0)">
                    <div class="float-left mt-10 d-none d-sm-block">
                        <i class="si si-envelope-open fa-3x text-body-bg-dark"></i>
                    </div>
                    <div class="block-content block-content-full clearfix">
                        <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="15">0</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Messages</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-3">
                <a class="block block-link-shadow text-right" href="javascript:void(0)">
                    <div class="float-left mt-10 d-none d-sm-block">
                        <i class="si si-envelope-open fa-3x text-body-bg-dark"></i>
                    </div>
                    <div class="block-content block-content-full clearfix">
                        <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="4252">0</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Online</div>
                    </div>
                </a>
            </div>
            <!-- END Row #1 -->
        </div>
        <div class="row invisible" data-toggle="appear">
            <!-- Row #2 -->
            <div class="col-md-6">
                <div class="block">
                    <div class="block-header">
                        <h3 class="block-title">
                            Sales <small>This week</small>
                        </h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                            <button type="button" class="btn-block-option">
                                <i class="si si-wrench"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="pull-all">
                            <!-- Lines Chart Container functionality is initialized in js/pages/be_pages_dashboard.min.js which was auto compiled from _es6/pages/be_pages_dashboard.js -->
                            <!-- For more info and examples you can check out http://www.chartjs.org/docs/ -->
                            <canvas class="js-chartjs-dashboard-lines"></canvas>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row items-push">
                            <div class="col-6 col-sm-4 text-center text-sm-left">
                                <div class="font-size-sm font-w600 text-uppercase text-muted">This Month</div>
                                <div class="font-size-h4 font-w600">720</div>
                                <div class="font-w600 text-success">
                                    <i class="las la-caret-up"></i> +16%
                                </div>
                            </div>
                            <div class="col-6 col-sm-4 text-center text-sm-left">
                                <div class="font-size-sm font-w600 text-uppercase text-muted">This Week</div>
                                <div class="font-size-h4 font-w600">160</div>
                                <div class="font-w600 text-danger">
                                    <i class="las la-angle-down"></i> -3%
                                </div>
                            </div>
                            <div class="col-12 col-sm-4 text-center text-sm-left">
                                <div class="font-size-sm font-w600 text-uppercase text-muted">Average</div>
                                <div class="font-size-h4 font-w600">24.3</div>
                                <div class="font-w600 text-success">
                                    <i class="las la-caret-up"></i> +9%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="block">
                    <div class="block-header">
                        <h3 class="block-title">
                            Earnings <small>This week</small>
                        </h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                            <button type="button" class="btn-block-option">
                                <i class="si si-wrench"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="pull-all">
                            <!-- Lines Chart Container functionality is initialized in js/pages/be_pages_dashboard.min.js which was auto compiled from _es6/pages/be_pages_dashboard.js -->
                            <!-- For more info and examples you can check out http://www.chartjs.org/docs/ -->
                            <canvas class="js-chartjs-dashboard-lines2"></canvas>
                        </div>
                    </div>
                    <div class="block-content bg-white">
                        <div class="row items-push">
                            <div class="col-6 col-sm-4 text-center text-sm-left">
                                <div class="font-size-sm font-w600 text-uppercase text-muted">This Month</div>
                                <div class="font-size-h4 font-w600">$ 6,540</div>
                                <div class="font-w600 text-success">
                                    <i class="las la-caret-up"></i> +4%
                                </div>
                            </div>
                            <div class="col-6 col-sm-4 text-center text-sm-left">
                                <div class="font-size-sm font-w600 text-uppercase text-muted">This Week</div>
                                <div class="font-size-h4 font-w600">$ 1,525</div>
                                <div class="font-w600 text-danger">
                                    <i class="las la-angle-down"></i> -7%
                                </div>
                            </div>
                            <div class="col-12 col-sm-4 text-center text-sm-left">
                                <div class="font-size-sm font-w600 text-uppercase text-muted">Balance</div>
                                <div class="font-size-h4 font-w600">$ 9,352</div>
                                <div class="font-w600 text-success">
                                    <i class="las la-caret-up"></i> +35%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Row #2 -->
        </div>
        <div class="row invisible" data-toggle="appear">
            <!-- Row #3 -->
            <div class="col-md-4">
                <div class="block">
                    <div class="block-content block-content-full">
                        <div class="py-20 text-center">
                            <div class="mb-20">
                                <i class="las la-envelope-open fa-4x text-primary"></i>
                            </div>
                            <div class="font-size-h4 font-w600">9.25k Subscribers</div>
                            <div class="text-muted">Your main list is growing!</div>
                            <div class="pt-20">
                                <a class="btn btn-rounded btn-alt-primary" href="javascript:void(0)">
                                    <i class="las la-cog mr-5"></i> Manage list
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="block">
                    <div class="block-content block-content-full">
                        <div class="py-20 text-center">
                            <div class="mb-20">
                                <i class="las la-twitter fa-4x text-info"></i>
                            </div>
                            <div class="font-size-h4 font-w600">+36 followers</div>
                            <div class="text-muted">You are doing great!</div>
                            <div class="pt-20">
                                <a class="btn btn-rounded btn-alt-info" href="javascript:void(0)">
                                    <i class="las la-users mr-5"></i> Check them out
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="block">
                    <div class="block-content block-content-full">
                        <div class="py-20 text-center">
                            <div class="mb-20">
                                <i class="las la-check fa-4x text-success"></i>
                            </div>
                            <div class="font-size-h4 font-w600">Business Plan</div>
                            <div class="text-muted">This is your current active plan</div>
                            <div class="pt-20">
                                <a class="btn btn-rounded btn-alt-success" href="javascript:void(0)">
                                    <i class="las la-arrow-up mr-5"></i> Upgrade to VIP
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Row #3 -->
        </div>

    @endif

@endsection

@section('js')
    <!-- Page JS Plugins -->
    <script src="{{ url('themes/codebase') }}/assets/js/plugins/chartjs/Chart.bundle.min.js"></script>
    <script src="{{ url('themes/codebase') }}/assets/js/plugins/slick/slick.min.js"></script>

    <!-- Page JS Code -->
    <script src="{{ url('themes/codebase') }}/assets/js/pages/be_pages_dashboard.min.js"></script>

@endsection

