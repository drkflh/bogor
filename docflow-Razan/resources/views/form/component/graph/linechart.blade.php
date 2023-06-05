@if(isset( $form['label']) && $form['label'] != '')
    <h6 class="card-title mb-0" >{{ $form['label'] }}</h6>
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
