
@extends('master')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Invoice</li>
                            <li class="breadcrumb-item active" aria-current="page">Invoice Edit</li>
                        </ol>
                    </div>
                </div>

                <!-- Page-Title -->
                <!-- <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="vendor-title">
                            <p>Invoice Edit</p>
                        </div>
                    </div>
                </div> -->
                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box">

                            <form  class="vendor-form" action="{{route('invoice-product.update',$invoice_product->id)}}" method="post">
                                @csrf
                                @method('PUT')

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="invoice_no" class="col-md-2 col-form-label">Invoice No</label>
                                    <div class="col-md-8">
                                        <input type="text"  class="form-control" id="invoice_no" value="{{\App\Invoice::find($invoice_product->invoice_id)->invoice_number}}" placeholder="" disabled>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="sku" class="col-md-2 col-form-label">Sku</label>
                                    <div class="col-md-8">
                                        <input type="text"  class="form-control" id="sku" value="{{\App\ProductVariation::find($invoice_product->product_variation_id)->sku}}" placeholder="" disabled>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                @if($shelfUse == 1)
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="shelver" class="col-md-2 col-form-label required">Shelver</label>
                                    <div class="col-md-8">
                                        <select name="shelver_user_id" class="form-control" required >
                                            @if($invoice_product->shelver_user_id)
                                                <option value="{{$invoice_product->shelver_user_id}}">{{\App\User::find($invoice_product->shelver_user_id)->name}}</option>
                                                @foreach($users as $user)
                                                    @if(\App\User::find($invoice_product->shelver_user_id)->name != $user->name)
                                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                                <option value="">select Shelver</option>
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                @endif

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="product-type" class="col-md-2 col-form-label required">Product Type</label>
                                    <div class="col-md-8">
                                        <select name="product_type" class="form-control" required >
                                            @if(count($conditions) > 0)
                                                @foreach($conditions as $condition)
                                                    <option value="{{$condition->id}}" @if($invoice_product->product_type == $condition->id) selected @endif>{{$condition->condition_name}}</option>
                                                @endforeach
                                                    <option value="0" @if($invoice_product->product_type == 0) selected @endif>Defected</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                    @if (\Session::has('error'))
                                        <div class="alert alert-danger" role="alert">
                                            {!! \Session::get('error') !!}
                                        </div>
                                    @endif
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="quantity" class="col-md-2 col-form-label required">Quantity</label>
                                    <div class="col-md-8">
                                        <input id="quantity" type="number" name="quantity"  class="form-control"  value="{{$invoice_product->quantity}}" placeholder="" required>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="price" class="col-md-2 col-form-label required">Price</label>
                                    <div class="col-md-8">
                                        <input id="price" type="number" name="price"  class="form-control"  value="{{$invoice_product->price}}" placeholder="" required>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="total_price" class="col-md-2 col-form-label required">Total Price</label>
                                    <div class="col-md-8">
                                        <input type="text" id="total_price" name="total_price"  class="form-control" value="{{$invoice_product->total_price}}" placeholder="" required>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button class="vendor-btn" type="submit" class="btn btn-primary waves-effect waves-light">
                                            <b> Update </b>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- card-box -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- container -->
        </div>
        <!-- content -->
    </div>
    <!-- content page-->
    <script>
        $(document).ready(function() {
            $("#quantity").on('input', function () {

                var price = $('input[name=price]').val();
                var quantity = $('input[name=quantity]').val();

                document.getElementById("total_price").value =  parseInt(price) * parseInt(quantity) ;
                if(!quantity){
                    document.getElementById("total_price").value =  parseInt(price) ;
                }

            });
            $("#price").on('input', function () {
                var price = $('input[name=price]').val();
                var quantity = $('input[name=quantity]').val();

                document.getElementById("total_price").value =  parseInt(price) * parseInt(quantity) ;
                if(!quantity){
                    document.getElementById("total_price").value =  parseInt(price) ;
                }

            });
        });

    </script>
@endsection
