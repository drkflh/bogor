<b-modal id="runFormModal"
         no-close-on-backdrop
         no-close-on-esc
         @ok="commitSaveForm"
         ok-title="Submit Form"
         size="lg"
         centered
         scrollable
         @shown="loadFormDef()"
         :title="getFormTitle()"
         modal-class="modal-bv">
    <div class="row" id="runFormModal">
        <div class="col-12">
            <active-form
                v-model="runFormModel"
                :content="runFormContent"
                :object-default="runFormDefault"
                :template="runFormTemplate"
            ></active-form>
        </div>
    </div>
</b-modal>
