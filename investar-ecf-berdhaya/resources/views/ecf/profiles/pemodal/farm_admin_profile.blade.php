<div>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
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
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-8">
                    {!! $bizUnit ?? '' !!}
                </div>
                <div class="col-4">
                    {!! $employeeDateHired ?? '' !!}
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    {!! $placeOfBirth ?? '' !!}
                </div>
                <div class="col-4">
                    {!! $dateOfBirth ?? '' !!}
                </div>
                <div class="col-4">
                    {!! $gender ?? '' !!}
                </div>
            </div>
            {!! $address ?? '' !!}
            {!! $kabupaten ?? '' !!}
            {!! $province ?? '' !!}
            {!! $ZIP ?? '' !!}
        </div>
{{--        <div class="col-md-4 col-sm-12 col-xs-12">--}}
{{--            {!! $notificationSubs ?? '' !!}--}}
{{--        </div>--}}
    </div>
</div>
