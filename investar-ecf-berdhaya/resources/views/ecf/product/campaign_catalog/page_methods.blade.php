addToCart(item){
@if(Auth::check())
    this.cartObject = {
        "vendorCode" :  this.vendorCode,
        "productCode" :  this.productCode,
        "productName" :  this.productName,
        "weight" :  this.weight,
        "category" :  this.category,
        "currency" :  this.currency,
        "price" :  this.price,
        "picture" :  this.picture,
        "pictureObjects" :  this.pictureObjects,
        "unit" :  this.unit,
        "shortDescription" :  this.shortDescription,
        "goodsType" :  this.goodsType,
        "type" :  this.type,
        "SKU" :  this.SKU,
        "MFG" :  this.MFG,
        "tags" :  this.tags,
        "life" :  this.life,
        "stock" :  this.stock,
        "specifications" :  this.specifications,
        "shippingPolicy" :  this.shippingPolicy,
        "shippingLocation" :  this.shippingLocation,
        "shippingFee" :  this.shippingFee,
        "shippingCourier" :  this.shippingCourier,
        "description" :  this.description,
        "vendor" :  this.vendor,
        "vendorInfo" :  this.vendorInfo,
        "reviews" :  this.reviews,
        "promo" :  this.promo,
        "refundPolicy" :  this.refundPolicy,
        "warrantyPolicy" :  this.warrantyPolicy,
        "MinMaxBuy" :  this.MinMaxBuy,
    };
    this.cartSubTotal = this.price;
    this.cartQty = 1;
    this.cartPrice = this.price;
    this.cartNote = '';
    this.weight = this.weight;
    this.$bvModal.show('addToCartModal');
@else
    this.showAuthModal();
@endif

},
addToWishlist(item){
@if(Auth::check())
    this.$bvModal.show('addToWishlistModal');
@else
    this.showAuthModal();
@endif
},
commitAddToCart(){
    var cartItem = this.cartObject;
    cartItem.orderSubTotal = this.cartSubTotal;
    cartItem.orderQty = this.cartQty;
    cartItem.orderPrice = this.cartPrice;
    cartItem.orderNote = this.cartNote;
    cartItem.weight = this.weight;

    cartItem.ajax = 1;

    axios.post( '{{ url('sfm/shopping-cart/add') }}' , cartItem )
        .then(response => {
            console.log(response.data);
            if(response.data.result == 'OK'){
                this.$bvModal.hide('addToCartModal');
                bus.$emit('refreshShoppingCart');
            }
        })
        .catch(function(error) {
            console.log(error);
            @if( \Illuminate\Support\Facades\Auth::check() )
                if(error.response.status == 401){
                var d = new Date();
                alert('Your session is expired. Please re-login');
                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                }
            @endif
        });

},
