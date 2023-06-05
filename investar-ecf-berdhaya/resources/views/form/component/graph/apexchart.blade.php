@if(isset( $form['label']))

@endif
<apexchart
    width="{{ $form['chart_width'] }}"
    height="{{ $form['chart_height'] }}"
    :options="{{ $form['chart_options'] }}"
    :series="{{ $form['chart_series'] }}"
></apexchart>
