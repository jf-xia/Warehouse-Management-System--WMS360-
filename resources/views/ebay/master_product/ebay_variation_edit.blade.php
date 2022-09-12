@extends('master')

@section('title')
    eBay | Active Product | eBay variation edit | WMS360
@endsection

@section('content')

<div class="content-page ebay">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">

            <div class="d-flex justify-content-center align-items-center">
                <div>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item" aria-current="page">Active Product</li>
                        <li class="breadcrumb-item active" aria-current="page">eBay variation edit</li>
                    </ol>
                </div>
            </div>

            <div class="row m-t-20">
                <div class="col-md-12">
                    <div class="card-box shadow">
                        <form role="form" class="" action="{{url('update-ebay-variation/'.$result->id)}}" method="POST">
                            @csrf
                            <div class="wms-row">
                                <div class="wms-col-8">
                                    <div class="variation_step_1">
                                        <div class="wms-row">
                                            <div class="wms-col-6">
                                                <div class="input-wrapper">
                                                    <label class="variation-sku" for="sku">SKU</label>
                                                    <input type="text" id="sku" readonly data-parsley-maxlength="30" class="form-control variation-sku " name="sku" value="{{$result->sku}}" autocomplete="sku" autofocus="">
                                                    <input type="hidden" name="productVariation[0][variation_id]" value="98580">
                                                </div>
                                            </div>
                                            @isset($variations)
                                                @foreach($variations as $attribute => $terms)
                                                <div class="wms-col-6">
                                                    <div class="input-wrapper">
                                                        <label class="variation-size" for="Colour">{{$attribute}}</label>
                                                        <input type="text" id="{{$attribute}}" readonly class="form-control variation-size " name="attribute[{{$attribute}}]" value="{{$terms}}" data-parsley-maxlength="30" autocomplete="Colour" autofocus="">
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endisset

                                            <div class="wms-col-6">
                                                <div class="input-wrapper">
                                                    <label class="variation-start-price" for="start_price">Start Price</label>
                                                    <input type="text" id="start_price"  class="form-control variation-start-price " name="start_price" value="{{$result->start_price}}" data-parsley-maxlength="30" autocomplete="start_price" autofocus="">
                                                </div>
                                            </div>

                                            <div class="wms-col-6">
                                                <div class="input-wrapper">
                                                    <label class="variation-rrp" for="rrp">RRP</label>
                                                    <input type="text" id="rrp" class="form-control variation-rrp " name="rrp" value="{{$result->rrp}}" maxlength="80" onkeyup="Count();" required="" autocomplete="rrp" autofocus="">
                                                    <span id="rrp" class="float-right"></span>
                                                </div>
                                            </div>

                                            <div class="wms-col-6">
                                                <div class="input-wrapper">
                                                    <label class="variation-ean" for="ean">Enter EAN</label>
                                                    <input type="text" id="ean" readonly class="form-control variation-ean " name="ean" value="{{$result->ean}}" data-parsley-maxlength="30" autocomplete="ean" autofocus="">
                                                </div>
                                            </div>

                                            <div class="wms-col-6">
                                                <div class="input-wrapper">
                                                    <label class="variation-quantity" for="quantity">Enter Quantity</label>
                                                    <input type="text" id="quantity" disabled class="form-control variation-quantity " name="quantity" value="{{$result->quantity}}" data-parsley-maxlength="30" autocomplete="quantity" autofocus="">
                                                </div>
                                            </div>
                                            <input type="hidden" name="item_id" value="{{$item_id}}">
                                            <input type="hidden" name="account_id" value="{{$account_id}}">
                                            <input type="hidden" name="site_id" value="{{$site_id}}">
                                        </div>
                                    </div>
                                </div><!--End wms-col-8-->

{{--                                <div class="wms-col-4">--}}
{{--                                    <div class="variation_step_2 edit_variation_image">--}}
{{--                                        <div class="variation-image-header">--}}
{{--                                            Upload IMAGE--}}
{{--                                        </div>--}}
{{--                                        <div class="variation-image-body">--}}
{{--                                            <input accept="image/*" type='file' style="margin: 20px 25px;" id="imgInp">--}}
{{--                                            <img id="upload_image" src="#" style="width: 150px; height: 150px" alt="">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div><!--End wms-col-4-->--}}

                            </div>

                            <div class="form-group row mt-3">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary draft-pro-btn waves-effect waves-light">
                                        <b> Submit </b>
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
            upload_image.src = URL.createObjectURL(file)
        }
    }
</script>


@endsection
