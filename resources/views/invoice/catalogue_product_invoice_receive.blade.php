@extends('master')
@section('title')
    Catalogue | Receive Invoice | WMS360
@endsection
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item">Active Catalogue</li>
                        <li class="breadcrumb-item active" aria-current="page">Receive Invoice</li>
                    </ol>
                </div>
                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box shadow">
                            @if(Session::get('success'))
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{Session::get('success')}}</strong>
                                </div>
                            @endif

                            @if(Session::get('error'))
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{Session::get('error')}}</strong>
                                </div>
                            @endif
                            <div class="form-group row">
                                <div class="col-md-1"></div>
                                <h5 class="col-md-2">Catalogue : </h5>
                                <div class="col-md-8">
                                    <h5>{{$catalogue_name->name ?? ''}}</h5>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <input type="hidden" name="cost_price" id="cost_price" value="{{$variation_info->cost_price ?? ''}}">
                            <form action="{{url('save-catalogue-product-invoice-receive')}}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="invoice_no" class="col-md-2 col-form-label required">Invoice No</label>
                                    <div class="col-md-8">
                                    @if(isset($return_id))
                                    <select class="form-control" name="invoice_number" id="invoice_number" required>
                                        @if(is_array($allInvoiceNumbers) && count($allInvoiceNumbers) > 1)
                                            <option value="">Select Invoice</option>
                                        @endif
                                        @foreach($allInvoiceNumbers as $invoiceNumber)
                                            <option value="{{$invoiceNumber['invoice_number']}}" id="{{$invoiceNumber['vendor_id']}}">{{$invoiceNumber['invoice_number']}}</option>
                                        @endforeach
                                    </select>
                                    @else
                                        <input name="invoice_number" id="invoice_number" type="text" required data-parsley-maxlength="30" class="form-control" placeholder="">
                                        <div id="livesearch"></div>
                                    @endif
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <input type="hidden" name="return_order_id" id="return_order_id" value="{{$return_id ? $var_id : null}}">
                                <input type="hidden" name="pk_return_order_id" id="pk_return_order_id" value="{{$return_id ?? null}}">

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="vendor" class="col-md-2 col-form-label required">Supplier</label>
                                    <div class="col-md-8">
                                        <select name="vendor_id" class="form-control" required>
                                            @if(is_array($vendors) && count($vendors) > 1)
                                                <option value="">Select Supplier</option>
                                            @endif
                                            @isset($vendors)
                                                @foreach($vendors as $vendor)
                                                    <option value="{{$vendor->id ?? ''}}">{{$vendor->company_name ?? ''}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="date" class="col-md-2 col-form-label required">Date</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input name="receive_date" type="text" class="form-control" placeholder="DD/MM/YYYY" value="<?php echo date('d-m-Y H:i:s');?>" id="datepicker-autoclose" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="md md-event-note"></i></span>
                                            </div>
                                        </div><!-- input-group -->
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <input type="hidden" name="invoice_type" value="{{$return_id ?? ''}}">

                                <!--table start--->
                                <div class="row m-t-40">

                                    <input type="hidden" id="master_catalogue_id" value="{{$catalogue_name->id}}">
                                    <div class="col-md-12 table-responsive">
                                        <div id="flash"></div>
                                        <table class="table table-bordered table-hover table-sortable" >
                                            <thead>
                                            <tr class="row">
                                                <th class="text-center col-2">
                                                    <label class="required"> SKU </label>
                                                </th>
                                                <th class="text-center col-2">
                                                    <label>Variation</label>
                                                </th>
                                                <th class="text-center col-2">
                                                    <label class="required">Quantity</label>
                                                </th>
                                                <th class="text-center col-2">
                                                    <label class="required">Unit Cost</label>
                                                </th>
                                                <!-- <th class="text-center col-2">
                                                    <label class="required">Product Type</label>
                                                </th> -->
                                                @if($shelfUse == 1)
                                                <th class="text-center col-2" id="shelver_th">
                                                    <label class="required">Shelver</label>
                                                </th>
                                                @endif
                                                <th class="text-center col-2">
                                                    <label>Action</label>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <tr class="invoice-row row">
                                                <td class="col-2">
                                                    <select class="form-control product-unit-cost" name="product_variation_id[]" id="product_variation_id_1" required>
                                                        @if(is_array($product_variations) && count($product_variations) > 1)
                                                            <option value="">Select SKU</option>
                                                        @endif
                                                        @isset($product_variations)
                                                            @foreach($product_variations as $product_variation)
                                                                @if($product_variation->id == $variationId)
                                                                    <option value="{{$product_variation->id ?? ''}}" selected>
                                                                        {{$product_variation->sku ?? ''}}
                                                                    </option>
                                                                @else
                                                                    <option value="{{$product_variation->id ?? ''}}">
                                                                        {{$product_variation->sku ?? ''}}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        @endisset
                                                    </select>
                                                </td>
                                                <td class="col-2">
                                                    <span id="variation-show_1" class="variation_show">{{$singleVariationInfo['variation'] ?? 'No Variation'}}</span>
                                                </td>
                                                <td class="col-2">
                                                    <input type="number" id="quantity1" name='quantity[]' placeholder='' class="form-control quantity" value="{{$singleVariationInfo['return_quantity'] ?? ''}}" required>
                                                </td>
                                                <td class="col-2">
                                                    <input type="text" id="price1" name='price[]' placeholder='' class="form-control unit-price" value="{{$singleVariationInfo['cost_price'] ?? ''}}" required>
                                                </td>
                                                <!-- <td class="col-2">
                                                    <select class="form-control product_type" id="product_type_1" name="product_type[]" required>
                                                        @isset($conditions)
                                                            @foreach($conditions as $condition)
                                                                <option value="{{$condition->id ?? ''}}" @if($condition->id == $catalogue_name->condition) selected @endif>{{$condition->condition_name ?? ''}}</option>
                                                            @endforeach
                                                        @endif
                                                            <option value="0">Defected</option>
                                                    </select>
                                                </td> -->
                                                @if($shelfUse == 1)
                                                <td class="col-2 shelver-td">
                                                    <select id="shelver_user_id1" class="form-control shelver_user_id" name="shelver_user_id[]" required>
                                                        <option value="">Select Shelver</option>
                                                        @if(count($all_shelver->users_list) > 0)
                                                            @foreach($all_shelver->users_list as $shelver)
                                                                <option value="{{$shelver->id}}">{{$shelver->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="text-danger hide">Select Shelver</span>
                                                </td>
                                                @endif
                                                <td class="col-2 text-center">
                                                    <button type="button" class="btn btn-danger remove-more-invoice">Remove</button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <span>
                                        <button type="button" class="btn btn-primary receive-all-product">Select All ({{count($product_variations) ?? 0}})</button>&nbsp;
                                        <button type="button" class="btn btn-success add-more-invoice">Add More</button> <span class="total-variation hide">{{count($product_variations) ?? 0}}</span>
                                        </span>
                                    </div>
                                </div>   <!--// End table --->

                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" style="color: #fff;"  class="vendor-btn"  class="btn btn-primary">
                                            <b>Add</b>
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>  <!-- card-box -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content-page-->
    <script>
        $(document).ready(function() {
            $("tbody").on('change','.product-unit-cost',function () {
                var product_variation_id = $(this).val();
                var row_count_string = $(this).attr('id').split('product_variation_id_');
                var row_count = row_count_string[1];
                var return_order_id = $('#return_order_id').val();
                var tr = $(this).closest('tr')
                var trNumber = $('tbody tr').index(tr)
                var variationIds = []
                var variationIds = putSelectedVariationIdToArray(variationIds)

                showHideDropdownSku(variationIds)

                if(product_variation_id == ''){
                    $('#variation-show_'+row_count).html('No Variation');
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url: "{{url('/get-quantity')}}",
                    data: {
                        "_token" : "{{csrf_token()}}",
                        "product_variation_id" : product_variation_id,
                        "order_id" : return_order_id
                    },
                    success: function (data) {
                        $('#variation-show_'+row_count).html(data.variation);
                        $('#quantity'+row_count).val(data.quantity);
                        let exitCost = $('#price'+row_count).val()
                        $('#price'+row_count).val(exitCost != '' ? exitCost : data.cost_price);
                        addMoreButtonShowHide()
                    },
                    error: function (jqXHR, exception) {

                    }
                })

            });

            $('button.receive-all-product').on('click',function(){
                var firstShelverDiv = $('.invoice-row').first().find('.shelver_user_id')
                var firstShelverContent = firstShelverDiv.html()
                var firstShelverId = firstShelverDiv.val()
                var shelver = ''
                if(firstShelverId == ''){
                    var content = '<select id="shelver_user_id" class="form-control shelver_user_id" name="shelver_user_id[]" required>'+firstShelverContent+'</div>'
                    Swal.fire({
                        title: 'Choose Shelver',
                        html: content,
                        showCancelButton: true,
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                            var shelver = Swal.getPopup().querySelector('#shelver_user_id').value
                            if(shelver == ''){
                                Swal.showValidationMessage(`Select Shelver`)
                                return false
                            }
                            $('td.shelver-td .shelver_user_id > option').each(function(){
                                if(this.value == shelver){
                                    $(this).attr('selected','selected')
                                }
                            })
                            bulkReceiveRow(shelver)
                        }
                    })
                    return false
                }else{
                    bulkReceiveRow(firstShelverId)
                }
            })

            $(".product_type").on('change',function () {
                var product_type = $(this).val();
                var row_count_string = $(this).attr('id').split('product_type_');
                var row_count = row_count_string[1];
                if(product_type == 0){
                    $('#shelver_user_id'+row_count).attr("required", false);
                    $('#shelver_user_id'+row_count).hide();
                    return false;
                }else{
                    $('#shelver_user_id'+row_count).show();
                    $('#shelver_user_id'+row_count).attr("required", true);
                    return false;
                }
            });

            // var cost_price = $('#cost_price').val();
            // document.getElementById('price').value = cost_price;

            $('.add-more-invoice').on('click', function () {
                var firstShelverTd = $('.invoice-row').first()
                var firstShelverDiv = firstShelverTd.find('.shelver_user_id')
                var firstShelverId = firstShelverDiv.val()
                if(firstShelverId == ''){
                    firstShelverDiv.addClass('border border-danger')
                    firstShelverTd.find('.shelver-td span').removeClass('hide').addClass('d-block')
                    return false
                }else{
                    firstShelverDiv.removeClass('border border-danger')
                    firstShelverTd.find('.shelver-td span').removeClass('d-block').addClass('hide')
                }
                addMoreButtonShowHide()
                $('.invoice-row').first().clone(true).appendTo('tbody').each(function () {
                    var add_card_id = $('table tbody tr').length;
                    $(this).find('.product-unit-cost').attr("id","product_variation_id_"+add_card_id);
                    $(this).find('.variation_show').attr("id","variation-show_"+add_card_id);
                    $(this).find('input.quantity').attr("id","quantity"+add_card_id);
                    $(this).find('input.unit-price').attr("id","price"+add_card_id);
                    $(this).find('select.shelver_user_id').attr("id","shelver_user_id"+add_card_id);
                    $(this).find('.product_type').attr("id","product_type_"+add_card_id);
                    $('#quantity'+add_card_id).val('');
                    $('#variation-show_'+add_card_id).html('No Variation');
                    var shelver_id = $('#shelver_user_id1 option:selected').val();
                    var value_check = '#shelver_user_id'+add_card_id;
                    $('#shelver_user_id'+add_card_id).show();
                    $('#shelver_user_id'+add_card_id).attr("required", true);
                    $(value_check+" option").each(function(){
                        if($(this).val()==shelver_id){
                            $(this).attr("selected","selected");
                        }
                    });

                })
            });
            $('tbody').on('click','.remove-more-invoice', function () {
                let value = $('tbody tr').length;
                var variationIds = []
                if(value > 1) {
                    $(this).closest('tr').remove()
                    var variationIds = mapSelectedVariationIdToArray(variationIds)
                    var count = 1
                    $('tbody tr').each(function(i, data){
                        $(this).find('.product-unit-cost').attr('id','product_variation_id_'+count)
                        $(this).find('.variation_show').attr("id","variation-show_"+count);
                        $(this).find('input.quantity').attr("id","quantity"+count);
                        $(this).find('input.unit-price').attr("id","price"+count);
                        $(this).find('select.shelver_user_id').attr("id","shelver_user_id"+count);
                        $(this).find('.product_type').attr("id","product_type_"+count);
                        var shelver_id = $('#shelver_user_id1 option:selected').val();
                        var value_check = '#shelver_user_id'+count;

                        $(this).find(".product-unit-cost > option").each(function(i){
                            if(variationIds.includes($(this).val()) == true){
                                $(this).css('display','none')
                            }else{
                                $(this).css('display','block')
                            }
                        })
                        count++
                    })
                }else{
                    return false;
                }
                addMoreButtonShowHide()
            });

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
                            document.getElementById('quantity').readOnly = true;
                            document.getElementById('quantity').value = data.return_product_quantity;
                            document.getElementById('return_order_product_id').value = data.id;
                        },
                        error: function (jqXHR, exception) {

                        }
                    })
                }else{
                    document.getElementById('quantity').readOnly = false;
                }
            });

            $("#invoice_number").on('input', function () {
                var invoice_number = $('input[name=invoice_number]').val();
                if(invoice_number == ''){
                    $('#livesearch').hide();
                    return false;
                }
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
                        $('select[name="vendor_id"]').find('option[value='+data.vendor_id+']').attr("selected",true);
                        //document.getElementById('vendor_id'). = 1;
                        document.getElementById("livesearch").style.border = "1px solid #A5ACB2";

                    },
                    error: function (jqXHR, exception) {

                    }
                });
                document.getElementById("invoice_number").value = value;
                $('#livesearch').hide();
                // var value = $(event.target).text();
                // document.getElementById("invoice_number").value = value;
                // $('#livesearch').hide();
            });
            $('select#invoice_number').on('change',function (event) {
                var value = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: '{{url('/get-vendor').'?_token='.csrf_token()}}',
                    data: {
                        'invoice_number': value
                    },
                    success: function (data) {
                        $('select[name="vendor_id"]').find('option').attr("selected",false);
                        $('select[name="vendor_id"]').find('option[value='+data.vendor_id+']').attr("selected",true);
                        //document.getElementById('vendor_id'). = 1;
                        // document.getElementById("livesearch").style.border = "1px solid #A5ACB2";

                    },
                    error: function (jqXHR, exception) {

                    }
                });

                // document.getElementById("invoice_number").value = value;
            });
            $('select[name="vendor_id"]').on('change',function(){
                var supplierId = $(this).val()
                if(supplierId == ''){
                    alert('Please select supplier')
                }
                $('select[name="invoice_number"] > option').each(function(){
                    if(this.id != ''){
                        if(supplierId == this.id){
                            $("select[name='invoice_number'] option[id=" + this.id + "]").show();
                        }else{
                            $("select[name='invoice_number'] option[id=" + this.id + "]").hide();
                        }
                    }
                })
            })
        });

        function putSelectedVariationIdToArray(variationIds){
            $('tbody tr').each(function(i, data){
                $(this).find(".product-unit-cost > option:selected").each(function(i,v) {
                    variationIds.push($(this).val())
                });
            })
            return variationIds
        }

        function mapSelectedVariationIdToArray(variationIds){
            $('tbody tr').each(function(i, data){
                var opt = $(this).find(".product-unit-cost > option:selected").map(function(i,v) {
                    variationIds.push(this.value)
                });
            })
            return variationIds
        }

        function showHideDropdownSku(variationIds){
            $('tbody tr').each(function(i, data){
                $(this).find(".product-unit-cost > option").each(function(i){
                    if(variationIds.includes($(this).val()) == true){
                        $(this).css('display','none')
                    }else{
                        $(this).css('display','block')
                    }
                })
            })
        }

        function addMoreButtonShowHide(){
            var totalVariation = $('span.total-variation').text()
            var count = $('table tbody tr').length;
            if(count >= totalVariation){
                $('.add-more-invoice').addClass('hide')
            }else{
                $('.add-more-invoice').removeClass('hide')
            }
        }
        // $(".product-unit-cost").on('change',function () {
        //     let prodcut_id = $('.product-unit-cost').val();
        //     $.ajax({
        //         type: "post",
        //         url:"{{url('get-product-price-ajax')}}",
        //         data: {
        //             "_token" : "{{csrf_token()}}",
        //             "prodcut_id" : prodcut_id
        //         },
        //         success: function (response) {
        //             $('#price').val(response.data);
        //         }
        //     })
        // });
        function bulkReceiveRow(shelverId){
            let masterCatalogueId = $('#master_catalogue_id').val()
            $.ajax({
                type: "POST",
                url: "{{url('/get-quantity')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "master_catalogue_id" : masterCatalogueId
                },
                success: function (response) {
                    var allProductInvoice = ''
                    var shelverOption = ''
                    $('span.total-variation').text(response.invoice_info.length)
                    if(shelverId != undefined){
                        response.shelver_info.users_list.forEach(function(shelver){
                            if(shelver.id == shelverId){
                                shelverOption += '<option value="'+shelver.id+'" selected>'+shelver.name+'</option>'
                            }else{
                                shelverOption += '<option value="'+shelver.id+'">'+shelver.name+'</option>'
                            }
                        })
                    }
                    var variationIds = []
                    var count = 1
                    response.invoice_info.forEach(function(invoice){
                        allProductInvoice += '<tr class="invoice-row row">'
                            +'<td class="col-2">'
                            +'<select class="form-control product-unit-cost" name="product_variation_id[]" id="product_variation_id_'+count+'" required>'
                            if(response.invoice_info.length > 1){
                                allProductInvoice += '<option value="">Select SKU</option>'
                            }
                            response.invoice_info.forEach(function(info){
                                if(info.sku === invoice.sku){
                                    allProductInvoice += '<option value="'+invoice.variation_id+'" selected>'+invoice.sku+'</option>'
                                }else{
                                    allProductInvoice += '<option value="'+info.variation_id+'">'+info.sku+'</option>'
                                }
                            })
                            allProductInvoice += '</select>'
                            +'</td>'
                            +'<td class="col-2">'
                            +'<span id="variation-show_'+count+'" class="variation_show">'+invoice.variation+'</span>'
                            +'</td>'
                            +'<td class="col-2">'
                            +' <input type="number" id="quantity'+count+'" name="quantity[]" placeholder="" class="form-control quantity" value="" required>'
                            +'</td>'
                            +'<td class="col-2">'
                            +'<input type="text" id="price'+count+'" name="price[]" placeholder="" class="form-control unit-price" value="'+invoice.cost_price+'" required>'
                            +'</td>'
                            if(shelverId != undefined){
                                allProductInvoice += '<td class="col-2">'
                                +'<select id="shelver_user_id'+count+'" class="form-control shelver_user_id" name="shelver_user_id[]" required>'
                                +'<option value="">Select Shelver</option>'
                                +shelverOption+
                                '</select>'
                                +'</td>'
                            }
                            allProductInvoice += '<td class="col-2 text-center">'
                            +'<button type="button" class="btn btn-danger remove-more-invoice">Remove</button>'
                            +'</td>'
                            +'</tr>'
                            //variationIds.push(invoice.variation_id)
                            count++
                    });
                    $('table tbody').html(allProductInvoice)
                    var variationIds = putSelectedVariationIdToArray(variationIds)
                    showHideDropdownSku(variationIds)
                    addMoreButtonShowHide()
                    // $('#variation-show_'+row_count).html(data.variation);
                    // $('#quantity'+row_count).val(data.quantity);
                    // let exitCost = $('#price'+row_count).val()
                    // $('#price'+row_count).val(exitCost != '' ? exitCost : data.cost_price);
                },
                error: function (jqXHR, exception) {

                }
            })
        }


        @if ($message = Session::get('new_product_success'))
            swal("{{ $message }}", "", "success");
        @endif

    </script>
@endsection
