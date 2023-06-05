<div>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            {!! $avatar ?? '' !!}
            {!! $name ?? '' !!}
{{--            {!! $username ?? '' !!}--}}
            {!! $email ?? '' !!}
            {!! $mobile ?? '' !!}
            @if($_isCreate)
{{--                <h5>Access</h5>--}}
{{--                <h6>Password</h6>--}}
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
                <div class="col-6">
                    {!! $placeOfBirth ?? '' !!}
                </div>
                <div class="col-6">
                    {!! $dateOfBirth ?? '' !!}
                </div>
            </div>
            {!! $gender ?? '' !!}
            <hr>
            {!! $address ?? '' !!}
            {!! $province ?? '' !!}
            {!! $city ?? '' !!}
            {!! $ZIP ?? '' !!}


        </div>
    </div>
</div>
