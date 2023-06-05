<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<pdf-annotator
        doc-url="{{ url( 'doc/test_doc.pdf' ) }}"
        :handle="handle"
        ns="{{ $form['model'] }}"
        base-url=""
        :defaulturl="defaultImageDraw"
        mode="single"
        buttonlabel="{{ (isset($form['attr']['buttonlabel']))?$form['attr']['buttonlabel']:'Edit' }}"
    >

</pdf-annotator>
