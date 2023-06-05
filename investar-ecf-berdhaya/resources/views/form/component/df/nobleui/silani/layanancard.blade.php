<div class="card" style="border-radius: 1rem;">
  <div class="card-body">
    <h4 v-html="{{ $form['title'] }}"></h4>
    <br>
      <apexchart
          width="350"
          height="auto"
          :options="{{ $form['chart_options'] }}"
          :series="{{ $form['model'] }}"
      ></apexchart>
  </div>
</div>
