@extends('layouts.dashforge')

@section('js')
<script>
    $(document).ready(function(){
        var tvm = new Vue({
            data: function(){
                return {
                    columns: ['_id', 'name', 'email', 'updated_at'],
                    secondcolumns: ['name', 'email'],
                    uniqueKey: '_id',
                    options: {
                        filterByColumn: true,
                        headings: {
                            name: 'Employee Name',
                            email: 'Email',
                            updated_at: 'Last Update',
                            id: 'ID',
                        },
                        filterable:['name','email','updated_at'],
                        dateColumns:['updated_at'],
                        dateFormat: 'YYYY-MM-DD',
                        datepickerOptions: {
                            showDropdowns: true,
                            autoUpdateInput: true,
                        },
                        columnsDropdown : true,
                        listColumns: {
                            name: [
                                {
                                    id: 1,
                                    text: 'Dog'
                                },
                                {
                                    id: 2,
                                    text: 'Cat',
                                    hide:true
                                },
                                {
                                    id: 3,
                                    text: 'Tiger'
                                },
                                {
                                    id: 4,
                                    text: 'Bear'
                                }
                            ]
                        },
                        requestFunction: function (data) {
                            return axios.post(this.url, {
                                params: data
                            }).catch(function (e) {
                                this.dispatch('error', e);
                            }.bind(this));
                        }
                    }
                };
            },
            methods: {
                showUpModal: function(id){
                    console.log(id);
                    showUpdateModal();
                }
            }
        }).$mount('#app');
    });

    function showUpdateModal(){

    }
</script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <v-server-table class="table" url="{{ url($dataurl) }}" :columns="columns" :options="options"  ></v-server-table>
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
                {{--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">--}}
                    {{--Add--}}
                {{--</button>--}}
                {{--<button type="button" class="btn btn-primary" @click="showUpModal(id)">--}}
                    {{--Update--}}
                {{--</button>--}}


            </div>
        </div>
    </div>


    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade modal-fullscreen" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    This is a fullscreen modal
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-fullscreen" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    This is a fullscreen modal
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
