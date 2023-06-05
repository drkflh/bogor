<b-modal id="historyLogModal" size="md" centered no-close-on-backdrop no-close-on-esc @ok="hideLogModal"
    ok-title="Close" cancel-title="Close" @hidden="logModalHidden" @shown="logModalShown" modal-class="modal-bv"
    :hide-footer="true" style="min-height: 300px;">
    <template v-slot:modal-header="{ close }">
        <span class="modal-title">
            <h4 style="margin-bottom: 0px;"></h4>
        </span>
        <!-- Emulate built in modal header close button action -->
        <b-button size="sm" variant="outline-secondary" pill @click="close()">
            <b-spinner small v-show="isLoading" label="Loading..."></b-spinner>
            <i v-show="!isLoading" class="fa fa-times"></i>
        </b-button>
    </template>
    <template v-slot:modal-footer>

    </template>
    <approval-time-line v-model="docHistory"></approval-time-line>

</b-modal>