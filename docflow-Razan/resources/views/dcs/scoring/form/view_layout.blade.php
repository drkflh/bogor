<div class="row">
    <div class="col-2">
        {!! $isActive ?? '' !!}
        {!! $section ?? '' !!}
        {!! $category ?? '' !!}
        {!! $tags ?? '' !!}
        {!! $slug ?? '' !!}
        <div class="row">
            <div class="col-6">
                {!! $validFrom ?? '' !!}
            </div>
            <div class="col-6">
                {!! $validUntil ?? '' !!}
            </div>
        </div>
        {!! $picture ?? '' !!}
    </div>
    <div class="col-5">
        <div class="row" >
            <div class="col-3" style="height: 100px;">
                {!! $formCode ?? '' !!}
            </div>
            <div class="col-9">
                {!! $title ?? '' !!}
            </div>
        </div>
        <div class="row" >
            <div class="col-3" style="height: 100px;">
                {!! $layout ?? '' !!}
            </div>
            <div class="col-9">
                {!! $description ?? '' !!}
            </div>
        </div>
        <h5>Custom Layout</h5>
        <b-form-radio-group>
            <b-form-radio value="noHeader" v-model="formHeader" >No Header</b-form-radio>
            <b-form-radio value="splitHead" v-model="formHeader" >Split Header</b-form-radio>
            <b-form-radio value="fullHead" v-model="formHeader" >Full Header</b-form-radio>
        </b-form-radio-group>
        <b-form-radio-group>
            <b-form-radio value="noFooter" v-model="formFooter" >No Footer</b-form-radio>
            <b-form-radio value="splitFooter" v-model="formFooter" >Split Footer</b-form-radio>
            <b-form-radio value="fullFooter" v-model="formFooter" >Full Footer</b-form-radio>
        </b-form-radio-group>
        <div class="row" v-if="formHeader != 'noHeader'" >
            <div class="col-6" style="height: 50px;">
                {!! $headLeft ?? '' !!}
            </div>
            <div class="col-6">
                {!! $headRight ?? '' !!}
            </div>
        </div>
        {!! $body ?? '' !!}
        <div class="row"  v-if="formFooter != 'noFooter'">
            <div class="col-6" style="height: 50px;">
                {!! $footerLeft ?? '' !!}
            </div>
            <div class="col-6">
                {!! $footerCenter ?? '' !!}
            </div>
        </div>
    </div>
    <div class="col-5">
        <h5>Preview</h5>

    </div>
</div>
