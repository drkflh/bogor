@if($label && $label != '')
    <label for="{{ $form['model'] }}" style="font-size: 9pt;font-weight: bold;" >{{ $label }}</label>
@endif
<table class="table" style="width: 100%;height:200px;">
    <tr>
        <td style="width:60% !important;min-width:120px;">
            <vue-svg-gauge
                :start-angle="-110"
                :end-angle="110"
                :value="{{ $form['model'] }}"
                :separator-step="0"
                :min="{{ $form['min_val'] ?? 0 }}"
                :max="{{ $form['max_val'] ?? 100 }}"
                gauge-color="#C70039"
                base-color="#DAF7A6"
                :scale-interval="{{ $form['scale_interval'] ?? 0.1 }}"
            >
                <div style="height:100%;width:100%;position:relative;">
                    <span style="position: absolute; bottom: 0px; height: 35px; width: 100%; text-align: center;font-size:18pt;font-weight: bold;" v-html="{{ $form['model'] }}" ></span>
                </div>
            </vue-svg-gauge>
        </td>
        <td style="max-width:80px;">
            <div style="font-size:14pt;font-weight: bold;width:100%;line-height: 30pt;" >Avg</div>
            <div style="font-size:22pt;font-weight: bold;" v-html="formatCurrency( avg{{ $form['model'] }} )" ></div>
        </td>
    </tr>
</table>
