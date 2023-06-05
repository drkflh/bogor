<div class="row mb-4">
    <a href="{{ url('dwf/document/list/surat-dinas') }}" class="col-md-6 col-xs-12 mb-2">
        <div class="card text-white bg-primary" style="border-radius: 1rem;">
            <div class="card-header" style="font-size: 18px" v-html="{{ $form['label_suratdinas'] }}"></div>
            <h2 class="text-right text-white mx-4 mt-2" v-html="{{ $form['total_suratdinas'] }}"></h2>
            <h3 class="text-right text-white mx-4 mt-2" v-html="{{ $form['this_month_suratdinas'] }}"></h3>
            <h3 style="margin-top: 0px;" class="text-right text-white mx-4" v-html="{{ $form['sys_suratdinas'] }}"></h3>
        </div>
    </a>
    <a href="{{ url('dwf/document/list/nota-dinas') }}" class="col-md-6 col-xs-12 mb-2">
        <div class="card text-white bg-success" style="border-radius: 1rem;">
            <div class="card-header" style="font-size: 18px" v-html="{{ $form['label_notadinas'] }}"></div>
            <h2 class="text-right text-white mx-4 mt-2" v-html="{{ $form['total_notadinas'] }}"></h1>
            <h3 class="text-right text-white mx-4 mt-2" v-html="{{ $form['this_month_notadinas'] }}"></h3>
            <h3 style="margin-top: 0px;" class="text-right text-white mx-4" v-html="{{ $form['sys_notadinas'] }}"></h3>
        </div>
    </a>
    <a href="{{ url('dwf/document/list/lembar-disposisi') }}" class="col-md-6 col-xs-12 mb-2">
        <div class="card text-white bg-warning" style="border-radius: 1rem;">
            <div class="card-header" style="font-size: 18px" v-html="{{ $form['label_disposisi'] }}"></div>
            <h2 class="text-right text-white mx-4 mt-2" v-html="{{ $form['total_disposisi'] }}"></h2>
            <h3 class="text-right text-white mx-4 mt-2" v-html="{{ $form['this_month_disposisi'] }}"></h3>
            <h3 style="margin-top: 0px;" class="text-right text-white mx-4" v-html="{{ $form['sys_disposisi'] }}"></h3>
        </div>
    </a>
    <a href="{{ url('dwf/document/list/memo-internal') }}" class="col-md-6 col-xs-12 mb-2">
        <div class="card text-white bg-danger" style="border-radius: 1rem;">
            <div class="card-header" style="font-size: 18px" v-html="{{ $form['label_memo'] }}"></div>
            <h2 class="text-right text-white mx-4 mt-2" v-html="{{ $form['total_memo'] }}"></h2>
            <h3 class="text-right text-white mx-4 mt-2" v-html="{{ $form['this_month_memo'] }}"></h3>
            <h3 style="margin-top: 0px;" class="text-right text-white mx-4" v-html="{{ $form['sys_memo'] }}"></h3>
        </div>
    </a>
</div>
