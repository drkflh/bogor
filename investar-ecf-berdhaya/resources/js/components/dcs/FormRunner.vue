<template>
    <div class="row">
        <div class="col-12">
            <active-form
                v-model="formModel"
                :content="formContent"
                :object-default="formDefault"
                :params="formParams"
                :template="formTemplate"
            ></active-form>
        </div>
    </div>
</template>

<script>
export default {
    name: "FormRunner",
    props: {
        formTitle: {
            type: [String]
        },
        formContent: {
            type: [String, Object, Array]
        },
        formParams: {
            type: [String, Object, Array]
        },
        formTemplate: {
            type: [String, Object, Array]
        },
        formDefault: {
            type: [String, Object, Array],
            default: function () {
                return {}
            }
        },
        result: {
            type: [String, Object, Array],
            default: function () {
                return {}
            }
        },
        loadUrl: {
            type: [String]
        },
        saveUrl: {
            type: [String]
        },
    },
    data: function(){
        return {
            formModel : {}
        }
    },
    watch: {
        formModel: {
            deep: true,
            handler(result){
                this.$emit('input', result);
            }
        },
    },
    methods: {
        clearRunForm(){
            this.formData = {};
            this.formModel = {};
            this.formDefault = {};
            this.formTemplate = '';
            this.formCode = '';
            this.formId = '';
        },
        commitSaveForm(event){
            event.preventDefault();

            var data = {
                formCode: this.formCode,
                formId: this.formId,
                formData: this.formData,
                model: this.formModel,
                default: this.formDefault,
                template: this.formTemplate
            };
            if(true){
                axios.post( this.saveUrl , data )
            .then(response => {
                    console.log(response.data);
                    if(response.data.result == 'OK'){
                        this.$bvModal.hide('formModal');
                        alert('Form Submitted Successfuly')
                    }
                    if(response.data.result == 'ERR'){
                        alert(response.data.message);
                    }
                })
                    .catch(function(error) {
                        console.log(error);
                    });
            }else{
                alert('PIN tidak sama')
            }
        },
        loadFormDef(){
            if(true){
                axios.post( this.loadUrl , this.formData  )
                .then(response => {
                    console.log(response.data);
                    if(response.data.result == 'OK'){
                        var fd = response.data.data;
                        this.formTemplate = fd.template;
                        this.formModel = fd.model;
                        this.formDefault = fd.default;
                    }
                    if(response.data.result == 'ERR'){
                        alert(response.data.message);
                    }
                })
                    .catch(function(error) {
                        console.log(error);
                    });
            }else{
                alert('Definition not found')
            }
        },

    }
}
</script>

<style scoped>

</style>
