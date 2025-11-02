<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Invoice Sale -{{ $sales->first()->first()->receipt }}</title>
  <link rel="stylesheet" href="{{ asset('assets/print/assets/css/style.css') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/harem.png') }}">

</head>

<body>
  <div class="cs-container">
    <div class="cs-bg-white cs-border-radious25">
      <div class="cs-bottom-bg2">
        <div class="cs-top-bg2">
          <div class="cs-invoice cs-style1 cs-bg-none">
            <div>
              <div class="cs-invoice_in" id="download_section">
                <div>
                  <div class="cs-logo"><img src="{{ asset('assets/img/haremw.png') }}" style="width: 185px;"></div>
                </div>
                <div class="cs-mb50">
                  <div class="cs-text_right">
                    <b class="cs-primary_color">PAYMENT STATUS </b>
                    <p class="cs-m0" style="font-weight: 500;">
                      {{ $sales->first()->first()->salesOrder->status =='Completed' ? 'PAID' :'UNPAID' }}
                      <br><br><br><br>
                    </p>
                  </div>
                  <div class="cs-invoice_left">
                    <b class="cs-primary_color">BILLED TO:</b>
                    <p>
                      @foreach ($sales as $group)
                      @foreach ($group as $sale)
                      @if ($sale->customer_id)
                      {{ $sales->first()->first()->customer->customer_name }} <br>
                      {{ $sales->first()->first()->customer->email }}
                      <br>{{ $sales->first()->first()->customer->phone }} <br>
                      {{ $sales->first()->first()->customer->address }} ,
                      {{ $sales->first()->first()->customer->district }} ,
                      {{ $sales->first()->first()->customer->city }} <br>
                      @elseif ($sale->user_id)
                      {{ $sale->salesuser->username }} <br>
                      {{ $sale->salesuser->email }}
                      <br>{{ $sale->salesuser->phone }} <br><br><br>
                      {{-- {{ $sales->salesuser->address }} ,
                      {{ $sales->salesuser->district }} ,
                      {{ $sales->salesuser->city }} <br> --}}
                      @else
                      No customer or user associated
                      @endif
                      @break
                      @endforeach
                      @endforeach

                    </p>
                  </div>
                </div>
                <div class="cs-table cs-style2 tm-border-none padding-rignt-left">
                  <div class="tm-border-none">
                    <div class="cs-table_responsive">
                      <table class="cs-mb30">
                        <div class="tm-border-1px"></div>
                        <thead class="border-bottom-1 cs-mb50">
                          <tr class="cs-secondary_color">
                            <th class="cs-width_5 cs-normal">DESCRIPTION</th>
                            <th class="cs-width_2 cs-normal">PRICE</th>
                            <th class="cs-width_2 cs-normal">QUANTITY</th>
                            <th class="cs-width_2 cs-normal cs-text_right">AMOUNT USD</th>
                          </tr>
                        </thead>
                        <tbody>

                          @foreach ($sales as $group)
                          @foreach ($group as $sale)
                          <tr class="border-bottom-1">
                            <td class="cs-width_5 cs-primary_color cs-f15">
                              {{$sale->product->name}}
                            </td>
                            <td class="cs-width_2 cs-primary_color cs-f15">$
                              {{number_format($sale->price,0)}}</td>
                            <td class="cs-width_2 cs-primary_color cs-f15">{{$sale->quantity}}</td>
                            <td class="cs-width_2 cs-text_right cs-primary_color cs-f15">
                              ${{number_format($sale->subtotal,0)}}</td>
                          </tr>
                          @endforeach
                          @endforeach

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="display-flex space-between mq-align-items">
                  <div class="cs-width_7 cs-mt70">
                    {{-- <P class="cs-primary_color cs-bold cs-f16 cs-uppercase">Payment Method</P>
                    <div class="display-flex space-between cs-mb30">
                      <div class="cs-m0">
                        <p class="cs-primary_color cs-mb3 cs-semi_bold">BANK INFO:</p>
                        <p class="cs-lh-165 cs-m0">
                          365 Bloor Street East, <br> Toronto, Ontario, <br> M4W 3L4, Canada
                        </p>
                      </div>
                      <div>
                        <p class="cs-primary_color cs-mb3 cs-semi_bold">BANK INFO:</p>
                        <p class="cs-lh-165">
                          3752 4521 8465 45621 <br> Canadian Bank <br> Johan Stark
                        </p>
                      </div>
                    </div> --}}
                  </div>
                  <div class="cs-width_4">
                    <p class="cs-secondary_color cs-text_right cs-f15">Total : <span
                        class="cs-ml30 cs-primary_color cs-semi_bold">$ @php
                        $totalDollar = 0;
                        foreach ($sales as $group) {
                        $totalDollar += $group->first()->salesOrder->total_dollar;
                        }
                        echo number_format($totalDollar, 0);
                        @endphp</span>
                    </p>
                    {{-- <p class="cs-secondary_color cs-text_right cs-f15">Payments: <span
                        class=" cs-ml30 cs-primary_color cs-semi_bold">${{number_format($saless->invoice->total_amount,0)}}</span>
                    </p> --}}
                    {{-- <div class="cs-border-50percent"></div> --}}
                    {{-- <p class="cs-secondary_color cs-text_right cs-f15 cs-mt15">Amount Due: <span
                        class="cs-ml30 cs-primary_color cs-semi_bold">$0.00</span> </p> --}}
                    {{-- <div class="cs-border-50percent"></div> --}}
                  </div>
                </div>
                <div class="">
                  <div class="cs-invoice_left" style="margin-bottom: 100px">
                    <div>
                      <p class="cs-primary_color cs-mb3 cs-semi_bold">Term & Conditions:</p>
                      <p class="cs-lh-165">
                        Once order done, money can't refund <br> Delivery might delay due to some external
                      </p>
                    </div>
                  </div>
                  <div class="display-flex justify-content-flex-end">
                    <div class="cs-text_right">
                      <b class="cs-primary_color">
                        @if ($sales->first()->first()->salesOrder->status == 'Completed')
                        <img src="{{ asset('assets/img/paid.svg') }}">
                        @else
                        <img src="{{ asset('assets/img/notpaid.svg') }}">
                        @endif

                        {{-- <p class="cs-border-50percent"></p> --}}

                    </div>
                  </div>
                </div>
                <div class=" display-flex space-between flex-wrap">
                  <p class=" cs-primary_color cs-uppercase cs-semi_bold ">Thank you for buying from us</p>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Invoice 6 end -->
  <script>
    // Open the print dialog when the page loads
        window.onload = function() {
            window.print();
        };
  
        // Automatically redirect after printing
        window.onafterprint = function() {
            window.history.back(); // Go back to the previous page
        };
  </script>
  <script src="{{ asset('assets/print/assets/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/print/assets/js/jspdf.min.js') }}"></script>
  <script src="{{ asset('assets/print/assets/js/html2canvas.min.js') }}"></script>
  <script src="{{ asset('assets/print/assets/js/main.js') }}"></script>
</body>

</html>