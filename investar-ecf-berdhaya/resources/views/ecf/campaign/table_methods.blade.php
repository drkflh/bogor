openLogModal(row, status = 'all') {
axios.post( '{{ url('ecf/campaign/history') }}' , {
itemId : row._id,
status : status
} )
.then(response => {
console.log(response.data);
if(response.data.result == 'OK'){
this.docHistory = response.data.data;
this.docHistoryTitle = row.jobNo;
}
})
.catch(function(error) {
console.log(error);
});

this.$bvModal.show('historyLogModal');
},
hideLogModal() {
this.$bvModal.hide('historyLogModal');
},
logModalShown(){

},
logModalHidden(){
this.docHistory = [];
},
