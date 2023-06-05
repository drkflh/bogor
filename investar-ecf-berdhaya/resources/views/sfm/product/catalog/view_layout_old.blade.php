<link rel="stylesheet" href="{{ asset('themes/nest_frontend/assets/css/main.css?v=5.3') }}" />
<link rel="stylesheet" href="{{ asset('themes/nest_frontend/assets/css/plugins/animate.min.css') }}" />
    
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            
        </div>
        <div class="container mb-30">
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
<<<<<<< HEAD
                                    <!-- THUMBNAILS -->
                                    <!-- <div class="slider-nav-thumbnails mb-50">
                                        <div><img src="assets/imgs/shop/thumbnail-3.jpg" alt="product image" /></div>
                                        <div><img src="assets/imgs/shop/thumbnail-4.jpg" alt="product image" /></div>
                                        <div><img src="assets/imgs/shop/thumbnail-5.jpg" alt="product image" /></div>
                                        <div><img src="assets/imgs/shop/thumbnail-6.jpg" alt="product image" /></div>
                                        <div><img src="assets/imgs/shop/thumbnail-7.jpg" alt="product image" /></div>
                                        <div><img src="assets/imgs/shop/thumbnail-8.jpg" alt="product image" /></div>
                                        <div><img src="assets/imgs/shop/thumbnail-9.jpg" alt="product image" /></div>
                                    </div> -->
=======
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="detail-info pr-30 pl-30">
                                            <span class="stock-status out-stock"> Sale Off </span>
                                            <h2 class="title-detail">@{{ productName }}</h2>
                                            <?php
                                                $id = request()->route('id');
                                                $getRate = \App\Models\Reference\Product::select('rate')->where('_id', '=', $id)->first();
                                                $rate = $getRate['rate'];   
                                            ?>
                                            <div class="product-detail-rating">
                                                <div class="product-rate-cover text-end">
                                                    @if ($rate == '0')
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width: 0%"></div>
                                                    </div>
                                                    @endif
                                                    @if ($rate == '1')
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width: 20%"></div>
                                                    </div>
                                                    @endif
                                                    @if ($rate == '2')
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width: 40%"></div>
                                                    </div>
                                                    @endif
                                                    @if ($rate == '3')
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width: 60%"></div>
                                                    </div>
                                                    @endif
                                                    @if ($rate == '4')
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width: 80%"></div>
                                                    </div>
                                                    @endif
                                                    @if ($rate == '5')
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width: 100%"></div>
                                                    </div>
                                                    @endif
                                                    <span class="font-small ml-5 text-muted">{{ $rate }} out of 5</span>
                                                </div>
                                            </div>
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
                                                    <li><a href="#">@{{ weight }}g</a></li>
                                                </ul>
                                            </div>
                                            <div class="detail-extralink mb-50">
                                                <div class="detail-qty border radius">
                                                    <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                    <input type="text" name="quantity" class="qty-val" value="1" min="1">
                                                    <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                                </div>
                                                <div class="product-extra-link2">
                                                    <button @click="addToCart(item)" class="button button-add-to-cart"><i class="fi-rs-shopping-cart"></i>Add to cart</button>
                                                    <!-- <a aria-label="Add To Wishlist" class="action-btn hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a> -->
                                                    <!-- <a aria-label="Compare" class="action-btn hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a> -->
                                                </div>
                                            </div>
                                            <div class="font-xs">
                                                <ul class="mr-50 float-start">
                                                    <!-- <li class="mb-5">Type: <span class="text-brand">Organic</span></li> -->
                                                    <!-- <li class="mb-5">MFG:<span class="text-brand"> Jun 4.2022</span></li> -->
                                                    <!-- <li>LIFE: <span class="text-brand">70 days</span></li> -->
                                                </ul>
                                                <ul class="float-start">
                                                    <li class="mb-5">SKU: <a href="#">@{{ productCode }}</a></li>
                                                    <li class="mb-5">Tags: <a href="#" rel="tag">@{{ products }}</a></li>
                                                    <!-- <li>Stock:<span class="in-stock text-brand ml-5">8 Items In Stock</span></li> -->
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Detail Info -->
                                    </div>
>>>>>>> 3ed99724eaa301e99611bed653e313bad14ec8b5
                                </div>
                            </div>
<<<<<<< HEAD
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-info pr-30 pl-30">
                                    <span class="stock-status out-stock"> Special Offer </span>
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
=======
                        </div>
                        <?php
                            $categories = \App\Models\Reference\ProductCategory::get();
                        ?>
                        <div class="col-xl-3 primary-sidebar sticky-sidebar mt-30">
                            <div class="sidebar-widget widget-category-2 mb-30">
                                <h5 class="section-title style-1 mb-30">Category</h5>
                                <ul>
                                    @foreach ($categories as $cats)
                                    <li>
                                        <a href="#">{{ $cats->category }}</a>
                                    </li>
                                    @endforeach
                                </ul>
>>>>>>> 3ed99724eaa301e99611bed653e313bad14ec8b5
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>