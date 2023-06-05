<div class="row">
    <div class="col-2">
        {!! $section!!}
        {!! $category !!}
        {!! $tags !!}
        {!! $status !!}
        {!!  $slug !!}
        <div class="row">
            <div class="col-6">
                {!! $validFrom !!}
            </div>
            <div class="col-6">
                {!! $validUntil !!}
            </div>
        </div>
        {!! $picture !!}
    </div>
    <div class="col-10">
        {!! $title !!}
        {!! $description !!}
        <div class="row">
            <div class="col-6">
                {!! $body !!}
            </div>
            <div class="col-6">
                <label>Preview</label>
                <active-form
                    v-model="contentObject"
                    :content="contentString"
                    :object-default="contentObject"
                    :template="body"
                ></active-form>
            </div>
        </div>
    </div>
</div>
