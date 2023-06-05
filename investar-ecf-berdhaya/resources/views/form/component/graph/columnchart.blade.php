@if(isset( $form['label']) && $form['label'] != '')
    <h6 class="card-title mb-0" >{{ $form['label'] }}</h6>
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

    @if(isset($form['chart_height']) )
        height="{{ $form['chart_height'] }}"
    @endif

    @if(isset($form['chart_width']) )
        width="{{ $form['chart_width']  }}"
    @endif

    @if(isset($form['stacked']) && $form['stacked'] == true )
        :stacked="true"
    @endif

    legend="{{ $form['legend_position'] ?? 'bottom' }}"

></column-chart>
