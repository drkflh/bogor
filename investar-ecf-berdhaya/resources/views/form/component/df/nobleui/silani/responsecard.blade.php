<?php
$role = \App\Helpers\AuthUtil::getRoleName(Auth::user()->roleId );
?>

<div class="card" style="border-radius: 1rem;">
  <div class="card-body">
    <h3 class="mt-2" v-html="{{ $form['title'] }}"></h3>
    @if ($role == "Case Manager" || $role == "Senior Case Manager")
      <p><b>Lansia wilayah kerja </b> {{Auth::user()->name}}</p>
    @endif
    <br>
    <column-chart
        ref="{{ $form['model'] }}"
        @if(isset($form['url']) )
            data="{{ url( $form['url'] ) }}"
        @else
            :data="{{ $form['model'] }}"
        @endif

        @if(isset($form['refresh']) )
            refresh="{{ url( $form['refresh'] ) }}"
        @endif

    ></column-chart>
  </div>
</div>
