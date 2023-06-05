showSendModal(row){
    this.openSendModal(row);
},
openSendModal(row) {
    this.sendDoc = row;
    this.$bvModal.show('sendModal');
},
commitSend(){
    this.isLoading = true;
    axios.post( '{{ url('dwf/document/send') }}' , {
        item : this.sendDoc,
    } )
    .then(response => {
        console.log(response.data);
        if(response.data.result == 'OK'){
            alert('Naskah terkirim');
            this.sentTo = response.data.data;
            //this.hideSendModal();
            bus.$emit('refreshTable', {});
        }
        this.isLoading = false;
    })
    .catch(function(error) {
        this.isLoading = false;
        alert('Gagal mengirim naskah');
    });
},
hideSendModal() {
    this.$bvModal.hide('sendModal');
},
sendModalShown(){

},
sendModalHidden(){
    this.sendDoc = {};
    this.sentTo = {};
},

showDocLogModal(row){
    this.openLogModal(row);
},
openLogModal(row) {
    axios.post( '{{ url('dwf/document/history') }}' , {
        itemId : row._id,
    } )
    .then(response => {
        console.log(response.data);
        if(response.data.result == 'OK'){
            this.docHistory = response.data.data;
        }
    })
    .catch(function(error) {
        console.log(error);
    });

    this.$bvModal.show('approvalLogModal');
},
hideLogModal() {
    this.$bvModal.hide('approvalLogModal');
},
logModalShown(){

},
logModalHidden(){
    this.docHistory = [];
},
showButtonApproval(row){
    console.log('keywords',this.keywords);
    var kwd0 = _.get( this.keywords, 'keyword0' );
    var kwd1 = _.get( this.keywords, 'keyword1' );
    var showSignButton = 0;
    if( row.docStatus == 'DRAFT' || row.docStatus == 'APPROVED' ){
        if(kwd1 == 'signature'){
            var signer = _.get(row, 'signer');
            var signed = _.get(row, 'signingStatus');

            console.log('signer', signer);
            console.log('signed', signed);

            showSignButton = false;
            if( !( _.isNull(signer) || _.isUndefined(signer) ) && _.isArray(signer) ){
                _.forEach( signer, (val) => {
                    if( !( _.isNull(val) || _.isUndefined(val) ) && _.get( val , 'key' ) == '{{ Auth::user()->_id }}' ){
                        showSignButton = 1;
                    }
                });
            }
            if( !( _.isNull(signed) || _.isUndefined(signed) ) && _.isArray(signed) ){
                _.forEach( signed, (val) => {
                    if( !( _.isNull(val) || _.isUndefined(val) ) && _.get( val , 'key' ) == '{{ Auth::user()->_id }}' ){
                        showSignButton = 2;
                    }
                });
            }
            console.log('signer showSign Button', row.docNo ,showSignButton);
        }


        if(kwd1 == 'draft-review'){

            var drafter = _.get(row, 'draftRecipient');
            var drafted = _.get(row, 'draftStatus');

            console.log('drafter',drafter);
            console.log('drafted',drafted);

            showSignButton = 0;
            if( !( _.isNull(drafter) || _.isUndefined(drafter) ) && _.isArray(drafter) ){
                _.forEach( drafter, (val) => {
                    if( !( _.isNull(val) || _.isUndefined(val) ) && _.get( val , 'key' ) == '{{ Auth::user()->_id }}' ){
                        showSignButton = 1;
                    }
                });
            }
            if( !( _.isNull(drafted) || _.isUndefined(drafted) ) && _.isArray(drafted) ){
                _.forEach( drafted, (val) => {
                    if( !( _.isNull(val) || _.isUndefined(val) ) && _.get( val , 'key' ) == '{{ Auth::user()->_id }}' ){
                        showSignButton = 2;
                    }
                });
            }
            console.log('draft showSign Button', row.docNo, showSignButton);
        }

        console.log('return showSign Button', row.docNo, showSignButton);

        return showSignButton;
    }else{
        return false;
    }
},

showArchiveModal(row){
    this.openArchiveModal(row);
},
openArchiveModal(row) {
    this.sendDoc = row;
    this.$bvModal.show('archiveModal');
},
commitArchive(){
    this.isLoading = true;
    axios.post( '{{ url('dwf/document/archive') }}' , {
        item : this.sendDoc,
        archiveCategory : this.archiveCategorySelection
    } )
    .then(response => {
        console.log(response.data);
        if(response.data.result == 'OK'){
            alert('Naskah diarsipkan');
            bus.$emit('refreshTable', {});
        }
        this.isLoading = false;
        this.hideArchiveModal();
    })
    .catch(function(error) {
        this.isLoading = false;
        alert('Gagal mengarsipkan naskah');
    });
},
hideArchiveModal() {
    this.$bvModal.hide('archiveModal');
},
archiveModalShown(){

},
archiveModalHidden(){
    this.sendDoc = {};
    this.archiveCategorySelection = this.archiveCategoryDefault;
},


