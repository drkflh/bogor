<!-- About start -->
<section class="section bg-light" id="about">
    <div class="container">
        @if( isset($aux['head']))
            <div class="row justify-content-center mb-5">
                <div class="col-md-8 col-lg-6 text-center">
                    <h6 class="subtitle">{{ $aux['head'] }}</h6>
                    <h2 class="title">{{ $aux['description'] }}</h2>
                </div>
            </div>
        @endif
        <div class="row">
            @foreach($content as $c)
                <div class="col-md-4">
                    <div class="mt-5">
                        <div class="about-icon ms-3">
                            <img src="{{ url('themes/dojek') }}/images/agency/icon/1.png" alt="" class="img-fluid" />
                        </div>
                        <h5 class="fs-22 mt-4 pt-3 mb-3">{{ $c['title'] ?? '' }}</h5>
                        <p class="text-muted">{{ $c['description'] ?? '' }}</p>
                        <a href="{{ url('page/'.($c['slug'] ?? '') ) }}" class="text-danger">More About <i class="mdi mdi-arrow-right fs-14 ms-1"></i></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- About end -->
