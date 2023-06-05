<li class="nav-item">
    <a href="{{ url('/') }}" class="nav-link">Home</a>
</li>
<li class="nav-item dropdown" style="height:fit-content;font-size:12pt;color: #6c757d;">
    <div class="dropdown-toggle d-inline-flex align-items-center ml-2 " role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="nav-link">About</span>
    </div>
    <div class="dropdown-menu" style="min-width:220px;width:220px;" aria-labelledby="profileDropdown">
        <div class="dropdown-body">
            <ul class="profile-nav p-0 mt-0" style="list-style-type: none;" >
                <li class="nav-item">
                    <a href="{{ url('page/mengapa-investar') }}" class="nav-link">
                        <span>Mengapa Investar</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('profile-edit') }}" class="nav-link">
                        <i class="las la-user-edit"></i>
                        <span>Edit Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('ecf/dashboard') }}" class="nav-link" target="_blank">
                        <i class="las la-tachometer-alt"></i>
                        <span>Go To Dashboard</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</li>

<li class="nav-item">
    @if(Auth::check())
        @if (Auth::User()->roleSlug == 'pemodal' || Auth::User()->roleSlug == 'penerbit')
            <a href="{{ url('ecf/etalase') }}" class="nav-link">{{ __('Katalog Bisnis') }}</a>
        @else
            <a href="{{ url('ecf/etalase') }}" class="nav-link">{{ __('Katalog Bisnis') }}</a>
        @endif
    @else
        <a href="{{ url('catalog') }}" class="nav-link">{{ __('Katalog Bisnis') }}</a>
    @endif
</li>
<li class="nav-item">
    <a href="{{ url('/') }}/#testimonial" class="nav-link">Testimonial</a>
</li>
<li class="nav-item">
    <a href="{{ url('/') }}/#team" class="nav-link">Team</a>
</li>
@if(\Illuminate\Support\Facades\Auth::check())
<li class="nav-item dropdown">
    <a class="nav-link" href="#" id="cartDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if(Auth::check() && isset(Auth::user()->name))
                <i style="font-size: 24pt;" class="las la-shopping-cart mt-1"></i>
                <div v-if="totalQty > 0" class="indicator">
                    <div class="circle mt-1"></div>
                </div>                
            @endif
    </a>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cartDropdown" >
            <div class="dropdown-body" >
                <a v-for="c in cart" href="{{ url('ecf/shoppingcart') }}" class="dropdown-item mt-2 mb-2 p-2 d-flex" style="height: fit-content !important;" >
                    <div class="icon text-center align-self-start">
                        <i class="las la-envelope" style="margin: 0px;"></i>
                    </div>
                    <div class="content">
                        <p class="ellipsis" style="width:200px;font-size:9pt;" >@{{ c.campaignTitle ?? '' }}</p>
                        <p class="" style="width:200px;font-size:8pt;" class="sub-text text-muted">
                            @{{ c.orderQty }} × </span> Rp.@{{ formatCurrency(c.pricePerLot) }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="dropdown-footer d-flex align-items-end justify-content-center">
                <div class="shopping-cart-total">
                    <div>
                        <h4 style="text-align:left;">Total :<span> Rp.@{{ formatCurrency(totalBill) }}</span></h4>
                    </div>
                    <div>
                        <a href="{{ url('ecf/shoppingcart') }}" class="btn btn-outline-warning">View cart</a>
                        <a href="{{ url('check-out') }}" class="btn btn-outline-info">Checkout</a>
                    </div>
                </div>
            </div>
        </div>

    </li>
    @if(Auth::check())
        <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="profileDropdown" role="button"
               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="wd-30 ht-30 rounded-circle"
                     src="{{ Auth::user()->avatar }}"
                     onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/coffee.png' ) ) }}';"
                     alt="profile">
            </a>
            <div class="dropdown-menu p-0  dropdown-menu-end" aria-labelledby="profileDropdown">
                <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                    <div class="mb-3">
                        @if(Auth::check())
                            <img style="width: 80px;height: 80px;" src="{{ Auth::user()->avatar }}"
                                 onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/coffee.png' ) ) }}';"
                                 class="rounded-circle" alt="{{Auth::user()->name}}'s Profile Pic">
                        @endif
                    </div>
                    <?php
                        //$lang = Auth::user()->lang ?? env('DEFAULT_LANG');
                        $langList = config('util.languages');
                        $lang = App::currentLocale();
                        $lang = trim($lang) == '' || is_null($lang) ? env('DEFAULT_LANG', 'en'): strtolower($lang);
                        $lang = $langList[ $lang];
                    ?>
                    <div class="text-center">
                        <p class="tx-16 fw-bolder">{{ Auth::user()->name }}</p>
                        <p class="tx-16 fw-bolder">{{ Auth::user()->approvalStatus ?? 'UNVERIFIED'}}</p>
                        <p class="tx-12 fw-bolder">{{ Auth::user()->roleName ?? '' }}</p>
                        <p class="tx-12 text-muted">{{ env('REG_EMAIL', false) ? Auth::user()->email : Auth::user()->mobileString }}</p>
                    </div>
                </div>
                <ul class="list-unstyled p-1">
                    <li class="dropdown-item py-2">
                        <a href="{{ url('profile') }}"  class="text-body ms-0">
                            <i class="me-2 icon-md" data-feather="user"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li class="dropdown-item py-2">
                        <a href="{{ url('profile-edit') }}" class="text-body ms-0">
                            <i class="me-2 icon-md" data-feather="edit"></i>
                            <span>Edit Profile</span>
                        </a>
                    </li>
                    @if(env('WITH_FRONTEND', false) )
                    <li class="dropdown-item py-2">
                        <a href="{{ url('/') }}" class="text-body ms-0">
                            <i class="me-2 icon-md" data-feather="repeat"></i>
                            <span>Go To Frontpage</span>
                        </a>
                    </li>
                    @endif
                    <li class="dropdown-item py-2">
                        <a href=""
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                           class="text-body ms-0">
                            <i class="me-2 icon-md" data-feather="log-out"></i>
                            <span>Log Out</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </li>
    @endif                            
@else
<li class="nav-item">
    <a href="{{ url('login') }}" class="nav-link">{{ __('Login') }}</a>
</li>
<li class="nav-item">
    <a href="{{ url('register') }}" class="btn btn-gradient-secondary ">{{ __('Register') }}</a>
</li>
@endif



