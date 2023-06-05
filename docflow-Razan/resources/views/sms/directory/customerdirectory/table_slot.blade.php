
    <template v-else-if="props.column.field == 'customerName'">
        <b>Name</b><br>@{{ props.row.customerName ?? '-' }}<br>
        <b>Website</b><br>
        <a v-if="!_.isNull(props.row.website)" :href="normalizeUrl(props.row.website)" target="_blank">@{{ props.row.website }} </a>
        <template v-else>
            -
        </template><br>
        <b>Customer Class</b><br>@{{ props.row.customerClass ?? '-' }}<br>
        <b>Customer Code</b><br>@{{ props.row.customerCode ?? '-' }}<br>
    </template>
    <template v-else-if="props.column.field == 'services'">
        <b>Products</b> <br>
        @{{ props.row.products ?? '-' }} <br>
        <b>Services</b> <br>
        @{{ props.row.services ?? '-' }} <br>
        <b>Brands</b> <br>
        @{{ props.row.brands ?? '-' }}
    </template>
    <template v-else-if="props.column.field == 'address'">
        @{{ props.row.address }} <br>
        @{{ props.row.address2 }} <hr>
        <b>Phones</b>
        <div class="row">
            <div class="col-12">
              <span v-for="phone in saveSplit( props.row.offPhones ?? '-' )" style="display:block; margin-left:initial;"> @{{ phone }} </span>
            </div>
        </div>
        <b>Faxes</b>
        <div class="row">
            <div class="col-12">
              <span v-for="fax in saveSplit( props.row.offFaxes ?? '-' )" style="display:block; margin-left:initial"> @{{ fax }} </span>
            </div>
        </div>
        <b>Emails</b>
        <div class="row">
            <div class="col-12">
                <template v-if="!_.isNull(props.row.offEmails)">
                    <a style="display:block; margin-left:initial;" v-for="email in saveSplit( props.row.offEmails )" :href="'mailto:' + email" target="_blank" rel="noopener noreferrer">@{{ email }}</a><br>
                </template>
                <template v-else>
                    <div style="margin-left:initial;">-</div>
                </template>
            </div>
        </div>
    </template>
    <template v-else-if="props.column.field == 'picContacts'">
        <template v-if="!(_.isEmpty(props.row.picContacts) || props.row.picContacts.length == 0 )">
            <template v-for="contact in props.row.picContacts">
                <i class="fa fa-xs" :class="contact.contactDefault?'fa-user-check':'fa-user'" :style="contact.contactDefault?'color:green; margin-right:5px;':'color:grey; margin-right:8px;'" style="font-size:8pt;"></i> @{{ contact.contactName }} <br>
                <i class="fa fa-phone fa-xs" style="font-size:8pt; margin-right:7px;"></i> @{{ contact.contactPhone }} <br>
                <i class="fa fa-at fa-xs" style="font-size:8pt; margin-right:8px;"></i>
                <a :href = "'mailto:' + contact.contactEmail" target="_blank">@{{ contact.contactEmail }}</a><br>
            </template>
        </template>

        <template v-if="!(_.isEmpty(props.row.companyProfileUrl)  || props.row.companyProfileUrl == '' ) ">
            <span @click="showPdf(props.row.companyProfileUrl)"  style="cursor: pointer;">
                <i class="far fa-file-alt"></i> Company Profile
            </span><br>
        </template>

        <template v-if="!(_.isEmpty(props.row.mediaUrlCatalog)  || props.row.mediaUrlCatalog == '' ) ">
            <span @click="showPdf(props.row.mediaUrlCatalog)" style="cursor: pointer;"  >
                <i class="far fa-file-alt"></i> Catalog
            </span><br>
        </template>

        <template v-if="!(_.isEmpty(props.row.taxIdNpwp)  || props.row.taxIdNpwp == '' ) ">
            <span @click="showPdf(props.row.taxIdNpwp)" style="cursor: pointer;"  >
                <i class="far fa-file-alt"></i> Catalog
            </span><br>
        </template>

    </template>
