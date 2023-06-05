@extends($layout??'layouts.dashforge')

@section('js')

    <script>
    $(document).ready(function(){

        $( "form" ).submit(function( event ) {
            event.preventDefault();
        });

        var avm = new Vue({
            mounted(){
                window.dispatchEvent(new Event('resize'));
            },
            data: function(){
                return {
                    title:'Create',
                    {!! implode("\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataModel('default') ) !!}
                    handle: '',
                    autosave: false,
                    defaultImageThumbnail : '{{ url(env('DEFAULT_THUMBNAIL', '/')) }}',
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

                    dpFormat: 'DD/MM/YYYY',
                    tpHours: Array.from({ length: 10 }).map((_, i) => i + 8),

                    mapUrl: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
                    mapZoom: {{ config('geo.default_zoom') }},
                    mapCenter: [ {{ config('geo.origin_lat').','.config('geo.origin_lon') }} ],
                };
            },
            methods:{

                setDataModel(data){

                    @if( View::exists($js_load_transform) )
                        @include($js_load_transform)
                    @endif

                    _.forIn(data, (value, key) => {
                        this[key] = value;
                    });
                },
                collectData(){
                    var model_set = {
                        ajax: true,
                        handle: this.handle,
                        {!! implode("\r\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toVueDataModel('objectfield') ) !!}
                    };
                    return model_set;
                },
                getParam(){
                    axios.get('{{ url($paramurl) }}')
                        .then((response)=>{
                            var paramdata = response.data;
                            this.setDataModel(paramdata);
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                clearForm(){
                    this.handle = '';
                    {!! implode("\r\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toVueDataModel('clear') ) !!}

                    console.log("add form cleared");

                },
                addItem(){
                    this.postData();
                },
                postData(){
                    let self = this;
                    let postData = this.collectData();

                    @if( View::exists($js_post_transform) )
                        @include($js_post_transform)
                    @endif

                    console.log(postData);

                    axios.post('{{ url($addurl) }}', postData )
                        .then( response => {
                            console.log(response.data);
                            if(response.data.result == 'OK'){
                                //hideAddModal();
                                this.hideModal();
                                tvm.fetchData();
                                //tvm.$emit('refresh-data');
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                openModal(){
                    this.$bvModal.show('addItemModal');
                },
                hideModal(){
                    this.$bvModal.hide('addItemModal');
                },
                openSubModal(){
                    showSubModal();
                },
                {{ $template_var['avm_methods']??'' }}
            }
        }).$mount('#addModal');

        var uvm = new Vue({
            mounted(){
                window.dispatchEvent(new Event('resize'));
            },
            data: function(){
                return {
                    {!! implode("\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataModel('default') ) !!}
                    title:'Update',
                    itemId : '',
                    handle: '',
                    autosave: false,
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

                    dpFormat: 'DD/MM/YYYY',
                    tpHours: Array.from({ length: 10 }).map((_, i) => i + 8),

                    mapUrl: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
                    mapZoom: {{ config('geo.default_zoom') }},
                    mapCenter: {{ '{ lat:'.config('geo.origin_lat').', lng:'.config('geo.origin_lon').'}' }},

                };
            },
            methods:{

                setItemDataModel(data){

                    @if( View::exists($js_load_transform) )
                        @include($js_load_transform)
                    @endif

                    _.forIn(data, (value, key) => {
                        console.log(key, value);
                        this[key] = value;
                    });
                },
                collectData(){
                    var model_set = {
                        ajax: true,
                        handle: this.handle,
                        {!! implode("\r\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toVueDataModel('objectfield') ) !!}
                    };
                    return model_set;
                },
                getItemData(item_id){
                    this.itemId = item_id;
                    axios.get('{{ url($itemdataurl) }}/' + item_id)
                        .then((response)=>{
                            this.setItemDataModel(response.data);
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                clearForm(){
                    {!! implode("\r\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toVueDataModel('clear') ) !!}
                    this.handle = '';
                    this.itemId = '';
                    console.log("update form cleared");
                },
                updateItem(){
                    this.postData();
                },
                postData(){
                    let self = this;
                    let postData = this.collectData();

                    @if( View::exists($js_post_transform) )
                        @include($js_post_transform)
                    @endif

                    console.log(postData);

                    axios.post('{{ url($updateurl) }}/'  + this.itemId , postData )
                        .then(response => {
                            console.log(response.data);
                            if(response.data.result == 'OK'){
                                //hideUpdateModal();
                                this.hideModal();
                                tvm.fetchData();
                                //tvm.$emit('refresh-data');
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                openModal(){
                    this.$bvModal.show('updateItemModal');
                },
                hideModal(){
                    this.$bvModal.hide('updateItemModal');
                },

                {{ $template_var['uvm_methods']??'' }}
            }
        }).$mount('#updateModal');

        var vvm = new Vue({
            mounted(){
                window.dispatchEvent(new Event('resize'));
            },
            data: function(){
                return {
                    {!! implode("\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataModel('default') ) !!}
                    title:'View',
                    itemId : '',
                    handle: '',
                    autosave: false,
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

                    dpFormat: 'DD/MM/YYYY',
                    tpHours: Array.from({ length: 10 }).map((_, i) => i + 8),

                    mapUrl: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
                    mapZoom: {{ config('geo.default_zoom') }},
                    mapCenter: {{ '{ lat:'.config('geo.origin_lat').', lng:'.config('geo.origin_lon').'}' }},

                };
            },
            methods:{
                setTitle(title){
                    this.title = title;
                },
                setItemDataModel(data){

                    @if( View::exists($js_load_transform) )
                        @include($js_load_transform)
                    @endif

                    _.forIn(data, (value, key) => {
                        console.log(key, value);
                        this[key] = value;
                    });
                },
                getItemData(item_id){
                    this.itemId = item_id;
                    axios.get('{{ url($itemdataurl) }}/' + item_id)
                        .then((response)=>{
                            this.setItemDataModel(response.data);
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                clearForm(){
                    {!! implode("\r\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toVueDataModel('clear') ) !!}
                    this.handle = '';
                    this.itemId = '';
                    console.log("update form cleared");
                },
                openModal(){
                    this.$bvModal.show('viewItemModal');
                },
                hideModal(){
                    this.$bvModal.hide('viewItemModal');
                },

                {{ $template_var['uvm_methods']??'' }}
            }
        }).$mount('#viewModal');

        var imvm = new Vue({
            mounted(){

            },
            data: function(){
                return {
                    title : 'Import',
                    importId : '',
                    sourceUrl : '{!! url($import_src_url) !!}',
                    previewColumns : {!! json_encode($import_preview_cols) !!} ,
                    previewHeadings : {!! json_encode($import_preview_heads) !!} ,
                    uploadUrl : '{!! url($import_upload_url) !!}',
                    commitUrl : '{!! url($import_commit_url) !!}'
                };
            },
            methods:{
                setImportId(id){
                    this.importId = id;
                },
                commitData(){
                    var url = this.commitUrl + '?importid=' + this.importId;
                    return axios.post(url, {
                        params: {}
                    }).then( response => {
                        if(response.data.result == 'OK'){
                            hideUploadModal();
                        }
                    }).catch(function (e) {
                        this.dispatch('error', e);
                    });
                },
                openModal(){
                    this.$bvModal.show('uploadItemModal');
                },
                hideModal(){
                    this.$bvModal.hide('uploadItemModal');
                },

            }
        }).$mount('#uploadModal');

        var tvm = new Vue({
            mounted(){
                this.fetchData();
                window.dispatchEvent(new Event('resize'));
            },
            data: function() {
                return {
                    showProgress: false,
                    selectedRows:[],
                    rows: [],
                    columns: {!! \App\Helpers\Util::loadResYaml( $yml_file,$res_path )->toColFields() !!},
                    actions: [
                        @if($can_add)
                        {
                            btn_text: '<i class="fa fa-plus"></i> Add {{ Str::singular($title) }}',
                            event_name: "on-add",
                            class: "btn btn-primary my-custom-class",
                            event_payload: {
                                row: false
                            }
                        },
                        @endif

                        @if($can_upload)
                        {
                            btn_text: '<i class="fa fa-upload"></i> Upload',
                            event_name: "on-upload",
                            class: "btn btn-secondary my-custom-class",
                            event_payload: {
                                filetype: "xls"
                            }
                        },
                        @endif

                        @if($can_download_xls)
                        {
                            btn_text: '<i class="fa fa-download"></i> Download XLS',
                            event_name: "on-download",
                            class: "btn btn-secondary my-custom-class",
                            event_payload: {
                                filetype: "xls"
                            }
                        },
                        @endif

                        @if($can_download_csv)
                        {
                            btn_text: '<i class="fa fa-download"></i> Download CSV',
                            event_name: "on-download",
                            class: "btn btn-secondary my-custom-class",
                            event_payload: {
                                filetype: "csv"
                            }
                        },
                        @endif

                        @if($can_multi_delete)
                        {
                            btn_text: '<i class="fa fa-trash"></i> Multi Delete',
                            event_name: "on-delete",
                            class: "btn btn-danger my-custom-class",
                            event_payload: {
                                row: false
                            }
                        },
                        @endif
                    ],
                    config: {
                        server_mode: true,
                    @if($can_multi_select)
                        checkbox_rows: true,
                    @else
                        checkbox_rows: false,
                    @endif
                        rows_selectable: false,
                        card_mode: false,
                        card_title: "Vue Bootsrap 4 advanced table",
                        num_of_visibile_pagination_buttons: 7, // default 5
                        per_page: 25, // default 10,
                        per_page_options: [ 25, 50, 100, 150, 200 ],
                    },
                    queryParams: {
                        sort: [],
                        filters: [],
                        global_search: "",
                        extra_data: this.extraData,
                        per_page: 10,
                        page: 1
                    },
                    extraData : {!! json_encode($extra_query) !!},
                    total_rows: 0,
                    date_range_query: ''
                }
            },
            methods: {
                onChangeQuery(queryParams) {
                    this.queryParams = queryParams;
                    this.fetchData();
                },
                onSelectRow(rows){
                    console.log(rows);
                    this.selectedRows = rows.selected_items;
                },
                onUnSelectRow(rows){
                    console.log(rows);
                    this.selectedRows = rows.selected_items;
                },
                onSelectAllRow(rows){
                    console.log(rows);
                    this.selectedRows = rows.selected_items;
                },
                onUnSelectAllRow(rows){
                    console.log(rows);
                    this.selectedRows = rows.selected_items;
                },
                onRefreshData(){
                    this.fetchData();
                },
                onAdd(){
                    showAddModal();
                },
                showUpdateModal(row){
                    console.log(row);
                    uvm.title = row.name;
                    uvm.getItemData(row._id);
                    showUpdateModal(row);
                },
                showViewModal(row){
                    vvm.setTitle(row.name);
                    vvm.getItemData(row._id);
                    showViewModal(row);
                },
                fetchData() {
                    var self = this;

                    this.showProgress = true;

                    this.queryParams.extra_data = this.extraData;

                    axios.post('{{ url($dataurl) }}', {
                        params: {
                            "queryParams": this.queryParams,
                            "page": this.queryParams.page
                        }
                    })
                    .then(response => {
                        self.rows = response.data.data;
                        self.total_rows = response.data.total;
                        this.showProgress = false;
                    })
                    .catch( error=> {
                        console.log(error);
                        this.showProgress = false;
                    });
                },
                uploadData(payload){
                    showUploadModal();
                    console.log("Open upload form");
                },
                downloadData(payload) {
                    var filetype = payload.event_payload.filetype;
                    axios.post('{{ url($downloadurl) }}', {
                        params: {
                            "queryParams": this.queryParams,
                            "payload": payload
                        }
                    })
                    .then(function(response) {
                        var data = response.data;

                        if(data.status == 'OK'){

                            if(filetype == 'csv'){
                                window.location.href = data.urlcsv;
                            }else{
                                window.location.href = data.urlxls;
                            }

                        }

                    })
                    .catch(function(error) {
                        console.log(error);
                    });
                },
                showDeleteModal(row){
                    if( typeof row.event_payload === 'undefined'){
                        this.selectedRows.push(row);
                    }

                    console.log(this.selectedRows);

                    if(this.selectedRows.length > 0 ){
                        showDeleteModal();
                    }
                },
                showCloneModal(row){
                    if( typeof row.event_payload === 'undefined'){
                        this.selectedRows.push(row);
                    }

                    console.log(this.selectedRows);

                    if(this.selectedRows.length > 0 ){
                        showCloneModal();
                    }
                },
                clearSelection(){
                    this.selectedRows = [];
                },
                getCurrentSelection(){
                  return this.selectedRows;
                },

                confirmCloneData(){
                    let data = this.selectedRows;

                    axios.post('{{ url($cloneurl) }}', {
                        params: {
                            "data": data
                        }
                    })
                    .then(response => {
                        var data = response.data;

                        if(data.status == 'OK'){
                            this.clearSelection();
                            console.log(this.selectedRows);
                        }
                        hideCloneModal();
                    })
                    .catch(function(error) {
                        console.log(error);
                    });

                },

                confirmDelete(){
                    let data = this.selectedRows;

                    axios.post('{{ url($delurl) }}', {
                        params: {
                            "data": data
                        }
                    })
                    .then(response => {
                        var data = response.data;

                        if(data.status == 'OK'){
                            this.clearSelection();
                            console.log(this.selectedRows);
                        }
                        hideDeleteModal();
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
                },
                formatDate(dt){
                    return formatDate(dt);
                },
                goToLink(url){
                    console.log(url);
                    goToUrl(url);
                },
                imageUrl(file){
                    console.log(file);
                    if(_.isEmpty(file) || _.get(file, 'url') == '' ){
                        return '{{ url( env( "DEFAULT_THUMBNAIL" ) ) }}';
                    }else{
                        return file.base + file.url;
                    }
                },
                imageCount(files){
                    if(_.isEmpty(files)){
                        return '';
                    }else{
                        return files.length + ' photos';
                    }
                },
                imageUrls(files){
                    console.log(files);
                    var defUrl = '{{ url( env( "DEFAULT_THUMBNAIL" ) ) }}';
                    if(_.isEmpty(files)){
                        var imageThumb = {
                            src: defUrl, // origin image source
                            thumbnailSrc: defUrl, // thumbnail source
                            width: '150px', // thumbnail width
                            height: 'auto', // thumbnail height
                            name: 'No Image', // Image name which shows in footer
                            class: 'img-thumbnail'
                        };
                        return [ imageThumb ];
                    }else{
                        var images = [];
                        _.forEach(files, img => {
                            if(_.isEmpty(img) || _.get(img, 'url') == '' ){
                                //images.push( defUrl );
                            }else{
                                var imageThumb = {
                                    src: img.base + img.url, // origin image source
                                    thumbnailSrc: img.base + img.url, // thumbnail source
                                    width: '150px', // thumbnail width
                                    height: 'auto', // thumbnail height
                                    name: img.filename, // Image name which shows in footer
                                    class: 'img-thumbnail'
                                };

                                images.push( imageThumb );
                            }
                        });
                        return images;
                    }
                },


                {{ $template_var['tvm_methods']??'' }}

            }
        }).$mount('#app');

        function showUpdateModal(){
            uvm.openModal();
            //$('#updateModal').modal({show:true});
        }

        function goToUrl(url) {
            window.location.href = url;
        }

        function showViewModal(editObject){
            console.log(editObject);
            vvm.openModal();
            //$('#viewModal').modal({show:true});
        }

        function showSubModal(){
            $('#subModal').modal('show');
        }

        function showAddModal(){
            avm.getParam();
            avm.openModal();
            // $('#addModal').modal('show');
        }

        function hideAddModal(){
            $('#addModal').modal('hide');
            tvm.fetchData();
        }

        function showUploadModal(){
            var imid = _.random(1, 10000, false);
            imvm.setImportId(imid);
            imvm.openModal();
            // $('#uploadModal').modal('show');
        }

        function hideUploadModal(){
            //$('#uploadModal').modal('hide');
            imvm.hideModal();
            tvm.fetchData();
        }

        function showDeleteModal(){
            $('#deleteModal').modal('show');
        }

        function hideDeleteModal() {
            $('#deleteModal').modal('hide');
            tvm.clearSelection();
            tvm.fetchData();
        }

        function showCloneModal(){
            $('#cloneModal').modal('show');
        }

        function hideCloneModal() {
            $('#cloneModal').modal('hide');
            tvm.clearSelection();
            tvm.fetchData();
        }

        function hideUpdateModal(){
            $('#updateModal').modal('hide');
            tvm.fetchData();
        }

        $('#addItemButton').on('click',function(data){
            showAddModal();
        });

        $('#confirmDelete').on('click',function(){
           tvm.confirmDelete();
        });

        $('#confirmCloneData').on('click',function(){
            tvm.confirmCloneData();
        });

        $('#cloneModal').on('hidden.bs.modal', function(e){
            tvm.clearSelection();
        });

        $('#deleteModal').on('hidden.bs.modal', function(e){
            tvm.clearSelection();
        });

        $('#addModal').on('shown.bs.modal', function(event) {
            window.dispatchEvent(new Event('resize'));
        });

        $('#updateModal').on('shown.bs.modal', function(event) {
            window.dispatchEvent(new Event('resize'));
        });

        $('#viewModal').on('shown.bs.modal', function(event) {
            window.dispatchEvent(new Event('resize'));
        });

        $('#addModal').on('hidden.bs.modal', function(event) {
            window.dispatchEvent(new Event('resize'));
            avm.clearForm();
        });

        $('#updateModal').on('hidden.bs.modal', function(event) {
            window.dispatchEvent(new Event('resize'));
            uvm.clearForm();
        });

        $('#viewModal').on('hidden.bs.modal', function(event) {
            window.dispatchEvent(new Event('resize'));
            vvm.clearForm();
        });

        function formatDate(dt){
            return moment(dt).locale('id').format('{{ env('DATE_FORMAT', 'L') }}');
        }
    });


</script>

    <style>
        .vbt-checkbox: {
            margin-top: 8px !important;
        }

        .btn i , .btn-group > .btn i{
            font-size: 9pt;
        }
    </style>

    <link href="{{ url('/') }}/css/table_framework.css" rel="stylesheet">

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if( View::exists($extra_view) )
                @include($extra_view, $extra_view_params)
            @endif
        </div>
        <div class="col-md-12">
            <span  v-if="showProgress" class="loader">
                <b-spinner type="grow" label="Spinning"></b-spinner> Loading...
            </span>
        </div>
    </div>


    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <vue-bootstrap4-table
                            :rows="rows"
                            :columns="columns"
                            :config="config"
                            :actions="actions"
                            @on-change-query="onChangeQuery"
                            @on-select-row="onSelectRow"
                            @on-unselect-row="onUnSelectRow"
                            @on-all-select-rows="onSelectAllRow"
                            @on-all-unselect-rows="onUnSelectAllRow"
                            @on-download="downloadData"
                            @on-add="onAdd"
                            @on-upload="uploadData"
                            @on-delete="showDeleteModal"
                            @refresh-data="onRefreshData"
                            :total-rows="total_rows">
                        <template slot="sort-asc-icon">
                            <i class="fas fa-sort-up"></i>
                        </template>
                        <template slot="sort-desc-icon">
                            <i class="fas fa-sort-down"></i>
                        </template>
                        <template slot="no-sort-icon">
                            <i class="fas fa-sort"></i>
                        </template>
                        <template slot="refresh-button-text">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </template>
                        <template slot="reset-button-text">
                            <i class="fas fa-undo"></i> Reset
                        </template>
                        <template slot="empty-results">
                            <div class="text-center" style="color: steelblue">
                                <i class="far fa-3x fa-folder-open"></i><br>Nothing we can find that suit your request, sorry...
                            </div>
                        </template>
                        <template slot="_id" slot-scope="props">
                            <div>
                                @if($show_actions)
                                    <b-dropdown dropright variant="border-transparent" no-caret >
                                        <template v-slot:button-content>
                                            <i class="fa fa-chevron-right"></i>
                                        </template>
                                        <b-dropdown-item href="#" @click="showViewModal(props.row)" ><i class="fa fa-eye"></i> View</b-dropdown-item>
                                        <b-dropdown-item href="#" @click="showUpdateModal(props.row)" ><i class="fa fa-edit"></i> Edit</b-dropdown-item>
                                        <b-dropdown-divider></b-dropdown-divider>
                                        <b-dropdown-item href="#" @click="showCloneModal(props.row)" ><i class="fa fa-copy"></i> Clone</b-dropdown-item>
                                        <b-dropdown-divider></b-dropdown-divider>
                                        <b-dropdown-item href="#" @click="showDeleteModal(props.row)" ><i class="fa fa-trash"></i> Delete</b-dropdown-item>
                                    </b-dropdown>
                                @endif
                            </div>
                        </template>
                        @foreach($col_attributes as $ct=>$dt)
                            @if($dt['type'] == 'daterange')
                                <template slot="{{ $ct }}" slot-scope="props">
                            <span v-for="dt in props.row.{{ $ct }}" class="form-control-static mr-10" >
                                @{{ formatDate(dt) }}
                            </span>
                                </template>
                            @endif
                            @if($dt['type'] == 'date')
                                <template slot="{{ $ct }}" slot-scope="props">
                                    @{{ (typeof props.cell_value === 'undefined')?'': formatDate(props.cell_value) }}
                                </template>
                            @endif
                            @if($dt['type'] == 'actionLink')
                                <template slot="{{ $ct }}" slot-scope="props">
                                    <span v-if="!props.cell_value" ></span>
                                    <a v-if="props.cell_value" href="#" v-on:click="goToLink(props.cell_value)" class="btn btn-primary" >{{ $dt['label'] }}</a>
                                </template>
                            @endif
                            @if($dt['type'] == 'image')
                                <template slot="{{ $ct }}" slot-scope="props">
                                    <div class="thumb-container" >
                                        <img v-bind:src="imageUrl(props.row.{{ $ct }})" class="img-thumbnail" style="width: 150px;min-width: 150px;">
                                    </div>
                                </template>
                            @endif
                            @if($dt['type'] == 'imagearray')
                                <template slot="{{ $ct }}" slot-scope="props">
                                    <div class="thumb-container" >
                                        {{--<vue-previewer :images="imageUrls( props.row.{{ $ct }} )" :options="{}" />--}}
                                    </div>
                                </template>
                            @endif
                        @endforeach
                        @if( View::exists($tableslotview) )
                            @include($tableslotview, ['ct'=>$ct, 'dt'=>$dt])
                        @endif
                    </vue-bootstrap4-table>
                </div>
            </div>
        </div>
    </div>



    <div class="container">
        <div class="row justify-content-lg-around">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

    <!-- Button trigger modal -->
@section('modal')
    <!-- Modal -->
    <div id="addModal">
        <b-modal id="addItemModal"
                 modal-class="modal-fullscreen"
                 @ok="addItem"
                 size="xl"
                 title="Create {{ \Illuminate\Support\Str::singular($title) }}"
                 modal-class="modal-bv" >

            @include( $form_view ,[ 'yml_file'=>$yml_file,'yml_layout_file'=>$yml_layout_file,'res_path'=>$res_path ])

        </b-modal>
    </div>

    <div id="updateModal">
        <b-modal id="updateItemModal"
                 modal-class="modal-fullscreen"
                 @ok="updateItem"
                 size="xl"
                 title="Update {{ $title }}"
                 modal-class="modal-bv" >
                @include( $form_view ,[ 'yml_file'=>$yml_file,'yml_layout_file'=>$yml_layout_file,'res_path'=>$res_path ])
        </b-modal>
    </div>

    <div id="viewModal">
        <b-modal id="viewItemModal"
                 modal-class="modal-fullscreen"
                 @ok="hideModal"
                 size="xl"
                 title="View {{ $title }}"
                 modal-class="modal-bv" >

                @include( $form_view ,[ 'yml_file'=>$yml_file,'yml_layout_file'=>$yml_layout_file,'res_path'=>$res_path ])

        </b-modal>
    </div>

    <div id="uploadModal">
        <b-modal id="uploadItemModal"
                 modal-class="modal-fullscreen"
                 @ok="commitData"
                 size="xl"
                 title="Upload & Import"
                 modal-class="modal-bv" >
                <import-data
                        :importid="importId"
                        :sourceurl="sourceUrl"
                        :previewcolumns="previewColumns"
                        :previewheadings="previewHeadings"
                        :uploadurl="uploadUrl"
                        :commiturl="commitUrl"
                ></import-data>

        </b-modal>
    </div>

    <div class="modal fade" id="deleteModal"
         tabindex="-1" role="dialog"
         data-backdrop="false"
         aria-labelledby="Update"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete {{ $title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete these {{ $title }} ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete" >Yes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cloneModal"
         tabindex="-1" role="dialog"
         data-backdrop="false"
         aria-labelledby="Update"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Clone {{ $title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to clone data ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="confirmCloneData" >Yes</button>
                </div>
            </div>
        </div>
    </div>

@endsection
