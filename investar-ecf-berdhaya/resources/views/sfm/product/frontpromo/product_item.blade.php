{{--<div class="col-lg-1-5 col-md-4 col-12 col-sm-6">--}}
    <div class="product-cart-wrap mb-5 h-100 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
        <div class="product-img-action-wrap">
            <div class="product-img product-img-zoom">
                <a :href="'{{ url('promo/view') }}/' + item._id">
                    <img class="default-img" :src="_.first( item.picture )" alt=""
                         onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/blank.png' ) ) }}';"
                    />
                </a>
            </div>
            <!-- <div class="product-action-1">
                <a aria-label="Add To Wishlist" class="action-btn" @click="addToWishlist(item)" ><i class="fi-rs-heart"></i></a>
{{--                <a aria-label="Compare" class="action-btn" href="{{ url('themes/nest_frontend') }}/shop-compare.html"><i class="fi-rs-shuffle"></i></a>--}}
                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
            </div> -->
        </div>
        <div class="product-content-wrap" >
            <h2 style="min-height: 30pt;" ><a :href="'{{ url('promo/view') }}/' + item._id">@{{ item.name }}</a></h2>
            <div>
                <span class="font-small text-muted">Kode Promo: <a href="#">@{{ item.promoCode }}</a></span>
            </div>
            <div class="product-card-bottom">
                <div class="add-cart">
                    <a :href="'{{ url('promo/view') }}/' + item._id"><span class="add">Lihat Detail </span></a>
                </div>
            </div>
        </div>
    </div>
{{--</div>--}}

