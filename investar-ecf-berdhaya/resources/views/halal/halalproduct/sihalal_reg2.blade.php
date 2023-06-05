<div class="header">
    <div class="position-absolute top-0 start-0"></div>
    <h3>REGISTRASI PELAKU USAHA SIHALAL</h3>
</div><hr>

<h4>Untuk Pendaftaran Sertifikasi Produk Halal, Usaha Anda Harus Terdaftar di Sistem Sihalal. </h4>
<h5>Apakah Anda Ingin Mendaftarkan juga?</h5>
<br>
<div class="row mt-5">
    <form method="POST" action="{{ url('halal/halal-product/reg2-sihalal') }}">
        @csrf
        <div class="col">
            <button class="btn btn-danger" type="button"><a href="halal-product">
                <i style="color:white;">Kembali</i>
            </a></button>  
            <button class="btn btn-primary"><a href="sihalal-register2">
                <i style="color:white;">Resend</i>
            </a></button>&nbsp;&nbsp;&nbsp;&nbsp;
            <button class="btn btn-success" type="submit">
                <i style="color:white;">Daftar Sihalal</i>
            </button>  
        </div>
    </form>
</div>