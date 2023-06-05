<div class="" style="border-radius: 1rem;">
    <div class="card-header p-2">
        <h5 class="mt-2 mb-2" v-html="{{ __($form['title']) }}"></h5>
    </div>
    <div class="card-body">
        <br>
        <apexchart
            width="100%"
            height="auto"
            :options="{{ $form['chart_options'] }}"
            :series="{{ $form['model'] }}"
        ></apexchart>
    </div>
</div>
