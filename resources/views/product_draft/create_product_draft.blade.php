@extends('master')
@section('title')
    Catalogue | Add Draft Catalogue | WMS360
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

        .swal2-styled.swal2-confirm{
            width: 100px;
        }
        .swal2-styled.swal2-cancel{
            width: 100px;
        }

         /* width */
        .variation-attributes-height-controll::-webkit-scrollbar {
            width: 10px;
        }
        /* Track */
        /* ::-webkit-scrollbar-track {
            background: #f1f1f1;
        } */
        /* Handle */
        .variation-attributes-height-controll::-webkit-scrollbar-thumb {
            background: #888;
        }
        /* Handle on hover */
        .variation-attributes-height-controll::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

    </style>

    <script>
        $( function() {
            $( ".sortable" ).sortable({
                cursor: 'move'
            });
            $( ".sortable" ).disableSelection();
        } );

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
                <div class="d-flex justify-content-start align-items-center">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Catalogue</li>
                            <li class="breadcrumb-item active" aria-current="page">Add Draft Catalogue</li>
                        </ol>
                    </div>
                </div>

                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box shadow add-draft">
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

                            <form role="form" class="mobile-responsive mt-3" action= "{{URL::to('product-draft')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label required">Title</label>
                                    <div class="col-md-10">
                                        <input id="name" type="text" class="form-control" name="name" maxlength="80" onkeyup="Count();" required autocomplete="name" autofocus>
                                        <span id="display" class="float-right"></span>
                                        <span id="exist-catalogue-message" class="float-left"></span>
                                    </div>
                                </div>

                                <div class="row mt-4 mb-3 category-div">

                                    <div class="col-md-3 col-sm-6 form-group">
                                        <div class="btn-group" style="width:100%;">
                                            <button type="button" class="btn btn-primary dropdown-toggle form-control text-left category-child-btn" data-toggle="dropdown">  <span class="caret">Product Condition</span></button>
                                            <button type="button" onclick="addLabel(this,'Add Condition')" class="btn btn-outline-primary form-control add-categorization float-right"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        </div>
                                        <select id="selectCondition" class="form-control select2" name="condition" required>
                                            <option selected="true" disabled="disabled">Select Condition</option>
                                            @isset($conditions)
                                                @foreach($conditions as $condition)
                                                    <option onclick="optionClick(this)" value="{{$condition->id ?? ''}}" {{$condition->default_select == 1 ? 'selected' : ''}}>{{$condition->condition_name ?? ''}}</option>
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
                                                    {{-- <i class="fa fa-close" aria-hidden="true"></i> --}}
                                                    Cancel
                                                </div>

                                                <div class="cat-add">
                                                    <button type="button" onclick="addValue(this)" class="btn btn-default category-subBtn mb-3"> Add </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <!-- Modal -->
                                    {{-- <div class="modal  fade position-absolute" id="myModal" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 id="successMessage" class="alert-success"></h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body category-input">
                                                    <label id="label_name"></label>
                                                    <input id="value" class="p-1 category-focus" type="text" name="value">
                                                    <button type="button" onclick="addValue(this)" class="btn btn-default"> Submit</button>
                                                </div>
{{--                                                <div class="modal-footer">--}}
{{--                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
{{--                                                </div>--}}
                                            {{-- </div>

                                        </div>
                                    </div>  --}}


                                    <!-- Attribute Modal -->
                                    <div class="modal fade position-absolute" id="addAttModal" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 id="successMessage" class="alert-success"></h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <label id="label_name">Add New Variation</label>
                                                   <input id="value" type="text" name="value">
                                                    <button type="button" onclick="addValue(this)" class="btn btn-default"> Submit</button>
                                                </div>
{{--                                                <div class="modal-footer">--}}
{{--                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
{{--                                                </div>--}}
                                            </div>

                                        </div>
                                    </div>

                                    <!-- terms Modal -->
                                    <div class="modal fade position-absolute" id="addTermModal" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 id="successMessage" class="alert-success"></h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <label id="label_name">Add New Terms</label>
                                                   <input id="value" type="text" name="value">
                                                    <button type="button" onclick="addValue(this)" class="btn btn-default"> Submit</button>
                                                </div>
{{--                                                <div class="modal-footer">--}}
{{--                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
{{--                                                </div>--}}
                                            </div>

                                        </div>
                                    </div>


                                    <div class="col-md-3 6col-sm-6 form-group">
                                        <div class="btn-group" style="width:100%;">
                                            <button type="button" class="btn btn-primary dropdown-toggle form-control text-left category-child-btn" data-toggle="dropdown">  <span class="caret">Brand</span></button>
                                            <button  type="button" onclick="addLabel(this,'Add Brand')" class="btn btn-outline-primary form-control add-categorization" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        </div>

                                        <select id="selectBrand" class="form-control select2" name="brand_id" required>
                                            <option selected="true" disabled="disabled">Select Brand</option>
                                            @isset($brands)
                                                @foreach($brands as $brand)
                                                    <option onclick="optionClick(this)" value="{{$brand->id ?? ''}}">{{$brand->name ?? ''}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>

                                    <div class="col-md-3 col-sm-6 form-group">
                                        <div class="btn-group" style="width:100%;">
                                            <button type="button" class="btn btn-primary dropdown-toggle form-control text-left category-child-btn" data-toggle="dropdown">  <span class="caret">Department</span></button>
                                            <button  type="button" onclick="addLabel(this,'Add Department')" class="btn btn-outline-primary form-control add-categorization" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        </div>

                                        <select id="selectDepartment" class="form-control child-cat-select gender-choose" name="gender_id" required>
                                            <option hidden>Select Department</option>
                                            @isset($genders)
                                                @foreach($genders as $gender)
                                                    <option onclick="optionClick(this)" value="{{$gender->id ?? ''}}">{{$gender->name ?? ''}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>

                                    <div class="col-md-3 col-sm-6 form-group">
                                        <div class="btn-group" style="width:100%;">
                                            <button type="button" class="btn btn-primary dropdown-toggle form-control text-left category-child-btn" data-toggle="dropdown">  <span class="caret">WooWMS Category</span></button>
                                            <button  type="button" onclick="addLabel(this,'Add Wms Category')" class="btn btn-outline-primary form-control add-categorization" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        </div>

                                        <select id="selectWMSCategory" class="form-control child-cat-select category_select " name="category_id" required>
                                            <option value="">Select Category</option>
                                            @if (count($categories) > 0)
                                                @foreach ($categories as $cat)
                                                    <option onclick="optionClick(this)" value="{{$cat->id}}">{{$cat->category_name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>





                                    <!-- design for add attribute and terms end -->
                                    <div class="row">
                                        <div class="col-md-4">

                                            <div class="select-product-type">
                                                <div class="select-product-type-left">
                                                    <div>Product Type</div>
                                                </div>
                                                <div onclick="productType()" class="add-product-type ml-1">
                                                    <div class="pro-type-inner">
                                                        <div class="type-name">
                                                            Variable Product
                                                        </div>
                                                        <div class="btn-div">
                                                            <span class="switch-btn"></span>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="type" value="variable" id="product-type">
                                                </div>
                                                <div id="wms-tooltip">
                                                    <span id="wms-tooltip-text" class="csv-text">Select product type via toggle button from Variable to Simple or vice versa.</span>
                                                    <span><img class="wms-tooltip-image" src="https://www.woowms.com/wms-1004/assets/common-assets/tooltip_button.png"></span>
                                                </div>
                                            </div>

                                            <div class="variation-attributes-height-controll" style="position:relative;">
                                                <div class="row">
                                                    <div class="col-md-12 m-b-20 all-attribute-container">
                                                        <div id="sortableAttribute">

                                                        </div>
                                                        <div class="add-variation-content variation-terms">
                                                            <div class="d-flex align-items-center appendVariation mt-3">
                                                                <a class="btn btn-outline-default variation-remove-btn position-relative" onclick="variationRemoveBtn(this)"><i class="fa fa-remove"></i></a>
                                                                <div class="att-minus-msg v-msg" style="display: none">Click to remove</div>
                                                                <select class="form-control" id="selectVariation" onchange="selectVariations()">
                                                                    @isset($attribute_terms)
                                                                        @if(count($attribute_terms) > 0)
                                                                            <option>Select Variation</option>
                                                                            @foreach($attribute_terms as $attribute)
                                                                                <option value="{{$attribute->id ?? ''}}">{{$attribute->attribute_name ?? ''}}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    @endisset
                                                                </select>
                                                                {{-- <button type="button" class="btn btn-default btn-sm dropdown-toggle form-control modal_button" data-toggle="dropdown"><span class="caret">Variation</span></button> --}}
                                                                {{-- <button class="btn btn-outline-default select-variation-btn" type="button" onclick="addAttributeModal('attribute','')" style="float:right;"><i class="fa fa-plus" aria-hidden="true"></i></button> --}}
                                                                <button class="btn btn-outline-default select-variation-btn" type="button" onclick="addAttributeModal('')" style="float:right;"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                                <div class="att-plus-msg vpmsg" style="display: none">Add new variation</div>
                                                            </div>
                                                            {{-- <select class="form-control select2 select2-hidden-accessible" name="att_name_test[]" multiple> --}}
                                                        </div>
                                                        {{-- <div class="col-md-12 addAnotherVariation" style="display: none">
                                                            <button onclick="addAnotherVariation(this)" class="btn btn-default cursor-pointer w-100">Add Another variation</button>
                                                        </div> --}}


                                                        <!-- Modal -->
                                                        {{-- <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle">Choose Variation</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle form-control modal_button" data-toggle="dropdown"><span class="caret">Variation</span></button>
                                                                        <select class="form-control select2 select2-hidden-accessible" name="att_name_test[]" multiple>
                                                                            @isset($attribute_terms)
                                                                                @if(count($attribute_terms) > 0)
                                                                                    <option ></option>
                                                                                    @foreach($attribute_terms as $attribute)
                                                                                        <option value="{{$attribute->id ?? ''}}">{{$attribute->attribute_name ?? ''}}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            @endisset
                                                                        </select>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
                                                                </div> -->
                                                            </div>
                                                        </div> --}}
                                                        {{-- </div> --}}
                                                    </div>
                                                    @isset($attribute_terms)
                                                        @if(count($attribute_terms) > 0)
                                                        @php
                                                            $num = 0;
                                                        @endphp
                                                            @foreach($attribute_terms as $attribute_term)

                                                                    <div class="input-group col-md-12 m-b-20 attribute_terms_class position-relative" id="attribute-terms-container-{{$attribute_term->id}}" style="display: none;" draggable="true" ondrag="myFunction(event)">
                                                                        <button class="btn btn-outline-primary vr-minus-btn" type="button" onclick="removeThisVariation(this)"><i class="fa fa-remove"></i></button>
                                                                        <div class="att-minus-msg" style="display: none">Click to remove</div>
                                                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle form-control" data-toggle="dropdown">  <span class="caret" data-id="{{$attribute_term->id}}"> {{$attribute_term->attribute_name}} ({{count($attribute_term->attributes_terms)}})</span></button>
                                                                        <div class="input-group-append">
                                                                            {{-- <button class="btn btn-outline-primary" type="button" onclick="addAttributeModal('attribute_terms',{{$attribute_term->id}})"><i class="fa fa-plus"></i></button> --}}
                                                                            <button class="btn btn-outline-primary" type="button" onclick="addAttributeModal({{$attribute_term->id}})"><i class="fa fa-plus"></i></button>
                                                                            <input type="hidden" class="hidden-variation" value="{{ $attribute_term->id ?? '' }}">
                                                                            <div class="att-plus-msg" style="display: none">Add new terms</div>
                                                                        </div>
                                                                        <select class="form-control variation-term-select2 attribute-terms-option-{{$attribute_term->id}}" name="terms[{{$attribute_term->id}}][]" id="attribute-terms-option-{{$attribute_term->id}}" multiple="multiple" size='8'>
                                                                            @if(count($attribute_term->attributes_terms) > 0)
                                                                                @foreach($attribute_term->attributes_terms as $terms)
                                                                                    <option value="{{$terms->id ?? ''}}">{{$terms->terms_name ?? ''}}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>

                                                            @endforeach
                                                        @endif
                                                    @endisset
                                                </div>
                                            </div>


                                            <div class="draft-wrap variable-input-field">

                                                <div class="sku-short-code-label">
                                                    {{-- <label class="sku_short_code" for="sku_short_code">SKU Short Code</label> --}}
                                                    <div class="tab-input-label" style="display: none">SKU Short Code</div>
                                                    <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control" name="sku_short_code" autocomplete="sku_short_code" placeholder="SKU Short Code">
                                                    @error("sku_short_code")
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="low-quantity-label mt-4">
                                                    {{-- <label for="low_quantity" class="draft-low-quantity">Low Quantity</label> --}}
                                                    <div class="tab-input-label" style="display: none">Low Quantity</div>
                                                    <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('low_quantity') is-invalid @enderror" name="low_quantity" autocomplete="low_quantity" autofocus id="low_quantity" placeholder="Low Quantity">
                                                    @error('low_quantity')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="ean-label mt-4">
                                                    {{-- <label class="draft-ean_no" for="ean_no">EAN</label> --}}
                                                    <div class="tab-input-label" style="display: none">EAN</div>
                                                    <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error("ean_no") is-invalid @enderror" name="ean_no" autocomplete="ean_no" autofocus id="ean_no" placeholder="EAN">
                                                    @error("ean_no")
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="sku-label mt-4">
                                                    {{-- <label class="draft-sku" for="sku">SKU</label> --}}
                                                    <div class="tab-input-label" style="display: none">SKU</div>
                                                    <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error("sku") is-invalid @enderror" name="sku" autocomplete="sku" autofocus id="sku" placeholder="SKU">
                                                    @error("sku")
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                            </div>

                                        </div>



                                    <div class="col-md-8">
                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <div class="var-description mt-sm-20">
                                                    <label class="required_attributes des-variation-attribute">Description</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group draft-ckeditor">
                                            <div class="nicescroll variation-description-height-controll">
                                                <textarea id="messageArea"  name="description" required autocomplete="description" autofocus>{{ old('description') }}</textarea>
                                            </div>

                                            @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                 <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                {{-- <!-- @if (count($itemInfos) > 0)
                                    @foreach ($itemInfos as $item)
                                        <div class="card mt-3">
                                            <div class="card-header font-18">{{$item->item_attribute}}</div>
                                            <div class="card-body">
                                                <div class="draft-wrap">
                                                    <div class="wms-row">
                                                        @if(count($item->itemAttributeTerms) > 0)
                                                            @foreach ($item->itemAttributeTerms as $term)
                                                                <div>
                                                                    <label for="height" class="draft-height">{{$term->item_attribute_term}}</label>
                                                                    <input type="text" data-parsley-maxlength="30" class="form-control" name="item_attribute[{{$item->item_attribute_slug}}][{{$term->id}}]" autocomplete="height" autofocus id="height" placeholder="">
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif --> --}}


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
                                    </ul>
                                    <div class="tab-content catalogue-tabs-content">
                                        <div class="tab-pane active" id="price">
                                            <div class="draft-wrap">
                                                <div class="wms-row">
                                                    <div class="tab-input-div mb-3">
                                                        {{-- <label class="draft-regular-price" for="regular_price">Regular Price</label> --}}
                                                        <div class="tab-input-label" style="display: none">Regular Price</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('regular_price') is-invalid @enderror" name="regular_price" autocomplete="regular_price" autofocus id="regular_price" placeholder="Regular Price">
                                                        @error('regular_price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>

                                                    <div class="tab-input-div mb-3">
                                                        {{-- <label class="draft-sales-price" for="sale_price">Sales Price</label> --}}
                                                        <div class="tab-input-label" style="display: none">Sales Price</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('sale_price') is-invalid @enderror" name="sale_price" autocomplete="sale_price" autofocus id="sale_price" placeholder="Sales Price">
                                                        @error('sale_price')
                                                        <span class="invalid-feedback" role="alert">
                                                             <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>

                                                    <div class="tab-input-div mb-3">
                                                        {{-- <label class="draft-cost-price" for="cost_price">Cost Price</label> --}}
                                                        <div class="tab-input-label" style="display: none">Cost Price</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('cost_price') is-invalid @enderror" name="cost_price" autocomplete="cost_price" autofocus id="cost_price" placeholder="Cost Price">
                                                        @error('cost_price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                {{-- </div> --}}
                                                {{-- <div class="wms-row"> --}}
                                                    {{-- <div class="cat-device mt-sm-20 mt-xs-20"> --}}
                                                    <div class="tab-input-div mb-3">
                                                        {{-- <label class="input-field-design" for="rrp">RRP</label> --}}
                                                        <div class="tab-input-label" style="display: none">RRP</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('rrp') is-invalid @enderror" name="rrp" autocomplete="rrp" autofocus id="rrp" placeholder="RRP">
                                                        @error('rrp')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="tab-input-div mb-3">
                                                        {{-- <label class="input-field-design" for="base_price">Base Price</label> --}}
                                                        <div class="tab-input-label" style="display: none">Base Price</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('rrp') is-invalid @enderror" name="base_price" autocomplete="base_price" autofocus id="base_price" placeholder="Base Price">
                                                        @error('base_price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="tab-input-div mb-3">
                                                        {{-- <label class="input-field-design draft-active" for="vat">VAT Persentage</label> --}}
                                                        <div class="tab-input-label" style="display: none">VAT Percentage</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('rrp') is-invalid @enderror" name="vat" autocomplete="vat" autofocus id="vat" value="20" placeholder="VAT Persentage">
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
                                            <div class="draft-wrap">
                                                <div class="wms-row">
                                                    <div class="tab-input-div mb-3">
                                                        {{-- <label for="product_code" class="draft-product-code">Product Code</label> --}}
                                                        <div class="tab-input-label" style="display: none">Product Code</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('product_code') is-invalid @enderror" name="product_code" autocomplete="product_code" autofocus id="product_code" placeholder="Product Code">
                                                        @error('product_code')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>

                                                    <div class="tab-input-div mb-3">
                                                        {{-- <label for="color_code" class="draft-color-code">Color Code</label> --}}
                                                        <div class="tab-input-label" style="display: none">Color Code</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('color_code') is-invalid @enderror" name="color_code" autocomplete="color_code" autofocus id="color_code" placeholder="Color Code">
                                                        @error('color_code')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>

                                                    <div class="tab-input-div mb-3">
                                                        {{-- <label for="color" class="draft-color">Color</label> --}}
                                                        <div class="tab-input-label" style="display: none">Color</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('color') is-invalid @enderror" name="color" autocomplete="color" autofocus id="color" placeholder="Color">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="catalogue-product-image">
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
                                                    <ul class="d-flex flex-wrap sortable ebay-image-wrap" id="sortableImageDiv">
                                                        <div class="drag-drop-image add-photos-content no-img-content">
                                                            <p class="inner-add-sign">+</p>
                                                            <input type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control ebay-image-upload" accept="/image" onchange="preview_image();" multiple="">
                                                            <p class="inner-add-photo">Add Photos</p>
                                                        </div>
                                                        <div class="drag-drop-image add-photos-content no-img-content">
                                                            <p class="inner-add-sign">+</p>
                                                            <input type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control ebay-image-upload" accept="/image" onchange="preview_image();" multiple="" disabled="">
                                                            <p class="inner-add-photo">Add Photos</p>
                                                        </div>
                                                        <div class="drag-drop-image add-photos-content no-img-content">
                                                            <p class="inner-add-sign">+</p>
                                                            <input type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control ebay-image-upload" accept="/image" onchange="preview_image();" multiple="" disabled="">
                                                            <p class="inner-add-photo">Add Photos</p>
                                                        </div>
                                                        <div class="drag-drop-image add-photos-content no-img-content">
                                                            <p class="inner-add-sign">+</p>
                                                            <input type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control ebay-image-upload" accept="/image" onchange="preview_image();" multiple="" disabled="">
                                                            <p class="inner-add-photo">Add Photos</p>
                                                        </div>
                                                        <div class="drag-drop-image add-photos-content no-img-content">
                                                            <p class="inner-add-sign">+</p>
                                                            <input type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control ebay-image-upload" accept="/image" onchange="preview_image();" multiple="" disabled="">
                                                            <p class="inner-add-photo">Add Photos</p>
                                                        </div>
                                                        <div class="drag-drop-image add-photos-content no-img-content">
                                                            <p class="inner-add-sign">+</p>
                                                            <input type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control ebay-image-upload" accept="/image" onchange="preview_image();" multiple="" disabled="">
                                                            <p class="inner-add-photo">Add Photos</p>
                                                        </div>
                                                        <div class="drag-drop-image add-photos-content no-img-content">
                                                            <p class="inner-add-sign">+</p>
                                                            <input type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control ebay-image-upload" accept="/image" onchange="preview_image();" multiple="" disabled="">
                                                            <p class="inner-add-photo">Add Photos</p>
                                                        </div>
                                                        <div class="drag-drop-image add-photos-content no-img-content">
                                                            <p class="inner-add-sign">+</p>
                                                            <input type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control ebay-image-upload" accept="/image" onchange="preview_image();" multiple="" disabled="">
                                                            <p class="inner-add-photo">Add Photos</p>
                                                        </div>
                                                        <div class="drag-drop-image add-photos-content no-img-content">
                                                            <p class="inner-add-sign">+</p>
                                                            <input type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control ebay-image-upload" accept="/image" onchange="preview_image();" multiple="" disabled="">
                                                            <p class="inner-add-photo">Add Photos</p>
                                                        </div>
                                                        <div class="drag-drop-image add-photos-content no-img-content">
                                                            <p class="inner-add-sign">+</p>
                                                            <input type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control ebay-image-upload" accept="/image" onchange="preview_image();" multiple="" disabled="">
                                                            <p class="inner-add-photo">Add Photos</p>
                                                        </div>
                                                        <div class="drag-drop-image add-photos-content no-img-content">
                                                            <p class="inner-add-sign">+</p>
                                                            <input type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control ebay-image-upload" accept="/image" onchange="preview_image();" multiple="" disabled="">
                                                            <p class="inner-add-photo">Add Photos</p>
                                                        </div>
                                                        <div class="drag-drop-image add-photos-content no-img-content">
                                                            <p class="inner-add-sign">+</p>
                                                            <input type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control ebay-image-upload" accept="/image" onchange="preview_image();" multiple="" disabled="">
                                                            <p class="inner-add-photo">Add Photos</p>
                                                        </div>
                                                    </ul>
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
                                <div class="form-group row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary draft-add-btn waves-effect waves-light" id="addCatalogue">
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>

        $(document).ready(function(){
            $('div.add-variation-content').hide()
            var addVariation = '<div class="col-md-12 addVariation">'+
                               '  <a onclick="addVariation(this)" class="btn btn-default cursor-pointer w-100">Add Variation</a>'+
                               '</div>'
            $('div.all-attribute-container').after(addVariation)
            var attr = $('input[name="att_name_test[]"]').length
            // console.log('attr ' + attr)
            if(attr == ''){
                $('a.variation-remove-btn').hide()
            }
        })

        function addVariation(e){
            $(e).parent('div').hide()
            $('div.add-variation-content').show()
        }

        function selectVariations(){
            var e = document.getElementById('selectVariation')
            var optionName = e.options[e.selectedIndex].text
            var optionValue = e.options[e.selectedIndex].value
            $('div.input-group span.caret').each(function(index, element){
                // console.log(element.innerText)
                var a = element.innerText.replaceAll("\\d", "")
                var b = a.replace(/ *\([^)]*\) */g, "")
                var variationName = b.replace(/^0+/, '')
                var id = $(this).attr('data-id')
                var parentDiv = $(element).closest('div')
                if(optionName.trim() == variationName.trim() && optionValue == id){
                    // console.log('matched')
                    $('div#sortableAttribute').append(parentDiv)
                    $("#selectVariation").val($("#selectVariation option:first").val());
                    $('div#attribute-terms-container-'+id).show()
                    $(element).closest('div').find('input.hidden-variation').attr('name', 'att_name_test[]')
                    $('div#sortableAttribute').css('margin-top', '40px')
                    $("select#selectVariation option[value='"+id+"']").hide();
                    $('div.add-variation-content').hide()
                    var addAnotherVariation = '<div class="col-md-12 addAnotherVariation">'+
                                              '   <button onclick="addAnotherVariation(this)" class="btn btn-default cursor-pointer w-100">Add Another variation</button>'+
                                              '</div>'
                    $('div.add-variation-content').after(addAnotherVariation)
                    // $('.addAnotherVariation').show()
                    var attr = $('input[name="att_name_test[]"]').length
                    // console.log('attr ' + attr)
                    if(attr != ''){
                        $('a.variation-remove-btn').show()
                    }
                }

            })
        }

        function addAnotherVariation(e){
            // console.log('test')
            $(e).remove()
            $('div.add-variation-content').show()
        }

        function removeThisVariation(e){
            var id = $(e).closest('div').find('span.caret').attr('data-id')
            // console.log('id ' + id)
            $("select#selectVariation option[value='"+id+"']").show();
            $(e).closest('div').hide()
            $(e).closest('div').find('input.hidden-variation').removeAttr('name')
            var attr = $('input[name="att_name_test[]"]').length
            // console.log('attr ' + attr)
            if(attr == ''){
                $('a.variation-remove-btn').hide()
                $('div.addAnotherVariation').hide()
                $('div.addVariation').show()
                $('div.add-variation-content').hide()
                $('div.all-attribute-container').removeClass('m-b-20')
            }
        }

        function variationRemoveBtn(e){
            var attr = $('input[name="att_name_test[]"]').length
            // console.log('attr ' + attr)
            if(attr == ''){

            }else{
                $(e).closest('div.add-variation-content').hide()
                var addAnotherVariation = '<div class="col-md-12 addAnotherVariation">'+
                                              '   <button onclick="addAnotherVariation(this)" class="btn btn-default cursor-pointer w-100">Add Another variation</button>'+
                                              '</div>'
                $('div.add-variation-content').after(addAnotherVariation)
            }
        }


        $('.ean-label, .sku-label').hide()

        //Toggle switch button function
        function productType(){

            $('.onoffswitch-label').toggleClass('simple-color')
            $('.sku-short-code-label').toggleClass('d-none')
            $('.ean-label, .sku-label').toggleClass('d-block')
            $('.add-variation-content, .attribute_terms_class').toggleClass('d-none')
            $('.draft-wrap').toggleClass('variable-input-field')
            $('.draft-wrap').toggleClass('simple-input-field')
            $('div.pro-type-inner').toggleClass('flex-direction-re')
            $('button.addAnotherVariation').toggleClass('d-none')
            $('div.variation-attributes-height-controll').toggleClass('d-none')


            if($('input#product-type').val() == "variable") {
                $('input#product-type').val("simple");
                $('div.type-name').text('Simple Product')
                $('span.switch-btn').removeClass('float-right')
                $('span.switch-btn').addClass('float-left')
                $('div.add-product-type').addClass('simple-color')
                $('div.add-product-type').removeClass('variable-color')
                $('input#sku').prop('required',true);
                $('input.hidden-variation').removeAttr('name')
                simple();
            }else {
                $('input#product-type').val("variable");
                $('div.type-name').text('Variable Product')
                $('span.switch-btn').removeClass('float-left')
                $('span.switch-btn').addClass('float-right')
                $('div.add-product-type').removeClass('simple-color')
                $('div.add-product-type').addClass('variable-color')
                $('input#sku').prop('required',false);
                $('input.hidden-variation').attr('name', 'att_name_test[]')
                variable();
            }

        }


        function variable() {
            $('input#product-type').val("variable");
            $('input#sku').prop('required',false);
        }

        function simple() {
            $('input#product-type').val("simple");
            $('input#sku').prop('required',true);
        }

        //End Toggle switch button function


        $('button.vr-minus-btn').hover(function(){
            var parentDiv = $(this).closest('div')
            $('div.att-minus-msg', parentDiv).show()
        },function(){
            var parentDiv = $(this).closest('div')
            $('div.att-minus-msg', parentDiv).hide()
        })

        $('div.input-group-append').hover(function(){
            var parentDiv = $(this).closest('div')
            $('div.att-plus-msg', parentDiv).show()
        },function(){
            var parentDiv = $(this).closest('div')
            $('div.att-plus-msg', parentDiv).hide()
        })


        $('.variation-remove-btn').hover(function(){
            $('div.v-msg').show()
        },function(){
            $('div.v-msg').hide()
        })

        $('.select-variation-btn').hover(function(){
            $('div.vpmsg').show()
            var attr = $('input[name="att_name_test[]"]').length
            // console.log('attr ' + attr)
            if(attr == ''){
                // $('div.add-variation-content').css('margin-top', '44px')
                $('div.vpmsg').css({'right' : '20px', 'bottom' : '-43px'})
            }else{
                // $('div.vpmsg').css({'right' : '20px', 'bottom' : '40px'})
            }
        },function(){
            $('div.vpmsg').hide()
        })



        // function addAttributeModal(isModal, id = ''){
        function addAttributeModal(id = ''){
            // console.log(isModal, id)
            console.log(id)
            $('.swal2-confirm').css('width', '100px !important')
            $('.swal2-cancel').css('width', '100px !important')
            var html = ''
            if(id == ''){
                var html = '<div>'+
                           '     <div class="attribute-terms-span">'+
                           '         <div style="width: 92%">'+
                           '            <input type="text" id="attribute_or_term" class="form-control add_new_variation" value="" placeholder="Enter Variation">'+
                           '            <span id="newVariationValidation" style="display: none"></span>'+
                           '         </div>'+
                           '         <div style="width: 8%">'+
                           '            <i class="fa fa-plus add-new-variation" onmouseover="add_more_variation_in(this)" onmouseout="add_more_variation_out(this)" onclick="addNewVariation('+"''"+')"></i>'+
                           '            <i class="fa fa-close add-product-newvariation-close" title="Click to remove" onclick="removeNewVariationTerms(this)" style="display: none"></i>'+
                           '         </div>'+
                           '     </div>'+

                           '     <p>Use Variation</p>'+
                           '     <p class="font-12" id="add-more-variation" style="display: none">Add more</p>'+
                           '</div>'+
                           '<div class="d-flex justify-content-center align-items-center">'+
                            '   <div><input type="radio" name="use_variation" class="use_variation form-check-input" value="1" checked>Yes</div>'+
                            '   <div class="ml-5"><input type="radio" name="use_variation" class="use_variation form-check-input" value="0">No</div>'+
                            '</div>'

            }else{
                // var html = '<input type="text" id="attribute_or_term" class="form-control add_variation_terms" value="" placeholder="Enter Variation Terms"><span id="newVariationTermsValidation" style="display: none"></span>'
                var html = '<div>'+
                           '     <div class="attribute-terms-span">'+
                           '         <div style="width: 92%">'+
                           '            <input type="text" id="attribute_or_term" class="form-control add_variation_terms" value="" placeholder="Enter Variation Terms">'+
                           '            <span id="newVariationTermsValidation" style="display: none"></span>'+
                           '         </div>'+
                           '         <div style="width: 8%">'+
                           '              <i class="fa fa-close add-product-newvariation-close" title="Click to remove" onclick="removeNewVariationTerms(this)" style="display: none"></i>'+
                           '              <i class="fa fa-plus add-new-variation" onclick="addNewVariation('+id+')"></i>'+
                           '         </div>'+
                           '     </div>'+

                           '</div>'
            }
            //return false
            Swal.fire({
                title: (id == '') ? 'Add New Variation' : 'Add Terms',
                html: html,
                showCancelButton: true,
                confirmButtonText: 'Add',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    // const attribute = Swal.getPopup().querySelector('#attribute_or_term').value
                    if(id == ''){
                        var attribute = $('input.add_new_variation')
                    }else if(id != ''){
                        var attribute = $('input.add_variation_terms')
                    }

                    const useVariaton = (id == '') ? Swal.getPopup().querySelector('input[name="use_variation"]:checked').value : ''
                    // console.log(attribute, useVariaton)
                    attributeArray = []
                    for(var i = 0; i < attribute.length; i++){
                        attributeArray.push(attribute[i].value)
                    }
                    // console.log('attributeArray', attributeArray)
                    // return false
                    var dataObj = {}
                    if(id == ''){
                        var url = "{{asset('attribute')}}"
                        var dataObj = {
                                attribute_name: attributeArray,
                                use_variation: useVariaton,
                                type: 'ajax'
                            }
                        if(!attribute || !useVariaton){
                            Swal.showValidationMessage(`Invalid Attribute or Variation Selection`)
                            return false
                        }
                    }else{
                        var url = "{{asset('attribute-terms')}}"
                        var dataObj = {
                                terms_name: attributeArray,
                                attribute_id: id,
                                type: 'ajax'
                            }
                        if(!attribute){
                            Swal.showValidationMessage(`Invalid Attribute Terms`)
                            return false
                        }
                    }
                    console.log(url)
                    console.log(dataObj)

                    //let url = (id == '') ? "{{asset('attribute')}}" : "{{asset('attribute-terms')}}"

                    let token = "{{csrf_token()}}"
                    return fetch(url, {
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json, text-plain, */*",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": token
                            },
                        method: 'post',
                        body: JSON.stringify(dataObj)
                    })
                    .then((response) => {
                        if(!response.ok){
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(function(error) {
                        Swal.showValidationMessage(`Request failed: ${error}`)
                    });

                },
            })
            .then(result => {
                if(result.isConfirmed){
                    console.log('result ', result)
                    if(result.value.name == 'attribute'){
                        result.value.data.forEach(function(item, index, arr){
                            // console.log('item ', item[0]['id'])
                            var data = {
                                id: item[0]['id'],
                                text: item[0]['attribute_name']
                            };
                            // console.log('data.id ', data.id)
                            // console.log('data.text ', data.text)
                            var singleVariationFullContent = '<div class="input-group col-md-12 m-b-20 attribute_terms_class position-relative" id="attribute-terms-container-'+data.id+'" style="display: none;" draggable="true" ondrag="myFunction(event)">'+
                                                            '               <button class="btn btn-outline-primary vr-minus-btn" type="button" onclick="removeThisVariation(this)"><i class="fa fa-remove"></i></button>'+
                                                            '              <div class="att-minus-msg" style="display: none">Click to remove</div>'+
                                                            '             <button type="button" class="btn btn-primary btn-sm dropdown-toggle form-control" data-toggle="dropdown">  <span class="caret" data-id="'+data.id+'"> '+data.text+' (<span id="termsCounter-'+data.id+'">0</span>)</button>'+
                                                            '            <div class="input-group-append">'+
                                                            '                   <button class="btn btn-outline-primary" type="button" onclick="addAttributeModal('+data.id+')"><i class="fa fa-plus"></i></button>'+
                                                            '                   <input type="hidden" class="hidden-variation" value="'+data.id+'" name="att_name_test[]">'+
                                                            '                   <div class="att-plus-msg" style="display: none">Add new terms</div>'+
                                                            '               </div>'+
                                                            '               <select class="form-control variation-term-select2 attribute-terms-option-'+data.id+'" name="terms['+data.id+'][]" id="attribute-terms-option-'+data.id+'" multiple="multiple" size="8">'+
                                                            '               </select>'+
                                                            '           </div>'

                            $('select#selectVariation').append('<option value="'+data.id+'">'+data.text+'</option>')
                            var variationSelectionContent = $('div#sortableAttribute div.input-group').length
                            if(variationSelectionContent == 0){
                                $('div#sortableAttribute').css('margin-top', '40px').append(singleVariationFullContent)
                                $('div.add-variation-content').removeAttr('style')

                                $('div.input-group-append').hover(function(){
                                    $(this).children('div.att-plus-msg').show()
                                },function(){
                                    $(this).children('div.att-plus-msg').hide()
                                })

                                $('button.vr-minus-btn').hover(function(){
                                    $(this).next('div.att-minus-msg').show()
                                },function(){
                                    $(this).next('div.att-minus-msg').hide()
                                })

                            }else{
                                $('div#sortableAttribute').append(singleVariationFullContent)
                            }

                            $('div#attribute-terms-container-'+data.id).show()
                            $('.variation-term-select2').select2();
                            $('select#selectVariation option[value="'+data.id+'"]').hide()
                            $('div.add-variation-content').hide()
                            $('div.addAnotherVariation').show()
                            var addAnotherVariation = '<div class="col-md-12 addAnotherVariation">'+
                                                      '   <button onclick="addAnotherVariation(this)" class="btn btn-default cursor-pointer w-100">Add Another variation</button>'+
                                                      '</div>'
                            $('div.add-variation-content').after(addAnotherVariation)
                            if($('.addAnotherVariation').length > 1){
                                $('.addAnotherVariation:first').nextAll('.addAnotherVariation').remove()
                            }

                            // var newOption = new Option(data.text, data.id, false, false);
                            // $('#all_attribute').append(newOption).trigger('change');
                        })
                    }else{
                        result.value.data.forEach(function(item, index, arr){
                            // console.log(item[0].id)
                            // console.log(item[0].attribute_id)
                            // console.log(item[0].terms_name)
                            var id = item[0].id
                            var attribute_id = item[0].attribute_id
                            var terms_name = item[0].terms_name
                            $('select#attribute-terms-option-'+attribute_id).append('<option value="'+id+'" selected>'+terms_name+'</option>')
                        })

                        // var newOption = new Option(data.text, data.id, false, false);
                        // $('#attribute-terms-option-'+attribute_id).append(newOption).trigger('change');
                    }
                    Swal.fire({
                        title: `${result.value.msg}`,
                        icon: 'success'
                    })
                }
            })

            if(id == ''){
                var inputField = $('input.add_new_variation')
                var selectOption = $('select#selectVariation option')
            }else if(id != ''){
                var inputField = $('input.add_variation_terms')
                var selectOption = $("select.attribute-terms-option-"+id+ '> option')
            }


            inputField.on('input', function(){
                console.log('first')
                var first = "first"
                var inputVal = this.value
                var that = this
                if(id == ''){
                    var validationShow = $(that).closest('div.attribute-terms-span').find('span#newVariationValidation')
                }else if(id != ''){
                    var validationShow = $(that).closest('div.attribute-terms-span').find('span#newVariationTermsValidation')
                }
                selectOption.each(function(index, element){
                    if(inputVal != ''){
                        if(inputVal.toLowerCase() == element.text.toLowerCase()){
                            var validation = element.text +' is already exist!'
                            validationShow.show().text(validation)
                            $('i.add-new-variation').hide()
                            $('button.swal2-confirm').attr('disabled', 'disabled')
                            return false
                        }else{
                            validationShow.hide()
                            if(first){
                                var firstCount = $('.add_new_variation').length
                                $('i.add-new-variation').show()
                            }
                            $('button.swal2-confirm').removeAttr('disabled', 'disabled')
                        }
                    }
                })
            })
        }



        function addNewVariation(id = ''){
            // console.log(id)

            var new_variation_input =   '     <div class="attribute-terms-span mt-2">'+
                                        '         <div style="width: 92%">'+
                                        '            <input type="text" id="attribute_or_term" class="form-control add_new_variation" value="" placeholder="Enter Variation">'+
                                        '            <span id="newVariationValidation" style="display: none"></span>'+
                                        '         </div>'+
                                        '         <div style="width: 8%">'+
                                        '            <i class="fa fa-close add-product-newvariation-close" title="Click to remove" onclick="removeNewVariationTerms(this)" style="display: none"></i>'+
                                        '            <i class="fa fa-plus add-new-variation" onmouseover="add_more_variation_in(this)" onmouseout="add_more_variation_out(this)" onclick="addNewVariation('+"''"+')"></i>'+
                                        '         </div>'+
                                        '     </div>'
            var new_variation_terms_input = '     <div class="attribute-terms-span mt-2">'+
                                            '         <div style="width: 92%">'+
                                            '            <input type="text" id="attribute_or_term" class="form-control add_variation_terms" value="" placeholder="Enter Variation Terms">'+
                                            '            <span id="newVariationTermsValidation" style="display: none"></span>'+
                                            '         </div>'+
                                            '         <div style="width: 8%">'+
                                            '             <i class="fa fa-close add-product-newvariation-close" title="Click to remove" onclick="removeNewVariationTerms(this)" style="display: none"></i>'+
                                            '             <i class="fa fa-plus add-new-variation" onclick="addNewVariation('+id+')"></i>'+
                                            '         </div>'+
                                            '     </div>'


            // $('i.add-product-newvariation-close').css({'margin-left': '-25px'})
            if(id == ''){
                $('.add-new-variation').hide()
                $('.add-product-newvariation-close').show()
                $('div.attribute-terms-span').last().after(new_variation_input)
                var inputField = $('input.add_new_variation')
                var selectOption = $('select#selectVariation option')
            }else if(id != ''){
                $('.add-new-variation').hide()
                $('.add-product-newvariation-close').show()
                $('div.attribute-terms-span').last().after(new_variation_terms_input)
                var inputField = $('input.add_variation_terms')
                var selectOption = $("select.attribute-terms-option-"+id+ '> option')
            }

            // $('input.add_new_variation').on('input', function(){
            inputField.on('input', function(){
                console.log('last')
                var last = "last";
                var inputVal = this.value
                var that = this
                var type = []
                var nextAllDivDotAttributeTerms = $(that).closest('div.attribute-terms-span').nextAll('div.attribute-terms-span')
                if(id == ''){
                    var validationShow = $(that).closest('div.attribute-terms-span').find('span#newVariationValidation')
                }else if(id != ''){
                    var validationShow = $(that).closest('div.attribute-terms-span').find('span#newVariationTermsValidation')
                }
                inputField.each(function(){
                    if(inputVal == $(this).val() && that != this) {
                        $(that).next().after('<span id="type-value" style="color: red">'+inputVal+' is already typed!</span>')
                        // $('.add-product-newvariation-close').addClass('type-validation-class')
                        $('i.add-new-variation').hide()
                        $('button.swal2-confirm').attr('disabled', 'disabled')
                        type.push('typed')
                        return false
                    }else{
                        $('#type-value').remove()
                        // $(that).closest('div').find('#type-value').remove()
                        if(last){
                            $('i.add-new-variation').hide()
                            $(this).closest('div').next('div').find('.add-new-variation').show()
                        }
                        $('button.swal2-confirm').removeAttr('disabled', 'disabled')
                        $('.add-product-newvariation-close').removeClass('type-validation-class')
                    }
                    // console.log($(this).val())
                    // console.log(inputVal)
                })
                console.log('type ' + type)
                if(type.length == ''){
                    selectOption.each(function(index, element){
                        if(inputVal != ''){
                            if(inputVal.toLowerCase() == element.text.toLowerCase()){
                                var validation = element.text +' is already exist!'
                                validationShow.show().text(validation)
                                nextAllDivDotAttributeTerms.hide()
                                $('button.swal2-confirm').attr('disabled', 'disabled')
                                // $('i.add-product-newvariation-close').css({'margin-bottom': '24px'})
                                $('i.add-new-variation').hide()
                                return false
                            }else{
                                validationShow.hide()
                                nextAllDivDotAttributeTerms.show()
                                $('button.swal2-confirm').removeAttr('disabled', 'disabled')
                                $('i.add-product-newvariation-close').css('margin-bottom', '0')
                                if(last){
                                    $('i.add-new-variation').hide()
                                    $(that).closest('div').next('div').find('.add-new-variation').show()
                                }
                                // $('i.add-new-variation').show()
                            }
                        }
                    })
                }
            })
        }

        function removeNewVariationTerms(e){
            $(e).closest('div.attribute-terms-span').remove()
        }

        function add_more_variation_in(e){
            $(e).closest('div').find('#add-more-variation').show()
        }

        function add_more_variation_out(e){
            $(e).closest('div').find('#add-more-variation').hide()
        }


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

            // console.log(department);
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


        // Dropdown Select
        $('.select2').select2();
        // $(".select2").select2({ tags: true }); $("select").on("select2:select", function (evt) { var element = evt.params.data.element; var $element = $(element); $element.detach(); $(this).append($element); $(this).trigger("change"); });

        $("select").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);

            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });

        $('#sortableAttribute div.all-attribute-container .select2-hidden-accessible').select2({
            placeholder: 'Select Variation',
            // tags: true,
            multiple: true,
            // maximumSelectionLength: 1,
            tokenSeparators: [',', ' '],
            createTag: function (params) {
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                return {id: params.term, text: params.term, newTag: true};
            }
        })
        .on('change', function(e){
            // $(this).val() - array of tags in input

            var allTags = $(this).val();
            console.log(allTags)
            var newTags = [];
            $('#sortableAttribute > div').not('.all-attribute-container').each(function(){
                $(this).find('select.select2-hidden-accessible').attr('disabled', true)
                $(this).hide()
            })
            allTags.forEach(function (el, index) {

                    $('#attribute-terms-container-'+el).find('select.select2-hidden-accessible').attr('disabled', false)
                    if(index == 0){
                        // index = 130;
                        index = 35;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                        // $('#attribute-terms-container-'+el).show().css({ 'position' : 'absolute', 'left':'inherit', 'top':index })
                    }else if(index == 1){
                        index = 60;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }else if(index == 2){
                        index = 85;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }else if(index == 3){
                        index = 110;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }else if(index == 4){
                        index = 135;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }else if(index == 5){
                        index = 160;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 6){
                        index = 185;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 7){
                        index = 210;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 8){
                        index = 235;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 9){
                        index = 260;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 10){
                        index = 285;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 11){
                        index = 310;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 12){
                        index = 335;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 13){
                        index = 360;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 14){
                        index = 385;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 15){
                        index = 410;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 16){
                        index = 435;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 17){
                        index = 460;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 18){
                        index = 485;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 19){
                        index = 510;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 20){
                        index = 535;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 21){
                        index = 560;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 22){
                        index = 585;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 23){
                        index = 610;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 24){
                        index = 635;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 25){
                        index = 660;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 26){
                        index = 685;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 27){
                        index = 710;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 28){
                        index = 735;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 29){
                        index = 760;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }
                    else if(index == 30){
                        index = 785;
                        $('#attribute-terms-container-'+el).show().css({ 'left':'inherit', 'top':index })
                    }else{
                        $('#attribute-terms-container-'+el).show()
                    }


            });
        });
        // Start ckeditor summernote
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

        // End ckeditor summernote


        function Count() {
            var i = document.getElementById("name").value.length;
            document.getElementById("display").innerHTML = 'Character Remain: '+ (80 - i);
        }

        $(document).ready(function () {
            //document.getElementById('variation').style.display = "none";
            // $('.gender-choose').on('change',function () {
            //     var gender_id = $(this).val();
            //     if(gender_id == ''){
            //         swal.fire({
            //             title: 'Department name is not found',
            //             icon: 'warning'
            //         });
            //         return
            //     }
            //     $.ajax({
            //         type: "POST",
            //         url: "{{url('gender-category')}}",
            //         data: {
            //             "_token" : "{{csrf_token()}}",
            //             "gender_id" : gender_id
            //         },
            //         success: function (response) {
            //             if(response.genders.length > 0){
            //                 var content = '<option hidden>Select Category</option>';
            //                 response.genders.forEach(function(item){
            //                     content += '<option value="'+item.id+'">'+item.category_name+'</option>';
            //                 });
            //                 $('.category_select').html(content);
            //             }else{
            //                 swal.fire({
            //                     title: 'No category found. Please assign category in a department',
            //                     icon: 'warning'
            //                 });
            //             }
            //         }
            //     });
            // })

            $('.category_select').on('change',function () {
                var category_id = $(this).val();
                if(category_id == ''){
                    swal.fire({
                        title: 'Category name is not found',
                        icon: 'warning'
                    });
                    return
                }
                $.ajax({
                    type: "POST",
                    url: "{{url('gender-category')}}",
                    data: {
                        "_token" : "{{csrf_token()}}",
                        "category_id" : category_id
                    },
                    beforeSend: function () {
                        console.log('before send')
                        $('#ajax_loader').show();
                    },
                    success: function (response) {
                        if(response.type == 'success' && response.data != null){
                            // var content = ''
                            var tabTitles = ''
                            var tabContent = ''
                            if(response.data.category_attribute.length > 0){

                                response.data.category_attribute.forEach(function(item){
                                    if(item.attributes.length > 0){
                                        console.log('category attribute item')
                                        item.attributes.forEach(function(attr){
                                            tabTitles += '<li class="tab">'
                                            +'<a href="#'+attr.item_attribute_slug+'_'+attr.id+'" data-toggle="tab" aria-expanded="true">'+attr.item_attribute+'</a>'
                                            +'</li>'
                                            tabContent += '<div class="tab-pane item-attribute-tab-'+attr.id+'" data="'+attr.id+'" id="'+attr.item_attribute_slug+'_'+attr.id+'">'
                                            +'<div class="draft-wrap">'
                                            +'<div class="wms-row">'

                                        // content += '<div class="card mt-3">'
                                        //     +'<div class="card-header font-18">'+attr.item_attribute+'</div>'
                                        //         +'<div class="card-body">'
                                        //             +'<div class="draft-wrap">'
                                        //                 +'<div class="wms-row">';
                                                            if(attr.item_attribute_terms.length > 0){
                                                                var profileList = ''
                                                                if(response.itemProfileList.length > 0) {
                                                                    profileList += '<div class="tab-input-div mb-3">'
                                                                            +'<select class="form-control text-white item-profile-option" style="background: #5959ad">'
                                                                    profileList += '<option value="">Select Profile</option>'
                                                                    var i = 0
                                                                    response.itemProfileList.forEach(function(profile){
                                                                        if(profile.item_attribute_id == attr.id){
                                                                            profileList += '<option value="'+profile.id+'">'+profile.profile_name+'</option>'
                                                                            i++;
                                                                        }
                                                                    });
                                                                    profileList += '</select><span class="text-danger"></span>'
                                                                        +'</div>'
                                                                }
                                                                if(i > 0){
                                                                    tabContent += profileList
                                                                }
                                                                attr.item_attribute_terms.forEach(function(term){
                                                                    tabContent += '<div class="tab-input-div mb-3">'
                                                                                    //+'<label for="'+term.item_attribute_term_slug+'" class="draft-height">'+term.item_attribute_term+'</label>'
                                                                                    // +'<input type="text" class="form-control" name="item_attribute['+term.id+']" autocomplete="height" autofocus id="height" placeholder="'+term.item_attribute_term+'">'
                                                                                    +'<div class="tab-input-label" style="display: none">'+term.item_attribute_term+'</div>'
                                                                                    +'<input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control" name="item_attribute['+term.id+']" id="'+term.item_attribute_term_slug+'" placeholder="'+term.item_attribute_term+'" autofocus>'
                                                                                +'</div>'
                                                                    // content += '<div>'
                                                                    //     // +'<label for="height" class="draft-height">'+term.item_attribute_term+'</label>'
                                                                    //     +'<input type="text" data-parsley-maxlength="30" class="form-control" name="item_attribute['+term.id+']" autocomplete="'+term.item_attribute_term_slug+'" autofocus id="'+term.item_attribute_term_slug+'" placeholder="'+term.item_attribute_term+'">'
                                                                    // +'</div>';
                                                                })

                                                            }
                                                            tabContent += '</div>'
                                                                    +'</div>'
                                                                +'</div>'
                                            //             content += '</div>'
                                            //         +'</div>'
                                            //      +'</div>'
                                            // +'</div>';
                                        })
                                    }
                                });


                                // var content = '<option hidden>Select Category</option>';
                                // response.genders.forEach(function(item){
                                //     content += '<option value="'+item.id+'">'+item.category_name+'</option>';
                                // });
                                // $('.category_select').html(content);
                            }
                            // $('.catalogue-tabs-sec ul > li:nth-child(3)').after(tabTitles) //This is also correct
                            $('.add-catalogue-tab').find("li").slice(2).remove();
                            $('.catalogue-tabs-content').find("div.tab-pane").slice(2).remove();
                            $(tabTitles).insertAfter($('.catalogue-tabs-sec ul > li:nth-child(2)'))
                            $(tabContent).insertAfter($('.catalogue-tabs-content div.tab-pane:nth-child(2)'))
                            //$('span.item-title-term-append-div').html(content);

                        }else{
                            swal.fire({
                                title: 'No category found. Please assign category in a department',
                                icon: 'warning'
                            });
                        }

                    },
                    complete: function () {
                        console.log('end send')
                        $('#ajax_loader').hide();
                    }
                });

            })

            $('.catalogue-tabs-content').on('change','.item-profile-option',function(){
                $('#ajax_loader').show();
                var attributeId = $(this).closest('.tab-pane').attr('data')
                var itemAttributeTabHtml = $('.item-attribute-tab-'+attributeId)
                var profileId = $(this).val()
                if(profileId == ''){
                    itemAttributeTabHtml.find('input').val('')
                    $(this).closest('.tab-input-div').find('span').text('')
                    $('#ajax_loader').hide();
                    return false
                }
                var url = "{{asset('get-item-profile')}}"+"/"+profileId+"/"+attributeId
                var token = "{{csrf_token()}}"
                return fetch(url)
                .then(response => {
                    return response.json()
                })
                .then(data => {
                    if(data.type == 'success'){
                        if(data.profile && data.profile.item_attribute_profile_term.length > 0) {
                            itemAttributeTabHtml.find('input').val('')
                            data.profile.item_attribute_profile_term.forEach(function(profileData){
                                itemAttributeTabHtml.find('#'+profileData.item_attribute_term.item_attribute_term_slug).val(profileData.item_attribute_term_value)
                            })
                            $(this).closest('.tab-input-div').find('span').text('')
                        }else{
                            itemAttributeTabHtml.find('input').val('')
                            $(this).closest('.tab-input-div').find('span').text('No Value Found')
                        }
                    }else{
                        Swal.fire('Oops!',data.msg,'error')
                    }
                    $('#ajax_loader').hide();
                })
                .catch(error => {
                    Swal.fire('Oops!','Something Went Wrong','error')
                    $('#ajax_loader').hide();
                })
            })
        })


        // // placeholder label animation

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
        //     $(this).parent().find('draft-wrap').addClass('channel-input-edit-responsive');
        // });

        // $('input').on('focusout', function() {
        //     if (!this.value) {
        //         $(this).parent().find('label').removeClass('draft-active');
        //     }
        // });
        // // placeholder label animation

        // $(function(){
        //     var showClass = "draft-active";
        //     $("input").bind("checkval",function(){
        //         var label = $(this).prev('div');
        //         if(this.value !== ""){
        //             label.addClass(showClass);
        //         } else {
        //             label.removeClass(showClass);
        //         }
        //     }).trigger("checkval");
        // });


        $(function(){
            $('#sortableAttribute').sortable({
                handle: 'button',
                cancel: ''
            }).disableSelection()

            var titleInfo = $("#name");
            titleInfo.blur(function() {
                if( titleInfo.val() == 0 ) {
                    // suchfeld.val("Suche...");
                }else{
                    $.ajax({
                        type: "post",
                        url: "{{asset(url('master-catalogue-exist-check'))}}",
                        data: {
                            "_token": "{{csrf_token()}}",
                            "title": titleInfo.val()
                        },
                        success: function(response){
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

        $(function() {
            $( "#image_preview" ).sortable({
                // connectWith: $('#image_preview'),
                // items: '> li ',
                revert: true,
                update: function(event,ui){
                    sortableArray()
                }
            });
        });

        // function preview_image()
        // {
        //     var h = [];
        //     var total_file=document.getElementById("images").files.length;
        //     var file_name = document.getElementById("images").files;
        //     var temp = '';
        //     for(var i=0;i<total_file;i++)
        //     {
        //         var reader = new FileReader();
        //         var file = file_name[i];
        //         (function(file){
        //             reader.onload = function(event) {
        //             $('#image_preview').append("<span class='pip'><span class='remove drag_drop_remove_btn' onclick=removeImage(this)>&#10060;</span><li><img src='"+event.target.result+"' class='drag_drop_image' id='"+file.name+"'></li><input type='hidden' name='newUploadImage["+file.name+"]' value='"+event.target.result+"'></span>");
        //         }
        //         h.push(file.name);
        //         reader.readAsDataURL(file);
        //         })(file);
        //     }
        //     $('#sortable_image').val(h)
        // }
        // function removeImage(e) {
        //     $(e).parent('.pip').remove();
        //     sortableArray()
        // }

        // function sortableArray() {
        //     var h = [];
        //     $("#image_preview .pip").each(function() {  h.push($(this).find('img').attr('id'));  });
        //     $('#sortable_image').val(h);
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
                $('#counter').text('Add up to 9 more photos');}else if(imageList == 4){$('#counter').text('Add up to 8 more photos');}else if(imageList == 5){$('#counter').text('Add up to 7 more photos');}else if(imageList == 6){$('#counter').text('Add up to 6 more photos');}else if(imageList == 7){$('#counter').text('Add up to 5 more photos');}else if(imageList == 8){$('#counter').text('Add up to 4 more photos');}else if(imageList == 9){$('#counter').text('Add up to 3 more photos');}else if(imageList == 10){$('#counter').text('Add up to 2 more photos');}else if(imageList == 11){$('#counter').text('Add up to 1 more photo');}
            else if(imageList == 12){
                $('#counter').text('Photo limit reached');
            }
            $('#default_counter').text(' (' + imageList + ')');
            $('#modal_counter').text(imageList + (imageList === 1 ? ' image':' images'));

            if(imageList == 1){
                $('.prev, .next, .previous, .then').hide();
            }

            var errorIcon = $('a.image_dimension').length;
            if(errorIcon == 0){
                $('button#addCatalogue').attr('disabled', false);
            }

        }


        function preview_image(profileId){
            var total_file=document.getElementById("uploadImage").files.length;
            var file_name = document.getElementById("uploadImage").files;
            var fileUpload = document.getElementById("uploadImage");
            var imageList = $('ul.ebay-image-wrap li.drag-drop-image').length;
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
                            $('button#addCatalogue').click(function(){
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
                            $('#counter').text('Add up to 9 more photos');}else if(imageList == 4){$('#counter').text('Add up to 8 more photos');}else if(imageList == 5){$('#counter').text('Add up to 7 more photos');}else if(imageList == 6){$('#counter').text('Add up to 6 more photos');}else if(imageList == 7){$('#counter').text('Add up to 5 more photos');}else if(imageList == 8){$('#counter').text('Add up to 4 more photos');}else if(imageList == 9){$('#counter').text('Add up to 3 more photos');}else if(imageList == 10){$('#counter').text('Add up to 2 more photos');}else if(imageList == 11){$('#counter').text('Add up to 1 more photo');}
                        else if(imageList == 12){
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


        // dependency attribute to terms
        // *****
        // function displayForm(elem){
        // if(elem.value == "parent_select") {
        //     document.getElementById('terms_select').style.display = "block";
        //     } else {
        //     document.getElementById('terms_select').style.display = "none";
        //     }
        // }





        // test js here delete after test
        $(document).ready(function () {
            //@naresh action dynamic childs
            var next = 0;
            $("#add-more").click(function(e){
                e.preventDefault();
                var addto = "#field" + next;
                var addRemove = "#field" + (next);
                next = next + 1;
                var newIn = ' <div id="field'+ next +'" name="field'+ next +'"><!-- Text input--><div class="control-group input-group" style="margin-top:10px"><div class="btn-group" style="width:100%;"><button style="width:50%;" type="button" class="btn btn-primary dropdown-toggle form-control" data-toggle="dropdown">  <span class="caret">Select Variation</span></button><button style="width:50%;" type="button" onclick="" class="btn btn-primary form-control float-right" data-toggle="modal" data-target="#addAttModal">Add New Variation</button></div><div class="input-group" style="margin-bottom:10px;"><select id="parentAttSelect" class="form-control select2"><option  value="">- Select -</option><option  value="parent_select">top</option><option value="parent_select">Mustard</option><option value="parent_select">Ketchup</option><option value="parent_select">Relish</option></select></div></div><div id="terms_select"" class="form-group terms_select"><div class="btn-group" style="width:100%;"><button style="width:60%;" type="button" class="btn btn-primary dropdown-toggle form-control" data-toggle="dropdown">  <span class="caret">Select Terms</span></button><button style="width:40%;" type="button" onclick="" class="btn btn-primary form-control float-right" data-toggle="modal" data-target="#addTermModal">Add New Terms </button></div><div class="input-group"></div></div></div>';
                var newInput = $(newIn);
                var removeBtn = '<button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >Remove</button></div></div><div id="field">';
                var removeButton = $(removeBtn);
                $(addto).after(newInput);
                $(addRemove).after(removeButton);
                $("#field" + next).attr('data-source',$(addto).attr('data-source'));
                $("#count").val(next);

                    $('.remove-me').click(function(e){
                        e.preventDefault();
                        var fieldNum = this.id.charAt(this.id.length-1);
                        var fieldID = "#field" + fieldNum;
                        $(this).remove();
                        $(fieldID).remove();
                    });
            });


        });

        $("#parentAttSelect").change(function(){
        if($(this).val()=="parent_select")
        {
            document.getElementById('terms_select').style.display = "block";
        }
            else
            {
                document.getElementById('terms_select').style.display = "none";
            }
        });



    </script>
@endsection
