@if( \App\Helpers\AuthUtil::can('dispatch', 'repository', Auth::user()->roleId) )
<span class="btn btn-icon-text mr-2 mb-2 mb-md-0">
    <i class="btn-icon-prepend" data-feather="layers"></i>
    Sheets : @{{ selectedSheets }}
</span>

<button type="button"
        @click="setBox()"
        class="btn btn-info btn-icon-text mr-2 mb-2 mb-md-0">
    <i class="las la-archive"></i>
    Set Box
</button>
@endif

@if( \App\Helpers\AuthUtil::can('scanlink', 'repository', Auth::user()->roleId) )
{{--<button type="button"--}}
{{--        style="margin-right: 100px !important;"--}}
{{--        @click="openScanner()"--}}
{{--        class="btn btn-info btn-icon-text mr-2 mb-2 mb-md-0">--}}
{{--    <i class="btn-icon-prepend" data-feather="link"></i>--}}
{{--    Scan & Link--}}
{{--</button>--}}
@endif

