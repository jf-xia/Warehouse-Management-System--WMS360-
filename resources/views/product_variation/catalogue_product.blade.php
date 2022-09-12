@extends('master')
@section('title')
    Catalogue | Add Product | WMS360
@endsection
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.css')}}"  />
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>

    <script>
         $( function() {
            $( ".sortable" ).sortable({
                cursor: 'move'
            });
            $( ".sortable" ).disableSelection();
        } );
    </script>

    <style>
         .no-img-content{
            background-image: url('{{asset('assets/common-assets/no_image_box.jpg')}}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
    </style>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <div class="wms-breadcrumb">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Active Product</li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Variation</li>
                        </ol>
                    </div>
                    <div class="breadcrumbRightSideBtn">
                        <div id="expandCollapseImageGallaryTab" onclick="CollapseExpandGallery()" class="float-right" style="display: none"><span class="save-image">Save Image</span><span class="review-image d-none">Review Image</span></div>
                        {{-- <a href="{{url('catalogue-product-invoice-receive/'.$product_draft_result->id ?? '')}}"><button class="btn btn-default">Receive Product</button></a> --}}
                    </div>
                </div>


                <div class="card shadow p-4 mt-3" id="variation_cartesian">
                    <!-- <div class="m-b-5">
                        <button type="button" class="btn btn-primary manage-variation-image" data="{{$product_draft_result->id}}">Manage Image</button>
                    </div> -->
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
                    <form id="chargeForm" class="mobile-responsive" role="form" action="{{url('multiple-product-add')}}"  method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_draft_id" id="product-dropdown" value="{{$product_draft_result->id ?? ''}}">
                        <input type="hidden" name="generate_sku_name" id="generate_sku_name" value="{{$product_draft_result->sku_short_code ?? $product_draft_result->id ?? ''}}">
                        {{-- <div class="row">
                            <div class="col-md-6">
                                @if($attribute_info != null && count($attribute_info) > 0)
                                <select class="form-control" id="selectVariation" onchange="selectProductVariation()" name="attribute_variation">
                                    @if($attribute_terms != null && count($attribute_terms) > 0)
                                        <option value="">Select Attribute</option>
                                        @foreach($existAttr as $attr_id => $attr_name)
                                        <option value="{{$attr_id ?? ''}}/{{$attr_name ?? ''}}">{{$attr_name ?? ''}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div id="expandCollapseImageGallaryTab" onclick="CollapseExpandGallery()" class="float-right" style="display: none"><i class="fas fa-arrow-alt-circle-up"></i><i class="fas fa-arrow-alt-circle-down d-none"></i></div>
                            </div>
                        </div> --}}





                        {{-- Variation Tab --}}
                        <div id="variation-photo-sections" class="mt-4">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    {{-- Variation Tab list --}}
                                    <ul id="display-terms-tab">
                                    @if($attribute_info != null && count($attribute_info) > 0)
                                        @foreach($attribute_info as $attribute_id => $attribute_name_array)
                                            @foreach($attribute_name_array as $attribute_name => $attribute_terms_array)
                                                <div class="variation-parent-div">
                                                    <div class="variation-div" id="attribute-terms-container-{{$attribute_id}}" style="display: none">
                                                        <div class="variation-name" style="display: none">{{$attribute_name}}</div>
                                                        @if(count($attribute_terms) > 0)
                                                            @foreach($attribute_terms as $all_terms)
                                                                @if(($all_terms->attribute_name == $attribute_name)  && count($all_terms->attributes_terms) > 0)
                                                                    @if(is_array($attribute_terms_array))
                                                                        @foreach($attribute_terms_array as $attribute_term)
                                                                            @foreach($all_terms->attributes_terms as $terms)
                                                                                @if($terms->terms_name == $attribute_term['attribute_term_name'])
                                                                                <li class="terms-tab kkk" id="terms_name_{{$terms->id ?? ''}}" onclick="singleVariationTab(this, {{$terms->id ?? ''}})">
                                                                                    <div class="terms-tab-inner">
                                                                                        <div id="variation-terms-image-update_{{$terms->id ?? ''}}">{{$terms->terms_name ?? ''}}</div>
                                                                                        <div>(<span id="default_counter{{$terms->id ?? ''}}">0</span>/12 photos)</div>
                                                                                    </div>
                                                                                </li>
                                                                                @endif
                                                                            @endforeach
                                                                        @endforeach
                                                                    @else
                                                                        @foreach($all_terms->attributes_terms as $terms)
                                                                            @if($terms->terms_name == $attribute_terms_array)
                                                                                <li class="terms-tab kkk" id="terms_name_{{$terms->id ?? ''}}" onclick="singleVariationTab(this)">
                                                                                    <div class="terms-tab-inner">
                                                                                        <div id="variation-terms-image-update_{{$terms->id ?? ''}}">{{$terms->terms_name ?? ''}}</div>
                                                                                        <div>(<span id="default_counter{{$terms->id ?? ''}}">0</span>/12 photos)</div>
                                                                                    </div>
                                                                                </li>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endforeach

                                    @else

                                        @if(count($attribute_terms) > 0)
                                            @foreach($attribute_terms as $attribute_term)

                                                @php
                                                    $at_id = $attribute_term->id;
                                                    $at_name = $attribute_term->attribute_name;
                                                @endphp
                                                @if(isset($attribute_info[$at_id][$at_name]))
                                                    <div class="input-group col-md-4 col-sm-6 m-b-20" id="attribute-terms-container-{{$attribute_term->id}}">
                                                @else
                                                    <div class="input-group col-md-4 col-sm-6 m-b-20" id="attribute-terms-container-{{$attribute_term->id}}" style='display:none;'>
                                                @endif
                                                <div class="variation-name" style="display: none">{{$attribute_term->attribute_name}}</div>
                                                    @foreach($attribute_term->attributes_terms as $terms)
                                                            @isset($attribute_info[$terms->attribute_id][\App\Attribute::find($terms->attribute_id)->attribute_name])
                                                                @foreach($attribute_info[$terms->attribute_id][\App\Attribute::find($terms->attribute_id)->attribute_name] as $attributes)
                                                                    @if($terms->id == $attributes["attribute_term_id"])
                                                                    <li class="terms-tab kkk" id="terms_name_{{$terms->id ?? ''}}" onclick="singleVariationTab(this)">
                                                                        <div class="terms-tab-inner">
                                                                            <div id="variation-terms-image-update_{{$terms->id ?? ''}}">{{$terms->terms_name ?? ''}}</div>
                                                                            <div>(<span id="default_counter{{$terms->id ?? ''}}">0</span>/12 photos)</div>
                                                                        </div>
                                                                    </li>
                                                                    @endif
                                                                @endforeach
                                                            @endisset
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        @endif
                                    @endif
                                    </ul>
                                </div>
                                <div class="col-md-9">
                                    {{-- Variation Tab list gallery --}}
                                    <div class="image-gallery-parent-div">
                                    @if($attribute_info != null && count($attribute_info) > 0)
                                        @foreach($attribute_info as $attribute_id => $attribute_name_array)
                                            @foreach($attribute_name_array as $attribute_name => $attribute_terms_array)
                                                <div id="attribute-terms-container-{{$attribute_id}}">
                                                    <div class="image-gallery-under-variation-name" style="display: none">{{$attribute_name}}</div>

                                                      <div> <!--DON'T REMOVE THIS LEFT DIV-->
                                                        @if(count($attribute_terms) > 0)
                                                            @foreach($attribute_terms as $all_terms)
                                                                @if(($all_terms->attribute_name == $attribute_name)  && count($all_terms->attributes_terms) > 0)
                                                                    @if(is_array($attribute_terms_array))
                                                                        @foreach($attribute_terms_array as $attribute_term)
                                                                            @foreach($all_terms->attributes_terms as $terms)
                                                                                @if($terms->terms_name == $attribute_term['attribute_term_name'])
                                                                                <div id="terms_name_gallery{{$terms->id ?? ''}}" class="terms_name_gallery" style="display: none">
                                                                                    <div id="counter{{$terms->id ?? ''}}"></div>
                                                                                    <div class="row pl-2">
                                                                                        <div class="col-md-6 main-lf-image-content manage-variation-imglf-content">
                                                                                            <div class="main_image_show" id="main-lf-image-content_{{$terms->id ?? ''}}">
                                                                                                <span class="prev" id="prev-{{$terms->id ?? ''}}" onclick="prevPrevious(this, {{$terms->id ?? ''}})" style="display: none">Prev</span>
                                                                                                <div class="md-trigger gallery-trigger-preview" id="gallery-trigger-preview-{{$terms->id ?? ''}}" style="display: none">Click to enlarge</div>
                                                                                                <div class="showimagediv variationImageDiv" id="showimagediv{{$terms->id ?? ''}}">
                                                                                                @if(isset($attributeTermImageArray[$terms->terms_name]) && count($attributeTermImageArray) > 0)
                                                                                                    <img src="{{asset('/').$attributeTermImageArray[$terms->terms_name][0] ?? ''}}" class="fullImage">
                                                                                                @endif
                                                                                                </div>
                                                                                                <span class="next" id="next-{{$terms->id ?? ''}}" onclick="nextThen(this, {{$terms->id ?? ''}})" style="display: none">Next</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6 master-pro-img" style="padding:0;" id="imageProId_{{$terms->id ?? ''}}">
                                                                                            <ul class="d-flex flex-wrap sortable ebay-image-wrap variation-image-wrap" id="sortableImageDiv{{$terms->id ?? ''}}">
                                                                                                @if(isset($attributeTermImageArray[$terms->terms_name]) && count($attributeTermImageArray) > 0)
                                                                                                    @foreach ($attributeTermImageArray[$terms->terms_name] as $imgArr)
                                                                                                        <li class="drag-drop-image" id="drag-drop-image{{$terms->id ?? ''}}">
                                                                                                            <a class="cross-icon bg-white border-0 btn-outline-light" onclick="removeLi(this, {{$terms->id ?? ''}})">❌</a>
                                                                                                            <input type="hidden" id="image" name="image[{{$terms->id ?? ''}}][]" value="{{$imgArr}}">
                                                                                                            <span class="main_photo"></span>
                                                                                                            <img class="drag_drop_image" onclick="clickToShowDefaultImg(this, {{$terms->id ?? ''}})" id="drag_drop_image{{$terms->id ?? ''}}" src="{{asset('/').$imgArr}}">
                                                                                                        </li>
                                                                                                    @endforeach
                                                                                                    @for ($i = 0; $i < (12 - count($attributeTermImageArray[$terms->terms_name])); $i++)
                                                                                                        <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                            <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                            <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="">
                                                                                                            <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                        </div>
                                                                                                    @endfor
                                                                                                @else
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                @endif
                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>

                                                                                    <!-- Master product image preview fullscreen modal-->
                                                                                    <div class="md-modal md-effect-12">
                                                                                        <div class="md-modal-content">
                                                                                            <div style="color: #fff;font-size: 20px;margin-bottom: 10px;margin-left: 10px;" id="modal_counter{{$terms->id ?? ''}}"></div>
                                                                                            <span class="previous before" onclick="prevPrevious(this, {{$terms->id ?? ''}})">Prev</span>
                                                                                                <div class="md-content">
                                                                                                    <div>
                                                                                                        <span class="md-close float-right text-danger"></span>
                                                                                                    </div>
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-12">

                                                                                                            <div class="showimagediv" id="showImageDiv{{$terms->id ?? ''}}"></div>

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            <span class="then after" onclick="nextThen(this, {{$terms->id ?? ''}})">Next</span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="md-overlay"></div>
                                                                                    <!--End master product image preview fullscreen -->
                                                                                </div>
                                                                                @endif
                                                                            @endforeach
                                                                        @endforeach
                                                                        @else
                                                                            @foreach($all_terms->attributes_terms as $terms)
                                                                                @if($terms->terms_name == $attribute_terms_array)
                                                                                <div id="terms_name_gallery{{$terms->id ?? ''}}" class="terms_name_gallery" style="display: none">
                                                                                    <div id="counter{{$terms->id ?? ''}}"></div>
                                                                                    <div class="row pl-2">
                                                                                        <div class="col-md-6 main-lf-image-content">
                                                                                            <div class="main_image_show" id="main-lf-image-content_{{$terms->id ?? ''}}">
                                                                                                <span class="prev" id="prev-{{$terms->id ?? ''}}" onclick="prevPrevious(this, {{$terms->id ?? ''}})" style="display: none">Prev</span>
                                                                                                <div class="md-trigger gallery-trigger-preview" id="gallery-trigger-preview-{{$terms->id ?? ''}}" style="display: none">Click to enlarge</div>
                                                                                                <div class="showimagediv variationImageDiv" id="showimagediv{{$terms->id ?? ''}}">
                                                                                                @if(isset($attributeTermImageArray[$terms->terms_name]) && count($attributeTermImageArray) > 0)
                                                                                                    <img src="{{asset('/').$attributeTermImageArray[$terms->terms_name][0] ?? ''}}" class="fullImage">
                                                                                                @endif
                                                                                                </div>
                                                                                                <span class="next" id="next-{{$terms->id ?? ''}}" onclick="nextThen(this, {{$terms->id ?? ''}})" style="display: none">Next</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6 master-pro-img" style="padding:0;" id="imageProId_{{$terms->id ?? ''}}">
                                                                                            <ul class="d-flex flex-wrap sortable ebay-image-wrap variation-image-wrap" id="sortableImageDiv{{$terms->id ?? ''}}">
                                                                                                @if(isset($attributeTermImageArray[$terms->terms_name]) && count($attributeTermImageArray) > 0)
                                                                                                    @foreach ($attributeTermImageArray[$terms->terms_name] as $imgArr)
                                                                                                        <li class="drag-drop-image" id="drag-drop-image{{$terms->id ?? ''}}">
                                                                                                            <a class="cross-icon bg-white border-0 btn-outline-light" onclick="removeLi(this, {{$terms->id ?? ''}})">❌</a>
                                                                                                            <input type="hidden" id="image" name="image[{{$terms->id ?? ''}}][]" value="{{$imgArr}}">
                                                                                                            <span class="main_photo"></span>
                                                                                                            <img class="drag_drop_image" onclick="clickToShowDefaultImg(this, {{$terms->id ?? ''}})" id="drag_drop_image1530" src="{{asset('/').$imgArr}}">
                                                                                                        </li>
                                                                                                    @endforeach
                                                                                                    @for ($i = 0; $i < (12 - count($attributeTermImageArray[$terms->terms_name])); $i++)
                                                                                                        <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                            <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                            <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="">
                                                                                                            <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                        </div>
                                                                                                    @endfor
                                                                                                @else
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                                @endif
                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>

                                                                                    <!-- Master product image preview fullscreen modal-->
                                                                                    <div class="md-modal md-effect-12">
                                                                                        <div class="md-modal-content">
                                                                                            <div style="color: #fff;font-size: 20px;margin-bottom: 10px;margin-left: 10px;" id="modal_counter{{$terms->id ?? ''}}"></div>
                                                                                            <span class="previous before" onclick="prevPrevious(this, {{$terms->id ?? ''}})">Prev</span>
                                                                                                <div class="md-content">
                                                                                                    <div>
                                                                                                        <span class="md-close float-right text-danger"></span>
                                                                                                    </div>
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-12">

                                                                                                            <div class="showimagediv" id="showimagediv{{$terms->id ?? ''}}"></div>

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            <span class="then after" onclick="nextThen(this, {{$terms->id ?? ''}})">Next</span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="md-overlay"></div>
                                                                                    <!--End master product image preview fullscreen -->
                                                                                </div>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                      </div>
                                                </div>
                                            @endforeach
                                        @endforeach

                                    @else

                                        @if(count($attribute_terms) > 0)
                                            @foreach($attribute_terms as $attribute_term)

                                                @php
                                                    $at_id = $attribute_term->id;
                                                    $at_name = $attribute_term->attribute_name;
                                                @endphp
                                                @if(isset($attribute_info[$at_id][$at_name]))
                                                    <div id="attribute-terms-container-{{$attribute_term->id}}">
                                                @else
                                                    <div id="attribute-terms-container-{{$attribute_term->id}}" style='display:none;'>
                                                @endif

                                                    <div class="image-gallery-under-variation-name" style="display: none">{{$attribute_term->attribute_name}}</div>

                                                      <div> <!--DON'T REMOVE THIS LEFT DIV-->
                                                        @foreach($attribute_term->attributes_terms as $terms)
                                                                @isset($attribute_info[$terms->attribute_id][\App\Attribute::find($terms->attribute_id)->attribute_name])
                                                                    @foreach($attribute_info[$terms->attribute_id][\App\Attribute::find($terms->attribute_id)->attribute_name] as $attributes)
                                                                        @if($terms->id == $attributes["attribute_term_id"])
                                                                        <div id="terms_name_gallery{{$terms->id ?? ''}}" class="terms_name_gallery" style="display: none">
                                                                            <div id="counter{{$terms->id ?? ''}}"></div>
                                                                            <div class="row pl-2">
                                                                                <div class="col-md-6 main-lf-image-content">
                                                                                    <div class="main_image_show" id="main-lf-image-content_{{$terms->id ?? ''}}">
                                                                                        <span class="prev" id="prev-{{$terms->id ?? ''}}" onclick="prevPrevious(this, {{$terms->id ?? ''}})" style="display: none">Prev</span>
                                                                                        <div class="md-trigger gallery-trigger-preview" id="gallery-trigger-preview-{{$terms->id ?? ''}}" style="display: none">Click to enlarge</div>
                                                                                        <div class="showimagediv variationImageDiv" id="showimagediv{{$terms->id ?? ''}}">
                                                                                            @if(isset($attributeTermImageArray[$terms->terms_name]) && count($attributeTermImageArray) > 0)
                                                                                                <img src="{{asset('/').$attributeTermImageArray[$terms->terms_name][0] ?? ''}}" class="fullImage">
                                                                                            @endif
                                                                                        </div>
                                                                                        <span class="next" id="next-{{$terms->id ?? ''}}" onclick="nextThen(this, {{$terms->id ?? ''}})" style="display: none">Next</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6 master-pro-img" style="padding:0;" id="imageProId_{{$terms->id ?? ''}}">
                                                                                    <ul class="d-flex flex-wrap sortable ebay-image-wrap variation-image-wrap" id="sortableImageDiv{{$terms->id ?? ''}}">
                                                                                        @if(isset($attributeTermImageArray[$terms->terms_name]) && count($attributeTermImageArray) > 0)
                                                                                            @foreach ($attributeTermImageArray[$terms->terms_name] as $imgArr)
                                                                                                <li class="drag-drop-image" id="drag-drop-image{{$terms->id ?? ''}}">
                                                                                                    <a class="cross-icon bg-white border-0 btn-outline-light" onclick="removeLi(this, {{$terms->id ?? ''}})">❌</a>
                                                                                                    <input type="hidden" id="image" name="image[{{$terms->id ?? ''}}][]" value="{{$imgArr}}">
                                                                                                    <span class="main_photo"></span>
                                                                                                    <img class="drag_drop_image" onclick="clickToShowDefaultImg(this, {{$terms->id ?? ''}})" id="drag_drop_image1530" src="{{asset('/').$imgArr}}">
                                                                                                </li>
                                                                                            @endforeach
                                                                                            @for ($i = 0; $i < (12 - count($attributeTermImageArray[$terms->terms_name])); $i++)
                                                                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                                    <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                                    <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="">
                                                                                                    <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                                </div>
                                                                                            @endfor
                                                                                        @else
                                                                                        <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                            <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                            <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="">
                                                                                            <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                        </div>
                                                                                        <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                            <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                            <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                            <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                        </div>
                                                                                        <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                            <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                            <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                            <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                        </div>
                                                                                        <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                            <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                            <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                            <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                        </div>
                                                                                        <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                            <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                            <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                            <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                        </div>
                                                                                        <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                            <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                            <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                            <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                        </div>
                                                                                        <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                            <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                            <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                            <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                        </div>
                                                                                        <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                            <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                            <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                            <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                        </div>
                                                                                        <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                            <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                            <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                            <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                        </div>
                                                                                        <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                            <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                            <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                            <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                        </div>
                                                                                        <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                            <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                            <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                            <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                        </div>
                                                                                        <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$terms->id ?? ''}}">
                                                                                            <p class="inner-add-sign" id="innerAddSign{{$terms->id ?? ''}}">+</p>
                                                                                            <input type="file" title=" " name="uploadImage[{{$terms->id ?? ''}}][]" id="uploadImage{{$terms->id ?? ''}}" class="form-control ebay-image-upload" accept="/image" onchange="preview_image({{$terms->id ?? ''}});" multiple="" disabled="">
                                                                                            <p class="inner-add-photo" id="innerAddPhoto{{$terms->id ?? ''}}">Add Photos</p>
                                                                                        </div>
                                                                                        @endif
                                                                                    </ul>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Master product image preview fullscreen modal-->
                                                                            <div class="md-modal md-effect-12">
                                                                                <div class="md-modal-content">
                                                                                    <div style="color: #fff;font-size: 20px;margin-bottom: 10px;margin-left: 10px;" id="modal_counter{{$terms->id ?? ''}}"></div>
                                                                                    <span class="previous before" onclick="prevPrevious(this, {{$terms->id ?? ''}})">Prev</span>
                                                                                        <div class="md-content">
                                                                                            <div>
                                                                                                <span class="md-close float-right text-danger"></span>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-md-12">

                                                                                                    <div class="showimagediv" id="showimagediv{{$terms->id ?? ''}}"></div>

                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    <span class="then after" onclick="nextThen(this, {{$terms->id ?? ''}})">Next</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="md-overlay"></div>
                                                                            <!--End master product image preview fullscreen -->
                                                                        </div>
                                                                        @endif
                                                                    @endforeach
                                                                @endisset
                                                        @endforeach
                                                        </div>
                                                    </div>
                                            @endforeach
                                        @endif
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Bulk Generate Section --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="product-bulk-edit-section">
                                    <div class="bulk-price-edit">
                                        <div class="mr-2 mb-xs-5">
                                            <button type="button" class="btn product-bulk-edit-btn" id="regularPriceBtn" onclick="addLabel(this,'Change Regular Price')">Change Regular Price</button>
                                        </div>
                                        <div class="mr-2 mb-xs-5">
                                            <button type="button" class="btn product-bulk-edit-btn" id="salesPriceBtn" onclick="addLabel(this,'Change Sales Price')">Change Sales Price</button>
                                        </div>
                                        <div class="mr-2 ">
                                            <button type="button" class="btn product-bulk-edit-btn" id="rrpBtn" onclick="addLabel(this,'Change RRP')">Change RRP</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="product-bulk-edit-section mt-2">
                                    <div class="bulk-price-edit">
                                        <div class="mr-2">
                                            <button type="button" class="btn product-bulk-edit-btn" id="basePriceBtn" onclick="addLabel(this,'Change Base Price')">Change Base Price</button>
                                        </div>
                                        <div class="mr-2 mb-xs-5">
                                            <button type="button" class="btn product-bulk-edit-btn" id="costPriceBtn" onclick="addLabel(this,'Change Cost Price')">Change Cost Price</button>
                                        </div>
                                        <div class="mr-2">
                                            <button type="button" class="btn product-bulk-edit-btn"  id="availableQtyBtn" onclick="addLabel(this,'Change Low Qty')">Change Low Qty</button>
                                        </div>
                                        {{-- <div class="mr-2 mb-xs-5">
                                            <button type="button" class="btn product-bulk-edit-btn" id="colorCodeBtn" onclick="addLabel(this,'Change Color Code')">Change Colour Code</button>
                                        </div> --}}
                                    </div>
                                    <div>
                                        <button type="button" class="btn product-bulk-edit-btn" id="addVariationBtn" onclick="addVariationImage()">Add Variation Image</button>
                                        @if($attribute_info != null && count($attribute_info) > 0)
                                        <select class="form-control selectVariationProduct" id="selectVariation" onchange="selectProductVariation()" name="attribute_variation" style="display: none">
                                            @if($attribute_terms != null && count($attribute_terms) > 0)
                                                <option value="">Select Variation</option>
                                                @foreach($existAttr as $attr_id => $attr_name)
                                                <option value="{{$attr_id ?? ''}}/{{$attr_name ?? ''}}">{{$attr_name ?? ''}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!--Bulk Edit Modal-->
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
                                        <input type="text" id="value" class="p-1 category-focus text-center">
                                        <div class="change-sku">
                                            <input type="text" class="selected-terms-text form-control text-center">
                                        </div>
                                    </div>
                                    <div class="cat-modal-footer">
                                        <div class="trash-div" onclick="trashClick(this)">Cancel</div>
                                        <div class="cat-add">
                                            <button type="button" onclick="addValue(this)" class="btn btn-default category-subBtn mb-3"> Save </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End Bulk Edit Modal-->

                            <div class="col-md-12 mt-2 mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="v-select-and-b-generate">
                                        <span class="d-flex align-items-center mb-xs-5">
                                            <input type="button" v-on:click="selectAllSet" name="select_all_variation" style="cursor: pointer" class="btn btn-outline-primary add-all-combination" value="Add All Combination">
                                        </span>
                                        <span class="float-left ml-2 ml-xs-0 mb-xs-5">
                                            <button type="button" class="btn btn-outline-primary bulk-generate-sku">Bulk Generate SKU</button>
                                        </span>
                                        <div class="ml-2 ml-xs-0 changeSKU">
                                            <button type="button" class="btn btn-outline-primary" id="sku" onclick="addLabel(this,'Change SKU')">Change SKU</button>
                                        </div>
                                    </div>
                                    <div class="terms-addCombination-wrap">
                                        <div id="addTerms" class="btn btn-outline-primary mb-xs-5" onclick="addTermsToCatalog()">Add Terms</div>
                                        <div id="addCombination" class="btn btn-outline-primary ml-2" onclick="addCombination()">Add Combination</div>
                                        <select id="combination" class="form-control after-remove-variation-select-combination" onchange="variationSelectCombination(this.value)" style="display: none">
                                            <option>Select Combination</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                        </div>

                        {{-- @{{ cartesian_attributes }} --}}
                        {{-- @{{ combination_attributes }} --}}
                        {{-- @{{ only_combination_array }} --}}
                        {{-- @{{ product_variation_combination_attribute_array }} --}}

                        <div class="add-pro-table-sec table-responsive">
                            <table class="product-draft-table row-expand-table add-pro-table w-100">
                                <thead>
                                    <tr>
                                        <th style="text-align: center!important;width:5%"><input type="checkbox" class="selectAllVariation" v-on:click='checkAllVariation()'></th>
                                        <th class="variation" style="text-align: center!important;width:10%">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                    <div class="filter-btn" onclick="filterBtn()">
                                                        <i class="fa" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="filter-variation-sec d-none">
                                                        <p class="filter-var-para">Filter Variation</p>
                                                        @if(isset($attribute_array))
                                                            <select class="form-control b-r-0" id="variation-filter" v-on:change="variationFilter($event)" v-model="key">
                                                            {{-- <select class="form-control" id="variation-filter" onchange="variationFilter(this)"> --}}
                                                                <option value="">Select Variation</option>
                                                                @foreach($attribute_array as $color_key => $value)
                                                                    @foreach($value as $key => $value)
                                                                        <option value="{{$value['id'] ?? ''}}">{!! \App\Attribute::findOrFail($color_key)->attribute_name ?? '' !!} -> {{$value['name'] ?? ''}}</option>
                                                                    @endforeach
                                                                @endforeach
                                                                <option value="all">Display all combination</option>
                                                            </select>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div>Variation</div>
                                            </div>
                                        </th>
                                        <th class="image" style="text-align: center!important;width:6%">Image</th>
                                        <th class="sku" style="text-align: center!important;width:10%">
                                            <div>SKU<span class="ml-1" style="color: red">*</span></div>
                                        </th>
                                        <th class="ean" style="text-align: center!important;width:15%">EAN</th>
                                        <th class="regular-price" style="text-align: center!important;width:8%">
                                            <div>Regular Price<span class="ml-1" style="color: red">*</span></div>
                                        </th>
                                        <th class="sale-price" style="text-align: center!important;width:8%">
                                            <div>Sale Price<span class="ml-1" style="color: red">*</span></div>
                                        </th>
                                        <th class="rrp" style="text-align: center!important;width:8%">RRP</th>
                                        <th class="base-price" style="text-align: center!important;width:8%">Base Price</th>
                                        <th class="cost-price" style="text-align: center!important;width:8%">Cost Price</th>
                                        {{-- <th class="product-code text-center">Product Code</th> --}}
                                        {{-- <th class="color-code" style="text-align: center!important;width:8%">Colour Code</th> --}}
                                        <th class="low-qty" style="text-align: center!important;width:10%">Low Qty</th>
                                        @if (Session::get('woocommerce') == 1)
                                        <th class="description" style="text-align: center!important;width:10%">Description</th>
                                        @endif
                                        <th class="action" style="text-align: center!important;width:5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody v-if="variationAll">


                                </tbody>
                            </table>
                        </div>

                        {{-- <div></div> --}}

                        <div class="form-group row vendor-btn-top">
                            <div class="col-md-12 text-center active-catalogue-add-product">
                                <span class="add-pro-btn-span" onclick="photoError()">
                                    <button type="button" v-on:click="submitForm"  class="btn btn-primary vendor-btn add-pro-btn waves-effect waves-light">
                                        <b> Send </b>
                                    </button>
                                </span>
                            </div>
                        </div> <!--form-group end-->

                    </form>
                </div><!--End card-->


                {{-- Add terms to catalog modal --}}
                <div class="category-modal add-terms-catalog" style="display: none">
                    <div class="cat-header add-terms-catalog-header">
                        <div>
                            <label id="label_name" class="cat-label">Add Terms to Catalogue</label>
                        </div>
                        <div class="cursor-pointer" onclick="trashClick(this)">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="cat-body add-terms-catalog-body pt-3">
                        <form role="form" class="mobile-responsive" action= {{url('save-additional-terms-draft')}} method="post">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="low_quantity" class="col-md-form-label required mb-1">Catalogue ID</label>
                                    <input type="text" class="form-control" name="product_draft_id" value="{{$id ? $id : old('product_draft_id')}}" id="product_draft_id" placeholder="" required readonly>
                                </div>
                            </div>
                            <div class="row form-group select_variation_att">
                                <div class="col-md-10">
                                    <p class="font-18 required_attributes"> Select variation from below attributes </p>
                                </div>
                            </div>
                            <!-- <div class="form-group product-desn-top">

                                <div class=""> -->
                                    <!-- test here start -->
                                    <!-- <div class="nicescroll"> -->
                                        <div class="row" id="sortableAttribute">
                                            <div class="input-group col-md-12 col-sm-12 m-b-20 all-attribute-container">
                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle form-control" data-toggle="dropdown">  <span class="caret">Variation</span>
                                                </button>
                                                <!-- <div class="input-group-append">
                                                    <button class="btn btn-outline-info" type="button" onclick="addAttributeModal('attribute','')"><i class="fa fa-plus"></i></button>
                                                </div> -->

                                                @if($attribute_info != null && count($attribute_info) > 0)
                                                <select class="form-control select2 select2-hidden-accessible" id="" multiple @if($productVariationExist) disabled @endif>

                                                        @if($attribute_terms != null && count($attribute_terms) > 0)
                                                            <option value="">Select Attribute</option>
                                                            @foreach($existAttr as $attr_id => $attr_name)
                                                                <option value="{{$attr_id ?? ''}}" selected="selected">{{$attr_name ?? ''}}</option>
                                                            @endforeach
                                                            @if(!$productVariationExist)
                                                                @foreach($attribute_terms as $attribute)
                                                                    @if(!isset($existAttr[$attribute->id]))
                                                                        <option value="{{$attribute->id ?? ''}}">{{$attribute->attribute_name ?? ''}}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            <!-- @foreach($attribute_terms as $attribute)
                                                                @php
                                                                    $temp = null;
                                                                @endphp
                                                                @foreach($attribute_info as $attribute_id => $attribute_name_array)
                                                                    @foreach($attribute_name_array as $attribute_name => $attribute_terms_array)
                                                                        @if($attribute_id == $attribute->id)
                                                                            <option value="{{$attribute_id ?? ''}}" selected="selected">{{$attribute_name ?? ''}}</option>
                                                                            @php
                                                                                $temp = 1;
                                                                            @endphp
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                                @if($temp == null)
                                                                    <option value="{{$attribute->id ?? ''}}">{{$attribute->attribute_name ?? ''}}</option>
                                                                @endif
                                                            @endforeach -->

                                                            <!-- @foreach($attribute_terms as $attribute)
                                                                @php
                                                                    $temp = null;
                                                                @endphp
                                                                @foreach($attribute_info as $attribute_id => $attribute_name_array)
                                                                    @foreach($attribute_name_array as $attribute_name => $attribute_terms_array)
                                                                        @if($attribute_id == $attribute->id)
                                                                            <option value="{{$attribute->id ?? ''}}" selected>{{$attribute->attribute_name ?? ''}}</option>
                                                                            @php
                                                                                $temp = 1;
                                                                            @endphp
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                                @if($temp == null)
                                                                    <option value="{{$attribute->id ?? ''}}">{{$attribute->attribute_name ?? ''}}</option>
                                                                @endif
                                                            @endforeach -->
                                                        @endif

                                                @else
                                                <select class="form-control select2 select2-hidden-accessible" id="" multiple>
                                                    @if($attribute_terms != null && count($attribute_terms) > 0)
                                                        <option value="">Select Attribute</option>
                                                        @foreach($attribute_terms as $attribute)
                                                            <option value="{{$attribute->id ?? ''}}">{{$attribute->attribute_name ?? ''}}</option>
                                                        @endforeach
                                                    @endif
                                                @endif
                                                </select>
                                            </div>
                                        @if($attribute_info != null && count($attribute_info) > 0)

                                            @foreach($attribute_info as $attribute_id => $attribute_name_array)
                                                @foreach($attribute_name_array as $attribute_name => $attribute_terms_array)

                                                    <div class="input-group col-md-12 m-b-20" id="attribute-terms-container-{{$attribute_id}}">
                                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle form-control" data-toggle="dropdown">
                                                            <span class="caret"> {{$attribute_name}}</span>
                                                        </button>
                                                        <select class="form-control select2" name="terms[{{$attribute_id}}][]" id="attribute-terms-option-{{$attribute_id}}" multiple="multiple">
                                                            @if(count($attribute_terms) > 0)
                                                                @foreach($attribute_terms as $all_terms)
                                                                    @if(($all_terms->attribute_name == $attribute_name)  && count($all_terms->attributes_terms) > 0)
                                                                        @if(is_array($attribute_terms_array))
                                                                            @foreach($attribute_terms_array as $attribute_term)
                                                                                @foreach($all_terms->attributes_terms as $terms)
                                                                                    @if($terms->terms_name == $attribute_term['attribute_term_name'])
                                                                                        <option value="{{$terms->id ?? ''}}" selected="selected">{{$terms->terms_name ?? ''}}</option>
                                                                                    @else
                                                                                        <option value="{{$terms->id ?? ''}}">{{$terms->terms_name ?? ''}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endforeach
                                                                            @else
                                                                                @foreach($all_terms->attributes_terms as $terms)
                                                                                    @if($terms->terms_name == $attribute_terms_array)
                                                                                        <option value="{{$terms->id ?? ''}}" selected="selected">{{$terms->terms_name ?? ''}}</option>
                                                                                    @else
                                                                                        <option value="{{$terms->id ?? ''}}">{{$terms->terms_name ?? ''}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                @endforeach
                                            @endforeach


                                            @if(count($attribute_terms) > 0)
                                                @foreach($attribute_terms as $all_terms)
                                                    @if(!isset($existAttr[$all_terms->id]))
                                                    <div class="input-group col-md-12 m-b-20" id="attribute-terms-container-{{$all_terms->id}}" style='display:none;'>
                                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle form-control" data-toggle="dropdown">
                                                            <span class="caret"> {{$all_terms->attribute_name}}</span>
                                                        </button>
                                                        <select class="form-control select2" name="terms[{{$all_terms->id}}][]" id="attribute-terms-option-{{$all_terms->id}}" multiple="multiple">

                                                            @foreach($all_terms->attributes_terms as $terms)

                                                                    <option value="{{$terms->id ?? ''}}">{{$terms->terms_name ?? ''}}</option>

                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            @endif


                                        @else
                                            @if(count($attribute_terms) > 0)
                                                @foreach($attribute_terms as $attribute_term)

                                                    @php
                                                        $at_id = $attribute_term->id;
                                                        $at_name = $attribute_term->attribute_name;
                                                    @endphp
                                                    @if(isset($attribute_info[$at_id][$at_name]))
                                                        <div class="input-group col-md-12 m-b-20" id="attribute-terms-container-{{$attribute_term->id}}">
                                                    @else
                                                        <div class="input-group col-md-12 m-b-20" id="attribute-terms-container-{{$attribute_term->id}}" style='display:none;'>
                                                    @endif
                                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle form-control" data-toggle="dropdown">  <span class="caret"> {{$attribute_term->attribute_name}} ({{count($attribute_term->attributes_terms)}})</span>
                                                            </button>
                                                            <!-- <div class="input-group-append">
                                                                <button class="btn btn-outline-primary" type="button" onclick="addAttributeModal('attribute_terms',{{$attribute_term->id}})"><i class="fa fa-plus"></i></button>
                                                            </div> -->
                                                            <select class="form-control select2" name="terms[{{$attribute_term->id}}][]" id="attribute-terms-option-{{$attribute_term->id}}" multiple="multiple">

                                                                    @foreach($attribute_term->attributes_terms as $terms)
                                                                        <?php
                                                                            $temp = '';
                                                                            ?>
                                                                            @isset($attribute_info[$terms->attribute_id][\App\Attribute::find($terms->attribute_id)->attribute_name])
                                                                                @foreach($attribute_info[$terms->attribute_id][\App\Attribute::find($terms->attribute_id)->attribute_name] as $attributes)
                                                                                    @if($terms->id == $attributes["attribute_term_id"])
                                                                                        <option value="{{$terms->id ?? ''}}" selected="selected">{{$terms->terms_name ?? ''}}</option>

                                                                                            <?php
                                                                                            $temp = 1;
                                                                                            ?>
                                                                                    @endif
                                                                            @endforeach
                                                                            @endisset
                                                                                @if($temp == null)
                                                                                    <option value="{{$terms->id ?? ''}}">{{$terms->terms_name ?? ''}}</option>
                                                                                @endif
                                                                        @endforeach
                                                            </select>
                                                        </div>
                                                @endforeach
                                            @endif
                                        @endif
                                        </div>
                                        <!-- test here end -->

                                    <!-- @if(count($attribute_terms) > 0)
                                            @foreach($attribute_terms as $attribute_term)
                                                @if(!empty( $attribute_term->attributes_terms ))
                                                    <div class="button-group col-md-3 col-sm-6 m-b-20">
                                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle m-r-5 form-control" data-toggle="dropdown">  <span class="caret"> {{$attribute_term->attribute_name ?? ''}} ({{count($attribute_term->attributes_terms)}})</span>
                                                        </button>
                                                        <select class="form-control select2" name="terms[{{$attribute_term->id}}][]" multiple="multiple">
                                                            @foreach($attribute_term->attributes_terms as $terms)
                                                                <?php
                                                                $temp = '';
                                                                ?>
                                                                @isset($product_attribute[$terms->attribute_id][\App\Attribute::find($terms->attribute_id)->attribute_name])
                                                                    @foreach($product_attribute[$terms->attribute_id][\App\Attribute::find($terms->attribute_id)->attribute_name] as $attributes)
                                                                        @if($terms->id == $attributes["attribute_term_id"])
                                                                            <option value="{{$terms->id ?? ''}}" selected="selected">{{$terms->terms_name ?? ''}}</option>
                                                                            <h1>{{$terms->terms_name ?? ''}}</h1>
                                                                                <?php
                                                                                $temp = 1;
                                                                                ?>
                                                                        @endif
                                                                @endforeach
                                                                @endisset
                                                                    @if($temp == null)
                                                                        <option value="{{$terms->id ?? ''}}">{{$terms->terms_name ?? ''}}</option>
                                                                    @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif

                                            @endforeach
                                        @endif -->

                                    <!-- </div>
                                </div>
                            </div> -->
                            <div class="form-group row py-3">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary draft-pro-btn waves-effect waves-light termsCatalogueBtn">
                                        <b> Add </b>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div> <!--container fluid end-->
        </div> <!-- content -->
    </div>  <!-- content page -->


    <script>
        var app = new Vue({
            el: '#variation_cartesian',
            data: {
                selectAll: true,
                variationAll:false,
                cartesian_attributes: {!! json_encode($cartesian_attributes) !!},
                combination_attributes: {!! json_encode($combination_attribute_array) !!},
                only_combination_array: {!! json_encode($only_combination_array) !!},
                product_variation_combination_attribute_arrays: {!! json_encode($product_variation_combination_attribute_array) !!},
                new_combination_attributes: {!! json_encode($new_combination_attributes) !!},
                key: ''

            },
            created(){
                // console.log(this.only_combination_array)
                // console.log(this.combination_attributes)
                // console.log(this.product_variation_combination_attribute_arrays)
                // console.log(this.combination_attributes)
                let combination = ''
                this.only_combination_array.forEach(function(item, index, array){
                    var index = {{ $totlaExistCount }} + index
                    var newIndex = index
                    // alert(newIndex)
                    combination += $('select.after-remove-variation-select-combination').append('<option value="'+newIndex+'">'+item+'</option>') + "<br>"
                });
                // alert(this.product_variation_combination_attribute_arrays.length)
                if(this.product_variation_combination_attribute_arrays.length > 0){
                    $('form#chargeForm').prepend('<input type="hidden" id="updateImage" name="update_image" value="0">')
                }

            },
            methods: {
                selectAllSet: function(){
                    if(this.selectAll == true){
                        let trMnoClass = $('tr.mno').length
                        if(trMnoClass > 0){
                            Swal.fire({
                                    icon: 'error',
                                    title: 'Oops... Please reload this page then click select all variation button!'
                                })
                            return false
                        }else{
                            this.selectAll = false;
                            this.variationAll = true;
                            $('select.after-remove-variation-select-combination option:gt(0)').remove()
                            let combination = $('select.after-remove-variation-select-combination')
                            let existSelectCombination = $('select.after-remove-variation-select-combination').length
                            if(existSelectCombination != ''){
                                combination.hide()
                            }
                            document.getElementById('addCombination').style.display = 'block'
                            let newVariationCombination = ''
                            let trOnloadMno = $('tbody tr.onloadMno').length
                            // alert(trOnloadMno)
                            if(this.new_combination_attributes != ''){
                                if(trOnloadMno > 0){
                                    // alert('trOnloadMno >0 '+trOnloadMno)
                                    // $('table').append('<tbody></tbody>')
                                    this.new_combination_attributes.forEach(function(item, index, array){
                                        // console.log(item)
                                        // newVariationCombination += $('tbody').append(item)
                                        newVariationCombination += $('tbody').prepend(item)
                                    })

                                    $('div#addCombination').hide()

                                    return false
                                }
                                if(trOnloadMno == 0){
                                    // alert('trOnloadMno < 0 '+trOnloadMno)
                                    $('table').append('<tbody></tbody>')
                                    this.new_combination_attributes.forEach(function(item, index, array){
                                        // console.log(item)
                                        newVariationCombination += $('table').append(item)
                                    })

                                    $('div#addCombination').hide()

                                }

                            }
                        }


                    }else if(this.selectAll == false){
                        let combination = ''
                        this.only_combination_array.forEach(function(item, index, array){
                            combination += $('select.after-remove-variation-select-combination').append('<option value="'+index+'">'+item+'</option>') + "<br>"
                        })
                        $('div.changeSKU').hide()
                        this.selectAll = true;
                        this.variationAll = false;
                        $('tbody').remove()
                        let variationCombination = ''
                        if(this.product_variation_combination_attribute_arrays != ''){
                            $('table').append('<tbody></tbody>')
                            this.product_variation_combination_attribute_arrays.forEach(function(item, index, array){
                                // console.log(item)
                                variationCombination += $('tbody').append(item) + "<br>"
                            });
                        }
                        $('div#addCombination').show()
                    }
                },

                checkAllVariation: function(){
                    $('tbody').find('tr:visible input.selectVariation').prop('checked', $('input.selectAllVariation').prop('checked'))
                },
                updateCheckAllVariation: function(){
                    if(!$('.selectVariation').prop("checked")) {
                       $(".selectAllVariation").prop("checked", false);
                    }
                },
                addDescription: function(index){
                    $('div#categoryModal'+index).show()
                    $('a#addDescription'+index).addClass('add-description-click-color')
                    $('tr#cardId'+index).css('background-color', '#cdcdcd')
                },
                trashClick: function(index){
                    $('div#categoryModal'+index).hide()
                    $('a#addDescription'+index).removeClass('add-description-click-color')
                    $('tr#cardId'+index).css('background-color', 'inherit')
                },
                saveDescription: function(index){
                    $('div#categoryModal'+index).hide()
                    $('tr#cardId'+index).css('background-color', 'inherit')
                    $('a#addDescription'+index).removeClass('add-description-click-color')
                },
                variationFilter: function(event){
                    // console.log(event)
                    $('div.category-modal').hide()
                    var variationId = event.target.value
                    $('input.selectAllVariation, input.selectVariation').prop('checked', false)
                    $('tbody tr').hide()
                    if(event.target.value == 'all'){$('tbody tr').removeAttr('style')}
                    $('tbody tr select option').each(function(k, elem){
                        var attributeId = elem.value
                        if(variationId == attributeId){
                            $(elem).closest('tr').removeAttr('style')
                            $(elem).closest('tr:visible').find('input.selectVariation').prop('checked', true)
                        }
                    })
                },
                preventDefault: function (index) {

                    var sku = document.getElementById('sku'+index).value;
                    if (sku == ''){
                        generate_sku_from_vue(index);
                    }
                    var temp_length = this.cartesian_attributes.length - 1;
                    console.log()
                    var value = document.getElementById('ean_no'+index).value;
                    var counter = 0;
                    this.cartesian_attributes.forEach(function(item,indexOfEan){
                        if(document.getElementById('ean_no'+indexOfEan).value == ''){
                            counter++;
                        }
                    });
                    if (counter < 1 && document.getElementById('ean_no'+temp_length).value != '' && value.length == 13){
                        document.getElementById("chargeForm").submit();
                    }else {

                    }
                },
                submitForm : function () {
                    var attribute = $('#ebayImageAttribute').val()
                    var isCommonImageChecked = $('input[name="common_attribute_image"]').is(':checked')
                    if(isCommonImageChecked == true && document.getElementById("common_image").files.length == 0){
                        alert('Please upload a common image for all variation')
                        return false
                    }

                    var uploadImageArr = []
                    $('form div.single-variaiton-image-div input.variation-image').each(function(){
                        let isUploadImage = document.getElementById($(this).attr('id')).files.length
                        if(isUploadImage != 0){
                            uploadImageArr.push(isUploadImage)
                        }
                    })
                    if(uploadImageArr.length > 0){
                            if(attribute == ''){
                            alert('Please select attribute')
                            return false
                        }
                    }
                    // var temp_length = this.cartesian_attributes.length - 1;
                    var temp_length = $('tbody tr').length;
                    var regularPriceCount = 0;
                    var salePriceCount = 0;
                    var counter = 0;
                    if(this.variationAll){
                        // this.cartesian_attributes.forEach(function (item,index) {
                        $('tbody tr').each(function (item,content) {
                            var index = $(this).attr('id').replace(/[^0-9.]/g, "")
                            if(document.getElementById('sku'+index).value != ''){
                                counter++;
                            }
                            if(document.getElementById('regular_price'+index).value != ''){
                                regularPriceCount++
                            }
                            if(document.getElementById('sale_price'+index).value != ''){
                                salePriceCount++
                            }
                        })


                        if(counter == temp_length && regularPriceCount == temp_length && salePriceCount == temp_length){
                            document.getElementById("chargeForm").submit();
                        }else{
                            if(counter != temp_length){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Please fill in the required fields that are currently empty.'
                                })
                            }
                            if(regularPriceCount != temp_length){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Please fill in the required fields that are currently empty.'
                                })
                            }
                            if(salePriceCount != temp_length){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Please fill in the required fields that are currently empty.'
                                })
                            }
                        }

                    }else {

                        $('tbody tr').each(function (item,content) {
                            var index = $(this).attr('id').replace(/[^0-9.]/g, "")
                            if(document.getElementById('sku'+index).value != ''){
                                counter++;
                            }
                            if(document.getElementById('regular_price'+index).value != ''){
                                regularPriceCount++
                            }
                            if(document.getElementById('sale_price'+index).value != ''){
                                salePriceCount++
                            }
                        })


                        if(counter == temp_length && regularPriceCount == temp_length && salePriceCount == temp_length){
                            document.getElementById("chargeForm").submit();
                        }else{
                            if(counter != temp_length){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Please fill in the required fields that are currently empty.'
                                })
                            }
                            if(regularPriceCount != temp_length){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Please fill in the required fields that are currently empty.'
                                })
                            }
                            if(salePriceCount != temp_length){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Please fill in the required fields that are currently empty.'
                                })
                            }
                        }

                        $('.form-control-sku_class-individual').each(function(i, obj) {
                            console.log(obj)
                            if(obj.value != ''){
                                counter++;
                            }
                        });
                        if(counter == $('.form-control-sku_class-individual').length){
                            document.getElementById("chargeForm").submit();
                        }
                    }
                }
            }
        })
    </script>



    <script type="text/javascript">

        // $(document).ready(function(){
        //     $('div.note-editor').remove()
        // })

        $('.select2').select2();

        function preventDefault(e,index){
            var cartesian_attributes = {!! json_encode($cartesian_attributes) !!}
            var sku = document.getElementById('sku'+index).value;
            if (sku == ''){
                generate_sku_from_vue(index);
            }
            var temp_length = cartesian_attributes.length - 1;
            var value = document.getElementById('ean_no'+index).value;
            // console.log(value);
            var counter = 0;
            cartesian_attributes.forEach(function(item,indexOfEan){
                if($('#ean_no'+indexOfEan).val() == ''){
                    counter++;
                }
            });
            if (counter < 1 && document.getElementById('ean_no'+index).value != '' && value.length == 13){
                document.getElementById("chargeForm").submit();
            }else {

            }

            var old_value = $(e).attr('oldvalue')
            var get_changed_value = $(e).val()
            if(old_value != get_changed_value){
                $(e).closest('tr').find('td input.created-product').val(1)
            }

        }



        // $(document).ready(function() {
        function generate_sku_from_vue(id) {
            var card_id = id;
            var attribute = $('#product-dropdown').val();
            $('.form-control-attribute'+card_id).each(function(i, obj) {
                if ( attribute == ''){
                    attribute = $('#'+obj.id + ' '+ 'option:selected').html().split(' ').join('_');
                }else{
                    attribute = attribute + '_' + $('#'+obj.id + ' '+ 'option:selected').html().split(' ').join('_');
                }
            });
            attribute = attribute.replace(/_\s*$/, "");
            document.getElementById("sku" + card_id).value = attribute;
        }
        function generate_sku(e) {
            var button_id = e.id;
            var result = button_id.split('buttonid');
            var card_id = parseInt(result[1]);
            var attribute = $('#generate_sku_name').val();
            $('.form-control-attribute'+card_id).each(function(i, obj) {
                if ( attribute == ''){
                    attribute = $('#'+obj.id + ' '+ 'option:selected').html().split(' ').join('_');
                }else{
                    attribute = attribute + '_' + $('#'+obj.id + ' '+ 'option:selected').html().split(' ').join('_');
                 }
            });
            attribute = attribute.replace(/_\s*$/, "");
            document.getElementById("sku" + card_id).value = attribute;
        }

        // <!-- summernote--->
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

            // $('div.changeSKU').hide()

            $('.bulk-generate-sku').click(function(){
                var tr = $('tbody tr').length
                if(tr > 0){
                    $('div.changeSKU').show()
                }else{
                    $('div.changeSKU').hide()
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops... No variation found!'
                    })
                }
                $('table.product-draft-table .tr-variation').each(function(k, content){
                    // console.log(content)
                    var divCardId = content.id
                    var result = divCardId.split('cardId');
                    var card_id = parseInt(result[1]);
                    var attribute = $('#generate_sku_name').val();
                    $('.form-control-attribute'+card_id).each(function(i, obj) {
                        // console.log(obj)
                        if ( attribute == ''){
                            attribute = $('#'+obj.id + ' '+ 'option:selected').html().split(' ').join('_');
                        }else{
                            attribute = attribute + '_' + $('#'+obj.id + ' '+ 'option:selected').html().split(' ').join('_');
                        }
                    });
                    attribute = attribute.replace(/_\s*$/, "");
                    // console.log('attribute ' + attribute)
                    if(document.getElementById("sku" + card_id).value == ''){
                        document.getElementById("sku" + card_id).value = attribute;
                    }

                })

                // return false
                var skuArr = []
                $('table.product-draft-table tr:visible input.form-control-sku_class').each(function(){
                    // console.log(this.value)
                    skuArr.push($(this).val())
                })
                // console.log('skuArr ' + skuArr)

                $.ajax({
                    type: "POST",
                    url: "{{asset('manage-variation-sku-validation')}}",
                    data: {
                        _token: "{{csrf_token()}}",
                        sku: skuArr,
                        multiple_sku_validation: 'multiple_sku_validation'
                    },
                    success: function(response){
                        // console.log(response.sku_array)
                        response.sku_array.forEach(function(item, index, arr){
                            // console.log(item)
                            var response_sku_value = item
                            $('table.product-draft-table tr:visible input.form-control-sku_class').each(function(i, elem){
                                // console.log(elem.value)
                                var generate_sku_value = elem.value
                                if(response_sku_value == generate_sku_value){
                                    // console.log('ok')
                                    $(elem).css('border-color', 'red').next('span').addClass('sku-validation-message').text(response_sku_value + ' is already exist!!')
                                    $('button.add-pro-btn').attr('disabled', 'disabled')
                                }
                            })
                        })
                    }
                })

            })


            // $('select#ebayImageAttribute').change(function(){
            //     let attributeValue = $(this).val()
            //     if(attributeValue == ''){
            //         $('input[name="common_attribute_image"]').prop('checked', false)
            //         $('.common-attribute-image-toggle').hide('slow')
            //     }else{
            //         $('.common-attribute-image-toggle').show('slow')
            //     }
            // })
        });

        // function readURL(input,id) {
        //     if (input.files && input.files[0]) {
        //         var reader = new FileReader();

        //         reader.onload = function(e) {
        //             $('#blah'+id).attr('src', e.target.result);
        //         }

        //         reader.readAsDataURL(input.files[0]);
        //     }
        // }
        // function preview_image(input)
        // {
        //     let id = $(input).attr('id').split('variation-image')[1]
        //     if (input.files && input.files[0]) {
        //         var reader = new FileReader();
        //         $('#variation-image-append-'+id).show()
        //         reader.onload = function(e) {
        //             $('#variation-image-append-'+id).attr('src', e.target.result);
        //         }

        //         reader.readAsDataURL(input.files[0]);
        //     }
        // }

        function inputFocusInValue(e){
            $(e).attr('oldValue', $(e).val())
        }

        function inputKeyUpValue(e){
            var old_value = $(e).attr('oldvalue')
            var get_changed_value = $(e).val()
            if(old_value != get_changed_value){
                $(e).closest('tr').find('td input.created-product').val(1)
            }
            // else{
            //     $(e).closest('tr').find('td input.created-product').val(0)
            // }
        }

        function nospaces(t){
            if(t.value.match(/\s/g)){
                t.value=t.value.replace(/\s/g,'');
            }
            var old_value = $(t).attr('oldvalue')
            var get_changed_value = $(t).val()
            if(old_value != get_changed_value){
                $(t).closest('tr').find('td input.created-product').val(1)
                $.ajax({
                    type: "POST",
                    url: "{{asset('manage-variation-sku-validation')}}",
                    data: {
                        _token: "{{csrf_token()}}",
                        sku: get_changed_value
                    },
                    success: function(response){
                        // console.log(response.sku)
                        if(response.sku == get_changed_value){
                            $(t).css('border-color', 'red').next('span').addClass('sku-validation-message').text(response.sku + ' is already exist!!').show()
                            $('button.add-pro-btn').attr('disabled', 'disabled')
                        }
                    }
                })

                $(t).css('border-color', '#cccccc').next('span').removeClass('sku-validation-message').hide()
                var validation_message = $('span.sku-validation-message').length
                // console.log(validation_message)
                if(validation_message == 0){
                    $('button.add-pro-btn').removeAttr('disabled')
                }
            }
        }


        function addDescription(index){
            $('div.note-editor').remove()
            $('div.cat-input-div textarea').show()
            $('div#categoryModal'+index).show()
            $('a#addDescription'+index).addClass('add-description-click-color')
            $('tr#cardId'+index).css('background-color', '#cdcdcd')
        }

        function hideModal(index){
            $('div#categoryModal'+index).hide()
            $('a#addDescription'+index).removeClass('add-description-click-color')
            $('tr#cardId'+index).css('background-color', 'inherit')
        }

        function saveDescription(index){
            $('div#categoryModal'+index).hide()
            $('a#addDescription'+index).removeClass('add-description-click-color')
            $('tr#cardId'+index).css('background-color', 'inherit')
        }

        $(document).ready(function(){
            var combination = $('select#combination option').length
            if(combination > 1){
                $('div#addCombination').show()
                $('input.add-all-combination').show()
                $('button.bulk-generate-sku').parent('span').addClass('ml-2')
            }else{
                $('div#addCombination').hide()
                $('input.add-all-combination').hide()
                $('button.bulk-generate-sku').parent('span').removeClass('ml-2')
            }
        })


        $(document).ready(function(){
            var variationCombination = ''
            var product_variation_combination_attribute_arrays = {!! json_encode($product_variation_combination_attribute_array) !!}
            if(product_variation_combination_attribute_arrays != ''){
                $('table').append('<tbody></tbody>')
                product_variation_combination_attribute_arrays.forEach(function(item, index, array){
                    variationCombination += $('tbody').append(item) + "<br>"
                });
            }else{
                $('div.changeSKU').hide()
            }
            $('input.form-control-sku_class').each(function(i,content){
                // console.log(content)
                if(content.value != ''){
                    $('div.changeSKU').show()
                }else{
                    $('div.changeSKU').hide()
                }
            })
        })

        var combination_attributes = {!! json_encode($combination_attribute_array) !!}
        var removeVariationArr = []
        function removeVariation(e){
            var tbody = $('tbody').length
            if(tbody > 1){
                $('tbody:first').remove()
            }
            $('div#addCombination').show()
            var combination = $('select.after-remove-variation-select-combination')
            var existSelectCombination = $('select.after-remove-variation-select-combination').length
            if(existSelectCombination != ''){
                combination.hide()
            }
            var trId = $(e).closest('tr').attr('id')
            var trId = trId.replace(/[^0-9.]/g, "")

            // console.log('trId ' + trId)
            var mnoClass = $('tr.mno').length
            var onloadMnoClass = $('tr.onloadMno').length
            if(mnoClass > 0 || onloadMnoClass > 0) {
                var getVariation = $(e).closest('tr').find('td.variation').text().split('                                                                  ').join(':')
                // var getVariation = $(e).closest('tr').find('td.variation').text().split(' ').join(':')
            }else{
                var getVariation = $(e).closest('tr').find('td.variation').text().split(' ').join(':')
                // var getVariation = $(e).closest('tr').find('td.variation').text().split('                                                  ').join(':')
            }

            combination.append('<option value="'+trId+'">'+getVariation+'</option>')

            removeVariationArr[trId] = $(e).closest('tr')[0].outerHTML

            $(e).closest('tr').remove()

            delete combination_attributes[trId]

            // console.log(removeVariationArr)
            // console.log(combination_attributes)
        }

        $('div#addCombination').hide()
        function addCombination(){
            $('div#addCombination').hide()
            $('select.after-remove-variation-select-combination').show()
            $('select.after-remove-variation-select-combination').css('margin-left','10px')
        }


        function variationSelectCombination(value){
            var selectedVal = value
            // alert(selectedVal)
            // console.log(combination_attributes)
            $('select.after-remove-variation-select-combination option[value="'+selectedVal+'"]').remove()
            // $('tr#cardId'+selectedVal).removeClass('d-none')
            var option = $('select.after-remove-variation-select-combination option').length
            if(option == 1){
                $('select.after-remove-variation-select-combination').hide()
                $('div#addCombination').show()
            }
            // console.log(removeVariationArr)
            var mnoClass = $('tr.mno').length
            // alert('mnoClass ='+mnoClass)
            var onloadMnoClass = $('tr.onloadMno').length

            // console.log('combination_attributes = '+combination_attributes)
            // console.log('removeVariationArr = '+removeVariationArr)

            if(combination_attributes[selectedVal]){
                console.log('combinationArr')
                if(mnoClass > 0 || onloadMnoClass > 0){
                    $('tbody').prepend(combination_attributes[selectedVal])
                    $('input.add-all-combination').hide()
                    $('button.bulk-generate-sku').parent('span').removeClass('ml-2')
                }else{
                    $('table').append('<tbody></tbody>').append(combination_attributes[selectedVal])
                    $('input.add-all-combination').hide()
                    $('button.bulk-generate-sku').parent('span').removeClass('ml-2')
                }
            }

            if(removeVariationArr[selectedVal]){
                console.log('removeArr')
                if(mnoClass > 0 || onloadMnoClass > 0){
                    $('tbody').prepend(removeVariationArr[selectedVal])
                }else{
                    $('table').append('<tbody></tbody>').append(combination_attributes[selectedVal])
                }
            }

            var attribute = $('#generate_sku_name').val();
            $('.form-control-attribute'+selectedVal).each(function(i, obj) {
                if ( attribute == ''){
                    attribute = $('#'+obj.id + ' '+ 'option:selected').html().split(' ').join('_');
                }else{
                    attribute = attribute + '_' + $('#'+obj.id + ' '+ 'option:selected').html().split(' ').join('_');
                }
            });
            attribute = attribute.replace(/_\s*$/, "");
            document.getElementById("sku" + selectedVal).value = attribute;

        }

        async function fetchData(url) {
            return fetch(url)
            .then(response => {
                return response.json();
            })
            .then(data => {
                return data;
            })
            .catch(error => {
                console.log(error)
            })
        }

        async function addLabel(e,name){
            if(name == 'Change SKU') {
                var catalogueId = $('#product_draft_id').val()
                var url = "{{asset('check-catalogue-exist-in-channel')}}"+"/onbuy/"+catalogueId
                var result = await fetchData(url)
                if(!result.success) {
                    var productLink = "{{asset('onbuy/master-product-list?is_search=true&woo_catalogue_id=')}}"+catalogueId
                    var html = '<p>At first delete product from OnBuy then relist with new sku otherwise sku will not update</p><a href="'+productLink+'" target="_blank">Go to this product</a>'
                    Swal.fire(
                        {
                            title: 'This product exist on OnBuy',
                            icon: 'error',
                            html: html,

                        }
                    )
                    return false
                }
            }
            $("#label_name").text(name);
            $("#value").val('');
            $('div.category-modal').show()
            $('div.change-sku').hide()
            $('div.add-terms-catalog').hide()
            $('input#value').show()
            var selectVariation = $('table tbody tr td :checkbox:checked').length
            if(name == 'Change Regular Price'){
                var tr = $('tbody tr').length
                if(tr > 0){
                    if(selectVariation == ''){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops... Select at least 1 checkbox to change the Regular Price!',
                        })
                        $('div.category-modal').hide()
                    }
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops... No variation found!'
                    })
                    $('div.category-modal').hide()
                }
            }else if(name == 'Change Sales Price'){
                var tr = $('tbody tr').length
                if(tr > 0){
                    if(selectVariation == ''){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops... Select at least 1 checkbox to change the Sales Price!',
                        })
                        $('div.category-modal').hide()
                    }
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops... No variation found!'
                    })
                    $('div.category-modal').hide()
                }

            }else if(name == 'Change Cost Price'){
                var tr = $('tbody tr').length
                if(tr > 0){
                    if(selectVariation == ''){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops... Select at least 1 checkbox to change the Cost Price!',
                        })
                        $('div.category-modal').hide()
                    }
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops... No variation found!'
                    })
                    $('div.category-modal').hide()
                }
            }else if(name == 'Change Low Qty'){
                var tr = $('tbody tr').length
                if(tr > 0){
                    if(selectVariation == ''){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops... Select at least 1 checkbox to change the Low Qty!',
                        })
                        $('div.category-modal').hide()
                    }
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops... No variation found!'
                    })
                    $('div.category-modal').hide()
                }
            }else if(name == 'Change RRP'){
                var tr = $('tbody tr').length
                if(tr > 0){
                    if(selectVariation == ''){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops... Select at least 1 checkbox to change the RRP!',
                        })
                        $('div.category-modal').hide()
                    }
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops... No variation found!'
                    })
                    $('div.category-modal').hide()
                }
            }else if(name == 'Change Base Price'){
                var tr = $('tbody tr').length
                if(tr > 0){
                    if(selectVariation == ''){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops... Select at least 1 checkbox to change the Base Price!',
                        })
                        $('div.category-modal').hide()
                    }
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops... No variation found!'
                    })
                    $('div.category-modal').hide()
                }
            }else if(name == 'Change Color Code'){
                var tr = $('tbody tr').length
                if(tr > 0){
                    if(selectVariation == ''){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops... Select at least 1 checkbox to change the Color Code!',
                        })
                        $('div.category-modal').hide()
                    }
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops... No variation found!'
                    })
                    $('div.category-modal').hide()
                }
            }else if(name == 'Change SKU'){
                var optionText = $('#variation-filter option:selected').text()
                var optionValue = $('#variation-filter option:selected').val()
                // console.log('optionValue ' + optionValue)
                if(optionValue == ''){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops... Select at least 1 combination to change the SKU!',
                    })
                    $('div.category-modal').hide()
                }
                else if(selectVariation == ''){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops... Select at least 1 checkbox to change the SKU!',
                    })
                    $('div.category-modal').hide()
                }
                else{
                    $('input#value').hide()
                    $('div.change-sku').show()
                    var selectedTermsText = optionText.split('->')[1]
                    // console.log('optionText ' + optionText)
                    $('input.selected-terms-text').val(selectedTermsText)
                }

                if(optionValue == 'all'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops... Except display all combination! Select at least 1 combination to change the SKU!',
                    })
                    $('div.category-modal').hide()
                }
            }
        }

        function addValue(e){
            var value = $('input#value').val()
            var labelName = $('#label_name').text()
            var selectVariation = $('table tbody tr td :checkbox:checked').length
            if(labelName == 'Change Regular Price'){
                $('table tbody tr td :checkbox:checked').each(function(k, e){
                    $(e).closest('tr').find('input.regular-price').val(value)
                    $(e).closest('tr').find('input.created-product').val(1)
                })
            }
            else if(labelName == 'Change Sales Price'){
                $('table tbody tr td :checkbox:checked').each(function(k, e){
                    $(e).closest('tr').find('input.sale-price').val(value)
                    $(e).closest('tr').find('input.created-product').val(1)
                })
            }
            else if(labelName == 'Change Cost Price'){
                $('table tbody tr td :checkbox:checked').each(function(k, e){
                    $(e).closest('tr').find('input.cost-price').val(value)
                    $(e).closest('tr').find('input.created-product').val(1)
                })
            }
            else if(labelName == 'Change Low Qty'){
                $('table tbody tr td :checkbox:checked').each(function(k, e){
                    $(e).closest('tr').find('input.low-qty').val(value)
                    $(e).closest('tr').find('input.created-product').val(1)
                })
            }
            else if(labelName == 'Change RRP'){
                $('table tbody tr td :checkbox:checked').each(function(k, e){
                    $(e).closest('tr').find('input.rrp').val(value)
                    $(e).closest('tr').find('input.created-product').val(1)
                })
            }
            else if(labelName == 'Change Base Price'){
                $('table tbody tr td :checkbox:checked').each(function(k, e){
                    $(e).closest('tr').find('input.base-price').val(value)
                    $(e).closest('tr').find('input.created-product').val(1)
                })
            }
            else if(labelName == 'Change Color Code'){
                $('table tbody tr td :checkbox:checked').each(function(k, e){
                    $(e).closest('tr').find('input.color-code').val(value)
                    $(e).closest('tr').find('input.created-product').val(1)
                })
            }
            else if(labelName == 'Change SKU'){
                $('table tbody tr td :checkbox:checked').each(function(k, e){
                    var className = $(e).closest('tr').find('select').attr('class')
                    // console.log('className ' + className)
                    var id = className.replace(/[^0-9.]/g, "")
                    // console.log('id ' + id)
                    var master_sku = $('#generate_sku_name').val()
                    $(e).closest('tr').find('td select.form-control-attribute'+id).each(function(key, elem){
                        // console.log(elem.id)
                        var filterOptionValue = $('#variation-filter option:selected').val()
                        // console.log('filterOptionValue ' + filterOptionValue)
                        var optionValue = $(elem).val()
                        // console.log('optionValue ' + optionValue)
                        var selectedTextInSkuField = $('input.selected-terms-text').val()
                        var selectedTextInSkuField =  selectedTextInSkuField.replace(/ /g,'');
                        if(filterOptionValue == optionValue){
                            // alert('ok')
                            $(elem).find('option').text(selectedTextInSkuField)
                        }
                        if(master_sku == ''){
                            master_sku = $('#'+elem.id + ' '+ 'option:selected').html().split(' ').join('_')
                        }else{
                            master_sku = master_sku + '_' + $('#'+elem.id + ' '+ 'option:selected').html().split(' ').join('_')
                            // console.log('master_sku ' + master_sku)
                        }
                        master_sku = master_sku.replace(/_\s*$/, "");
                        // console.log('master_sku ' + master_sku)
                        document.getElementById("sku" + id).value = master_sku;
                        // $('input.form-control-sku_class').val(master_sku)
                    })

                })



                var skuArr = []
                $('table.product-draft-table tr:visible input.form-control-sku_class').each(function(){
                    // console.log(this.value)
                    skuArr.push($(this).val())
                })
                // console.log('skuArr ' + skuArr)

                $.ajax({
                    type: "POST",
                    url: "{{asset('manage-variation-sku-validation')}}",
                    data: {
                        _token: "{{csrf_token()}}",
                        sku: skuArr,
                        multiple_sku_validation: 'multiple_sku_validation'
                    },
                    success: function(response){
                        // console.log(response.sku_array)
                        response.sku_array.forEach(function(item, index, arr){
                            // console.log(item)
                            var response_sku_value = item
                            $('table.product-draft-table tr:visible input.form-control-sku_class').each(function(i, elem){
                                // console.log(elem.value)
                                var generate_sku_value = elem.value
                                if(response_sku_value == generate_sku_value){
                                    // console.log('ok')
                                    $(elem).css('border-color', 'red').next('span').addClass('sku-validation-message').text(response_sku_value + ' is already exist!!')
                                    $('button.add-pro-btn').attr('disabled', 'disabled')
                                }
                            })
                        })
                    }
                })



            }

            $('div.category-modal').hide()

        }

        function trashClick(e){
            $(e).closest('div.category-modal').hide()
        }

        // function variationFilter(e){
            // $('div.category-modal').hide()
            // var variationId = $(e).val()
            // $('input.selectAllVariation, input.selectVariation').prop('checked', false)
            // $('tbody tr').hide()
            // if(e.value == 'all'){$('tbody tr').removeAttr('style')}
            // $('tbody tr select option').each(function(k, elem){
            //     var attributeId = elem.value
            //     if(variationId == attributeId){
            //         $(elem).closest('tr').removeAttr('style')
            //         $('tbody').find('tr:visible input.selectVariation').prop('checked', $('input.selectAllVariation').prop('checked'))
            //         console.log($('tbody').find('tr:visible input.selectVariation').prop('checked', $('input.selectAllVariation').prop('checked')))
            //     }
            // })
        // }


        function addTermsToCatalog(){
            $('div.add-terms-catalog').show()
        }

        function addVariationImage(){
            // console.log('variation')
            $('button#addVariationBtn').hide()
            $('select#selectVariation').show()
        }

        function filterBtn(){
            $('div.filter-variation-sec').removeClass('d-none')
            $('th.variation').addClass('filter-bg')
        }

        $(document).mouseup(function(e){
            var container = $("div.filter-variation-sec");
            if(!container.is(e.target) && container.has(e.target).length === 0) {
                container.addClass('d-none')
                $('th.variation').removeClass('filter-bg')
            }
        });

        $(window).scroll(function(){
            var scroll = $(window).scrollTop()
            if(scroll >= 150){
                $('div.add-pro-table-sec').addClass('add-pro-table-height')
            }
        })


        //Modal button variation terms adding spining btn
        $('button.termsCatalogueBtn').click(function(){
            $(this).html(
                `<span class="mr-2"><i class="fa fa-spinner fa-spin"></i></span>Variation adding`
            );
            $(this).addClass('changeCatalogBTnCss');
        })


        function CollapseExpandGallery(){
            $('div#variation-photo-sections').toggleClass('d-none')
            $('div#expandCollapseImageGallaryTab span.save-image').toggleClass('d-none')
            $('div#expandCollapseImageGallaryTab span.review-image').toggleClass('d-none')
            // $('i.fa-arrow-alt-circle-up').toggleClass('d-none')
            // $('i.fa-arrow-alt-circle-down').toggleClass('d-none')
            // var text = $('div#expandCollapseImageGallaryTab').text()
            // $('div#expandCollapseImageGallaryTab').text(text == "-" ? "+" : "-")
        }

        function singleVariationTab(e, id){
            // console.log('id = '+ id)
            $(e).addClass('terms-active-li').siblings('li.terms-tab').removeClass('terms-active-li')
            $('div.terms_name_gallery').hide()
            $('div#terms_name_gallery'+id).show()


            $('div#addPhotosContent'+id).first().on('click', function(){
                if($(this).is(':first-child')) {
                    $('#btn-text'+id).closest('div').find('input').removeAttr('id');
                }
            })

            $('div.addPhotoBtnDiv').on('click', function(){
                $('#btn-text'+id).closest('div').find('input').attr('id','uploadImage'+id);
            })

            var notexistfirstDefaultImage = $('<div class="img-upload-main-content">'+
                    '<div class="img-content-wrap">'+
                        '<div class="addPhotoBtnDiv addProductGlry">'+
                            '<p class="btn-text" id="btn-text'+id+'">Add Photos</p>'+
                            '<input type="file" title=" " name="uploadImage['+id+'][]" id="uploadImage'+id+'" class="form-control" accept="/image" onchange="preview_image('+id+');" multiple>'+
                        '</div>'+
                        '<p class="photo-req-txt">Add up to 12 photos. We do not allow photos with extra borders, text or artwork.</p>'+
                    '</div>'+
                '</div>');

            var imageList = $('li#drag-drop-image'+id).length;
            if(imageList == 0){
                $('#counter'+id).text('We recommend adding 3 more photos');
                $('#showimagediv'+id).html(notexistfirstDefaultImage).show();
                $('#main-lf-image-content_'+id).hover(function(){
                    if($('div.addPhotoBtnDiv input#uploadImage'+id).is(':visible')){
                        $("#prev-"+id).removeAttr('style')
                        $("#prev-"+id).hide()
                        $("#next-"+id).removeAttr('style')
                        $("#next-"+id).hide()
                        $("#gallery-trigger-preview-"+id).removeAttr('style')
                        $("#gallery-trigger-preview-"+id).hide()
                    }
                });
            }else{
                var firstDefaultImageSrc = $('li #drag_drop_image'+id).first().attr('src');
                var firstDefaultImage = $('<img />', {src : firstDefaultImageSrc,'class': 'fullImage'});
                $('#showimagediv'+id).html(firstDefaultImage).show();
                $('li #drag_drop_image'+id).first().addClass('clicked');
            }

            $('.md-trigger').on('click', function() {
                var firstDefaultImageSec = $(this).next('div').clone()
                $('#showImageDiv'+id).html(firstDefaultImageSec).show()
                $('.md-modal').addClass('md-show');
            })

            $('.md-close').on('click', function() {
                $('.md-modal').removeClass('md-show');
            })

            if(imageList == 1){
                $('#counter'+id).text('We recommend adding 2 more photos');
            }else if(imageList == 2){
                $('#counter'+id).text('We recommend adding 1 more photo');
            }else if(imageList == 3){
                $('#counter'+id).text('Add up to 9 more photos');
            }else if(imageList == 4){
                $('#counter'+id).text('Add up to 8 more photos');
            }else if(imageList == 5){
                $('#counter'+id).text('Add up to 7 more photos');
            }else if(imageList == 6){
                $('#counter'+id).text('Add up to 6 more photos');
            }else if(imageList == 7){
                $('#counter'+id).text('Add up to 5 more photos');
            }else if(imageList == 8){
                $('#counter'+id).text('Add up to 4 more photos');
            }else if(imageList == 9){
                $('#counter'+id).text('Add up to 3 more photos');
            }else if(imageList == 10){
                $('#counter'+id).text('Add up to 2 more photos');
            }else if(imageList == 11){
                $('#counter'+id).text('Add up to 1 more photo');
            }
            else if(imageList == 12){
                $('#counter'+id).text('Photo limit reached');
            }
            $('#default_counter'+id).text(imageList);
            $('#modal_counter'+id).text(imageList + (imageList === 1 ? ' image':' images'));


            $('.ebay-image-upload:first').closest('div').removeClass('no-img-content');
            $('li.drag-drop-image img:first').addClass('clicked')
            $('li.drag-drop-image img:first').addClass('clicked-'+id)
            $('li.drag-drop-image p').text('Drag to rearrange')

            $('ul #uploadImage'+id).first().closest('div').removeClass('no-img-content');
            $('#uploadImage'+id).first().removeAttr('disabled');
            $('#innerAddSign'+id).first().css('opacity', '100');
            $('#innerAddPhoto'+id).first().css('opacity', '100');
            $('div.drag-drop-image #uploadImage'+id).first().css('opacity', '100');


        }



        $('div#variation-photo-sections').hide()

        function selectProductVariation(){

            $('div#variation-photo-sections').show()
            $('div#expandCollapseImageGallaryTab').show()

            $('div.variation-div').hide()
            $('ul li').removeClass('terms-active-li')
            $('div.terms_name_gallery').hide()

            var e = document.getElementById('selectVariation')
            var optionName = e.options[e.selectedIndex].text
            // console.log('optionName ' + optionName)
            var optionValue = e.options[e.selectedIndex].value

            $('div.variation-name').each(function(i, obj){
                // console.log(obj)
                if(optionName == obj.innerText){
                    $(obj).closest('div.variation-parent-div').find('div.variation-div').show()
                    $(obj).closest('div.variation-parent-div').find('li').first().addClass('terms-active-li').css('border-top', '1px solid var(--wms-primary-color)')
                }
            })

            $('div.terms_name_gallery').each(function(gIndex, gElement){
                // console.log(gElement)
                var termsNameGallery = $(gElement).attr('id')
                var id = termsNameGallery.replace(/[^0-9.]/g, "")
                // console.log(id)

                $('div.image-gallery-under-variation-name').each(function(index, element){
                    // console.log(element)
                    // console.log(element.innerText)
                    if(optionName == element.innerText){
                        // console.log(element)
                        $(element).next('div').find('div.terms_name_gallery').first().show()
                        $(element).next('div').find('div.add-photos-content').first().removeClass('no-img-content')

                        $('div#addPhotosContent'+id).first().on('click', function(){
                            if($(this).is(':first-child')) {
                                $('#btn-text'+id).closest('div').find('input').removeAttr('id');
                            }
                        })

                        $('div.addPhotoBtnDiv').on('click', function(){
                            $('#btn-text'+id).closest('div').find('input').attr('id','uploadImage'+id);
                        })


                        var notexistfirstDefaultImage = $('<div class="img-upload-main-content">'+
                            '<div class="img-content-wrap">'+
                                '<div class="addPhotoBtnDiv addProductGlry">'+
                                    '<p class="btn-text" id="btn-text'+id+'">Add Photos</p>'+
                                    '<input type="file" title=" " name="uploadImage['+id+'][]" id="uploadImage'+id+'" class="form-control" accept="/image" onchange="preview_image('+id+');" multiple>'+
                                '</div>'+
                                '<p class="photo-req-txt">Add up to 12 photos. We do not allow photos with extra borders, text or artwork.</p>'+
                            '</div>'+
                        '</div>');

                        var imageList = $('li#drag-drop-image'+id).length;
                        if(imageList == 0){
                            $('#counter'+id).text('We recommend adding 3 more photos');
                            $('#showimagediv'+id).html(notexistfirstDefaultImage).show();
                            $('#main-lf-image-content_'+id).hover(function(){
                                if($('div.addPhotoBtnDiv input#uploadImage'+id).is(':visible')){
                                    $("#prev-"+id).removeAttr('style')
                                    $("#prev-"+id).hide()
                                    $("#next-"+id).removeAttr('style')
                                    $("#next-"+id).hide()
                                    $("#gallery-trigger-preview-"+id).removeAttr('style')
                                    $("#gallery-trigger-preview-"+id).hide()
                                }
                            });
                        }else{
                            console.log('else')
                            var firstDefaultImageSrc = $('li #drag_drop_image'+id).first().attr('src');
                            var firstDefaultImage = $('<img />', {src : firstDefaultImageSrc,'class': 'fullImage'});
                            $('#showimagediv'+id).html(firstDefaultImage).show();
                            $('li #drag_drop_image'+id).first().addClass('clicked')
                        }

                        $('.md-trigger').on('click', function() {
                            var firstDefaultImageSec = $(this).next('div').clone()
                            $('#showImageDiv'+id).html(firstDefaultImageSec).show()
                            $('.md-modal').addClass('md-show');
                        })

                        $('.md-close').on('click', function() {
                            $('.md-modal').removeClass('md-show');
                        })

                        if(imageList == 1){
                            $('#counter'+id).text('We recommend adding 2 more photos');
                        }else if(imageList == 2){
                            $('#counter'+id).text('We recommend adding 1 more photo');
                        }else if(imageList == 3){
                            $('#counter'+id).text('Add up to 9 more photos');
                        }else if(imageList == 4){
                            $('#counter'+id).text('Add up to 8 more photos');
                        }else if(imageList == 5){
                            $('#counter'+id).text('Add up to 7 more photos');
                        }else if(imageList == 6){
                            $('#counter'+id).text('Add up to 6 more photos');
                        }else if(imageList == 7){
                            $('#counter'+id).text('Add up to 5 more photos');
                        }else if(imageList == 8){
                            $('#counter'+id).text('Add up to 4 more photos');
                        }else if(imageList == 9){
                            $('#counter'+id).text('Add up to 3 more photos');
                        }else if(imageList == 10){
                            $('#counter'+id).text('Add up to 2 more photos');
                        }else if(imageList == 11){
                            $('#counter'+id).text('Add up to 1 more photo');
                        }else if(imageList == 12){
                            $('#counter'+id).text('Photo limit reached');
                        }
                        $('#default_counter'+id).text(imageList);
                        $('#modal_counter'+id).text(imageList + (imageList === 1 ? ' image':' images'));

                        $('.ebay-image-upload:first').closest('div').removeClass('no-img-content');
                        $('li.drag-drop-image img:first').addClass('clicked');
                        $('li.drag-drop-image #drag_drop_image'+id).first().addClass('clicked-'+id)
                        $('li.drag-drop-image p').text('Drag to rearrange');

                        // $('#uploadImage'+id).first().closest('div').removeClass('no-img-content');
                        $('#uploadImage'+id).first().removeAttr('disabled');
                        $('#innerAddSign'+id).first().css('opacity', '100');
                        $('#innerAddPhoto'+id).first().css('opacity', '100');
                        $('div.drag-drop-image #uploadImage'+id).first().css('opacity', '100');

                    }
                })

            })

        }


        function preview_image(id){
            // console.log('upload id = '+id);
            var total_file=document.getElementById("uploadImage"+id).files.length;
            var file_name = document.getElementById("uploadImage"+id).files;
            var fileUpload = document.getElementById("uploadImage"+id);
            var imageList = $('li#drag-drop-image'+id).length;
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
                            errorIcon += '<a class="image_dimension" id="image_dimension'+id+'" title="error"></a>'+
                            '<div class="image_dimension_error_show hide">'+
                                '<span><b>Photo quality issues :</b></span><br>'+
                                '<span>"Upload high resolution photos that are at least 500 pixels on the longest side. If you are uploading a photo from your smartphone, select the medium or large photo size option."</span>'+
                            '</div>'

                            // $('button.add-pro-btn').on('click', function(){
                                // var iconError = $('div#sortableImageDiv'+id+ 'a.image_dimension').length;
                                // alert(iconError)
                                // if(iconError > 0){
                                //     $(this).attr('disabled','disabled');
                                //     Swal.fire('Oops.. Photo quality error issue!!','Upload high resolution photos that are at least 500 pixels on the longest side. If you are uploading a photo from your smartphone, select the medium or large photo size option. It looks like there is a problem with this listing.','warning');
                                // }

                            // });

                        }// if close height


                        $('<li class="drag-drop-image" id="drag-drop-image'+id+'">'+ // After uploading image
                                '<a class="cross-icon bg-white border-0 btn-outline-light"  onclick="removeLi(this, '+id+')">&#10060;</a>'+
                                '<input type="hidden" id="image" name="image['+id+'][]" value="'+file.name+'">'+
                                '<span class="main_photo"></span>'+
                                '<img class="drag_drop_image" onclick="clickToShowDefaultImg(this, '+id+')" id="drag_drop_image'+id+'" src="'+event.target.result+'"  alt="">'+
                                '<p class="drag_and_drop hide" id="drag_and_drop_'+id+'"></p>'+
                                errorIcon+
                                '<input type="hidden" name="newUploadImage['+id+']['+file.name+']" value="'+event.target.result+'">'+
                        '</li>').insertBefore("#addPhotosContent"+id).first();

                        $('a.image_dimension').hover(function(){ //each error button hover
                            $(this).next().removeClass('hide');
                        }, function(){
                            $(this).next().addClass('hide');
                        });

                        $('a#image_dimension'+id).each(function(i, item){
                            if(item){
                                $('button.add-pro-btn').attr('disabled','disabled')
                                $('button.add-pro-btn').attr('value','1')
                            }
                        })

                        // $('div.add-photos-content:last').remove(); // Removing last div
                        $('div#addPhotosContent'+id).last().remove(); // Removing last div

                        // var id = $('.form-group').closest('span').attr('class');
                        var imageList = $('li#drag-drop-image'+id).length;
                        // console.log('After uploading image = ' +imageList + ' images');
                        if(imageList == 0){
                            $('#counter'+id).text('We recommend adding 3 more photos');
                        }else if(imageList == 1){
                            $('#counter'+id).text('We recommend adding 2 more photos');
                        }else if(imageList == 2){
                            $('#counter'+id).text('We recommend adding 1 more photo');
                        }else if(imageList == 3){
                            $('#counter'+id).text('Add up to 9 more photos');
                        }else if(imageList == 4){
                            $('#counter'+id).text('Add up to 8 more photos');
                        }else if(imageList == 5){
                            $('#counter'+id).text('Add up to 7 more photos');
                        }else if(imageList == 6){
                            $('#counter'+id).text('Add up to 6 more photos');
                        }else if(imageList == 7){
                            $('#counter'+id).text('Add up to 5 more photos');
                        }else if(imageList == 8){
                            $('#counter'+id).text('Add up to 4 more photos');
                        }else if(imageList == 9){
                            $('#counter'+id).text('Add up to 3 more photos');
                        }else if(imageList == 10){
                            $('#counter'+id).text('Add up to 2 more photos');
                        }else if(imageList == 11){
                            $('#counter'+id).text('Add up to 1 more photo');
                        }else if(imageList == 12){
                            $('#counter'+id).text('Photo limit reached');
                        }
                        $('#default_counter'+id).text(imageList);
                        $('#modal_counter'+id).text(imageList + (imageList === 1 ? ' image':' images'));

                        $('li.drag-drop-image p:last').text('Drag to rearrange');
                        // $('li.drag-drop-image span.main_photo:first').text('Main Photo');

                        $('img.drag_drop_image').removeClass('clicked');
                        $('img.drag_drop_image:last').addClass('clicked'); //By default last image active show

                        var $afterUploadLastImgView = $('img#drag_drop_image'+id).last().attr('src');
                        var $img = $('<img />', {src : $afterUploadLastImgView,'class': 'fullImage'});
                        $('#showimagediv'+id).html($img).show();

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

                        var updateImg = $('input#updateImage').val()
                        if(updateImg == 0){
                            $('input#updateImage').val(1)
                        }

                        var terms_name = $('#variation-terms-image-update_'+id).text()
                        $('td.variation span.terms-name').each(function(){
                            if($(this).text() == terms_name+','){
                                $(this).closest("tr").find('input.created-product').val(1)
                            }
                        })

                    };

                } // function file close

                reader.readAsDataURL(file);
                })(file);

            } // for loop close

        } // preview_image close


        function clickToShowDefaultImg(e, id){
            // console.log(e)
            $('.drag_drop_image').removeClass('clicked');
            $(e).addClass('clicked');
            var img = $('<img />', {src : e.src,'class': 'fullImage'});
            $('#showimagediv'+id).html(img).show();
        }


        // Remove image list
        function removeLi(elem, id){
            var updateImg = $('input#updateImage').val()
            if(updateImg == 0){
                $('input#updateImage').val(1)
            }
            // console.log(elem)
            $(elem).closest('li').remove();

            $("#sortableImageDiv"+id).last().append('<div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent'+id+'">'+
                '<p class="inner-add-sign" id="innerAddSign'+id+'">&#43;</p>'+
                '<input type="file" title=" " name="uploadImage['+id+'][]" id="uploadImage'+id+'" class="form-control ebay-image-upload" accept="/image" onchange="preview_image('+id+');" multiple disabled>'+
                '<p class="inner-add-photo" id="innerAddPhoto'+id+'">Add Photos</p>'+
            '</div>');

            $('#uploadImage'+id).first().removeAttr('disabled');
            $('#innerAddSign'+id).first().css('opacity', '100');
            $('#innerAddPhoto'+id).first().css('opacity', '100');

            $('li.drag-drop-image img:first').addClass('clicked');
            $('li.drag-drop-image p').text('Drag to rearrange');

            $('div#addPhotosContent'+id).first().on('click', function(){
                if($(this).is(':first-child')) {
                    $('#btn-text'+id).closest('div').find('input').removeAttr('id');
                }
            })

            $('div.addPhotoBtnDiv').on('click', function(){
                $('#btn-text'+id).closest('div').find('input').attr('id','uploadImage'+id);
            })

            var firstDefaultImageSrc = $('li #drag_drop_image'+id).first().attr('src');
            var firstDefaultImage = $('<img />', {src : firstDefaultImageSrc,'class': 'fullImage'});
            var notexistfirstDefaultImage = $('<div class="img-upload-main-content">'+
                    '<div class="img-content-wrap">'+
                        '<div class="addPhotoBtnDiv addProductGlry">'+
                            '<p class="btn-text" id="btn-text'+id+'">Add Photos</p>'+
                            '<input type="file" title=" " name="uploadImage['+id+'][]" id="uploadImage'+id+'" class="form-control" accept="/image" onchange="preview_image('+id+');" multiple>'+
                        '</div>'+
                        '<p class="photo-req-txt">Add up to 12 photos. We do not allow photos with extra borders, text or artwork.</p>'+
                    '</div>'+
                '</div>');

            if(firstDefaultImageSrc == null){
                $('#showimagediv'+id).html(notexistfirstDefaultImage).show();
            }else{
                $('#showimagediv'+id).html(firstDefaultImage).show();
            }

            $('#uploadImage'+id).first().closest('div').removeClass('no-img-content');

            var imageList = $('li#drag-drop-image'+id).length;
            if(imageList == 0){
                $('#counter'+id).text('We recommend adding 3 more photos');
            }else if(imageList == 1){
                $('#counter'+id).text('We recommend adding 2 more photos');
            }else if(imageList == 2){
                $('#counter'+id).text('We recommend adding 1 more photo');
            }else if(imageList == 3){
                $('#counter'+id).text('Add up to 9 more photos');
            }else if(imageList == 4){
                $('#counter'+id).text('Add up to 8 more photos');
            }else if(imageList == 5){
                $('#counter'+id).text('Add up to 7 more photos');
            }else if(imageList == 6){
                $('#counter'+id).text('Add up to 6 more photos');
            }else if(imageList == 7){
                $('#counter'+id).text('Add up to 5 more photos');
            }else if(imageList == 8){
                $('#counter'+id).text('Add up to 4 more photos');
            }else if(imageList == 9){
                $('#counter'+id).text('Add up to 3 more photos');
            }else if(imageList == 10){
                $('#counter'+id).text('Add up to 2 more photos');
            }else if(imageList == 11){
                $('#counter'+id).text('Add up to 1 more photo');
            }else if(imageList == 12){
                $('#counter'+id).text('Photo limit reached');
            }
            $('#default_counter'+id).text(imageList);
            $('#modal_counter'+id).text(imageList + (imageList === 1 ? ' image':' images'));

            var errorIcon = $('a.image_dimension').length;
            if(errorIcon == 0){
                $('button.add-pro-btn').attr('disabled', false);
                $('button.add-pro-btn').removeAttr('value')
            }

            var terms_name = $('#variation-terms-image-update_'+id).text()
            $('td.variation span.terms-name').each(function(){
                if($(this).text() == terms_name+','){
                    $(this).closest("tr").find('input.created-product').val(1)
                }
            })

            if(imageList == 0){
                $('#main-lf-image-content_'+id).hover(function(){
                    if($('div.addPhotoBtnDiv input#uploadImage'+id).is(':visible')){
                        $("#prev-"+id).removeAttr('style')
                        $("#prev-"+id).hide()
                        $("#next-"+id).removeAttr('style')
                        $("#next-"+id).hide()
                        $("#gallery-trigger-preview-"+id).removeAttr('style')
                        $("#gallery-trigger-preview-"+id).hide()
                    }
                });
            }
        }

        function photoError(){
            if($("button.add-pro-btn").val() == 1){
                Swal.fire('Oops.. Photo quality error issue!!','Upload high resolution photos that are at least 500 pixels on the longest side. If you are uploading a photo from your smartphone, select the medium or large photo size option. It looks like there is a problem with this listing.','warning')
            }
        }

        $(document).ready(function(){
            $( ".ebay-image-wrap" ).sortable({
            revert: true,
            update: function( event, ui ) {
                    var id = $(this).closest('div').attr('id').split('_')[1]
                    var terms_name = $('#variation-terms-image-update_'+id).text()
                    $('td.variation span.terms-name').each(function(){
                        if($(this).text() == terms_name+','){
                            $(this).closest("tr").find('input.created-product').val(1)
                        }
                    })

                    var updateImg = $('input#updateImage').val()
                    if(updateImg == 0){
                        $(this).closest('form').find('input#updateImage').val(1)
                    }
                }
            });
            $( ".ebay-image-wrap" ).disableSelection();
        })




         //Click to enlarge image modal preview
         $(function () {
            $('.md-trigger').on('click', function() {
                $('.md-modal').addClass('md-show');
            });
            $('.md-close').on('click', function() {
                $('.md-modal').removeClass('md-show');
            });
        });


         //Small image on text show
         $(".drag_drop_image").hover(function () {
            $(this).next().removeClass('hide');
         }, function () {
            $(this).next().addClass('hide');
         });

            // console.log('ID ' + id);

        //Next and Prev button show on Big image
        $(document).ready(function(){
            $('.main_image_show').hover(function(){
                $('.prev, .next, .md-trigger').show();
            },  function () {
                $('.prev, .next, .md-trigger').hide();
            });
        })

        //If keep cursor on next and previous button then click to enlarge button will disappear
        $(document).ready(function(){
            $('.prev, .next').hover(function(){
                $('.md-trigger').addClass('hide');
            }, function(){
                $('.md-trigger').removeClass('hide');
            });
        })

        // $(document).on('click','.next,.then',function(){
        // $('.next,.then').click(function(){
        function nextThen(e, id){
            if(!$("ul#sortableImageDiv"+id+ ".clicked").is(".drag_drop_image:last")){
                var $first = $('li.drag-drop-image:first', "ul#sortableImageDiv"+id)
                $last = $('li.drag-drop-image:last', "ul#sortableImageDiv"+id)
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
        }

        // });

        // $(document).on('click','.prev,.previous',function(){
        // $('.prev,.previous').click(function(){
        function prevPrevious(e, id){
            if(!$("ul#sortableImageDiv"+id+ ".clicked").is(".drag_drop_image:first")){
                var $first = $('li.drag-drop-image:first', "ul#sortableImageDiv"+id),
                $last = $('li.drag-drop-image:last', "ul#sortableImageDiv"+id);
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
        }
        // });


        // function manageVariationForm(event){
        //     console.log(event)
        //     event.preventDefault
        // }

        //End 12 variation Drag drop image


        //Success Message Show
        @if ($message = Session::get('success'))
            swal("{{ $message }}", "", "success");
        @endif

        //Error Message Show
        @if ($message = Session::get('error'))
            swal("{{ $message }}", "", "error");
        @endif

        $(document).ready(function(){
            $('.manage-variation-image').click(function(){
                var masterCatalogueId = $(this).attr('data')
                Swal.fire({
                    title: 'Are you sure ?',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    showLoaderOnConfirm: true,
                    preConfirm: function(){
                        var url = "{{url('reformate-add-product-image')}}"
                        var token = "{{csrf_token()}}"
                        var dataObj = {
                            catalogueId: masterCatalogueId,
                        }
                        return fetch(url,{
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            method: 'post',
                            body: JSON.stringify(dataObj)
                        })
                        .then(response => {
                            if(!response.ok){
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .then(data => {
                            if(data.type == 'success'){
                                Swal.fire('Success',data.msg,'success')
                            }else{
                                Swal.fire('Oops!',data.msg,'error')
                            }
                        })
                        .catch(error => {
                            Swal.showValidationMessage(`Request Failed: ${error}`)
                        })
                    }
                })
            })
        })


        $(document).ready(function(){
            var count = 0
            $('ul.ebay-image-wrap li').each(function(i, item){
                count++
                if(count > 0){
                    $('button#addVariationBtn').text('Manage Variation images')
                }else{
                    $('button#addVariationBtn').text('Add Variation Image')
                }
            })
        })

        @if ($message = Session::get('updated_success'))
            swal("{{ $message }}", "", "success");
        @endif

        @if ($add_product_message = Session::get('add_product_success'))
            swal("{{ $add_product_message }}", "", "success");
        @endif

    </script>




    {{-- <script>
        export default {
            data() {
                return {
                    content: null
                }
            },
            components: {
                'summernote' : require('./Summernote')
            }
        }
    </script> --}}



@endsection
