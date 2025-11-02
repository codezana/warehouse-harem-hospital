    // {{-- show elements by category --}}

    document.addEventListener("DOMContentLoaded", function () {
        var categoryItems = document.querySelectorAll(".pos-category li");

        categoryItems.forEach(function (item) {
            item.addEventListener("click", function () {
                // Remove 'active' class from all category items
                categoryItems.forEach(function (item) {
                    if (item.classList.contains("clicked")) {
                        item.classList.remove("active");
                    } else {
                        item.classList.remove("active");
                    }
                });

                // Add 'active' class to the clicked category item
                this.classList.add("active");
                if (!this.classList.contains("clicked")) {
                    this.classList.add("clicked");
                }

                let clicked = this.classList.contains("clicked");
                // Get the value of data-tab attribute as integer
                var tab = parseInt(this.getAttribute("data-tab"));

                // Hide all product items
                var products = document.querySelectorAll(".product");
                products.forEach(function (product) {
                    // Compare data-tab attribute value with tab
                    if (
                        parseInt(product.getAttribute("data-tab")) === tab &&
                        clicked
                    ) {
                        product.style.display = "block";
                    } else if (!clicked) {
                        product.style.display = "block";
                    } else {
                        product.style.display = "none";
                    }
                });
            });
        });
    });

    // {{-- seraching for element --}}

    let searchInput = document.querySelector("#barcodeInput");
    let infos = document.querySelectorAll(".pro");

    searchInput.addEventListener("input", (e) => {
        let inputValue = e.target.value.toLowerCase(); // Get the input value and convert it to lowercase for case-insensitive comparison
        infos.forEach((info) => {
            let title = info.querySelector(".cat-name a");
            let barcode = info.querySelector(".barcode");
            if (
                title.textContent.toLowerCase().includes(inputValue) ||
                barcode.textContent.toLowerCase().includes(inputValue)
            ) {
                title.parentNode.parentNode.parentNode.style.display = "block";
            } else {
                title.parentNode.parentNode.parentNode.style.display = "none";
            }
        });
    });

    // {{-- add elements to selling list --}}

    let orderItems = [];
    var products = document.querySelectorAll(".product-info");
    let prouduct_wrap = document.querySelector("#product-wrap");
    products.forEach(function (product) {
        product.addEventListener("click", () => {
            let img = "";
            img =
                img ||
                (product.querySelector(".img-bg img") ?
                    product.querySelector(".img-bg img").src :
                    "");
            let name = product.querySelector(".cat-name a").textContent;
            let quantity = product.querySelector(".quantity").textContent;
            let price = parseFloat(
                product.querySelector("#price").textContent.replace("$", "")
            );
            addToOrder(img, name, quantity, price);
        });
    });

    // add items to array
    function addToOrder(img, name, quantity, price) {
        if (orderItems.some((item) => item.names === name)) {
            let productActive = document.querySelectorAll(".pro");
            productActive.forEach((product) => {
                let namee = product.querySelector(".cat-name a").textContent;
                if (namee === name) {
                    setTimeout(() => {
                        product.classList.add("active");
                    }, 200);
                }
            });

            Toastify({
                text: "Item already added",
                position: "bottom-right",
                duration: 2000,
                gravity: "top-left", // Position the toast notification at the top left corner
                close: true, // Show a close button
                backgroundColor: "linear-gradient(to right, #910d06, #44160f)", // Custom background color
                icon: '<i class="fas fa-check-circle"></i>', // Font Awesome icon for success
                className: "toastify-custom", // Custom CSS class for styling
            }).showToast();
            return; // Exit the function if the item already exists
        }

        var items = {
            image: img,
            names: name,
            quantitys: quantity,
            prices: price.toFixed(2),
        };

        let html = "";
        orderItems.push(items);
        orderItem();
    }
    // add items to order
    function orderItem() {
        let count = document.querySelector(".count");
        count.textContent = orderItems.length;
        if (orderItems.length > 0) {
            let orderQuantity = document.querySelectorAll(".product-order") || "";
            if (orderQuantity.length > 0) {
                orderQuantity.forEach((order, index) => {
                    let quantity =
                        parseInt(order.querySelector(".orderQuantity").value) || "";
                    if (orderItems[index]) {
                        orderItems[index].Qty = quantity; // Assign quantity to the corresponding order item
                    }
                });
            }
            prouduct_wrap.innerHTML = "";
            orderItems.forEach((item) => {
                html = `<div class="product-order product-list d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center product-info" data-bs-toggle="modal1"
                                data-bs-target="#products1">
                                <a  class="img-bg" style="overflow:hidden">
                                    <img src=" ${item.image} "
                                    alt="Products">
                                    </a>
                                    <div class="info">
                                        <span id="quantitys">${
                                            item.quantitys
                                        }</span>
                                        <h6><a class="product-name" >${
                                            item.names
                                        }</a></h6>
                                        <p class="orderPrice">$ ${
                                         parseInt(parseFloat(item.prices))
                                        }</p>
                                        </div>
                            </div>
                            <div class="qty-item text-center">
                                <a href="javascript:void(0);" onClick="minus(this)" class="dec d-flex justify-content-center align-items-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="minus">
                                    <i data-feather="minus-circle" id="minus" class="feather-14"></i>
                                </a>
                                <input onInput="inputChange(this)" type="text" class="orderQuantity form-control text-center" name="qty" value="${
                                    item.Qty || 1
                                }">
                                <a href="javascript:void(0);" class="inc d-flex justify-content-center align-items-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="plus" onClick="plus(this)">
                                    <i data-feather="plus-circle" class="feather-14"></i>
                                </a>

                            </div>
                                <div class="d-flex align-items-center action">
                                    <a class="delete btn-icon edit-icon me-2" data-bs-toggle="modal1"
                                    data-bs-target="#edit-product1">
                                    <i data-feather="edit" class="feather-14"></i>
                                    </a>
                                    <a class="delete btn-icon delete-icon confirm-text" onClick="deleteItem('${
                                        item.names
                                    }')">
                                        <i data-feather="trash-2" class="feather-14"></i>
                                        </a>
                                        </div>
                            </div>
                                        `;
                prouduct_wrap.innerHTML += html;
                feather.replace();
                subTotal();
                TotalQuantity();
                grandTotal();
            });
        } else {
            prouduct_wrap.innerHTML = "";
            subTotal();
            TotalQuantity();
            grandTotal();
        }
    }

    // clear all order
    let clear = document.querySelector(".clear");
    clear.addEventListener("click", () => {
        orderItems = [];
        let productActive = document.querySelectorAll(".pro");
        productActive.forEach((product) => {
            product.classList.remove("active");
        });
        orderItem();
    });

    // delete an order
    function deleteItem(productName) {
        orderItems = orderItems.filter((item) => item.names !== productName);
        let orderQuantity = document.querySelectorAll(".product-order") || "";
        orderQuantity.forEach((orderItem) => {
            let name = orderItem.querySelector(".product-name").textContent;
            if (name === productName) {
                orderItem.remove();
            }
        });

        let productActive = document.querySelectorAll(".pro");
        productActive.forEach((product) => {
            let name = product.querySelector(".cat-name a").textContent;
            if (name === productName) {
                product.classList.remove("active");
            }
        });
        orderItem();
    }

    // minus the order quantity
    function minus(element) {
        let input = element.parentNode.parentNode.querySelector("input");
        let value = parseInt(input.value);
        if (value === 0) {
            Toastify({
                text: "you can`t set to negative",
                position: "bottom-right",
                duration: 2000,
                gravity: "top-left",
                close: true,
                backgroundColor: "linear-gradient(to right, #910d06, #44160f)",
                icon: '<i class="fas fa-check-circle"></i>',
                className: "toastify-custom",
            }).showToast();
            input.value = 0;
            TotalQuantity();
            grandTotal();
        } else {
            value -= 1;
            input.value = value;
            TotalQuantity();
            grandTotal();
        }
    }

    // plus the order quantity
    function plus(element) {
        let input = element.parentNode.parentNode.querySelector("input");
        let value = parseInt(input.value);
        let parentElement = element.parentNode.parentNode;
        let maxQty = parseInt(
            parentElement
            .querySelector("#quantitys")
            .textContent.replace("Pcs", "")
            .trim()
        );

        if (value >= maxQty) {
            Toastify({
                text: "You reached max quantity",
                position: "bottom-right",
                duration: 2000,
                gravity: "top-left",
                close: true,
                backgroundColor: "linear-gradient(to right, #910d06, #44160f)",
                icon: '<i class="fas fa-check-circle"></i>',
                className: "toastify-custom",
            }).showToast();
            input.value = maxQty;
            TotalQuantity();
            grandTotal();
        } else {
            value += 1;
            input.value = value;
            TotalQuantity();
            grandTotal();
        }
    }

    // change quantity while input
    function inputChange(element) {
        let input = element.parentNode.parentNode.querySelector("input");
        let value = parseInt(element.value); // Update value here
        let parentElement = element.parentNode.parentNode;
        let maxQty = parseInt(
            parentElement
            .querySelector("#quantitys")
            .textContent.replace("Pcs", "")
            .trim()
        );

        if (value > maxQty) {
            Toastify({
                text: "You reached max quantity",
                position: "bottom-right",
                duration: 2000,
                gravity: "top-left",
                close: true,
                backgroundColor: "linear-gradient(to right, #910d06, #44160f)",
                icon: '<i class="fas fa-check-circle"></i>',
                className: "toastify-custom",
            }).showToast();
            input.value = maxQty;
            TotalQuantity();
            grandTotal();
        } else {
            if (!value) {
                input.value = 0;
                TotalQuantity();
                grandTotal();
            } else {
                input.value = value;
                TotalQuantity();
                grandTotal();
            }
        }
    }

    // subTotal of Orders
    function subTotal() {
        let subtotal = document.querySelector(".subTotal");
        let orderPrices = document.querySelectorAll(".orderPrice");
        let x = 0;
        if (orderItems.length > 0) {
            orderPrices.forEach((orderPrice) => {
                let price = parseFloat(
                    orderPrice.textContent.replace("$", "").trim()
                );
                x += price;
            });
            subtotal.textContent = "$ " + x.toFixed(2);
        } else {
            subtotal.textContent = "$ " + x.toFixed(2);
        }
    }

    // Quantity of Order
    function TotalQuantity() {
        let totalQuantity = document.querySelector(".totalQuantity");
        let quantitys = document.querySelectorAll(".orderQuantity");
        let x = 0;
        if (orderItems.length > 0) {
            quantitys.forEach((quantity) => {
                let qty = parseFloat(quantity.value);
                x += qty;
            });
            totalQuantity.textContent = x;
        } else {
            totalQuantity.textContent = x;
        }
    }

    // calculate total price
    function grandTotal() {
        let total = document.querySelector(".total");
        let productOrders = document.querySelectorAll(".product-order");
        let x = 0;
        if (orderItems.length > 0) {
            productOrders.forEach((productOrder) => {
                let quantity = parseFloat(
                    productOrder.querySelector(".orderQuantity").value
                );
                let price = parseFloat(
                    productOrder
                    .querySelector(".orderPrice")
                    .textContent.replace("$", "")
                    .trim()
                );
                x += quantity * price;
                total.textContent = "$ " + x.toFixed(2);
            });
        } else {
            total.textContent = "$ " + x.toFixed(2);
        }
    }

    // {{-- submit order and create invoice --}}

    function formatDate(date) {
        // Get the individual date components
        let hours = String(date.getHours()).padStart(2, "0");
        let minutes = String(date.getMinutes()).padStart(2, "0");
        let seconds = String(date.getSeconds()).padStart(2, "0");
        let day = String(date.getDate()).padStart(2, "0");
        let month = String(date.getMonth() + 1).padStart(2, "0"); // Month is zero-based
        let year = date.getFullYear();

        // Concatenate the components into the desired format
        return `${hours}:${minutes}:${seconds} ${day}/${month}/${year}`;
    }


    $(document).ready(function () {
        $('#submit').click(function (e) {
            e.preventDefault();
            let orderInvoice = [];
            if (orderItems.length > 0) {
            var customerSelect = $('#customerSelect').val();
                if (customerSelect.trim() === '') {
                    Toastify({
                        text: 'Customer is required!',
                        duration: 3000,
                        gravity: 'top-left',
                        close: true,
                        backgroundColor: "linear-gradient(to right, #910d06, #44160f)",
                        className: 'toastify-custom',
                    }).showToast();
                    return; // Exit the function if customerSelect is empty
                }else{
                   $("#payment-completed").modal("show");
                   $(".product-order").each(function () {
                       let names = $(this).find(".product-name").text();
                       let prices = $(this).find(".orderPrice").text().replace("$", "").trim();
                       let quantitys = $(this).find(".orderQuantity").val();
                       let orders = {
                           name: names,
                           price: prices,
                           quantity: quantitys
                       };
                       orderInvoice.push(orders);
                   });
   
                   let invoiceItmes = $(".invoice-order");
                   let i = 1;
                   invoiceItmes.html("");
                   $.each(orderInvoice, function (index, orderItem) {
                       let html = `
                   <tr>
                       <td>${i}. ${orderItem.name}</td>
                       <td>$ ${orderItem.price}</td>
                       <td>${orderItem.quantity}</td>
                       <td class="text-end">$ ${(orderItem.price * orderItem.quantity).toFixed(2)}</td>
                   </tr>`;
                       invoiceItmes.append(html);
                       i++;
                   });
   
                   let subTotal = $(".total").text();
                   let transaction = $(".transaction").text().replace("Transaction ID : #", "").trim();
                   $(".invoiceId").text(transaction);
                   let invoiceName = $(".invoice-name");

                   let selection = $(".selection");
                   let customerId = $("#customerSelect").val();
                   $("#customer_id").text(customerId); // Use .text() instead of .val()
                   



                   invoiceName.text(selection.find("option:selected").text());

                   let currentDate = new Date();
                   $(".date").text(formatDate(currentDate));
   
                   let barcode = $(".barcodes");
                   JsBarcode(barcode, transaction, {
                       format: "CODE128",
                       displayValue: false
                   });
   
                   console.log(orderInvoice);
                   invoiceItmes.append(`
               <td colspan="4">
                   <table class="table-borderless w-100 table-fit">
                       <tbody>
                           <tr>
                               <td>Sub Total :</td>
                               <td class="text-end">${subTotal}</td>
                           </tr>
                           <tr>
                               <td>Discount :</td>
                               <td class="text-end">$ 0.00</td>
                           </tr>
                           <tr>
                               <td>Shipping :</td>
                               <td class="text-end">$ 0.00</td>
                           </tr>
                           <tr>
                               <td>Tax :</td>
                               <td class="text-end">$ 0.00</td>
                           </tr>
                           <tr>
                               <td>Total Payable :</td>
                               <td class="text-end">${subTotal}</td>
                           </tr>
                       </tbody>
                   </table>
               </td>`);
 }
  // Prepare data to be sent
  var formData = new FormData();

  // Serialize order items array and append it to the form data
  formData.append('orderInvoice', JSON.stringify(orderInvoice));

  console.log("orderInvoice : " + JSON.stringify(orderInvoice));
  var totalDangerValue = document.querySelector('.total.danger').textContent.trim();

// Get the text content of the element with the class "date"
// Get the date value
var dateValue = $(".date").text();

// Split the date value into time and date parts
var parts = dateValue.split(' ');

// Split the date part into day, month, and year
var dateParts = parts[1].split('/');

// Construct the MySQL datetime string
var mysqlDatetime = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0] + ' ' + parts[0];


  var invoicenumber=$(".invoiceId").text();




  // Append total values to form data
  formData.append('date',mysqlDatetime);
  formData.append('Invoicenumber',invoicenumber);
  formData.append('customerSelect', customerSelect);
  formData.append('totalDanger', totalDangerValue);





  // Perform AJAX request
  var csrfToken = $('meta[name="csrf-token"]').attr('content');
  // Define the URL
  var url = storePosUrl;
  console.log(url)
  $.ajax({
      url: url,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      headers: {
          'X-CSRF-TOKEN': csrfToken
      },
      success: function (response) {
        Toastify({
            text: 'Payment Completed',
            duration: 2000,
            gravity: 'top-left',
            close: true,
            backgroundColor: "linear-gradient(to right, #117a82, #163234)",
            escape: false, // Set escape to false to render HTML
            className: "toastify-custom"
        }).showToast();
        
       $('#customerSelect').val('');

      },
      error: function (xhr, status, error) {
          // Handle error
          console.log("Error occurred:", xhr, status, error);
      }
  });
            } else {
                Toastify({
                    text: "Add an order to payment",
                    position: "bottom-right",
                    duration: 2000,
                    gravity: "top-left",
                    close: true,
                    backgroundColor: "linear-gradient(to right, #910d06, #44160f)",
                    icon: '<i class="fas fa-check-circle"></i>',
                    className: "toastify-custom"
                }).showToast();
            }
            $(".clear").click();


          





        });
    });

    let print = document.querySelector('.print');
    print.addEventListener('click', () => {
        window.print()
    })

    // {{-- print the invoice  --}}

    document.querySelector(".print").addEventListener("click", function () {
        // Open a new window
        var printWindow = window.open("", "_blank");

        // Generate the content for the new window
        var content = `
                            <!DOCTYPE html>
                            <html lang="en">
                            <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Print Receipt</title>
                            <link rel="stylesheet" href="{{ asset('assets/pos/assets/css/style.css') }}">

                            <style>
                                .d-flex.justify-content-end{
                                    display: none;
                                }
                                .modal-body .btn {
                                    display:none;
                                }
                                @media print {
                                    body {
                                        width: 8cm;
                                        display: flex;
                                        justify-content: center;
                                        align-items: center;
                                    }
                                    .modal-body {
                                                padding: 30px;
                                                color: #5b6670;
                                                text-align: center;
                                            }
                                    .modal-body h6 {
                                                font-size: 16px;
                                            }
                                    .modal-body .info h6 {
                                                margin: 10px 0;
                                                font-weight: normal;
                                            }
                                    .modal-body .info a {
                                                color: #5b6670;
                                            }
                                    .modal-body .tax-invoice h6 {
                                                margin: 10px 0;
                                                font-weight: 600;
                                                position: relative;
                                            }
                                    .modal-body .tax-invoice h6:after,
                                    .modal-body .tax-invoice h6:before {
                                                transform: translateY(-50%);
                                                -webkit-transform: translateY(-50%);
                                                -ms-transform: translateY(-50%);
                                                content: "";
                                                border-top: 1px dashed #5b6670;
                                                width: 35%;
                                            }
                                    .modal-body .tax-invoice h6:before {
                                                position: absolute;
                                                top: 50%;
                                                left: 0;
                                            }
                                    .modal-body .tax-invoice h6:after {
                                                position: absolute;
                                                top: 50%;
                                                right: 0;
                                            }
                                    .modal-body .tax-invoice .invoice-user-name {
                                                margin-bottom: 10px;
                                            }
                                    .modal-body .tax-invoice span {
                                                color: #092c4c;
                                            }
                                    .modal-body table thead th {
                                                color: #092c4c;
                                                width: auto;
                                                min-width: auto;
                                                padding: 5px;
                                                border-top: 1px dashed #5b6670;
                                                border-bottom: 1px dashed #5b6670;
                                            }
                                    .modal-body table tbody tr td {
                                                padding: 5px;
                                            }
                                    .modal-body table tbody tr table {
                                                border-top: 1px dashed #5b6670;
                                            }
                                    .modal-body table tbody tr table tr:last-child td {
                                                font-weight: 500;
                                                font-size: 15px;
                                                color: #092c4c;
                                            }
                                    .modal-body .invoice-bar {
                                                border-top: 1px dashed #5b6670;
                                                padding: 20px 0 0 0;
                                            }
                                    .modal-body .btn {
                                                display:none;
                                            }
                                }
                            </style>
                        </head>
                        <body>
                            ${document.querySelector(".modals").innerHTML}
                        </body>

                        </html>
        `;

        // Write the content to the new window
        printWindow.document.write(content);

        // Close the document stream to display the content
        printWindow.document.close();

        // Print the new window
        printWindow.print();

        // Close the window after printing
        printWindow.onafterprint = function () {
            printWindow.close();
        };
    });

    document.querySelector("#next-order").addEventListener("click", function (e) {
        e.preventDefault();
        paymentCompletedModal.hide();
    });
