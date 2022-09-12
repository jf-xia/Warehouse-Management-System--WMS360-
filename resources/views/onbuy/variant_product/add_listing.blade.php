
@extends('master')

@section('title')
    OnBuy | Active Product Details | Add Onbuy Listing | WMS360
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
                            <li class="breadcrumb-item active" aria-current="page">Add Onbuy Listing</li>
                        </ol>
                    </div>
                </div>


                <div class="row m-t-20 onbuy-product">
                    <div class="col-md-12">
                        <div class="card-box shadow">
                            <form class="mobile-responsive m-t-10" role="form" action= {{url('onbuy/save-listings/'.$id)}} method="post">
                                @csrf

                                <div class="row m-t-10 d-flex align-items-center">
                                    <div class="col-md-2">
                                        <label class="required">Condition</label>
                                    </div>
                                    <div class="col-md-10">
                                        <select class="form-control" name="condition">
                                            <option value="">Select Condition</option>
                                            @foreach($new_condition as $condition)
                                                <option value="{{$condition}}">{{$condition}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row m-t-10 d-flex align-items-center">
                                    <div class="col-md-2">
                                        <label class="required">New Unique SKU</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="sku" value="" required>
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
                                        <input type="text" class="form-control" name="price" value="">
                                    </div>
                                </div>

                                <div class="row m-t-10 d-flex align-items-center">
                                    <div class="col-md-2">
                                        <label>Stock</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="number" class="form-control" name="stock" value="">
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
@endsection
