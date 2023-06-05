<div id="doc">
    <div class="row">
        <div class="col-12" style="text-overflow: ellipsis; ">
            <label for="Id PU" style="color:#000000;font-weight: bold;">ID</label>
            <input class="form-control" name="id_pu" type="number" v-model="value.id_pu" />
        </div>
        <div class="col-12" style="text-overflow: ellipsis; ">
            <label for="Nama Outlet" style="color:#000000;font-weight: bold;">Outlet Name</label>
            <input class="form-control" name="nama" type="text" v-model="value.nama" />
        </div>
        <div class="col-12">
            <label for="Alamat" style="color:black;font-weight: bold;">Alamat</label>
            <input class="form-control" name="alamat" type="text" v-model="value.alamat" />
        </div>

        <div class="col-12">
            <label for="Kab/Kota" style="color:#000000;font-weight: bold;">Kabupaten</label>
            <input class="form-control" name="kab_kota" type="text" v-model="value.kab_kota" />
        </div>

        <div class="col-12">
            <label for="Provinsi" style="color:#000000;font-weight: bold;">Provinsi</label>
            <input class="form-control" name="provinsi" type="text" v-model="value.provinsi" />
        </div>
        <div class="col-12">
            <label for="Negara" style="color:#000000;font-weight: bold;">Negara</label>
            <input class="form-control" name="negara" type="text" v-model="value.negara" />
        </div>
        <div class="col-12">
            <label for="Kode Pos" style="color:#000000;font-weight: bold;">Kode Pos</label>
            <input class="form-control" name="kode_pos" type="text" v-model="value.kode_pos" />
        </div>
    </div>
</div>
