<!-- <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="detail-info pr-30 pl-30">
        <h4 class="title-detail">Nama Produk : @{{ cartObject.productName ?? '' }}</h4>
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

        <div class="">
            <div class=""> -->
            <div class="row pb-3" style="margin-left:0px;">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="title-detail  d-flex justify-content-center">@{{ cartObject.campaignTitle ?? '' }}</h4>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-12">
                            <h4 class="">Harga : RP. @{{ formatCurrency( cartPrice ) }}</h4>
                        </div>
                        
                    </div> -->
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <b-form-spinbutton id="cart-qty" v-model="cartQty" min="1" :max="cartObject.lotEmitted" class="" style="height: 48px !important;width: 150px !important;border:none;font-size: 14pt !important;" ></b-form-spinbutton>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h4 class="title-detail d-flex justify-content-center">{{ __('Sub Total') }} : Rp. @{{ formatCurrency( cartSubTotal ) }}</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h4 class="title-detail">{{ __('Note') }}</h4>
                            <div class="">
                                <textarea class="form-control" v-model="cartNote">

                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- </div>
            <span class="ml-1">
            </span>
{{--                <span class="ml-1">--}}
{{--                    @{{ cartObject.unitCount }} @{{ cartObject.unit }} (@{{ cartObject.weight }} gram)--}}
{{--                </span>--}}
            </div>
        </div>
        <div class="">
            <div class="primary-color">
                <span>
                </span>
            </div>
        </div>
        <div class="">
            <h5 class="title-detail">{{ __('Sub Total') }} : RP. @{{ formatCurrency( cartSubTotal ) }}</h4>
</h5><br>
            <div class="">
            </div>
        </div> -->
        <!-- <div class="">
            <h5 class="title-detail">{{ __('Weight') }}</h5>
            <div class="">
                <h4 class="title-detail">@{{ cartObject.weight }} gram</h4>
            </div>
        </div> -->
        <!-- <h5 class="title-detail">{{ __('Note') }}</h5>
        <div class="">
            <textarea class="form-control" v-model="cartNote">

            </textarea>
        </div>
    </div> -->
    <!-- Detail Info -->
<!-- </div> -->
