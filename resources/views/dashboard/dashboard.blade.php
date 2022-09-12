@extends('master')
@section('title')
    Dashboard | WMS360
@endsection
@section('content')
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://www.amcharts.com/lib/4/maps.js"></script>
    <script src="https://www.amcharts.com/lib/4/geodata/worldLow.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">

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
    @if(Auth::check() && Auth::user())
        @if($userExpireLastDate)
            $(window).on('load',function(){
                Swal.fire({
                    position: 'top-end',
                    showCloseButton: true,
                    allowOutsideClick: false,
                    icon: 'error',
                    title: 'Your subscription will expire on {{$userExpireLastDate['expire_date']}}',
                    showConfirmButton: false,
                    timer: 30000,
                })
            });
        @endif
        @if($userExpireDate)
            $(window).on('load',function(){
                Swal.fire({
                    icon: 'error',
                    title: 'Your subscription has expired, please renew your subscription!',
                    showConfirmButton: false,
                    width: 800,
                    height: 600,
                    overFlow: false,
                    padding: '3em',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    html: '<a class="btn btn-custom customSwalBtn" href="https://wms360.co.uk/my-account/">Renew</a>',
                })
            });
        @endif
    @endif
</script>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center" style="padding-bottom: 20px">
                <ol class="breadcrumb page-breadcrumb">
                    <li class="breadcrumb-item"><i class="ti-home"></i>WMS</li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                <div class="dash_top_eight_card_content">
                    <a type="button" class="dropdown-toggle" style="cursor: pointer" data-toggle="dropdown">
                        <span id="activeTopEightCard"></span>
                        <span class="fa fa-angle-down font-18"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <div class="tab d-block m-l-10">
                            <a class="topEightCardSaletablinks d-block" style="cursor: pointer" onclick="sales_by_date(event, 1 , 'Today');">Today</a>
                            <a class="topEightCardSaletablinks d-block" style="cursor: pointer" onclick="sales_by_date(event, -1 , 'Yesterday');">Yesterday</a>
                            <a class="topEightCardSaletablinks d-block" style="cursor: pointer" onclick="sales_by_date(event, 7 , 'Last 7 days');">Last 7 days</a>
                            <a class="topEightCardSaletablinks d-block" style="cursor: pointer" onclick="sales_by_date(event, 30 , 'Last 30 days');" id="topEightCardSaledefaultOpen">Last 30 days</a>
                            <a class="topEightCardSaletablinks d-block" style="cursor: pointer" onclick="sales_by_date(event, 60 , 'Last 60 days');">Last 60 days</a>
                            <a class="topEightCardSaletablinks d-block" style="cursor: pointer" onclick="sales_by_date(event, 90 , 'Last 90 days');">Last 90 days</a>
                            <a class="topEightCardSaletablinks d-block" style="cursor: pointer" onclick="sales_by_date(event, 180 , 'Last 6 months');">Last 6 months</a>
                            <a class="topEightCardSaletablinks d-block" style="cursor: pointer" onclick="sales_by_date(event, 365 , 'Last 12 months');">Last 12 months</a>
                            <a class="topEightCardSaletablinks d-block" style="cursor: pointer" onclick="sales_by_date(event, 'all' , 'Over All Sales');">Lifetime</a>
                            <div class="dropdown-divider"></div>
                            <small>Custom Date</small>
                            <span class="dashboard-custom-date-sale-div">
                                <input type="date" name="start_date" class="form-control cus_start_date mb-1">
                                <input type="date" name="end_date" class="form-control cus_end_date mb-1">
                                <button class="btn btn-info btn-sm" onclick="sales_by_date(event, 'custom' , 'Custom Date');">Search</button>
                            </span>
                        </div>
                    </ul>
                </div>
            </div>

                <!--Top Eight Card Tab Content Start-->
                <div id="topEightCardSale_Today" class="topEightCardSaletabcontent">
                    <!--Sales Part-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row position-relative">
                                <div id="salesLoader" class="lds-dual-ring sales-lds-dual-ring hidden"></div> <!--Sales part Loader added-->
                                @if (Session::get('ebay') == 1)
                                <div class="col-xl-3 col-lg-6 col-md-4">
                                    <div class="card sales-card l-bg-cherry mb-3">
                                        <div class="card-statistic p-4">
                                            <div class="card-icon card-icon-large"><i class="fa fa-gbp"></i></div>
                                            <div class="mb-4 d-flex">
                                                <div><h5 class="card-title mb-0">eBay Sales</h5></div>
                                            </div>

                                            <div class="row align-items-center mb-2 d-flex">
                                                <div class="col-8">
                                                    <h2 class="d-flex align-items-center ebay mb-0">
                                                        {{ number_format($data['ebay_total_sell'], 2)}}
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if (Session::get('amazon') == 1)
                                <div class="col-xl-3 col-lg-6 col-md-4">
                                    <div class="card sales-card l-bg-blue-dark mb-3">
                                        <div class="card-statistic p-4">
                                            <div class="card-icon card-icon-large"><i class="fa fa-gbp"></i></div>
                                            <div class="mb-4">
                                                <h5 class="card-title mb-0">Amazon Sales</h5>
                                            </div>
                                            <div class="row align-items-center mb-2 d-flex">
                                                <div class="col-8">
                                                    <h2 class="d-flex align-items-center amazon mb-0">
                                                        {{ number_format($data['amazon_total_sell'], 2)}}
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if (Session::get('woocommerce') == 1)
                                <div class="col-xl-3 col-lg-6 col-md-4">
                                    <div class="card sales-card l-bg-green-dark mb-3">
                                        <div class="card-statistic p-4">
                                            <div class="card-icon card-icon-large"><i class="fa fa-gbp"></i></div>
                                            <div class="mb-4">
                                                <h5 class="card-title mb-0">WooCommerce Sales</h5>
                                            </div>
                                            <div class="row align-items-center mb-2 d-flex">
                                                <div class="col-8">
                                                    <h2 class="d-flex align-items-center website mb-0">
                                                        {{ number_format($data['tbo_total_sell'], 2)}}
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if (Session::get('onbuy') == 1)
                                <div class="col-xl-3 col-lg-6 col-md-4">
                                    <div class="card sales-card l-bg-orange-dark mb-3">
                                        <div class="card-statistic p-4">
                                            <div class="card-icon card-icon-large"><i class="fa fa-gbp"></i></div>
                                            <div class="mb-4">
                                                <h5 class="card-title mb-0">OnBuy Sales</h5>
                                            </div>
                                            <div class="row align-items-center mb-2 d-flex">
                                                <div class="col-8">
                                                    <h2 class="d-flex align-items-center onbuy mb-0">
                                                        {{ number_format($data['onbuy_total_sell'], 2)}}
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if (Session::get('shopify') == 1)
                                <div class="col-xl-3 col-lg-6 col-md-4">
                                    <div class="card sales-card l-bg-light-green-orange mb-3">
                                        <div class="card-statistic p-4">
                                            <div class="card-icon card-icon-large"><i class="fa fa-gbp"></i></div>
                                            <div class="mb-4">
                                                <h5 class="card-title mb-0">Shopify Sales</h5>
                                            </div>
                                            <div class="row align-items-center mb-2 d-flex">
                                                <div class="col-8">
                                                    <h2 class="d-flex align-items-center shopify mb-0">
                                                        {{ number_format($data['shopify_total_sell'], 2)}}
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-xl-3 col-lg-6 col-md-4">
                                    <div class="card sales-card l-bg-bringal-dark mb-3">
                                        <div class="card-statistic p-4">
                                            <div class="card-icon card-icon-large"><i class="fa fa-gbp"></i></div>
                                            <div class="mb-4">
                                                <h5 class="card-title mb-0">Complete Order Sales</h5>
                                            </div>
                                            <div class="row align-items-center mb-2 d-flex">
                                                <div class="col-8">
                                                    <h2 class="d-flex align-items-center complete-order mb-0">
                                                        {{ number_format($data['complete_order_sell'], 2)}}
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-md-4">
                                    <div class="card sales-card l-bg-cyan-dark mb-3">
                                        <div class="card-statistic p-4">
                                            <div class="card-icon card-icon-large"><i class="fa fa-gbp"></i></div>
                                            <div class="mb-4">
                                                <h5 class="card-title mb-0">Processing Order Sales</h5>
                                            </div>
                                            <div class="row align-items-center mb-2 d-flex">
                                                <div class="col-8">
                                                    <h2 class="d-flex align-items-center processing-order mb-0">
                                                        {{ number_format($data['processing_order_sell'], 2)}}
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-md-4">
                                    <div class="card sales-card l-bg-ash-dark mb-3">
                                        <div class="card-statistic p-4">
                                            <div class="card-icon card-icon-large"><i class="fa fa-gbp"></i></div>
                                            <div class="mb-4">
                                                <h5 class="card-title mb-0">ePOS Sales</h5>
                                            </div>
                                            <div class="row align-items-center mb-2 d-flex">
                                                <div class="col-8">
                                                    <h2 class="d-flex align-items-center manual-order mb-0">
                                                        {{ number_format($data['manual_total_sell'], 2)}}
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-md-4">
                                    <div class="card sales-card l-bg-melon-dark mb-3">
                                        <div class="card-statistic p-4">
                                            <div class="card-icon card-icon-large"><i class="fa fa-gbp"></i></div>
                                            <div class="mb-4">
                                                <h5 class="card-title mb-0">Total Sales</h5>
                                            </div>
                                            <div class="row align-items-center mb-2 d-flex">
                                                <div class="col-8">
                                                    <h2 class="d-flex align-items-center total-sales mb-0">
                                                        {{ number_format($data['total_sell'], 2) }}
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Sales Part -->
                </div>
                <!--Catalogue Order Product Inventory-->
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-4">
                        <div class="card mixin-card">
                            <div class="card-statistic-2">
                                <div class="align-items-center justify-content-between">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pr-0 pt-3">
                                            <div class="card-content">
                                                <h5>Total Catalogue</h5>
                                                <h2 class="mb-3 font-18">{{$data['total_catalogue'] ?? 0}}</h2>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pl-0">
                                            <div class="banner-img">
                                                <img src="{{asset('assets/common-assets/1.png')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <p class="text-muted m-0">Last 30 Day's Catalogue: {{$data['last_month_total_catalogue'] ?? 0}}</p>
                                            <p class="text-muted m-0">Last 7 Day's Catalogue: {{$data['last_week_total_catalogue'] ?? 0}}</p>
                                            <p class="text-muted m-0">Today's Catalogue: {{$data['today_catalogue'] ?? 0}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-4">
                        <div class="card mixin-card">
                            <div class="card-statistic-2">
                                <div class="align-items-center justify-content-between">
                                    <div class="row ">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pr-0 pt-3">
                                            <div class="card-content">
                                                <h5> Total Order </h5>
                                                <h2 class="mb-3 font-18">{{$data['total_order'] ?? 0}}</h2>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pl-0">
                                            <div class="banner-img">
                                                <img src="{{asset('assets/common-assets/2.png')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <p class="text-muted m-0">Last 30 Day's Order: {{$data['last_month_total_order'] ?? 0}}</p>
                                            <p class="text-muted m-0">Last 7 Day's Order: {{$data['last_week_total_order'] ?? 0}}</p>
                                            <p class="text-muted m-0">Today's Order: {{$data['today_order'] ?? 0}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-4">
                        <div class="card mixin-card">
                            <div class="card-statistic-2">
                                <div class="align-items-center justify-content-between">
                                    <div class="row ">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pr-0 pt-3">
                                            <div class="card-content">
                                                <h5> Total Product </h5>
                                                <h2 class="mb-3 font-18">{{$data['total_product'] ?? 0}}</h2>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pl-0">
                                            <div class="banner-img">
                                                <img src="{{asset('assets/common-assets/3.png')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <p class="text-muted m-0">Last 30 Day's Product: {{$data['last_month_total_product'] ?? 0}}</p>
                                            <p class="text-muted m-0">Last 7 Day's Product: {{$data['last_week_total_product'] ?? 0}}</p>
                                            <p class="text-muted m-0">Today's Product: {{$data['today_product'] ?? 0}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-4">
                        <div class="card mixin-card">
                            <div class="card-statistic-2">
                                <div class="align-items-center justify-content-between">
                                    <div class="row ">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pr-0 pt-3">
                                            <div class="card-content">
                                                <h5>Total Invoice</h5>
                                                <h2 class="mb-3 font-18">{{$data['total_invoice'] ?? 0}}</h2>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pl-0">
                                            <div class="banner-img">
                                                <img src="{{asset('assets/common-assets/4.png')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <p class="text-muted m-0">Last 30 Day's Invoice: {{$data['last_month_total_invoice'] ?? 0}}</p>
                                            <p class="text-muted m-0">Last 7 Day's Invoice: {{$data['last_week_total_invoice'] ?? 0}}</p>
                                            <p class="text-muted m-0">Today's Invoice: {{$data['today_invoice'] ?? 0}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-4">
                        <div class="card mixin-card">
                            <div class="card-statistic-2">
                                <div class="align-items-center justify-content-between">
                                    <div class="row ">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pr-0 pt-3">
                                            <div class="card-content">
                                                <h5>Inventory Value</h5>
                                                <h2 class="mb-3 font-18"><i class="fa fa-gbp mr-1"></i>{{ number_format($data['total_cost_price'], 2)}}</h2>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pl-0">
                                            <div class="banner-img">
                                                <img src="{{asset('assets/common-assets/5.png')}}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-4">
                        <div class="card mixin-card">
                            <div class="card-statistic-2">
                                <div class="align-items-center justify-content-between">
                                    <div class="row ">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pr-0 pt-3">
                                            <div class="card-content">
                                                <h5>Hold Orders</h5>
                                                <h2 class="mb-3 font-18"><i class="fa fa-gbp mr-1"></i>{{ number_format($data['onhold_order_sell'], 2)}}</h2>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pl-0">
                                            <div class="banner-img">
                                                <img src="{{asset('assets/common-assets/6.png')}}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-4">
                        <div class="card mixin-card">
                            <div class="card-statistic-2">
                                <div class="align-items-center justify-content-between">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pr-0 pt-3">
                                            <div class="card-content">
                                                <h5>Total Users</h5>
                                                <h2 class="mb-3 font-18">{{$data['total_user'] ?? 0}}</h2>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pl-0">
                                            <div class="banner-img">
                                                <img src="{{asset('assets/common-assets/7.png')}}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-4">
                        <div class="card mixin-card">
                            <div class="card-statistic-2">
                                <div class="align-items-center justify-content-between">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pr-0 pt-3">
                                            <div class="card-content">
                                                <h5>Total Return</h5>
                                                <h2 class="mb-3 font-18">{{$data['return_order'] ?? 0}}</h2>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pl-0">
                                            <div class="banner-img">
                                                <img src="{{asset('assets/common-assets/8.png')}}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--End Catalogue Order Product Inventory-->
                @if($userExpireDate < $currentDate)
                <div class="row">
                    <div class="col-md-8">
                        <div class="card-box shadow ordered-sales-header">
                            <div class="d-flex justify-content-between columnchart">
                                <div> <p><b>Overall Sales (Last 30 Days)</b></p> </div>
                                <div class="overall_sell"></div>
                            </div>
                            <div id="chartdiv1" class="mt-2"></div>
                        </div>
                    </div>

                    <div class="col-md-4 position-relative">
                        <div id="ChannelLoader" class="lds-dual-ring hidden"></div> <!--Loader added-->
                        <div class="card-box shadow ordered-channel-header">
                            <div class="d-flex justify-content-between piechart">
                                <div class="loaderSpinner"> <p><b>Sales by Channel</b></p> </div>
                                <div class="sales_by_channel">
                                    <a type="button" class="dropdown-toggle" style="cursor: pointer" data-toggle="dropdown">
                                        <span id="activeChannel"></span>
                                        <span class="fa fa-angle-down font-18"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <div class="tab d-block m-l-10">
                                            <a class="channeltablinks d-block" style="cursor: pointer" onclick="sales_by_channel(event, 1 ,'Today')" >Today</a>
                                            <a class="channeltablinks d-block" style="cursor: pointer" onclick="sales_by_channel(event, 7 ,'Last 7 days')">Last 7 days</a>
                                            <a class="channeltablinks d-block" style="cursor: pointer" onclick="sales_by_channel(event, 30 ,'Last 30 days')" id="channeldefaultOpen">Last 30 days</a>
                                            <a class="channeltablinks d-block" style="cursor: pointer" onclick="sales_by_channel(event, 60 ,'Last 60 days')">Last 60 days</a>
                                            <a class="channeltablinks d-block" style="cursor: pointer" onclick="sales_by_channel(event, 90 ,'Last 90 days')">Last 90 days</a>
                                            <a class="channeltablinks d-block" style="cursor: pointer" onclick="sales_by_channel(event, 180 ,'Last 6 months')">Last 6 months</a>
                                            <a class="channeltablinks d-block" style="cursor: pointer" onclick="sales_by_channel(event, 3650 ,'Last 12 months')">Last 12 months</a>
                                            <a class="channeltablinks d-block" style="cursor: pointer" onclick="sales_by_channel(event, 'all' ,'Over All')">Over All</a>
                                        </div>
                                    </ul>
                                </div>
                            </div>

                            <div id="channel_Today" class="channeltabcontent">
                                <div id="chartdiv2" class="mt-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-8 position-relative">
                        <div id="orderCountryLoader" class="lds-dual-ring order-country-lds-dual-ring hidden"></div> <!--orderCountryLoader Loader added-->
                        <div class="card-box shadow ordered-country-card">
                            <div class="d-flex justify-content-between ordercategorychart">
                                <div> <p><b>Top 20 Ordered Country</b></p> </div>
                                <div class="top_twenty_ordered_country">
                                    <a type="button" class="dropdown-toggle" style="cursor: pointer" data-toggle="dropdown">
                                        <span id="activeTopOrderCountry"></span>
                                        <span class="fa fa-angle-down font-18"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <div class="tab d-block m-l-10">
                                            <a class="TopORcountrytablinks d-block" style="cursor: pointer" onclick="top_ordered_country(event, 1 ,'Today')" >Today</a>
                                            <a class="TopORcountrytablinks d-block" style="cursor: pointer" onclick="top_ordered_country(event, 7 ,'Last 7 days')">Last 7 days</a>
                                            <a class="TopORcountrytablinks d-block" style="cursor: pointer" onclick="top_ordered_country(event, 30 ,'Last 30 days')" id="TopORcountrydefaultOpen">Last 30 days</a>
                                            <a class="TopORcountrytablinks d-block" style="cursor: pointer" onclick="top_ordered_country(event, 60 ,'Last 60 days')">Last 60 days</a>
                                            <a class="TopORcountrytablinks d-block" style="cursor: pointer" onclick="top_ordered_country(event, 90 ,'Last 90 days')">Last 90 days</a>
                                            <a class="TopORcountrytablinks d-block" style="cursor: pointer" onclick="top_ordered_country(event, 180 ,'Last 6 months')">Last 6 months</a>
                                            <a class="TopORcountrytablinks d-block" style="cursor: pointer" onclick="top_ordered_country(event, 365 ,'Last 12 months')">Last 12 months</a>
                                            <a class="TopORcountrytablinks d-block" style="cursor: pointer" onclick="top_ordered_country(event, 'all' ,'Over All')">Over All</a>
                                        </div>
                                    </ul>
                                </div>
                            </div>

                            <div id="TopOrderCountry_Today" class="TopORcountrytabcontent">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mt-3">
                                            <div id="chartdiv4"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="nicescroll mt-3" style="height: 350px; padding-right: 6px">
                                            @isset($data['top_country'])
                                                @foreach($data['top_country'] as $top_country)
                                                    <div class="row m-b-15">
                                                        <div class="col-9">{{$top_country->customer_country ?? ''}}</div>
                                                        <div class="col-3 text-right">{{$top_country->total_country ?? 0}}</div>
                                                        <div class="col-12">
                                                            <div class="progress" data-height="6" style="height: 6px;">
                                                                <div class="progress-bar bg-purple" style="width: 100%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endisset
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4 position-relative">
                        <div id="orderProductLoader" class="lds-dual-ring order-product-lds-dual-ring hidden"></div> <!--Order product loader-->
                        <div class="card-box shadow ordered-product-card">
                            <div class="d-flex justify-content-between orderproductchart">
                                <div> <p><b>Top 20 Ordered Catalogue</b></p> </div>
                                <div class="top_twenty_ordered_product">
                                    <a type="button" class="dropdown-toggle" style="cursor: pointer" data-toggle="dropdown">
                                        <span id="activeOrderProduct"></span>
                                        <span class="fa fa-angle-down font-18"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <div class="tab d-block m-l-10">
                                            <a class="orderproducttablinks d-block" style="cursor: pointer" onclick="top_ordered_product(event, 1 ,'Today')" >Today</a>
                                            <a class="orderproducttablinks d-block" style="cursor: pointer" onclick="top_ordered_product(event, 7 ,'Last 7 days')">Last 7 days</a>
                                            <a class="orderproducttablinks d-block" style="cursor: pointer" onclick="top_ordered_product(event, 30 ,'Last 30 days')" id="OrderProductdefaultOpen">Last 30 days</a>
                                            <a class="orderproducttablinks d-block" style="cursor: pointer" onclick="top_ordered_product(event, 60 ,'Last 60 days')">Last 60 days</a>
                                            <a class="orderproducttablinks d-block" style="cursor: pointer" onclick="top_ordered_product(event, 90 ,'Last 90 days')">Last 90 days</a>
                                            <a class="orderproducttablinks d-block" style="cursor: pointer" onclick="top_ordered_product(event, 180 ,'Last 6 months')">Last 6 months</a>
                                            <a class="orderproducttablinks d-block" style="cursor: pointer" onclick="top_ordered_product(event, 365 ,'Last 12 months')">Last 12 months</a>
                                            <a class="orderproducttablinks d-block" style="cursor: pointer" onclick="top_ordered_product(event, 'all' ,'Over All')">Over All</a>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                            <div id="OrderProduct_Today" class="orderproducttabcontent">
                                <div class="nicescroll" style="height: 330px">
                                    <ul class="list-unstyled top-ordered-product mt-3">
                                        @isset($data['top_product'])
                                            @foreach($data['top_product'] as $top_product)
                                                <li class="media">
                                                    <img class="mr-3 rounded" width="55" src="{{$top_product['catalogue_image'] ? asset('/').$top_product['catalogue_image'] : asset('assets/common-assets/no_image.jpg')}}" alt="product">
                                                    <div class="media-body">
                                                        <div class="float-right">
                                                            <div class="font-weight-600 text-default label label-success">{{$top_product['total_order_product'] ?? 0}} Orders</div>
                                                        </div>
                                                        <div class="media-title">{{$top_product['catalogue_title'] ?? ''}}</div>
                                                        <div class="mt-1">
                                                            <div id="sales-price">
                                                                <div class="sales-price-square bg-purple" style="width: 45%;"></div>
                                                                <div class="sales-price-label"><i class='fa fa-gbp mr-1'></i>{{number_format($top_product['total_order_price'],2)}}</div>
                                                            </div>
                                                            <div id="sales-price">
                                                                <div class="sales-price-square bg-danger" style="width: 30%;"></div>
                                                                <div class="sales-price-label"><i class='fa fa-gbp mr-1'></i>{{number_format($top_product['total_cost_price'],2)}}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endisset
                                    </ul>
                                </div>
                                <div class="pt-3 d-flex justify-content-center">
                                    <div class="justify-content-center" id="sales-price">
                                        <div class="sales-price-square bg-purple" data-width="20" style="width: 20px;"></div>
                                        <div class="sales-price-label">Selling Price</div>
                                    </div>
                                    <div class="justify-content-center" id="sales-price">
                                        <div class="sales-price-square bg-danger" data-width="20" style="width: 20px;"></div>
                                        <div class="sales-price-label">Product Cost</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div> <!-- End row -->


                <div class="row">
                    <div class="col-md-12 position-relative">
                        <div id="orderCategoryLoader" class="lds-dual-ring order-category-lds-dual-ring hidden"></div> <!--Order product loader-->
                        <div class="card-box shadow ordered-category-card">
                            <div class="d-flex justify-content-between ordercategorychart">
                                <div> <p><b>Top 20 Ordered Category</b></p> </div>
                                <div class="top_twenty_ordered_category">
                                    <a type="button" class="dropdown-toggle" style="cursor: pointer" data-toggle="dropdown">
                                        <span id="activeOrderCategory"></span>
                                        <span class="fa fa-angle-down font-18"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <div class="tab d-block m-l-10">
                                            <a class="ordercategorytablinks d-block" style="cursor: pointer" onclick="top_order_category(event, 1 ,'Today')" >Today</a>
                                            <a class="ordercategorytablinks d-block" style="cursor: pointer" onclick="top_order_category(event, 7 ,'Last 7 days')">Last 7 days</a>
                                            <a class="ordercategorytablinks d-block" style="cursor: pointer" onclick="top_order_category(event, 30 ,'Last 30 days')" id="OrderCategorydefaultOpen">Last 30 days</a>
                                            <a class="ordercategorytablinks d-block" style="cursor: pointer" onclick="top_order_category(event, 60 ,'Last 60 days')">Last 60 days</a>
                                            <a class="ordercategorytablinks d-block" style="cursor: pointer" onclick="top_order_category(event, 90 ,'Last 90 days')">Last 90 days</a>
                                            <a class="ordercategorytablinks d-block" style="cursor: pointer" onclick="top_order_category(event, 180 ,'Last 6 months')">Last 6 months</a>
                                            <a class="ordercategorytablinks d-block" style="cursor: pointer" onclick="top_order_category(event, 365 ,'Last 12 months')">Last 12 months</a>
                                            <a class="ordercategorytablinks d-block" style="cursor: pointer" onclick="top_order_category(event, 'all','Over All')">Over All</a>
                                        </div>
                                    </ul>
                                </div>
                            </div>


                            <div id="OrderCategory_Today" class="ordercategorytabcontent">
                                <div id="chartdiv3"></div>
                            </div>

                        </div>

                    </div>
                </div> <!-- End row -->

            </div> <!-- container -->


        </div> <!-- content -->
    </div> <!--content page-->



    <!-- <div id="Load" class="load" style="display: none;">
        <div class="load__container">
            <div class="load__animation"></div>
            <div class="load__mask"></div>
            <span class="load__title">Content is loading...</span>
        </div>
    </div> -->

    <script type="text/javascript">

        am4core.ready(function() {
// Themes begin
            am4core.useTheme(am4themes_animated);
// Themes end
// Create chart instance
            var chart = am4core.create("chartdiv1", am4charts.XYChart);
            chart.numberFormatter.numberFormat = "£#,###";
            // chart.scrollbarX = new am4core.Scrollbar();
                var barChart = "{{$data['bar_chart_sale']}}";
                var filter_sale = barChart.replace(/&quot;/g,'"');
                var filter_sale_infos = JSON.parse(filter_sale);
                chart.data = filter_sale_infos;
// Add data
//             chart.data = [{
//                 "September Sales": "1",
//                 "price": 4025
//             }, {
//                 "September Sales": "2",
//                 "price": 1882
//             }, {
//                 "September Sales": "3",
//                 "price": 1809
//             }, {
//                 "September Sales": "4",
//                 "price": 1322
//             }, {
//                 "September Sales": "5",
//                 "price": 1122
//             }, {
//                 "September Sales": "6",
//                 "price": 1114
//             }, {
//                 "September Sales": "7",
//                 "price": 984
//             }, {
//                 "September Sales": "8",
//                 "price": 711
//             }, {
//                 "September Sales": "9",
//                 "price": 665
//             }, {
//                 "September Sales": "10",
//                 "price": 580
//             }, {
//                 "September Sales": "11",
//                 "price": 443
//             }, {
//                 "September Sales": "12",
//                 "price": 441
//             }, {
//                 "September Sales": "13",
//                 "price": 395
//             }, {
//                 "September Sales": "14",
//                 "price": 386
//             }, {
//                 "September Sales": "15",
//                 "price": 384
//             }, {
//                 "September Sales": "16",
//                 "price": 338
//             }, {
//                 "September Sales": "17",
//                 "price": 388
//             }, {
//                 "September Sales": "18",
//                 "price": 428
//             }, {
//                 "September Sales": "19",
//                 "price": 456
//             }, {
//                 "September Sales": "20",
//                 "price": 234
//             }, {
//                 "September Sales": "21",
//                 "price": 345
//             }, {
//                 "September Sales": "22",
//                 "price": 238
//             }, {
//                 "September Sales": "23",
//                 "price": 277
//             }, {
//                 "September Sales": "24",
//                 "price": 456
//             }, {
//                 "September Sales": "25",
//                 "price": 365
//             }, {
//                 "September Sales": "26",
//                 "price": 635
//             }, {
//                 "September Sales": "27",
//                 "price": 364
//             }, {
//                 "September Sales": "28",
//                 "price": 153
//             }, {
//                 "September Sales": "29",
//                 "price": 624
//             }, {
//                 "September Sales": "30",
//                 "price": 379
//             }, {
//                 "September Sales": "31",
//                 "price": 837
//             }
//             ];


            // Create axes
            let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "Sales";
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.renderer.minGridDistance = 30;
            // categoryAxis.renderer.labels.template.horizontalCenter = "right";
            categoryAxis.renderer.labels.template.verticalCenter = "middle";
            // categoryAxis.renderer.labels.template.rotation = 360;
            categoryAxis.tooltip.disabled = true;
            // categoryAxis.renderer.minHeight = 110;

            let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.renderer.minWidth = 50;
            valueAxis.title.text = "Sales";
            valueAxis.title.fontWeight = "bold";

            // Create series
            let series = chart.series.push(new am4charts.ColumnSeries());
            // series.sequencedInterpolation = true;
            series.dataFields.valueY = "price";
            series.dataFields.categoryX = "Sales";
            series.name = "Sales";
            series.tooltipText = "{categoryX}: [bold]{valueY}[/]";
            series.columns.template.strokeWidth = 0;
            series.columns.template.width = am4core.percent(40);
            // series.columns.template.color = "#67b7dc !important",
            series.tooltip.pointerOrientation = "vertical";
            series.columns.template.column.cornerRadiusTopLeft = 10;
            series.columns.template.column.cornerRadiusTopRight = 10;
            series.columns.template.column.fillOpacity = 0.8;
            series.columns.template.column.fill = am4core.color("rgba(103, 183, 220, 1)");
            series.tooltip.getFillFromObject = false;
            series.tooltip.background.fill = am4core.color("rgba(103, 183, 220, 1)");

            // on hover, make corner radiuses bigger
            let hoverState = series.columns.template.column.states.create("hover");
            hoverState.properties.cornerRadiusTopLeft = 0;
            hoverState.properties.cornerRadiusTopRight = 0;
            hoverState.properties.fillOpacity = 1;

            series.columns.template.adapter.add("fill", function(fill, target) {
                return chart.colors.getIndex(target.dataItem.index);
            });

            // Cursor
            chart.cursor = new am4charts.XYCursor();
            chart.logo.disabled = true;

        });  // end am4core.ready()

        // Sales by channel pie chart
        // Create chart instance
        var chart = am4core.create("chartdiv2", am4charts.PieChart3D);
        var channel = "{{$data['order_channel']}}";
        var filter_channel = channel.replace(/&quot;/g,'"');
        var filter_channel_infos = JSON.parse(filter_channel);
        chart.data = filter_channel_infos;


        // Add data
        {{--chart.data = [{--}}
        {{--    "ChannelFactory": "eBay",--}}
        {{--    "salesPrice": "{{json_encode($data['ebay_total_sell'])}}"--}}
        {{--}, {--}}
        {{--    "ChannelFactory": "Amazon",--}}
        {{--    "salesPrice": "{{json_encode($data['amazon_total_sell'])}}"--}}
        {{--}, {--}}
        {{--    "ChannelFactory": "Website",--}}
        {{--    "salesPrice": "{{json_encode($data['tbo_total_sell'])}}"--}}
        {{--}, {--}}
        {{--    "ChannelFactory": "Onbuy",--}}
        {{--    "salesPrice": "{{json_encode($data['onbuy_total_sell'])}}"--}}
        {{--}, {--}}
        {{--    "ChannelFactory": "E-POS",--}}
        {{--    "salesPrice": "{{json_encode($data['manual_total_sell'])}}"--}}
        {{--}];--}}

        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries3D());
        pieSeries.dataFields.value = "salesPrice";
        pieSeries.dataFields.category = "ChannelFactory";

        pieSeries.ticks.template.disabled = true;
        pieSeries.alignLabels = false;
        pieSeries.labels.template.text = "{value.percent.formatNumber('#.0')}%";
        pieSeries.labels.template.radius = am4core.percent(-40);
        pieSeries.labels.template.fill = am4core.color("white");
        chart.legend = new am4charts.Legend();
        // Top 20 Ordered Category
        am4core.ready(function() {
            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes endTop 20 Ordered Category
            var chart = am4core.create("chartdiv3", am4charts.PieChart3D);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
            var category = "{{$data['product_category']}}";
            var filter_category = category.replace(/&quot;/g,'"');
            var filter_category_infos = JSON.parse(filter_category);
            chart.data = filter_category_infos;

            // chart.data = [
            //     {
            //         category: "3 Pack/1 pack/2 pack",
            //         totalCategory: 576
            //     },
            //     {
            //         category: "Mens Jeans",
            //         totalCategory: 564
            //     },
            //     {
            //         category: "Crewneck",
            //         totalCategory: 561
            //     },
            //     {
            //         category: "Mens T-Shirt",
            //         totalCategory: 165.8
            //     },
            //     {
            //         category: "Mens Puffer Jacket",
            //         totalCategory: 56
            //     },
            //     {
            //         category: "Mens Underwear",
            //         totalCategory: 303
            //     },
            //     {
            //         category: "Mens Sweat Shirt/Jumper/Knitwear",
            //         totalCategory: 230
            //     },
            //     {
            //         category: "Men",
            //         totalCategory: 227
            //     },
            //     {
            //         category: "Mens Fleece Shorts",
            //         totalCategory: 208
            //     },
            //     {
            //         category: "Boxer",
            //         totalCategory: 184
            //     },
            //     {
            //         category: "Mens Shorts",
            //         totalCategory: 169
            //     },
            //     {
            //         category: "Mens Jogger",
            //         totalCategory: 144
            //     },
            //     {
            //         category: "Brief",
            //         totalCategory: 77
            //     },
            //     {
            //         category: "Mens Hoodies",
            //         totalCategory: 72
            //     },
            //     {
            //         category: "Mens Polo Shirt",
            //         totalCategory: 72
            //     },
            //     {
            //         category: "Mens Trainer",
            //         totalCategory: 65
            //     },
            //     {
            //         category: "Mens Activewear",
            //         totalCategory: 64
            //     },
            //     {
            //         category: "Mens Footwear",
            //         totalCategory: 62
            //     },
            //     {
            //         category: "Mens Sneakers",
            //         totalCategory: 128.3
            //     },
            //     {
            //         category: "Mens Zipper Hoodie",
            //         totalCategory: 57
            //     },
            // ];

            chart.innerRadius = am4core.percent(40);
            chart.depth = 120;
            chart.logo.disabled = true;

            chart.legend = new am4charts.Legend();
            var series = chart.series.push(new am4charts.PieSeries3D());
            series.dataFields.value = "totalCategory";
            series.dataFields.depthValue = "totalCategory";
            series.dataFields.category = "category";
            series.slices.template.cornerRadius = 5;
            series.colors.step = 3;

        }); // end am4core.ready()

        //Visitors  by countries world map
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end
        // Create map instance
        var chart = am4core.create("chartdiv4", am4maps.MapChart);
        var country_map = "{{ $data['country_map'] }}";
        var country_map_info = country_map.replace(/&quot;/g,'"');
        var country_map_infos = JSON.parse(country_map_info);
        var mapData = country_map_infos;
        // var mapData = [
        //     { "id": "GB", "name": "GB", "value": 260, "color": "#bf345b" },
        //     { "id": "US", "name": "US", "value": 193, "color": "#bf345b" },
        //     { "id": "DE", "name": "DE", "value": 432, "color": "#bf345b" },
        //     { "id": "JP", "name": "JP", "value": 561, "color": "#bf345b" },
        //     { "id": "IL", "name": "IL", "value": 236, "color": "#bf345b" },
        //
        // ];

        // Set map definition
        chart.geodata = am4geodata_worldLow;
        chart.logo.disabled = true;

        // Set projection
        chart.projection = new am4maps.projections.Miller();

        // Create map polygon series
        var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
        polygonSeries.exclude = ["AQ"];
        polygonSeries.useGeodata = true;
        polygonSeries.nonScalingStroke = true;
        polygonSeries.strokeWidth = 0.5;
        polygonSeries.calculateVisualCenter = true;

        polygonSeries.events.on("validated", function(){
            imageSeries.invalidate();
        })
        var imageSeries = chart.series.push(new am4maps.MapImageSeries());
        imageSeries.data = mapData;
        imageSeries.dataFields.value = "value";

        var imageTemplate = imageSeries.mapImages.template;
        imageTemplate.nonScaling = true

        imageTemplate.adapter.add("latitude", function(latitude, target) {
            var polygon = polygonSeries.getPolygonById(target.dataItem.dataContext.id);
            if(polygon){
                return polygon.visualLatitude;
            }
            return latitude;
        })

        imageTemplate.adapter.add("longitude", function(longitude, target) {
            var polygon = polygonSeries.getPolygonById(target.dataItem.dataContext.id);
            if(polygon){
                return polygon.visualLongitude;
            }
            return longitude;
        })

        var circle = imageTemplate.createChild(am4core.Circle);
        circle.fillOpacity = 0.7;
        circle.propertyFields.fill = "color";
        circle.tooltipText = "{name}: [bold]{value}[/]";

        imageSeries.heatRules.push({
            "target": circle,
            "property": "radius",
            "min": 4,
            "max": 30,
            "dataField": "value"
        })

        var label = imageTemplate.createChild(am4core.Label);
        label.text = "{name}"
        label.horizontalCenter = "middle";
        label.padding(0,0,0,0);
        label.adapter.add("dy", function(dy, target){
            var circle = target.parent.children.getIndex(0);
            return circle.pixelRadius;
        })
        // Dashboard Top Eight Card Sales
        var activeTopEightCard = "";
        $("#activeTopEightCard").html(activeTopEightCard);
        function EightCardSale(evt, topEightCardSale, topEightCardSaleTitle) {
            var i, topEightCardSaletabcontent, topEightCardSaletablinks;
            topEightCardSaletabcontent = document.getElementsByClassName("topEightCardSaletabcontent");
            for (i = 0; i < topEightCardSaletabcontent.length; i++) {
                topEightCardSaletabcontent[i].style.display = "none";
            }
            topEightCardSaletablinks = document.getElementsByClassName("topEightCardSaletablinks");
            for (i = 0; i < topEightCardSaletablinks.length; i++) {
                topEightCardSaletablinks[i].className = topEightCardSaletablinks[i].className.replace(" active", "");
            }
            document.getElementById(topEightCardSale).style.display = "block";
            evt.currentTarget.className += " active";

            $("#activeTopEightCard").html(topEightCardSaleTitle);
        }

        // Get the element with id="topEightCardSaledefaultOpen" and click on it
        document.getElementById("topEightCardSaledefaultOpen").click();
        //Overall sale
        var activeSale = "";
        $("#activeSale").html(activeSale);

        function overallSale(evt, Sale, saleTitle) {
            var i, saletabcontent, saletablinks;
            saletabcontent = document.getElementsByClassName("saletabcontent");
            for (i = 0; i < saletabcontent.length; i++) {
                saletabcontent[i].style.display = "none";
            }
            saletablinks = document.getElementsByClassName("saletablinks");
            for (i = 0; i < saletablinks.length; i++) {
                saletablinks[i].className = saletablinks[i].className.replace(" active", "");
            }
            document.getElementById(Sale).style.display = "block";
            evt.currentTarget.className += " active";

            $("#activeSale").html(saleTitle);
        }

        // Get the element with id="saleDefaultOpen" and click on it
        // document.getElementById("saleDefaultOpen").click();

        //Sales By ChannelFactory
        var activeChannel = "";
        $("#activeChannel").html(activeChannel);

        function channelSale(evt, Channel, channelTitle) {
            var i, channeltabcontent, channeltablinks;
            channeltabcontent = document.getElementsByClassName("channeltabcontent");
            for (i = 0; i < channeltabcontent.length; i++) {
                channeltabcontent[i].style.display = "none";
            }
            channeltablinks = document.getElementsByClassName("channeltablinks");
            for (i = 0; i < channeltablinks.length; i++) {
                channeltablinks[i].className = channeltablinks[i].className.replace(" active", "");
            }
            document.getElementById(Channel).style.display = "block";
            evt.currentTarget.className += " active";

            $("#activeChannel").html(channelTitle);
        }

        function sales_by_channel(evt, day, optionTitle) {
            $("#activeChannel").html(optionTitle);
            $.ajax({
                type : "POST",
                url : "{{url('sales-by-channel')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "day" : day
                },
                beforeSend: function(){
                    $('#ChannelLoader').removeClass('hidden')
                },
                success: function (response) {
                    if(response.length > 0) {
                        var chart = am4core.create("chartdiv2", am4charts.PieChart3D);
                        chart.data = response;
                        var pieSeries = chart.series.push(new am4charts.PieSeries3D());
                        pieSeries.dataFields.value = "salesPrice";
                        pieSeries.dataFields.category = "ChannelFactory";
                        pieSeries.ticks.template.disabled = true;
                        pieSeries.alignLabels = false;
                        pieSeries.labels.template.text = "{value.percent.formatNumber('#.0')}%";
                        pieSeries.labels.template.radius = am4core.percent(-40);
                        pieSeries.labels.template.fill = am4core.color("white");
                        chart.legend = new am4charts.Legend();
                        chart.logo.disabled = true;
                    }else {
                        $('#chartdiv2').html('<div class="aler alert-danger p-20 text-center">No Order Found</div>');
                    }
                },
                complete:function(data){
                    $('#ChannelLoader').addClass('hidden')
                }
            });
        }

        // Get the element with id="channeldefaultOpen" and click on it
        document.getElementById("channeldefaultOpen").click();

        //Top 20 ordered product
        var activeOrderProduct = "";
        $("#activeOrderProduct").html(activeOrderProduct);

        function OrderProduct(evt, OrderProduct, OrderProductTitle) {
            var i, orderproducttabcontent, orderproducttablinks;
            orderproducttabcontent = document.getElementsByClassName("orderproducttabcontent");
            for (i = 0; i < orderproducttabcontent.length; i++) {
                orderproducttabcontent[i].style.display = "none";
            }
            orderproducttablinks = document.getElementsByClassName("orderproducttablinks");
            for (i = 0; i < orderproducttablinks.length; i++) {
                orderproducttablinks[i].className = orderproducttablinks[i].className.replace(" active", "");
            }
            document.getElementById(OrderProduct).style.display = "block";
            evt.currentTarget.className += " active";

            $("#activeOrderProduct").html(OrderProductTitle);
        }

        // Get the element with id="OrderProductdefaultOpen" and click on it
        document.getElementById("OrderProductdefaultOpen").click();


        //Top 20 ordered category
        var activeOrderCategory = "";
        $("#activeOrderCategory").html(activeOrderCategory);

        function OrderCategory(evt, OrderCategory, OrderCategoryTitle) {
            var i, ordercategorytabcontent, ordercategorytablinks;
            ordercategorytabcontent = document.getElementsByClassName("ordercategorytabcontent");
            for (i = 0; i < ordercategorytabcontent.length; i++) {
                ordercategorytabcontent[i].style.display = "none";
            }
            ordercategorytablinks = document.getElementsByClassName("ordercategorytablinks");
            for (i = 0; i < ordercategorytablinks.length; i++) {
                ordercategorytablinks[i].className = ordercategorytablinks[i].className.replace(" active", "");
            }
            document.getElementById(OrderCategory).style.display = "block";
            evt.currentTarget.className += " active";

            $("#activeOrderCategory").html(OrderCategoryTitle);
        }

        // Get the element with id="OrderProductdefaultOpen" and click on it
        document.getElementById("OrderCategorydefaultOpen").click();


        //Top 20 ordered country
        var activeTopOrderCountry = "";
        $("#activeTopOrderCountry").html(activeTopOrderCountry);

        function TopOrderCountry(evt, TopORcountry, TopORcountryTitle) {
            var i, TopORcountrytabcontent, TopORcountrytablinks;
            TopORcountrytabcontent = document.getElementsByClassName("TopORcountrytabcontent");
            for (i = 0; i < TopORcountrytabcontent.length; i++) {
                TopORcountrytabcontent[i].style.display = "none";
            }
            TopORcountrytablinks = document.getElementsByClassName("TopORcountrytablinks");
            for (i = 0; i < TopORcountrytablinks.length; i++) {
                TopORcountrytablinks[i].className = TopORcountrytablinks[i].className.replace(" active", "");
            }
            document.getElementById(TopORcountry).style.display = "block";
            evt.currentTarget.className += " active";

            $("#activeTopOrderCountry").html(TopORcountryTitle);
        }

        function top_ordered_country(evt, day , optionTitle){
            $("#activeTopOrderCountry").html(optionTitle);
            $.ajax({
                type : "POST",
                url : "{{url('top-ordered-country')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "day" : day
                },
                beforeSend: function(){
                    $("#orderCountryLoader").show();
                },
                success: function (response) {
                    console.log(response);
                    if(response.map_country.length > 0) {
                        var order_country = '';
                        response.ordered_country.data.forEach(function (item) {
                            order_country += '<div class="row m-b-15">\n' +
                                '    <div class="col-9">' + (item.customer_country == '' ? 'Others' : item.customer_country) + '</div>\n' +
                                '    <div class="col-3 text-right">' + item.total_country + '</div>\n' +
                                '    <div class="col-12">\n' +
                                '        <div class="progress" data-height="6" style="height: 6px;">\n' +
                                '             <div class="progress-bar bg-purple" style="width: 100%;"></div>\n' +
                                '        </div>\n' +
                                '    </div>\n' +
                                '</div>'
                        })
                        $('.TopORcountrytabcontent div.nicescroll').html(order_country);
                        var chart = am4core.create("chartdiv4", am4maps.MapChart);
                        var mapData = response.map_country;

                        // Set map definition
                        chart.geodata = am4geodata_worldLow;
                        chart.logo.disabled = true;

                        // Set projection
                        chart.projection = new am4maps.projections.Miller();

                        // Create map polygon series
                        var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
                        polygonSeries.exclude = ["AQ"];
                        polygonSeries.useGeodata = true;
                        polygonSeries.nonScalingStroke = true;
                        polygonSeries.strokeWidth = 0.5;
                        polygonSeries.calculateVisualCenter = true;

                        polygonSeries.events.on("validated", function () {
                            imageSeries.invalidate();
                        })

                        var imageSeries = chart.series.push(new am4maps.MapImageSeries());
                        imageSeries.data = mapData;
                        imageSeries.dataFields.value = "value";

                        var imageTemplate = imageSeries.mapImages.template;
                        imageTemplate.nonScaling = true

                        imageTemplate.adapter.add("latitude", function (latitude, target) {
                            var polygon = polygonSeries.getPolygonById(target.dataItem.dataContext.id);
                            if (polygon) {
                                return polygon.visualLatitude;
                            }
                            return latitude;
                        })

                        imageTemplate.adapter.add("longitude", function (longitude, target) {
                            var polygon = polygonSeries.getPolygonById(target.dataItem.dataContext.id);
                            if (polygon) {
                                return polygon.visualLongitude;
                            }
                            return longitude;
                        })

                        var circle = imageTemplate.createChild(am4core.Circle);
                        circle.fillOpacity = 0.7;
                        circle.propertyFields.fill = "color";
                        circle.tooltipText = "{name}: [bold]{value}[/]";

                        imageSeries.heatRules.push({
                            "target": circle,
                            "property": "radius",
                            "min": 4,
                            "max": 30,
                            "dataField": "value"
                        })

                        var label = imageTemplate.createChild(am4core.Label);
                        label.text = "{name}"
                        label.horizontalCenter = "middle";
                        label.padding(0, 0, 0, 0);
                        label.adapter.add("dy", function (dy, target) {
                            var circle = target.parent.children.getIndex(0);
                            return circle.pixelRadius;
                        })
                    }else{
                        $('.TopORcountrytabcontent div.nicescroll').html('');
                        $('#chartdiv4').html('<div class="aler alert-danger p-20 text-center">No Ordered Country Found</div>');

                    }
                },
                complete:function(data){
                    // Hide image container
                    $("#orderCountryLoader").hide();
                }
            });
        }

        // Get the element with id="TopORcountrydefaultOpen" and click on it
        document.getElementById("TopORcountrydefaultOpen").click();

        function sales_by_date(evt, day , optionTitle){
            let startDate = $('.cus_start_date').val()
            let endDate = $('.cus_end_date').val()
            if(day == 'custom'){
                optionTitle = optionTitle + '('+startDate+' to '+endDate+')'
            }
            $.ajax({
                type : "POST",
                url : "{{url('sales-by-date')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "day" : day,
                    "start_date" : startDate,
                    "end_date" : endDate
                },beforeSend: function(){
                    $("#salesLoader").show();
                },
                success: function (response) {
                    // console.log(response.shopify_total_sell)
                    $('.topEightCardSaletabcontent h2.ebay').text(response.ebay_total_sell);
                    $('.topEightCardSaletabcontent h2.amazon').text(response.amazon_total_sell);
                    $('.topEightCardSaletabcontent h2.website').text(response.tbo_total_sell);
                    $('.topEightCardSaletabcontent h2.onbuy').text(response.onbuy_total_sell);
                    $('.topEightCardSaletabcontent h2.shopify').text(response.shopify_total_sell);
                    $('.topEightCardSaletabcontent h2.complete-order').text(response.complete_order_sell);
                    $('.topEightCardSaletabcontent h2.processing-order').text(response.processing_order_sell);
                    $('.topEightCardSaletabcontent h2.manual-order').text(response.manual_total_sell);
                    $('.topEightCardSaletabcontent h2.total-sales').text(response.total_sell);
                    $("#activeTopEightCard").html(optionTitle);
                },
                complete:function(data){
                    $("#salesLoader").hide();
                }
            });
        }

        function top_ordered_product(evt, day , optionTitle) {
            $.ajax({
                type : "POST",
                url : "{{url('top-ordered-product')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "day" : day
                },beforeSend: function(){
                    $("#orderProductLoader").show();
                },
                success: function (response) {
                    if(response != 'no-data') {
                        $('.orderproducttabcontent ul.list-unstyled').html(response);
                        $('#activeOrderProduct').html(optionTitle);
                    }else{
                        $('.orderproducttabcontent ul.list-unstyled').html('<div class="alert alert-danger p25 text-center">No Ordered Product Found.</div>');
                    }
                },
                complete:function(data){
                    $("#orderProductLoader").hide();
                }
            });
        }

        function top_order_category(evt, day, optionTitle){
            $("#activeOrderCategory").html(optionTitle);
            $.ajax({
                type : "POST",
                url : "{{url('top-ordered-category')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "day" : day
                },beforeSend: function(){
                    $("#orderCategoryLoader").show();
                },
                success: function (response) {
                    if(response.length > 0) {
                        var chart = am4core.create("chartdiv3", am4charts.PieChart3D);
                        chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
                        chart.data = response;
                        chart.innerRadius = am4core.percent(40);
                        chart.depth = 120;
                        chart.legend = new am4charts.Legend();
                        chart.logo.disabled = true;
                        var series = chart.series.push(new am4charts.PieSeries3D());
                        series.dataFields.value = "totalCategory";
                        series.dataFields.depthValue = "totalCategory";
                        series.dataFields.category = "category";
                        series.slices.template.cornerRadius = 5;
                        series.colors.step = 3;
                    }else{
                        $('#chartdiv3').html('<div class="alert alert-danger p25 text-center">No Ordered Category Found</div>');
                    }
                },
                complete:function(data){
                    $("#orderCategoryLoader").hide();
                }
            });
        }


        @if ($message = Session::get('response_logout_error'))
            swal("{{ $message }}", "", "warning")
        @endif
        //Page onload remove auto loader
        document.getElementById("salesLoader").style.display = "none";
        // document.getElementById("ChannelLoader").style.visibility = "hidden";
        document.getElementById("orderCountryLoader").style.display = "none";
        document.getElementById("orderProductLoader").style.display = "none";
        document.getElementById("orderCategoryLoader").style.display = "none";

    </script>





@endsection
