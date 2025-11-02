@extends('layouts.nav')

@section('name', 'Invoice Report')
@section('custom-css')
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/harem.png') }}">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
        .clickable {
            cursor: pointer;
        }

        .clickable:hover {
            background-color: #f0f0f0;
            /* Add hover effect */
        }
    </style>
@endsection
@section('content')


    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Advanced Report 🪖 </h4>
                    <h6>Manage your System Report</h6>

                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <!-- --------------------------- -->
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Customer & Supplier & Requests</label>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <select id="customersAndSuppliers" class="customersAndSuppliers">
                                            <option></option>
                                            <option value="All">All</option>
                                            @foreach ($contacts as $contact)
                                                <option value="{{ $contact['id'] }}">{{ $contact['name'] }}
                                                    ({{ $contact['type'] }})
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Users </label>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <select id="users" class="users">
                                            <option></option>
                                            <option value="All">All</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->username }}</option>
                                            @endforeach
                                        </select>


                                    </div>

                                </div>
                            </div>

                            <!-- Modal -->

                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Date Range</label>
                                <div class="input-groupicon">
                                    <input id="dates" type="text" name="datefilter" value="" />
                                    <script type="text/javascript">
                                        $(function() {

                                            $('input[name="datefilter"]').daterangepicker({
                                                autoUpdateInput: false,
                                                locale: {
                                                    cancelLabel: 'Clear'
                                                }
                                            });

                                            $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
                                                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                                                    'MM/DD/YYYY'));
                                            });

                                            $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
                                                $(this).val('');
                                            });

                                        });
                                    </script>
                                    <div class="addonset">
                                        <img src="assets/img/icons/calendars.svg" alt="img">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Products </label>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <select id="products" class="Products">
                                            <option></option>
                                            <option value="All">All</option>

                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach



                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12" id="purchaseSection">
                            <div class="dash-widget dash0 clickable">
                                <div class="dash-widgetimg">
                                    <span><img src="assets/img/icons/handdue.svg" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5><span class="counters">Purchase</span></h5>
                                    <h6>Report Purchased</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12" id="salesSection">
                            <div class="dash-widget dash1 clickable">
                                <div class="dash-widgetimg">
                                    <span><img src="assets/img/icons/sold.svg" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5><span class="counters">Sales</span></h5>
                                    <h6>Report Sold</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12" id="soldproduct">
                            <div class="dash-widget dash2 clickable">
                                <div class="dash-widgetimg">
                                    <span><img src="assets/img/icons/qty.svg" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5><span class="counters">Products Sold</span></h5>
                                    <h6>Report Quantity Sold</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12" id="purchaseQtySection">
                            <div class="dash-widget dash3 clickable">
                                <div class="dash-widgetimg dash3">
                                    <span><img src="assets/img/icons/qtypurchase.svg" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5><span class="counters">Products Purchase</span></h5>
                                    <h6>Report Quantity Purchased</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom-js')
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="assets/plugins/select2/js/select2.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


    <script src="assets/js/jquery.slimscroll.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#purchaseSection').click(function() {
                var customersAndSuppliers = $('#customersAndSuppliers').val();
                var users = $('#users').val();
                var dateRange = $('#dates').val();
                var products = $('#products').val();

                if (dateRange == '') {
                    showNotification('Please choose a Date Range!');
                    return;
                }

                if (customersAndSuppliers == '' || users == '' || products == '') {
                    showNotification('Please choose at least one!');
                    return;
                }
                // Check if the selected contact type is a supplier
                var selectedOptionText = $('#customersAndSuppliers option:selected').text();
                if (selectedOptionText.toLowerCase() !== 'all') {
                    if (selectedOptionText.indexOf('(') !== -1 && selectedOptionText.indexOf(')') !== -1) {
                        var contactType = selectedOptionText.split('(')[1].split(')')[0].trim();
                        if (contactType != 'Supplier') {
                            showNotification('Please select a supplier, not a customer!');
                            return;
                        }
                    } else {
                        showNotification('Please select a valid option!');
                        return;
                    }
                }


                $.ajax({
                    url: '{{ route('purchase.advanced') }}',
                    type: 'POST',
                    data: {
                        customersAndSuppliers: customersAndSuppliers,
                        users: users,
                        dateRange: dateRange,
                        products: products,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Handle the response, e.g., update the DOM with the filtered data
                        window.location.href = '{{ route('purchase.invoice') }}';
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        if (xhr.status === 404) {
                            showNotification('No filtered sales found. Please try again.');
                        } else {
                            showNotification(
                                'An error occurred while processing your request. Please try again later.'
                                );
                            console.error(xhr.responseText);
                        }
                    }
                });
            });

            function showNotification(message) {
                Toastify({
                    text: message,
                    duration: 3000,
                    gravity: 'top-left',
                    close: true,
                    backgroundColor: 'linear-gradient(to right, #600411, #34161d)',
                    className: 'toastify-custom',
                }).showToast();
            }
        });
    </script>

    {{-- 2 --}}
    <script>
        $(document).ready(function() {
            $('#salesSection').click(function() {
                var customers = $('#customersAndSuppliers').val();
                var usersale = $('#users').val();
                var dateRangesale = $('#dates').val();
                var productsale = $('#products').val();

                if (dateRangesale == '') {
                    showNotification('Please choose a Date Range!');
                    return;
                }

                if (customers == '' || usersale == '' || productsale == '') {
                    showNotification('Please choose at least one!');
                    return;
                }
                // Check if the selected contact type is a Customer
                var selectedOptionText = $('#customersAndSuppliers option:selected').text();
                if (selectedOptionText.toLowerCase() !== 'all') {
                    if (selectedOptionText.indexOf('(') !== -1 && selectedOptionText.indexOf(')') !== -1) {
                        var contactType = selectedOptionText.split('(')[1].split(')')[0].trim();
                        if (contactType != 'Customer' && contactType != 'Requests') {
                            showNotification('Please select a Customer or Requests, not a Supplier!');
                            return;
                        }

                    } else {
                        showNotification('Please select a valid option!');
                        return;
                    }
                }


                $.ajax({
                    url: '{{ route('sales.advanced') }}',
                    type: 'POST',
                    data: {
                        customers: customers,
                        users: usersale,
                        dateRange: dateRangesale,
                        products: productsale,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Handle the response, e.g., update the DOM with the filtered data
                        if (response.length > 0) {
                            // Filtered sales found, redirect to the invoice sales page
                            window.location.href = '{{ route('sales.invoice') }}';
                        } else {
                            // No filtered sales found, display the message
                            showNotification('No filtered Sales found.');
                        }
                    },
                    error: function(xhr, status, error) {

                        if (xhr.status === 404) {
                            showNotification('No filtered sales found. Please try again.');
                        } else {
                            showNotification(
                                'An error occurred while processing your request. Please try again later.'
                                );
                            console.error(xhr.responseText);
                        }
                    }
                });
            });

            function showNotification(message) {
                Toastify({
                    text: message,
                    duration: 3000,
                    gravity: 'top-left',
                    close: true,
                    backgroundColor: 'linear-gradient(to right, #600411, #34161d)',
                    className: 'toastify-custom',
                }).showToast();
            }
        });
    </script>

 {{-- 3 --}}
 <script>
	$(document).ready(function() {
		$('#soldproduct').click(function() {
			var customers = $('#customersAndSuppliers').val();
			var usersale = $('#users').val();
			var dateRangesale = $('#dates').val();
			var productsale = $('#products').val();

			if (dateRangesale == '') {
				showNotification('Please choose a Date Range!');
				return;
			}

			if (customers == '' || usersale == '' || productsale == '') {
				showNotification('Please choose at least one!');
				return;
			}
			// Check if the selected contact type is a Customer
			var selectedOptionText = $('#customersAndSuppliers option:selected').text();
			if (selectedOptionText.toLowerCase() !== 'all') {
				if (selectedOptionText.indexOf('(') !== -1 && selectedOptionText.indexOf(')') !== -1) {
					var contactType = selectedOptionText.split('(')[1].split(')')[0].trim();
					if (contactType != 'Customer' && contactType != 'Requests') {
						showNotification('Please select a Customer or Requests, not a Supplier!');
						return;
					}

				} else {
					showNotification('Please select a valid option!');
					return;
				}
			}


			$.ajax({
				url: '{{ route('sold.advanced') }}',
				type: 'POST',
				data: {
					customers: customers,
					users: usersale,
					dateRange: dateRangesale,
					products: productsale,
					_token: '{{ csrf_token() }}'
				},
				success: function(response) {
					// Handle the response, e.g., update the DOM with the filtered data
					if (response.length > 0) {
						// Filtered sold found, redirect to the invoice sold page
						window.location.href = '{{ route('sold.invoice') }}';
					} else {
						// No filtered sold found, display the message
						showNotification('No filtered sold found.');
					}
				},
				error: function(xhr, status, error) {

					if (xhr.status === 404) {
						showNotification('No filtered sold found. Please try again.');
					} else {
						showNotification(
							'An error occurred while processing your request. Please try again later.'
							);
						console.error(xhr.responseText);
					}
				}
			});
		});

		function showNotification(message) {
			Toastify({
				text: message,
				duration: 3000,
				gravity: 'top-left',
				close: true,
				backgroundColor: 'linear-gradient(to right, #600411, #34161d)',
				className: 'toastify-custom',
			}).showToast();
		}
	});
</script>
{{-- 4 --}}

<script>
    $(document).ready(function() {
        $('#purchaseQtySection').click(function() {
            var suppliers = $('#customersAndSuppliers').val();
            var usersqty = $('#users').val();
            var dateRangeqty = $('#dates').val();
            var productsqty = $('#products').val();

            if (dateRangeqty == '') {
                showNotification('Please choose a Date Range!');
                return;
            }

            if (suppliers == '' || usersqty == '' || productsqty == '') {
                showNotification('Please choose at least one!');
                return;
            }
            // Check if the selected contact type is a supplier
            var selectedOptionText = $('#customersAndSuppliers option:selected').text();
            if (selectedOptionText.toLowerCase() !== 'all') {
                if (selectedOptionText.indexOf('(') !== -1 && selectedOptionText.indexOf(')') !== -1) {
                    var contactType = selectedOptionText.split('(')[1].split(')')[0].trim();
                    if (contactType != 'Supplier') {
                        showNotification('Please select a supplier, not a customer!');
                        return;
                    }
                } else {
                    showNotification('Please select a valid option!');
                    return;
                }
            }


            $.ajax({
                url: '{{ route('qty.advanced') }}',
                type: 'POST',
                data: {
                    suppliers: suppliers,
                    users: usersqty,
                    dateRange: dateRangeqty,
                    products: productsqty,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Handle the response, e.g., update the DOM with the filtered data
                    window.location.href = '{{ route('qty.invoice') }}';
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    if (xhr.status === 404) {
                        showNotification('No filtered sales found. Please try again.');
                    } else {
                        showNotification(
                            'An error occurred while processing your request. Please try again later.'
                            );
                        console.error(xhr.responseText);
                    }
                }
            });
        });

        function showNotification(message) {
            Toastify({
                text: message,
                duration: 3000,
                gravity: 'top-left',
                close: true,
                backgroundColor: 'linear-gradient(to right, #600411, #34161d)',
                className: 'toastify-custom',
            }).showToast();
        }
    });
</script>







    <script>
        localStorage.removeItem('customerName');
        localStorage.removeItem('userName');
        localStorage.removeItem('dateRange');
        localStorage.removeItem('ProductName');

        let customerName;
        let userName;
        let dateRange;
        let productName;
        setTimeout(() => {
            $(document).ready(function() {
                $(".customersAndSuppliers").select2({
                    placeholder: "Select a state",
                    allowClear: true,
                    templateSelection: customerNames,
                });
                $(".users").select2({
                    placeholder: "Select a user",
                    allowClear: true,
                    templateSelection: usersNames,

                });
                $(".Products").select2({
                    placeholder: "Select a Products",
                    allowClear: true,
                    templateSelection: prodctNames,

                });
            });
            let customersOrSuppliers = document.querySelector('#select2-customersAndSuppliers-container');
            let customers = document.querySelector('#customersAndSuppliers');
            let users = document.getElementById('users');
            let dates = document.getElementById('dates');

            let products = document.getElementById('products');
            let applayButton = document.querySelector('.applyBtn');
            // window.addEventListener('click', (event) => {
            //     // console.log(event.target.textContent)
            //     console.log(customersOrSuppliers)
            // })
            function customerNames(data) {
                customerName = data.text;
                localStorage.setItem('customerName', customerName);
                return data.text
            }


            function usersNames(data) {
                userName = data.text;
                localStorage.setItem('userName', userName);

                return data.text
            }
            applayButton.addEventListener('click', () => {
                setTimeout(() => {
                    dateRange = dates.value
                    localStorage.setItem('dataRange', dateRange);
                }, 100);
            })

            function prodctNames(data) {
                productName = data.text;
                localStorage.setItem('productName', productName);

                return data.text
            }
        }, 100);
    </script>





@endsection
