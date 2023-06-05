@extends(env('DEFAULT_LAYOUT')??'layouts.dashforge')

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

    <script>
        $(document).ready(function(){

            var uvm = new Vue({
                mounted(){
                    this.getItemData(this.itemId);
                },
                data: function(){
                    return {
                        {!! implode("\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataModel('default') ) !!}
                        title:'Update',
                        itemId : '{{ $id }}',
                        handle: '',
                        autosave: true,

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
                        mapBounds: null,
                        markerDraggable: true,
                        markerIcon: '{{ url('images/vendor/leaflet/dist/marker-icon.png') }}',
                        markerIconRetina: '{{ url('images/vendor/leaflet/dist/marker-icon-2x.png') }}'


                    };
                },
                methods:{
                    zoomUpdated (zoom) {
                        this.mapZoom = zoom;
                    },
                    centerUpdated (center) {
                        this.mapCenter = center;
                    },
                    boundsUpdated (bounds) {
                        this.mapBounds = bounds;
                    },

                    setItemDataModel(data){

                        @if( View::exists($js_load_transform) )
                            @include($js_load_transform)
                        @endif

                        this.selectOptions = data.selOptions;
                        {!! implode("\r\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataModel('load') ) !!}
                    },
                    collectData(){
                        var model_set = {
                            {!! implode("\r\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataModel('objectfield') ) !!}
                            handle: this.handle,
                            ajax: true
                        };
                        return model_set;
                    },
                    getItemData(item_id){
                        axios.get('{{ url($itemdataurl) }}?id=' + item_id)
                            .then((response)=>{
                                this.setItemDataModel(response.data);
                            })
                            .catch(function(error) {
                                console.log(error);
                            });
                    },
                    clearForm(){
                        {!! implode("\r\n", \App\Helpers\Util::loadResYaml($yml_file,$res_path)->addData($data)->toVueDataModel('clear') ) !!}
                            this.handle = '';
                        this.itemId = '';
                        this.photos = [];
                        this.avatar = {};
                        this.IdPic = {};

                    },
                    postData(){
                        let self = this;
                        let postData = this.collectData();

                        console.log(postData);

                        axios.post('{{ url($updateurl) }}/'  + this.itemId , postData )
                            .then(function(response) {
                                console.log(response.data);
                                if(response.data.result == 'OK'){
                                    hideUpdateModal();
                                    tvm.$emit('refresh-data');
                                }
                            })
                            .catch(function(error) {
                                console.log(error);
                            });
                    },

                    {{ $template_var['uvm_methods']??'' }}
                }
            }).$mount('#mainForm');

            function showUpdateModal(){
                $('#updateModal').modal({show:true});
            }

            function goToUrl(url) {
                window.location.href = url;
            }

            function showSubModal(){
                $('#subModal').modal('show');
            }

            function showAddModal(){
                avm.getParam();
                $('#addModal').modal('show');
            }

            function hideAddModal(){
                $('#addModal').modal('hide');
                tvm.fetchData();
            }

            function showUploadModal(){
                $('#uploadModal').modal('show');
            }

            function showDeleteModal(){
                $('#deleteModal').modal('show');
            }

            function hideDeleteModal() {
                $('#deleteModal').modal('hide');
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

            $('#deleteModal').on('hidden.bs.modal', function(e){
                tvm.clearSelection();
            });

            $('#addModal').on('shown.bs.modal', function(event) {
                window.dispatchEvent(new Event('resize'));
            });

            $('#updateModal').on('shown.bs.modal', function(event) {
                window.dispatchEvent(new Event('resize'));
            });

            function formatDate(dt){
                return moment(dt).locale('id').format('L');
            }
        });


    </script>
@endsection

@section('content')
    <style>
        /*.wrap {*/
            /*overflow: hidden;*/
            /*overflow-x: auto;*/
            /*overflow-scrolling: auto;*/
            /*width: 100%;*/
            /*flex-direction: row;*/
            /*height: 40px;*/
        /*}*/

        /*.nav-tabs, nav-pills {*/
            /*flex-wrap: nowrap;*/
            /*white-space: nowrap;*/
            /*max-width: 100%;*/
            /*overflow: auto;*/
        /*}*/

    </style>
    <div id="mainForm">
        <div>
            <b-form-checkbox switch size="lg" v-model="autosave" >Auto Save</b-form-checkbox>
        </div>
        @if($auxdata['hasTabs'] == 1)
        <b-tabs pills content-class="mt-6">
            <b-tab v-for="ctab in contentTabs" :key="ctab.key" :title="ctab.title">
                <active-view
                        :content="ctab.content"
                        :template="tabViewTemplate"
                >
                </active-view>

            </b-tab>
        </b-tabs>
        @else
            <?php

                $form_fields = \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toFormWithKey('name');

                $form_page = \App\Helpers\Util::loadResYaml($yml_layout_file,$res_path)->formWithLayout($form_fields) ;

                print implode("\r\n", $form_page);

            ?>

        @endif
        {{--<b-tabs pills content-class="mt-6">--}}
            {{--<b-tab pills key="inputForm" title="Input">--}}
                {{--<div>--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-lg-6 col-sm-12">--}}
                            {{--@foreach( \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toFormPage($mode,1) as $field )--}}
                                {{--{!! $field !!}--}}
                            {{--@endforeach--}}
                        {{--</div>--}}
                        {{--<div class="col-lg-6 col-sm-12">--}}
                            {{--@foreach( \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toFormPage($mode,2) as $field )--}}
                                {{--{!! $field !!}--}}
                            {{--@endforeach--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</b-tab>--}}
            {{--<b-tab pills key="historyPanel" title="History">--}}
                {{--<h3>History</h3>--}}
                {{--<div>--}}
                {{--</div>--}}
            {{--</b-tab>--}}
        {{--</b-tabs>--}}


    </div>
@endsection
