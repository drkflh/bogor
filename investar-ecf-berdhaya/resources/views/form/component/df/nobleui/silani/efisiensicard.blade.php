<div class="row">
  <div class="col-md-6">
    <h5 class="m-3">Efisiensi Permintaan</h5>
  </div>
  <div class="col-md-6">
    <h5 class="m-3">Tingkat Pembatalan</h5>
  </div>
</div>

<div class="row">
  <div class="col-md-6" data-toggle="popover" data-trigger="hover focus" data-placement="right" title="(total sukses ÷ total selesai) * 100">
    <div class="card mb-4" style="border-radius: 1rem;">
      <apexchart
        width="100%"
        height="auto"
        :options="{{ $form['chart_options'] }}"
        :series="{{ $form['percent_efisiensi'] }}"
      ></apexchart>
    </div>
  </div>

  <div class="col-md-6" data-toggle="popover" data-trigger="hover focus" data-placement="right" title="(total cancel ÷ total seluruh) * 100">
    <div class="card mb-4" style="border-radius: 1rem;">
        <apexchart
          width="100%"
          height="auto"
          :options="{{ $form['chart_options_cancel'] }}"
          :series="{{ $form['percent_cancel'] }}"
          ></apexchart>
    </div>
  </div>
</div>
