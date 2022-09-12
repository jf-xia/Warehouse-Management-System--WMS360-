@extends('master')

@section('title')
    OnBuy | Active Product Details | Edit Listing | WMS360
@endsection

@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <div class="wms-breadcrumb-middle">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Active Product Details</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Listing</li>
                        </ol>
                    </div>
                </div>


                <div class="row m-t-20 onbuy-product">
                    <div class="col-md-12">
                        <div class="card-box shadow">

                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif


                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif


                            <form class="mobile-responsive m-t-10" role="form" action= {{url('onbuy/update-variation-product/'.$single_variation_product_info->id)}} method="post">
                                @csrf
                                <div class="container">
                                    <div class="row d-flex align-items-center pt-1">
                                        <div class="col-md-2">
                                            <label>SKU</label>
                                        </div>
                                        <div class="col-md-10 controls" id="category-level-1-group">
                                            <input type="text" class="form-control" name="sku" id="sku" value="{{$single_variation_product_info->sku}}" readonly>
                                        </div>
                                    </div>
                                    <div class="row d-flex align-items-center pt-1">
                                        <div class="col-md-2">
                                            <label>Updated SKU <span>
                                                    <a class="ui-tooltip" title="This SKU will update only in WMS">
                                                        <span style="cursor: help;">
                                                            <img  style="width: 15px; height: 15px;margin-left: 10px" src="https://image.flaticon.com/icons/png/512/36/36601.png">
                                                        </span>
                                                    </a>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="col-md-10 controls" id="category-level-1-group">
                                            <input type="text" class="form-control" name="updated_sku" id="updated_sku" value="" placeholder="">
                                        </div>
                                    </div>
                                    <div class="row m-t-10 d-flex align-items-center">
                                        <div class="col-md-2">
                                            <label class="required">Price</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="price" id="price" value="{{$single_variation_product_info->price}}">
                                        </div>
                                    </div>
                                    <div class="row m-t-10 d-flex align-items-center">
                                        <div class="col-md-2">
                                            <label class="required">Base Price</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="base_price" id="base_price" value="{{$single_variation_product_info->base_price ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="row m-t-10 d-flex align-items-center">
                                        <div class="col-md-2">
                                            <label class="required">Max Price</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="max_price" id="max_price" value="{{$single_variation_product_info->max_price ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="row m-t-10 d-flex align-items-center">
                                        <div class="col-md-2">
                                            <label>Stock</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="stock" id="stock" value="{{$single_variation_product_info->stock}}">
                                        </div>
                                    </div>
                                    <div class="form-group row m-t-40">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                                                <b>Update</b>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form> <!--//End form -->
                        </div> <!--//End card-box -->
                    </div><!--//End col-md-12 -->
                </div><!--//End row -->
            </div> <!-- // End Container-fluid -->
        </div> <!-- // End Content -->
    </div> <!-- // End Contact page -->

@endsection
