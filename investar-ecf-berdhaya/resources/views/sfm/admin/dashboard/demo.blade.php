<div class="row">

    <div class="col-xl-3 col-md-6">
        <div class="card widget-box-one border border-primary bg-soft-primary">
            <div class="card-body">
                <div class="float-right avatar-lg rounded-circle mt-3">
                    <i class="mdi mdi-chart-areaspline font-30 widget-icon rounded-circle avatar-title text-primary"></i>
                </div>
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-weight-bold text-muted" title="Statistics">Statistics</p>
                    <h2><span data-plugin="counterup">34578</span> <i class="mdi mdi-arrow-up text-success font-24"></i></h2>
                    <p class="text-muted m-0"><span class="font-weight-medium">Last:</span> 30.4k</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->

    <div class="col-xl-3 col-md-6">
        <div class="card widget-box-one border border-warning bg-soft-warning">
            <div class="card-body">
                <div class="float-right avatar-lg rounded-circle mt-3">
                    <i class="mdi mdi-layers font-30 widget-icon rounded-circle avatar-title text-warning"></i>
                </div>
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-weight-bold text-muted" title="User This Month">User This Month</p>
                    <h2><span data-plugin="counterup">52410 </span> <i class="mdi mdi-arrow-up text-success font-24"></i></h2>
                    <p class="text-muted m-0"><span class="font-weight-medium">Last:</span> 40.33k</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->

    <div class="col-xl-3 col-md-6">
        <div class="card widget-box-one border border-danger bg-soft-danger">
            <div class="card-body">
                <div class="float-right avatar-lg rounded-circle mt-3">
                    <i class="mdi mdi-av-timer font-30 widget-icon rounded-circle avatar-title text-danger"></i>
                </div>
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-weight-bold text-muted" title="Statistics">Statistics</p>
                    <h2><span data-plugin="counterup">6352 </span> <i class="mdi mdi-arrow-up text-success font-24"></i></h2>
                    <p class="text-muted m-0"><span class="font-weight-medium">Last:</span> 956</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->

    <div class="col-xl-3 col-md-6">
        <div class="card widget-box-one border border-success bg-soft-success">
            <div class="card-body">
                <div class="float-right avatar-lg rounded-circle mt-3">
                    <i class="mdi mdi-account-convert font-30 widget-icon rounded-circle avatar-title text-success"></i>
                </div>
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-weight-bold text-muted" title="User Today">User Today</p>
                    <h2><span data-plugin="counterup">895</span> <i class="mdi mdi-arrow-down text-danger font-24"></i></h2>
                    <p class="text-muted m-0"><span class="font-weight-medium">Last:</span> 1250</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card-box">
            <h4 class="header-title mb-4">Total Revenue</h4>

            <div id="website-stats" style="height: 320px;" class="flot-chart"></div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card-box">
            <h4 class="header-title mb-4">Sales Analytics</h4>

            <div class="float-right">
                <div id="reportrange" class="form-control form-control-sm">
                    <i class="far fa-calendar-alt mr-1"></i>
                    <span></span>
                </div>
            </div>
            <div class="clearfix"></div>

            <div id="donut-chart">
                <div id="donut-chart-container" class="flot-chart" style="height: 246px;">
                </div>
            </div>

            <p class="text-muted mb-0 mt-3 text-truncate">Pie chart is used to see the proprotion of each data groups, making Flot pie chart is pretty simple, in order to make pie chart you have to incldue jquery.flot.pie.js plugin.</p>
        </div>
    </div>

</div>
<!-- end row -->

<div class="row">

    <div class="col-lg-4">
        <div class="card-box">
            <h4 class="header-title mb-4">Messages</h4>

            <div class="inbox-widget slimscroll" style="max-height: 360px;">
                <a href="{{ url('themes/zircos') }}/#">
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="{{ url('themes/zircos') }}/assets/images/users/avatar-1.jpg" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author">Chadengle</p>
                        <p class="inbox-item-text font-12">Hey! there I'm available...</p>
                        <p class="inbox-item-date">13:40 PM</p>
                    </div>
                </a>
                <a href="{{ url('themes/zircos') }}/#">
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="{{ url('themes/zircos') }}/assets/images/users/avatar-2.jpg" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author">Tomaslau</p>
                        <p class="inbox-item-text font-12">I've finished it! See you so...</p>
                        <p class="inbox-item-date">13:34 PM</p>
                    </div>
                </a>
                <a href="{{ url('themes/zircos') }}/#">
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="{{ url('themes/zircos') }}/assets/images/users/avatar-3.jpg" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author">Stillnotdavid</p>
                        <p class="inbox-item-text font-12">This theme is awesome!</p>
                        <p class="inbox-item-date">13:17 PM</p>
                    </div>
                </a>
                <a href="{{ url('themes/zircos') }}/#">
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="{{ url('themes/zircos') }}/assets/images/users/avatar-4.jpg" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author">Kurafire</p>
                        <p class="inbox-item-text font-12">Nice to meet you</p>
                        <p class="inbox-item-date">12:20 PM</p>
                    </div>
                </a>
                <a href="{{ url('themes/zircos') }}/#">
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="{{ url('themes/zircos') }}/assets/images/users/avatar-5.jpg" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author">Shahedk</p>
                        <p class="inbox-item-text font-12">Hey! there I'm available...</p>
                        <p class="inbox-item-date">10:15 AM</p>
                    </div>
                </a>
                <a href="{{ url('themes/zircos') }}/#">
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="{{ url('themes/zircos') }}/assets/images/users/avatar-6.jpg" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author">Adhamdannaway</p>
                        <p class="inbox-item-text font-12">This theme is awesome!</p>
                        <p class="inbox-item-date">9:56 AM</p>
                    </div>
                </a>
                <a href="{{ url('themes/zircos') }}/#">
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="{{ url('themes/zircos') }}/assets/images/users/avatar-8.jpg" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author">Arashasghari</p>
                        <p class="inbox-item-text font-12">Hey! there I'm available...</p>
                        <p class="inbox-item-date">10:15 AM</p>
                    </div>
                </a>
                <a href="{{ url('themes/zircos') }}/#">
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="{{ url('themes/zircos') }}/assets/images/users/avatar-9.jpg" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author">Joshaustin</p>
                        <p class="inbox-item-text font-12">I've finished it! See you so...</p>
                        <p class="inbox-item-date">9:56 AM</p>
                    </div>
                </a>
            </div>

        </div>
        <!-- end card -->
    </div>
    <!-- end col -->

    <div class="col-lg-8">
        <div class="card-box">
            <h4 class="header-title mb-4">Recent Users</h4>

            <div class="table-responsive">
                <table class="table table table-hover m-0">
                    <thead>
                    <tr>
                        <th></th>
                        <th>User Name</th>
                        <th>Phone</th>
                        <th>Location</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>
                            <img src="{{ url('themes/zircos') }}/assets/images/users/avatar-6.jpg" alt="user" class="avatar-sm rounded-circle" />
                        </th>
                        <td>
                            <h5 class="m-0 font-15">Louis Hansen</h5>
                            <p class="m-0 text-muted font-13"><small>Web designer</small></p>
                        </td>
                        <td>+12 3456 789</td>
                        <td>USA</td>
                        <td>07/08/2016</td>
                    </tr>

                    <tr>
                        <th>
                            <span class="avatar-sm-box bg-primary">C</span>
                        </th>
                        <td>
                            <h5 class="m-0 font-15">Craig Hause</h5>
                            <p class="m-0 text-muted font-13"><small>Programmer</small></p>
                        </td>
                        <td>+89 345 6789</td>
                        <td>Canada</td>
                        <td>29/07/2016</td>
                    </tr>

                    <tr>
                        <th>
                            <img src="{{ url('themes/zircos') }}/assets/images/users/avatar-7.jpg" alt="user" class="avatar-sm rounded-circle" />
                        </th>
                        <td>
                            <h5 class="m-0 font-15">Edward Grimes</h5>
                            <p class="m-0 text-muted font-13"><small>Founder</small></p>
                        </td>
                        <td>+12 29856 256</td>
                        <td>Brazil</td>
                        <td>22/07/2016</td>
                    </tr>

                    <tr>
                        <th>
                            <span class="avatar-sm-box bg-pink">B</span>
                        </th>
                        <td>
                            <h5 class="m-0 font-15">Bret Weaver</h5>
                            <p class="m-0 text-muted font-13"><small>Web designer</small></p>
                        </td>
                        <td>+00 567 890</td>
                        <td>USA</td>
                        <td>20/07/2016</td>
                    </tr>

                    <tr>
                        <th>
                            <img src="{{ url('themes/zircos') }}/assets/images/users/avatar-8.jpg" alt="user" class="avatar-sm rounded-circle" />
                        </th>
                        <td>
                            <h5 class="m-0 font-15">Mark</h5>
                            <p class="m-0 text-muted font-13"><small>Web design</small></p>
                        </td>
                        <td>+91 123 456</td>
                        <td>India</td>
                        <td>07/07/2016</td>
                    </tr>

                    </tbody>
                </table>

            </div>
            <!-- table-responsive -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->

</div>
<!-- end row -->
