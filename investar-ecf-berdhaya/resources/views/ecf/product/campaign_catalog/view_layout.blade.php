<link rel="stylesheet" href="{{ asset('themes/nest_frontend/assets/css/main.css?v=5.3') }}" />
<link rel="stylesheet" href="{{ asset('themes/nest_frontend/assets/css/plugins/animate.min.css') }}" />
    
    <main class="main">
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
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="detail-info pr-30 pl-30">
                                            <span class="stock-status out-stock"> Sale Off </span>
                                            <h2 class="title-detail">@{{ productName }}</h2>
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
                                            <div v-if = "stock != '0'">
                                            <div class="detail-extralink mb-50">
                                                <!-- <div class="detail-qty border radius">
                                                    <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                    <input type="text" name="quantity" class="qty-val" value="1" min="1">
                                                    <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                                </div> -->
                                                <div class="product-extra-link2">
                                                        <button @click="addToCart(item)" class="button button-add-to-cart"><i class="fi-rs-shopping-cart"></i>Add to cart</button>
                                                        <!-- <a aria-label="Add To Wishlist" class="action-btn hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a> -->
                                                        <!-- <a aria-label="Compare" class="action-btn hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a> -->
                                                </div>
                                            </div>
                                            </div>
                                            <div v-else>
                                            <div class="detail-extralink">
                                                <!-- <div class="detail-qty border radius">
                                                    <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                    <input type="text" name="quantity" class="qty-val" value="1" min="1">
                                                    <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                                </div> -->
                                                <div class="product-extra-link2">
                                                        <!-- <a aria-label="Add To Wishlist" class="action-btn hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a> -->
                                                        <!-- <a aria-label="Compare" class="action-btn hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a> -->
                                                </div>
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
                                                    <li>Stock:<span class="in-stock text-brand ml-5">@{{ stock }} Items In Stock</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Detail Info -->
                                    </div>
                                </div>
                            </div>
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
                                        <a href="{{ url('catalog/list/cat/'.$cats->slug ) }}">{{ $cats->category }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>