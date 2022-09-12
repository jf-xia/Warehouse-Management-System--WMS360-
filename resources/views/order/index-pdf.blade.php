<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>
    @isset($all_pending_order)  
    @foreach($all_pending_order as $pending) {{$pending->order_number ?? ''}} @endforeach
    @endisset
  </title>
    <link rel="stylesheet" href="style.css" media="all" />
    <style>
      @font-face {
        font-family: SourceSansPro;
        src: url(SourceSansPro-Regular.ttf);
      }

      .clearfix:after {
        content: "";
        display: table;
        clear: both;
      }

      a {
        color: #0087C3;
        text-decoration: none;
      }

      body {
        position: relative;
        width: 18cm;  
        height: 29.7cm; 
        margin: 0 auto; 
        color: #555555;
        background: #FFFFFF; 
        font-family: Arial, sans-serif; 
        font-size: 14px; 
        font-family: SourceSansPro;
      }

      header {
        padding: 0px 0;
        /* margin-bottom: 20px; */
        width: 10cm;
      }

      #logo {
        float: left;
        margin-top: 8px;
      }

      #logo img {
        height: 70px;
      }

      #company {
        float: right;
        text-align: right;
      }


      #details {
        margin-bottom: 5px;
        width: 18cm;
      }

      #client {
        padding-left: 6px;
        border-left: 6px solid #0087C3;
        float: left;
      }

      #client .to {
        color: #777777;
      }

      h2.name {
        font-size: 1.4em;
        font-weight: normal;
        margin: 0;
      }

      #invoice {
        float: right;
        /* text-align: right; */
      }

      #invoice h1, #client h1 {
        color: #0087C3;
        font-size: 2.4em;
        line-height: 1em;
        font-weight: normal;
        margin: 0  0 10px 0;
      }

      #invoice .date {
        font-size: 1.1em;
        color: #777777;
      }

      table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        /* margin-bottom: 20px; */
      }

      table th,
      table td {
        padding: 5px;
        background: #EEEEEE;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;
      }

      table th {
        white-space: nowrap;        
        font-weight: normal;
      }

      table td {
        text-align: right;
      }

      table td h3{
        color: #57B223;
        font-size: 1.2em;
        font-weight: normal;
        margin: 0 0 0.2em 0;
      }

      table .no {
        color: #FFFFFF;
        font-size: 1.6em;
        background: #57B223;
      }

      table .desc {
        text-align: left;
      }

      table .unit {
        background: #DDDDDD;
      }

      table .qty {
      }

      table .total {
        background: #57B223;
        color: #FFFFFF;
      }

      table td.unit,
      table td.qty,
      table td.total {
        font-size: 1.2em;
      }

      table tbody tr:last-child td {
        border: none;
      }

      table tfoot td {
        padding: 5px 20px;
        background: #FFFFFF;
        border-bottom: none;
        font-size: 1.2em;
        white-space: nowrap; 
        border-top: 1px solid #AAAAAA; 
      }

      table tfoot tr:first-child td {
        border-top: none; 
      }

      table tfoot tr:last-child td {
        color: #57B223;
        font-size: 1.4em;
        border-top: 1px solid #57B223; 

      }

      table tfoot tr td:first-child {
        border: none;
      }

      #thanks{
        font-size: 2em;
        margin-bottom: 5px;
      }

      #notices{
        padding-left: 6px;
        border-left: 6px solid #0087C3;  
      }

      #notices .notice {
        font-size: 1.2em;
      }

      footer {
        color: #777777;
        width: 100%;
        height: 30px;
        position: absolute;
        bottom: 0;
        border-top: 1px solid #AAAAAA;
        padding: 8px 0;
        text-align: center;
      }
      p{
        display:inline-block;
        margin-top:0px;
        margin-bottom:2px;
      }
      span{
        display:inline-block;
        margin-top:2px;
        margin-bottom:2px;
      }
      .content-right{
        display:inline-block;
      }
      .content-left{
        /* float:left; */
        display:inline-block;
        /* width:60px; */
      }
      .justify-content-start{
        width:218px !important;
      }
      #details{
        border-top: 1px solid #AAAAAA;
        padding-top:20px !important;
      }
      ul li{
        word-break:break-all !important;
      }


    </style>
  </head>
  <body>
    <header class="clearfix">
        <div id="logo">
            @if(!empty($client->logo_url))
                <img src="{{$client->logo_url}}">
            @endif    
                <div id="" style="">
                  @if(!empty($client->client_name))
                  <h2 class="name">{{$client->client_name}}</h2>
                  @endif
                      <ul style="list-style:none; padding:0; margin-top:0px;">
                        @if(!empty($client->address_line_1))
                          <li><span>Address 1 : </span><p>{!! "&nbsp;" !!}{{$client->address_line_1}}</p></li>
                        @endif
                        @if(!empty($client->address_line_2))  
                          <li><span>Address 2 : </span><p>{!! "&nbsp;" !!}{{$client->address_line_2}}</p></li>
                        @endif
                        @if(!empty($client->address_line_3))
                          <li><span>Address 3 : </span><p>{!! "&nbsp;" !!}{{$client->address_line_3}}</p></li>
                        @endif
                        @if(!empty($client->email))
                          <li><span>Email : </span><p>{!! "&nbsp;" !!}{{$client->email}}</p></li>
                        @endif
                        @if(!empty($client->city))
                          <li><span>Country : </span><p>{!! "&nbsp;" !!}{{$client->city}}</p></li>
                        @endif
                        @if(!empty($client->city))
                          <li><span>Country : </span><p>{!! "&nbsp;" !!}{{$client->country}}</p></li>
                        @endif
                      </ul>
                </div>        
        </div>
        
      <div id="company" style="float:right">
        <h2 class="name">Invoice No</h2>
        @isset($all_pending_order)
        @foreach($all_pending_order as $pending)
        <div>{{$pending->order_number}}</div>
        <h2 class="name">Invoice Date</h2>
        <div>{{date("d/m/Y")}}</div>
        @endforeach
        @endisset
        @if(!empty($client->reg_no))
          <h2 class="name">Reg No</h2>
          <div>{{$client->reg_no}}</div>
        @endif
        @if(!empty($client->phone_no))
          <h2 class="name">Phone No</h2>
          <div>{{$client->phone_no}}</div>
        @endif
        @if(!empty($client->post_code))
          <h2 class="name">Post Code</h2>
          <div>{{$client->post_code}}</div>
        @endif  
        @if(!empty($client->post_code))
          <h2 class="name">VAT ID</h2>
          <div>{{$client->vat}}</div>
        @endif  
      </div>
	  
    </header>
    
      </div>
    <main>
    @if(!empty($all_pending_order))  
    @foreach($all_pending_order as $pending)
      <div id="details" class="clearfix">
        <div id="client" style="float:left; width:320px !important;">
        <h1>Bill To</h1>
          <div class="to">INVOICE TO:</div>
          @if(!empty($pending->customer_name))
          <h2 class="name">{{$pending->customer_name}}</h2>
          @endif
          <ul style="list-style:none; padding:0; margin-top:0px;">
            @if(!empty($pending->customer_email))    
              <li><span>Email : </span><p>{!! "&nbsp;" !!}{{$pending->customer_email}}</p></li>
            @endif
            @if(!empty($pending->customer_phone))
              <li><span>Phone : </span><p>{!! "&nbsp;" !!}{{$pending->customer_phone}}</p></li>
            @endif
            @if(!empty($pending->customer_city))
              <li><span>City : </span><p>{!! "&nbsp;" !!}{{$pending->customer_city}}</p></li>
            @endif  
            @if(!empty($pending->customer_state))
              <li><span>State : </span><p>{!! "&nbsp;" !!}{{$pending->customer_state}}</p></li>
            @endif  
            @if(!empty($pending->customer_zip_code))
              <li><span>Post Code : </span><p>{!! "&nbsp;" !!}{{$pending->customer_zip_code}}</p></li>
            @endif
            @if(!empty($pending->customer_country))
              <li><span>Country : </span><p> {!! "&nbsp;" !!}{{$pending->customer_country}}</p></li>
            @endif  
            </ul>
        </div>
        <div id="invoice" style="float:right;">
          <h1 style="float:left; overflow:hidden !important; margin-bottom:30px; height:50px;">Ship To</h1>
              <div class="shipping-content" style="overflow:hidden !important; margin-top:55px;">
                  {!! $pending->shipping !!}
              </div>
        </div>
      </div>
      @endforeach
      @endif
      <table border="0" cellspacing="0" cellpadding="0">
          @if($inv_no == 2)
          <thead>
              <tr>
                <th colspan="4" class="service">DESCRIPTION</th>
                <th class="desc">QTY</th>
              </tr>
            </thead>
          @endif
          @if($inv_no == 1)  
          <thead>
              <tr>
                <th class="service">DESCRIPTION</th>
                <th class="desc">QTY</th>
                <th class="unit">NET</th>
                <th class="desc">VAT</th>
                <th class="desc">PRICE</th>
                <th class="unit">TOTAL</th>
              </tr>
            </thead>
          @endif  
            <tbody>
              @if(!empty($all_pending_order))
              @foreach($all_pending_order as $pending)
                  @php 
                      $sum = 0;
                  @endphp

                  @foreach($pending->product_variations as $product)
                    @php
                      $product_draft_vat =  $product->product_draft_id;
                      $product_draft_vat = \App\ProductDraft::select('vat')->where('id' , '=', $product_draft_vat)->get();
                    @endphp
                    @foreach($product_draft_vat as $draft_vat)
                      @php
                      echo $draft_vat = $draft_vat['vat'];
                      @endphp
                    @endforeach  
                  @if($inv_no == 2)
                  <tr style="overflow:hidden;">
                      <td colspan="4" style=" overflow:hidden; text-align:left !important; width:350px !important; word-break: break-all !important;" class="service">
                      {{$product->pivot->name}}
                    </td>
                      <td style="text-align: center !important;" class="qty">{{$product->pivot->quantity}}</td>
                  </tr>
                  @if((isset($InvoiceSetting['sku_no']) == 1 || isset($InvoiceSetting['variation_id']) == 1 || isset($InvoiceSetting['ean_no']) == 1 || isset($InvoiceSetting['attribute']) == 1) || (!isset($InvoiceSetting['sku_no'], $InvoiceSetting['variation_id'], $InvoiceSetting['ean_no'], $InvoiceSetting['attribute'])))
                  <tr>
                    <td colspan=6 style="text-align:left; color:green; word-break:break-all;">
                      @if(!isset($InvoiceSetting['sku_no']) || $InvoiceSetting['sku_no'] == 1)
                        SKU({{$product->sku}}) 
                      @endif
                      @if(!isset($InvoiceSetting['variation_id']) || $InvoiceSetting['variation_id'] == 1)
                        Variation ID({{$product->pivot->variation_id}}) 
                      @endif
                      @if(!isset($InvoiceSetting['ean_no']) || $InvoiceSetting['ean_no'] == 1)
                        EAN NO({{$product->pivot->ean_no}})
                      @endif
                      @if(!isset($InvoiceSetting['attribute']) || $InvoiceSetting['attribute'] == 1)
                        Attrubute: 
                        @php
                          $serial_att = $product->attribute;
                          $unserial_att = unserialize($serial_att);
                        @endphp
                        @foreach($unserial_att as $single_att)
                          @php
                            echo $single_att['attribute_name'].'('.$single_att['terms_name'].')';
                          @endphp
                        @endforeach
                      @endif
                    </td>
                  </tr>
                  @endif
                  @endif

                  @if($inv_no == 1)
                  <tr style="overflow:hidden;">
                      <td style=" overflow:hidden; text-align:left !important; width:350px !important; word-break: break-all !important;" class="service">
                      {{$product->pivot->name}}
                      </td>
                      <td class="qty">{{$product->pivot->quantity}}</td>
                      <td class="unit">
                        @if(!empty($draft_vat))
                            @php
                                $net_price = ($draft_vat / 100) * $product->pivot->price;
                                $net_price = $product->pivot->price - $net_price;
                                echo round($net_price, 2);
                            @endphp
                        
                        
                        @else
                          @if(!empty($InvoiceSetting['default_vat']))
                            @php
                              $vat_default = $InvoiceSetting['default_vat']
                            @endphp    
                          @else
                            @php
                              $vat_default = 20
                            @endphp  
                          @endif
                          @php
                              $net_price = ($vat_default / 100) * $product->pivot->price;
                              $net_price = $product->pivot->price - $net_price;
                              echo round($net_price, 2);
                          @endphp
                        @endif
                        @php 
                          $sum = $sum + $net_price*$product->pivot->quantity;
                        @endphp
                      </td>
                      <td style="text-align: center !important;" class="price">
                      @if(!empty($draft_vat))
                          {{$draft_vat}}
                      @else
                          @if(!empty($InvoiceSetting['default_vat']))
                              {{$InvoiceSetting['default_vat']}}
                            @else
                              20
                          @endif
                      @endif
                        %
                      </td>
                      <td style="text-align: center !important;" class="price">{{$product->pivot->price}}</td>
                      <td style="text-align: center !important;" class="unit">
                          @php
                              echo $unit_price_quantity = $product->pivot->quantity*$product->pivot->price;
                          @endphp    
                      </td>
                  </tr>
                  @if((isset($InvoiceSetting['sku_no']) == 1 || isset($InvoiceSetting['variation_id']) == 1 || isset($InvoiceSetting['ean_no']) == 1 || isset($InvoiceSetting['attribute']) == 1) || (!isset($InvoiceSetting['sku_no'], $InvoiceSetting['variation_id'], $InvoiceSetting['ean_no'], $InvoiceSetting['attribute'])))
                  <tr>
                    <td colspan=6 style="text-align:left; color:green; word-break:break-all;">
                    @if(!isset($InvoiceSetting['sku_no']) || $InvoiceSetting['sku_no'] == 1)
                      SKU({{$product->sku}}) 
                    @endif
                    @if(!isset($InvoiceSetting['variation_id']) || $InvoiceSetting['variation_id'] == 1)
                      Variation ID({{$product->pivot->variation_id}}) 
                    @endif
                    @if(!isset($InvoiceSetting['ean_no']) || $InvoiceSetting['ean_no'] == 1)
                      EAN NO({{$product->pivot->ean_no}})
                    @endif
                    @if(!isset($InvoiceSetting['attribute']) || $InvoiceSetting['attribute'] == 1)
                      Attrubute: 
                      @php
                        $serial_att = $product->attribute;
                        $unserial_att = unserialize($serial_att);
                      @endphp
                      @foreach($unserial_att as $single_att)
                        @php
                          echo $single_att['attribute_name'].'('.$single_att['terms_name'].')';
                        @endphp
                      @endforeach
                    @endif
                  </td>
                  </tr>
                  @endif
                  @endif
                  @endforeach  
              </tbody>
              @if($inv_no == 1)
                <tfoot>
                  <tr>
                    <td colspan="3"></td>
                    <td colspan="2">Net Total</td>
                    <td>
                      {{$total_net_sum = round($sum, 2)}}
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3"></td>
                    <td colspan="2">Discount</td>
                    <td>0%</td>
                  </tr>
                  <tr>
                    <td colspan="3"></td>
                    <td colspan="2">VAT</td>
                    <td>
                      @if(!empty($InvoiceSetting['default_vat']))
                        {{$InvoiceSetting['default_vat']}}
                      @else
                        20
                      @endif
                      %
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3"></td>
                    <td colspan="2">Total VAT</td>
                    <td>
                      @if(!empty($pending->total_price))
                      {{$total_vat = $pending->total_price - $total_net_sum}}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3"></td>
                    <td colspan="2">Grand Total</td>
                    <td>@if(!empty($pending->total_price)){{$pending->total_price}}@endif</td>
                  </tr>
                </tfoot>
                @endif
        @endforeach
        @endif 
      </table>
      
      <div id="thanks">Thank you!</div>
      @if(isset($InvoiceSetting['invoice_notice']))
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">{{$InvoiceSetting['invoice_notice']}}</div>
      </div>
      @endif
    </main>
  </body>
</html>