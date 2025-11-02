


@extends('layouts.nav')

@section('name', 'Inventory Report')
@section('custom-css')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection
@section('content')







<div class="page-wrapper page-wrapper-one">
    <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Inventory Report</h4>
                        <h6>Manage your Inventory Report</h6>
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
                                    <div class="col-lg col-sm-6 col-12 ">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="productname"
                                                placeholder="Enter Product Name">
                                        </div>
                                    </div>
                                    <div class="col-lg col-sm-6 col-12 ">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="sku"
                                                placeholder="Enter SKU">
                                        </div>
                                    </div>
                                    <div class="col-lg col-sm-6 col-12 ">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="category"
                                                placeholder="Enter Category">
                                        </div>
                                    </div> 
                                    
                                    <div class="col-lg col-sm-6 col-12 ">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="brand"
                                                placeholder="Enter brand">
                                        </div>
                                    </div>
                                    <div class="col-lg col-sm-6 col-12 ">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="unit"
                                                placeholder="Enter unit">
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
                                        <th>Product Name</th>
                                        <th>SKU</th>
                                        <th>Category</th>
                                        <th>Brand</th>
                                        <th>Price</th>
                                        <th>Unit</th>
                                        <th>Instock qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
									<tr>
										<td>
											<label class="checkboxs">
												<input type="checkbox">
												<span class="checkmarks"></span>
											</label>
										</td>
										<td class="productimgname">
											<a class="product-img">
												<img src="{{ asset('uploads/product/products/' . $product->image) }}" alt="product">
											</a>
											<a href="javascript:void(0);">{{ $product->name }}</a>
										</td>
										<td>{{ $product->sku_code }}</td>
										<td>{{ $product->category->name }}</td>
										<td>{{ $product->brand->name }}</td>
										<td><span style="color: black">$</span>{{ $product->price }}</td>
										<td>{{ $product->type->type_name }}</td>
										<td>{{ $product->quantity}}</td>
									</tr>
									@endforeach
							
                              
                                </tbody>
                            </table>
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
                var url = "InventoryPrint.html";

                // Redirect to the print.html page
                window.open(url, '_blank');
            });
        });
    </script>
    
    



    <script>
        $(document).ready(function() {
            const clearButton = $("#clear");
    
            // Add event listeners to filter inputs
            $("#productname, #sku, #category,#brand,#unit").on("keyup change",
                function() {
                    const productname = $("#productname").val().toLowerCase();
                    const sku = $("#sku").val().toLowerCase();
                    const category = $("#category").val().toLowerCase();
                    const brand = $("#brand").val().toLowerCase();
                    const unit = $("#unit").val().toLowerCase();
    
                    $("#userTable").DataTable().columns().every(function() {
                        const columnIndex = this[0][0];
                        let inputValue = "";
    
                        if (columnIndex === 1) { // Product name column index
                            inputValue = productname;
        
                        }else if (columnIndex === 4) { // Category column index
                            inputValue = brand;
                        }
                        
                        else if (columnIndex === 2) { // Brand name column index
                            inputValue = sku;
                        } else if (columnIndex === 3) { // code column index
                            inputValue = category;
                        }
                        else if (columnIndex === 6) { // code column index
                            inputValue = unit;
                        }
    
                        this.search(inputValue, true, false).draw();
                    });
                });
            clearButton.on("click", function() {
                $("#productname, #sku, #category,#brand,#unit").val(""); // Clear input values
                $("#SubCategorySelect").val(""); // Reset the selected option for SubCategorySelect
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