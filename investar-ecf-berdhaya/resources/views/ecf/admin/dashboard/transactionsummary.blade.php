<div class="row d-flex justify-content-center">
    <div class="col-md-12 col-sm-12">
        <h5 class="section mb-2">{{ __('Transaction') }}</h5>
        <div class="row flex-grow">
            <div class="col-md-4 col-sm-12 grid-margin stretch-card">
                {!! $totalRevenue !!}
            </div>
            <div class="col-md-4 col-sm-12 grid-margin stretch-card">
                {!! $totalSales !!}
            </div>
            <div class="col-md-4 col-sm-12 grid-margin stretch-card">
                {!! $totalBuyer !!}
            </div>
        </div>
        {{-- <div class="row flex-grow">
            <div class="col-md-6 col-sm-12 grid-margin stretch-card">
                {!! $salesByPeriod !!}
            </div>
            <div class="col-md-6 col-sm-12 grid-margin stretch-card">
                {!! $revenueByPeriod !!}
            </div>
        </div> --}}
        <div class="row flex-grow">
            <div class="col-md-6 col-sm-12 grid-margin stretch-card">
                {!! $productSalesByPeriod !!}
            </div>
            <div class="col-md-6 col-sm-12 grid-margin stretch-card">
                {!! $productRevenueByPeriod !!}
            </div>
        </div>
        {{-- <h5 class="section mb-2">Customer</h5>
        <div class="row flex-grow">
            <div class="col-md-4 col-sm-12 grid-margin stretch-card">
                {!! $totalUser !!}
            </div>
            <div class="col-md-4 col-sm-12 grid-margin stretch-card">
                {!! $totalCustomer !!}
            </div>
        </div>
    </div>
</div> <!-- row -->
<div class="row">
    <div class="col-lg-5 col-xl-4 grid-margin grid-margin-xl-0 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">{{ __('Recent Buyers') }}</h6>
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
                    <a v-for="su in submitter" :key="su._id" href="#" class="d-flex align-items-center border-bottom pb-3">
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
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7 col-xl-8 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">{{ __('Transactions') }}</h6>
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
                            <th class="pt-0">Nama Produk</th>
                            <th class="pt-0">Tanggal</th>
                            <th class="pt-0">Perkiraan Selesai</th>
                            <th class="pt-0">Status</th>
                            <th class="pt-0">Diproses Oleh</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="sx in submission" :key="sx._id">
                            <td>1</td>
                            <td>NobleUI jQuery</td>
                            <td>01/01/2020</td>
                            <td>26/04/2020</td>
                            <td><span class="badge badge-danger">Released</span></td>
                            <td>Leonardo Payne</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> <!-- row --> --}}
