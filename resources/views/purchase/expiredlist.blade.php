@extends('layouts.nav')

@section('name', 'Expired List')
@section('custom-css')
<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="assets/css/animate.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

@endsection
@section('content')



<div class="page-wrapper page-wrapper-one">
    <div class="content" id="refreshContent">
        <div class="page-header">
            <div class="page-title">
                <h4>Expired LIST</h4>
                <h6>Manage your Expireds</h6>
            </div>

        </div>


        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-path">
                            <a class="btn btn-filter" id="filter_search">
                                <img src="assets/img/icons/filter.svg" alt="img">
                                <span><img src="assets/img/icons/closes.svg" alt="img"></span>
                            </a>
                        </div>
                        <div class="search-input">
                            <a class="btn btn-searchset"><img src="assets/img/icons/search-white.svg" alt="img"></a>
                        </div>
                    </div>
                    <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                        src="assets/img/icons/pdf.svg" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                        src="assets/img/icons/excel.svg" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                        src="assets/img/icons/printer.svg" alt="img"></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card" id="filter_inputs">
                    <div class="card-body pb-0">
                        <div class="row">

                            <div class="col-lg col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" placeholder="Enter supplier name" id="suppliername">
                                </div>
                            </div>
                            <div class="col-lg col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" placeholder="Enter QTY" id="QTY">
                                </div>
                            </div>
                            <div class="col-lg col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" class="datetimepicker cal-icon" placeholder="Choose Date"
                                        id="Date">
                                </div>
                            </div>
                            <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                                <div class="form-group">
                                    <a class="btn btn-filters ms-auto" style="background-color: #ffffff;"><img
                                            src="assets/img/icons/clears.svg" alt="img" id="clear"></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table datanew" id="userTable">
                        <thead>
                            <tr>
                                <th>
                                    <label class="checkboxs">
                                        <input type="checkbox" id="select-all">
                                        <span class="checkmarks"></span>
                                    </label>
                                </th>
                                <th>Supplier Name</th>
                                <th>QTY</th>
                                <th>Expire Date</th>
                                <th>Expired</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                use App\Models\Product;
                                use Carbon\Carbon;

                            @endphp
                            @foreach ($expiringPurchases as $expiring)
                                @php

                                    $product = Product::find($expiring->product_id);
                                @endphp

                                @if ($product && $product->quantity > 0)
                                    @php
                                        $expireDate = Carbon::createFromFormat('Y-m-d', $expiring->expire_date);
                                        $remainingDays = $expireDate->diffInDays(\Carbon\Carbon::now());
                                    @endphp

                                    @if ($remainingDays >= 0 && $remainingDays <= 30)
                                        <tr>
                                            <td>
                                                <label class="checkboxs">
                                                    <input type="checkbox">
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </td>
                                            <td class="text-bolds">{{ $product->name }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>{{ $expiring->expire_date }}</td>
                                            <td>
                                                @if (!empty($expiring->expire_date))
                                                    <span class="badges bg-danger">Expired</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach


                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
</div>









<script>
    $(document).ready(function() {
            const clearButton = $("#clear");

            // Add event listeners to filter inputs
            $("#Date").on("focusout",
                function() {
                    const Date = $("#Date").val();
                    var rtldate="";

               var Datetext=Date;
               for(var year=6; year<10 ;year++){
                rtldate+=Datetext[year];

               };
              
               for(var month=2; month<6 ;month++){
                rtldate+=Datetext[month];
               };
               for(var day=0; day<2 ;day++){
                rtldate+=Datetext[day];
               };
                    $("#userTable").DataTable().columns().every(function() {
                        const columnIndex = this[0][0];
                        let inputValue = "";

                        if (columnIndex === 3) { // Product name column index
                            inputValue = rtldate;
                        } 


                        this.search(inputValue, true, false).draw();
                    });
                });
               

                $("#suppliername,#QTY").on("keyup change",
                function() {
                    const suppliername = $("#suppliername").val().toLowerCase();
                    const QTY = $("#QTY").val().toLowerCase();
                   
                    $("#userTable").DataTable().columns().every(function() {
                        const columnIndex = this[0][0];
                        let inputValue = "";

                        if (columnIndex === 1) { // Product name column index
                            inputValue = suppliername;
                        } else if(columnIndex === 2){
                            inputValue = QTY;

                        }


                        this.search(inputValue, true, false).draw();
                    });
                });







            clearButton.on("click", function() {
                $("#Date,#suppliername,#QTY").val(
                    ""); // Clear input values
                $("#userTable").DataTable().search("").columns().search("")
                    .draw(); // Clear DataTable search and redraw
            });
        });


</script>













@endsection
@section('custom-js')
<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
@endsection