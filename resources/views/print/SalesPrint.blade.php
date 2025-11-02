<!DOCTYPE html>
<html>

<head>
</head>

<body>

    <style>
body{
    display: none;
}


@page {
  margin: 20mm
}

@media print {
   thead {display: table-header-group;} 
   tfoot {display: table-footer-group;}
   
   button {display: none;}
   
   body {margin: 0;
display: block;}

   header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

 h1 {
            border-top: 1px solid #5D6975;
            border-bottom: 1px solid #5D6975;
            color: #5D6975;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
        }

        #project {
            float: left;
        }

        #project span {
            color: #5D6975;
            text-align: right;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
        }

        #company {
            float: right;
            text-align: right;
        }

        #project div,
        #company div {
            white-space: nowrap;
        }
table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table tr:nth-child(2n-1) td {
            background: #F5F5F5;
        }


        table td {
            text-align: center;
            padding: 5px 20px;
            border-right: 1px solid black;
            border-bottom: 1px solid black;
            border-left: 1px solid black;

            border-top: 1px solid black;

        }
table td:last-child() {
            border: none !important;
        }

        table th {
            padding: 5px 20px;
            color: #000000;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: bolder;
            border-bottom: 1px solid black;

        }



        table .service,
        table .desc {
            text-align: left;
        }

        table td {
            padding: 16px 16px;
        }
        /* Styles go here */

.page-header, .page-header-space {
  height: 100px;
}

.page-footer, .page-footer-space {
  height: 100px;

}

.page-footer {
  position: fixed;
  bottom: 0;
  width: 100%;
  border-top: 1px solid black; /* for demo */
}

.page-header {
  position: fixed;
  top: 0mm;
  width: 100%;
  border-bottom: 1px solid black; /* for demo */
}

.page {
  page-break-after: auto;
}
#logo {
            text-align: center;
            margin-bottom: 10px;
        }

        #logo img {
            width: 90px;
        }
}

    </style>

  <div class="page-header" style="text-align: left; border-top: 1px solid black;">
    <div id="project" style="position: absolute; left: 0; margin-top: 3px; margin-left: 10px">
        <div><span>cCompany</span> Harem Hospital</div>
        <div><span>CLIENT</span> Users</div>
        <div><span>ADDRESS</span> jaday 60 matre</div>
        <div><span>EMAIL</span> <a href="mailto:john@example.com">haremhospital@gmail.com</a></div>
        <div><span>DATE</span> August 17, 2015</div>
    </div>
    <div id="logo" style="position: absolute; left: 50%; margin-top: 3px; transform: translateX(-50%);">
        <img src="assets/img/harem.png">
    </div>


    <div id="company" class="clearfix1" style="position: absolute; right:  0; margin-top: 3px; margin-right: 10px">
        <div>Company Name</div>
        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div>
    </div>
  </div>


  <div class="page-footer" style="display: block; border-bottom: 1px solid black;">
    <div id="project" style="position: absolute; left: 0; margin-top: 3px; margin-left: 10px">
        <div><span>cCompany</span> Harem Hospital</div>
        <div><span>CLIENT</span> Users</div>
        <div><span>ADDRESS</span> jaday 60 matre</div>
        <div><span>EMAIL</span> <a href="mailto:john@example.com">haremhospital@gmail.com</a></div>
        <div><span>DATE</span> August 17, 2015</div>
    </div>
    <div id="logo" style="position: absolute; left: 50%; margin-top: 3px; transform: translateX(-50%);">
        <img src="assets/img/harem.png">
    </div>


    <div id="company" class="clearfix1" style="position: absolute; right:  0; margin-top: 3px; margin-right: 10px">
        <div>Company Name</div>
        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div>
    </div>
  </div>


  <table class="table">

    <thead>
      <tr>
        <td style="
        background: transparent;
        border: none;
    ">
          <!--place holder for the fixed-position header-->
          <div class="page-header-space"></div>
        </td>
      </tr>
    </thead>

    <tbody>
        
        <div id="selectedRows" class="page" style="line-height: 2;"></div>
      
    </tbody>

    <tfoot >
        <tr>
          <td style="
          border: none;
          background: transparent;
      ">
            <!--place holder for the fixed-position footer-->
            <div class="page-footer-space"></div>
          </td>
        </tr>
      </tfoot>

  </table>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
    let jsonData = localStorage.getItem('printData');
    let data = JSON.parse(jsonData);
    
    let tbody = document.getElementById('selectedRows'); 

    let thead = document.createElement('thead');
    let tr = document.createElement('tr');

    // Define column names
    let columnNames = [
        'ID',
        'Product Name',
        'SKU',
        'Category',
        'Brand',
        'Sold amount',
        'Sold qty',
        'Instock qty'
    ];

    // Add column names to the table header
    columnNames.forEach(function(header) {
        let th = document.createElement('th');
        th.innerText = header;
        tr.appendChild(th);
    });

    thead.appendChild(tr);
    tbody.appendChild(thead);



    data.forEach(function(rowData, index) { 
        let row = document.createElement('tr');

        // Create a new td for the unique ID
        let idCell = document.createElement('td');
        idCell.innerText = '' + (index + 1);
        row.appendChild(idCell);

        rowData.forEach(function(cellData) {
            let cell = document.createElement('td');
            cell.innerText = cellData;
            row.appendChild(cell);
        });

        tbody.appendChild(row);
    });

    let table = document.querySelector('.table'); 
    table.appendChild(tbody); 

    window.print();

    window.addEventListener('afterprint', function() {
        // Close the window after printing or cancelling
        window.close();
    });
});


  </script>
</body>

</html>