@extends('master')
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="vendor-title">
                            <p>Ordered Product Reshelve</p>
                        </div>
                    </div>
                </div>

                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box shadow">

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(Session::has('success'))
                                <div class="alert alert-success">
                                    {!! Session::get('success') !!}
                                </div>
                            @endif
                                <div class="alert alert-success">
                                    Product quantity have merged with all channel. Now reshelve below product using mobile app.
                                </div>

                            <form role="form" class="mobile-responsive" action="{{url('cancel-order-product-sync')}}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-3 text-center">
                                        <p>Product Name</p>
                                    </div>
{{--                                    <div class="col-md-2 text-center">--}}
{{--                                        Variation ID--}}
{{--                                    </div>--}}
                                    <div class="col-md-3 text-center">
                                        Ordered SKU
                                    </div>
                                    <div class="col-md-2 text-center">
                                        Exchanged Quantity
                                    </div>
                                    <div class="col-md-2 text-center">
                                        Ordered Picked Quantity
                                    </div>
                                    <div class="col-md-2 text-center">
                                        Ordered Product Shelf
                                    </div>
                                </div><hr>

                                @if(count($picked_product) > 0)
                                    @foreach($picked_product as $product)
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <p>{{$product['name']}}</p>
                                            </div>
{{--                                            <div class="col-md-2">--}}
{{--                                                <input type="text" name="variation_id[]" class="form-control" value="{{$product['variation_id'] ?? ''}}">--}}
{{--                                            </div>--}}
                                            <div class="col-md-3">
                                                <input type="text" name="sku[]" class="form-control" value="{{$product['variation_details']->variation_info->sku}}">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="quantity[]" class="form-control" value="{{$product['quantity'] ?? ''}}">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="picked_quantity[]" class="form-control" value="{{$product['picked_quantity'] ?? ''}}">
                                            </div>
                                            <div class="col-md-2">
                                                <select name="shelf_id[]" class="form-control">
                                                    @if(!empty($product['shelf_details']))
                                                        @foreach($product['shelf_details'] as $shelf)
                                                            <option value="{{$shelf->shelf_id}}">{{$shelf->shelf_info->shelf_name}} / {{$shelf->quantity}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <input type="hidden" name="product_order_id[]" value="{{$product['product_order_id'] ?? ''}}">
                                            <input type="hidden" name="variation_id[]" value="{{$product['variation_id'] ?? ''}}">
                                        </div>
                                    @endforeach
                                @endif
                                <input type="hidden" name="route_name" value="{{$route ?? 'order/list'}}">
                                <div class="row">
                                    <div class="col text-center">
                                        <button type="submit" class="btn btn-primary">Reshelve</button>
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

@endsection
