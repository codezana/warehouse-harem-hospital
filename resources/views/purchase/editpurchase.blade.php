@extends('layouts.nav')

@section('name', 'Edit Purchase')
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
                    <h4>Edit Purchase 🛒</h4>
                    <h6>Edit your Purchase</h6>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row" style="position: relative">
                        <form action="{{ route('update.purchase') }}" method="POST">
                            <div class="row">
                                <div class="table-responsive mb-3">
                                    <table id="item-table" class="table">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Product Name</th>
                                                <th style="display: none;">Product ID</th>
                                                <th>QTY</th>
                                                <th>Price</th>
                                                <th>Subtotal</th>
                                                <th>Receipt</th>
                                                <th>Date</th>
                                                <th style="display: none">Supplier</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($purchases as $key => $purchase)
                                                <tr class="tr">
                                                    <td>{{ $key + 1 }}</td>
                                                    <td><a>{{ $purchase->product->name }}</a></td>
                                                    <td style="display: none;">{{ $purchase->product->id }}</td>
                                                    <td style="width: 100px">
                                                        <div class="d-flex">
                                                            <a href="#" class="btn btn-secondary btn-sm"
                                                                style="background: transparent"
                                                                data-decrease-id="{{ $purchase->product->id }}"
                                                                id="decreaseOrderQuantity"><i style="vertical-align: bottom"
                                                                    class="fa fa-minus"></i>
                                                            </a>
                                                            <input type="text" id="qty" style="width: 60px"
                                                                data-id="{{ $purchase->product->id }}"
                                                                class="form-control w-60px form-control-sm mx-2 bg-white bg-opacity-25 bg-white bg-opacity-25 text-center"
                                                                value="{{ $purchase->quantity }}">
                                                            <a href="#" class="btn btn-secondary btn-sm"
                                                                data-increase-id="{{ $purchase->product->id }}"
                                                                id="increaseOrderQuantity"
                                                                style="background: transparent"><i
                                                                    style="vertical-align: bottom"
                                                                    class="fa fa-plus"></i></a>
                                                        </div>
                                                    </td>
                                                    <td class="price">{{ $purchase->purchase_price }}</td>
                                                    <td class="subTotal">{{ $purchase->total_cost }}</td>
                                                    <td style="width: 101px;"><input class="Receipts" type="text"
                                                            value="{{ $purchase->reference }}"
                                                            style="width: min-content; background: transparent;color: #97a2d2;text-align: center;border:none;">
                                                    </td>
                                                    <td>{{ $purchase->date }}</td>
                                                    <td style="display: none">{{ $purchase->supplier->id }}</td>
                                                    <td><a href="javascript:void(0);" class="delete-set"><img
                                                                src="assets/img/icons/delete.svg" alt="svg"></a></td>



                                                </tr>
                                            @endforeach








                                        </tbody>
                                    </table>
                                </div>


                                <input type="text" style="display: none" name="purchasesOrderId" id="purchasesOrderId"
                                    value="{{ $purchasesOrderId }}">
                                <input type="text" name="" style="display: none" id="receipt_sale" value="{{ $receipt }}">
                                <input type="text" name="" style="display: none" id="date_sale" value="{{ $date }}">

                                <div class="row">
                                    <div class="form-group col-lg-4">
                                        <label>Paid Dollar</label>
                                        <input type="number" value="{{ $paid }}" id="paidInput">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Shipping</label>
                                        <input type="number" value="{{ $shipping }}" name="shippingval" id="shippingval">
                                    </div>
                                    {{-- <div class="col-lg-6 col-sm-12 col-12"> --}}
                                    <div class="form-group col-lg-4">
                                        <label>Status</label>
                                        <select class="select form-control" id="statusSelect">
                                            <option {{ $status == 'Completed' ? 'selected' : '' }}>
                                                Completed</option>
                                            <option {{ $status == 'Inprogress' ? 'selected' : '' }}>
                                                Inprogress</option>
                                        </select>
                                    </div>



                                    {{-- </div> --}}
                                </div>
                                <div class="col-lg-6 ">
                                    <div class="total-order w-100 max-widthauto m-auto mb-4">
                                        <ul>
                                            <li>
                                                <h4>Dollar Price</h4>
                                                <div class="input-groupicon" style="width: 50%;">
                                                    <input id="dinar" style="text-align: right;border: none"
                                                    value="{{ $dolar }}"  type="number" placeholder="Dollar price">
                                                </div>
                                            </li>
                                            <li>
                                                <h4>Paid Dinar</h4>
                                                <h5 id="paidDinar">{{ $paid_dinar }}</h5>
                                            </li>
                                            <li>
                                                <h4>Total Dinar</h4>
                                                <h5 id="grand-total-dinar">{{ $grand_dinar }}</h5>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6 ">
                                    <div class="total-order w-100 max-widthauto m-auto mb-4">
                                        <ul>
                                            <li>
                                                <h4>Total Quantity</h4>
                                                <h5 id="quantityDisplay">0</h5>
                                            </li>
                                            <li>
                                                <h4>Paid Dollar</h4>
                                                <h5 id="paidDollar">{{ $paid }}</h5>
                                            </li>
                                            <li class="total">
                                                <h4>Total Dollar</h4>
                                                <h5 id="grand-total">$ {{ $grandTotal }}</h5>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Form contents go /addsales/storehere -->

                            <div class="col-lg-12">
                                <button type="submit" id="submit-button" class="btn btn-submit me-2">Submit</button>
                                <a href="{{ route('purchaselistpage') }}" class="btn btn-cancel" id="cancel-button">Cancel</a>
                            </div>

        



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
                        quantity: $(this).find('td:nth-child(4)').find('input[type="text"]')
                            .val(),
                        reference: $(this).find('td:nth-child(7)').find('input[type="text"]')
                            .val(),
                        total_cost: $(this).find('td:nth-child(6)').text().replace(/[$,]/g, ''),
                    };

                    tableData.push(rowData);
                });

                var grandTotalText = $('#grand-total').text().replace(/[$,]/g, '');
                var grandTotal = parseFloat(grandTotalText);
                var paid = $('#paidInput').val();
                var shippingValue = $('#shippingval').val();

                var grand_dinarText = $('#grand-total-dinar').text().replace(/[$,]/g, '');
                var grand_dinar = parseFloat(grand_dinarText);
                var paid_dinar = $('#paidDinar').text().replace(/[$,]/g, '');
                var statusSelect = document.getElementById("statusSelect");
                var selectedStatus = statusSelect.options[statusSelect.selectedIndex].text;
                var purchasesOrderId = document.getElementById("purchasesOrderId").value;

                var receipt_sale = document.getElementById("receipt_sale").value;
                var date_sale = document.getElementById("date_sale").value;
                var dolar=$('#dinar').val();

                $.ajax({
                    type: 'PUT',
                    url: '{{ route('update.purchase') }}',
                    data: {
                        tableData: tableData,
                        shippingValue: shippingValue,
                        grandTotal: grandTotal,
                        date_sale: date_sale,
                        receipt_sale: receipt_sale,
                        purchasesOrderId: purchasesOrderId,
                        paid: paid,
                        dolar:dolar,

                        grand_dinar: grand_dinar,
                        paid_dinar: paid_dinar,
                        selectedStatus: selectedStatus,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Display a customized toast notification at the top left corner
                        Toastify({
                            text: 'Purchase Updated successfully!',
                            duration: 3000,
                            gravity: 'top-left', // Position the toast notification at the top left corner
                            close: true, // Show a close button
                            backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)', // Custom background color
                            icon: '<i class="fas fa-check-circle"></i>', // Font Awesome icon for success
                            className: 'toastify-custom', // Custom CSS class for styling
                        }).showToast();

                        // Redirect to the sales list page after a delay
                        setTimeout(function() {
                            window.location.href = '{{ route('purchaselistpage') }}';
                        }, 3000); // Adjust the delay as needed
                    },
                    error: function(error) {
                        Toastify({
                                                                            text: 'Chaeck Again , Error Have',
                                                                            duration: 3000,
                                                                            gravity: 'top-left', // Position the toast notification at the top left corner
                                                                            close: true, // Show a close button
                                                                            backgroundColor: '#ff0000', // Red background color for error
                                                                            className: 'toastify-custom', // Custom CSS class for styling
                                                                        }).showToast();
                    }
                });

                $('#item-table tbody').empty();
            });
        });
    </script>




    <script>
        $(document).ready(function() {
            subTotal();
            updateTotal();
            var dollarPrice = 0; // Initialize with a default value

            function subTotal() {
                let trs = document.querySelectorAll('.tr');
                trs.forEach(tr => {
                    let subTotalElement = tr.querySelector('.subTotal');
                    let price = parseInt(tr.querySelector('.price').textContent);
                    let qty = parseInt(tr.querySelector('#qty')
                        .value);

                    let subTotal = price * qty;

                    subTotalElement.textContent = subTotal;
                });
                updateTotalDinar();
                updateTotal();
            }



            // Add an event listener to update the variable when the input changes
            document.getElementById('dinar').addEventListener('input', e => {
                var total = 0;

                $('tbody tr').each(function() {
                    var price = parseFloat($(this).find('td:nth-child(6)')
                        .text());
                    total += price;
                });
                var inputValue = parseFloat(this.value);
                let paidDollar = parseFloat(document.getElementById('paidDollar').textContent.replace('$',
                    ''));
                let paidDinar = document.getElementById('paidDinar');
                var inputValue = parseFloat($(e.target).val());
                if (!isNaN(inputValue)) {
                    dollarPrice = inputValue;
                    // Update the grand total when the dollar price changes
                    $('#grand-total-dinar').text((total * dollarPrice).toFixed(0).replace(
                        /\B(?=(\d{3})+(?!\d))/g, ","));
                    if (paidDollar > 0) {
                        paidDinar.textContent = paidDollar * inputValue;
                    } else if (paidDinar === '') {
                        paidDinar.textContent = 0;
                    } else {
                        paidDinar.textContent = 0;

                    }
                } else {
                    $('#grand-total-dinar').text(0)
                    paidDinar.textContent = 0;

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
                let quantityDisplay = document.querySelector('#quantityDisplay');
                var totalQuantity = 0;
                var total = 0;

                $('tbody tr').each(function() {
                    var price = parseFloat($(this).find('td:nth-child(6)')
                        .text()); // Assuming price is in the 5th column
                    total += price;
                });
                $('tbody tr').each(function() {
                    var quantity = parseFloat($(this).find('td:nth-child(4) input')
                        .val()); // Get the value of the input field in the 4th column
                    totalQuantity += quantity;
                });
                quantityDisplay.textContent = totalQuantity;

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
            // Add event listener for the input event on the paidDollar input
            $('#paidInput').on('input', e => {
                let paidDollar = $('#paidDollar');
                let inputValue = $(e.target).val(); // Retrieve the value of the input field
                if (inputValue > 0) {
                    paidDollar.text('$ ' + inputValue);
                } else {
                    paidDollar.text('$ 0');
                }
            });
            // Add event listener for the input event on the paidDinar input
            $('#paidInput').on('input', e => {
                let paidDollar = $('#paidDollar');
                let inputValue = $(e.target).val(); // Retrieve the value of the input field
                if (inputValue > 0) {
                    paidDollar.text('$ ' + inputValue);
                } else {
                    paidDollar.text('$ 0');
                }
            });


            $(document).on('click', '.delete-set', function() {
                $(this).closest('tr').remove(); // Remove the row
                updateTotalDinar();
                updateTotal(); // Update the total after removing a row
            });

            // Select all elements with the ID 'increaseOrderQuantity'
            let increaseOrderQuantitys = document.querySelectorAll('#increaseOrderQuantity');

            // Iterate over each selected element
            increaseOrderQuantitys.forEach(increaseOrderQuantity => {
                // Add a click event listener to each element
                increaseOrderQuantity.addEventListener('click', () => {
                    // Select all elements with the ID 'qty'
                    let QtyInputs = document.querySelectorAll('#qty');
                    // Retrieve the custom data attribute 'increaseId' from the clicked element
                    let e = increaseOrderQuantity.dataset.increaseId;

                    // Iterate over each selected 'QtyInput' element
                    QtyInputs.forEach(QtyInput => {
                        // Retrieve the custom data attribute 'id' from the 'QtyInput' element
                        let d = QtyInput.dataset.id;

                        // Check if the custom data attribute values match
                        if (e === d) {
                            // Parse the value of 'QtyInput' element to an integer
                            let qty = parseInt(QtyInput.value);

                            // Increase the quantity by 1 if it's greater than 0
                            if (qty >= 0) {
                                qty += 1;
                            } else {
                                // Show an error toast if the quantity is not greater than 0
                                Toastify({
                                    text: 'Error: Maximum quantity reached!',
                                    duration: 3000,
                                    gravity: 'top-left', // Position the toast notification at the top left corner
                                    close: true, // Show a close button
                                    backgroundColor: 'linear-gradient(to right, #FF5733, #C70039)', // Custom background color for error
                                    icon: '<i class="fas fa-exclamation-circle"></i>', // Font Awesome icon for error
                                    className: 'toastify-custom', // Custom CSS class for styling
                                }).showToast();
                            }

                            // Update the value of 'QtyInput' element
                            QtyInput.value = qty;

                            // Call the 'subTotal' function if needed
                            subTotal();
                        }
                    });
                });
            });
            let decreaseOrderQuantitys = document.querySelectorAll('#decreaseOrderQuantity');

            // Iterate over each selected element
            decreaseOrderQuantitys.forEach(decreaseOrderQuantity => {
                // Add a click event listener to each element
                decreaseOrderQuantity.addEventListener('click', () => {
                    // Select all elements with the ID 'qty'
                    let QtyInputs = document.querySelectorAll('#qty');
                    // Retrieve the custom data attribute 'increaseId' from the clicked element
                    let e = decreaseOrderQuantity.dataset.decreaseId;

                    // Iterate over each selected 'QtyInput' element
                    QtyInputs.forEach(QtyInput => {
                        // Retrieve the custom data attribute 'id' from the 'QtyInput' element
                        let d = QtyInput.dataset.id;

                        // Check if the custom data attribute values match
                        if (e === d) {
                            // Parse the value of 'QtyInput' element to an integer
                            let qty = parseInt(QtyInput.value);


                            // Increase the quantity by 1 if it's greater than 0
                            if (qty > 0) {
                                qty -= 1;
                            } else {
                                // Show an error toast if the quantity is not greater than 0
                                Toastify({
                                    text: 'Error: Maximum quantity reached!',
                                    duration: 3000,
                                    gravity: 'top-left', // Position the toast notification at the top left corner
                                    close: true, // Show a close button
                                    backgroundColor: 'linear-gradient(to right, #FF5733, #C70039)', // Custom background color for error
                                    icon: '<i class="fas fa-exclamation-circle"></i>', // Font Awesome icon for error
                                    className: 'toastify-custom', // Custom CSS class for styling
                                }).showToast();
                            }

                            // Update the value of 'QtyInput' element
                            QtyInput.value = qty;

                            // Call the 'subTotal' function if needed
                            subTotal();
                        }
                    });
                });
            });

            let QtyInputs = document.querySelectorAll('#qty');
            // Iterate over each selected 'QtyInput' element
            QtyInputs.forEach(QtyInput => {
                QtyInput.addEventListener('input', () => {
                    subTotal();
                });
            });

        });
    </script>


    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/plugins/select2/js/select2.min.js"></script>

    <script src="assets/js/feather.min.js"></script>

    <script src="assets/js/jquery.slimscroll.min.js"></script>



@endsection
