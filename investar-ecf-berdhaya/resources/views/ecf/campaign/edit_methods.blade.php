postGetSeq(){
    <!-- console.log( 'clusternya :', this.cluster ); -->

    var bizProfileId = this.bizProfileId;

    if( this.bizProfileId != '' ){
        <!-- console.log( 'yes here' ); -->

        axios.post( '{{ url('ecf/campaign/get-seq') }}' , { bizProfileId: bizProfileId } ) 
        .then(response => {
            console.log( 'responseraw---', response.data );
             if(response.data.result == 'OK'){
                var bizRegisteredName =  _.get( response.data , 'bizRegisteredName', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.bizRegisteredName = bizRegisteredName; 
                var bizCompanyType =  _.get( response.data , 'bizCompanyType', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.bizCompanyType = bizCompanyType; 
                var email =  _.get( response.data , 'email', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.email = email;
                var name =  _.get( response.data , 'name', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.name = name; 
                var position =  _.get( response.data , 'position', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.position = position; 
                var contactWA =  _.get( response.data , 'contactWA', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.contactWA = contactWA; 
                var bizTradeMark =  _.get( response.data , 'bizTradeMark', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.bizTradeMark = bizTradeMark; 
                var bizAddress =  _.get( response.data , 'bizAddress', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.bizAddress = bizAddress; 
                var bizType =  _.get( response.data , 'bizType', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.bizType = bizType; 
                var legality =  _.get( response.data , 'legality', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.legality = legality; 
                var noNPWP =  _.get( response.data , 'noNPWP', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.noNPWP = noNPWP; 
                var slikOJK =  _.get( response.data , 'slikOJK', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.slikOJK = slikOJK; 
                var productServices =  _.get( response.data , 'productServices', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.productServices = productServices; 
                var establishedSinceYear =  _.get( response.data , 'establishedSinceYear', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.establishedSinceYear = establishedSinceYear; 
                var establishedSince =  _.get( response.data , 'establishedSince', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.establishedSince = establishedSince; 
                var noOfBranches =  _.get( response.data , 'noOfBranches', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.noOfBranches = noOfBranches; 
                var productServicesDescription =  _.get( response.data , 'productServicesDescription', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.productServicesDescription = productServicesDescription; 
                var marketingFunnels =  _.get( response.data , 'marketingFunnels', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.marketingFunnels = marketingFunnels; 
                var monthlyGrossRevenue =  _.get( response.data , 'monthlyGrossRevenue', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.monthlyGrossRevenue = monthlyGrossRevenue; 
                var monthlyNettRevenue =  _.get( response.data , 'monthlyNettRevenue', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.monthlyNettRevenue = monthlyNettRevenue; 
                var requiredFunding =  _.get( response.data , 'requiredFunding', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.requiredFunding = requiredFunding; 
                var typeOfFunding =  _.get( response.data , 'typeOfFunding', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.typeOfFunding = typeOfFunding; 
                var contractReference =  _.get( response.data , 'contractReference', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.contractReference = contractReference; 
                var covidStrategy =  _.get( response.data , 'covidStrategy', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.covidStrategy = covidStrategy; 
                var getToKnowInvestar =  _.get( response.data , 'getToKnowInvestar', '' );
                <!-- console.log( 'regionalnya', regional ); -->
                this.getToKnowInvestar = getToKnowInvestar; 
            } 
        })
        .catch(function(error) {
            console.log(error);
        });
    } else{
        console.log("Asset Name is not available");
    }

},

getYearCalculate(){

var establishedSinceYear = this.establishedSinceYear;

axios.post( '{{ url('ecf/campaign/get-year') }}' , { establishedSinceYear : establishedSinceYear } )
    .then(response => {
        console.log(  'responseraw', response.data );
        if(response.data.result == 'OK'){
            var establishedYear =  _.get( response.data , 'establishedYear' );          
            this.establishedYear = establishedYear;
        }
    })
    .catch(function(error) {
        console.log(error);
    });
},
