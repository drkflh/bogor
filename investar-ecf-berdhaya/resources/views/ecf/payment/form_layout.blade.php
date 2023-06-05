<?php
use App\Models\Ecf\ShoppingCart;
$cartSession = Auth::user()->cartSession;
$shoppingCart = ShoppingCart::where('cartSession', '=', $cartSession)->get();

?>
<form method="POST" action="{{ url('proceed') }}">
    @csrf
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="invoice-inner">
                    <div class="invoice-info" id="invoice_wrapper">
                        <div>
                            <div class="row">
                                <div class="col">
                                    <div class="col">
                                        <div class="text">
                                            <h5><strong>Investor:</strong> @{{ buyer ?? '--' }}</h5>
                                            <h5><strong>Mobile :</strong> @{{ mobile ?? '-' }}</h5>
                                            <h5><strong>Email :</strong> @{{ email ?? '-' }}</h5>

                                        </div>
                                    </div>
                                </div>
                                <div class="col text-end">
                                    <h2>Payment Confirmation</h2>
                                    <h4>TRX ID: <span class="text-brand"> @{{ orderID ?? '-' }}</span></h4>
                                    <h6>Order Date: <span class="text-brand"> @{{ orderDate ?? '-' }}</span></h6>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">

                            </div>
                        </div>
                        <!-- <div class="invoice-banner"> -->
                        <!-- <img src="assets/imgs/invoice/banner.png" alt=""> -->
                        <!-- </div> -->

                        <div class="invoice-center">
                            <div class="table-responsive"><br><br>
                                <table class="table table-hover mb-0 table-striped">
                                    <tbody>
                                        @foreach ($shoppingCart as $shopping)
                                            <?php
                                            $priceCurrency = \App\Helpers\NumberUtil::currency($shopping['orderPrice']);
                                            $orderSubTotalCurrency = \App\Helpers\NumberUtil::currency($shopping['orderSubTotal']);
                                            ?>
                                            <tr>
                                                <td class="col-md-4">
                                                    <h5>{{ $shopping->campaignTitle ?? '-' }}</h5>
                                                </td>
                                                <td class="col-md-2">
                                                    <h6>Rp. {{ $priceCurrency ?? '-' }}</h6>
                                                </td>
                                                <td class="col-md-1">
                                                    <h6>x {{ $shopping->orderQty ?? '-' }}</h6>
                                                </td>
                                                <td class="col-md-2">
                                                    <h5 class="text-brand">Rp. {{ $orderSubTotalCurrency ?? '-' }}</h5>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table><br>
                            </div>

                        </div>
                        <div class="invoice-bottom pb-80">
                            <div class="row">
                                <div class="col-md-6">


                                    <!-- <h6 class="mb-15">Delivery Information</h6>
                                        <p class="font-sm">
                                            <strong>Name:</strong> 20 march, 2022<br />
                                            <strong>Address:</strong> NestMart Inc<br />
                                            <strong>Swift Code:</strong> BFTV VNVXS
                                        </p>  -->

                                    <a class="btn btn-info text-white mb-20" href="{{ url('ecf/etalase') }}"><i
                                            data-feather="arrow-left"></i>Continue Shopping</a>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="row">
                                        <div class="col">
                                            <input type="hidden" name="shippingCost" value="@{{ shippingCost ?? '0' }}">
                                            <h5 class="mb-15 text-end">Total Amount :</h5>
                                            <h5 class="mb-15 text-end">Rp. @{{ formatCurrency(total) ?? '--' }}</h5>
                                        </div>
                                        <div class="col">
                                            <div class="col-md-2">
                                            </div>
                                            <h4 class="mb-30 font-weight-bold">Select Payment</h4>
                                            <div class="payment_option ">
                                                <div class="">
                                                    <h5><input class="form-check-input" value="Bank Transfer"
                                                            type="radio" name="payment_option" id="exampleRadios3"
                                                            checked="">&nbsp;&nbsp;Direct Bank Transfer</h5>
                                                </div>
                                            </div>

                                            <div class="payment-logo d-flex">
                                                <!-- <img class="mr-15" src="" alt=""> -->
                                                <img class="mr-15"
                                                    src="http://dev.topang.id/themes/nest_frontend/assets/imgs/theme/icons/payment-visa.svg"
                                                    alt="">
                                                <img class="mr-15"
                                                    src="http://dev.topang.id/themes/nest_frontend/assets/imgs/theme/icons/payment-master.svg"
                                                    alt="">
                                                <!-- <img src="http://dev.topang.id/themes/nest_frontend/assets/imgs/theme/icons/payment-zapper.svg" alt=""> -->
                                            </div> <br><br>

                                            <!-- </div>
                                            <div class="col-md-8"> -->

                                            <button type="submit" href="{{ url('proceed') }}"
                                                class="btn btn-success text-light mb-20 w-75">Proceed<i
                                                    class="fi-rs-sign-out ml-15"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
