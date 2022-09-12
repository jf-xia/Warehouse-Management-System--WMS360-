
@extends('master')

@section('title')
    Order | Exchange Order Product | WMS360
@endsection

@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">Order</li>
                            <li class="breadcrumb-item active" aria-current="page">Exchange Order Product</li>
                        </ol>
                    </div>
                </div>


                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box shadow">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (Session::has('success_msg'))
                                <div class="alert alert-success">
                                    {!! Session::get('success_msg') !!}
                                </div>
                            @endif

                            @if (Session::has('error'))
                                <div class="alert alert-danger">
                                    {!! Session::get('error') !!}
                                </div>
                            @endif

                            <form role="form" class="mobile-responsive" action="{{url('save-exchange-order-product')}}" method="post">
                                @csrf
                                <input type="hidden" name="product_order_id" value="{{$id}}">
                                <input type="hidden" name="picked_quantity" value="{{$product_info->picked_quantity}}">
                                <div class="form-group row">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="name" class="col-form-label required">ID</label>
                                        <input type="text" name="id" class="form-control" id="id" value="{{$id}}" placeholder="Enter ID here" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="name" class="col-form-label required">Ordered Product SKU</label>
                                        <input type="text" name="order_sku" class="form-control" id="order_sku" value="{{ $product_info->variation_info->sku ? $product_info->variation_info->sku : old('order_sku') }}" placeholder="Enter Ordered SKU here (Ex. A5-5600-M)" readonly required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="name" class="col-form-label required">Quantity</label>
                                        <input type="text" name="order_quantity" class="form-control" id="order_quantity" value="{{ $product_info->quantity ? $product_info->quantity : old('order_quantity') }}" placeholder="Enter Ordered Quantity here (Ex. 1)" readonly required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="name" class="col-form-label required">Exchange Product SKU</label>
                                        <input type="text" name="exchange_sku" class="form-control" id="exchange_sku" value="{{ old('exchange_sku') }}" placeholder="Enter Exchanged SKU here (Ex. A6-5300-S)" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="name" class="col-form-label required">Quantity</label>
                                        <input type="text" name="exchange_quantity" class="form-control" id="exchange_quantity" value="{{ old('exchange_quantity') }}" placeholder="Enter Exchange Quantity here (Ex. 1)" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="catalogue_title" class="col-form-label required">Catalogue Title</label>
                                        <input type="text" name="catalogue_title" class="form-control" id="catalogue_title" value="{{old('catalogue_title')}}" placeholder="Enter New SKU Catalogue Title" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="product_price" class="col-form-label required">Product Unit Price</label>
                                        <input type="text" name="product_price" class="form-control" id="product_price" value="{{old('product_price')}}" placeholder="Enter Product Unit Price" required>
                                    </div>
                                </div>

                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
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

    </div>
    <script>

        $(document).ready(function(){
            $('#exchange_sku').on('blur',function(){
                var exchangeSKU = $(this).val()
                if(exchangeSKU == '' || exchangeSKU == 'undefined' || exchangeSKU == null) {
                    Swal.fire('SKU Not Found','If you found this pop up, make sure you click outside of exchange sku product input field after given exchange sku','warning');
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url: "{{asset('master-catalogue-by-sku-ajax')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'sku': exchangeSKU
                    },
                    beforeSend: function() {
                        $('#ajax_loader').show()
                    },
                    success: function(response) {
                        console.log(response);
                        if(response.type == 'success'){
                            if(response.result != null) {
                                $('#catalogue_title').val(response.result.product_draft.name)
                                $('#product_price').val(response.result.sale_price)
                            }
                        }else {
                            $('#catalogue_title').val('')
                            $('#product_price').val('')
                            Swal.fire('Oops',response.msg,response.icon)
                        }
                    },
                    error: function(error) {
                        console.log(error)
                    },
                    complete: function() {
                        $('#ajax_loader').hide()
                    }
                })
            })
        })

    </script>
@endsection
