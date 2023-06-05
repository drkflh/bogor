addToCart(item){
@if(Auth::check())
    this.cartObject = item;
    this.campaignId = item._id;
    this.cartSubTotal = item.pricePerLot;
    this.cartQty = 1;
    this.cartPrice = item.pricePerLot;
    this.cartNote = '';
    this.weight = item.weight;
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
    cartItem.campaignId = this.campaignId;
    cartItem.weight = this.weight;

    cartItem.ajax = 1;
    console.log(cartItem);

    axios.post( '{{ url('ecf/shopping-cart/add') }}' , cartItem )
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
