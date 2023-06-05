<div class="row" style="margin-top:30px;">
    <div class="col-7" style="border-right: thin solid #000000; ">
        <div class="row">
            <div class="col-2">
            <label style="color:#000;font-weight:bold;">Cust. Class</label>
                {!! $customerClass !!}
            </div>
            <div class="col-2">
                <label style="color:#000;font-weight:bold;">Co. Type</label>
                {!! $companyType !!}
            </div>
            <div class="col-4">
            <label style="color:#000;font-weight:bold;">Customer Name</label>
                {!! $customerName !!}
            </div>
            <div class="col-1">
                    <label style="color:#000;font-weight:bold;">&nbsp;Create </label>
                    <button class="btn btn-default" @click="getSequence()">
                        <i class="fa fa-plus-square"></i>
                    </button>
            </div>
            <div class="col-3">
            <label style="color:#000;font-weight:bold;">Customer Code</label>
                {!! $customerCode !!}
            </div>
        </div>
            <label style="color:#000;font-weight:bold;">Contact Info</label>
        <div class="row">
            <div class="col-6">
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
        <div class="row">
            <div class="col-4">
            <label style="color:#000;font-weight:bold;">Phone</label>
                {!! $offPhones!!}
            </div>
            <div class="col-4">
            <label style="color:#000;font-weight:bold;">Email</label>
                {!! $offEmails !!}
            </div>
            <div class="col-4">
            <label style="color:#000;font-weight:bold;">Fax</label>
                {!! $offFaxes !!}
            </div>
        </div>
        <div class="row">
            <div class="col-4">{!! $website !!}</div>
            <div class="col-4"></div>
            <div class="col-4"></div>
        </div>
        <div style="color:#800000;">
        <label style="color:#000;font-weight:bold;">Contact Person</label>
            {!! $picContacts !!}
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
                    <div class="container">

                        <div class="row">
                            <label style="margin-top:20px;color:#000000;margin-right:10px;font-weight:bold;">Upload : </label>
                            <div class="col-5" style="bottom:3px;right:8px;height:20px;width:10px;">
                               <a href="#">{!! $companyProfileUrl !!}</a>
                            </div>
                            <div class="col-5" style="bottom:3px;right:90px;height:20px;width:10px;" >
                                 <a href="#">{!! $mediaUrlCatalog !!}</a>
                            </div>
                        </div>
                    </div>

             </div>

            <div class="container">
                <b style="color:#800000;">Filled by Finance Department Only:</b>
                <div  class="row">
                    <div  class="col-5" >
                            <label style="color:#000;font-weight:bold;">Customer Tax ID</label>
                                {!! $customerTaxId !!}
                            <label style="color:#000000;font-weight:bold;"> Tax Collector (WAPU)
                                {!! $taxCollector !!}
                            </label>
                    </div>
                    <div style="color:#000000;" class="col-5">
                        <label style="color:#000;font-weight:bold;">No. PKP</label>
                        {!! $pkpNo !!}
                        <label style="color:#000000;margin-right:10px;font-weight:bold;">Upload : </label>
                        <a href="#">{!! $taxIdNpwp !!}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

