<div class="row">
    <div class="col-5">
        <div class="row" >
            <div class="col-6" >
                {!! $formCode !!}
            </div>
            <div class="col-4">
                {!! $layout !!}
            </div>
            <div class="col-2">
                {!! $isActive !!}
            </div>
        </div>
        {!! $title !!}
        {!! $slug !!}
        <div class="row" >
            <div class="col-6">
                {!! $section!!}
            </div>
            <div class="col-6">
                {!! $category !!}
            </div>
        </div>
        <div class="row" >
            <div class="col-5">
                {!! $tags !!}
            </div>
            <div class="col-7">
                {!! $access!!}
            </div>
        </div>
        {!! $accessUrl !!}
        {!! $description !!}
{{--        <div class="row">--}}
{{--            <div class="col-6">--}}
{{--                {!! $validFrom !!}--}}
{{--            </div>--}}
{{--            <div class="col-6">--}}
{{--                {!! $validUntil !!}--}}
{{--            </div>--}}
{{--        </div>--}}
        {!! $picture !!}
    </div>
    <div class="col-7">
        <b-tabs>
            <b-tab title="Questions">
                {!! $formQuestions!!}
            </b-tab>
            <b-tab title="Preview">

            </b-tab>
            <b-tab title="Custom Layout">
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
                <div class="row" v-if="formHeader == 'splitHead'" >
                    <div class="col-6" >
                        {!! $headLeft !!}
                    </div>
                    <div class="col-6">
                        {!! $headRight !!}
                    </div>
                </div>
                <div class="row" v-if="formHeader == 'fullHead'" >
                    <div class="col-12" style="display:block;">
                        {!! $headFull !!}
                    </div>
                </div>
                <div class="row" >
                    <div class="col-12">
                        {!! $body !!}
                    </div>
                </div>
                <div class="row"  v-if="formFooter != 'noFooter'">
                    <div class="col-6" >
                        {!! $footerLeft !!}
                    </div>
                    <div class="col-6">
                        {!! $footerCenter !!}
                    </div>
                </div>

            </b-tab>
        </b-tabs>

    </div>
</div>
