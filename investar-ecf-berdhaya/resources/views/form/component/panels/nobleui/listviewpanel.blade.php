<?php

?>
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
