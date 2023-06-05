
@if(\Illuminate\Support\Facades\Auth::check())
    <li class="nav-item dropdown nav-profile" style="height:fit-content;font-size:12pt;color: #6c757d;">
        <div class="dropdown-toggle d-inline-flex align-items-center ml-2 " id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if(Auth::check() && isset(Auth::user()->name))
                <i style="font-size: 30pt;" class="lar la-user-circle"></i>
            @endif
        </div>
        <div class="dropdown-menu" style="min-width:220px;width:220px;" aria-labelledby="profileDropdown">
            <?php
                //$lang = Auth::user()->lang ?? env('DEFAULT_LANG');
                $langList = config('util.languages');
                $lang = App::currentLocale();
                $lang = trim($lang) == '' || is_null($lang) ? env('DEFAULT_LANG', 'en'): strtolower($lang);
                $lang = $langList[ $lang];
            ?>
            <div class="dropdown-body">
                <ul class="profile-nav p-0 mt-0" style="list-style-type: none;" >
                    @if(Auth::check() && isset(Auth::user()->name))
                    <li class="nav-item text-center">
                        <a href="{{ url('profile') }}" class="nav-link">
                            <img style="width: 40px;height: 40px;" src="{{ Auth::user()->avatar }}"
                                 onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/coffee.png' ) ) }}';"
                                 class="rounded-circle" alt="{{Auth::user()->name}}'s Profile Pic">
                            <br>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ url('profile') }}" class="nav-link">
                            <i class="las la-user"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('profile-edit') }}" class="nav-link">
                            <i class="las la-user-edit"></i>
                            <span>Edit Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('halal/dashboard') }}" class="nav-link" target="_blank">
                            <i class="las la-tachometer-alt"></i>
                            <span>Go To Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href=""  class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                           data-toggle="tooltip" title="Sign out">
                            <i class="las la-sign-out-alt"></i>
                            <span>Log Out</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </li>
@else
<li class="nav-item">
    <a href="{{ url('login') }}" class="nav-link">{{ __('Login') }}</a>
</li>
<li class="nav-item">
    <a href="{{ url('register') }}" class="btn btn-gradient-secondary ">{{ __('Register') }}</a>
</li>
@endif
