<div>
    <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-12">
            {!! $avatar ?? '' !!}
            {!! $name ?? '' !!}
{{--            {!! $username ?? '' !!}--}}
{{--            {!! $email ?? '' !!}--}}
            {!! $mobile ?? '' !!}
            @if($_isCreate)
{{--                <hr>--}}
{{--                <h5>Access</h5>--}}
{{--                {!! $password ?? '' !!}--}}
{{--                {!! $confirm_password ?? '' !!}--}}
{{--                <br>--}}
{{--                <h6>PIN</h6>--}}
{{--                {!! $pin ?? '' !!}--}}
{{--                {!! $confirm_pin ?? '' !!}--}}
{{--                <br>--}}
{{--                <br>--}}
            @endif

        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-md-7 col-sm-12 col-xs-12">
                    {!! $bizUnit ?? '' !!}
                </div>
                <div class="col-md-5 col-sm-12 col-xs-12">
                    {!! $employeeDateHired ?? '' !!}
                </div>
            </div>
            <div class="row">
                <div class="col-7">
                    {!! $placeOfBirth ?? '' !!}
                </div>
                <div class="col-5">
                    {!! $dateOfBirth ?? '' !!}
                </div>
            </div>
            {!! $gender ?? '' !!}
            {!! $address ?? '' !!}
            {!! $kabupaten ?? '' !!}
            {!! $province ?? '' !!}
            {!! $ZIP ?? '' !!}
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            {!! $notificationSubs ?? '' !!}
        </div>
    </div>
</div>
