<form class="p-3">


<b-tab title="SKU" active>
    <div class="row">
        <div class="col-12">
            {!! $productCode ?? '' !!}
        </div>
    </div>
</b-tab>

<div class="row">  
    <div class="col-12">
        {!! $productName ?? '' !!}
    </div>
  
</div>

<div class="row">  
    <div class="col-12">
        {!! $price ?? '' !!}
    </div>
        
</div>

<div class="row">  
    <div class="col-6">
        {!! $unitCount ?? '' !!}
    </div>
    <div class="col-6">
        {!! $unit ?? '' !!}
        
    </div>          
</div>

<div class="row">  
    <div class="col-6">
        {!! $orderPrice ?? '' !!}
    </div>
    <div class="col-6">
        {!! $orderTime ?? '' !!}
    </div>          
</div>

<div class="row">  
    <div class="col-6">
        {!! $orderSubTotal ?? '' !!}
    </div>
    <div class="col-6">
        {!! $orderQty ?? '' !!}
    </div>          
</div>

<div class="row">  
    <div class="col-12">
        {!! $weight ?? '' !!}
    </div>
        
</div>

</form>

