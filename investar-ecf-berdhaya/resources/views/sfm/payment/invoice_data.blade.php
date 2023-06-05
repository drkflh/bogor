<div class="container">
    <?php
        $invCode = request()->route('id');
        $invoice = \App\Models\Sfm\Invoice::where('invCode', '=', $invCode)->first();
        
        $totalCurrency = \App\Helpers\NumberUtil::currency($invoice['total']);
        $status = $invoice['status'];
        if($status == "Open"){
            $paid = "UNPAID";
            $style = "text-dark";
        }else{
            $paid = strtoupper($status);
            if($paid== "PAID"){
                $style = "text-success";
            }else{
                $style = "text-danger";
            }
        }
        $subtotalCurrency = \App\Helpers\NumberUtil::currency($invoice['subTotal']);
        $shippingCostCurrency = \App\Helpers\NumberUtil::currency($invoice['shippingCost']);

        $cartSession = $invoice->cartSession;
        $salesOrder = \App\Models\Sfm\SalesOrder::where('cartSession', '=', $cartSession)->get();

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
                                            <h5><strong>Delivery to:</strong></h5>    
                                            <h4 class="text-brand">{{ $invoice->fname ?? '--'}} {{ $invoice->lname ?? '--'}}</h4>
                                             
                                             <h5>{{ $invoice->billing_address ?? ''}} {{ $invoice->billing_address2 ?? ''}} 
                                                <br>{{ $invoice->city ?? ''}} {{ $invoice->zipcode ?? ''}} </h5>  
                                            <h5><strong>Mobile :</strong> {{ $invoice->mobile ?? '-'}}</h5> 
                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col text-end">
                                        <h2>INVOICE</h2>
                                        <h4>ID: <span class="text-brand <?php $style;?>"> {{ $invoice->invCode ?? '-'}} ( {{ $paid}})</span></h4>
                                        <h5><strong>Payment Method:</strong> {{ $invoice->payment_option ?? '-'}}</h5>
                                        <h5><strong>Shipping by:</strong> {{ $invoice->delivery_option ?? '-'}}</h5>                                    
                                    </div>
                                </div>
                            </div>
                             
                            <div class="invoice-center">
                                <div class="table-responsive"><br><br>
                                <table class="table table-hover mb-0 table-striped">
                                <tbody>
                                    @foreach ($salesOrder as $sales)
                                    <?php
                                        $priceCurrency = \App\Helpers\NumberUtil::currency($sales['orderPrice']);
                                        $orderSubTotalCurrency = \App\Helpers\NumberUtil::currency($sales['orderSubTotal']);
                                    ?>
                                    <tr>
                                        <td class="col-md-4"><h5 >{{ $sales->productName ?? '-'}}</h5></td>
                                        <td class="col-md-2"><h6>Rp. {{ $priceCurrency ?? '-'}}</h6></td>
                                        <td class="col-md-1"><h6>x {{ $sales->orderQty ?? '-'}}</h6></td>
                                        <td class="col-md-2"><h5 class="text-brand">Rp. {{ $orderSubTotalCurrency ?? '-'}}</h5></td>
                                    </tr>

                                    @endforeach
                                </tbody>
                                </table><br>
                                </div>

                            </div>
                            <div class="invoice-bottom pb-80">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ url('home') }}" class="btn mb-20 w-50"><i class="fi-rs-arrow-left mr-10"></i>Back to Shop</a>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="row">
                                            <div class="col text-end">  
                                            <h5><strong>Sub Total:</strong> Rp. {{ $subtotalCurrency ?? '-'}}</h5>  
                                            <h5><strong>Shipping Cost:</strong> Rp. {{ $shippingCostCurrency ?? '-'}}</h5>  
                                            <h3><strong>Total:</strong> <span class="text-brand">Rp. {{ $totalCurrency ?? '-'}}</span></h3>  
                                        </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

