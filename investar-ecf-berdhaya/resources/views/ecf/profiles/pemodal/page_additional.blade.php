<button class="btn btn-outline-primary" @click="openPasswordModal" >{{ __('Change Password') }}</button>
@if(env('USE_PIN', true))
    <button class="btn btn-outline-primary" @click="openPinModal">{{ __('Change PIN') }}</button>
@endif
