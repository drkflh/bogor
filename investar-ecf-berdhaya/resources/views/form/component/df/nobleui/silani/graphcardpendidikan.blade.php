<div class="card" style="border-radius: 1rem;">
  <div class="card-body" data-toggle="collapse" href="#collapseLansiaPendidikan">
    <h4 v-html="{{ $form['title'] }}"></h4>
    <br>
    @if(isset( $form['label']))

    @endif
    <column-chart

        @if(isset($form['url']) )
            data="{{ url( $form['url'] ) }}"
        @else
            :data="{{ $form['model'] }}"
        @endif

        @if(isset($form['refresh']) )
            refresh="{{ url( $form['refresh'] ) }}"
        @endif

    ></column-chart>
  </div>
  <div class="collapse" id="collapseLansiaPendidikan">
    <div class="table-responsive overflow-auto">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th><b>No</b></th>
                    <th><b>Provinsi</b></th>
                    <th><b>Tidak/belum sekolah</b></th>
                    <th><b>Belum tamat SD/Sederajat</b></th>
                    <th><b>Tamat SD/Sederajat</b></th>
                    <th><b>SLTP/Sederajat</b></th>
                    <th><b>SLTA/Sederajat</b></th>
                    <th><b>Diploma 1/II atau lebih tinggi</b></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in {{ $form['pendidikanLansiaCount'] }}" :key="index">
                    <td style="font-size: 14px;" @if (isset($form['th_class'])) :class="{{ $form['th_class'] }}[0]" @endif>
                        <p v-html="index+1"></p>
                    </td>

                    <td style="font-size: 14px;" >
                        <detail-prov-pendidikan
                        :label="item.provinsi"
                        prov-url="detail-prov-pendidikan"
                        :wilcah="item.wilcah"
                        >
                        </detail-prov-pendidikan>
                    </td>
                    <td style="font-size: 14px;text-align:center" >
                        <p  v-if="item" v-html="item.Tidakbelumsekolah"></p>
                        <p v-else>-</p>
                    </td>
                    <td style="font-size: 14px;text-align:center" >
                        <p  v-if="item" v-html="item.BelumtamatSDSederajat"></p>
                        <p v-else>-</p>
                    </td>
                    <td style="font-size: 14px;text-align:center" >
                        <p  v-if="item" v-html="item.TamatSDSederajat"></p>
                        <p v-else>-</p>
                    </td>
                    <td style="font-size: 14px;text-align:center" >
                        <p  v-if="item" v-html="item.SLTPSederajat"></p>
                        <p v-else>-</p>
                    </td>
                    <td style="font-size: 14px;text-align:center" >
                        <p  v-if="item" v-html="item.SLTASederajat"></p>
                        <p v-else>-</p>
                    </td>
                    <td style="font-size: 14px;text-align:center" >
                        <p  v-if="item" v-html="item.Diploma1IIataulebihtinggi"></p>
                        <p v-else>-</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>
