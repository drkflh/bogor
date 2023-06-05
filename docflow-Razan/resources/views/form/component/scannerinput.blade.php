<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<scanner-input
        v-model="{{ $form['model'] }}"
        :aux-data="{{ $form['auxData'] }}"
        :result.sync="{{ $form['result'] }}"
        @if(isset($form['options']))
            search-url="{{ url( $form['options']['url'] )  }}"
        @endif
        @if(isset($form['param']))
            search-url="{{ url( $form['param']['url'] )  }}"
        @endif
        @if(isset($form['show_result']) && $form['show_result'] == true )
            show-result
        @endif
        @if(isset($form['auxRequired']) && $form['auxRequired'] == true )
            aux-required
            aux-req-message="{{ $form['auxReqMessage'] }}"
        @endif
        @if(isset($form['extra_data']))
            :extra-data="{{ $form['extra_data'] ?? '{}'  }}"
        @endif
></scanner-input>
<br>
