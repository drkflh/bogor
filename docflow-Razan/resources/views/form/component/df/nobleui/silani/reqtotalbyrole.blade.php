<div class="card mb-4" style="border-radius: 1rem;">
    <div class="p-3 row">
        <div class="col-md-4 text-center" style="border-right: 1px solid grey;">
            <h5>Naskah Bulan Ini</h5>
            <h5 class="mt-2" v-html="{{$form['total_cm']}}"></h5>
        </div>
        <div class="col-md-4 text-center" style="border-right: 1px solid grey;">
            <h5>Naskah Total</h5>
            <h5 class="mt-2" v-html="{{$form['total_ln']}}"></h5>
        </div>
        <div class="col-md-4 text-center">
            <h5>Rata-rata Harian</h5>
            <h5 class="mt-2" v-html="{{$form['total_ad']}}"></h5>
        </div>
    </div>
</div>
