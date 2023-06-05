@if($label && $label != '')
    <label style="color:#800000; font-size:12px;" for="{{ $form['model'] }}" >{{ __($label) }}</label><br>
@endif
<div
    style="display: block; padding:6px; overflow-scrolling: auto;"
>
    <table class="table" >
        <thead >
            <tr>
                @if( isset($form['ordered']) && $form['ordered'] )
                <th style="width: 50px;">
                    No
                </th>
                @endif
                <th>
                    Key
                </th>
                <th>
                    Value
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(nval,nkey,index) in {{ $form['model'] }}">
                @if( isset($form['ordered']) && $form['ordered'] )
                    <td style="font-size:12px; width: 50px" class="ellipsis">
                        @{{ index + 1 }}
                    </td>
                @endif
                    <td style="font-size:14px;font-weight: bold;width: 30%;min-width: 150px !important;" class="ellipsis" >
                        @{{ nkey }}
                    </td>
                    <td style="font-size:14px;" class="ellipsis" >
                        @{{ nval }}
                    </td>
            </tr>
        </tbody>
    </table>
</div>
