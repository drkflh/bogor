<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="I" />
        <meta name="keywords" content="bootstrap 5, premium, marketing, multipurpose" />
        <meta name="author" content="Coderthemes" />

        <!-- Site Title -->
        <title>{{ env('SITE_TITLE') }}</title>
        <!-- Site favicon -->
        <!-- Light-box -->
        <link rel="stylesheet" href="{{ url('themes/dojek') }}/css/mklb.css" type="text/css" />

        <!-- Swiper js -->
        <link rel="stylesheet" href="{{ url('themes/dojek') }}/css/swiper-bundle.min.css" type="text/css" />

        <!--Material Icon -->
        <link rel="stylesheet" type="text/css" href="{{ url('themes/dojek') }}/css/materialdesignicons.min.css" />

        <link rel="stylesheet" href="{{ url('themes/dojek') }}/css/bootstrap.min.css" type="text/css" />
        <link rel="stylesheet" type="text/css" href="{{ url('themes/dojek') }}/css/style.css" />
        <!-- icon line -->
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <link rel="shortcut icon" href="{{ url(env('APP_FAVICON', 'favicon.ico')) }}"/>
        <script src="{{ url( 'js/jquery-3.6.0.min.js' ) }}"></script>

        @yield('js')
    </head>

    <body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="60">
        <!--Navbar Start-->
        <nav class="navbar navbar-expand-lg fixed-top navbar-custom navbar-light sticky-dark" id="navbar-sticky">
            <div class="container">
                <!-- LOGO -->
                <a class="logo text-uppercase" href="{{ url('/') }}">
                    <img src="{{ url( env('APP_LOGO_LIGHT') ) }}" alt="" height="75">
                    @if(env('LOGO_TEXT', false ))
                        <span class="sidebar-brand" style="font-size: 15pt;font-weight: bold;">{{ env('SITE_TITLE') }}</span>
                    @endif
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="mdi mdi-menu"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ms-auto navbar-center" id="mySidenav">
                        @include('partials.app.ecf.open')
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Navbar End -->

        <!-- home-agency start -->
        <section class="hero-3" id="home">
           <div class="container-lg">
               <div class="row align-items-center justify-content-evenly">
                    <div class="col-lg-5">
                        <div class="hero-3-img mb-5 mb-lg-0">
                            <img src="{{ url('themes/dojek') }}/images/heros/hero-3-img.jpg" alt="" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-lg-7 col-xl-6 justify-content-center">
                        <h1 class="text-white hero-title fw-normal">{{ $title }}</h1>
                        @yield('auth_form')
                    </div>
               </div>
           </div>
        </section>
        <!-- home-agency end -->

        <!-- footer & cta start -->
        <section class="footer bg-light">
{{--            <div class="cta-content">--}}
{{--                <div class="container">--}}
{{--                    <div class="row bg-dark cta-bg p-5 rounded align-items-center">--}}
{{--                        <div class="col-lg-6">--}}
{{--                            <h3 class="text-white fs-26 mb-3">Subscribe our newsletter</h3>--}}
{{--                            <p class="text-white opacity-75 mb-4 mb-lg-0">Et harum quidem rerum facilis est us et expedita distinctio am libero tempore cum soluta nobis.</p>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-5 offset-lg-1">--}}
{{--                            <div class="subscribe-form">--}}
{{--                                <i class="mdi mdi-email-outline form-icon"></i>--}}
{{--                                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Enter Email Address" />--}}
{{--                                <a href="{{ url('themes/dojek') }}/javascript:void(0);" class="btn btn-primary form-btn">Get Access</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 text-center text-lg-start">
                        <div class="footer-logo mb-4">
                            <a href="{{ url('/') }}/#">
                                <img src="{{ url( env('APP_LOGO') ) }}" alt="" height="50">
                            </a>
                        </div>
                        <a href="{{ url('themes/dojek') }}/#" class="text-muted m-2">Hello@coderthemes.com</a>
                        <p class="text-muted m-2">+01 ( 1234 567 890 )</p>
                    </div>
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <h5 class="fs-22 mb-3 fw-semibold">About Us</h5>
                                <ul class="list-unstyled footer-nav">
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Support Center</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Customer Support</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">About Us</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Copyright</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Popular Campaign</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <h5 class="fs-22 mb-3 fw-semibold">Our Information</h5>
                                <ul class="list-unstyled footer-nav">
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Return Policy</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Privacy Policy</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Terms & Conditions</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Site Map</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Store Hours</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <h5 class="fs-22 mb-3 fw-semibold">My Account</h5>
                                <ul class="list-unstyled footer-nav">
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Press Inquiries</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Social Media Directories</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Images & B-roll</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Permissions</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Speaker Requests</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <h5 class="fs-22 mb-3 fw-semibold">Policy</h5>
                                <ul class="list-unstyled footer-nav">
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Application Security</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Softwere Principles</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Unwanted Softwere Policy</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Risponsible Supply Chain</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- footer & cta end -->

        <!-- Back to top -->
        <a href="{{ url('themes/dojek') }}/#" onclick="topFunction()" class="back-to-top-btn btn btn-dark" id="back-to-top"><i class="mdi mdi-chevron-up"></i></a>

        <!-- javascript -->
        <script src="{{ url('themes/dojek') }}/js/bootstrap.bundle.min.js"></script>
        <!-- Portfolio filter -->
        <script src="{{ url('themes/dojek') }}/js/filter.init.js"></script>
        <!-- Light-box -->
        <script src="{{ url('themes/dojek') }}/js/mklb.js"></script>
        <!-- swiper -->
        <script src="{{ url('themes/dojek') }}/js/swiper-bundle.min.js"></script>
        <script src="{{ url('themes/dojek') }}/js/swiper.js"></script>

        <!-- counter -->
        <script src="{{ url('themes/dojek') }}/js/counter.init.js"></script>
        <script src="{{ url('themes/dojek') }}/js/app.js"></script>
    </body>
</html>
