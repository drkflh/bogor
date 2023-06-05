<div id="contact">
  <simple-switch
    label="Default"
    v-model="value.contactDefault"
    :model="value.contactDefault"
    position="right"
    :checkedlabel="true"
  >
  </simple-switch>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <label for="contactName">Name</label>
            <input class="form-control" name="contactName" type="text" v-model="value.contactName" />
        </div>
        <div class="col-md-6 col-xs-12" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                <label for="contactEmail">Email</label>
                <input class="form-control" name="contactEmail" type="email" v-model="value.contactEmail" />
        </div>
    </div>
    <div class="row">
    <div class="col-md-6 col-xs-12">
      <label for="contactPhone">Phone</label>
      <input class="form-control" name="contactPhone" type="text" v-model="value.contactPhone" />
    </div>
        <div class="col-md-6 col-xs-12">
            <label for="contactMobile">Mobile</label>
            <input class="form-control" name="contactMobile" type="text" v-model="value.contactMobile" />
        </div>
  </div>
</div>
