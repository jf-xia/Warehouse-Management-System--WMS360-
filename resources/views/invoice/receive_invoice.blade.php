@extends('master')

@section('title')
    Add Inventory | WMS360
@endsection

@section('content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <div class="d-flex justify-content-between align-items-center">
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item">Inventory</li>
                        <li class="breadcrumb-item active" aria-current="page">Add Inventory</li>
                    </ol>
                </div>



                <div class="row m-t-20 receive-invoice">
                    <div class="col-md-12">
                        <div class="card-box pt-5 shadow">

{{--                                @csrf--}}
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="printer_option" class="col-md-2 col-form-label">Printer Option</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="printer_option" id="printer_option">
                                            <option value="1">On</option>
                                            <option value="0">Off</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1"></div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="invoice_no" class="col-md-2 col-form-label required">Invoice No</label>
                                    <div class="col-md-8">
                                        <input name="invoice_number" id="invoice_number" type="text" value="1002" required data-parsley-maxlength="30" class="form-control">
                                        <div id="livesearch" v-on:click="getVendor(this)"></div>
                                    </div>

                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="vendor" class="col-md-2 col-form-label required">Supplier</label>
                                    <div class="col-md-8">
                                        <select id="vendor_id" name="vendor_id" class="form-control" required>
                                            @if(count($vendors) == 1)
                                                @foreach($vendors as $vendor)
                                                    <option value="{{$vendor->id}}">{{$vendor->company_name}}</option>
                                                @endforeach
                                            @else
                                                <option hidden>Select Supplier</option>
                                                @foreach($vendors as $vendor)
                                                    <option value="{{$vendor->id}}">{{$vendor->company_name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="date" class="col-md-2 col-form-label required">Date</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input name="receive_date" type="text" class="form-control" placeholder="MM/DD/YYYY" value="<?php echo date('Y-m-d H:i:s');?>" id="datepicker-autoclose" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="md md-event-note"></i></span>
                                            </div>
                                        </div><!-- input-group -->
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="date" class="col-md-2 col-form-label form">Return Order</label>
                                    <div class="col-md-4 m-t-10">
                                        <div class="custom-control custom-checkbox">
                                            <input name="return_order" type="checkbox" class="custom-control-input" id="return_order_checkbox" onclick="returnOrder()">
                                            <label class="custom-control-label" for="return_order_checkbox">  </label>
                                        </div>
                                    </div>
                                    <div class="col-md-5"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3"></div>
{{--                                    <label for="date" class="col-md-2 col-form-label">Return Order</label>--}}
                                    <div class="col-md-4 m-t-10">
                                        <div class="custom-control dropdown">
                                            <select name="order_id" class="form-control" style="margin-left: -24px;" id="return_order" onchange="get_return_order_product_sku();" disabled>
                                                @isset($all_return_order)
                                                    @if($all_return_order->count() == 1)
                                                        @foreach($all_return_order as $return_order)
                                                            @if(isset($return_order->is_return_product_shelved[0]))
                                                                <option value="{{$return_order->orders->id}}">{{$return_order->orders->order_number}}</option>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <option hidden>Select Return Order</option>
                                                        @foreach($all_return_order as $return_order)
                                                            @if(isset($return_order->is_return_product_shelved[0]))
                                                                <option value="{{$return_order->orders->id}}">{{$return_order->orders->order_number}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endisset
                                            </select>
                                        </div>
                                    </div>
                                    <input id="return_order_product_id" name="return_order_product_id" value=""  type="hidden">
                                    <div class="col-md-7"></div>
                                </div>

                                    <!--table start--->
                                    <div class="row m-t-40">
                                        <div class="col-md-12 table-responsive">
                                            <div id="flash"></div>
                                            <table class="table table-bordered table-hover table-sortable" >
                                                <thead>
                                                <tr class="row">
                                                    <th class="text-center col-2">
                                                        <label class="required"> SKU </label>
                                                    </th>
                                                    <th class="text-center col-2">
                                                        Variation
                                                    </th>
                                                    <th class="text-center col-1">
                                                        <label class="required">Quantity</label>
                                                    </th>
                                                    <th class="text-center col-1">
                                                        <label class="required">Unit Cost</label>
                                                    </th>
                                                    <th class="text-center col-2">
                                                        <label class="required">Product Type</label>
                                                    </th>
                                                    @if($shelfUse == 1)
                                                        <th class="text-center col-2" id="shelver_th">
                                                            <label class="required">Shelver</label>
                                                        </th>
                                                    @endif
                                                    <th class="text-center col-2">
                                                        <label class="required">Total Cost</label>
                                                    </th>
                                                    {{--                                                    <th>Action</th>--}}
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <tr id="product_variation_id" class="invoice-row row">
                                                    <td class="col-2">

                                                        <select class="form-control select2 product-unit-cost" name="product_variation_id" id="product_variation_id" required>
                                                            @if(count($product_variations) == 1)
                                                                @foreach($product_variations as $product_variation)
                                                                    <option value="{{$product_variation->id}}">
                                                                        {{$product_variation->sku}}
    {{--                                                                    {{$product_variation->attribute1 ? '/'.$product_variation->attribute1 : ''}}{{$product_variation->attribute2 ? '/'.$product_variation->attribute2 : ''}}--}}
    {{--                                                                    {{$product_variation->attribute3 ? '/'.$product_variation->attribute3 : ''}}{{$product_variation->attribute4 ? '/'.$product_variation->attribute4 : ''}}--}}
    {{--                                                                    {{$product_variation->attribute5 ? '/'.$product_variation->attribute5 : ''}}{{$product_variation->attribute6 ? '/'.$product_variation->attribute6 : ''}}--}}
    {{--                                                                    {{$product_variation->attribute7 ? '/'.$product_variation->attribute7 : ''}}{{$product_variation->attribute8 ? '/'.$product_variation->attribute8 : ''}}--}}
    {{--                                                                    {{$product_variation->attribute9 ? '/'.$product_variation->attribute9 : ''}}{{$product_variation->attribute10 ? '/'.$product_variation->attribute10 : ''}}--}}
                                                                    </option>
    {{--                                                                <input type="hidden" id="variaton_value" value="1">--}}
                                                                @endforeach
                                                            @else
                                                                <option selected="true" disabled="disabled">Select SKU</option>
                                                                @foreach($product_variations as $product_variation)
                                                                    <option value="{{$product_variation->id}}">{{$product_variation->sku}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td class="col-2">
                                                        <span id="variation-show">No Variation</span>
                                                    </td>
                                                    <td class="col-1">
                                                        <input type="number" id="quantity" name='quantity' placeholder='' class="form-control" required>
                                                    </td>
                                                    <td class="col-1">
                                                        <input type="text" id="price" name='price' placeholder='' class="form-control" required>
                                                    </td>
                                                    <td class="col-2">
                                                        <select onchange="productType()" class="form-control" name="product_type" required>
                                                            <option hidden>Select type</option>
                                                            <option value="1">New</option>
                                                            <option value="0">New With Defected</option>
                                                        </select>
                                                    </td>
                                                    @if($shelfUse == 1)
                                                        <td class="col-2" id="shelver_td">
                                                            <select id="shelver_user_id" class="form-control select2" name="shelver_user_id" required>
                                                                @if(count($all_shelver->users_list) == 1)
                                                                    @foreach($all_shelver->users_list as $shelver)
                                                                        <option value="{{$shelver->id}}">{{$shelver->name}}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option selected="true" disabled="disabled">Select Shelver</option>
                                                                    @foreach($all_shelver->users_list as $shelver)
                                                                        <option value="{{$shelver->id}}">{{$shelver->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </td>
                                                    @endif
                                                    <td class="col-2">
                                                        <input type="text" value="0" id="total_price"  name='total_price' placeholder='' class="form-control" required>
                                                    </td>
{{--                                                    <td><button type="button" class="btn btn-danger remove-more-invoice">Remove</button></td>--}}
                                                </tr>
                                                </tbody>
                                            </table>
{{--                                            <span><button class="btn btn-success add-more-invoice">Add More</button></span>--}}
{{--                                            <button type="button" onclick="myFunction()"  class='btn btn-danger row-remove'>Delete</button>--}}
{{--                                            <button type="button" id="add_row"  class='btn btn-success'>Add Row</button>--}}
{{--                                            <a><div class="button btn-success" >add row</div></a> <a><div class="button btn-danger" >Delete</div></a>--}}
{{--                                           <div><input type="hidden" value="0" id="add" class="btn btn-primary float-right"></div>--}}
                                        </div>
                                    </div>   <!--// End table --->

{{--                                <div class="row">--}}
{{--                                    <div class="col-md-2"></div>--}}
{{--                                    <div class="col-md-6 balance">--}}
{{--                                        <table>--}}
{{--                                            <tr>--}}
{{--                                                <th class="text-center">Total Price</th>--}}
{{--                                                <td><input name="total"> </td>--}}
{{--                                            </tr>--}}
{{--                                        </table>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-4"></div>--}}
{{--                                </div>--}}



{{--                                <div class="form-group row m-t-10">--}}
{{--                                      <div class="col-md-6 text-center">--}}
{{--                                          <button class="vendor-btn float-left" type="submit" class="btn btn-primary waves-effect waves-light">--}}
{{--                                              <b>Submit</b>--}}
{{--                                          </button>--}}
{{--                                      </div>--}}
{{--                                    <div class="col-md-6"></div>--}}






                                 <div class="form-group row vendor-btn-top">
                                      <div class="col-md-12 text-center">
                                          <a style="color: #fff;" id="add"  class="vendor-btn"  class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#myModal">
                                              <b>Add</b>
                                          </a>
                                      </div>

                                     <!-- The Modal -->
                                     <div class="modal fade" id="myModal">
                                         <div class="modal-dialog modal-lg">
                                             <div class="modal-content">
                                                 <!-- Modal Header -->
                                                 <div class="modal-header">
                                                     <h4 class="modal-title"> Receive Invoice </h4>
                                                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                 </div>

                                                 <div id="modalAjax"></div>

                                                 <div class="modal-footer">
                                                     <button id="submitc" type="submit" class="btn btn-success" data-dismiss="modal">Save</button>
                                                     <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                 </div>

                                             </div>
                                         </div>
                                     </div>  <!-- // END The Modal -->

                                  </div>


                        </div>  <!-- card-box -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content-page-->


    <script>
        // Select 2 option dropdown
        $('.select2').select2();


        $(document).ready(function() {

            // $('.add-more-invoice').on('click', function () {
            //     $('.invoice-row').first().clone(true).appendTo('tbody');
            // });
            // $('.remove-more-invoice').on('click', function () {
            //     let value = $('tbody tr').length;
            //     if(value > 1) {
            //         $(this).closest('tr').remove();
            //     }else{
            //         return false;
            //     }
            // });

            $(".searchbox").val($("#listBox1 :selected").val());

            $("#product_variation_id").on('change',function () {
                if(document.getElementById('return_order_checkbox').checked) {
                    var product_variation_id = $('select[name=product_variation_id]').val();
                    var order_id = $('select[name=order_id]').val();

                    $.ajax({
                        type: 'POST',
                        url: '{{url('/get-quantity').'?_token='.csrf_token()}}',
                        data: {
                            'product_variation_id': product_variation_id, 'order_id': order_id
                        },
                        success: function (data) {

                            console.log(data.quantity);
                            console.log(data.variation);
                            $('#variation-show').html(data.variation);
                            $('#price').val(data.cost_price);
                            document.getElementById('quantity').readOnly = true;
                            document.getElementById('quantity').value = data.quantity;
                            document.getElementById('return_order_product_id').value = data.id;

                        },
                        error: function (jqXHR, exception) {

                            console.log(data);
                        }
                    })
                }else{
                    document.getElementById('quantity').readOnly = false;
                }
            });
            $("#add").on('click', function () {
                var invoice_number = $('input[name=invoice_number]').val();
                var vendor_id = $('select[name=vendor_id]').val();
                var receive_date = $('input[name=receive_date]').val();
                var product_variation_id = $('select[name=product_variation_id]').val();
                var shelver_user_id = $('select[name=shelver_user_id]').val();
                var quantity = $('input[name=quantity]').val();
                var product_type = $('select[name=product_type]').val();
                var price = $('input[name=price]').val();
                var total_price = $('input[name=total_price]').val();
                if(document.getElementById('return_order_checkbox').checked){
                    var order_id = $('select[name=order_id]').val();
                }else {
                    var order_id = null;
                }

                console.log(invoice_number);
                console.log(vendor_id);

                if(invoice_number == ''){
                    swal("Error", "Please give an invoice number", "warning");
                    return false;
                }
                if(vendor_id == ''){
                    swal("Error", "Please select a supplier", "warning");
                    return false;
                }
                if(product_variation_id == ''){
                    swal("Error", "Please select a SKU", "warning");
                    return false;
                }

                if(quantity == ''){
                    swal("Error", "Please select quantity", "warning");
                    return false;
                }

                if(price == ''){
                    swal("Error", "Please select unit price", "warning");
                    return false;
                }

                if(product_type == 1){
                    if(shelver_user_id == ''){
                        swal("Error", "Please select shelver", "warning");
                        return false;
                    }
                }




                // console.log('type'+invoice_number);
                $.ajax({
                    type:'POST',
                    url:'{{url('/invoice-check').'?_token='.csrf_token()}}',
                    data: {
                        'invoice_number' : invoice_number, 'vendor_id' : vendor_id, 'receive_date' : receive_date,
                        'product_variation_id' : product_variation_id, 'shelver_user_id' : shelver_user_id, 'quantity' : quantity,
                        'product_type' : product_type, 'price' : price, 'total_price' : total_price, 'order_id' : order_id
                    },
                    success:function(data) {
                        // var res = '';
                        // res += '<div class="alert alert-success alert-block">\n' +
                        //     '                        <button type="button" class="close" data-dismiss="alert">×</button>\n' +
                        //     '                        <strong id="flash">'+data +'</strong>\n' +
                        //     '                    </div>';
                         $("#modalAjax").html(data);



                        console.log(data);
                    },
                    error: function(jqXHR, exception) {
                        // var res = '';
                        //
                        // res += '<div class="alert alert-danger alert-block">\n' +
                        //     '                        <button type="button" class="close" data-dismiss="alert">×</button>\n' +
                        //     '                        <strong>'+exception+'</strong>\n' +
                        //     '                    </div>';
                        // $("#flash").html(res);
                        console.log(data);
                    }

                });
            });

            $("#submitc").on('click', function () {


                var printer_option = $('select[name=printer_option]').val();
                var invoice_number = $('input[name=invoice_number]').val();
                var vendor_id = $('select[name=vendor_id]').val();
                var receive_date = $('input[name=receive_date]').val();
                var product_variation_id = $('select[name=product_variation_id]').val();
                var shelver_user_id = $('select[name=shelver_user_id]').val();
                var quantity = $('input[name=quantity]').val();
                var product_type = $('select[name=product_type]').val();
                var price = $('input[name=price]').val();
                var total_price = $('input[name=total_price]').val();
                if(document.getElementById('return_order_checkbox').checked){
                    var order_id = $('select[name=order_id]').val();
                    var return_order_product_id = $('input[name=return_order_product_id]').val();
                }else {
                    var order_id = null;
                }


                //console.log(order_id);
                $.ajax({
                    type:'POST',
                    url:'{{url('/invoice').'?_token='.csrf_token()}}',
                    data: {
                        'printer_option' : printer_option,'invoice_number' : invoice_number, 'vendor_id' : vendor_id, 'receive_date' : receive_date,
                        'product_variation_id' : product_variation_id, 'shelver_user_id' : shelver_user_id, 'quantity' : quantity,
                        'product_type' : product_type, 'price' : price, 'total_price' : total_price,'order_id' : order_id, return_order_product_id: return_order_product_id
                    },
                    success:function(data) {
                        // var res = '';
                        // res += '<div class="alert alert-success alert-block">\n' +
                        //     '                        <button type="button" class="close" data-dismiss="alert">×</button>\n' +
                        //     '                        <strong id="flash">'+data +'</strong>\n' +
                        //     '                    </div>';
                        // $("#flash").html(res);

                        if(data != 1) {
                            w = window.open(window.location.href, "_blank");
                            w.document.open();
                            w.document.write(data);
                            w.document.close();
                            // w.window.print();
                            swal.fire(
                                'Good Jobs',
                                'Product successfully received at invoice number: ' + invoice_number,
                                'success'
                            );
                            // swal("Good job!", "Product successfully received at invoice number: " + invoice_number, "success");
                        }else{
                            swal.fire(
                                'Good Jobs',
                                'Product successfully received at invoice number: ' + invoice_number,
                                'success'
                            );
                            // swal("Good job!", "Product successfully received at invoice number: " + invoice_number, "success");
                        }

                        //console.log(data);
                    },
                    error: function(jqXHR, exception) {
                        // var res = '';
                        //
                        // res += '<div class="alert alert-danger alert-block">\n' +
                        //     '                        <button type="button" class="close" data-dismiss="alert">×</button>\n' +
                        //     '                        <strong>'+exception+'</strong>\n' +
                        //     '                    </div>';
                        // $("#flash").html(res);

                        swal("Bad Job!", exception, "error");
                    }

                });

                // console.log(data);
            });

            $("#quantity").on('input', function () {

                var price = $('input[name=price]').val();
                var quantity = $('input[name=quantity]').val();

                     document.getElementById("total_price").value =  (parseFloat(price) * parseInt(quantity)).toFixed(2) ;
                if(!quantity){
                    document.getElementById("total_price").value =  parseFloat(price).toFixed(2) ;
                }

            });
            $("#price").on('input', function () {
                var price = $('input[name=price]').val();
                var quantity = $('input[name=quantity]').val();

                    document.getElementById("total_price").value =  (parseFloat(price) * parseInt(quantity)).toFixed(2) ;
                    if(!quantity){
                        document.getElementById("total_price").value =  parseFloat(price).toFixed(2) ;
                    }

            });

            $("#invoice_number").on('input', function () {
                var invoice_number = $('input[name=invoice_number]').val();
                //console.log(invoice_number);
                $.ajax({
                    type:'POST',
                    url:'{{url('/invoice/number').'?_token='.csrf_token()}}',
                    data: {
                        'invoice_number' : invoice_number
                    },
                    success:function(data) {
                        $('#livesearch').show();
                         var res = '';
                         document.getElementById("livesearch").style.border="1px solid #A5ACB2";

                        if($.trim(data)){
                            Object.keys(data).forEach(function(key,value) {

                                Object.keys(data[value]).forEach(function(key1,value1) {
                                    console.log(data[value][key1]);
                                    res +='<option style="cursor:pointer">' + data[value][key1] +'</option' +"<br>";
                                })
                            });
                            document.getElementById("livesearch").innerHTML=res;
                        }

                        if(!$.trim(data)){
                            document.getElementById("livesearch").innerHTML= 'no match found';
                        }
                    },
                    error: function(jqXHR, exception) {

                    }

                });

            });
            $('#livesearch').on('click',function (event) {
                var value = $(event.target).text();
                $.ajax({
                    type: 'POST',
                    url: '{{url('/get-vendor').'?_token='.csrf_token()}}',
                    data: {
                        'invoice_number': value
                    },
                    success: function (data) {
                        console.log(data.vendor_id);
                        $('select[name="vendor_id"]').find('option[value='+data.vendor_id+']').attr("selected",true);
                        //document.getElementById('vendor_id'). = 1;
                        document.getElementById("livesearch").style.border = "1px solid #A5ACB2";

                    },
                    error: function (jqXHR, exception) {

                    }
                });
                document.getElementById("invoice_number").value = value;
                $('#livesearch').hide();
            });


        });

        function productType () {
             var product_type = $('select[name=product_type]').val();

             if(product_type == 0){
                 document.getElementById("shelver_user_id").selectedIndex = 0;
                document.getElementById('shelver_th').hidden = true;
                document.getElementById('shelver_td').hidden = true;

             }else if(product_type == 1){
                document.getElementById('shelver_th').hidden = false;
                document.getElementById('shelver_td').hidden = false;
            }
            console.log(product_type);
        }
        function returnOrder()
        {
            //console.log('1');
            if (document.getElementById('return_order_checkbox').checked)
            {
                document.getElementById('return_order').disabled  = false;

            } else {
                document.getElementById('return_order').disabled  = true;
            }
        };

        function get_return_order_product_sku() {
            var id = document.getElementById("return_order").value;
            if (Number(id) > 0) {
                document.getElementById('return_order_checkbox').disabled = true;
            }else{
                console.log(id);
                document.getElementById('return_order_checkbox').checked = false;
                document.getElementById('return_order').disabled = true;
                document.getElementById('return_order_checkbox').disabled = false;
            }
            console.log(id);
            $.ajax({
                type: 'GET',
                url: '{{url('/get-return-order-product-sku')}}',
                data: {
                    "_token ": "{{csrf_token()}}",
                    "id": id,
                },
                success: function (data) {
                    //$("#msg").html(data.msg);
                    $("#product_variation_id").html(data);
                }

            });
        }

        $(".product-unit-cost").on('change',function () {
            let prodcut_id = $('.product-unit-cost').val();
            // console.log(prodcut_id);

            $.ajax({
                type: "post",
                url:"{{url('get-product-price-ajax')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "prodcut_id" : prodcut_id
                },
                success: function (response) {
                    console.log(response.data);
                    console.log(response.variation);
                    $('#variation-show').html(response.variation);
                    $('#price').val(response.data);
                }
            })
        });
    </script>





@endsection
