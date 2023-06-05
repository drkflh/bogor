<template>
    <div class="panel-body">
        <div class="row" >
            <div :class="autoSelect?'col-11':'col-10'">
                <local-search-select
                        id="formSelect"
                        v-model="selectedSchema"
                        :options="schemaOptions"
                        text
                ></local-search-select>
            </div>
            <div class="col-1" style="text-align: center; display: table-cell;">
                <b-spinner v-show="showLoading" label="Spinning" style="vertical-align: middle;" ></b-spinner>
            </div>
            <div class="col-1" v-if="!autoSelect">
                <button class="btn btn-primary" @click="openForm" >Select</button>
            </div>
        </div>
        <div v-if="showForm" class="row">
            <div class="col-12" >
                <div class="card block" style="box-shadow: 0px 0px !important; margin-bottom: 0px;margin-top: 8px;">
                    <div class="block-header block-header-default">
                        <h2 class="block-title">{{ getTitle() }}</h2>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-down"></i></button>
                        </div>
                    </div>
                    <div class="card-body block-content block-content-full" style="max-height: 400px;overflow-y: auto; border: thin solid lightgrey;">
                        <active-form
                            v-model="model"
                            :params="schema.formParam"
                            :object-default="schema.formObjectDefault"
                            :template="schema.formContent"
                        >
                        </active-form>
                    </div>
                </div>
            </div>
        </div>

        <b-modal id="modalId"
                 @ok="addItem"
                 no-close-on-backdrop
                 no-close-on-esc
                 size="lg" :title="getTitle()"
                 :visibility="showModal"
                 :hide-backdrop="hideBackdrop"
                 modal-class="modal-bv"
                 scrollable
        >
            <b-spinner type="grow" v-show="showLoading" label="Spinning"></b-spinner>
            <div class="row" >
                <div class="col-12">
                    <form>
                        <active-form
                                v-model="model"
                                :params="schema.formParam"
                                :object-default="schema.formObjectDefault"
                                :template="schema.formContent"
                        >
                        </active-form>
                    </form>
                </div>
            </div>


        </b-modal>


    </div>
</template>

<script>
    export default {
        name: "TemplateSelector",
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            value: {
                type: [String, Object, Array, Number]
            },
            options: {
                type: [String, Object, Array]
            },
            loadUrl: {
                type: String
            },
            schemaOptions: {
                type: Array
            },
            searchUrl: {
                type: String
            },
            searchVar: {
                type: String,
                default: 'q'
            },
            showResult: {
                type: Boolean,
                default: false
            },
            outView: {
                type: String,
                default: ''
            },
            autoSelect: {
                type: Boolean,
                default: false
            },
            replaceWith: {
                type: Object,
                default: function(){
                    return {};
                }
            }
        },
        data: function() {
            return {
                schema: {
                    formModel: {},
                    formContent: '',
                    formParam: {},
                    formObjectDefault: {},
                },
                formTitle:'',
                model: {},
                selectedSchema : '',
                showLoading: false,
                showModal : false,
                hideBackdrop : false,
                showForm : false
            }
        },
        watch: {
            model: function(val){
                var mod = val;
                mod.formTitle = this.formTitle;
                mod.formHtml = _.get(this.schema, 'formContent' );
                mod.formKey = this.selectedSchema;
                mod.formTs = moment().unix();
                this.$emit('input', mod);
            },
            selectedSchema: function(val){
                if(this.autoSelect){
                    if( ! ( _.isNull(val) || _.isUndefined(val) ) ){
                        this.getForm(this.selectedSchema);
                    }
                }
            }
        },
        methods: {
            openForm(){
                this.getForm(this.selectedSchema);
            },
            addItem(){
                if(_.isEmpty(this.model)){
                    alert('Empty data !')
                }else{
                    var mod = this.model;
                    mod.formTitle = this.formTitle;
                    mod.formHtml = _.get(this.schema, 'formContent' );
                    mod.formKey = this.selectedSchema;
                    mod.formTs = moment().unix();
                    this.$emit('input', mod);
                    this.showForm = true;
                    this.$bvModal.hide('modalId');
                }
            },
            getTitle(){
                return this.formTitle;
            },
            getForm(key) {
                if(key == ''){
                    this.showLoading = false;
                }else{
                    this.showLoading = true;
                    axios.post(this.searchUrl + '?' + this.searchVar + '=' + key, { replaceWith : this.replaceWith }  )
                        .then( response => {
                            this.showLoading = false;
                            console.log(response.data);
                            if(response.data.result == 'OK'){


                                try {
                                    var sch = response.data.schema;

                                    console.log(sch);
                                    this.formTitle = sch.name;

                                    var sc = {
                                            formModel: sch.formModel,
                                            formContent: sch.formContent,
                                            formParam:  sch.formParam,
                                            formObjectDefault: sch.formObjectDefault
                                    };
                                    this.schema = sc;
                                    this.model = this.schema.formModel;
                                    this.$emit('update:outView', sch.formContent );

                                }catch (e) {
                                    console.log(e);
                                    this.showLoading = false;
                                }
                            }
                        })
                        .catch( error=> {
                            this.showLoading = false;
                            console.log(error);
                        });
                }
            }

        }
    }
</script>

<style scoped>

</style>
