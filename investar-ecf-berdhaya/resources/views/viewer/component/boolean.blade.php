<i class="far fa-1_5x fa-check-circle mr-1" :class="booleanVal( {{ $form['model'] }} ) ? 'status-approved': 'status-canceled'  "  ></i>
@if(isset($label) && $label != '')
    <label for="{{ $form['model'] }}" class="view-label" >{{ __($label) }}</label>
@endif
