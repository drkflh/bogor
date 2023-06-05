<div class="card" style="border-radius: 1rem;">
  <div class="card-body" data-toggle="collapse" href="#collapseLansiaUsia">
    <h4 v-html="{{ $form['title'] }}"></h4>
    <br>
    @if(isset( $form['label']))

    @endif
    <line-chart

        @if(isset($form['url']) )
            data="{{ url( $form['url'] ) }}"
        @else
            :data="{{ $form['model'] }}"
        @endif

        @if(isset($form['refresh']) )
            refresh="{{ url( $form['refresh'] ) }}"
        @endif

    ></line-chart>
  </div>
  <div class="collapse" id="collapseLansiaUsia">
    <div class="table-responsive overflow-auto">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th><b>No</b></th>
                    <th><b>Provinsi</b></th>
                    <th><b>60-64</b></th>
                    <th><b>65-69</b></th>
                    <th><b>70-74</b></th>
                    <th><b>75-79</b></th>
                    <th><b>80-84</b></th>
                    <th><b>85-89</b></th>
                    <th><b>>=90</b></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in {{ $form['lansiaUsiaCount'] }}" :key="index">
                    <td style="font-size: 14px;" @if (isset($form['th_class'])) :class="{{ $form['th_class'] }}[0]" @endif>
                        <p v-html="index+1"></p>
                    </td>
                    <td style="font-size: 14px;" >
                        <detail-prov-usia
                        :label="item.provinsi"
                        prov-url="detail-prov-usia"
                        :wilcah="item.wilcah"
                        >
                    </detail-prov-usia>
                    </td>
                    <td style="font-size: 14px;" >
                        <p  v-if="item" v-html="item.r6064"></p>
                        <p v-else>-</p>
                    </td>
                    <td style="font-size: 14px;" >
                        <p  v-if="item" v-html="item.r6569"></p>
                        <p v-else>-</p>
                    </td>
                    <td style="font-size: 14px;" >
                        <p  v-if="item" v-html="item.r7074"></p>
                        <p v-else>-</p>
                    </td>
                    <td style="font-size: 14px;" >
                        <p  v-if="item" v-html="item.r7579"></p>
                        <p v-else>-</p>
                    </td>
                    <td style="font-size: 14px;" >
                        <p  v-if="item" v-html="item.r8084"></p>
                        <p v-else>-</p>
                    </td>
                    <td style="font-size: 14px;" >
                        <p  v-if="item" v-html="item.r8589"></p>
                        <p v-else>-</p>
                    </td>
                    <td style="font-size: 14px;" >
                        <p  v-if="item" v-html="item.r90"></p>
                        <p v-else>-</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    {{-- <p v-html="{{ $form['test'] }}"></p> --}}
</div>
</div>
