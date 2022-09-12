@extends('master')
@section('title')
   Catalogue | Edit Active Catalogue | WMS360
@endsection
@section('content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300' rel='stylesheet' type='text/css'>
    <style>
        .no-img-content{
            background-image: url('{{asset('assets/common-assets/no_image_box.jpg')}}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
    </style>
    <script>
        $( function() {
            $( ".sortable" ).sortable({
                cursor: 'move'
            });
            $( ".sortable" ).disableSelection();
        } );
    </script>
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item" aria-current="page"><a href="{{url('completed-catalogue-list')}}">Active Catalogue</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Active Catalogue</li>
                        </ol>
                    </div>
                </div>
                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box shadow">
                            @if ($message = Session::get('ebay_success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif

                            @if ($message = Session::get('ebay_error'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif

                            @if ($message = Session::get('wms_success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif

                            @if ($message = Session::get('wms_error'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif

                            @if ($message = Session::get('onbuy_success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif

                            @if ($message = Session::get('onbuy_error'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif

                            @if ($message = Session::get('woocom_success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif

                            @if ($message = Session::get('woocom_error'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form class="mobile-responsive mt-3" action={{ route('product-draft.update',$product_draft->id ?? '') }} method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label for="validationDefault01" class="col-md-2 col-form-label required">Title</label>
                                    <div class="col-md-10">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" maxlength="80" value="{{$product_draft->name ?? ''}}" onkeyup="Count();" required autocomplete="name" autofocus>
                                        <input id="main_id" type="hidden" name="main_id" value="{{$product_draft->id ?? ''}}">
                                        <span id="display" style="float: right;"></span>
                                        <span id="exist-catalogue-message" class="float-left"></span>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-4 mb-3 category-div">
                                    <div class="col-md-3 col-sm-6 form-group">
                                        <div class="btn-group" style="width:100%;">
                                            <button type="button" class="btn btn-primary dropdown-toggle form-control text-left category-child-btn" data-toggle="dropdown">  <span class="caret">Product Condition</span></button>
                                            <button type="button" onclick="addLabel(this,'Add Condition')" class="btn btn-outline-primary form-control add-categorization float-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        </div>
                                        <select id="selectCondition" class="form-control select2" name="condition" required>
                                            <option value="">Select Condition</option>
                                                @isset($conditions)
                                                    @foreach($conditions as $condition)
                                                        <option onclick="optionClick(this)" value="{{$condition->id ?? ''}}" {{$condition->id == $product_draft->condition ? 'selected' : ''}}>{{$condition->condition_name ?? ''}}</option>
                                                    @endforeach
                                                @endisset
                                        </select>
                                    </div>


                                    <!--Categorization Modal-->
                                    <div class="category-modal" style="display: none">
                                        <div class="cat-header">
                                            <div>
                                                <label id="label_name" class="cat-label"></label>
                                            </div>
                                            <div class="cursor-pointer" onclick="trashClick(this)">
                                                <i class="fa fa-close" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <div class="cat-body">
                                            <div class="cat-input-div">
                                                <input id="value" class="p-1 category-focus" type="text" name="value">
                                                <span class="category-validate" style="display: none"></span>
                                            </div>

                                            <!--oninput search result in Category modal-->
                                            <ul id="categorySelectOption"></ul>

                                            <div class="cat-modal-footer">
                                                <div class="trash-div" onclick="trashClick(this)">
                                                    Cancel
                                                </div>

                                                <div class="cat-add">
                                                    <button type="button" onclick="addValue(this)" class="btn btn-default category-subBtn mb-3"> Add </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="col-md-3 col-sm-6 form-group">
                                        <div class="btn-group" style="width:100%;">
                                            <button type="button" class="btn btn-primary dropdown-toggle form-control text-left category-child-btn" data-toggle="dropdown">  <span class="caret">Brand</span></button>
                                            <button  type="button" onclick="addLabel(this,'Add Brand')" class="btn btn-outline-primary form-control add-categorization"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        </div>
                                        <select id="selectBrand" class="form-control select2" name="brand_id" required>
                                            <option value="">Select Brand</option>
                                            @isset($brands)
                                                @foreach($brands as $brand)
                                                    <option onclick="optionClick(this)" value="{{$brand->id ?? ''}}" {{$brand->id == $product_draft->brand_id ? 'selected' : ''}}>{{$brand->name ?? ''}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-sm-6 form-group">
                                    <div class="btn-group" style="width:100%;">
                                        <button type="button" class="btn btn-primary dropdown-toggle form-control text-left category-child-btn" data-toggle="dropdown">  <span class="caret">Department</span>
                                        </button>
                                            <button  type="button" onclick="addLabel(this,'Add Department')" class="btn btn-outline-primary form-control add-categorization"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        </div>
                                        <select id="selectDepartment" class="form-control gender-choose select2" name="gender_id" required>
                                            <option value="">Select Department</option>
                                            @isset($genders)
                                                @foreach($genders as $gender)
                                                    <option onclick="optionClick(this)" value="{{$gender->id ?? ''}}" {{$gender->id == $product_draft->gender_id ? 'selected' : ''}}>{{$gender->name ?? ''}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-sm-6 form-group">
                                    <div class="btn-group" style="width:100%;">
                                        <button type="button" class="btn btn-primary dropdown-toggle form-control text-left category-child-btn" data-toggle="dropdown">  <span class="caret">WooWMS Category</span></button>
                                            <button  type="button" onclick="addLabel(this,'Add Wms Category')" class="btn btn-outline-primary form-control add-categorization"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        </div>
                                        <select id="selectWMSCategory" class="form-control category_select select2" name="category_id" required>
                                            <option value="">First Select Category</option>
                                            @isset($categories)
                                                @foreach($categories as $category)
                                                    <option onclick="optionClick(this)" value="{{$category->id ?? ''}}" {{$category->id == $product_draft->woowms_category ? 'selected' : ''}}>{{$category->category_name ?? ''}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        @if($product_draft->type == 'variable')
                                            <div class="draft-wrap mt-5">
                                                <div class="tab-input-div mb-3">
                                                    {{-- <label for="sku_short_code" class="draft-sku_short_code">SKU Short Code</label> --}}
                                                    <div class="tab-input-label" style="display: none">SKU Short Code</div>
                                                    <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('sku_short_code') is-invalid @enderror" name="sku_short_code" value="{{$product_draft->sku_short_code ?? ''}}" autocomplete="sku_short_code" autofocus id="sku_short_code" placeholder="SKU Short Code">
                                                    @error('sku_short_code')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="tab-input-div mb-3">
                                                    {{-- <label for="low_quantity" class="draft-low-quantity">Low Quantity</label> --}}
                                                    <div class="tab-input-label" style="display: none">Low Quantity</div>
                                                    <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('low_quantity') is-invalid @enderror" name="low_quantity" value="{{$product_draft->low_quantity ?? 0}}" autocomplete="low_quantity" autofocus id="low_quantity" placeholder="Low Quantity">
                                                    <input type="hidden" name="old_low_quantity" value="{{$product_draft->low_quantity}}">
                                                    @error('low_quantity')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @else
                                            <div class="draft-wrap mt-5">
                                                <div class="tab-input-div mb-3">
                                                    {{-- <label for="sku_short_code" class="draft-sku_short_code">SKU Short Code</label> --}}
                                                    <div class="tab-input-label" style="display: none">SKU Short Code</div>
                                                    <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control" name="sku_short_code" autocomplete="sku_short_code" value="{{$product_draft->sku_short_code ?? ''}}" autofocus="" id="sku_short_code" placeholder="SKU Short Code">
                                                </div>
                                                <div class="tab-input-div mb-3">
                                                    {{-- <label class="draft-ean_no" for="ean_no">EAN</label> --}}
                                                    <div class="tab-input-label" style="display: none">EAN</div>
                                                    <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control " name="ean_no" autocomplete="ean_no" value="{{$product_variation->ean_no ?? ''}}" autofocus="" id="ean_no" placeholder="EAN">
                                                </div>
                                                <div class="tab-input-div mb-3">
                                                    {{-- <label class="draft-sku" for="sku">SKU</label> --}}
                                                    <div class="tab-input-label" style="display: none">SKU</div>
                                                    <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control " name="sku" autocomplete="sku" autofocus="" value="{{$product_variation->sku ?? ''}}" id="sku" placeholder="SKU" required="">
                                                </div>
                                                <div class="tab-input-div mb-3">
                                                    {{-- <label class="draft-sku" for="low_quantity">Low Quantity</label> --}}
                                                    <div class="tab-input-label" style="display: none">Low Quantity</div>
                                                    <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control " name="low_quantity" autocomplete="low_quantity" autofocus="" value="{{$product_variation->low_quantity ?? ''}}" id="low_quantity" placeholder="Low Quantity" required="">
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-8">
                                        <div class="var-description">
                                            <label class="required_attributes">Description</label>
                                        </div>
                                        <div class="form-group edit-draft-ckeditor mt-3">
                                            <div>
                                                <textarea class="form-control @error('description') is-invalid @enderror" id="messageArea" name="description" required autocomplete="description" autofocus>{!! $product_draft->description ?? '' !!}</textarea>
                                            </div>
                                            @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="catalogue-tabs-sec">
                                    <ul class="nav nav-tabs tabs add-catalogue-tab">
                                        <li class="tab">
                                            <a href="#price" class="active" data-toggle="tab" aria-expanded="false">
                                                Price
                                            </a>
                                        </li>
                                        <li class="tab">
                                            <a href="#item_specific" data-toggle="tab" aria-expanded="false">
                                                Item Specific
                                            </a>
                                        </li>
                                        @if ($tabAttributeInfo)
                                            @php
                                            $activeClass = true
                                            @endphp
                                            @if (isset($tabAttributeInfo->categoryAttribute))
                                            @if(count($tabAttributeInfo->categoryAttribute) > 0)
                                                @foreach($tabAttributeInfo->categoryAttribute as $key => $attribute)
                                                    @if (count($attribute->attributes) > 0)
                                                        @foreach ($attribute->attributes as $term)
                                                            <li class="tab">
                                                                <a href="#{{$term->item_attribute_slug}}" data-toggle="tab" aria-expanded="false">
                                                                    {{$term->item_attribute}}
                                                                </a>
                                                            </li>
                                                            @php
                                                                $activeClass = false
                                                            @endphp
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                            @endif
                                            @php
                                                $activeClass = true
                                            @endphp
                                        @endif
                                    </ul>

                                    <div class="tab-content catalogue-tabs-content">
                                        <div class="tab-pane active" id="price">
                                            <div class="draft-wrap mt-3">
                                                <div class="wms-row">
                                                    <div class="tab-input-div mb-3">
                                                        {{-- <label class="draft-regular-price" for="regular_price">Regular Price</label> --}}
                                                        <div class="tab-input-label" style="display: none;">Regular Price</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('regular_price') is-invalid @enderror" name="regular_price" value="{{$product_draft->regular_price}}" autocomplete="regular_price" autofocus id="regular_price" placeholder="Regular Price">
                                                        @error('regular_price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>

                                                    <div class="tab-input-div mb-3">
                                                        {{-- <label class="draft-sales-price" for="sale_price">Sales Price</label> --}}
                                                        <div class="tab-input-label" style="display: none;">Sales Price</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('sale_price') is-invalid @enderror" name="sale_price" value="{{$product_draft->sale_price}}" autocomplete="sale_price" autofocus id="sale_price" placeholder="Sales Price">
                                                        @error('sale_price')
                                                        <span class="invalid-feedback" role="alert">
                                                             <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>

                                                    <div class="tab-input-div mb-3">
                                                        {{-- <label class="draft-cost-price" for="cost_price">Cost Price</label> --}}
                                                        <div class="tab-input-label" style="display: none;">Cost Price</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('cost_price') is-invalid @enderror" name="cost_price" value="{{$product_draft->cost_price}}" autocomplete="cost_price" autofocus id="cost_price" placeholder="Cost Price">
                                                        @error('cost_price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="tab-input-div mb-3">
                                                        {{-- <label class="input-field-design" for="rrp">RRP</label> --}}
                                                        <div class="tab-input-label" style="display: none;">RRP</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('rrp') is-invalid @enderror" name="rrp" value="{{$product_draft->rrp}}" autocomplete="rrp" autofocus id="rrp" placeholder="RRP">
                                                        @error('rrp')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="tab-input-div mb-3">
                                                        {{-- <label class="input-field-design" for="base_price">Base Price</label> --}}
                                                        <div class="tab-input-label" style="display: none;">Base Price</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('rrp') is-invalid @enderror" name="base_price" value="{{$product_draft->base_price}}" autocomplete="base_price" autofocus id="base_price" placeholder="Base Price">
                                                        @error('base_price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="tab-input-div mb-3">
                                                        {{-- <label class="input-field-design draft-active" for="vat">VAT Percentage</label> --}}
                                                        <div class="tab-input-label" style="display: none;">VAT Percentage</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('rrp') is-invalid @enderror" name="vat" autocomplete="vat" autofocus id="vat" value="20" placeholder="VAT Percentage">
                                                        @error('vat')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="item_specific">
                                            <div class="draft-wrap mt-3">
                                                <div class="wms-row">
                                                    <div class="tab-input-div mb-3">
                                                        {{-- <label for="product_code" class="draft-product-code">Product Code</label> --}}
                                                        <div class="tab-input-label" style="display: none;">Product Code</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('product_code') is-invalid @enderror" name="product_code" value="{{$product_draft->product_code}}" autocomplete="product_code" autofocus id="product_code" placeholder="Product Code">
                                                        @error('product_code')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>

                                                    <div class="tab-input-div mb-3">
                                                        {{-- <label for="color_code" class="draft-color-code">Color Code</label> --}}
                                                        <div class="tab-input-label" style="display: none;">Color Code</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('color_code') is-invalid @enderror" name="color_code" value="{{$product_draft->color_code}}" autocomplete="color_code" autofocus id="color_code" placeholder="Color Code">
                                                        @error('color_code')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>

                                                    <div class="tab-input-div mb-3">
                                                        {{-- <label for="color" class="draft-color">Color</label> --}}
                                                        <div class="tab-input-label" style="display: none;">Color</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('color') is-invalid @enderror" name="color" value="{{$product_draft->color}}" autocomplete="color" autofocus id="color" placeholder="Color">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if(isset($tabAttributeInfo->categoryAttribute))
                                        @if (count($tabAttributeInfo->categoryAttribute) > 0)
                                            @foreach($tabAttributeInfo->categoryAttribute as $key => $attribute)
                                                @if (count($attribute->attributes) > 0)
                                                    @foreach ($attribute->attributes as $term_att)
                                                    <div class="tab-pane" id="{{$term_att->item_attribute_slug}}">
                                                        <div class="draft-wrap">
                                                            <div class="wms-row">
                                                                @if (count($term_att->itemAttributeTerms) > 0)
                                                                    @foreach ($term_att->itemAttributeTerms as $term)
                                                                        <div class="tab-input-div mb-3">
                                                                            {{-- <label class="draft-regular-price" for="{{$term->item_attribute_term_slug}}">{{$term->item_attribute_term}}</label> --}}
                                                                            <div class="tab-input-label" style="display: none;">{{$term->item_attribute_term}}</div>
                                                                            <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control" name="item_attribute[{{$term->id}}/{{$term->catalogueItemAttribute->itemAttributeTermValue->id ?? ''}}]" value="{{$term->catalogueItemAttribute->itemAttributeTermValue->item_attribute_term_value ?? ''}}" placeholder="{{$term->item_attribute_term}}">
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                        @endif
                                    </div>
                                </div>


                            {{-- 12 Variation Image --}}
                            <div class="card mt-3">
                                <div class="card-header font-18"><input type="checkbox" name="image_update_check" id="image_update_check" value="1"> Do you want to update your image ?</div>
                                    <div class="card-body">
                                        <div class="form-group row mt-4">
                                            <div class="col-md-2 d-flex">
                                                <div>
                                                    <label for="image_flag" class="col-form-label">Select image<span id="default_counter"></span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="d-flex mb-1">
                                                    <div id="counter"></div>
                                                </div>
                                                <div class="row pl-2">
                                                    <div class="col-md-6 main-lf-image-content">
                                                        <div class="main_image_show">
                                                            <span class="prev hide">Prev</span>
                                                            <div class="md-trigger hide" data-modal="modal-12">Click to enlarge</div>
                                                            <div class="showimagediv"></div>
                                                            <span class="next hide">Next</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 master-pro-img" style="padding:0;" >
                                                        <ul class="d-flex flex-wrap funcs sortable ebay-image-wrap" id="sortableImageDiv">
                                                        @isset($product_draft->images)
                                                            @php
                                                                $counter = 0;
                                                            @endphp
                                                            @foreach($product_draft->images as $images)
                                                            <li class="drag-drop-image active">
                                                                <a class="cross-icon bg-white border-0 btn-outline-light" id="{{$images->image_url ?? ''}}" onclick="removeLi(this)">&#10060;</a>
                                                                <input type="hidden" name="newUploadImage[{{$images->image_url}}]" value="{{(filter_var($images->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$images->image_url : $images->image_url}}">
                                                                <span class="main_photo"></span>
                                                                <img class="drag_drop_image" id="{{$images->image_url ?? ''}}" src="{{(filter_var($images->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$images->image_url : $images->image_url}}">
                                                                <p class="drag_and_drop hide"></p>
                                                            </li>
                                                            @php
                                                                $counter++;
                                                            @endphp
                                                            @endforeach
                                                            @for($i=0; $i< 12-$counter; $i++)
                                                            <div class="drag-drop-image add-photos-content no-img-content">
                                                                <p class="inner-add-sign">+</p>
                                                                <input type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control ebay-image-upload" accept="/image" onchange="preview_image();" multiple="" disabled>
                                                                <p class="inner-add-photo">Add Photos</p>
                                                            </div>
                                                            @endfor
                                                        @endisset
                                                        </ul>
                                                        <input type="hidden" name="sortable_image" id="sortable_image" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <!-- Master product image preview fullscreen modal-->
                                <div class="md-modal md-effect-12">
                                    <div class="md-modal-content">
                                        <div id="modal_counter" class="ml-2 mb-2 font-18 text-white"></div>
                                        <span class="previous before">Prev</span>
                                            <div class="md-content">
                                                <div>
                                                    <span class="md-close float-right text-danger"></span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">

                                                        <div class="showimagediv"></div>

                                                    </div>
                                                </div>
                                            </div>
                                        <span class="then after">Next</span>
                                    </div>
                                </div>
                                <div class="md-overlay"></div>
                                <!--End master product image preview fullscreen -->


                                <!-- @if($product_draft->type == 'variable')
                                    <div class="card mt-3">
                                        <div class="card-header font-18"><input type="checkbox" name="upload_variation_image" id="upload_variation_image" value="1">Upload Variation Image</div>
                                        <div class="card-body col-md-8">
                                            <select class="form-control variation-select-height" name="attribute" id="attribute_image">
                                                @if($product_draft->attribute != '')
                                                    <option hidden>Select Attribute</option>
                                                    @foreach(\Opis\Closure\unserialize($product_draft->attribute) as $attribute_key => $attribute_value)
                                                        @foreach($attribute_value as $key => $value)
                                                            <option value="{{$product_draft->id ?? ''}}/{{$attribute_key ?? ''}}">{{$key ?? ''}}</option>
                                                        @endforeach
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="card append-attribute-image p-10" style="padding: 10px !important; display:none">

                                            </div>
                                        </div>

                                    </div>
                                @endif -->



                                <div class="row my-3">
                                    <div class="col-md-4 d-flex" id="updateOnlyWMSbtn">
                                        <button type="submit" id="submit" name="button" class="btn btn-primary update-wms-btn waves-effect waves-light draftEdit font-16" onclick="return imageDraggable();" value="wms">
                                            <b> Update Only WMS </b>
                                        </button>
                                    </div>
                                    <div class="col-md-8" id="channelSectionBtn">
                                        <div class="channel-section-border">
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                @if(isset($channels))
                                                    @foreach ($channels as $channel)
                                                        @if($channel->is_active == 1)
                                                            @php
                                                                $chanelLogo = '';
                                                                $isListed = false;
                                                                if($channel->channel_term_slug == 'ebay'){
                                                                    $chanelLogo = 'fab fa-ebay';
                                                                    $request_name = "ebay_update";
                                                                    if(count($product_draft->ebayCatalogueInfo) > 0 && count($active_status) > 0){
                                                                        $isListed = true;
                                                                    }
                                                                }
                                                                if($channel->channel_term_slug == 'woocommerce'){
                                                                    $chanelLogo = 'fab fa-wordpress';
                                                                    $request_name = "website_update";
                                                                    if($product_draft->woocommerce_catalogue_info){
                                                                        $isListed = true;
                                                                    }
                                                                }
                                                                if($channel->channel_term_slug == 'onbuy'){
                                                                    $chanelLogo = 'fa fa-shopping-cart';
                                                                    $request_name = "onbuy_update";
                                                                    if($product_draft->onbuy_product_info){
                                                                        $isListed = true;
                                                                    }
                                                                }
                                                                if($channel->channel_term_slug == 'shopify'){
                                                                    $chanelLogo = 'fab fa-shopify';
                                                                    $request_name = "shopify_update";
                                                                    if(count($product_draft->shopifyCatalogueInfo) > 0){
                                                                        $isListed = true;
                                                                    }
                                                                }
                                                                if($channel->channel_term_slug == 'amazon'){
                                                                    $chanelLogo = 'fab fa-amazon';
                                                                    $request_name = "amazon_update";
                                                                    if(count($product_draft->amazonCatalogueInfo) > 0){
                                                                        $isListed = true;
                                                                    }
                                                                }
                                                            @endphp
                                                            @if ($isListed)
                                                                <div class="mr-2">
                                                                    <div class="updateChannelIconButton cursor-pointer" id="updateChannelIconButton" title="Click to deselect ({{$channel->channel ?? ''}})" onclick="channelCheckUncheck(this)">
                                                                        <i class="{{$chanelLogo ?? ''}} custom-font channel-icon-font"></i>
                                                                        <i class="fa fa-check channel-show-check-{{$channel->channel_term_slug ?? ''}} channel-show-check"></i>
                                                                    </div>
                                                                    <input type="checkbox" id="{{$channel->channel_term_slug ?? ''}}" class="checkbox-inline" name="{{$request_name ?? ''}}" value="1" style="display: none" checked>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                            <button type="submit" id="submit" name="button" class="btn btn-primary catalog-update-btn waves-effect waves-light draftEdit font-16 mt-2" onclick="return imageDraggable();" value="update">
                                                <b> Update In Selected Channels</b>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="card mt-3">
                                    <div class="card-header">Channel</div>
                                    <div class="card-body">
                                        <div>
                                            @if (Session::get('ebay') == 1)
                                             @if($account['ebay_status'] != '' && $account['ebay_status']->status == 1)
                                                <input type="checkbox" class="checkbox-inline" name="ebay_update" value="1" checked> Ebay
                                             @endif
                                            @endif
                                            @if (Session::get('woocommerce') == 1)
                                             @if($account['woocommerce_status'] != '' && $account['woocommerce_status']->status == 1)
                                                <input type="checkbox" class="checkbox-inline" name="website_update" value="1" checked> Website &nbsp;
                                             @endif
                                            @endif
                                            @if (Session::get('onbuy') == 1)
                                             @if($account['onbuy_status'] != '' && $account['onbuy_status']->status == 1)
                                                <input type="checkbox" class="checkbox-inline" name="onbuy_update" value="1" checked> OnBuy &nbsp; (Check the field which channel you want to update along with master catalogue)
                                             @endif
                                            @endif
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="form-group row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" id="submit" name="button" class="btn btn-primary draft-add-btn waves-effect waves-light draftEdit mr-2" onclick="return imageDraggable();" value="wms">
                                            <b> Update Wms </b>
                                        </button><button type="submit" id="submit" name="button" class="btn btn-primary draft-add-btn waves-effect waves-light draftEdit" onclick="return imageDraggable();" value="update">
                                            <b> Update </b>
                                        </button>
                                    </div>
                                </div> --}}



                            </form>
                        </div>
                    </div>  <!-- card-box -->
                </div> <!-- end col -->
        </div> <!-- container -->
    </div> <!-- content -->
    </div>  <!-- content page -->

    <script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>

    <script>

        //Select Option
        $('.select2').select2();

    // placeholder label animation

       function inputLabelShow(e){
           $(e).prev('div').show()
           $(e).addClass('tabInputClick')
           $(e).attr('placeholder', '')
       }

       function inputLabelHide(e){
           var labelName = $(e).prev('div').text()
           if(!e.value) {
               $(e).prev('div').hide()
               $(e).removeClass('tabInputClick')
               $(e).attr('placeholder', labelName);
           }
       }

       $(function(){
           $(".tab-input-div input").bind("checkval",function(){
               if(this.value !== ""){
                   $(this).prev('div').show()
                   $(this).addClass('tabInputClick')
               } else {
                   $(this).prev('div').hide()
                   $(this).removeClass('tabInputClick')
               }
           }).trigger("checkval");
       });

        // $('input').on('focusin', function() {
        //     $(this).parent().find('label').addClass('draft-active');
        // });
        // $('input').on('focusout', function() {
        //     if (!this.value) {
        //         $(this).parent().find('label').removeClass('draft-active');
        //     }
        // });
        // $(function(){
        //     var showClass = "draft-active";
        //     $("input").bind("checkval",function(){
        //         var label = $(this).prev("label");
        //         if(this.value !== ""){
        //             label.addClass(showClass);
        //         } else {
        //             label.removeClass(showClass);
        //         }
        //     }).trigger("checkval");
        // });
        // placeholder label animation

        // $(function() {
        //     $( "#image_preview" ).sortable({
        //         // connectWith: $('#image_preview'),
        //         // items: '> li ',
        //         revert: true
        //     });
        //     $('button#sortimage').click(function () {
        //         // $("#image_preview").sortable('destroy');
        //     });
        //     $('input#image_update_check').click(function () {
        //         var h = [];
        //         $("#image_preview .pip").each(function() {  h.push($(this).find('img').attr('id'));  });
        //         $('#sortable_image').val(h);
        //     });
        //     $('#image_preview .pip').click(function () {
        //         $('input#image_update_check').prop('checked', true);
        //     })
        // });

        $(function() {
            $( ".ebay-image-wrap" ).sortable({
                revert: true
            });
            $('input#image_update_check').click(function () {
                var h = [];
                $(".ebay-image-wrap li").each(function() {  h.push($(this).find('img').attr('id'));  });
                $('#sortable_image').val(h);
            });
            $('.ebay-image-wrap li').click(function () {
                $('input#image_update_check').prop('checked', true);
            })
        });

        // function imageDraggable() {
        //     // $('input#image_update_check').prop('checked',true);
        //     var h = [];
        //     $("#image_preview .pip").each(function() {  h.push($(this).find('img').attr('id'));  });
        //     $('#sortable_image').val(h);
        //     var check = confirm('Are you sure to update ?');
        //     if(check){
        //         return true;
        //     }else{
        //         return false;
        //     }
        // }

        // function imageDraggable() {
        //     // $('input#image_update_check').prop('checked',true);
        //     // alert('ok');
        //     var h = [];
        //     $(".ebay-image-wrap li").each(function() {  h.push($(this).find('img').attr('id'));  });
        //     $('#sortable_image').val(h);
        //     var check = confirm('Are you sure to update ?');
        //     if(check){
        //         return true;
        //     }else{
        //         return false;
        //     }
        // }


        function submitData() {
            var name = $('input[name=name]').val();
            var category_id = $('#category_id').val();
            var brand_id = $('#brand_id').val();
            var gender_id = $('#gender_id').val();
            var description = CKEDITOR.instances['messageArea'].getData();
            var short_description = $('textarea[name=short_description]').val();
            var regular_price = $('input[name=regular_price]').val();
            var sale_price = $('input[name=sale_price]').val();
            var cost_price = $('input[name=cost_price]').val();
            var product_code = $('input[name=product_code]').val();
            var color_code = $('input[name=color_code]').val();
            var low_quantity = $('input[name=low_quantity]').val();
            var update_img_check = 0;
            if ($('input#image_update_check').is(':checked')) {
                var update_img_check = $('input[name=image_update_check]').val();
            }
            sortArray = Zepto('.funcs').dragswap('toArray');
            $.ajax({
                type: 'POST',
                url: '{{route('product-draft.update',$product_draft->id).'?_token='.csrf_token()}}',
                data: {
                    '_method' : 'PUT',
                    'name' : name,
                    'category_id' : category_id,
                    'brand_id' : brand_id,
                    'gender_id' : gender_id,
                    'description' : description,
                    'short_description' : short_description,
                    'regular_price' : regular_price,
                    'sale_price' : sale_price,
                    'cost_price' : cost_price,
                    'product_code' : product_code,
                    'color_code' : color_code,
                    'low_quantity' : low_quantity,
                    'update_img_check' : update_img_check,
                    'sortArray': sortArray
                },
                beforeSend: function(){
                    $('button i').addClass('fa fa-spinner fa-spin');
                },
                success: function (data) {
                    if(data == 1) {
                        //window.location.href = "product-draft";
                        $('button i').removeClass('fa fa-spinner fa-spin');
                        alert('Product updated successfully');
                    }else{
                        alert('Something went wrong. Please try again.');
                    }
                },
                error: function (jqXHR, exception) {

                }
            });
        }
        const toBase64 = files => new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(files);
            reader.onload = () => resolve(reader.result);
            reader.onerror = error => reject(error);
        });


        // function preview_image()
        // {
        //     var total_file=document.getElementById("images").files.length;
        //     var file_name = document.getElementById("images").files;
        //     $('input#image_update_check').prop('checked', true);
        //     var temp = '';
        //     for(var i=0;i<total_file;i++)
        //     {
        //         var reader = new FileReader();
        //         var file = file_name[i];
        //         (function(file){
        //             reader.onload = function(event) {
        //             $('#image_preview').append("<span class='pip'><span class='remove drag_drop_remove_btn' onclick=removeImage(this)>&#10060;</span><li><img src='"+event.target.result+"' class='drag_drop_image' id='"+file.name+"'></li><input type='hidden' name='newUploadImage["+file.name+"]' value='"+event.target.result+"'></span>");
        //         }

        //         reader.readAsDataURL(file);
        //         })(file);
        //     }
        // }
        // var items=[];
        // var rmvExistingImage=[];
        // function removeImage(e) {
        //     items.push(e.id);
        //     $('#removeImageArray').val(items) ;
        //     $(e).parent('.pip').remove();
        //     sortArray = Zepto('.funcs').dragswap('toArray');
        // }

        // function removeExistingImage(e) {
        //     rmvExistingImage.push(e.id);
        //     $('input#image_update_check').prop('checked', true);
        //     $('#rmvExistingImage').val(rmvExistingImage) ;
        //     $(e).parent('.pip').remove();
        //     sortArray = Zepto('.funcs').dragswap('toArray');
        // }


        //12 variation Drag drop image
       //Click to enlarge image modal preview
       $(function () {
            $('.md-trigger').on('click', function() {
                $('.md-modal').addClass('md-show');
            });
            $('.md-close').on('click', function() {
                $('.md-modal').removeClass('md-show');
            });
        });

        $('div.drag-drop-image:first').on('click', function(){
            if($(this).is(':first-child')) {
                // $('.addPhotoBtnDiv input').remove();
                $('.addPhotoBtnDiv input').removeAttr('id');
            }
        })

        $('div.addPhotoBtnDiv').on('click', function(){
            $('.addPhotoBtnDiv input').attr('id', 'uploadImage');
        })

        var notexistfirstDefaultImage = $('<div class="img-upload-main-content">'+
                '<div class="img-content-wrap">'+
                    '<div class="addPhotoBtnDiv">'+
                        '<p class="btn-text">Add photos</p>'+
                        '<input type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control" accept="/image" onchange="preview_image();" multiple>'+
                    '</div>'+
                    '<p class="photo-req-txt">Add up to 12 photos. We do not allow photos with extra borders, text or artwork.</p>'+
                '</div>'+
            '</div>');

        var imageList = $('ul.ebay-image-wrap li.drag-drop-image').length;
        if(imageList == 0){
            $('#counter').text('We recommend adding 3 more photos');
            $('.showimagediv').html(notexistfirstDefaultImage).show();
            $('.md-trigger, .prev, .next').hide();
            $('.main_image_show').hover(function(){
                $('.md-trigger, .prev, .next').hide();
            });
        }else{
            var firstDefaultImageSrc = $('li .drag_drop_image:first').attr('src');
            var firstDefaultImage = $('<img />', {src : firstDefaultImageSrc,'class': 'fullImage'});
            $('.showimagediv').html(firstDefaultImage).show();
        }

        if(imageList == 1){
            $('#counter').text('We recommend adding 2 more photos');
        }else if(imageList == 2){
            $('#counter').text('We recommend adding 1 more photo');
        }else if(imageList == 3){
            $('#counter').text('Add up to 9 more photos');
        }else if(imageList == 4){
            $('#counter').text('Add up to 8 more photos');
        }else if(imageList == 5){
            $('#counter').text('Add up to 7 more photos');
        }else if(imageList == 6){
            $('#counter').text('Add up to 6 more photos');
        }else if(imageList == 7){
            $('#counter').text('Add up to 5 more photos');
        }else if(imageList == 8){
            $('#counter').text('Add up to 4 more photos');
        }else if(imageList == 9){
            $('#counter').text('Add up to 3 more photos');
        }else if(imageList == 10){
            $('#counter').text('Add up to 2 more photos');
        }else if(imageList == 11){
            $('#counter').text('Add up to 1 more photo');
        }else if(imageList == 12){
            $('#counter').text('Photo limit reached');
        }
        $('#default_counter').text(' (' + imageList + ')');
        $('#modal_counter').text(imageList + (imageList === 1 ? ' image':' images'));// Modal inside image counter
        // Set starting index.
        // var index = imageList.index($('.active'));
        // $('#counter').text((index + 1) + ' of ' + imageList.length);
        // console.log($('#counter').text((index + 1) + ' of ' + imageList.length));
        // $('.after').on('click', function () {
        //     var currentImg = $('.active');
        //     var nextImg = currentImg.next();
        //     if (nextImg.length) {
        //         currentImg.removeClass('active').css('z-index', -10);
        //         nextImg.addClass('active').css('z-index', 10);
        //         // Find the index of the image.
        //         var index = imageList.index(nextImg);
        //         $('#counter').text((index + 1) + ' of ' + imageList.length);
        //         console.log($('#counter').text((index + 1) + ' of ' + imageList.length));
        //     }
        // });

        // $('.before').on('click', function () {
        //     var currentImg = $('.active');
        //     var prevImg = currentImg.prev();
        //     if (prevImg.length) {
        //         currentImg.removeClass('active').css('z-index', -10);
        //         prevImg.addClass('active').css('z-index', 10);
        //         // Find the index of the image.
        //         var index = imageList.index(prevImg);
        //         $('#counter').text((index + 1) + ' of ' + imageList.length);
        //     }
        // });

        //Small image on text show
        $(".drag_drop_image").hover(function () {
            $(this).next().removeClass('hide');
        }, function () {
            $(this).next().addClass('hide');
        });

        //Next and Prev button show on Big image
        $('.main_image_show').hover(function(){
            $('.prev, .next, .md-trigger').removeClass('hide');
        },  function () {
            $('.prev, .next, .md-trigger').addClass('hide');
        });

        //If keep cursor on next and previous button then click to enlarge button will disappear
        $('.prev, .next').hover(function(){
            $('.md-trigger').addClass('hide');
        }, function(){
            $('.md-trigger').removeClass('hide');
        });


        // By default first image show left side image content
        // var firstDefaultImageSrc = $('li .drag_drop_image:first').attr('src');
        // var firstDefaultImage = $('<img />', {src : firstDefaultImageSrc,'class': 'fullImage'});
        // $('.showimagediv').html(firstDefaultImage).show();

        $('.drag_drop_image').click(function(){
            $('.drag_drop_image').removeClass('clicked');
            $(this).addClass('clicked');
            var img = $('<img />', {src : this.src,'class': 'fullImage'});
            $('.showimagediv').html(img).show();
        });

        $('.next,.then').click(function(){
            if(!$(".clicked").is(".drag_drop_image:last")){
                var $first = $('li.drag-drop-image:first', 'ul.ebay-image-wrap'),
                $last = $('li.drag-drop-image:last', 'ul.ebay-image-wrap');
                var $next, $selected = $(".clicked");
                $next = $selected.next('li.drag-drop-image').length ? $selected.next('li.drag-drop-image') : $first;

                $selected.removeClass("clicked");
                $next.addClass('clicked');

                var imgSrc = $next.find('img').attr('src');
                var img = $next.find('img');
                var img = $('<img />', {src : imgSrc,'class': 'fullImage'});
                console.log($next.find('img').attr('src'));
                $('.showimagediv').html(img).show();
            }
        });
        $('.prev,.previous').click(function(){
            if(!$(".clicked").is(".drag_drop_image:first")){
                var $first = $('li.drag-drop-image:first', 'ul.ebay-image-wrap'),
                $last = $('li.drag-drop-image:last', 'ul.ebay-image-wrap');
                var $prev, $selected = $(".clicked");

                $prev = $selected.prev('li.drag-drop-image').length ? $selected.prev('li.drag-drop-image') : $last;
                $selected.removeClass("clicked");
                $prev.addClass('clicked');

                var imgSrc = $prev.find('img').attr('src');
                var img = $prev.find('img');
                var img = $('<img />', {src : imgSrc,'class': 'fullImage'});
                console.log($prev.find('img').attr('src'));
                $('.showimagediv').html(img).show();
            }
        });


        $('.ebay-image-upload:first').closest('div').removeClass('no-img-content');
        $('li.drag-drop-image img:first').addClass('clicked');
        $('li.drag-drop-image p').text('Drag to rearrange');
        // $('li.drag-drop-image span.main_photo:first').text('Main Photo');
        //$('li.drag-drop-image span.main_photo:gt(0)').hide();
        var imgList = $('li.drag-drop-image').length;
        console.log(imgList + ' Image list');
        //By default remove attribute disabled
        var firstRemoveAttribute = $('.add-photos-content input:first').attr('disabled');
        $('.add-photos-content input:first').removeAttr(firstRemoveAttribute);
        $('.add-photos-content .inner-add-sign:first,input:first,.inner-add-photo:first').css('opacity', '100');


        // Remove image list
        function removeLi(elem){
            $(elem).parent('li').remove();
            console.log($(elem).parent('li').remove());
            $('input#image_update_check').prop('checked', true);
            $("ul.ebay-image-wrap:last").append('<div class="drag-drop-image add-photos-content no-img-content">'+
                '<p class="inner-add-sign">&#43;</p>'+
                '<input type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control ebay-image-upload" accept="/image" onchange="preview_image();" multiple disabled>'+
                '<p class="inner-add-photo">Add Photos</p>'+
            '</div>');
            $('.add-photos-content input:first').removeAttr('disabled');
            $('p.inner-add-sign:first').css('opacity', '100');
            $('p.inner-add-photo:first').css('opacity', '100');

            $('li.drag-drop-image img:first').addClass('clicked');
            $('li.drag-drop-image p').text('Drag to rearrange');
            // $('li.drag-drop-image span.main_photo:first').text('Main Photo');
            //$('li.drag-drop-image span.main_photo:gt(0)').hide();

            var firstDefaultImageSrc = $('li .drag_drop_image:first').attr('src');
            var firstDefaultImage = $('<img />', {src : firstDefaultImageSrc,'class': 'fullImage'});
            var notexistfirstDefaultImage = $('<div class="img-upload-main-content">'+
                    '<div class="img-content-wrap">'+
                        '<div class="addPhotoBtnDiv">'+
                            '<p class="btn-text">Add photos</p>'+
                            '<input type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control" accept="/image" onchange="preview_image();" multiple>'+
                        '</div>'+
                        '<p class="photo-req-txt">Add up to 12 photos. We do not allow photos with extra borders, text or artwork.</p>'+
                    '</div>'+
                '</div>');
            $('.showimagediv').html(firstDefaultImage).show();

            if(firstDefaultImageSrc == null){
                $('.showimagediv').html(notexistfirstDefaultImage).show();
                $('.md-trigger, .prev, .next').hide();
                $('.main_image_show').hover(function(){
                    $('.md-trigger, .prev, .next').hide();
                });
            }else{
                $('.showimagediv').html(firstDefaultImage).show();
            }

            $('div.drag-drop-image:first').on('click', function(){
                if($(this).is(':first-child')) {
                    // $('.addPhotoBtnDiv input').remove();
                    $('.addPhotoBtnDiv input').removeAttr('id');
                }
            })

            $('div.addPhotoBtnDiv').on('click', function(){
                $('.addPhotoBtnDiv input').attr('id', 'uploadImage');
            })

            $('.ebay-image-upload:first').closest('div').removeClass('no-img-content');

            // $(function(){
            //     $('div.drag-drop-image:first').on("click", function () {
            //         $('.addPhotoBtnDiv input').addClass('hide');
            //         setTimeout(RemoveClass, 25000);
            //     });
            //     function RemoveClass() {
            //         $('.addPhotoBtnDiv input').RemoveClass('hide');
            //     }
            // });

            var imageList = $('ul.ebay-image-wrap li.drag-drop-image').length;
            if(imageList == 0){
            $('#counter').text('We recommend adding 3 more photos');
            }else if(imageList == 1){
                $('#counter').text('We recommend adding 2 more photos');
            }else if(imageList == 2){
                $('#counter').text('We recommend adding 1 more photo');
            }else if(imageList == 3){
                $('#counter').text('Add up to 9 more photos');
            }else if(imageList == 4){
                $('#counter').text('Add up to 8 more photos');
            }else if(imageList == 5){
                $('#counter').text('Add up to 7 more photos');
            }else if(imageList == 6){
                $('#counter').text('Add up to 6 more photos');
            }else if(imageList == 7){
                $('#counter').text('Add up to 5 more photos');
            }else if(imageList == 8){
                $('#counter').text('Add up to 4 more photos');
            }else if(imageList == 9){
                $('#counter').text('Add up to 3 more photos');
            }else if(imageList == 10){
                $('#counter').text('Add up to 2 more photos');
            }else if(imageList == 11){
                $('#counter').text('Add up to 1 more photo');
            }else if(imageList == 12){
                $('#counter').text('Photo limit reached');
            }
            $('#default_counter').text(' (' + imageList + ')');
            $('#modal_counter').text(imageList + (imageList === 1 ? ' image':' images'));

            if(imageList == 1){
                $('.prev, .next, .previous, .then').hide();
            }

            var errorIcon = $('a.image_dimension').length;
            if(errorIcon == 0){
                $('button.draftEdit').attr('disabled', false);
            }

        }


        function preview_image(profileId){
            var total_file=document.getElementById("uploadImage").files.length;
            var file_name = document.getElementById("uploadImage").files;
            var fileUpload = document.getElementById("uploadImage");
            var imageList = $('ul.ebay-image-wrap li.drag-drop-image').length;
            $('input#image_update_check').prop('checked', true);
            if(total_file+imageList >= 13){
                Swal.fire('Oops.. Photo limit exceeded','You have exceeded the total amount of photos allowed. Only the first 12 photos have been uploaded','warning');
            }
            var temp = '';
            for(var i=0;i<total_file;i++){
                var reader = new FileReader();
                var file = file_name[i];
                (function(file){
                    console.log(file);
                    reader.onload = function(event) {
                    var image = new Image();
                    image.src = event.target.result;
                    image.onload = function (i) {
                        var height = this.height;
                        var width = this.width;
                        var t = file.type;
                        var n = file.name;
                        var s = ~~(file.size/1024) +'KB';
                        var errorIcon = '';
                        if(height < 500){
                            errorIcon += '<a class="image_dimension" title="error"></a>'+
                            '<div class="image_dimension_error_show hide">'+
                                '<span><b>Photo quality issues :</b></span><br>'+
                                '<span>"Upload high resolution photos that are at least 500 pixels on the longest side. If you are uploading a photo from your smartphone, select the medium or large photo size option."</span>'+
                            '</div>'
                            $('button.draftEdit').click(function(){
                                var iconError = $('a.image_dimension').length;
                                if(iconError > 0){
                                    $(this).attr('disabled','disabled');
                                    Swal.fire('Oops.. Photo quality error issue!!','Upload high resolution photos that are at least 500 pixels on the longest side. If you are uploading a photo from your smartphone, select the medium or large photo size option. It looks like there is a problem with this listing.','warning');
                                }
                            });
                        } // if close height


                        $('<li class="drag-drop-image">'+ // After uploading image
                                '<a class="cross-icon bg-white border-0 btn-outline-light" id="'+file.name+'" onclick="removeLi(this)">&#10060;</a>'+
                                '<input type="hidden" id="image" name="image[]" value="'+file.name+'">'+
                                '<span class="main_photo"></span>'+
                                '<img class="drag_drop_image" src="'+event.target.result+'"  alt="">'+
                                '<p class="drag_and_drop hide"></p>'+
                                errorIcon+
                                '<input type="hidden" name="newUploadImage['+file.name+']" value="'+event.target.result+'">'+
                        '</li>').insertBefore('.add-photos-content:first');

                        $('a.image_dimension').hover(function(){ //each error button hover
                            $(this).next().removeClass('hide');
                        }, function(){
                            $(this).next().addClass('hide');
                        });

                        $('div.add-photos-content:last').remove(); // Removing last div

                        var imageList = $('ul.ebay-image-wrap li.drag-drop-image').length;
                        console.log('After uploading image = ' +imageList + ' images');
                        if(imageList == 0){
                            $('#counter').text('We recommend adding 3 more photos');
                        }else if(imageList == 1){
                            $('#counter').text('We recommend adding 2 more photos');
                        }else if(imageList == 2){
                            $('#counter').text('We recommend adding 1 more photo');
                        }else if(imageList == 3){
                            $('#counter').text('Add up to 9 more photos');
                        }else if(imageList == 4){
                            $('#counter').text('Add up to 8 more photos');
                        }else if(imageList == 5){
                            $('#counter').text('Add up to 7 more photos');
                        }else if(imageList == 6){
                            $('#counter').text('Add up to 6 more photos');
                        }else if(imageList == 7){
                            $('#counter').text('Add up to 5 more photos');
                        }else if(imageList == 8){
                            $('#counter').text('Add up to 4 more photos');
                        }else if(imageList == 9){
                            $('#counter').text('Add up to 3 more photos');
                        }else if(imageList == 10){
                            $('#counter').text('Add up to 2 more photos');
                        }else if(imageList == 11){
                            $('#counter').text('Add up to 1 more photo');
                        }else if(imageList == 12){
                            $('#counter').text('Photo limit reached');
                        }
                        $('#default_counter').text(' (' + imageList + ')');
                        $('#modal_counter').text(imageList + (imageList === 1 ? ' image':' images'));

                        // if(imageList >= 13){
                        //     Swal.fire('Oops.. Photo limit reached','You have uploaded 12 photos, now you are not allowed to upload more than 12 photos','warning');
                        // }

                        $('li.drag-drop-image p:last').text('Drag to rearrange');
                        // $('li.drag-drop-image span.main_photo:first').text('Main Photo');

                        // $('img.drag_drop_image:last').addClass('clicked'); //By default last image active show

                        var $afterUploadLastImgView = $('img.drag_drop_image:last').attr('src');
                        var $img = $('<img />', {src : $afterUploadLastImgView,'class': 'fullImage'});
                        $('.showimagediv').html($img).show();

                        $('.drag_drop_image').click(function(){
                            $('.drag_drop_image').removeClass('clicked');
                            $(this).addClass('clicked');
                            var img = $('<img />', {src : this.src,'class': 'fullImage'});
                            $('.showimagediv').html(img).show();
                        });

                        $(".drag_drop_image").hover(function () {
                            $(this).next().removeClass('hide');
                        }, function () {
                            $(this).next().addClass('hide');
                        });

                        $('.prev, .next').hover(function(){

                            $('.md-trigger').addClass('hide');
                        }, function(){
                            $('.md-trigger').removeClass('hide');
                        });

                        $('.main_image_show').hover(function(){
                            $('.prev,.next,.md-trigger,.before,.after,.then,.previous').removeAttr('style');
                        });

                    };



                } // function file close

                reader.readAsDataURL(file);
                })(file);

            } // for loop close

        } // preview_image close

        //End 12 variation Drag drop image



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
        function Count() {
            var i = document.getElementById("name").value.length;
            document.getElementById("display").innerHTML = 'Character Remain: '+ (80 - i);
        }

    </script>

    <script src="{{asset('assets/js/zepto.min.js')}}"></script>
    <script src="{{asset('assets/js/zepto.dragswap.js')}}"></script>

    <script>

        window.onload = function() {
            var sortArray = [];
            // dropComplete();
            sortArray = Zepto('.funcs').dragswap('toArray');
        };
        $(function() {
            Zepto('.sortable_exclude_dynamic').dragswap({
                element : 'li',
                dropAnimation: true,
                exclude : ['.correct', '.empty']
            });
            Zepto('.sortable').dragswap({
                element : 'li',
                dropAnimation: true
            });
            Zepto('.funcs').dragswap({
                dropAnimation: false,
                dropComplete: function() {
                    sortArray = Zepto('.funcs').dragswap('toArray');
                    $('#arrayResults').html('['+sortArray.join(',')+']');
                    var sortJSON = Zepto('.funcs').dragswap('toJSON');
                    $('#jsonResults').html(sortJSON);
                }
            });
        });


        function addLabel(e,name){
            // console.log("test");
            $("#label_name").text(name);
            $("#value").val('');
            $("#successMessage").text("")
            $('div.category-modal').show()
            if(name == 'Add Condition'){
                $('input#value').on('input', function(){
                    var inpVal = $(this).val()
                    $('select#selectCondition option').each(function(index, element){

                        if(inpVal != '' ){
                            if(inpVal.toLowerCase() == element.text.toLowerCase()){
                                var validation = element.text +' is already exist!'
                                $('.category-validate').show().text(validation)
                                $('button.category-subBtn').attr('disabled', 'disabled')
                                return false
                            }
                            else{
                                console.log('else')
                                $('.category-validate').hide()
                                $('button.category-subBtn').removeAttr('disabled', 'disabled')

                            }

                            $('ul#categorySelectOption').show()
                            const {value} = document.getElementById('value');
                            const resUl = document.querySelector('#categorySelectOption');
                            resUl.innerHTML = '';
                            Array.from(document.getElementById('selectCondition').children).filter(e => e.innerText.toLowerCase().startsWith(value.toLowerCase()))
                                .forEach(el =>
                                    resUl.appendChild(el.cloneNode(true))
                                );

                            var optionCount = $('ul#categorySelectOption option').length
                            if(optionCount > 5){
                                $('ul#categorySelectOption').css({
                                    'height' : '160px',
                                    'overflow-y' : 'scroll',
                                    'margin-bottom' : '15px'
                                })
                            }else{
                                $('ul#categorySelectOption').removeAttr('style')
                            }


                        }else{
                            $('ul#categorySelectOption').hide()
                            $('span.category-validate').hide()
                            $('button.category-subBtn').show()
                        }

                    })



                })
            }

            if(name == 'Add Brand'){
                $('input#value').on('input', function(){
                    var inpVal = $(this).val()
                    // console.log('up ' + inpVal )
                    $('select#selectBrand option').each(function(index, element){

                        if(inpVal != '' ){
                            if(inpVal.toLowerCase() == element.text.toLowerCase()){
                                var validation = element.text +' is already exist!'
                                $('.category-validate').show().text(validation)
                                $('button.category-subBtn').attr('disabled', 'disabled')
                                return false
                            }else{
                                $('.category-validate').hide()
                                $('button.category-subBtn').removeAttr('disabled', 'disabled')

                            }

                            $('ul#categorySelectOption').show()
                            const {value} = document.getElementById('value');
                            const resUl = document.querySelector('#categorySelectOption');
                            resUl.innerHTML = '';
                            Array.from(document.getElementById('selectBrand').children).filter(e => e.innerText.toLowerCase().startsWith(value.toLowerCase()))
                                .forEach(el =>
                                    resUl.appendChild(el.cloneNode(true))
                                );

                            var optionCount = $('ul#categorySelectOption option').length
                            if(optionCount > 5){
                                $('ul#categorySelectOption').css({
                                    'height' : '160px',
                                    'overflow-y' : 'scroll',
                                    'margin-bottom' : '15px'
                                })
                            }else{
                                $('ul#categorySelectOption').removeAttr('style')
                            }

                        }else{

                            $('ul#categorySelectOption').hide()
                            $('span.category-validate').hide()
                            $('button.category-subBtn').show()

                        }

                    })

                })
            }


            if(name == 'Add Department'){
                $('input#value').on('input', function(){
                    var inpVal = $(this).val()
                    // console.log('up ' + inpVal )
                    $('select#selectDepartment option').each(function(index, element){

                        if(inpVal != '' ){
                            if(inpVal.toLowerCase() == element.text.toLowerCase()){
                                var validation = element.text +' is already exist!'
                                $('.category-validate').show().text(validation)
                                $('button.category-subBtn').attr('disabled', 'disabled')
                                return false
                            }else{
                                $('.category-validate').hide()
                                $('button.category-subBtn').removeAttr('disabled', 'disabled')

                            }

                            $('ul#categorySelectOption').show()
                            const {value} = document.getElementById('value');
                            const resUl = document.querySelector('#categorySelectOption');
                            resUl.innerHTML = '';
                            Array.from(document.getElementById('selectDepartment').children).filter(e => e.innerText.toLowerCase().startsWith(value.toLowerCase()))
                                .forEach(el =>
                                    resUl.appendChild(el.cloneNode(true))
                                );

                            var optionCount = $('ul#categorySelectOption option').length
                            if(optionCount > 5){
                                $('ul#categorySelectOption').css({
                                    'height' : '160px',
                                    'overflow-y' : 'scroll',
                                    'margin-bottom' : '15px'
                                })
                            }else{
                                $('ul#categorySelectOption').removeAttr('style')
                            }

                        }else{
                            $('ul#categorySelectOption').hide()
                            $('span.category-validate').hide()
                            $('button.category-subBtn').show()
                        }

                    })

                })
            }


            if(name == 'Add Wms Category'){
                $('input#value').on('input', function(){
                    var inpVal = $(this).val()
                    // console.log('up ' + inpVal )

                    $('select#selectWMSCategory option').each(function(index, element){

                        if(inpVal != '' ){
                            if(inpVal.toLowerCase() == element.text.toLowerCase()){
                                var validation = element.text +' is already exist!'
                                $('.category-validate').show().text(validation)
                                $('button.category-subBtn').attr('disabled', 'disabled')
                                return false
                            }else{
                                $('.category-validate').hide()
                                $('button.category-subBtn').removeAttr('disabled', 'disabled')

                            }

                            $('ul#categorySelectOption').show()
                            const {value} = document.getElementById('value');
                            const resUl = document.querySelector('#categorySelectOption');
                            resUl.innerHTML = '';
                            Array.from(document.getElementById('selectWMSCategory').children).filter(e => e.innerText.toLowerCase().startsWith(value.toLowerCase()))
                                .forEach(el =>
                                    resUl.appendChild(el.cloneNode(true))
                                );

                            var optionCount = $('ul#categorySelectOption option').length
                            if(optionCount > 5){
                                $('ul#categorySelectOption').css({
                                    'height' : '160px',
                                    'overflow-y' : 'scroll',
                                    'margin-bottom' : '15px'
                                })
                            }else{
                                $('ul#categorySelectOption').removeAttr('style')
                            }

                        }else{
                            $('ul#categorySelectOption').hide()
                            $('span.category-validate').hide()
                            $('button.category-subBtn').show()
                        }

                    })

                })
            }

        }


        function optionClick(e){

            var optionText = $(e).text()

            $('select#selectCondition').find('option').removeAttr('selected')
            $('select#selectBrand').find('option').removeAttr('selected')
            $('select#selectDepartment').find('option').removeAttr('selected')
            $('select#selectWMSCategory').find('option').removeAttr('selected')

            $('select#selectCondition option').each(function(index, element){
                if(element.text == optionText){
                    // console.log(element.text)
                    // console.log(element)
                    element.setAttribute('selected', 'selected')
                    $('select#selectCondition').prepend(element)
                }
            })

            $('select#selectBrand option').each(function(index, element){
                if(element.text == optionText){
                    element.setAttribute('selected', 'selected')
                    $('select#selectBrand').prepend(element)
                }
            })

            $('select#selectDepartment option').each(function(index, element){
                if(element.text == optionText){
                    element.setAttribute('selected', 'selected')
                    $('select#selectDepartment').prepend(element)

                    // departmentChange()
                }
            })

            $('select#selectWMSCategory option').each(function(index, element){
                if(element.text == optionText){
                    element.setAttribute('selected', 'selected')
                    $('select#selectWMSCategory').prepend(element)
                }
            })

            $('div.category-modal').hide()

        }


        function addValue(e){
            var value = $("#value").val();
            var department = $("#selectDepartment").val();
            var label_name = $("#label_name").text();

            if(value == ''){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Add category input field is empty!',
                })
            }

            // console.log(value);
            // console.log(label_name)

            $.ajax({
                type:"POST",
                url:"{{url('add-product-draft-value')}} ",
                data:{
                    _token: "{{csrf_token()}}",
                    value : value,
                    name: label_name,
                    department: department
                },
                success : function (data){
                    console.log(data.result);
                    console.log('data id = ' + data.id)
                    var select = document.getElementById(data.id);
                    var option = document.createElement("option");
                    option.value = data.result.id;
                    if (data.id == "selectCondition"){
                        option.text = data.result.condition_name;
                        $('select#selectCondition').find('option').removeAttr('selected')
                        option.setAttribute('selected', 'selected')
                    }else if(data.id == "selectBrand" || data.id == "selectDepartment"){
                        option.text = data.result.name;
                        $('select#selectBrand').find('option').removeAttr('selected')
                        $('select#selectDepartment').find('option').removeAttr('selected')
                        option.setAttribute('selected', 'selected')
                    }else if(data.id == "selectWMSCategory"){
                        option.text = data.result.category_name;
                        $('select#selectWMSCategory').find('option').removeAttr('selected')
                        option.setAttribute('selected', 'selected')
                    }

                    // $('#selectCondition option:eq(1)').attr('selected', 'selected')

                    //$("#"+data.id).appendChild(option);

                    select.add(option, 1)
                    $("#successMessage").text("Added Successfully");
                    $('div.category-modal').hide()
                    $('.modal-backdrop').hide();
                    //select.appendChild(option);

                }


            });
        }


        function trashClick(e){
            $(e).closest('div.category-modal').hide()
            $('ul#categorySelectOption').hide()
            $('span.category-validate').hide()
        }


        $(document).ready(function () {
            $('.gender-choose').on('change',function () {
                var gender_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{url('gender-category')}}",
                    data: {
                        "_token" : "{{csrf_token()}}",
                        "gender_id" : gender_id
                    },
                    success: function (response) {
                        if(response.genders.length > 0){
                            var content = '<option value="">Select Category</option>';
                            response.genders.forEach(function(item){
                                content += '<option value="'+item.id+'">'+item.category_name+'</option>';
                            });
                            $('.category_select').html(content);
                        }else{
                            alert('No category found. Please assign category in a department');
                        }
                    }
                });
            })

            $('select#attribute_image').on('change',function () {
                var ids = $('select#attribute_image').val();
                console.log(ids)
                $.ajax({
                    type: "POST",
                    url: "{{url('get-terms-information')}}",
                    data: {
                        "_token" : "{{csrf_token()}}",
                        "ids" : ids
                    },
                    success: function (response) {

                        var single = 0;
                        var html = '<div class="row">\n' +
                            '                                                     <div class="col-md-6">\n' +
                            '                                                        <input type="checkbox" name="singleVariationImageCheckbox" id="singleVariationImage" value="1" onchange="valueChanged()"> Check the box if you want to upload single image for below attribute\n' +
                            '                                                         <span id="variationImageFile" style="display: none">\n' +
                            '                                                            <input type="file" class="form-control" name="singleImageFile" onchange="choose_image('+single+');" id="imgvar'+single+'"><hr>\n' +
                            '                                                         </span>\n' +
                            '                                                     </div>\n' +
                            '<div class="col-md-6 mt-xs-5" id="singleImageShow" style="display: none">\n' +
                            '    <img src="" id="var_image_0" style="width: 100px;height: 100px;border: 1px solid #ccc2c2;padding: 5px">\n' +
                            '</div>\n' +
                            '                                                 </div><div class="uploadable-variation-image-content m-b-10">';
                        var count = 1;
                        response.forEach(function (items) {
                            html += '<div class="row m-b-10">\n' +
                                        '<div class="col-md-6">\n' +
                                        '     <span>'+items.terms_name+'</span>' +
                                        '     <input type="hidden" name="var_id[]" value="'+items.var_id+'">\n' +
                                        '     <input type="hidden" name="attribute_name[]" value="'+items.attribute_name+'">\n' +
                                        '     <input type="hidden" name="attribute_terms[]" value="'+items.terms_name+'">\n' +
                                        '     <input type="hidden" name="variation_ids[]" value="['+items.variation_id+']">\n' +
                                        '     <input type="file" class="form-control imgInp" name="variation_image[]" onchange="choose_image('+count+');" id="imgvar'+count+'">\n' +
                                        '</div>\n' +
                                        '<div class="col-md-6 mt-xs-5">\n' +
                                        '    <img src="'+items.image+'" id="var_image_'+count+'" style="width: 100px;height: 100px;border: 1px solid #ccc2c2;padding: 5px">\n' +
                                        '</div>\n' +
                                    '</div>';
                            count++;
                        });
                        html += '</div>';
                        $('.card .append-attribute-image').show();
                        $('.card .append-attribute-image').html(html);
                    }
                });
            });
        })
        function valueChanged(){
            if($('#singleVariationImage').is(":checked")) {
                $("#variationImageFile").show();
                $('#singleImageShow').show();
                $('.uploadable-variation-image-content').hide();
            }
            else {
                $("#variationImageFile").hide();
                $('#singleImageShow').hide();
                $('.uploadable-variation-image-content').show();
            }
        }
        function choose_image(id) {
            var file_name = document.getElementById("imgvar"+id).files;
            var reader = new FileReader();
            var file = file_name[0];
            (function(file){
                reader.onload = function(event) {
                    $('#var_image_'+id).attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            })(file);
        }


        $(function(){
            var titleInfo = $("#name");
            var mainId = $("#main_id").val();
            titleInfo.blur(function() {
                if( titleInfo.val() == 0 ) {
                    // suchfeld.val("Suche...");
                }else{
                    $.ajax({
                        type: "post",
                        url: "{{asset(url('master-catalogue-exist-check'))}}",
                        data: {
                            "_token": "{{csrf_token()}}",
                            "title": titleInfo.val(),
                            "id": mainId
                        },
                        success: function(response){
                            console.log(response)
                            if(response.type == 1){
                                $('button.draft-add-btn').prop('disabled',true)
                                document.getElementById("exist-catalogue-message").innerHTML = '<p class="text-danger">Catalogue already exist</p>'
                            }else{
                                $('button.draft-add-btn').prop('disabled',false)
                                document.getElementById("exist-catalogue-message").innerHTML = ''
                            }
                        }
                    })
                }
            });
        })


        function channelCheckUncheck(e){
            var id = $(e).next('input').attr('id');
            if($('#'+id).is(':checked')){
                if(id == 'ebay'){
                    document.getElementById(id).checked = false;
                    $('.channel-show-check-'+id).removeClass('channel-show-check').hide()
                    $(e).attr('title', 'Click to select ('+id+')').css({
                        'border' : '1px solid var(--wms-primary-color)',
                        'background-color' : '#ffffff',
                        'color' : '#000'
                    })
                }
                if(id == 'woocommerce'){
                    document.getElementById(id).checked = false;
                    $('.channel-show-check-'+id).removeClass('channel-show-check').hide()
                    $(e).attr('title', 'Click to select ('+id+')').css({
                        'border' : '1px solid var(--wms-primary-color)',
                        'background-color' : '#ffffff',
                        'color' : '#000'
                    })
                }
                if(id == 'onbuy'){
                    document.getElementById(id).checked = false;
                    $('.channel-show-check-'+id).removeClass('channel-show-check').hide()
                    $(e).attr('title', 'Click to select ('+id+')').css({
                        'border' : '1px solid var(--wms-primary-color)',
                        'background-color' : '#ffffff',
                        'color' : '#000'
                    })
                }
                if(id == 'amazon'){
                    document.getElementById(id).checked = false;
                    $('.channel-show-check-'+id).removeClass('channel-show-check').hide()
                    $(e).attr('title', 'Click to select ('+id+')').css({
                        'border' : '1px solid var(--wms-primary-color)',
                        'background-color' : '#ffffff',
                        'color' : '#000'
                    })
                }
                if(id == 'shopify'){
                    document.getElementById(id).checked = false;
                    $('.channel-show-check-'+id).removeClass('channel-show-check').hide()
                    $(e).attr('title', 'Click to select ('+id+')').css({
                        'border' : '1px solid var(--wms-primary-color)',
                        'background-color' : '#ffffff',
                        'color' : '#000'
                    })
                }
            }else{
                if(id == 'ebay'){
                    document.getElementById(id).checked = true;
                    $('.channel-show-check-'+id).addClass('channel-show-check').show()
                    $(e).attr('title', 'Click to deselect ('+id+')').css({
                        'border' : '2px solid var(--wms-primary-color)',
                        'background' : '#5D9CEC',
                        'color' : '#ffffff'
                    })
                }
                if(id == 'woocommerce'){
                    document.getElementById(id).checked = true;
                    $('.channel-show-check-'+id).addClass('channel-show-check').show()
                    $(e).attr('title', 'Click to deselect ('+id+')').css({
                        'border' : '2px solid var(--wms-primary-color)',
                        'background' : '#5D9CEC',
                        'color' : '#ffffff'
                    })
                }
                if(id == 'onbuy'){
                    document.getElementById(id).checked = true;
                    $('.channel-show-check-'+id).addClass('channel-show-check').show()
                    $(e).attr('title', 'Click to deselect ('+id+')').css({
                        'border' : '2px solid var(--wms-primary-color)',
                        'background' : '#5D9CEC',
                        'color' : '#ffffff'
                    })
                }
                 if(id == 'amazon'){
                    document.getElementById(id).checked = true;
                    $('.channel-show-check-'+id).addClass('channel-show-check').show()
                    $(e).attr('title', 'Click to deselect ('+id+')').css({
                        'border' : '2px solid var(--wms-primary-color)',
                        'background' : '#5D9CEC',
                        'color' : '#ffffff'
                    })
                }
                if(id == 'shopify'){
                    document.getElementById(id).checked = true;
                    $('.channel-show-check-'+id).addClass('channel-show-check').show()
                    $(e).attr('title', 'Click to deselect ('+id+')').css({
                        'border' : '2px solid var(--wms-primary-color)',
                        'background' : '#5D9CEC',
                        'color' : '#ffffff'
                    })
                }
            }
        }


        $(document).ready(function(){
            var channelCount = $('div.updateChannelIconButton').length
            if(channelCount == 0){
                $('#channelSectionBtn').hide()
                $('#updateOnlyWMSbtn').addClass('offset-md-4')
            }
        })

    </script>
@endsection
