
@extends('master')

@section('title')
    Add Onbuy Existing Listing | WMS360
@endsection

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <div class="wms-breadcrumb-middle">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Active Product Details</li>
                            <li class="breadcrumb-item active" aria-current="page">Add Onbuy Listing</li>
                        </ol>
                    </div>
                </div>
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
                <div class="row m-t-20 onbuy-product">
                    <div class="col-md-12">
                        <div class="card-box shadow">
                            <form class="mobile-responsive m-t-10" role="form" action= {{url('onbuy/save-exist-ean-listings')}} method="post">
                                @csrf
                                <div class="row m-t-10 d-flex align-items-center">
                                    <div class="col-md-2">
                                        <label class="required">Profile</label>
                                    </div>
                                    <div class="col-md-10">
                                        <select class="form-control select2" name="profileId" required>
                                            <option value="">Select Profile</option>
                                            @isset($allProfile)
                                                @foreach ($allProfile as $profile)
                                                    <option value="{{$profile->id}}" @if(($profileId != null) && ($profile->id == $profileId)) selected @endif">{{$profile->name}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>
                                <div class="row m-t-10 d-flex align-items-center">
                                    <div class="col-md-2">
                                        <label class="required">Variation</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="row">
                                            @if(($productInfo->attribute != null) && (is_array(unserialize($productInfo->attribute))))
                                                @foreach(unserialize($productInfo->attribute) as $cat_var)
                                                    <div class="col-md-2">
                                                        <span>{{$cat_var['attribute_name']}}</span>
                                                        <select class="form-control" name="variation_terms[][{{$cat_var['attribute_id']}}/{{$cat_var['attribute_name']}}]">
                                                                <option value="{{$cat_var['terms_name']}}">{{$cat_var['terms_name']}}</option>
                                                        </select>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-10 d-flex align-items-center">
                                    <div class="col-md-2">
                                        <label class="required">Brand</label>
                                    </div>
                                    <div class="col-md-10">
                                        <select class="form-control" name="brand_id">
                                            <option value="">Select Brand</option>
                                            @isset($onbuyBrand)
                                                @foreach($onbuyBrand as $brand)
                                                    <option value="{{$brand->brand_id}}" @if(isset($profileInfo->brand) && ($brand->brand_id == $profileInfo->brand)) selected @endif">{{$brand->name}}</option>
                                                @endforeach
                                            @endisset

                                        </select>
                                    </div>
                                </div>
                                <div class="row m-t-10 d-flex align-items-center">
                                    <div class="col-md-2">
                                        <label class="required">Condition</label>
                                    </div>
                                    <div class="col-md-10">
                                        <select class="form-control" name="condition">
                                            <option value="">Select Condition</option>
                                            <option value="new" selected>New</option>
                                            <option value="excellent">Excellent</option>
                                            <option value="verygood">Very Good</option>
                                            <option value="good">Good</option>
                                            <option value="average">Average</option>
                                            <option value="belowaverage">Below Average</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="master_catalogue" value="{{$catalogueId}}">
                                <input type="hidden" name="exist_opc" value="{{$existOPC}}">
                                <input type="hidden" name="exist_ean" value="{{$existEAN ?? null}}">
                                <input type="hidden" name="productId" value="{{$productId}}">
                                <!-- <input type="hidden" name="profileId" value="{{$profileId}}"> -->
                                <div class="row m-t-10 d-flex align-items-center">
                                    <div class="col-md-2">
                                        <label class="required">New Unique SKU</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="sku" value="{{$productInfo->sku ?? ''}}" required>
                                    </div>
                                </div>

                                <div class="row m-t-10 d-flex align-items-center">
                                    <div class="col-md-2">
                                        <label>Group SKU</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="group_sku" value="">
                                    </div>
                                </div>

                                <div class="row m-t-10 d-flex align-items-center">
                                    <div class="col-md-2">
                                        <label class="required">Price</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="price" value="{{$productInfo->sale_price ?? ''}}">
                                    </div>
                                </div>

                                <div class="row m-t-10 d-flex align-items-center">
                                    <div class="col-md-2">
                                        <label>Stock</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="number" class="form-control" name="stock" value="{{$productInfo->actual_quantity ?? ''}}">
                                    </div>
                                </div>

                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                                            <b>Add</b>
                                        </button>
                                    </div>
                                </div>
                            </form> <!--//End form -->
                        </div> <!--//End card-box -->
                    </div><!--//End col-md-12 -->
                </div><!--//End row -->
            </div> <!-- // End Container-fluid -->
        </div> <!-- // End Content -->
    </div> <!-- // End Contact page -->
    <script>
        $('.select2').select2();
    </script>
@endsection
