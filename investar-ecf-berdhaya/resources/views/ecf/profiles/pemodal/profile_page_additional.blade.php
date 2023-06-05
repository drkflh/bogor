<button class="btn btn-outline-primary" @click="openPasswordModal" >{{__('Change Password')}}</button>
@if(env('USE_PIN', true))
    <button class="btn btn-outline-primary mr-2" @click="openPinModal">{{__('Change PIN')}}</button>
@endif
@if( !preg_match( '/profile-edit/', url()->current() ) )
    <a class="btn btn-outline-primary mr-2" href="{{ url('profile-edit') }}" >{{__('Edit Profile')}}</a>
@endif
