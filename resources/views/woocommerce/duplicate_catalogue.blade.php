@extends('master')
@section('content')

<link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.css')}}"  />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">


            <!-- Page-Title -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="vendor-title">
                        <p>Duplicate Catalogue</p>
                    </div>
                </div>
            </div>


            <div class="row m-t-20">
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



                        <form role="form" class="vendor-form mobile-responsive" action= {{URL::to('woocommerce/catalogue/store')}} method="post">
                            @csrf
                            <div class="form-group row">
                                <label for="validationDefault01" class="col-md-2 col-form-label required">Name</label>
                                <div class="col-md-10 wow pulse">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$product_draft->name}}" maxlength="80" onkeyup="Count();" required autocomplete="name" autofocus>
                                    <span id="display" class="float-right"></span>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                        @enderror
                                </div>
                            </div>

                            <input type="hidden" name="master_catalogue_id" value="{{$product_draft->master_catalogue_id}}">

                            <div class="form-group row">
                                <label for="validationDefault03" class="col-md-2 col-form-label required">Category</label>
                                <div class="col-md-10 wow pulse">
                                    <select id="category_id" class="form-control select2 @error('category') is-invalid @enderror" multiple="multiple" name="category_id[]" value="{{ old('category_id') }}" required autocomplete="category_id" autofocus>
                                        @foreach($categories as $category)
                                        <?php
                                        $temp = '';
                                        ?>
                                        @foreach($product_draft->all_category as $edit_category)
                                        @if($category->id == $edit_category->id)
                                        <option value="{{$edit_category->id}}"selected="selected">{{$edit_category->category_name}}</option>
                                        <?php
                                        $temp = 1;
                                        ?>
                                        @endif
                                        @endforeach
                                        @if($temp == null)
                                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                        @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="category" class="col-md-2 col-form-label required">Brand</label>
                                <div class="col-md-10 wow pulse">
                                    <select id="brand_id" class="form-control select2 @error('brand') is-invalid @enderror" name="brand_id" value="{{ old('brand_id') }}" required autocomplete="brand_id" autofocus>
                                        <option value="">Select Brand</option>
                                        @foreach($brands as $brand)
                                            @if($brand->id == $product_draft->brand_id)
                                                <option value="{{$brand->id}}" selected>{{$brand->name}}</option>
                                            @else
                                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="role" class="col-md-2 col-form-label required">Gender</label>

                                <div class="col-md-10 wow pulse">
                                    <select id="gender_id" class="form-control select2 @error('gender') is-invalid @enderror" name="gender_id" value="{{ old('gender_id') }}" required autocomplete="gender_id" autofocus>
                                        <option value="">Select Gender</option>
                                        @foreach($genders as $gender)
                                            @if($gender->id == $product_draft->gender_id)
                                                <option value="{{$gender->id}}" selected>{{$gender->name}}</option>
                                            @else
                                                <option value="{{$gender->id}}">{{$gender->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-2 col-form-label required">Description</label>
                                <div class="col-md-10 wow pulse">
                                    <textarea class="" id="messageArea"  name="description" required autocomplete="description" autofocus>{!! $product_draft->description !!}</textarea>
                                    {{--                                        <div class="summernote">--}}
                                        {{--                                            <h3> </h3>--}}
                                        {{--                                        </div>--}}
                                </div>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                    @enderror
                            </div>


                            <div class="form-group row" id="accordion">
                                <label for="short_description" class="col-md-2 col-form-label">
                                    <a class="collapsed" data-toggle="collapse" href="#collapseShortDescription">Short Description</a>
                                </label>
                                <div class="col-md-10 wow pulse collapse" id="collapseShortDescription" data-parent="#accordion">
                                    <textarea class="summernote" name="short_description" autocomplete="short_description" autofocus>{!! $product_draft->short_description !!}</textarea>

                                </div>
                                @error('short_description')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                    @enderror
                            </div>


                            <div class="form-group row">
                                <label for="regular_price" class="col-md-2 col-form-label ">Regular Price</label>

                                <div class="col-md-10 wow pulse">
                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('regular_price') is-invalid @enderror" name="regular_price" value="{{$product_draft->regular_price}}" autocomplete="regular_price" autofocus
                                           id="regular_price" placeholder="">
                                    @error('regular_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                        @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="sale_price" class="col-md-2 col-form-label ">Sales Price</label>

                                <div class="col-md-10 wow pulse">
                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('sale_price') is-invalid @enderror" name="sale_price" value="{{$product_draft->sale_price}}" autocomplete="sale_price" autofocus
                                           id="sale_price" placeholder="">
                                    @error('sale_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                        @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="cost_price" class="col-md-2 col-form-label ">Cost Price</label>

                                <div class="col-md-10 wow pulse">
                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('sale_price') is-invalid @enderror" name="cost_price" value="{{$product_draft->cost_price}}" autocomplete="cost_price" autofocus
                                           id="cost_price" placeholder="">
                                    @error('cost_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                        @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="product_code" class="col-md-2 col-form-label ">Product Code</label>

                                <div class="col-md-10 wow pulse">
                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('product_code') is-invalid @enderror" name="product_code" value="{{$product_draft->product_code}}" autocomplete="product_code" autofocus
                                           id="product_code" placeholder="">
                                    @error('product_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                        @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="color_code" class="col-md-2 col-form-label ">Color Code</label>

                                <div class="col-md-10 wow pulse">
                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('color_code') is-invalid @enderror" name="color_code" value="{{$product_draft->color_code}}" autocomplete="color_code" autofocus
                                           id="color_code" placeholder="">
                                    @error('color_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                        @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="low_quantity" class="col-md-2 col-form-label">Low Quantity</label>

                                <div class="col-md-10 wow pulse">
                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('low_quantity') is-invalid @enderror" name="low_quantity" value="{{$product_draft->low_quantity}}" autocomplete="low_quantity" autofocus
                                           id="low_quantity" placeholder="">
                                    @error('low_quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                        @enderror
                                </div>
                            </div>

                            <div class="row form-group select_variation_att">
                                <div class="col-md-10">
                                    <h6 class="font-18 required_attributes"> Select variation from below attributes </h6>
                                </div>
                            </div>

                            <div class="row form-group product-desn-top">

                                <div class="col-md-12">
                                    <div class="row">

                                        @foreach($attribute_terms as $attribute_term)

                                        @if(!empty( $attribute_term->woocommerce_attributes_terms))

                                        <div class="button-group col-md-3 m-b-20">
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle m-r-5 form-control" data-toggle="dropdown">  <span class="caret"> {{$attribute_term->attribute_name}} ({{count($attribute_term->woocommerce_attributes_terms)}})</span>
                                            </button>
                                            <select class="form-control select2" name="terms[{{$attribute_term->id}}][]" multiple="multiple">
                                                @foreach($attribute_term->woocommerce_attributes_terms as $terms)
                                                <?php
                                                $temp = '';
                                                ?>
                                                @foreach($attribute_info->woocommerce_catalogue_attribute as $attributes)
                                                @if($terms->id == $attributes->pivot->attribute_term_id)
                                                <option value="{{$terms->id}}" selected="selected">{{$terms->terms_name}}</option>
                                                <?php
                                                $temp = 1;
                                                ?>
                                                @endif
                                                @endforeach
                                                @if($temp == null)
                                                <option value="{{$terms->id}}">{{$terms->terms_name}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div> <!--buttongroup close-->


                                        @endif
                                        <!--end column-->

                                        @endforeach
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row vendor-btn-top">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" style="background-color: #7e57c2!important;padding: 5px 40px 5px 40px;">
                                        <b> Add </b>
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
</div>  <!-- content page -->

<!----- ckeditor summernote ------->
<script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>

<script>
    $('.select2').select2();
</script>

<!--ckeditor summernote--->
<script type="text/javascript">
    CKEDITOR.replace( 'messageArea',
        {
            customConfig : 'config.js',
            toolbar : 'simple'
        })

    $(document).on("click", ".copyTo", function(){
        let $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).text()).select();
        document.execCommand("copy");
        $temp.remove();
    });
</script>

<script>

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

<script type="text/javascript">
    function Count() {
        var i = document.getElementById("name").value.length;
        document.getElementById("display").innerHTML = 'Character Remain: '+ (80 - i);
    }
</script>



@endsection
