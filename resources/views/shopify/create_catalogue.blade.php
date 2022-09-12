@extends('master')

@section('title')
    Catalogue | Active Catalogue | Add Shopify Draft Catalogue | WMS360
@endsection

@section('content')

    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.css')}}"  />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <style>
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
                            <li class="breadcrumb-item active" aria-current="page">Add Shopify Draft Catalogue</li>
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


                            <form role="form" class="vendor-form mobile-responsive" action="{{URL::to('shopify/catalogue/store')}}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="title" class="col-md-2 col-form-label required">Title</label>
                                    <div class="col-md-10">
                                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" maxlength="80" onkeyup="Count();" value="{{$product_draft->name ?? ''}}" required autocomplete="title" autofocus>
                                        <span id="display" class="float-right"></span>
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="category" class="col-md-2 col-form-label required">Select Account</label>
                                    <div class="col-md-10">
                                        <select id="account_name" class="form-control select2 @error('account_name') is-invalid @enderror" multiple="multiple" name="account_name[]" value="{{ old('account_name') }}" required autocomplete="account_name" autofocus>
                                            @php
                                                $single_account = count($accounts);
                                            @endphp
                                            @if(1 == $single_account)
                                            @foreach($accounts as $account)
                                                <option value="{{$account->id}}" selected>{{$account->account_name}}</option>
                                            @endforeach
                                            @else
                                                @foreach($accounts as $account)
                                                    <option value="{{$account->id}}">{{$account->account_name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('account_name')
                                        <span class="invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <input type="hidden" name="product_draft_id" value="{{$product_draft->id}}">

                                <div class="form-group row">
                                    <div class="col-md-12 row">
                                        <div class="col-md-12"></div>
                                        {{--                                        <div class="button-group col-md-3 m-b-20">--}}
                                        {{--                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle m-r-5 form-control" data-toggle="dropdown"><span class="caret">Vendor</span>--}}
                                        {{--                                            </button>--}}
                                        {{--                                            <select class="form-control select2">--}}
                                        {{--                                                <option value="">Selecet</option>--}}
                                        {{--                                                <option value="" selected="selected">admin name</option>--}}
                                        {{--                                            </select>--}}
                                        {{--                                        </div>--}}
                                        <div class="button-group col-md-4 m-b-20">
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle m-r-5 form-control" data-toggle="dropdown"><span class="caret">Collection</span>
                                            </button>
                                            <select class="form-control select2" name="collections[]" multiple>
                                                @if(!empty($collections))
                                                @foreach($collections as $collection)
                                                    @if(isset($collection->user_info->id))
                                                    <option value="{{$collection->shopify_collection_id}}/{{$collection->user_info->id}}">{{$collection->category_name}} ({{$collection->user_info->account_name}})</option>
                                                    @endif
                                                @endforeach
                                                @endif
                                                {{--                                                <option value="active" selected="selected">Active</option>--}}

                                            </select>
                                            {{--                                            <input id="product_type" type="text" class="form-control" name="product_type" value="">--}}
                                        </div>
                                        {{--                                        <div class="button-group col-md-3 m-b-20">--}}
                                        {{--                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle m-r-5 form-control" data-toggle="dropdown"><span class="caret">Collection</span>--}}
                                        {{--                                            </button>--}}
                                        {{--                                            <select class="form-control select2" name="collection" multiple="multiple">--}}
                                        {{--                                                <option value="">Selecet</option>--}}
                                        {{--                                                @foreach($collects as $cat)--}}
                                        {{--                                                    <option value="{{$cat['title']}}">{{$cat['title']}}</option>--}}
                                        {{--                                                @endforeach--}}
                                        {{--                                            </select>--}}
                                        {{--                                        </div>--}}
                                        <div class="button-group col-md-4 m-b-20">
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle m-r-5 form-control" data-toggle="dropdown"><span class="caret">Product Status</span>
                                            </button>
                                            <select class="form-control select2" name="status">
                                                <option value="active" selected="selected">Active</option>
                                                <option value="draft">Draft</option>
                                            </select>
                                        </div>
                                        <div class="button-group col-md-4 m-b-20">
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle m-r-5 form-control" data-toggle="dropdown"><span class="caret">Tags</span>
                                            </button>
                                            <select class="form-control select2 js-example-tokenizer" multiple="multiple" name="tags[]">
                                                @foreach($all_tags as $tag)
                                                    <option value="{{$tag->tag_name}}">{{$tag->tag_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @error('role')
                                    <span class="invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="row form-group">
                                    <div class="col-md-10">
                                        <label class="required_attributes des-variation-attribute">Description</label>
                                    </div>
                                </div>

                                <div class="form-group draft-ckeditor">
                                    <div class="nicescroll variation-description-height-controll">
                                        <textarea id="messageArea"  name="body_html" required autocomplete="budy_html" autofocus>{{$product_draft->description}}</textarea>
                                    </div>

                                    @error('budy_html')
                                    <span class="invalid-feedback" role="alert">
                                                 <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
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
                                            <input type="text" data-parsley-maxlength="30" class="form-control @error('regular_price') is-invalid @enderror" name="regular_price" value="{{$product_draft->regular_price}}" autocomplete="regular_price" autofocus id="regular_price" >
                                            @error('regular_price')
                                            <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>

                                        <div class="mt-xs-20">
                                            <label class="draft-sales-price" for="sale_price">Sales Price</label>
                                            <input type="text" data-parsley-maxlength="30" class="form-control @error('sale_price') is-invalid @enderror" name="sale_price" value="{{$product_draft->sale_price}}" autocomplete="sale_price" autofocus id="sale_price">
                                            @error('sale_price')
                                            <span class="invalid-feedback" role="alert">
                                                       <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>

                                        <div class="mt-sm-20 mt-xs-20">
                                            <label class="draft-cost-price" for="cost_price">Cost Price</label>
                                            <input type="text" data-parsley-maxlength="30" class="form-control @error('cost_price') is-invalid @enderror" name="cost_price" value="{{$product_draft->cost_price}}" autocomplete="cost_price" autofocus id="cost_price">
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
                                            <input type="text" data-parsley-maxlength="30" class="form-control @error('rrp') is-invalid @enderror" name="rrp" value="{{$product_draft->rrp}}" autocomplete="rrp" autofocus id="rrp" >
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
                            <div class="card-header font-18">Images</div>
                            <div class="card-body">
                                <div class="row">
                                    @isset($product_draft->images)
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach($product_draft->images as $images)
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
                                <div class="row">
                                    @isset($product_draft->ProductVariations)
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach($product_draft->ProductVariations as $images)
                                            @php
                                                $variation_image[] = $images->image;
                                                $i++;
                                            @endphp
                                        @endforeach
                                        @php
                                            $variation_images = array_unique($variation_image);
                                        @endphp
                                        @foreach($variation_images as $image)
                                            <div class="col-md-2 m-b-10">
                                                {{--                                                        <img class="img-thumbnail" style="border: 2px solid #cccccc" src="{{$image}}" width="200" height="auto" alt="image">--}}
                                                <input type="hidden" name="images[]" value="{{$image}}">
                                            </div>
                                        @endforeach
                                    @endisset
                                </div>
                            </div>
                        </div>

                        <!-- Variation table start -->
                        <table class="product-draft-table row-expand-table product-draft-view pro-draft-det w-100">
                            <thead>
                            <tr>
                                <th class="image" style="text-align: center !important; width: 6%">Image</th>
                                <th class="id" style="text-align: center !important; width: 6%;">ID</th>
                                <th class="sku" style="width: 20%; text-align: center !important;">SKU</th>
                                {{--                                <th class="qr" style="width: 10%">QR</th>--}}
{{--                                <th class="ean" style="width: 10%">EAN</th>--}}
                                <th class="regular-price filter-symbol draftDeFilter" style="width: 10%; text-align: center !important;">
                                    <div class="d-flex justify-content-center">
                                        <div class="btn-group">

                                        </div>
                                        <div>Regular Price</div>
                                    </div>
                                </th>
                                <th class="sales-price filter-symbol draftDeFilter" style="width: 10%; text-align: center !important;">
                                    <div class="d-flex justify-content-center">
                                        <div class="btn-group">

                                        </div>
                                        <div>Sales Price</div>
                                    </div>
                                </th>
                                <?php if(Auth::check() && in_array('1',explode(',',Auth::user()->role))): ?>
                                <th class="cost-price filter-symbol" style="width: 10%; text-align: center !important;">
                                    <div class="d-flex justify-content-center">
                                        <div class="btn-group">

                                        </div>
                                        <div>Cost Price</div>
                                    </div>
                                </th>
                                <?php endif; ?>


                                {{--                                <th class="sold filter-symbol draftDeFilter" style="width: 5%; text-align: center !important;">--}}
                                {{--                                    <div class="d-flex justify-content-center">--}}
                                {{--                                        <div class="btn-group">--}}

                                {{--                                        </div>--}}
                                {{--                                        <div>Sold</div>--}}
                                {{--                                    </div>--}}
                                {{--                                </th>--}}
                                {{--                                <th class="available-qty filter-symbol draftDeFilter" style="width: 10%; text-align: center !important;">--}}
                                {{--                                    <div class="d-flex justify-content-center">--}}
                                {{--                                        <div class="btn-group">--}}

                                {{--                                        </div>--}}
                                {{--                                        <div>Available Qty</div>--}}
                                {{--                                    </div>--}}
                                {{--                                </th>--}}
                                {{--                                <th class="shelf-qty filter-symbol draftDeFilter" style="width: 10%; text-align: center !important;">--}}
                                {{--                                    <div class="d-flex justify-content-center">--}}
                                {{--                                        <div class="btn-group">--}}

                                {{--                                        </div>--}}
                                {{--                                        <div>Shelf Qty</div>--}}
                                {{--                                    </div>--}}
                                {{--                                </th>--}}
                            </tr>
                            </thead>
                            <tbody id="product_variation_table">
                            @foreach($product_draft->ProductVariations as $variation)
                                <tr>
                                    {{--                                    @php--}}
                                    {{--                                        echo '<pre>';--}}
                                    {{--                                        print_r($variation);--}}
                                    {{--                                    @endphp--}}
                                    <td class="image">
                                        @if($variation->image != null)
                                            <a href="<?php echo e($variation->image ?? ''); ?>">
                                                <img src="<?php echo e($variation->image ?? ''); ?>" class="thumb-md" alt="catalogue-details-image">
                                            </a>
                                        @elseif(isset($product_draft->images[0]->image_url))
                                            <a href="{{$product_draft->images[0]->image_url ? asset('/').$product_draft->images[0]->image_url : ''}}">
                                                <img src="{{$product_draft->images[0]->image_url ? asset('/').$product_draft->images[0]->image_url : ''}}" class="thumb-md" alt="catalogue-details-image">
                                            </a>
                                        @else
                                            <a href="#">
                                                <img src="{{asset('assets/images/users/no_image.jpg')}}" class="thumb-md" alt="catalogue-details-image">
                                            </a>
                                        @endif
                                    </td>

                                    <td style="text-align: center !important;">{{$variation->id}}</td>
                                    <td style="text-align: center !important;">{{$variation->sku}}</td>
{{--                                    <td style="text-align: center !important;">{{$variation->ean_no}}</td>--}}
                                    <td style="text-align: center !important;">{{$variation->regular_price}}</td>
                                    <td style="text-align: center !important;">{{$variation->sale_price}}</td>
                                    <td style="text-align: center !important;">{{$variation->cost_price}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- Variation table end -->


                        <div class="form-group row vendor-btn-top">
                            <div class="col-md-12 text-center">
                                <button type="submit" id="shopify_create_product" onclick="shopifyCreateProduct()" class="btn btn-primary draft-pro-btn waves-effect waves-light">
                                    <b> Add </b>
                                </button>
                            </div>
                        </div>

                        </form>
                    </div>  <!-- card-box -->
                </div> <!-- end col -->
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->

    <!----- ckeditor summernote ------->
    <script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>


    <script type="text/javascript">
        // Select Option Jquery
        $('.select2').select2();

        $(".js-example-tokenizer").select2({
            tags: true,
            tokenSeparators: [',', ' ']
        })

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

        // page loader
        function shopifyCreateProduct(){
            $('#ajax_loader').show();
        }

    </script>



@endsection
