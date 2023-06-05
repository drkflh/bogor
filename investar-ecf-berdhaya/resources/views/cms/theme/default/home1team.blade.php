@if( is_array($content) && !empty($content) )
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
@endif
