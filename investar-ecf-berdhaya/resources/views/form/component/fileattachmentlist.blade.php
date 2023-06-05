@if($label != '')
    <label for="{{ $form['model'] }}" >{{  __($label)  }}</label><br>
@endif
<file-attachment-list
    :items.sync="{{ $form['model'] }}"
    :direct-view-action="{{ $form['direct_view_action'] ?? 'true' }}"
></file-attachment-list>
