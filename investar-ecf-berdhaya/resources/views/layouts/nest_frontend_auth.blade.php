<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ env('SITE_NAME','') }} - {{ env('SITE_TITLE') }}</title>
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
    <link rel="stylesheet" href="{{ url('themes/nest_frontend') }}/assets/css/main.css?v=5.3" />

    {{-- icon line --}}
    <link rel="stylesheet" href="{{ url('line-awesome-master/dist/font-awesome-line-awesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ url('line-awesome-master/dist/line-awesome/css/line-awesome.min.css') }}">

    <style>
        .form-select {
            line-height: 3.1rem !important;
        }
        .input-group-prepend .form-select {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        .input-group-append button {
            height: 64px;
        }
    </style>
</head>

<body
    style="background-image: url( '{{ url( env('BG_PATTERNS', 'images/patterns/50872.jpg') ) }}' );background-repeat: repeat;background-size: initial; background-position: bottom;background-attachment: fixed;"
>
     <!-- <header class="header-area header-style-1 header-height-2">  -->
        <!-- <div class="mobile-promotion">
            <span>Grand opening, <strong>up to 15%</strong> off all items. Only <strong>3 days</strong> left</span>
        </div> -->
        <!-- Top view -->

        <!-- End Top view -->

        <!-- Main Head view -->
        <?php
        $content = \App\Helpers\CmsUtil::getArticleByCategorySlug('campaign-list');
        $cat = \App\Helpers\CmsUtil::getCategoryBySlug('campaign-list');
        $aux = [
            'head'=>'',
            'title'=>($cat['categoryName'] ?? ''),
            'description'=>($cat['categoryDescription'] ?? '')
        ];
        ?>
        {!! \App\Helpers\CmsUtil::singleBlock( $content, 'main_head', 'nest_frontend', $aux ) !!}

       <!-- End Main Head view -->

       <!-- Main Head Nav view -->
{{--        {!! \App\Helpers\CmsUtil::singleBlock( $content, 'main_head_nav', 'nest_frontend', $aux ) !!}--}}
<!-- End Main Head Nav view -->
    </header>
    <div class="mobile-header-active mobile-header-wrapper-style">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-top">
                <div class="mobile-header-logo d-flex align-items-center justify-content-center">
                    <a href="{{ url('/') }}"><img src="{{ url( env('APP_LOGO')) }}" alt="logo" style="width: 75px;" /></a>
                </div>
                <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                    <button class="close-style search-close">
                        <i class="icon-top"></i>
                        <i class="icon-bottom"></i>
                    </button>
                </div>
            </div>
            <div class="mobile-header-content-area">
                <div class="mobile-search search-style-3 mobile-header-border">test 2
                    <form action="catalog" method="get">
                        <input type="text" name="keyword" placeholder="Search for items…" />
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
                    <a href="{{ url('themes/nest_frontend') }}/#"><img src="{{ url('themes/nest_frontend') }}/assets/imgs/theme/icons/icon-facebook-white.svg" alt="" /></a>
                    <a href="{{ url('themes/nest_frontend') }}/#"><img src="{{ url('themes/nest_frontend') }}/assets/imgs/theme/icons/icon-twitter-white.svg" alt="" /></a>
                    <a href="{{ url('themes/nest_frontend') }}/#"><img src="{{ url('themes/nest_frontend') }}/assets/imgs/theme/icons/icon-instagram-white.svg" alt="" /></a>
                    <a href="{{ url('themes/nest_frontend') }}/#"><img src="{{ url('themes/nest_frontend') }}/assets/imgs/theme/icons/icon-pinterest-white.svg" alt="" /></a>
                    <a href="{{ url('themes/nest_frontend') }}/#"><img src="{{ url('themes/nest_frontend') }}/assets/imgs/theme/icons/icon-youtube-white.svg" alt="" /></a>
                </div>
            </div>
        </div>
    </div>
    <!--End header-->
    <main class="main pages">
        @yield('breadcumb')
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6 m-auto">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="login_wrap widget-taber-content background-white">
                                            <div class="padding_eight_all bg-white">
                                                <div class="heading_s1">
                                                    <h1 class="mb-5">{{ $title }}</h1>
                                                </div>
                                                @yield('auth_form')
                                            </div>
                                        </div>
                                    </div>
                                    {{--                            <div class="col-lg-6 pr-30 d-none d-lg-block">--}}
                                    {{--                                <div class="card-login mt-115">--}}
                                    {{--                                    <a href="{{ url('themes/nest_frontend') }}/#" class="social-login facebook-login">--}}
                                    {{--                                        <img src="{{ url('themes/nest_frontend') }}/assets/imgs/theme/icons/logo-facebook.svg" alt="" />--}}
                                    {{--                                        <span>Continue with Facebook</span>--}}
                                    {{--                                    </a>--}}
                                    {{--                                    <a href="{{ url('themes/nest_frontend') }}/#" class="social-login google-login">--}}
                                    {{--                                        <img src="{{ url('themes/nest_frontend') }}/assets/imgs/theme/icons/logo-google.svg" alt="" />--}}
                                    {{--                                        <span>Continue with Google</span>--}}
                                    {{--                                    </a>--}}
                                    {{--                                    <a href="{{ url('themes/nest_frontend') }}/#" class="social-login apple-login">--}}
                                    {{--                                        <img src="{{ url('themes/nest_frontend') }}/assets/imgs/theme/icons/logo-apple.svg" alt="" />--}}
                                    {{--                                        <span>Continue with Apple</span>--}}
                                    {{--                                    </a>--}}
                                    {{--                                </div>--}}
                                    {{--                            </div>--}}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="main">

        <!--End newsletter-->

        <!--End Features-->

        {!! \App\Helpers\CmsUtil::singleBlock( $content, 'footer_company', 'nest_frontend', $aux ) !!}
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
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/wow.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/perfect-scrollbar.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/magnific-popup.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/select2.min.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/waypoints.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/counterup.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/jquery.countdown.min.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/images-loaded.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/isotope.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/scrollup.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/jquery.vticker-min.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/jquery.theia.sticky.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/jquery.elevatezoom.js"></script>
    <!-- Template  JS -->
    <script src="{{ url('themes/nest_frontend') }}/./assets/js/main.js?v=5.3"></script>
    <script src="{{ url('themes/nest_frontend') }}/./assets/js/shop.js?v=5.3"></script>

    <script>

        $(document).ready(function(){

        });

        function pasVis() {
            x = $('#password');
            y = $('#iconPass');

            console.log('x', x);
            console.log('y', y);

            if (x.prop('type') === "password") {
                x.prop('type', 'text');
                y.removeClass().addClass('las la-eye-slash');
            } else {
                x.prop('type', 'password');
                y.removeClass().addClass('las la-eye');
            }
        }

    </script>
</body>

</html>
