bus.$on('returndocument', (data) => {
        if( _.isUndefined(data.editIndex) || _.isNull(data.editIndex) || _.isNil(data.editIndex) ){
            this.invitationToBid.push(data);
        }else{
            var editIndex = data.editIndex;
            _.unset(data, 'editIndex');
            this.invitationToBid[editIndex] = data;
        }
});
