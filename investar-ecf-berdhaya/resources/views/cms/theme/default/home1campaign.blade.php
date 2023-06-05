{{-- @if( is_array($content) && !empty($content) ) --}}
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

        <div class="row clients-slider p-4">
            @foreach($content as $c)
            <div class="col-md-6 col-xl-4 filter-box branding designing development">
                <div class="card item-box rounded mt-4 overflow-hidden">
                    <div class="card-body">
                    <div class="position-relative">
                        <?php
                            if (is_array($c['picture'])) {
                                $campaignPic = $c['picture'][0];
                            }elseif ($c['picture'] == null){
                                $campaignPic = "";
                            }else{
                                $campaignPic = $c['picture'];
                            }
                            $stDate = $c['campaignStart'] ?? $c['campaignPeriod'][0];
                            $endDate = $c['campaignEnd'] ?? $c['campaignPeriod'][1];
                            $today = Illuminate\Support\Carbon::now();
                            $todays = Illuminate\Support\Carbon::parse(strtotime($today));
                            $stDates = Illuminate\Support\Carbon::parse(strtotime($stDate));
                            $endDates = Illuminate\Support\Carbon::parse(strtotime($endDate));
                            $stDatess = Illuminate\Support\Carbon::parse(strtotime($stDate))->format('d M Y');
                            $endDatess = Illuminate\Support\Carbon::parse(strtotime($endDate))->format('d M Y');
                            $durasi = $stDates->diff($endDates)->days;
                            $tersisa =  $todays->diff($endDates)->days;
                        ?>
                        <a href="/ecf/etalase/detail/{{ $c['_id'] }}"><img class="item-container img-fluid" src="{{$campaignPic}}" style="width: 100%;
                        height: 15vw;
                        object-fit: cover" alt="Card image cap"
                        onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/blank.png' ) ) }}';"></a>
                    </div>
                    
                            <p class="card-text">{{ $c['bizRegisteredName'] }}</p>
                            <p class="card-text">{{ $c['campaignTitle'] }}</p>
                            <p class="card-text">LOT Tersedia: {{ $c['lotEmitted'] }}/{{ $c['totalLot'] ?? '0'}}</p>
                            <?php
                                if ($c['totalLot'] == null || $c['totalLot'] == 0) {
                                    $totalLot = 1;
                                }else{
                                    $totalLot = $c['totalLot'];
                                }
                                
                                $persen = 100 - ($c['lotEmitted'] / $totalLot / 0.01);
                                // echo $persen;
                            ?>
                            Terbeli : <div class="progress">
                               <div class="progress-bar" role="progressbar" style="width: {{$persen}}%" aria-valuenow="{{$persen}}" aria-valuemin="0" aria-valuemax="$c['totalLot']"></div>
                            </div>
                            <p class="card-text"><small>{{ $stDatess ?? 0 }} - {{$endDatess ?? 0}} ({{$durasi}} hari)</small></p>

                            @if (Auth::check() && Auth::User()->approvalStatus == 'VERIFIED')
                            <br>
                            <a href="{{ url('ecf/etalase') }}"><button class="btn btn-success text-white" >Add </button></a>
                                <!-- <button class="btn btn-success text-white" @click="addToCart(item)" >Add </button> -->
                            @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>
<!-- Projects end -->
{{--@endif--}}
