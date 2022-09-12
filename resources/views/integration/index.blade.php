@extends('master')
@section('title')
    Channel Integration
@endsection
@section('content')

<!-- <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Warehouse Management System">
    <link rel="shortcut icon" href="{{asset('assets/common-assets/wms.ico')}}">
    <meta name="author" content="Combosoft">
    <title>
        @yield('title', 'WMS360 | Admin Panel')
    </title> -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- JS cookies- -->
    <script src="{{asset('assets/js/js.cookie.js')}}"></script>
    <style>
        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .content{
            width: 100%;
            height: auto;
            padding: 30px;
        }

        .nav-pills{
            width: 90%;
        }
        .nav-item{
            width: 20%;
        }
        .nav-pills .nav-link{
            font-weight: bold;
            padding-top: 13px;
            text-align: center;
            /* background: #343436; */
            background: #343f44;
            color: #fff;
            border-radius: 30px;
            /* height: 100px; */
            height: 50px;
        }
        .nav-pills .nav-link.active{
            background: var(--wms-primary-color);
            /* background: #fff; */
            color: #ffffff;
            /* color: #000; */
        }
        .tab-content{
            width: 100%;
            height: auto;
            margin-top: -50px;
            background: #fff;
            color: #000;
            border-radius: 30px;
            z-index: 1000;
            box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.4);
        }
        .tab-content button{
            border-radius: 15px;
            width: 100px;
            margin: 0 auto;
        }
        .next{
            position: static;
        }
    </style>
    <style>
        * {
            margin: 0;
            padding: 0
        }

        html {
            height: 100%
        }

        p {
            color: grey
        }

        #heading {
            text-transform: uppercase;
            color: #673AB7;
            font-weight: normal
        }

        #msform {
            text-align: center;
            position: relative;
            margin-top: 30px
        }

        #msform fieldset {
            background: white;
            border: 0 none;
            border-radius: 0.5rem;
            box-sizing: border-box;
            width: 100%;
            margin: 0;
            padding-bottom: 20px;
            position: relative
        }

        .form-card {
            text-align: left
        }

        #msform fieldset:not(:first-of-type) {
            display: none
        }

        #msform input,
        #msform textarea {
            padding: 6px 15px 6px 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            margin-top: 2px;
            width: 100%;
            box-sizing: border-box;
            font-family: montserrat;
            color: #2C3E50;
            /* background-color: #ECEFF1; */
            font-size: 16px;
            letter-spacing: 1px
        }

        #msform input.select2-search__field{
            display: none;
        }

        #msform input:focus,
        #msform textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: 1px solid #673AB7;
            outline-width: 0
        }

        #msform .action-button {
            width: 100px;
            background: #673AB7;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 0px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 0px 10px 5px;
            float: right
        }

        #msform .action-button:hover,
        #msform .action-button:focus {
            background-color: #311B92
        }

        #msform .action-button-previous {
            width: 100px;
            background: #616161;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 0px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px 10px 0px;
            float: right
        }

        #msform .action-button-previous:hover,
        #msform .action-button-previous:focus {
            background-color: #000000
        }

        .card {
            z-index: 0;
            border: none;
            position: relative
        }

        .fs-title {
            font-size: 25px;
            color: #673AB7;
            margin-bottom: 15px;
            font-weight: normal;
            text-align: left
        }

        .purple-text {
            color: #673AB7;
            font-weight: normal
        }

        .steps {
            font-size: 25px;
            color: gray;
            margin-bottom: 10px;
            font-weight: normal;
            text-align: right
        }

        .fieldlabels {
            color: gray;
            text-align: left
        }

        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            color: lightgrey
        }

        #progressbar .active {
            color: #673AB7
        }

        #progressbar li {
            list-style-type: none;
            font-size: 15px;
            width: 25%;
            float: left;
            position: relative;
            font-weight: 400
        }

        #progressbar #account:before {
            font-family: FontAwesome;
            content: "\f234"
        }

        #progressbar #personal:before {
            font-family: FontAwesome;
            content: "\f1de"
        }

        #progressbar #payment:before {
            font-family: FontAwesome;
            content: "\f021"
        }

        #progressbar #confirm:before {
            font-family: FontAwesome;
            content: "\f00c"
        }

        #progressbar li:before {
            width: 50px;
            height: 50px;
            line-height: 45px;
            display: block;
            font-size: 20px;
            color: #ffffff;
            background: lightgray;
            border-radius: 50%;
            margin: 0 auto 10px auto;
            padding: 2px
        }
        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: lightgray;
            position: absolute;
            left: 0;
            top: 25px;
            z-index: -1
        }

        #progressbar li.active:before,
        #progressbar li.active:after {
            background: #673AB7
        }

        .progress {
            height: 30px;
        }

        .progress-bar {
            background-color: #673AB7
        }

        .fit-image {
            width: 100%;
            object-fit: cover
        }
        .footer {
            position: relative !important
        }
        .ebay-sites-select {
            position: relative;
        }
        .ebay-sites-placeholder{
            position: absolute;
            margin-top: -32px;
            margin-left: 15px;
            color: #2c3e50d6;
        }
    </style>
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <!-- Nav pills -->
            <div class="d-flex justify-content-center">
                <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#eBay">eBay</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#woocommerce">WooCommerce</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#onBuy">OnBuy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#shopify">Shopify</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#amazon">Amazon</a>
                    </li>
                </ul>
            </div>
            <!-- Tab panes -->
            <div class="tab-content">
                <div id="eBay" class="container tab-pane active">
                    <div class="container-fluid integration-tab-content-inner">
                        {{-- <div class="row justify-content-center"> --}}
                            {{-- <div class="col-12 col-sm-10"> --}}
                                <div class="px-0 pt-4 pb-0 mt-3 mb-3">
                                    <h5 id="heading" class="text-center mt-5">Eassy!! 3 Step Migration</h5>
                                    <form id="msform">
                                        <!-- progressbar -->
                                        <ul id="progressbar">
                                            <li class="active" id="account"><strong>Add Ebay Account</strong></li>
                                            <li id="personal"><strong>Set Default Profile</strong></li>
                                            <li id="payment"><strong>Product Migration</strong></li>
                                            <li id="confirm"><strong>Finish</strong></li>
                                        </ul>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div> <br> <!-- fieldsets -->
                                        <fieldset>
                                            <div class="form-card">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h4 class="fs-title">Account Information:</h4>
                                                    </div>
                                                    <div class="col-5">
                                                        <h2 class="steps">Step 1 - 4</h2>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="fieldlabels">eBay Username: *</label> <input id="ebayName" class="form-controll" type="text" name="account_name" placeholder="User Name" />
                                                        <label id="ebayNamer" style="display:none;color: red">eBay Username is required</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="fieldlabels">Feeder Quantity: *</label> <input id="feederQuantity" type="number" name="feeder_quantity" value="3" placeholder="Feeder Quantity" />
                                                        <label id="feederQuantityr" style="display:none;color: red">Feeder Quantity is required</label>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-6 ebaySites">
                                                        <label class="fieldlabels">eBay Sites *</label>
                                                        <span id="clickSec" onfocusin="ebaySitesPlaceholderIn()" onfocusout="ebaySitesPlaceholderOut()">
                                                            <select id="site_id" class="form-control ebay-sites-select select2 @error('site') is-invalid @enderror" multiple name="site_id[]" required >
                                                                @foreach($sites as $site)
                                                                    <option value="{{$site->id}}">{{$site->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </span>
                                                        <div class="ebay-sites-placeholder" onclick="selectSites()">Select eBay Sites</div>
                                                        <label id="site_idr" style="display:none;color: red">eBay Sites is required</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="fieldlabels">Item Location: *</label> <input id="location" type="text" name="location" placeholder="Location" />
                                                        <label id="locationr" style="display:none;color: red">Item Location is required</label>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="fieldlabels">Country: *</label> <select id="country" class="form-control" name="country" required>
                                                            <option value="">Select Country</option>
                                                            @foreach($countries as $country)
                                                                <option value="{{$country->country_code}}">{{$country->country_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <label id="countryr" style="display:none;color: red">Country is required</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="fieldlabels">Postcode: *</label> <input id="postcode" type="text" name="post_code" placeholder="Postcode" />
                                                        <label id="postcoder" style="display:none;color: red">Postcode is required</label>
                                                    </div>
                                                </div>


                                                {{--                                        <label class="fieldlabels">Developer Account: *</label> --}}
                                                <select id="developer_id" style="display: none;" class="form-control @error('developer_id') is-invalid @enderror"  name="developer_id" value="{{ old('developer_id') }}" required autocomplete="developer_id" autofocus>
                                                    @foreach($developer_accounts as $developer_account)
                                                        <option value="{{$developer_account->id}}">{{$developer_account->client_id}}</option>
                                                    @endforeach
                                                </select>
                                            </div> <button id="step1" type="button" name="next" class="next action-button" value="Next" >Next</button>

                                        </fieldset>
                                        <fieldset>
                                            <div class="form-card">
                                                <div class="row">
                                                    <div class="col-7">
                                                    </div>
                                                    <div class="col-5">
                                                        <h2 class="steps">Step 2 - 4</h2>
                                                    </div>
                                                </div>
                                                <div id="syncing_message" class="d-flex justify-content-center align-items-center">
                                                    <p class="text-red font-18">Please do not close or reload this browser!!</p>
                                                </div>
                                                <div id="step-2-loader" class="row mb-4">
                                                    <div class="col-1">

                                                    </div>
                                                    <div  class="col-10">
                                                        <h7 class="text-center">Syncing Account</h7>
                                                        <div class="progress">
                                                            <div id="pBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%;background-color: #5cb85c">
                                                                0%
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-1">

                                                    </div>
                                                </div>
                                                <div id="step-2-form" class="row mb-4">
                                                    <div class="col-4">
                                                        <label class="fieldlabels">Default Return Policy: *</label> <select id="return-policy" class="form-control" name="return_policy" required>
                                                            <option value="">Select Default Return Policy</option>
                                                        </select>
                                                        <label id="return-policyr" style="display:none;color: red">Return Policy is required</label>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="fieldlabels">Default Shipment Policy: *</label> <select id="shipment-policy" class="form-control" name="shipment_policy" required>
                                                            <option value="">Select Default Shipment Policy</option>
                                                        </select>
                                                        <label id="shipment-policyr" style="display:none;color: red">Shipment Policy is required</label>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="fieldlabels">Default Payment Policy: *</label> <select id="payment-policy" class="form-control" name="payment_policy" required>
                                                            <option value="">Select Default Payment Policy</option>
                                                        </select>
                                                        <label id="payment-policyr" style="display:none;color: red">Payment Policy is required</label>
                                                    </div>
                                                </div>
                                                {{-- <div class="row dash-height">

                                                </div> --}}

                                            </div> <input id="step2n" type="button" name="next" class="next mb-4 action-button" value="Next" />
                                        </fieldset>
                                        <fieldset>
                                            <div class="form-card">
                                                <div id="step-3-loader" class="row">
                                                    <div class="col-5">

                                                    </div>
                                                    <div  class="col-5">
                                                        <h8 class="text-center">Preparing For Migration</h8>
                                                        <div class="loader"></div>

                                                    </div>
                                                    <div class="col-1">

                                                    </div>
                                                </div>
                                                <div id="step-3-product-loader" class="row">
                                                    <div class="col-3">
                                                    </div>
                                                    <div  class="col-7">
                                                        <h7 class="text-center">Migrating Products</h7>
                                                        <div class="progress">
                                                            <div id="pBarGreen3" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:40%;background-color: #5cb85c">
                                                                Done
                                                            </div>
                                                            <div id="pBarYellow3" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:10%; background-color: #f0ad4e;">
                                                                Remains
                                                            </div>
                                                            <div id="pBarRed3" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:20%;background-color: #d9534f">
                                                                Failed
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-1">

                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <div class="form-card">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="fs-title">Finish:</h2>
                                                    </div>
                                                    <div class="col-5">
                                                        <h2 class="steps">Step 4 - 4</h2>
                                                    </div>
                                                </div> <br><br>
                                                <h2 class="purple-text text-center"><strong>SUCCESS ! <br> <a href="{{URL::to('dashboard')}}">Dashboard</a></strong></h2> <br>
                                                <div class="row justify-content-center">
                                                    <div class="col-3"> <img src="https://i.imgur.com/GwStPmg.png" class="fit-image"> </div>
                                                </div> <br><br>
                                                <div class="row justify-content-center">
                                                    <div class="col-7 text-center">

                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            {{-- </div> --}}
                        {{-- </div> --}}
                    </div>

                </div>
                <div id="woocommerce" class="container tab-pane">
                    <div class="container-fluid integration-tab-content-inner">
                        {{-- <div class="row justify-content-center"> --}}
                            {{-- <div class="col-12 col-sm-10"> --}}
                                <div class="px-0 pt-4 pb-0 mt-3 mb-3">
                                    <h5 id="heading" class="text-center mt-5">Woocommerce Integration</h5>
                                    <form id="woocommerceForm" class="p-5" method="post" action="javascript:void(0)">
                                        <div class="form-group">
                                            <label for="consumer_key" class="required">Consumer Key</label>
                                            <input type="text" class="form-control" id="consumer_key" name="consumer_key" placeholder="Enter Woocomerce Consumer Key" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="secret_key" class="required">Secret Key</label>
                                            <input type="text" class="form-control" id="secret_key" name="secret_key" placeholder="Enter Woocomerce Secret Key" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="account_name" class="required">Account Name</label>
                                            <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Enter Woocomerce Account Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="site_url" class="required">Website URL</label>
                                            <input type="text" class="form-control" id="site_url" name="site_url" placeholder="Enter Woocomerce Website URL" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="status" class="required">Status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="1" selected>Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                        <input type="hidden" name="request_type" value="ajax_integration">
                                        <button type="submit" id="send_woocommerce_form" class="btn btn-primary btn-sm send_form_info" data-url="woocommerce/create-account">Submit</button>
                                    </form>
                                </div>
                            {{-- </div> --}}
                        {{-- </div> --}}
                    </div>
                </div>
                <div id="onBuy" class="container tab-pane">
                    <div class="container-fluid">
                        {{-- <div class="row justify-content-center"> --}}
                            {{-- <div class="col-12 col-sm-10"> --}}
                                <div class="px-0 pt-4 pb-0 mt-3 mb-3">
                                    <h5 id="heading" class="text-center mt-5">onBuy Integration</h5>
                                    <form id="onbuyForm" class="p-5" method="post" action="javascript:void(0)">
                                        <div class="form-group">
                                            <label for="consumer_key" class="required">Consumer Key</label>
                                            <input type="text" class="form-control" id="consumer_key" name="consumer_key" placeholder="Enter Onbuy Consumer Key" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="secret_key" class="required">Secret Key</label>
                                            <input type="text" class="form-control" id="secret_key" name="secret_key" placeholder="Enter Onbuy Secret Key" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="account_name" class="required">Account Name</label>
                                            <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Enter Onbuy Account Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="status" class="required">Status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="1" selected>Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                        <input type="hidden" name="request_type" value="ajax_integration">
                                        <button type="submit" id="send_onbuy_form" class="btn btn-primary btn-sm send_form_info" data-url="onbuy/create-account">Submit</button>
                                    </form>
                                </div>
                            {{-- </div> --}}
                        {{-- </div> --}}
                    </div>
                </div>
                <div id="shopify" class="container tab-pane">
                    <div class="container-fluid">
                        {{-- <div class="row justify-content-center"> --}}
                            {{-- <div class="col-12 col-sm-10"> --}}
                                <div class="px-0 pt-4 pb-0 mt-3 mb-3">
                                    <h5 id="heading" class="text-center mt-5">Shopify Integration</h5>
                                    <form id="shopifyForm" class="p-5" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="account_name" class="required">Account Name</label>
                                            <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Enter Shopify Account Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="shop_url" class="required">Shop Url</label>
                                            <input type="text" class="form-control" id="shop_url" name="shop_url" placeholder="Enter Shop Url" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="api_key" class="required">Api Key</label>
                                            <input type="text" class="form-control" id="api_key" name="api_key" placeholder="Enter API Key" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="required">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="account_status" class="required">Status</label>
                                            <select class="form-control" id="account_status" name="account_status" required>
                                                <option value="1" selected>Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="account_logo">Account Logo</label>
                                            <input type="file" class="form-control" id="account_logo" name="account_logo">
                                            <span class="uploadedLogo"></span>
                                        </div>
                                        <input type="hidden" name="request_type" value="ajax_integration">
                                        <button type="submit" id="send_shopify_form" class="btn btn-primary btn-sm">Submit</button>
                                    </form>
                                </div>
                            {{-- </div> --}}
                        {{-- </div> --}}
                    </div>
                </div>
                <div id="amazon" class="container tab-pane">
                    <div class="container-fluid">
                        {{-- <div class="row justify-content-center"> --}}
                            {{-- <div class="col-12 col-sm-10"> --}}
                                <div class="px-0 pt-4 pb-0 mt-3 mb-3">
                                    <h5 id="heading" class="text-center mt-5">Amazon Integration</h5>
                                    <div class="mb-2">
                                        <form id="amazonAccountForm" class="px-5" method="post" enctype="multipart/form-data">
                                            <h5>Add Account</h5><span class="text-primary"><small>(First Add Account If not Exist And Then Add Application Under Existing Account. Add Both Account Seperately)</small></span>
                                            <div class="form-row">
                                                <div class="col-md-4">
                                                    <label for="amazon_account_name" class="required">Account Name</label>
                                                    <input type="text" class="form-control" id="amazon_account_name" name="amazon_account_name" placeholder="Enter Amazon Account Name">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="amazon_account_status" class="required">Status</label>
                                                    <select class="form-control" id="amazon_account_status" name="amazon_account_status">
                                                        <option value="1" selected>Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="amazon_account_logo">Account Logo</label>
                                                    <input type="file" class="form-control" id="amazon_account_logo" name="amazon_account_logo">
                                                    <span class="uploadedLogo"></span>
                                                </div>
                                            </div>
                                            <input type="hidden" name="amazon_account_logo" value="null">
                                            <input type="hidden" name="request_type" value="ajax_integration">
                                            <button type="submit" id="send_amazon_account_form" class="btn btn-primary btn-sm" data-url="amazon/save-account">Submit</button>
                                        </form>
                                    </div>
                                    <hr>
                                    <div class="mb-2">
                                        <form id="amazonAccountApplicationForm" class="px-5 pb-5" method="post" enctype="multipart/form-data">
                                            <h5>Add Account Application</h5>
                                            <div class="form-row mb-3">
                                                <div class="col-md-4">
                                                    <label for="amazon_account_id" class="required">Amazon Account</label>
                                                    <select class="form-control" name="amazon_account_id" id="amazon_account_id" required>
                                                        @if(isset($allAccounts) && (count($allAccounts) > 1))
                                                            <option value="">Select Account</option>
                                                            @foreach($allAccounts as $account)
                                                                <option value="{{$account->id ?? ''}}">{{$account->account_name ?? ''}}</option>
                                                            @endforeach
                                                        @else
                                                            @foreach($allAccounts as $account)
                                                                <option value="{{$account->id ?? ''}}" selected>{{$account->account_name ?? ''}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="application_name" class="required">Application Name</label>
                                                    <input type="text" name="application_name" class="form-control" id="application_name" placeholder="Enter Application Name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="application_id" class="required">Application ID</label>
                                                    <input type="text" name="application_id" class="form-control" id="application_id" placeholder="Enter Application Id" required>
                                                </div>
                                            </div>
                                            <div class="form-row mb-3">
                                                <div class="col-md-4">
                                                    <label for="iam_arn" class="required">IAM ARN</label>
                                                    <input type="text" name="iam_arn" class="form-control" id="iam_arn" placeholder="Enter IAM ARN" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="lwa_client_id" class="required">LWA Client Id</label>
                                                    <input type="text" name="lwa_client_id" class="form-control" id="lwa_client_id" placeholder="Enter LWA Client Id" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="lwa_client_secret" class="required">LWA Client Secret</label>
                                                    <input type="text" name="lwa_client_secret" class="form-control" id="lwa_client_secret" placeholder="Enter LWA Client Secret" required>
                                                </div>
                                            </div>
                                            <div class="form-row mb-3">
                                                <div class="col-md-4">
                                                    <label for="aws_access_key_id" class="required">AWS Access Key Id</label>
                                                    <input type="text" name="aws_access_key_id" class="form-control" id="aws_access_key_id" placeholder="Enter AWS Access Key Id" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="aws_secret_access_key" class="required">AWS Secret Access Key</label>
                                                    <input type="text" name="aws_secret_access_key" class="form-control" id="aws_secret_access_key" placeholder="Enter AWS Secret Access Key" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="amazon_marketplace_fk_id" class="required">Amazon Market Place</label>
                                                    <select class="form-control" name="amazon_marketplace_fk_id" id="amazon_marketplace_fk_id" required>
                                                        @if(isset($allMarketPlaces) && (count($allMarketPlaces) > 1))
                                                            <option value="">Select Market Place</option>
                                                            @foreach($allMarketPlaces as $marketplace)
                                                                <option value="{{$marketplace->id ?? ''}}">{{$marketplace->marketplace ?? ''}}</option>
                                                            @endforeach
                                                        @else
                                                            @foreach($allMarketPlaces as $marketplace)
                                                                <option value="{{$marketplace->id ?? ''}}" selected>{{$marketplace->marketplace ?? ''}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row mb-3">
                                                <div class="col-md-4">
                                                    <label for="oauth_login_url">Amazon OAuth Login Url</label>
                                                    <input type="text" name="oauth_login_url" class="form-control" id="oauth_login_url" placeholder="Enter OAuth Login Url" >
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="oauth_redirect_url" class="required">Amazon OAuth Redirect Url</label>
                                                    <input type="text" name="oauth_redirect_url" class="form-control" id="oauth_redirect_url" placeholder="Enter OAuth Redirect Url" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="application_status" class="required">Application Status</label>
                                                    <select class="form-control" name="application_status" id="application_status" required>
                                                        <option value="">Application Status</option>
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row mb-2">
                                                <div class="col-md-4">
                                                    <label for="application_logo">Application Logo</label>
                                                    <input type="file" name="application_logo" class="form-control" id="application_logo" onchange="previewImage()">
                                                    <span class="d-none application-logo-show-span"><img src="" alt="" width="60" height="60"></span>
                                                </div>
                                            </div>
                                            <input type="hidden" name="request_type" value="ajax_integration">
                                            <button type="submit" id="send_amazon_account_application_form" class="btn btn-primary btn-sm" data-url="amazon/save-application">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            {{-- </div> --}}
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){

        // $('.ebaySites .select2').select2({
        //     placeholder: {
        //         text: 'Select eBay Sites'
        //     }
        // })

        $('.send_form_info').click(function(e){
        e.preventDefault();
        /*Ajax Request Header setup*/
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            }
        });
        var url = $(this).attr('data-url')
        var formId = $(this).closest('form').attr('id')
        /* Submit form data using ajax*/
            $.ajax({
                url: "{{ url('/')}}"+"/"+url,
                method: 'post',
                data: $('#'+formId).serialize(),
                success: function(response){
                    console.log(response)
                if(response.type == 'success'){
                    Swal.fire('Success',response.msg,'success')
                    $("#"+formId)[0].reset();
                }else{
                    Swal.fire('Oops!',response.msg,'error')
                }
            }});
        });

        $('#amazonAccountForm').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                }
            });
            $.ajax({
                url: "{{ url('amazon/save-account')}}",
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(response){
                    console.log(response)
                if(response.type == 'success'){
                    Swal.fire('Success',response.msg,'success')
                    $("#amazonAccountForm")[0].reset();
                }else{
                    Swal.fire('Oops!',response.msg,'error')
                }
            }});
        })
        $('#amazonAccountApplicationForm').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                }
            });
            $.ajax({
                url: "{{ url('amazon/save-application')}}",
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(response){
                    console.log(response)
                if(response.type == 'success'){
                    Swal.fire('Success',response.msg,'success')
                    $("#amazonAccountApplicationForm")[0].reset();
                }else{
                    Swal.fire('Oops!',response.msg,'error')
                }
            }});
        })
        $('#shopifyForm').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                }
            });
            $.ajax({
                url: "{{ url('shopify-create-account')}}",
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(response){
                    console.log(response)
                if(response.type == 'success'){
                    Swal.fire('Success',response.msg,'success')
                    $("#shopifyForm")[0].reset();
                }else{
                    Swal.fire('Oops!',response.msg,'error')
                }
            }});
        })

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;
        var current = 1;
        var steps = $("fieldset").length;
        var stp = {{$step}}
        var account_id = getCookie('account_id')
        var stepTwoEmptyField = false;
        // console.log(current)
        if (stp == 2){
            jQuery(function(){ jQuery("#step1").trigger('click'); });
            getMigration(account_id)
        }
        setProgressBar(current);
        $("#step-2-form").hide();
        $("#step-3-product-loader").hide();

        $(".next").click(function(){
            console.log(current)
            if(current == 1 && stp != 2){
                var emptyField = false;
                if ($('#ebayName').val().length === 0){
                    showRequired("ebayName")
                    emptyField = true;
                }else {
                    emptyRequired("ebayName")
                }
                if ($('#feederQuantity').val().length === 0){
                    showRequired("feederQuantity")
                    emptyField = true;
                }else {
                    emptyRequired("feederQuantity")
                }
                if ($('#site_id').val().length === 0){
                    showRequired("site_id")
                    emptyField = true;
                }else {
                    emptyRequired("site_id")
                }
                if ($('#location').val().length === 0){
                    showRequired("location")
                    emptyField = true;
                }else {
                    emptyRequired("location")
                }
                if ($('#country').val().length === 0){
                    showRequired("country")
                    emptyField = true;
                }else {
                    emptyRequired("country")
                }
                if ($('#postcode').val().length === 0){
                    showRequired("postcode")
                    emptyField = true;
                }else {
                    emptyRequired("postcode")
                }
                if (current == 1 && !emptyField){
                    $("#step1").append("<i class=\"fa fa-circle-o-notch fa-spin\" aria-hidden=\"true\"></i>")
                    $("#step1").prop("disabled",true)
                    var ebayName = $('#ebayName').val();
                    var feeder_quantity = $('#feederQuantity').val();
                    var site_id = $('#site_id').val();
                    var location = $('#location').val();
                    var country = $('#country').val();
                    var postcode = $('#postcode').val();
                    var developer_id = $('#developer_id').val();
                    // var logo = $('#logo').prop('files');

                    $.ajax({
                        type:'post',
                        url:"{{URL::to('ebay-create-account/new')}}",
                        data:{
                            _token: "{{csrf_token()}}",
                            account_name : ebayName,
                            feeder_quantity:feeder_quantity,
                            site_id:site_id,
                            country:country,
                            location:location,
                            developer_id:developer_id,
                            post_code:postcode
                            // logo: logo
                        },
                        beforeSend: function(){

                        },
                        success: function (response) {
                            let url = window.location.href;

                            const url_array = url.split("channel-integration/1");
                            Cookies.set('url', url_array[0]);
                            Cookies.set('type','new')
                            Cookies.set('account_id',response.account_id)

                            console.log(response)
                            window.location.href = response.sign_in_link;

                        }
                    })
                }else{

                }
                // console.log(ebayName,feeder_quantity,site_id,location,country,postcode,developer_id)
                return false
            }
            else if(stp == 2 && current == 2){

                var return_policy= $("#return-policy option:selected").val()
                var shipment_policy = $("#shipment-policy option:selected").val()
                var payment_policy = $("#payment-policy option:selected").val()
                console.log(account_id)

                if ($("#return-policy option:selected").val() == ""){
                    console.log('empty')
                    showRequired("return-policy")
                    stepTwoEmptyField = true;
                }else{
                    console.log('else')
                    emptyRequired("return-policy")
                    stepTwoEmptyField = false;
                }
                if ($("#return-policy option:selected").val() == ""){
                    showRequired("shipment-policy")
                    stepTwoEmptyField = true;
                }else{
                    emptyRequired("shipment-policy")
                    stepTwoEmptyField = false;
                }
                if ($("#return-policy option:selected").val() == ""){
                    showRequired("payment-policy")
                    stepTwoEmptyField = true;
                }else {
                    emptyRequired("payment-policy")
                    stepTwoEmptyField = false;
                }
                if (stepTwoEmptyField){
                    return false
                }


                $.ajax({
                    type:"post",
                    url:"{{URL::to("set-default-policy")}}",
                    data:{
                        _token:"{{csrf_token()}}",
                        return_policy:return_policy,
                        shipment_policy:shipment_policy,
                        payment_policy:payment_policy,
                        account_id: account_id
                    },
                    success:function (response) {

                        if (!stepTwoEmptyField){
                            $.ajax({
                                type: "get",
                                url: "{{URL::to("auto-create-profile")}}"+"/"+account_id,
                                data: {
                                    account_id: account_id
                                },
                                success: function (response) {
                                    startMigration(account_id)
                                    $('#step-3-loader').hide()
                                    $('#step-3-product-loader').show()
                                }
                            })
                        }


                    }
                })
            }

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();
            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

//show the next fieldset
            next_fs.show();
//hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now) {
// for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({'opacity': opacity});
                },
                duration: 500
            });
            setProgressBar(++current);



        });

        $(".previous").click(function(){

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

//Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

//show the previous fieldset
            previous_fs.show();

//hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now) {
// for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({'opacity': opacity});
                },
                duration: 500
            });
            setProgressBar(--current);
        });
        function startMigration(account_id){
            $.ajax({
                type:"get",
                url:"{{URL::to('ebay-migration-started-integration')}}"+"/"+account_id,
                success: function (response) {

                    var totalItem = parseInt(response.done)+parseInt(response.remains)+parseInt(response.failed)
                    console.log("done")
                    console.log((100*parseInt(response.done)/totalItem).toFixed())
                    console.log("remains")
                    console.log((100*parseInt(response.remains)/totalItem).toFixed())
                    console.log("failed")
                    console.log((100*parseInt(response.failed)/totalItem).toFixed())


                    $("#pBarGreen3").css("width",(100*(parseInt(response.done))/totalItem).toFixed()+"%");
                    $("#pBarGreen3").text("Done "+(response.done).toFixed());

                    $("#pBarYellow3").css("width",(100*(parseInt(response.remains))/totalItem).toFixed()+"%");
                    $("#pBarYellow3").text("Remains "+(response.remains).toFixed());

                    $("#pBarRed3").css("width",(100*(parseInt(response.failed))/totalItem).toFixed()+"%");
                    $("#pBarRed3").text("Failed "+(response.failed).toFixed());

                    console.log(response.done)
                    if ((parseInt(response.done)+parseInt(response.failed)) == totalItem){
                        jQuery(function(){ jQuery("#step3").trigger('click'); });
                    }else{
                        startMigration(account_id);
                    }
                    //
                }
            })
        }
        function setProgressBar(curStep){
            var percent = parseFloat(100 / steps) * curStep;
            percent = percent.toFixed();
            $(".progress-bar")
                .css("width",percent+"%")
            $("#pBar").css("width","5%")
        }

        function getMigration(accountId){
            // console.log(accountId)
            $("#step2n").hide()

            $.ajax({
                type: "get",
                url: "{{url('ebay-sync-account')}}"+'/'+accountId+'/'+'new',
                beforeSend: function (){
                    // $("#"+"a"+accountId).removeClass("fas fa-sync");
                    // $("#"+"a"+accountId).addClass("fa fa-circle-o-notch fa-spin");
                    // document.getElementById("a"+accountId).classList.replace("fa fa-circle-o-notch fa-spin")
                    // $('#Load').show();
                },
                success: function (response) {
                    // console.log(response)
                    // $("#"+"a"+accountId).removeClass("fa fa-circle-o-notch fa-spin");
                    // $("#"+"a"+accountId).addClass("fas fa-sync");
                    // $('#Load').hide();
                    console.log('test')
                    // console.log(response.pageNumber)
                    // console.log(response.totalItem)
                    getItemToMigrationList(accountId,response.pageNumber,response.totalItem,0);

                },
                complete: function (data) {
                    // $("#"+"a"+accountId).removeClass("fa fa-circle-o-notch fa-spin");
                    // $("#"+"a"+accountId).addClass("fas fa-sync");
                    // $('#Load').hide();
                }
            });
        }

        function showPolicy(accountId){
            var return_policy =""
            var payment_policy =""
            var shipment_policy =""
            $('#step-2-loader').hide()
            $.ajax({
                type:"get",
                url: "{{url('get-policy')}}"+"/"+accountId,
                success: function (response) {
                    // console.log(response)
                    jQuery.each(response.return_policy, function(index, item) {
                        // do something with `item` (or `this` is also `item` if you like)
                        return_policy += "<option value="+item.return_id+">"+item.return_name+"</option>"
                        // console.log(item)
                    });
                    jQuery.each(response.shipment_policy, function(index, item) {
                        // do something with `item` (or `this` is also `item` if you like)
                        shipment_policy += "<option value="+item.shipment_id+">"+item.shipment_name+"</option>"
                        // console.log(item)
                    });
                    jQuery.each(response.payment_policy, function(index, item) {
                        // do something with `item` (or `this` is also `item` if you like)
                        payment_policy += "<option value="+item.payment_id+">"+item.payment_name+"</option>"
                        // console.log(item)
                    });
                    $("#return-policy").append(return_policy)
                    $("#shipment-policy").append(shipment_policy)
                    $("#payment-policy").append(payment_policy)
                }
            });
            $('#step-2-form').show()
            $("#step2n").show()
        }
        function getItemToMigrationList(accountId,pageNumber,totalItem,counter){
            console.log(totalItem)
            console.log((((100*counter)/totalItem)).toFixed());
            $.ajax({
                type:"get",
                url: "{{url('ebay-get-item')}}"+"/"+accountId+"/"+pageNumber,
                success: function (response) {
                    var r_counter = counter+parseInt(response)
                    console.log(response)
                    $("#pBar").css("width",((100*r_counter)/totalItem).toFixed()+"%");
                    $("#pBar").text((((100*r_counter)/totalItem)).toFixed()+"%");
                    var pNo=  pageNumber-1
                    if (pNo != 0){
                        getItemToMigrationList(accountId,pNo,totalItem,(r_counter));
                    }else{
                        showPolicy(accountId);
                    }
                }
            });
        }
        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for(var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
        $(".submit").click(function(){
            return false;
        })
        $('.select2').select2({

        });

        function showRequired(id){

            $('#'+id+'r').show();
        }
        function emptyRequired(id){
            $('#'+id+'r').hide();
        }
    });

    function ebaySitesPlaceholderIn(){
        $('.ebay-sites-placeholder').hide()
    }

    function ebaySitesPlaceholderOut(){
        var option = $('li.select2-selection__choice').length
        if(option > 0){
            $('.ebay-sites-placeholder').hide()
        }else{
            $('.ebay-sites-placeholder').show()
        }
    }

    function selectSites(){
        $('.ebay-sites-placeholder').hide()
        $('.select2-selection').click()
    }

    $(document).ready(function(){
        {{--var url = "{{ url('/')}}"+"/"+"channel-integration/2"--}}
        {{--var current_url = window.location.href--}}
        {{--if(current_url == url){--}}
        {{--    $("#syncing_message").show()--}}
        {{--}--}}

        // country select option a-z sorting
        var options = $('select#country option')
        var arr = options.map(function(_, o){
            return {
                t: $(o).text(),
                v: o.value
            };
        }).get();
        // console.log(arr)
        arr.sort(function(o1, o2) {
            return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0;
        });
        options.each(function(i, o){
            // console.log(i)
            o.value = arr[i].v
            $(o).text(arr[i].t)
        })

    })


</script>

@endsection



