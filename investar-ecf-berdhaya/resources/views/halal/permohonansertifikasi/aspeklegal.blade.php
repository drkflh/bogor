<div id="doc">
    <div class="row">
        <div class="col-12" style="text-overflow: ellipsis; ">
            <label for="Id PU" style="color:#000000;font-weight: bold;">Id</label>
            <input class="form-control" name="id_pu" type="number" v-model="value.id_pu" />
        </div>

        <div class="col-12">
            <label for="Jenis Surat" style="color:black;font-weight: bold;">Jenis Surat</label>
            <input class="form-control" name="jenis_surat" type="text" v-model="value.jenis_surat" />
        </div>

        <div class="col-12">
            <label for="Jenis Surat Lainnnya" style="color:#000000;font-weight: bold;">Jenis Surat Lainnya</label>
            <input class="form-control" name="jenis_surat_lainnya" type="text" v-model="value.jenis_surat_lainnya" />
        </div>

        <div class="col-12">
            <label for="No Surat" style="color:#000000;font-weight: bold;">No Surat</label>
            <input class="form-control" name="no_surat" type="number" v-model="value.no_surat" />
        </div>

        <div class="col-12">
            <label for="Tanggal" style="color:#000000;font-weight: bold;">Tgl Surat</label>
            <input class="form-control" name="tgl_surat" type="date" v-model="value.tgl_surat" />
        </div>
        <div class="col-12">
            <label for="Masa Berlaku" style="color:#000000;font-weight: bold;">Masa Berlaku</label>
            <input class="form-control" name="masa_berlaku" type="date" v-model="value.masa_berlaku" />
        </div>
        <div class="col-12">
            <label for="Instansi Penerbit" style="color:#000000;font-weight: bold;">Instansi</label>
            <input class="form-control" name="instansi_penerbit" type="text" v-model="value.instansi_penerbit" />
        </div>
    </div>
</div>
