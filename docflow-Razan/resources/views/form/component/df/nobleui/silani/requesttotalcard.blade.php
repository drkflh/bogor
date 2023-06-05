<div class="row mb-4">
    <a href="{{ url('dwf/document/list/surat-dinas') }}" class="col-md-6 col-xs-12 mb-2">
        <div class="card text-white bg-primary" style="border-radius: 1rem;">
            <div class="card-header" style="font-size: 18px" v-html="{{ $form['label_suratdinas'] }}"></div>
            <h5 class="text-right text-white mx-4 mt-2" v-html="{{ $form['total_suratdinas'] }}"></h5>
            <h5 class="text-right text-white mx-4 mt-2" v-html="{{ $form['this_month_suratdinas'] }}"></h5>
            <h5 style="margin-top: 0px;" class="text-right text-white mx-4" v-html="{{ $form['sys_suratdinas'] }}"></h5>
        </div>
    </a>
    <a href="{{ url('dwf/document/list/nota-dinas') }}" class="col-md-6 col-xs-12 mb-2">
        <div class="card text-white bg-success" style="border-radius: 1rem;">
            <div class="card-header" style="font-size: 18px" v-html="{{ $form['label_notadinas'] }}"></div>
            <h5 class="text-right text-white mx-4 mt-2" v-html="{{ $form['total_notadinas'] }}"></h5>
            <h5 class="text-right text-white mx-4 mt-2" v-html="{{ $form['this_month_notadinas'] }}"></h5>
            <h5 style="margin-top: 0px;" class="text-right text-white mx-4" v-html="{{ $form['sys_notadinas'] }}"></h5>
        </div>
    </a>
    <a href="{{ url('dwf/document/list/lembar-disposisi') }}" class="col-md-6 col-xs-12 mb-2">
        <div class="card text-white bg-warning" style="border-radius: 1rem;">
            <div class="card-header" style="font-size: 18px" v-html="{{ $form['label_disposisi'] }}"></div>
            <h5 class="text-right text-white mx-4 mt-2" v-html="{{ $form['total_disposisi'] }}"></h5>
            <h5 class="text-right text-white mx-4 mt-2" v-html="{{ $form['this_month_disposisi'] }}"></h5>
            <h5 style="margin-top: 0px;" class="text-right text-white mx-4" v-html="{{ $form['sys_disposisi'] }}"></h5>
        </div>
    </a>
    <a href="{{ url('dwf/document/list/memo-internal') }}" class="col-md-6 col-xs-12 mb-2">
        <div class="card text-white bg-danger" style="border-radius: 1rem;">
            <div class="card-header" style="font-size: 18px" v-html="{{ $form['label_memo'] }}"></div>
            <h5 class="text-right text-white mx-4 mt-2" v-html="{{ $form['total_memo'] }}"></h5>
            <h5 class="text-right text-white mx-4 mt-2" v-html="{{ $form['this_month_memo'] }}"></h5>
            <h5 style="margin-top: 0px;" class="text-right text-white mx-4" v-html="{{ $form['sys_memo'] }}"></h5>
        </div>
    </a>
</div>
