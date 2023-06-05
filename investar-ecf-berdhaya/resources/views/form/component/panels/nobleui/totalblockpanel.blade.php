<?php
$model = '{{'.$form['model'].'}}';
$deltaModel = '{{'.$form['delta'].'}}';
?>
<div class="card">
    <div class="card-body" style="{{ $form['style'] ?? 'backgroundcolor: #4bd41e;' }}">
        <div class="d-flex justify-content-between align-items-baseline">
            <h6 class="card-title mb-0">{{ $label }}</h6>
{{--            <div class="dropdown mb-2">--}}
{{--                <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>--}}
{{--                </button>--}}
{{--                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">--}}
{{--                    <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>--}}
{{--                    <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>--}}
{{--                    <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>--}}
{{--                    <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>--}}
{{--                    <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
        <div class="row">
            <div class="col-6 col-md-12 col-xl-5">
                <h1 class="mb-2">{{ $model }}</h1>
                @if( isset($form['delta']) )
                {{-- <div class="d-flex align-items-baseline">
                    <p class="text-success">
                        <span>{{ $deltaModel }}</span>
                        <i class="icon-sm mb-1 las" :class="{{ $form['delta'] }} > 0 ? 'la-arrow-up' : 'la-arrow-down'" ></i>
                    </p>
                </div> --}}
                @endif
            </div>
        </div>
    </div>
</div>

