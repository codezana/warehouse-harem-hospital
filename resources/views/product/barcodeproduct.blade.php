<!DOCTYPE html>
<html>

<head>
    <title>User List - Warehouse Harem Hospital (Print)</title>
    <style>
        .clearfix {
            display: flex;
            justify-content: space-between;
            height: 80px;

        }

        /* Define your print-specific styles here */
        .clearfix1:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            width: 21cm;
            height: 29.7cm;
            border: 1px solid black;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-family: Arial;
        }

        header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
        }

        #logo img {
            width: 90px;
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
            padding: 15px;
        }
    </style>
</head>



<body>
    <div class="print-bar-code-view">
        @php
            $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
            $barcodeImage = $generatorPNG->getBarcode($product->barcode, $generatorPNG::TYPE_CODE_128);
        @endphp


        <img src="data:image/png;base64,{{ base64_encode($barcodeImage) }}" alt="barcode"
            style="height: 55px;width: 160px">
        <br>
        <span class="barcode-number"
            style="position: absolute;
margin-right: 25px;
margin-bottom: -29px;
font-weight: bolder;">No:
            {{ $product->barcode }}</span>

    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
