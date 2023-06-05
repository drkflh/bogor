<div class="row">
    <div class="col-4" style="border-right: thin solid darkgrey;">
        <div class="row">
            <div class="col-6">
                {!! $IO !!}
            </div>
            <div class="col-6">
                {!! $IODate !!}
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                {!! $Tipe !!}
            </div>
            <div class="col-6">
                {!! $DocDate !!}
            </div>
        </div>
        {!! $Coy !!}
        {!! $DocRef !!}
        {!! $Subject !!}
        <div class="row">
            <div class="col-4">
                {!! $NoSheet !!}
            </div>
            <div class="col-4">
                {!! $NoPage !!}
            </div>
            <div class="col-4">
                {!! $OriginFormat !!}
            </div>
        </div>
        {!! $Sender !!}
        {!! $Recipient !!}
        {!! $Keyword !!}
    </div>
    <div class="col-8">
        <label class="h5">Call Code</label>
        <div class="row">
            <div class="col-3">
                @if($_isCreate)
                    {!! $TopicObject !!}
                @else
                    {!! $Topic !!}
                @endif
            </div>
            <div class="col-2">
                {!! $CoyCode !!}
            </div>
            <div class="col-2">
                {!! $Feature !!}
            </div>
            <div class="col-2">
                {!! $MMYY !!}
            </div>
            <div class="col-2">
                {!! $Urut !!}
            </div>
            <div class="col-1">
                @if($_isCreate)
                    <label>&nbsp;</label>
                    <button class="btn btn-default" @click="getSequence()">
                        <i class="fa fa-plus-square"></i> seq
                    </button>
                @endif
            </div>
        </div>
        {!! $TopicDescr !!}
        <hr>
        <label class="h5">Label</label>
        <div class="row">
            <div class="col-8" style="margin-left:12px;margin-top: 8px;">
                {!! $previewLabel !!}
            </div>
            <div class="col-1">
                {!! $printLabel !!}
            </div>
        </div>
        <hr>
        <label class="h5">Retention</label>
        <div class="row">
            <div class="col-3">
                {!! $RetPer !!}
            </div>
            <div class="col-3">
                {!! $RetDate !!}
            </div>
            <div class="col-3">
                {!! $DispPer !!}
            </div>
            <div class="col-3">
                {!! $DispDate !!}
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                {!! $Location !!}
            </div>
            <div class="col-3">
                {!! $Store !!}
            </div>
            <div class="col-3">
                {!! $Status !!}
            </div>
            <div class="col-3">
                {!! $Class !!}
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                {!! $ExpDate !!}
            </div>
            <div class="col-9">
                {!! $NotifyTo !!}
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-9">
                {!! $urlDisplay !!}
            </div>
            <div class="col-3">
                {!! $FileUrl !!}
            </div>
        </div>

    </div>
</div>
