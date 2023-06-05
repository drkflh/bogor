<template>
    <div class="container">
        <div class="row">
            <div class="col-5">
                {!! $bizUnitCode ?? '' !!}
                {!! $bizUnitName ?? '' !!}
                {!! $bizUnitType ?? '' !!}
                {!! $companyCode ?? '' !!}
                {!! $companyName ?? '' !!}
                <div class="row">
                    <div class="col-8">
                        {!! $companyPhone ?? '' !!}
                    </div>
                    <div class="col-4">
                        {!! $companyPhoneExt ?? '' !!}
                    </div>
                        </div>
                <div class="row">
                    <div class="col-8">
                        {!! $companyPhone2 ?? '' !!}
                    </div>
                    <div class="col-4">
                        {!! $companyPhoneExt2 ?? '' !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        {!! $companyFax ?? '' !!}
                    </div>
                    <div class="col-4">
                        {!! $companyFaxExt ?? '' !!}
                    </div>
                </div>
                {!! $noNpwp ?? '' !!}
                {!! $nib ?? '' !!}
                {!! $api ?? '' !!}
            </div>
            <div class="col-7" style="margin-bottom:10px;">
                {!! $companyAddress ?? '' !!}
                {!! $companyAddress1 ?? '' !!}
                {!! $companyAddress2 ?? '' !!}
                {!! $companyEmail ?? '' !!}
                {!! $companyWeb ?? '' !!}
                {!! $companyLogo ?? '' !!}
            </div>
        </div>
    </div>
</template>
