<div class="{!!  $form['width_class'] !!} grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-0" v-html="{!!  $form['label_left'] !!}"></h6>
                <h6 class="card-title mb-0" v-html="{!!  $form['label_right'] !!}"></h6>
            </div>
            <div class="d-flex justify-content-between align-items-baseline">
                <h3 class="mb-2" v-html="{!!  $form['model_left'] !!}" ></h3>
                <h3 class="mb-2" v-html="{!!  $form['model_right'] !!}" ></h3>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="d-flex align-items-baseline">
                        <p class="text-success">
                            <span v-html="{!!  $form['model_percent'] !!}" ></span>
                            <span v-show="{!! $form['model_up'] !!}" >
                                <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                            </span>
                            <span v-show="{!!  $form['model_down'] !!}" >
                                <i data-feather="arrow-down" class="icon-sm mb-1"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="col-6">
                    @if($form['label_right']  != '' )
                    <div class="text-right" style="width: 100%;">
                        <p class="text-success">
                            <span v-html="{!!  $form['model_percent_right'] !!}" ></span>
                            <span v-show="{!! $form['model_up_right'] !!}" >
                                <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                            </span>
                            <span v-show="{!!  $form['model_down_right'] !!}" >
                                <i data-feather="arrow-down" class="icon-sm mb-1"></i>
                            </span>
                        </p>
                    </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    @if( isset($form['chart_options_left'] ) && $form['chart_options_left'] )
                        <div class="mt-md-3 mt-xl-0">
                            <apexchart
                                :options="{!!  $form['chart_options_left'] !!}"
                                :series="{!!  $form['chart_series_left'] !!}"
                            ></apexchart>
                        </div>
                    @endif
                </div>
                <div class="col-6"></div>
                <div class="col-3">
                    <div class="mt-md-3 mt-xl-0">
                        <apexchart
                            :options="{!!  $form['chart_options'] !!}"
                            :series="{!!  $form['chart_series'] !!}"
                        ></apexchart>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
