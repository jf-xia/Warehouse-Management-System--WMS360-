@extends('master')
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="content-top-header-card">
                            <p>Add Product In Empty Order</p>
                        </div>
                    </div>
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

                            <form action="{{url('save-product-empty-order')}}" method="post">
                                @csrf
                                <!--table start--->
                                <div class="row m-t-40">
                                    <div class="col-md-12 table-responsive">
                                        <div id="flash"></div>
                                        <table class="table table-bordered table-hover table-sortable" >
                                            <thead>
                                            <tr class="row">
                                                <th class="text-center col-3">
                                                    <label class="required"> SKU </label>
                                                </th>
                                                <th class="text-center col-3">
                                                    <label class="required">Quantity</label>
                                                </th>
                                                <th class="text-center col-3">
                                                    <label class="required">Price</label>
                                                </th>
                                                <th class="text-center col-3">
                                                    <label>Action</label>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <tr class="product-row row">
                                                <td class="col-3">
                                                    <input type="text" id="product_sku" name='product_sku[]' placeholder='' data='sku' class="form-control add-order-product" required>
                                                    <small class="text-danger"></small>
                                                </td>
                                                <td class="col-3">
                                                    <input type="number" id="quantity" name='quantity[]' placeholder='' data='quantity' class="form-control add-order-product"  required>
                                                    <small class="text-danger"></small>
                                                </td>
                                                <td class="col-3">
                                                    <input type="text" id="price" name='price[]' placeholder='' class="form-control" required>
                                                </td>
                                                <td class="col-3 text-center">
                                                    <button type="button" class="btn btn-danger remove-more-product">Remove</button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <input type="hidden" name="order_id" value="{{$order_id}}">
                                        <span><button type="button" class="btn btn-success add-more-product">Add More</button></span>
                                    </div>
                                </div>   <!--// End table --->

                                <div class="form-group row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" style="color: #fff;" class="btn btn-primary add-order-submit-btn">
                                            <b>Submit</b>
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

            $('.add-more-product').on('click', function () {
                console.log('found');

                var row_html = '<tr class="product-row row">\n' +
                    '                                                <td class="col-3">\n' +
                    '                                                    <input type="text" id="product_sku" name=\'product_sku[]\' placeholder=\'\' data=\'sku\' class="form-control add-order-product" required>\n' +
                    '                                                    <small class="text-danger"></small>'+
                    '                                                </td>\n' +
                    '                                                <td class="col-3">\n' +
                    '                                                    <input type="number" id="quantity" name=\'quantity[]\' placeholder=\'\' data=\'quantity\' class="form-control add-order-product" required>\n' +
                    '                                                    <small class="text-danger"></small>'+
                    '                                                </td>\n' +
                    '                                                <td class="col-3">\n' +
                    '                                                    <input type="text" id="price" name=\'price[]\' placeholder=\'\' class="form-control" required>\n' +
                    '                                                </td>\n' +
                    '                                                <td class="col-3 text-center">\n' +
                    '                                                    <button type="button" class="btn btn-danger remove-more-product">Remove</button>\n' +
                    '                                                </td>\n' +
                    '                                            </tr>';
                $('table tbody').append(row_html);

            });
            $('.table-bordered').on('click','.remove-more-product', function () {
                console.log('remove found');
                $(this).closest("tr").remove();
            });

            $('tbody').on('blur','.add-order-product',function(){
                var attrData = $(this).attr('data')
                var parentRow = $(this).closest('tr')
                var quantity = parentRow.find('#quantity').val()
                var sku = parentRow.find('#product_sku').val()
                
                if(quantity < 1 || quantity == undefined) {
                    parentRow.find('td:eq(1)').find('small').text('Invalid quantity')
                    $('.add-order-submit-btn').prop('disabled',true)
                    return false
                }else {
                    parentRow.find('td:eq(1)').find('small').text('')
                    $('.add-order-submit-btn').prop('disabled',false)
                }
                if(sku == '' || sku == undefined) {
                    parentRow.children('td:first').find('small').text('Please provide sku')
                    $('.add-order-submit-btn').prop('disabled',true)
                    return false
                }else {
                    parentRow.children('td:first').find('small').text('')
                    $('.add-order-submit-btn').prop('disabled',false)
                }
                var url = "{{asset('check-quantity-for-add-product-in-order')}}"
                var token = "{{csrf_token()}}"
                var dataObj = {
                    'sku': sku,
                    'quantity': quantity
                }
                console.log(dataObj)
                return fetch(url, {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": token
                    },
                    method: "post",
                    body: JSON.stringify(dataObj)
                })
                .then(response => {
                    return response.json()
                })
                .then(data => {
                    console.log(data)
                    if(data.type == 'error') {
                        parentRow.find('td:eq(1)').find('small').text(data.msg)
                        $('.add-order-submit-btn').prop('disabled',true)
                    }else {
                        parentRow.find('td:eq(1)').find('small').text('')
                        $('.add-order-submit-btn').prop('disabled',false)
                    }
                })
                .catch(error => {
                    Swal.showValidationMessage(`Request Failed: ${error}`)
                })
            })


        });


    </script>



@endsection
