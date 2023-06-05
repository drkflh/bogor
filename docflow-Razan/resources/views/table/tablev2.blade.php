@extends($layout??'layouts.dashforge')

@section('js')
    <script src="{{ url('/') }}/editor/ckeditor5-31.1.0/build/ckeditor.js" ></script>

    <script>
        $(document).ready(function () {

            window.tz = "{{ $tz ?? env('DEFAULT_TIME_ZONE', 'Asia/Jakarta') }}";

            $("form").submit(function (event) {
                event.preventDefault();
            });

            @if( env('WITH_WEBSOCKET', false))
            Echo.channel('dashboard-notification')
                .listen('.{{ env('APP_NAMESPACE') }}.ExportDone', (e)=>{
                    bus.$emit('exportdone', e);
                });

            Echo.channel('dashboard-notification')
                .listen('.{{ env('APP_NAMESPACE') }}.MailSent', (e)=>{
                    bus.$emit('mailsent', e);
                });
            @endif

            var lightboxvm = new Vue({
                mounted(){
                    bus.$on('openlightbox', (payload) => {
                        console.log('openlightbox', payload);
                        var images = [];
                        var selected = {};
                        var imgindex = 0;

                        if(_.isObject(payload) && _.has(payload, 'items')){
                            selected = _.get(payload, 'selected');
                            var imgs = _.get(payload, 'items');
                            _.forEach(imgs, im=>{
                                if(!this.isDoc(im.url)){
                                    images.push(im.url);
                                }
                            })
                            imgindex = images.indexOf(selected.url);

                            console.log('lightbox images', images);
                            console.log('lightbox selected', selected);
                            if(selected.type == 'images' && !this.isDoc(selected.url) ){
                                this.galleryUrls = images;
                                this.showLightBox(imgindex);
                            }else{
                                this.showPdf(selected.url);
                            }

                        }else if(_.isArray(payload)){
                            _.forEach(payload, img=>{
                                console.log('img', img);
                                if (_.isString(img)){
                                    images.push(img);
                                    imgindex = images.indexOf(img);
                                }
                            });
                            this.galleryUrls = images;
                            this.showLightBox(imgindex);
                        }


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
                        tvm.pdfDocUrl = url;
                        tvm.pdfLightBoxVisible = true;
                    }
                }
            }).$mount('#lightBoxContainer');

            var avm = new Vue({
                mounted() {
                    @if( View::exists($add_event_view) )
                        @include($add_event_view)
                    @endif

                    window.dispatchEvent(new Event('resize'));
                },
                name: 'Add Modal',
                data: function () {
                    return {
                        title: 'Create',

                        @if(strpos($yml_file, '_controller') === false)
                            {!! implode("\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataModel('default') ) !!}
                        @else
                            {!! implode("\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataList() ) !!}
                        @endif

                        handle: '',
                        itemId: '',
                        timer: null,
                        keyword0: '{!! $keyword0 !!}',
                        keyword1: '{!! $keyword1 !!}',
                        keyword2: '{!! $keyword2 !!}',
                        autosave: false,
                        isLoading: false,
                        loadSession: '',
                        paramUrl: '{{ url($paramurl) }}',
                        defaultImageThumbnail: '{{ url(env('DEFAULT_THUMBNAIL', '/')) }}',
                        defaultImageDraw: '{{ url(env('DEFAULT_DRAW_IMAGE', '/')) }}',
                        notificationClass: 'message',
                        notificationMessage: '',
                        // editor: ClassicEditor,
                        // editorConfig: {
                        //     // The configuration of the editor.
                        // },

                    @if(isset($auxdata))
                        @foreach($auxdata as $k=>$v)
                            @if( is_array( $v ) )
                                {{ $k }}: {!! json_encode($v) !!} ,
                            @else
                                {{ $k }}: {!! $v !!},
                            @endif
                        @endforeach
                    @endif
                        mapUrl: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
                        mapZoom: {{ config('geo.default_zoom') }},
                        mapCenter: [ {{ config('geo.origin_lat').','.config('geo.origin_lon') }} ],
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
                watch: {
                    @if( View::exists($add_watch_view) )
                        @include($add_watch_view)
                    @endif
                },
                computed: {
                    @if( View::exists($add_computed_view) )
                        @include($add_computed_view)
                    @endif
                },

                methods: {
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
                    collectData() {
                        var model_set = {
                            ajax: true,
                            handle: this.handle,
                            tz: window.tz,
                            @if(strpos($yml_file, '_controller') === false)
                                {!! implode("\r\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toVueDataModel('objectfield') ) !!}
                            @else
                                {!! implode("\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataList('', ':', 'this.',',', true) ) !!}
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
                                console.log(error);
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
                    getItemData(item_id) {
                        this.itemId = _.isNull(item_id) ? this.itemId : item_id;
                        this.isLoading = true;
                        this.notificationMessage = 'Loading item data';
                        this.notificationClass = 'message';

                        var keywords = {
                            keyword0 : this.keyword0,
                            keyword1 : this.keyword1,
                            keyword2 : this.keyword2
                        };

                        axios.post('{{ url($itemdataurl) }}/' + item_id, keywords)
                            .then((response) => {
                                this.setDataModel(response.data);
                                this.isLoading = false;
                                this.notificationMessage = 'Success loading data';
                                this.notificationClass = 'message';
                            })
                            .catch(function (error) {
                                console.log(error);
                                this.isLoading = false;
                                this.notificationMessage = 'Failed loading item data';
                                this.notificationClass = 'error';
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }
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
                    cancelForm(){
                        this.clearForm();
                        this.hideModal();
                        tvm.loadTableData();
                    },
                    clearForm() {
                        this.handle = '';
                        if(this.timer != null){
                            clearInterval(this.timer);
                        }
                        @if(strpos($yml_file, '_controller') === false)
                            {!! implode("\r\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toVueDataModel('clear') ) !!}
                        @else
                            {!! implode("\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataList('this.','=', '',',') ) !!}
                        @endif
                        console.log("add form cleared");

                        /**
                         * auxiliary function on add form hidden
                         * */
                        if (typeof this.onHiddenMethod == 'function') {
                            console.log('onHiddenMethod');
                            this.onHiddenMethod();
                        }
                        bus.$emit('refreshTable',{});
                    },
                    endSession(){
                        avm.hideModal();
                    },
                    addItem(event) {
                        @if(env('SKIP_VALIDATION', true ))
                            this.postData(event);
                            avm.hideModal();
                        @else
                            //evt.preventDefault();
                            console.log(avm.$refs);
                            avm.$refs.add_veeObserver.validate()
                            .then((valid) => {
                                console.log('valid', valid);
                                if(valid) {
                                    this.postData(event);
                                }
                            })
                            .catch((error) => {
                                alert(error.toString());
                            })
                        @endif
                    },
                    postData(act) {
                        let self = this;
                        let postData = this.collectData();
                        postData.tz = window.tz;

                        @if( View::exists($js_post_transform) )
                            @include($js_post_transform)
                        @endif
                        console.log(postData);
                        this.isLoading = true;
                        this.notificationMessage = 'Saving Data';
                        this.notificationClass = 'message';

                        var keywords = {
                            keyword0 : this.keyword0,
                            keyword1 : this.keyword1,
                            keyword2 : this.keyword2
                        };

                        postData.keywords = keywords;

                        axios.post('{{ url($addurl) }}', postData)
                            .then(response => {
                                console.log(response.data);
                                if (response.data.result == 'OK') {

                                    if( act == 'CLOSE'){
                                        this.clearForm();
                                        this.hideModal();
                                        //tvm.loadTableData();
                                    }else{
                                        console.log('continue editing');
                                        alert('Data saved successfully. Continue with new data.')
                                        this.clearForm();
                                    }
                                    this.isLoading = false;
                                    this.notificationMessage = '';
                                    this.notificationClass = 'message';

                                }
                            })
                            .catch( (error) => {
                                console.log(error);
                                this.isLoading = false;
                                this.notificationMessage = 'Failed to load data';
                                this.notificationClass = 'error';

                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }

                            }).finally( () => {
                                this.isLoading = false;
                            });
                    },
                    onShown(){
                        window.dispatchEvent(new Event('resize'));
                        bus.$emit('resize',{});
                        if (typeof this.onShownMethod == 'function') {
                            console.log('onShowMethod');
                            this.onShownMethod();
                        }
                    },
                    async isUnique(field, params, data){
                        var postData = {
                            field : field,
                            params : params,
                            data : data
                        };
                        axios.post('{{ url($validate_url) }}', postData)
                            .then(response => {
                                console.log(response.data);
                                if (response.data.result == 'OK') {

                                }
                            })
                            .catch( (error) => {
                                console.log(error);
                            }).finally( () => {
                                this.isLoading = false;
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
                    openModal() {
                        this.$bvModal.show('addItemModal');
                    },
                    formatCurrency(val, neg = false){
                        val = parseFloat(val);
                        if(neg){
                            val = -val ;
                        }
                        return accounting.formatMoney( val , this.accFormat);
                    },
                    getTitle(){
                        return {!! $add_title_fields !!};
                    },
                    generateRandomString(length=6){
                        return Math.random().toString(20).substr(2, length);
                    },
                    hideModal() {
                        this.clearForm();
                        this.$bvModal.hide('addItemModal');
                        bus.$emit('refreshTable', {});
                    },
                    toSlug(val){
                        if(_.isString(val)){
                            return val.replace(/^\s+|\s+$|\s+(?=\s)/g, '').replace(/[^\w\s]/gi, '').split(' ').join('-').toLowerCase();
                        }else{
                            return val;
                        }
                    },
                    @if( View::exists($add_methods_view) )
                        @include($add_methods_view)
                    @endif
                }
            }).$mount('#addModal');

            var uvm = new Vue({
                mounted() {
                    @if( View::exists($edit_event_view) )
                        @include($edit_event_view)
                    @endif
                    window.dispatchEvent(new Event('resize'));
                },
                name: 'Update Modal',
                data: function () {
                    return {
                        @if(strpos($yml_file, '_controller') === false)
                            {!! implode("\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataModel('default') ) !!}
                        @else
                            {!! implode("\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataList() ) !!}
                        @endif
                        title: 'Update',
                        itemId: '',
                        handle: '',
                        keyword0: '{!! $keyword0 !!}',
                        keyword1: '{!! $keyword1 !!}',
                        keyword2: '{!! $keyword2 !!}',
                        autosave: false,
                        isLoading: false,
                        defaultImageThumbnail: '{{ url(env('DEFAULT_THUMBNAIL')) }}',
                        defaultImageDraw: '{{ url(env('DEFAULT_DRAW_IMAGE', '/')) }}',
                        notificationClass: 'message',
                        notificationMessage: '',
                        // editor: ClassicEditor,
                        // editorConfig: {
                        //     // The configuration of the editor.
                        // },

                    @if(isset($auxdata))
                        @foreach($auxdata as $k=>$v)
                            @if( is_array( $v ) )
                                {{ $k }}: {!! json_encode($v) !!} ,
                            @else
                                {{ $k }}: {!! $v !!},
                            @endif
                        @endforeach
                    @endif
                        mapUrl: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
                        mapZoom: {{ config('geo.default_zoom') }},
                        mapCenter: {{ '{ lat:'.config('geo.origin_lat').', lng:'.config('geo.origin_lon').'}' }},
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
                watch: {
                    @if( View::exists($edit_watch_view) )
                        @include($edit_watch_view)
                    @endif
                },
                computed: {
                    @if( View::exists($edit_computed_view) )
                        @include($edit_computed_view)
                    @endif
                },
                methods: {
                    slugToTitle(val){
                        var str = this[val];
                        if(_.isString(str) && str != '' ){
                            var words = str.split('-').join(' ');
                            return titleCase(words);
                        }else{
                            return str;
                        }
                    },
                    sumColumn(collection, fieldname){
                        var items = collection.map( it => { return it[fieldname] } );
                        var total = items.reduce( ( prev, curr) => {
                            return prev + parseFloat(curr);
                        }, 0 );
                        console.log(total);
                        return total;
                    },
                    generateRandomString(length=6){
                        return Math.random().toString(20).substr(2, length);
                    },
                    maxToday(date){
                        return maxToday(date);
                    },
                    setItemDataModel(data) {
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
                    collectData() {
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
                    getItemData(item_id) {
                        this.itemId = item_id;
                        this.isLoading = true;
                        this.notificationMessage = 'Loading item data';
                        this.notificationClass = 'message';

                        axios.post('{{ url($itemdataurl) }}/' + item_id, { action : 'LOAD_UPDATE'})
                            .then((response) => {
                                this.setItemDataModel(response.data);
                                this.isLoading = false;
                                this.notificationMessage = 'Success loading data';
                                this.notificationClass = 'message';
                            })
                            .catch(function (error) {
                                console.log(error);
                                this.isLoading = false;
                                this.notificationMessage = 'Failed loading item data';
                                this.notificationClass = 'error';
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }
                            });
                    },
                    cancelForm(){
                        this.clearForm();
                        this.hideModal();
                        tvm.loadTableData();
                    },
                    clearForm() {
                        @if(strpos($yml_file, '_controller') === false)
                            {!! implode("\r\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toVueDataModel('clear') ) !!}
                        @else
                            {!! implode("\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataList('this.','=','',';') ) !!}
                        @endif

                        this.handle = '';
                        this.itemId = '';
                        console.log("update form cleared");
                        bus.$emit('refreshTable',{});
                    },
                    endSession(){
                        uvm.hideModal();
                    },
                    updateItem(event) {
                        @if(env('SKIP_VALIDATION', true ))
                            this.postData(event);
                        @else
                            // event.preventDefault();
                            uvm.$refs.edit_veeObserver.validate()
                            .then((valid) => {
                                if(valid) {
                                    this.postData(event);
                                    // .then(() => {
                                    //     uvm.$refs.edit_veeObserver.reset();
                                    // });
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                                this.isLoading = false
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }
                            })
                        @endif
                    },
                    postData(act) {
                        let self = this;
                        let postData = this.collectData();
                        postData.tz = window.tz;

                        @if( View::exists($js_post_transform) )
                            @include($js_post_transform)
                        @endif

                        console.log(postData);
                        this.isLoading = true;
                        this.notificationMessage = 'Saving Data';
                        this.notificationClass = 'message';

                        var keywords = {
                            keyword0 : this.keyword0,
                            keyword1 : this.keyword1,
                            keyword2 : this.keyword2
                        };

                        postData.keywords = keywords;

                        axios.post('{{ url($updateurl) }}/' + this.itemId, postData)
                            .then(response => {
                                console.log(response.data);
                                if (response.data.result == 'OK') {

                                    if( act == 'CLOSE'){
                                        this.clearForm();
                                        this.hideModal();
                                        tvm.loadTableData();
                                    }else{
                                        console.log('continue editing');
                                        alert('Data updated successfully.')
                                    }
                                    this.isLoading = false;
                                    this.notificationMessage = '';
                                    this.notificationClass = 'message';
                                    //tvm.$emit('refresh-data');
                                }
                            })
                            .catch( (error) => {
                                console.log(error);
                                this.isLoading = false;
                                this.notificationMessage = 'Failed to load data';
                                this.notificationClass = 'error';

                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }
                            }).finally( () => {
                                this.isLoading = false;
                            });
                    },
                    onShown(){
                        window.dispatchEvent(new Event('resize'));
                        bus.$emit('resize',{});
                    },
                    busEmit(command,payload){
                        bus.$emit(command, payload );
                    },
                    openModal() {
                        this.$bvModal.show('updateItemModal');
                    },
                    hideModal() {
                        this.clearForm();
                        this.$bvModal.hide('updateItemModal');
                        bus.$emit('refreshTable', {});
                    },
                    formatCurrency(val, neg = false){
                        val = parseFloat(val);
                        if(neg){
                            val = -val ;
                        }
                        return accounting.formatMoney( val ,this.accFormat);
                    },
                    getTitle(){
                        return {!! $update_title_fields !!};
                    },
                    toSlug(val){
                        if(_.isString(val)){
                            return val.replace(/^\s+|\s+$|\s+(?=\s)/g, '').replace(/[^\w\s]/gi, '').split(' ').join('-').toLowerCase();
                        }else{
                            return val;
                        }
                    },
                    @if( View::exists($edit_methods_view) )
                        @include($edit_methods_view)
                    @endif
                }
            }).$mount('#updateModal');

            var vvm = new Vue({
                mounted() {
                    @if( View::exists($view_event_view) )
                        @include($view_event_view)
                    @endif
                    window.dispatchEvent(new Event('resize'));
                },
                name: 'View Modal',
                data: function () {
                    return {
                        @if(strpos($yml_file, '_controller') === false)
                            {!! implode("\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataModel('default') ) !!}
                        @else
                            {!! implode("\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataList() ) !!}
                        @endif
                        title: 'View',
                        itemId: '',
                        handle: '',
                        autosave: false,
                        isLoading: false,
                        printItem: {},
                        defaultImageThumbnail: '{{ url(env('DEFAULT_THUMBNAIL')) }}',
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

                    // dpFormat: 'DD/MM/YYYY',
                    // tpHours: Array.from({ length: 10 }).map((_, i) => i + 8),

                    mapUrl: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
                    mapZoom: {{ config('geo.default_zoom') }},
                    mapCenter: {{ '{ lat:'.config('geo.origin_lat').', lng:'.config('geo.origin_lon').'}' }},
                        accFormat: {
                            format : {
                                pos : "%s %v",   // for positive values, eg. "$ 1.00" (required)
                                neg : "%s (%v)", // for negative values, eg. "$ (1.00)" [optional]
                                zero: "%s  -- "  // for zero values, eg. "$  --" [optional]
                            }
                        }

                    };
                },
                methods: {
                    slugToTitle(val){
                        var str = this[val];
                        if(_.isString(str) && str != '' ){
                            var words = str.split('-').join(' ');
                            return titleCase(words);
                        }else{
                            return str;
                        }
                    },
                    formatDate(dt) {
                        return formatDate(dt);
                    },
                    sumColumn(collection, fieldname){
                        var items = collection.map( it => { return it[fieldname] } );
                        var total = items.reduce( ( prev, curr) => {
                            return prev + parseFloat(curr);
                        }, 0 );
                        console.log(total);
                        return total;
                    },
                    setTitle(title) {
                        this.title = title;
                    },
                    setPrintItem(item){
                        this.printItem = item;
                    },
                    setItemDataModel(data) {

                        @if( View::exists($js_load_transform) )
                            @include($js_load_transform)
                        @endif

                        _.forIn(data, (value, key) => {
                            console.log(key, value);
                            this[key] = value;
                        });
                    },
                    getItemData(item_id) {
                        this.itemId = item_id;
                        this.isLoading = true;
                        axios.post('{{ url($itemdataurl) }}/' + item_id , { action: 'VIEW' })
                            .then((response) => {
                                this.setItemDataModel(response.data);
                                this.isLoading = false;
                            })
                            .catch(function (error) {
                                console.log(error);
                                this.isLoading = false;
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }

                            });
                    },
                    clearForm() {
                        @if(strpos($yml_file, '_controller') === false)
                            {!! implode("\r\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toVueDataModel('clear') ) !!}
                        @else
                            {!! implode("\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataList('this.','=','',';') ) !!}
                        @endif
                        this.handle = '';
                        this.itemId = '';
                        console.log("update form cleared");
                    },
                    showLightBox(key){
                        var pic = _.get( this, key );
                        if(_.isArray(pic)){
                            bus.$emit('openlightbox', pic );
                        }else if(_.isString( pic )){
                            bus.$emit('openlightbox', [pic] );
                        }
                    },
                    showPdf(url) {
                        tvm.pdfDocUrl = url;
                        tvm.pdfLightBoxVisible = true;
                    },
                    printSelected(){

                        var payload = {
                            ns: 'default',
                            obj: [this.printItem],
                            multi: false,
                            modalClass: '{{ $print_modal_class }}',
                            modalSize: '{{ $print_modal_size }}',
                            showSelect: false,
                            @if(is_string($print_template))
                            defaultTemplate: '{{ $print_template }}'
                            @endif
                        };
                        //console.log(data);
                        bus.$emit('printitem', payload );
                    },
                    printSelectedTemplate(template, modal_size){

                        var payload = {
                            ns: 'default',
                            obj: [this.printItem],
                            multi: false,
                            modalClass: '{{ $print_modal_class }}',
                            modalSize: modal_size,
                            showSelect: false,
                            defaultTemplate: template
                        };
                        //console.log(data);
                        bus.$emit('printitem', payload );
                    },
                    prettyJson(json){
                        if (typeof json != 'string') {
                            json = JSON.stringify(json, undefined, 2);
                        }
                        if(json == ''){
                            return json;
                        }else{
                            return jsonFormater.format(json);
                        }
                    },
                    formatDate(dt) {
                        return formatDate(dt);
                    },
                    formatTime(dt) {
                        return formatTime(dt);
                    },
                    formatDateTime(dt) {
                        return formatDateTime(dt);
                    },
                    formatDateTimeUTC(dt) {
                        return formatDateTimeUTC(dt);
                    },
                    formatMonth(dt) {
                        return formatMonth(dt);
                    },
                    formatCurrency(val, neg = false){
                        val = parseFloat(val);
                        if(neg){
                            val = -val ;
                        }
                        return accounting.formatMoney( val , '' ,2, '.', ',', this.accFormat);
                    },
                    busEmit(command,payload){
                        bus.$emit(command, payload );
                    },
                    openModal() {
                        this.$bvModal.show('viewItemModal');
                    },
                    hideModal() {
                        this.$bvModal.hide('viewItemModal');
                    },
                    getTitle(){
                        return {!! $view_title_fields !!};
                    },
                    toSlug(val){
                        if(_.isString(val)){
                            return val.replace(/^\s+|\s+$|\s+(?=\s)/g, '').replace(/[^\w\s]/gi, '').split(' ').join('-').toLowerCase();
                        }else{
                            return '';
                        }
                    },
                    @if( View::exists($view_methods_view) )
                        @include($view_methods_view)
                    @endif
                },
                watch: {
                    @if( View::exists($view_watch_view) )
                        @include($view_watch_view)
                    @endif
                },
                computed: {
                    @if( View::exists($view_computed_view) )
                        @include($view_computed_view)
                    @endif
                },
            }).$mount('#viewModal');

            var pvm = new Vue({
                mounted() {
                    bus.$on('printitem', (payload) => {
                        console.log('printdocument', payload);
                        if( _.has( payload, 'ns' ) ){

                            this.modalClass = _.get( payload, 'modalClass' );
                            this.modalSize = _.get( payload, 'modalSize' );
                            this.ns = _.get( payload, 'ns' );
                            this.itemId = _.get( payload, 'defaultTemplate' );
                            this.title = 'Print Document';
                            this.printItemData = _.get( payload, 'obj' );
                            this.serverParams = _.get( payload, 'serverParams' );

                            console.log(this.serverParams);
                            var search = _.get(this.serverParams, 'searchTerm', '' );
                            var exsearch = _.get( this.serverParams, 'extraData', false );

                            var tmpl_name = this.transformTemplateName(this.itemId, this.printItemData );

                            if( search != '' || exsearch ){
                                this.getTemplate(tmpl_name);
                            }else{
                                if(_.isEmpty(this.printItemData) || _.isNull(this.printItemData)){
                                    alert("Please select item(s) to print out");
                                }else {
                                    this.getTemplate(tmpl_name);
                                }
                            }
                        }
                    });

                    window.dispatchEvent(new Event('resize'));
                },
                name: 'Print Modal',
                data: function () {
                    return {
                        title: 'Print',
                        itemId: '',
                        handle: '',
                        modalSize: 'lg',
                        modalClass: '',
                        autosave: false,
                        isLoading: false,
                        printItemData: [],
                        printTemplate: '',
                        printUrl: '',
                        serverParams: {},
                        cacheid : '',
                        keywords: {
                            keyword0: '{!! $keyword0 !!}',
                            keyword1: '{!! $keyword1 !!}',
                            keyword2: '{!! $keyword2 !!}'
                        },
                        printOptions: { styles: [
                                                '{{ url('css/app.css')  }}',
                                                '{{ url('css/table_framework.css')  }}',
                                                '{{ url('css/print.css')  }}',
                                            ]
                                    },
                        doApproval: false,
                        requestSigning : false,
                        decision : {
                            'approverId':'{{ Auth::user()->_id ?? 'noid' }}',
                            'approverName': '{{ Auth::user()->name ?? 'noname' }}',
                            'decision' : '',
                            'timestamp' : null,
                            'note' : '',
                            'authorization': '',
                            'authorizationSign' : '',
                            'initialSign' : '',
                            'useSignature' : false,
                            'useInitial' : false,
                            'authorizationSignSpecimen' : '{{ Auth::user()->signatureSpecimen ?? '' }}',
                            'initialSignSpecimen' : '{{ Auth::user()->initialSpecimen ?? '' }}',
                        }
                    };
                },
                methods: {
                    setTitle(title) {
                        this.title = title;
                    },
                    onShow(){
                        this.handle = this.generateRandomString(6);
                    },
                    generateRandomString(length=6){
                        return Math.random().toString(20).substr(2, length);
                    },
                    closeApproval(){
                        this.doApproval = false;
                        this.decision = {
                            'approverId':'{{ Auth::user()->_id ?? 'noid' }}',
                            'approverName': '{{ Auth::user()->name ?? 'noname' }}',
                            'decision' : '',
                            'timestamp' : null,
                            'note' : '',
                            'authorization': '',
                            'authorizationSign' : '',
                            'initialSign' : '',
                            'useSignature' : false,
                            'useInitial' : false
                        };
                    },

                    commitSigning(event) {

                        if(this.decision.decision == ''){
                            alert('Please set Decision');
                            return;
                        }

                        if(this.decision.useSignature && this.decision.authorizationSign == ''){
                            alert('Please sign and save your signature');
                            return;
                        }

                        if(this.decision.useInitial && this.decision.initialSign == ''){
                            alert('Please sign and save your initial');
                            return;
                        }

                        if(this.decision.authorization.length < 6){
                            alert('PIN should be 6 digit number');
                            return;
                        }

                        this.isLoading = true;

                        var doc = _.first(this.printItemData);

                        var decisionData = {
                            doc : doc,
                            entity : this.entity,
                            decisionData : this.decision
                        };

                        axios.post('{{ url( $approval_commit_url ) }}',
                            {
                                data: decisionData,
                                tz: window.tz
                            }
                        )
                            .then((response) => {
                                this.isLoading = false;
                                if(response.data.result == 'OK' ){
                                    alert(response.data.message);
                                    this.hideModal();
                                    //this.hideDecisionModal();
                                }else{
                                    alert(response.data.message);
                                }
                            })
                            .catch(function (error) {
                                console.log(error);
                                this.isLoading = false;
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }

                            });
                    },

                    signing(){
                        this.doApproval = true;
                        // var payload = this.printItem;
                        // bus.$emit('makeDecision', payload );
                        window.dispatchEvent(new Event('resize'));
                    },
                    needSigning(){
                    @if( View::exists($authorization_method_view) )
                        @include($authorization_method_view)
                    @else
                        if( _.isArray( this.printItemData ) && this.printItemData.length > 0 ){
                            var doc = _.head( this.printItemData);
                            var approvers = _.get( doc, 'approverIdStr', false );
                            if(_.isString(approvers) && approvers != ''  ){
                                if( approvers.indexOf( '{{ Auth::user()->_id }}' ) == -1  ){
                                    this.requestSigning = false;
                                }else{
                                    this.requestSigning = true;
                                }
                            }else{
                                this.requestSigning = false;
                            }
                        }else{
                            this.requestSigning = false;
                        }
                    @endif

                    },
                    transformTemplateName(val, obj){
                        @if( View::exists($tmplname_methods_view) )
                            @include($tmplname_methods_view)
                        @endif
                        return val;
                    },
                    downloadPrintXls(){
                        this.isLoading = true;
                        axios.post('{{ url( $downloadprinturl ?? 'api/v1/core/print/template' ) }}?q=' + this.itemId + '&id=' + this.cacheid,
                                {
                                    data: this.printItemData,
                                    serverParams: this.serverParams,
                                    tz: window.tz
                                }
                            )
                            .then((response) => {
                                this.isLoading = false;
                                console.log('response',response);
                                if(response.data.status == 'OK' && response.data.urlxls != '' ){
                                    console.log('response ok',response);
                                    window.location.href = response.data.urlxls;
                                }
                            })
                            .catch((error) =>{
                                console.log(error);
                                this.isLoading = false;
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }

                            });
                    },
                    printLabelContent(){
                        document.getElementById("print-iframe").contentWindow.print();
                    },
                    getTemplate(slug) {
                        this.isLoading = true;
                        axios.post('{{ url( $print_template_url ?? 'api/v1/core/print/template' ) }}?q=' + slug,
                                {
                                    data: this.printItemData,
                                    serverParams: this.serverParams,
                                    tz: window.tz
                                }
                            )
                            .then((response) => {
                                this.isLoading = false;
                                if(response.data.result == 'OK' && response.data.printurl != '' ){
                                    this.printUrl = response.data.printurl;
                                    this.cacheid = response.data.cacheid;
                                    this.openModal();
                                }
                            })
                            .catch(function (error) {
                                console.log(error);
                                this.isLoading = false;
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }

                            });
                    },
                    clearForm() {
                        this.itemId = '';
                        console.log("update form cleared");
                    },
                    busEmit(command,payload){
                        bus.$emit(command, payload );
                    },
                    openModal() {
                        this.$bvModal.show('printItemModal');
                    },
                    hideModal() {
                        this.closeApproval();
                        this.$bvModal.hide('printItemModal');
                    },
                    iOnLoad(){
                        this.handle = this.generateRandomString(6);
                        console.log('iframe loaded');
                        this.isLoading = false;
                    },
                    iOnLoadStart(){
                        this.needSigning();
                        console.log('iframe load start');
                        this.isLoading = true;
                    },
                    getTitle(){
                        return '{!! $view_title_fields ?? 'Print Preview' !!}';
                    },
                    @if( View::exists($view_methods_view) )
                        @include($view_methods_view)
                    @endif
                },
                watch: {

                },
                computed: {

                },
            }).$mount('#printModal');

            var cdvm = new Vue({
                mounted() {
                    bus.$on('confirmDelete', (payload) => {
                        console.log('confirmDelete', payload);
                        if(_.isArray(payload)){
                            this.docs = payload;
                        }else{
                            this.docs = [payload];
                        }
                        this.openConfirmDeleteModal();
                    });

                    bus.$on('confirmRevise', (payload) => {
                        console.log('confirmDelete', payload);
                        if(_.isArray(payload)){
                            this.docs = payload;
                        }else{
                            this.docs = [payload];
                        }
                        this.openConfirmReviseModal();
                    });

                    bus.$on('confirmClone', (payload) => {
                        console.log('confirmClone', payload);
                        if(_.isArray(payload)){
                            this.docs = payload;
                        }else{
                            this.docs = [payload];
                        }
                        this.openConfirmCloneModal();
                    });

                    window.dispatchEvent(new Event('resize'));
                },
                name: 'Confirm Delete Modal',
                data: function () {
                    return {
                        itemId: '',
                        handle: '',
                        modalSize: 'lg',
                        modalClass: '',
                        autosave: false,
                        isLoading: false,

                        docs: [],
                        entity: '{{ $entity }}',

                    };
                },
                computed: {

                },
                methods: {
                    commitDelete(event) {
                        tvm.confirmDelete();
                    },
                    commitClone(event) {
                        tvm.confirmCloneData();
                    },
                    commitRevision(event) {
                        tvm.confirmReviseData();
                    },
                    clearForm() {
                        this.docs = [];
                        console.log("update form cleared");
                    },
                    busEmit(command,payload){
                        bus.$emit(command, payload );
                    },

                    openConfirmDeleteModal() {
                        console.log('deleteConfirmModal', this.docs);
                        this.handle = 'X' + _.random(1, 10000, false);
                        this.$bvModal.show('deleteConfirmModal');
                    },
                    hideConfirmDeleteModal() {
                        this.$bvModal.hide('deleteConfirmModal');
                    },

                    openConfirmCloneModal() {
                        this.handle = 'X' + _.random(1, 10000, false);
                        this.$bvModal.show('cloneConfirmModal');
                    },
                    hideConfirmCloneModal() {
                        this.$bvModal.hide('cloneConfirmModal');
                    },

                    openConfirmReviseModal() {
                        this.handle = 'X' + _.random(1, 10000, false);
                        this.$bvModal.show('revisionConfirmModal');
                    },
                    hideConfirmReviseModal() {
                        this.$bvModal.hide('revisionConfirmModal');
                    },

                    shownRevisionModal(){
                        bus.$emit('resize');
                    },
                    shownDeleteModal(){
                        bus.$emit('resize');
                    },
                    shownCloneModal(){
                        bus.$emit('resize');
                    }
                },
                watch: {

                },
                computed: {

                }
            }).$mount('#confirmationDialogs');

            /**
             * Import Single Sheet XLS
             * @type {this}
             */
            var imvm = new Vue({
                mounted() {

                },
                name: 'Import Modal',
                data: function () {
                    return {
                        title: 'Import',
                        importId: '',
                        sourceUrl: '{!! url($import_src_url) !!}',
                        previewColumns: {!! json_encode($import_preview_cols) !!} ,
                        previewHeadings: {!! json_encode($import_preview_heads) !!} ,
                        uploadUrl: '{!! url($import_upload_url) !!}',
                        commitUrl: '{!! url($import_commit_url) !!}',
                        selectedKeys : [],
                        importAllData : false
                    };
                },
                methods: {
                    setImportId(id) {
                        this.importId = id;
                    },
                    commitData(event) {
                        if(_.isEmpty(this.selectedKeys) && this.importAllData == false){
                            alert('Select items or set Import All to true');
                            event.preventDefault();
                        }else{
                            var url = this.commitUrl + '?importid=' + this.importId;
                            return axios.post(url, {
                                params: {
                                    selectedKeys : this.selectedKeys,
                                    importAllData : this.importAllData,
                                    tz: window.tz
                                }
                            }).then(response => {
                                if (response.data.result == 'OK') {
                                    this.hideModal();
                                }else{
                                    alert( response.data.message );
                                }
                            }).catch(function (e) {
                                if(e.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }
                                if(e.response.status == 409){
                                    console.log(e);
                                    alert('Import failed ' +  e.response.data.message);
                                }
                            });
                        }
                    },
                    openModal() {
                        this.$bvModal.show('uploadItemModal');
                    },
                    hideModal() {
                        this.selectedKeys = [];
                        this.importAllData = false;
                        this.$bvModal.hide('uploadItemModal');
                        //tvm.loadTableData();
                        bus.$emit('refreshTable', {});
                    },
                    hidden(){
                        this.selectedKeys = [];
                        this.importAllData = false;
                    }
                }
            }).$mount('#uploadModal');

            /**
             * Import Multi Sheet XLS
             * @type {this}
             */
            var immsvm = new Vue({
                mounted() {

                },
                name: 'Import Multisheet Modal',
                data: function () {
                    return {
                        title: 'Import Multi Sheets',
                        importId: '',
                        sourceUrl: '{!! url($import_src_url) !!}',
                        previewColumns: {!! json_encode($import_preview_cols) !!} ,
                        previewHeadings: {!! json_encode($import_preview_heads) !!} ,
                        uploadUrl: '{!! url($import_upload_multi_url) !!}',
                        commitUrl: '{!! url($import_commit_url) !!}'
                    };
                },
                methods: {
                    setImportId(id) {
                        this.importId = id;
                    },
                    commitData() {
                        var url = this.commitUrl + '?importid=' + this.importId;
                        return axios.post(url, {
                            params: {},
                            tz: window.tz
                        }).then(response => {
                            if (response.data.result == 'OK') {
                                this.hideModal();
                            }
                        }).catch(function (e) {
                            this.dispatch('error', e);
                            if(e.response.status == 401){
                                var d = new Date();
                                alert('Your session is expired. Please re-login');
                                window.location.href = '{{ url('login') }}?' + d.getTime() ;
                            }
                        });
                    },
                    openModal() {
                        this.$bvModal.show('uploadMultisheetItemModal');
                    },
                    hideModal() {
                        this.$bvModal.hide('uploadMultisheetItemModal');
                        tvm.loadTableData();
                    },

                }
            }).$mount('#uploadMultisheetModal');

            /**
             * Import Cell Mapped XLS
             * @type {this}
             */
            var imcmvm = new Vue({
                mounted() {

                },
                name: 'Import Cell Modal',
                data: function () {
                    return {
                        title: 'Import',
                        importId: '',
                        sourceUrl: '{!! url($import_src_url) !!}',
                        previewColumns: {!! json_encode($import_preview_cols) !!} ,
                        previewHeadings: {!! json_encode($import_preview_heads) !!} ,
                        uploadUrl: '{!! url($import_upload_url) !!}',
                        commitUrl: '{!! url($import_commit_url) !!}'
                    };
                },
                methods: {
                    setImportId(id) {
                        this.importId = id;
                    },
                    commitData() {
                        var url = this.commitUrl + '?importid=' + this.importId;
                        return axios.post(url, {
                            params: {},
                            tz: window.tz
                        }).then(response => {
                            if (response.data.result == 'OK') {
                                this.hideModal();
                            }
                        }).catch(function (e) {
                            this.dispatch('error', e);
                            if(e.response.status == 401){
                                var d = new Date();
                                alert('Your session is expired. Please re-login');
                                window.location.href = '{{ url('login') }}?' + d.getTime() ;
                            }
                        });
                    },
                    openModal() {
                        this.$bvModal.show('uploadCellItemModal');
                    },
                    hideModal() {
                        this.$bvModal.hide('uploadCellItemModal');
                        tvm.loadTableData();
                    },

                }
            }).$mount('#uploadCellModal');

            /**
             * Workflow VM
             * @type {this}
             */
            var wfvm = new Vue({
                mounted() {
                    bus.$on('makeApprovalRequest', (payload) => {
                        console.log('requestdecision', payload);
                        this.doc = payload;
                        this.openRequestDecisionModal();
                    });

                    bus.$on('makeDecision', (payload) => {
                        console.log('decision', payload);
                        this.doc = payload;
                        this.openDecisionModal();
                    });

                    window.dispatchEvent(new Event('resize'));
                },
                name: 'Workflow Modal',
                data: function () {
                    return {
                        itemId: '',
                        handle: '',
                        modalSize: 'lg',
                        modalClass: '',
                        autosave: false,
                        isLoading: false,

                        requestNote: '',
                        approverList: [],

                        requestData : {
                            'requesterId':'{{ Auth::user()->_id ?? 'noid' }}',
                            'requesterName': '{{ Auth::user()->name ?? 'noname'}}',
                            'requestNote' : '',
                            'requestApprovers': [],
                            'timestamp' : null,
                            'note' : '',
                            'authorization': '',
                            'authorizationSign' : '{{ Auth::user()->signatureSpecimen ?? '' }}'
                        },


                        doc: {},
                        entity: '{{ $entity }}',

                        approverList : [],

                        reviewDescription :'',
                        decision : {
                            'approverId':'{{ Auth::user()->_id ?? 'noid' }}',
                            'approverName': '{{ Auth::user()->name ?? 'noname' }}',
                            'decision' : '',
                            'timestamp' : null,
                            'note' : '',
                            'authorization': '',
                            'authorizationSign' : ''
                        }
                    };
                },
                computed: {
                },
                methods: {
                    commitRequestDecision(event){
                        event.preventDefault();

                        if(this.requestData.authorizationSign == ''){
                            alert('Please sign and save your signature');
                            return;
                        }

                        if(this.requestData.authorization.length < 6){
                            alert('PIN should be 6 digit number');
                            return;
                        }

                        this.isLoading = true;

                        var requestObj = {
                            doc : this.doc,
                            entity : this.entity,
                            requestData : this.requestData,
                            commitUrl : '{{ url( $approval_commit_url ) }}'
                        };

                        axios.post('{{ url( $approval_request_url ) }}',
                                {
                                    data: requestObj,
                                    tz: window.tz
                                }
                            )
                            .then((response) => {
                                this.isLoading = false;
                                if(response.data.result == 'OK' ){
                                    alert(response.data.message);
                                    this.hideRequestDecisionModal();
                                }else{
                                    alert(response.data.message);
                                }
                            })
                            .catch(function (error) {
                                console.log(error);
                                this.isLoading = false;
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }

                            });

                    },
                    getDecisionTitle(){
                        return 'Approval Review';
                    },
                    getRequestTitle(){
                        return 'Request for Approval ' + this.doc.{{ $wf_request_doc_id }};
                    },
                    requestDocId: function(){
                        return this.doc.{{ $wf_request_doc_id }};
                    },
                    requestDocTitle: function(){
                        return this.doc.{{ $wf_request_doc_title }};
                    },
                    requestDocDescription: function(){
                        return this.doc.{{ $wf_request_doc_desc }};
                    },
                    slugToTitle: function(val){
                        var str = this[val];
                        if(_.isString(str) && str != '' ){
                            var words = str.split('-').join(' ');
                            return titleCase(words);
                        }else{
                            return str;
                        }
                    },
                    commitDecision(event) {
                        event.preventDefault();

                        if(this.decision.authorizationSign == ''){
                            alert('Please sign and save your signature');
                            return;
                        }

                        if(this.decision.authorization.length < 6){
                            alert('PIN should be 6 digit number');
                            return;
                        }

                        this.isLoading = true;

                        var decisionData = {
                            doc : this.doc,
                            entity : this.entity,
                            decisionData : this.decision
                        };

                        axios.post('{{ url( $approval_commit_url ) }}',
                            {
                                data: decisionData,
                                tz: window.tz
                            }
                        )
                        .then((response) => {
                            this.isLoading = false;
                            if(response.data.result == 'OK' ){
                                alert(response.data.message);
                                this.hideDecisionModal();
                            }else{
                                alert(response.data.message);
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                            this.isLoading = false;
                            if(error.response.status == 401){
                                var d = new Date();
                                alert('Your session is expired. Please re-login');
                                window.location.href = '{{ url('login') }}?' + d.getTime() ;
                            }

                        });
                    },
                    loadApprovalParam(){
                            console.log('request approval');
                            axios.post('{{ url( $approval_param_url ) }}',
                                {
                                    tz: window.tz
                                }
                            )
                            .then((response) => {
                                this.isLoading = false;
                                if(response.data.result == 'OK' ){
                                    this.approverList = response.data.data.approvers;
                                }else{
                                    alert(response.data.message);
                                }
                            })
                            .catch(function (error) {
                                console.log(error);
                                this.isLoading = false;
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }

                            });
                    },
                    clearForm() {
                        this.itemId = '';
                        console.log("update form cleared");
                    },
                    busEmit(command,payload){
                        bus.$emit(command, payload );
                    },
                    shownDecisionModal(){
                        this.$refs.decisionSignPad.refreshCanvas();
                    },
                    openDecisionModal() {
                        this.handle = 'X' + _.random(1, 10000, false);
                        this.$bvModal.show('wfDecisionModal');
                    },
                    hideDecisionModal() {
                        this.$bvModal.hide('wfDecisionModal');
                    },
                    openRequestDecisionModal() {
                        this.handle = 'X' + _.random(1, 10000, false);
                        this.$bvModal.show('wfRequestDecisionModal');
                    },
                    hideRequestDecisionModal() {
                        this.$bvModal.hide('wfRequestDecisionModal');
                    },
                    iOnLoad(){
                        console.log('iframe loaded');
                        this.isLoading = false;
                    },
                    iOnLoadStart(){
                        console.log('iframe load start');
                        this.isLoading = true;
                    },
                    getTitle(){
                        return '{!! $view_title_fields ?? 'Print Preview' !!}';
                    }
                },
                watch: {

                },
                computed: {

                },
            }).$mount('#workFlowModal');

            /**
             * Table VM
             * @type {this}
             */
            var tvm = new Vue({
                mounted() {
                    @if( View::exists($table_event_view) )
                        @include($table_event_view)
                    @endif
                    bus.$on('copyToClipboard', (data) => {
                        console.log('copyclipboard', data);
                        this.$copyText(data).then(function (e) {
                            alert('Copied')
                            console.log(e)
                        }, function (e) {
                            alert('Can not copy')
                            console.log(e)
                        })
                    });

                    bus.$on('refreshTable', (data) => {
                        this.loadTableData();
                    });

                    bus.$on('exportdone', (data) => {
                        console.log('exportdone',data);
                        this.downloadDone = true;
                        this.processingQueue = false;
                    });

                    <?php
                        $qreq = \Illuminate\Http\Request::capture();
                        $qkey = $qreq->get('q');
                    ?>
                    this.$refs['vgt-table'].globalSearchTerm =  '{!! $qkey !!}' ;
                    this.serverParams.searchTerm = '{!! $qkey !!}';
                    this.loadTableData();
                    window.dispatchEvent(new Event('resize'));
                    setupTable();
                },
                name: 'Data Table Modal',
                data: function () {
                    return {
                    @if(strpos($yml_file, '_controller') === false)
                        {!! implode("\n", \App\Helpers\Util::loadResYaml('fields','views/dms/repository')->toVueDataModel('default') ) !!}
                    @else
                        {!! implode("\n", \App\Helpers\Util::loadResYaml('fields','views/dms/repository')->addData($data)->toVueDataList() ) !!}
                    @endif
                        openSearch : false,
                        withAdvancedSearch : {{ $with_advanced_search ? 'true': 'false' }},
                        tz : window.tz,
                        pdfLightBoxVisible: false,
                        pdfDocUrl: '',
                        showProgress: false,
                        selectedRows: [],
                        rows: [],
                        selectedApprovalStatus: [],
                        approvalStatusList: {!! json_encode(config('util.approval_status_list')) !!},
                        keywords: {
                            keyword0: '{!! $keyword0 !!}',
                            keyword1: '{!! $keyword1 !!}',
                            keyword2: '{!! $keyword2 !!}'
                        },
                        modalBusy : false,
                        downloadAllDisabled : false,
                        downloadMethod : 'all',
                        downloadFields : 'all',
                        downloadType : 'xls',
                        downloadList : [],
                        downloadTotal : 0,
                        downloadChunk : {{ intval( config('util.download_qty')) ?? 10000 }},
                        downloadDone : false,
                        processingQueue : false,

                        columns: {!! json_encode( $table_column ) !!},
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
                                btn_text: '<i class="fa fa-trash"></i> Del Selection',
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
                        @if(isset($can_multi_select) && $can_multi_select == true )
                            checkbox_rows: true,
                        @else
                            checkbox_rows: false,
                        @endif
                            rows_selectable: false,
                            card_mode: false,
                            card_title: "Vue Bootsrap 4 advanced table",
                            num_of_visible_pagination_buttons: 7, // default 5
                            per_page: {{ env('TABLE_PER_PAGE', 100) }}, // default 10,
                            per_page_options: [10, 25, 50, 100, 150, 200],
                        },
                        queryParams: {
                            sort: [],
                            filters: [],
                            global_search: "",
                            extra_data: this.extraData,
                            keywords: this.keywords,
                            per_page: {{ env('TABLE_PER_PAGE', 100) }},
                            page: 1
                        },
                        extraData: {!! json_encode($extra_query) !!},
                        total_rows: 0,
                        date_range_query: '',

                        /* temp selection object for data passing */
                        selectedRow: {},

                        /* ant-vue-table */
                        selectedRowKeys: [],

                        /* vue good table */
                        isLoading: false,
                        totalRecords: 0,
                        serverParams: {
                            columnFilters: {},
                            sort: {
                                field: '',
                                type: '',
                            },
                            page: 1,
                            perPage: {{ env('TABLE_PER_PAGE', 100) }}
                        },
                        paginationOptions: {
                            enabled: true,
                            mode: 'records',
                            perPage: {{ env('TABLE_PER_PAGE', 100) }},
                            position: 'top',
                            perPageDropdown: [10, 25, 50, 100, 150, 200, 500, 1000],
                            dropdownAllowAll: false,
                            setCurrentPage: 1,
                            nextLabel: 'NEXT',
                            prevLabel: 'PREV',
                            rowsPerPageLabel: 'Records per page',
                            ofLabel: 'of',
                            pageLabel: 'page', // for 'pages' mode
                            allLabel: 'All',
                        },
                        selectOptions: {
                        @if(isset($can_multi_select) && $can_multi_select == true)
                            enabled: true,
                        @else
                            enabled: false,
                        @endif
                            selectOnCheckboxOnly: true,
                        },
                        showClearButton: false,
                        searchOptions: {
                            enabled: true,
                            // skipDiacritics: true,
                            //searchFn: 'globalSearch',
                            trigger: '{{ env('SEARCH_TRIGGER', 'key-up') }}',
                            placeholder: 'Search records'
                            {{--externalQuery: searchQuery--}}
                        },
                    @if(isset($auxdata))
                        @foreach($auxdata as $k=>$v)
                            @if( is_array( $v ) )
                                {{ $k }}: {!! json_encode($v) !!} ,
                            @else
                                {{ $k }}: {!! $v !!},
                            @endif
                        @endforeach
                    @endif

                    }
                },
                watch: {
                    openSearch: (val)=>{
                        if(val){

                        }else{
                            this.extraData = {!! empty($extra_query) ? '{}' : json_encode($extra_query) !!};
                            this.$refs['vgt-table'].globalSearchTerm = '';
                            this.loadTableData();
                        }
                    },
                    downloadTotal: function(val){
                        if(parseInt(val) > 50000){
                            this.downloadAllDisabled = true;
                            this.downloadMethod = 'chunked';
                        }else{
                            this.downloadAllDisabled = false;
                        }
                    },
                    @if( View::exists($table_watch_view) )
                        @include($table_watch_view)
                    @endif
                },
                computed: {
                    @if( View::exists($table_computed_view) )
                    @include($table_computed_view)
                    @endif
                },
                methods: {
                    onChangeQuery(queryParams) {
                        this.queryParams = queryParams;
                        this.fetchData();
                    },
                    onSelectRow(rows) {
                        console.log(rows);
                        this.selectedRows = rows.selected_items;
                    },
                    onUnSelectRow(rows) {
                        console.log(rows);
                        this.selectedRows = rows.selected_items;
                    },
                    onSelectAllRow(rows) {
                        console.log(rows);
                        this.selectedRows = rows.selected_items;
                    },
                    onUnSelectAllRow(rows) {
                        console.log(rows);
                        this.selectedRows = rows.selected_items;
                    },
                    onCellClick(cell) {
                        console.log(cell);
                        if (cell.column.datatype == 'image'){
                            bus.$emit('openlightbox', [cell.row[cell.column.field]])
                        }
                        if (cell.column.datatype == 'imagearray'){
                            bus.$emit('openlightbox', cell.row[cell.column.field])
                        }
                    },
                    onRefreshData() {
                        this.fetchData();
                    },
                    onAdd() {
                        showAddModal();
                    },
                    needSigning(row){
                        var approvers = _.get( row, 'approverIdStr', false );
                        if(_.isString(approvers) && approvers != '' ){
                            if(  approvers.indexOf( '{{ Auth::user()->_id }}' ) == -1  ){
                                return false;
                            }else{
                                return true;
                            }
                        }else{
                            return false;
                        }
                    },
                    showAddModal() {
                        @if( $edit_as_page )
                            window.location.href = '{!! url($add_page_base) !!}';
                        @else
                            avm.getParam();
                            avm.openModal();
                            // $('#addModal').modal('show');
                        @endif
                    },
                    showUpdateModal(row) {
                        @if( $edit_as_page )
                            <?php
                                if($backlink != ''){
                                    $backlink = '?back='.$backlink;
                                }
                                ?>
                            window.location.href = '{!! url($edit_page_base) !!}/' + row._id + '{{ $backlink }}';
                        @else
                            console.log('update data',row);
                            uvm.title = row.name;
                            uvm.getItemData(row._id);
                            uvm.openModal();
                        @endif
                    },
                    showViewModal(row) {
                        vvm.setPrintItem(row);
                        vvm.setTitle(row.name);
                        vvm.getItemData(row._id);
                        vvm.openModal();
                    },
                    showUploadModal() {
                        var imid = _.random(1, 10000, false);
                        imvm.setImportId(imid);
                        imvm.openModal();
                    },
                    showUploadMultisheetModal() {
                        var imid = _.random(1, 10000, false);
                        immsvm.setImportId(imid);
                        immsvm.openModal();
                    },
                    showUploadCellModal() {
                        var imid = _.random(1, 10000, false);
                        imcmvm.setImportId(imid);
                        imcmvm.openModal();
                    },
                    makeApprovalRequest(row){
                        var payload = row;
                        bus.$emit('makeApprovalRequest', payload );
                    },
                    reviewDecision(row){
                        var payload = row;
                        bus.$emit('makeDecision', payload );
                    },
                    showPdf(url) {
                        this.pdfDocUrl = url;
                        this.pdfLightBoxVisible = true;
                    },
                    maxToday(date){
                        return maxToday(date);
                    },
                    titleCase(str){
                        if( !_.isNull(str) ){
                            var words = str.split('-').join(' ');
                            return titleCase(words);
                        }else{
                            return str;
                        }
                    },
                    sortArray( arr, criteria){
                        if(_.isArray(arr)){
                            return _.sortBy(arr , criteria);
                        }else{
                            return [];
                        }
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
                    prettyJson(json){
                        if (typeof json != 'string') {
                            json = JSON.stringify(json, undefined, 2);
                        }
                        if(json == ''){
                            return json;
                        }else{
                            return jsonFormater.format(json);
                        }
                    },
                    toSlug(val){
                        if(_.isString(val)){
                            return val.replace(/^\s+|\s+$|\s+(?=\s)/g, '').replace(/[^\w\s]/gi, '').split(' ').join('-').toLowerCase();
                        }else{
                            return val;
                        }
                    },
                    capitalize(str){
                        if(_.isString(str)){
                            return str.charAt(0).toUpperCase() + str.toLowerCase().slice(1).replace('_', ' ');
                        }else{
                            return str;
                        }
                    },
                    booleanVal(val){
                        if(_.isBoolean(val)){
                            return val;
                        }

                        if(_.isString(val)){
                            if(val == 'true'){
                                return true;
                            }else{
                                return false;
                            }
                        }else{
                            return Boolean(val);
                        }
                    },
                    busEmit(command,payload){
                        bus.$emit(command, payload );
                    },
                    fetchData() {
                        var self = this;
                        this.showProgress = true;
                        this.queryParams.extra_data = this.extraData;
                        axios.post('{{ url($dataurl) }}', {
                            params: {
                                "queryParams": this.queryParams,
                                "page": this.queryParams.page
                            },
                            action : 'LOAD_TABLE',
                            tz: window.tz
                        })
                        .then(response => {
                            self.rows = response.data.data;
                            self.total_rows = response.data.total;
                            this.showProgress = false;
                            this.$refs['vgt-table'].expandAll();
                        })
                        .catch(error => {
                            console.log(error);
                            this.showProgress = false;
                            if(error.response.status == 401){
                                var d = new Date();
                                alert('Your session is expired. Please re-login');
                                window.location.href = '{{ url('login') }}?' + d.getTime() ;
                            }
                        });
                    },
                    /* ant-vue-table */
                    onSelectChange(selectedRowKeys, selectedRows) {
                        console.log('selectedRow changed: ', selectedRows);
                        console.log('selectedRowKeys changed: ', selectedRowKeys);
                        this.selectedRowKeys = selectedRowKeys
                        this.selectedRows = selectedRows;
                    },

                    openAdvancedQuery(){
                        this.$bvModal.show('advancedSearchModal');
                    },
                    closeAdvancedQuery(event){
                        this.openSearch = true;
                        this.loadTableData();
                        this.$bvModal.hide('advancedSearchModal');
                    },
                    clearAdvancedQuery(event){
                        this.openSearch = false;
                        this.extraData = {!! empty($extra_query) ? '{}' : json_encode($extra_query) !!};
                        this.$refs['vgt-table'].globalSearchTerm = '';
                        this.serverParams.searchTerm = '';
                        this.loadTableData();
                        this.$bvModal.hide('advancedSearchModal');
                    },
                    shownAdvancedQuery(event){

                    },
                    hiddenAdvancedQuery(event){

                    },
                    printAdvancedQuery(event){

                    },
                    clearGlobalQuery(event){
                        this.extraData = {!! empty($extra_query) ? '{}' : json_encode($extra_query) !!};
                        this.$refs['vgt-table'].globalSearchTerm = '';
                        this.serverParams.searchTerm = '';
                        this.showClearButton = false;
                        this.loadTableData();
                    },

                    // upload & download data handler
                    uploadData(payload) {
                        showUploadModal();
                        console.log("Open upload form");
                    },

                    showDownloadDialog(payload){
                        this.downloadType = payload;
                        this.downloadTotal = this.selectedRows.length == 0 ? this.totalRecords : this.selectedRows.length;
                        this.$bvModal.show('downloadConfirmModal');

                    },
                    commitDownloadData(bvModalEvt){
                        bvModalEvt.preventDefault();
                        this.modalBusy = true;
                        this.downloadData(this.downloadType);
                    },
                    downloadData(payload) {

                        if (_.isString(payload)) {
                            var filetype = payload;
                            payload = this.serverParams;
                            _.set(payload, 'isGT', true);
                            _.set(payload, 'filetype', filetype);
                        } else {
                            var filetype = payload.event_payload.filetype;
                            _.set(payload, 'isGT', false);
                        }

                        this.downloadDone = false;
                        this.processingQueue = true;

                        axios.post('{{ url($downloadurl) }}', {
                            params: {
                                "queryParams": this.queryParams,
                                "payload": payload,
                                "selectedRows": this.selectedRows,
                                "downloadMethod": this.downloadMethod,
                                "downloadFields": this.downloadFields,
                                "downloadChunk": this.downloadChunk,
                                "totalRecords": this.downloadTotal
                            },
                            advancedSearch : { enable : this.withAdvancedSearch , isOpen : this.openSearch },
                            extraData : this.extraData,
                            tz: window.tz
                        })
                            .then((response)=> {
                                var data = response.data;
                                this.modalBusy = false;

                                if (data.status == 'OK') {

                                    //this.$bvModal.hide('downloadConfirmModal');

                                    if( data.multiple ){
                                        if (filetype == 'csv') {
                                            this.downloadList = data.urlcsvfiles;
                                        } else {
                                            this.downloadList = data.urlxlsfiles;
                                        }
                                        //this.$bvModal.show('downloadListModal');
                                    }else{
                                        if (filetype == 'csv') {
                                            this.downloadList.push(data.urlcsv);
                                            //window.location.href = data.urlcsv;
                                        } else {
                                            this.downloadList.push(data.urlxls);
                                            //window.location.href = data.urlxls;
                                        }
                                    }
                                }

                            })
                            .catch((error)=> {
                                console.log(error);
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }

                            });
                    },
                    clearDownloadList(){
                        this.downloadList = [];
                        this.downloadDone = false;
                        this.processingQueue = false;
                    },
                    downloadPrintXls(){
                        this.isLoading = true;
                        axios.post('{{ url( $downloadprinturl ?? 'api/v1/core/print/template' ) }}?q=' + this.itemId + '&id=' + this.cacheid,
                            {
                                data: this.printItemData,
                                serverParams: this.serverParams,
                                tz: window.tz
                            }
                        )
                            .then((response) => {
                                this.isLoading = false;
                                console.log('response',response);
                                if(response.data.status == 'OK' && response.data.urlxls != '' ){
                                    console.log('response ok',response);
                                    window.location.href = response.data.urlxls;
                                }
                            })
                            .catch((error) =>{
                                console.log(error);
                                this.isLoading = false;
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }

                            });
                    },
                    directPrintXls(){
                        this.isLoading = true;
                        axios.post('{{ url( $downloadsummaryurl ?? 'api/v1/core/print/template' ) }}?q={{ $print_summary_template }}&id=',
                            {
                                data: this.printItemData,
                                serverParams: this.serverParams,
                                tz: window.tz
                            }
                        )
                            .then((response) => {
                                this.isLoading = false;
                                console.log('response',response);
                                if(response.data.status == 'OK' && response.data.urlxls != '' ){
                                    console.log('response ok',response);
                                    window.location.href = response.data.urlxls;
                                }
                            })
                            .catch((error) =>{
                                console.log(error);
                                this.isLoading = false;
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }

                            });
                    },

                    // delete data handler

                    showDeleteModal(row) {
                        if (typeof row.event_payload === 'undefined') {
                            this.selectedRows.push(row);
                        }

                        console.log(this.selectedRows);

                        if (this.selectedRows.length > 0) {
                            cdvm.openConfirmDeleteModal();
                        }
                    },
                    showCloneModal(row) {
                        if (typeof row.event_payload === 'undefined') {
                            this.selectedRows.push(row);
                        }

                        console.log(this.selectedRows);

                        if (this.selectedRows.length > 0) {
                            cdvm.openConfirmCloneModal();
                        }
                    },
                    clearSelection() {
                        this.selectedRows = [];
                    },
                    getCurrentSelection() {
                        return this.selectedRows;
                    },
                    showApprovalStatusModal(){
                        if (this.selectedRows.length > 0) {
                            this.$bvModal.show('approvalStatusModal');
                        }else{
                            alert('No {{ $entity }} selected');
                        }
                    },
                    commitApprovalStatus(){

                        let data = this.selectedRows;

                        axios.post('{{ url($adminapprovalurl) }}', {
                            params: {
                                "data": data,
                                "status": this.selectedApprovalStatus
                            },
                            tz: window.tz
                        })
                        .then(response => {
                            var data = response.data;

                            if (data.status == 'OK') {
                                this.clearSelection();
                                console.log(this.selectedRows);
                                this.loadTableData();
                            }
                            this.$bvModal.hide('approvalStatusModal');

                        })
                        .catch(function (error) {
                            console.log(error);
                            if(error.response.status == 401){
                                var d = new Date();
                                alert('Your session is expired. Please re-login');
                                window.location.href = '{{ url('login') }}?' + d.getTime() ;
                            }
                        });

                    },
                    showResetRevLockModal(){
                        if (this.selectedRows.length > 0) {
                            this.$bvModal.show('resetLockModal');
                        }else{
                            alert('No {{ $entity }} selected');
                        }
                    },
                    commitResetRevLock(){
                        let data = this.selectedRows;

                        axios.post('{{ url($adminresetrevurl) }}', {
                            params: {
                                "data": data,
                                "status": this.selectedApprovalStatus
                            },
                            tz: window.tz
                        })
                        .then(response => {
                            var data = response.data;

                            if (data.status == 'OK') {
                                this.clearSelection();
                                console.log(this.selectedRows);
                                this.loadTableData();
                            }
                            this.$bvModal.hide('resetLockModal');

                        })
                        .catch(function (error) {
                            console.log(error);
                            if(error.response.status == 401){
                                var d = new Date();
                                alert('Your session is expired. Please re-login');
                                window.location.href = '{{ url('login') }}?' + d.getTime() ;
                            }
                        });
                    },
                    showReviseModal(row) {
                        if (typeof row.event_payload === 'undefined') {
                            this.selectedRows.push(row);
                        }

                        console.log(this.selectedRows);

                        if (this.selectedRows.length > 0) {
                            cdvm.openConfirmReviseModal();
                        }
                    },
                    confirmReviseData(){
                        let data = this.selectedRows;

                        axios.post('{{ url($cloneurl) }}', {
                            params: {
                                "data": data,
                                "type" : 'revision'
                            },
                            tz: window.tz

                        })
                            .then(response => {
                                var data = response.data;

                                if (data.result == 'OK') {
                                    this.clearSelection();

                                    console.log('revision',data.data);

                                    var row = data.data.data;
                                    row.isRevision = true;
                                    this.showUpdateModal(row)
                                    this.loadTableData();
                                }
                                cdvm.hideConfirmReviseModal();
                            })
                            .catch(function (error) {
                                console.log(error);
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }
                            });

                    },
                    confirmCloneData() {
                        let data = this.selectedRows;

                        axios.post('{{ url($cloneurl) }}', {
                            params: {
                                "data": data,
                                "type" : 'clone'
                            },
                            tz: window.tz
                        })
                            .then(response => {
                                var data = response.data;

                                if (data.result == 'OK') {
                                    this.clearSelection();
                                    console.log(this.selectedRows);
                                    this.loadTableData();
                                }
                                cdvm.hideConfirmCloneModal();

                            })
                            .catch(function (error) {
                                console.log(error);
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }
                            });

                    },

                    printItem(item, templateName, modalSize = 'lg', modalClass = '' ){
                        let data = [item];
                        var payload = {
                            ns: 'default',
                            obj: data,
                            multi: false,
                            modalClass: modalClass,
                            modalSize: modalSize,
                            showSelect: false,
                            defaultTemplate: templateName,
                            serverParams: this.serverParams
                        };
                        //console.log(data);
                        bus.$emit('printitem', payload );
                    },
                    printSelected(){
                        let data = this.selectedRows;
                        var payload = {
                            ns: 'default',
                            obj: data,
                            multi: false,
                            modalClass: '{{ $print_modal_class }}',
                            modalSize: '{{ $print_modal_size }}',
                            showSelect: false,
                            serverParams: this.serverParams,
                            @if(is_string($print_template))
                            defaultTemplate: '{{ $print_template }}'
                            @endif
                        };
                        //console.log(data);
                        bus.$emit('printitem', payload );
                    },
                    printSelectedTemplate(template, modal_size){
                        let data = this.selectedRows;
                        var payload = {
                            ns: 'default',
                            obj: data,
                            multi: false,
                            modalClass: '{{ $print_modal_class }}',
                            modalSize: modal_size,
                            showSelect: false,
                            serverParams: this.serverParams,
                            defaultTemplate: template
                        };
                        //console.log(data);
                        bus.$emit('printitem', payload );
                    },
                    confirmDelete() {
                        let data = this.selectedRows;

                        axios.post('{{ url($delurl) }}', {
                            params: {
                                "data": data
                            },
                            tz: window.tz

                        })
                        .then(response => {
                            var data = response.data;

                            if (data.status == 'OK') {
                                tvm.clearSelection();
                                console.log(this.selectedRows);
                                tvm.loadTableData();
                            }
                            cdvm.hideConfirmDeleteModal();

                        })
                        .catch(function (error) {
                            console.log(error);
                            if(error.response.status == 401){
                                var d = new Date();
                                alert('Your session is expired. Please re-login');
                                window.location.href = '{{ url('login') }}?' + d.getTime() ;
                            }
                        });
                    },
                    sumColumn(collection, fieldname){
                        console.log('scCol', collection);
                        if(_.isArray(collection)){
                            var items = collection.map( it => { return it[fieldname] } );
                            var total = items.reduce( ( prev, curr) => {
                                if(_.isString(curr)){
                                    var item = curr.replace( /,|\./gi , '');
                                }else{
                                    var item = curr;
                                }
                                return prev + parseFloat(item);
                            }, 0 );
                            console.log(total);
                            return total;
                        }else {
                            return null;
                        }
                    },
                    colorizeStatus(status){
                        if(_.isString(status)){
                            return 'status-' + status.toLowerCase();
                        }
                        else {
                            return '';
                        }
                    },
                    formatDate(dt) {
                        return formatDate(dt);
                    },
                    formatTime(dt) {
                        return formatTime(dt);
                    },
                    formatDateTime(dt) {
                        return formatDateTime(dt);
                    },
                    formatDateTimeUTC(dt) {
                        return formatDateTimeUTC(dt);
                    },
                    formatMonth(dt) {
                        return formatMonth(dt);
                    },
                    formatCurrency(val, neg = false){
                        val = parseFloat(val);
                        if(neg){
                            val = -val ;
                        }
                        return accounting.formatMoney( val , '' ,2, '.', ',', this.accFormat);
                    },
                    goToLink(url) {
                        console.log(url);
                        goToUrl(url);
                    },
                    isExist(val){
                        return !( _.isNull(val) || _.isUndefined(val))
                    },
                    imageUrl(file) {
                        console.log(file);
                        if (_.isEmpty(file) || _.get(file, 'url') == '') {
                            return '{{ url( env( "DEFAULT_THUMBNAIL" ) ) }}';
                        } else {
                            return file.base + file.url;
                        }
                    },
                    emptySub(str, sub = '-'){
                        return str ?? sub;
                    },
                    imageCount(files) {
                        if (_.isEmpty(files)) {
                            return '';
                        } else {
                            return files.length + ' photos';
                        }
                    },
                    imageUrls(files) {
                        console.log(files);
                        var defUrl = '{{ url( env( "DEFAULT_THUMBNAIL" ) ) }}';
                        if (_.isEmpty(files)) {
                            var imageThumb = {
                                src: defUrl, // origin image source
                                thumbnailSrc: defUrl, // thumbnail source
                                width: '150px', // thumbnail width
                                height: 'auto', // thumbnail height
                                name: 'No Image', // Image name which shows in footer
                                class: 'img-thumbnail'
                            };
                            return [imageThumb];
                        } else {
                            var images = [];
                            _.forEach(files, img => {
                                if (_.isEmpty(img) || _.get(img, 'url') == '') {
                                    //images.push( defUrl );
                                } else {
                                    var imageThumb = {
                                        src: img.base + img.url, // origin image source
                                        thumbnailSrc: img.base + img.url, // thumbnail source
                                        width: '150px', // thumbnail width
                                        height: 'auto', // thumbnail height
                                        name: img.filename, // Image name which shows in footer
                                        class: 'img-thumbnail'
                                    };

                                    images.push(imageThumb);
                                }
                            });
                            return images;
                        }
                    },

                    /* vue good table*/
                    updateParams(newProps) {
                        this.serverParams = Object.assign({}, this.serverParams, newProps);
                        if(this.serverParams.searchTerm != ''){
                            this.showClearButton = true;
                        }else{
                            this.showClearButton = false;
                        }
                    },

                    onPageChange(params) {
                        this.updateParams({page: params.currentPage});
                        this.loadTableData();
                    },

                    onPerPageChange(params) {
                        this.updateParams({perPage: params.currentPerPage});
                        this.loadTableData();
                    },

                    onSortChange(params) {
                        console.log('sortParams', params);
                        this.updateParams({
                            sort: params,
                        });
                        this.loadTableData();
                    },

                    onColumnFilter(params) {
                        this.updateParams(params);
                        this.loadTableData();
                    },

                    onGlobalSearch(params) {
                        console.log('VGT global search');
                        this.updateParams(params);
                        _.debounce(this.loadTableData(), 100);
                    },
                    generateRandomString(length=6){
                        return Math.random().toString(20).substr(2, length);
                    },
                    // load items is what brings back the rows from server
                    loadTableData() {
                        console.log('VGT load table data');
                        this.isLoading = true;
                        this.serverParams.advancedSearch = { enable : this.withAdvancedSearch , isOpen : this.openSearch };
                        this.serverParams.extraData = this.extraData;
                        this.serverParams.keywords = this.keywords;
                        this.serverParams.tz = window.tz;
                        this.serverParams.action = 'LOAD_TABLE';
                        this.serverParams.echo = this.generateRandomString(5);
                        axios.post('{{ url($dataurl) }}',
                            this.serverParams)
                            .then(response =>{
                                console.log(response);
                                if(response.status == 200){
                                    if(response.data.echo == this.serverParams.echo){
                                        this.rows = response.data.data;
                                        this.totalRecords = response.data.total;
                                    }
                                }else if(response.status == 401){
                                    alert('Your session is expired. Please re-login');
                                }
                                this.isLoading = false;
                            })
                            .catch(error => {
                                this.isLoading = false;
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }
                            });

                    },
                    pageChange(page){
                        this.serverParams.page = page;
                        this.loadTableData();
                    },
                    handleTableChange(pagination, filters, sorter) {

                        //this.serverParams.page = pager.current;

                        console.log( pagination );
                        console.log( filters );
                        console.log( sorter );
                        console.log( this.serverParams );

                        this.serverParams.page = pagination.current;
                        this.serverParams.perPage = pagination.pageSize;
                        this.loadTableData();
                    },
                    saveSplit(str){
                        if(_.isString(str)){
                            if(_.isString(str) != ''){
                                var arr = str.split(',');
                                if( _.isArray(arr) ){
                                    return arr
                                } else {
                                    return []
                                }
                            }
                        }else{
                            return []
                        }
                    },
                    splitExtract(str, delim, idx){
                        if(_.isString(str) && _.isString(delim)){
                            var arr = str.split(delim);
                            return arr[idx]?arr[idx]:'';
                        }else{
                            return '';
                        }
                    },
                    onSelectionChanged(sel){
                        console.log(sel);
                        this.selectedRows = sel.selectedRows;
                        console.log(this.selectedRows);
                    },

                    @if( View::exists($table_methods_view) )
                        @include($table_methods_view)
                    @endif

                }
            }).$mount('#app');

            function setupTable(){
                console.log('table mounted');
            }

            function loadTabledata(){
                tvm.loadTabledata();
            }

            function goToUrl(url) {
                window.location.href = url;
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

    <style>
        .vbt-checkbox: {
            margin-top: 8px !important;
        }
    </style>

    <link href="{{ url('/') }}/css/table_framework.css" rel="stylesheet">

@endsection

@section('content')
    @if( $table_component == 'vue-good-table')

    @else
        <div class="row">
            <div class="col-md-12">
                @if( View::exists($extra_view) )
                    @include($extra_view, $extra_view_params)
                @endif
            </div>
            <div class="col-md-12">
                @if( !$table_component == 'vue-good-table')
                    <span v-if="showProgress" class="loader">
                        <b-spinner label="Spinning"></b-spinner> Loading...
                    </span>
                @endif
            </div>
        </div>
    @endif

    <div class="">

        @if( $table_component == 'full-calendar')
            <div class="container-fluid">
                <a-calendar >
                </a-calendar>
            </div>
        @endif

    @if( $table_component == 'grid-view')
            <div style="width: 100%;display: table;">
                <b-pagination
                    v-model="currentPage"
                    pills
                    align="right"
                    :total-rows="totalRecords"
                    :per-page="{{ env('TABLE_PER_PAGE', 100) }}"
                    @change="pageChange"
                    >
                </b-pagination>
            </div>
            <a-spin :spinning="isLoading" size="large" >
                <div class="card-columns">
                    <div class="card" v-for="item in rows" >
                        @if( View::exists($grid_item_view) )
                            @include($grid_item_view)
                        @endif
                    </div>
                </div>

            </a-spin>
        @endif

        @if( $table_component != 'grid-view' && $table_component != 'full-calendar')
            <div class="card" >
                <div class="card-header" style="border-bottom: none;display:block;position:relative;height:fit-content;padding-top:8px;padding-right:16px;">
                    @if(env('ACTION_IN_TABLE', false) == false)
                        <div class="action-row d-flex justify-content-between align-items-center flex-wrap"
                             style="height:40px;position:relative;">
                            @if($with_advanced_search)
                                @if($table_advanced_search_type == 'dialog')
                                    <div class="" style="margin: 18px 8px;position: absolute;left: 0px;">
                                        <button @click="openAdvancedQuery" class="btn btn-outline-info  mb-2 mb-md-0" ><i class="fa fa-2x fa-search-plus"></i> Adv. Search</button>
                                        <span v-if="openSearch" class="btn mr-1 mb-2 mb-md-0" >@{{ totalRecords  }} found</span>
                                        {{--<span @click="printAdvancedQuery" v-if="openSearch" class="btn mb-2 mb-md-0" ><i class="fa fa-print"></i> Print</span>--}}
                                        <span @click="clearAdvancedQuery" v-if="openSearch" class="btn mb-2 mb-md-0" ><i class="fa fa-backspace"></i> Clear</span>
                                    </div>
                                @else
                                    <div class="" style="margin: 18px 0px;position: absolute;left: 0px;">
                                        <button @click="openSearch=!openSearch" class="btn mr-2 mb-2 mb-md-0" :class="openSearch ? ' btn-danger': ' btn-outline-info' " ><i class="fa fa-2x fa-search-plus"></i> @{{ openSearch?'Close':'Open' }} Advanced Search</button>
                                    </div>
                                @endif

                            @endif

                            <div style="margin: 18px 0px;position: absolute;right: 0px;">
                                <div style="display:inline-block;width:fit-content;margin-right: 16px;">
                                    @if( View::exists($table_additional_view) )
                                        @include($table_additional_view)
                                    @endif
                                </div>
                                @if($can_add)
                                    <button type="button"
                                            @click="showAddModal()"
                                            class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                                        <i class="btn-icon-prepend" data-feather="plus"></i> {{ $entity }}
                                    </button>
                                @endif
                                @if($can_print && !(is_null($print_template) ) )
                                    @if(is_array($print_template) && count($print_template) > 0)
                                        <b-dropdown text="Print" variant="outline-primary" class="d-none d-md-inline-block" style="padding: 8px;" no-caret>
                                            <template #button-content>
                                                <i class="fa fa-print"></i> Print
                                                <i class="fa fa-caret-down ml-2"></i>
                                            </template>
                                            @foreach($print_template as $pt)
                                                <b-dropdown-item href="#"
                                                                 @click="printSelectedTemplate('{{ $pt['template'] }}', '{{ $pt['modal'] }}')"
                                                >
                                                    <i class="fa fa-print"></i> {{$pt['label']}}
                                                </b-dropdown-item>
                                            @endforeach
                                        </b-dropdown>
                                    @elseif(is_string($print_template) && $print_template != '' )
                                        <button type="button"
                                                @click="printSelectedTemplate('{{ $print_template }}', '{{ $print_modal_size?? 'xl' }}'  )"
                                                class="btn btn-outline-primary btn-icon-text ml-2 mb-2 mb-md-0 d-none d-md-inline-block">
                                            <i class="fa fa-print"></i> Print
                                        </button>
                                    @endif
                                @endif

                                @if($can_multi_clone)
                                    <button type="button"
                                            @click="showCloneModal(false)"
                                            class="btn btn-primary btn-icon-text ml-2 mb-2 mb-md-0 d-none d-md-inline-block">
                                        <i class="btn-icon-prepend" data-feather="copy"></i>
                                        Clone
                                    </button>
                                @endif
                                @if($can_multi_delete)
                                    <button type="button"
                                            @click="showDeleteModal(false)"
                                            class="btn btn-danger btn-icon-text ml-2 mb-2 mb-md-0 d-none d-md-inline-block">
                                        <i class="btn-icon-prepend" data-feather="trash"></i>
                                        Del
                                    </button>
                                @endif

                                @if($can_upload)
                                    @if(env('ADVANCED_UPLOAD', false) == false)
                                        <button type="button"
                                                @click="showUploadModal()"
                                                class="btn btn-outline-primary btn-icon-text ml-2 mb-2 mb-md-0 d-none d-md-inline-block">
                                            <i class="las la-upload"></i> XLS
                                        </button>
                                    @else
                                        <b-dropdown text="Upload" variant="outline-primary" small no-caret
                                                    class="d-none d-md-inline-block"
                                        >
                                            <template #button-content>
                                                <i class="btn-icon-prepend" style="width:15px;height:15px;" data-feather="upload"></i> XLS
                                                <i class="fa fa-caret-down ml-2"></i>
                                            </template>
                                            <b-dropdown-item
                                                @click="showUploadModal()"
                                            >
                                                <i class="btn-icon-prepend" data-feather="upload"></i>
                                                One sheet XLS
                                            </b-dropdown-item>
                                            <b-dropdown-item
                                                @click="showUploadMultisheetModal()"
                                            >
                                                <i class="btn-icon-prepend" data-feather="upload"></i>
                                                Multi sheet XLS
                                            </b-dropdown-item>
                                            <b-dropdown-item
                                                @click="showUploadCellModal()"
                                            >
                                                <i class="btn-icon-prepend" data-feather="upload"></i>
                                                Cell Based XLS
                                            </b-dropdown-item>
                                        </b-dropdown>
                                    @endif
                                @endif
                                @if($can_download_xls || $can_download_csv )
                                <b-dropdown text="Download" variant="outline-primary" small no-caret class="ml-2 d-none d-md-inline-block" >
                                    <template #button-content>
                                        <i class="btn-icon-prepend" style="width:15px;height:15px;" data-feather="download-cloud"></i>
                                        <i class="fa fa-caret-down ml-2"></i>
                                    </template>
                                    @if($can_download_xls)
                                        <b-dropdown-item type="button"
                                                         @click="showDownloadDialog('xls')">
                                            <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                                            XLS
                                        </b-dropdown-item>
                                    @endif
                                    @if($can_download_csv)
                                        <b-dropdown-item type="button"
                                                         @click="showDownloadDialog('csv')">
                                            <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                                            CSV
                                        </b-dropdown-item>
                                    @endif
                                    <b-dropdown-item type="button"
                                         @click="directPrintXls()">
                                        <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                                        XLS Summary
                                    </b-dropdown-item>
                                </b-dropdown>
                                @endif
                                @if(\App\Helpers\AuthUtil::isRoot() && env('WITH_ADMIN_ACTION'))
                                    <b-dropdown text="Admin Action" variant="outline-danger" small style="padding: 8px;" no-caret >
                                        <template #button-content>
                                            <i class="btn-icon-prepend" style="width:15px;height:15px;" data-feather="star"></i> Admin Action
                                        </template>
                                        @if($with_workflow)
                                        <b-dropdown-item
                                            @click="showApprovalStatusModal()"
                                        >
                                            <i class="btn-icon-prepend" data-feather="upload"></i>
                                            Set Approval Status
                                        </b-dropdown-item>
                                        <b-dropdown-item
                                            @click="showResetRevLockModal()"
                                        >
                                            <i class="btn-icon-prepend" data-feather="upload"></i>
                                            Reset Rev Lock
                                        </b-dropdown-item>
                                        @endif
                                    </b-dropdown>
                                @endif

                            </div>
                        </div>
                    @endif

                    @if( View::exists($table_modal_view) )
                        @include($table_modal_view)
                    @endif

                    @if( $with_advanced_search && $table_advanced_search_type == 'dialog')
                    <b-modal id="advancedSearchModal"
                             no-close-on-backdrop
                             no-close-on-esc
                             ok-title="Search"
                             cancel-title="Cancel & Clear"
                             @ok="closeAdvancedQuery()"
                             @cancel="clearAdvancedQuery()"
                             @hidden="hiddenAdvancedQuery()"
                             size="{{ $table_advanced_search_size ?? 'md' }}"
                             centered
                             scrollable
                             @shown="shownAdvancedQuery()"
                             title="Advanced Search - {{ $entity }}"
                             modal-class="modal-bv">

                            @if( View::exists($table_advanced_search_view) )
                                @include($table_advanced_search_view)
                            @endif

                    </b-modal>
                    @endif
                    <b-modal id="downloadConfirmModal"
                             no-close-on-backdrop
                             no-close-on-esc
                             ok-title="Close"
                             ok-only
                             @hidden="clearDownloadList()"
                             size="md"
                             centered
                             scrollable
                             title="Download {{ $entity }}"
                             modal-class="modal-bv">
                        <template v-slot:modal-header-close >
                            <b-button size="sm" variant="outline-secondary" pill @click="close()"  >
                                <b-spinner small v-show="modalBusy" label="Loading..."></b-spinner>
                                <i v-show="!modalBusy" class="fa fa-times"></i>
                            </b-button>
                        </template>

                        <div class="row">
                            <div class="col-12">
                                <p>
                                    Total records to download : @{{ downloadTotal }} records
                                </p>
                                <p>
                                    <b>Records to download</b>
                                    <b-form-radio-group
                                        id="radio-group-download"
                                        v-model="downloadMethod"
                                        name="download-method"
                                        stacked
                                    >
                                        <b-form-radio value="all" :disabled="downloadAllDisabled" >Download all at once</b-form-radio>
                                        <b-form-radio value="chunked">Download as multiple file, <input type="number" class="form-control" name="downloadChunk" v-model="downloadChunk" /> records / file</b-form-radio>
                                    </b-form-radio-group>
                                </p>
{{--                                <p>--}}
{{--                                    <b>Fields to download</b>--}}
{{--                                    <b-form-radio-group--}}
{{--                                        id="radio-group-download-fields"--}}
{{--                                        v-model="downloadFields"--}}
{{--                                        name="download-fields"--}}
{{--                                    >--}}
{{--                                        <b-form-radio value="all">Data</b-form-radio>--}}
{{--                                        <b-form-radio value="id">id + Data</b-form-radio>--}}
{{--                                        <b-form-radio value="system">Data + system fields</b-form-radio>--}}
{{--                                        <b-form-radio value="table">Table visible only</b-form-radio>--}}
{{--                                    </b-form-radio-group>--}}
{{--                                </p>--}}

                                <b >Result @{{ downloadList.length }} files to download :</b>
                                <div><span v-if="processingQueue">Processing queue...</span><span v-if="downloadDone" >Done.</span></div>
                                <ul>
                                    <li v-for="url in downloadList">
                                        <a :href="url" target="_blank">@{{ url }}</a>
                                    </li>
                                </ul>
                                <button class="btn btn-primary mt-1 mb-2" style="width:100%;" @click="commitDownloadData" >
                                    <b-spinner small v-show="modalBusy" label="Loading..."></b-spinner>
                                    Generate Downloadables
                                </button>
                                <p class="mt-1">
                                    <b>Note :</b><hr>
                                    <ol>
                                        <li>
                                            Table pagination does not affect download quantity
                                        </li>
                                        <li>
                                            Result files can also be accessed through <b>Workflow > Organizer > <a href="{{ url('workflow/file-download') }}">Download History</a></b>
                                        </li>
                                    </ol>
                                </p>
                            </div>
                        </div>
                    </b-modal>

                    <b-modal id="downloadListModal"
                             no-close-on-backdrop
                             no-close-on-esc
                             ok-only
                             ok-title="Done"
                             size="lg"
                             centered
                             scrollable
                             title="Download List"
                             modal-class="modal-bv">
                        <div class="row">
                            <div class="col-12">
                                <b >@{{ downloadList.length }} files to download :</b>
                                <ul>
                                    <li v-for="url in downloadList">
                                        <a :href="url" target="_blank">@{{ url }}</a>
                                    </li>
                                </ul>
                                <p>
                                    <b>Note :</b><hr>
                                    These files can also be accessed through <b>Workflow > Organizer > <a href="{{ url('/') }}">File Downloads</a></b>
                                </p>
                            </div>
                        </div>
                    </b-modal>

                    <b-modal id="approvalStatusModal"
                             no-close-on-backdrop
                             no-close-on-esc
                             @ok="commitApprovalStatus()"
                             size="sm"
                             centered
                             scrollable
                             title="Change Approval Status"
                             modal-class="modal-bv">
                        <div class="row">
                            <div class="col-12">
                                @{{ selectedRows.length }} item(s) selected.<br/>
                                <b-form-select v-model="selectedApprovalStatus" :options="approvalStatusList"></b-form-select>
                            </div>
                        </div>
                    </b-modal>

                    <b-modal id="resetLockModal"
                             no-close-on-backdrop
                             no-close-on-esc
                             @ok="commitResetRevLock()"
                             size="sm"
                             centered
                             scrollable
                             title="Confirm Reset Revision Lock"
                             modal-class="modal-bv">
                        <div class="row">
                            <div class="col-12">
                                <p>
                                    @{{ selectedRows.length }} item(s) selected.<br/>
                                    Are you sure you want to reset revision lock of selected {{ $entity }} ?
                                </p>
                            </div>
                        </div>
                    </b-modal>

                </div>
                <div class="card-body row" style="padding-top:0px;">
                @if( $with_advanced_search && $table_advanced_search_type != 'dialog')
                    <div v-if="openSearch" class="col-3" style="padding-top: 60px;" >

                        @if( View::exists($table_advanced_search_view) )
                            @include($table_advanced_search_view)
                        @endif
                    </div>
                    <div :class="openSearch?'col-9':'col-12'">
                @else
                    <div class="col-12">
                @endif
                        <div class="table-responsive" style="overflow-y:hidden;padding-bottom: 0px;" >

                            @if( $table_component == 'kanban-board')
                                <kanban-board
                                    :items="kanbanItems"
                                    :users="kanbanUsers"
                                    :lanes="kanbanLanes"
                                    v-on:item-updated="kanbanItemUpdated"
                                    v-on:item-clicked="kanbanItemClicked"
                                    v-on:item-created="kanbanItemCreated">
                                    <template scope="props">
                                        <div class="kb-card-header" style="display:flex;flex:1;">
                                            <p class="kb-card-title"
                                                style="color: #464957;font-weight: 700;font-size: 16px;margin-top: 0;margin-bottom: 0;-webkit-box-flex: 1;-ms-flex: 1;flex: 1;">
                                                @{{ props.data.summary }}
                                            </p>
                                            <img style="width: 30px;height: 30px;"
                                                 class="kb-card-image rounded-circle" src="{{ Auth::user()->avatar }}"
                                                 onerror="this.onerror=null;this.src='{{ env('DEFAULT_AVATAR') }}';"
                                            >
                                        </div>
                                        <p class="kb-card-description">@{{ props.data.description }}</p>
                                        <div class="kb-card-footer">
                                            <span class="left"><i class="fa fa-check-circle"></i> 2/5</span>
                                            <span class="left"><i class="fa fa-comment"></i> 5</span>
                                            <span class="right"><i class="fa fa-clock-o"></i> Tomorrow</span>
                                        </div>
                                    </template>
                                </kanban-board>
                            @endif


                            @if( $table_component == 'ant-vue-table')
                                <a-table
                                    :columns="columns"
                                    :row-key="record => record._id"
                                    :data-source="rows"
                                    :pagination="{ total: totalRecords }"
                                    :loading="isLoading"
                                    :scroll="{ y: 650, x: 2500 }"
                                    :row-selection="{ selectedRowKeys: selectedRowKeys, onChange: onSelectChange }"
                                    @change="handleTableChange"
                                >
                                    <template slot="_id" slot-scope="text, record">
                                        <div>
                                            @if($show_actions)
                                                <b-dropdown dropright variant="border-transparent" no-caret>
                                                    <template v-slot:button-content>
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </template>
                                                    <b-dropdown-item href="#" @click="showViewModal(record)"><i
                                                            class="fa fa-eye"></i> View
                                                    </b-dropdown-item>
                                                    @if($can_update)
                                                        <b-dropdown-item href="#" @click="showUpdateModal(record)"><i
                                                                class="fa fa-edit"></i> Edit
                                                        </b-dropdown-item>
                                                    @endif

                                                    @if($can_print && !is_null($print_template) )
                                                        @if(is_array($print_template))
                                                            @if(count($print_template) == 1)
                                                                <b-dropdown-item href="#"
                                                                                 @click="printItem(record, '{{ $print_template[0]['template'] }}', '{{ $print_template[0]['modal'] }}'  )"
                                                                >
                                                                    <i class="fa fa-print"></i> {{$print_template[0]['label']}}
                                                                </b-dropdown-item>
                                                            @else
                                                                <b-dropdown text="Print" variant="outline-primary" class="m-2">
                                                                    @foreach($print_template as $pt)
                                                                        <b-dropdown-item href="#"
                                                                                         @click="printItem(record, '{{ $pt['template'] }}', '{{ $pt['modal'] }}'  )"
                                                                        >
                                                                            <i class="fa fa-print"></i> {{$pt['label']}}
                                                                        </b-dropdown-item>
                                                                    @endforeach
                                                                </b-dropdown>
                                                            @endif
                                                        @elseif(is_string($print_template) && $print_template != '')
                                                            <b-dropdown-item href="#"
                                                                             @click="printItem(record, '{{ $print_template }}', '{{ $print_modal_size }}'  )"
                                                            >
                                                                <i class="fa fa-print"></i> Print
                                                            </b-dropdown-item>
                                                        @endif

                                                    @endif

                                                    @if( View::exists($table_action_view) )
                                                        @include($table_action_view)
                                                    @endif

                                                    @if($can_revise)
                                                        <template v-if="record.revLock == 0 || _.isNull(record.revLock) || _.isUndefined(record.revLock )" >
                                                            <b-dropdown-divider></b-dropdown-divider>
                                                            <b-dropdown-item  v-if="record.revLock == 0" href="#"
                                                                              @click="showReviseModal(record)">
                                                                <i style="font-size: 12pt;" class="lar la-check-circle"></i>
                                                                Revise
                                                            </b-dropdown-item>
                                                        </template>
                                                    @endif

                                                    @if($can_request_approval)
{{--                                                        <b-dropdown-divider></b-dropdown-divider>--}}
{{--                                                        <b-dropdown-item href="#" @click="makeApprovalRequest(record)"><i--}}
{{--                                                                class="fa fa-copy"></i> Request Approval--}}
{{--                                                        </b-dropdown-item>--}}
                                                    @endif

                                                    @if($can_approve)
{{--                                                        <b-dropdown-divider></b-dropdown-divider>--}}
{{--                                                        <b-dropdown-item href="#" @click="reviewDecision(record)"><i--}}
{{--                                                                class="fa fa-copy"></i> Review Approval--}}
{{--                                                        </b-dropdown-item>--}}
                                                    @endif

                                                    @if($can_clone)
                                                        <b-dropdown-divider></b-dropdown-divider>
                                                        <b-dropdown-item href="#" @click="showCloneModal(record)"><i
                                                                class="fa fa-copy"></i> Clone
                                                        </b-dropdown-item>
                                                    @endif
                                                    @if($can_delete)
                                                        <b-dropdown-divider></b-dropdown-divider>
                                                        <b-dropdown-item href="#" @click="showDeleteModal(record)"><i
                                                                class="fa fa-trash"></i> Delete
                                                        </b-dropdown-item>
                                                    @endif
                                                </b-dropdown>
                                            @endif
                                        </div>
                                    </template>

                                    @if( View::exists($tableslotview) )
                                        @include($tableslotview)
                                    @endif

                                </a-table>

                            @endif

                            @if( $table_component == 'vue-good-table')
                                <vue-good-table
                                    ref="vgt-table"
                                    mode="remote"
                                    style-class="vgt-table striped"
                                    @on-page-change="onPageChange"
                                    @on-sort-change="onSortChange"
                                    @on-column-filter="onColumnFilter"
                                    @on-per-page-change="onPerPageChange"
                                    @on-selected-rows-change="onSelectionChanged"
                                    @on-search="onGlobalSearch"
                                    @on-cell-click="onCellClick"

                                    :line-numbers="true"
                                    @if($table_grouped)
                                    :group-options="{ enabled: true }"
                                    @endif
                                    :total-rows="totalRecords"
                                    :is-loading.sync="isLoading"
                                    :pagination-options="paginationOptions"
                                    :select-options="selectOptions"
                                    :search-options="searchOptions"
                                    :columns="columns"
                                    :rows="rows">

                                    <template slot="table-column" slot-scope="props">
                                        <template v-if="props.column.field == '_id'">
                                            &nbsp;
                                        </template>
                                        @if( View::exists($tableheadslotview) )
                                            @include($tableheadslotview)
                                        @endif
                                        <template v-else>
                                            @{{props.column.label}}
                                        </template>
                                    </template>
                                    <template slot="table-row" slot-scope="props">
                                        <template v-if="props.column.datatype == 'image'">
                                            <img v-if="!_.isEmpty(props.row[props.column.field])"
                                                 style="cursor:pointer;"
                                                 onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/blank.png' ) ) }}';"
                                                 :src="props.row[props.column.field]" class="img-thumbnail"/>
                                        </template>
                                        <template v-else-if="props.column.datatype == 'imagearray'">
                                            <img v-if="!_.isEmpty(props.row[props.column.field])"
                                                 style="cursor:pointer;"
                                                 onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/blank.png' ) ) }}';"
                                                 :src="_.isString(_.head(props.row[props.column.field]) )?_.head(props.row[props.column.field]) : _.get( _.head(props.row[props.column.field]) , 'url' ) " class="img-thumbnail"/>
                                        </template>
                                        <template v-else-if="props.column.datatype == 'currency'">
                                            @{{ accounting.formatMoney( parseFloat(props.row[props.column.field]) , '' ,2, '.', ',') }}
                                        </template>
                                        <template v-else-if="props.column.datatype == 'boolean' || props.column.datatype == 'bool'">
                                            <i class="far fa-1_5x fa-check-circle " :class="booleanVal(props.row[props.column.field]) ? 'status-approved': 'status-canceled'  "  ></i>
                                        </template>
                                        <template v-else-if="props.column.datatype == 'markdown'">
                                            <vue-markdown>@{{ props.row[props.column.field] }}</vue-markdown>
                                        </template>
                                        <template v-else-if="props.column.datatype == 'pre'">
                                            <pre v-html="props.row[props.column.field]" style="text-align:left; max-height: 300px;"></pre>
                                        </template>
                                        @if($show_actions)
                                        <template v-else-if="props.column.field == '_id'">
                                            <div>
                                                    @if($can_view)
                                                        <button class="btn btn-icon {{ !$show_more_actions ? 'd-sm-inline-block d-xs-inline-block':'d-none d-md-inline-block' }}" :class="needSigning(props.row)? 'bg-blue': '' "  :id="'popview-'+ props.row._id" href="#"
                                                            @if($viewer_as_document)
                                                                @click="printItem(props.row, '{{ $print_template }}', '{{ $print_modal_size?? 'xl' }}'   )"
                                                            @else
                                                                @click="showViewModal(props.row)"
                                                            @endif
                                                        >
                                                            <i :class="needSigning(props.row)? 'las la-pen-alt': 'far fa-eye' "></i>
                                                        </button>
                                                        <b-popover
                                                            :target="'popview-'+ props.row._id"
                                                            placement="top"
                                                            triggers="hover focus"
                                                            @if($viewer_as_document)
                                                                :content="needSigning(props.row) ? 'Sign Doc':'View Doc' "
                                                            @else
                                                                content="View"
                                                            @endif
                                                        ></b-popover>
                                                    @else
                                                         <button class="btn btn-icon disabled {{ !$show_more_actions ? 'd-sm-inline-block d-xs-inline-block':'d-none d-md-inline-block' }}"><i
                                                                class="far fa-eye"></i>
                                                        </button>
                                                    @endif


                                                    @if($with_workflow && $with_revision)
                                                        {{-- Workflow system--}}
                                                        @if($can_revise)
                                                            @if($can_update)
                                                                <template
                                                                    v-if="props.row.approvalStatus == 'APPROVED'"
                                                                >
                                                                    <button class="btn btn-icon {{ !$show_more_actions ? 'd-sm-inline-block d-xs-inline-block':'d-none d-md-inline-block' }}"
                                                                            :id="'poprevise-'+ props.row._id"
                                                                            v-if="parseInt(props.row.revLock) != 1"
                                                                            @click="showReviseModal(props.row)">
                                                                        <i style="font-size: 12pt;" class="lar la-check-circle"></i>
                                                                    </button>
                                                                    <button class="btn btn-icon disabled {{ !$show_more_actions ? 'd-sm-inline-block d-xs-inline-block':'d-none d-md-inline-block' }}"
                                                                            v-if="parseInt(props.row.revLock) == 1"
                                                                    >
                                                                        <i style="font-size: 12pt;" class="lar la-check-circle"></i>
                                                                    </button>

                                                                    <b-popover
                                                                        :target="'poprevise-'+ props.row._id"
                                                                        placement="top"
                                                                        triggers="hover focus"
                                                                        content="Revise"
                                                                    ></b-popover>

                                                                </template>
                                                                <template
                                                                    v-if="props.row.approvalStatus != 'APPROVED' || _.isUndefined(props.row.approvalStatus) "
                                                                >
                                                                    <button class="btn btn-icon {{ !$show_more_actions ? 'd-sm-inline-block d-xs-inline-block':'d-none d-md-inline-block' }}"
                                                                            :id="'popupdate-'+ props.row._id"
                                                                            @click="showUpdateModal(props.row)">
                                                                        <i class="far fa-edit"></i>
                                                                    </button>
                                                                    <b-popover
                                                                        :target="'popupdate-'+ props.row._id"
                                                                        placement="top"
                                                                        triggers="hover focus"
                                                                        content="Update"
                                                                    ></b-popover>
                                                                </template>
                                                            @else
                                                                <button class="btn btn-icon {{ !$show_more_actions ? 'd-sm-inline-block d-xs-inline-block':'d-none d-md-inline-block' }}"
                                                                        v-if="parseInt(props.row.revLock) != 1 && props.row.approvalStatus != 'APPROVED' "
                                                                        @click="showReviseModal(props.row)">
                                                                    <i style="font-size: 12pt;" class="lar la-check-circle"></i>
                                                                </button>
                                                                <button class="btn btn-icon disabled {{ !$show_more_actions ? 'd-sm-inline-block d-xs-inline-block':'d-none d-md-inline-block' }}"
                                                                        v-else >
                                                                    <i style="font-size: 12pt;" class="lar la-check-circle"></i>
                                                                </button>
                                                            @endif
                                                        @else
                                                            @if($can_update)
                                                                <button class="btn btn-icon disabled {{ !$show_more_actions ? 'd-sm-inline-block d-xs-inline-block':'d-none d-md-inline-block' }}"
                                                                        v-if="props.row.approvalStatus == 'APPROVED'" >
                                                                    <i class="far fa-edit"></i>
                                                                </button>
                                                                <button class="btn btn-icon {{ !$show_more_actions ? 'd-sm-inline-block d-xs-inline-block':'d-none d-md-inline-block' }}"
                                                                        v-else
                                                                        @click="showUpdateModal(props.row)">
                                                                    <i class="far fa-edit"></i>
                                                                </button>
                                                            @else
                                                                <button class="btn btn-icon disabled {{ !$show_more_actions ? 'd-sm-inline-block d-xs-inline-block':'d-none d-md-inline-block' }}" ><i
                                                                        class="far fa-edit"></i>
                                                                </button>
                                                            @endif
                                                        @endif
                                                    @else
                                                        {{-- Non workflow system--}}
                                                        @if($can_update)
                                                            <button class="btn btn-icon {{ !$show_more_actions ? 'd-sm-inline-block d-xs-inline-block':'d-none d-md-inline-block' }}" href="#" @click="showUpdateModal(props.row)" ><i
                                                                    class="far fa-edit"></i>
                                                            </button>
                                                        @else
                                                            {{--<button class="btn btn-icon disabled" ><i
                                                                    class="far fa-edit"></i>
                                                            </button> --}}
                                                        @endif

                                                    @endif

                                                    @if( $show_more_actions )

                                                            <b-dropdown
                                                                :id="'popmore-'+ props.row._id"
                                                                dropright no-flip class="btn btn-icon" boundary="scrollParent"
                                                                variant="border-transparent"
                                                                class="{{ $show_more_actions ? 'd-sm-inline-block d-xs-inline-block':'d-none d-md-inline-block' }}"
                                                                no-caret
                                                            >
                                                                <template v-slot:button-content>
                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                </template>

{{--                                                                @if($can_view)--}}
{{--                                                                    <b-dropdown-item class="d-md-none d-sm-inline-block d-xs-inline-block" :class="needSigning(props.row)? 'bg-blue': '' "--}}
{{--                                                                            href="#"--}}
{{--                                                                            @click="showViewModal(props.row)"--}}
{{--                                                                    >--}}
{{--                                                                        <i :class="needSigning(props.row)? 'las la-pen-alt': 'far fa-eye' "></i> {{ __('View') }}--}}
{{--                                                                    </b-dropdown-item>--}}
{{--                                                                @else--}}
{{--                                                                    <b-dropdown-item class="btn btn-icon disabled d-none d-md-inline-block"><i--}}
{{--                                                                            class="far fa-eye"></i> {{ __('View') }}--}}
{{--                                                                    </b-dropdown-item>--}}
{{--                                                                @endif--}}


{{--                                                                @if($can_update)--}}
{{--                                                                    <b-dropdown-item--}}
{{--                                                                        class="d-md-none d-sm-inline-block d-xs-inline-block" href="#" @click="showUpdateModal(props.row)" >--}}
{{--                                                                        <i class="far fa-edit"></i>  {{ __('Edit') }}--}}
{{--                                                                    </b-dropdown-item>--}}
{{--                                                                @else--}}
{{--                                                                    <b-dropdown-item--}}
{{--                                                                        class="disabled d-md-none d-sm-inline-block d-xs-inline-block" >--}}
{{--                                                                        <i class="far fa-edit"></i>  {{ __('Edit') }}--}}
{{--                                                                    </b-dropdown-item>--}}
{{--                                                                @endif--}}

                                                                @if($can_print && !(is_null($print_template) || $print_template == '') )
                                                                    @if(is_array($print_template) && count($print_template) > 0)
                                                                        @foreach($print_template as $pt)
                                                                            <b-dropdown-item href="#"
                                                                                             @click="printItem(props.row, '{{ $pt['template'] }}', '{{ $pt['modal'] }}'  )"
                                                                            >
                                                                                <i class="fa fa-print"></i> {{$pt['label']}}
                                                                            </b-dropdown-item>
                                                                        @endforeach
                                                                    @elseif(is_string($print_template))
                                                                        <b-dropdown-item href="#"
                                                                                         @click="printItem(props.row, '{{ $print_template }}', '{{ $print_modal_size?? 'xl' }}'  )"
                                                                        >
                                                                            <i class="fa fa-print"></i> {{ __('Print') }}
                                                                        </b-dropdown-item>
                                                                    @endif
                                                                @endif

                                                                @if($can_revise && $with_workflow)

                                                                    {{--                                                        <template v-if="parseInt(props.row.revLock) != 1 && props.row.approvalStatus != 'APPROVED' " >--}}
                                                                    {{--                                                            <b-dropdown-item  href="#" @click="showReviseModal(props.row)">--}}
                                                                    {{--                                                                <i class="fas fa-check-circle"></i> Revise--}}
                                                                    {{--                                                            </b-dropdown-item>--}}
                                                                    {{--                                                            <b-dropdown-divider></b-dropdown-divider>--}}
                                                                    {{--                                                        </template>--}}

                                                                @endif

                                                                @if($can_request_approval && $with_workflow)
{{--                                                                    <template--}}
{{--                                                                        v-if="props.row.approvalStatus != 'APPROVED' || _.isUndefined(props.row.approvalStatus) "--}}
{{--                                                                    >--}}
{{--                                                                        <b-dropdown-item href="#"--}}
{{--                                                                                         @click="makeApprovalRequest(props.row)"><i--}}
{{--                                                                                class="fas fa-clipboard-check"></i> Request Approval--}}
{{--                                                                        </b-dropdown-item>--}}

{{--                                                                        @if($can_approve)--}}
{{--                                                                            <div style="height: 8px;"></div>--}}
{{--                                                                        @else--}}
{{--                                                                            <b-dropdown-divider></b-dropdown-divider>--}}
{{--                                                                        @endif--}}
{{--                                                                    </template>--}}
                                                                @endif

                                                                @if($can_approve && $with_workflow)
{{--                                                                    <template--}}
{{--                                                                        v-if="props.row.approvalStatus != 'APPROVED' || _.isUndefined(props.row.approvalStatus) "--}}
{{--                                                                    >--}}
{{--                                                                        <b-dropdown-item href="#" @click="reviewDecision(props.row)"><i--}}
{{--                                                                                class="fas fa-signature"></i> Review Approval--}}
{{--                                                                        </b-dropdown-item>--}}
{{--                                                                        <b-dropdown-divider></b-dropdown-divider>--}}
{{--                                                                    </template>--}}
                                                                @endif

                                                                @if( View::exists($table_action_view) )

                                                                    @include($table_action_view)

                                                                @endif

                                                                @if($can_clone)
                                                                    <b-dropdown-divider></b-dropdown-divider>
                                                                    <b-dropdown-item href="#" @click="showCloneModal(props.row)"><i
                                                                            class="fas fa-clone"></i> Clone
                                                                    </b-dropdown-item>
                                                                @endif
                                                                @if($can_delete)
                                                                    <b-dropdown-divider></b-dropdown-divider>
                                                                    <b-dropdown-item href="#" @click="showDeleteModal(props.row)">
                                                                        <i class="fa fa-trash" style="color:red;" ></i> Delete
                                                                    </b-dropdown-item>
                                                                @endif
                                                            </b-dropdown>
                                                            <b-popover
                                                                :target="'popmore-'+ props.row._id"
                                                                placement="top"
                                                                triggers="hover focus"
                                                                content="More"
                                                            ></b-popover>

                                                    @else
                                                        <button class="btn btn-icon disabled" ><i
                                                                class="fa fa-ellipsis-v"></i>
                                                        </button>
                                                    @endif

                                            </div>
                                        </template>
                                        @endif
                                        @if( View::exists($tableslotview) )
                                            @include($tableslotview)
                                        @endif
                                        <template v-else>
                                            <template v-if="props.column.datatype == 'date'">
                                            <span v-if="!_.isEmpty(props.row[props.column.field])">
                                                @{{ formatDate(props.row[props.column.field]) }}
                                            </span>
                                            </template>
                                            <template v-else-if="props.column.datatype == 'datetime'">
                                            <span v-if="!_.isEmpty(props.row[props.column.field])">
                                                @{{ formatDateTime(props.row[props.column.field]) }}
                                            </span>
                                            </template>
                                            <template v-else>
                                                @{{ props.row[props.column.field] }}
                                            </template>
                                        </template>
                                    </template>

                                    <template slot="loadingContent" slot-scope="props">
                                        <b-spinner label="Spinning"></b-spinner>
                                        <br>Loading...
                                    </template>

                                    <template slot="table-actions">
                                    @if(env('ACTION_IN_TABLE', false))

                                        @if( View::exists($table_additional_view) )
                                            @include($table_additional_view)
                                        @endif

                                        @if($can_add)
                                            <button type="button"
                                                    @click="showAddModal()"
                                                    class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                                                <i class="btn-icon-prepend" data-feather="plus-circle"></i>
                                                {{ Str::singular($entity) }}
                                            </button>
                                        @endif

                                        @if($can_print && !is_null($print_template) )
                                            @if(is_array($print_template) && count($print_template) > 0)
                                                <b-dropdown text="Print Sel" variant="outline-primary" class="m-2" style="padding: 8px;" no-caret>
                                                    <template #button-content>
                                                        <i class="fa fa-print"></i> Print Sel
                                                    </template>
                                                    @foreach($print_template as $pt)
                                                        <b-dropdown-item href="#"
                                                                         @click="printSelectedTemplate('{{ $pt['template'] }}', '{{ $pt['modal'] }}')"
                                                        >
                                                            <i class="fa fa-print"></i> {{$pt['label']}}
                                                        </b-dropdown-item>
                                                    @endforeach
                                                </b-dropdown>
                                            @elseif(is_string($print_template) && $print_template != '')
                                                <button type="button"
                                                        @click="printSelectedTemplate('{{ $print_template }}', '{{ $print_modal_size?? 'xl' }}'  )"
                                                        class="btn btn-outline-primary btn-icon-text ml-2 mr-2 mb-2 mb-md-0 d-none d-md-inline-block">
                                                    <i class="fa fa-print"></i> Print
                                                </button>
                                            @endif
                                        @endif
                                        @if($can_multi_clone)
                                            <button type="button"
                                                    @click="showCloneModal(false)"
                                                    class="btn btn-primary btn-icon-text mr-2 mb-2 mb-md-0 d-none d-md-inline-block">
                                                <i class="btn-icon-prepend" data-feather="copy"></i>
                                                Clone
                                            </button>
                                        @endif
                                        @if($can_multi_delete)
                                            <button type="button"
                                                    @click="showDeleteModal(false)"
                                                    class="btn btn-danger btn-icon-text mr-2 mb-2 mb-md-0 d-none d-md-inline-block">
                                                <i class="btn-icon-prepend" data-feather="trash"></i>
                                                Del
                                            </button>
                                        @endif

                                        @if($can_upload)
                                            <b-dropdown text="Upload" variant="outline-primary" small style="padding: 8px;" no-caret class=" d-none d-md-inline-block" >
                                                <template #button-content>
                                                    <i class="btn-icon-prepend" style="width:15px;height:15px;" data-feather="upload"></i>
                                                    <i class="fa fa-caret-down ml-2"></i>
                                                </template>
                                                <b-dropdown-item type="button"
                                                                 @click="showUploadModal()">
                                                    <i class="btn-icon-prepend" data-feather="upload"></i>
                                                    XLS
                                                </b-dropdown-item>
                                                <b-dropdown-item type="button"
                                                                 @click="showUploadModal()">
                                                    <i class="btn-icon-prepend" data-feather="upload"></i>
                                                    CSV
                                                </b-dropdown-item>
                                            </b-dropdown>
                                        @endif
                                        @if($can_download_xls || $can_download_csv)
                                            <b-dropdown text="Download" variant="outline-primary" small style="padding: 8px;" no-caret class=" d-none d-md-inline-block" >
                                                <template #button-content>
                                                    <i class="btn-icon-prepend" style="width:15px;height:15px;" data-feather="download-cloud"></i>
                                                    <i class="fa fa-caret-down ml-2"></i>
                                                </template>
                                                @if($can_download_xls)
                                                <b-dropdown-item type="button"
                                                                 @click="showDownloadDialog('xls')">
                                                    <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                                                    XLS
                                                </b-dropdown-item>
                                                @endif
                                                @if($can_download_csv)
                                                <b-dropdown-item type="button"
                                                                 @click="showDownloadDialog('csv')">
                                                    <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                                                    CSV
                                                </b-dropdown-item>
                                                @endif
                                                <b-dropdown-item type="button"
                                                                 @click="showDownloadDialog('csv')">
                                                    <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                                                    XLS Summary
                                                </b-dropdown-item>
                                            </b-dropdown>
                                        @endif
                                    @endif

                                        <button type="button"
                                                style="margin-top:8px;"
                                                v-if="showClearButton"
                                                @click="clearGlobalQuery()"
                                                class="btn btn-outline-light btn-icon">
                                            <i class="fa fa-backspace"></i>
                                        </button>
                                        <button type="button"
                                                style="margin-top:8px;"
                                                @click="loadTableData()"
                                                class="btn btn-outline-light btn-icon">
                                            <i class="far fa-undo" data-feather="rotate-cw"></i>
                                        </button>
                                    </template>

                                </vue-good-table>
                            @endif


                        </div>
                    </div>

                </div>
                <div class="card-footer" style="text-align:right;">
                    @{{ ' tz: ' + tz }}
                </div>
            </div>

        @endif

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
    <span id="copyTemp"  style="display: none" ></span>

    <pdf-light-box
        ref="pdfLightBox"
        :show.sync="pdfLightBoxVisible"
        :doc-url="pdfDocUrl"
    >
@endsection


    <!-- Button trigger modal -->
@section('modal')
        <!-- Modal -->
            <div id="addModal">
                <b-modal id="addItemModal"
                         @if( $form_dialog_size == 'modal-fullscreen' || $form_dialog_size == 'fs' )
                            modal-class="modal-fullscreen"
                         @elseif( $form_dialog_size == 'md' || $form_dialog_size == '')
                            modal-class="modal-md"
                         @elseif( $form_dialog_size != '')
                            size="{{ $form_dialog_size }}"
                         @endif
                         no-close-on-backdrop
                         no-close-on-esc
                         centered
                         scrollable
                         @ok.prevent="addItem"
                         @shown="onShown"
                         @hidden="clearForm"
                         :title="getTitle()"
                         modal-class="modal-bv">
                    <template v-slot:modal-header="{ close }">
                        {!! $add_icon ?? '' !!}<span class="modal-title" v-html="getTitle()" ></span>
                        <!-- Emulate built in modal header close button action -->
                        <b-button size="sm" variant="outline-secondary" pill @click="close()">
                            <b-spinner small v-show="isLoading" label="Loading..."></b-spinner>
                            <i v-show="!isLoading" class="fa fa-times"></i>
                        </b-button>
                    </template>

                    <template v-slot:modal-footer >
                        <div style="display:inline-block;position:absolute;left: 10px;" :class="notificationClass"
                             v-html="notificationMessage" ></div>
                        <!-- Emulate built in modal header close button action -->
                        <button class="btn btn-alt-secondary" @click="cancelForm()">
                            Cancel
                        </button>
                        @if($non_saving_close)
                            <button class="btn btn-primary" pill @click="endSession()">
                                End Session
                            </button>
                        @else
                            @if( $non_closing_save )
                                <button class="btn btn-primary" pill @click="addItem('RESET')">
                                    Save & New
                                </button>
                            @endif
                            <button class="btn btn-primary" pill @click="addItem('CLOSE')">
                                Save
                            </button>
                        @endif

                    </template>

                    @if(env('SKIP_VALIDATION', true ))
                        @include( $form_view ,[ 'yml_file'=>$yml_file,'yml_layout_file'=>$yml_layout_file,'res_path'=>$res_path, 'is_create'=>true ])
                    @else
                        <validation-observer v-slot="{ invalid }" ref="add_veeObserver">
                            @include( $form_view ,[ 'yml_file'=>$yml_file,'yml_layout_file'=>$yml_layout_file,'res_path'=>$res_path, 'is_create'=>true ])
                        </validation-observer>
                    @endif
                </b-modal>
            </div>

            <div id="updateModal">
                <b-modal id="updateItemModal"
                         @if( $form_dialog_size == 'modal-fullscreen' || $form_dialog_size == 'fs' )
                             modal-class="modal-fullscreen"
                         @elseif( $form_dialog_size == 'md' || $form_dialog_size == '')
                             modal-class="modal-md"
                         @elseif( $form_dialog_size != '')
                             size="{{ $form_dialog_size }}"
                         @endif
                         no-close-on-backdrop
                         no-close-on-esc
                         centered
                         scrollable
                         @ok.prevent="updateItem"
                         @shown="onShown"
                         @hidden="clearForm"
                         :title="getTitle()"
                         modal-class="modal-bv">
                    <template v-slot:modal-header="{ close }">
                        {!! $edit_icon ?? '' !!}<span class="modal-title" v-html="getTitle()" ></span>
                        <!-- Emulate built in modal header close button action -->
                        <b-button size="sm" variant="outline-secondary" pill @click="close()">
                            <b-spinner small v-show="isLoading" label="Loading..."></b-spinner>
                            <i v-show="!isLoading" class="fa fa-times"></i>
                        </b-button>
                    </template>
                    <template v-slot:modal-footer >
                        <div style="display:inline-block;position:absolute;left: 10px;" :class="notificationClass" v-html="notificationMessage" ></div>
                        <!-- Emulate built in modal header close button action -->
                        <button class="btn btn-alt-secondary" @click="cancelForm()">
                            Cancel
                        </button>

                        @if($non_saving_close)
                            <button class="btn btn-primary" pill @click="endSession()">
                                End Session
                            </button>
                        @else
                            @if( $non_closing_save )
                                <button class="btn btn-primary" pill @click="updateItem('CONTINUE')">
                                    Save & Continue
                                </button>
                            @endif
                            <button class="btn btn-primary" pill @click="updateItem('CLOSE')">
                                Save
                            </button>
                        @endif
                    </template>

                    @if(env('SKIP_VALIDATION', true ))
                        @include( $form_view ,[ 'yml_file'=>$yml_file,'yml_layout_file'=>$yml_layout_file,'res_path'=>$res_path , 'is_create'=>false])
                    @else
                        <validation-observer v-slot="{ invalid }" ref="edit_veeObserver">
                            @include( $form_view ,[ 'yml_file'=>$yml_file,'yml_layout_file'=>$yml_layout_file,'res_path'=>$res_path , 'is_create'=>false])
                        </validation-observer>
                    @endif
                </b-modal>
            </div>

            <div id="viewModal">
                <b-modal id="viewItemModal"
                         @if( $viewer_dialog_size == 'modal-fullscreen' || $viewer_dialog_size == 'fs' )
                             modal-class="modal-fullscreen"
                         @elseif( $viewer_dialog_size == 'md' || $viewer_dialog_size == '')
                             modal-class="modal-md"
                         @elseif( $viewer_dialog_size != '')
                             size="{{ $viewer_dialog_size }}"
                         @endif
                         centered
                         scrollable
                         no-close-on-backdrop
                         @hidden="clearForm"
                         modal-class="modal-bv">

                    <template v-slot:modal-header="{ close }">
                        {!! $viewer_icon ?? '' !!}<h4 class="modal-title" v-html="getTitle()"></h4>
                        <!-- Emulate built in modal header close button action -->
                        <b-button size="sm" variant="outline-secondary" pill @click="close()">
                            <b-spinner small v-show="isLoading" label="Loading..."></b-spinner>
                            <i v-show="!isLoading" class="fa fa-times"></i>
                        </b-button>
                    </template>

                    <template v-slot:modal-footer >
                        &nbsp;
                        @if( $viewer_can_print )
                            <button class="btn btn-primary" pill @click="printSelected()">
                                Print
                            </button>
                        @endif
                    </template>


                    @include( $viewer_view ,[ 'yml_file'=>$yml_file,'yml_layout_file'=>$yml_layout_file,'res_path'=>$res_path, 'view_layout'=>$viewer_layout ,'is_create'=>false  ])

                </b-modal>
            </div>

            <div id="printModal">
                <b-modal id="printItemModal"
                    :modal-class="modalClass"
                    size="xl"
                    centered
                    no-close-on-backdrop
                    no-close-on-esc
                    @ok="printLabelContent"
                    ok-title="Print"
                    cancel-title="Close"
                    @hidden="iOnLoad"
                    @shown="iOnLoadStart"
                    modal-class="modal-bv"
                    :hide-footer="false"
                >
                    <template v-slot:modal-header="{ close }">
                        {!! $viewer_icon ?? '' !!}<span class="modal-title" >
                            <h4 style="margin-bottom: 0px;"  >View Document</h4>
                        </span>
                        <!-- Emulate built in modal header close button action -->
                        <b-button size="sm" variant="outline-secondary" pill @click="close()">
                            <b-spinner small v-show="isLoading" label="Loading..."></b-spinner>
                            <i v-show="!isLoading" class="fa fa-times"></i>
                        </b-button>
                    </template>

                    <template v-slot:modal-footer >
                        <button class="btn btn-outline-danger" pill @click="hideModal()">
                            <i class="fa fa-times" ></i> Close
                        </button>
                        @if( env('PRINT_AS_PDF') == false )
                            <button class="btn btn-primary" pill @click="printLabelContent()">
                                <i class="fa fa-print" ></i> Print
                            </button>
                        @endif
                        @if( $print_download_xls )
                            <button class="btn btn-primary" pill @click="downloadPrintXls()">
                                <i class="fa fa-download" ></i> Download XLS
                            </button>
                        @endif
                        @if( $can_approve )
                        <button v-show="requestSigning && ( doApproval == false)" class="btn btn-primary" pill @click="signing()">
                            <i class="las la-signature"></i> Sign This Document
                        </button>
                        <button v-show="requestSigning && ( doApproval == true)" class="btn btn-primary" pill @click="commitSigning()">
                            <i class="las la-signature"></i> Save Signature
                        </button>
                        @endif

                    </template>

                    @if(env('PRINT_AS_PDF'))
                    <div v-show="isLoading" style="display:block; text-align: center;" >
                        <b-spinner small v-show="isLoading" label="Creating PDF ..."></b-spinner>
                        Creating PDF ...
                    </div>
                    @endif

                    <div id="printedItemContentFrame" style="height: 100%; min-height: 600px;">
                        <iframe :src="printUrl" id="print-iframe"
                                v-on:load="iOnLoad"
                                @loaded="iOnLoad"
                                style="height:100%;width: 100%; min-height: 600px;border:none"></iframe>
                    </div>
                    <div v-if="doApproval">
                        <div class="row">
                            <div class="col-11"></div>
                            <div class="col-1">
                                <span class="btn btn-transparent" @click="closeApproval()" >
                                <i class="fa fa-times" ></i>
                                </span>
                            </div>
                        </div>
                        <div class="row pb-5" style="border-top: thin solid lightgrey;">
                            <div class="col-7">
                                <div v-if="decision.useSignature" class="row pl-5" >
                                    <div class="col-7 col-xs-12">
                                        <label class="ml-5">&nbsp;</label>
                                        <sign-pad
                                            ref="signaturePad"
                                            v-model="decision.authorizationSign"
                                            :specimen="decision.authorizationSignSpecimen"
                                            :handle="handle"
                                            ns="signature"
                                            uploadurl="{{ url( 'api/v1/core/form-upload' )  }}"
                                            mode="single"
                                            width="100%"
                                            height="250px"
                                        >
                                        </sign-pad>
                                    </div>
                                    <div class="col-5 col-xs-12">
                                        <label >Full Signature / Tanda Tangan</label>
                                        <image-card-upload
                                            name="signatureSpecimen"
                                            v-model="decision.authorizationSign"
                                            :handle="handle"
                                            ns="signatureSpecimen"
                                            uploadurl="{{ url( 'api/v1/core/upload' )  }}"
                                            :hide-upload-button="true"
                                            defaulturl="{{ url( 'images/default_256.jpg' )  }}"
                                            mode="single"
                                            bucket="signature"
                                            buttonlabel="Upload Signature"
                                        >
                                        </image-card-upload>

                                    </div>
                                </div>
                                <div v-if="decision.useInitial" class="row pl-5" >
                                    <div class="col-7 col-xs-12">
                                        <label class="ml-5">&nbsp;</label>
                                        <sign-pad
                                            ref="initialPad"
                                            v-model="decision.initialSign"
                                            :specimen="decision.initialSignSpecimen"
                                            :handle="handle"
                                            ns="signature"
                                            uploadurl="{{ url( 'api/v1/core/form-upload' )  }}"
                                            mode="single"
                                            width="100%"
                                            height="250px"
                                        >
                                        </sign-pad>
                                    </div>
                                    <div class="col-5 col-xs-12">
                                        <label >Initial Signature / Paraf</label>
                                        <image-card-upload
                                            name="signatureSpecimen"
                                            v-model="decision.initialSign"
                                            :handle="handle"
                                            ns="signatureSpecimen"
                                            uploadurl="{{ url( 'api/v1/core/upload' )  }}"
                                            :hide-upload-button="true"
                                            defaulturl="{{ url( 'images/default_256.jpg' )  }}"
                                            mode="single"
                                            bucket="signature"
                                            buttonlabel="Upload Paraf"
                                        >
                                        </image-card-upload>

                                    </div>
                                </div>
                            </div>
                            <div class="col-4 ml-5">
                                <label for="decision_note">Decision / Keputusan</label>
                                <b-form-group>
                                    <b-form-radio-group id="radio-group-decisionlist" v-model="decision.decision"
                                                        name="decisionlist">
                                        <b-form-radio class="col-12" value="APPROVED">Approved</b-form-radio><br>
                                        <b-form-radio class="col-12" value="REJECTED">Rejected</b-form-radio><br>
                                        @if( \App\Helpers\AuthUtil::isAdmin() )
                                        <b-form-radio class="col-12" value="RELEASED">Release</b-form-radio>
                                        @endif
                                    </b-form-radio-group>
                                </b-form-group>
                                <label for="decision_note">Catatan</label>
                                <textarea
                                    name="decision_note"
                                    class="form-control"
                                    v-model="decision.note"
                                ></textarea>
                                <hr>
                                <label for="authorization">PIN</label>
                                <pin-input
                                    v-model="decision.authorization"
                                    ref-key="decisionAuth"
                                    num-inputs="6"
                                    input-type="password"
                                    separator=""
                                >
                                </pin-input>
                            </div>
                        </div>
                    </div>
                </b-modal>
            </div>

            <div id="uploadModal">
                <b-modal id="uploadItemModal"
                         @ok="commitData"
                         size="xl"
                         centered
                         scrollable
                         no-close-on-backdrop
                         no-close-on-esc
                         @hidden="hidden"
                         title="Upload & Import {{ Str::plural($entity) }}"
                         modal-class="modal-bv">
                    <import-data
                        :importid="importId"
                        :sourceurl="sourceUrl"
                        :previewcolumns="previewColumns"
                        :previewheadings="previewHeadings"
                        :uploadurl="uploadUrl"
                        :commiturl="commitUrl"
                        download-tmpl-url="{{ url('api/v1/core/export/xls/template') }}"
                        :selected-keys.sync="selectedKeys"
                        :import-all-data.sync="importAllData"
                    ></import-data>

                </b-modal>
            </div>

            <div id="uploadMultisheetModal">
                <b-modal id="uploadMultisheetItemModal"
                         @ok="commitData"
                         size="xl"
                         centered
                         scrollable
                         no-close-on-backdrop
                         no-close-on-esc
                         title="Upload & Import {{ Str::plural($entity) }}"
                         modal-class="modal-bv">
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

            <div id="uploadCellModal">
                <b-modal id="uploadCellItemModal"
                         @ok="commitData"
                         size="xl"
                         centered
                         scrollable
                         no-close-on-backdrop
                         no-close-on-esc
                         title="Upload & Import {{ Str::plural($entity) }}"
                         modal-class="modal-bv">
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

            <div id="workFlowModal">
                <b-modal id="wfDecisionModal"
                         no-close-on-backdrop
                         no-close-on-esc
                         @ok="commitDecision"
                         size="lg"
                         centered
                         scrollable
                         @shown="shownDecisionModal"
                         :title="getDecisionTitle()"
                         modal-class="modal-bv">
                    <div class="row">
                        <div class="col-6 col-xs-12">
                            <h5 v-html="requestDocId()"></h5>
                            <h6 v-html="requestDocTitle()"></h6>
                            <p v-html="requestDocDescription()"></p>
                            <hr>
                            <label for="decision_note">Decision</label>
                            <b-form-group>
                                <b-form-radio-group id="radio-group-decisionlist" v-model="decision.decision"
                                                    name="decisionlist">
                                    <b-form-radio class="col-3" value="Approved">Approve</b-form-radio><br>
                                    <b-form-radio class="col-3" value="Rejected">Reject</b-form-radio>
                                    <b-form-radio class="col-6" value="Released">Approve & Release</b-form-radio>
                                </b-form-radio-group>
                            </b-form-group>
                            <label for="decision_note">Note</label>
                            <textarea
                                name="decision_note"
                                class="form-control"
                                v-model="decision.note"
                            ></textarea>
                        </div>
                        <div class="col-6 col-xs-12">
                            <h6>Authorization</h6>
                            <label for="approver" style="display:block;">Approver</label>

                            <b class="form-control" v-html="decision.approverName"></b>

                            <label for="authorization">PIN</label>
                            <div style="text-align:center;">
                                <pin-input
                                    v-model="decision.authorization"
                                    ref-key="decisionAuth"
                                    num-inputs="6"
                                    input-type="password"
                                    separator=""
                                >
                                </pin-input>
                            </div>
                            <label for="decision_note">Signature</label>
                            <sign-pad
                                ref="decisionSignPad"
                                ref-key="decisionSignPadComp"
                                v-model="decision.authorizationSign"
                                :handle="handle"
                                ns="authorizationSign"
                                uploadurl="{{ url( 'api/v1/core/form-upload' )  }}"
                                mode="single"
                            >

                            </sign-pad>
                        </div>
                    </div>

                </b-modal>

                <b-modal id="wfRequestDecisionModal"
                         no-close-on-backdrop
                         no-close-on-esc
                         @ok="commitRequestDecision"
                         @shown="loadApprovalParam"
                         size="lg"
                         centered
                         scrollable
                         :title="getRequestTitle()"
                         modal-class="modal-bv">
                    <div class="row">
                        <div class="col-6 col-xs-12">
                            <h5 v-html="requestDocId()"></h5>
                            <h6 v-html="requestDocTitle()"></h6>
                            <p v-html="requestDocDescription()"></p>
                            <label for="decision_note">Approver</label>
                            <b-form-group>
                                <b-form-checkbox-group id="checkbox-group-approverList" v-model="requestData.requestApprovers"
                                                       name="requestApprovers">
                                    <b-form-checkbox v-for="ap in approverList" :key="ap.value" class="col-12" :value="ap">@{{ ap.text }}</b-form-checkbox><br>
                                </b-form-checkbox-group>
                            </b-form-group>

                            <label for="decision_note">Request Note</label>
                            <textarea
                                class="form-control"
                                v-model="requestData.requestNote"
                            >
                            </textarea>
                        </div>
                        <div class="col-6 col-xs-12">
                            <h6>Authorization</h6>
                            <label for="requester" style="display:block;">Requester</label>

                            <b class="form-control" v-html="requestData.requesterName"></b>

                            <label for="authorization">PIN</label>
                            <div style="text-align:center;">
                                <pin-input
                                    v-model="requestData.authorization"
                                    ref-key="requestDataAuth"
                                    num-inputs="6"
                                    input-type="password"
                                    separator=""
                                >
                                </pin-input>
                            </div>
                            <label for="requestData_note">Signature Specimen</label>
                            <hr>
                                <img
                                    style="width:300px;height:auto;"
                                    :src="requestData.authorizationSign"
                                    :alt="requestData.authorizationSign" />
                        </div>
                    </div>

                </b-modal>
            </div>

            <div id="lightBoxContainer">
                <vue-easy-lightbox
                    :visible="lightBoxVisible"
                    :imgs="galleryUrls"
                    :index="lightBoxindex"
                    @hide="lightBoxHandleHide"
                ></vue-easy-lightbox>
            </div>

            <div id="confirmationDialogs">

                <b-modal id="cloneConfirmModal"
                         no-close-on-backdrop
                         no-close-on-esc
                         @ok="commitClone"
                         size="md"
                         centered
                         scrollable
                         @shown="shownCloneModal"
                         title="Confirm Clone"
                         modal-class="modal-bv">
                    <div class="row">
                        <div class="col-12">
                            Are you sure you want to clone these {{ $entity }} ?
                        </div>
                    </div>
                </b-modal>

                <b-modal id="deleteConfirmModal"
                         no-close-on-backdrop
                         no-close-on-esc
                         @ok="commitDelete"
                         size="md"
                         centered
                         scrollable
                         @shown="shownDeleteModal"
                         title="Confirm Delete"
                         modal-class="modal-bv">
                    <div class="row">
                        <div class="col-12">
                            Are you sure you want to delete these {{ $entity }} ?
                        </div>
                    </div>
                </b-modal>

                <b-modal id="revisionConfirmModal"
                         no-close-on-backdrop
                         no-close-on-esc
                         @ok="commitRevision"
                         size="md"
                         centered
                         scrollable
                         @shown="shownRevisionModal"
                         title="Confirm Revise"
                         modal-class="modal-bv">
                    <div class="row">
                        <div class="col-12">
                            Are you sure you want to revise these {{ $entity }} ?
                        </div>
                    </div>
                </b-modal>

            </div>


@endsection
