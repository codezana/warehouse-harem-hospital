@extends('layouts.nav')

@section('name', 'Request Report')
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection
@section('content')







    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Request order report</h4>
                    <h6>Manage your Request order report</h6>
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
                                    <a href="#" id="generate-pdf" data-bs-toggle="tooltip" data-bs-placement="top" title="pdf">
                                        <img src="assets/img/icons/pdf.svg" alt="PDF">
                                    </a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                            src="assets/img/icons/excel.svg" alt="img"></a>
                                </li>
                                <li>
                                    <a href="#" id="print-data" data-bs-toggle="tooltip" data-bs-placement="top" title="print">
                                        <img src="assets/img/icons/printer.svg" alt="Print">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card" id="filter_inputs">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-lg col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="requestitem"
                                            placeholder="Enter Request Item">
                                    </div>
                                </div>
                                <div class="col-lg col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="requestQTY"
                                            placeholder="Enter Request QTY">
                                    </div>
                                </div>
                                <div class="col-lg col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="ordernumber"
                                            placeholder="Order Number">
                                    </div>
                                </div>
                                <div class="col-lg col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="requestReceipt"
                                            placeholder="enter Request Receipt">
                                    </div>
                                </div>
                                <div class="col-lg col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="requestname"
                                            placeholder="Request Name">
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
                                    <th>Request Item</th>
                                    <th>Requeste QTY</th>
                                    <th>Requestd amount</th>
                                    <th>Order number</th>
                                    <th>Request Receipt</th>
                                    <th>Request Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Orders->sortByDesc(function ($orderGroup) {
                                    return $orderGroup->first()->is_active;
                                }) as $order)
                                    @php
                                        // Get the first sale in the group
                                        $firstSale = $order->first();
                                        $totalQuantity = $order->sum('qty');
                                    @endphp
                                
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td class="productimgname">
                                            <a class="product-img">
                                                <img src="{{ asset('uploads/product/products/' . $firstSale->product->image) }}"
                                                    alt="product">
                                            </a>
                                            <a href="javascript:void(0);">{{ $firstSale->product->name }}</a>
                                        </td>
                                        <td>{{ $totalQuantity }}</td>
                                        <td>${{ $firstSale->product->price * $totalQuantity }}</td>
                                        <td>{{ $firstSale->order }}</td>
                                        <td>{{ $firstSale->receipt }}</td>
                                        <td>{{ $firstSale->userorder->username }}</td>
                                        <td>
                                            @if ($firstSale->is_active)
                                                <a href="{{ route('toggleStatusorder', ['id' => $firstSale->request_id]) }}"
                                                    class="bg-lightgreen badges">Active</a>
                                            @else
                                                <a href="{{ route('toggleStatusorder', ['id' => $firstSale->request_id]) }}"
                                                    class="bg-lightred badges">Disable</a>
                                            @endif
                                        </td>
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
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('print-button').addEventListener('click', function() {
                let selectedRows = [];

                document.querySelectorAll('#data-table tbody input[type="checkbox"]').forEach(function(
                    checkbox) {
                    if (checkbox.checked) {
                        let row = checkbox.closest('tr');
                        let rowData = [];

                        // Skip the checkbox column (start loop from 1)
                        for (let i = 1; i < row.cells.length; i++) {
                            rowData.push(row.cells[i].innerText);
                        }

                        selectedRows.push(rowData);
                    }
                });

                localStorage.setItem('printData', JSON.stringify(selectedRows));
                var url = "requestPrint.balde.php";

                // Redirect to the print.html page
                window.open(url, '_blank');
            });
        });
    </script>


<script>
    $(document).ready(function() {
        const clearButton = $("#clear");

        // Add event listeners to filter inputs
        $("#requestitem, #requestQTY, #ordernumber,#requestReceipt,#requestname").on("keyup change",
            function() {
                const requestitem = $("#requestitem").val().toLowerCase();
                const requestQTY = $("#requestQTY").val().toLowerCase();
                const ordernumber = $("#ordernumber").val().toLowerCase();
                const requestReceipt = $("#requestReceipt").val().toLowerCase();
                const requestname = $("#requestname").val().toLowerCase();

                $("#userTable").DataTable().columns().every(function() {
                    const columnIndex = this[0][0];
                    let inputValue = "";

                    if (columnIndex === 1) { // Product name column index
                        inputValue = requestitem;
    
                    }else if (columnIndex === 5) { // Category column index
                        inputValue = requestReceipt;
                    }
                    
                    else if (columnIndex === 2) { // Brand name column index
                        inputValue = requestQTY;
                    } else if (columnIndex === 4) { // code column index
                        inputValue = ordernumber;
                    }
                    else if (columnIndex === 6) { // code column index
                        inputValue = requestname;
                    }

                    this.search(inputValue, true, false).draw();
                });
            });
        clearButton.on("click", function() {
            $("#requestitem, #requestQTY, #ordernumber,#requestReceipt,#requestname").val(""); // Clear input values
            $("#SubCategorySelect").val(""); // Reset the selected option for SubCategorySelect
            $("#userTable").DataTable().search("").columns().search("")
                .draw(); // Clear DataTable search and redraw
        });
    });
</script>


    <script src="assets/js/feather.min.js"></script>

    <script src="assets/js/jquery.slimscroll.min.js"></script>

    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>

    <script src="assets/plugins/select2/js/select2.min.js"></script>

    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>

    <script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>


@endsection
