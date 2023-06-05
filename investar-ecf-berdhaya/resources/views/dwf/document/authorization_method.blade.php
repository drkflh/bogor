
if( _.isArray(this.printItemData) ){
    var item = _.first(this.printItemData);
    console.log( '{{ Auth::user()->_id }} approval item' , item);
    this.decision.useSignature = false;
    this.decision.useInitial = false;

    var kwd0 = _.get( this.keywords, 'keyword0' );
    var kwd1 = _.get( this.keywords, 'keyword1' );
    var showSignButton = false;

    if( item.docStatus == 'DRAFT' || item.docStatus == 'APPROVED' ){

        if(kwd1 == 'signature'){
            this.decision.useSignature = true;
            var signer = _.get(item, 'signer');
            var signed = _.get(item, 'signingStatus');

            console.log('signer', signer);
            console.log('signed', signed);

            showSignButton = false;
            if( !( _.isNull(signer) || _.isUndefined(signer) ) && _.isArray(signer) ){
                _.forEach( signer, (val) => {
                    if( !( _.isNull(val) || _.isUndefined(val) ) && _.get( val , 'key' ) == '{{ Auth::user()->_id }}' ){
                        showSignButton = true;
                    }
                });
            }
            if( !( _.isNull(signed) || _.isUndefined(signed) ) && _.isArray(signed) ){
                _.forEach( signed, (val) => {
                    if( !( _.isNull(val) || _.isUndefined(val) ) && _.get( val , 'key' ) == '{{ Auth::user()->_id }}' ){
                        showSignButton = false;
                    }
                });
            }
            console.log('signer showSign Button', item.docNo ,showSignButton);
        }

        if(kwd1 == 'draft-review'){
            this.decision.useInitial = true;
            var drafter = _.get(item, 'draftRecipient');
            var drafted = _.get(item, 'draftStatus');

            console.log('drafter',drafter);
            console.log('drafted',drafted);

            showSignButton = false;
            if( !( _.isNull(drafter) || _.isUndefined(drafter) ) && _.isArray(drafter) ){
                _.forEach( drafter, (val) => {
                    if( !( _.isNull(val) || _.isUndefined(val) ) && _.get( val , 'key' ) == '{{ Auth::user()->_id }}' ){
                        showSignButton = true;
                    }
                });
            }
            if( !( _.isNull(drafted) || _.isUndefined(drafted) ) && _.isArray(drafted) ){
                _.forEach( drafted, (val) => {
                    if( !( _.isNull(val) || _.isUndefined(val) ) && _.get( val , 'key' ) == '{{ Auth::user()->_id }}' ){
                        showSignButton = false;
                    }
                });
            }
            console.log('draft showSign Button', item.docNo, showSignButton);
        }

        console.log('showSign', showSignButton);

        this.requestSigning = showSignButton;
    }else{
        this.requestSigning = false;
    }
}
