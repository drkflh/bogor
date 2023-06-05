<b-modal id="addToCartModal"
         no-close-on-backdrop
         no-close-on-esc
         @ok.prevent="commitAddToCart"
         ok-title="{{ __('Add') }}"
         size="md"
         centered
         scrollable
         title="Change Pin"
         modal-class="modal-bv">
    <template v-slot:modal-header="{ close }">
                        <span class="modal-title" >
                            <h4 style="margin-bottom: 0px;"  >{{ __('Add to Cart') }}</h4>
                        </span>
        <b-button size="sm" variant="outline-secondary" pill @click="close()">
            <b-spinner small v-show="isLoading" label="Loading..."></b-spinner>
            <i v-show="!isLoading" class="las la-times"></i>
        </b-button>
    </template>
    <div class="row">
        <div class="col-12">
            @include('sfm.product.catalog.addproductcart')
        </div>
    </div>
</b-modal>

<b-modal id="addToWishlistModal"
         no-close-on-backdrop
         no-close-on-esc
         @ok.prevent="commitAddToWishlist"
         size="md"
         centered
         scrollable
         title="Change Pin"
         modal-class="modal-bv">
    <div class="row" id="changePinForm">
        <div class="col-12">
            <validation-observer v-slot="{ invalid }" ref="changePinForm">
                <validation-provider rules="required|digits:6" v-slot="{ errors }" name="new_pin" vid="new_pin" >
                    <p class="mt-2">PIN</p>
                    <pin-input
                        v-model="new_pin"
                        name="new_pin"
                        num-inputs="6"
                        input-type="password"
                        separator=""
                    >
                    </pin-input>
                    <div style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
                </validation-provider>
                <validation-provider rules="required|confirmed:new_pin" v-slot="{ errors }" name="Confirm PIN">
                    <p class="mt-2">Confirm PIN</p>
                    <pin-input
                        v-model="new_confirm_pin"
                        name="new_confirm_pin"
                        num-inputs="6"
                        input-type="password"
                        separator=""
                    >
                    </pin-input>
                    <div style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
                </validation-provider>
            </validation-observer>

        </div>
    </div>
</b-modal>
