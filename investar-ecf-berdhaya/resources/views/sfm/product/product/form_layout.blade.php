<div class="container">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            {!! $productCode ?? '' !!}
            {!! $productName ?? '' !!}
            {!! $category ?? '' !!}
            {!! $description ?? '' !!}
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="row">
                <div class="col-7">
                    {!! $price ?? '' !!}
                </div>
                <div class="col-3">
                    {!! $unitCount ?? '' !!}
                </div>
                <div class="col-2">
                    {!! $unit ?? '' !!}
                </div>
            </div>
                <div class="row">
                    <div class="col-6">
                        {!! $rate ?? '' !!}
                    </div>
                    <div class="col-6">
                        {!! $weight ?? '' !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        {!! $products ?? '' !!}
                    </div>
                    <div class="col-6">
                        {!! $stock ?? '' !!}
                    </div>
                </div>
            {!! $picture ?? '' !!}
        </div>
    </div>
</div>

{{-- <script>
    (function() {
  var numberFields = document.querySelectorAll("input[type=number]"),
    len = numberFields.length,
    numberField = null;

  for (var i = 0; i < len; i++) {
    numberField = numberFields[i];
    numberField.onclick = function() {
      this.setAttribute("step", ".5");
    };
    numberField.onkeyup = function(e) {
      if (e.keyCode === 38 || e.keyCode === 40) {
        this.setAttribute("step", ".5");
      }
    };
  }
}());
</script> --}}
