
<!-- <div class="card-body">
    <div>
        <img class="card-img-top" src="_.first( item.picture ?? '')" alt="Card image cap"
             onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/blank.png' ) ) }}';"
        >
    </div>
    <h5 class="card-title">@{{ item.campaignTitle }}</h5>
    <h5 class="card-title">@{{ item.bizRegisteredName }}</h5>
    <p class="card-text">Jumlah Order : @{{ item.orderQty }}</p>
    <p class="card-text">Jumlah LOT : @{{ item.lotEmitted }}</p>
    <p class="card-text">Harga LOT : @{{ formatCurrency(item.pricePerLot) }}</p>
    <p class="card-text"><small class="text-muted">Updated @{{ item.lastUpdate }}</small></p>
</div> -->
    <div class="row" style="margin-left:3px;">
        <div class="col-12" style="margin-bottom:5px; ">
            <div class="row pb-2">
                <div class="col-4">
                    <img class="card-img-top" :src="_.first( item.picture ?? ' ')" alt="Card image cap"
                    onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/blank.png' ) ) }}';"
                    >
                </div>
                <div class="col-8">
                    <h5 class="card-title">@{{ item.campaignTitle }}</h5>
                    <p class="card-text">Jumlah Order : @{{ item.buyQty ?? item.stock}}</p>
                    <p class="card-text">Harga Per Lot: Rp. @{{ formatCurrency(item.price) }}</p>
                    <p class="card-title">Total : Rp. @{{ formatCurrency(item.orderSubTotal ?? item.stock*item.price) }}</p>
                    <h5 class="card-title">@{{ item.status }}</h5>
                    <div class="card-title"><small class="text-muted">Buy on @{{ item.created_at}}</small></div>
                </div>
            </div>
            
            
        </div>
    </div>
    <div class="form-row" style="border-bottom: thin solid #000000;">
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
