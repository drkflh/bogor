<span class="btn btn-icon-text mr-2 mb-2 mb-md-0">
    <i class="btn-icon-prepend" data-feather="layers"></i>
    Selected Sheets : @{{ selectedSheets }}
</span>

<button type="button"
        @click="setBox()"
        class="btn btn-info btn-icon-text mr-2 mb-2 mb-md-0">
    <i class="btn-icon-prepend" data-feather="trash"></i>
    Dispose
</button>

<button type="button"
        style="margin-right: 100px !important;"
        @click="scanDirectory()"
        class="btn btn-info btn-icon-text mr-2 mb-2 mb-md-0">
    <i class="btn-icon-prepend" data-feather="link"></i>
    Check Links
</button>

