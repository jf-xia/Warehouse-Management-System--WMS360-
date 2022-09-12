@extends('master')
@section('title')
    eBay | Add eBay Profile | WMS360
@endsection
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">
    <div class="content-page ebay">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="d-flex justify-content-center align-items-center">
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item">eBay</li>
                        <li class="breadcrumb-item active" aria-current="page">Create eBay Profile</li>
                    </ol>
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
                            <form role="form" target="_blank" class="vendor-form mobile-responsive" action= {{URL::to('ebay-profile')}} method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="condition" class="col-md-2 col-form-label required">eBay Account</label>
                                    <div class="col-md-10 wow pulse">
                                        <select id="account_id" class="form-control" name="account_id" onchange="getAccountSiteData()">
                                            <option value="{{$account_result->id}}">{{$account_result->account_name}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="condition" class="col-md-2 col-form-label required">eBay Site</label>
                                    <div class="col-md-10 wow pulse">
                                        <select id="site_id" class="form-control" name="site_id" onchange="getAccountSiteData()">
                                            <option value="{{$siteInfo->id}}">{{$siteInfo->name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="profile_name" class="col-md-2 col-form-label required">Profile Name</label>
                                    <div class="col-md-10 wow pulse">
                                        <input id="profile_name" type="text" class="form-control @error('profile_name') is-invalid @enderror" name="profile_name" value="" maxlength="80" onkeyup="Count();" required autocomplete="profile_name" autofocus>
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
                                        <textarea id="profile_description" type="text" class="form-control @error('profile_description') is-invalid @enderror" name="profile_description" value="" maxlength="80" onkeyup="Count();" autocomplete="profile_description" autofocus></textarea>
                                        <span id="display" class="float-right"></span>
                                        @error('profile_description')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row" id="all_category_div">
                                    <label for="Category" class="col-md-2 col-form-label required">Category</label>
                                    <div class="col-md-10 controls wow pulse" id="category-level-1-group">
                                        <select class="form-control category_select" name="child_cat[1]" id="child_cat_1" onchange="myFunction(1)">
                                            <option value="{{$categoryInfo->category_id}}/{{$categoryInfo->category_name}}">{{$categoryInfo->category_name}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row" id="all_category_div2">
                                    <label for="Category" class="col-md-2 col-form-label">Sub Category</label>
                                    <div class="" id="category2-level-0-group">

                                    </div>
                                    <div class="col-sm-1 ">
                                        <label class="fa fa-remove" onclick="myFunction2(1,'remove')"></label>
                                    </div>
                                    <div class="col-md-9 controls wow pulse" id="category2-level-1-group">
                                        <select class="form-control category2_select" name="child_cat2[1]" id="child_cat2_1" onchange="myFunction2(1)">
                                            <option value="">Select Category</option>
                                            @foreach($categories['CategoryArray']['Category'] as $category)
                                                <option value="{{$category['CategoryID']}}/{{$category['CategoryName']}}">{{$category['CategoryName']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-2">   </div>
                                    <div class="col-md-10">
                                        <button type="button" class="btn btn-primary m-t-10" id="list_button" style="display: none;">List</button>
                                        <input type="hidden" class="form-control" name="last_cat_id" id="last_cat_id" value="{{$categoryInfo->category_id}}">
                                        <input type="hidden" class="form-control" name="last_cat2_id" id="last_cat2_id" value="">
                                    </div>
                                </div>

                                <div class="form-group row ">
                                    <label for="Category" class="col-md-2 col-form-label required">Item Specifies</label>
                                    @isset($item_specifics['Recommendations']['NameRecommendation'])
                                        <div class="col-md-10 wow pulse">
                                            <div class="row d-flex justify-content-between">
                                                @foreach($item_specifics['Recommendations']['NameRecommendation'] as $index => $item_specific)
                                                    @php
                                                        $counter = 0;
                                                        if(isset($result[0]->attribute)){
                                                            foreach (\Opis\Closure\unserialize($result[0]->attribute) as $key => $attribute_array){
                                                                foreach ($attribute_array as $attribute => $terms_array){
                                                                    if($key == $item_specific['Name']){
                                                                        $counter++;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    @endphp

                                                    @if(isset($item_specific['Name']) && $counter==0)
                                                        <div class="col-md-4 mb-3">
                                                            <label style="font-weight: normal">{{$item_specific['Name']}}
                                                                @if($item_specific['ValidationRules']['UsageConstraint'] == 'Required')
                                                                    <strong>*</strong>
                                                                @endif
                                                            </label>
                                                            <input type="search" class="form-control" list="modelslist{{$index}}"  name="item_specific[{{$item_specific['Name']}}]">
                                                            @if(isset($item_specific['ValueRecommendation']))
                                                                <datalist id="modelslist{{$index}}">
                                                                    @foreach($item_specific['ValueRecommendation'] as $recommendation)
                                                                        @if(isset($recommendation['Value']))
                                                                            <option value="{{$recommendation['Value']}}">
                                                                        @endif
                                                                    @endforeach
                                                                </datalist>

                                                            @endif
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
                                @isset($shop_categories['Store']['CustomCategories']['CustomCategory'])
                                    <div class="form-group row ">
                                        <label for="Category" class="col-md-2 col-form-label required">Shop Category</label>
                                        <div class="col-md-10 wow pulse">
                                            <div class="row d-flex justify-content-between">
                                                <div class="col-md-4 mb-3">
                                                    <select name='store_id' class="form-control select2">
                                                        <option value=""> Select shop</option>
                                                        @if(isset($shop_categories['Store']['CustomCategories']['CustomCategory'][0]) && is_array($shop_categories['Store']['CustomCategories']['CustomCategory']))
                                                            @foreach($shop_categories['Store']['CustomCategories']['CustomCategory'] as $shop_category)
                                                                @if(isset($shop_category['ChildCategory']) && is_array($shop_category))
                                                                    @foreach($shop_category['ChildCategory'] as $child_category_1)
                                                                        @if(isset($child_category_1['ChildCategory']) && is_array($child_category_1['ChildCategory']))
                                                                            @foreach($child_category_1['ChildCategory'] as $child_category_2)
                                                                                @if(isset($child_category_2['CategoryID']))
                                                                                    <option value="{{$child_category_2['CategoryID']}}/{{$child_category_2['Name']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            <option value="{{$child_category_1['CategoryID']}}/{{$child_category_1['Name']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <option value="{{$shop_category['CategoryID']}}/{{$shop_category['Name']}}">{{$shop_category['Name']}}</option>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <option value="{{$shop_categories['Store']['CustomCategories']['CustomCategory']['CategoryID']}}/{{$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']}}">{{$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']}}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endisset

                                @isset($shop_categories['Store']['CustomCategories']['CustomCategory'])
                                    <div class="form-group row ">
                                        <label for="Category" class="col-md-2 col-form-label required">Shop Category 2</label>
                                        <div class="col-md-10 wow pulse">
                                            <div class="row d-flex justify-content-between">
                                                <div class="col-md-4 mb-3">
                                                    <select name='store2_id' class="form-control select2">
                                                        <option value=""> Select shop 2</option>
                                                        @if(isset($shop_categories['Store']['CustomCategories']['CustomCategory'][0]) && is_array($shop_categories['Store']['CustomCategories']['CustomCategory']))
                                                            @foreach($shop_categories['Store']['CustomCategories']['CustomCategory'] as $shop_category)
                                                                @if(isset($shop_category['ChildCategory']) && is_array($shop_category['ChildCategory']))
                                                                    @foreach($shop_category['ChildCategory'] as $child_category_1)
                                                                        @if(isset($child_category_1['ChildCategory']) && is_array($child_category_1['ChildCategory']))
                                                                            @foreach($child_category_1['ChildCategory'] as $child_category_2)
                                                                                @if(isset($child_category_2['CategoryID']))
                                                                                    <option value="{{$child_category_2['CategoryID']}}/{{$child_category_2['Name']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            <option value="{{$child_category_1['CategoryID']}}/{{$child_category_1['Name']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <option value="{{$shop_category['CategoryID']}}/{{$shop_category['Name']}}">{{$shop_category['Name']}}</option>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <option value="{{$shop_categories['Store']['CustomCategories']['CustomCategory']['CategoryID']}}/{{$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']}}">{{$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']}}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endisset

                                <div class="form-group row ">
                                    <label for="Category" class="col-md-2 col-form-label required">Condition</label>
                                    @isset($conditions['Category']['ConditionValues']['Condition'])
                                        <div class="col-md-10 wow pulse">
                                            <div class="row d-flex justify-content-between">
                                                @if(isset($conditions['Category']['ConditionValues']['Condition'][0]))
                                                    <div class="col-md-4 mb-3">
                                                        <select name='condition_id' class="form-control select2" required>
                                                            <option value="">Select Condition</option>
                                                            @foreach($conditions['Category']['ConditionValues']['Condition'] as $condition)
                                                                <option value="{{$condition['ID']}}/{{$condition['DisplayName']}}" @if($condition['ID'] == $categoryInfo->condition_id) selected @endif>{{$condition['DisplayName']}}/{{$condition['ID']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @elseif(!isset($conditions['Category']['ConditionValues']['Condition'][0]))
                                                    <div class="col-md-4 mb-3">
                                                        <select name='condition_id' class="form-control select2" required>
                                                            <option value="">Select Condition</option>

                                                            <option value="{{$conditions['Category']['ConditionValues']['Condition']['ID']}}/{{$conditions['Category']['ConditionValues']['Condition']['DisplayName']}}">{{$conditions['Category']['ConditionValues']['Condition']['DisplayName']}}</option>

                                                        </select>
                                                    </div>
                                                @else
                                                    condition not available
                                                @endif
                                            </div>
                                        </div>
                                    @endisset
                                </div>

                                <div class="form-group row">
                                    <label for="post_code" class="col-md-2 col-form-label ">Condition Description</label>
                                    <div class="col-md-10 wow pulse">
                                        <textarea class="col-10" name="condition_description"></textarea>
                                    </div>
                                </div>

                                <input type="hidden" name="currency" value="{{$currency[0]->currency}}">

                                <div class="form-group row">
                                    <label for="condition" class="col-md-2 col-form-label"></label>
                                    <div class="col-md-10 wow pulse">
                                        <input type="checkbox" name="galleryPlus" value="1"><strong>  Display a large photo in search results with Gallery Plus(fees may apply)</strong>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="condition" class="col-md-2 col-form-label required">Use Picture</label>
                                    <div class="col-md-10 wow pulse">
                                        <select class="form-control" name="eps" required>
                                            <option value="" disabled selected>Select Options</option>
                                            <option value="EPS">EPS</option>
                                            <option value="Vendor">Shelf Hosted</option>
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
                                            <option value="">Select Template</option>
                                            @foreach($templates as $template)
                                            <option value="{{$template->id}}">{{$template->template_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="return_id" class="col-md-2 col-form-label required">Return Policy</label>
                                    <div class="col-md-10 wow pulse">
                                        <select class="form-control" name="return_id">
                                                <option value="">Select Return Policy</option>
                                            @foreach($return_policies as $return_policy)
                                                <option value="{{$return_policy->return_id}}">{{$return_policy->return_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="shipment_id" class="col-md-2 col-form-label required">Shipment Policy</label>
                                    <div class="col-md-10 wow pulse">
                                        <select class="form-control" name="shipping_id">
                                            <option value="">Select Shipment Policy</option>
                                            @foreach($shipment_policies as $shipment_policy)
                                                <option value="{{$shipment_policy->shipment_id}}">{{$shipment_policy->shipment_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="payment_id" class="col-md-2 col-form-label required">Payment Policy</label>
                                    <div class="col-md-10 wow pulse">
                                        <select class="form-control" name="payment_id">
                                            <option value="">Select Payment Policy</option>
                                            @foreach($payment_policies as $payment_policy)
                                                <option value="{{$payment_policy->payment_id}}">{{$payment_policy->payment_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="country" class="col-md-2 col-form-label required">Country</label>
                                    <div class="col-md-10 wow pulse">
                                        <select class="form-control" name="country">
                                            <option value="">Select Country</option>
                                            @foreach($countries as $country)
                                            <option value="{{$country->country_code}}" @if($country->country_code == $account_result->country) selected @endif>{{$country->country_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="location" class="col-md-2 col-form-label required">Location</label>
                                    <div class="col-md-10 wow pulse">
                                        <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{$account_result->location ?? ''}}" maxlength="80" onkeyup="Count();" required autocomplete="location" autofocus>
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
                                        <input id="post_code" type="text" class="form-control @error('post_code') is-invalid @enderror" name="post_code" value="{{$account_result->post_code ?? ''}}" maxlength="80" onkeyup="Count();" required autocomplete="post_code" autofocus>
                                        <span id="post_code" class="float-right"></span>
                                        @error('post_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>


                                <div id="account_site_data">
                                </div>

                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button  type="submit" class="btn btn-primary draft-pro-btn waves-effect waves-light">
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

    <div id="Load" class="load" style="display: none;">
        <div class="load__container">
            <div class="load__animation"></div>
            <div class="load__mask"></div>
            <span class="load__title">Content is loading...</span>
        </div>
    </div>

    <!----- ckeditor summernote ------->
    <script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>

    <script>

        //Select 2 drop down
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

        function myFunction2(id,remove = 0) {
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
                        //document.getElementById('last_cat2_id').val(category_id)
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
