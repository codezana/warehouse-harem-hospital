@extends('layouts.nav')

@section('name', 'Customer Report')
@section('custom-css')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection
@section('content')


    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Customer Report</h4>
                    <h6>Manage your Customer Report</h6>
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
                                    <a id="print-button" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="print"><img src="assets/img/icons/printer.svg" alt="img"></a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card" id="filter_inputs">
                        <div class="card-body pb-0">
                            <div class="row">
                                
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" id="customername" class="form-control"
                                            placeholder="customer name">
                                    </div>
                                </div>

                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" id="customeremail" class="form-control"
                                            placeholder="customer email">
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
                        <table id="userTable" class="table datanew">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>#</th>
                                    <th>Customer Name </th>
                                    <th>Customer Email</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Paument Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($sales as $key => $sale)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $key + 1 }}</td>
                                        <td>

                                            @if ($sale->customer_id)
                                                {{ $sale->customer->customer_name }}
                                            @elseif ($sale->user_id)
                                                {{ $sale->salesuser->username }}
                                            @else
                                                No customer or user associated
                                            @endif
                                        </td>
                                        <td>

                                            @if ($sale->customer_id)
                                                {{ $sale->customer->email }}
                                            @elseif ($sale->user_id)
                                                {{ $sale->salesuser->email }}
                                            @else
                                                No customer or user associated
                                            @endif
                                        </td>
                                        <td>{{ $sale->salesOrder->total_dollar }}</td>
                                        <td>
                                            <span
                                                class="badges bg-{{ $sale->salesOrder->status === 'Completed' ? 'lightgreen' : 'danger' }}">{{ $sale->salesOrder->status }}</span>
                                        </td>


                                        <td>
                                            <span
                                                class="badges bg-{{ $sale->salesOrder->status === 'Completed' ? 'lightgreen' : 'danger' }}">{{ $sale->salesOrder->status === 'Completed' ? 'Paid' : 'Unpaid' }}</span>
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
                var url = "CustomersPrint.html";

                // Redirect to the print.html page
                window.open(url, '_blank');
            });
        });
    </script>


<script>
    $(document).ready(function() {
        const clearButton = $("#clear");

        // Add event listeners to filter inputs
        $("#customername, #customeremail").on("keyup change",
            function() {
                const customername = $("#customername").val().toLowerCase();
                const customeremail = $("#customeremail").val().toLowerCase();
                
                $("#userTable").DataTable().columns().every(function() {
                    const columnIndex = this[0][0];
                    let inputValue = "";

                    if (columnIndex === 2) { // Product name column index
                        inputValue = customername;
                    } else if (columnIndex === 3) { // code column index
                        inputValue = customeremail;
                    }
                    this.search(inputValue, true, false).draw();
                });
            });
        clearButton.on("click", function() {
            $("#customername,#customeremail").val(""); // Clear input values
            $("#userTable").DataTable().search("").columns().search("")
                .draw(); // Clear DataTable search and redraw
        });
    });
</script>




    <script src="assets/js/feather.min.js"></script>

    <script src="assets/js/jquery.slimscroll.min.js"></script>


    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>

    <script src="assets/plugins/select2/js/select2.min.js"></script>

    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>

    <script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>


@endsection
