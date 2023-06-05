<div class="header">
    <div class="position-absolute top-0 start-0"></div>
    <h3>REGISTRASI USER SIHALAL</h3>
</div><hr>

<h4>Untuk Pendaftaran Sertifikasi Produk Halal, Anda Harus Menjadi Member di Sistem Sihalal. </h4>
<h5>Apakah Anda Ingin Mendaftar?</h5>
<br>
<template>
    <form method="POST" action="{{ url('halal/halal-product/reg-sihalal') }}">
        @csrf
        <div class="row mt-5">
            <div class="col">
                <button class="btn btn-danger" type="button"><a href="halal-product">
                    <i style="color:white;">Tidak</i>
                </a></button>  
                <button class="btn btn-primary" type="submit">
                    <i style="color:white;">Daftar Sihalal</i>
                </button>  
            </div>
        </div>
    </form>
</template>