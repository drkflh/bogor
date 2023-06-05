<b-modal id= "modalSihalal"
         size="md"
         centered
         no-close-on-backdrop
         @ok="openRegModal"
         ok-title="Submit"
         cancel-title="Close"
         title="Sihalal"
         style="min-height: 300px;"
>
    <template v-slot:modal-header="{ close }">
            <span class="modal-title" >
                <h4 style="margin-bottom: 0px;">Registrasi Sihalal Produk</h4>
            </span>
        <b-button size="sm" variant="outline-secondary" pill @click="close()">
            <b-spinner small v-show="isLoading" label="Loading..."></b-spinner>
            <i v-show="!isLoading" class="fa fa-times"></i>
        </b-button>
    </template>
    <template v-slot:modal-footer >
    </template>
</b-modal>
{{-- 
<b-modal id= "modalSihalalReg"
         size="md"
         centered
         no-close-on-backdrop
         @ok="openHalalRegModal"
         ok-title="Submit"
         cancel-title="Close"
         title="Sihalal"
         style="min-height: 300px;"
>
    <template v-slot:modal-header="{ close }">
            <span class="modal-title" >
                <h4 style="margin-bottom: 0px;">Registrasi Sihalal</h4>
            </span>
        <b-button size="sm" variant="outline-secondary" pill @click="close()">
            <b-spinner small v-show="isLoading" label="Loading..."></b-spinner>
            <i v-show="!isLoading" class="fa fa-times"></i>
        </b-button>
    </template>
    <template v-slot:modal-footer >
    </template>
</b-modal> --}}
