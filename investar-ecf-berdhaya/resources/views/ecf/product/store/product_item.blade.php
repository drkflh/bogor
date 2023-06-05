{{--<div class="col-lg-1-5 col-md-4 col-12 col-sm-6">--}}
    <div class="product-cart-wrap mb-5 h-100 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
        <div class="product-img-action-wrap">
            <div class="product-img product-img-zoom">
                <a href="{{ url('themes/nest_frontend') }}/shop-product-right.html">
                    <img class="default-img" :src="_.first( item.picture )" alt=""
                         onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/blank.png' ) ) }}';"
                    />
                    <img class="hover-img" src=" " alt=""
                         onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/blank.png' ) ) }}';"
                    />
                </a>
            </div>
            <div class="product-action-1">
                <a aria-label="Add To Wishlist" class="action-btn" @click="addToWishlist(item)" ><i class="fi-rs-heart"></i></a>
{{--                <a aria-label="Compare" class="action-btn" href="{{ url('themes/nest_frontend') }}/shop-compare.html"><i class="fi-rs-shuffle"></i></a>--}}
                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
            </div>
            <div class="product-badges product-badges-position product-badges-mrg">
                <span class="hot">Hot</span>
            </div>
        </div>
        <div class="product-content-wrap" >
            <div class="product-category">
                <a :href="'{{ url('catalog/list/cat/') }}' + item.category">@{{ item.productCategory }}</a>
            </div>
            <h2 style="min-height: 30pt;" ><a :href="'{{ url('catalog/view') }}/' + item._id">@{{ item.productName }}</a></h2>
            <div class="product-rate-cover">
                <div class="product-rate d-inline-block">
                    <div class="product-rating" style="width: 90%"></div>
                </div>
                <span class="font-small ml-5 text-muted"> (4.0)</span>
            </div>
            <div>
                <span class="font-small text-muted">By <a href="{{ url('vendor/view') }}">@{{ item.vendor }}</a></span>
            </div>
            <div class="product-price">
{{--                <span>{{ $c['currency'] }} {{  App\Helpers\NumberUtil::currency( $c['price']) }} {{ $c['unit'] }}</span>--}}
{{--                @if( ($c['isPromo'] ?? false) )--}}
{{--                    <span class="old-price">$32.8</span>--}}
{{--                @endif--}}
            </div>
            <div class="product-card-bottom">
                <div class="add-cart">
                    <span class="add" @click="addToCart(item)" ><i class="fi-rs-shopping-cart mr-5"></i>Add </span>
                </div>
            </div>
        </div>
    </div>
{{--</div>--}}
