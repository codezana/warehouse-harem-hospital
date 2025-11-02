@extends('layouts.nav')

@section('name', 'Purchase Details')
@section('custom-css')
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">


@endsection
@section('content')

    <div class="page-wrapper page-wrapper-one">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Purchase Details</h4>
                    <h6>View Purchase details</h6>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-sales-split">
                        <h2>Purchase Detail : {{ $purchases->first()->first()->reference }}</h2>
                        <ul>
                            @foreach ($purchases as $group)
                                @foreach ($group as $key => $purchase)
                                    @if ($key === 0 && $loop->parent->index === 0)
                                        <li>
                                            <a href="{{ route('edit.purchase', ['date' => $purchase->date, 'reference' => $purchase->reference]) }}">
                                                <img src="assets/img/icons/edit.svg" alt="Edit">
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @endforeach
                            
                            <li><a href="javascript:void(0);"><img src="assets/img/icons/pdf.svg" alt="PDF"></a></li>
                            <li><a href="javascript:void(0);"><img src="assets/img/icons/excel.svg" alt="Excel"></a></li>
                            <li><a href="javascript:void(0);"><img src="assets/img/icons/printer.svg" alt="Printer"></a></li>
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
                                                                Supplier Info</font>
                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                @foreach ($purchases as $group)
                                                                    @foreach ($group as $purchase)
                                                                        @if ($purchase->supplier_id)
                                                                            {{ $purchase->supplier->supplier_name }}
                                                                        @else
                                                                            No Supplier associated
                                                                        @endif
                                                                    @break
                                                                @endforeach
                                                            @endforeach

                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#12894b;font-weight: 400;">
                                                                @foreach ($purchases as $group)
                                                                @foreach ($group as $purchase)
                                                                    @if ($purchase->supplier_id)
                                                                        {{ $purchase->supplier->email }}
                                                                    @else
                                                                        No Supplier email associated
                                                                    @endif
                                                                @break
                                                            @endforeach
                                                        @endforeach
                                                        </font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font
                                                            style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            @foreach ($purchases as $group)
                                                            @foreach ($group as $purchase)
                                                                @if ($purchase->supplier_id)
                                                                    {{ $purchase->supplier->phone }}
                                                                @else
                                                                    No Supplier phone associated
                                                                @endif
                                                            @break
                                                        @endforeach
                                                    @endforeach
                                                    </font>
                                                </font><br>
                                                <font style="vertical-align: inherit;">
                                                    <font
                                                        style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">

                                                        @foreach ($purchases as $group)
                                                        @foreach ($group as $purchase)
                                                            @if ($purchase->supplier_id)
                                                                {{ $purchase->supplier->city }},
                                                                {{ $purchase->supplier->district }}.
                                                                {{ $purchase->supplier->address }}


                                                            @else
                                                                No Supplier Address associated
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
                                                {{ $purchases->first()->first()->reference }} </font>
                                        </font><br>
                                        <font style="vertical-align: inherit;">
                                            <font
                                                style="vertical-align: inherit;font-size: 14px;color:#2E7D32;font-weight: 400;">
                                                @foreach ($purchases as $group)
                                                    @foreach ($group as $purchase)
                                                        {{ $purchase->totalPurchase->status === 'Completed' ? 'Paid' : 'Unpaid' }}
                                                    @break
                                                @endforeach
                                            @endforeach
                                        </font>
                                    </font><br>
                                    <font style="vertical-align: inherit;">
                                        <font
                                            style="vertical-align: inherit;font-size: 14px;color:#2E7D32;font-weight: 400;">
                                            @foreach ($purchases as $group)
                                                @foreach ($group as $purchase)
                                                    {{ $purchase->totalPurchase->status }}
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
        @foreach ($purchases as $group)
            @foreach ($group as $purchase)
                <tr class="details" style="border-bottom:1px solid #E9ECEF ;text-align: center">
                    <td
                        style="padding: 10px; vertical-align: top; display: flex; align-items: center; text-align: center; justify-content: center;">
                        <img src="{{ asset('uploads/product/products/' . $purchase->product->image) }}"
                            alt="img" class="me-2"
                            style="width: 40px; height: 40px; border-radius: 50%;">
                        {{ $purchase->product->name }}
                    </td>

                    <td style="padding: 10px;vertical-align: top; ">
                        {{ $purchase->quantity }}
                    </td>
                    <td style="padding: 10px;vertical-align: top; ">
                        {{ $purchase->sale_price }}
                    </td>
                    <td style="padding: 10px;vertical-align: top; ">
                        ${{ number_format($purchase->totalPurchase->shipping_total, 2) }}
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
                            foreach ($purchases as $group) {
                                $totalQuantity += $group->sum('quantity');
                            }
                            echo $totalQuantity;
                        @endphp
                    </h5>
                </li>
                <li>
                    <h4>Paid IQD </h4>
                    <h5>
                        @php
                            $totalDinar = 0;
                            foreach ($purchases as $group) {
                                $totalDinar += $group->first()->totalPurchase->paid_dinar;
                            }
                            echo number_format($totalDinar, 0, '.', ',');
                        @endphp
                        IQD
                    </h5>
                </li>
                <li>
                    <h4>Grand Total IQD </h4>
                    <h5>
                        @php
                            $totalDinar = 0;
                            foreach ($purchases as $group) {
                                $totalDinar += $group->first()->totalPurchase->grand_dinar;
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
                    <h5>$ {{ number_format($purchases->first()->first()->totalPurchase->shipping_total, 2) }}
                    </h5>
                </li>
                <li class="total">
                    <h4>Paid</h4>
                    <h5>$
                        @php
                            $totalDollar = 0;
                            foreach ($purchases as $group) {
                                $totalDollar += $group->first()->totalPurchase->paid;
                            }
                            echo number_format($totalDollar, 2);
                        @endphp
                    </h5>
                </li>
                <li class="total">
                    <h4>Grand Total</h4>
                    <h5>$
                        @php
                            $totalDollar = 0;
                            foreach ($purchases as $group) {
                                $totalDollar += $group->first()->totalPurchase->grand_total;
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
