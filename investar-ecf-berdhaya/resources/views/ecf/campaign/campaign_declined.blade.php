
 <div class="container">
@php
 use App\Models\Ecf\Campaign;
 $campaign = Campaign::where('_id', '=', request('id'))->get();
 $camp = json_decode($campaign);
 $campaigTitle = $camp[0]->campaignTitle;
 $idCampaign = $camp[0]->_id;
 $nt = $camp[0]->decisionList;
 $note = end($nt)->changeRemarks;

@endphp

 <div class="grid-margin card">
     <div class="card-body">
             <h3>{!! $campaigTitle ?? '' !!} tidak memenuhi syarat, silakan diubah</h3>
             <!-- <h3></h3><br> -->
             <h3>Note :</h3>
             <h5>
             {!! $note ?? '' !!}
             </h5><br><br>
             <a class="btn btn-primary" href="/ecf/campaign/declined/<?php echo $idCampaign ?>" role="button">Edit</a>
     </div>
 </div>
</div>