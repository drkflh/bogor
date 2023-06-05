<h1 class="hero-title fw-bold mb-4">{!! $content['title'] ?? '' !!}</h1>
<p class="text-muted mb-5 fs-18">{!! $content['description'] ?? '' !!}</p>
<div class="d-flex align-items-center mb-4 mb-lg-0">
    <a href="{{ url('page/'.($content['slug'] ?? '') ) }}" class="btn btn-gradient-success rounded-pill me-4">More About Us <i class="mdi mdi-chevron-right ms-1"></i></a>
    <a href="#" class="text-secondary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#watchvideomodal">
        See Demo <i class="mdi mdi-motion-play-outline h1 mb-0 ms-2"></i>
    </a>

    <div class="modal fade bd-example-modal-lg" id="watchvideomodal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog modal-lg">
            <div class="modal-content video-modal">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <video id="VisaChipCardVideo" class="w-100" controls>
                    @if( isset($content['attachments']) && ( is_array($content['attachments']) && isset($content['attachments'][0]) ) ) )
                        <source src="{{ url( $content['attachments'][0] ) }}" type="video/mp4" />
                    @else
                        <source src="{{ url('themes/dojek') }}/https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4" />
                    @endif
                    <!--Browser does not support <video> tag -->
                </video>
            </div>
        </div>
    </div>
    <!-- Modal -->
</div>
