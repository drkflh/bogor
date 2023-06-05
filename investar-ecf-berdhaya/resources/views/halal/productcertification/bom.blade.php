<div id="doc">
    <div class="row">
        <div class="col-12" style="text-overflow: ellipsis; ">
            <label for="Nama Bahan" style="color:#000000;font-weight: bold;">Nama Bahan</label>
            <input class="form-control" name="material" type="text" v-model="value.material" />
        </div>
    
        <div class="col-12">
            <label for="Merek Produk" style="color:black;font-weight: bold;">Merek Produk</label>
            <input class="form-control" name="materialBrand" type="text" v-model="value.materialBrand" />
        </div>

        <div class="col-12">
            <label for="Produsen" style="color:#000000;font-weight: bold;"> Produsen</label>
            <input class="form-control" name="producer" type="text" v-model="value.producer" />
        </div>

        <div class="col-12">
            <label for="Nomor Sertifikat Halal" style="color:#000000;font-weight: bold;">Nomor SH</label>
            <input class="form-control" name="halalCertNo" type="text" v-model="value.halalCertNo" />
        </div>

        <div class="col-12">
            <label for="Masa Berlaku Sertifikasi Halal" style="color:#000000;font-weight: bold;">Masa Berlaku </label>
            <input class="form-control" name="halalCertValidUntil" type="text" v-model="value.halalCertValidUntil" />
        </div>
    </div>
</div>
