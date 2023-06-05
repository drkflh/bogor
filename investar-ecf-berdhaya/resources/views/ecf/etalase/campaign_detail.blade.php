<!-- <link rel="stylesheet" href="{{ asset('themes/nest_frontend/assets/css/main.css?v=5.3') }}" />
<link rel="stylesheet" href="{{ asset('themes/nest_frontend/assets/css/plugins/animate.min.css') }}" /> -->
<script type="application/javascript">
        function subtract(lotBuy, pricePerLot, dividendAnnualReturn)
        {
            let dollarUSLocale = Intl.NumberFormat('en-US');
            var returnPerPeriode = dividendAnnualReturn/100 ;
            var totalReturnPerPeriode = pricePerLot * returnPerPeriode;
            total = (lotBuy * pricePerLot) + (lotBuy * totalReturnPerPeriode);
            obj("total").value = dollarUSLocale.format(total);
        }

        function obj(id)
        {
            return document.getElementById(id);
        } 
</script>
<?php
use App\Models\Ecf\Campaign;
use App\Helpers\NumberUtil;
$id = request()->route('id');
$campaign = Campaign::where('_id', $id)->first();
if (is_array($campaign->picture)) {
    $campaignPicture = $campaign->picture[0];
}else{
    $campaignPicture = $campaign->picture;
}
?>
    <main class="main">
        <div class="container mb-30">
        @if(Auth::user()->roleSlug == 'pemodal')
        <a href="/ecf/etalase"><button class="btn btn-danger text-white">Back </button></a>
        @else
        <a href="/"><button class="btn btn-danger text-white">Back </button></a>
        @endif
            <div class="row">
                <div class="col-xl-11 col-lg-12 m-auto">
                    <div class="row">
                        <div class="col-xl-9">
                            <div class="product-detail accordion-detail">
                                <div class="row mb-50 mt-30">
                                    <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                                        <div class="detail-gallery">
                                            <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                            <!-- MAIN SLIDES -->
                                            @if($campaignPicture != null)
                                            <img class="card-img-top" src="{{ $campaignPicture }}" alt="Card image cap"
                                                onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/blank.png' ) ) }}';"
                                            >
                                            <!-- THUMBNAILS -->
                                            <div class="slider-nav-thumbnails">
                                                <!-- <div><img src="assets/imgs/shop/thumbnail-3.jpg" alt="product image" /></div> -->
                                            </div>
                                            @endif
                                        </div>
                                        <!-- End Gallery -->
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="detail-info pr-30 pl-30">
                                            <!-- <span class="stock-status out-stock"> Sale Off </span> -->
                                            <h2 class="title-detail">{{ $campaign->campaignTitle ?? '--' }}</h2>
                                            <div class="clearfix product-price-cover">
                                                <div class="product-price primary-color float-left">
                                                    <h5 class="current-price text-brand">Harga Per Lot: Rp.{{ NumberUtil::currency($campaign->pricePerLot) }}</h5>
                                                    <h5 class="current-price text-brand">Lot Tersisa: {{ $campaign->lotEmitted }}/{{ $campaign->totalLot }}</h5>
                                                    <h5 class="current-price text-brand">Periode Dividen: Per {{ $campaign->dividendPeriod }} {{ $campaign->dividendPeriodUnit }}</h5>
                                                    <h5 class="current-price text-brand">Estimasi Dividen: {{ $campaign->dividendAnnualReturn }}%</h5>
                                                </div>
                                            </div>
                                            <div class="short-desc mb-30">
                                                <!-- <h6 class="font-lg">@{{ campaignExecSummary }}</h6> -->
                                            </div>
                                            <!-- <div class="attr-detail attr-size mb-30">
                                                <strong class="mr-10">Size / Weight: </strong>
                                                <ul class="list-filter size-filter font-small">
                                                    <li><a href="#">@{{ weight }}g</a></li>
                                                </ul>
                                            </div> -->
                                            <!-- <div v-if = "lotEmmited != '0'">
                                            <div class="detail-extralink mb-50"> -->
                                                <!-- <div class="detail-qty border radius">
                                                    <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                    <input type="text" name="quantity" class="qty-val" value="1" min="1">
                                                    <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                                </div> -->
                                                <!-- <div class="product-extra-link2"> -->
                                                        <!-- <button @click="addToCart(item)" class="button button-add-to-cart"><i class="fi-rs-shopping-cart"></i>Add to cart</button> -->
                                                        <!-- <a aria-label="Add To Wishlist" class="action-btn hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a> -->
                                                        <!-- <a aria-label="Compare" class="action-btn hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a> -->
                                                <!-- </div>
                                            </div>
                                            </div>
                                            <div v-else>
                                            <div class="detail-extralink"> -->
                                                <!-- <div class="detail-qty border radius">
                                                    <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                    <input type="text" name="quantity" class="qty-val" value="1" min="1">
                                                    <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                                </div> -->
                                                <!-- <div class="product-extra-link2"> -->
                                                        <!-- <a aria-label="Add To Wishlist" class="action-btn hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a> -->
                                                        <!-- <a aria-label="Compare" class="action-btn hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a> -->
                                                <!-- </div>
                                            </div>
                                            </div> -->
                                            <!-- <div class="font-xs">
                                                <ul class="mr-50 float-start"> -->
                                                    <!-- <li class="mb-5">Type: <span class="text-brand">Organic</span></li> -->
                                                    <!-- <li class="mb-5">MFG:<span class="text-brand"> Jun 4.2022</span></li> -->
                                                    <!-- <li>LIFE: <span class="text-brand">70 days</span></li> -->
                                                <!-- </ul>
                                                <ul class="float-start">
{{--                                                    <li class="mb-5">SKU: <a href="#">@{{ productCode }}</a></li>--}}
{{--                                                    <li class="mb-5">Tags: <a href="#" rel="tag">@{{ products }}</a></li>--}}
{{--                                                    <li>Stock:<span class="in-stock text-brand ml-5">@{{ stock }} Items In Stock</span></li>--}}
                                                </ul>
                                            </div> -->
                                        </div>
                                        <!-- Detail Info -->
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="detail-info pr-30 pl-30">
                                            <h2 class="title-detail">Kalkulator Investasi:</h2>
                                                <div class="row">
                                                    <div class="col-3">
                                                    <!-- <span class="stock-status out-stock"> Sale Off </span> -->
                                                        
                                                        <label>Lot Dibeli</label>
                                                        <input class="form-control" type="number" id="lotBuy" oninput="this.value=this.value.replace(/[^0-9]/g,'');" onkeyup="javascript:subtract(this.value, obj('pricePerLot').value, obj('dividendAnnualReturn').value)" />
                                                        
                                                        <input type="hidden" id="pricePerLot" value="{{ $campaign->pricePerLot }}" onkeyup="javascript:subtract(obj('lotBuy').value, this.value, obj('dividendAnnualReturn').value)"/>
                                                        <input type="hidden" id="dividendAnnualReturn" value="{{ $campaign->dividendAnnualReturn }}" onkeyup="javascript:subtract(obj('lotBuy').value, obj('pricePerLot').value, this.value)"/>
                                                    </div>
                                                    <div class="col-9">
                                                        <label>Perkiraan Imbal Hasil per Periode Dividen:</label> 
                                                        
                                                        <input class="form-control" type="text" id="total" readonly/>
                                                    </div>
                                                </div>
                                            
                                        </div>
                                    </div>
                                
                                @if(is_array($campaign->campaignProspectus) || is_array($campaign->campaignProspectus))
                                    @if(is_array($campaign->campaignExecSummary))
                                        <hr>
                                        <div id="printedItemContentFrame" style="height: 100%; min-height: 800px;">                                

                                        <h2 class="title-detail">Deskripsi:</h2>
                                        @foreach ($campaign->campaignExecSummary as $camdesc)
                                        
                                            <iframe src="{{ $camdesc }}" id="print-iframe" 
                                                    style="height:100%;width: 100%; min-height: 800px;border:none"></iframe>
                                        
                                        @endforeach
                                    </div>
                                    @endif
                                    
                                    @if(is_array($campaign->campaignProspectus))
                                        <hr>
                                        <div id="printedItemContentFrame" style="height: 100%; min-height: 800px;">
                                        <h2 class="title-detail">Propspectus:</h2>
                                        @foreach ($campaign->campaignProspectus as $campros)
                                            <iframe src="{{ $campros }}" id="print-iframe" 
                                                    style="height:100%;width: 100%; min-height: 800px;border:none"></iframe>
                                        
                                        @endforeach
                                        </div>
                                    @endif
                                    
                                @endif
                </div>
            </div>
        </div>
    </main>
