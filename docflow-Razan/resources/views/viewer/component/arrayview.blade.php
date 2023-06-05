@if($label && $label != '')
    <label style="color:#800000; font-size:12px;" for="{{ $form['model'] }}" >{{ __($label) }}</label><br>
@endif
<div
    style="display: block; padding:6px; overflow-scrolling: auto;"
>
    <table class="table" >
        @if( isset($form['show_table_header'] ) && $form['show_table_header'] == true )
        <thead >
            <tr>
                @if( isset($form['ordered']) && $form['ordered'] )
                <th style="width: 50px;">
                    No
                </th>
                @endif
                <th v-for="val in {{ $form['model'] }}Fields">
                    @{{ val.label }}
                </th>
            </tr>
        </thead>
        @endif
        <tbody>
            <tr v-for="(value,index) in {{ $form['model'] }}">
                @if( isset($form['ordered']) && $form['ordered'] )
                    <td style="font-size:12px; width: 50px">
                        @{{ index + 1 }}
                    </td>
                @endif
                @if( isset($form['show_table_header'] ) && $form['show_table_header'] == true )
                        <td v-for="hval in {{ $form['model'] }}Fields" class="ellipsis" :class="hval.class" >
                            @{{ _.get(value, hval.key, '' ) }}
                        </td>
                @else
                        <td v-for="val in value" style="font-size:14px;" >
                            <a-tooltip placement="top" :title="val" >
                                <p class="ellipsis">
                                    @{{ val }}
                                </p>
                            </a-tooltip>
                        </td>
                @endif
            </tr>
        </tbody>
    </table>
</div>
