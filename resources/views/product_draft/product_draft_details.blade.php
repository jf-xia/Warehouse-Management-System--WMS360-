@extends('master')
@section('title')
    Catalogue | Active Catalogue Details | WMS360
@endsection
@section('content')

    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="wms-breadcrumb">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">{{$product_draft_variation_results == 'product-draft' ? 'Product Draft' : 'Active Catalogue'}}</li>
                            <li class="breadcrumb-item active" aria-current="page">{{$product_draft_variation_results == 'product-draft' ? 'Draft Catalogue Details' : 'Active Catalogue Details'}}</li>
                        </ol>
                    </div>
                    <div class="breadcrumbRightSideBtn">
                        <a href="{{route('product-draft.edit',$product_draft_variation_results->id ?? '')}}"><button class="btn btn-default">Edit</button></a>
                    </div>
                </div>
                     <div class="card-box m-t-20 shadow product-draft-details table-responsive">

                        {{-- <!-- @if ($message = Session::get('success'))
                             <div class="alert alert-success alert-block">
                                 <button type="button" class="close" data-dismiss="alert">×</button>
                                 <strong>{{ $message }}</strong>
                             </div>
                         @endif --> --}}

                         {{-- <!-- @if ($message = Session::get('error'))
                             <div class="alert alert-danger alert-block">
                                 <button type="button" class="close" data-dismiss="alert">×</button>
                                 <strong>{{ $message }}</strong>
                             </div>
                         @endif --> --}}

                        <div class="row">
                            <div class="col-md-12 m-t-30">
                                <div class="row">
                                    @if($product_image != null)
                                        @foreach($product_image as $image)
                                            <div class="col-md-2 col-sm-6">
                                                <div class="card m-b-10">
                                                    <img class="card-img-top img-thumbnail" src="{{(filter_var($image->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$image->image_url : $image->image_url}}" alt="Product image">
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-md-12">
                                            <h3>No Product image for show</h3>
                                        </div>
                                    @endif
                                </div> <!--end row-->
                            </div> <!-- end col-md-12 -->
                            <div class="col-md-12 m-t-20">
                                <div class="card p-2 m-t-10">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p><span class="font-weight-bold text-purple">Name : </span> &nbsp; {{$product_draft_variation_results-> name ?? ''}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card p-2 m-t-10">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p><span class="font-weight-bold text-purple">Category : </span> &nbsp; {{$product_draft_variation_results->woo_wms_category-> category_name ?? ''}}</p>
                                        </div>
                                    </div>
                                </div>
                                @if($product_draft_variation_results->type == 'variable')
                                    <div class="card p-2 m-t-10">
                                        <div class="row attribute">
                                            <div class="w-25 mb-1">
                                                <p><b>Attribute Name :</b></p>
                                            </div>
                                            <div class="w-75 mb-1">
                                                <p><b>Attribute Terms Name :</b></p>
                                            </div>
                                            @if($product_draft_variation_results->attribute != '')
                                                @foreach(\Opis\Closure\unserialize($product_draft_variation_results->attribute) as $attribute_info_key => $attribute_info_value)
                                                    @foreach($attribute_info_value as $attribute_key => $attribute_val)
                                                    <div class="w-25">
                                                        <p>{{$attribute_key ?? ''}} <i class="fa fa-arrow-right font-13"></i></p>
                                                    </div>
                                                    <div class="w-75">
                                                        <p>
                                                            @foreach($attribute_val as $key => $val)
                                                                {{$val['attribute_term_name'] ?? ''}},
                                                            @endforeach
                                                        </p>
                                                    </div>
                                                    @endforeach
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="card m-t-10">
                                    <div class="product-description p-2" onclick="product_description(this)">
                                        <div> <p> Product Description</p> </div>
                                        <div>
                                            <i class="fa fa-arrow-down font-13" aria-hidden="true"></i>
                                            <i class="fa fa-arrow-up font-13 hide" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="product-description-content hide">
                                        {!! $product_draft_variation_results->description ?? '' !!}
                                    </div>
                                </div>


                                @if(isset($product_draft_variation_results->short_description))
                                <div class="card m-t-10">
                                    <div class="product-description p-2" onclick="product_description(this)">
                                        <div> <p>Product Short Description</p> </div>
                                        <div>
                                            <i class="fa fa-arrow-down font-13" aria-hidden="true"></i>
                                            <i class="fa fa-arrow-up font-13 hide" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="product-description-content hide">
                                        {!! $product_draft_variation_results->short_description ?? '' !!}
                                    </div>
                                </div>
                                @endisset

                                {{-- <div class="card card_hover pulse m-t-10">
                                    <a href="#product-draft-details-des-hide" id="product-draft-details-des-hide">Product Description <i class="fa fa-arrow-down font-13"></i></a>
                                    <a href="#/" id="product-draft-details-des-show">Product Description &nbsp; <i class="fa fa-arrow-up font-13"></i></a>
                                    <div id="description-content">
                                        <div class="product-draft-description-content">
                                            <div class="card-body">
                                                {!! $product_draft_variation_results->description ?? '' !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if(isset($product_draft_variation_results->short_description))
                                <div class="card card_hover pulse m-t-10 khali">
                                    <a href="#product-draft-details-short-des-hide" id="product-draft-details-short-des-hide">Product Short Description <i class="fa fa-arrow-down font-13"></i></a>
                                    <a href="#/" id="product-draft-details-short-des-show">Product Short Description &nbsp;<i class="fa fa-arrow-up font-13"></i></a>
                                    <div id="description-content">
                                        <div class="product-draft-short-description-content">
                                            <div class="card-body asd">
                                                {!! $product_draft_variation_results->short_description ?? '' !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif --}}


                                <div class="card p-2 m-t-10">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-3">
                                                <div class="d-flex">
                                                    <div class="w-50">
                                                        <p><b>Product code :</b></p>
                                                        <p><b>Color code :</b></p>
                                                        <p><b>SKU Short code :</b></p>
                                                        <p><b>Color code :</b></p>
                                                    </div>
                                                    <div class="w-50">
                                                        <p>{{$product_draft_variation_results->product_code ?? ''}}</p>
                                                        <p>{{$product_draft_variation_results->color_code ?? ''}}</p>
                                                        <p>{{$product_draft_variation_results->sku_short_code ?? ''}}</p>
                                                        <p>{{$product_draft_variation_results->color ?? ''}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col-md-12 -->
                        </div> <!--end row-->



                         <div class="row m-t-40">
                             <div class="col-md-12">
                                 <!--screen option-->
                                 <div class="row">
                                     <div class="col-md-12">

                                         <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                                         <input type="hidden" id="firstKey" value="catalogue">
                                         <input type="hidden" id="secondKey" value="catalogue_details">
                                         <!----END ON OFF SWITCH ARRAY KEY DECLARATION---->

                                         <div class="card-box screen-option-content draft-details-card" style="display: none">
                                             <div class="row content-inner catalogue-draft-details">
                                                 <div class="col-md-4">
                                                     <div class="d-flex align-items-center">
                                                         <div class="onoffswitch">
                                                             <input type="checkbox" name="image" class="onoffswitch-checkbox" id="image" tabindex="0" @if(isset($setting['catalogue']['catalogue_details']['image']) && $setting['catalogue']['catalogue_details']['image'] == 1) checked @elseif(isset($setting['catalogue']['catalogue_details']['image']) && $setting['catalogue']['catalogue_details']['image'] == 0) @else checked @endif>
                                                             <label class="onoffswitch-label" for="image">
                                                                 <span class="onoffswitch-inner"></span>
                                                                 <span class="onoffswitch-switch"></span>
                                                             </label>
                                                         </div>
                                                         <div class="ml-1"><p>Image</p></div>
                                                     </div>
                                                     <div class="d-flex align-items-center mt-2">
                                                         <div class="onoffswitch">
                                                             <input type="checkbox" name="id" class="onoffswitch-checkbox" id="id" tabindex="0" @if(isset($setting['catalogue']['catalogue_details']['id']) && $setting['catalogue']['catalogue_details']['id'] == 1) checked @elseif(isset($setting['catalogue']['catalogue_details']['id']) && $setting['catalogue']['catalogue_details']['id'] == 0) @else checked @endif>
                                                             <label class="onoffswitch-label" for="id">
                                                                 <span class="onoffswitch-inner"></span>
                                                                 <span class="onoffswitch-switch"></span>
                                                             </label>
                                                         </div>
                                                         <div class="ml-1"><p>ID</p></div>
                                                     </div>
                                                     <div class="d-flex align-items-center mt-2">
                                                         <div class="onoffswitch">
                                                             <input type="checkbox" name="sku" class="onoffswitch-checkbox" id="sku" tabindex="0" @if(isset($setting['catalogue']['catalogue_details']['sku']) && $setting['catalogue']['catalogue_details']['sku'] == 1) checked @elseif(isset($setting['catalogue']['catalogue_details']['sku']) && $setting['catalogue']['catalogue_details']['sku'] == 0) @else checked @endif>
                                                             <label class="onoffswitch-label" for="sku">
                                                                 <span class="onoffswitch-inner"></span>
                                                                 <span class="onoffswitch-switch"></span>
                                                             </label>
                                                         </div>
                                                         <div class="ml-1"><p>SKU</p></div>
                                                     </div>
                                                     <div class="d-flex align-items-center mt-2">
                                                         <div class="onoffswitch">
                                                             <input type="checkbox" name="qr" class="onoffswitch-checkbox" id="qr" tabindex="0" @if(isset($setting['catalogue']['catalogue_details']['qr']) && $setting['catalogue']['catalogue_details']['qr'] == 1) checked @elseif(isset($setting['catalogue']['catalogue_details']['qr']) && $setting['catalogue']['catalogue_details']['qr'] == 0) @else checked @endif>
                                                             <label class="onoffswitch-label" for="qr">
                                                                 <span class="onoffswitch-inner"></span>
                                                                 <span class="onoffswitch-switch"></span>
                                                             </label>
                                                         </div>
                                                         <div class="ml-1"><p>QR</p></div>
                                                     </div>
                                                     <div class="d-flex align-items-center mt-2">
                                                         <div class="onoffswitch">
                                                             <input type="checkbox" name="base_price" class="onoffswitch-checkbox" id="base_price" tabindex="0" @if(isset($setting['catalogue']['catalogue_details']['base_price']) && $setting['catalogue']['catalogue_details']['base_price'] == 1) checked @elseif(isset($setting['catalogue']['catalogue_details']['base_price']) && $setting['catalogue']['catalogue_details']['base_price'] == 0) @else checked @endif>
                                                             <label class="onoffswitch-label" for="base_price">
                                                                 <span class="onoffswitch-inner"></span>
                                                                 <span class="onoffswitch-switch"></span>
                                                             </label>
                                                         </div>
                                                         <div class="ml-1"><p>Base Price</p></div>
                                                     </div>
                                                 </div>
                                                 <div class="col-md-4">
                                                     <div class="d-flex align-items-center mt-sm-2 mt-xs-10">
                                                         <div class="onoffswitch">
                                                             <input type="checkbox" name="variation" class="onoffswitch-checkbox" id="variation" tabindex="0" @if(isset($setting['catalogue']['catalogue_details']['variation']) && $setting['catalogue']['catalogue_details']['variation'] == 1) checked @elseif(isset($setting['catalogue']['catalogue_details']['variation']) && $setting['catalogue']['catalogue_details']['variation'] == 0) @else checked @endif>
                                                             <label class="onoffswitch-label" for="variation">
                                                                 <span class="onoffswitch-inner"></span>
                                                                 <span class="onoffswitch-switch"></span>
                                                             </label>
                                                         </div>
                                                         <div class="ml-1"><p>Variation</p></div>
                                                     </div>
                                                     <div class="d-flex align-items-center mt-2">
                                                         <div class="onoffswitch">
                                                             <input type="checkbox" name="ean" class="onoffswitch-checkbox" id="ean" tabindex="0" @if(isset($setting['catalogue']['catalogue_details']['ean']) && $setting['catalogue']['catalogue_details']['ean'] == 1) checked @elseif(isset($setting['catalogue']['catalogue_details']['ean']) && $setting['catalogue']['catalogue_details']['ean'] == 0) @else checked @endif>
                                                             <label class="onoffswitch-label" for="ean">
                                                                 <span class="onoffswitch-inner"></span>
                                                                 <span class="onoffswitch-switch"></span>
                                                             </label>
                                                         </div>
                                                         <div class="ml-1"><p>EAN</p></div>
                                                     </div>
                                                     <div class="d-flex align-items-center mt-2">
                                                         <div class="onoffswitch">
                                                             <input type="checkbox" name="regular-price" class="onoffswitch-checkbox" id="regular-price" tabindex="0" @if(isset($setting['catalogue']['catalogue_details']['regular-price']) && $setting['catalogue']['catalogue_details']['regular-price'] == 1) checked @elseif(isset($setting['catalogue']['catalogue_details']['regular-price']) && $setting['catalogue']['catalogue_details']['regular-price'] == 0) @else checked @endif>
                                                             <label class="onoffswitch-label" for="regular-price">
                                                                 <span class="onoffswitch-inner"></span>
                                                                 <span class="onoffswitch-switch"></span>
                                                             </label>
                                                         </div>
                                                         <div class="ml-1"><p>Regular Price</p></div>
                                                     </div>
                                                     <div class="d-flex align-items-center mt-2">
                                                         <div class="onoffswitch">
                                                             <input type="checkbox" name="sales-price" class="onoffswitch-checkbox" id="sales-price" tabindex="0" @if(isset($setting['catalogue']['catalogue_details']['sales-price']) && $setting['catalogue']['catalogue_details']['sales-price'] == 1) checked @elseif(isset($setting['catalogue']['catalogue_details']['sales-price']) && $setting['catalogue']['catalogue_details']['sales-price'] == 0) @else checked @endif>
                                                             <label class="onoffswitch-label" for="sales-price">
                                                                 <span class="onoffswitch-inner"></span>
                                                                 <span class="onoffswitch-switch"></span>
                                                             </label>
                                                         </div>
                                                         <div class="ml-1"><p>Sales Price</p></div>
                                                     </div>
                                                 </div>
                                                 <div class="col-md-4">
                                                    @if (Auth::check() && in_array('1',explode(',',Auth::user()->role)))
                                                     <div class="d-flex align-items-center mt-sm-2 mt-xs-10">
                                                        <div class="onoffswitch">
                                                             <!-- <input type="checkbox" name="cost-price" class="onoffswitch-checkbox" id="cost-price" tabindex="0" @if(isset($setting['catalogue']['catalogue_details']['cost-price']) && $setting['catalogue']['catalogue_details']['cost-price'] == 1) checked @elseif(isset($setting['catalogue']['catalogue_details']['cost-price']) && $setting['catalogue']['catalogue_details']['cost-price'] == 0) @else checked @endif> -->
                                                             <input type="checkbox" name="cost-price" class="onoffswitch-checkbox" id="cost-price" tabindex="0" @if(isset($setting['catalogue']['catalogue_details']['cost-price']) && $setting['catalogue']['catalogue_details']['cost-price'] == 1) checked @elseif(isset($setting['catalogue']['catalogue_details']['cost-price']) && $setting['catalogue']['catalogue_details']['cost-price'] == 0) @endif>
                                                             <label class="onoffswitch-label" for="cost-price">
                                                                 <span class="onoffswitch-inner"></span>
                                                                 <span class="onoffswitch-switch"></span>
                                                             </label>
                                                        </div>
                                                        <div class="ml-1"><p>Cost Price</p></div>
                                                     </div>
                                                     @endif
                                                     <div class="d-flex align-items-center mt-2">
                                                         <div class="onoffswitch">
                                                             <input type="checkbox" name="sold" class="onoffswitch-checkbox" id="sold" tabindex="0" @if(isset($setting['catalogue']['catalogue_details']['sold']) && $setting['catalogue']['catalogue_details']['sold'] == 1) checked @elseif(isset($setting['catalogue']['catalogue_details']['sold']) && $setting['catalogue']['catalogue_details']['sold'] == 0) @else checked @endif>
                                                             <label class="onoffswitch-label" for="sold">
                                                                 <span class="onoffswitch-inner"></span>
                                                                 <span class="onoffswitch-switch"></span>
                                                             </label>
                                                         </div>
                                                         <div class="ml-1"><p>Sold</p></div>
                                                     </div>
                                                     <div class="d-flex align-items-center mt-2">
                                                         <div class="onoffswitch">
                                                             <input type="checkbox" name="available-qty" class="onoffswitch-checkbox" id="available-qty" tabindex="0" @if(isset($setting['catalogue']['catalogue_details']['available-qty']) && $setting['catalogue']['catalogue_details']['available-qty'] == 1) checked @elseif(isset($setting['catalogue']['catalogue_details']['available-qty']) && $setting['catalogue']['catalogue_details']['available-qty'] == 0) @else checked @endif>
                                                             <label class="onoffswitch-label" for="available-qty">
                                                                 <span class="onoffswitch-inner"></span>
                                                                 <span class="onoffswitch-switch"></span>
                                                             </label>
                                                         </div>
                                                         <div class="ml-1"><p>Available Qty</p></div>
                                                     </div>
                                                     @if($shelf_use == 1)
                                                         <div class="d-flex align-items-center mt-2">
                                                             <div class="onoffswitch">
                                                                 <input type="checkbox" name="shelf-qty" class="onoffswitch-checkbox" id="shelf-qty" tabindex="0" @if(isset($setting['catalogue']['catalogue_details']['shelf-qty']) && $setting['catalogue']['catalogue_details']['shelf-qty'] == 1) checked @elseif(isset($setting['catalogue']['catalogue_details']['shelf-qty']) && $setting['catalogue']['catalogue_details']['shelf-qty'] == 0) @else checked @endif>
                                                                 <label class="onoffswitch-label" for="shelf-qty">
                                                                     <span class="onoffswitch-inner"></span>
                                                                     <span class="onoffswitch-switch"></span>
                                                                 </label>
                                                             </div>
                                                             <div class="ml-1"><p>Shelf Qty</p></div>
                                                         </div>
                                                     @endif
                                                 </div>
                                             </div>

                                             <div class="mt-3 draft_details_msg_top screen-option-btn-flex">
                                                 {{-- <span class="pagination-mgs-show text-success"></span> --}}
                                                 <div class="submit">
                                                     <input type="submit" class="btn submit-btn pagination-apply" value="Apply">
                                                 </div>
                                                 <div class="d-flex align-items-center">
                                                    {{-- <div class="mt-xs-10 m-r-10"><a class="btn btn-outline-success" target="_blank" href="{{url('catalogue/'.$product_draft_variation_results->id.'/product')}}">Manage Variation</a></div> --}}
                                                    {{-- <div class="responsive_terms_to_catalogue m-r-10 s-m-r-10 mt-sm-10"><a class="btn btn-outline-success addTermstoCatalogBtn">Add Terms to Catalogue</a></div> --}}
                                                 </div>
                                             </div>

                                             <!---Catalogue button area --->
                                            <!-- <div class="catalogue-btn-area">
                                                @if(Auth::check() && Auth::user()->email == "support@combosoft.co.uk")
                                                    <div class="m-r-10"><a class="btn btn-outline-primary" href="Javascript:void(0)">Available and Shelf Qty Sync</a></div>
                                                @endif
                                                <div class="mt-xs-10 m-r-10"><a class="btn btn-outline-success" target="_blank" href="{{url('catalogue/'.$product_draft_variation_results->id.'/product')}}">Add Product</a></div>
                                                <div class="responsive_terms_to_catalogue m-r-10 ss-m-r-10"><a class="btn btn-outline-success" target="_blank" href="{{url('add-additional-terms-draft/'.$product_draft_variation_results->id ?? '')}}">Add Terms to Catalogue</a></div>
                                                <div class="add-reason">
                                                    <a href="Javascript:void(0)" class="btn btn-outline-info">Add Reason</a>
                                                </div>
                                            </div> -->

                                         </div>
                                     </div>
                                 </div>
                                 <!--//screen option-->

                                    <div class="screen-option" id="product-details-page">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <!-- <div>
                                            @if($product_draft_variation_results->type == 'variable')
                                                <h5 class="upload-variation-image">Upload variation image</h5>
                                                <div class="d-flex justify-content-center align-items-center" style="width: fit-content;">
                                                <select class="form-control variation-select-height b-r-0" name="attribute" id="attribute_image">
                                                    @if($product_draft_variation_results->attribute != '')
                                                        <option hidden>Select Attribute</option>
                                                        @foreach(\Opis\Closure\unserialize($product_draft_variation_results->attribute) as $attribute_key => $attribute_value)
                                                            @foreach($attribute_value as $key => $value)
                                                                <option value="{{$id ?? ''}}/{{$attribute_key ?? ''}}">{{$key ?? ''}}</option>
                                                            @endforeach
                                                        @endforeach
                                                    @endif
                                                </select> -->
                                                    <!-- <div class="variation_search">
                                                        <input type="text" class="form-control b-r-0" id="product_variation_search" placeholder="Search.....">
                                                    </div> -->
                                                    <!-- <div>
                                                        <a class="btn btn-default product_v_reload" href="" title="Refresh This Page"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                                    </div> -->
                                                <!-- </div>
                                                @endif
                                            </div> -->
                                        </div>
                                        <div class="screen-option-btn mb-3 mt-sm-10">
                                            <button class="btn btn-link waves-effect waves-light" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Screen Options &nbsp; <i class="fa" aria-hidden="true"></i>
                                            </button>
                                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion"></div>
                                        </div>
                                    </div>


                                     <div class="row image_upload_attribute_wise mt-2">
                                         <div class="col-md-12 m-b-10">
                                             <form action="{{url('save-variation-image-attribute-wise')}}" method="POST" enctype="multipart/form-data">
                                                 @csrf
                                                 <div class="card card-body m-b-10" style="display: none">

                                                 </div>
                                             </form>
                                         </div>
                                     </div>

                                     @if ($message = Session::get('image_success'))
                                         <div class="alert alert-success alert-block">
                                             <button type="button" class="variation-close" data-dismiss="alert">×</button>
                                             <strong>{{ $message }}</strong>
                                         </div>
                                     @endif

                                     <div id="Load" class="load" style="display: none;">
                                         <div class="load__container">
                                             <div class="load__animation"></div>
                                             <div class="load__mask"></div>
                                             <span class="load__title">Content id loading...</span>
                                         </div>
                                     </div>

                                     <!-- Sidebar drawer bulk edit section -->
                                    <div class="bulk-edit-drawer-box" style="display: none">
                                        <div class="bulk-edit-drawer-box-inner">
                                            <h4 class="text-center">Bulk Edit</h4>
                                            <div class="bulk-action-btn-group">
                                                <div class="bulk-action-area row">
                                                    <div class="col-md-12 d-flex justify-content-center align-items-center">
                                                        <div class="checkbox-count text-primary mb-2"></div>
                                                    </div>
                                                    <div class="action-btn col-md-12 d-flex justify-content-center mb-2">
                                                        <button class="btn check-active regular-price-btn btn-inactive" type="button" id="regularPriceBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Regular Price
                                                        </button>
                                                    </div>

                                                    <!--RegularPriceBtn The Modal -->
                                                    <div id="regularPriceModal" class="variation-modal">
                                                        <!-- Modal content -->
                                                        <div class="variation-modal-content">
                                                            <div class="variation-modal-header">
                                                                <div class="row" style="width: -webkit-fill-available;">
                                                                    <div class="col-md-6 d-flex align-items-center">Regular Price</div>
                                                                    <div class="col-md-6 d-flex justify-content-end">
                                                                        <div class="variation-close regularPriceClose">×</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="variation-modal-body">
                                                                <form action="Javascript:void(0);">
                                                                    <div>
                                                                        <input type="text" class="form-control input-text" name="field_value">
                                                                        <input type="hidden" class="input-field" name="field_name" value="regular_price">
                                                                    </div>
                                                                    <div>
                                                                        <button type="button" class="btn btn-primary vendor-btn waves-effect waves-light submit-btn mt-3" id="bulk_edit">Submit</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="action-btn col-md-12 d-flex justify-content-center mb-2">
                                                        <button class="btn check-active sales-price-btn btn-inactive" type="button" id="salesPriceBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Sales Price
                                                        </button>
                                                        <!--SalesPriceBtn The Modal -->
                                                        <div id="salesPriceModal" class="variation-modal">
                                                            <!-- Modal content -->
                                                            <div class="variation-modal-content">
                                                                <div class="variation-modal-header">
                                                                    <div class="row" style="width: -webkit-fill-available;">
                                                                        <div class="col-md-6 d-flex align-items-center">Sales Price</div>
                                                                        <div class="col-md-6 d-flex justify-content-end">
                                                                            <div class="variation-close salesPriceClose">×</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="variation-modal-body">
                                                                    <form action="Javascript:void(0);">
                                                                        <div>
                                                                            <input type="text" class="form-control input-text" name="field_value">
                                                                            <input type="hidden" class="input-field" name="field_name" value="sale_price">
                                                                        </div>
                                                                        <div>
                                                                            <button type="button" class="btn btn-primary vendor-btn waves-effect waves-light submit-btn mt-3" id="bulk_edit">Submit</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="action-btn col-md-12 d-flex justify-content-center mb-2">
                                                        <button class="btn check-active cost-price-btn btn-inactive" type="button" id="costPriceBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Cost Price
                                                        </button>

                                                        <!--CostPriceBtn The Modal -->
                                                        <div id="costPriceModal" class="variation-modal">
                                                            <!-- Modal content -->
                                                            <div class="variation-modal-content">
                                                                <div class="variation-modal-header">
                                                                    <div class="row" style="width: -webkit-fill-available;">
                                                                        <div class="col-md-6 d-flex align-items-center">Cost Price</div>
                                                                        <div class="col-md-6 d-flex justify-content-end">
                                                                            <div class="variation-close costPriceClose">×</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="variation-modal-body">
                                                                    <form action="Javascript:void(0);">
                                                                        <div>
                                                                            <input type="text" class="form-control input-text" name="field_value">
                                                                            <input type="hidden" class="input-field" name="field_name" value="cost_price">
                                                                        </div>
                                                                        <div>
                                                                            <button type="button" class="btn btn-primary vendor-btn waves-effect waves-light submit-btn mt-3" id="bulk_edit">Submit</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>


                                                    @if (Auth::check() && !empty(array_intersect(['1'],explode(',',Auth::user()->role))))
                                                    <div class="action-btn responsive_ava_qnty col-md-12 d-flex justify-content-center mb-2">
                                                        <button class="btn check-active available-qty-btn btn-inactive" type="button" id="availableQtyBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Available Qty
                                                        </button>
                                                        <!--availableQtyBtn The Modal -->
                                                        <div id="availableQtyModal" class="variation-modal">
                                                            <!-- Modal content -->
                                                            <div class="variation-modal-content">
                                                                <div class="variation-modal-header">
                                                                    <div class="row" style="width: -webkit-fill-available;">
                                                                        <div class="col-md-6 d-flex align-items-center">Available Quantity</div>
                                                                        <div class="col-md-6 d-flex justify-content-end">
                                                                            <div class="variation-close availableQtyClose">×</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="variation-modal-body">
                                                                    <form action="Javascript:void(0);">
                                                                        <div>
                                                                            <input type="text" class="form-control input-text" name="field_value">
                                                                            <input type="hidden" class="input-field" name="field_name" value="actual_quantity">
                                                                        </div>
                                                                        <div>
                                                                            <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light submit-btn mt-3" id="bulk_edit">Submit</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif


                                                    <div class="action-btn responsive_rrp col-md-12 d-flex justify-content-center mb-2">
                                                        <button class="btn check-active available-qty-btn btn-inactive" type="button" id="rrpBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            RRP
                                                        </button>
                                                         <!--availableQtyBtn The Modal -->
                                                         <div id="rrpModal" class="variation-modal">
                                                            <!-- Modal content -->
                                                            <div class="variation-modal-content">
                                                                <div class="variation-modal-header">
                                                                    <div class="row" style="width: -webkit-fill-available;">
                                                                        <div class="col-md-6 d-flex align-items-center">RRP</div>
                                                                        <div class="col-md-6 d-flex justify-content-end">
                                                                            <div class="variation-close rrpClose">×</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="variation-modal-body">
                                                                    <form action="Javascript:void(0);">
                                                                        <div>
                                                                            <input type="text" class="form-control input-text" name="field_value">
                                                                            <input type="hidden" class="input-field" name="field_name" value="rrp">
                                                                        </div>
                                                                        <div>
                                                                            <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light submit-btn mt-3" id="bulk_edit">Submit</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>


                                                    <div class="action-btn responsive_base_price col-md-12 d-flex justify-content-center mb-2">
                                                        <button class="btn check-active available-qty-btn btn-inactive" type="button" id="basePriceBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Base Price
                                                        </button>
                                                        <!--availableQtyBtn The Modal -->
                                                        <div id="basePriceModal" class="variation-modal">
                                                            <!-- Modal content -->
                                                            <div class="variation-modal-content">
                                                                <div class="variation-modal-header">
                                                                    <div class="row" style="width: -webkit-fill-available;">
                                                                        <div class="col-md-6 d-flex align-items-center">Base Price</div>
                                                                        <div class="col-md-6 d-flex justify-content-end">
                                                                            <div class="variation-close basePriceClose">×</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="variation-modal-body">
                                                                    <form action="Javascript:void(0);">
                                                                        <div>
                                                                            <input type="text" class="form-control input-text" name="field_value">
                                                                            <input type="hidden" class="input-field" name="field_name" value="base_price">
                                                                        </div>
                                                                        <div>
                                                                            <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light submit-btn mt-3" id="bulk_edit">Submit</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>


                                            <!---Catalogue button area --->
                                            <div class="catalogue-btn-area row mt-2">
                                                @if (Auth::check() && !empty(array_intersect(['1'],explode(',',Auth::user()->role))))
                                                <div class="col-md-12 mb-2"><a class="btn btn-outline-success catalogue-btn-view-details available-shelf-quantity" href="Javascript:void(0)">Quantity Sync</a></div>
                                                @endif
                                                <div class="col-md-12 mb-2"><a class="btn btn-outline-success catalogue-btn-view-details" target="_blank" href="{{url('catalogue/'.$product_draft_variation_results->id.'/product')}}">Manage Variation</a></div>
                                                <!-- <div class="col-md-12 mb-2"><a class="btn btn-outline-success catalogue-btn-view-details" target="_blank" href="{{url('add-additional-terms-draft/'.$product_draft_variation_results->id ?? '')}}">Add Terms</a></div> -->
                                                {{-- <div class="col-md-12 mb-2"><a class="btn btn-outline-success catalogue-btn-view-details" id="addTermsBtn">Add Terms</a></div> --}}
                                                <!-- <div class="col-md-12 mb-2 add-reason">
                                                    <a href="Javascript:void(0)" class="btn btn-outline-success catalogue-btn-view-details">Add Reason</a>
                                                </div> -->
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-outline-danger variation-bulk-delete">Delete</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                     <!--Bulk edit arae -->
                                    <!-- <div class="product-draft-checkbox-content mb-3" style="display: none;">
                                        <div class="bulk-action-btn-group">
                                            <div class="bulk-action-area">
                                                <div class="action-btn">
                                                    <button class="btn check-active regular-price-btn btn-inactive" type="button" id="dropdownRegularPriceButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Regular Price
                                                    </button>
                                                    <form action="Javascript:void(0);">
                                                        <div class="dropdown-menu bulk-action-drop-down-btn" aria-labelledby="dropdownRegularPriceButton">
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                <div>
                                                                    <input type="text" class="form-control input-text" name="field_value">
                                                                    <input type="hidden" class="input-field" name="field_name" value="regular_price">
                                                                </div>
                                                                <div>
                                                                    <button type="button" class="btn btn-primary submit-btn" id="bulk_edit">Submit</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="action-btn">
                                                    <button class="btn check-active sales-price-btn btn-inactive" type="button" id="dropdownSalesPriceButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Sales Price
                                                    </button>
                                                    <form action="Javascript:void(0);">
                                                        <div class="dropdown-menu bulk-action-drop-down-btn" aria-labelledby="dropdownSalesPriceButton">
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                <div>
                                                                    <input type="text" class="form-control input-text" name="field_value">
                                                                    <input type="hidden" class="input-field" name="field_name" value="sale_price">
                                                                </div>
                                                                <div>
                                                                    <button type="button" class="btn btn-primary submit-btn" id="bulk_edit">Submit</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="action-btn">
                                                    <button class="btn check-active cost-price-btn btn-inactive" type="button" id="dropdownCostPriceButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Cost Price
                                                    </button>
                                                    <form action="Javascript:void(0);">
                                                        <div class="dropdown-menu bulk-action-drop-down-btn" aria-labelledby="dropdownCostPriceButton">
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                <div>
                                                                    <input type="text" class="form-control input-text" name="field_value">
                                                                    <input type="hidden" class="input-field" name="field_name" value="cost_price">
                                                                </div>
                                                                <div>
                                                                    <button type="button" class="btn btn-primary submit-btn" id="bulk_edit">Submit</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                @if(Auth::check() && Auth::user()->email == "support@combosoft.co.uk")
                                                <div class="action-btn responsive_ava_qnty">
                                                    <button class="btn check-active available-qty-btn btn-inactive" type="button" id="dropdownAvailableQtyButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Available Quantity
                                                    </button>

                                                    <form action="Javascript:void(0);">
                                                        <div class="dropdown-menu bulk-action-drop-down-btn" aria-labelledby="dropdownAvailableQtyButton">
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                <div>
                                                                    <input type="text" class="form-control input-text" name="field_value">
                                                                    <input type="hidden" class="input-field" name="field_name" value="actual_quantity">
                                                                </div>
                                                                <div>
                                                                    <button type="submit" class="btn btn-primary submit-btn" id="bulk_edit">Submit</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                                @endif

                                                <div class="action-btn responsive_rrp">
                                                    <button class="btn check-active available-qty-btn btn-inactive" type="button" id="dropdownRrp" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        RRP
                                                    </button>
                                                    <form action="Javascript:void(0);">
                                                        <div class="dropdown-menu bulk-action-drop-down-btn" aria-labelledby="dropdownRrp">
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                <div>
                                                                    <input type="text" class="form-control input-text" name="field_value">
                                                                    <input type="hidden" class="input-field" name="field_name" value="rrp">
                                                                </div>
                                                                <div>
                                                                    <button type="submit" class="btn btn-primary submit-btn" id="bulk_edit">Submit</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="action-btn responsive_base_price">
                                                    <button class="btn check-active available-qty-btn btn-inactive" type="button" id="dropdownBasePrice" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Base Price
                                                    </button>
                                                    <form action="Javascript:void(0);">
                                                        <div class="dropdown-menu bulk-action-drop-down-btn" aria-labelledby="dropdownBasePrice">
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                <div>
                                                                    <input type="text" class="form-control input-text" name="field_value">
                                                                    <input type="hidden" class="input-field" name="field_name" value="base_price">
                                                                </div>
                                                                <div>
                                                                    <button type="submit" class="btn btn-primary submit-btn" id="bulk_edit">Submit</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-danger variation-bulk-delete">Delete</button>
                                            </div>
                                        </div>

                                        <div class="checkbox-count text-primary font-16 ml-3 mb-2"></div>

                                    </div> -->
                                    <!--End Bulk edit arae -->

                                    <input type="hidden" name="master_catalogue_id" id="master_catalogue_id" value="{{$id}}">
                                     <table class="product-draft-table row-expand-table product-draft-view pro-draft-det w-100">
                                         <thead>
                                         <tr>
                                             <th style="width: 3%"><input type="checkbox" class="ckbCheckAll" id="ckbCheckAll" onclick="bulkEditAllCheckbox()"><label for="selectall"></label></th>
                                             @if($product_draft_variation_results->type == 'variable')
                                                <th class="image" style="text-align: center !important; width: 6%">Image</th>
                                             @endif
                                             <th class="id" style="text-align: center !important; width: 6%;">ID</th>
                                             <th class="sku" style="width: 20%">SKU</th>
                                             <th class="qr" style="width: 10%">QR</th>
                                             @if($product_draft_variation_results->type == 'variable')
                                             <th class="variation" style="width: 10%">
                                                 <div class="d-flex justify-content-center">
                                                     <div class="btn-group">
                                                         <form action="Javascript:void(0);" method="post">
                                                             <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                 <i class="fa" aria-hidden="true"></i>
                                                             </a>
                                                             <div class="dropdown-menu filter-content shadow" role="menu">
                                                                 <p>Filter Value</p>

{{--                                                                 <div class="multiselect">--}}
{{--                                                                     <div class="selectBox" onclick="showCheckboxes()">--}}
{{--                                                                         <select>--}}
{{--                                                                             <option>Select an variation</option>--}}
{{--                                                                         </select>--}}
{{--                                                                         <div class="overSelect"></div>--}}
{{--                                                                     </div>--}}
{{--                                                                     <div id="checkboxes">--}}
{{--                                                                         @if(count($variaition_terms) > 0)--}}
{{--                                                                             @foreach($variaition_terms as $terms)--}}
{{--                                                                                 <label for="{{$terms['variation_id']}}">--}}
{{--                                                                                     <div class="d-flex align-items-center">--}}
{{--                                                                                         <div class="d-flex align-items-center">--}}
{{--                                                                                             <input type="checkbox" class="variation_id" id="{{$terms['variation_id']}}">--}}
{{--                                                                                         </div>--}}
{{--                                                                                         <div class="d-flex align-items-center ml-1">--}}
{{--                                                                                             {{$terms['attribute_name']}} -> {{$terms['terms_name']}}--}}
{{--                                                                                         </div>--}}
{{--                                                                                     </div>--}}
{{--                                                                                 </label>--}}
{{--                                                                             @endforeach--}}
{{--                                                                         @endif--}}
{{--                                                                     </div>--}}
{{--                                                                 </div>--}}

                                                                 <select class="form-control b-r-0 choose-variation">
                                                                     @if(count($variaition_terms) > 0)
                                                                         <option hidden>Select Variation</option>
                                                                         @foreach($variaition_terms as $terms)
                                                                             <option value="{{$terms['variation_id']}}"> {{$terms['attribute_name']}} -> {{$terms['terms_name']}}</option>
                                                                         @endforeach
                                                                     @endisset
                                                                 </select>
                                                             </div>
                                                         </form>
                                                     </div>
                                                     <div>Variation</div>
                                                 </div>
                                             </th>
                                             @endif
                                             <th class="ean" style="width: 10%">EAN</th>
                                             <th class="regular-price filter-symbol draftDeFilter" style="width: 10%; text-align: center !important;">
                                                 <div class="d-flex justify-content-center">
                                                     <div class="btn-group">
                                                         <form action="Javascript:void(0);" method="post">
                                                             <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                 <i class="fa" aria-hidden="true"></i>
                                                             </a>
                                                             <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                                 <p>Filter Value</p>
                                                                 <div class="d-flex">
                                                                     <div>
                                                                         <select class="form-control" id="aggregate_condition">
                                                                             <option value="=">=</option>
                                                                             <option value="<"><</option>
                                                                             <option value=">">></option>
                                                                             <option value="<=">≤</option>
                                                                             <option value=">=">≥</option>
                                                                         </select>
                                                                     </div>
                                                                     <div class="ml-2">
                                                                         <input type="number" class="form-control input-text symbol-filter-input-text base_price_reset">
                                                                     </div>
                                                                 </div>
{{--                                                                 <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">--}}
{{--                                                                     <input id="opt-out4" type="checkbox" name="opt_out" value="1"><label for="opt-out4">Opt Out</label>--}}
{{--                                                                 </div>--}}
{{--                                                                 <button type="submit" class="btn btn-primary filter-apply-btn float-right" onclick="searchColumn();">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>--}}
                                                             </div>
                                                         </form>
                                                     </div>
                                                     <div>Regular Price</div>
                                                 </div>
                                             </th>
                                             <th class="sales-price filter-symbol draftDeFilter" style="width: 10%; text-align: center !important;">
                                                 <div class="d-flex justify-content-center">
                                                     <div class="btn-group">
                                                         <form action="Javascript:void(0);" method="post">
                                                             <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                 <i class="fa" aria-hidden="true"></i>
                                                             </a>
                                                             <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                                 <p>Filter Value</p>
                                                                 <div class="d-flex">
                                                                     <div>
                                                                         <select class="form-control" id="aggregate_condition">
                                                                             <option value="=">=</option>
                                                                             <option value="<"><</option>
                                                                             <option value=">">></option>
                                                                             <option value="<=">≤</option>
                                                                             <option value=">=">≥</option>
                                                                         </select>
                                                                     </div>
                                                                     <div class="ml-2">
                                                                         <input type="number" class="form-control input-text symbol-filter-input-text base_price_reset">
                                                                     </div>
                                                                 </div>
{{--                                                                 <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">--}}
{{--                                                                     <input id="opt-out5" type="checkbox" name="opt_out" value="1"><label for="opt-out5">Opt Out</label>--}}
{{--                                                                 </div>--}}
{{--                                                                 <button type="submit" class="btn btn-primary filter-apply-btn float-right" >Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>--}}
                                                             </div>
                                                         </form>
                                                     </div>
                                                     <div>Sales Price</div>
                                                 </div>
                                             </th>
                                             @if (Auth::check() && in_array('1',explode(',',Auth::user()->role)))
                                             <th class="cost-price filter-symbol" style="width: 10%; text-align: center !important;">
                                                 <div class="d-flex justify-content-center">
                                                     <div class="btn-group">
                                                         <form action="" method="">
                                                             <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                 <i class="fa" aria-hidden="true"></i>
                                                             </a>
                                                             <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                                 <p>Filter Value</p>
                                                                 <div class="d-flex">
                                                                     <div>
                                                                         <select class="form-control" name="aggregate_condition">
                                                                             <option value="=">=</option>
                                                                             <option value="<"><</option>
                                                                             <option value=">">></option>
                                                                             <option value="<=">≤</option>
                                                                             <option value=">=">≥</option>
                                                                         </select>
                                                                     </div>
                                                                     <div class="ml-2">
                                                                         <input type="text" class="form-control input-text symbol-filter-input-text base_price_reset" name="search_value">
                                                                     </div>
                                                                 </div>
                                                                 <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                     <input id="opt-out6" type="checkbox" name="opt_out" value="1"><label for="opt-out6">Opt Out</label>
                                                                 </div>
                                                                 <input type="hidden" name="column_name" value="">
                                                                 <input type="hidden" name="route_name" value="">
                                                                 <input type="hidden" name="status" value="">
                                                                 <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                             </div>
                                                         </form>
                                                     </div>
                                                     <div>Cost Price</div>
                                                 </div>
                                             </th>
                                             @endif
                                             <th class="rrp filter-symbol draftDeFilter" style="width: 10%; text-align: center !important;">
                                                 <div class="d-flex justify-content-center">
                                                     <div class="btn-group">
                                                         <form action="Javascript:void(0);" method="post">
                                                             <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                 <i class="fa" aria-hidden="true"></i>
                                                             </a>
                                                             <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                                 <p>Filter Value</p>
                                                                 <div class="d-flex">
                                                                     <div>
                                                                         <select class="form-control" id="aggregate_condition">
                                                                             <option value="=">=</option>
                                                                             <option value="<"><</option>
                                                                             <option value=">">></option>
                                                                             <option value="<=">≤</option>
                                                                             <option value=">=">≥</option>
                                                                         </select>
                                                                     </div>
                                                                     <div class="ml-2">
                                                                         <input type="number" class="form-control input-text symbol-filter-input-text base_price_reset">
                                                                     </div>
                                                                 </div>
{{--                                                                 <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">--}}
{{--                                                                     <input id="opt-out7" type="checkbox" name="opt_out" value="1"><label for="opt-out7">Opt Out</label>--}}
{{--                                                                 </div>--}}
{{--                                                                 <button type="submit" class="btn btn-primary filter-apply-btn float-right" onclick="searchColumn();">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>--}}
                                                             </div>
                                                         </form>
                                                     </div>
                                                     <div>RRP</div>
                                                 </div>
                                             </th>
                                             <th class="base_price filter-symbol draftDeFilter" style="width: 10%; text-align: center !important;">
                                                 <div class="d-flex justify-content-center">
                                                     <div class="btn-group">
                                                         <form action="Javascript:void(0);" method="post">
                                                             <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                 <i class="fa" aria-hidden="true"></i>
                                                             </a>
                                                             <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                                 <p>Filter Value</p>
                                                                 <div class="d-flex">
                                                                     <div>
                                                                         <select class="form-control" id="aggregate_condition">
                                                                             <option value="=">=</option>
                                                                             <option value="<"><</option>
                                                                             <option value=">">></option>
                                                                             <option value="<=">≤</option>
                                                                             <option value=">=">≥</option>
                                                                         </select>
                                                                     </div>
                                                                     <div class="ml-2">
                                                                         <input type="number" class="form-control input-text symbol-filter-input-text base_price_reset">
                                                                     </div>
                                                                 </div>
{{--                                                                 <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">--}}
{{--                                                                     <input id="opt-out8" type="checkbox" name="opt_out" value="1"><label for="opt-out8">Opt Out</label>--}}
{{--                                                                 </div>--}}
{{--                                                                 <button type="submit" class="btn btn-primary filter-apply-btn float-right" onclick="searchColumn();">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>--}}
                                                             </div>
                                                         </form>
                                                     </div>
                                                     <div>Base Price</div>
                                                 </div>
                                             </th>
                                             <th class="sold filter-symbol draftDeFilter" style="width: 5%; text-align: center !important;">
                                                 <div class="d-flex justify-content-center">
                                                     <div class="btn-group">
                                                         <form action="Javascript:void(0);" method="post">
                                                             <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                 <i class="fa" aria-hidden="true"></i>
                                                             </a>
                                                             <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                                 <p>Filter Value</p>
                                                                 <div class="d-flex">
                                                                     <div>
                                                                         <select class="form-control" id="aggregate_condition">
                                                                             <option value="=">=</option>
                                                                             <option value="<"><</option>
                                                                             <option value=">">></option>
                                                                             <option value="<=">≤</option>
                                                                             <option value=">=">≥</option>
                                                                         </select>
                                                                     </div>
                                                                     <div class="ml-2">
                                                                         <input type="number" id="sold_price_reset" class="form-control input-text symbol-filter-input-text base_price_reset">
                                                                     </div>
                                                                 </div>
{{--                                                                 <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">--}}
{{--                                                                     <input id="opt-out9" type="checkbox" name="opt_out" value="1"><label for="opt-out9">Opt Out</label>--}}
{{--                                                                 </div>--}}
{{--                                                                 <button type="submit" class="btn btn-primary filter-apply-btn float-right" onclick="searchColumn();">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>--}}
                                                             </div>
                                                         </form>
                                                     </div>
                                                     <div>Sold</div>
                                                 </div>
                                             </th>
                                             <th class="available-qty filter-symbol draftDeFilter" style="width: 10%; text-align: center !important;">
                                                 <div class="d-flex justify-content-center">
                                                     <div class="btn-group">
                                                         <form action="Javascript:void(0);" method="post">
                                                             <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                 <i class="fa" aria-hidden="true"></i>
                                                             </a>
                                                             <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                                 <p>Filter Value</p>
                                                                 <div class="d-flex">
                                                                     <div>
                                                                         <select class="form-control" id="aggregate_condition">
                                                                             <option value="=">=</option>
                                                                             <option value="<"><</option>
                                                                             <option value=">">></option>
                                                                             <option value="<=">≤</option>
                                                                             <option value=">=">≥</option>
                                                                         </select>
                                                                     </div>
                                                                     <div class="ml-2">
                                                                         <input type="number" class="form-control input-text symbol-filter-input-text base_price_reset">
                                                                     </div>
                                                                 </div>
{{--                                                                 <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">--}}
{{--                                                                     <input id="opt-out10" type="checkbox" name="opt_out" value="1"><label for="opt-out10">Opt Out</label>--}}
{{--                                                                 </div>--}}
{{--                                                                 <button type="submit" class="avl btn btn-primary filter-apply-btn float-right ">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>--}}
                                                             </div>
                                                         </form>
                                                     </div>
                                                     <div>Available Qty</div>
                                                 </div>
                                             </th>
                                             @if($shelf_use == 1)
                                                 <th class="shelf-qty filter-symbol draftDeFilter" style="width: 10%; text-align: center !important;">
                                                     <div class="d-flex justify-content-center">
                                                         <div class="btn-group">
                                                             <form action="Javascript:void(0);" method="post">
                                                                 <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                     <i class="fa" aria-hidden="true"></i>
                                                                 </a>
                                                                 <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                                     <p>Filter Value</p>
                                                                     <div class="d-flex">
                                                                         <div>
                                                                             <select class="form-control" id="aggregate_condition">
                                                                                 <option value="=">=</option>
                                                                                 <option value="<"><</option>
                                                                                 <option value=">">></option>
                                                                                 <option value="<=">≤</option>
                                                                                 <option value=">=">≥</option>
                                                                             </select>
                                                                         </div>
                                                                         <div class="ml-2">
                                                                             <input type="number" class="form-control input-text symbol-filter-input-text base_price_reset" id="myInput">
                                                                         </div>
                                                                     </div>
{{--                                                                     <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">--}}
{{--                                                                         <input id="opt-out11" type="checkbox" name="opt_out" value="1"><label for="opt-out11">Opt Out</label>--}}
{{--                                                                     </div>--}}
{{--                                                                     <button type="submit" class="btn btn-primary filter-apply-btn float-right" onclick="searchColumn();">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>--}}
                                                                 </div>
                                                             </form>
                                                         </div>
                                                         <div>Shelf Qty</div>
                                                     </div>
                                                 </th>
                                             @endif
                                             <th style="width: 6%">Actions
                                                <div id="all_reset_button" style="display:none;">
                                                    <a style="padding:5px;" title="Clear filters" href="{{url()->current()}}/#product-details-page" id="clear_all_field" class='btn btn-outline-info'>
                                                        <img src="{{asset('assets/common-assets/25.png')}}">
                                                    </a>
                                                </div>
                                            </th>
                                         </tr>
                                         </thead>
                                         <tbody id="product_variation_table">
                                         @if(count($product_draft_variation_results->product_variations) > 0)
                                             @foreach($product_draft_variation_results->product_variations as $product_variation)
                                                 @php
                                                     $data = \App\ShelfedProduct::where('variation_id',$product_variation->id)->sum('quantity');
                                                     $total_sold = 0;
                                                     if(count($product_variation->order_products) > 0){
                                                         foreach ($product_variation->order_products as $product){
                                                             $total_sold += $product->sold;
                                                         }
                                                     }
                                                 @endphp
                                                 <tr id="variation-wise-show-{{$product_variation->id}}">
                                                     <td style="width: 3%">
                                                         <input type="checkbox" class="checkBoxClass" id="customCheck" onclick="bulkEditCheckBox()" value="{{$product_variation->id ?? ''}}">
                                                     </td>
                                                     @if($product_draft_variation_results->type == 'variable')
                                                         @if($product_variation->image != null)
                                                             <td class="image" style="text-align: center !important; width: 6%">
                                                                 <a href="{{$product_variation->image ?? ''}}"  title="Click to expand" target="_blank">
                                                                     <img src="{{$product_variation->image ?? ''}}" class="thumb-md" alt="catalogue-details-image">
                                                                 </a>
                                                             </td>
                                                         @elseif(isset($product_image[0]->image_url))
                                                             <td class="image" style="text-align: center !important; width: 6%">
                                                                 <img src="{{(filter_var($product_image[0]->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product_image[0]->image_url : $product_image[0]->image_url}}" class="thumb-md" alt="catalogue-details-image">
                                                             </td>
                                                         @else
                                                             <td class="image" style="text-align: center !important; width: 6%">
                                                                 <img src="{{asset('assets/common-assets/no_image.jpg')}}" class="thumb-md" title="No img available" alt="catalogue-details-image">
                                                             </td>
                                                         @endif
                                                     @endif
                                                     <td class="id" style="text-align: center !important; width: 6%;">
                                                         <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                             <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_variation->id ?? ''}}</span>
                                                             <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                         </div>
                                                     </td>
                                                     <td class="sku" style="width: 20%">
                                                         <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                             <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button w-100">{{$product_variation->sku ?? ''}}</span>
                                                             <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                         </div>
                                                     </td>
                                                     <td class="qr" style="width: 10%">
                                                         <div class="pt-2 pb-2"><a target="_blank" href="{{url('print-barcode/'.$product_variation->id ?? '')}}">
                                                         {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(60)->generate($product_variation->sku ?? ''); !!}
                                                         </a>

                                                         </div>
                                                     </td>
                                                     @if($product_draft_variation_results->type == 'variable')
                                                         <td class="variation" style="width: 10%">
                                                            @isset($product_variation->attribute)
                                                                @php
                                                                    $exist = [];
                                                                    $notExist = [];
                                                                @endphp
                                                                <span class="modified-variation-{{$product_variation->id}}">
                                                                @foreach(\Opis\Closure\unserialize($product_variation->attribute) as $attribute_value)
                                                                     <label><b style="color: #7e57c2">{{$attribute_value['attribute_name'] ?? ''}}</b> <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{$attribute_value['terms_name'] ?? ''}}, </label>
                                                                    @php
                                                                        $exist[] = $attribute_value['attribute_id'];
                                                                    @endphp
                                                                @endforeach
                                                                </span>
                                                                <div class="product-variation-div-{{$product_variation->id}}">
                                                                    @foreach(\Opis\Closure\unserialize($product_draft_variation_results->attribute) as $attribute_info_key => $attribute_info_value)
                                                                        @foreach($attribute_info_value as $attribute_key => $attribute_val)
                                                                            @if(!in_array($attribute_info_key,$exist))
                                                                                <div class="btn-group" id="submit-variation-{{$product_variation->id}}">
                                                                                    <select name="" id="" class="form-control attribute-term">
                                                                                        <option value="">Select Variation</option>
                                                                                        @foreach($attribute_val as $key => $val)
                                                                                            <option value="{{$attribute_info_key}}/{{$val['attribute_term_name']}}">{{$val['attribute_term_name'] ?? ''}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    <input type="hidden" class="variation-id" value="{{$product_variation->id}}">

                                                                                </div>
                                                                                @php
                                                                                    $notExist[] = $attribute_info_key;
                                                                                @endphp
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                    @if($notExist)
                                                                        <button type="button" class="btn btn-success btn-sm add-additional-term" onclick="submitVariation({{$product_variation->id}})">add</button>
                                                                    @endif
                                                                </div>
                                                            @endisset
                                                         </td>
                                                     @endif
                                                     <td class="ean" style="width: 10%">{{$product_variation->ean_no ?? ''}}</td>
                                                     <td class="regular-price" style="width: 10% !important;">
                                                         <div class="d-flex justify-content-center align-items-center">
                                                             <div class="shown" id="regular_price_{{$product_variation->id ?? ''}}">
                                                                <span>
                                                                    <p>{{$product_variation->regular_price ?? 0}}</p>
                                                                    <div class="hover-shown overflow-hidden">
                                                                         <form action="Javascript:void(0);">
                                                                              <a href="#" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-pencil"></i></a>
                                                                              <div class="dropdown-menu pen-edit-btn" aria-labelledby="dropdownMenuButton1">
                                                                                  <div class="d-flex justify-content-center align-items-center">
                                                                                      <div>
                                                                                          <input type="text" class="form-control input-text form_control_hover_shown" name="field_value">
                                                                                          <input type="hidden" class="input-field" name="field_name" value="regular_price">
                                                                                      </div>
                                                                                      <div>
                                                                                          <button type="button" class="btn btn-primary submit-btn" id="{{$product_variation->id ?? ''}}">Submit</button>
                                                                                      </div>
                                                                                  </div>
                                                                              </div>
                                                                         </form>
                                                                    </div>
                                                                </span>
                                                             </div>
                                                         </div>
                                                     </td>
                                                     <td class="sales-price" style="width: 10% !important;">
                                                         <div class="d-flex justify-content-center align-items-center">
                                                             <div class="shown" id="sale_price_{{$product_variation->id ?? ''}}">
                                                                 <span>
                                                                     <p>{{$product_variation->sale_price ?? ''}}</p>
                                                                     <div class="hover-shown overflow-hidden">
                                                                     <form action="Javascript:void(0);">
                                                                          <a href="#" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-pencil"></i></a>
                                                                          <div class="dropdown-menu pen-edit-btn" aria-labelledby="dropdownMenuButton2">
                                                                              <div class="d-flex justify-content-center align-items-center">
                                                                                  <div>
                                                                                      <input type="text" class="form-control input-text form_control_hover_shown" name="field_value">
                                                                                      <input type="hidden" class="input-field" name="field_name" value="sale_price">
                                                                                  </div>
                                                                                  <div>
                                                                                      <button type="button" class="btn btn-primary submit-btn" id="{{$product_variation->id ?? ''}}">Submit</button>
                                                                                  </div>
                                                                              </div>
                                                                          </div>
                                                                     </form>
                                                                     </div>
                                                                 </span>
                                                             </div>
                                                         </div>
                                                     </td>
                                                     @if (Auth::check() && in_array('1',explode(',',Auth::user()->role)))
                                                     <td class="cost-price" style="width: 10% !important;">
                                                         <div class="d-flex justify-content-center align-items-center">
                                                             <div class="shown" id="cost_price_{{$product_variation->id ?? ''}}">
                                                                 <span>
                                                                     {{$product_variation->cost_price ?? ''}}
                                                                     <div class="hover-shown overflow-hidden">
                                                                     <form action="Javascript:void(0);">
                                                                          <a href="#" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-pencil"></i></a>
                                                                          <div class="dropdown-menu pen-edit-btn" aria-labelledby="dropdownMenuButton2">
                                                                              <div class="d-flex justify-content-center align-items-center">
                                                                                  <div>
                                                                                       <input type="text" class="form-control input-text" name="field_value">
                                                                                       <input type="hidden" class="input-field" name="field_name" value="cost_price">
                                                                                  </div>
                                                                                  <div>
                                                                                      <button type="button" class="btn btn-primary submit-btn" id="{{$product_variation->id ?? ''}}">Submit</button>
                                                                                  </div>
                                                                              </div>
                                                                          </div>
                                                                     </form>
                                                                     </div>
                                                                 </span>
                                                             </div>
                                                         </div>
                                                     </td>
                                                     @endif
                                                     <td class="rrp" style="width: 10% !important;">
                                                         <div class="d-flex justify-content-center align-items-center">
                                                             <div class="shown" id="rrp_{{$product_variation->id ?? ''}}">
                                                                 <span>
                                                                     <p>{{$product_variation->rrp ?? ''}}</p>
                                                                     <div class="hover-shown overflow-hidden">
                                                                     <form action="Javascript:void(0);">
                                                                          <a href="#" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-pencil"></i></a>
                                                                          <div class="dropdown-menu pen-edit-btn" aria-labelledby="dropdownMenuButton2">
                                                                              <div class="d-flex justify-content-center align-items-center">
                                                                                  <div>
                                                                                      <input type="text" class="form-control input-text form_control_hover_shown" name="field_value">
                                                                                      <input type="hidden" class="input-field" name="field_name" value="rrp">
                                                                                  </div>
                                                                                  <div>
                                                                                      <button type="button" class="btn btn-primary submit-btn" id="{{$product_variation->id ?? ''}}">Submit</button>
                                                                                  </div>
                                                                              </div>
                                                                          </div>
                                                                     </form>
                                                                     </div>
                                                                 </span>
                                                             </div>
                                                         </div>
                                                     </td>
                                                     <td class="base_price" style="width: 10% !important;">
                                                         <div class="d-flex justify-content-center align-items-center">
                                                             <div class="shown" id="base_price_{{$product_variation->id ?? ''}}">
                                                                 <span>
                                                                     <p>{{$product_variation->base_price ?? ''}}</p>
                                                                     <div class="hover-shown overflow-hidden">
                                                                     <form action="Javascript:void(0);">
                                                                          <a href="#" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-pencil"></i></a>
                                                                          <div class="dropdown-menu pen-edit-btn" aria-labelledby="dropdownMenuButton2">
                                                                              <div class="d-flex justify-content-center align-items-center">
                                                                                  <div>
                                                                                      <input type="text" class="form-control input-text form_control_hover_shown" name="field_value">
                                                                                      <input type="hidden" class="input-field" name="field_name" value="base_price">
                                                                                  </div>
                                                                                  <div>
                                                                                      <button type="button" class="btn btn-primary submit-btn" id="{{$product_variation->id ?? ''}}">Submit</button>
                                                                                  </div>
                                                                              </div>
                                                                          </div>
                                                                     </form>
                                                                     </div>
                                                                 </span>
                                                             </div>
                                                         </div>
                                                     </td>
                                                     <td class="sold" style="width: 5% !important; text-align: center !important;">{{$total_sold ?? 0}}</td>
                                                     <td class="available-qty" style="width: 10% !important;">
                                                         <div class="d-flex justify-content-center align-items-center">
                                                             <div class="shown" id="actual_quantity_{{$product_variation->id ?? ''}}">
                                                                 <span>
                                                                    @if($product_variation->notification_status == 1 && $product_variation->actual_quantity < $product_variation->low_quantity)
                                                                        <p class="text-center">{{$product_variation->actual_quantity ?? ''}}</p><span class="label label-table label-danger">Low Quantity {{$product_variation->low_quantity ?? ''}}</span>
                                                                    @else
                                                                        <p>{{$product_variation->actual_quantity ?? ''}}</p>
                                                                    @endif
                                                                    @if (Auth::check() && !empty(array_intersect(['1'],explode(',',Auth::user()->role))))
                                                                     <div class="hover-shown overflow-hidden">
                                                                         <form action="Javascript:void(0);">
                                                                              <a href="#" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-pencil"></i></a>
                                                                              <div class="dropdown-menu pen-edit-btn" aria-labelledby="dropdownMenuButton3">
                                                                                  <div class="d-flex justify-content-center align-items-center">
                                                                                      <div>
                                                                                          <input type="text" class="form-control input-text form_control_hover_shown" name="field_value">
                                                                                          <input type="hidden" class="input-field" name="field_name" value="actual_quantity">
                                                                                      </div>
                                                                                      <div>
                                                                                          <button type="button" class="btn btn-primary submit-btn" id="{{$product_variation->id ?? ''}}">Submit</button>
                                                                                      </div>
                                                                                  </div>
                                                                              </div>
                                                                         </form>
                                                                    </div>
                                                                    @endif
                                                                 </span>
                                                             </div>
                                                         </div>
                                                     </td>
                                                     @if($shelf_use == 1)
                                                         <td class="shelf-qty" id="shelfQuantity-{{$product_variation->id}}" style="width: 10% !important; text-align: center !important;">{{$data ?? 0}}@if(count($product_variation->get_reshelved_product) > 0)<pre class="text-danger">(Pending Reshelve: {{$product_variation->get_reshelved_product[0]->pending_reshelve}})</pre>@endif</td>
                                                     @endif
                                                     <td class="actions" style="width: 6%">
                                                         <div class="btn-group dropup">
                                                             <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                 Manage
                                                             </button>
                                                             <div class="dropdown-menu">
                                                                 <!-- Dropdown menu links -->
                                                                 <div class="dropup-content catalogue-dropup-content">
                                                                     <div class="action-1">
                                                                         <!-- <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{route('product-variation.edit',$product_variation->id ?? '')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div> -->
                                                                         <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{url('variation-details/'.Crypt::encrypt($product_variation->id ?? ''))}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                                                         @if($shelf_use == 1 && Auth::check() && !empty(array_intersect(['1'],explode(',',Auth::user()->role))))
                                                                             <div class="align-items-center mr-2" data-toggle="tooltip" data-placement="top" title="Shelf View"><a class="btn-size shelf-btn" href="#" data-toggle="modal" target="_blank" data-target="#myModal{{$product_variation->id ?? ''}}"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a></div>
                                                                         @endif
                                                                         <div class="align-items-center mr-2"><a class="btn-size invoice-btn" href="{{url('catalogue-product-invoice-receive/'.$product_draft_variation_results->id.'/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Receive Invoice"><i class="fa fa-book" aria-hidden="true"></i></a></div>
                                                                         <!-- @if(Auth::check() && Auth::user()->email == "support@combosoft.co.uk") -->
                                                                         <div class="align-items-center mr-2"><a class="btn-size" href="Javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Declare Defect" onclick="declare_defect({{$product_variation->id}})"><i class="fa fa-bug" aria-hidden="true"></i></a></div>
                                                                         <!-- @endif -->
                                                                         @if(Session::get('ebay') == 1)
                                                                         @if($product_draft_variation_results->type == 'variable')
                                                                            <div class="align-items-center mr-2"> <a class="btn-size list-on-ebay-btn" style="padding: 7px 9px 7px 9px;" href="{{url('create-ebay-product-variation/'.$product_draft_variation_results->id.'/'.$product_variation->sku)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List on eBay"><i class="fab fa-ebay" aria-hidden="true"></i></a></div>
                                                                         @endif
                                                                         @endif
                                                                         <div class="align-items-center mr-2"><a class="btn-size print-btn" target="_blank" href="{{url('print-barcode/'.$product_variation->id ?? '')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print" aria-hidden="true"></i></a></div>
                                                                         <div class="align-items-center">
                                                                             <form action="{{route('product-variation.destroy',$product_variation->id ?? '')}}" method="post">
                                                                                 @csrf
                                                                                 @method('DELETE')
                                                                                 <button class="del-pub delete-btn" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('product');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                             </form>
                                                                         </div>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     </td>


                                                     <div class="shelf-product-modal modal fade" id="myModal{{$product_variation->id ?? ''}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                         <div class="modal-dialog" role="document">
                                                             <div class="modal-content">

                                                             <script>
                                                                  $('#myModal{{$product_variation->id ?? ''}}').on('shown.bs.modal', function() {
                                                                        $(document).off('focusin.modal');
                                                                    });
                                                             </script>

                                                                 <!-- Modal Header -->
                                                                 <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Shelf Product</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                 </div>

                                                                 <!-- Modal body -->
                                                                 <div class="modal-body">
                                                                     <div class="row">
                                                                         <div class="col-md-12">
                                                                             <div class="p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                                                                                <div class="mb-2 add-reason" style="width: -webkit-fill-available;">
                                                                                    <a href="Javascript:void(0)" class="btn btn-success catalogue-btn-view-details">Add Reason</a>
                                                                                </div>
                                                                                 <div style="border: 1px solid #ccc;">
                                                                                     <div class="row m-t-10">
                                                                                         <div class="col-3 text-center">
                                                                                             <h6> Shelf Name </h6>
                                                                                             <hr width="60%">
                                                                                         </div>
                                                                                         <div class="col-3 text-center">
                                                                                             <h6>Quantity</h6>
                                                                                             <hr width="20%">
                                                                                         </div>
                                                                                         @if (Auth::check() && !empty(array_intersect(['1'],explode(',',Auth::user()->role))))
                                                                                         <div class="col-3 text-center">
                                                                                             <h6>Action</h6>
                                                                                             <hr width="60%">
                                                                                         </div>
                                                                                         @endif
                                                                                     </div>
                                                                                     @if(count($product_variation->shelf_quantity) > 0)
                                                                                         @foreach($product_variation->shelf_quantity as $shelf)
                                                                                             @if($shelf->pivot->quantity != 0)
                                                                                                 <div class="row">
                                                                                                     <div class="col-3 text-center m-b-10">
                                                                                                         <h7> {{$shelf->shelf_name ?? ''}} </h7>
                                                                                                     </div>
                                                                                                     <div class="col-3 text-center m-b-10">
                                                                                                         <h7 class="qnty_{{$product_variation->id ?? ''}}_{{$shelf->pivot->id ?? ''}}"> {{$shelf->pivot->quantity ?? ''}} </h7>
                                                                                                     </div>
                                                                                                     @if (Auth::check() && !empty(array_intersect(['1'],explode(',',Auth::user()->role))))
                                                                                                      <div class="col-3 text-center m-b-10">
                                                                                                         <button type="button" class="btn btn-default waves-effect waves-light btn-sm change_quantity" id="{{$product_variation->id ?? ''}}_{{$shelf->pivot->id ?? ''}}">Change Quantity</button>
                                                                                                     </div>
                                                                                                     @endif
                                                                                                 </div>
                                                                                             @endif
                                                                                         @endforeach
                                                                                     @endif
                                                                                     <div class="row p-20 change_quantity_div" style="display: none;">
                                                                                         <div class="col-12">
                                                                                             <h3>Change Info:</h3><span></span>
                                                                                             <hr>
                                                                                             <div class="form-group">
                                                                                                 <label class="required">Quantity</label>
                                                                                                 <input type="text" class="form-control c_quantity_{{$product_variation->id ?? ''}}" name="c_quantity" id="">
                                                                                             </div>
                                                                                             <div class="form-group">
                                                                                                 <label for="">Reason</label>
                                                                                                 <select class="form-control c_reason_{{$product_variation->id ?? ''}}" name="c_reason" id="c_reason" required>
                                                                                                    <option value="">Select Reason</option>
                                                                                                    @if(count($shelfQuantityChangeReason) > 0)
                                                                                                        @foreach($shelfQuantityChangeReason as $reason)
                                                                                                            <option value="{{$reason->reason}}">{{$reason->reason}}</option>
                                                                                                        @endforeach
                                                                                                    @endif
                                                                                                 </select>
                                                                                             </div>
                                                                                             <div class="text-center">
                                                                                                <button type="button" class="btn btn-primary add-change-qty waves-effect waves-light">Add</button>
                                                                                             </div>
                                                                                         </div>
                                                                                     </div>
                                                                                 </div>
                                                                             </div> <!-- end card -->
                                                                         </div> <!-- end col-12 -->
                                                                     </div> <!-- end row -->
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     </div>  <!-- // The Modal -->
                                                 </tr>
                                             @endforeach
                                         @endif
                                         </tbody>
                                     </table>

                             </div>
                         </div> <!-- end row -->

                </div> <!-- end card box -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->


<!----------- Add Terms To Catalogue Modal View------------
------------------------------------------------------------>

    <div class="category-modal add-terms-catalog" id="addTermsModal" style="display: none">
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
                            @if($attribute_info_unserialize != null && count($attribute_info_unserialize) > 0)

                                @foreach($attribute_info_unserialize as $attribute_id => $attribute_name_array)
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

    <!--TermsBtn The Modal -->



<!-----------End Add Terms To Catalogue Modal View------------
------------------------------------------------------------>




<script type="text/javascript">

// $('.select2').select2();
$("select").select2();
        $("select").on("select2:select", function (evt) {
        var element = evt.params.data.element;
        var $element = $(element);
        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
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

            $('#sortableAttribute').sortable({
                handle: 'button',
                cancel: ''
            }).disableSelection()
        });

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
            allTags.forEach(function (el) {
                console.log(allTags);
                $('#attribute-terms-container-'+el).find('select.select2-hidden-accessible').attr('disabled', false)
                $('#attribute-terms-container-'+el).show()
            });
        });




    function bulkEditCheckBox(){
        // console.log('test1')
        if($('.checkBoxClass:checked').length > 0) {
            $(".bulk-edit-drawer-box").show({
                duration: 800,
                specialEasing: {
                width: "linear",
                }
            });
            $('.variation-modal').hide()
        }else{
            $('.bulk-edit-drawer-box').hide(1000);
        }
    }

    function bulkEditAllCheckbox(){
        // console.log('test2')
        if($('.ckbCheckAll:checked').length > 0) {
            $(".bulk-edit-drawer-box").show({
                duration: 800,
                specialEasing: {
                width: "linear",
                }
            });
            $('.variation-modal').hide()
        }else{
            $('.bulk-edit-drawer-box').hide(1000);
        }
    }




    //Datatable row-wise searchable option
    $(document).ready(function(){
        $("#row-wise-search").on("keyup", function() {
            let value = $(this).val().toLowerCase();
            $("#table-body tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });

        });
    });





        //Check uncheck property count
        // $('.ckbCheckAll, .checkBoxClass').click(function () {
        //     if($('.ckbCheckAll:checked').length > 0 || $('.checkBoxClass:checked').length > 0) {
        //         $('.product-draft-checkbox-content').show(500);
        //     }else{
        //         $('.product-draft-checkbox-content').hide(500);
        //     }
        // })

        const variationColumnCountCheckedAll = function() {
            let counter = $(".checkBoxClass:checked").length;
            $(".checkbox-count").html( counter + " Selected!" );
            // console.log(counter + ' variation selected!');
        };

        $(".checkBoxClass").on( "click", variationColumnCountCheckedAll );

        $('.ckbCheckAll').click(function() {
            if ($(this).is(":checked")) {
                $('tbody').find('tr:visible .checkBoxClass').prop('checked', true);
                variationColumnCountCheckedAll();
            }
            else {
                $('tbody').find('tr:visible .checkBoxClass').prop('checked', false);
                $('.product-draft-checkbox-content').hide(500);
            }
        })

        $(".checkBoxClass").change(function() {
            if (!$(this).prop("checked")) {
                $(".ckbCheckAll").prop("checked", false);
            }
        });
        //End check uncheck property count

        //Bulk action active inactive
        $(document).ready(function(){
            $('div.bulk-action-btn-group button.btn').click(function(){
                $('div.bulk-action-btn-group button.check-active').removeClass('btn-active');
                $(this).addClass('btn-active');
                var variation_ids = [];
                $('table tbody tr td :checkbox:checked').each(function(i){
                    variation_ids[i] = $(this).val();
                });
                if(variation_ids.length == 0){
                    Swal.fire({
                        title: 'Please Select Atleast One Product',
                        icon: 'warning'
                    })
                    $('.modal').hide(500)
                    return false
                }
            });
            $('form button').click(function(){
                var edit_type = $(this).attr('id');
                var quantityInfo = []
                if(edit_type == 'bulk_edit'){
                    var variation_ids = [];
                    $('table tbody tr:visible td :checkbox:checked').each(function(i){
                        variation_ids[i] = $(this).val();

                        // quantity['avaiableQuantity'] = $(this).closest('tr').find('td.available-qty div.shown span p').text()
                        // quantity['shelfQuantity'] = $(this).closest('tr').find('td.shelf-qty').text()
                        quantityInfo[i] = {
                            'variationId': $(this).val(),
                            'availableQuantity': $(this).closest('tr').find('td.available-qty div.shown span p').text(),
                            'shelfQuantity': $(this).closest('tr').find('td.shelf-qty').text()
                        }
                    });
                }else{
                    var variation_ids = [];
                    variation_ids.push(edit_type);
                }
                var input_value = $(this).closest('form').find('.input-text').val();
                var input_field = $(this).closest('form').find('.input-field').val();

                if(input_value == ''){
                    alert('Please give input value');
                    return false;
                }else if(variation_ids.length == 0){
                    alert('Please select product');
                    return false;
                }
                // return false
                // console.log(variation_ids)
                $.ajax({
                    type: "post",
                    url: "{{url('variation-price-bulk-update')}}",
                    data: {
                        "_token" : "{{csrf_token()}}",
                        "input_value" : input_value,
                        "input_field" : input_field,
                        "variation_ids" : variation_ids,
                        "quantityInfo" : quantityInfo,
                        'editType' : edit_type
                    },
                    beforeSend: function(){
                        // Show image container
                        $("#ajax_loader").show();
                    },
                    success: function (response) {
                        console.log(response)
                        if(response.msg == 'success'){
                            $('table thead tr').find('input#ckbCheckAll:checkbox').prop('checked',false)
                            $('.checkbox-count').html('')
                            $('.product-draft-checkbox-content').hide(500)
                            $('.modal').hide(500)
                            $('.bulk-edit-drawer-box').hide(500)
                            $.each(response.responseContentShow, function( index, value ) {
                                $('#'+input_field+'_'+value.variation_id).text(value.updatedQuantity);
                                $('table tbody tr#variation-wise-show-'+value.variation_id+' td').find('input:checkbox').prop('checked',false)
                            });
                            // $('.screen-option h5').html('Updated successfully').addClass('text-success');
                            if(response.largerAvailableQuantityProducts.length > 0){
                                var html = '<table class="table"><thead><tr><th scope="col">SKU</th><th scope="col">Old Quantity</th><th scope="col">Updated Quantity</th><th scope="col">Shelf Quantity</th></tr></thead><tbody>';
                                response.largerAvailableQuantityProducts.forEach(function (data) {
                                    html += '<tr><td>' + data.sku + '</td><td>' + data.previousQuantity + '</td><td>' + data.updatedQuantity + '</td><td>' + data.shelfQuantity + '</td></tr>';
                                });
                                html += '</tbody><p class="text-danger">Below SKUs Available Quantity Is Greater Than Shelf Quantity. Please Check These Quantity Again</p></table>';
                            }else{
                                var html = ''
                            }
                            swal.fire({
                                title: 'Successfully Updated',
                                html: html,
                                icon: 'success'
                            })
                        }else {
                            // $('.screen-option h5').html(response.msg).addClass('text-danger');
                            Swal.fire({
                                title: 'Oops...',
                                icon: 'error',
                                text: response.msg
                            })
                        }
                    },
                    complete:function(data){
                        // Hide image container
                        $("#ajax_loader").hide();
                    }
                });
            });
        })
        $(document).ready(function() {
            // Default Datatable
            // $('#datatable').DataTable();
            $('button.change_quantity').on('click',function () {
                var id = $(this).attr('id');
                var id_split = id.split('_');
                $('#myModal'+id_split[0]+' .change_quantity_div input.c_quantity_'+id_split[0]).attr('id','c_quantity_'+id);
                $('#myModal'+id_split[0]+' .change_quantity_div button').attr('id',id);
                $('#myModal'+id_split[0]+' .change_quantity_div span').attr('id',id);

                $('#myModal'+id_split[0]+' .change_quantity_div').slideToggle();
            });

            $('.change_quantity_div button').on('click',function () {
                var full_id = $(this).attr('id');
                var id = full_id.split('_');
                var variation_id = id[0];
                var product_shelf_id = id[1];
                var quantity = $('#myModal'+variation_id+' .change_quantity_div input#c_quantity_'+full_id).val();
                var reason = $('#myModal'+variation_id+' .change_quantity_div select.c_reason_'+variation_id).val();
                if(quantity == ''){
                    alert('Please give change quantity.');
                    return false;
                }
                if(reason == ''){
                    alert('Please select a reason');
                    return false;
                }
                //var reason = $('#myModal'+variation_id+' .change_quantity_div textarea#c_reason').val();
                $.ajax({
                    type: "POST",
                    url: "{{url('shelf_quantity_update')}}",
                    data: {
                        "_token" : "{{csrf_token()}}",
                        "product_shelf_id" : product_shelf_id,
                        "quantity" : quantity,
                        "reason" : reason
                    },
                    success: function (response) {
                        if(response.data == true){
                            $('.qnty_'+full_id).text(quantity);
                            $('#myModal'+variation_id+' .change_quantity_div span#'+full_id).addClass('text-success').html('Quantity updated successfully.');
                            $('#myModal'+variation_id+' .change_quantity_div input#c_quantity_'+full_id).val('');
                            $('#myModal'+variation_id+' .change_quantity_div select.c_reason_'+variation_id).val('');
                            //$('#myModal'+variation_id+' .change_quantity_div textarea#c_reason').val('');
                            var updatedQnty = (parseInt($('#shelfQuantity-'+variation_id).text()) - parseInt(response.oldShelfInfo.quantity)) +  parseInt(quantity);
                            $('#shelfQuantity-'+variation_id).text(updatedQnty);
                        }
                    }
                });
            });

        } );


        //screen option toggle
        $(document).ready(function(){
            $(".screen-option-btn").click(function(){
                $(".screen-option-content").slideToggle(500);
            });

            $('.screen-option select#attribute_image').on('change',function () {
                var ids = $('.screen-option select#attribute_image').val();

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
                            '                                                 </div>';
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
                        html += '<div class="col-md-2"><button type="submit" class="btn btn-primary">Add</button></div>';
                        $('.image_upload_attribute_wise .card').show();
                        $('.image_upload_attribute_wise .card').html(html);
                    }
                });
            });

        });

        // table column hide and show toggle checkbox
        $("input:checkbox").click(function(){
            let column = "."+$(this).attr("name");
            $(column).toggle();
        });
        function valueChanged(){
            if($('#singleVariationImage').is(":checked")) {
                $("#variationImageFile").show();
                $('#singleImageShow').show();
            }
            else {
                $("#variationImageFile").hide();
                $('#singleImageShow').hide();
            }
        }


        //table column by default hide
        $("input:checkbox:not(:checked)").each(function() {
            var column = "table ." + $(this).attr("name");
            $(column).hide();
        });

        //prevent onclick dropdown menu close
        $('.filter-content').on('click', function(event){
            event.stopPropagation();
        });

        //Table inner variation price edit hover content fixed jquery
        (function($) {
            var activeHover;
            $('.shown span').on('mouseenter', function () {
                    if ($(this).index() === activeHover) {
                        return;
                    }
                    $('.shown span').removeClass('contentHover');
                    $(this).addClass('contentHover');
                });
        })(jQuery);


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


            // $(".ckbCheckAll").click(function () {
            //     const variationIds = $('select.choose-variation').val();
            //     console.log(variationIds + ' selected!')
            //     if(variationIds != ''){
            //         variationIds.split('/').forEach(function(id){
            //             $('tbody tr#variation-wise-show-'+id).find('.checkBoxClass').prop('checked',true);
            //             variationColumnCountCheckedAll();
            //         })
            //     }else{
            //         $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            //     }
            // });
            //
            // $(".checkBoxClass").change(function() {
            //     if (!$(this).prop("checked")) {
            //         $(".ckbCheckAll").prop("checked", false);
            //     }
            // });


        // Product draft details variation table row filter
        $(document).ready(function(){
            $('select.choose-variation').on('change',function(){
                var variationIds = $(this).val()

                // if(variationIds != ''){
                //     $(".checkBoxClass").prop('checked', false);
                //     $("#ckbCheckAll").prop("checked",false);
                //     // $('#ckbCheckAll').hide()
                // }else{
                //     $('#ckbCheckAll').show()
                //     $('tbody tr').show()
                //     $(".checkBoxClass").prop('checked', false);
                //     return false
                // }
                var ids = variationIds.split('/')
                $('tbody tr').hide();
                $('tbody tr').each(function(){
                    var rowId = $(this).attr('id')
                    ids.forEach(function(id){
                        if(rowId == 'variation-wise-show-'+id){
                            $('tbody tr#variation-wise-show-'+id).show();
                        }
                    })
                })
            })



            $('div.catalogue-btn-area .available-shelf-quantity').on('click',function(){
                var variation_ids = []
                var variation_info = []
                $('table tbody tr:visible td :checkbox:checked').each(function(i){
                    variation_ids[i] = $(this).val()
                    variation_info[i] = {
                        'id': $(this).val(),
                        'sku': $('tbody tr#variation-wise-show-'+$(this).val()).find('td.sku span.id_copy_button').text(),
                        'availableQuantity': $('tbody tr#variation-wise-show-'+$(this).val()).find('td.available-qty span p').text(),
                        'shelfQuantity': $('tbody tr#variation-wise-show-'+$(this).val()).find('td.shelf-qty').text()
                        }
                });
                if(variation_ids.length == 0){
                    alert('Please select a proudct')
                    return false
                }
                // console.log(variation_ids)
                // console.log(variation_info)
                $.ajax({
                    type: "POST",
                    url: "{{asset('shelf-available-bulk-sync')}}",
                    data: {
                        "_token": "{{csrf_token()}}",
                        "variationIds": variation_ids,
                        "variationInfo": variation_info
                    },
                    beforeSend: function(){
                        $('#ajax_loader').show();
                    },
                    success: function(response){
                        if(response.data == 'success'){
                            var icon = 'success'
                        }else{
                            var icon = 'error'
                        }
                        $('#ajax_loader').hide();
                        if(response.largerAvaiableQuantity.length > 0){
                        var html = '<table class="table"><thead><tr><th scope="col">SKU</th><th scope="col">Old Quantity</th><th scope="col">Updated Quantity</th><th scope="col">Shelf Quantity</th></tr></thead><tbody>';
                            response.largerAvaiableQuantity.forEach(function (data) {
                                html += '<tr><td>' + data.sku + '</td><td>' + data.previousQuantity + '</td><td>' + data.updatedQuantity + '</td><td>' + data.shelfQuantity + '</td></tr>';
                            });
                        html += '</tbody><p class="text-danger">Below SKUs Available Quantity Is Greater Than Shelf Quantity. Please Check These Quantity Again</p></table>';
                        }else{
                            var html = ''
                        }
                        swal.fire({
                            title: response.msg,
                            html: html,
                            icon: icon
                        })
                    }
                })
            })
        })

        //Product variation row serach
        $(document).ready(function(){
            $("#product_variation_search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#product_variation_table tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('button.variation-bulk-delete').on('click',function(){
                var catalogueId = $('#master_catalogue_id').val()
                var variationIds= []
                $('table tbody tr td :checkbox:checked').each(function(i){

                    if($('#variation-wise-show-'+$(this).val()).css('display') != 'none'){
                        variationIds[i] = $(this).val()

                    }

                })
                if(variationIds.length == 0){
                    Swal.fire('Oops!','Please select atleast one product','warning')
                }

                Swal.fire({
                    title: 'Are you sure to delete ?',
                    text: 'All product will be deleted from every channel',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Delete',
                    showLoaderOnConfirm: true,
                    focusConfirm: false,
                    preConfirm: () => {
                        const url = "{{asset('variation-bulk-delete')}}"
                        const token = "{{csrf_token()}}"
                        return fetch(url,{
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json, text-plain, */*",
                                "X-Requested-width": "XMLHttpRequest",
                                "X-CSRF-TOKEN": token
                            },
                            method: 'post',
                            body: JSON.stringify({
                                catalogueId: catalogueId,
                                variaitonIds: variationIds
                            })
                        })
                        .then((res) => {
                            if(!res.ok){
                                throw new Error(res.statusText);
                            }
                            return res.json()
                        })
                        .catch((err) => {
                            Swal.showValidationMessage(`Request Failed: ${err}`)
                        })
                    }
                })
                .then(result => {
                    console.log('in the then block')
                    console.log(result)
                    if(result.isConfirmed){
                        if(result.value.exception.length > 0){
                            var exceptionMsg = '<h3 class="text-danger">Exceptions are listed below</h3>';
                            result.value.exception.forEach((val) => {
                                exceptionMsg += val+'<br>'
                            })
                        }
                        Swal.fire({
                            title: `${result.value.message}`,
                            html: exceptionMsg,
                            icon: 'success'
                        })
                        result.value.variation_ids.forEach((id) => {
                            $('table tbody tr#variation-wise-show-'+id).remove()
                            $('.product-draft-checkbox-content').hide(500)
                        })
                    }
                })

            })
        });

        function submitVariation(productId){
            let attr = $('#submit-variation-'+productId+' .attribute-term')
            var attrArr = []
            for(var i = 0; i < attr.length; i++){
                attrArr.push($(attr[i]).val())
            }
            let variationId = $('#submit-variation-'+productId).find('input.variation-id').val()
            fetch("{{url('variation-modified')}}",{
                method: 'post',
                headers: {
                    'Accept':'application/json',
                    'Content-Type':'applcation/json',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: JSON.stringify({attribute: attrArr, variation_id: variationId})
            })
            .then(res => {
                return res.json()
            })
            .then(data => {
                if(data.type == 'success'){
                    Swal.fire('Success',data.msg,'success')
                    $('div.product-variation-div-'+productId).remove()
                    $('span.modified-variation-'+productId).html(data.variation)
                }else{
                    Swal.fire('Warning',data.msg,'warning')
                }
            })
            .catch(err => {
                Swal.fire('Oops!',data.msg,'error')
            })
        }

        // Product draft details table filter column search
        const aggrFn = {
            "=": (a, b) => a == b,
            "<": (a, b) => a < b,
            ">": (a, b) => a > b,
            "<=": (a, b) => a <= b,
            ">=": (a, b) => a >= b,
        };

        function filterColumns($table) {
            const colFilters = {};
            $table.find("thead .draftDeFilter").each(function() {
                colFilters[$(this).index()] = {
                    agg: $(this).find("select").val(),
                    val: $(this).find("input").val(),
                }
            });
            $table.find("tbody tr").each(function() {
                const $tr = $(this);
                const shouldHide = Object.entries(colFilters).some(([k, v]) => {

                    return v.val === "" ? false : !aggrFn[v.agg](parseFloat($tr.find(`td:eq(${k})`).text()), parseFloat(v.val));

                });
                $tr.toggleClass("u-none", shouldHide);
            });
        }

        $(".draftDeFilter").on("input", ":input", function() {
            filterColumns($(this).closest("table"));
        });




        // $('button').click(function(){
        //     // event.preventDefault()
        //     var avlQuantity = [];
        //     var aggOperator = $(this).closest('div').find('#aggregate_condition').val();
        //     var inputValue = $(this).closest('div').find('#available_quantity').val();
        //     var idValue = $(this).closest('div').find('#id-value').val();
        //     console.log(aggOperator,inputValue,idValue)
        //     $('table tbody tr').each(function(){
        //         avlQuantity.push($(this).find('td:eq(12) span p').text());
        //         console.log(avlQuantity);
        //         // console.log($(this).find('td:eq(12) span p').text());
        //     });
        //     // return false
        //
        //     if(aggOperator == '='){
        //         aggOperator = '=='
        //     }
        //
        //     if(aggOperator,inputValue){
        //         avlQuantity.push($(this).find('td:eq(12) span p').text());
        //         console.log(avlQuantity.push($(this).find('td:eq(12) span p').text()));
        //         // console.log(avlQuantity);
        //     }
        //
        //     $('table tbody tr').filter(function () {
        //         var rowId = $(this).attr('id');
        //         avlQuantity.forEach(function (id) {
        //             if(rowId == 'variation-wise-show-'+id){
        //                 $('table tbody tr#variation-wise-show-'+id).show();
        //                 console.log('table tbody tr#variation-wise-show-'+id)
        //             }
        //             // console.log(id);
        //         })
        //         // console.log(rowId);
        //     })
        //
        //     console.log('end');
        //     return false
        // })

            $('div.add-reason a').click(function(){
                Swal.fire({
                    title: 'Add Reason',
                    input: 'text',
                    showCancelButton: true,
                    confirmButtonText: 'Add',
                    showLoaderOnConfirm: true,
                    preConfirm: (reason) => {
                        return new Promise(function(resolve){
                            $.ajax({
                                type: "post",
                                url: "{{url('shelf-quantity-change-reason')}}",
                                data: {
                                    "_token": "{{csrf_token()}}",
                                    "reason": reason
                                }
                            })
                            .done(function(response){
                                if(response.type == 'success'){
                                    $('.modal select').append('<option value="'+response.data.reason+'">'+response.data.reason+'</option>')
                                    Swal.fire('Success',response.msg,'success')
                                }else{
                                    Swal.fire('Oops...','Something went wrong','warning')
                                }
                            })
                            .fail(function(){
                                Swal.fire('Oops...','Something went wrong','error')
                            })
                        })
                    },
                    allowOutsideClick: false
                })
            })

        //Select option expand customize
        let expanded = false;
        function showCheckboxes() {
            let checkboxes = document.getElementById("checkboxes");
            if (!expanded) {
                checkboxes.style.display = "block";
                expanded = true;
            } else {
                checkboxes.style.display = "none";
                expanded = false;
            }
        }

        $(document).on('click','.add-new-reason',function(){
            $('.add-new-defect-reason-div').toggle('slow');
        })

        $(document).on('click','.add-new-defect-reason',function(){
            let newDefectReason = $('.add-new-defect-reason-div #add_defect_reason').val()
            var url = "{{asset('defect-reason/a/add')}}"
            if(newDefectReason == ''){
                Swal.showValidationMessage('Enter Defect Reason')
                return false
            }else{
                Swal.resetValidationMessage()
            }

            return fetch(url,{
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                body: JSON.stringify({input_value: newDefectReason})
            })
            .then(res => {
                return res.json()
            })
            .then((result) => {
                if(result.type == 'success'){
                    $('.add-new-defect-reason-div #add_defect_reason').val('')
                    $('.add-new-defect-reason-div').hide('slow');
                    Swal.resetValidationMessage()
                    $('select#defect_reason').append('<option value="'+result.response_data.id+'" selected>'+result.response_data.reason+'</option>')
                }else{
                    Swal.showValidationMessage(`${result.msg}`)
                    //Swal.fire('Oops!',result.msg,'error')
                }
            })
            .catch(error => {
                Swal.showValidationMessage(`Something Went Wrong: ${error}`)
            })
        })

        function declare_defect(variationId){
            var reasons = []
            fetch("{{asset('get-defected-reason')}}"+'/'+variationId)
            .then(response => {
                return response.json()
            })
            .then(data => {
                if(data.allDefectedReason.length > 0){
                    var reasonOption = ''
                    var shelfOption = ''
                    data.allDefectedReason.forEach((reasonData) => {
                        if(data.allDefectedReason.length == 1){
                            reasonOption += '<option value="'+reasonData.id+'" selected>'+reasonData.reason+'</option>'
                        }else{
                            reasonOption += '<option value="'+reasonData.id+'">'+reasonData.reason+'</option>'
                        }
                    })
                    data.shelfInfo.forEach((shelfData) => {
                        if(data.shelfInfo.length == 1){
                            shelfOption += '<option value="'+shelfData.shelf_info.id+'" selected>'+shelfData.shelf_info.shelf_name+' ('+shelfData.total_quantity+')</option>'
                        }else{
                            shelfOption += '<option value="'+shelfData.shelf_info.id+'">'+shelfData.shelf_info.shelf_name+' ('+shelfData.total_quantity+')</option>'
                        }
                    })
                    var html = '<button type="button" class="btn btn-primary btn-sm mb-2 add-new-reason">Add Reason</button>'+
                                '<div class="add-new-defect-reason-div mb-2" style="display: none">'+
                                '<input type="text" name="add_defect_reason" id="add_defect_reason" class="form-control mb-2" placeholder="Enter Defect Reason">'+
                                '<button type="button" class="btn btn-success btn-sm add-new-defect-reason">Submit</button>'+
                                '</div>'+
                                '<input type="text" name="defect_quantity" id="defect_quantity" class="form-control mb-2" placeholder="Enter Defect Quantity">'+
                                '<select name="defect_reason" id="defect_reason" class="form-control mb-2">'+
                                    '<option value="">Select Defect Reason</option>'+
                                    reasonOption +
                                '</select>'+'<select name="shelf" id="shelf" class="form-control">'+
                                    '<option value="">Select Shelf</option>'+
                                    shelfOption +
                                '</select>'
                    Swal.fire({
                        title: 'Declare Defect',
                        html: html,
                        showCancelButton: true,
                        confirmButtonText: 'Proceed',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                            const defectQuantity = Swal.getPopup().querySelector('#defect_quantity').value
                            const defectReason = Swal.getPopup().querySelector('#defect_reason').value
                            const shelfId = Swal.getPopup().querySelector('#shelf').value
                            var presentQuantity = $('#actual_quantity_'+variationId+' p').text()
                            if(defectQuantity == '' || defectReason == '' || shelfId == ''){
                                Swal.showValidationMessage(
                                    `Please Select The Required Field`
                                )
                                return false
                            }else if((presentQuantity - defectQuantity) < 0){
                                Swal.showValidationMessage(`Defected Quantity Must Be Equal Or Smaller Than Available Quantity`)
                                return false
                            }
                            var dataObj ={
                                defect_product_id: variationId,
                                present_quantity: presentQuantity,
                                defect_quantity: defectQuantity,
                                shelf_id: shelfId ?? null,
                                defect_reason: defectReason
                            }
                            let token = "{{csrf_token()}}"
                            return fetch("{{asset('variation-declare-defect')}}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    "X-CSRF-TOKEN": token
                                },
                                body: JSON.stringify(dataObj)
                            })
                            .then(response => {
                                return response.json()
                            })
                            .then(data => {
                                if(data.type == 'success'){
                                    $('#actual_quantity_'+variationId+' p').text($('#actual_quantity_'+variationId+' p').text() - data.insert_data.defected_product)
                                    if(shelfId != ''){
                                        $('#shelfQuantity-'+variationId).text($('#shelfQuantity-'+variationId).text() - data.insert_data.defected_product)
                                    }
                                    Swal.fire('Success',data.insert_data.defected_product + ' Quantity Declared As Defected Successfully','success')
                                }else{
                                    Swal.fire('Error',data.msg,'error')
                                }
                            })
                            .catch(error => {
                                Swal.fire('Error','Somethnig Went Wrong','error')
                            })
                        }
                    })
                }else{
                    Swal.fire('Oops','Please Add A Defect Reason First','warning')
                    return false
                }
            })
            .catch(error => {
                Swal.fire('Error','Somethnig Went Wrong','error')
            })

        }

        // reset button show function
        var getClass = document.getElementsByClassName('base_price_reset');
        for (var i = 0; i < getClass.length; i++) {
            getClass[i].addEventListener('change', function() {
            $('#all_reset_button').show();
            });
        }


        ////////// START BULK EDIT SCRIPT ////////////

        var regPriceModal = document.getElementById("regularPriceModal");
        var salesPriceModal = document.getElementById("salesPriceModal");
        var costPriceModal = document.getElementById("costPriceModal");
        var availableQtyModal = document.getElementById("availableQtyModal");
        var rrpModal = document.getElementById("rrpModal");
        var basePriceModal = document.getElementById("basePriceModal");

        // Get the button that opens the modal
        var regPriceBtn = document.getElementById("regularPriceBtn");
        var salesPriceBtn = document.getElementById("salesPriceBtn");
        var costPriceBtn = document.getElementById("costPriceBtn");
        var availableQtyBtn = document.getElementById("availableQtyBtn");
        var rrpBtn = document.getElementById("rrpBtn");
        var basePriceBtn = document.getElementById("basePriceBtn");

        // Get the <div> element that closes the modal
        var regPriceClose = document.getElementsByClassName("regularPriceClose")[0];
        var salesDivClose = document.getElementsByClassName("salesPriceClose")[0];
        var costPriceClose = document.getElementsByClassName("costPriceClose")[0];
        var availableQtyClose = document.getElementsByClassName("availableQtyClose")[0];
        var rrpClose = document.getElementsByClassName("rrpClose")[0];
        var basePriceClose = document.getElementsByClassName("basePriceClose")[0];

        // When the user clicks the button, open the modal
        regPriceBtn.onclick = function() {
            regPriceModal.style.display = "block";
        }

        salesPriceBtn.onclick = function() {
            salesPriceModal.style.display = "block";
        }

        costPriceBtn.onclick = function() {
            costPriceModal.style.display = "block";
        }

        @if (Auth::check() && !empty(array_intersect(['1'],explode(',',Auth::user()->role))))
        availableQtyBtn.onclick = function() {
            availableQtyModal.style.display = "block";
        }
        @endif

        rrpBtn.onclick = function() {
            rrpModal.style.display = "block";
        }

        basePriceBtn.onclick = function() {
            basePriceModal.style.display = "block";
        }

        // When the user clicks on <div> (x), close the modal
        regPriceClose.onclick = function() {
            regPriceModal.style.display = "none";
            $('button.btn-active').removeClass('btn-active')
        }

        salesDivClose.onclick = function() {
            salesPriceModal.style.display = "none";
            $('button.btn-active').removeClass('btn-active')
        }

        costPriceClose.onclick = function() {
            costPriceModal.style.display = "none";
            $('button.btn-active').removeClass('btn-active')
        }

        @if (Auth::check() && !empty(array_intersect(['1'],explode(',',Auth::user()->role))))
        availableQtyClose.onclick = function() {
            availableQtyModal.style.display = "none";
            $('button.btn-active').removeClass('btn-active')
        }
        @endif

        rrpClose.onclick = function() {
            rrpModal.style.display = "none";
            $('button.btn-active').removeClass('btn-active')
        }

        basePriceClose.onclick = function() {
            basePriceModal.style.display = "none";
            $('button.btn-active').removeClass('btn-active')
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == regPriceModal) {
                regPriceModal.style.display = "none";
            }
        }

        window.onclick = function(event) {
            if (event.target == salesPriceModal) {
                salesPriceModal.style.display = "none";
            }
        }

        window.onclick = function(event) {
            if (event.target == costPriceModal) {
                costPriceModal.style.display = "none";
            }
        }

        @if (Auth::check() && !empty(array_intersect(['1'],explode(',',Auth::user()->role))))
        window.onclick = function(event) {
            if (event.target == availableQtyModal) {
                availableQtyModal.style.display = "none";
            }
        }
        @endif

        window.onclick = function(event) {
            if (event.target == rrpModal) {
                rrpModal.style.display = "none";
            }
        }

        window.onclick = function(event) {
            if (event.target == basePriceModal) {
                basePriceModal.style.display = "none";
            }
        }

        ////////// END BULK EDIT SCRIPT ////////////


        ///Add Terms Modal
        // var addTermsModal = document.getElementById("addTermsModal");
        // var addTermsBtn = document.getElementById("addTermsBtn");
        // var termsClose = document.getElementsByClassName("terms-close")[0];
        // addTermsBtn.onclick = function() {
        //     addTermsModal.style.display = "block";
        // }
        // termsClose.onclick = function() {
        //     addTermsModal.style.display = "none";
        // }
        // window.onclick = function(event) {
        //     if (event.target == addTermsModal) {
        //         addTermsModal.style.display = "none";
        //     }
        // }
        ///End Add Terms Modal

        $('.addTermstoCatalogBtn').on('click', function(){
            $('#addTermsModal').show()
            $('a.addTermstoCatalogBtn').css('border', '3px solid')
        })

        function trashClick(e){
            $(e).closest('div#addTermsModal').hide()
            $('a.addTermstoCatalogBtn').css('border', '1px solid')
        }

        //Success Message Show
        @if ($message = Session::get('success_message'))
            swal("{{ $message }}", "", "success");
        @endif

        //Error Message Show
        @if ($message = Session::get('error'))
            swal("{{ $message }}", "", "error");
        @endif

        //Modal button variation terms adding spining btn
        $('button.termsCatalogueBtn').click(function(){
            $(this).html(
                `<span class="mr-2"><i class="fa fa-spinner fa-spin"></i></span>Variation adding`
            );
            $(this).addClass('changeCatalogBTnCss');
        })

        $('#myModal').on('shown.bs.modal', function() {
            $(document).off('focusin.modal');
        });

    </script>


@endsection
