<div class="card shadow-md" style="height: 410px; border-radius: 10px">
  <div class="card-body" data-toggle="popover" data-trigger="hover focus" data-placement="right" title="Artikel yang baru ditambahkan">
    <h3><i class="las la-newspaper"></i> Artikel Terbaru</h3>
    <hr>
    <p style="font-size: 20px; font-weight: bold;" v-html="{{ $form['data'] }}.title" class="my-3"></p>
    <p class="text-muted" style="font-size: 12px">Created Date: <span v-html="{{ $form['data'] }}.createdDate"></span></p>
    <p class="my-3" style="overflow: hidden;display: -webkit-box;-webkit-line-clamp: 4;-webkit-box-orient: vertical;" v-html="{{ $form['data'] }}.body"></p>
    <?php
      $role = \App\Helpers\AuthUtil::getRoleName(Auth::user()->roleId );
    ?>
    @if ($role == "Superuser")
    <div class="d-flex justify-content-end">
      <a class="btn btn-primary py-2 px-4 text-white mt-3" href="/cms/article">Selengkapnya</a>
    </div>
    @endif
  </div>
</div>