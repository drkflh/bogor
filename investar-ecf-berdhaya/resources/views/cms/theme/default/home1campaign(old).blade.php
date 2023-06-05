@if( is_array($content) && !empty($content) )
<!-- Projects start -->
<section class="section" id="projects">
    <div class="container">
        @if( isset($aux['head']))
        <div class="row justify-content-center mb-5">
            <div class="col-md-8 col-lg-6 text-center">
                <h6 class="subtitle">{{ $aux['head'] }}</h6>
                <h2 class="title">{{ $aux['title'] }}</h2>
            </div>
        </div>
        @endif
        @if(isset($aux['tags']))
        <div class="row">
            <ul class="col busi-container-filter categories-filter text-center" id="filter">
                <li><a class="categories tab-active active" onclick="filterSelection('all')">{{ __('All') }}</a></li>
                @foreach($aux['tags'] as $tobj)
                <li><a class="categories tab-active" onclick="filterSelection('{{ $tobj['value'] }}')">{{ $tobj['text'] }}</a></li>
                @endforeach
            </ul>
        </div>
        <!-- Gallary -->
        @endif

        <div class="row justify-content-center">
            @foreach($content as $c)
            <div class="col-md-6 col-xl-4 filter-box branding designing development">
                <div class="card item-box rounded mt-4 overflow-hidden">
                    <div class="position-relative">
                        <img class="item-container img-fluid" src="{{ url( ($c['attachments'][0] ?? url('themes/dojek').'/images/agency/project-img/1.jpg') ) }}" alt="1" />
                        <div class="item-mask mfp-image" data-src="{{ url( ($c['attachments'][0] ?? url('themes/dojek').'/images/agency/project-img/1.jpg') ) }}" data-gallery="myGal"></div>
                    </div>
                    <div class="card-body">
                        <h5 class="fs-18 mb-1">{{ $c['title'] }}</h5>
                        <p class="text-muted mb-0">{{ $c['description'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Projects end -->
@endif
