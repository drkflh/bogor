<div class="header">
    <div class="position-absolute top-0 start-0"></div>
    <h3>KONFIRMASI REGISTRASI SIHALAL</h3>
</div><hr>

<h4>Apakah Anda yakin Akan Melakukan Pendaftaran Produk Sihalal Berikut ? </h4>
<br>
<div >
    <div class="row">
        <div class="col">
                <h6><strong>Nama Produk :</strong> @{{ name ?? '-'}}</h6>    
                <h6><strong>Detail Produk :</strong> @{{ productDetail ?? '-'}}</h6>  
                <h6><strong>Business Ref :</strong> @{{ businessRef  ?? '-'}}</h6>  <br>
                <h6><strong>BOM :</strong> @{{ bom ?? '-'}}</h6>          
        </div>
    </div>
</div>
<div class="row">
    <form method="POST" action="{{ url('halal/halal-product/confirm-sihalal') }}">
        @csrf
        <div class="col mt-5 mb-2 ">
            <button class="btn btn-danger" type="button"><a href="halal-product">
                <i style="color:white;">Kembali</i>
            </a></button>  
            <button class="btn btn-success" type="submit">
                <i style="color:white;">Konfirmasi</i>
            </button>  
        </div>
    </form>
</div>