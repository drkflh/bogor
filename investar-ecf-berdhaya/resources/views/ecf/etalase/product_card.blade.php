<?php
use App\Helpers\NumberUtil;
?>

<div class="card-body shadow-sm bg-white mx-1">
    <a :href="'etalase/detail/' +  item._id "><img class="card-img-top" :src="_.first(item.picture ?? ' ')" style="width: 100%;
                        height: 17vw;
                        object-fit: cover"
        onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/blank.png' ) ) }}';"
    ></a>
    <div class="row">
        <div class="col-12">
            <h5 class="text-truncate card-text" colspan="2">@{{ item.bizRegisteredName }}</h5>
            <a :href="'etalase/detail/' +  item._id "><h5 class="text-truncate card-title">@{{ item.campaignTitle }}</h5></a>
            <p class="card-title">Tersisa: @{{ item.lotEmitted }}/@{{ item.totalLot ?? 0}}(@{{formatCurrency(100 - (item.lotEmitted / item.totalLot / 0.01))}}%)</p>
            <p class="card-title">Harga LOT : Rp.@{{ formatCurrency(item.pricePerLot) }}</p>

        </div>
    </div>
    <div class="row">
        <div class="col-6">
                <div class="col">
                    <!-- <a :href="'etalase/detail/' +  item._id "><button class="btn btn-warning text-white">View </button></a> -->
                </div>
                <p class="card-text"><small>@{{ formatDate(item.campaignPeriod[0] ?? item.campaignStart ?? 0) }} - @{{ formatDate(item.campaignPeriod[1] ?? item.campaignEnd ?? 0)}}</small></p>
        </div>
        <div class="col-6">
                <div class="col">
                    @if (Auth::User()->approvalStatus == 'VERIFIED' && Auth::User()->roleSlug == 'pemodal')
                        <button class="btn btn-success text-white" v-if="item.lotEmitted > 0" @click="addToCart(item)" >Add </button>
                        <button class="btn btn-danger text-white disabled" v-if="item.lotEmitted <= 0" >Stock Habis </button>
                    @endif
                    <!-- <a :href="'etalase/detail/' +  item._id "><button class="btn btn-warning text-white">View </button></a> -->
                </div>
        </div>
    </div>
</div>
{{--
{
"_id": "633ee7bc665b157c1a13e835",
"id": "1",
"id_generate": "20150825100628",
"product_no_master": "1",
"product_id_master": "A101",
"product_name_master": "WIKA SWH SR130E1",
"product_id": "A201",
"kd_sumber_daya": "",
"product_name": "TANGKI SWH ST130ER",
"product_name_old": null,
"status": null,
"qty": "1",
"price": "0",
"unit": "",
"deskripsi": "",
"garansi": null,
"tgl_input": "2015-08-25",
"wkt_input": "10:14:41",
"last_update": "2015-08-25 10:14:41",
"user_input": "31",
"updated_at": "2022-10-06 14:35:40",
"created_at": "2022-10-06 14:35:40"
}
--}}
