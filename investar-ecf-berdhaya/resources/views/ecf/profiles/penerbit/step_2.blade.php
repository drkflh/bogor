@if (\Session::has('error'))
    <div class="alert alert-danger">
        <ul>
            <li>{!! Session::get('error') !!}</li>
        </ul>
    </div>
@endif
<div>    
    <div class="row" style="margin-left:3px;">
        <div class="col-6" style="margin-bottom:5px; ">
            <div class="container text-left">
            {!! $isComplete !!}
                <div class="row align-items-start">
                    <div class="col">
                        {!! $bizTradeMark ?? '' !!}
                    </div>
                </div>
            </div>
            <div class="container text-left">
                <div class="row align-items-start">
                    <div class="col">
                        {!! $bizAddress ?? '' !!}
                    </div>
                </div>
            </div>
            
            <div class="container text-left">
                <div class="row align-items-start">
                    <div class="col">
                    {!! $bizType ?? '' !!}  
                    </div>
                </div>
            </div>

            <div class="container text-left">
                <div class="row align-items-start">
                    <div class="col">
                        {!! $bizRegisteredName ?? '' !!}
                    </div>
                </div>
            </div>
            <div class="container text-left">
                <div class="row align-items-start">
                    <div class="col">
                    {!! $haveLegalitas ?? '' !!}
                    </div>
                </div>
            </div>
            <div class="container text-left">
                <div class="row align-items-start">
                    <div class="col">
                    {!! $bizCompanyType ?? '' !!}
                    </div>
                </div>
            </div>

            <div class="container text-left">
                <div class="row align-items-start">
                    <div class="col">
                    {!! $bizIdType ?? '' !!}
                    </div>                    
                </div>
            </div>

            <div class="container text-left">
                <div class="row align-items-start">
                    <div class="col">
                    {!! $bizIdNumber ?? '' !!}
                    </div>                    
                </div>
            </div>

            <div class="container text-left">
                <div class="row align-items-start">
                    <div class="col">
                    {!! $noNPWP ?? '' !!}
                    </div>
                </div>
            </div>

            <div class="container text-left">
                <div class="row align-items-start">
                    <div class="col">
                    {!! $attNPWP ?? '' !!}
                    </div>
                </div>
            </div>
        </div>

           
        <div class="col-5 ml-2" style="border-left: thin solid #000000;">
            <div class="container text-left">
                {!! $attAktaPerusahaan ?? '' !!}
                {!! $attSKKemenhumham ?? '' !!}
                {!! $attNIB ?? '' !!}
                {!! $attTDP ?? '' !!}
                {!! $slikOJK ?? '' !!}
                {!! $legality ?? '' !!}
            </div>
        </div>
    </div>
</div>