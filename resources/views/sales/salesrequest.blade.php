@extends('layouts.nav')

@section('name', 'Sales Requests')
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>









@endsection
@section('content')

    <style>
        .custom-select {
            position: relative;
            width: 200px;
            border: 1px solid #ccc;
            padding: 5px;
            cursor: pointer;
        }

        .select-header {
            background-color: #f5f5f5;
            padding: 5px;
        }

        .options {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            width: 100%;
        }

        .option {
            padding: 5px;
            cursor: pointer;
        }

        .option:hover {
            background-color: #f0f0f0;
        }

        body[data-theme="dark"] .select2-search--dropdown {
            background: #1d1d42ff;
        }

        body[data-theme="dark"] .select2-search__field {
            background: #1d1d42ff;
            color: white;
            border: none;
        }

        .form-group input[type="number"],
        input[type="number"],
        .form-group input[type="password"],
        input[type="text"] {
            border: 1px solid rgba(145, 158, 171, 0.32);
            height: 40px;
            width: 100%;
            font-size: 14px;
            font-weight: 500;
            color: #637381;
            padding: 10px 15px;
            border-radius: 5px;
        }

        body[data-theme="dark"] .form-group input[type="number"],
        body[data-theme="dark"] input[type="number"] {
            background: #1d1d42 !important;
            color: #97a2d2;
        }

        /* Hide the increase and decrease buttons */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }


        td,
        th {
            text-align: center
        }
    </style>


    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Sales Request 🛒</h4>
                    <h6>Add your new sale</h6>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row" style="position: relative">
                        <form action="{{ route('store_requests') }}" method="POST">
                            <div class="row">
                                <div class="table-responsive mb-3">
                                    <table id="item-table" class="table">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Product Name</th>
                                                <th style="display: none;">Product ID</th>
                                                <th>Size</th>
                                                <th>QTY</th>
                                                <th>Price</th>
                                                <th>Subtotal</th>
                                                <th>Receipt</th>
                                                <th>Date</th>
                                                <th style="display: none">Customer</th>
                                                <th style="display: none">request id</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>



                                            @foreach ($orders as $key => $order)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td><a>{{ $order->product->name }}</a></td>
                                                    <td style="display: none;">{{ $order->product_id }}</td>
                                                    <td>{{ $order->size->name }}</td>
                                                    <td style="display: flex; justify-content: center; border-top: none;">
                                                        <div class="d-flex">
                                                            <h6 class="quantitys" style="display: none">
                                                                {{ $order->product->quantity }}</h6>
                                                            <a style="background: transparent"
                                                                class="decrease-button btn btn-secondary btn-sm"><i
                                                                    style="vertical-align: bottom;"
                                                                    class="fa fa-minus"></i></a>
                                                            <input type="number"
                                                                style="width: 60px; background: transparent;color: #97a2d2;text-align: center;border:none;"
                                                                id="qty" class="form-control-sm text-center"
                                                                value="{{ $order->qty }}">
                                                            <a style="background: transparent"
                                                                class="increase-button btn btn-secondary btn-sm"><i
                                                                    style="vertical-align: bottom;"
                                                                    class="fa fa-plus"></i></a>
                                                        </div>
                                                    </td>
                                                    <td class="prices">{{ $order->product->sale }}</td>
                                                    <td id="subTotal">{{ $order->product->sale * $order->qty }}</td>
                                                    <td><input class="Receipts" type="text"
                                                            style="background: transparent;color: #97a2d2;text-align: center;border:none;"
                                                            value="{{ $order->receipt }}"></td>
                                                    <td>{{ $order->created_at->toDateString() }}</td>
                                                    <td style="display: none">{{ $order->customer_id }}</td>
                                                    <td style="display: none;">{{ $order->request_id }}</td>
                                                    <td><a href="javascript:void(0);" class="delete-set"><img
                                                                src="assets/img/icons/delete.svg" alt="svg"></a></td>



                                                </tr>
                                            @endforeach





                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Shipping</label>
                                        <input type="number" id="shippingInput">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select id="statusSelect" class="select">
                                            {{-- <option>Choose Status</option> --}}
                                            <option>Completed</option>
                                            <option selected>Inprogress</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 ">
                                    <div class="total-order w-100 max-widthauto m-auto mb-4">
                                        <ul>
                                            <li>
                                                <h4>Dollar Price</h4>
                                                <div class="input-groupicon" style="width: 50%;">
                                                    <input id="dinar" style="text-align: right;border: none"
                                                        type="number" placeholder="Dollar price">
                                                </div>
                                            </li>
                                            <li>
                                                <h4>Total Dinar</h4>
                                                <h5 id="grand-total-dinar">0</h5>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6 ">
                                    <div class="total-order w-100 max-widthauto m-auto mb-4">
                                        <ul>
                                            <li>
                                                <h4>Total Quantity</h4>
                                                <h5 id="sDisplay">0</h5>
                                            </li>
                                            <li class="total">
                                                <h4>Total Dollar</h4>
                                                <h5 id="grand-total">$ 0.00</h5>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Form contents go /addsales/storehere -->

                            <div class="col-lg-12">
                                <button type="submit" id="submit-button" class="btn btn-submit me-2">Submit</button>
                                <a href="javascript:void(0);" class="btn btn-cancel" id="cancel-button">Cancel</a>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $('#cancel-button').click(function() {
                                        // Get the request_id from the URL
                                        var urlParams = new URLSearchParams(window.location.search);
                                        var request_id = urlParams.get('request_id');

                                        // Send an AJAX request to update the is_active column to 0
                                        $.ajax({
                                            type: 'POST', // Change the method to POST
                                            url: '{{ route('update_order_records') }}', // Change the route to the appropriate route for updating records
                                            data: {
                                                request_id: request_id,
                                                _token: '{{ csrf_token() }}'
                                            },
                                            success: function(response) {

                                                window.location.href = '{{ route('dashboard') }}';

                                            },
                                            error: function(error) {
                                                console.error('Error updating records:', error);
                                            }
                                        });
                                    });
                                });
                            </script>





                        </form>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                $('.select2').select2();
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('custom-js')





    <script>
        let receipts = document.querySelectorAll('.Receipts');
        receipts.forEach(receipt => {
            receipt.addEventListener('input', (e) => {
                let inputValue = e.target.value;
                receipts.forEach(other => {
                    other.value = inputValue;
                });
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            $('#submit-button').click(function(event) {
                event.preventDefault(); // Prevent the default form submission

                var tableData = [];

                $('#item-table tbody tr').each(function() {
                    var rowData = {
                        product_id: $(this).find('td:nth-child(3)').text(),
                        size: $(this).find('td:nth-child(4)').text(),
                        quantity: $(this).find('input#qty')
                    .val(), // Select input field within current row
                        price: parseFloat($(this).find('td:nth-child(6)').text()),
                        subtotal: parseFloat($(this).find('td:nth-child(7)').text().replace('$',
                            '')), // Remove $ symbol
                        receipt: $(this).find('input.Receipts').val(),
                        date: $(this).find('td:nth-child(9)').text(),
                        customer_id: $(this).find('td:nth-child(10)').text(),
                        request_id: $(this).find('td:nth-child(11)').text()
                    };
                    console.log('sub   :', rowData.subtotal);
                    // Parse numeric data
                    rowData.quantity = parseInt(rowData.quantity);
                    rowData.price = parseFloat(rowData.price);
                    rowData.subtotal = parseFloat(rowData.subtotal);

                    tableData.push(rowData);
                });
                console.log('Table Data:', tableData);

                var grandTotalDinar = $('#grand-total-dinar').text().replace(/,/g, '');
                var grandTotalDollarText = $('#grand-total').text().replace('$', '').replace(/,/g, '');
                var grandTotalDollar = parseFloat(grandTotalDollarText);

                var shipping = $('#shippingInput').val(); // Get the shipping value
                var status = $('#statusSelect').val(); // Get the status value
                var dolar = $('#dinar').val();


                $.ajax({
                    type: 'POST',
                    url: '{{ route('store_requests') }}',
                    data: {
                        tableData: tableData,
                        grandTotalDinar: grandTotalDinar,
                        grandTotalDollar: grandTotalDollar,
                        shipping: shipping,
                        status: status,
                        dolar: dolar,

                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Display a customized toast notification at the top left corner
                        Toastify({
                            text: 'Request stored successfully !',
                            duration: 3000,
                            gravity: 'top-left', // Position the toast notification at the top left corner
                            close: true, // Show a close button
                            backgroundColor: 'linear-gradient(to right, #01919C, #2B2B2B)', // Custom background color
                            className: 'toastify-custom', // Custom CSS class for styling
                        }).showToast();

                        // Redirect to the sales list page after a delay
                        setTimeout(function() {
                            window.location.href = '{{ route('saleslist.page') }}';
                        }, 1000); // Adjust the delay as needed
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });

                $('#item-table tbody').empty();
            });

            // Your other JavaScript code goes here...
        });
    </script>



    <script>
        updateTotal();
        var dollarPrice = 0; // Initialize with a default value

        // Add an event listener to update the variable when the input changes
        document.getElementById('dinar').addEventListener('input', function() {
            var total = 0;

            $('tbody tr').each(function() {
                var price = parseFloat($(this).find('td:nth-child(6)')
                    .text());
                total += price;
            });
            var inputValue = parseFloat(this.value);
            if (!isNaN(inputValue)) {
                dollarPrice = inputValue;
                // Update the grand total when the dollar price changes
                $('#grand-total-dinar').text((total * dollarPrice).toFixed(0).replace(
                    /\B(?=(\d{3})+(?!\d))/g, ","));
            } else {
                $('#grand-total-dinar').text(0)
            }
        });
        var total = 0;

        function updateTotalDinar() {
            var total = 0;
            var shipping = parseFloat($('#shippingInput').val()) || 0;

            $('tbody tr').each(function() {
                var price = parseFloat($(this).find('td:nth-child(6)')
                    .text());
                total += price;
            });
            var inputValue = document.getElementById('dinar').value;
            if (!isNaN(inputValue)) {
                dollarPrice = inputValue;
                total += shipping;
                // Update the grand total when the dollar price changes
                $('#grand-total-dinar').text((total * dollarPrice).toFixed(0).replace(
                    /\B(?=(\d{3})+(?!\d))/g, ","));
            } else {
                $('#grand-total-dinar').text(0)
            }
        };

        function updateTotal() {
            let sDisplay = document.querySelector('#sDisplay');
            var totals = 0;
            var total = 0;

            $('tbody tr').each(function() {
                var price = parseFloat($(this).find('td:nth-child(6)')
                    .text()); // Assuming price is in the 5th column
                total += price;
            });
            // Calculate total quantity
            $('tbody tr').each(function() {
                var s = parseFloat($(this).find('input#qty').val()); // Parse input value as float
                totals += s;
            });

            sDisplay.textContent = totals;

            var shipping = parseFloat($('#shippingInput').val()) ||
                0; // Get the shipping value, default to 0 if not a valid number
            var grandTotal = total + shipping;

            $('#grand-total').text('$ ' + grandTotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        }

        // Add event listener for the change event on the shipping input
        $('#shippingInput').on('input', function() {
            updateTotalDinar();
            updateTotal();
        });

        $(document).on('click', '.delete-set', function() {
            $(this).closest('tr').remove(); // Remove the row
            updateTotalDinar();
            updateTotal(); // Update the total after removing a row
        });



        let decreaseButton = document.querySelectorAll('.decrease-button');
        decreaseButton.forEach(decrease => {
            decrease.addEventListener('click', () => {

                // Find the input field containing the s value
                let qtyInput = decrease.parentNode.querySelector('input[type="number"]');

                // Ensure that the input field is found
                if (qtyInput) {
                    // Get the current s value
                    let currentQty = parseInt(qtyInput.value);

                    // Decrease the s by 1, ensuring it doesn't go below 0
                    let newQty = Math.max(currentQty - 1, 1);

                    // Update the input field with the new s value
                    qtyInput.value = newQty;
                } else {
                    console.error('s input field not found.');
                }

                updateTotal();
                subTotal()
            })
        })
        let increaseButton = document.querySelectorAll('.increase-button');
        increaseButton.forEach(increase => {
            increase.addEventListener('click', () => {

                // Find the input field containing the s value
                let qtyInput = increase.parentNode.querySelector('input[type="number"]');
                let maxQuantity = parseInt(increase.parentNode.querySelector('.quantitys').textContent);

                // Ensure that the input field is found
                if (qtyInput) {
                    // Get the current s value
                    let currentQty = parseInt(qtyInput.value);

                    // Decrease the s by 1, ensuring it doesn't go below 0
                    let newQty = Math.min(currentQty + 1, maxQuantity);

                    // Update the input field with the new s value
                    qtyInput.value = newQty;
                } else {
                    console.error('s input field not found.');
                }

                updateTotal();
                subTotal()
            })
        })
        let changeQuantity = document.querySelectorAll('#qty');
        changeQuantity.forEach(quantity => {
            quantity.addEventListener('input', () => {
                let maxQuantity = parseInt(quantity.parentNode.querySelector('.quantitys').textContent);
                if (quantity.value >= 0) {
                    let currentQty = parseInt(quantity.value);

                    let newQty = Math.min(Math.max(currentQty, 1), maxQuantity);

                    quantity.value = newQty;
                } else if (quantity.value < 0) {
                    let currentQty = parseInt(quantity.value);

                    let newQty = Math.max(currentQty, 0);

                    quantity.value = newQty;
                }
                subTotal()
            })

        })

        function subTotal() {
            let trs = document.querySelectorAll('#item-table tbody tr');
            let total = document.querySelector('#grand-total');
            let totals = 0;
            trs.forEach(tr => {
                let subTotal = 0;
                let subtotals = tr.querySelector('#subTotal');
                let quantity = parseInt(tr.querySelector('#qty').value)
                let price = parseInt(tr.querySelector('.prices').textContent.replace('.00', '').trim())
                if (quantity && price) {
                    subTotal += quantity * price;
                    totals += quantity * price;
                    total.textContent = '$ ' + totals.toFixed(2);
                    subtotals.textContent = '$ ' + subTotal.toFixed(2);
                } else {
                    subtotals.textContent = '$ 0.00';

                }
            })
        }
        subTotal()
    </script>


    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/plugins/select2/js/select2.min.js"></script>

    <script src="assets/js/feather.min.js"></script>

    <script src="assets/js/jquery.slimscroll.min.js"></script>



@endsection
