<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Advanced Report-Quantity Purchased</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/print/invoic-advance/assets/css/bootstrap.min.css') }}">

    <!-- Favicon icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/harem.png') }}">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/print/invoic-advance/assets/css/style.css') }}">


    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"
    integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .invoice-top {
            display: block;
            /* Show the invoice top section on print */
            /* position: fixed;
            top: 0;
            left: 0;
            right: 0; */
            background-color: #fff;
            /* Adjust background color as needed */
            padding: 20px;
            border-bottom: 1px solid #ccc;
            /* Add a border for separation */
            page-break-after: auto;

        }

        .invoice-info,
        .invoice-informeshon,
        .invoice-contact {
            display: block;
            /* Show these sections on print */
            page-break-after: auto;
            /* Force page break after each section */
        }
    </style>
</head>

<body>

    <!-- Invoice 6 start -->
    <div class="invoice-6 invoice-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-inner" id="invoice_wrapper">
                        <div class="invoice-top">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="logo">
                                        <div class="cs-logo"><img src="{{ asset('assets/img/haremw.png') }}"
                                                style="width: 190px;height: 63px;"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="invoice text-end">
                                        <h1>Invoice</h1>
                                        <p class="mb-1">Invoice Number <span>#{{$filteredPurchases->first()->first()->reference}}</span></p>
                                        <p class="mb-0">Invoice Date : <span id="invoice-date">{{ \Carbon\Carbon::parse($filteredPurchases->first()->first()->date)->format('d-m-Y') }}</span></p>
                                    </div>

                      

                                </div>
                            </div>
                        </div>
                        <div class="invoice-info">
                            <div class="row">
                                <div class="col-sm-6 mb-30">
                                    <div class="invoice-number">
                                        <h4 class="inv-title-1">Supplier Info</h4>
                                        <p class="invo-addr-1">
                                            {{ $filteredPurchases->first()->first()->supplier->supplier_name }} <br>
                                            {{ $filteredPurchases->first()->first()->supplier->email }}
                                            <br>{{ $filteredPurchases->first()->first()->supplier->phone }} <br>
                                            {{ $filteredPurchases->first()->first()->supplier->address }} ,
                                            {{ $filteredPurchases->first()->first()->supplier->district }} ,
                                            {{ $filteredPurchases->first()->first()->supplier->city }} <br>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-30">
                                    <div class="invoice-number text-end">
                                        <h4 class="inv-title-1">Bill To</h4>
                                        <p class="invo-addr-1" style="font-weight: 600">
                                            {{ $filteredPurchases->first()->first()->totalPurchase->status }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 mb-30">
                                    <h4 class="inv-title-1">Date</h4>
                                    <p class="inv-from-1">Date : {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</p>

                                </div>
                                <div class="col-sm-6 text-end mb-30">
                                    <h4 class="inv-title-1">Payment Method</h4>
                                    <p class="inv-from-1">{{ $filteredPurchases->first()->first()->totalPurchase->status === 'Completed' ? 'Paid' : 'Unpaid' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="order-summary">
                            <div class="table-responsive">
                                <table class="table invoice-table">
                                    <thead class="bg-active">
                                        <tr>
                                            <th>Id</th>
                                            <th>Item</th>
                                            <th class="text-center">Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($filteredPurchases as $index => $filteredPurchase)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td class="text-center">
                                                    <div class="item-desc-1">
                                                        <span style="text-align: center">{{ $filteredPurchase->product->name }}</span>
                                                    </div>
                                                </td>
                                                <td class="text-center">{{ $filteredPurchase->quantity }}</td>
                                               

                                            </tr>
                                        @endforeach




                                        <tr>
                                            <td colspan="2" class="text-center fw-bold">Total Quantity</td>
                                            <td class="text-right fw-bold">{{ $filteredPurchases->sum(function ($purchase) {
                                                return $purchase->quantity;
                                            }) }}</td>                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="invoice-informeshon">
                            <div class="row">
          
                                <div class="col-md-6 col-sm-6">
                                    <div class="nates mb-30">
                                        <h4 class="inv-title-1">Terms and Condistions</h4>
                                        <p class="text-muted">Once order done, money can't refund. Delivery might delay
                                            due to some external</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="invoice-contact clearfix">
                            <div class="row g-0">
                                <div class="col-lg-9 col-md-11 col-sm-12">
                                    <div class="contact-info" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;font-weight: 500">
                                        <a href="tel:+55-4XX-634-7071"><i class="fa fa-phone"></i> +964 770 385 3805</a>
                                        <a href="tel:haremhospital@gmail.com"><i class="fa fa-envelope"></i> haremhospital@gmail.com</a>
                                        <a href="tel:info@themevessel.com" class="mr-0 d-none-580"><i class="fa fa-map-marker"></i> 60 metre street, Sulaymaniyah</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="invoice-btn-section clearfix d-print-none">
                        <a href="javascript:window.print()" class="btn btn-lg btn-print">
                            <i class="fa fa-print"></i> Print Invoice
                        </a>
                        <a id="invoice_download_btn" class="btn btn-lg btn-download btn-theme">
                            <i class="fa fa-download"></i> Download Invoice
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Invoice 6 end -->

    <script src="{{ asset('assets/print/invoic-advance/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/print/invoic-advance/assets/js/jspdf.min.js') }}"></script>
    <script src="{{ asset('assets/print/invoic-advance/assets/js/html2canvas.js') }}"></script>
    <script src="{{ asset('assets/print/invoic-advance/assets/js/app.js') }}"></script>

    <script>
        let customerName = localStorage.getItem('customerName');
        let userName = localStorage.getItem('userName');
        let dateRange = localStorage.getItem('dataRange');
        let productName = localStorage.getItem('productName');



        let invoiceToName = document.querySelector('.invoiceToName');
        let invoiceToEmail = document.querySelector('.invoiceToEmail');
        let invoiceToAddress = document.querySelector('.invoiceToAddress');
        invoiceToName.textContent = 'Customer : ' + customerName;
        invoiceToEmail.textContent = 'Email : ' + customerName;
        invoiceToAddress.textContent = 'Address : ' + customerName;

        let dateForm = document.querySelector('.inv-from-1');
        if (!dateRange) {
            dateForm.textContent = "Due Date : All Time";

        } else {
            dateForm.textContent = "Due Date : " + dateRange;
        }

        let grandTotal = document.querySelector('#grandTotal');
        let calculatedTotal = document.querySelectorAll('tbody tr td:nth-child(3)');
        let totals = 0;
        calculatedTotal.forEach(td => {
            let total = parseInt(td.textContent.trim());
            totals += total;
        });
        grandTotal.textContent = totals;
        // Function to execute after printing
        function afterPrint() {
            console.log('Print dialog closed');
            // Add your code to navigate to the previous location here
            window.location.previoce();
        }

        // Attach event listener for afterprint event
        window.onafterprint = afterPrint;
    </script>
</body>

</html>
