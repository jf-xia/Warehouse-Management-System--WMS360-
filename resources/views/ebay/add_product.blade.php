@extends('master')
@section('content')

    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.css')}}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>



    <div class="content-page ebay">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <!-- Page-Title -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="vendor-title">
                            <p>Add Draft Catalogue</p>
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


                            <form role="form" class="vendor-form mobile-responsive" action= {{URL::to('ebay-create-product')}} method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label required">Name</label>
                                    <div class="col-md-10 wow pulse">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$result[0]->name}}" maxlength="80" onkeyup="Count();" required autocomplete="name" autofocus>
                                        <span id="display" class="float-right"></span>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row" id="all_category_div">
                                    <label for="Category" class="col-md-2 col-form-label required">Category</label>
                                    <div class="col-md-10 controls wow pulse" id="category-level-1-group">
                                        <select class="form-control category_select select2 " name="child_cat[1]" id="child_cat_1" onchange="myFunction(1)">
                                            <option value="">Select Category</option>
                                            @foreach($categories['CategoryArray']['Category'] as $category)
                                                <option value="{{$category['CategoryID']}}">{{$category['CategoryName']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">   </div>
                                    <div class="col-md-10">
                                        <button type="button" class="btn btn-primary m-t-10" id="list_button" style="display: none;">List</button>
                                        <input type="text" class="form-control" name="last_cat_id" id="last_cat_id" style="display: none;" value="">
                                    </div>
                                </div>

                                <div id="add_variant_product"></div>

                                <div class="form-group row">
                                    <label for="condition" class="col-md-2 col-form-label required">Condition</label>
                                    <div class="col-md-10 wow pulse">
                                        <select class="form-control select2" name="condition">
                                            <option value="-1">-</option>
                                            <option value="1000">New with tags</option>
                                            <option value="1500">New without tags</option>
                                            <option value="1750">New with defects</option>
                                            <option value="3000">Pre-owned</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Category" class="col-md-2 col-form-label required">Store Categories</label>
                                    <div class="col-md-10 wow pulse">
                                        <select class="form-control select2">
                                            <option value="">Select store Categories</option>
                                            <option value="">SHSDJ</option>
                                            <option value="">SHSDJ</option>
                                            <option value="">SHSDJ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="description" class="col-md-2 col-form-label required">Description</label>
                                    <div class="col-md-10 wow pulse">
                                        <textarea class="" id="messageArea"  name="description" required autocomplete="description" autofocus>{{$result[0]->description}}</textarea>
{{--                                                                                <div class="summernote">--}}
{{--                                                                                    <h3> </h3>--}}
{{--                                                                                </div>--}}
                                    </div>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>


                                <div class="form-group row" id="accordion">
                                    <label for="short_description" class="col-md-2 col-form-label">
                                        <a class="collapsed" data-toggle="collapse" href="#collapseShortDescription">Short Description</a>
                                    </label>
                                    <div class="col-md-10 wow pulse collapse" id="collapseShortDescription" data-parent="#accordion">
                                        <textarea name="short_description" class="w-100 form-control" autocomplete="short_description" autofocus>{{ old('short_description') }}</textarea>

                                    </div>
                                    @error('short_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>




                                <div class="form-group row">
                                    <label for="ean" class="col-md-2 col-form-label ">Master product image</label>

                                    <div class="col-md-10 wow pulse">
                                        <div class="row master-pro-img">
                                        @foreach($result[0]['images'] as $images)
                                            <div class="col-lg-3 col-md-4 col-6">
                                                <input type="hidden" id="image" name="image[]" value="{{$images->image_url}}">
                                                <img class="img-fluid img-thumbnail mb-4" src="{{$images->image_url}}" alt="">
                                            </div>
                                        @endforeach
                                        </div>
                                        @error('ean')
                                        <span class="invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label for="item-description" class="col-md-2 col-form-label required">Item Description</label>
                                    <div class="col-md-10 wow pulse">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#menu1">Standard</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#menu2">HTML</a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="menu1">
                                                <textarea class="" id="messageArea1"  name="description" required autocomplete="description" autofocus>  </textarea>
                                            </div>
                                            <div class="tab-pane fade" id="menu2">
                                                <textarea class="" id="messageArea2"  name="description" required autocomplete="description" autofocus>  </textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>




                                <div class="form-group row">
                                    <label for="Category" class="col-md-2 col-form-label required">Select Image</label>
                                    <div class="col-md-10 wow pulse">
                                        <div class="fileupload btn btn-default waves-effect waves-light">
                                            <span><i class="ion-upload m-r-5"></i>Upload</span>
                                            <input type="file" id="imgInp" class="upload">
                                        </div>  <br>
                                        <img id="imageShow" class="img-thumbnail mt-3" src="#" alt="Images" width="150px" height="120px" style="display: none;">
                                    </div>
                                </div>




                           <!-- variation start-->

                                    @isset($result[0]['ProductVariations'])
                                    <div class="form-group row">
                                        <label for="variation" class="col-md-2 col-form-label required">Variation </label>

                                            <div class="col-md-10">
                                                <div class="row">
                                                    @foreach($result[0]['ProductVariations'] as  $key => $product_variation)
                                                    <div class="col-md-6">
                                                        <div class="card p-3">
                                                            <div class="form-group">
                                                                <label for="sku" class="col-form-label ">sku</label>
                                                                <input type="text" data-parsley-maxlength="30" class="form-control @error('ean') is-invalid @enderror" name="productVariation[{{$key}}][sku]" value="{{$product_variation->sku}}" autocomplete="sku" autofocus
                                                                       id="sku" placeholder="">

                                                                @error('sku')
                                                                <span class="invalid-feedback" role="alert">
                                                                     <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                            @if($product_variation->attribute1 != null)
                                                                <div class="form-group">
                                                                    <label for="sku" class="col-form-label">Size</label>
                                                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('Size') is-invalid @enderror" name="productVariation[{{$key}}][Size]" value="{{$product_variation->attribute1}}" autocomplete="Size" autofocus
                                                                           id="Size" placeholder="">

                                                                    @error('Size')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            @endif

                                                            @if($product_variation->attribute2 != null)
                                                                <div class="form-group">
                                                                    <label for="Colour" class="col-form-label ">Colour</label>
                                                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('Colour') is-invalid @enderror" name="productVariation[{{$key}}][Colour]" value="{{$product_variation->attribute1}}" autocomplete="Colour" autofocus
                                                                           id="Colour" placeholder="">

                                                                    @error('Colour')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            @endif

                                                            @if($product_variation->attribute3 != null)
                                                                <div class="form-group">
                                                                    <label for="Style" class="col-form-label">Style</label>
                                                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('Style') is-invalid @enderror" name="productVariation[{{$key}}][Style]" value="{{$product_variation->attribute3}}" autocomplete="Style" autofocus
                                                                           id="Style" placeholder="">

                                                                    @error('Style')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror

                                                                </div>
                                                            @endif
                                                            <div class="form-group">
                                                                <label for="start_price" class="col-md-2 col-form-label">Start Price</label>
                                                                <input type="text" data-parsley-maxlength="30" class="form-control @error('start_price') is-invalid @enderror" name="productVariation[{{$key}}][start_price]" value="{{$product_variation->sale_price}}" autocomplete="start_price" autofocus
                                                                       id="start_price" placeholder="">
                                                                @error('start_price')
                                                                <span class="invalid-feedback" role="alert">
                                                                     <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="ean" class="col-md-2 col-form-label">Enter EAN</label>
                                                                <input type="text" data-parsley-maxlength="30" class="form-control @error('ean') is-invalid @enderror" name="productVariation[{{$key}}][ean]" value="{{$product_variation->ean_no}}" autocomplete="ean" autofocus
                                                                       id="ean" placeholder="">
                                                                @error('ean')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="quantity" class="col-form-label">Enter Quantity</label>
                                                                <input type="text" data-parsley-maxlength="30" class="form-control @error('quantity') is-invalid @enderror" name="productVariation[{{$key}}][quantity]" value="{{$product_variation->actual_quantity}}" autocomplete="quantity" autofocus
                                                                       id="quantity" placeholder="">
                                                                @error('quantity')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="image" class="col-form-label">Image</label>
                                                                <input type="hidden" id="image" name="productVariation[{{$key}}][image]" value="{{$product_variation->image}}">
                                                                <img src="{{$product_variation->image}}" style="width: 150px; height: 120px; border: 1px solid #cccccc;">
                                                                @error('image')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                    </div>
                                    @endisset

                             <!-- End  variation   -->




{{--                                <div class="row form-group select_variation_att">--}}
{{--                                    <div class="col-md-10">--}}
{{--                                        <h6 class="font-18 required_attributes"> Select variation from below attributes </h6>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="row form-group product-desn-top">--}}

{{--                                    <div class="col-md-12">--}}
{{--                                        <div class="row">--}}

{{--                                            @foreach($attribute_terms as $attribute_term)--}}

{{--                                                @if(!empty( $attribute_term->attributes_terms ))--}}

{{--                                                    <div class="button-group col-md-3 col-sm-6 m-b-20">--}}
{{--                                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle m-r-5 form-control" data-toggle="dropdown">  <span class="caret"> {{$attribute_term->attribute_name}} ({{count($attribute_term->attributes_terms)}})</span>--}}
{{--                                                        </button>--}}
{{--                                                        <select class="form-control select2" name="terms[{{$attribute_term->id}}][]" multiple="multiple">--}}
{{--                                                            @foreach($attribute_term->attributes_terms as $terms)--}}
{{--                                                                <option value="{{$terms->id}}">{{$terms->terms_name}}</option>--}}
{{--                                                            @endforeach--}}
{{--                                                        </select>--}}
{{--                                                                                                            <ul class="dropdown-menu checkbox-hight">--}}
{{--                                                                                                                @foreach($attribute_term->attributes_terms as $terms)--}}

{{--                                                                                                                    <li>--}}
{{--                                                                                                                        <input style="margin-left: 5px;" type="checkbox" name="terms[{{$attribute_term->id}}][]" id="terms" value="{{$terms->id}}"/>&nbsp;{{$terms->terms_name}}--}}
{{--                                                                                                                    </li>--}}

{{--                                                                                                                @endforeach--}}
{{--                                                                                                            </ul>--}}
{{--                                                    </div> <!--buttongroup close-->--}}


{{--                                                @endif--}}
{{--                                            <!--end column-->--}}

{{--                                            @endforeach--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                </div>--}}

                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary draft-pro-btn waves-effect waves-light">
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

        CKEDITOR.replace( 'messageArea1',
            {
                customConfig : 'config.js',
                toolbar : 'simple'
            })

        CKEDITOR.replace( 'messageArea2',
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

    <script type="text/javascript">
        function Count() {
            var i = document.getElementById("name").value.length;
            document.getElementById("display").innerHTML = 'Character Remain: '+ (80 - i);
        }
    </script>
    <script>

        function myFunction(id) {
            // console.log('found');

            // Category choose
            // $(document).ready(function () {
            //     $('select').on("change",function(){
            var category_id = $('#child_cat_'+id).val();
            console.log(category_id);
            console.log(parseInt(id)+1);
            $.ajax({
                type: "post",
                url: "{{url('get-ebay-category')}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    "category_id": category_id,
                    "level" : parseInt(id)+1
                },
                beforeSend: function (){
                    $('#ajax_loader').show();
                },
                success: function (response) {
                    if(response.data == 1) {
                        console.log(response.content);
                        console.log(response.lavel);
                        $('#category-level-' + response.lavel + '-group').nextAll().remove();
                        $('#last_cat_id').val('');
                        $('#last_cat_id').hide();
                        $('#all_category_div').append(response.content);

                    }else{
                        $('#last_cat_id').show();
                        $('#last_cat_id').val(category_id);
                        console.log(response);
                        $('#add_variant_product').html(response);
                    }
                },
                complete: function (data) {
                    $('#ajax_loader').hide();
                }
            });
            //     });
            // });
        }
    </script>

    <script type="text/javascript">


        //After uploading image, image will show bellow the select image button
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#imageShow').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function() {
            $('#imageShow').show();
            readURL(this);
        });


    </script>


@endsection
