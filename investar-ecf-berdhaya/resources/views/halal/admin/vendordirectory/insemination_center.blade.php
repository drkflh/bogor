<div class="row" style="margin-top:30px;">
    <div class="col-7" style="border-right: thin solid #000000; ">
        <div class="row">
            <div class="col-12">
            <label style="color:#000;font-weight:bold;">Name</label>
                {!! $coyName !!}
            </div>
        </div>
            <label style="color:#000;font-weight:bold;">Contact Info</label>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                {!! $address !!}
                {!! $address2 !!}
            </div>
            <div class="col-3">
                {!! $city !!}
                {!! $country!!}
            </div>
            <div class="col-3">
                {!! $province!!}
                {!! $postalCode!!}
            </div>
        </div>
        <div style="color:#800000;">
            <label style="color:#000;font-weight:bold;">Contact Person</label>
            {!! $picContacts !!}
        </div>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <label style="color:#000;font-weight:bold;">Phone</label>
                {!! $offPhones!!}
            </div>
            <div class="col-md-6 col-xs-12">
                <label style="color:#000;font-weight:bold;">Fax</label>
                {!! $offFaxes !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <label style="color:#000;font-weight:bold;">Email</label>
                {!! $offEmails !!}
            </div>
            <div class="col-md-6 col-xs-12">
                <label style="color:#000;font-weight:bold;">Website</label>
                {!! $website !!}
            </div>
        </div>
    </div>
    <div class="col-5">
        <div class="row">
            <div class="container" style="margin-bottom:20px;">
                    <label style=" color:#000000;font-weight:bold;">Products</label>
                    {!! $products !!}
                    <label style=" color:#000000;font-weight:bold;">Services</label>
                    {!! $services !!}
                    <label style=" color:#000000;font-weight:bold;">Brands</label>
                    {!! $brands !!}
             </div>

        </div>
    </div>
</div>


