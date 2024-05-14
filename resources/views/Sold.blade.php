@extends('userNav')
@section('content')


<head>
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        i {
            font-size: 20px;
        }
    </style>
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


                <!-- latest update tracking chart-->
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-12 latest-update-tracking">
                    <div class="card">
                        <div class="card-header latest-update-heading d-flex justify-content-between">
                            <h4 class="latest-update-heading-title text-bold-500">Sold Products</h4>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>

                                        <th>Quantity
                                        </th>
                                        <th>Price</th>
                                        <th>Profit</th>

                                       
                                       


                                       
                                        

                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($Sold))
                                    @foreach($Sold as $item)

                                    <tr>

                                        <td>{{$item->id}}</td>
                                        <td>{{$item->product_name}}</td>
                                        <td>{{$item->product_quantity}}</td>
                                        <td>{{$item->product_price}}</td>
                                        <td>{{$item->Profit}}</td>

                                       





                                        





                                       
                                        
                                    </tr>

                                    @endforeach
                                    @endif
                                </tbody>

                            </table>


                        </div>

                    </div>
                </div>
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-bold-500">Monthly Sales</h4>
                        </div>
                        <div class="card-body">
                            <!-- Display Monthly Sales Data Here -->
                            <p>Total Sales: {{$monthlySales}}</p>
                            <!-- Add more information or charts as needed -->
                        </div>
                    </div>
                </div>

                <!-- Div for Weekly Sales -->
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-bold-500">Weekly Sales</h4>
                        </div>
                        <div class="card-body">
                            <!-- Display Weekly Sales Data Here -->
                            <p>Total Sales: {{$weeklySales}}</p>
                            <!-- Add more information or charts as needed -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



</div>
</div>

</div>



@endsection