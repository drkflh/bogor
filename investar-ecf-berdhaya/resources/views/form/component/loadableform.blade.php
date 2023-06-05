<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<loadable-form-modal
        v-model="{{ $form['model'] }}"
        :schema-options="{{ $form['model'].'SchemaOptions' }}"
        @if(isset($form['options']))
            search-url="{{ url( $form['options']['url'] )  }}"
        @endif
        @if(isset($form['param']))
            search-url="{{ url( $form['param']['url'] )  }}"
        @endif
        @if(isset($form['auto_select']) && $form['auto_select'] == true )
            auto-select
        @endif
        @if(isset($form['attr']))
            @foreach($form['attr'] as $att=>$v)
                {{ $att }}="{{ $v }}"
            @endforeach
        @endif
></loadable-form-modal>
<br>
