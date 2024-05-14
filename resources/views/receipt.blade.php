<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt </title>
    <link rel="stylesheet" href="./temp/assets/css/reciept.css">
    
</head>
<body>
    
<div class="container" id="receipt-content">
    
    <div class="receipt_header" >
    <h1>Receipt of Sale <span>POS</span></h1>
    <h2>Address: Lorem Ipsum, 1234-5 <span>Tel: +1 012 345 67 89</span></h2>
    </div>
    
   
        <div class="items" >
            <table>
        
                <thead>
                    <th>QTY</th>
                    <th>ITEM</th>
                    <th>AMT</th>
                </thead>
        @php
$total = 0;
        @endphp
                <tbody>
                   @foreach($itemsInBill as $item)
                    <tr>
                      <td>{{$item->product_quantity}}</td>
                      <td>{{$item->product_name}}</td>
                      <td>{{$item->product_price}}</td>
                      {{$total += $item->product_quantity * $item->product_price}}
                    </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td></td>
                        <td>{{$total}}</td>
                    </tr>

                    
                </tfoot>

            </table>
        </div>

    </div>


    <h3>Thank You!</h3>
</div>
<button id="printButton">Print Receipt</button>


</body>
<script>

document.addEventListener('DOMContentLoaded', (event) => {
    function printReceipt() {
        window.print();
    }
    document.getElementById('printButton').addEventListener('click', printReceipt);
});

</script>
</html>
