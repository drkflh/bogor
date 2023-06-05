@if( is_array($content) && !empty($content) )
<!-- Testimonials start -->
<section class="section testi-bg" id="testimonial">
    <div class="container">
        @if( isset($aux['head']))
        <div class="row justify-content-center mb-5">
            <div class="col-md-8 col-lg-6 text-center">
                <h6 class="subtitle text-dark">{{ $aux['head'] ?? '' }}</h6>
                <h2 class="title">{{ $aux['title'] ?? '' }}</h2>
                {{-- <p class="text-muted">{{ $aux['description'] }}</p> --}}
            </div>
        </div>
        @endif

        <div class="row testi-row">
            <div class="col-12">
                <!-- Swiper -->
                <div class="clients-slider">
                    <div class="swiper-wrapper">
                        @foreach($content as $c)
                        <div class="swiper-slide">
                            <div class="card shadow-lg">
                                <div class="card-body p-4">
                                    {{-- <img src="{{ url('themes/dojek') }}/images/users/user-1.jpg" alt="" class="rounded-circle shadow-lg" width="60" /> --}}
                                    <h5 class="my-4 pt-2 fs-18 lh-base table-responsive" style="height: 400px;">{{ $c['description'] }}</h5>

                                    <h6 class="mb-0">{{ $c['title'] }}</h6>
                                    <p class="mb-0">{{ $c['ownerName'] }}</p>
                                    {{-- <div class="position-absolute bottom-0 end-0">
                                        <img src="{{ url( $c['attachments'][0] ?? 'themes/dojek/images/agency/project-img/1.jpg'  ) }}" alt="" height="45" />
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Testimonials end -->
@endif
