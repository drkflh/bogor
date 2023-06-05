<div class="row">
    <div class="col-4" style="border-right: thin solid darkgrey;">
        {!! $scanCallCode ?? '' !!}
        <hr>
        {!! $docUpload ?? '' !!}
        <hr>
        <div class="row">
            <div class="col-10">
                <label class="mb-20" for="scanButton">Directory</label>
                <br>
                <i class="btn-icon-prepend" data-feather="folder"></i>
                /Directory/
            </div>
            <div class="col-2">
                <label class="mb-20" for="scanButton">Scan</label>
                <button type="button"
                        style="margin-right: 100px !important;"
                        @click="openScanner()"
                        class="btn btn-info btn-icon-text mr-2 mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="eye"></i>
                </button>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-6">
                <label class="mb-20" for="scanButton"># of Documents : </label>
                @{{ _.size(docList) }}
            </div>
            <div class="col-6">
                <button type="button"
                        style="margin-right: 100px !important;float:right;"
                        @click="clearScanTemp()"
                        class="btn btn-info btn-icon-text mr-2 mb-2 mb-md-0 pull-right">
                    <i class="btn-icon-prepend" data-feather="trash"></i> Clear Temp
                </button>
            </div>
        </div>
        {!! $docList ?? '' !!}
    </div>
    <div class="col-8">
        {!! $docViewer ?? '' !!}
    </div>
</div>
