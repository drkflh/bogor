<div class="form-row" style="border-bottom: thin solid #000000;">
</div>
<div class="form-row" >
    <div style="height:100px;width:225px; margin-left:10px;padding-right:20px;">
    <label style="color:#000000;font-weight:bold;">Purchase Request No</label>
    {!! $prNo !!}
   </div>
   <div  style="padding-left:20px;padding-right: 15px;width: 180px;border-left: thin solid #000000;" >
    <label style="color:#000000;font-weight:bold;">Purchase Order Date</label>
       {!! $purchaseOrderDate !!}
   </div>
   <div style="width: 220px;padding-right:15px;" >
       <label style="color:#000000;font-weight:bold;">Company</label>
       {!! $companyName !!}
   </div>
   <div style="width: 110px;padding-right:15px;" >
   <label style="color:#000000;font-weight:bold;">Job Number</label>
       {!! $jobNo !!}
   </div>
   <div style="width: 100px;padding-right:15px;" >
   <label style="color:#000000;font-weight:bold;">Cost Center</label>
       {!! $costCenter !!}
   </div>
   <div style="color:#000000;width: 85px;padding-right:15px;">
   <label style="color:#000000;font-weight:bold;">Currency</label>
       {!! $currency !!}
   </div>
   <div style="width: 200px;">
   <label style="color:#000000;font-weight:bold;">Purchase Order No</label>
        {!! $orderNo !!}
   </div>
   <div style="width: 30px;margin-left:5px;margin-right:20px;">
        <label style="color:#000000;font-weight:bold;">Rev.</label>
        {!! $rev !!}
   </div>
</div>
<div class="form-row" style="height:5px; border-bottom: thin solid #000000;border-top: thin solid #000000;">
</div>

{{-- end header --}}

{{-- body --}}
<div class="row" style="border-bottom:thin solid black;">
    <div class="col-4">
        <h5 style="color:#000000; font-size: 17px;"><b>Order To: </b></h5>
   <div class="row" >
       <div  class="col-4">
           <div>
               {!! $vendorCode !!}
           </div>
       </div>
       <div class="col-8">
           {!! $vendorName !!}
       </div>
   </div>
   <div class="row ">
       <div class="col-12">
           {!! $vendorAddress !!}
       </div>
   </div>
   <div class="row">
       <div class="col-12">
           {!! $vendorAddress2 !!}
       </div>
   </div>
   <div class="row">
       <div class="col-6">
           {!! $vendorCity!!}
       </div>
       <div class="col-6">
           {!! $vendorProvince!!}
       </div>
   </div>
   <div class="row">
       <div class="col-6">
           {!! $vendorCountry!!}
       </div>
       <div class="col-6">
           {!! $vendorPostal!!}
       </div>
   </div>
   <div class="row">
       <div class="col-4">
            {!! $vendorPic !!}
       </div>
       <div class="col-4">
            {!! $vendorPhone!!}
       </div>
       <div class="col-4">
           {!! $vendorEmail!!}
      </div>
   </div>
    </div>
    <div class="col-4" style="border-right: thin solid #000000;border-left: thin solid #000000;">
        <h5 style="color:#000000; font-size:17px;"><b>Deliver To:</b></h5>
        <div class="row">
            <div  class="col-12">
            {!! $shippingInstansi !!}
                </div>
            <div  class="col-12">
            {!! $shippingAddress !!}
            </div>
        </div>
        <div class="row">
            <div  class="col-12">
            {!! $shippingAddress2 !!}
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                {!! $shippingCity!!}
            </div>
            <div class="col-6">
                {!! $shippingProvince!!}
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                {!! $shippingCountry!!}
            </div>
            <div class="col-6">
                {!! $shippingPostalCode!!}
            </div>
        </div>
         <div class="row" style="margin-bottom: 20px;">
            <div  class="col-4">
                {!! $contactPerson !!}
            </div>
            <div  class="col-4">
                {!! $contactNo!!}
            </div>
            <div  class="col-4">
                {!! $contactEmail!!}
            </div>
        </div>
    </div>
    <div class="col-4">
        <h5 style="color:#000000; font-size:17px;margin-bottom: 24px;"><b>Reference :</b></h5>
        <div  class="row" style="margin-top: 33px;">
            <div  class="col-5" >
                <label style="color:#000000;font-weight:bold">Vendor Quotation</label>
                {!! $referenceNo!!}
            </div>
                <div style="color:#000000;padding-top:3px;" class="col-5">
                <label style="color:#000000;font-weight:bold">Quotation Date</label>
                {!! $referenceDate!!}
            </div>
        </div>
           <div class="row" style="margin-top: 13px">
               <div  class="col-10">
                   <label style="color:#000000;font-weight:bold">Inco Term</label>
                   {!! $incoTerm!!}
               </div>
           </div>
           <div class="row">
            <div class="col-10">
                <label style="color:#000000;font-weight:bold">Shipment Mode</label>
                {!! $modaShipment!!}
            </div>
           </div>
    </div>
    <div class="form-row" style="height:1px; border-top: thin solid #000000;">
    </div>
</div>
<div class="row" style="border-bottom:thin solid black;">
    <div class="col-4" style=" background-color:#fff199;">
        <div class="form-row" >

        </div>
    </div>
    <div class="col-4" style="border-right: thin solid #000000;border-left: thin solid #000000; ">
        <div class="row" >
            <div class="col-8" style="margin-top: 10px;">
                <label style="color:#000000;font-weight:bold;">Discount:</label>
                <div class="row">
                    <div class="col-6">
                        <div class="row" id="discount">
                            <div>

                                <b-form-checkbox switch v-model="discountSwitch" id="discountSwitch" name="discountSwitch" style="margin-top: 0px;"></b-form-checkbox>
                            </div>
                            <div style="margin-right: 25px;">
                                <label for="" style="font-size: 14px;color:#000000;">Percentage</label>
                            </div>
                            <div class="col-6" style="margin-left:115px;margin-top:-50px;">
                                {!! $discountPercentage !!}
                            </div>
                            <div style="margin-left:180px;margin-top:-22px;color:#000000;font-weight:bold">%</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div>
                                <b-form-checkbox switch v-model="discountLumpSumSwitch" id="discountLumpSumSwitch" name="discountLumpSumSwitch" style="margin-top: 0px;"></b-form-checkbox>
                            </div>
                            <div style="margin-right: 25px;">
                                <label for="" style="font-size: 14px;color:#000000;">Lump Sum</label>
                            </div>
                            <div class="col-12" style="margin-left:115px;margin-top:-45px;height:1px;">
                                {!! $discountLumpSum !!}
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div  class="col-4" style="margin-top:10px;" >
                <label style="color:#000000;font-weight:bold">VAT:</label>
                <div class="row" style="font-weight: bold">
                    <div class="col-8" style="margin-top: 15px;">{!! $vat !!}</div>
                    <div style="margin-top: 40px;color:#000000;font-weight:bold">%</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div  class="row">
            <div  class="col-5" style="margin-top:20px;margin-bottom:20px;" >
                <label style="color:#000000;font-weight:bold">Authorized By</label>
                {!! $authorizedBy!!}
            </div>
            <div class="col-5" style="margin-top:20px;margin-bottom:20px;" >
                <label style="color:#000000;font-weight:bold">Date</label>
                {!! $authorizationDate!!}
            </div>
        </div>
    </div>
 </div>

{{-- tab details --}}
<b-tabs content-class="mt-3 tabHeader mb-4" nav-class="tab-header" fill justified >
    <b-tab title="Detail" active>
        <div class="row">
            {!! $details !!}
        </div>
        <div class="row" style="float:right;">
            <div style="margin-top:-10px;margin-right:50px;margin-bottom:10px;">
                <div>
                    <div class="row">
                        <div class="col-6">
                            <label style="color:#000000;font-weight:bold;">Total</label>
                        </div>
                        <div class="col-6">
                           {!! $total !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label style="color:#000000;font-weight:bold;">Discount</label>
                        </div>
                        <div class="col-6">
                                {!! $totalDisc !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label style="color:#000000;font-weight:bold;">VAT</label>
                        </div>
                        <div class="col-6">
                            {!! $totalVat !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label style="color:#000000;font-weight:bold;">Grand Total</label>
                        </div>
                        <div class="col-6">
                            {!! $grandTotal !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </b-tab>

    <b-tab title="General Terms">
        <div class="row" style="margin-left: 120px; align-items: center;">
            {!! $generalTerms !!}
        </div>
    </b-tab>

    <b-tab title="Shipping Instruction" >
        <div class="row" style="margin-left: 120px; align-items: center;">
            {!! $shippingInst !!}
        </div>
    </b-tab>

    <b-tab title="Payment Terms" >
        <div class="row" style="margin-left: 120px; align-items: center;">
            {!! $termOfPayment !!}
        </div>
    </b-tab>

    <b-tab title="Documentation">
        <div class="row">
            <div class="col-12">
                {!! $addDocument !!}
            </div>
        </div>
    </b-tab>

    <b-tab title="Correspondence">
        <div class="row" style="margin-left: 120px; align-items: center;">
            {!! $communication !!}
        </div>
    </b-tab>
</b-tabs>

