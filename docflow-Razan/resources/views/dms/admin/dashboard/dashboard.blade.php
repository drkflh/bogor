<div class="d-flex flex-row flex-nowrap card-block overflow-auto">
  {{-- Left Side --}}
  <div class="col-md-7">
    {!! $tableHighlight ?? '' !!}
    {!! $tableLead ?? '' !!}
    {!! $tableProspect ?? '' !!}
  </div>

  {{-- Right Side --}}
  <div class="col-md-5">
    <div class="flex row">
      <div class="col-md-6">
        {!! $cardCoy1 ?? '' !!}
        {!! $cardCoy2 ?? '' !!}
        {!! $cardCoy3 ?? '' !!}
        {!! $cardCoy4 ?? '' !!}
      </div>
      <div class="col-md-6">
        {!! $cardGoodwin ?? '' !!}
        {!! $cardSri ?? '' !!}
        {!! $cardBurraco ?? '' !!}
        {!! $cardOther ?? '' !!}
      </div>
    </div>
  </div>
</div>
