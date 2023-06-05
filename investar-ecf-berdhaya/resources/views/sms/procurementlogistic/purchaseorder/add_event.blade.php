bus.$on('returndocument', (data) => {
    console.log('addform',data);
    if( _.isUndefined(data.editIndex) || _.isNull(data.editIndex) || _.isNil(data.editIndex) ){
        this.invitationToBid.push(data);
    }else{
        var editIndex = data.editIndex;
        console.log('addform',data);
        _.unset(data, 'editIndex');
        console.log('addform',data);
        console.log('addform',editIndex);
        this.invitationToBid[editIndex] = data;
    }
});
