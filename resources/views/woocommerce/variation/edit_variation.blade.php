@extends('master')

@section('title')
    WooCommerce | Active Product Details | Edit Variation | WMS360
@endsection

@section('content')

    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.css')}}"  />

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <div class="wms-breadcrumb-middle">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">Active Product Details</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Variation</li>
                        </ol>
                    </div>
                </div>


                <form role="form" action="{{url('woocommerce/variation/update/'.$variation_info->id)}}" method="post" class="vendor-form mobile-responsive" style="margin-top: 0px;" enctype="multipart/form-data">
                    @csrf
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

                                <div class="form-group row m-t-30">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2">
                                        <p class="font-16">Product Name : </p>
                                    </div>
                                    <div class="card col-md-8 v-e-p-name">
                                        <p class="font-16">{{$variation_info->master_catalogue->name}}</p>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-5"><p class="font-16">Product Variation : </p></div>
                                    <div class="col-md-6"></div>
                                </div>

                                <div class="form-group row font-16">
                                    <div class="col-md-1"></div>
                                    @isset($variation_info->attribute)
                                        @foreach(\Opis\Closure\unserialize($variation_info->attribute) as $attribute)
                                        <div class="col-md-3">
                                            <label><b class="v-e-p-variation">{{$attribute['attribute_name']}}</b> <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{$attribute['terms_name']}} </label>
                                        </div>
                                        @endforeach
                                    @endisset

                                    <div class="col-md-2"></div>
                                </div>
{{--                                @if(Auth::check() && in_array('1',explode(',',Auth::user()->role)))--}}
{{--                                    <div class="form-group row">--}}
{{--                                        <div class="col-md-1"></div>--}}
{{--                                        <div class="col-md-8"><p class="font-16">Select variation : </p></div>--}}
{{--                                        <div class="col-md-3"></div>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-group row">--}}
{{--                                        <div class="col-md-1"></div>--}}
{{--                                        <div class="col-md-10">--}}
{{--                                            <div class="row">--}}
{{--                                                @foreach($attribute_array as $key => $value)--}}

{{--                                                    <div  class="col-md-2">--}}
{{--                                                        <div class="text-center"> <label>{!! \App\Attribute::findOrFail($key)->attribute_name !!}</label></div>--}}
{{--                                                        <div>--}}
{{--                                                            <select name="a{{$key}}" id="a{{$key}}" class="form-control" required >--}}
{{--                                                                <option>select</option>--}}
{{--                                                                @foreach($value as $key => $value)--}}
{{--                                                                    <option>{{$value['name']}}</option>--}}
{{--                                                                @endforeach--}}
{{--                                                            </select>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

{{--                                                @endforeach--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-1"></div>--}}
{{--                                    </div>--}}
{{--                                @endif--}}

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-3 m-t-10">
                                        <div>
                                            @if($variation_info->notification_status == 1)
                                                <div class="custom-control custom-checkbox mb-3 d-flex align-items-center">
                                                    <input class="custom-control-input" id="customCheck1" name="notification_status" type="checkbox" checked>
                                                    <label class="custom-control-label" for="customCheck1"> Notification Status </label>
                                                </div>
                                            @else
                                                <div class="custom-control custom-checkbox mb-3 d-flex align-items-center">
                                                    <input class="custom-control-input" id="customCheck1" name="notification_status" type="checkbox">
                                                    <label class="custom-control-label" for="customCheck1"> Notification Status </label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-5"></div>
                                </div>

                                <div class="form-group m-t-20 row">
                                    {{--                                    <div class="col-md-1"></div>--}}
                                    <div class="col-md-3 text-center m-t-10 wow pulse">
                                        <label class="required">SKU</label>
                                        <input name="sku" type="text" value="{{$variation_info->sku}}" class="form-control" required>
                                    </div>
                                    <div class="col-md-3 text-center m-t-10 wow pulse">
                                        <label class="v-e-label">EAN</label>
                                        <input name="ean_no" type="text" maxlength="13" pattern="[0-9]{13}" value="{{$variation_info->ean_no ? $variation_info->ean_no : old('ean_no')}}" class="form-control">
                                    </div>
                                    <div class="col-md-3 text-center m-t-10 wow pulse">
                                        <label class="v-e-label required">Regular Price</label>
                                        <input name="regular_price" type="text" value="{{$variation_info->regular_price}}" class="form-control" required>
                                    </div>
                                    <div class="col-md-3 text-center m-t-10 wow pulse">
                                        <label class="v-e-label required">Sale Price</label>
                                        <input name="sale_price" type="text" value="{{$variation_info->sale_price}}" class="form-control" required>
                                    </div>
                                    <div class="col-md-3 text-center m-t-10 wow pulse">
                                        <label class="v-e-label">Cost Price</label>
                                        <input name="cost_price" type="text" value="{{$variation_info->cost_price}}" class="form-control">
                                    </div>
                                    <div class="col-md-3 text-center m-t-10 wow pulse">
                                        <div class="text-center"> <label class="p-v-label">Actual Quantity</label></div>
                                        <div>
                                            <input type="text" name="actual_quantity" value="{{$variation_info->actual_quantity}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-center m-t-10 wow pulse">
                                        <label class="v-e-label">Product Code</label>
                                        <input name="product_code" type="text" value="{{$variation_info->product_code}}" class="form-control">
                                    </div>
                                    <div class="col-md-3 text-center m-t-10 wow pulse">
                                        <label class="v-e-label">Color Code</label>
                                        <input name="color_code" type="text" value="{{$variation_info->color_code}}" class="form-control">
                                    </div>
                                    <div class="col-md-3 text-center m-t-10 wow pulse">
                                        <label class="v-e-label">Low Qty</label>
                                        <input name="low_quantity" type="text" value="{{$variation_info->low_quantity}}" class="form-control">
                                    </div>
                                    {{--                                    <div class="col-md-3"></div>--}}
                                </div>

                                <div class="form-group m-t-40 row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-6 m-t-20 wow pulse">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="imgInp" name="file">
                                            <label class="custom-file-label" for="customFile">Select Image</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 wow pulse">
                                        <img class="v-e-img" src="{{$variation_info->image}}" id="variation_edit_image" alt="Image" width="70px" height="70px">
                                        <img id="blah" class="rounded" src="#" alt="Images" width="70px" height="70px" style="display: none;">
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group m-t-40 row wow pulse">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-10">
                                        <label>Description</label>
                                        <textarea class="summernote"  name="description" autocomplete="description" autofocus>{{$variation_info->description}}</textarea>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                                            <b>Update</b>
                                        </button>
                                    </div>
                                </div>


                            </div>  <!-- card-box -->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->
                </form>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content-page-->

    <script>

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function() {
            $('#variation_edit_image').hide();
            $('#blah').show();
            readURL(this);
        })

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

        });
    </script>

@endsection
