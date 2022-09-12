@extends('master')

@section('title')
    eBay | Active Product | Edit Active Product | WMS360
@endsection

@section('content')

    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.css')}}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <!-- <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script> -->
    <style>
        .onoffswitch{
            /*margin-left: -6%;*/
            width: 70px;
        }
        .no-img-content{
            background-image: url('{{asset('assets/common-assets/no_image_box.jpg')}}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
    </style>


    <div class="content-page ebay">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <div class="screen-option">
                    <div class="d-flex justify-content-start align-items-center">
                        <div>
                            <ol class="breadcrumb page-breadcrumb">
                                <li class="breadcrumb-item" aria-current="page">Active Product</li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Active Product</li>
                            </ol>
                        </div>
                    </div>
                    <div id="secondary-input-field" class="mt-sm-15" onclick="secondaryInputField()">
                        Listing Options <i class="fas fa-arrow-right ml-1"></i>
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


                            <form role="form" target="_blank" class="mobile-responsive mt-4" method="post" enctype="multipart/form-data" action= {{URL::to('ebay-product-update/'.$result->id)}}>
                                @csrf
                                @method('PUT')

                                <div id="Load" class="load" style="display: none;">
                                    <div class="load__container">
                                        <div class="load__animation"></div>
                                        <div class="load__mask"></div>
                                        <span class="load__title">Content is loading...</span>
                                    </div>
                                </div>


                                <div class="ebay-secondary-input-drawer-box" style="display: none">
                                    <div class="drawer-box-header">
                                        <div><i class="fa fa-close ebay-drawer-close-btn" onclick="ebayDrawerBoxCloseBtn()"></i></div>
                                        <div class="text-white">Listing Options</div>
                                    </div>
                                    <div class="drawer-box-body">
                                        <div class="row form-group">
                                            <div class="col-md-3 d-flex align-items-center">
                                                <div>
                                                    <label for="account_id" class=" col-form-label r-sec required">eBay Account</label>
                                                </div>
                                                <div class="ml-1">
                                                    <div id="wms-tooltip">
                                                        <span id="wms-tooltip-text">This shows the account where the item is listed.</span>
                                                        <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="product_id" value="{{$result->id}}">
                                            <input type="hidden" name="type" value="{{$result->type}}">
                                            {{-- <div class="col-md-1"></div> --}}
                                            <div class="col-md-9 pointer-events">
                                                <select id="account_id" class="form-control select2" name="account_id" onchange="getAccountSiteData()">
                                                    @if(isset($result->account_id))
                                                        <option value="{{$result->account_id}}" selected>{{\App\EbayAccount::find($result->account_id)->account_name}}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 d-flex align-items-center">
                                                <div>
                                                    <label for="site_id" class="col-form-label r-sec required">Listed On</label>
                                                </div>
                                                <div class="ml-1">
                                                    <div id="wms-tooltip">
                                                        <span id="wms-tooltip-text">This shows the eBay site on which the item is listed.</span>
                                                        <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-9 pointer-events">
                                                <select id="site_id" class="form-control select2" name="site_id" onchange="getAccountSiteData()">
                                                    <option value="{{$result->site_id}}" selected>{{\App\EbaySites::find($result->site_id)->name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="fq">
                                            <div class="col-md-3 d-flex align-items-center">
                                                <div>
                                                    <label for="custom_feeder_flag" class="col-form-label r-sec required">Feeder Quantity</label>
                                                </div>
                                                <div class="ml-1">
                                                    <div id="wms-tooltip">
                                                        <span id="wms-tooltip-text" class="feeder-qty-text">A feeder quantity will free up your monthly selling allowance & allow you to list more over loading your current allowance. Please set the max quantity limit that should be shown on eBay at a given time. Upon sales WMS360 will feed up to max limit set by you.</span>
                                                        <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="onoffswitch mb-sm-10 res-onoff-btn">
                                                    <input type="checkbox" value="{{\Opis\Closure\unserialize($result->draft_status)['feeder_flag'] ?? 0}}" name="custom_feeder_flag" class="onoffswitch-checkbox"  id="custom_feeder_flag" tabindex="1" @isset(\Opis\Closure\unserialize($result->draft_status)['feeder_flag']) @if (\Opis\Closure\unserialize($result->draft_status)['feeder_flag'] == 1)  checked @else unchecked @endif @endisset >
                                                    <label class="onoffswitch-label" for="catalogue-name">
                                                        <span onclick="onOff('custom_feeder_flag')" class="onoffswitch-inner"></span>
                                                        <span onclick="onOff('custom_feeder_flag')" class="ebay-onoffswitch-switch"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-8 fq-pl">
                                                <!-- <input id="custom_feeder_quantity" type="number" class="form-control @error('feeder_quantity') is-invalid @enderror" name="custom_feeder_quantity" min="3" value="{{$result->custom_feeder_quantity ?? 3}}"  oninput="autoOff('custom_feeder_flag');" required> -->
                                                <input id="custom_feeder_quantity" type="number" class="form-control @error('feeder_quantity') is-invalid @enderror" name="custom_feeder_quantity" value="{{$result->custom_feeder_quantity ?? 0}}" oninput="feederQuantity();" required>
                                                <span id="custom_feeder_quantity" class="float-right"></span>
                                                @error('custom_feeder_quantity')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <input id="item_id" type="hidden" class="form-control @error('name') is-invalid @enderror" name="item_id" value="{{$result->item_id}}" maxlength="80" onkeyup="Count();" required autocomplete="name" autofocus>

                                        <div class="form-group row">
                                            <div class="col-md-3 d-flex align-items-center">
                                                <div>
                                                    <label for="condition_id" class="col-form-label r-sec required">Condition</label>
                                                </div>
                                                <div class="ml-1">
                                                    <div id="wms-tooltip">
                                                        <span id="wms-tooltip-text" class="ebay-condition-text">
                                                            Select the condition of the item you're listing.
                                                        </span>
                                                        <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @isset($conditions['Category']['ConditionValues']['Condition'])
                                                <div class="col-md-9 pointer-events">
                                                    <!-- <div class="row"> -->
                                                        @if(isset($conditions['Category']['ConditionValues']['Condition']))
                                                            <!-- <div class="col-md-4 mb-3"> -->
                                                                <select name='condition_id' class="form-control select2" id="condition-select">
                                                                    <option value="">Select Condition</option>
                                                                    @foreach($conditions['Category']['ConditionValues']['Condition'] as $condition)
                                                                        @if($condition['ID'] == $result->condition_id)
                                                                            <option value="{{$condition['ID']}}/{{$condition['DisplayName']}}" selected>{{$condition['DisplayName']}}</option>
                                                                        @else
                                                                            <option value="{{$condition['ID']}}/{{$condition['DisplayName']}}" >{{$condition['DisplayName']}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            <!-- </div> -->
                                                        @else
                                                            condition not available
                                                        @endif
                                                    <!-- </div> -->
                                                </div>
                                            @endisset
                                        </div>

                                        <!--Condition Description-->
                                        <div class="form-group row" id="condition-description-sec">
                                            <div class="col-md-3 d-flex align-items-center">
                                                <div>
                                                    <label for="condition_description" class="col-form-label r-sec">Condition Description</label>
                                                </div>
                                                <div class="ml-2">
                                                    <div id="wms-tooltip">
                                                        <span id="wms-tooltip-text" class="ebay-condition-description">Provide details about the condition of an item that is not new, including any defects or flaws, so that buyers know exactly what to expect.</span>
                                                        <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <textarea rows="1" style="width: 100%;" class="form-control profile-data" name="condition_description">{{ $result->condition_description }}</textarea>
                                            </div>
                                        </div>

                                        <div id="account_site_data">
                                            <div class="form-group row" id="all_category_div">
                                                <div class="col-md-3 d-flex align-items-center">
                                                    <div>
                                                        <label for="Category" class="col-form-label required">Category</label>
                                                    </div>
                                                    <div class="ml-1">
                                                        <div id="wms-tooltip">
                                                            <span id="wms-tooltip-text">Selecting the appropriate eBay category is important to appear under the right eBay category.</span>
                                                            <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-9 controls pointer-events" id="category-level-1-group">
                                                    <select class="form-control category_select select2 " name="child_cat[1]" id="child_cat_1" onchange="myFunction(1)">
                                                        <option value="{{$result->category_id}}/{{$result->category_name}}">{{$result->category_name}}</option>
                                                        @foreach($categories[0]['category'] as $category)
                                                            <option value="{{$category['CategoryID']}}/{{$category['pivot']['CategoryName']}}">{{$category['pivot']['CategoryName']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- <div class="form-group row">
                                                <div class="col-md-2">   </div>
                                                <div class="col-md-10">
                                                    <button type="button" class="btn btn-primary m-t-10" id="list_button" style="display: none;">List</button>
                                                    <input type="text" class="form-control" name="last_cat_id" id="last_cat_id" style="display: none;" value="{{$result->category_id}}">
                                                </div>
                                            </div> --}}

                                            {{--    second category--}}
                                            <div class="form-group row" id="all_category_div2">
                                                <div class="col-md-3 d-flex align-items-center"><b class="sub-cat-font">Sub Category</b>
                                                    <div>
                                                        <label for="Category" class="col-md-2 col-form-label sub-label required"> </label>
                                                    </div>
                                                    <div class="sub-label">
                                                        <div id="wms-tooltip">
                                                            <span id="wms-tooltip-text">Selecting a sub-category will make the listing appear in the second category.</span>
                                                            <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                        </div>
                                                    </div>
                                                    <div class="edit-ebay-close-btn" title="Click here to remove sub category" style="display: none">
                                                        <label class="fa fa-remove cursor-pointer" onclick="myFunction2(1,'remove')"></label>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="current_sub_category" value="{{$result->sub_category_name}}">
                                                <div id="category2-level-0-group">

                                                </div>
                                                <div class="col-md-9 controls float-left d-flex" id="category2-level-1-group">
                                                    <select class="form-control category2_select " name="child_cat2[1]" id="child_cat2_1" onchange="myFunction2(1)">
                                                        <option value="">{{$result->sub_category_name}}</option>
                                                        @foreach($categories[0]['category'] as $category)
                                                            <option value="{{$category['CategoryID']}}//{{$category['pivot']['CategoryName']}}">{{$category['pivot']['CategoryName']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                            <input type="hidden" name="sub_category_name" value="{{$result->sub_category_name}}">
                                            {{-- <div class="form-group row">
                                                <div class="col-md-2">   </div>
                                                <div class="col-md-10">
                                                    <button type="button" class="btn btn-primary m-t-10" id="list_button" style="display: none;">List</button>
                                                    <input type="text" class="form-control" name="last_cat_id" id="last_cat_id" style="display: none;" value="{{$result->category_id}}">
                                                    <input type="text" class="form-control" name="last_cat2_id" id="last_cat2_id" style="display: none;" value="{{$result->sub_category_id}}">
                                                </div>
                                            </div> --}}
                                       </div> <!--account site data-->

                                        @isset($shop_categories['Store']['CustomCategories']['CustomCategory'])
                                                <div class="form-group row">
                                                    <div class="col-md-3 d-flex align-items-center">
                                                        <div>
                                                            <label for="store_id" class="col-form-label r-sec">Shop Category</label>
                                                        </div>
                                                        <div class="ml-1">
                                                            {{-- <div class="tooltip-container">
                                                                <a class="tooltips" href="#"><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}">
                                                                    <span class="sCategory">If you have an eBay Shop, select the Shop categories of the items you're listing.</span>
                                                                </a>
                                                            </div> --}}
                                                            <div id="wms-tooltip">
                                                                <span id="wms-tooltip-text">
                                                                    If you have an eBay Shop, select the Shop categories of the items you're listing.
                                                                </span>
                                                                <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-9">
                                                        <!-- <div class="row d-flex justify-content-between">
                                                            <div class="col-md-4 mb-3"> -->
                                                                <select name='store_id' class="form-control select2">
                                                                    @foreach($shop_categories['Store']['CustomCategories']['CustomCategory'] as $shop_category)
                                                                        @if(isset($shop_category['ChildCategory']))
                                                                            @foreach($shop_category['ChildCategory'] as $child_category_1)
                                                                                @if(isset($child_category_1['ChildCategory']))
                                                                                    @foreach($child_category_1['ChildCategory'] as $child_category_2)
                                                                                        @if(isset($child_category_2['CategoryID']))
                                                                                            @if($result->store_id == $child_category_2['CategoryID'])
                                                                                                <option value="{{$child_category_2['CategoryID']}}/{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}" selected>{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}</option>
                                                                                            @else
                                                                                                <option value="{{$child_category_2['CategoryID']}}/{{$child_category_1['Name']}}>{{$child_category_2['Name']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}</option>
                                                                                            @endif
                                                                                        @endif
                                                                                    @endforeach
                                                                                @else
                                                                                    @if($result->store_id == $child_category_1['CategoryID'])
                                                                                        <option value="{{$child_category_1['CategoryID']}}/{{$shop_category['Name']}}>{{$child_category_1['Name']}}" selected>{{$shop_category['Name']}}>{{$child_category_1['Name']}}</option>
                                                                                    @else
                                                                                        <option value="{{$child_category_1['CategoryID']}}/{{$shop_category['Name']}}>{{$child_category_1['Name']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}</option>
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            @if($result->store_id == $shop_category['CategoryID'])
                                                                                <option value="{{$shop_category['CategoryID']}}/{{$shop_category['Name']}}" selected>{{$shop_category['Name']}}</option>
                                                                            @else
                                                                                <option value="{{$shop_category['CategoryID']}}/{{$shop_category['Name']}}">{{$shop_category['Name']}}</option>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            <!-- </div>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            @endisset

                                            @isset($shop_categories['Store']['CustomCategories']['CustomCategory'])
                                                <div class="form-group row">
                                                    <div class="col-md-3 d-flex align-items-center">
                                                        <div>
                                                            <label for="store2_id" class="col-form-label r-sec">Shop Category 2</label>
                                                        </div>
                                                        <div class="ml-1">
                                                            {{-- <div class="tooltip-container">
                                                                <a class="tooltips" href="#"><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}">
                                                                    <span class="sCategory2">If you have an eBay Shop, select the Shop categories of the items you're listing.</span>
                                                                </a>
                                                            </div> --}}
                                                            <div id="wms-tooltip">
                                                                <span id="wms-tooltip-text">
                                                                    If you have an eBay Shop, select the Shop categories of the items you're listing.
                                                                </span>
                                                                <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <!-- <div class="row d-flex justify-content-between"> -->
                                                            <!-- <div class="col-md-4 mb-3"> -->
                                                                <select name='store2_id' class="form-control select2">
                                                                    @foreach($shop_categories['Store']['CustomCategories']['CustomCategory'] as $shop_category)
                                                                        @if(isset($shop_category['ChildCategory']))
                                                                            @foreach($shop_category['ChildCategory'] as $child_category_1)
                                                                                @if(isset($child_category_1['ChildCategory']))
                                                                                    @foreach($child_category_1['ChildCategory'] as $child_category_2)
                                                                                        @if(isset($child_category_2['CategoryID']))
                                                                                            @if($result->store2_id == $child_category_2['CategoryID'])
                                                                                                <option value="{{$child_category_2['CategoryID']}}/{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}" selected>{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}</option>
                                                                                            @else
                                                                                                <option value="{{$child_category_2['CategoryID']}}/{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}</option>
                                                                                            @endif
                                                                                        @endif
                                                                                    @endforeach
                                                                                @else
                                                                                    @if($result->store2_id == $child_category_1['CategoryID'])
                                                                                        <option value="{{$child_category_1['CategoryID']}}/{{$shop_category['Name']}}>{{$child_category_1['Name']}}" selected>{{$shop_category['Name']}}>{{$child_category_1['Name']}}</option>
                                                                                    @else
                                                                                        <option value="{{$child_category_1['CategoryID']}}/{{$shop_category['Name']}}>{{$child_category_1['Name']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}</option>
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            @if($result->store2_id == $shop_category['CategoryID'])
                                                                                <option value="{{$shop_category['CategoryID']}}/{{$shop_category['Name']}}" selected>{{$shop_category['Name']}}</option>
                                                                            @else
                                                                                <option value="{{$shop_category['CategoryID']}}/{{$shop_category['Name']}}">{{$shop_category['Name']}}</option>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            <!-- </div> -->
                                                        <!-- </div> -->
                                                    </div>
                                                </div>
                                            @endisset

                                            <div class="form-group row">
                                                <div class="col-md-3 d-flex align-items-center">
                                                    <div>
                                                        <label for="private_listing" class="col-form-label">Private Listing <label id="privateListing"></label></label>
                                                    </div>
                                                    <div class="ml-1">
                                                        <div id="wms-tooltip">
                                                            <span id="wms-tooltip-text">
                                                                Keep bidder and buyer identities hidden from other eBay members. <b>(fees may apply)</b>
                                                            </span>
                                                            <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-9 d-flex align-items-center">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="private_listing" value="1" class="custom-control-input private_listing" id="private_listing"
                                                        @if($result->private_listing)
                                                            checked

                                                        @endif>
                                                        <label class="custom-control-label" for="private_listing"> </label>
                                                    </div>
                                                    {{-- <div class="onoffswitch mb-sm-10 res-onoff-btn">
                                                        <input type="checkbox" value="1" name="private_listing" class="onoffswitch-checkbox"  id="private_listing" tabindex="1"
                                                            @if(isset($result->private_listing)){
                                                                checked
                                                                }
                                                            @endif>
                                                        <label class="onoffswitch-label" for="private_listing">
                                                            <span class="onoffswitch-inner"></span>
                                                            <span class="ebay-onoffswitch-switch"></span>
                                                        </label>
                                                    </div> --}}
                                                </div>
                                            </div>




        {{--                                    <div class="form-group row">--}}
        {{--                                        <div class="col-md-2 d-flex align-items-center">--}}
        {{--                                            <div>--}}
        {{--                                                <label for="condition_id" class="col-form-label required">Make Listing Private</label>--}}
        {{--                                            </div>--}}
        {{--                                            <div class="ml-1">--}}
        {{--                                                <div id="wms-tooltip">--}}
        {{--                                                    <span id="wms-tooltip-text">--}}
        {{--                                                        Select the condition of the item you're listing.--}}
        {{--                                                    </span>--}}
        {{--                                                    <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </div>--}}
        {{--                                            <div class="col-md-10">--}}
        {{--                                                <!-- <div class="row"> -->--}}
        {{--                                                <!-- <div class="col-md-4 mb-3"> -->--}}
        {{--                                                    <select name='private_listing' class="form-control select2" id="private_listing">--}}
        {{--                                                        <option value="1">Yes</option>--}}
        {{--                                                        <option value="0">No</option>--}}

        {{--                                                    </select>--}}
        {{--                                                    <!-- </div> -->--}}

        {{--                                            <!-- </div> -->--}}
        {{--                                            </div>--}}
        {{--                                    </div>--}}


                                            @if($result->type == 'simple')
                                            <div class="form-group row">
                                                <div class="col-md-3 d-flex align-items-center">
                                                    <div>
                                                        <label for="start_price" class="col-form-label r-sec required">Start Price in <strong>{{$result->currency}}</label>
                                                    </div>
                                                    <div class="ml-1">
                                                        <div id="wms-tooltip">
                                                            <span id="wms-tooltip-text">Tooltips are labels that appear on hover and focus when</span>
                                                            <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="currency" value="{{$result->currency}}">
                                                <div class="col-md-9">
                                                    <input id="start_price" type="text" class="form-control @error('start_price') is-invalid @enderror" name="start_price" value="{{$result->start_price}}" maxlength="80" required autocomplete="start_price" autofocus>
                                                    <span id="start_price" class="float-right"></span>
                                                    @error('start_price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            @endif


                                            <!-- <div class="form-group row ">
                                                <label for="Category" class="col-md-2 col-form-label "></label>
                                                <div class="col-md-10">

                                                    <div class="col-md-12">
                                                        {{--                                                        <h5></h5><span>(Write your value after the already inserted id and don't give '/' slash in your input value)</span><br>--}}

                                                        <input type=number step=0.1 name="bid_rate" max="100" value="{{isset(unserialize($result->campaign_data)["bidPercentage"]) ? unserialize($result->campaign_data)["bidPercentage"] : ''}}" />
                                                    </div>


                                                    <div class="row d-flex justify-content-between">

                                                    </div>


                                                </div>
                                            </div> -->
                                            <div class="form-group row">
                                                <div class="col-md-3 d-flex align-items-center">
                                                    <div>
                                                        <label for="condition_id" class="r-sec">International Site Visibility <label id="intSiteVisibility"></label></label>
                                                    </div>
                                                    <div class="ml-1">
                                                        <div id="wms-tooltip">
                                                            <span id="wms-tooltip-text">Select an additional eBay site where you'd like this listing to appear. <b>(fees may apply)</b></span>
                                                            <span><img style="width: 18px; height: 18px;" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-9 d-flex align-items-center">
                                                    <!-- <div class="row d-flex justify-content-between"> -->
                                                    <!-- <div class="col-md-4 mb-3"> -->
                                                    <select name="cross_border_trade" class="form-control" id="condition-select">
                                                        @if($result->cross_border_trade == "None")
                                                            <option value="None" selected>-</option>
                                                            <option value="North America">eBay US and Canada</option>
                                                        @elseif($result->cross_border_trade == "North America")
                                                            <option value="None">-</option>
                                                            <option value="North America" selected>eBay US and Canada</option>
                                                        @else
                                                            <option value="None" selected>-</option>
                                                            <option value="North America" >eBay US and Canada</option>
                                                        @endif
                                                    </select>
                                                    <!-- </div> -->
                                                    <!-- </div> -->
                                                </div>
                                            </div>

                                           <div class="form-group row">
                                            <label for="condition" class="col-md-3 col-form-label required">Location & Policy</label>
                                            <div class="col-md-9">
                                                <div class="location-policy-container card">
                                                    <input class="location-collapse-open" type="checkbox" id="location-collapse">
                                                    <label class="location-header card-header cursor-pointer location-collapse-btn" for="location-collapse">Expand Location & Policy</label>
                                                    <div class="location-content" style="display: none;">
                                                        <div class="form-group row">
                                                            <label for="condition" class="col-md-4 col-form-label required">Use Picture</label>
                                                            <div class="col-md-8 pointer-events">
                                                                <select class="form-control" name="eps" required>

                                                                    @if($result->eps == 'EPS')
                                                                        <option value="" disabled>Select Options</option>
                                                                        <option value="EPS" selected>EPS</option>
                                                                        <option value="Vendor">Shelf Hosted</option>
                                                                    @elseif($result->eps =='Vendor')
                                                                        <option value="">Select Options</option>
                                                                        <option value="EPS">EPS</option>
                                                                        <option value="Vendor" selected>Shelf Hosted</option>
                                                                    @else
                                                                        <option value="" disabled>Select Options</option>
                                                                        <option value="EPS" selected>EPS</option>
                                                                        <option value="Vendor">Shelf Hosted</option>

                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <div class="col-md-4 d-flex align-items-center">
                                                                <div>
                                                                    <label for="duration" class="col-form-label required">Duration</label>
                                                                </div>
                                                                <div class="ml-1">
                                                                    <div id="wms-tooltip">
                                                                        <span id="wms-tooltip-text">
                                                                            Select how long your listing will run for. If your item doesn't sell, you can choose to relist it.
                                                                        </span>
                                                                        <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 pointer-events">
                                                                <select class="form-control select2" name="duration">
                                                                    <option value="GTC">Good 'Til Cancelled</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-4 d-flex align-items-center">
                                                                <div>
                                                                    <label for="return_id" class="col-form-label required">Return Policy</label>
                                                                </div>
                                                                <div class="ml-1">
                                                                    <div id="wms-tooltip">
                                                                        <span id="wms-tooltip-text">Select the appropriate return policy which is already pre-created by eBay Business Policies portal. If buyer would like to return the item, buyer will be aware of return criteria.</span>
                                                                        <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 pointer-events">
                                                                <select class="form-control select2" name="return_id" required>
                                                                    <option value="">Select Return Policy</option>
                                                                    @foreach($return_policies as $return_policy)
                                                                        @if($return_policy->return_id == $result->return_id)
                                                                            <option value="{{$return_policy->return_id}}" selected>{{$return_policy->return_name}}</option>
                                                                        @else
                                                                            <option value="{{$return_policy->return_id}}">{{$return_policy->return_name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-4 d-flex align-items-center">
                                                                <div>
                                                                    <label for="shipment_id" class="col-form-label required">Shipment Policy</label>
                                                                </div>
                                                                <div class="ml-1">
                                                                    <div id="wms-tooltip">
                                                                        <span id="wms-tooltip-text">Select the appropriate shipment policy which is already pre-created by eBay Business Policies portal. If buyer would like to purchase the item, buyer will be aware of selection of shipping service.</span>
                                                                        <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 pointer-events">
                                                                <select class="form-control select2" name="shipping_id">
                                                                    <option value="">-1</option>
                                                                    @foreach($shipment_policies as $shipment_policy)
                                                                        @if($shipment_policy->shipment_id == $result->shipping_id)
                                                                            <option value="{{$shipment_policy->shipment_id}}" selected>{{$shipment_policy->shipment_name}}</option>
                                                                        @else
                                                                            <option value="{{$shipment_policy->shipment_id}}">{{$shipment_policy->shipment_name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-4 d-flex align-items-center">
                                                                <div>
                                                                    <label for="payment_id" class="col-form-label">Payment Policy</label>
                                                                </div>
                                                                <div class="ml-1">
                                                                    <div id="wms-tooltip">
                                                                        <span id="wms-tooltip-text">Select the appropriate payment policy which is already pre-created by eBay Business Policies portal. If buyer would like to purchase the item, buyer will be aware of selection of payment method available prior to the purchase.</span>
                                                                        <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 pointer-events">
                                                                <select class="form-control select2" name="payment_id">

                                                                    @foreach($payment_policies as $payment_policy)
                                                                        @if($payment_policy->payment_id == $result->payment_id)
                                                                            <option value="{{$payment_policy->payment_id}}" selected>{{$payment_policy->payment_name}}</option>
                                                                        @else
                                                                            <option value="{{$payment_policy->payment_id}}">{{$payment_policy->payment_name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-4 d-flex align-items-center">
                                                                <div>
                                                                    <label for="country" class="col-form-label required">Country</label>
                                                                </div>
                                                                <div class="ml-1">
                                                                    <div id="wms-tooltip">
                                                                        <span id="wms-tooltip-text">Select the country where the item is located.</span>
                                                                        <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 pointer-events">
                                                                <select class="form-control select2" name="country">
                                                                    @foreach($countries as $country)
                                                                        @if($country->country_code == $result->country)
                                                                            <option value="{{$country->country_code}}" selected>{{$country->country_name}}</option>
                                                                        @endif
                                                                        <option value="{{$country->country_code}}">{{$country->country_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-4 d-flex align-items-center">
                                                                <div>
                                                                    <label for="location" class="col-form-label required">City, County</label>
                                                                </div>
                                                                <div class="ml-1">
                                                                    <div id="wms-tooltip">
                                                                        <span id="wms-tooltip-text">Please enter the city/county where the item is located.</span>
                                                                        <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 pointer-events">
                                                                <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{$result->location}}" maxlength="80" onkeyup="Count();" required autocomplete="location" autofocus>
                                                                <span id="location" class="float-right"></span>
                                                                @error('location')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <div class="col-md-4 d-flex align-items-center">
                                                                <div>
                                                                    <label for="post_code" class="col-form-label required">Postcode</label>
                                                                </div>
                                                                <div class="ml-1">
                                                                    <div id="wms-tooltip">
                                                                        <span id="wms-tooltip-text">Please enter the postcode where the item is located.</span>
                                                                        <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 pointer-events">
                                                                <input id="post_code" type="text" class="form-control @error('post_code') is-invalid @enderror" name="post_code" value="{{$result->post_code}}" maxlength="80" onkeyup="Count();" required autocomplete="post_code" autofocus>
                                                                <span id="post_code" class="float-right"></span>
                                                                @error('post_code')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>



                                                        {{--                                    <div class="form-group row">--}}
                                                        {{--                                        <label for="condition" class="col-md-2 col-form-label required">Pypal Account</label>--}}
                                                        {{--                                        <div class="col-md-10">--}}
                                                        {{--                                            <select class="form-control select2" name="paypal">--}}
                                                        {{--                                                @foreach($paypal_accounts as $paypal_account)--}}
                                                        {{--                                                    @if($paypal_account->paypal_email == $result->paypal)--}}
                                                        {{--                                                        <option value="{{$paypal_account->paypal_email}}" selected>{{$paypal_account->paypal_email}}</option>--}}
                                                        {{--                                                    @else--}}
                                                        {{--                                                        <option value="{{$paypal_account->paypal_email}}">{{$paypal_account->paypal_email}}</option>--}}
                                                        {{--                                                    @endif--}}
                                                        {{--                                                @endforeach--}}
                                                        {{--                                            </select>--}}
                                                        {{--                                        </div>--}}
                                                        {{--                                    </div>--}}

                                                        <div class="form-group row">
                    {{--                                        <div class="col-md-2 d-flex align-items-center">--}}
                    {{--                                            <div>--}}
                    {{--                                                <label for="duration" class="col-form-label required">Price in <strong>{{$result->currency}}</strong></label>--}}
                    {{--                                            </div>--}}
                    {{--                                            <div class="ml-1">--}}
                    {{--                                                <a data-toggle="tooltip" data-placement="top" title="Set tooltip message">--}}
                    {{--                                                    <img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}">--}}
                    {{--                                                </a>--}}
                    {{--                                            </div>--}}
                    {{--                                        </div>--}}
                                                            <input type="hidden" name="currency" value="{{$result->currency}}">
                    {{--                                        <div class="col-md-10">--}}
                    {{--                                            <input id="start_price" type="text" class="form-control @error('start_price') is-invalid @enderror" name="start_price" value="{{$result->start_price}}" maxlength="80" onkeyup="Count();" required autocomplete="start_price" autofocus>--}}
                    {{--                                            <span id="start_price" class="float-right"></span>--}}
                    {{--                                            @error('start_price')--}}
                    {{--                                            <span class="invalid-feedback" role="alert">--}}
                    {{--                                                <strong>{{ $message }}</strong>--}}
                    {{--                                            </span>--}}
                    {{--                                            @enderror--}}
                    {{--                                        </div>--}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                            <!-- variation start-->

                                            @isset($result->variationProducts)

                                            <div class="form-group row">
                                                <div class="col-md-3 d-flex">
                                                    @if($result->type == 'variable')
                                                        <div>
                                                            <label for="variation" class="col-form-label required">Variation</label>
                                                        </div>
                                                        <div>
                                                            <div id="wms-tooltip">
                                                                <span id="wms-tooltip-text">This shows all the active variations related to this listing.</span>
                                                                <span><img class="wms-tooltip-image mt-2 ml-1" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="col-md-9">
                                                    @if($result->type == 'variable')
                                                    <div class="variation-container card">
                                                        <input class="variation-collapse-open" type="checkbox" id="variation-collapse">
                                                        <label class="header card-header cursor-pointer variation-collapse-btn" for="variation-collapse">Expand Variation</label>
                                                    @endif
                                                        <div class="content">
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            @foreach($result->variationProducts as  $key => $product_variation)
                                                                <div class="card mb-3 ebay-variation-card">
                                                                    <div>
                                                                        @if($result->type == 'variable')
                                                                            {{-- <input class="collapse-open" type="checkbox" id="collapse-{{$no}}">
                                                                            <label class="collapse-btn" style="width: 100%;cursor: grab;" for="collapse-{{$no}}"> --}}
                                                                                <div class="card-header variation-header cursor-pointer" id="variation-header-{{$product_variation->id}}" onclick="variationDisplay({{$product_variation->id}})">
                                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                                        <div>
                                                                                            {{ $no }}. &nbsp; [{{$product_variation->sku}}]
                                                                                            @if($result->type == 'variable')
                                                                                                @isset($product_variation->variation_specifics)
                                                                                                    @if(is_array(unserialize($product_variation->variation_specifics)))
                                                                                                        @foreach(unserialize($product_variation->variation_specifics) as $key1 =>$variation_specifics)
                                                                                                            [{{$variation_specifics}}]
                                                                                                        @endforeach
                                                                                                    @else
                                                                                                        @php
                                                                                                        echo "<pre>";
                                                                                                            print_r($product_variation->variation_specifics);
                                                                                                        @endphp
                                                                                                    @endif
                                                                                                @endisset
                                                                                            @endif
                                                                                        </div>
                                                                                        <div>
                                                                                            <i class="fas fa-arrow-down" id="fa-arrow-down-{{$product_variation->id}}"></i>
                                                                                            <i class="fas fa-arrow-up d-none" id="fa-arrow-up-{{$product_variation->id}}"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            {{-- </label> --}}
                                                                        @endif
                                                                        @if($result->type == 'variable')
                                                                        {{-- <div class="collapse-painel"> --}}
                                                                        <div class="d-none" id="collapsePainel-{{$product_variation->id}}">
                                                                            <div class="collapse-inner">
                                                                                @endif
                                                                                <div class="wms-row">
                                                                                    <div class="wms-col-12">
                                                                                        <div class="variation_step_1">
                                                                                            <div class="wms-row">
                                                                                                <div class="wms-col-6">
                                                                                                    <div class="input-wrapper">
                                                                                                        <label class="variation-sku" for="sku">SKU</label>
                                                                                                        <input type="text" id="sku" class="form-control variation-sku @error('ean') is-invalid @enderror" name="productVariation[{{$key}}][sku]" value="{{$product_variation->sku}}" autocomplete="sku" readonly autofocus>
                                                                                                        <input type="hidden" name="productVariation[{{$key}}][variation_id]" value="{{$product_variation->master_variation_id}}">
                                                                                                        <input type="hidden" name="productVariation[{{$key}}][ebay_variation_id]" value="{{$product_variation->id}}">
                                                                                                        {{--                                                                                                    <input type="checkbox" name="productVariation[{{$key}}][delete]" value="">--}}
                                                                                                        @error('sku')
                                                                                                        <span class="invalid-feedback" role="alert">
                                                                                                                <strong>{{ $message }}</strong>
                                                                                                            </span>
                                                                                                        @enderror
                                                                                                    </div>
                                                                                                </div>
                                                                                                @if($result->type == 'variable')
                                                                                                    @foreach(unserialize($product_variation->variation_specifics) as $key1 =>$variation_specifics)
                                                                                                        <div class="wms-col-6">
                                                                                                            <div class="input-wrapper">
                                                                                                                <label class="variation-size" for="{{$key1}}">{{$key1}}</label>
                                                                                                                <input type="text" id="{{$key1}}" class="form-control variation-size @error('Style') is-invalid @enderror" name="productVariation[{{$key}}][{{$key1}}]" value="{{$variation_specifics}}" autocomplete="{{$key1}}" autofocus>
                                                                                                                <input type="hidden" name="productVariation[{{$key}}][attribute][{{$key1}}]" value="{{$variation_specifics}}">
                                                                                                                <input type="hidden" name="attribute[{{$key1}}][]" value="{{$variation_specifics}}">
                                                                                                                <input type="hidden" name="variation_image[{{$key1}}][{{$product_variation->attribute3}}][]" value="{{$variation_specifics}}">
                                                                                                                @error('Style')
                                                                                                                <span class="invalid-feedback" role="alert">
                                                                                                                        <strong>{{ $message }}</strong>
                                                                                                                    </span>
                                                                                                                @enderror
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    @endforeach
                                                                                                @endif
                                                                                                <div class="wms-col-6">
                                                                                                    <div class="input-wrapper">
                                                                                                        <label class="variation-start-price" for="start_price">Start Price</label>
                                                                                                        <input type="text" id="start_price" class="form-control variation-start-price @error('start_price') is-invalid @enderror" name="productVariation[{{$key}}][start_price]" value="{{$product_variation->start_price}}" autocomplete="start_price" autofocus>
                                                                                                        @error('start_price')
                                                                                                        <span class="invalid-feedback" role="alert">
                                                                                                                <strong>{{ $message }}</strong>
                                                                                                            </span>
                                                                                                        @enderror
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="wms-col-6">
                                                                                                    <div class="input-wrapper">
                                                                                                        <label class="variation-rrp required" for="rrp">RRP</label>
                                                                                                        <input type="text" id="rrp" class="form-control variation-rrp @error('rrp') is-invalid @enderror" name="productVariation[{{$key}}][rrp]" value="{{$product_variation->rrp}}" maxlength="80" onkeyup="Count();" autocomplete="rrp" autofocus required>
                                                                                                        <span id="rrp" class="float-right"></span>
                                                                                                        @error('rrp')
                                                                                                        <span class="invalid-feedback" role="alert">
                                                                                                                <strong>{{ $message }}</strong>
                                                                                                            </span>
                                                                                                        @enderror
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="wms-col-6">
                                                                                                    <div class="input-wrapper">
                                                                                                        <label class="variation-ean" for="ean">Enter EAN</label>
                                                                                                        <input type="text" id="ean" class="form-control variation-ean @error('ean') is-invalid @enderror" name="productVariation[{{$key}}][ean]" value="{{$product_variation->ean}}" autocomplete="ean" autofocus>
                                                                                                        @error('ean')
                                                                                                        <span class="invalid-feedback" role="alert">
                                                                                                                <strong>{{ $message }}</strong>
                                                                                                            </span>
                                                                                                        @enderror
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="wms-col-6">
                                                                                                    <div class="input-wrapper">
                                                                                                        <label class="variation-quantity" for="quantity">Enter Quantity</label>
                                                                                                        <input type="text" id="quantity" class="form-control variation-quantity @error('quantity') is-invalid @enderror" name="productVariation[{{$key}}][quantity]" value="{{$product_variation->quantity}}" autocomplete="quantity" readonly autofocus>
                                                                                                        @error('quantity')
                                                                                                        <span class="invalid-feedback" role="alert">
                                                                                                                <strong>{{ $message }}</strong>
                                                                                                            </span>
                                                                                                        @enderror
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div><!--End wms-col-12-->
                                                                                </div><!--End wms row-->
                                                                                @if($result->type == 'variable')
                                                                            </div><!--End collapse-inner-->
                                                                        </div><!--End collapse-painel-->
                                                                        @endif
                                                                    </div><!--End empty div-->
                                                                </div><!--End card-->
                                                                @php
                                                                    $no++;
                                                                @endphp
                                                            @endforeach
                                                        </div><!--End Content-->
                                                        @if($result->type == 'variable')
                                                    </div><!--End variation container-->
                                                    @endif

                                                </div> <!--End col-md-10 -->

                                            </div><!--End form group row-->

                                    @endisset

                                    <!-- End  variation   -->


                                                @if($result->type == 'variable')
                                                <div class="form-group row" style="display: none">
                                                    <div class="col-md-3 d-flex align-items-center">
                                                        <div>
                                                            <label for="image_attribute" class="col-form-label r-sec required">Image Variation</label>
                                                        </div>
                                                        <div class="ml-1">
                                                            <div id="wms-tooltip">
                                                                <span id="wms-tooltip-text">Tooltips are labels that appear on hover and focus when</span>
                                                                <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select class="form-control select2" name="image_attribute">
                                                            <option value="{{$result->image_attribute}}" selected>{{$result->image_attribute}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif



                                            <div class="form-group row" style="display: none">
                                                <div class="col-md-2">   </div>
                                                <div class="col-md-10">
                                                    <button type="button" class="btn btn-primary m-t-10" id="list_button" style="display: none;">List</button>
                                                    <input type="text" class="form-control" name="last_cat_id" id="last_cat_id" style="display: none;" value="{{$result->category_id}}">
                                                    <input type="text" class="form-control" name="last_cat2_id" id="last_cat2_id" style="display: none;" value="{{$result->sub_category_id}}">
                                                </div>
                                            </div>

                                            <div class="form-group row" style="display: none">
                                                <div class="col-md-2">   </div>
                                                <div class="col-md-10">
                                                    <button type="button" class="btn btn-primary m-t-10" id="list_button" style="display: none;">List</button>
                                                    <input type="text" class="form-control" name="last_cat_id" id="last_cat_id" style="display: none;" value="{{$result->category_id}}">
                                                </div>
                                            </div>

                                    </div>
                                </div>

                                {{-- End Drawer box modal --}}





                                <div class="form-group  row">
                                    <div class="col-md-2 d-flex align-items-center">
                                        <div>
                                            <label for="name" class="col-form-label required">Title</label>
                                        </div>
                                        <div class="ml-1">
                                            <div id="wms-tooltip">
                                                <span id="wms-tooltip-text" class="title-tooltip-text">
                                                    A descriptive title helps buyers find your item. State exactly what your item is. Include words that buyers might use to search for your item.
                                                </span>
                                                <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                            </div>
                                        </div>
                                        <div class="ebay-edit-title-switch-btn">
                                            <div class="onoffswitch mb-sm-10 res-onoff-btn">
                                                <input type="checkbox" value="{{\Opis\Closure\unserialize($result->draft_status)['title_flag'] ?? 0}}" name="title_flag" class="onoffswitch-checkbox"  id="title_flag" tabindex="1" @isset(\Opis\Closure\unserialize($result->draft_status)['title_flag']) @if (\Opis\Closure\unserialize($result->draft_status)['title_flag'] == 1)  checked @else unchecked @endif @endisset>
                                                <label class="onoffswitch-label" for="catalogue-name">
                                                    <span onclick="onOff('title_flag')" class="onoffswitch-inner"></span>
                                                    <span onclick="onOff('title_flag')" class="ebay-onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$result->title}}" maxlength="80" onkeyup="Count();" oninput="autoOff('title_flag');" required autocomplete="name" autofocus>
                                        <span id="display" class="float-right"></span>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group  row subtitle-div" id="sub">
                                    <div class="col-md-2 subtitle-inner ebay-edit-subtitle">
                                        <div>
                                            <label for="name" class="col-form-label">Subtitle <label id="subl"> </label></label>
                                        </div>
                                        <div class="subtitle-tooltip">
                                            <div id="wms-tooltip">
                                                <span id="wms-tooltip-text">
                                                    Subtitles appear in eBay search results in list view and can increase buyer interest by providing more descriptive info. <b>(fees may apply)</b>
                                                </span>
                                                <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <input id="subtitle" type="text" class="form-control @error('subtitle') is-invalid @enderror" name="subtitle" value="{{$result->subtitle}}" maxlength="80" autocomplete="name" autofocus>
                                        <span id="display" class="float-right"></span>
                                        @error('subtitle')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <input type="hidden" name="profile_id" value="{{$result->profile_id}}">


                                <div class="form-group pt-3 row">
                                    <div class="col-md-2 d-flex">
                                        <div>
                                            <label for="image_flag" class="col-form-label">Product Image<span id="default_counter"></span></label>
                                        </div>
                                        <div class="ml-1 mt-1 mt-sm-2">
                                            <div id="wms-tooltip">
                                                <span id="wms-tooltip-text">The right picture is the key to convert your visitor into a customer. Photos need to be at least 500 pixels on the longest side but we recommend you aim for 800-1600 pixels on the longest side. <b>(fees may apply)</b></span>
                                                <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="d-flex mb-2">
                                            <div class="onoffswitch mb-sm-10">
                                                <input type="checkbox" value="{{\Opis\Closure\unserialize($result->draft_status)['image_flag'] ?? 0}}" name="image_flag" class="onoffswitch-checkbox" id="image_flag" tabindex="1" @isset(\Opis\Closure\unserialize($result->draft_status)['image_flag']) @if (\Opis\Closure\unserialize($result->draft_status)['image_flag'] == 1)  checked @else unchecked @endif @endisset>
                                                <label class="onoffswitch-label" for="catalogue-name">
                                                    <span onclick="onOff('image_flag')" class="onoffswitch-inner"></span>
                                                    <span onclick="onOff('image_flag')" class="ebay-onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                            <div id="counter"></div>
                                        </div>
                                        <div class="row pl-2 ebay-glsm">
                                            <div class="col-md-6 main-lf-image-content">
                                                <div class="main_image_show">
                                                    <span class="prev hide">Prev</span>
                                                    <div class="md-trigger hide" data-modal="modal-12">Click to enlarge</div>
                                                    <div class="showimagediv create-ebay-showimagediv"></div>
                                                    <span class="next hide">Next</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 master-pro-img" style="padding:0;">
                                                <ul class="d-flex flex-wrap sortable ebay-image-wrap edit-wrap create-ebay-image-wrap" id="sortableImageDiv">

                                                    @if(isset($master_images))
                                                        @php
                                                            $counter = 0;
                                                        @endphp
                                                        @foreach($master_images as $master_image)
                                                            <li class="drag-drop-image active">
                                                                <a class="cross-icon bg-white border-0 btn-outline-light" id="{{$master_image ?? ''}}" onclick="removeLi(this)">&#10060;</a>
                                                                <input type="hidden" id="image" name="newUploadImage[]" value="{{$master_image}}">
                                                                <span class="main_photo"></span>
                                                                <img class="drag_drop_image" src="{{$master_image}}">
                                                                <p class="drag_and_drop hide"></p>
                                                            </li>
                                                            @php
                                                                $counter++;
                                                            @endphp
                                                        @endforeach
                                                        @for($i=0; $i< 12-$counter; $i++)
                                                        <div class="drag-drop-image add-photos-content no-img-content">
                                                            <p class="inner-add-sign">&#43;</p>
                                                            <input style="opacity: 0" type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control ebay-image-upload" accept="/image" onchange="preview_image();" multiple disabled>
                                                            <p class="inner-add-photo">Add Photos</p>
                                                        </div>
                                                        @endfor
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        @error('ean')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="custom-control custom-checkbox d-flex align-items-center">
                                                    <input type="checkbox" name="galleryPlus" value="1" class="custom-control-input galleryPlus" id="galleryPlus" @if($result->galleryPlus) checked @endif>
                                                    <strong>  Display a large photo in search results with Gallery Plus <span id="productImg"></span> <span id="imgfees">(fees may apply)</span></strong>
                                                    <label class="custom-control-label" for="galleryPlus"> </label>
                                                </div>
                                                {{-- <input type="checkbox" name="galleryPlus" onclick="verify()" value="1" @if($result->galleryPlus) checked @endif> --}}

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
                                    <div class="col-md-2 d-flex">
                                        <div>
                                            <label for="description_flag" class="col-form-label required">Description</label>
                                        </div>
                                        <div style="margin-left: 5px !important">
                                            <div id="wms-tooltip">
                                                <span id="wms-tooltip-text">
                                                    Describe the item you're selling and provide complete and accurate details. Use a clear and concise format to ensure your description is mobile-friendly.
                                                </span>
                                                <span><img class="wms-tooltip-image mt-2 ml-1 ml-sm-0" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="onoffswitch mb-sm-10 res-onoff-btn mb-2">
                                            <input type="checkbox" value="1" name="description_flag" class="onoffswitch-checkbox" id="description_flag" tabindex="1" @isset(\Opis\Closure\unserialize($result->draft_status)['description_flag']) @if (\Opis\Closure\unserialize($result->draft_status)['description_flag'] == 1)  checked @else unchecked @endif @endisset>
                                            <label class="onoffswitch-label" for="description_flag">
                                                <span onclick="onOff('description_flag')" class="onoffswitch-inner"></span>
                                                <span onclick="onOff('description_flag')" class="ebay-onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ebay-description-container card">
                                            <input class="ebay-description-collapse-open" type="checkbox" id="ebay-description-collapse">
                                            <label class="ebay-description-header cursor-pointer ebay-description-collapse-btn" for="ebay-description-collapse">Expand Description</label>
                                            <div class="ebay-description-content" style="display: none;">
                                                {{-- <div class="onoffswitch mb-sm-10 res-onoff-btn mb-2">
                                                    <input type="checkbox" value="1" name="description_flag" class="onoffswitch-checkbox" id="description_flag" tabindex="1" @isset(\Opis\Closure\unserialize($result->draft_status)['description_flag']) @if (\Opis\Closure\unserialize($result->draft_status)['description_flag'] == 1)  checked @else unchecked @endif @endisset>
                                                    <label class="onoffswitch-label" for="description_flag">
                                                        <span onclick="onOff('description_flag')" class="onoffswitch-inner"></span>
                                                        <span onclick="onOff('description_flag')" class="ebay-onoffswitch-switch"></span>
                                                    </label>
                                                </div> --}}
                                                <textarea id="messageArea" class="form-control" name="description" required autocomplete="description" oninput="autoOff('description_flag');" autofocus>{{$result->description}}</textarea>
                                                @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div id="add_variant_product">

                                    <div class="form-group row">
                                        <div class="col-md-2 d-flex">
                                            <div>
                                                <label for="item_specific" class="col-form-label required">Item Specifies</label>
                                            </div>
                                            <div class="ml-1 mt-1 mt-sm-2">
                                                <div id="wms-tooltip">
                                                    <span id="wms-tooltip-text">
                                                        Provide info about the item you're selling, such as brand, size type, size, colour and style. These details help buyers find your item when they filter their searches and appear at the top of your listing description in a consistent format.
                                                    </span>
                                                    <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                </div>
                                            </div>
                                        </div>
                                        @isset($item_specifics['Recommendations']['NameRecommendation'])
                                            <div class="col-md-10">


                                                <div class="col-md-12">
                                                    {{--                                                        <h5></h5><span>(Write your value after the already inserted id and don't give '/' slash in your input value)</span><br>--}}
                                                </div>


                                                <div class="row d-flex justify-content-between">
                                                    @foreach($item_specifics['Recommendations']['NameRecommendation'] as $index => $item_specific)
                                                        @php
                                                            $counter = 0;
                                                            if ($result->type == 'variable' && isset($result->variation_specifics)){
                                                                foreach (unserialize($result->variation_specifics) as $key => $value){
                                                                    if($key == $item_specific['Name']){
                                                                        $counter++;
                                                                    }
                                                                }
                                                            }

                                                        @endphp
                                                        @if(isset($item_specific['Name']) && $counter == 0)
                                                            <div class="col-md-3 mb-3">
                                                                <label style="font-weight: normal">{{$item_specific['Name']}}
                                                                    @if($item_specific['ValidationRules']['UsageConstraint'] == 'Required')
                                                                        <strong>*</strong>
                                                                    @endif
                                                                </label>

                                                                <input type="search" class="form-control" list="modelslist{{$index}}"  name='item_specific[{{$item_specific['Name']}}]' value="{{isset($item_specific_results[$item_specific['Name']]) ? $item_specific_results[$item_specific['Name']] : ''}}">
                                                                @if(isset($item_specific['ValueRecommendation']))

                                                                    <datalist id="modelslist{{$index}}">
                                                                        @foreach($item_specific['ValueRecommendation'] as $recommendation)
                                                                            @if(isset($recommendation['Value']))
                                                                                <option value="{{$recommendation['Value']}}">
                                                                            @endif
                                                                        @endforeach
                                                                    </datalist>

                                                                @endif
                                                                {{--                                                                            <input type="text" class="form-control" name='item_specific[{{$item_specific['Name']}}]' value="{{$item_specific_result}}">--}}

                                                                {{--                        <select name='item_specific[{{$item_specific['Name']}}]' class="form-control select2">--}}
                                                                {{--                            <option value="">Select-{{$item_specific['Name']}}</option>--}}
                                                                {{--                            <option value="">ABC</option>--}}
                                                                {{--                            <option value="">BDC</option>--}}
                                                                {{--                            <option value="">BDF</option>--}}
                                                                {{--                            <option value="">ADE</option>--}}
                                                                {{--                        </select>--}}
                                                            </div>
                                                        @endif
                                                        @php
                                                            $counter = 0;
                                                        @endphp
                                                    @endforeach
                                                </div>


                                            </div>

                                        @endisset
                                    </div>


                                    <div class="form-group row campaign">
                                        <div class="col-md-2 d-flex">
                                            <div>
                                                <label for="campaign" class="col-form-label">Campaigns</label>
                                            </div>
                                            <div class="ml-1 mt-1 mt-sm-2">
                                                <div id="wms-tooltip">
                                                    <span id="wms-tooltip-text">
                                                        A campaign is a simple way to organise your promoted listings into a single group, and allows you to track performance and manage all of your listings at the same time on your
                                                    </span>
                                                    <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="ebay-campaigns-container card">
                                                <input class="ebay-campaigns-collapse-open" type="checkbox" id="ebay-campaigns-collapse">
                                                <label class="ebay-campaigns-header cursor-pointer ebay-campaigns-collapse-btn" for="ebay-campaigns-collapse">Expand Campaigns</label>
                                                <div class="ebay-campaigns-content" style="display: none;">
                                            {{-- <div class="ebay-description-container card">
                                                <input class="ebay-description-collapse-open" type="checkbox" id="ebay-description-collapse">
                                                <label class="ebay-description-header card-header cursor-pointer ebay-description-collapse-btn" for="ebay-description-collapse">Expand Description</label>
                                                <div class="ebay-description-content" style="display: none;"> --}}
                                                    <div class="d-flex align-items-center">
                                                        <div class="custom-control custom-checkbox">
                                                            <input name="campaign_checkbox" type="checkbox" class="custom-control-input campaign_checkbox" id="campaign_checkbox" checked>
                                                            <label class="custom-control-label" for="campaign_checkbox"> </label>
                                                        </div>
                                                        <div>
                                                            <p class="font-16">Boost your item's visibility with premium placements on eBay and pay only if your item sells.<a href="https://pages.ebay.co.uk/seller-center/promoted-listings-learnmore" class="ml-1 text-decoration" target="_blank">Learn more</a></p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center my-3">
                                                        <div>
                                                            <p class="font-16 mr-2">Set ad rate</p>
                                                        </div>
                                                        <div id="wms-tooltip">
                                                            <span id="wms-tooltip-text">
                                                                Ad rate is the percentage of your final sale price that you’ll pay if your item sells via promoted listings within 30 days of a click on your ad. <b>Suggested ad rates</b> are tailored to each of your listings and designed to help you find the balance between cost and performance.
                                                            </span>
                                                            <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="div_disable">
                                                        <div class="col-md-3">
                                                            <p>
                                                                <img style="cursor: pointer; width: 30px; height: 30px" src="{{asset('assets/common-assets/MINUS.png')}}" class="minus mb-1">
                                                                <input type="text" size="3" class="qty items_number" name="bid_rate" onkeyup="percentage();" value="{{isset(unserialize($result->campaign_data)["bidPercentage"]) ? unserialize($result->campaign_data)["bidPercentage"] : '0.0'}}"> %
                                                                <img style="cursor: pointer; width: 30px; height: 30px" src="{{asset('assets/common-assets/PLUS.png')}}" class="plus mb-1">
                                                            </p>
                                                            <input type="hidden" name="suggested_rate" value="{{$suggested_rate}}">
                                                            <p class="mt-3 mb-3 text-decoration cursor-pointer" onclick="suggestRate();">Suggested ad rate {{$suggested_rate}}%</p>
                                                            @if(isset($campaigns))
                                                                @php
                                                                    $campaign_id = '';
                                                                    if(isset(unserialize($result->campaign_data)["campaignId"])){
                                                                        $campaign_id =unserialize($result->campaign_data)["campaignId"];
                                                                    }
                                                                @endphp
                                                            <div style="float: right">
                                                                <select name='campaign_id' class="form-control select2 campaign_id" id="campaign_id">
                                                                    @foreach($campaigns->campaigns as $campaign)
                                                                        @if($campaign->campaignId == $campaign_id)
                                                                            <option value="{{$campaign->campaignId}}" data-campaign="" selected>{{$campaign->campaignName}}</option>
                                                                        @elseif($campaign_id == null)
                                                                            <option value="null" data-campaign="" selected>Remove Campaign</option>
                                                                        @else
                                                                            <option value="{{$campaign->campaignId}}" data-campaign="" >{{$campaign->campaignName}}</option>
                                                                        @endif
                                                                    @endforeach

                                                                </select>
                                                            </div>

                                                            @endif
                                                        </div>

                                                        <div class="col-md-1">
                                                            <div class="vl"></div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <p><b><span id="display_max_min_percentage">£0.00 - £0.00</span></b></p>
                                                            <p>(<span id="display_max_min_vat_percentage">£0.00 - £0.00</span> inclusive of VAT, if applicable)</p>
                                                            <p>Ad fee if this item sells through promoted listings</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="card px-3 py-3">

                                            </div> --}}
                                        </div>
                                    </div>

                                </div>
                                <input type="hidden" id="create_fees" value="{{unserialize($result->fees)["Fee"] ?? null}}">


                                <div class="form-group row" >
                                    <div class="col-md-2 d-flex align-items-center">
                                        <div>
                                            <label for="image_attribute" class="col-form-label">Total Fee</label>
                                        </div>
                                        <div class="ml-1">
                                            <div id="wms-tooltip">
                                                <span id="wms-tooltip-text">
                                                    Click on the amount to see a breakdown of your fees.
                                                </span>
                                                <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="totalFees" class="col-md-10 d-flex align-items-center">
                                        <div>£0.0</div>
                                    </div>
                                    <input type="hidden" id="total_fees" name="total_fees" value="">
                                </div>
                                <div id="myModal" class="modal fade" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Error</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <p id="error"></p>
                                            </div>
                                            {{--                                        <div class="modal-footer">--}}
                                            {{--                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>--}}
                                            {{--                                            <button type="button" class="btn btn-primary">Save</button>--}}
                                            {{--                                        </div>--}}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <span class="draft-pro-btn btn btn-primary waves-effect waves-light" onclick="verify()">
                                            <b> Verify </b>
                                        </span>
                                        <button type="submit" class="btn btn-primary draft-pro-btn waves-effect waves-light ml-2">
                                            <b> Update </b>
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
     <!-- <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script> -->
    <!-- <script>
        const checkbox = document.getElementById('description_flag');
        CKEDITOR.replace('description');
        for (const i in CKEDITOR.instances) {
            CKEDITOR.instances[i].on('change', function () {
                checkbox.checked = false;
                checkbox.value = 0;
            });
        }
    </script> -->

    <script>
        // window.onload = function() {
        //     verify();
        // };
        // // Select Option  jquery
        // $('.select2').select2();


        //ckeditor summernote
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
        //End ckeditor summernote
        function updateCampaign() {
            var item_id = $("#item_id").val()
            var account_id = $("#").val()
            $.ajax({
                type:"post",
                url: "{{url("update-ebay-campaign")}}",
                data:{
                    "_token": "{{csrf_token()}}",
                    "account_id": account_id,
                    "item_id": item_id
                },
                beforeSend: function () {

                },
                success:function (response) {

                },
                complete:function (data) {

                }
            })
        }

        function Count() {
            var i = document.getElementById("name").value.length;
            document.getElementById("display").innerHTML = 'Character Remain: '+ (80 - i);
        }

        function myFunction(id) {
            // console.log('found');

            // Category choose
            // $(document).ready(function () {
            //     $('select').on("change",function(){
            var category_id = $('#child_cat_'+id).val();
            var category = category_id.split('/');
            var category_id = category[0];
            var account_id = $('#account_id').val();
            var site_id = $('#site_id').val();
            console.log(category_id);
            console.log(parseInt(id)+1);
            $.ajax({
                type: "post",
                url: "{{url('get-ebay-category')}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    "category_id": category_id,
                    "account_id" : account_id,
                    "site_id"    : site_id,
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

        function getAccountSiteData() {
            var account_id = $('#account_id').val();
            var site_id = $('#site_id').val();

            if(account_id !='' && site_id !=''){
                console.log(account_id,site_id);

                $.ajax({
                    type: "post",
                    url: "{{url('get-account-site-data')}}",
                    data: {
                        "_token": "{{csrf_token()}}",
                        "account_id": account_id,
                        "site_id": site_id,

                    },
                    beforeSend: function (){
                        $('#ajax_loader').show();
                    },
                    success: function (response) {
                        console.log(response);
                        $('#account_site_data').html(response);
                        // if(response.data == 1) {
                        //     console.log(response.content);
                        //     console.log(response.lavel);
                        //     $('#category-level-' + response.lavel + '-group').nextAll().remove();
                        //     $('#last_cat_id').val('');
                        //     $('#last_cat_id').hide();
                        //     $('#all_category_div').append(response.content);
                        //
                        // }else{
                        //     $('#last_cat_id').show();
                        //     $('#last_cat_id').val(category_id);
                        //     console.log(response);
                        //     $('#add_variant_product').html(response);
                        // }
                    },
                    complete: function (data) {
                        $('#ajax_loader').hide();
                    }
                });
            }

        }

        function feederQuantity(){
             var feederQty  = document.getElementById('custom_feeder_quantity').value;
             //console.log('Test feederQTY '+feederQty)
            if(feederQty <= 0){
                document.getElementById('custom_feeder_flag').value = 0;
                document.getElementById('custom_feeder_flag').checked = false;
            }else{
                document.getElementById('custom_feeder_flag').value = 1;
                document.getElementById('custom_feeder_flag').checked = true;
            }
        }

        function onOff(id){
            // console.log(document.getElementById($id).value);
            var value_clicked = $('#'+id).val();

            if(value_clicked == 1){
                document.getElementById(id).value = 0;
                document.getElementById(id).checked = false;
            }
            else{
                document.getElementById(id).value = 1;
                document.getElementById(id).checked = true;
            }
            //console.log(document.getElementById($id).value);
        }

        function myFunction2(id,remove = 0) {

            // Category choose
            // $(document).ready(function () {
            //     $('select').on("change",function(){
            var category_id = $('#child_cat2_'+id).val();
            var category = category_id.split('/');
            var category_id = category[0];
            var account_id = $('#account_id').val();
            var site_id = $('#site_id').val();
            console.log(category_id);
            console.log(parseInt(id)+1);
            $.ajax({
                type: "post",
                url: "{{url('get-ebay-subcategory')}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    "category_id": category_id,
                    "account_id" : account_id,
                    "site_id"    : site_id,
                    "level" : parseInt(id)+1
                },
                beforeSend: function (){
                    $('#ajax_loader').show();
                },
                success: function (response) {
                    // verify()

                    if(response.data == 1) {
                        console.log(response.content);
                        console.log(response.lavel);
                        if (remove == 'remove'){
                            $('#category2-level-' + 0 + '-group').nextAll().remove();
                        }else{
                            $('#category2-level-' + response.lavel + '-group').nextAll().remove();
                        }

                        $('div.edit-ebay-close-btn').show()
                        $('#last_cat2_id').val('');
                        $('#last_cat2_id').hide();
                        $('#all_category_div2').append(response.content);

                        if(remove == 'remove'){
                            $('div.empty-div').each(function(i, item){
                                // console.log(item)
                                $(item).first().remove()
                            })
                        }

                    }else{
                        // $('#last_cat2_id').show();
                        $('#last_cat2_id').val(category_id);
                        console.log(response);

                    }

                },
                complete: function (data) {
                    $('#ajax_loader').hide();
                }
            });
            //     });
            // });
        }

        // $(window).scroll(function () {
        //     if($(window).scrollTop() >= ($(document).height() - $(window).height())-150){
        //         window.stop()
        //         verify()
        //     }
        // });

        function verify(){
            // console.log("console test")
            // var profile_id = profileId
            var queryString = $('form').serialize();

            // console.log(queryString)
            $.ajax({
                url: "{{url("verify-ebay-product")}}",
                type: "POST",
                data:{
                    "_token" : "{{csrf_token()}}",
                    "form_data" : queryString,

                },
                beforeSend: function (){
                    $('#ajax_loader').show();
                },
                success : function (response) {
                    var total_profile_fees = 0;
                    var total_fees = 0;
                    // console.log(response);
                    // response.fees.forEach(function (fee,index) {
                    //      console.log(fee.index);
                    //     fee.index.forEach(function (item,i) {
                    //         console.log(item)
                    //     })
                    // })
                    //     console.log(response.fees)
                    if(typeof response.fees !== 'undefined') {
                        if(typeof response.fees[0][19] !== 'undefined'){
                            document.getElementById("subl").innerText = "fee(" + response.fees[0][19]['Fee'] + ")";
                        }
                        if(typeof response.fees[0][5] !== 'undefined'){
                            document.getElementById("productImg").innerText = "fee(" + response.fees[0][5]['Fee'] + ")";
                            document.getElementById("imgfees").style.display = "none";
                        }
                        if(typeof response.fees[0][24] !== 'undefined'){
                            document.getElementById("privateListing").innerText = "fee(" + response.fees[0][24]['Fee'] + ")";
                        }
                        if(typeof response.fees[0][27] !== 'undefined'){
                            document.getElementById("intSiteVisibility").innerText = "fee(" + response.fees[0][27]['Fee'] + ")";
                        }

                        // document.getElementById("subl").innerText = "fee(" + response.fees[0][19]['Fee'] + ")";
                        // document.getElementById("productImg").innerText = "fee(" + response.fees[0][5]['Fee'] + ")";
                        // document.getElementById("privateListing").innerText = "fee(" + response.fees[0][24]['Fee'] + ")";
                        // document.getElementById("intSiteVisibility").innerText = "fee(" + response.fees[0][27]['Fee'] + ")";

                        // document.getElementById("pName").innerText = response.fees[0][14]['Fee'];
                        total_fees = parseFloat(response.fees[0][14]['Fee']).toPrecision(3) - parseFloat(response.fees[0][14]['PromotionalDiscount'])
                        // console.log(key, value[0][19]['Name']);
                        var create_fees = $('#create_fees').val();
                        // console.log(create_fees);
                        if (create_fees != '') {
                            total_fees = total_fees.toPrecision(3) - parseFloat(create_fees).toPrecision(3)
                        }

                        // console.log(response)
                        document.getElementById("totalFees").innerText = total_fees.toPrecision(2)
                        var create_total = parseFloat(total_fees) + parseFloat(create_fees)
                        // console.log(create_total)
                        $('#total_fees').val(create_total)
                    }else if(typeof response.message !== 'undefined'){
                        $("#error").text("")
                        if(typeof response.message[0] !== 'undefined'){

                            for (const [key, value] of Object.entries(response.message)) {
                                $("#error").append("<li>"+value.ShortMessage+"</li>")
                                $("#myModal").modal('show');
                            }
                        }else{
                            $("#error").append("<li>"+response.message.ShortMessage+"</li>")
                            $("#myModal").modal('show');
                        }


                        // console.log('error')
                        // $("#error").text(response.message)
                        // console.log(response.message)
                        // $("#myModal").modal('show');
                    }


                },
                complete: function (data) {
                    $('#ajax_loader').hide();
                }
            })
        }

        function autoOff(id){


            document.getElementById(id).checked = false;
            document.getElementById(id).value = 0;

            // if ($id == 'title_flag' && counter_title_flag == 0){
            //     document.getElementById($id).checked = false;
            //     document.getElementById($id).value = 0;
            //     counter_title_flag++;
            // }else if($id == 'description_flag' && counter_description_flag == 0){
            //     document.getElementById($id).checked = false;
            //     document.getElementById($id).value = 0;
            //     counter_description_flag++;
            // }else if($id == 'image_flag' && counter_image_flag == 0){
            //     document.getElementById($id).checked = false;
            //     document.getElementById($id).value = 0;
            //     counter_image_flag++;
            // }
            //  $('#'+id).one(function() {
            //     // alert('You will only see this once.');
            //         document.getElementById(id).checked = false;
            //         document.getElementById(id).value = 0;
            //  });

        }


        // $('p.text-decoration').on('click',function(){
        //     var getTxtNum = $(this).text().replace(/[^0-9.]/gi, '')
        //     var getFloatNum = parseFloat(getTxtNum)
        //     $('input.items_number').val(getFloatNum)
        //     console.log('test'+getFloatNum)

        // })





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


        // Collapse Variation Expand Variation
        $(".header").click(function () {
            $header = $(this);
            $content = $header.next();
            $content.slideToggle(500, function () {
                $header.text(function () {
                    return $content.is(":visible") ? "Collapse Variation" : "Expand Variation";
                });
            });
            $(this).toggleClass('primary-color text-white');
        });

        // Collapse Variation Expand Variation
        $(".location-header").click(function () {
            $header = $(this);
            $content = $header.next();
            $content.slideToggle(500, function () {
                $header.text(function () {
                    return $content.is(":visible") ? "Collapse Location & Policy" : "Expand Location & Policy";
                });
            });
            $(this).toggleClass('primary-color text-white');
        });

        // Collapse Description Expand Description
        $('.ebay-description-header').click(function(){
            $header = $(this);
            $content = $header.next();
            $content.slideToggle(500, function(){
                $header.text(function(){
                    return $content.is(":visible") ? "Collapse Description" : "Expand Description";
                })
            })
            $(this).toggleClass('primary-color text-white');
        })

         // Collapse Campaigns Expand Campaigns
         $('.ebay-campaigns-header').click(function(){
            $header = $(this);
            $content = $header.next();
            $content.slideToggle(500, function(){
                $header.text(function(){
                    return $content.is(":visible") ? "Collapse Campaigns" : "Expand Campaigns";
                })
            })
            $(this).toggleClass('primary-color text-white');
        })


        // Item increment decrement input
        $(function () {
            var prices = [];
            // console.log(prices);
            $('input.variation-start-price').each(function(){
                var getPrice = $(this).val().match(/[^£]*$/);
                prices.push(getPrice);
            })
            var max = Math.max.apply(Math, prices);
            var min = Math.min.apply(Math, prices);
            // console.log('This is max price ' + max);
            // console.log('This is min price ' + min);
            $('.plus').on('click',function(){
                var qty = $(this).closest('p').find('.qty');
                var currentVal = parseFloat($(qty).val());
            if (!isNaN(currentVal) && currentVal < 100) {
                $(qty).val((currentVal + 0.1).toFixed(1));
                var after_click_actual_value = currentVal + 0.1;
                // console.log('OnClickinput' + after_click_actual_value);
                var max_sum = (after_click_actual_value*max)/100 + parseFloat(max);
                var min_sum = (after_click_actual_value*min)/100 + parseFloat(min);
                // console.log('This is onclick max_sum ' + max_sum.toFixed(2));
                // console.log('This is onclick min_sum ' + min_sum.toFixed(2));
                var hsum = max_sum - max;
                var lsum = min_sum - min;
                // console.log('Total hsum' + hsum.toFixed(2));
                // console.log('Total lsum' + lsum.toFixed(2));
                $("#display_max_min_percentage").text('£'+ lsum.toFixed(2) + ' - ' + '£' + hsum.toFixed(2));
                $("#display_max_min_vat_percentage").text('£'+ (((lsum*20)/100)+lsum).toFixed(2) + ' - ' + '£' + (((hsum*20)/100)+hsum).toFixed(2));
                }
                if(currentVal >= 100){
                Swal.fire('Oops..','Do not type more than 100','warning')
                    return false
                }
            });
            $('.minus').on('click',function(){
                var qty = $(this).closest('p').find('.qty');
                var currentVal = parseFloat($(qty).val());
                if (!isNaN(currentVal) && currentVal > 0) {
                    $(qty).val((currentVal - 0.1).toFixed(1));
                    var after_click_actual_value = currentVal - 0.1;
                    // console.log('OnClickinput' + after_click_actual_value);
                    var max_sum = (after_click_actual_value*max)/100 + parseFloat(max);
                    var min_sum = (after_click_actual_value*min)/100 + parseFloat(min);
                    // console.log('This is onclick max_sum ' + max_sum.toFixed(2));
                    // console.log('This is onclick min_sum ' + min_sum.toFixed(2));
                    var hsum = max_sum - max;
                    var lsum = min_sum - min;
                    // console.log('Total hsum' + hsum.toFixed(2));
                    // console.log('Total lsum' + lsum.toFixed(2));
                    $('#display_max_min_percentage').text('£'+ lsum.toFixed(2) + ' - ' + '£' + hsum.toFixed(2));
                    $('#display_max_min_vat_percentage').text('£'+ (((lsum*20)/100)+lsum).toFixed(2) + ' - ' + '£' + (((hsum*20)/100)+hsum).toFixed(2));
                }
                if(currentVal <= 0){
                    Swal.fire('Oops..','Do not type less than 0','warning')
                    return false
                }
            });
        });




        // Campaign auto price show
        var prices = []
        // console.log(prices);
        $('input.variation-start-price').each(function(){
            var getPrice = $(this).val().match(/[^£]*$/);
            prices.push(getPrice);
        })
        var max = Math.max.apply(Math, prices);
        var min = Math.min.apply(Math, prices);
        // console.log('This is max price ' + max);
        // console.log('This is min price ' + min);

        function suggestRate(){
            var getTxtNum = $('p.text-decoration').text().replace(/[^0-9.]/gi, '')
            var getFloatNum = parseFloat(getTxtNum)
            $('input.items_number').val(getFloatNum)
            console.log('test'+getTxtNum)
            percentage()
        }

        // $('input.items_number').keyup(function(){
        function percentage(){
            var on_input_value = $('input.items_number').closest('p').find('input.items_number').val();
            // console.log('type value', on_input_value)
            // console.log('Oninput' + on_input_value);
            var max_sum = (on_input_value*max)/100 + parseFloat(max);
            var min_sum = (on_input_value*min)/100 + parseFloat(min);
            // console.log('This is max_sum ' + max_sum.toFixed(2));
            // console.log('This is min_sum ' + min_sum.toFixed(2));
            var hsum = max_sum - max;
            var lsum = min_sum - min;
            // console.log('Total hsum' + hsum.toFixed(2));
            // console.log('Total lsum' + lsum.toFixed(2));
            $('#display_max_min_percentage').text('£'+ lsum.toFixed(2) + ' - ' + '£' + hsum.toFixed(2));
            $('#display_max_min_vat_percentage').text('£'+ (((lsum*20)/100)+lsum).toFixed(2) + ' - ' + '£' + (((hsum*20)/100)+hsum).toFixed(2));
        }

        // });


        // Campaign Div content disable enable
        $(document).ready(function(){
            $(".campaign_checkbox").click(function(){
                if(!$(this).is(":checked")){
                    $("#div_disable").addClass("content_disabled");
                }else{
                    $("#div_disable").removeClass("content_disabled");
                }
            });
            // verify()
        });

        // Condition if option New with tags selected
        $(document).ready(function(){
            var selectChangedFunc = function() {
                if ($('#condition-select').val() == '1000/New with tags') {
                    $('#condition-description-sec').hide();
                } else {
                    $('#condition-description-sec').show();
                }
            };

            selectChangedFunc();

            $('#condition-select').change(function() {
                selectChangedFunc();
            });
        });



        //----12 variation Drag drop image

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

        var notexistfirstDefaultImage = $('<div class="img-upload-main-content create-ebay">'+
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

        $('#uploadImage:first').parent('div').removeClass('no-img-content');
        $('li.drag-drop-image img:first').addClass('clicked');
        $('li.drag-drop-image p').text('Drag to rearrange');
        // $('li.drag-drop-image span.main_photo:first').text('Main Photo');
        //$('li.drag-drop-image span.main_photo:gt(0)').hide();
        var imgList = $('li.drag-drop-image').length;
        // console.log(imgList + ' Image list');
        //By default remove attribute disabled
        var firstRemoveAttribute = $('.add-photos-content input:first').attr('disabled');
        $('.add-photos-content input:first').removeAttr(firstRemoveAttribute);
        $('.add-photos-content .inner-add-sign:first,input:first,.inner-add-photo:first').css('opacity', '100');

        // Drag and drop function
        $(function() {
            $(".ebay-image-wrap").sortable({
                    revert: true,
                    update: function() {
                    $('input#image_flag').prop('checked', false)
                    document.getElementById('image_flag').value = 0;
                }
            });
            $( ".ebay-image-wrap" ).disableSelection();
        });


        // Remove image list
        function removeLi(elem){
            $(elem).parent('li').remove();
            document.getElementById('image_flag').value = 0;
            $('input#image_flag').prop('checked', false);
            // console.log($(elem).parent('li').remove());
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
            var notexistfirstDefaultImage = $('<div class="img-upload-main-content create-ebay">'+
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

            $('#uploadImage:first').parent('div').removeClass('no-img-content');

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
                $('button.draftEdit').attr('disabled', false);
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

                        document.getElementById('image_flag').value = 0;
                        $('input#image_flag').prop('checked', false);

                    };



                } // function file close

                reader.readAsDataURL(file);
                })(file);
            }
        }

        function secondaryInputField(){
            $(".ebay-secondary-input-drawer-box").show(500)
        }

        function ebayDrawerBoxCloseBtn(){
            $('.ebay-secondary-input-drawer-box').hide(500)
        }

        $(document).ready(function(){
            $("input#Colour, input#Size").attr('readonly',true)
            $(".ebay-variation-card:last").removeClass('mb-3')
        })

        function variationDisplay(id){
            $("#collapsePainel-"+id).toggleClass('d-none')
            $("i#fa-arrow-down-"+id).toggleClass('d-none')
            $("i#fa-arrow-up-"+id).toggleClass('d-none')
            $("#variation-header-"+id).toggleClass('primary-color text-white')
        }

        $(document).mouseup(function(e){
            var container = $("div.ebay-secondary-input-drawer-box");
            if(!container.is(e.target) && container.has(e.target).length === 0) {
                container.hide(500)
            }
        });

    </script>





@endsection
