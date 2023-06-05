<div class="card-dash" style="margin:5px;">
    <div class="card shadow-sm bg-white rounded">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline">
                <p class="card-title" style="font-size:12px;" v-html="{{ $form['label'] }}"></p>
                <div class="d-flex justify-content-between align-items-baseline">
                    <p class="card-title mr-1" style="font-size:12px;">NEW ORDER</p>
{{--                    <div class="dropdown">--}}
{{--                        <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                            <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>--}}
{{--                        </button>--}}
{{--                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">--}}
{{--                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>--}}
{{--                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>--}}
{{--                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>--}}
{{--                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>--}}
{{--                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <h4 class="mb-2" v-html="{{ $form['model'] }}" ></h4>
                    <div class="d-flex align-items-baseline">
                        <p class="text-firm" style="font-size:12px;">
                            <span>FIRM BUYING</span>
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4 class="mb-2"  v-html="{{ $form['model_percent'] }}" ></h4>
                    <div class="d-flex align-items-baseline">
                        <p class="text-budget" style="font-size:12px;">
                            <span>BUDGETARY</span>
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4 class="mb-2" v-html="{{ $form['model_percent'] }}" ></h4>
                </div>
            </div>
            <hr>
            <div class="text-right">
                <h5 class="card-title-maroon">
                    <strong v-html="{{ $form['vendor_name'] ?? '' }}" ></strong>
                </h5>
            </div>
        </div>
    </div>
</div>

