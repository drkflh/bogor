@section('extjs')
    @if( \App\Helpers\AuthUtil::getRoleLayout( \Illuminate\Support\Facades\Auth::user()->roleId ) == 'layouts.nobleui_h')
        <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/css/demo_5/style.css">
    @else
        <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/css/demo_1/style.css">
    @endif

    <script src="{{ url('themes/nobleui') }}/assets/vendors/chartjs/Chart.min.js"></script>
    <script src="{{ url('themes/nobleui') }}/assets/vendors/jquery.flot/jquery.flot.js"></script>
    <script src="{{ url('themes/nobleui') }}/assets/vendors/jquery.flot/jquery.flot.resize.js"></script>
{{--    <script src="{{ url('themes/nobleui') }}/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>--}}
{{--    <script src="{{ url('themes/nobleui') }}/assets/vendors/apexcharts/apexcharts.min.js"></script>--}}
    <script src="{{ url('themes/nobleui') }}/assets/vendors/progressbar.js/progressbar.min.js"></script>
    <!-- end plugin js for this page -->
    <!-- inject:js -->
{{--    <script src="{{ url('themes/nobleui') }}/assets/vendors/feather-icons/feather.min.js"></script>--}}
{{--    <script src="{{ url('themes/nobleui') }}/assets/js/template.js"></script>--}}
    <!-- endinject -->
    <!-- custom js for this page -->
    <script src="{{ url('themes/nobleui') }}/assets/js/dashboard.js"></script>

@endsection
@section('content')

<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Pendaftar Baru</h6>
                            <div class="dropdown mb-2">
                                <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2">3,897</h3>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-success">
                                        <span>+3.3%</span>
                                        <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                            <div class="col-6 col-md-12 col-xl-7">
                                <div id="apexChart1" class="mt-md-3 mt-xl-0"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Pengajuan Baru</h6>
                            <div class="dropdown mb-2">
                                <button class="btn p-0" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2">35,084</h3>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-danger">
                                        <span>-2.8%</span>
                                        <i data-feather="arrow-down" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                            <div class="col-6 col-md-12 col-xl-7">
                                <div id="apexChart2" class="mt-md-3 mt-xl-0"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Sertifikasi Selesai</h6>
                            <div class="dropdown mb-2">
                                <button class="btn p-0" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2">89.87%</h3>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-success">
                                        <span>+2.8%</span>
                                        <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                            <div class="col-6 col-md-12 col-xl-7">
                                <div id="apexChart3" class="mt-md-3 mt-xl-0"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- row -->

<div class="row">
    <div class="col-lg-12 col-xl-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Permohonan Sertifikasi</h6>
                    <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
                        </div>
                    </div>
                </div>
                <p class="text-muted mb-4">Permohonan sertifikasi dari bulan ke bulan.</p>
                <div class="monthly-sales-chart-wrapper">
                    <canvas id="monthly-sales-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div> <!-- row -->

<div class="row">
    <div class="col-12 col-xl-12 grid-margin stretch-card">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                    <h6 class="card-title mb-0">Proses Sertifikasi</h6>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
                        </div>
                    </div>
                </div>
                <div class="row align-items-start mb-2">
                    <div class="col-md-7">
                        <p class="text-muted tx-13 mb-3 mb-md-0">
                            Jumlah proses sertifikasi berjalan
                        </p>
                    </div>
                    <div class="col-md-5 d-flex justify-content-md-end">
                        <div class="btn-group mb-3 mb-md-0" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-outline-primary">Today</button>
                            <button type="button" class="btn btn-outline-primary d-none d-md-block">Week</button>
                            <button type="button" class="btn btn-primary">Month</button>
                            <button type="button" class="btn btn-outline-primary">Year</button>
                        </div>
                    </div>
                </div>
                <div class="flot-wrapper">
                    <div id="flotChart1" class="flot-chart"></div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- row -->


<div class="row">
    <div class="col-lg-5 col-xl-4 grid-margin grid-margin-xl-0 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Pemohon Sertifikasi</h6>
                    <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton6">
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <a href="#" class="d-flex align-items-center border-bottom pb-3">
                        <div class="mr-3">
                            <img src="https://via.placeholder.com/35x35" class="rounded-circle wd-35" alt="user">
                        </div>
                        <div class="w-100">
                            <div class="d-flex justify-content-between">
                                <h6 class="text-body mb-2">Leonardo Payne</h6>
                                <p class="text-muted tx-12">12.30 PM</p>
                            </div>
                            <p class="text-muted tx-13">Hey! there I'm available...</p>
                        </div>
                    </a>
                    <a href="#" class="d-flex align-items-center border-bottom py-3">
                        <div class="mr-3">
                            <img src="https://via.placeholder.com/35x35" class="rounded-circle wd-35" alt="user">
                        </div>
                        <div class="w-100">
                            <div class="d-flex justify-content-between">
                                <h6 class="text-body mb-2">Carl Henson</h6>
                                <p class="text-muted tx-12">02.14 AM</p>
                            </div>
                            <p class="text-muted tx-13">I've finished it! See you so..</p>
                        </div>
                    </a>
                    <a href="#" class="d-flex align-items-center border-bottom py-3">
                        <div class="mr-3">
                            <img src="https://via.placeholder.com/35x35" class="rounded-circle wd-35" alt="user">
                        </div>
                        <div class="w-100">
                            <div class="d-flex justify-content-between">
                                <h6 class="text-body mb-2">Jensen Combs</h6>
                                <p class="text-muted tx-12">08.22 PM</p>
                            </div>
                            <p class="text-muted tx-13">This template is awesome!</p>
                        </div>
                    </a>
                    <a href="#" class="d-flex align-items-center border-bottom py-3">
                        <div class="mr-3">
                            <img src="https://via.placeholder.com/35x35" class="rounded-circle wd-35" alt="user">
                        </div>
                        <div class="w-100">
                            <div class="d-flex justify-content-between">
                                <h6 class="text-body mb-2">Amiah Burton</h6>
                                <p class="text-muted tx-12">05.49 AM</p>
                            </div>
                            <p class="text-muted tx-13">Nice to meet you</p>
                        </div>
                    </a>
                    <a href="#" class="d-flex align-items-center border-bottom py-3">
                        <div class="mr-3">
                            <img src="https://via.placeholder.com/35x35" class="rounded-circle wd-35" alt="user">
                        </div>
                        <div class="w-100">
                            <div class="d-flex justify-content-between">
                                <h6 class="text-body mb-2">Yaretzi Mayo</h6>
                                <p class="text-muted tx-12">01.19 AM</p>
                            </div>
                            <p class="text-muted tx-13">Hey! there I'm available...</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7 col-xl-8 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Dalam Proses</h6>
                    <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th class="pt-0">#</th>
                            <th class="pt-0">Product Name</th>
                            <th class="pt-0">Submit Date</th>
                            <th class="pt-0">Due Date</th>
                            <th class="pt-0">Status</th>
                            <th class="pt-0">Process By</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>NobleUI jQuery</td>
                            <td>01/01/2020</td>
                            <td>26/04/2020</td>
                            <td><span class="badge badge-danger">Released</span></td>
                            <td>Leonardo Payne</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>NobleUI Angular</td>
                            <td>01/01/2020</td>
                            <td>26/04/2020</td>
                            <td><span class="badge badge-success">Review</span></td>
                            <td>Carl Henson</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>NobleUI ReactJs</td>
                            <td>01/05/2020</td>
                            <td>10/09/2020</td>
                            <td><span class="badge badge-info-muted">Pending</span></td>
                            <td>Jensen Combs</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>NobleUI VueJs</td>
                            <td>01/01/2020</td>
                            <td>31/11/2020</td>
                            <td><span class="badge badge-warning">Work in Progress</span>
                            </td>
                            <td>Amiah Burton</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>NobleUI Laravel</td>
                            <td>01/01/2020</td>
                            <td>31/12/2020</td>
                            <td><span class="badge badge-danger-muted text-white">Coming soon</span></td>
                            <td>Yaretzi Mayo</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>NobleUI NodeJs</td>
                            <td>01/01/2020</td>
                            <td>31/12/2020</td>
                            <td><span class="badge badge-primary">Coming soon</span></td>
                            <td>Carl Henson</td>
                        </tr>
                        <tr>
                            <td class="border-bottom">3</td>
                            <td class="border-bottom">NobleUI EmberJs</td>
                            <td class="border-bottom">01/05/2020</td>
                            <td class="border-bottom">10/11/2020</td>
                            <td class="border-bottom"><span class="badge badge-info-muted">Pending</span></td>
                            <td class="border-bottom">Jensen Combs</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> <!-- row -->
@endsection
