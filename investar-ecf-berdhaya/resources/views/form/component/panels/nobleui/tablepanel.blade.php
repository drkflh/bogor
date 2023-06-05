<?php
$model = '{{'.$form['model'].'}}';
$deltaModel = '{{'.$form['delta'].'}}';
?>
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline mb-2">
            <h6 class="card-title mb-0">{{ $titleTable }}</h6>
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
