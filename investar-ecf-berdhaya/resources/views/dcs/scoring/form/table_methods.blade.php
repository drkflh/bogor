openFormModal(val){
    this.val = val;
    this.runFormData = val;
    this.runFormCode = val.formCode;
    this.runFormId = val._id;
    this.$bvModal.show('runFormModal');
},
getFormTitle(){
    return this.runFormData.formCode + ' - '+ this.runFormData.title;
},
clearRunForm(){
    this.runFormData = {};
    this.runFormModel = {};
    this.runFormDefault = {};
    this.runFormTemplate = '';
    this.runFormCode = '';
    this.runFormId = '';
},
commitSaveForm(event){
    event.preventDefault();

    var data = {
        formCode: this.runFormCode,
        formId: this.runFormId,
        formData: this.runFormData,
        model: this.runFormModel,
        default: this.runFormDefault,
        template: this.runFormTemplate
    };
    if(true){
        axios.post( '{{ url('/dcs/scoring/form/form-save') }}' , data )
            .then(response => {
                console.log(response.data);
                if(response.data.result == 'OK'){
                    this.$bvModal.hide('runFormModal');
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
        axios.post( '{{ url('/dcs/scoring/form/form-def') }}' , this.runFormData  )
            .then(response => {
                console.log(response.data);
                if(response.data.result == 'OK'){
                    var fd = response.data.data;
                    this.runFormTemplate = fd.template;
                    this.runFormModel = fd.model;
                    this.runFormDefault = fd.default;
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
