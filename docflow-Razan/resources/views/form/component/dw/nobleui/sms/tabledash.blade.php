<div class="grid-margin card">
    <div class="card-body">
    <div class="d-flex">
        <img :style="{{ $form['style_image'] ?? 'width:50px;height:50px;margin-right:8px' }}" :src="{{ $form['image'] ?? '' }}"/>
        <h4 style="margin-top: 8px;" :class="{{ $form['title_color'] ?? 'text-red' }}" v-html="{{ $form['title_table'] ?? '' }}"></h4>
    </div>
        <div class="table-responsive" style="max-height: 320px;height: 320px; overflow-x: auto;">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th v-for="(item, index) in {{ $form['th_table'] }}" :key="index"
                            @if(isset($form['th_class']))
                                :class="{{ $form['th_class'] }}[index]"
                            @endif
                        >
                            <b v-html="item"></b>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in {{ $form['td_table']}}" :key="index"
                    >
                        <td style="font-size: 10pt;padding: 8px !important;"
                            @if(isset($form['th_class']))
                                :class="{{ $form['th_class'] }}[0]"
                            @endif
                        >
                            <p style="margin: 0px;" v-html="index+1"></p>
                        </td>
                        <td style="font-size: 10pt;padding: 8px !important;" v-for="(x, y, z) in item" :key="z">
                            <a-tooltip placement="top" :title="x" >
                                <p style="margin: 0px;"
                                   v-if="x"
                                   @if(isset($form['th_class']))
                                   :class="{{ $form['th_class'] }}[z+1]"
                                   @endif
                                >
                                    <span v-if="y == 'company'" style="font-weight:400;color:#1c2f55;" ><b>@{{ x }}</b></span>
                                    <span v-else-if="y == 'lastFollowUp' || y == 'actualDelivery'">@{{ formatDate(x) }}</span>
                                    <span v-else v-html="x"></span>
                                </p>
                                <p v-else>-</p>
                            </a-tooltip>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
