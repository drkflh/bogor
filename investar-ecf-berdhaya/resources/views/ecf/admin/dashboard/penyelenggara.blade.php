
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h5 class="card-title mb-0">Daftar Penerbit yang belum di verifikasi</h5>
                    </div>
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <a href="/ecf/penerbit/verif"><button class="btn btn-info text-white">Verifikasi </button></a>
                    </div>
                    <br>
                    <div class="table-responsive" style="height: 200px;">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 400px;">Nama</th>
                                    <th style="width: 200px;">Email</th>
                                </tr>
                            </thead>
                            <tbody> 
                            @foreach ( App\Models\Core\Mongo\User::where('roleSlug', 'penerbit')->where('approvalStatus', 'UNVERIFIED')->orderBy('created_at', 'DESC')->get() as $row)
                                    <tr>
                                        <td style="width: 400px;"><a href="#">{{ $row->name }}</a></td>
                                        <!-- <td style="width: 400px;"><a href="dashboard/invoice/{{$row->invCode}}">{{ $row->invCode }}</a></td> -->
                                        <td style="width: 200px;">{{$row->email}}</td>
                                    </tr>       
                            @endforeach 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h5 class="card-title mb-0">Daftar Pemodal yang belum di verifikasi</h5>
                    </div>
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <a href="/ecf/pemodal/verif"><button class="btn btn-info text-white">Verifikasi </button></a>
                    </div>
                    <br>
                    <div class="table-responsive" style="height: 200px;">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 400px;">Nama</th>
                                    <th style="width: 200px;">Email</th>
                                </tr>
                            </thead>
                            <tbody> 
                            @foreach ( App\Models\Core\Mongo\User::where('roleSlug', 'pemodal')->where('approvalStatus', 'UNVERIFIED')->orderBy('created_at', 'DESC')->get() as $row)
                                    <tr>
                                        <td style="width: 400px;"><a href="#">{{ $row->name }}</a></td>
                                        <!-- <td style="width: 400px;"><a href="dashboard/invoice/{{$row->invCode}}">{{ $row->invCode }}</a></td> -->
                                        <td style="width: 200px;">{{$row->email}}</td>
                                    </tr>       
                            @endforeach 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h5 class="card-title mb-0">Daftar Campaign yang belum di verifikasi</h5>
                    </div>
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <a href="/ecf/campaign/verif"><button class="btn btn-info text-white">Verifikasi </button></a>
                    </div>
                    <br>
                    <div class="table-responsive" style="height: 200px;">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 50%;">Nama Kampanye</th>
                                    <th style="width: 50%;">PErusahaan penyelenggara</th>
                                </tr>
                            </thead>
                            <tbody> 
                            @foreach ( App\Models\Ecf\Campaign::where('campaignStatus', 'DRAFT')->orderBy('created_at', 'DESC')->get() as $row)
                                    <tr>
                                        <td style="width: 50%;"><a href="#">{{ $row->campaignTitle }}</a></td>
                                        <!-- <td style="width: 400px;"><a href="dashboard/invoice/{{$row->invCode}}">{{ $row->invCode }}</a></td> -->
                                        <td style="width: 50%;">{{$row->bizRegisteredName}}</td>
                                    </tr>       
                            @endforeach 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-4">
            {!! $totalPenerbit !!}
        </div>
        <div class="col-sm-4">
            {!! $totalPemodal !!}
        </div>
        <div class="col-sm-4">
            {!! $totalCampaign !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            {!! $penerbitPemodalByChart !!}
        </div>
        <div class="col-sm-6">
            {!! $verifiedUnverifiedByChart !!}
        </div>
    </div>