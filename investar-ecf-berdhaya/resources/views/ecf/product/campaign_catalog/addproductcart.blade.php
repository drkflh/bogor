<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="detail-info pr-30 pl-30">
        <h2 style="font-size: 14pt;">@{{ cartObject.bizTradeMark ?? '' }}</h2>
        <h3 style="font-size: 12pt;">@{{ cartObject.bizCompanyType ?? '' }} @{{ cartObject.bizRegisteredName ?? '' }}</h3>


        <div class="clearfix product-price-cover">
            <div class="product-price primary-color float-left">
                <p>@{{ cartObject.productServicesDescription }}</p>
{{--                <h4 class="title-detail">@{{ cartObject.currency }} @{{ formatCurrency( cartPrice ) }}</h4>--}}
{{--                <span class="ml-1">--}}
{{--                    @{{ cartObject.unitCount }} @{{ cartObject.unit }} (@{{ cartObject.weight }} gram)--}}
{{--                </span>--}}
            </div>
        </div>
        <div class="clearfix product-price-cover">
            <div class="d-flex align-content-around justify-content-around">
                <span>
                    <b-form-spinbutton id="cart-qty" v-model="cartQty" min="1" class="d-flex align-items-center" style="height: 56px !important;border:none;font-size: 18pt !important;" ></b-form-spinbutton>
                </span> <h3 style="font-size: 12pt;">lot</h3>
            </div>
        </div>
        <div class="clearfix product-price-cover d-flex align-content-between align-items-end">
            <h5 style="font-size: 14pt;">{{ __('Sub Total') }}</h5>
            <div class="product-price primary-color">
                <h4 style="font-size: 14pt;">@{{ cartObject.currency }} @{{ formatCurrency( cartSubTotal ) }}</h4>
            </div>
        </div>
        <h5 class="title-detail">{{ __('Note') }}</h5>
        <div class="clearfix product-price-cover d-flex align-content-between align-items-center">
            <textarea class="form-control" v-model="cartNote">

            </textarea>
        </div>
    </div>
    <!-- Detail Info -->
</div>
