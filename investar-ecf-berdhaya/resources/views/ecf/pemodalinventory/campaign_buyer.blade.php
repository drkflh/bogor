<div class="container">
    <?php
    use App\Helpers\NumberUtil;
        $campaignId = request()->route('id');
        $campaign = \App\Models\Ecf\Campaign::where('_id', '=', $campaignId)->first();
        $inventoryItem = \App\Models\Ecf\InventoryItem::where('campaignId', '=', $campaignId)->get();
        $uniqInventoryItem = \App\Models\Ecf\InventoryItem::where('campaignId', '=', $campaignId)->groupBy('masterId')->get();
        $itemPrice = $campaign['pricePerLot'];
        $totalLotBuyed = \App\Models\Ecf\InventoryItem::where('campaignId', '=', $campaignId)->sum('stock');
        $totalPriceBuyed = $itemPrice * $totalLotBuyed;
        $soldLot = $campaign['totalLot'] - ($campaign['totalLot'] - $totalLotBuyed);
        if ($campaign['totalLot'] == null || $campaign['totalLot'] == 0) {
            $totalLot = 1;
        }else{
            $totalLot = $campaign['totalLot'];
        }
        
        $persen = 100 - (($totalLot - $totalLotBuyed)  / $totalLot / 0.01);
        // echo $persen;
        // $status = $invoice['status'];
        // if($status == "OPEN"){
        //     $paid = "UNPAID";
        //     $style = "text-dark";
        // }else{
        //     $paid = strtoupper($status);
        //     if($paid== "PAID"){
        //         $style = "text-success";
        //     }else{
        //         $style = "text-danger";
        //     }
        // }

    ?>

            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-inner">
                        <div class="invoice-info" id="invoice_wrapper">
                            <div>
                                <div class="row">
                                    <div class="col">
                                        <div class="col">
                                            <div class="text">
                                            <h5><strong>Campaign :</strong> {{ $campaign->campaignTitle ?? '--'}}</h5>  
                                                @if($campaign->campaignPeriod != null)  
                                                    <h5><strong>Start :</strong> {{ date("d-m-Y",strtotime($campaign->campaignStart ?? $campaign->campaignPeriod[0]))}}</h5> 
                                                    <h5><strong>End :</strong> {{ date("d-m-Y",strtotime($campaign->campaignEnd ?? $campaign->campaignPeriod[1]))}}</h5>
                                                @endif  
                                                <h5><strong> {{$soldLot}}/{{$campaign['totalLot']}}({{$persen}}%):</strong>
                                                <br>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: <?php echo $persen ?>%" aria-valuenow="<?php echo $persen ?>" aria-valuemin="0" aria-valuemax="<?php echo $campaign['totalLot'] ?>"></div>
                                                    </div>
                                                </h5>                                             
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col text-end">
                                        <h5><strong>Lot Price :</strong>Rp. {{ NumberUtil::currency($campaign->pricePerLot) ?? '--'}}</h5>    
                                        <h5><strong>Funding Total :</strong>Rp. {{ NumberUtil::currency($totalPriceBuyed) ?? '--'}}</h5> 
                                        <h5><strong>Required Funding :</strong>Rp. {{ NumberUtil::currency($campaign->requiredFunding) ?? '--'}}</h5>    
                                        
                                        <a href="{{ url('/ecf/buyer') }}" class="btn btn-warning text-white mb-20 w-50"><i class="fi-rs-arrow-left mr-10"></i>Back</a>
                                    
                                        </div> 
                                    </div>
                                </div>
                            </div>
                             
                            <div class="invoice-center">
                                <div class="table-responsive"><br><br>
                                <table class="table table-hover mb-0 table-striped">
                                <tbody>
                                    <tr class="bg-white text-dark">
                                        <td class="col-md-2"><h6>Nama Pemodal</h6></td> 
                                        <td class="col-md-1"><h6>Qty</h6></td>
                                        <td class="col-md-4"><h5>Total</h5></td>
                                        
                                       
                                    </tr>
                                @foreach ($uniqInventoryItem as $invIt) 
                                    <?php
                                        $buyerId = $invIt['masterId'];
                                        $buyer = \App\Models\Core\Mongo\User::where('_id', '=', $buyerId)->first();
                                        $buyerItem = \App\Models\Ecf\InventoryItem::where('masterId', '=', $buyerId)->first();
                                        $buyerStock = \App\Models\Ecf\InventoryItem::where('masterId', '=', $buyerId)->where('campaignId', '=', $campaignId)->sum('stock');
                                        $orderST = $itemPrice * $buyerStock;
                                        $orderSTC = \App\Helpers\NumberUtil::currency($orderST);
                                        
                                    ?>
                                        <tr>
                                            <td class="col-md-2"><h6>{{ $buyer->name ?? '-'}}</h6></td> 
                                            <td class="col-md-1"><h6>x {{ $buyerStock}}</h6></td>
                                            <td class="col-md-4"><h5 >Rp. {{$orderSTC}}</h5></td>
                                            
                                        
                                        </tr>
                        
                                @endforeach
                                
                                </tbody>
                                </table><br>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

