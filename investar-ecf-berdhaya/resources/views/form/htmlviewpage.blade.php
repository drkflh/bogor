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
                    showAuthModal() {
                        this.$bvModal.show('authLoginModal');
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
                        formMode : '{{ $mode }}',
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

                        stepProgress : {!! json_encode($step_progress) !!},

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
                    },
                    /**
                     * Approval system related
                     */
                    requestBy : function(val){
                        this.setApprovers();
                    },
                    auditedBy : function(val){
                        this.setApprovers();
                    },
                    recomendedBy : function(val){
                        this.setApprovers();
                    },
                    authorizedBy : function(val){
                        this.setApprovers();
                    },
                    reviewedBy1 : function(val){
                        this.setApprovers();
                    },
                    reviewedBy2 : function(val){
                        this.setApprovers();
                    }
                },

                computed: {
                    @if( View::exists($page_computed_view) )
                        @include($page_computed_view)
                    @endif
                },
                methods:{
                    @if( View::exists($page_methods_view) )
                        @include($page_methods_view)
                    @endif
                    //UI
                    showAuthModal() {
                        this.$bvModal.show('authLoginModal');
                    },

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
                        return moment(dt).format('{{ env('DATE_FORMAT', 'DD MMM YYYY') }}');
                    },
                    formatDateByField(dtf){
                        let dt = _.get( this, dtf );
                        console.log('dtf', dt);
                        return moment(dt).format('{{ env('DATE_FORMAT', 'DD MMM YYYY') }}');
                    },

                    formatDateTime(dt){
                        return moment(dt).format('{{ env('DATETIME_FORMAT', 'L') }}');
                    },
                    formatDateTimeByField(dtf){
                        let dt = _.get( this, dtf );
                        return moment(dt).format('{{ env('DATETIME_FORMAT', 'L') }}');
                    },

                    formatMonth(dt) {
                        if( moment(dt).isValid()){
                            return moment(dt).locale('en').format('{{ env('MONTH_FORMAT', 'MMM') }}');
                        }else{
                            return dt;
                        }
                    },
                    formatMonthByField(dtf) {
                        let dt = _.get( this, dtf );
                        if( moment(dt).isValid()){
                            return moment(dt).locale('en').format('{{ env('MONTH_FORMAT', 'MMM') }}');
                        }else{
                            return dt;
                        }
                    },

                    formatTime(dt) {
                        if( moment(dt).isValid()){
                            return moment(dt).locale('en').format('{{ env('TIME_FORMAT', 'HH:ss') }}');
                        }else{
                            return dt;
                        }
                    },
                    formatTimeByField(dtf) {
                        let dt = _.get( this, dtf );
                        if( moment(dt).isValid()){
                            return moment(dt).locale('en').format('{{ env('TIME_FORMAT', 'HH:ss') }}');
                        }else{
                            return dt;
                        }
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
                    doSave(event){
                        this.saveItem(event)
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
                                this.notificationMessage = '';
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
                                    mode: '{{ $mode }}',
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
                                this.notificationMessage = '';
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
                    showToast(message, title = '{{ env('APP_NAME') }}'){
                        this.$bvToast.toast(message, {
                            title: title,
                            autoHideDelay: 5000,
                            appendToast: true
                        });
                    },
                    clearForm(){
                        @if(strpos($yml_file, '_controller') === false)
                            {!! implode("\r\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toVueDataModel('clear') ) !!}
                        @else
                            {!! implode("\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataList('this.','=','',';') ) !!}
                        @endif
                        this.handle = '';
                        this.itemId = '';
                        console.log("update form cleared");
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
                    postData(act){
                        var self = this;
                        var postData = this.collectData();

                        @if( View::exists($js_post_transform) )
                            @include($js_post_transform)
                        @endif

                        console.log(postData);

                        postData.mode = '{{ $mode }}';

                        postData.itemId = this.itemId;
                        postData.handle = this.handle;
                        postData.formMode = this.formMode;
                        postData.timestamp = moment().unix();

                        @if($mode == 'add' || $mode == 'revise')
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
                                    //this.actionState = response.data.msg;


                                    if(act == 'RESET'){
                                        //alert('Data updated successfully.');
                                        this.showToast(response.data.msg);
                                        this.clearForm();
                                    }else{
                                        @if($page_redirect_after_save)
                                            //this.actionState = 'Redirecting back to previous page';
                                            @if($save_then_edit)
                                                this.itemId = response.data.itemId;
                                                this.showToast( '{{ __('Save success, Redirecting back to previous page') }}');
                                                window.location = '{{ url($page_save_redirect) }}/' + this.itemId + '/' + this.keyword0 + '/' + this.keyword1 + '/' + this.keyword2 ;
                                            @else
                                                this.showToast( '{{ __('Save success, Redirecting back to previous page') }}');
                                                window.location = '{{ url($page_save_redirect) }}';
                                            @endif
                                        @else
                                            this.showToast( '{{ __('Save success') }}');
                                            this.itemId = response.data.itemId;
                                        @endif
                                    }

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
                    startTimerNoSave(){
                        /**
                         * auxiliary function for periodic update on add form
                         * */
                        if (typeof this.periodicMethod == 'function') {
                            console.log('start periodic');
                            this.timer = setInterval( () => {
                                this.periodicMethod();
                            }, {{ $add_form_interval ?? 5000 }} );
                        }
                    },
                    stopTimerNoSave(){
                        clearInterval(this.timer);
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

                        // if(this.itemId == ''){
                        //     this.formMode = 'add';
                        // }

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
                    setApprovers(){
                        this.requestByObj = _.get( this.requestByObjMap , this.requestBy );
                        this.recomendedByObj = _.get( this.recomendedByObjMap , this.recomendedBy );
                        this.auditedByObj = _.get(this.auditedByObjMap, this.auditedBy );
                        this.authorizedByObj = _.get(this.authorizedByObjMap, this.authorizedBy );
                        this.reviewedBy1Obj = _.get(this.reviewedBy1ObjMap, this.reviewedBy1 );
                        this.reviewedBy2Obj = _.get(this.reviewedBy2ObjMap, this.reviewedBy2 );
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

            function titleCase(str){
                str = str.trim().toLowerCase().replace(/\w\S*/g, (w) => (w.replace(/^\w/, (c) => c.toUpperCase())));
                return str;
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
        @if( View::exists($page_modal_view) )
            @include($page_modal_view)
        @endif

        <b-modal id="authLoginModal"
                 no-close-on-backdrop
                 no-close-on-esc
                 @ok="close()"
                 size="md"
                 centered
                 scrollable
                 ok-title="Close"
                 :ok-only="true"
                 modal-class="modal-bv">
            <template v-slot:modal-header="{ close }">
                <span class="modal-title" >
                    <h4 style="margin-bottom: 0px;"  >{{ __('Authentication') }}</h4>
                </span>
                <b-button size="sm" variant="outline-secondary" pill @click="close()">
                    <b-spinner small v-show="isLoading" label="Loading..."></b-spinner>
                    <i v-show="!isLoading" class="las la-times"></i>
                </b-button>
            </template>
            <div class="row">
                <div class="col-12 text-center">
                    <p><b>This function needs authentication</b></p>
                    <p>Please <a href="{{ url('login') }}">Login</a></p>
                    <p>or</p>
                    <p><a href="{{ url('register') }}">Register</a> here.</p>
                </div>
            </div>
        </b-modal>

        <b-overlay :show="isLoading" variant="white" opacity="0.85" class="h-100"  >
            <template #overlay>
                <div
                    style="display: flex;justify-content: center;align-content: flex-start;height: 50%;padding: 16px;"
                >
                    <div class="vertical-centered-box">
                        <div class="content">
                            <div class="loader-circle"></div>
                            <div class="loader-line-mask one">
                                <div class="loader-line"></div>
                            </div>
                            <div class="loader-line-mask two">
                                <div class="loader-line"></div>
                            </div>
                            <div class="loader-line-mask three">
                                <div class="loader-line"></div>
                            </div>
                            <div class="loader-line-mask four">
                                <div class="loader-line"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>


            <div class="card h-100 {{ $page_class }} " style="margin: auto;">

                <div class="card-body">
                    <div class="d-md-none d-sm-block d-xs-block">
                        @if( View::exists($page_additional_view) )
                            @include($page_additional_view)
                        @endif
                    </div>

                    @if($mode == 'view')
                        <?php
                            //print $view_layout;
                            $form_fields['_isCreate'] = $is_create;

                            if(strpos($yml_file,'_controller') === false){
                                $form_fields = \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toViewWithKey('name', $is_create);
                                $form_page = \App\Helpers\Util::formWithBladeLayout($view_layout,$form_fields, $is_create) ;
                            }else{
                                $form_fields = \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toViewElementWithKey('name', $is_create);
                                $form_page = \App\Helpers\Util::formElementWithBladeLayout($view_layout,$form_fields, $is_create);
                            }

                            print $form_page;

                        ?>
                    @endif
                </div>

{{--                <div class="card-footer d-flex justify-content-between">--}}
{{--                    <span :class="notificationClass"--}}
{{--                          v-html="notificationMessage" >--}}
{{--                    </span>--}}
{{--                </div>--}}

            </div>
        </b-overlay>

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
