@extends('master')

@section('title')
    WooCommerce | Active Product | Add Variation | WMS360
@endsection

@section('content')


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.css')}}"  />


    <div class="content-page">
        <!-- Start content -->
        <div class="content" >
            <div class="container-fluid">


                <div class="wms-breadcrumb">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Active Product</li>
                            <li class="breadcrumb-item active" aria-current="page">Add Product</li>
                        </ol>
                    </div>
                    <div class="breadcrumbRightSideBtn">
                        <a href="#"><button class="btn btn-default">Receive Product</button></a>
                    </div>
                </div>


                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box shadow" id="variation_cartesian">


                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

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


                            <form id="chargeForm" class="m-t-40 mobile-responsive" role="form" action="{{url('woocommerce/variation/create')}}"  method="post">
                                @csrf
                                <input type="hidden" name="woocom_master_product_id" id="product-dropdown" value="{{$woo_id}}">
{{--                                <div class="form-group row">--}}
{{--                                    <div class="col-md-10"><h5 class="pl-3">Catalouge : {{$master_variation->name}}</h5></div>--}}
{{--                                </div>--}}
                                <div class="container" >
                                    @foreach($master_variation as $variation)
                                        @if(!isset($variation->woocommerce_variations))
                                        <div class="card p-20 m-t-10 variation-card" id="cardId">
                                            <div>
                                                <div class="form-group row">
{{--                                                    <h5 class="m-l-10">Add variation</h5>--}}
                                                </div>
                                                <div class="form-group row">
                                                        @php
                                                            $id_arr = [];
                                                            foreach (\Opis\Closure\unserialize($variation->attribute) as $attribute){
                                                                $id_arr[] = [
                                                                    'id' => $attribute['attribute_id'],
                                                                    'value' => $attribute['terms_name'],
                                                                    'term_id' => $attribute['terms_id'],
                                                                    'term_name' => $attribute['terms_name']
                                                                    ];
                                                            }
                                                        @endphp
                                                        @if(count($id_arr) > 0)
                                                            @foreach($id_arr as $id)
                                                                <div class="col-md-2">
                                                                    <div class="text-center"> <label>{!! \App\Attribute::findOrFail($id['id'])->attribute_name !!}</label></div>
                                                                    <div>
                                                                        {{----}}
                                                                        <select name="attribute[{{$id['id']}}][]" id="a{{$id['id']}}"   class="form-control variation_dropdowm_field var_dr_attr_field{{$id['id']}}" required >
                                                                            <option value="{{$id['term_id']}}">{{$id['value']}}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    <div class="col-md-2">
                                                        <div>
                                                            <img src="{{$variation->image ?? asset('uploads/no_image.jpg')}}" alt="{{$variation->image ?? 'No Image'}}" height="100" width="100">
                                                            <input type="hidden" name="image[]" value="{{$variation->image ?? null}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{----}}
{{--                                                <div class="form-group row">--}}
{{--                                                    <div class="col-md-3">--}}
{{--                                                        <div class="d-flex align-items-center custom-control custom-checkbox">--}}
{{--                                                            <input type="checkbox" class="custom-control-input" :id='"customCheck"+index'>--}}
{{--                                                            <label class="custom-control-label" :for='"customCheck" + index'>Notification Status</label>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    --}}{{--                                                --}}{{----}}{{--                                    <div class="col-md-3"> </div>--}}
{{--                                                </div>--}}

                                                <input type="hidden" name="woocomm_variation_id[]" value="{{$variation->id}}">
                                                <div class="form-group row">
                                                    <div class="col-md-3">
                                                        <div class="text-center"> <label class="required">SKU</label></div>
                                                        <div>
                                                            <input type="text" name="sku[]" class="form-control sku_class" required data-parsley-maxlength="30" id="sku" value="{{$variation->sku}}" placeholder="">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="text-center"> <label class="p-v-label">EAN</label></div>
                                                        <div>
                                                            <input type="text" name="ean_no[]" class="form-control ean_class"  maxlength="13" pattern="[0-9]{13}" :id="ean_no" value="{{$variation->ean_no}}" placeholder="">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="text-center"> <label class="required p-v-label">Regular price</label></div>
                                                        <div>
                                                            <input type="text" name="regular_price[]" value="{{$variation->regular_price}}" class="form-control" required data-parsley-maxlength="30" id="" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="text-center"> <label class="required p-v-label">Sale Price</label></div>
                                                        <div>
                                                            <input type="text" name="sale_price[]" value="{{$variation->sale_price}}" class="form-control" required data-parsley-maxlength="30" id="" placeholder="">
                                                        </div>
                                                    </div>
                                                    {{----}}
                                                    <div class="col-md-3">
                                                        <div class="text-center"> <label class="p-v-label">Cost Price</label></div>
                                                        <div>
                                                            <input type="text" name="cost_price[]" value="{{$variation->cost_price}}" class="form-control" data-parsley-maxlength="30" id="" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="text-center"> <label class="p-v-label">RRP</label></div>
                                                        <div>
                                                            <input type="text" name="rrp[]" value="{{$variation->rrp}}" class="form-control" data-parsley-maxlength="30" id="" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="text-center"> <label class="p-v-label">Actual Quantity</label></div>
                                                        <div>
                                                            <input type="text" name="actual_quantity[]" value="{{$variation->actual_quantity}}" class="form-control" data-parsley-maxlength="30" id="" placeholder="">
                                                        </div>
                                                    </div>
                                                    {{----}}
                                                    <div class="col-md-3">
                                                        <div class="text-center"> <label class="p-v-label">Product Code</label></div>
                                                        <div>
                                                            <input type="text" name="product_code[]" value="{{$variation->product_code}}" class="form-control" data-parsley-maxlength="30" id="product_code" placeholder="">
                                                        </div>
                                                    </div>
                                                    {{----}}
                                                    <div class="col-md-3">
                                                        <div class="text-center"> <label class="p-v-label">Color Code</label></div>
                                                        <div>
                                                            <input type="text" name="color_code[]" value="{{$variation->color_code}}" class="form-control" data-parsley-maxlength="30" id="color_code" placeholder="">
                                                        </div>
                                                    </div>
                                                    {{----}}
                                                    {{----}}
                                                    <div class="col-md-3">
                                                        <div class="text-center"> <label class="p-v-label">low Quantity</label></div>
                                                        <div>
                                                            <input type="text" name="low_quantity[]" class="form-control" data-parsley-maxlength="30" id="" placeholder="">
                                                        </div>
                                                    </div>

                                                    {{--                                                --}}{{--    <div class="col-md-1"></div>--}}

                                                </div>
                                                <div class="form-group row" style="margin-top: 1rem;">
                                                    <label><a class="collapsed" data-toggle="collapse" href="#collapseDescription{{$variation->id}}">Description</a></label>
                                                    <div class="col-md-10 wow pulse collapse" id="collapseDescription{{$variation->id}}" data-parent="#accordion">
                                                        <textarea name="description[]" class="form-control summernote"></textarea>
                                                    </div>
                                                </div>

                                                <!--form-group end-->
                                                <span>
                                                    <button type="button" class="btn btn-danger remove-variation float-right">Remove</button>
                                                </span>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>


                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light" >
                                            <b> Send </b>
                                        </button>
                                    </div>
                                </div> <!--form-group end-->

                            </form> <!--END FORM-->

                        </div>  <!-- card-box -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->
    <script>
        $('.select2').select2();
    </script>


    <script type="text/javascript">

        jQuery(document).ready(function(){

            $('.summernote').summernote({
                height: 250,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: false                 // set focus to editable area after initializing summernote
            });

            $('.inline-editor').summernote({
                airMode: true
            });

            $('.remove-variation').click(function () {
                console.log('found');
                $(this).closest('.variation-card').remove();
            });

        });

    </script>


@endsection
