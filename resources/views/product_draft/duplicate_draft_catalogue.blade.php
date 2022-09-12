@extends('master')

@section('title')
   Catalogue | Active Catalogue | Duplicate Catalogue | WMS360
@endsection


@section('content')

    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.css')}}"  />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script>
        $(function(){
            $(".sortable").sortable({
                cursor: 'move'
            });
            $(".sortable").disableSelection();
        } );
    </script>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Catalogue</li>
                            <li class="breadcrumb-item active" aria-current="page">Duplicate Catalogue</li>
                        </ol>
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


                            <form role="form" class="vendor-form mobile-responsive" action= {{url('product-draft')}} method="post">
                                @csrf

                                <div class="form-group row">
                                    <label for="validationDefault01" class="col-md-2 col-form-label required">Title</label>
                                    <div class="col-md-10">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$product_draft->name}}" maxlength="80" onkeyup="Count();" required autocomplete="name" autofocus>
                                        <span id="display" class="float-right"></span>
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
                                            <button type="button" onclick="addLabel(this,'Add Condition')" class="btn btn-outline-primary form-control add-categorization float-right"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        </div>
                                        <select id="selectCondition" class="form-control select2" name="condition" required>
                                            <option selected="true" disabled="disabled">Select Condition</option>
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
                                                    {{-- <i class="fa fa-close" aria-hidden="true"></i> --}}
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
                                            <button type="button" class="btn btn-primary dropdown-toggle form-control text-left category-child-btn" data-toggle="dropdown">  <span class="caret">Brand</span>
                                            </button>
                                            <button  type="button" onclick="addLabel(this,'Add Brand')" class="btn btn-outline-primary form-control add-categorization" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        </div>
                                        <select id="selectBrand" class="form-control select2" name="brand_id" required>
                                            <option selected="true" disabled="disabled">Select Brand</option>
                                            @isset($brands)
                                                @foreach($brands as $brand)
                                                    <option onclick="optionClick(this)" value="{{$brand->id}}" {{$brand->id == $product_draft->brand_id ? 'selected' : ''}}>{{$brand->name}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>


                                    <div class="col-md-3 col-sm-6 form-group">
                                        <div class="btn-group" style="width:100%;">
                                            <button type="button" class="btn btn-primary dropdown-toggle form-control text-left category-child-btn" data-toggle="dropdown">  <span class="caret">Department</span></button>
                                            <button  type="button" onclick="addLabel(this,'Add Department')" class="btn btn-outline-primary form-control add-categorization"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        </div>
                                        <select id="selectDepartment" class="form-control gender-choose select2" name="gender_id" required>
                                            <option selected="true" disabled="disabled">Select Department</option>
                                            @isset($genders)
                                                @foreach($genders as $gender)
                                                    <option onclick="optionClick(this)" value="{{$gender->id}}" {{$gender->id == $product_draft->gender_id ? 'selected' : ''}}>{{$gender->name}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>

                                    <div class="col-md-3 col-sm-6 form-group">
                                        <div class="btn-group" style="width:100%;">
                                            <button type="button" class="btn btn-primary dropdown-toggle form-control text-left category-child-btn" data-toggle="dropdown">  <span class="caret">WooWMS Category</span></button>
                                            <button type="button" onclick="addLabel(this,'Add Wms Category')" class="btn btn-outline-primary form-control add-categorization"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        </div>
                                        <select id="selectWMSCategory" class="form-control category_select select2" name="category_id" required>
                                            <option selected="true" disabled="disabled">First Select Department</option>
                                            @isset($categories)
                                                @foreach($categories as $category)
                                                    <option onclick="optionClick(this)" value="{{$category->id}}" {{$category->id == $product_draft->woowms_category ? 'selected' : ''}}>{{$category->category_name}}</option>
                                                @endforeach
                                            @endisset
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
                                            @if($product_draft->type == 'variable')
                                            <div class="add-product-type ml-1">
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
                                            @elseif($product_draft->type == 'simple')
                                            <div class="add-product-type ml-1 simple-color">
                                                <div class="pro-type-inner flex-direction-re">
                                                    <div class="type-name">
                                                        Simple Product
                                                    </div>
                                                    <div class="btn-div">
                                                        <span class="switch-btn float-left"></span>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="type" value="simple" id="product-type">
                                            </div>
                                            @endif
                                            <div id="wms-tooltip">
                                                <span id="wms-tooltip-text" class="csv-text">Select product type via toggle button from Variable to Simple or vice versa.</span>
                                                <span><img class="wms-tooltip-image" src="https://www.woowms.com/wms-1004/assets/common-assets/tooltip_button.png"></span>
                                            </div>
                                        </div> 


                                        @if($product_draft->type == 'variable')
                                        <div class="nicescroll variation-attributes-height-controll" style="position:relative">
                                            <div class="row" style="width:100%;">
                                                <div class="col-md-12 m-b-20 all-attribute-container">  
                                                    <div id="sortableAttribute"> 
                                                        @isset($attribute_info)
                                                            @foreach($attribute_info as $key => $value)
                                                                @isset($attribute_terms) 
                                                                    @if(count($attribute_terms) > 0)
                                                                        @foreach($attribute_terms as $attribute_term)
                                                                            @php
                                                                                $at_id = $attribute_term->id;
                                                                                $at_name = $attribute_term->attribute_name;
                                                                            @endphp
                                                                            @if($key == $attribute_term->id)   
                                                                                <div class="input-group m-b-20 attribute_terms_class att_terms_active position-relative" id="attribute-terms-container-{{$attribute_term->id}}">
                                                                                    <input type="hidden" class="hidden-variation" value="{{ $attribute_term->id }}" name="att_name_test[]">
                                                                                    <button class="btn btn-outline-primary vr-minus-btn" type="button" onclick="removeThisVariation(this)"><i class="fa fa-remove" aria-hidden="true"></i></button>
                                                                                    <div class="att-minus-msg dmm" style="display: none;">Click to remove</div>
                                                                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle form-control" data-toggle="dropdown"><span class="caret" data-id="{{$attribute_term->id}}"> {{$attribute_term->attribute_name}} ({{count($attribute_term->attributes_terms)}})</span></button>
                                                                                    <div class="input-group-append">
                                                                                        <button class="btn btn-outline-primary" type="button" onclick="addAttributeModal('attribute_terms',{{$attribute_term->id}})"><i class="fa fa-plus"></i></button>
                                                                                        <input type="hidden" class="hidden-variation" value="{{ $attribute_term->id ?? '' }}">
                                                                                        <div class="att-plus-msg dpm" style="display: none;">Add new variation</div>
                                                                                    </div>
                                                                                    <select class="form-control variation-term-select2" name="terms[{{$attribute_term->id}}][]" id="attribute-terms-option-{{$attribute_term->id}}" multiple="multiple">
                                                                                    @if(count($attribute_term->attributes_terms) > 0)  
                                                                                        @foreach($attribute_term->attributes_terms as $terms)  
                                                                                            <?php
                                                                                            $temp = '';
                                                                                            ?>
                                                                                            @isset($attribute_info[$terms->attribute_id][\App\Attribute::find($terms->attribute_id)->attribute_name])
                                                                                                @if(is_array($attribute_info[$terms->attribute_id][\App\Attribute::find($terms->attribute_id)->attribute_name]))
                                                                                                    @foreach($attribute_info[$terms->attribute_id][\App\Attribute::find($terms->attribute_id)->attribute_name] as $attributes)
                                                                                                        @if($terms->id == $attributes["attribute_term_id"])
                                                                                                            <option value="{{$terms->id ?? ''}}" selected="selected">{{$terms->terms_name ?? ''}}</option>
            
                                                                                                                <?php
                                                                                                                $temp = 1;
                                                                                                                ?>
                                                                                                        @endif
                                                                                                    @endforeach
                                                                                                @endif
                                                                                            @endisset
                                                                                            @if($temp == null)
                                                                                                <option value="{{$terms->id ?? ''}}">{{$terms->terms_name ?? ''}}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    @endif
                                                                                    </select>
                                                                                </div>
                                                                            @endif  
                                                                        @endforeach
                                                                    @endif
                                                                @endisset
                                                            @endforeach 
                                                        @endisset


                                                        @isset($attribute_terms) 
                                                            @if(count($attribute_terms) > 0)
                                                                @foreach($attribute_terms as $attribute_term)
                                                                    @php
                                                                        $at_id = $attribute_term->id;
                                                                        $at_name = $attribute_term->attribute_name;
                                                                    @endphp
                                                                    @if(isset($attribute_info[$at_id][$at_name]))
                                                                                {{--  --}}
                                                                    @else  
                                                                        <div class="input-group m-b-20 attribute_terms_class att_terms_inactive position-relative" id="attribute-terms-container-{{$attribute_term->id}}" style='display:none;'>  
                                                                            <input type="hidden" class="hidden-variation" value="{{ $attribute_term->id }}" name="att_name_test[]">
                                                                            <button class="btn btn-outline-primary vr-minus-btn" type="button" onclick="removeThisVariation(this)"><i class="fa fa-remove" aria-hidden="true"></i></button>
                                                                            <div class="att-minus-msg dmm" style="display: none;">Click to remove</div>
                                                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle form-control" data-toggle="dropdown"><span class="caret" data-id="{{$attribute_term->id}}"> {{$attribute_term->attribute_name}} ({{count($attribute_term->attributes_terms)}})</span></button>
                                                                            <div class="input-group-append">
                                                                                <button class="btn btn-outline-primary" type="button" onclick="addAttributeModal('attribute_terms',{{$attribute_term->id}})"><i class="fa fa-plus"></i></button>
                                                                                <input type="hidden" class="hidden-variation" value="{{ $attribute_term->id ?? '' }}">
                                                                                <div class="att-plus-msg dpm" style="display: none;">Add new variation</div>
                                                                            </div>
                                                                            <select class="form-control variation-term-select2" name="terms[{{$attribute_term->id}}][]" id="attribute-terms-option-{{$attribute_term->id}}" multiple="multiple">
                                                                            @if(count($attribute_term->attributes_terms) > 0)  
                                                                                @foreach($attribute_term->attributes_terms as $terms)  
                                                                                    <?php
                                                                                    $temp = '';
                                                                                    ?>
                                                                                    @isset($attribute_info[$terms->attribute_id][\App\Attribute::find($terms->attribute_id)->attribute_name])
                                                                                        @if(is_array($attribute_info[$terms->attribute_id][\App\Attribute::find($terms->attribute_id)->attribute_name]))
                                                                                            @foreach($attribute_info[$terms->attribute_id][\App\Attribute::find($terms->attribute_id)->attribute_name] as $attributes)
                                                                                                @if($terms->id == $attributes["attribute_term_id"])
                                                                                                    <option value="{{$terms->id ?? ''}}" selected="selected">{{$terms->terms_name ?? ''}}</option>

                                                                                                        <?php
                                                                                                        $temp = 1;
                                                                                                        ?>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        @endif
                                                                                    @endisset
                                                                                    @if($temp == null)
                                                                                        <option value="{{$terms->id ?? ''}}">{{$terms->terms_name ?? ''}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                            </select>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endisset
                                                        

                                                    </div> 
                                                </div>

                                                <div class="col-md-12 addVariation">
                                                    <a onclick="addVariation(this)" class="btn btn-default addVariation cursor-pointer w-100">Add variation</a>
                                                </div>


                                                <div class="add-variation-content col-md-12 col-sm-6">
                                                    <div class="d-flex align-items-center appendVariation dava">
                                                        <a class="btn btn-outline-default variation-remove-btn" onclick="variationRemoveBtn(this)"><i class="fa fa-remove"></i></a>
                                                        <div class="att-minus-msg v-msg d-msg" style="display: none">Click to remove</div>
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
                                                        <button class="btn btn-outline-default select-variation-btn" type="button" onclick="addAttributeModal('attribute','')" style="float:right;"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                        <div class="att-plus-msg vpmsg" style="display: none">Add new variation</div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        @endif


                                        @if($product_draft->type == 'variable')

                                            <div class="draft-wrap variable-input-field">
                                                <div class="tab-input-div mb-3">
                                                    <div class="tab-input-label" style="display: none;">SKU Short Code</div>
                                                    <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control" name="sku_short_code" autocomplete="sku_short_code" value="{{$product_draft->sku_short_code}}" autofocus id="sku_short_code" placeholder="SKU Short Code">
                                                </div>
    
                                                <div class="tab-input-div mb-3">
                                                    <div class="tab-input-label" style="display: none;">Low Quantity</div>
                                                    <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('low_quantity') is-invalid @enderror" name="low_quantity" value="{{$product_draft->low_quantity}}" autocomplete="low_quantity" autofocus id="low_quantity" placeholder="Low Quantity">
                                                    @error('low_quantity')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                        @elseif($product_draft->type == 'simple')

                                            <div class="draft-wrap simple-input-field">
                                                <div class="tab-input-div mb-3">
                                                    <div class="tab-input-label" style="display: none;">Low Quantity</div>
                                                    <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('low_quantity') is-invalid @enderror" name="low_quantity" value="{{$product_draft->low_quantity}}" autocomplete="low_quantity" autofocus id="low_quantity" placeholder="Low Quantity">
                                                    @error('low_quantity')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="tab-input-div mb-3">
                                                    <div class="tab-input-label" style="display: none;">EAN</div>
                                                    <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error("ean_no") is-invalid @enderror" name="ean_no" value="{{$product_variation->ean_no}}" autocomplete="ean_no" autofocus id="ean_no" placeholder="EAN">
                                                    @error("ean_no")
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="tab-input-div mb-3">
                                                    <div class="tab-input-label" style="display: none;">SKU</div>
                                                    <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error("sku") is-invalid @enderror" name="sku" value="{{$product_variation->sku}}" autocomplete="sku" autofocus id="sku" placeholder="SKU">
                                                    @error("sku")
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                            </div>
                                            
                                        @endif

                                    </div>
                                    <!-- test design delelete after test end -->

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
                                                <textarea class="" id="messageArea"  name="description" required autocomplete="description" autofocus>{!! $product_draft->description !!}</textarea>
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
                                            @if (count($tabAttributeInfo->categoryAttribute) > 0)
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
                                                        <div class="tab-input-label" style="display: none;">Regular Price</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('regular_price') is-invalid @enderror" name="regular_price" value="{{$product_draft->regular_price}}" autocomplete="regular_price" autofocus id="regular_price" placeholder="Regular Price">
                                                        @error('regular_price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
    
                                                    <div class="tab-input-div mb-3">
                                                        <div class="tab-input-label" style="display: none;">Sales Price</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('sale_price') is-invalid @enderror" name="sale_price" value="{{$product_draft->sale_price}}" autocomplete="sale_price" autofocus id="sale_price" placeholder="Sales Price">
                                                        @error('sale_price')
                                                        <span class="invalid-feedback" role="alert">
                                                             <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
    
                                                    <div class="tab-input-div mb-3">
                                                        <div class="tab-input-label" style="display: none;">Cost Price</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('cost_price') is-invalid @enderror" name="cost_price" value="{{$product_draft->cost_price}}" autocomplete="cost_price" autofocus id="cost_price" placeholder="Cost Price">
                                                        @error('cost_price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="wms-row">
                                                    <div class="tab-input-div mb-3">
                                                        <div class="tab-input-label" style="display: none;">RRP</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('rrp') is-invalid @enderror" name="rrp" autocomplete="rrp" autofocus id="rrp" placeholder="RRP">
                                                        @error('rrp')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="tab-input-div mb-3">
                                                        <div class="tab-input-label" style="display: none;">Base Price</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('rrp') is-invalid @enderror" name="base_price" autocomplete="base_price" autofocus id="base_price" placeholder="Base Price">
                                                        @error('base_price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="tab-input-div mb-3">
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
                                                        <div class="tab-input-label" style="display: none;">Product Code</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('product_code') is-invalid @enderror" name="product_code" value="{{$product_draft->product_code}}" autocomplete="product_code" autofocus id="product_code" placeholder="Product Code">
                                                        @error('product_code')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
    
                                                    <div class="tab-input-div mb-3">
                                                        <div class="tab-input-label" style="display: none;">Color Code</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('color_code') is-invalid @enderror" name="color_code" value="{{$product_draft->color_code}}" autocomplete="color_code" autofocus id="color_code" placeholder="Color Code">
                                                        @error('color_code')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
    
                                                    <div class="tab-input-div mb-3">
                                                        <div class="tab-input-label" style="display: none;">Color</div>
                                                        <input type="text" onfocusin="inputLabelShow(this)" onfocusout="inputLabelHide(this)" class="form-control @error('color') is-invalid @enderror" name="color" value="{{$product_draft->color}}" autocomplete="color" autofocus id="color" placeholder="Color">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                                                        @php
                                                                            $activeClass = false
                                                                        @endphp
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary draft-add-btn waves-effect waves-light">
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

        $(document).ready(function(){
            if($('input#product-type').val() == 'simple'){
                $('div.addVariation').hide()
            }
            $('div.add-variation-content').hide()
            var dVariation = $('div.att_terms_active').length
            if(dVariation > 0){
                // $('div.variation-attributes-height-controll').css('margin-top', '30px')
                $('div.addVariation').hide()
                var addAnotherVariation = '<div class="col-md-12 addAnotherVariation">'+
                                          '    <button onclick="addAnotherVariation(this)" class="btn btn-default addAnotherVariation cursor-pointer w-100">Add Another variation</button>'+
                                          '</div>'
                $('div.add-variation-content').after(addAnotherVariation)
                $('div#sortableAttribute').css('margin-top', '40px')
            }

            var attr = $('input[name="att_name_test[]"]').length
            // console.log('attr ' + attr)
            if(attr == ''){
                $('a.variation-remove-btn').hide()
            }

            
            $('div.att_terms_active span.caret').each(function(index, element){
                var a = element.innerText.replaceAll("\\d", "")
                var b = a.replace(/ *\([^)]*\) */g, "")
                var variationName = b.replace(/^0+/, '')
                var id = $(this).attr('data-id')
                $('select#selectVariation option').each(function(index, element){
                    var optionName = element.innerText
                    var optionValue = $(this).val()
                    // console.log('optionValue ' + optionValue)
                    if(optionName.trim() == variationName.trim() && optionValue == id){
                        // alert('test ok')
                        $("select#selectVariation option[value='"+id+"']").hide();
                    }
                })
            })
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
                    $("select#selectVariation option[value='"+id+"']").hide();
                    $('div.add-variation-content').hide()
                    var addAnotherVariation = '<div class="col-md-12 addAnotherVariation">'+
                                              '   <button onclick="addAnotherVariation(this)" class="btn btn-default addAnotherVariation cursor-pointer w-100">Add Another variation</button>'+
                                              '</div>'
                    $('div.add-variation-content').after(addAnotherVariation)
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
                $('div.add-variation-content').css('margin-top', '44px')
                $('div.vpmsg').css({'right' : '10px', 'bottom' : '38px'})
            }else{
                $('div.vpmsg').css({'right' : '10px', 'bottom' : '40px'})
                $('div.add-variation-content').css('margin-top', '0px')
            }
        },function(){
            $('div.vpmsg').hide()
        })




        //Select Option
        $('.select2').select2();
        $('select').on('select2:select', function(evt){
            var element = evt.params.data.element
            $element = $(element)
            $element.detach()
            $(this).append($element)
            $(this).trigger('change')
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

        $(function(){
            $('#sortableAttribute').sortable({
                handle: 'button',
                cancel: ''
            }).disableSelection()
        });

        // placeholder label animation




        function Count() {
            var i = document.getElementById("name").value.length;
            document.getElementById("display").innerHTML = 'Character Remain: '+ (80 - i);
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
        })

        $('#sortableAttribute div.all-attribute-container .select2-hidden-accessible').select2({
            placeholder: 'Search for tags',
            // tags: true,
            multiple: true,
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
                console.log(allTags);
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


        function addAttributeModal(isModal, id = ''){
            console.log(isModal, id)
            var html = ''
            if(id == ''){
                var html = '<input type="text" id="attribute_or_term" class="form-control" value="" placeholder="Enter Variation"><p>Use Variation</p><div class="form-check-inline">'
                +'<input type="radio" name="use_variation" class="use_variation form-check-input ml-3" value="1" checked>Yes'
                +'<input type="radio" name="use_variation" class="use_variation form-check-input ml-3" value="0">No'
                +'</div>'
            }else{
                var html = '<input type="text" id="attribute_or_term" class="form-control" value="" placeholder="Enter Variation Terms">'
            }
            //return false
            Swal.fire({
                title: (id == '') ? 'Add New Variation' : 'Add Terms',
                html: html,
                showCancelButton: true,
                confirmButtonText: 'Add',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const attribute = Swal.getPopup().querySelector('#attribute_or_term').value
                    const useVariaton = (id == '') ? Swal.getPopup().querySelector('input[name="use_variation"]:checked').value : ''
                    console.log(attribute, useVariaton)
                    var dataObj = {}
                    if(id == ''){
                        var url = "{{asset('attribute')}}"
                        var dataObj = {
                                attribute_name: attribute,
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
                                terms_name: attribute,
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
                    //return false
                    //return false
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
                    console.log(result)
                    if(result.value.name == 'attribute'){
                        var data = {
                            id: result.value.data.id,
                            text: result.value.data.attribute_name
                        };
                        var newOption = new Option(data.text, data.id, false, false);
                        $('#all_attribute').append(newOption).trigger('change');
                    }else{
                        var data = {
                            id: result.value.data.id,
                            text: result.value.data.terms_name
                        };
                        var attribute_id = result.value.data.attribute_id
                        var newOption = new Option(data.text, data.id, false, false);
                        $('#attribute-terms-option-'+attribute_id).append(newOption).trigger('change');
                    }
                    Swal.fire({
                        title: `${result.value.msg}`,
                        icon: 'success'
                    })
                }
            })
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
                },
                success : function (data){
                    console.log(data.result);
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



    </script>






@endsection
