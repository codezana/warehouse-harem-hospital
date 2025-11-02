@extends('layouts.nav')

@section('name', 'Sales Details')
@section('custom-css')
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">


@endsection
@section('content')

    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Sale Details</h4>
                    <h6>View sale details</h6>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-sales-split">
                        <h2>Sale Detail : {{ $sales->first()->first()->receipt }}</h2>
                        <ul>
                            <li>
                                @foreach ($sales as $group)
                                @foreach ($group as $index => $sale)
                                    @if ($index === 0)
                                        <a 
                                            href="{{ route('sale.edit', ['date' => $sale->date, 'receipt' => $sale->receipt]) }}"><img
                                                src="assets/img/icons/edit.svg" alt="img"></a>
                                    @endif
                                @endforeach
                            @endforeach
                            
                            </li>
                            <li>
                                <a href="javascript:void(0);"><img src="assets/img/icons/pdf.svg" alt="img"></a>
                            </li>
                            <li>
                                <a href="javascript:void(0);"><img src="assets/img/icons/excel.svg" alt="img"></a>
                            </li>
                            <li>
                                <a href="javascript:void(0);"><img src="assets/img/icons/printer.svg" alt="img"></a>
                            </li>
                        </ul>
                    </div>
                    <div class="invoice-box table-height"
                        style="max-width: 1600px;width:100%;overflow: auto;margin:15px auto;padding: 0;font-size: 14px;line-height: 24px;color: #555;">
                        <table cellpadding="0" cellspacing="0" style="width: 100%;line-height: inherit;text-align: left;">
                            <tbody>
                                <tr class="top">
                                    <td colspan="6" style="padding: 5px;vertical-align: top;">
                                        <table style="width: 100%;line-height: inherit;text-align: left;">
                                            <tbody>
                                                <tr>
                                                    <td
                                                        style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                                        <font style="vertical-align: inherit;margin-bottom:25px;">
                                                            <font
                                                                style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">
                                                                Customer Info</font>
                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                @foreach ($sales as $group)
                                                                    @foreach ($group as $sale)
                                                                        @if ($sale->customer_id)
                                                                            {{ $sale->customer->customer_name }}
                                                                        @elseif ($sale->user_id)
                                                                            {{ $sale->salesuser->username }}
                                                                        @else
                                                                            No customer or user associated
                                                                        @endif
                                                                    @break
                                                                @endforeach
                                                            @endforeach

                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#12894b;font-weight: 400;">
                                                                @foreach ($sales as $group)
                                                                    @foreach ($group as $sale)
                                                                        @if ($sale->customer_id)
                                                                            {{ $sale->customer->email }}
                                                                        @elseif ($sale->user_id)
                                                                            {{ $sale->salesuser->email }}
                                                                        @else
                                                                            No customer or user associated
                                                                        @endif
                                                                    @break
                                                                @endforeach
                                                            @endforeach
                                                        </font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font
                                                            style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            @foreach ($sales as $group)
                                                                @foreach ($group as $sale)
                                                                    @if ($sale->customer_id)
                                                                        {{ $sale->customer->phone }}
                                                                    @elseif ($sale->user_id)
                                                                        {{ $sale->salesuser->phone }}
                                                                    @else
                                                                        No customer or user associated
                                                                    @endif
                                                                @break
                                                            @endforeach
                                                        @endforeach
                                                    </font>
                                                </font><br>
                                                <font style="vertical-align: inherit;">
                                                    <font
                                                        style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">

                                                        @foreach ($sales as $group)
                                                            @foreach ($group as $sale)
                                                                @if ($sale->customer_id)
                                                                    {{ $sale->customer->address }} ,
                                                                    {{ $sale->customer->district }} ,
                                                                    {{ $sale->customer->city }}
                                                                @elseif ($sale->user_id)
                                                                    
                                                                @else
                                                                    No customer or user associated
                                                                @endif
                                                            @break
                                                        @endforeach
                                                    @endforeach

                                                </font>
                                            </font><br>
                                    </td>


                                    <td
                                        style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                        <font style="vertical-align: inherit;margin-bottom:25px;">
                                            <font
                                                style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">
                                                Invoice Info</font>
                                        </font><br>
                                        <font style="vertical-align: inherit;">
                                            <font
                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                Reference </font>
                                        </font><br>
                                        <font style="vertical-align: inherit;">
                                            <font
                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                Payment Status</font>
                                        </font><br>
                                        <font style="vertical-align: inherit;">
                                            <font
                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                Status</font>
                                        </font><br>
                                    </td>
                                    <td
                                        style="padding:5px;vertical-align:top;text-align:right;padding-bottom:20px;">
                                        <font style="vertical-align: inherit;margin-bottom:25px;">
                                            <font
                                                style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">
                                                &nbsp;</font>
                                        </font><br>
                                        <font style="vertical-align: inherit;">
                                            <font
                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                {{ $sales->first()->first()->receipt }} </font>
                                        </font><br>
                                        <font style="vertical-align: inherit;">
                                            <font
                                                style="vertical-align: inherit;font-size: 14px;color:#2E7D32;font-weight: 400;">
                                                @foreach ($sales as $group)
                                                    @foreach ($group as $sale)
                                                        {{ $sale->salesOrder->status === 'Completed' ? 'Paid' : 'Unpaid' }}
                                                    @break
                                                @endforeach
                                            @endforeach
                                        </font>
                                    </font><br>
                                    <font style="vertical-align: inherit;">
                                        <font
                                            style="vertical-align: inherit;font-size: 14px;color:#2E7D32;font-weight: 400;">
                                            @foreach ($sales as $group)
                                                @foreach ($group as $sale)
                                                    {{ $sale->salesOrder->status }}
                                                @break
                                            @endforeach
                                        @endforeach

                                    </font>
                                </font><br>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr class="heading " style="background: #F3F2F7;text-align: center">
            <td
                style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                Product Name
            </td>
            <td
                style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                QTY
            </td>
            <td
                style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                Price
            </td>
            <td
                style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                Shipping
            </td>

        </tr>
        @foreach ($sales as $group)
            @foreach ($group as $sale)
                <tr class="details" style="border-bottom:1px solid #E9ECEF ;text-align: center">
                    <td
                        style="padding: 10px; vertical-align: top; display: flex; align-items: center; text-align: center; justify-content: center;">
                        <img src="{{ asset('uploads/product/products/' . $sale->product->image) }}"
                            alt="img" class="me-2"
                            style="width: 40px; height: 40px; border-radius: 50%;">
                        {{ $sale->product->name }}
                    </td>

                    <td style="padding: 10px;vertical-align: top; ">
                        {{ $sale->quantity }}
                    </td>
                    <td style="padding: 10px;vertical-align: top; ">
                        {{ $sale->price }}
                    </td>
                    <td style="padding: 10px;vertical-align: top; ">
                        ${{ number_format($sale->salesOrder->shipping, 2) }}
                    </td>

                </tr>
            @endforeach
        @endforeach

    </tbody>
</table>
</div>
<div class="row">

<div class="row">
    <div class="col-lg-6 ">
        <div class="total-order w-100 max-widthauto m-auto mb-4">
            <ul>
                <li>
                    <h4>Number of Sold</h4>
                    <h5>
                        @php
                            $totalQuantity = 0;
                            foreach ($sales as $group) {
                                $totalQuantity += $group->sum('quantity');
                            }
                            echo $totalQuantity;
                        @endphp
                    </h5>
                </li>
                <li>
                    <h4>Grand Total IQD </h4>
                    <h5>
                        @php
                            $totalDinar = 0;
                            foreach ($sales as $group) {
                                $totalDinar += $group->first()->salesOrder->total_dinar;
                            }
                            echo number_format($totalDinar, 0, '.', ',');
                        @endphp
                        IQD
                    </h5>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-lg-6 ">
        <div class="total-order w-100 max-widthauto m-auto mb-4">
            <ul>
                <li>
                    <h4>Shipping</h4>
                    <h5>${{ number_format($sales->first()->first()->salesOrder->shipping, 2) }}
                    </h5>
                </li>
                <li class="total">
                    <h4>Grand Total</h4>
                    <h5>
                        @php
                            $totalDollar = 0;
                            foreach ($sales as $group) {
                                $totalDollar += $group->first()->salesOrder->total_dollar;
                            }
                            echo number_format($totalDollar, 2);
                        @endphp
                    </h5>
                </li>
            </ul>
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

<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
@endsection
