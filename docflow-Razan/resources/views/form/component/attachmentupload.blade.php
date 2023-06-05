@if( $label && $label != '')
<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
@endif
<attachment-upload
    v-model="{{ $form['model'] }}"
    :file-objects.sync="{{ $form['model'] }}Objects"
    :handle="handle"
    :direct-view-action="{{ isset($form['direct_view_action']) && $form['direct_view_action'] ? 'true': 'false' }}"
    ns="{{ $form['model'] }}"
    bucket="{{ $form['bucket'] ?? 'document' }}"
    accepted-files="{{ $form['acceptedFiles'] ?? 'application/pdf, image/*, video/*'  }}"
    @if(isset($form['on_attachment_click']))
        @onattachmentitemclick="{{ $form['on_attachment_click'] ?? 'addAttachmentClick' }}"
    @endif
    @if(isset($form['options']))
        uploadurl="{{ url( $form['options']['url'] )  }}"
    @endif
    @if(isset($form['param']))
        uploadurl="{{ url( $form['param']['url'] )  }}"
    @endif
    caption-url="{{ url( $form['caption_url'] ?? 'api/v1/core/upload/caption' )  }}"
    mode="{{ $form['mode'] ?? 'multi' }}"
    :show-list="{{ isset($form['show_list']) && $form['show_list'] ? 'true':'false' }}"
    :return-array="{{ $form['return_array'] ?? 'false' }}"
    :can-copy="{{ $form['can_copy'] ?? 'false' }}"
    defaulturl="{{ url( env('DEFAULT_THUMBNAIL') ) }}"
    buttonlabel="{{ (isset($form['param']['buttonlabel']))?$form['param']['buttonlabel']:'Click or drop to upload' }}"
    :use-caption="{{ isset($form['use_caption']) && $form['use_caption'] ? 'true':'false' }}"
    :caption-required="{{ isset($form['caption_required']) && $form['caption_required'] ? 'true':'false' }}"
    caption-label="{{ $form['caption_label'] ?? 'Description' }}"
    @if(isset($form['extra_data']))
    :extra-data="{{ $form['extra_data'] ?? '{}'  }}"
    @endif
>
</attachment-upload>
