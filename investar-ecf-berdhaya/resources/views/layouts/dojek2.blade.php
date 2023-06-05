<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="Premium Bootstrap 5 Landing Page Template" />
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
        <link rel="stylesheet" type="text/css" href="{{ url('css/theme/dojek.css') }}" />
        <!-- icon line -->
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <link rel="shortcut icon" href="{{ url(env('APP_FAVICON', 'favicon.ico')) }}"/>
        <script src="{{ url( 'js/jquery-3.6.0.min.js' ) }}"></script>

        @yield('js')
    </head>

    <body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="60">
        <!--Navbar Start-->
        <nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky-dark" id="navbar-sticky">
            <div class="container">
                <!-- LOGO -->
                <a class="logo text-uppercase" href="{{ url('/') }}">
                    <img src="{{ url( env('APP_LOGO') ) }}" alt="" height="50">
                    @if(env('LOGO_TEXT', false ))
                        <span class="sidebar-brand" style="font-size: 15pt;font-weight: bold;">{{ env('SITE_TITLE') }}</span>
                    @endif
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="mdi mdi-menu"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ms-auto navbar-center" id="mySidenav">
                        @include(env('APP_OPEN_NAV_VIEW'))
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Navbar End -->

        {!! \App\Helpers\CmsUtil::singleBlock( \App\Helpers\CmsUtil::getArticleBySlug('home-hero'), 'home2hero', 'dojek' ) !!}


        {{-- What We Do--}}
        <?php
        $content = \App\Helpers\CmsUtil::getArticlesByTag('what-we-do');
        $cat = \App\Helpers\CmsUtil::getCategoryBySlug('what-we-do');
        $aux = [
            'head'=>'',
            'title'=>($cat['categoryName'] ?? ''),
            'description'=>($cat['categoryDescription'] ?? '' )
        ];
        ?>
        {!! \App\Helpers\CmsUtil::singleBlock( $content, 'home1wedo', 'dojek', $aux ) !!}

        {{-- Campaign--}}
        <?php
        $content = \App\Helpers\CmsUtil::getArticleByCategorySlug('campaign-list');
        $cat = \App\Helpers\CmsUtil::getCategoryBySlug('campaign-list');
        $aux = [
            'head'=>'',
            'title'=>($cat['categoryName'] ?? ''),
            'description'=>($cat['categoryDescription'] ?? '' )
        ];
        ?>
        {!! \App\Helpers\CmsUtil::singleBlock( $content, 'home1campaign', 'dojek', $aux ) !!}

        {{-- Testimonial--}}
        <?php
        $content = \App\Helpers\CmsUtil::getArticleByCategorySlug('campaign-list');
        $cat = \App\Helpers\CmsUtil::getCategoryBySlug('campaign-list');
        $aux = [
            'head'=>'',
            'title'=>($cat['categoryName'] ?? ''),
            'description'=>($cat['categoryDescription'] ?? '' )
        ];
        ?>
        {!! \App\Helpers\CmsUtil::singleBlock( $content, 'home1testimonial', 'dojek', $aux ) !!}

        {{-- Counter--}}
        {!! \App\Helpers\CmsUtil::singleBlock( \App\Helpers\CmsUtil::getArticleBySlug('home-counter'), 'home1counter', 'dojek' ) !!}

        {{-- Team --}}
        {!! \App\Helpers\CmsUtil::singleBlock( \App\Helpers\CmsUtil::getArticleBySlug('home-team'), 'home1team', 'dojek' ) !!}

        {{-- Footer --}}
        {!! \App\Helpers\CmsUtil::singleBlock( \App\Helpers\CmsUtil::getArticleBySlug('home-footer'), 'home1footer', 'dojek' ) !!}

        <!-- Back to top -->
        <a href="#" onclick="topFunction()" class="back-to-top-btn btn btn-dark" id="back-to-top"><i class="mdi mdi-chevron-up"></i></a>

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
