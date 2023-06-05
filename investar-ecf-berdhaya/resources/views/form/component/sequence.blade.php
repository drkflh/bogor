@if($label != '')
    <label for="{{ $form['model'] }}" >{{ __($label) ?? '&nbsp;' }}</label><br>
@endif
@if(env('SKIP_VALIDATION', true ))
    <div class="row">
        <div class="col-10">
            <input type="text"
                   name="{{ $form['model'] }}"
                   v-model="{{ $form['model'] }}"
                   @if(isset($form['v_show']))
                   v-show="{!! $form['v_show'] !!}"
                   @endif
                   @if(isset($form['placeholder']))
                   placeholder="{!! $form['placeholder'] !!}"
                   @endif
                   @if(isset($form['class']))
                   class="form-control {!! $form['class'] !!}"
                   @else
                   class="form-control"
            @endif
            @if(isset($form['attr']) && is_array($form['attr']))
                @foreach($form['attr'] as $at=>$av)
                    {{ $at }}="{{ $av }}"
                @endforeach
            @endif

            >
        </div>
        <div class="col-2 text-left">
            <button class="btn btn-outline-secondary" @click="getSequence()" >
                <i class="las la-plus-circle"></i>
            </button>
        </div>
    </div>
@else
    <validation-provider rules="{{ $form['validator'] ?? '' }}" v-slot="{ errors }" name="{{ strtolower($label) }}">
        <div class="form-inline">
            <input type="text"
                   name="{{ $form['model'] }}"
                   v-model="{{ $form['model'] }}"
                   @if(isset($form['v_show']))
                   v-show="{!! $form['v_show'] !!}"
                   @endif
                   @if(isset($form['placeholder']))
                   placeholder="{!! $form['placeholder'] !!}"
                   @endif
                   @if(isset($form['class']))
                   class="form-control {!! $form['class'] !!}"
                   @else
                   class="form-control"
            @endif
            @if(isset($form['attr']) && is_array($form['attr']))
                @foreach($form['attr'] as $at=>$av)
                    {{ $at }}="{{ $av }}"
                @endforeach
            @endif

            >
            <button class="btn btn-outline-secondary" @click="getSequence()" >
                <i class="las la-plus-circle"></i>
            </button>
        </div>
        <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
    </validation-provider>
@endif

