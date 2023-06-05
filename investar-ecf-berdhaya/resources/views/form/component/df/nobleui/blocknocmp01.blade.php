<div class="{{ $form['width_class'] }} grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-0" v-html="{{ $form['label_left'] }}"></h6>
                <h6 class="card-title mb-0" v-html="{{ $form['label_right'] }}"></h6>
            </div>
            <div class="d-flex justify-content-between align-items-baseline">
                <h3 class="mb-2" v-html="{{ $form['model_left'] }}" ></h3>
                <h3 class="mb-2" v-html="{{ $form['model_right'] }}" ></h3>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-baseline">
                        <p class="text-success">
                        </p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mt-md-3 mt-xl-0">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
