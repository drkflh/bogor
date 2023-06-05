<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="detail-info pr-30 pl-30">
        <h4 class="title-detail">@{{ cartObject.productName }}</h4>

{{--        <h6 class="title-detail">{{ __('Variant') }}</h6>--}}
{{--        <div class="attr-detail attr-size mb-30">--}}
{{--            <strong class="mr-10">Size / Weight: </strong>--}}
{{--            <ul class="list-filter size-filter font-small">--}}
{{--                <li><a href="#">50g</a></li>--}}
{{--                <li class="active"><a href="#">60g</a></li>--}}
{{--                <li><a href="#">80g</a></li>--}}
{{--                <li><a href="#">100g</a></li>--}}
{{--                <li><a href="#">150g</a></li>--}}
{{--            </ul>--}}
{{--        </div>--}}

        <div class="clearfix product-price-cover">
            <div class="product-price primary-color float-left">
                <h4 class="title-detail">@{{ cartObject.currency }} @{{ formatCurrency( cartPrice ) }}</h4>
                <span class="ml-1">
                    @{{ cartObject.unitCount }} @{{ cartObject.unit }} (@{{ cartObject.weight }} gram)
                </span>
            </div>
        </div>
        <div class="clearfix product-price-cover">
            <div class="product-price primary-color float-left">
                <span>
                    <b-form-spinbutton id="cart-qty" v-model="cartQty" min="1" class="d-flex align-items-center" style="height: 56px !important;border:none;font-size: 18pt !important;" ></b-form-spinbutton>
                </span>
            </div>
        </div>
        <div class="clearfix product-price-cover d-flex align-content-between align-items-center">
            <h5 class="title-detail">{{ __('Sub Total') }}</h5>
            <div class="product-price primary-color">
                <h4 class="title-detail">@{{ cartObject.currency }} @{{ formatCurrency( cartSubTotal ) }}</h4>
            </div>
        </div>
        <!-- <div class="clearfix product-price-cover d-flex align-content-between align-items-center">
            <h5 class="title-detail">{{ __('Weight') }}</h5>
            <div class="product-price primary-color">
                <h4 class="title-detail">@{{ cartObject.weight }} gram</h4>
            </div>
        </div> -->
        <h5 class="title-detail">{{ __('Note') }}</h5>
        <div class="clearfix product-price-cover d-flex align-content-between align-items-center">
            <textarea class="form-control" v-model="cartNote">

            </textarea>
        </div>
    </div>
    <!-- Detail Info -->
</div>
