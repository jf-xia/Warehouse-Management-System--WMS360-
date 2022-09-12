@extends('master')

@section('title')
    Catalogue | Active Catalogue | Add WooCommerce Draft Catalogue | WMS360
@endsection

@section('content')

    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.css')}}"  />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <style>
        .no-img-content{
            background-image: url('{{asset('assets/common-assets/no_image_box.jpg')}}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        .customSwalBtn{
            background-color: var(--wms-primary-color)!important;
            border-left-color: var(--wms-primary-color)!important;
            border-right-color: var(--wms-primary-color)!important;
            border: 0;
            border-radius: 3px;
            box-shadow: none;
            color: #fff;
            cursor: pointer;
            font-size: 17px;
            font-weight: 500;
            margin: 30px 5px 0px 5px;
            padding: 10px 32px;
        }
        html.swal2-shown,body.swal2-shown {
            overflow-y: hidden !important;
            height: auto!important;
        }

    </style>

    <script>
        $(function(){
            $( ".sortable" ).sortable({
                cursor: 'move'
            });
            $( ".sortable" ).disableSelection();
        });

        @if($listingLimitAllChannelActiveProduct >= $clientListingLimit)
            $(window).on('load',function(){
                Swal.fire({
                    icon: 'error',
                    title: 'You have reached your listing limit!',
                    showConfirmButton: false,
                    width: 800,
                    height: 600,
                    overFlow: false,
                    padding: '3em',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    html: '<div>'+
                          '    (Listing limit = '+{!! json_encode($clientListingLimit) !!}+','+
                          '    Listed product = '+{!! json_encode($listingLimitInfo['subTotalActiveProduct'] ?? 0) !!}+')'+
                          '<br>'+
                          '    (Active catalogue product = '+{!! json_encode($listingLimitInfo['activeCatalogueCount'] ?? 0) !!}+','+
                          '    WoCommerce active product = '+{!! json_encode($listingLimitInfo['wooActiveProductCount'] ?? 0) !!}+','+
                          '    OnBuy active product = '+{!! json_encode($listingLimitInfo['onbuyActiveProductCount'] ?? 0) !!}+','+
                          '    eBay active product = '+{!! json_encode($listingLimitInfo['ebayActiveProductCount'] ?? 0) !!}+','+
                          '    Amazon active product = '+{!! json_encode($listingLimitInfo['amazonActiveProductCount'] ?? 0) !!}+','+
                          '    Shopify active product = '+{!! json_encode($listingLimitInfo['shopifyActiveProductCount'] ?? 0) !!}+')'+
                          ' </div>'+
                          '<div class="d-flex justify-content-center">'+
                          '      <div>'+
                          '         <a class="btn btn-custom customSwalBtn" href="https://www.wms360.co.uk/my-account/">Upgrade</a>'+
                          '      </div>'+
                          '      <div>'+
                          '          <a class="btn btn-custom customSwalBtn" href="{{url('dashboard')}}">Dashboard</a>'+
                          '      </div>'+
                          '</div>'
                })
            });
        @endif

    </script>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Active Catalogue</li>
                            <li class="breadcrumb-item active" aria-current="page">Add WooCommerce Draft Catalogue</li>
                        </ol>
                    </div>
                </div>


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


                            <form role="form" class="vendor-form mobile-responsive" action= {{URL::to('woocommerce/catalogue/store')}} method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label required">Name</label>
                                    <div class="col-md-10">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" maxlength="80" onkeyup="Count();" value="{{$attribute_info->name ?? ''}}" required autocomplete="name" autofocus>
                                        <span id="display" class="float-right"></span>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <input type="hidden" name="master_catalogue_id" value="{{$master_catalogue_id}}">

                                <div class="form-group row">
                                    <label for="category" class="col-md-2 col-form-label required">Category</label>
                                    <div class="col-md-10">
                                        <select id="category_id" class="form-control select2 @error('category') is-invalid @enderror" multiple="multiple" name="category_id[]" value="{{ old('category_id') }}" required autocomplete="category_id" autofocus>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->category_name}}</option>
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
                                    <label for="not_variation" class="col-md-2 col-form-label required">Not As Variation</label>
                                    <div class="col-md-10 row">
                                        <div class="col-md-12"></div>
                                        @foreach($not_use_variation_attribute_terms as $attribute_term)
                                            @if(!empty( $attribute_term->woocommerce_attributes_terms))
                                                <div class="button-group col-md-2 m-b-20">
                                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle m-r-5 form-control" data-toggle="dropdown">  <span class="caret"> {{$attribute_term->attribute_name}} ({{count($attribute_term->woocommerce_attributes_terms    )}})</span>
                                                    </button>
                                                    <select class="form-control variation-term-select2" name="not_variation[{{$attribute_term->id}}][]" multiple="multiple">
                                                        <option value="">Selecet</option>
                                                        @foreach($attribute_term->woocommerce_attributes_terms as $terms)
                                                            <?php
                                                            $temp = '';
                                                            ?>
                                                            @isset($terms->terms_name)
                                                                @if($terms->terms_name == $master_brand || $terms->terms_name == $master_gender)
                                                                    <option value="{{$terms->id}}" selected="selected">{{$terms->terms_name}}</option>
                                                                    <?php
                                                                    $temp = 1;
                                                                    ?>
                                                                @endif
                                                            @endisset
                                                            @if($temp == null)
                                                                <option value="{{$terms->id}}">{{$terms->terms_name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                        @error('role')
                                        <span class="invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">

                                        <div class="row form-group">
                                            <div class="col-md-10">
                                                <label class="required_attributes select-variation-attribute">Select Variation Attributes</label>
                                            </div>
                                        </div>


                                        <div class="nicescroll variation-attributes-height-controll">

                                            <div class="row">

                                            @foreach($attribute_terms as $attribute_term)

                                                @if(!empty( $attribute_term->woocommerce_attributes_terms))

                                                    <div class="button-group col-md-12 m-b-20">
                                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle m-r-5 form-control" data-toggle="dropdown">  <span class="caret"> {{$attribute_term->attribute_name}} ({{count($attribute_term->woocommerce_attributes_terms    )}})</span>
                                                        </button>
                                                        <select class="form-control variation-term-select2" name="terms[{{$attribute_term->id}}][]" multiple="multiple">
                                                            @foreach($attribute_term->woocommerce_attributes_terms as $terms)
                                                                <?php
                                                                $temp = '';
                                                                ?>
                                                                @isset($woo_attribute_info[$attribute_term->id][$attribute_term->attribute_name])
                                                                    @foreach($woo_attribute_info[$attribute_term->id][$attribute_term->attribute_name] as $attribute)
                                                                        @if($terms->master_terms_id == $attribute["attribute_term_id"])
                                                                            <option value="{{$terms->id}}" selected="selected">{{$terms->terms_name}}</option>
                                                                            <?php
                                                                            $temp = 1;
                                                                            ?>
                                                                        @endif
                                                                    @endforeach
                                                                @endisset
                                                                @if($temp == null)
                                                                    <option value="{{$terms->id}}">{{$terms->terms_name}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                @endif

                                            @endforeach

                                        </div>

                                        </div>
                                    </div>
                                    <div class="col-md-8">

                                        <div class="row form-group">
                                            <div class="col-md-10">
                                                <label class="required_attributes des-variation-attribute">Description</label>
                                            </div>
                                        </div>

                                        <div class="form-group draft-ckeditor">
                                            <div class="nicescroll variation-description-height-controll">
                                                <textarea id="messageArea"  name="description" required autocomplete="description" autofocus>{{$attribute_info->description}}</textarea>
                                            </div>

                                            @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                 <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header font-18">SKU</div>
                                    <div class="card-body">
                                        <div class="draft-wrap">
                                            <div class="wms-row">
                                                <div>
                                                    <label class="input-field-design" for="sku">Parent SKU</label>
                                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('sku') is-invalid @enderror" name="sku" autocomplete="sku" autofocus id="sku" value="{{$attribute_info->sku_short_code ?? ''}}" placeholder="">
                                                    @error('sku')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header font-18">Price</div>
                                    <div class="card-body">
                                        <div class="draft-wrap">
                                            <div class="wms-row">
                                                <div>
                                                    <label class="draft-regular-price" for="regular_price">Regular Price</label>
                                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('regular_price') is-invalid @enderror" name="regular_price" value="{{$mapFields['Regular Price'] ?? $attribute_info->regular_price ?? ''}}" autocomplete="regular_price" autofocus id="regular_price" >
                                                    @error('regular_price')
                                                    <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="mt-xs-20">
                                                    <label class="draft-sales-price" for="sale_price">Sales Price</label>
                                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('sale_price') is-invalid @enderror" name="sale_price" value="{{$mapFields['Sales Price'] ?? $attribute_info->sale_price ?? ''}}" autocomplete="sale_price" autofocus id="sale_price">
                                                    @error('sale_price')
                                                    <span class="invalid-feedback" role="alert">
                                                       <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="mt-sm-20 mt-xs-20">
                                                    <label class="draft-cost-price" for="cost_price">Cost Price</label>
                                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('cost_price') is-invalid @enderror" name="cost_price" value="{{$mapFields['Cost Price'] ?? $attribute_info->cost_price ?? ''}}" autocomplete="cost_price" autofocus id="cost_price">
                                                    @error('cost_price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="wms-row">
                                                <div class="cat-device mt-sm-20 mt-xs-20">
                                                    <label class="draft-regular-price" for="rrp">RRP</label>
                                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('rrp') is-invalid @enderror" name="rrp" value="{{$mapFields['RRP'] ?? $attribute_info->rrp ?? ''}}" autocomplete="rrp" autofocus id="rrp" >
                                                    @error('rrp')
                                                    <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card mt-3">
                                    <div class="card-header font-18">Item Specific</div>
                                    <div class="card-body">
                                        <div class="draft-wrap">
                                            <div class="wms-row">
                                                <div>
                                                    <label for="product_code" class="draft-product-code">Product Code</label>
                                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('product_code') is-invalid @enderror" name="product_code" value="{{$mapFields['Product Code'] ?? $attribute_info->product_code ?? ''}}" autocomplete="product_code" autofocus id="product_code" placeholder="">
                                                    @error('product_code')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="mt-xs-20">
                                                    <label for="color_code" class="draft-color-code ">Color Code</label>
                                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('color_code') is-invalid @enderror" name="color_code" value="{{$mapFields['Color Code'] ?? $attribute_info->color_code ?? ''}}" autocomplete="color_code" autofocus id="color_code" placeholder="">
                                                    @error('color_code')
                                                    <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="mt-sm-20 mt-xs-20">
                                                    <label for="low_quantity" class="draft-low-quantity">Low Quantity</label>
                                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('low_quantity') is-invalid @enderror" name="low_quantity" value="{{$mapFields['Low Quantity'] ?? $attribute_info->low_quantity ?? ''}}" autocomplete="low_quantity" autofocus id="low_quantity" placeholder="">
                                                    @error('low_quantity')
                                                    <span class="invalid-feedback" role="alert">
                                                          <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="cat-device mt-sm-20 mt-xs-20">
                                                    <label for="sku_short_code" class="draft-sku_short_code">SKU Short Code</label>
                                                    <input type="text" data-parsley-maxlength="30" class="form-control" name="sku_short_code" value="{{$mapFields['SKU Short Code'] ?? ''}}" autocomplete="sku_short_code" autofocus id="sku_short_code" placeholder="">
                                                </div>
                                            </div>


{{--                                            <div class="d-flex justify-content-between mt-4">--}}
{{--                                                <div>--}}
{{--                                                    <label for="sku_short_code" class="draft-sku_short_code">SKU Short Code</label>--}}
{{--                                                    <input type="text" data-parsley-maxlength="30" class="form-control" name="sku_short_code" autocomplete="sku_short_code" autofocus id="sku_short_code" placeholder="">--}}
{{--                                                </div>--}}
{{--                                                <div>--}}
{{--                                                    <label for="color" class="draft-color">Color</label>--}}
{{--                                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('color') is-invalid @enderror" name="color" autocomplete="color" autofocus id="color" placeholder="">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

                                    </div>
                                </div>
                            </div>


                                <div class="card mt-3">
                                    <div class="card-header font-18">Images</div>
                                    <div class="card-body">
                                        <div class="row">
                                            @isset($master_images->images)
                                                @php
                                                    $i = 0;
                                                @endphp
                                                @foreach($master_images->images as $images)
                                                    <div class="col-md-2 m-b-10">
                                                        <img class="img-thumbnail" style="border: 2px solid #cccccc" src="{{(filter_var($images->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$images->image_url : $images->image_url}}" width="200" height="auto" alt="image">
                                                        <input type="hidden" name="images[]" value="{{(filter_var($images->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$images->image_url : $images->image_url}}">
                                                    </div>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endforeach
                                            @endisset
                                        </div>
                                    </div>
                                </div>


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


    <script type="text/javascript">
       // Select Option Jquery
        $('.select2').select2();

        //ckeditor summernote
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


       // placeholder label animation
       $('input').on('focusin', function() {
           $(this).parent().find('label').addClass('draft-active');
       });

       $('input').on('focusout', function() {
           if (!this.value) {
               $(this).parent().find('label').removeClass('draft-active');
           }
       });

       $(function(){
           var showClass = "draft-active";
           $("input").bind("checkval",function(){
               var label = $(this).prev("label");
               if(this.value !== ""){
                   label.addClass(showClass);
               } else {
                   label.removeClass(showClass);
               }
           }).trigger("checkval");
       });
       // placeholder label animation


        // Name character
       function Count() {
           var i = document.getElementById("name").value.length;
           document.getElementById("display").innerHTML = 'Character Remain: '+ (80 - i);
       }

    </script>



@endsection
