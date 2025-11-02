


@extends('layouts.nav')

@section('name', 'Sales Report')
@section('custom-css')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">
@endsection
@section('content')




<div class="page-wrapper page-wrapper-one">
	<div class="content">
				<div class="page-header">
					<div class="page-title">
						<h4>Sales Report</h4>
						<h6>Manage your Sales Report</h6>
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
										<a id="print-button" data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
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
											<input type="text" placeholder="Enter product Name" id="productname">
										</div>
									</div>
									<div class="col-lg col-sm-6 col-12">
										<div class="form-group">
											<input type="text" placeholder="Enter SKU" id="SKU">
										</div>
									</div>
									<div class="col-lg col-sm-6 col-12">
										<div class="form-group">
											<input type="text" placeholder="Category" id="category">
										</div>
									</div>
									<div class="col-lg col-sm-6 col-12">
										<div class="form-group">
											<input type="text" placeholder="Brand" id="brand">
										</div>
									</div>

									<div class="col-lg col-sm-6 col-12">
										<div class="form-group">
											<input type="text" class="datetimepicker cal-icon" placeholder="Choose Date" id="Date">
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
										<th>SKU</th>
										<th>Category</th>
										<th>Brand</th>
										<th>Sold amount</th>
										<th>Sold amount IQD</th>
										<th>Sold SKU</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>


									@foreach ($sales as $sale)
									<tr>
										<td>
											<label class="checkboxs">
												<input type="checkbox">
												<span class="checkmarks"></span>
											</label>
										</td>
										<td class="productimgname">
											<a class="product-img">
												<img src="{{ asset('uploads/product/products/' . $sale->product->image) }}" alt="product">
											</a>
											<a href="javascript:void(0);">{{ $sale->product->name }}</a>
										</td>
										<td>{{ $sale->product->sku_code }}</td>
										<td>{{ $sale->product->category->name }}</td>
										<td>{{ $sale->product->brand->name }}</td>
										<td><span style="color: black">$</span>{{ $sale->salesOrder->total_dollar }}</td>
										<td>{{ $sale->salesOrder->total_dinar }}<span style="color: black"> IQD</span></td>

										<td>{{ $sale->quantity }}</td>
										<td>{{ $sale->created_at->format('Y-m-d') }}</td>
									</tr>
									@endforeach
							
							
								</tbody>
							</table>
						</div>
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
                var url = "SalesPrint.html";

                // Redirect to the print.html page
                window.open(url, '_blank');
            });
        });
    </script>
    
    
    




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

                        if (columnIndex === 8) { // Product name column index
                            inputValue = rtldate;
                        } 


                        this.search(inputValue, true, false).draw();
                    });
                });
               

                $("#productname,#SKU,#category,#brand").on("keyup change",
                function() {
                    const productname = $("#productname").val().toLowerCase();
                    const SKU = $("#SKU").val().toLowerCase();
                    const category = $("#category").val().toLowerCase();
                    const brand = $("#brand").val().toLowerCase();
                   
                    $("#userTable").DataTable().columns().every(function() {
                        const columnIndex = this[0][0];
                        let inputValue = "";

                        if (columnIndex === 1) { // Product name column index
                            inputValue = productname;
                        } else if(columnIndex === 2){
                            inputValue = SKU;

                        }else if(columnIndex === 3){
                            inputValue = category;

                        }else if(columnIndex === 4){
                            inputValue = brand;

                        }


                        this.search(inputValue, true, false).draw();
                    });
                });







            clearButton.on("click", function() {
                $("#Date,#productname,#SKU,#category,#brand").val(
                    ""); // Clear input values
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
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>


    
    @endsection