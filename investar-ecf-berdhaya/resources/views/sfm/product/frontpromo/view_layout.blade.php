<link rel="stylesheet" href="{{ asset('themes/nest_frontend/assets/css/main.css?v=5.3') }}" />
<link rel="stylesheet" href="{{ asset('themes/nest_frontend/assets/css/plugins/animate.min.css') }}" />

<main class="main">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                            <div class="product-detail accordion-detail">
                                <div class="row mb-50 mt-30">
                                    <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                                        <div class="detail-gallery">
                                            <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                            <!-- MAIN SLIDES -->
                                            <div class="product-image-slider">
                                                <figure class="border-radius-10">
                                                    {!! $picture ?? '' !!}
                                                </figure>
                                            </div>
                                            <!-- THUMBNAILS -->
                                            <div class="slider-nav-thumbnails">
                                                <div><img src="assets/imgs/shop/thumbnail-3.jpg" alt="product image" /></div>
                                            </div>
                                        </div>
                                        <!-- End Gallery -->
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="detail-info pr-30 pl-30">
                                            <span class="stock-status out-stock"> Kode Promo: @{{ promoCode }}</span>
                                            <h2 class="title-detail"> @{{ name }} </h2>
                                            <div class="short-desc mb-30">
                                                <p class="font-lg"> @{{ description }} </p>
                                            </div>
                                            <div class="attr-detail attr-size mb-30">
                                                <strong class="mr-10">Periode Promo:  </strong>
                                                <ul class="list-filter size-filter font-small">
                                                    <li>{!! $periodStart ?? '' !!}</li>
                                                    <li>{!! $periodEnd ?? '' !!}</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Detail Info -->
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </main>