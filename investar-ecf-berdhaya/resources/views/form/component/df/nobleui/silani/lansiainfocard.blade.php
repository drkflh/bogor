<div class="card card-list shadow-sm" style="border-radius: 1rem;">
    <div class="card-body">
        <h4 v-html="{{ $form['label'] }}"></h4>
        {{-- info utama --}}
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex mt-3">
                <i class="las la-users la-4x mr-3"></i>
                <h1 v-html="{{ $form['total_user'] }}"></h1>
            </div>
            <a class="btn btn-primary py-2 px-4" data-toggle="collapse" href="#collapseLansiaCount">Lihat Detail</a>
        </div>
      <div class="collapse" id="collapseLansiaCount">
        <div class="table-responsive overflow-auto">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th><b>No</b></th>
                        <th><b>Provinsi</b></th>
                        <th><b>Count</b></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in {{ $form['lansiaKotaCount'] }}" :key="index">
                        <td style="font-size: 14px;" @if (isset($form['th_class'])) :class="{{ $form['th_class'] }}[0]" @endif>
                            <p v-html="index+1"></p>
                        </td>
                        <td style="font-size: 14px;" >
                            <detail-prov
                            :label="item.provinsi"
                            prov-url="detail-prov"
                            :wilcah="item.wilcah"
                            >
                        </detail-prov>
                        </td>
                        <td style="font-size: 14px;" >
                            <p  v-if="item" v-html="item.count"></p>
                            <p v-else>-</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        {{-- <p v-html="{{ $form['test'] }}"></p> --}}
    </div>

        {{-- info detail --}}
        <h4 class="mt-3"><b>Info Detail</b></h4>
        <div class="d-flex justify-content-between align-items-center" v-for="(x,y) in {{ $form['detail'] }}">
            <div class="d-flex my-1">
                <i :class="`${x[0]} la-2x mr-2`"></i>
                <h5 class="mt-2" v-html="x[1]"></h5>
            </div>
            <h4 v-html="x[2]"></h4>
        </div>
        <div class="d-flex">
            <i class="las la-user-friends la-2x mr-2"></i>
            <h5 class="mt-2">Gender Lansia</h5>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            {{-- chart pie --}}
            <div>
                <apexchart
                    width="220"
                    height="auto"
                    :options="{{ $form['chart_options'] }}"
                    :series="{{ $form['chart_model'] }}"
                ></apexchart>
            </div>
            <a class="btn btn-primary py-2 px-4" data-toggle="collapse" href="#collapseLansiaGender">Lihat Detail</a>
        </div>
        <div class="collapse" id="collapseLansiaGender">
           <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th><b>No</b></th>
                            <th><b>Provinsi</b></th>
                            <th><b>Laki - Laki</b></th>
                            <th><b>Perempuan</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in {{ $form['lansiaGender'] }}" :key="index">
                            <td style="font-size: 14px;" @if (isset($form['th_class'])) :class="{{ $form['th_class'] }}[0]" @endif>
                                <p v-html="index+1"></p>
                            </td>
                            <td style="font-size: 14px;" >
                                <detail-prov-gender
                                :label="item.provinsi"
                                prov-url="detail-prov-gender"
                                :wilcah="item.wilcah"
                                >
                                </detail-prov-gender>
                            </td>
                            <td style="font-size: 14px;" >
                                <p  v-if="item" v-html="item.male"></p>
                                <p v-else>-</p>
                            </td>
                            <td style="font-size: 14px;" >
                                <p  v-if="item" v-html="item.female"></p>
                                <p v-else>-</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </div>
</div>
