<div class="row">
    <div class="col-4">
        <div class="row">
            <div class="col-1">
                {!! $approve!!}
            </div>
        </div>
        <div class="row" style="margin-left:5px">
            <div class="col-8">
                {!! $select!!}
            </div>
            <div class="col-1">
                <div style="margin-top: -10px">
                    <button class="btn btn-default" style="margin-top:30px;margin-left: -10px;" @click="getSequence()">
                        <i class="las la-plus-square"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row" style="margin-left:5px">
            <div class="col-8">
                <label for="" style="color:#000000;font-weight:bold;">Note</label>
                {!! $note!!}
            </div>
        </div>
    </div>
    <div class="col-8">
        {!! $body !!}
    </div>
</div>
