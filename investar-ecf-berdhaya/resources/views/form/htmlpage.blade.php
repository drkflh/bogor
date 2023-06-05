@extends($layout??'layouts.dashforge')

@section('js')
    <style>
        .btn.btn-secondary.vbt-reset-button,
        .btn.btn-secondary.vbt-refresh-button,
        .btn.btn-secondary.dropdown-toggle {
            background-color: transparent;
            color: darkslategrey;
            border-color: lightgrey;
        }

        .table-active, .table-active td {
            background-color: transparent !important;
        }

        label {
            display: inline-block;
            margin-bottom: 0.5rem;
            margin-top: 0.8rem;
        }
        .daterangepicker{
            display: block !important;
            top: 25px !important;
            min-width: 400px;
        }

        .vue-daterange-picker {
            padding-left: 0px !important;
        }

        .col-action{
            width: 100px;
            min-width: 100px;
        }
        .fill-parent{
            width: 50%;
            max-width: 50% ;
        }
        h2.mt-2 {
            font-size: 18px;
            vertical-align: middle;
            padding-top: 8px;
            padding-bottom: 16px;
        }
        /* vue2 datepicker */
        .mx-datepicker-popup {
            z-index: 2000 !important;
        }
        .v-center {
            margin: 0;
            position: relative;
            top: 50%;
            -ms-transform: translate(0%, -50%);
            transform: translate(0%, -50%);
        }
        .card a.nav-link {
            font-weight: bold;
            font-size: 14pt;
        }
    </style>

    <link href="{{ url( env('APP_CSS', 'css/parama.css') ) }}" rel="stylesheet">
    <link href="{{ url('/') }}/css/table_framework.css" rel="stylesheet">

    <script src="{{ url('/') }}/editor/ckeditor5-31.1.0/build/ckeditor.js" ></script>

    <script>
        $(document).ready(function(){

            window.tz = "{{ $tz ?? env('DEFAULT_TIME_ZONE', 'Asia/Jakarta') }}";

            var intervalID = null;

            var lightboxvm = new Vue({
                mounted(){
                    bus.$on('openlightbox', (data) => {
                        console.log(data);
                        this.galleryUrls = data.gallery;
                        this.showLightBox(data.index);
                        //this.onPopOpen(data);
                    });
                },
                name: 'Lightbox Modal',
                data: function(){
                    return {
                        galleryUrls : [],
                        lightBoxVisible: false,
                        lightBoxindex: 0,
                    };
                },
                methods:{
                    showLightBox(index){
                        this.lightBoxindex = index;
                        this.lightBoxVisible = true;
                    },
                    isDoc(file) {
                        var extension = file.substr((file.lastIndexOf('.') +1));
                        if (/(pdf|zip|doc)$/ig.test(extension)) {
                            return true;
                        }else{
                            return false;
                        }
                    },
                    lightBoxHandleHide(){
                        this.lightBoxVisible = false;
                        this.lightBoxindex = 0;
                        this.galleryUrls = [];
                    },
                    showPdf(url) {
                        this.pdfDocUrl = url;
                        this.pdfLightBoxVisible = true;
                    }
                }
            }).$mount('#lightBoxContainer');

            var uvm = new Vue({
                mounted(){
                    bus.$on('refreshPage',()=>{
                        @if($mode == 'add')
                            this.getParam();
                        @else
                            this.getItemData(this.itemId);
                        @endif
                        @if($customLoader && $customLoader != '')
                            {{ $customLoader }}
                        @endif
                    });

                    bus.$on('loadPageData',()=>{
                        @if($mode == 'add')
                            this.getParam();
                        @else
                            this.getItemData(this.itemId);
                        @endif
                        @if($customLoader && $customLoader != '')
                            {{ $customLoader }}
                        @endif
                    });

                    bus.$on('opendraw', (ev, data) => {
                        this.openDrawingBoard();
                    });

                    bus.$on('popopen', (ev, data) => {
                        this.onPopOpen(ev, data);
                    });

                    @if($mode == 'add')
                        this.getParam();
                    @endif

                    window.dispatchEvent(new Event('resize'));

                    // this.startAutosave();
                    //
                    // if(this.$localStorage){
                    //     var last = this.$localStorage.get( 'LAST_' + this.localStorageKey ,[]);
                    //
                    //     if(!_.isEmpty(last)){
                    //         this.lastFive = JSON.parse(last);
                    //     }else{
                    //         this.lastFive = [];
                    //     }
                    //
                    // }

                },
                name: 'Page VM',
                data: function(){
                    return {
                        @if(strpos($yml_file, '_controller') === false)
                            {!! implode("\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataModel('default') ) !!}
                        @else
                            {!! implode("\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataList() ) !!}
                        @endif
                        title:'Update',
                        itemId : '{{ $_id }}',
                        formMode : '',
                        handle: '',
                        keyword0: '{!! $keyword0 !!}',
                        keyword1: '{!! $keyword1 !!}',
                        keyword2: '{!! $keyword2 !!}',
                        paramUrl: '{{ url($paramurl) }}',
                        loadSession: '',
                        autosave: {{ env('AUTOSAVE_ON')?'true':'false' }},
                        autosaving: false,
                        localStorageKey: '{{ $localStorageKey }}',
                        isLoading : false,
                        savingInProgress : false,
                        defaultImageThumbnail: '{{ url(env('DEFAULT_THUMBNAIL')) }}',
                        defaultImageDraw: '{{ url(env('DEFAULT_DRAW_IMAGE', '/')) }}',
                        notificationClass: 'message',
                        notificationMessage: '',
                        editor: ClassicEditor,
                        editorConfig: {
                            // The configuration of the editor.
                        },
                        lastFive: [],
                        lock: false,
                        tabIndex: 0,
                        highlighted : {
                            'background-color': 'blue',
                            color: 'white'
                        },
                        dimmed : {
                            'background-color': 'lightgrey',
                            color: 'grey'
                        },
                        actionState : '',

                        extraData: {!! json_encode($extra_query) !!},

                        defaultImageThumbnail : '{{ url(env('DEFAULT_THUMBNAIL')) }}',
                        defaultImageDraw: '{{ url(env('DEFAULT_DRAW_IMAGE', '/')) }}',

                        @if(isset($auxdata))
                            @foreach($auxdata as $k=>$v)
                                @if( is_array( $v ) )
                                    {{ $k }}: {!! json_encode($v) !!} ,
                                @else
                                    {{ $k }}: {!! $v !!},
                                @endif
                            @endforeach
                        @endif

                        dpFormat: '{{ env('DATE_FORMAT') }}',
                        tpHours: Array.from({ length: 10 }).map((_, i) => i + 8),

                        mapUrl: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
                        mapZoom: {{ config('geo.default_zoom') }},
                        mapCenter: {{ '{ lat:'.config('geo.origin_lat').', lng:'.config('geo.origin_lon').'}' }},
                        progressValue: 0,
                        progressMax: 0,
                        showProgress: false,
                        accFormat: {
                            symbol: '',
                            precision : 2,
                            thousand: '.',
                            decimal: ',',
                            format : {
                                pos : "%s %v",   // for positive values, eg. "$ 1.00" (required)
                                neg : "%s (%v)", // for negative values, eg. "$ (1.00)" [optional]
                                zero: "%s  -- "  // for zero values, eg. "$  --" [optional]
                            }
                        }
                    };
                },
                watch:{
                    @if( View::exists($page_watch_view) )
                        @include($page_watch_view)
                    @endif
                    tabIndex: function(val){
                        //for now the first tab contains form
                        if( !_.isEmpty(this.contentTabs) && !_.isEmpty( this.contentTabs[val])){

                        }
                        this.$emit('resize');
                        bus.$emit('refresh');
                        window.dispatchEvent(new Event('resize'));
                    },
                    autosave: function(val){
                        if(val){
                            console.log('autosave started');
                            intervalID = setInterval( function(){
                                uvm.doAutoSave();
                            }, {{ env('AUTOSAVE_MS') }});
                        }else{
                            console.log('autosave stopped');
                            clearInterval(intervalID);
                        }
                    },
                    handle: function(val){
                        bus.$emit('handle', val);
                    }
                },

                computed: {
                    @if( View::exists($page_computed_view) )
                        @include($page_computed_view)
                    @endif
                    // lockStyle: function(){
                    //     return this.lock?'background-color: red; color: white': 'background-color: transparent; color: grey; border: thin solid grey;';
                    // },
                    // lockIcon: function(){
                    //     return this.lock?'las la-lock': 'las la-unlock';
                    // }
                },
                methods:{
                    @if( View::exists($page_methods_view) )
                        @include($page_methods_view)
                    @endif
                    //UI

                    displayProgress(max){
                        console.log('max',max);
                        this.progressMax = max;
                        this.showProgress = true;
                    },
                    updateProgress(val){
                        console.log('prg',val);
                        this.progressValue = val;
                    },

                    hideProgress(){
                        this.progressMax = 0;
                        this.progressValue = 0;
                        this.showProgress = false;
                    },

                    formatUnixDate(dt){
                        return moment.unix(dt).format('{{ env('DATETIME_FORMAT') }}');
                    },

                    formatDate(dt){
                        return formatDate(dt);
                    },

                    formatCurrency(val, neg = false){
                        val = parseFloat(val);
                        if(neg){
                            val = -val ;
                        }
                        return accounting.formatMoney( val , this.accFormat);
                    },

                    slugToTitle(val){
                        var str = this[val];
                        if(_.isString(str) && str != '' ){
                            var words = str.split('-').join(' ');
                            return titleCase(words);
                        }else{
                            return str;
                        }
                    },
                    maxToday(date){
                        return maxToday(date);
                    },
                    maxTodayNotBefore(){
                        return maxTodayNotBefore(date);
                    },
                    startAutosave(){
                        if(this.autosave){
                            console.log('autosave started');
                            intervalID = setInterval( function(){
                                uvm.doAutoSave();
                            }, {{ env('AUTOSAVE_MS') }});
                        }else{
                            console.log('autosave stopped');
                            clearInterval(intervalID);
                        }
                    },

                    openBackupForm(){
                        this.$bvModal.show('getBackupModal');
                    },

                    doAutoSave(){
                        this.postAutosave();
                        this.postData();
                    },
                    doSave(){
                        //this.autosave = false;
                        //this.postData();
                        this.saveItem()
                    },
                    onTabChange(ev, payload){
                        @if( View::exists($js_tab_change) )
                            @include($js_tab_change)
                        @endif
                    },
                    onPopOpen(ev, payload){
                        @if( View::exists($js_pop_open) )
                            @include($js_pop_open)
                        @endif
                    },
                    //Data
                    setDataModel(data) {

                        @if( View::exists($js_load_transform) )
                        @include($js_load_transform)
                        @endif

                        _.forIn(data, (value, key) => {
                            console.log('inObj', key, value);
                            if(!(_.isNull(key) || _.isUndefined(key)) ){
                                this[key] = value;
                            }
                        });
                    },
                    setItemDataModel(data){

                        @if( View::exists($js_load_transform) )
                            @include($js_load_transform)
                        @endif

                        _.forIn(data, (value, key) => {
                            console.log('inObj', key, value);
                            if(!(_.isNull(key) || _.isUndefined(key)) ){
                                this[key] = value;
                            }
                        });
                    },
                    collectData(){
                        var model_set = {
                            ajax: true,
                            handle: this.handle,
                            tz: window.tz,
                            @if(strpos($yml_file, '_controller') === false)
                                {!! implode("\r\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toVueDataModel('objectfield') ) !!}
                            @else
                                {!! implode("\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataList('',':','this.',',', true) ) !!}
                            @endif
                        };
                        return model_set;
                    },
                    getParam(query) {
                        this.isLoading = true;
                        this.notificationMessage = 'Loading parameters';
                        this.notificationClass = 'message';
                        /**
                         * query string GET parameter dengan awalan "?" eg: "?pr=PR-0001&po=PO34545"
                         * yang dikomposisikan secara external di method caller
                         * @type {string|*}
                         */
                        this.loadSession = this.generateRandomString(5);

                        var tz = window.tz;

                        query = (_.isEmpty(query) || _.isNull(query) || _.isUndefined(query))? '?loadSession=' + this.loadSession + '&tz=' + tz : query + '&tz=' + tz + '&loadSession=' + this.loadSession;

                        var keywords = {
                            keyword0 : this.keyword0,
                            keyword1 : this.keyword1,
                            keyword2 : this.keyword2
                        };

                        axios.post(this.paramUrl + query , keywords )
                            .then((response) => {
                                var paramdata = response.data;
                                if( this.loadSession == paramdata.loadSession ){
                                    this.setDataModel(paramdata);
                                }
                                this.isLoading = false;
                                this.notificationMessage = 'Ready';
                                this.notificationClass = 'message';
                            })
                            .catch(function (error) {
                                console.log( 'error',error);
                                this.isLoading = false;
                                this.notificationMessage = 'Failed loading params';
                                this.notificationClass = 'error';
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }
                            });
                    },
                    getItemData(item_id){
                        this.itemId = item_id;

                        this.showProgress = true;
                        this.isLoading = true;
                        this.notificationMessage = 'Loading item data';
                        this.notificationClass = 'message';

                        var keywords = {
                            keyword0 : this.keyword0,
                            keyword1 : this.keyword1,
                            keyword2 : this.keyword2
                        };

                        axios.post( '{{ url($itemdataurl) }}/' + item_id ,
                                {
                                    extraData : this.extraData,
                                    keyword0 : this.keyword0,
                                    keyword1 : this.keyword1,
                                    keyword2 : this.keyword2
                                }
                            )
                            .then((response)=>{
                                this.isLoading = false;
                                this.showProgress = false;
                                this.setItemDataModel(response.data);
                                this.notificationMessage = 'Ready';
                                this.notificationClass = 'message';
                            })
                            .catch((error) => {
                                this.isLoading = false;
                                this.showProgress = false;
                                this.notificationMessage = 'Failed loading parameters';
                                this.notificationClass = 'error';
                                console.log(error);
                            })
                            .then(()=>{
                                this.isLoading = false;
                            });
                    },
                    clearForm(){
                        this.handle = '';
                        this.itemId = '';
                        {!! implode("\r\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataModel('clear') ) !!}

                    },
                    getHandle(){
                        return this.handle;
                    },
                    saveItem(event) {
                        @if(env('SKIP_VALIDATION', true ))
                            this.postData(event);
                        @else
                            uvm.$refs.page_veeObserver.validate()
                            .then((valid) => {
                                console.log('validation success',valid);
                                if(valid) {
                                    this.postData(event);
                                }
                            })
                            .catch((error) => {
                                console.log('validation error',error);
                                this.isLoading = false
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }
                            })
                        @endif
                    },
                    postData(){
                        var self = this;
                        var postData = this.collectData();

                        @if( View::exists($js_post_transform) )
                            @include($js_post_transform)
                        @endif

                        console.log(postData);

                        postData.itemId = this.itemId;
                        postData.handle = this.handle;
                        postData.formMode = this.formMode;
                        postData.timestamp = moment().unix();

                        // if(this.$localStorage){
                        //     this.$localStorage.set( 'UNSAVED_'+ this.localStorageKey , JSON.stringify(postData));
                        //
                        //     console.log('lastFive',this.lastFive);
                        //
                        //     if(this.lastFive.length > 5){
                        //         this.lastFive.pop();
                        //     }
                        //     this.lastFive.unshift(postData);
                        //
                        //     this.$localStorage.set( 'LAST_' + this.localStorageKey , JSON.stringify(this.lastFive));
                        // }

                        @if($mode == 'add')
                            var postUrl = '{{ url($addurl) }}';
                        @endif
                        @if($mode == 'edit')
                            var postUrl = '{{ url($updateurl) }}/'  + this.itemId;
                        @endif

                        this.savingInProgress = true;
                        this.actionState = '';

                        console.log('mode', '{{ $mode }}' );
                        console.log('post url', postUrl);

                        axios.post( postUrl , postData )
                            .then(response => {
                                console.log(response.data);
                                if(response.data.result == 'OK'){
                                    this.actionState = response.data.msg;
                                    @if($page_redirect_after_save)
                                        this.actionState = 'Redirecting back to previous page';
                                        window.location = '{{ url($page_save_redirect) }}';
                                    @else
                                        this.itemId = response.data.itemId;

                                        if(this.$localStorage){
                                            this.$localStorage.set( 'UNSAVED_'+ this.localStorageKey , false);
                                        }
                                        //alert( response.data.msg );
                                    @endif
                                }
                                this.savingInProgress = false;
                            })
                            .catch(function(error) {
                                this.savingInProgress = false;
                                console.log(error);
                            });
                    },
                    getSequence(){
                        var postData = {
                            bounds : {
                                @foreach($sequence_bounds as $bound)
                                    {{ $bound }} : this.{{ $bound.',' }}
                                    @endforeach
                            },
                            tz : tz
                        };
                        axios.post('{{ url($sequence_url) }}', postData)
                            .then(response => {
                                console.log(response.data);
                                if (response.data.result == 'OK') {
                                    var data = response.data.data;
                                    this.{{ $sequence_field ?? 'seq'}} = data.seq;
                                    this.{{ $numbering_field }} = '{{ $numbering_prefix }}' + data.padded;
                                }
                            })
                            .catch( (error) => {
                                console.log(error);
                            }).finally( () => {
                            this.isLoading = false;
                        });
                    },
                    busEmit(command,payload){
                        bus.$emit(command, payload );
                    },
                    formatCurrency(val, neg = false){
                        val = parseFloat(val);
                        if(neg){
                            val = -val ;
                        }
                        return accounting.formatMoney( val , this.accFormat);
                    },
                    generateRandomString(length=6){
                        return Math.random().toString(20).substr(2, length);
                    },
                    restoreBackup(ts){
                        var st = _.find(this.lastFive, { 'timestamp': ts });

                        this.$bvModal.hide('getBackupModal');

                        @if( View::exists($js_data_replay) )
                            @include($js_data_replay)
                        @endif
                    },
                    toSlug(val){
                        if(_.isString(val)){
                            return val.replace(/^\s+|\s+$|\s+(?=\s)/g, '').replace(/[^\w\s]/gi, '').split(' ').join('-').toLowerCase();
                        }else{
                            return val;
                        }
                    },
                    replayData(){

                        var st = false;
                        if(this.$localStorage) {
                            var last = this.$localStorage.get( 'UNSAVED_' + this.localStorageKey ,false);
                            st = JSON.parse(last);
                        }

                        if(st){
                            @if( View::exists($js_data_replay) )
                                @include($js_data_replay)
                            @endif
                        }else{
                            alert('All data has been saved.');
                        }

                    },
                    postAutosave(){
                        let self = this;
                        let postData = this.collectData();

                        @if( View::exists($js_post_transform) )
                            @include($js_post_transform)
                        @endif

                        console.log(postData);

                        if(this.itemId == ''){
                            this.formMode = 'create';
                        }

                        postData.itemId = this.itemId;
                        postData.handle = this.handle;
                        postData.formMode = this.formMode;

                        postData.timestamp = moment().unix();

                        if(this.$localStorage){
                            this.$localStorage.set( 'UNSAVED_'+ this.localStorageKey , JSON.stringify(postData));

                            console.log('lastFive',this.lastFive);

                            if(this.lastFive.length > 5){
                                this.lastFive.pop();
                            }
                            this.lastFive.unshift(postData);

                            this.$localStorage.set( 'LAST_' + this.localStorageKey , JSON.stringify(this.lastFive));
                        }



                        this.autosaving = true;

                        axios.post('{{ url($autosaveurl) }}' , postData )
                            .then( response => {
                                console.log(response.data);
                                if(response.data.result == 'OK'){
                                    this.itemId = response.data.itemId;
                                }
                                this.autosaving = false;
                                if(this.$localStorage){
                                    this.$localStorage.set( 'UNSAVED_'+ this.localStorageKey , false);
                                }

                            })
                            .catch( error => {
                                console.log(error);
                                this.autosaving = false;
                            });
                    },
                    @if( View::exists($edit_methods_view) )
                        @include($edit_methods_view)
                    @endif
                }
            }).$mount('#mainForm');

            function goToUrl(url) {
                window.location.href = url;
            }

            function showUploadModal(){
                $('#uploadModal').modal('show');
            }

            function showPopViewModal(){
                $('#popViewModal').modal('show');
            }

            function showDeleteModal(){
                $('#deleteModal').modal('show');
            }

            function hideDeleteModal() {
                $('#deleteModal').modal('hide');
                tvm.clearSelection();
                tvm.fetchData();
            }

            function formatDate(dt) {
                if( moment(dt).isValid()){
                    return moment(dt).locale('en').format('{{ env('DATE_FORMAT', 'L') }}');
                }else{
                    return dt;
                }
            }

            function formatTime(dt) {
                if( moment(dt).isValid()){
                    console.log('formatdate', dt);
                    return moment(dt).locale('en').format('HH:mm');
                }else{
                    return dt;
                }
            }

            function formatDateTime(dt){
                if( moment(dt).isValid()){
                    return moment(dt).locale('en').format('{{ env('DATETIME_FORMAT', 'DD MMM YYYY HH:mm:ss') }}');
                }else{
                    return dt;
                }
            }

            function formatDateTimeUTC(dt){
                if( moment(dt).isValid()){
                    return moment(dt).locale('en').format('{{ env('DATETIME_FORMAT', 'DD MMM YYYY HH:mm') }}');
                }else{
                    return dt;
                }
            }

            function titleCase(str){
                str = str.trim().toLowerCase().replace(/\w\S*/g, (w) => (w.replace(/^\w/, (c) => c.toUpperCase())));
                return str;
            }

            function formatMonth(dt) {
                if( moment(dt).isValid()){
                    return moment(dt).locale('en').format('{{ env('MONTH_FORMAT', 'MM-YYYY') }}');
                }else{
                    return dt;
                }
            }

            function maxToday(date){
                const today = new Date();
                return date >= today;
            }

            function maxTodayNotBefore(date){
                const today = new Date();
                const before = new Date(this.DocDate);
                return before > date || date > today;
            }

        });


    </script>

@endsection

@section('content')
    <div id="mainForm" class="h-100" >
        <b-overlay :show="isLoading" variant="white" opacity="0.85" class="h-100"  >
            <template #overlay>
                <div
                    style="display: flex;justify-content: center;align-content: flex-start;height: 50%;padding: 16px;"
                >
                    <semipolar-spinner
                        :animation-duration="2000"
                        :size="75"
                        color="#33ccff"
                    />
                </div>
            </template>


            <div class="card h-100">
                <div class="card-header">
                    <div class="d-none d-md-inline-block"
                         style="width: fit-content;display: inline-block;">
                        @if( View::exists($page_additional_view) )
                            @include($page_additional_view)
                        @endif
                    </div>
                     @if($can_save )
                        @if( $non_closing_save )
                            <button class="btn btn-primary" pill @click="doSave('RESET')">
                                {{__('Save & New')}}
                            </button>
                        @endif
                        <button
                            style="float:right;"
                            @if($can_lock)
                                v-if="!lock"
                            @endif
                            @click="doSave" class="btn btn-primary">
                            <i v-if="!savingInProgress" class="las la-save"></i>
                            <b-spinner v-if="savingInProgress"  small ></b-spinner > Save
                        </button>
                        <a
                            href="{!! url($page_cancel_redirect) !!}"
                            style="float:right;"
                            class="btn mr-3"
                            v-html="lock ? 'Back': 'Cancel' "
                        > Cancel
                        </a>
                    @endif
                    <div v-if="actionState != ''" style="display: inline-block;float: right;padding: 6px 8px;background-color: aqua;border-radius: 6px;" v-html="actionState"></div>
                </div>
                <div class="card-body" >
                    <div class="d-md-none d-sm-block d-xs-block">
                        @if( View::exists($page_additional_view) )
                            @include($page_additional_view)
                        @endif
                    </div>
                    @if(env('SKIP_VALIDATION', true ))
                        <?php
                            if(strpos($yml_file,'_controller') === false){
                                $form_fields = \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toFormWithKey('name', $is_create);
                                $form_fields['_isCreate'] = $is_create;
                                $form_page = \App\Helpers\Util::formWithBladeLayout($form_layout,$form_fields, $is_create) ;
                            }else{
                                $form_fields = \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toFormElementWithKey('name', $is_create);
                                $form_page = \App\Helpers\Util::formElementWithBladeLayout($form_layout,$form_fields, $is_create) ;
                            }
                            print $form_page;
                        ?>
                    @else
                        <validation-observer v-slot="{ invalid }" ref="page_veeObserver">
                            <?php
                                if(strpos($yml_file,'_controller') === false){
                                    $form_fields = \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toFormWithKey('name', $is_create);
                                    $form_fields['_isCreate'] = $is_create;
                                    $form_page = \App\Helpers\Util::formWithBladeLayout($form_layout,$form_fields, $is_create) ;
                                }else{
                                    $form_fields = \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toFormElementWithKey('name', $is_create);
                                    $form_page = \App\Helpers\Util::formElementWithBladeLayout($form_layout,$form_fields, $is_create) ;
                                }
                                print $form_page;
                            ?>
                        </validation-observer>
                    @endif
                </div>
                <div class="card-footer">
                    <span :class="notificationClass"
                          v-html="notificationMessage" >
                    </span>
    {{--                <b-spinner  v-show="isLoading" label="Loading..."></b-spinner>--}}
                </div>
            </div>
        </b-overlay>


        @if( View::exists($page_modal_view) )
            @include($page_modal_view)
        @endif
    </div>

    <div id="lightBoxContainer">
        <vue-easy-lightbox
                :visible="lightBoxVisible"
                :imgs="galleryUrls"
                :index="lightBoxindex"
                @hide="lightBoxHandleHide"
        ></vue-easy-lightbox>
    </div>

@endsection
