
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
        {!! $cartSession ?? '' !!} 
        {!! $buyer ?? '' !!}      
            <div class="row">
                <div class="col-6">
                   {!! $fname ?? '' !!}
                </div>
                <div class="col-6">
                   {!! $lname ?? '' !!}
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                   {!! $email ?? '' !!}
                </div>
                <div class="col-6">
                   {!! $mobile ?? '' !!}
                </div>
            </div> 
            <div class="row">
                <div class="col-6">
                    {!! $billing_address ?? '' !!}
                </div>
                <div class="col-6">
                   {!! $billing_address2 ?? '' !!}
                </div>
            </div>
            <div class="row">    
                <div class="col-3">
                    {!! $delivery_option ?? '' !!}
                </div>
                <div class="col-6">
                   {!! $payment_option ?? '' !!}
                </div>
                <div class="col-3">
                   {!! $shippingCost ?? '' !!}
                </div>
            </div> 
            <div class="row">    
                <div class="col-3">
                    {!! $zipcode ?? '' !!}
                </div>
                <div class="col-9">
                   {!! $city ?? '' !!}
                </div>
            </div>
            
            {!! $add_info ?? '' !!}   
            <div class="row">
                <div class="col-8">
                    {!! $invCode ?? '' !!}
                </div>
                <div class="col-4">
                   {!! $status ?? '' !!}
                </div>
            </div>     
        </div>
    </div>   
</div>