<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<drawing-board
        v-model="{{ $form['model'] }}"
        :item-id="{{ $form['item_id'] }}"
        :tab-key="{{ $form['tab_key'] }}"
        :image-url="{{ $form['model'].'ImgUrl' }}"
        :image-name="{{ $form['model'].'ImgName' }}"
        :image-id="{{ $form['model'] }}"
        :image-token="{{ $form['model'].'ImgToken' }}"
        :url-load="{{ $form['model'].'UrlLoad' }}"
        :url-return="{{ $form['model'].'UrlReturn' }}"
        :url-save="{{ $form['model'].'UrlSave' }}"
        :editor-url="{{ $form['model'].'EditorUrl' }}"
        :handle="handle"

        @if(isset($form['show_upload']) && $form['show_upload'] == true)
            show-upload
        @endif

        ns="{{ $form['model'] }}"

        :image-upload.sync="{{ $form['image_upload'] }}"
        @if(isset($form['options']))
            uploadurl="{{ url( $form['options']['url'] )  }}"
        @endif
        @if(isset($form['param']))
            uploadurl="{{ url( $form['param']['url'] )  }}"
        @endif
        :defaulturl="defaultImageDraw"
        mode="single"
        :docbase="drawbase"
        buttonlabel="{{ (isset($form['attr']['buttonlabel']))?$form['attr']['buttonlabel']:'Edit' }}"
    >

</drawing-board>
