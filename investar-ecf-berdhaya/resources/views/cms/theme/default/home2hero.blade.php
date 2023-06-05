<!-- home-agency start -->
<section class="hero-2" id="home">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                {!! \App\Helpers\CmsUtil::singleBlock( \App\Helpers\CmsUtil::getArticleByTag('home-hero-article'), 'homehero2video', 'dojek' ) !!}
            </div>

            <div class="col-lg-6">
                <div class="hero-2-img-bg mt-4 mt-lg-0">
                    <img src="{{ url('themes/dojek') }}/images/heros/hero-2-img.png" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- home-agency end -->
