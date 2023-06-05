 
<div class="container mb-80 mt-50" >
            <div class="row">
                <div class="col-lg-8 mb-40">
                    <h1 class="heading-2 mb-10">Your Cart</h1>
                    <div class="d-flex justify-content-between" v-if="totalShopping > 0">
                        <h6 class="text-body">There are <span class="text-brand">@{{ totalShopping }}</span> products in your cart</h6>
                        <h6 class="text-body"><a href="{{ url('cart/clear') }}" class="text-muted"><i class="fi-rs-trash mr-5"></i>Clear Cart</a></h6>
                    </div>
                    <div v-if="totalShopping <= 0">   
                        <h4>Shopping cart empty</h4>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-8">
                    <div class="table-responsive shopping-summery" v-if="totalShopping > 0">
                    {!! $tableCart ?? '' !!}
                    </div>
                    <!-- <div class="divider-2 mb-30"></div> -->
                    <div class="cart-action d-flex justify-content-between">
                        <a class="btn " href="{{ url('home') }}"><i class="fi-rs-arrow-left mr-10"></i>Continue Shopping</a>
                        <!-- <a class="btn  mr-10 mb-sm-15" href="{{ url('home') }}"><i class="fi-rs-refresh mr-10"></i>Update Cart</a> -->
                    </div>
                    <div class="row mt-50">
                        <!-- <div class="col-lg-7"> -->
                            <!-- <div class="calculate-shiping p-40 border-radius-15 border"> -->
                                <!-- <h4 class="mb-10">Calculate Shipping</h4> -->
                                <!-- <p class="mb-30"><span class="font-lg text-muted">Flat rate:</span><strong class="text-brand">5%</strong></p> -->
                                <!-- <form class="field_form shipping_calculator"> -->
                                    <!-- <div class="form-row">
                                        <div class="form-group col-lg-12">
                                            <div class="custom_select">
                                                <select class="form-control select-active w-100">
                                                </select>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- <div class="form-row row">
                                        <div class="form-group col-lg-6">
                                            <input required="required" placeholder="State / Country" name="name" type="text">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input required="required" placeholder="PostCode / ZIP" name="name" type="text">
                                        </div>
                                    </div> -->
                                <!-- </form> -->
                            <!-- </div> -->
                        <!-- </div> -->
                        <!-- <div class="col-lg-5">
                            <div class="p-40">
                                <h4 class="mb-10">Apply Coupon</h4>
                                <p class="mb-30"><span class="font-lg text-muted">Using A Promo Code?</p>
                                <form action="#">
                                    <div class="d-flex justify-content-between">
                                        <input class="font-medium mr-15 coupon" name="Coupon" placeholder="Enter Your Coupon">
                                        <button class="btn"><i class="fi-rs-label mr-10"></i>Apply</button>
                                    </div>
                                </form>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="col-lg-4">
                <!-- <div> -->
                <div v-if="totalShopping > 0">
                <!-- <div class="border p-md-4 cart-totals ml-30"> -->
                        <!-- <div class="table-responsive"> -->
                        <div>
                            <table >
                                <tbody>
                                    <tr>
                                        <!-- <td >
                                            <h4 >Subtotal</h4>
                                        </td> -->
                                        <td colspan="2">
                                            <h5  >Subtotal : @{{ currency.currency }}. @{{ subTotal }}</h4>
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <td scope="col" colspan="2">
                                            <div class="divider-2 mt-10 mb-10"></div>
                                        </td>
                                    </tr> -->
                                    <tr>
                                        <!-- <td > -->
                                            <!-- <h4 >Weight</h4>
                                        </td> -->
                                        <td colspan="2" class="cart_total_amount">
                                        <!-- <td class="cart_total_amount"> -->
                                            <!-- <h5 class="text-heading text-end">@{{ weight }}</h4> -->
                                            <h5 >Weight : @{{ weight }} Gram</h4>
                                        </td> 
                                    </tr> 
                                        <!-- <tr>

                                        <td class="cart_total_amount">
                                            <h5 class="text-heading text-end">United Kingdom</h4</td> </tr> <tr>
                                        <td scope="col" colspan="2">
                                            <div class="divider-2 mt-10 mb-10"></div>
                                        </td>
                                    </tr> -->
                                    <!-- <tr> -->
                                        <!-- <td >
                                            <h4 >Total</h4>
                                        </td> -->
                                        <!-- <td colspan="2">
                                            <h5>Total : Rp.&nbsp;@{{ total }}</h4>
                                        </td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ url('check-out') }}" class="btn mb-20 w-100">Proceed To CheckOut<i class="fi-rs-sign-out ml-15"></i></a>
                    </div>
                </div>
            </div>
        </div>

 
