
openRegModal(row) {
    axios.post( '{{ url('halal/halal-product/get-sihalal') }}' , {
        itemId : row._id
    } )
    .then(response => {
        console.log(response.data);
        if(response.data.result == 'OK'){
            console.log("test 1");
        }else{
            console.log("tes 2");
        }
    })
    .catch(function(error) {
        console.log(error);
    });

    this.$bvModal.show('modalSihalal');
},
hideRegModal() {
    this.$bvModal.hide('modalSihalal');
},
logModalShown(){

},
logModalHidden(){
 
},


openHalalRegModal(row) {
    axios.post( '{{ url('/halal/halal-product/reg-sihalal') }}' , {
    } )
    .then(response => {
        console.log(response.data); 
        if(response.data.result == 'OK'){
            console.log("test 1 halal");
        }else{
            console.log("tes 2");
        }
    })
    .catch(function(error) {
        console.log(error);
    });

    {{-- this.$bvModal.show('modalSihalalReg'); --}}
},


