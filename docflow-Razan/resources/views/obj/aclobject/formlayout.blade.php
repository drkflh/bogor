<div class="row">
    <div class="col-4">
        <div class="row">
            <div class="col-7">
                {!! $group ?? '' !!}
            </div>
            <div class="col-5">
                {!! $isActive ?? '' !!}
            </div>
        </div>
        {!! $objectName ?? '' !!}
        {!! $objectKey ?? '' !!}
        {!! $objectDescription ?? '' !!}
    </div>
    <div class="col-4">
        {!! $standardCrud ?? '' !!}<br>
        <hr>
        <h5>Custom Permission Object</h5>
        {!! $checkMethod ?? '' !!}
        <h6>Text Match</h6>
        {!! $textMatchDir ?? '' !!}
        {!! $textMatchSubject ?? '' !!}
        {!! $textMatchMode ?? '' !!}
        {!! $textMatchField ?? '' !!}
    </div>
    <div class="col-4">
        <h5>Parameter</h5>
        <b>Use Standard CRUD</b>
        <p>Will default to standard Create, Read, Update, Delete permission parameter, with addition of Multiple Delete, Clone & Multiple Clone. this parameter is additive to Custom Object if any.</p>
        <b>Check Method</b>
        <p><b>BooleanCheck</b> will check the state of each set parameters in acl.crud</p>
        <p><b>TextMatcher</b> will perform text operation between subject and userfield content or string  literal.
            the comparison direction may be reversed
        </p>
        <p><b>Match Subject</b> by default is equal with Object Key, while modifiable into any string literal
            to match with user field content
        </p>
        <b>Db</b>
        <p>Load the value array a database collection. specified in the parameter string are :
            [collection name]:[key field name]:[value field name], separated by colon ":"
        </p>
        <b>Config</b>
        <p>Load the value array from config file, the value loaded must be an associative array / hash / key value array</p>
    </div>
</div>
