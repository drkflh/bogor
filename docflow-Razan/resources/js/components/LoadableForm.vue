<template>
    <div class="panel-body">
        <div class="row" >
            <div class="col-11">
                <b-form-select
                        v-model="selectedSchema"
                        :options="schemaOptions"
                ></b-form-select>
            </div>
            <div class="col-1">
                <b-spinner type="grow" v-show="showLoading" label="Spinning"></b-spinner>
            </div>
        </div>
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
    </div>
</template>

<script>
    export default {
        name: "LoadableForm",
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
            }
        },
        data: function() {
            return {
                schema: {
                    formModel: {},
                    formContent: '',
                    formParam: {},
                    formObjectDefault: {}
                },
                model: {},
                selectedSchema : '',
                showLoading: false
            }
        },
        watch: {
            selectedSchema: function (val) {
                this.getForm(val);
            },
            model: function(val){
                this.$emit('input', val);
            }
        },
        methods: {
            getForm(key) {
                if(key == ''){
                    this.showLoading = false;
                }else{
                    this.showLoading = true;
                    axios.get(this.searchUrl + '?' + this.searchVar + '=' + key )
                        .then( response => {
                            this.showLoading = false;
                            console.log(response.data);
                            if(response.data.result == 'OK'){
                                try {
                                    var sch = response.data.schema;

                                    console.log(sch);

                                    var sc = {
                                            formModel: sch.formModel,
                                            formContent: sch.formContent,
                                            formParam:  sch.formParam,
                                            formObjectDefault: sch.formObjectDefault
                                    };
                                    this.schema = sc;
                                    this.model = this.schema.formModel;
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
