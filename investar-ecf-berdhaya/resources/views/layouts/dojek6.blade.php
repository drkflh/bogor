<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="Premium Bootstrap 5 Landing Page Template" />
        <meta name="keywords" content="bootstrap 5, premium, marketing, multipurpose" />
        <meta name="author" content="Coderthemes" />

        <!-- Site Title -->
        <title>Dojek - Responsive Bootstrap 5 Landing Page Template</title>
        <!-- Site favicon -->
        <link rel="shortcut icon" href="{{ url('themes/dojek') }}/images/favicon.ico" />

        <!-- Light-box -->
        <link rel="stylesheet" href="{{ url('themes/dojek') }}/css/mklb.css" type="text/css" />

        <!-- Swiper js -->
        <link rel="stylesheet" href="{{ url('themes/dojek') }}/css/swiper-bundle.min.css" type="text/css" />

        <!--Material Icon -->
        <link rel="stylesheet" type="text/css" href="{{ url('themes/dojek') }}/css/materialdesignicons.min.css" />

        <link rel="stylesheet" href="{{ url('themes/dojek') }}/css/bootstrap.min.css" type="text/css" />
        <link rel="stylesheet" type="text/css" href="{{ url('themes/dojek') }}/css/style.css" />
    </head>

    <body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="60">
        <!--Navbar Start-->
        <nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky-dark" id="navbar-sticky">
            <div class="container">
                <!-- LOGO -->
                <a class="logo text-uppercase" href="{{ url('themes/dojek') }}/index-1.html">
                    <img src="{{ url('themes/dojek') }}/images/logo-dark.png" alt="" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="mdi mdi-menu"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ms-auto navbar-center" id="mySidenav">
                        <li class="nav-item">
                            <a href="{{ url('themes/dojek') }}/#home" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('themes/dojek') }}/#about" class="nav-link">About</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('themes/dojek') }}/#projects" class="nav-link">Projects</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('themes/dojek') }}/#testimonial" class="nav-link">Testimonial</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('themes/dojek') }}/#team" class="nav-link">Team</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Navbar End -->

        <!-- home-agency start -->
        <section class="hero-6" id="home">
           <div class="container">
               <div class="row justify-content-center">
                   <div class="col-lg-7">
                      <div class="text-center">
                            <h1 class="display-5 mb-4 fw-semibold hero-title">We Help Startups Launch Their Products</h1>
                            <p class="text-muted fs-18 lh-base mb-5">Aenean vulputate eleifend tellus eenean a ligula porttitor consequat vitae eleifend ac enim eliquam ante dapibus.</p>
                            <a href="{{ url('themes/dojek') }}/javascript:void(0);" class="play-btn" data-bs-toggle="modal" data-bs-target="#watchvideomodal">
                                <i class="mdi mdi-play play-icon"></i>
                            </a>

                            <div class="modal fade bd-example-modal-lg" id="watchvideomodal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog modal-lg">
                                    <div class="modal-content video-modal">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        <video id="VisaChipCardVideo" class="w-100" controls>
                                            <source src="{{ url('themes/dojek') }}/https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4" />
                                            <!--Browser does not support <video> tag -->
                                        </video>
                                    </div>
                                </div>
                            </div>
                      </div>
                   </div>
               </div>
           </div>
        </section>
        <!-- home-agency end -->

        <!-- About start -->
        <section class="section bg-light" id="about">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-md-8 col-lg-6 text-center">
                        <h6 class="subtitle">What We Do</h6>
                        <h2 class="title">The things motivates me is commen form of motivation.</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mt-5">
                            <div class="about-icon ms-3">
                                <img src="{{ url('themes/dojek') }}/images/agency/icon/1.png" alt="" class="img-fluid" />
                            </div>
                            <h5 class="fs-22 mt-4 pt-3 mb-3">Strategy & Research</h5>
                            <p class="text-muted">Et harum quidem as rerum facilis us est et distinctio nam libero temp soluta nobis esteligendi optio.</p>
                            <a href="{{ url('themes/dojek') }}/javascript:void(0);" class="text-danger">More About <i class="mdi mdi-arrow-right fs-14 ms-1"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mt-5">
                            <div class="about-icon ms-3">
                                <img src="{{ url('themes/dojek') }}/images/agency/icon/2.png" alt="" class="img-fluid" />
                            </div>
                            <h5 class="fs-22 mt-4 pt-3 mb-3">Design & Development</h5>
                            <p class="text-muted">Et harum quidem as rerum facilis us est et distinctio nam libero temp soluta nobis esteligendi optio.</p>
                            <a href="{{ url('themes/dojek') }}/javascript:void(0);" class="text-danger">More About <i class="mdi mdi-arrow-right fs-14 ms-1"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mt-5">
                            <div class="about-icon ms-3">
                                <img src="{{ url('themes/dojek') }}/images/agency/icon/3.png" alt="" class="img-fluid" />
                            </div>
                            <h5 class="fs-22 mt-4 pt-3 mb-3">Management & Marketing</h5>
                            <p class="text-muted">Et harum quidem as rerum facilis us est et distinctio nam libero temp soluta nobis esteligendi optio.</p>
                            <a href="{{ url('themes/dojek') }}/javascript:void(0);" class="text-danger">More About <i class="mdi mdi-arrow-right fs-14 ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About end -->

        <!-- Projects start -->
        <section class="section" id="projects">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-md-8 col-lg-6 text-center">
                        <h6 class="subtitle">Our Projects</h6>
                        <h2 class="title">A great design brings thousands of great results.</h2>
                    </div>
                </div>

                <div class="row">
                    <ul class="col busi-container-filter categories-filter text-center" id="filter">
                        <li><a class="categories tab-active active" onclick="filterSelection('all')">All Items</a></li>
                        <li><a class="categories tab-active" onclick="filterSelection('branding')">Design</a></li>
                        <li><a class="categories tab-active" onclick="filterSelection('designing')">Creative</a></li>
                        <li><a class="categories tab-active" onclick="filterSelection('photography')">Digital</a></li>
                        <li><a class="categories tab-active" onclick="filterSelection('development')">Photography</a></li>
                    </ul>
                </div>
                <!-- Gallary -->

                <div class="row justify-content-center">
                    <div class="col-md-6 col-xl-4 filter-box branding designing development">
                        <div class="card item-box rounded mt-4 overflow-hidden">
                            <div class="position-relative">
                                <img class="item-container img-fluid" src="{{ url('themes/dojek') }}/images/agency/project-img/1.jpg" alt="1" />
                                <div class="item-mask mfp-image" data-src="{{ url('themes/dojek') }}/images/agency/project-img/1.jpg" data-gallery="myGal"></div>
                            </div>
                            <div class="card-body">
                                <h5 class="fs-18 mb-1">The Language of Designs</h5>
                                <p class="text-muted mb-0">Design</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-4 filter-box photography">
                        <div class="card item-box rounded mt-4">
                            <div class="position-relative">
                                <img class="item-container img-fluid rounded" src="{{ url('themes/dojek') }}/images/agency/project-img/2.jpg" alt="2" />
                                <div class="item-mask mfp-image" data-src="{{ url('themes/dojek') }}/images/agency/project-img/2.jpg" data-gallery="myGal"></div>
                            </div>
                            <div class="card-body">
                                <h5 class="fs-18 mb-1">The Language of Designs</h5>
                                <p class="text-muted mb-0">Design</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-4 filter-box branding development">
                        <div class="card item-box rounded mt-4">
                            <div class="position-relative">
                                <img class="item-container img-fluid rounded" src="{{ url('themes/dojek') }}/images/agency/project-img/3.jpg" alt="3" />
                                <div class="item-mask mfp-image" data-src="{{ url('themes/dojek') }}/images/agency/project-img/3.jpg" data-gallery="myGal"></div>
                            </div>
                            <div class="card-body">
                                <h5 class="fs-18 mb-1">The Language of Designs</h5>
                                <p class="text-muted mb-0">Design</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-4 filter-box branding designing">
                        <div class="card item-box rounded mt-4">
                            <div class="position-relative">
                                <img class="item-container img-fluid rounded" src="{{ url('themes/dojek') }}/images/agency/project-img/4.jpg" alt="4" />
                                <div class="item-mask mfp-image" data-src="{{ url('themes/dojek') }}/images/agency/project-img/4.jpg" data-gallery="myGal"></div>
                            </div>
                            <div class="card-body">
                                <h5 class="fs-18 mb-1">The Language of Designs</h5>
                                <p class="text-muted mb-0">Design</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-4 filter-box branding designing">
                        <div class="card item-box rounded mt-4">
                            <div class="position-relative">
                                <img class="item-container img-fluid rounded" src="{{ url('themes/dojek') }}/images/agency/project-img/5.jpg" alt="5" />
                                <div class="item-mask mfp-image" data-src="{{ url('themes/dojek') }}/images/agency/project-img/5.jpg" data-gallery="myGal"></div>
                            </div>
                            <div class="card-body">
                                <h5 class="fs-18 mb-1">The Language of Designs</h5>
                                <p class="text-muted mb-0">Design</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-4 filter-box photography">
                        <div class="card item-box rounded mt-4">
                            <div class="position-relative">
                                <img class="item-container img-fluid rounded" src="{{ url('themes/dojek') }}/images/agency/project-img/6.jpg" alt="6" />
                                <div class="item-mask mfp-image" data-src="{{ url('themes/dojek') }}/images/agency/project-img/6.jpg" data-gallery="myGal"></div>
                            </div>
                            <div class="card-body">
                                <h5 class="fs-18 mb-1">The Language of Designs</h5>
                                <p class="text-muted mb-0">Design</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Projects end -->

        <!-- Testimonials start -->
        <section class="section testi-bg" id="testimonial">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-md-8 col-lg-6 text-center">
                        <h6 class="subtitle text-dark">Testimonial</h6>
                        <h2 class="title">Client Feedback</h2>
                        <p class="text-muted">Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut consequuntur magni dolores.</p>
                    </div>
                </div>

                <div class="row testi-row">
                    <div class="col-12">
                        <!-- Swiper -->
                        <div class="clients-slider">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="card shadow-lg">
                                        <div class="card-body p-4">
                                            <img src="{{ url('themes/dojek') }}/images/users/user-1.jpg" alt="" class="rounded-circle shadow-lg" width="60" />
                                            <h5 class="my-4 pt-2 fs-18 lh-base">" Excellent support for a tricky issue related to our customization of the template."</h5>

                                            <h6 class="mb-0">Brightlight books</h6>
                                            <p class="mb-0">Ubold Customer</p>
                                            <div class="position-absolute bottom-0 end-0">
                                                <img src="{{ url('themes/dojek') }}/images/agency/quote.png" alt="" height="45" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card shadow-lg">
                                        <div class="card-body p-4">
                                            <img src="{{ url('themes/dojek') }}/images/users/user-2.jpg" alt="" class="rounded-circle shadow-lg" width="60" />
                                            <h5 class="my-4 pt-2 fs-18 lh-base">" This kit provides many options which I can you use everyday. It's great work.”</h5>

                                            <h6 class="mb-0">Echineo</h6>
                                            <p class="mb-0">Ubold Customer</p>
                                            <div class="position-absolute bottom-0 end-0">
                                                <img src="{{ url('themes/dojek') }}/images/agency/quote.png" alt="" height="45" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card shadow-lg">
                                        <div class="card-body p-4">
                                            <img src="{{ url('themes/dojek') }}/images/users/user-3.jpg" alt="" class="rounded-circle shadow-lg" width="60" />
                                            <h5 class="my-4 pt-2 fs-18 lh-base">" This is a very extensive web app kit that can serve all kinds of purposes."</h5>

                                            <h6 class="mb-0">Aebra Schultz</h6>
                                            <p class="mb-0">Designer</p>
                                            <div class="position-absolute bottom-0 end-0">
                                                <img src="{{ url('themes/dojek') }}/images/agency/quote.png" alt="" height="45" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Add Pagination -->
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Testimonials end -->

        <!-- counter start -->
        <section class="section bg-light">
            <div class="container">
                <div class="row" id="counter">
                    <div class="col-sm-6 col-lg-3">
                        <div class="text-center my-3">
                            <div class="counter-content">
                                <h2><span class="counter_value" data-target="825">0</span></h2>
                                <p class="counter-name text-muted mb-0 text-uppercase">Global Brands</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="text-center my-3">
                            <div class="counter-content">
                                <h2><span class="counter_value" data-target="1800">0</span>+</h2>
                                <p class="counter-name text-muted mb-0 text-uppercase">Happy Clients</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="text-center my-3">
                            <div class="counter-content">
                                <h2><span class="counter_value" data-target="599">0</span>+</h2>
                                <p class="counter-name text-muted mb-0 text-uppercase">Creative Idea</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="text-center my-3">
                            <div class="counter-content">
                                <h2><span class="counter_value" data-target="2000">0</span>+</h2>
                                <p class="counter-name text-muted mb-0 text-uppercase">User clients</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- counter end -->

        <!-- team start -->
        <section class="section" id="team">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-md-8 col-lg-6 text-center">
                        <h6 class="subtitle">Team</h6>
                        <h2 class="title">Amazing Team</h2>
                        <p class="text-muted">Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut consequuntur magni dolores.</p>
                    </div>
                </div>

                <div class="row mb-5 pb-5">
                    <div class="col-sm-6 col-lg-3">
                        <div class="team-bg rounded text-center">
                            <img src="{{ url('themes/dojek') }}/images/agency/team/1.png" alt="" class="img-fluid" />
                        </div>
                        <h5 class="fs-18 mb-0 mt-3">Adela White</h5>
                        <p class="text-muted fs-15 mb-4 mb-lg-0">Web Designer, USA</p>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="team-bg rounded text-center">
                            <img src="{{ url('themes/dojek') }}/images/agency/team/2.png" alt="" class="img-fluid" />
                        </div>
                        <h5 class="fs-18 mb-0 mt-3">Ronnie Cooper</h5>
                        <p class="text-muted fs-15 mb-4 mb-lg-0">Graphic Designer, USA</p>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="team-bg rounded text-center">
                            <img src="{{ url('themes/dojek') }}/images/agency/team/3.png" alt="" class="img-fluid" />
                        </div>
                        <h5 class="fs-18 mb-0 mt-3">Helen Kim</h5>
                        <p class="text-muted fs-15 mb-4 mb-lg-0">Web Developer, USA</p>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="team-bg rounded text-center">
                            <img src="{{ url('themes/dojek') }}/images/agency/team/4.png" alt="" class="img-fluid" />
                        </div>
                        <h5 class="fs-18 mb-0 mt-3">Howard Shiflet</h5>
                        <p class="text-muted fs-15 mb-4 mb-lg-0">PHP Developer, USA</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- team end -->

        <!-- footer & cta start -->
        <section class="footer bg-light">
            <div class="cta-content">
                <div class="container">
                    <div class="row bg-dark cta-bg p-5 rounded align-items-center">
                        <div class="col-lg-6">
                            <h3 class="text-white fs-26 mb-3">Subscribe our newsletter</h3>
                            <p class="text-white opacity-75 mb-4 mb-lg-0">Et harum quidem rerum facilis est us et expedita distinctio am libero tempore cum soluta nobis.</p>
                        </div>
                        <div class="col-lg-5 offset-lg-1">
                            <div class="subscribe-form">
                                <i class="mdi mdi-email-outline form-icon"></i>
                                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Enter Email Address" />
                                <a href="{{ url('themes/dojek') }}/javascript:void(0);" class="btn btn-primary form-btn">Get Access</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 text-center text-lg-start">
                        <div class="footer-logo mb-4">
                            <a href="{{ url('themes/dojek') }}/#">
                                <img src="{{ url('themes/dojek') }}/images/logo-dark.png" alt="" />
                            </a>
                        </div>
                        <a href="{{ url('themes/dojek') }}/#" class="text-muted">Hello@coderthemes.com</a>
                        <p class="text-muted">+01 ( 1234 567 890 )</p>
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
