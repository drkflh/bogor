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

    </style>

    <link href="{{ url( env('APP_CSS', 'css/framework.css') ) }}" rel="stylesheet">

    <script>
        $(document).ready(function(){

            var intervalID = null;
            initTab();

            var lightboxvm = new Vue({
                mounted(){
                    bus.$on('openlightbox', (data) => {
                        console.log(data);
                        this.galleryUrls = data.gallery;
                        this.showLightBox(data.index);
                        //this.onPopOpen(data);
                    });
                },
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
                    lightBoxHandleHide(){
                        this.lightBoxVisible = false;
                        this.lightBoxindex = 0;
                        this.galleryUrls = [];
                    }
                }
            }).$mount('#lightBoxContainer');


            var popvm = new Vue({
                mounted(){
                    bus.$on('openpopwindow', (data) => {
                        this.onPopOpen(data);
                    });
                },
                data: function(){
                    return {
                        label: 'Pop Modal',
                        content: [],
                        template: {!! $auxdata['popviewContentTemplate'] ?? "''" !!}
                    };
                },
                methods:{
                    onPopOpen(data){
                        var ct = data.content.content.popitem;
                        console.log(ct, data.key);
                        this.label = this.properCase( this.splitCamel( data.key ) ) ;
                        var ctx = _.get(ct, data.key);
                        this.content = ctx;
                        this.$refs['pop-modal'].openModal();
                        //showPopViewModal();
                    },
                    splitCamel(str){

                        str = str.replace(/([a-z\xE0-\xFF])([A-Z\xC0\xDF])/g, "$1 $2");
                        str = str.toLowerCase(); //add space between camelCase text
                        return str;
                    },
                    lowerCase(str) {
                        return str.toLowerCase();
                    },
                    upperCase(str) {
                        return str.toUpperCase();
                    },
                    properCase(str) {
                        return this.lowerCase(str).replace(/^\w|\s\w/g, this.upperCase);
                    },
                }
            }).$mount('#popViewContainer');

            var uvm = new Vue({
                mounted(){
                    this.getItemData(this.itemId);

                    bus.$on('opendraw', (ev, data) => {
                        this.openDrawingBoard();
                    });

                    bus.$on('popopen', (ev, data) => {
                        this.onPopOpen(ev, data);
                    });

                    initTab();
                    window.dispatchEvent(new Event('resize'));

                    this.startAutosave();

                    if(this.$localStorage){
                        var last = this.$localStorage.get( 'LAST_' + this.localStorageKey ,[]);

                        if(!_.isEmpty(last)){
                            this.lastFive = JSON.parse(last);
                        }else{
                            this.lastFive = [];
                        }

                    }

                },
                data: function(){
                    return {
                        {!! implode("\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataModel('default') ) !!}
                        title:'Update',
                        itemId : '{{ $id }}',
                        formMode : '',
                        handle: '',
                        autosave: {{ env('AUTOSAVE_ON')?'true':'false' }},
                        autosaving: false,
                        localStorageKey: '{{ $localStorageKey }}',

                        isLoading : false,

                        lastFive: [],
                        lock: false,

                        docbase: '{{ env('KMN_PIC_BASE')  }}',
                        docthumb: '{{ url(env('ICON_PDF')) }}',
                        drawbase: '{{ env('KMN_DRAW_BASE')  }}',

                        tabIndex: 0,

                        highlighted : {
                            'background-color': 'blue',
                            color: 'white'
                        },
                        dimmed : {
                            'background-color': 'lightgrey',
                            color: 'grey'
                        },


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
                        showProgress: false
                    };
                },
                watch:{
                    @if( View::exists($page_watch_view) )
                        @include($page_watch_view)
                    @endif
                    tabIndex: function(val){
                        //for now the first tab contains form
                        if( !_.isEmpty(this.contentTabs) && !_.isEmpty( this.contentTabs[val])){
                            this.currentTabContent = this.contentTabs[val];
                            this.lock = this.currentTabContent.content.lock;
                            rsbvm.setHandle(this.currentTabContent.key);

                            var infobar = {
                                info: this.currentTabContent.content.pasien,
                                alergi: this.currentTabContent.content.popitem.alergi,
                                kondisikhusus: this.currentTabContent.content.popitem.kondisikhusus,
                            };

                            infobarvm.setContent(infobar);

                            bus.$emit('setbadge', this.currentTabContent.content.popitem);

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
                    lockStyle: function(){
                        return this.lock?'background-color: red; color: white': 'background-color: transparent; color: grey; border: thin solid grey;';
                    },
                    lockIcon: function(){
                        return this.lock?'las la-lock': 'las la-unlock';
                    }
                },
                methods:{
                    @if( View::exists($page_methods_view) )
                        @include($page_methods_view)
                    @endif
                    //UI
                    scrollLeft() {
                        var content = document.querySelector(".nav-pills");
                        content.scrollLeft -= 50;
                    },
                    scrollRight() {
                        var content = document.querySelector(".nav-pills");
                        content.scrollLeft += 50;
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
                        this.postData();
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
                    setItemDataModel(data){
                        {!! implode("\r\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataModel('load') ) !!}

                        @if( View::exists($js_load_transform) )
                            @include($js_load_transform)
                        @endif

                        this.selectOptions = data.selOptions;
                    },
                    collectData(){
                        var model_set = {
                            ajax: true,
                            handle: this.handle,
                            {!! implode("\r\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataModel('objectfield') ) !!}
                        };
                        return model_set;
                    },
                    getItemData(item_id){
                        this.itemId = item_id;

                        this.showProgress = true;

                        axios.get('{{ url($itemdataurl) }}/' + item_id)
                            .then((response)=>{
                                this.showProgress = false;
                                this.setItemDataModel(response.data);
                            })
                            .catch(function(error) {
                                this.showProgress = false;
                                console.log(error);
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

                        if(this.$localStorage){
                            this.$localStorage.set( 'UNSAVED_'+ this.localStorageKey , JSON.stringify(postData));

                            console.log('lastFive',this.lastFive);

                            if(this.lastFive.length > 5){
                                this.lastFive.pop();
                            }
                            this.lastFive.unshift(postData);

                            this.$localStorage.set( 'LAST_' + this.localStorageKey , JSON.stringify(this.lastFive));
                        }


                        var postUrl = '{{ url($updateurl) }}/'  + this.itemId;

                        if( this.itemId == ''){
                            postUrl = '{{ url($addurl) }}';
                        }

                        this.savingInProgress = true;

                        axios.post( postUrl , postData )
                            .then(response => {
                                console.log(response.data);
                                if(response.data.result == 'OK'){
                                    @if($page_save_redirect != '')
                                        window.location = '{{ url($page_save_redirect) }}';
                                    @endif

                                    //alert( response.data.msg );
                                    this.itemId = response.data.itemId;

                                    if(this.$localStorage){
                                        this.$localStorage.set( 'UNSAVED_'+ this.localStorageKey , false);
                                    }

                                }

                                this.savingInProgress = false;

                            })
                            .catch(function(error) {
                                this.savingInProgress = false;
                                console.log(error);
                            });
                    },
                    restoreBackup(ts){
                        var st = _.find(this.lastFive, { 'timestamp': ts });

                        this.$bvModal.hide('getBackupModal');

                        @if( View::exists($js_data_replay) )
                            @include($js_data_replay)
                        @endif
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
                    openDrawingBoard(){
                        console.log('opendraw');
                        showDrawModal();
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

            $('#confirmDelete').on('click',function(){
                tvm.confirmDelete();
            });

            $('#deleteModal').on('hidden.bs.modal', function(e){
                tvm.clearSelection();
            });

            function formatDate(dt){
                return moment(dt).locale('id').format('L');
            }

            function showDrawModal(){
                $('#drawModal').modal('show');
            }

            function initTab(){
                // $('.nav-tabs').scrollingTabs({
                //     bootstrapVersion: 4
                // });
            }

            function refreshTab(){
                // $('.nav-tabs').scrollingTabs('refresh');
            }

        });


    </script>
@endsection

@section('content')
    <style>

        .tab-panel {
            flex-wrap: nowrap;
        }

        .wrap {
            overflow: hidden;
            width: 100%;
            flex-direction: row;
        }

        .nav-tabs, .nav-pills {
            flex-wrap: nowrap;
            white-space: nowrap;
            max-width: 100%;
            overflow-x: auto;
        }

        .v-center {
            margin: 0;
            position: relative;
            top: 50%;
            -ms-transform: translate(0%, -50%);
            transform: translate(0%, -50%);
        }

    </style>
    <div id="mainForm"
        @opendraw="openDrawingBoard"
    >
        <div class="row mb-10">
                <div class="col-lg-7 col-md-7 col-sm-12" style="display: block;position: relative;">
                    @if($has_tab)
                        <button @click="scrollLeft" class="btn btn-secondary pull-left v-center"><i class="las la-arrow-alt-circle-left"></i> </button>
                        <button @click="scrollRight" class="btn btn-secondary pull-left v-center" style="margin-right: 25px;"><i class="las la-arrow-alt-circle-right"></i> </button>
                    @endif
                    @if($show_title == true)
                        <h3 class="pull-left align-baseline v-center">
                            <a href="{{ url('clinic/patient') }}">
                                Patient List
                            </a> &raquo;
                            {{ $title }}
                            <b-spinner v-if="showProgress" variant="primary"  label="Spinning" class="ml-20" ></b-spinner>

                        </h3>
                    @endif
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12" style="display: block;position: relative;display: table-cell">
                    @if($can_save )
                    <button v-if="!lock" @click="doSave" class="btn btn-primary pull-right v-center">
                        <i v-if="!savingInProgress" class="las la-save"></i>
                        <b-spinner v-if="savingInProgress"  small ></b-spinner > Save</button>
                    @endif
                    @if($can_autosave)
                        <button v-bind:class="['btn', 'pull-right v-center', 'mr-20']" v-bind:style="lockStyle" ><i v-bind:class="lockIcon"></i></button>
                    @endif
                    @if($can_autosave)
                        <button v-if="!lock" @click="openBackupForm" class="btn btn-secondary pull-right mr-30">
                            <i class="las la-refresh"></i> Restore Backup
                        </button>
                        {{--<b-form-checkbox v-if="!lock" switch size="lg" v-model="autosave" class="pull-right v-center mr-30" >--}}
                            {{--<span class="v-center" style="font-size: 11pt;">Auto Save</span>--}}
                        {{--</b-form-checkbox>--}}
                        <span v-if="!autosaving" class="v-center pull-right mr-15" style="font-size: 11pt;">Autosaving @{{ autosave?'ON':'OFF' }}</span>
                        <span v-if="autosaving" class="v-center pull-right mr-15" style="font-size: 11pt;">Autosaving...</span>

                            <b-modal id="getBackupModal"
                                     size="md" title="Available Backup"
                                     modal-class="modal-bv"
                                     scrollable
                                     no-close-on-backdrop
                                     no-close-on-esc
                                     ok-only
                                     ok-title="Dismiss"
                                     @ok="this.$bvModal.hide('getBackupModal')"

                            >
                                <div class="row" >
                                    <div class="col-12">
                                        <template v-if="_.isEmpty(lastFive)">
                                            <p class="text-center">No local backup available</p>
                                        </template>
                                        <table v-else class="table">
                                            <tr v-for="bk in lastFive">
                                                <td>
                                                   @{{ formatUnixDate(  _.get(bk, 'timestamp') ) }}
                                                </td>
                                                <td style="width: 100px;">
                                                    <button class="btn btn-primary" @click="restoreBackup(_.get(bk, 'timestamp'))">
                                                        Restore
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </b-modal>


                    @endif
                    {{--<span v-if="autosave" class="pull-right v-center align-baseline" style="margin-top: 16px;margin-right: 40px;"><b>ID : </b>--}}
                        {{--@{{ itemId }}--}}
                    {{--</span>--}}
                </div>
        </div>
        {{--<div class="row" style="display: block;padding-left: 15px;">--}}
            {{--<b-progress height="10px" class="align-baseline v-center" v-if="showProgress" :value="progressValue" :max="progressMax" show-progress animated></b-progress>--}}
        {{--</div>--}}

        {{--if form has tab --}}
        @if(!$has_tab)

            <?php

                $form_fields = \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toFormWithKey('name', $is_create);

                $form_fields['_isCreate'] = $is_create;

                $form_page = \App\Helpers\Util::formWithBladeLayout($form_layout,$form_fields, $is_create, $auxdata, $id) ;

                print $form_page;

            ?>
        @endif
        {{--if form has tab --}}
        @if($has_tab)
        <b-tabs pills content-class="mt-6"  @change="onTabChange" v-model="tabIndex" >
            {{--</b-tab>--}}
            <b-tab v-for="ctab in contentTabs" :key="ctab.key" :title="ctab.title">

                <div  v-if="!ctab.content.lock" >

                    <?php

                    $form_fields = \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toFormWithKey('name', $is_create);
                    $form_fields['_isCreate'] = $is_create;
                    $form_page = \App\Helpers\Util::formWithBladeLayout($form_layout,$form_fields, $is_create) ;
                    print $form_page;
                    ?>

                </div>

                <div  v-if="ctab.content.lock">
                    <active-view class="mt-30"
                                 :content="ctab.content"
                                 :template="tabViewTemplate"
                                 :params="{ winHeight: windowObject.innerHeight - 50 }"
                    >
                    </active-view>
                </div>
            </b-tab>
        </b-tabs>
        @endif

    </div>

    <div id="popViewContainer">
        <pop-view-modal
            ref="pop-modal"
            :label="label"
            :content="content"
            :template="template"
        >
        </pop-view-modal>
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
