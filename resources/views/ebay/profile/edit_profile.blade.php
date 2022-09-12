@extends('master')

@section('title')
    eBay | Profile List | Edit eBay Profile | WMS360
@endsection

@section('content')

    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.css')}}" />
{{--    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>--}}


    <div class="content-page ebay">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <div class="wms-breadcrumb-middle">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">Profile List</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit eBay Profile</li>
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


                            <form role="form" target="_blank" class="vendor-form mobile-responsive" action= {{URL::to('ebay-profile/'.$result->id)}} method="post">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label for="condition" class="col-md-2 col-form-label required">Ebay Account</label>
                                    <div class="col-md-10 wow pulse">
                                        <select id="account_id" class="form-control" name="account_id" onchange="getAccountSiteData()">
                                            <option value="">-</option>
                                            @foreach($accounts as $account)
                                                @if($account->id == $result->account_id)
                                                    <option value="{{$account->id}}" selected>{{$account->account_name}}</option>
                                                @else
                                                    <option value="{{$account->id}}">{{$account->account_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="condition" class="col-md-2 col-form-label required">Ebay Site</label>
                                    <div class="col-md-10 wow pulse">
                                        <select id="site_id" class="form-control" name="site_id" onchange="getAccountSiteData()">
                                            <option value="">-</option>
                                            @foreach($sites as $site)
                                                @if($site->id == $result->site_id)
                                                    <option value="{{$site->id}}" selected>{{$site->name}}</option>
                                                @else
                                                    <option value="{{$site->id}}">{{$site->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="profile_name" class="col-md-2 col-form-label required">Profile Name</label>
                                    <div class="col-md-10 wow pulse">
                                        <input id="profile_name" type="text" class="form-control @error('profile_name') is-invalid @enderror" name="profile_name" value="{{$result->profile_name}}" maxlength="80" onkeyup="Count();" required autocomplete="profile_name" autofocus>
                                        <span id="display" class="float-right"></span>
                                        @error('profile_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="profile_name" class="col-md-2 col-form-label">Profile description</label>
                                    <div class="col-md-10 wow pulse">
                                        <textarea id="profile_description" type="text" class="form-control @error('profile_description') is-invalid @enderror" name="profile_description" value="" maxlength="80" onkeyup="Count();" autocomplete="profile_description" autofocus>{{$result->profile_description}}</textarea>
                                        <span id="display" class="float-right"></span>
                                        @error('profile_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div id="account_site_data">

                                    <div class="form-group row" id="all_category_div">
                                        <label for="Category" class="col-md-2 col-form-label required">Category</label>
                                        <input type="hidden" name="current_category" value="{{$result->category_name}}">
                                        <div class="col-md-10 controls wow pulse" id="category-level-1-group">
                                            <select class="form-control category_select " name="child_cat[1]" id="child_cat_1" onchange="myFunction(1)">
                                                <option value="">{{$result->category_name}}</option>
                                                @foreach($categories[0]["category"] as $category)
                                                    <option value="{{$category['CategoryID']}}//{{$category["pivot"]['CategoryName']}}">{{$category["pivot"]['CategoryName']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="all_category_div2">
                                        <label for="Category" class="col-md-2 col-form-label required">Sub Category</label>
                                        <input type="hidden" name="current_sub_category" value="{{$result->category_name}}">
                                        <div class="" id="category2-level-0-group">

                                        </div>
                                        <div class="col-sm-1 ">
                                            <label class="fa fa-remove" onclick="myFunction2(1,'remove')"></label>
                                        </div>
                                        <div class="col-md-9 controls wow pulse" id="category2-level-1-group">
                                            <select class="form-control category2_select " name="child_cat2[1]" id="child_cat2_1" onchange="myFunction2(1)">
                                                <option value="">{{$result->sub_category_name}}</option>
                                                @foreach($categories[0]["category"] as $category)
                                                    <option value="{{$category['CategoryID']}}//{{$category["pivot"]['CategoryName']}}">{{$category["pivot"]['CategoryName']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="condition" class="col-md-2 col-form-label"></label>
                                        <div class="col-md-10 wow pulse">
                                            <input type="checkbox" name="galleryPlus" value="1" @if($result->galleryPlus) checked @endif><strong>  Display a large photo in search results with Gallery Plus (fees may apply)</strong>
                                        </div>
                                    </div>
                                    <input type="hidden" name="currency" value="{{$result->currency}}">
                                    <div class="form-group row">
                                        <div class="col-md-2">   </div>
                                        <div class="col-md-10">
                                            <button type="button" class="btn btn-primary m-t-10" id="list_button" style="display: none;">List</button>
                                            <input type="text" class="form-control" name="last_cat_id" id="last_cat_id" style="display: none;" value="{{$result->category_id}}">
                                            <input type="text" class="form-control" name="last_cat2_id" id="last_cat2_id" style="display: none;" value="{{$result->sub_category_id}}">
                                        </div>
                                    </div>

                                    <div id="add_variant_product">
                                        <div class="form-group row ">
                                            <label for="Category" class="col-md-2 col-form-label required">Item Specifies</label>
                                            @if(isset($item_specifics['Recommendations']['NameRecommendation']) && $item_specifics != '' )
                                                <div class="col-md-10 wow pulse">


                                                    <div class="col-md-12">
                                                        {{--                                                        <h5></h5><span>(Write your value after the already inserted id and don't give '/' slash in your input value)</span><br>--}}
                                                    </div>


                                                    <div class="row d-flex justify-content-between">
                                                        @foreach($item_specifics['Recommendations']['NameRecommendation'] as $index => $item_specific)
                                                            @isset($item_specific['Name'])
                                                                <div class="col-md-4 mb-3">
                                                                    <label style="font-weight: normal">{{$item_specific['Name']}}
                                                                        @if($item_specific['ValidationRules']['UsageConstraint'] == 'Required')
                                                                            <strong>*</strong>
                                                                        @endif
                                                                    </label>
                                                                    @if($item_specific_results != '')
                                                                        @foreach($item_specific_results as $key => $item_specific_result)
                                                                            @if($item_specific['Name'] == $key)
                                                                                <input type="search" class="form-control" list="modelslist{{$index}}"  name='item_specific[{{$item_specific['Name']}}]' value="{{$item_specific_results[$item_specific['Name']]}}">
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
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                            <input type="search" class="form-control" list="modelslist{{$index}}"  name='item_specific[{{$item_specific['Name']}}]' value="">
                                                                            @if(isset($item_specific['ValueRecommendation']))

                                                                                <datalist id="modelslist{{$index}}">
                                                                                    @foreach($item_specific['ValueRecommendation'] as $recommendation)
                                                                                        @if(isset($recommendation['Value']))
                                                                                            <option value="{{$recommendation['Value']}}">
                                                                                        @endif
                                                                                    @endforeach
                                                                                </datalist>

                                                                            @endif
                                                                    @endif

                                                                    {{--                        <select name='item_specific[{{$item_specific['Name']}}]' class="form-control">--}}
                                                                    {{--                            <option value="">Select-{{$item_specific['Name']}}</option>--}}
                                                                    {{--                            <option value="">ABC</option>--}}
                                                                    {{--                            <option value="">BDC</option>--}}
                                                                    {{--                            <option value="">BDF</option>--}}
                                                                    {{--                            <option value="">ADE</option>--}}
                                                                    {{--                        </select>--}}
                                                                </div>
                                                            @endisset
                                                        @endforeach
                                                    </div>


                                                </div>

                                            @endisset
                                        </div>

                                        <div class="form-group row ">
                                            <label for="Category" class="col-md-2 col-form-label required">Shop Category</label>
                                            @isset($shop_categories['Store']['CustomCategories']['CustomCategory'])
                                                <div class="col-md-10 wow pulse">


                                                    <div class="row d-flex justify-content-between">
                                                        <div class="col-md-4 mb-3">
                                                            <select name='store_id' class="form-control">
                                                                @if(isset($shop_categories['Store']['CustomCategories']['CustomCategory'][0]) && is_array($shop_categories['Store']['CustomCategories']['CustomCategory']))
                                                                    @foreach($shop_categories['Store']['CustomCategories']['CustomCategory'] as $shop_category)
                                                                        @if(isset($shop_category['ChildCategory']) && is_array($shop_category))
                                                                            @foreach($shop_category['ChildCategory'] as $child_category_1)
                                                                                @if(isset($child_category_1['ChildCategory']) && is_array($child_category_1['ChildCategory']))
                                                                                    @foreach($child_category_1['ChildCategory'] as $child_category_2)
                                                                                        @if(isset($child_category_2['CategoryID']))
                                                                                            @if($result->store_id == $child_category_2['CategoryID'])
                                                                                                <option value="{{$child_category_2['CategoryID']}}/{{$child_category_2['Name']}}" selected>{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}</option>
                                                                                            @else
                                                                                                <option value="{{$child_category_2['CategoryID']}}/{{$child_category_2['Name']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}</option>
                                                                                            @endif
                                                                                        @endif
                                                                                    @endforeach
                                                                                @else
                                                                                    @if($result->store_id == $child_category_1['CategoryID'])
                                                                                        <option value="{{$child_category_1['CategoryID']}}/{{$child_category_1['Name']}}" selected>{{$shop_category['Name']}}>{{$child_category_1['Name']}}</option>
                                                                                    @else
                                                                                        <option value="{{$child_category_1['CategoryID']}}/{{$child_category_1['Name']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}</option>
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
                                                                @else
                                                                    <option value="{{$shop_categories['Store']['CustomCategories']['CustomCategory']['CategoryID']}}/{{$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']}}">{{$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']}}</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>


                                                </div>

                                            @endisset
                                        </div>


                                        <div class="form-group row ">
                                            <label for="Category" class="col-md-2 col-form-label required">Shop Category 2</label>
                                            @isset($shop_categories['Store']['CustomCategories']['CustomCategory'])
                                                <div class="col-md-10 wow pulse">



                                                    <div class="row d-flex justify-content-between">
                                                        <div class="col-md-4 mb-3">
                                                            <select name='store2_id' class="form-control">
                                                                @if(isset($shop_categories['Store']['CustomCategories']['CustomCategory'][0]) && is_array($shop_categories['Store']['CustomCategories']['CustomCategory']))
                                                                    @foreach($shop_categories['Store']['CustomCategories']['CustomCategory'] as $shop_category)
                                                                        @if(isset($shop_category['ChildCategory']) && is_array($shop_category))
                                                                            @foreach($shop_category['ChildCategory'] as $child_category_1)
                                                                                @if(isset($child_category_1['ChildCategory']) && is_array($child_category_1['ChildCategory']))
                                                                                    @foreach($child_category_1['ChildCategory'] as $child_category_2)
                                                                                        @if(isset($child_category_2['CategoryID']))
                                                                                            @if($result->store2_id == $child_category_2['CategoryID'])
                                                                                                <option value="{{$child_category_2['CategoryID']}}/{{$child_category_2['Name']}}" selected>{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}</option>
                                                                                            @else
                                                                                                <option value="{{$child_category_2['CategoryID']}}/{{$child_category_2['Name']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}</option>
                                                                                            @endif
                                                                                        @endif
                                                                                    @endforeach
                                                                                @else
                                                                                    @if($result->store2_id == $child_category_1['CategoryID'])
                                                                                        <option value="{{$child_category_1['CategoryID']}}/{{$child_category_1['Name']}}" selected>{{$shop_category['Name']}}>{{$child_category_1['Name']}}</option>
                                                                                    @else
                                                                                        <option value="{{$child_category_1['CategoryID']}}/{{$child_category_1['CategoryID']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}</option>
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
                                                                @else
                                                                    <option value="{{$shop_categories['Store']['CustomCategories']['CustomCategory']['CategoryID']}}/{{$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']}}">{{$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']}}</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>


                                                </div>

                                            @endisset
                                        </div>


                                        <div class="form-group row ">
                                            <label for="Category" class="col-md-2 col-form-label required">Condition</label>
                                            @if(isset($conditions['Category']['ConditionValues']['Condition']))
                                                <div class="col-md-10 wow pulse">


                                                    <div class="row d-flex justify-content-between">
                                                        @if(isset($conditions['Category']['ConditionValues']['Condition']))
                                                            <div class="col-md-4 mb-3">
                                                                <select name='condition_id' class="form-control" id="condition-select">
                                                                    @foreach($conditions['Category']['ConditionValues']['Condition'] as $condition)
                                                                        @if($condition['ID'] == $result->condition_id)
                                                                            <option value="{{$condition['ID']}}/{{$condition['DisplayName']}}" selected>{{$condition['DisplayName']}}/{{$condition['ID']}}</option>
                                                                        @else
                                                                            <option value="{{$condition['ID']}}/{{$condition['DisplayName']}}" >{{$condition['DisplayName']}}/{{$condition['ID']}}</option>
                                                                        @endif
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        @else
                                                            condition not available
                                                        @endif
                                                    </div>


                                                </div>

                                            @endisset
                                        </div>

                                        <!-- Condition Description -->
                                        <div class="form-group row" id="condition-description-sec">
                                            <div class="col-md-2 d-flex align-items-center">
                                                <div>
                                                    <label for="condition_description" class="col-form-label required">Condition Description</label>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <textarea rows="1" style="width: 100%;" class="form-control profile-data" name="condition_description">{{ $result->condition_description }}</textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label for="condition" class="col-md-2 col-form-label required">Use Picture</label>
                                        <div class="col-md-10 wow pulse">
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
                                                    <option value="" disabled selected>Select Options</option>
                                                    <option value="EPS">EPS</option>
                                                    <option value="Vendor">Shelf Hosted</option>

                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="condition" class="col-md-2 col-form-label required">Duration</label>
                                        <div class="col-md-10 wow pulse">
                                            <select class="form-control" name="duration">
                                                <option value="GTC">Good 'Til Cancelled</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="template_id" class="col-md-2 col-form-label required">Templates</label>
                                        <div class="col-md-10 wow pulse">
                                            <select class="form-control" name="template_id">
                                                @foreach($templates as $template)
                                                    @if($result->template_id == $template->id)
                                                        <option value="{{$template->id}}" selected>{{$template->template_name}}</option>
                                                    @else
                                                        <option value="{{$template->id}}">{{$template->template_name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>



{{--                                    <div class="form-group row">--}}
{{--                                        <label for="condition" class="col-md-2 col-form-label">PayPal Account</label>--}}
{{--                                        <div class="col-md-10 wow pulse">--}}
{{--                                            <select class="form-control" name="paypal">--}}
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

{{--                                    <div class="form-group row">--}}
{{--                                        <label for="start_price" class="col-md-2 col-form-label">Price in <strong>{{$result->currency}}</strong></label>--}}
{{--                                        <input type="hidden" name="currency" value="{{$result->currency}}">--}}
{{--                                        <div class="col-md-10 wow pulse">--}}
{{--                                            <input id="start_price" type="text" class="form-control @error('start_price') is-invalid @enderror" name="start_price" value="{{$result->start_price}}" maxlength="80" onkeyup="Count();" required autocomplete="start_price" autofocus>--}}
{{--                                            <span id="start_price" class="float-right"></span>--}}
{{--                                            @error('start_price')--}}
{{--                                            <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}

{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                    </div>--}}


                                    <div class="form-group row">
                                        <label for="return_id" class="col-md-2 col-form-label required">Return Policy</label>
                                        <div class="col-md-10 wow pulse">
                                            <select class="form-control" name="return_id">
                                                <option disabled selected>Select Return Policy</option>
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
                                        <label for="shipment_id" class="col-md-2 col-form-label required">Shipment Policy</label>
                                        <div class="col-md-10 wow pulse">
                                            <select class="form-control" name="shipping_id">
                                                <option disabled selected>Select Shipment Policy</option>
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
                                        <label for="payment_id" class="col-md-2 col-form-label required">Payment Policy</label>
                                        <div class="col-md-10 wow pulse">
                                            <select class="form-control" name="payment_id">
                                                <option disabled selected>Select Payment Policy</option>
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
                                        <label for="country" class="col-md-2 col-form-label required">Country</label>
                                        <div class="col-md-10 wow pulse">
                                            <select class="form-control" name="country">
                                                @foreach($countries as $country)
                                                    @if($country->country_code == $result->country)
                                                        <option value="{{$country->country_code}}" selected>{{$country->country_name}}</option>
                                                    @else
                                                        <option value="{{$country->country_code}}">{{$country->country_name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="location" class="col-md-2 col-form-label required">Location</label>
                                        <div class="col-md-10 wow pulse">
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
                                        <label for="post_code" class="col-md-2 col-form-label required">Post code</label>
                                        <div class="col-md-10 wow pulse">
                                            <input id="post_code" type="text" class="form-control @error('post_code') is-invalid @enderror" name="post_code" value="{{$result->post_code}}" maxlength="80" onkeyup="Count();" required autocomplete="post_code" autofocus>
                                            <span id="post_code" class="float-right"></span>
                                            @error('post_code')
                                            <span class="invalid-feedback" role="alert">
                                                 <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                </div>

                                {{--                                <div class="form-group row" id="all_category_div">--}}
                                {{--                                    <label for="Category" class="col-md-2 col-form-label required">Category</label>--}}
                                {{--                                    <div class="col-md-10 controls wow pulse" id="category-level-1-group">--}}
                                {{--                                        <select class="form-control category_select " name="child_cat[1]" id="child_cat_1" onchange="myFunction(1)">--}}
                                {{--                                            <option value="">Select Category</option>--}}
                                {{--                                            @foreach($categories['CategoryArray']['Category'] as $category)--}}
                                {{--                                                <option value="{{$category['CategoryID']}}">{{$category['CategoryName']}}</option>--}}
                                {{--                                            @endforeach--}}
                                {{--                                        </select>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                {{--                                <div class="form-group row">--}}
                                {{--                                    <div class="col-md-2">   </div>--}}
                                {{--                                    <div class="col-md-10">--}}
                                {{--                                        <button type="button" class="btn btn-primary m-t-10" id="list_button" style="display: none;">List</button>--}}
                                {{--                                        <input type="text" class="form-control" name="last_cat_id" id="last_cat_id" style="display: none;" value="">--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}

                                {{--                                <div id="add_variant_product"></div>--}}

                                {{--                                <div class="form-group row">--}}
                                {{--                                    <label for="condition" class="col-md-2 col-form-label required">Condition</label>--}}
                                {{--                                    <div class="col-md-10 wow pulse">--}}
                                {{--                                        <select class="form-control" name="condition">--}}
                                {{--                                            <option value="-1">-</option>--}}
                                {{--                                            <option value="1000">New with tags</option>--}}
                                {{--                                            <option value="1500">New without tags</option>--}}
                                {{--                                            <option value="1750">New with defects</option>--}}
                                {{--                                            <option value="3000">Pre-owned</option>--}}
                                {{--                                        </select>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                {{--                                <div class="form-group row">--}}
                                {{--                                    <label for="Category" class="col-md-2 col-form-label required">Store Categories</label>--}}
                                {{--                                    <div class="col-md-10 wow pulse">--}}
                                {{--                                        <select class="form-control">--}}
                                {{--                                            <option value="">Select store Categories</option>--}}
                                {{--                                            <option value="">SHSDJ</option>--}}
                                {{--                                            <option value="">SHSDJ</option>--}}
                                {{--                                            <option value="">SHSDJ</option>--}}
                                {{--                                        </select>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                {{--                                <div class="form-group row">--}}
                                {{--                                    <label for="description" class="col-md-2 col-form-label required">Description</label>--}}
                                {{--                                    <div class="col-md-10 wow pulse">--}}
                                {{--                                        <textarea class="" id="messageArea"  name="description" required autocomplete="description" autofocus>{{$result[0]->description}}</textarea>--}}
                                {{--                                        --}}{{--                                                                                <div class="summernote">--}}
                                {{--                                        --}}{{--                                                                                    <h3> </h3>--}}
                                {{--                                        --}}{{--                                                                                </div>--}}
                                {{--                                    </div>--}}
                                {{--                                    @error('description')--}}
                                {{--                                    <span class="invalid-feedback" role="alert">--}}
                                {{--                                        <strong>{{ $message }}</strong>--}}

                                {{--                                    @enderror--}}
                                {{--                                </div>--}}


                                {{--                                <div class="form-group row" id="accordion">--}}
                                {{--                                    <label for="short_description" class="col-md-2 col-form-label">--}}
                                {{--                                        <a class="collapsed" data-toggle="collapse" href="#collapseShortDescription">Short Description</a>--}}
                                {{--                                    </label>--}}
                                {{--                                    <div class="col-md-10 wow pulse collapse" id="collapseShortDescription" data-parent="#accordion">--}}
                                {{--                                        <textarea name="short_description" class="w-100 form-control" autocomplete="short_description" autofocus>{{ old('short_description') }}</textarea>--}}

                                {{--                                    </div>--}}
                                {{--                                    @error('short_description')--}}
                                {{--                                    <span class="invalid-feedback" role="alert">--}}
                                {{--                                        <strong>{{ $message }}</strong>--}}

                                {{--                                    @enderror--}}
                                {{--                                </div>--}}




                                {{--                                <div class="form-group row">--}}
                                {{--                                    <label for="ean" class="col-md-2 col-form-label ">Master product image</label>--}}

                                {{--                                    <div class="col-md-10 wow pulse">--}}
                                {{--                                        <div class="row master-pro-img">--}}
                                {{--                                            @foreach($result[0]['images'] as $images)--}}
                                {{--                                                <div class="col-lg-3 col-md-4 col-6">--}}
                                {{--                                                    <input type="hidden" id="image" name="image[]" value="{{$images->image_url}}">--}}
                                {{--                                                    <img class="img-fluid img-thumbnail mb-4" src="{{$images->image_url}}" alt="">--}}
                                {{--                                                </div>--}}
                                {{--                                            @endforeach--}}
                                {{--                                        </div>--}}
                                {{--                                        @error('ean')--}}
                                {{--                                        <span class="invalid-feedback" role="alert">--}}
                                {{--                                        <strong>{{ $message }}</strong>--}}

                                {{--                                        @enderror--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}



                                {{--                                <div class="form-group row">--}}
                                {{--                                    <label for="item-description" class="col-md-2 col-form-label required">Item Description</label>--}}
                                {{--                                    <div class="col-md-10 wow pulse">--}}
                                {{--                                        <ul class="nav nav-tabs">--}}
                                {{--                                            <li class="nav-item">--}}
                                {{--                                                <a class="nav-link active" data-toggle="tab" href="#menu1">Standard</a>--}}
                                {{--                                            </li>--}}
                                {{--                                            <li class="nav-item">--}}
                                {{--                                                <a class="nav-link" data-toggle="tab" href="#menu2">HTML</a>--}}
                                {{--                                            </li>--}}
                                {{--                                        </ul>--}}

                                {{--                                        <!-- Tab panes -->--}}
                                {{--                                        <div class="tab-content">--}}
                                {{--                                            <div class="tab-pane active" id="menu1">--}}
                                {{--                                                <textarea class="" id="messageArea1"  name="description" required autocomplete="description" autofocus>  </textarea>--}}
                                {{--                                            </div>--}}
                                {{--                                            <div class="tab-pane fade" id="menu2">--}}
                                {{--                                                <textarea class="" id="messageArea2"  name="description" required autocomplete="description" autofocus>  </textarea>--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}

                                {{--                                    </div>--}}
                                {{--                                </div>--}}




                                {{--                                <div class="form-group row">--}}
                                {{--                                    <label for="Category" class="col-md-2 col-form-label required">Select Image</label>--}}
                                {{--                                    <div class="col-md-10 wow pulse">--}}
                                {{--                                        <div class="fileupload btn btn-default waves-effect waves-light">--}}
                                {{--                                            <span><i class="ion-upload m-r-5"></i>Upload</span>--}}
                                {{--                                            <input type="file" id="imgInp" class="upload">--}}
                                {{--                                        </div>  <br>--}}
                                {{--                                        <img id="imageShow" class="img-thumbnail mt-3" src="#" alt="Images" width="150px" height="120px" style="display: none;">--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}




                                {{--                                <!-- variation start-->--}}

                                {{--                                @isset($result[0]['ProductVariations'])--}}
                                {{--                                    <div class="form-group row">--}}
                                {{--                                        <label for="variation" class="col-md-2 col-form-label required">Variation </label>--}}

                                {{--                                        <div class="col-md-10">--}}
                                {{--                                            <div class="row">--}}
                                {{--                                                @foreach($result[0]['ProductVariations'] as  $key => $product_variation)--}}
                                {{--                                                    <div class="col-md-6">--}}
                                {{--                                                        <div class="card p-3">--}}
                                {{--                                                            <div class="form-group">--}}
                                {{--                                                                <label for="sku" class="col-form-label ">sku</label>--}}
                                {{--                                                                <input type="text" data-parsley-maxlength="30" class="form-control @error('ean') is-invalid @enderror" name="productVariation[{{$key}}][sku]" value="{{$product_variation->sku}}" autocomplete="sku" autofocus--}}
                                {{--                                                                       id="sku" placeholder="">--}}

                                {{--                                                                @error('sku')--}}
                                {{--                                                                <span class="invalid-feedback" role="alert">--}}
                                {{--                                                    <strong>{{ $message }}</strong>--}}

                                {{--                                                                @enderror--}}
                                {{--                                                            </div>--}}
                                {{--                                                            @if($product_variation->attribute1 != null)--}}
                                {{--                                                                <div class="form-group">--}}
                                {{--                                                                    <label for="sku" class="col-form-label">Size</label>--}}
                                {{--                                                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('Size') is-invalid @enderror" name="productVariation[{{$key}}][Size]" value="{{$product_variation->attribute1}}" autocomplete="Size" autofocus--}}
                                {{--                                                                           id="Size" placeholder="">--}}

                                {{--                                                                    @error('Size')--}}
                                {{--                                                                    <span class="invalid-feedback" role="alert">--}}
                                {{--                                                        <strong>{{ $message }}</strong>--}}

                                {{--                                                                    @enderror--}}
                                {{--                                                                </div>--}}
                                {{--                                                            @endif--}}

                                {{--                                                            @if($product_variation->attribute2 != null)--}}
                                {{--                                                                <div class="form-group">--}}
                                {{--                                                                    <label for="Colour" class="col-form-label ">Colour</label>--}}
                                {{--                                                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('Colour') is-invalid @enderror" name="productVariation[{{$key}}][Colour]" value="{{$product_variation->attribute1}}" autocomplete="Colour" autofocus--}}
                                {{--                                                                           id="Colour" placeholder="">--}}

                                {{--                                                                    @error('Colour')--}}
                                {{--                                                                    <span class="invalid-feedback" role="alert">--}}
                                {{--                                                        <strong>{{ $message }}</strong>--}}

                                {{--                                                                    @enderror--}}
                                {{--                                                                </div>--}}
                                {{--                                                            @endif--}}

                                {{--                                                            @if($product_variation->attribute3 != null)--}}
                                {{--                                                                <div class="form-group">--}}
                                {{--                                                                    <label for="Style" class="col-form-label">Style</label>--}}
                                {{--                                                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('Style') is-invalid @enderror" name="productVariation[{{$key}}][Style]" value="{{$product_variation->attribute3}}" autocomplete="Style" autofocus--}}
                                {{--                                                                           id="Style" placeholder="">--}}

                                {{--                                                                    @error('Style')--}}
                                {{--                                                                    <span class="invalid-feedback" role="alert">--}}
                                {{--                                                        <strong>{{ $message }}</strong>--}}

                                {{--                                                                    @enderror--}}

                                {{--                                                                </div>--}}
                                {{--                                                            @endif--}}
                                {{--                                                            <div class="form-group">--}}
                                {{--                                                                <label for="start_price" class="col-md-2 col-form-label">Start Price</label>--}}
                                {{--                                                                <input type="text" data-parsley-maxlength="30" class="form-control @error('start_price') is-invalid @enderror" name="productVariation[{{$key}}][start_price]" value="{{$product_variation->sale_price}}" autocomplete="start_price" autofocus--}}
                                {{--                                                                       id="start_price" placeholder="">--}}
                                {{--                                                                @error('start_price')--}}
                                {{--                                                                <span class="invalid-feedback" role="alert">--}}
                                {{--                                                    <strong>{{ $message }}</strong>--}}

                                {{--                                                                @enderror--}}
                                {{--                                                            </div>--}}

                                {{--                                                            <div class="form-group">--}}
                                {{--                                                                <label for="ean" class="col-md-2 col-form-label">Enter EAN</label>--}}
                                {{--                                                                <input type="text" data-parsley-maxlength="30" class="form-control @error('ean') is-invalid @enderror" name="productVariation[{{$key}}][ean]" value="{{$product_variation->ean_no}}" autocomplete="ean" autofocus--}}
                                {{--                                                                       id="ean" placeholder="">--}}
                                {{--                                                                @error('ean')--}}
                                {{--                                                                <span class="invalid-feedback" role="alert">--}}
                                {{--                                                    <strong>{{ $message }}</strong>--}}

                                {{--                                                                @enderror--}}
                                {{--                                                            </div>--}}

                                {{--                                                            <div class="form-group">--}}
                                {{--                                                                <label for="quantity" class="col-form-label">Enter Quantity</label>--}}
                                {{--                                                                <input type="text" data-parsley-maxlength="30" class="form-control @error('quantity') is-invalid @enderror" name="productVariation[{{$key}}][quantity]" value="{{$product_variation->actual_quantity}}" autocomplete="quantity" autofocus--}}
                                {{--                                                                       id="quantity" placeholder="">--}}
                                {{--                                                                @error('quantity')--}}
                                {{--                                                                <span class="invalid-feedback" role="alert">--}}
                                {{--                                                    <strong>{{ $message }}</strong>--}}

                                {{--                                                                @enderror--}}
                                {{--                                                            </div>--}}
                                {{--                                                            <div class="form-group">--}}
                                {{--                                                                <label for="image" class="col-form-label">Image</label>--}}
                                {{--                                                                <input type="hidden" id="image" name="productVariation[{{$key}}][image]" value="{{$product_variation->image}}">--}}
                                {{--                                                                <img src="{{$product_variation->image}}" style="width: 150px; height: 120px; border: 1px solid #cccccc;">--}}
                                {{--                                                                @error('image')--}}
                                {{--                                                                <span class="invalid-feedback" role="alert">--}}
                                {{--                                                    <strong>{{ $message }}</strong>--}}

                                {{--                                                                @enderror--}}
                                {{--                                                            </div>--}}
                                {{--                                                        </div>--}}
                                {{--                                                    </div>--}}
                                {{--                                                @endforeach--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}

                                {{--                                    </div>--}}
                                {{--                                @endisset--}}

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
                                {{--                                                        <select class="form-control" name="terms[{{$attribute_term->id}}][]" multiple="multiple">--}}
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
                                <div class="form-group row ">
                                    <label for="Category" class="col-md-2 col-form-label required">
                                       Select Revise Option</label>
                                        <div class="col-md-10 wow pulse">
                                            <div class="row d-flex justify-content-between">
                                                <div class="col-md-4 mb-3">
                                                    <select name='revise_flag' class="form-control" required>
                                                        <option value="" selected>Revise Option</option>
                                                        <option value="1">Apply Revise</option>
                                                        <option value="">Don't Apply Revise</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary draft-pro-btn waves-effect waves-light">
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

    <script type="text/javascript">

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
                console.log('test')
                selectChangedFunc();
            });
        });

        // Select 2 drop down
        $('.select2').select2();

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
                        // $('#last_cat_id').show();
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
        function myFunction2(id,remove =0) {
            // console.log('found');

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
                    if(response.data == 1) {
                        console.log(response.content);
                        console.log(response.lavel);
                        if (remove == 'remove'){
                            $('#category2-level-' + 0 + '-group').nextAll().remove();
                        }else{
                            $('#category2-level-' + response.lavel + '-group').nextAll().remove();
                        }
                        $('#last_cat2_id').val('');
                        $('#last_cat2_id').hide();
                        $('#all_category_div2').append(response.content);

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
                        $('#Load').show();
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
                        $('#Load').hide();
                    }
                });
            }

        }




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
