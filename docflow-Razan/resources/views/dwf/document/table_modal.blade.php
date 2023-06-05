 <b-modal id="approvalLogModal"
             size="md"
             centered
             no-close-on-backdrop
             no-close-on-esc
             @ok="hideLogModal"
             ok-title="Close"
             cancel-title="Close"
             @hidden="logModalHidden"
             @shown="logModalShown"
             modal-class="modal-bv"
             :hide-footer="true"
             style="min-height: 300px;"
    >
        <template v-slot:modal-header="{ close }">
            <span class="modal-title" >
                            <h4 style="margin-bottom: 0px;"  >Riwayat Naskah</h4>
            </span>
            <!-- Emulate built in modal header close button action -->
            <b-button size="sm" variant="outline-secondary" pill @click="close()">
                <b-spinner small v-show="isLoading" label="Loading..."></b-spinner>
                <i v-show="!isLoading" class="fa fa-times"></i>
            </b-button>
        </template>
        <template v-slot:modal-footer >
{{--            <button class="btn btn-outline-danger" pill @click="hideLogModal()">--}}
{{--                <i class="fa fa-times" ></i> Close--}}
{{--            </button>--}}
        </template>
        <approval-time-line
            v-model="docHistory"
        ></approval-time-line>

    </b-modal>

<b-modal id="sendModal"
             size="lg"
             centered
             scrollable
             no-close-on-backdrop
             no-close-on-esc
             @ok.prevent="commitSend()"
             ok-title="Kirim"
             cancel-title="Close"
             @hidden="sendModalHidden"
             @shown="sendModalShown"
             modal-class="modal-bv"
             :hide-footer="false"
             style="min-height: 300px;"
    >
        <template v-slot:modal-header="{ close }">
            <span class="modal-title" >
                            <h4 style="margin-bottom: 0px;"  >Kirim Naskah</h4>
            </span>
            <!-- Emulate built in modal header close button action -->
            <b-button size="sm" variant="outline-secondary" pill @click="close()">
                <b-spinner small v-show="isLoading" label="Loading..."></b-spinner>
                <i v-show="!isLoading" class="fa fa-times"></i>
            </b-button>
        </template>
        <template v-slot:modal-footer >
{{--            <button class="btn btn-outline-danger" pill @click="hideLogModal()">--}}
{{--                <i class="fa fa-times" ></i> Close--}}
{{--            </button>--}}
        </template>
        <h5>No : @{{ sendDoc.docNo }}</h5>
        <div class="row">

            <div class="col-4">
                <h6>Tujuan</h6>
                <a-config-provider>
                    <template #renderEmpty>
                        <div style="text-align: center">
                            <i style="color: orange;" class="las la-exclamation-triangle"></i>
                        </div>
                    </template>
                    <a-list item-layout="horizontal" row-key="key" :data-source="sendDoc.recipient">
                        <a-list-item slot="renderItem" slot-scope="it, idx">
                            <a-list-item-meta
                                :description="it.obj.name"
                            >
                            </a-list-item-meta>
                        </a-list-item>
                    </a-list>
                </a-config-provider>
            </div>
            <div class="col-4">
                <h6>Terkirim Kepada</h6>
                <a-config-provider>
                    <template #renderEmpty>
                        <div style="text-align: center">
                            <i style="color: orange;" class="las la-exclamation-triangle"></i>
                        </div>
                    </template>
                    <a-list item-layout="horizontal" row-key="key" :data-source="sentTo.sendRecipient">
                        <a-list-item slot="renderItem" slot-scope="it, idx">
                            <a-list-item-meta
                                :description="it.obj.name"
                            >
                            </a-list-item-meta>
                        </a-list-item>
                    </a-list>
                </a-config-provider>
            </div>
            <div class="col-4">
                <h6>Tembusan</h6>
                <a-config-provider>
                    <template #renderEmpty>
                        <div style="text-align: center">
                            <i style="color: orange;" class="las la-exclamation-triangle"></i>
                        </div>
                    </template>
                    <a-list item-layout="horizontal" row-key="key" :data-source="sentTo.copyRecipient">
                        <a-list-item slot="renderItem" slot-scope="it, idx">
                            <a-list-item-meta
                                :description="it.obj.name"
                            >
                            </a-list-item-meta>
                        </a-list-item>
                    </a-list>
                </a-config-provider>
            </div>
        </div>

    </b-modal>

<b-modal id="archiveModal"
             size="md"
             centered
             scrollable
             no-close-on-backdrop
             no-close-on-esc
             @ok.prevent="commitArchive()"
             ok-title="Arsipkan"
             cancel-title="Close"
             @hidden="archiveModalHidden"
             @shown="archiveModalShown"
             modal-class="modal-bv"
             :hide-footer="false"
             style="min-height: 300px;"
    >
        <template v-slot:modal-header="{ close }">
            <span class="modal-title" >
                   <h4 style="margin-bottom: 0px;"  >Arsipkan Naskah</h4>
            </span>
            <!-- Emulate built in modal header close button action -->
            <b-button size="sm" variant="outline-secondary" pill @click="close()">
                <b-spinner small v-show="isLoading" label="Loading..."></b-spinner>
                <i v-show="!isLoading" class="fa fa-times"></i>
            </b-button>
        </template>
        <template v-slot:modal-footer >
{{--            <button class="btn btn-outline-danger" pill @click="hideLogModal()">--}}
{{--                <i class="fa fa-times" ></i> Close--}}
{{--            </button>--}}
        </template>
        <h5>No : @{{ sendDoc.docNo }}</h5>
        <div class="row">
            <div class="col-12">
                <h6>Kategori Arsip</h6>
                <b-form-select
                    name="HasLinkFilter"
                    v-model="archiveCategorySelection"
                    :options="archiveCategoryOptions"
                ></b-form-select>
            </div>
        </div>

    </b-modal>
