<div class="card card-dash shadow-sm bg-white rounded mb-4">
    <div class="card-body p-sm-2 p-md-3 ">
        <div class="d-flex justify-content-between align-items-baseline">
            <p class="card-title" style="font-size:10pt;">INQUIRIES</p>
            <p class="card-title" style="font-size:10pt;">NEW ORDER</p>
        </div>
        <div class="row">
            <div class="col-md-5">
                <h4 class="mb-2" v-html="{{ $form['firm_buying'] ?? '' }}"></h4>
                <div class="d-flex align-items-baseline">
                    <p class="text-firm" style="font-size:9pt;">
                        <span>FIRM BUYING</span>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <h4 class="mb-2" v-html="{{ $form['budgetary'] ?? '' }}"></h4>
                <div class="d-flex align-items-baseline">
                    <p class="text-budget" style="font-size:9pt;">
                        <span>BUDGETARY</span>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <h4 class="mb-2 text-center" v-html="{{ $form['new_order'] ?? '' }}"></h4>
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-between" style="height:40px !important;max-height: 40px;" >
            <img style="width:auto;height:40px !important;max-height: 40px;margin-right:5px" :src="{{ $form['image'] ?? '' }}"/>
            <a href="reference/company">
                <h6 :class="{{ $form['title_color'] ?? 'text-budget'}}" style="font-size: 10pt !important;"
                    @if(isset($form['company_type']))
                    v-html="{{ $form['company_name'] ?? '' }}.companyName"
                    @else
                    v-html="{{ $form['company_name'] ?? '' }}"
                    @endif
                ></h6>
            </a>
        </div>
    </div>
</div>
