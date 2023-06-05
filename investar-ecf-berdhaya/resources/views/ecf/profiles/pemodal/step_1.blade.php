@if (\Session::has('error'))
    <div class="alert alert-danger">
        <ul>
            <li>{!! \Session::get('error') !!}</li>
        </ul>
    </div>
@endif
<div class="row" style="margin-left:3px; border-bottom: thin solid #000000;">
    <div class="col-6" style="margin-bottom:5px; ">
        <div class="container text-left">
        {!! $phone !!}
        {!! $name ?? '' !!}
        <div class="row align-items-start">
            <div class="col">
            {!! $firstName ?? '' !!}
            </div>
            <div class="col">
            {!! $lastName ?? '' !!}
            </div>
        </div>
        
        {!! $gender ?? '' !!}
        <div class="row align-items-start">
            <div class="col">
            {!! $placeOfBirth ?? '' !!}
            </div>
            <div class="col">
            {!! $dateOfBirth ?? '' !!}
            </div>
        </div>
        
        
        {!! $citizenship ?? '' !!}
        {!! $maritalStatus ?? '' !!}
        {!! $relativeName ?? '' !!}
        {!! $relativeMobile ?? '' !!}
        {!! $relativeRelation ?? '' !!}
        </div>
    </div>

    <div class="col-5 ml-2" style="border-left: thin solid #000000;">
        <div class="container text-left">
            {!! $IdCardAddress ?? '' !!}
            {!! $address ?? '' !!}


            {!! $lastEducation ?? '' !!}
            {!! $currentJob ?? '' !!}
            {!! $monthlyIncome ?? '' !!}
            {!! $incomeSource ?? '' !!}

            {!! $currentJobDesc ?? '' !!}
            {!! $incomeSourceDesc ?? '' !!}
            {!! $ageStatus !!}
        </div>
    </div>
</div>
<br>    
<div class="row" style="margin-left:3px; border-bottom: thin solid #000000;">
<small>
    Sesuai dengan peraturan OJK No 37/POJK.04/2018 dan perubaahannya bahwa :
<ul>
    <li>Jika penghasilan < = Rp. 500.000.000,- ( Lima ratus juta Rupiah) / tahun maka maksimal investasi yang diperbolehkan adalah 5% dari total penghasilan/tahun.</li>
    <li>Jika penghasilan > Rp. 500.000.000,- ( Lima ratus juta Rupiah) / tahun maka maksimal investasi yang diperbolehkan adalah 10% dari total penghasilan /tahun</li>
</ul>
    </small>
</div>


