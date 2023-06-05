     
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
                                        <figure class="border-radius-10">
                                             {!! $picture ?? '' !!}
                                        </figure>
                                        <figure class="border-radius-10">
                                             {!! $picture ?? '' !!}
                                        </figure>
                                        <figure class="border-radius-10">
                                             {!! $picture ?? '' !!}
                                        </figure>
                                        <figure class="border-radius-10">
                                             {!! $picture ?? '' !!}
                                        </figure>
                                        <figure class="border-radius-10">
                                             {!! $picture ?? '' !!}
                                        </figure>
                                        <figure class="border-radius-10">
                                             {!! $picture ?? '' !!}
                                        </figure>
                                    </div>
 
                                </div>
                                <!-- End Gallery -->
                                <div class="detail-extralink mb-50">
                                    <span class="stock-status out-stock"> @{{ products }} </span>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-info pr-30 pl-30">
                                    <span class="stock-status out-stock"> Special offer </span>
                                    <h2 class="title-detail"> @{{ productName }}</h2>
                                    <!-- <div class="product-detail-rating">
                                        <div class="product-rate-cover text-end">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted">@{{category}}</span>
                                        </div>
                                    </div> -->
                                    <div class="clearfix product-price-cover">
                                        <div class="product-price primary-color float-left">
                                            <span class="current-price text-brand">Rp.&nbsp;@{{ price }}</span>
                                        </div>
                                    </div>
                                    <div class="short-desc mb-30">
                                        <p class="font-lg">@{{ description }}</p>
                                    </div>
                                    <div class="attr-detail attr-size mb-30">
                                        <strong class="mr-10">Size / Weight: </strong>
                                        <ul class="list-filter size-filter font-small">
                                            <li><a href="#">@{{ unit }}</a></li>
                                        </ul>
                                    </div>
                                    <div class="detail-extralink mb-50">
                                        <div class="detail-qty border radius">
                                            <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                            <input type="text" name="quantity" class="qty-val" value="1" min="1">
                                            <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                        </div>
                                        <!-- <div class="product-extra-link2">
                                            <button type="submit" class="button button-add-to-cart"><i class="fi-rs-shopping-cart"></i>Add to cart</button>
                                            <a aria-label="Add To Wishlist" class="action-btn hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                        </div> -->
                                    </div>
                                    <div class="font-xs">
                                        <ul class="mr-50 float-start">
                                            <li class="mb-5">SKU: <a href="#">@{{ productCode }}</a></li>
                                            <!-- <li class="mb-5">Type: <span class="text-brand">@{{ productCode }}</span></li> -->
                                            <li class="mb-5">Unit:<span class="text-brand"> @{{ unit }}</span></li>
                                          
                                        </ul>
                                        <ul class="float-start">
                                            <!-- <li class="mb-5">Tags: <a href="#">@{{ products }}</a></li> -->
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
    
  
    <!-- Vendor JS-->
    <script src="assets/js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="assets/js/vendor/jquery-migrate-3.3.0.min.js"></script>
    <script src="assets/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="assets/js/plugins/slick.js"></script>
    <script src="assets/js/plugins/jquery.syotimer.min.js"></script>
    <script src="assets/js/plugins/wow.js"></script>
    <script src="assets/js/plugins/perfect-scrollbar.js"></script>
    <script src="assets/js/plugins/magnific-popup.js"></script>
    <script src="assets/js/plugins/select2.min.js"></script>
    <script src="assets/js/plugins/waypoints.js"></script>
    <script src="assets/js/plugins/counterup.js"></script>
    <script src="assets/js/plugins/jquery.countdown.min.js"></script>
    <script src="assets/js/plugins/images-loaded.js"></script>
    <script src="assets/js/plugins/isotope.js"></script>
    <script src="assets/js/plugins/scrollup.js"></script>
    <script src="assets/js/plugins/jquery.vticker-min.js"></script>
    <script src="assets/js/plugins/jquery.theia.sticky.js"></script>
    <script src="assets/js/plugins/jquery.elevatezoom.js"></script>
    <!-- Template  JS -->
    <script src="./assets/js/main.js?v=5.3"></script>
    <script src="./assets/js/shop.js?v=5.3"></script>
