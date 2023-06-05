<?php
use App\Models\Ecf\ShoppingCart;
$cartSession = Auth::user()->cartSession;
$shoppingCart = ShoppingCart::where('cartSession', '=', $cartSession)->get();

?>

<form method="POST" action="{{ url('payment') }}">
@csrf    
<div class="container mb-80 mt-50">
            <div class="row">
                <div class="col-lg-8 mb-40">
                    <h1 class="heading-2 mb-10">Checkout</h1>
                    <div class="d-flex justify-content-between">
                        <h6 class="text-body">There are <span class="text-brand">@{{ totalShopping }}</span> products in your cart</h6>
                    </div>
                </div>
            </div>
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
                                        <td class="col-md-4"><h5 >{{ $shopping->campaignTitle ?? '-' }}</h5></td>
                                        <td class="col-md-2"><h6>Rp. {{ $priceCurrency ?? '-'}}</h6></td>
                                        <td class="col-md-1"><h6>x {{ $shopping->orderQty ?? '-' }}</h6></td>
                                        <td class="col-md-2"><h5 class="text-brand">Rp. {{ $orderSubTotalCurrency ?? '-'}}</h5></td>
                                    </tr>

                                  @endforeach 
                                </tbody>
                                </table><br>
                                </div>

                            </div>
            <div class="row">
                <div class="col-lg-7">
                    <!-- <div class="row mb-50"> -->
                         
                        <!-- <div class="col-lg-6 mb-sm-15 mb-lg-0 mb-md-3">
                            <div class="toggle_info">
                                <span><i class="fi-rs-user mr-10"></i><span class="text-muted font-lg">Already have an account?</span> <a href="#loginform" data-bs-toggle="collapse" class="collapsed font-lg" aria-expanded="false">Click here to login</a></span>
                            </div>
                            <div class="panel-collapse collapse login_form" id="loginform">
                                <div class="panel-body">
                                    <p class="mb-30 font-sm">If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing &amp; Shipping section.</p> -->
                                    <!-- <form method="post">
                                        <div class="form-group">
                                            <input type="text" name="email" placeholder="Username Or Email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" placeholder="Password">
                                        </div>
                                        <div class="login_footer form-group">
                                            <div class="chek-form">
                                                <div class="custome-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="checkbox" id="remember" value="">
                                                    <label class="form-check-label" for="remember"><span>Remember me</span></label>
                                                </div>
                                            </div>
                                            <a href="#">Forgot password?</a>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-md" name="login">Log in</button>
                                        </div>
                                    </form> -->
                                <!-- </div>
                            </div>
                        </div> -->
                        <!-- <div class="col-lg-6">
                            <form method="post" class="apply-coupon">
                                <input type="text" placeholder="Enter Coupon Code...">
                                <button class="btn  btn-md" name="login">Apply Coupon</button>
                            </form>
                        </div> -->
                    <!-- </div> -->
                    <!-- <div class="row">
                        <h4 class="mb-30">Billing Details</h4>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="text" required="" name="fname" placeholder="First name *">
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="text" required="" name="lname" placeholder="Last name *">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="text" name="billing_address" required="" placeholder="Address *">
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="text" name="billing_address2"  placeholder="Address line2">
                                </div>
                            </div>
                           
                            <div class="row shipping_calculator"> -->
                                <!-- <div class="form-group col-lg-6">
                                    <div class="custom_select">
                                        <select class="form-control select-active">
                                            <option value="">Select an option...</option>
                                            <option value="ZW">Zimbabwe</option>
                                        </select>
                                    </div>
                                </div> -->
                                <!-- <div class="form-group col-lg-6">
                                    <input required=""  type="text" name="city" placeholder="City / Town *">
                                </div>
                                <div class="form-group col-lg-6">
                                    <input required=""  type="text" name="zipcode" placeholder="Postcode / ZIP *">
                                </div>
                            </div>
                            <div class="row">
 
                                <div class="form-group col-lg-6">
                                    <input   type="text" name="mobile" placeholder="Mobile *">
                                </div>
                                <div class="form-group col-lg-6">
                                    <input   type="text" name="email" placeholder="Email address *">
                                </div>
                            </div>

                            <div class="form-group mb-30">
                                <textarea rows="5" placeholder="Additional information" name="add_info"></textarea>
                            </div>                             -->
                            <!-- <div class="order_table checkout"> -->
                                <!-- <div class="form-group col-lg-6">
                                    <input required="" type="text" name="cname" placeholder="Company Name">
                                </div> -->
                                <!-- <div class="form-group col-lg-6">
                                    <input required="" type="text" name="email" placeholder="Email address *">
                                </div>-->
                            <!-- </div> -->

                            <!-- <div class="form-group">
                                <div class="checkbox">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="createaccount">
                                        <label class="form-check-label label_info" data-bs-toggle="collapse" href="#collapsePassword" data-target="#collapsePassword" aria-controls="collapsePassword" for="createaccount"><span>Create an account?</span></label>
                                    </div>
                                </div>
                            </div> -->
                            <!-- <div id="collapsePassword" class="form-group create-account collapse in">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <input required="" type="password" placeholder="Password" name="password">
                                    </div>
                                </div>
                            </div> -->
                            <!-- <div class="ship_detail"> -->
                                <!-- <div class="form-group">
                                    <div class="chek-form">
                                        <div class="custome-checkbox">
                                            <input class="form-check-input" type="checkbox" name="checkbox" id="differentaddress">
                                            <label class="form-check-label label_info" data-bs-toggle="collapse" data-target="#collapseAddress" href="#collapseAddress" aria-controls="collapseAddress" for="differentaddress"><span>Ship to a different address?</span></label>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- <div id="collapseAddress" class="different_address collapse in"> -->
                                    <!-- <div class="row">
                                        <div class="form-group col-lg-6">
                                            <input type="text" required="" name="fname" placeholder="First name *">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input type="text" required="" name="lname" placeholder="Last name *">
                                        </div>
                                    </div> -->
                                    <!-- <div class="row shipping_calculator">
                                        <div class="form-group col-lg-6">
                                            <input required="" type="text" name="cname" placeholder="Company Name">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <div class="custom_select w-100">
                                            select-active -->
                                                <!-- <select class="form-control ">
                                                    <option value="">Select an option...</option>

                                                    <option value="ZW">Zimbabwe</option>
                                                </select>
                                            </div>
                                        </div> -->
                                    <!-- </div>  -->
                                    <!-- <div class="row">
                                        <div class="form-group col-lg-6">
                                            <input type="text" name="billing_address" required="" placeholder="Address *">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input type="text" name="billing_address2" required="" placeholder="Address line2">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <input required="" type="text" name="state" placeholder="State / County *">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input required="" type="text" name="city" placeholder="City / Town *">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <input required="" type="text" name="zipcode" placeholder="Postcode / ZIP *">
                                        </div>
                                    </div> -->
                                <!-- </div> -->
                            <!-- </div> -->
                        <!-- </form> -->
                    <!-- </div> -->
                </div>
                <div class="col-lg-5">
                    <!-- <div class="border p-40 cart-totals ml-30 mb-50"> -->
                        <!-- <div class="d-flex align-items-end justify-content-between mb-30"> -->
                            <!-- <h4>Your Order</h4> -->
                            <!-- <h6 class="text-muted">Subtotal</h6> -->
                        <!-- </div> -->
                        <!-- <div class="divider-2 mb-30"></div> -->
                        <!-- <div class="table-responsive order_table checkout"> -->
                            <!-- @{{ tableCart }} -->
                            <!-- <h4>Sub Total :  <span class="text-brand">RP. @{{ formatCurrency(subTotal) }}</span></h4>        -->
                        <!-- </div> -->
                    <!-- </div> -->
                    <div class="payment ml-30">
                        <!-- <h4 class="mb-30 font-weight-bold">Delivery Method</h4>                                                                             
                                <div class="payment_option">
                                    <div class="">
                                    <h5><input class="form-check-input" value="topangDelivery"  type="radio" name="delivery_option" id="exampleRadios3" checked="">&nbsp;&nbsp;Topang Delivery</h5>
                                    </div>
                                    <div><h5><input class="form-check-input" value="selfPickup"  type="radio" name="delivery_option" id="exampleRadios4" checked="">&nbsp;&nbsp;Self Pickup</h5>
                                    </div>
                                    <div><h5><input class="form-check-input" value="courier"  type="radio" name="delivery_option" id="exampleRadios5" checked="">&nbsp;&nbsp;Other Courier</h5>
                                    </div>
                                </div> -->
                                <!-- <a class="btn " href="{{ url('home') }}"><i class="fi-rs-arrow-left mr-10"></i>Continue Shopping</a> -->
                                <h4>Sub Total :  <span class="text-brand">RP. @{{ formatCurrency(subTotal) }}</span></h4>               
                        <button  type="submit" class="btn btn-primary text-light btn-fill-out btn-block mt-30">Place an Order<i class="fi-rs-sign-out ml-15"></i></button>
                    </div>
                </div>
            </div>
</form>
