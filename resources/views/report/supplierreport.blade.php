@extends('layouts.nav')

@section('name', 'Supplier Report')
@section('custom-css')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

<style>
    .card {
        .card {
            border: unset;
        }
    }

</style>
@endsection
@section('content')



<div class="page-wrapper page-wrapper-one">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Supplier Report</h4>
                <h6>Manage your Supplier Report</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="tabs-set">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="purchase-tab" data-bs-toggle="tab"
                                data-bs-target="#purchase" type="button" role="tab" aria-controls="purchase"
                                aria-selected="true">Purchase</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment"
                                type="button" role="tab" aria-controls="payment" aria-selected="false">Supplier</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="return-tab" data-bs-toggle="tab" data-bs-target="#return"
                                type="button" role="tab" aria-controls="return" aria-selected="false">Return</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="purchase" role="tabpanel"
                            aria-labelledby="purchase-tab">
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
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"
                                                id="PDFbtnPurchase"><img src="assets/img/icons/pdf.svg" alt="img"></a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                                    src="assets/img/icons/excel.svg" alt="img"></a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"
                                                id="PrintbtnPurchase"><img src="assets/img/icons/printer.svg"
                                                    alt="img"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card" id="filter_inputs">
                                <div class="card-body pb-0">
                                    <div class="row">


                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="Enter product name" id="productname">
                                            </div>
                                        </div>

                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="Enter QTY" id="QTY">
                                            </div>
                                        </div>

                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <input type="text" class="datetimepicker cal-icon"
                                                    placeholder="Choose Date" id="Date">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                                            <div class="form-group">
                                                <a class="btn btn-filters ms-auto"
                                                    style="background-color: #ffffff;"><img
                                                        src="assets/img/icons/clean.png" width="50px" alt="img"
                                                        id="clear1"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table datanew" id="userTable1">
                                    <thead>
                                        <tr>
                                            <th>
                                                <label class="checkboxs">
                                                    <input type="checkbox" class="row-checkboxPurchase" id="select-all">
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </th>
                                            <th>#</th>
                                            <th>Purchased Date</th>
                                            <th>Product Name</th>
                                            <th>Purchased QTY</th>
                                            <th>Purchased amount</th>
                                            <th>Paid</th>
                                            <th>Shipping</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($purchase as $key => $purchases)
                                        <tr>
                                            <td>
                                                <label class="checkboxs">
                                                    <input type="checkbox" class="row-checkboxPurchase">
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </td>
                                            <td>{{ $key + 1 }}</td>

                                            <td>{{ $purchases->date }}</td>
                                            <td class="productimgname">
                                                <a class="product-img">
                                                    <img src="{{ asset('uploads/product/products/' . $purchases->product->image) }}"
                                                        alt="product">
                                                </a>
                                                <a href="javascript:void(0);">{{ $purchases->product->name }}</a>
                                            </td>
                                            <td>{{ $purchases->quantity }}</td>
                                            <td>${{ $purchases->totalPurchase->grand_total }}</td>
                                            <td>${{ $purchases->totalPurchase->paid }}</td>
                                            <td>
                                                @if ($purchases->totalPurchase->shipping_total)
                                                ${{ $purchases->totalPurchase->shipping_total }}
                                                @else
                                                No Shipping
                                                @endif


                                            </td>
                                            <td>
                                                <span
                                                    class="badges bg-{{ $purchases->totalPurchase->status === 'Completed' ? 'lightgrey' : 'danger' }}">{{ $purchases->totalPurchase->status === 'Completed' ? 'Received' : 'UnReceived' }}</span>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="payment" role="tabpanel">
                            <div class="table-top">
                                <div class="search-set">
                                    <div class="search-path">
                                        <a class="btn btn-filter" id="filter_search2">
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
                                            <a href="{{route("generatePDFSupplier_Report_Supplier")}}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                                    src="assets/img/icons/pdf.svg" alt="img"></a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                                    src="assets/img/icons/excel.svg" alt="img"></a>
                                        </li>
                                        <li>
                                            <a href="{{route("generatePrintSupplier_Report_Supplier")}}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                                    src="assets/img/icons/printer.svg" alt="img"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card" id="filter_inputs2">
                                <div class="card-body pb-0">
                                    <div class="row">

                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="Enter ID" id="ID">
                                            </div>
                                        </div>
                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="Enter Suppliername" id="Suppliername1">
                                            </div>
                                        </div>
                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="Phone Number" id="Phonenumber">
                                            </div>
                                        </div>
                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="Email" id="Email">
                                            </div>
                                        </div>
                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="enter City" id="City">
                                            </div>
                                        </div>
                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="Created By" id="createdby">
                                            </div>
                                        </div>



                                        <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                                            <div class="form-group">
                                                <a class="btn btn-filters ms-auto"
                                                    style="background-color: #ffffff;"><img
                                                        src="assets/img/icons/clean.png" width="50px" alt="img"
                                                        id="clear2"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table datanew" id="userTable2">
                                    <thead>
                                        <tr>
                                            <th>
                                                <label class="checkboxs">
                                                    <input type="checkbox" >
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </th>
                                            <th>ID</th>
                                            <th>Avatar</th>
                                            <th>Supplier Name</th>
                                            <th>Phone</th>
                                            <th>email</th>
                                            <th>City</th>
                                            <th>Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suppliers as $index => $supplier)
                                        <tr>
                                            <td>
                                                <label class="checkboxs">
                                                    <input type="checkbox">
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </td>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="productimgname">
                                                <a href="javascript:void(0);" class="product-img">
                                                    <img src="{{ asset('uploads/suppliers/' . $supplier->avatar) }}"
                                                        alt="Customer Pic">
                                                </a>
                                            </td>
                                            <td>{{ $supplier->supplier_name }}</td>
                                            <td>{{ $supplier->phone }}</td>
                                            <td>{{ $supplier->email }}</td>
                                            <td>{{ $supplier->city }}</td>
                                            <td>{{ $supplier->createdBy->username }}</td>

                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="return" role="tabpanel">
                            <div class="table-top">
                                <div class="search-set">
                                    <div class="search-path">
                                        <a class="btn btn-filter" id="filter_search1">
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
                                            <a href="{{route("generatePDFSupplier_Report_Return")}}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                                    src="assets/img/icons/pdf.svg" alt="img"></a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                                    src="assets/img/icons/excel.svg" alt="img"></a>
                                        </li>
                                        <li>
                                            <a href="{{route("generatePrintSupplier_Report_Return")}}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                                    src="assets/img/icons/printer.svg" alt="img"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card" id="filter_inputs1">
                                <div class="card-body pb-0">
                                    <div class="row">

                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="enter reference" id="reference">
                                            </div>
                                        </div>
                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="enter supplier name" id="suppliername2">
                                            </div>
                                        </div>

                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="payment status" id="paymentstatus">
                                            </div>
                                        </div>




                                        <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                                            <div class="form-group">
                                                <a class="btn btn-filters ms-auto"
                                                    style="background-color: #ffffff;"><img
                                                        src="assets/img/icons/clean.png" width="50px" alt="img"
                                                        id="clear3"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="table-responsive">
                                <table class="table datanew" id="userTable3">
                                    <thead>
                                        <tr>
                                            <th>
                                                <label class="checkboxs">
                                                    <input type="checkbox" id="select-all">
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </th>
                                            <th>#</th>
                                            <th>Reference</th>
                                            <th>Supplier name </th>
                                            <th>Amount</th>
                                            <th>Paid</th>
                                            <th>Amount due</th>
                                            <th>Status</th>
                                            <th>Payment Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($purchaseReturn as $key => $purchaseReturns)
                                        <tr>
                                            <td>
                                                <label class="checkboxs">
                                                    <input type="checkbox">
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </td>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $purchaseReturns->reference }}</td>
                                            <td>{{ $purchaseReturns->supplier->supplier_name }}</td>
                                            <td>${{ $purchaseReturns->totalPurchase->grand_total }}</td>
                                            <td>{{ $purchaseReturns->totalPurchase->paid }}</td>
                                            <td>${{ $purchaseReturns->totalPurchase->grand_total - $purchaseReturns->totalPurchase->paid }}
                                            </td>

                                            <td>
                                                <span
                                                    class="badges bg-{{ $purchaseReturns->totalPurchase->status === 'Completed' ? 'lightgrey' : 'danger' }}">{{ $purchaseReturns->totalPurchase->status === 'Completed' ? 'Completed' : 'InProgress' }}</span>
                                            </td>


                                            <td>
                                                <span
                                                    class="badges bg-{{ $purchaseReturns->totalPurchase->status === 'Completed' ? 'lightgreen' : 'danger' }}">{{ $purchaseReturns->totalPurchase->status === 'Completed' ? 'Paid' : 'Unpaid' }}</span>
                                            </td>



                                        </tr>
                                        @endforeach






                                    </tbody>
                                </table>
                            </div> --}}
                        </div>
                    </div>
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
{{-- <script>
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
                var url = "SalesPrint.html";

                // Redirect to the print.html page
                window.open(url, '_blank');
            });
        });
    </script> --}}

{{-- important code for searing --}}
<script>
    let supplier = document.querySelector('#payment-tab');
    let clickHandler = () => {
        let searchInput = document.querySelectorAll('.search-input');
        let supplierChild = searchInput[1].children[3];
        searchInput[1].innerHTML =
            '<a class="btn btn-searchset"><img src="assets/img/icons/search-white.svg" alt="img"></a>';
        searchInput[1].appendChild(supplierChild);

        supplier.removeEventListener('click', clickHandler);
    };

    supplier.addEventListener('click', clickHandler);



    let returns = document.querySelector('#return-tab');
    let clickHandlers = () => {
        let searchInput = document.querySelectorAll('.search-input');
        let supplierChild = searchInput[2].children[13];
        searchInput[2].innerHTML =
            '<a class="btn btn-searchset"><img src="assets/img/icons/search-white.svg" alt="img"></a>';
        searchInput[2].appendChild(supplierChild);

        returns.removeEventListener('click', clickHandlers);
    };

    returns.addEventListener('click', clickHandlers);

</script>













<script>
    $(document).ready(function () {
        const clearButton = $("#clear1");

        // Add event listeners to filter inputs
        $("#Date").on("focusout",
            function () {
                const Date = $("#Date").val();
                var rtldate = "";

                var Datetext = Date;
                for (var year = 6; year < 10; year++) {
                    rtldate += Datetext[year];

                };

                for (var month = 2; month < 6; month++) {
                    rtldate += Datetext[month];
                };
                for (var day = 0; day < 2; day++) {
                    rtldate += Datetext[day];
                };
                $("#userTable1").DataTable().columns().every(function () {
                    const columnIndex = this[0][0];
                    let inputValue = "";

                    if (columnIndex === 2) { // Product name column index
                        inputValue = rtldate;
                    }


                    this.search(inputValue, true, false).draw();
                });
            });


        $("#productname,#QTY").on("keyup change",
            function () {
                const productname = $("#productname").val().toLowerCase();
                const QTY = $("#QTY").val().toLowerCase();

                $("#userTable1").DataTable().columns().every(function () {
                    const columnIndex = this[0][0];
                    let inputValue = "";

                    if (columnIndex === 3) { // Product name column index
                        inputValue = productname;
                    } else if (columnIndex === 4) {
                        inputValue = QTY;

                    }


                    this.search(inputValue, true, false).draw();
                });
            });







        clearButton.on("click", function () {
            $("#Date,#productname,#QTY").val(
                ""); // Clear input values
            $("#userTable1").DataTable().search("").columns().search("")
                .draw(); // Clear DataTable search and redraw
        });
    });

</script>



<script>
    $(document).ready(function () {
        const clearButton = $("#clear2");

        // Add event listeners to filter inputs
        $("#ID, #Suppliername1, #Phonenumber,#Email,#City,#createdby").on("keyup change",
            function () {
                const ID = $("#ID").val().toLowerCase();
                const Suppliername1 = $("#Suppliername1").val().toLowerCase();
                const Phonenumber = $("#Phonenumber").val().toLowerCase();
                const Email = $("#Email").val().toLowerCase();
                const City = $("#City").val().toLowerCase();
                const createdby = $("#createdby").val().toLowerCase();

                $("#userTable2").DataTable().columns().every(function () {
                    const columnIndex = this[0][0];
                    let inputValue = "";

                    if (columnIndex === 1) { // Product name column index
                        inputValue = ID;

                    } else if (columnIndex === 3) { // Category column index
                        inputValue = Suppliername1;
                    } else if (columnIndex === 4) { // Brand name column index
                        inputValue = Phonenumber;
                    } else if (columnIndex === 5) { // code column index
                        inputValue = Email;
                    } else if (columnIndex === 6) { // code column index
                        inputValue = City;
                    } else if (columnIndex === 7) { // code column index
                        inputValue = createdby;
                    }

                    this.search(inputValue, true, false).draw();
                });
            });
        clearButton.on("click", function () {
            $("#ID, #Suppliername1, #Phonenumber,#Email,#City,#createdby").val(
            ""); // Clear input values
            $("#SubCategorySelect").val(""); // Reset the selected option for SubCategorySelect
            $("#userTable2").DataTable().search("").columns().search("")
                .draw(); // Clear DataTable search and redraw
        });
    });

</script>




<script>
    $(document).ready(function () {
        const clearButton = $("#clear3");

        // Add event listeners to filter inputs
        $("#reference, #suppliername2, #paymentstatus").on("keyup change",
            function () {
                const reference = $("#reference").val().toLowerCase();
                const suppliername2 = $("#suppliername2").val().toLowerCase();
                const paymentstatus = $("#paymentstatus").val().toLowerCase();


                $("#userTable3").DataTable().columns().every(function () {
                    const columnIndex = this[0][0];
                    let inputValue = "";

                    if (columnIndex === 2) { // Product name column index
                        inputValue = reference;

                    } else if (columnIndex === 3) { // Category column index
                        inputValue = suppliername2;
                    } else if (columnIndex === 8) { // Brand name column index
                        inputValue = paymentstatus;
                    }

                    this.search(inputValue, true, false).draw();
                });
            });
        clearButton.on("click", function () {
            $("#reference, #suppliername2, #paymentstatus").val(""); // Clear input values
            $("#SubCategorySelect").val(""); // Reset the selected option for SubCategorySelect
            $("#userTable3").DataTable().search("").columns().search("")
                .draw(); // Clear DataTable search and redraw
        });
    });

</script>











<script>
    const checkboxes = document.querySelectorAll('.row-checkboxPurchase');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            selectedData();


        });
    });

    function selectedData() {

        const selectedRowsData = [];

        checkboxes.forEach((cb, index) => {
            if (cb.checked) {
                // Retrieve data from the selected row
                const row = cb.closest('tr');
                const rowData = {
                    purchasedDate: row.cells[2].textContent.trim(),
                    productname: row.cells[3].textContent.trim(),
                    QTY: row.cells[4].textContent.trim(),
                    Amount: row.cells[5].textContent.trim(),
                    paid: row.cells[6].textContent.trim(),
                    shipping: row.cells[7].textContent.trim(),
                    status: row.cells[8].textContent.trim()


                };

                selectedRowsData.push(rowData);
            };

        });
        if (document.getElementById("select-all").checked) {
            selectedRowsData.shift();

        }

        //   console.log(selectedRowsData); // You can perform any action with the data here
        localStorage.setItem('myListData', JSON.stringify(selectedRowsData));

    }


    // //alert when we forget to check data to print or pdf
    // $("#PrintbtnPurchase,#PDFbtnPurchase").on("click", function () {

    //     let receivedList = JSON.parse(localStorage.getItem('myListData'));

    //     if (receivedList.length == 0) {
    //         alert("please select the data that you want to print or make pdf");
    //         $("#PrintbtnPurchase").removeAttr('href');
    //         $("#PDFbtnPurchase").removeAttr('href');
    //     } else {
    //         $("#PrintbtnPurchase").attr('href', "{{route('generatePrintSupplier_Report_Purchase')}}");
    //         $("#PDFbtnPurchase").attr('href', "{{route('generatePDFSupplier_Report_Purchase')}}");

    //     };





    // });






    window.addEventListener('load', function () {

        localStorage.setItem('myListData', JSON.stringify([]));

    });

</script>














<script src="assets/js/feather.min.js"></script>

<script src="assets/js/jquery.slimscroll.min.js"></script>

<script src="assets/js/moment.min.js"></script>

<script src="assets/js/bootstrap-datetimepicker.min.js"></script>


<script src="assets/plugins/select2/js/select2.min.js"></script>

<script src="assets/js/moment.min.js"></script>

<script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
<script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>



@endsection
