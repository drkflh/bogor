<div class="card">
    <div class="card-body shadow-lg p-3 bg-body rounded">
        


<b-tab title="SKU" active>
    <div class="row p-3">
        <div class="col-6">
            {!! $productCode ?? '' !!}
        </div>

     <div class="col-6">
        {!! $price ?? '' !!}
    </div> 
    </div>

</b-tab>

<div class="row  p-3">  

    <div class="col-6">
        {!! $productName ?? '' !!}
    </div>

    <div class="col-6">
        {!! $category ?? '' !!}
    </div>
  
</div>



<div class="row  p-3">  
    <div class="col-6">
        {!! $unitCount ?? '' !!}
    </div>
    <div class="col-6">
        {!! $unit ?? '' !!}
        
    </div>          
</div>

<div class="row  p-3">  
    <div class="col-5">
        {!! $orderPrice ?? '' !!}
    </div>
    <div class="col-3">
        {!! $orderTime ?? '' !!}
    </div>      

     <div class="col-4">
        {!! $weight ?? '' !!}
    </div>    
</div>

<div class="row  p-3">  
    <div class="col-6">
        {!! $orderSubTotal ?? '' !!}
    </div>
    <div class="col-6">
        {!! $orderQty ?? '' !!}
    </div>          
</div>



</div>
</div>

