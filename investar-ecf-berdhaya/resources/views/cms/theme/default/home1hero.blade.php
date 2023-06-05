<!-- home-agency start -->
<section class="hero-agency" id="home">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                {!! \App\Helpers\CmsUtil::singleBlock( \App\Helpers\CmsUtil::getArticleByTag('home-hero-article'), 'homehero1video', 'dojek' ) !!}
            </div>
            <div class="col-lg-6">
                <img src="{{ url('themes/dojek') }}/images/agency/hero-img.png" alt="" class="img-fluid" />
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                {!! \App\Helpers\CmsUtil::singleBlock( \App\Helpers\CmsUtil::getArticleBySlug('home-client-list'), 'home1clientlist', 'dojek' ) !!}
            </div>
        </div>
    </div>
</section>
<!-- home-agency end -->
