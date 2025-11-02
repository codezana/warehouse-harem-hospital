@extends('layouts.nav')

@section('name', 'Purchase Report')
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


@endsection
@section('content')

<div class="page-wrapper page-wrapper-one">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Purchase Report</h4>
                <h6>Manage your Purchase Report</h6>
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
                            <a class="btn btn-searchset"><img src="assets/img/icons/search-white.svg"
                                    alt="img"></a>
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
                                    <input type="text" placeholder="Enter Product Name" id="productname">
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
                                <th>Product Name</th>
                                <th>Purchased amount</th>
                                <th>Purchased QTY</th>
                                <th>Instock qty</th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach ($purchases as $purchase)
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td class="productimgname">
                                    <a class="product-img">
                                        <img src="{{ asset('uploads/product/products/' . $purchase->product->image) }}" alt="product">
                                    </a>
                                    <a href="javascript:void(0);">{{ $purchase->product->name }}</a>
                                </td>
                                <td>{{ $purchase->totalpurchase->grand_total }}</td>
                                <td>{{ $purchase->quantity }}</td>
                                <td>{{ $purchase->product->quantity }}</td>
                            </tr> 
                            @endforeach
                            


                 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="searchpart">
    <div class="searchcontent">
        <div class="searchhead">
            <h3>Search </h3>
            <a id="closesearch"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
        </div>
        <div class="searchcontents">
            <div class="searchparts">
                <input type="text" placeholder="search here">
                <a class="btn btn-searchs">Search</a>
            </div>
            <div class="recentsearch">
                <h2>Recent Search</h2>
                <ul>
                    <li>
                        <h6><i class="fa fa-search me-2"></i> Settings</h6>
                    </li>
                    <li>
                        <h6><i class="fa fa-search me-2"></i> Report</h6>
                    </li>
                    <li>
                        <h6><i class="fa fa-search me-2"></i> Invoice</h6>
                    </li>
                    <li>
                        <h6><i class="fa fa-search me-2"></i> Sales</h6>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


@endsection
@section('custom-js')


<script>
    $(document).ready(function() {
        const clearButton = $("#clear");

        // Add event listeners to filter inputs
        $("#productname").on("keyup change",
            function() {
                const productname = $("#productname").val().toLowerCase();
              
                
                $("#userTable").DataTable().columns().every(function() {
                    const columnIndex = this[0][0];
                    let inputValue = "";

                    if (columnIndex === 1) { // Product name column index
                        inputValue = productname;
                
                    }

                    this.search(inputValue, true, false).draw();
                });
            });
        clearButton.on("click", function() {
            $("#productname").val(""); // Clear input values
            $("#userTable").DataTable().search("").columns().search("")
                .draw(); // Clear DataTable search and redraw
        });
    });
</script>



    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/plugins/select2/js/select2.min.js"></script>

    <script src="assets/js/feather.min.js"></script>

    <script src="assets/js/jquery.slimscroll.min.js"></script>

    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>


    <script src="assets/plugins/select2/js/select2.min.js"></script>

    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>

    <script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>

@endsection
