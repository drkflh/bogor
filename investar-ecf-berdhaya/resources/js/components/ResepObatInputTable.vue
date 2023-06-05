<template>
    <div class="sti-container" style="width: 100%; margin-top: 20px;">
        <div style="width: 100%;display: block;">
            <label>{{ label }}</label>
            <button  v-if="hideAddButton"  class="btn btn-primary btn-sm pull-right" @click="showModal('terapiObatHistoryModal')" ><i class="las la-plus-circle"></i></button>
        </div>
        <div style="width: 100%;display: block;">
            <table class="table">
                <tr v-for="item in objItems">
                    <td v-if="_.has(item, 'data' )">
                        {{ splitExtract(item['data']['terapiObat']['namaObat'], 0) }} {{ item['data']['terapiObat']['jumlah'] ? ', ' + item['data']['terapiObat']['jumlah'] + ' ' + splitExtract(item['data']['terapiObat']['namaObat'], 1) : '' }} {{ item['data']['terapiObat']['namaObatTeks'] ? ', '+ item['data']['terapiObat']['namaObatTeks'] : '' }} {{ item['data']['terapiObat']['aturanPakai'] ? ', '+ item['data']['terapiObat']['aturanPakai'] : '' }} {{ item['data']['terapiObat']['aturanPakaiTeks'] ? ', '+ item['data']['terapiObat']['aturanPakaiTeks'] : '' }} {{ item['data']['terapiObat']['mata'] ? ', '+ item['data']['terapiObat']['mata'] : ''}} {{ item['data']['terapiObat']['keterangan'] ? ', '+ item['data']['terapiObat']['keterangan'] : ''}}
                    </td>
                    <td v-else>
                        {{ splitExtract( item.namaObat , 0) }} {{ item.jumlah ? ', ' + item.jumlah + ' ' + splitExtract(item.namaObat, 1) : '' }} {{ item.namaObatTeks ? ', '+ item.namaObatTeks : '' }} {{ item.aturanPakai ? ', '+ item.aturanPakai : '' }} {{ item.aturanPakaiTeks ? ', '+ item.aturanPakaiTeks : '' }} {{ item.mata ? ', '+ item.mata : ''}} {{ item.keterangan ? ', '+ item.keterangan : ''}}
                    </td>
                    <td style="position: relative;width: 50px;max-width: 50px;vertical-align: bottom;padding-right: 0px;">
                        <span v-on:click="removeItem(item)" style="cursor: pointer;" class="btn btn-sm btn-danger pull-right" ><i class="las la-times-circle"></i></span>
                    </td>
                </tr>
            </table>
        </div>

        <b-modal id="terapiObatHistoryModal"
                 title="Terapi Obat"
                 size="lg"
                 scrollable
                 no-close-on-backdrop
                 no-close-on-esc
                 modal-class="modal-bv"
                 @ok="hideModal('terapiObatHistoryModal')"
                 ok-title="Close"
                 :ok-only="true"
                 ok-variant="secondary">
            <table class="table">
                <tr>
                    <th>
                        Saat Ini
                    </th>
                    <td style="position: relative;width: 150px;max-width: 150px;vertical-align: bottom;padding-right: 0px;">
                        <button class="btn btn-primary btn-sm" @click="showModal('terapiObatModal')" >Buat Resep Baru</button>
                    </td>
                </tr>
            </table>
            <table class="table">
                <tr v-for="(item, index) in objItems">
                    <td v-if="_.has(item, 'data' )">
                        {{ splitExtract(item['data']['terapiObat']['namaObat'], 0) }} {{ item['data']['terapiObat']['jumlah'] ? ', ' + item['data']['terapiObat']['jumlah'] + ' ' + splitExtract(item['data']['terapiObat']['namaObat'], 1) : '' }} {{ item['data']['terapiObat']['namaObatTeks'] ? ', '+ item['data']['terapiObat']['namaObatTeks'] : '' }} {{ item['data']['terapiObat']['aturanPakai'] ? ', '+ item['data']['terapiObat']['aturanPakai'] : '' }} {{ item['data']['terapiObat']['aturanPakaiTeks'] ? ', '+ item['data']['terapiObat']['aturanPakaiTeks'] : '' }} {{ item['data']['terapiObat']['mata'] ? ', '+ item['data']['terapiObat']['mata'] : ''}} {{ item['data']['terapiObat']['keterangan'] ? ', '+ item['data']['terapiObat']['keterangan'] : ''}}
                    </td>
                    <td v-else>
                        {{ splitExtract( item.namaObat , 0) }} {{ item.jumlah ? ', ' + item.jumlah + ' ' + splitExtract(item.namaObat, 1) : '' }} {{ item.namaObatTeks ? ', '+ item.namaObatTeks : '' }} {{ item.aturanPakai ? ', '+ item.aturanPakai : '' }} {{ item.aturanPakaiTeks ? ', '+ item.aturanPakaiTeks : '' }} {{ item.mata ? ', '+ item.mata : ''}} {{ item.keterangan ? ', '+ item.keterangan : ''}}
                    </td>
                    <td style="position: relative;width: 50px;max-width: 50px;vertical-align: bottom;padding-right: 0px;">
                        <span v-on:click="removeItem(item)" style="cursor: pointer;" class="btn btn-sm btn-danger pull-right" ><i class="las la-times-circle"></i></span>
                    </td>
                </tr>
            </table>

            <table class="table">
                <tr v-if="checkedHistory.length>0">
                    <th colspan="2">
                        <span>Riwayat Resep Obat</span>
                        <button class="btn btn-primary btn-sm pull-right" :disabled="roTerapiObat.length === 0 || !roTerapiObat[0].checked" @click="showModal('terapiObatModal', roTerapiObat);" >Ulang</button>
                    </th>
                </tr>
                <template v-if="isEmpty(checkedHistory)">
                    <tr>
                        <th colspan="2">
                            <p>Tidak ada riwayat resep obat</p>
                        </th>
                    </tr>
                </template>
                <template v-else >
                    <template v-for="(ro, index) in checkedHistory">
                        <tr>
                            <td colspan="2">
                                <template v-if="ro.data.kodeDokter.indexOf('-') !== -1">
                                    <b>{{ fmtDate( ro.data.tanggal , 'DD MMM YYYY' ) }} {{  ro.data.namaJenis }} {{  ro.data.kodeDokter.split('-')[1].substring(0,3) }}</b><br>
                                </template>
                                <template v-else>
                                    <b>{{ fmtDate( ro.data.tanggal , 'DD MMM YYYY' ) }} {{  ro.data.namaJenis }} {{  ro.data.kodeDokter.substring(0,3) }}</b><br>
                                </template>
                            </td>
                        </tr>
                        <tr>
                            <td v-if="checkedHistory.length>0" style="width: 10px;">
                                <input type="checkbox" v-model="checkedHistory[index].checked" @input="onChecked(ro, index)"/>
                            </td>
                            <td v-if="_.has(ro, 'data' )">
                                <template v-if="!empty(ro.data.terapiObat['namaObat'])">
                                    {{ splitExtract(ro.data.terapiObat['namaObat'], 0) }}
                                </template>
                                <template v-if="parseInt(ro.data.terapiObat['jumlah']) > 0">
                                    , {{ ro.data.terapiObat['jumlah'] }} {{ splitExtract(ro.data.terapiObat['namaObat'], 1) }}
                                </template>
                                <template v-if="!empty(ro.data.terapiObat['namaObatTeks'])">
                                    , {{ ro.data.terapiObat['namaObatTeks'] }}
                                </template>
                                <template v-if="!empty(ro.data.terapiObat['aturanPakai'])">
                                    , {{ ro.data.terapiObat['aturanPakai'] }}
                                </template>
                                <template v-if="!empty(ro.data.terapiObat['aturanPakaiTeks'])">
                                    , {{ ro.data.terapiObat['aturanPakaiTeks'] }}
                                </template>
                                <template v-if="!empty(ro.data.terapiObat['mata'])">
                                    ,{{ ro.data.terapiObat['mata'] }}
                                </template>
                                <template v-if="!empty(ro.data.terapiObat['keterangan'])">
                                    ,{{ ro.data.terapiObat['keterangan'] }}
                                </template>
                            </td>
                            <td v-else >
                                <template v-if="!empty(ro['namaObat'])">
                                    {{ splitExtract(ro['namaObat'], 0) }}
                                </template>
                                <template v-if="parseInt(ro['jumlah']) > 0">
                                    , {{ ro['jumlah'] }} {{ splitExtract(ro['namaObat'], 1) }}
                                </template>
                                <template v-if="!empty(ro['namaObatTeks'])">
                                    , {{ ro['namaObatTeks'] }}
                                </template>
                                <template v-if="!empty(ro['aturanPakai'])">
                                    , {{ ro['aturanPakai'] }}
                                </template>
                                <template v-if="!empty(ro['aturanPakaiTeks'])">
                                    , {{ ro['aturanPakaiTeks'] }}
                                </template>
                                <template v-if="!empty(ro['mata'])">
                                    ,{{ ro['mata'] }}
                                </template>
                                <template v-if="!empty(ro['keterangan'])">
                                    ,{{ ro['keterangan'] }}
                                </template>
                            </td>

                        </tr>

                    </template>
                </template>
            </table>

        </b-modal>

        <b-modal id="terapiObatModal"
                 @ok="saveHideModal('terapiObatModal')"
                 @hide="onHide"
                 title="Terapi Obat"
                 scrollable
                 no-close-on-backdrop
                 no-close-on-esc
                 size="lg"
                 modal-class="modal-bv" >
            <tab v-if="roTerapiObat.length>0"
                :header="tabTitle"
                @tab-index="onTabIndex">
                <div>
                <div v-for="(item, index) in roTerapiObat">
                        <div :id="'tab'+index" v-if="activeTab===index">
                            <div class="row">
                                <div class="col-6">
                                    <async-select
                                        :id="'namaObat'+index"
                                        :name="'namaObat'+index"
                                        v-model="roTerapiObat[index].data.terapiObat.namaObat"
                                        :label="'Nama Obat'"
                                        :searchUrl="params.jenisObatUrl"
                                        :autocomplete="'off'"
                                        :disabled="false"
                                        :placeholder="'Search'"
                                        :searchVar="'q'"
                                        :refs="'namaObat'+index"
                                        :labelField="'Nama'"
                                        :valueField="'ID'"
                                        :defaultValue="roTerapiObat[index].data.terapiObat.namaObat"
                                        @onSelected="onNamaObatSelected">
                                    </async-select>
                                    <label :for="'mata'+index" >Mata</label><br>
                                    <b-form-select
                                            v-model="roTerapiObat[index].data.terapiObat.mata"
                                            :options="params.mataoptions"
                                    ></b-form-select>

                                    <async-select
                                        :id="'aturanPakai'+index"
                                        :name="'aturanPakai'+index"
                                        v-model="roTerapiObat[index].data.terapiObat.aturanPakai"
                                        :label="'Aturan Pakai'"
                                        :searchUrl="params.aturanPakaiUrl"
                                        :autocomplete="'off'"
                                        :disabled="false"
                                        :placeholder="'Search'"
                                        :searchVar="'q'"
                                        :refs="'aturanPakai'+index"
                                        :labelField="'Name'"
                                        :valueField="'Code'"
                                        :defaultValue="roTerapiObat[index].data.terapiObat.aturanPakai"
                                        @onSelected="onAturanPakaiSelected">
                                    </async-select>

                                </div>
                                <div class="col-6">
                                    <label :for="'namaObatTeks'+index" >Nama Obat (Text)</label><br>
                                    <input type="text" class="form-control" :id="'namaObatTeks'+index"
                                        v-model="roTerapiObat[index].data.terapiObat.namaObatTeks"
                                    ></input>
                                    <label :for="'jumlah'+index" >Jumlah</label><br>
                                    <input type="number" class="form-control" :id="'jumlah'+index"
                                        v-model="roTerapiObat[index].data.terapiObat.jumlah"
                                    ></input>
                                    <label :for="'aturanPakaiTeks'+index" >Aturan Pakai (Text)</label><br>
                                    <input type="text" class="form-control" :id="'aturanPakaiTeks'+index"
                                        v-model="roTerapiObat[index].data.terapiObat.aturanPakaiTeks"
                                    ></input>
                                </div>
                            </div>
                            <label :for="'keterangan'+index" >Keterangan</label><br>
                            <textarea style="height: 80px;" class="form-control" v-model="roTerapiObat[index].data.terapiObat.keterangan" ></textarea>
                        </div>
                    </div>
                </div>
            </tab>

        </b-modal>


    </div>

</template>

<script>

    export default {
        name: "ResepObatInputTable",
        props: {
            label : {
                type: String,
                default: 'Table Input'
            },
            cols : {
                type: Array,
                default: function(){
                    return [];
                }
            },
            items : {
                type: Array,
                default: function(){
                    return [];
                }
            },
            historyItems : {
                type: Array,
                default: function(){
                    return [];
                }
            },
            content: {
                type: [String, Object, Array]
            },
            params: {
                type: [String, Object, Array]
            },
            template: {
                type: [String, Object, Array]
            },
            objectDefault: {
                type: [String, Object, Array],
                default: function () {
                    return {}
                }
            },
            hideAddButton: {
                type: Boolean,
                default: false
            }
        },
        data: function(){
            return {
                editObj : this.objectDefault,
                aturanPakaiSelected : '',
                aturanPakaiObject : {},
                namaObatSelected : '',
                aturanPakaiSelected : '',
                checkedHistory: [],
                tabTitle: ['Tambah Baru'],
                roTerapiObat: [],
                activeTab: 0,
                // Tak tambahin obj baru
                objItems: []
            };
        },
        watch:{
            namaObatObject: function(val){
                this.editObj.kodeObat = val.ID;
            },
            checkedHistory: function(val) {
                console.log('valcheckedHistory', val)
            },
            $bvModal: function(val) {
                console.log(val)
            },
            objItems: function (val){
                this.$emit('update:items', val);
            }
        },
        computed: {
            dataChecked() {
                let data = this.checkedHistory;
                console.log('dataChecked', data)
                return data.filter(i => i.checked);
                // return this.checkedHistory.filter(i => i.checked);
            }
        },
        created() {
            if(this.historyItems.length>0) {
                this.objItems = _.cloneDeep(this.items)
                this.historyItems.map((i) => {
                    if(i.terapiObat.length>0) {
                        i.terapiObat.map((j, index) => {
                            this.checkedHistory.unshift({
                                index: index,
                                checked: false,
                                data:  {
                                    ...i,
                                    terapiObat: j
                                }
                            });
                        })
                    }
                })
                console.log('this.objItems', this.objItems)
                this.roTerapiObat = []
            }
        },
        methods: {
            addItem(){
                if(this.isEmpty(this.roTerapiObat)){
                    alert('Empty data !')
                }else{
                    this.pushItems(this.roTerapiObat)
                }
            },
            pushItems(items) {
                console.log('items', items)
                if(items.length>0) {
                    var index = items.findIndex(tab => typeof tab.isTab !=='undefined')
                    // console.log('items[index]', items[index].data)
                    var includeTab = this.checkProperties(items[index].data.terapiObat)
                    console.log('includeTab', includeTab)
                    if(!includeTab) {
                        items.map((k) => {
                            console.log('k', k)
                            this.objItems.push(_.cloneDeep(k))
                        })
                    } else {
                        items.filter(i => typeof i.isTab ==='undefined')
                        .map((j) => {
                            console.log('j', j)
                            this.objItems.push(_.cloneDeep(j))
                        })
                    }
                }
                console.log('objItems', this.objItems)
                this.roTerapiObat = []
                // this.editObj = _.cloneDeep(this.objectDefault);
                this.hideModal('terapiObatHistoryModal');

            },
            checkProperties(obj) {
                for (var key in obj) {
                    if (obj[key] !== null && obj[key] != "")
                        return false;
                }
                return true;
            },
            clearChecked() {
                if(this.checkedHistory.length>0) {
                    let data = []
                    this.checkedHistory.map((item) => {
                        data.push({
                            ...item,
                            checked: false
                        })
                    })
                    this.checkedHistory = _.cloneDeep(data)
                }
            },
            contentToModel(obj){
                this.editObj = obj;
            },
            modelToDefault(){
                this.editObj = _.cloneDeep(this.objectDefault);
            },
            emitData(){
                var val = this.value;
                // if(typeof val !== 'undefined') {
                    //     this.$emit('input', this.roTerapiObat );
                // }
                this.roTerapiObat = [];
                this.editObj = _.cloneDeep(this.objectDefault);
            },
            showModal(_id, obj) {
                console.log('ulangResep', obj);
                if(obj == undefined || obj == null){
                    const obj_x = [
                        {
                            index: 0,
                            checked: false,
                            isTab: true,
                            data: {
                                terapiObat: _.cloneDeep(this.objectDefault)
                            }
                        }
                    ];
                    // this.editObj = _.cloneDeep(obj_x);
                    this.roTerapiObat = obj_x
                    this.setTab(this.roTerapiObat)

                }else{
                    const obj_x = obj.concat([
                        {
                            index: obj.length === 1 ? 1 : (obj.length - 1) + 1,
                            checked: false,
                            isTab: true,
                            data: {
                                terapiObat: _.cloneDeep(this.objectDefault)
                            }
                        }
                    ]);
                    // this.editObj = _.cloneDeep(obj_x);
                    this.roTerapiObat = obj_x
                    console.log('roTerapiObat', this.roTerapiObat)
                    this.setTab(this.roTerapiObat)
                    // this.namaObatSelected = this.editObj.namaObat;
                    // this.aturanPakaiSelected = this.editObj.aturanPakai;

                }
                this.$bvModal.show(_id);
            },
            setTab(obj) {
                console.log('obj', obj.length)
                this.tabTitle = []
                if(obj.length>0 && obj.length === 1) {
                    this.tabTitle = ['Tambah Baru']
                } else if(obj.length>0 && obj.length > 1){
                    this.tabTitle = ['Tambah Baru']
                    obj.map((j) => {
                        if(j.data.terapiObat.kodeObat) {
                            this.tabTitle.unshift(j.data.terapiObat.namaObat)
                        }
                    })
                }
            },
            hideModal(_id) {
                this.$bvModal.hide(_id);
                this.emitData();
            },
            onHide(evt) {
                this.tabTitle = ['Tambah Baru']
                this.roTerapiObat = []
                this.clearChecked()
                this.$bvModal.hide('terapiObatModal');
            },
            saveHideModal(_id) {
                this.addItem();
                this.$bvModal.hide(_id);

                if(_id != 'terapiObatHistoryModal'){
                    this.$bvModal.show('terapiObatHistoryModal');
                }

                this.emitData();
            },

            removeItem(obj){
                var index = this.objItems.indexOf(obj);
                this.objItems.splice(index, 1);
            },
            isEmpty(obj) {
                for(var key in obj) {
                    if(obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            },
            empty(obj){
              return _.isEmpty(obj) || obj === '';
            },
            reverseArray(arr){
                return _.reverse(arr);
            },
            fmtDate(dateString, dateFormat){
                var dtrans = moment(dateString).format(dateFormat);
                return dtrans;
            },
            toggleShowAll(){
                this.showAll = !this.showAll;
            },
            splitExtract(str, x){
                console.log('splitExStr', str);
                if( _.isNull( str ) || _.isUndefined( str )){
                    return '';
                }else{
                    var arr = str.split(',');
                    console.log('splitEx', arr);
                    return arr[x] ? arr[x] : '';
                }
            },
            splitCamel(str){
                str = str.replace(/([a-z\xE0-\xFF])([A-Z\xC0\xDF])/g, "$1 $2");
                str = str.toLowerCase(); //add space between camelCase text
                return str;
            },
            lowerCase(str) {
                if(str == null || str == undefined ){

                }else{
                    str = str.toLowerCase();
                }
                return str.toLowerCase();

            },
            upperCase(str) {
                if(str == null || str == undefined ){

                }else{
                    str = str.toUpperCase();
                }
                return str.toUpperCase();
            },
            properCase(str) {
                if(str == null || str == undefined ){

                }else{
                    str = this.lowerCase(str).replace(/^\w|\s\w/g, this.upperCase);
                }
                return str;
            },
            bus(evt, payload){
                bus.$emit(evt, payload );
            },
            onNamaObatSelected(val) {
                console.log('namaobatval', val)
                if(this.roTerapiObat.length>0) {
                    this.roTerapiObat[this.activeTab].data.terapiObat.namaObat = val.value;
                    this.roTerapiObat[this.activeTab].data.terapiObat.kodeObat = val.isfreetext;
                    var uom = this.splitExtract( val.value, 1);
                    this.roTerapiObat[this.activeTab].data.terapiObat.unitPenggunaan = uom.trim();

                }
                // else {
                //     this.editObj.namaObat = val.value
                // }
            },
            onAturanPakaiSelected(val) {
                console.log('aturanval', val)
                if(this.roTerapiObat.length>0) {
                    this.roTerapiObat[this.activeTab].data.terapiObat.aturanPakai = val.value
                    this.roTerapiObat[this.activeTab].data.terapiObat.kodeAturanPakai = val.isfreetext
                }
                // else {
                //     this.editObj.aturanPakai = val.value
                // }
            },
            onChecked(item, index) {
                this.checkedHistory[index].checked = !this.checkedHistory[index].checked
                let data = this.checkedHistory.filter(i => i.checked);
                this.roTerapiObat = _.cloneDeep(data)
                console.log('roTerapiObat', this.roTerapiObat)
            },
            onTabIndex(index) {
                this.activeTab = index
                console.log(index)
            }

        }
    }
</script>

<style scoped>

</style>
