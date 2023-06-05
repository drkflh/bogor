<b-dropdown-item href="#" @click="openPasswordModal(props.row._id)" ><i class="las la-lock"></i> Change Password</b-dropdown-item>
@if(env('USE_PIN', false))
<b-dropdown-item href="#" @click="openPinModal(props.row._id)" ><i class="las la-file"></i> Change PIN</b-dropdown-item>
@endif
