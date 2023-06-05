<div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-inner">
                        <div class="invoice-info" id="invoice_wrapper">
                            <div class="invoice-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="logo d-flex align-items-center">
                                            <div class="text">
                                                <h3><strong class="text-brand">Thank you for your order</strong> <br />
                                                Please check notification about this order
                                                </h3>
                                                <!-- <p class="font-sm">
                                                    <strong>Issue date:</strong> @{{ total }}<br />
                                                    <strong>Invoice To:</strong> @{{ buyerName }}<br />@{{ address }} <br>@{{ city }}
                                                    <strong>Payment Method:</strong> @{{ payment }}
                                                </p> -->

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <h2>INVOICE</h2>
                                        <h5>ID Number: <a href="{{ url('invoice/view/')}}<?php "test"?>"><span class="text-brand">@{{ invNumber }}</span></a></h5>
                                    </div>
                                </div>
                            </div>
 
                            <!-- <div class="invoice-bottom pb-80">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ url('home') }}" class="btn mb-20 w-25">Back to Shop<i class="fi-rs-sign-out ml-15"></i></a>

                                    </div>
                                    <div class="col-md-6 text-end">
                                        <h6 class="mb-15">Sub Total</h6>
                                        <h3 class="mt-0 mb-0 text-brand">@{{ subTotal }}</h3>
                                        <h6 class="mb-15">Shipping Cost</h6>
                                        <h3 class="mt-0 mb-0 text-brand">@{{ shippingCost }}</h3>
                                        <h6 class="mb-15">Total Amount</h6>
                                        <h3 class="mt-0 mb-0 text-brand">@{{ total }}</h3> -->
                                        <!-- <p class="mb-0 text-muted">Taxes Included</p> -->

                                    <!-- </div>
                                </div>

                            </div> -->
                        </div>
                    </div>
                </div>
