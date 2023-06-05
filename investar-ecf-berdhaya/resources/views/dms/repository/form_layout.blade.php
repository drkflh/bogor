<div class="row">
    <div class="col-lg-5 col-md-5" style="border-right: thin solid darkgrey;overflow: auto;">
        <div class="row">
            <div class="col-12">
                {!! $FileUrl !!}
            </div>
            <div class="col-12" style="cursor:pointer;" @click="viewPdf()">
                {!! $urlDisplay !!}
            </div>
        </div>
        <h5>Label</h5>
        <div class="row">
            <div class="col-md-8 mt-2 ml-2">
                {!! $previewLabel !!}
            </div>
            <div class="col-md-3">
                <button class="btn btn-icon" @click="embedQR()" >
                    <i class="las la-qrcode" style="font-size: 16pt;"></i>
                </button>
                Embed QR
                <b-spinner v-if="isEmbedding" small></b-spinner>
                <hr style="margin: 4px;">
                {!! $printLabel !!}
            </div>
        </div>
        <hr>
        <h5>Call Code</h5>
        <hr>
        <div class="row">
            <div class="col-2 pr-0">
                <label for="TopicObject">Topic</label><br>
                <input v-model="Topic"
                       class="form-control  "
                       name="Coy"
                       type="text"
                       disabled="disabled"
                       readonly="readonly"
                >
            </div>
            <div class="col-2 pr-0">
                <label class="" for="Coy">Company</label>
                <input v-model="Coy"
                       class="form-control  "
                       name="Coy"
                       type="text"
                       disabled="disabled"
                       readonly="readonly"
                >
            </div>
            <div class="col-3 pr-0">
                <label class="" for="Feature">Feature</label>
                <input v-model="Feature"
                       class="form-control  "
                       name="Coy"
                       type="text"
                       disabled="disabled"
                       readonly="readonly"
                >
            </div>
            <div class="col-2 pr-0">
                <label class="" for="MMYY">MMYY</label>
                <input v-model="MMYY"
                       class="form-control  "
                       name="MMYY"
                       type="text"
                       disabled="disabled"
                       readonly="readonly"
                >
            </div>
            <div class="col-3">
                {!! $Urut !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
{{--                @if($_isCreate)--}}
                    {!! $TopicObject !!}
{{--                @else--}}
{{--                    {!! $Topic !!}--}}
{{--                @endif--}}
            </div>
            <div class="col-md-5">
                {!! $Coy !!}
            </div>
            <div class="col-md-4">
                {!! $DocDate !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                {!! $Feature !!}
            </div>
            <div class="col-md-9">
                {!! $DocRef !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! $TopicDescr !!}
            </div>
        </div>

        <hr>
        <h5>{{ __('Document Cataloging') }}</h5>
        <div class="row">
            <div class="col-md-4">
                {!! $Tipe !!}
            </div>
            <div class="col-md-4">
                {!! $IO !!}
            </div>
            <div class="col-md-4">
                {!! $OriginFormat !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                {!! $IODate !!}
            </div>
            <div class="col-md-4">
                {!! $ExpDate !!}
            </div>
        </div>
        {!! $Subject !!}
        <div class="row">
            <div class="col-md-6">
                {!! $Sender !!}
            </div>
            <div class="col-md-6">
                {!! $Recipient !!}
            </div>
        </div>
        <hr>
        <h5>{{ __('Document Storage Management') }}</h5>
        <hr>
        <div class="row">
            <div class="col-md-3">
                {!! $NoSheet !!}
            </div>
            <div class="col-md-3">
                {!! $NoPage !!}
            </div>
            <div class="col-md-3">
                {!! $Location !!}
            </div>
            <div class="col-md-3">
                {!! $Store !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                {!! $Class !!}
            </div>
            <div class="col-md-3">
                {!! $Status !!}
            </div>
            <div class="col-md-6">
                {!! $NotifyTo !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h6>Active</h6>
                <div class="row">
                    <div class="col-md-5">
                        {!! $RetPer !!}
                    </div>
                    <div class="col-md-7">
                        {!! $RetDate !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h6>Disposal</h6>
                <div class="row">
                    <div class="col-md-5">
                        {!! $DispPer !!}
                    </div>
                    <div class="col-md-7">
                        {!! $DispDate !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7 col-md-7">
        {!! $docViewer !!}
    </div>
</div>
