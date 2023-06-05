

    <template v-else-if="props.column.field == 'position'">
        Email<hr>
        No. Whatsapp
    </template>
    <template v-else-if="props.column.field == 'email'">
        Nama<hr>
        Posisi di perusahaan
    </template>
    <template v-else-if="props.column.field == 'bizTradeMark'">
        Merek Bisnis<hr>
        Jenis Usaha
    </template> 
    <template v-else-if="props.column.field == 'bizRegisteredName'">
        Nama Badan Usaha <hr>
        Bentuk Badan Usaha
    </template> 
    <template v-else-if="props.column.field == 'establishedSinceYear'">
        Berdiri Tahun<hr>
        Lama Bisnis Berdiri
    </template> 
    <template v-else-if="props.column.field == 'requiredFunding'">
        Pendanaan yang dibutuhkan (Rp)<hr>
        Jenis pendanaan
    </template>  
    <template v-else-if="props.column.field == 'campaignTitle'">
        Nama Kampanye<hr>
        Periode Kampanye
    </template>
    <template v-else-if="props.column.field == 'campaignStart'">
        Mulai<hr>
        Berakhir
    </template>
    <template v-else-if="props.column.field == 'lotEmitted'">
        Jumlah Lot<hr>
        Harga Per Lot
    </template>
    <template v-else-if="props.column.field == 'unitPerLot'">
        Unit Per Lot<hr>
        Minimum Lot
    </template>
    <template v-else-if="props.column.field == 'dividendPeriod'">
        Periode Dividen<hr>
        Satuan Periode
    </template>