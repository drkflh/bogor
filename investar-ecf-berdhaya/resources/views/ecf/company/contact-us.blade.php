<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ env('SITE_NAME', '') }} - {{ env('SITE_TITLE') }}</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url(env('APP_FAVICON', 'favicon.ico')) }}" />
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ url('themes/nest_frontend') }}/assets/css/plugins/animate.min.css" />
    <link rel="stylesheet" href="{{ url('themes/nest_frontend') }}/assets/css/main.css?v=5.3" />
</head>

<body
    style="background-image: url( '{{ url(env('BG_PATTERNS', 'images/patterns/50872.jpg')) }}' );background-repeat: repeat;background-size: initial; background-position: bottom;background-attachment: fixed;">
    <!-- Modal -->

    <!-- Quick view -->

    <header class="header-area header-style-1 header-height-2">
        {{-- <div class="mobile-promotion"> --}}
        {{-- <span>Grand opening, <strong>up to 15%</strong> off all items. Only <strong>3 days</strong> left</span> --}}
        {{-- </div> --}}
        <!-- Top view -->

        <!-- End Top view -->

        <!-- Main Head view -->
        <?php
        $content = \App\Helpers\CmsUtil::getArticleByCategorySlug('campaign-list');
        $cat = \App\Helpers\CmsUtil::getCategoryBySlug('campaign-list');
        $aux = [
            'head' => '',
            'title' => $cat['categoryName'] ?? '',
            'description' => $cat['categoryDescription'] ?? '',
        ];
        ?>
        {!! \App\Helpers\CmsUtil::singleBlock($content, 'main_head', 'nest_frontend', $aux) !!}

        <!-- End Main Head view -->

        <!-- Main Head Nav view -->
        {!! \App\Helpers\CmsUtil::singleBlock($content, 'main_head_nav', 'nest_frontend', $aux) !!}
        <!-- End Main Head Nav view -->

    </header>
    <div class="mobile-header-active mobile-header-wrapper-style">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-top">
                <div class="mobile-header-logo d-flex align-items-center justify-content-center">
                    <a href="{{ url('/') }}"><img src="{{ url(env('APP_LOGO')) }}" alt="logo"
                            style="width: 75px;" /></a>
                </div>
                <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                    <button class="close-style search-close">
                        <i class="icon-top"></i>
                        <i class="icon-bottom"></i>
                    </button>
                </div>
            </div>
            <div class="mobile-header-content-area">
                <div class="mobile-search search-style-3 mobile-header-border">
                    <form action="#">
                        <input type="text" placeholder="Search for items…" />
                        <button type="submit"><i class="fi-rs-search"></i></button>
                    </form>
                </div>
                <div class="mobile-menu-wrap mobile-header-border" style="margin-bottom: 35px;">
                    <!-- mobile menu start -->
                    <nav>
                        <ul class="mobile-menu font-heading">
                            <li class="menu-item">
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ url('/') }}">Shop</a>
                            </li>
                        </ul>
                    </nav>
                    <!-- mobile menu end -->
                </div>
                <div class="mobile-social-icon mb-50 mt-5" style="margin-top: 35px;">
                    <h6 class="mb-15">Follow Us</h6>
                    <a href="{{ url('themes/nest_frontend') }}/#"><img
                            src="{{ url('themes/nest_frontend') }}/assets/imgs/theme/icons/icon-facebook-white.svg"
                            alt="" /></a>
                    <a href="{{ url('themes/nest_frontend') }}/#"><img
                            src="{{ url('themes/nest_frontend') }}/assets/imgs/theme/icons/icon-twitter-white.svg"
                            alt="" /></a>
                    <a href="{{ url('themes/nest_frontend') }}/#"><img
                            src="{{ url('themes/nest_frontend') }}/assets/imgs/theme/icons/icon-instagram-white.svg"
                            alt="" /></a>
                    <a href="{{ url('themes/nest_frontend') }}/#"><img
                            src="{{ url('themes/nest_frontend') }}/assets/imgs/theme/icons/icon-pinterest-white.svg"
                            alt="" /></a>
                    <a href="{{ url('themes/nest_frontend') }}/#"><img
                            src="{{ url('themes/nest_frontend') }}/assets/imgs/theme/icons/icon-youtube-white.svg"
                            alt="" /></a>
                </div>
            </div>
        </div>
    </div>
    <!--End header-->
    <main class="main">
        <!--Hero slider-->

        <!--End hero slider-->

        <!--Category slider-->

        <!--End category slider-->

        <!--Banners-->

        <!--End banners-->
        <!--Products Tabs-->
        <section class="product-tabs section-padding position-relative">
            <div class="container">
                <div class="section-title style-2 wow animate__animated animate__fadeIn">
                    <h4>{{ $title }}</h4>
                </div>
            </div>
            </endsection>

            <div class="row">
                    <div class="col col-md-4 text-center mb-5 mt-5">
                        <div class="product-cart-container">
                            <div class="container ">
                                <div class="justify-content-center">
                                    {{-- <img class="img-fluid img-responsive w-50" src="{{ asset('images/upload.png') }}" alt="description of myimage"> --}}
                                    <h3 class="mb-5 mt-4 text-success">
                                        Email Kami
                                    </h3>
                                </div>
                                <div class="mb-5 p-1">
                                    <a class="bold" type="email">
                                        tokopanganrakyat@gmail.com
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-4 text-center mb-5 mt-5">
                        <div class="d-flex flex-column container justify-content-center">
                            <div class="product-cart-container">
                                <div class="container">
                                    <div class="justify-content-center">
                                        {{-- <img class="img-fluid img-responsive w-50" src="{{ asset('images/upload.png') }}" alt="description of myimage"> --}}
                                        <h3 class="mb-5 mt-4 text-success">
                                            Telepon Kami
                                        </h3>
                                    </div>
                                    <div class="mb-5 p-1">
                                        <a class="bold">
                                            (+62 21) - 52395419
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-4 text-center mb-5 mt-5">
                        <div class="d-flex flex-column container justify-content-center">
                            <div class="product-cart-container">
                                <div class="container">
                                    <div class="justify-content-center">
                                        {{-- <img class="img-fluid img-responsive w-50" src="{{ asset('images/upload.png') }}" alt="description of myimage"> --}}
                                        <h3 class="mb-5 mt-4 text-success">
                                            Alamat Kami
                                        </h3>
                                    </div>
                                    <div class="mb-5 p-1">
                                        <a class="bold">
                                            Rawa Melati Blok A1 No.5 Rt.3/RW.1 Tegal Alur, Kalideres Jakarta barat 11820
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <!--End Best Sales-->

            <!--End Deals-->

            <!--End 4 columns-->
    </main>
    <footer class="main">

        <!--End newsletter-->

        <!--End Features-->

        {!! \App\Helpers\CmsUtil::singleBlock($content, 'footer_company', 'nest_frontend', $aux) !!}
    </footer>
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src="{{ url('themes/nest_frontend') }}/assets/imgs/theme/loading.gif" alt="" />
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor JS-->
    <script src="{{ url('themes/nest_frontend') }}/assets/js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/vendor/jquery-migrate-3.3.0.min.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/slick.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/jquery.syotimer.min.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/waypoints.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/wow.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/perfect-scrollbar.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/magnific-popup.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/select2.min.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/counterup.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/jquery.countdown.min.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/images-loaded.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/isotope.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/scrollup.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/jquery.vticker-min.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/jquery.theia.sticky.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/jquery.elevatezoom.js"></script>
    <!-- Template  JS -->
    <script src="{{ url('themes/nest_frontend') }}/assets/js/main.js?v=5.3"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/shop.js?v=5.3"></script>
</body>

</html>
