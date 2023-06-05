<div class="form-row" style="border-bottom: thin solid #000000;">
</div>
<div class="form-row">
    <div style="background-color:#fff199;height:100px;width:150px; margin-right:2px; border-right: thin solid #000000;">
        <div style="margin-top:3px;padding-left: 8px;padding-right: 8px;">
            {!! $regDate ?? '' !!}
        </div>
    </div>
    <div style="padding-left:20px;padding-right: 15px;width: 170px;">
        {!! $docDate ?? '' !!}
    </div>
    <div style="width: 150px;padding-right:15px;">
        {!! $receivedDate ?? '' !!}
    </div>
    <div style="color:#000000;width: 150px;padding-right:15px;">
        {!! $titleCode ?? '' !!}
    </div>
{{--    <div style="width: 150px;padding-right:15px;">--}}
{{--        {!! $confidentiality ?? '' !!}--}}
{{--    </div>--}}
{{--    @if($_isCreate)--}}
{{--        <div style="margin-right: 0px">--}}
{{--            <button class="btn btn-default" style="margin-top:30px;margin-left: -10px;" @click="getSequence()">--}}
{{--                <i class="las la-plus-square"></i>--}}
{{--            </button>--}}
{{--        </div>--}}
{{--    @endif--}}
    <div style="width: 185px;">
        {!! $docNo ?? '' !!}
    </div>
{{--    <div style="width: 100px;margin-left:5px;margin-right:20px;">--}}
{{--        {!! $docStatus ?? '' !!}--}}
{{--    </div>--}}
</div>
<div class="form-row" style="height:5px; border-bottom: thin solid #000000;border-top: thin solid #000000;">
</div>

<div class="row" style="margin-left:3px;">
    <div class="col-4" style="margin-bottom:30px; ">
        <h6 style="color:#000000; font-size: 17px;"><b>Kepada: </b></h6>
        <div class="row">
            <div class="col-12">
                {!! $recipient ?? '' !!}
            </div>
        </div>
        <div class="row ">
            <div class="col-12">
                {!! $subject ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {!! $signer ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {!! $signatures ?? '' !!}
            </div>
        </div>
    </div>
    <div class="col-4" style="border-right: thin solid #000000;border-left: thin solid #000000;">
        <h6 style="color:#000000; font-size:17px;"><b>Isi dan Lampiran:</b></h6>
{{--        <div class="row">--}}
{{--            <div class="col-12">--}}
{{--                {!! $copy ?? '' !!}--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="row">
            <div class="col-12">
                {!! $dispositionContent ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {!! $attachments ?? '' !!}
            </div>
        </div>
{{--        <div class="row" style="margin-bottom:14px;">--}}
{{--            <div class="col-12">--}}
{{--                {!! $footer ?? '' !!}--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
    <div class="col-4">
        <h6 style="color:#000000; font-size:17px;"><b>Dokumen Terkait :</b></h6>
        <div class="row">
            <div class="col-12">
                {!! $docRef ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {!! $sender ?? '' !!}
            </div>
        </div>
{{--        <div class="row" style="margin-bottom:14px;">--}}
{{--            <div class="col-12">--}}
{{--                {!! $remarks ?? '' !!}--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
</div>
<div class="form-row" style="height:1px; border-top: thin solid #000000;">
</div>
<h6 style="color:#000000; font-size:17px;"><b>Isi :</b></h6>
<div class="row">
    <div class="col-12">
        {!! $body ?? '' !!}
    </div>
</div>

{{--{!! $receivedDate ?? '' !!}--}}
{{--{!! $location ?? '' !!}--}}

{{--{!! $dispositionContent ?? '' !!}--}}

{{--{!! $docType ?? '' !!}--}}
{{--{!! $formTemplate ?? '' !!}--}}
