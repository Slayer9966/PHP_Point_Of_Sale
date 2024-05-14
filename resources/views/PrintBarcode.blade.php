@extends('userNav')

@section('content')
<head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.11.6/JsBarcode.all.min.js" integrity="sha512-k2wo/BkbloaRU7gc/RkCekHr4IOVe10kYxJ/Q8dRPl7u3YshAQmg3WfZtIcseEk+nGBdK03fHBeLgXTxRmWCLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<div class="app-content content">

    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>

        <div class="content-body">
            <!-- Grouped multiple cards for statistics starts here -->


            <!-- Grouped multiple cards for statistics ends here -->


            <!-- Minimal modern charts for power consumption, region statistics and sales etc. starts here -->

           
            <br>
            <br>
            <!-- info and time tracking chart -->
            <div class="row minimal-modern-charts">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-12 latest-update-tracking">
  <div class="card">
    <div class="card-header latest-update-heading d-flex justify-content-between">
      <h4 class="latest-update-heading-title text-bold-500">Available Publications</h4>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-bordered zero-configuration">
        <thead>
          <tr>
            <th>Name</th>
            <th>BarCode</th>
            <th>Image</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @if(!empty($Data))
            @foreach($Data as $item)
              <tr>
                <td>{{$item->Name}}</td>
                <td>
                  <img id="barcode-{{ $item->id }}"></img>
                  <script>
                    JsBarcode("#barcode-{{ $item->id }}", "{{ $item->Product_Code }}", {
                      format: "CODE128",
                      width: 1,  // Adjust width as needed
                      height: 30,  // Adjust height as needed
                      displayValue: true
                    });
                  </script>
                </td>
                <td>
                  <img width="200px" src="{{ asset($item->ProductImage) }}" alt="Product Image">
                </td>
                <td>
                  <button onclick="printBarcode('{{ $item->id }}')">Print Barcode</button>
                </td>
              </tr>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
</div>

</div>
<script>
  function printBarcode(barcodeId) {
    var barcodeImage = document.getElementById("barcode-" + barcodeId);
    
    if (barcodeImage) {
      var printWindow = window.open("", "_blank");
      printWindow.document.write('<img src="' + barcodeImage.src + '">');
      printWindow.document.close();
      printWindow.print();
    } else {
      console.error('Barcode image not found.');
    }
  }
</script>

@endsection
