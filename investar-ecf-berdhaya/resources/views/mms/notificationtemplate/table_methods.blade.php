submitTpl(row){

    axios.post( '{{ url('mms/qontak/add-tpl') }}' ,
        { entity: row,  } )
    .then(response => {
        console.log(response.data);
        if(response.data.result == 'OK'){

        } else {
            alert(response.data.msg);
        }
        this.loadTableData();
    })
    .catch(function(error) {
        console.log(error);
    });
},
checkTpl(row){

    axios.post( '{{ url('mms/qontak/check-tpl') }}' ,
        { entity: row,  } )
    .then(response => {
        console.log(response.data);
        if(response.data.result == 'OK'){

        } else {
            alert(response.data.msg);
        }
        this.loadTableData();
    })
    .catch(function(error) {
        console.log(error);
    });
},
updateCheck(row){
    if( _.isNull( row.submitted ) || _.isUndefined( row.submitted ) ){
        return false;
    }else{
        return row.submitted;
    }
},
