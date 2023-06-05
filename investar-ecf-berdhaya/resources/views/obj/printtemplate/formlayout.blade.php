<div class="row">
    <div class="col-3">
        {!! $title ?? '' !!}
        {!! $slug ?? '' !!}
        {!! $description ?? '' !!}
        <div class="row">
            <div class="col-6">
                {!! $section ?? ''!!}
            </div>
            <div class="col-6">
                {!! $category ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {!! $pageSize ?? '' !!}
            </div>
        </div>
        <h6>Margins</h6>
        <div class="row">
            <div class="col-4">
            </div>
            <div class="col-4">
                {!! $marginTop ?? ''!!}
            </div>
            <div class="col-4">
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                {!! $marginLeft ?? ''!!}
            </div>
            <div class="col-6">
            </div>
            <div class="col-3">
                {!! $marginRight ?? ''!!}
            </div>
        </div>
        <div class="row">
            <div class="col-4">
            </div>
            <div class="col-4">
                {!! $marginBottom ?? ''!!}
            </div>
            <div class="col-4">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {!! $headerSetting ?? '' !!}
            </div>
            <div class="col-12">
                {!! $footerSetting ?? '' !!}
            </div>
            <div class="col-12">
                {!! $numberSetting ?? '' !!}
            </div>
            <div class="col-12">
                {!! $numberFormat ?? '' !!}
                eg:<br>'Hal ' counter(page) ' dari ' counter(pages)
            </div>
            <div class="col-12">
                {!! $firstNumberPosition ?? '' !!}
            </div>
            <div class="col-12">
                {!! $numberPosition ?? '' !!}
            </div>
        </div>
        <hr>
        {!! $attachments ?? '' !!}
    </div>
    <div class="col-9">
        <div class="row" >
            <div class="col-6" style="height: 50px;">
            </div>
            <div class="col-6">
                {!! $headFirst ?? '' !!}
            </div>
        </div>
        <div class="row" >
            <div class="col-6" style="height: 50px;">
                {!! $headLeft ?? '' !!}
            </div>
            <div class="col-6">
                {!! $headRight ?? '' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {!! $body ?? '' !!}
            </div>
        </div>
        <div class="row" >
            <div class="col-4" style="height: 50px;">
                {!! $footerLeft ?? '' !!}
            </div>
            <div class="col-4">
                {!! $footerCenter ?? '' !!}
            </div>
            <div class="col-1">
                [ page number ]
            </div>
        </div>
        <div class="row" >
            <div class="col-12" style="height: 50px;">
                {!! $footerFull ?? '' !!}
            </div>
        </div>
    </div>
</div>
