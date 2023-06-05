
<div class="card">
    <div class="card-body">
        @if($label && $label != '')
        <div class="d-flex justify-content-between align-items-baseline mb-2">
            <h6 class="card-title mb-0">
                    {{ __($label) }}
            </h6>
        </div>
        @endif
        <div class="d-flex flex-column">
            <a v-for="val in {{ $form['model'] }}" href="#" class="d-flex align-items-center border-bottom pb-3">
                <div class="mr-3">
                    <img :src="val.approverSignature" class="rounded-5 wd-35" alt="signature">
                </div>
                <div class="w-100">
                    <div class="d-flex justify-content-between">
                        <h6 class="text-body mb-2">@{{ val.approverDecision ?? '' }} by @{{ val.approverName }}</h6>
                    </div>
                    <p class="text-muted tx-13">@{{ val.approverNote }}</p>
                    <p class="text-muted tx-12">@{{ val.approverTime ?? '' }}<br>@{{ val.approverTz ?? '' }}</p>
                </div>
            </a>
        </div>
    </div>
</div>
