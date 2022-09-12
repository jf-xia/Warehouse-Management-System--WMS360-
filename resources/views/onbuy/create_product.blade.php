@extends('master')

@section('title')
    Catalogue | Active Catalogue | Add OnBuy Product | WMS360
@endsection

@section('content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">

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

    </style>

    <script>
        $(function(){
            $( ".sortable" ).sortable({
                cursor: 'move'
            });
            $( ".sortable" ).disableSelection();
        });

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


                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Active Product</li>
                            <li class="breadcrumb-item active" aria-current="page">Add OnBuy Product</li>
                        </ol>
                    </div>
                </div>


                <div id="Load" class="load" style="display: none;">
                    <div class="load__container">
                        <div class="load__animation"></div>
                        <div class="load__mask"></div>
                        <span class="load__title">Content is loading...</span>
                    </div>
                </div>

                <div class="row m-t-20 onbuy-product">
                    <div class="col-md-12">

                        <div class="card-box py-5 shadow">

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


                            <div class="container" id="product_data">
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-2">
                                        <label class="required">Profile</label>
                                    </div>
                                    <div class="col-md-10" id="product_data1">
                                        <select class="form-control select2" name="profile_id" id="profile_id" required>
                                            <option value="">Select Profile</option>
                                            @foreach($profile_lists as $key => $profile)
                                                <option value="{{$profile->id}}">
    {{--                                                @foreach(unserialize($profile->category_ids) as $category)--}}
    {{--                                                    / {{\App\OnbuyCategory::find($category)->name}}--}}
    {{--                                                @endforeach--}}
                                                    {{$profile->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
{{--                            <div class="col-md-10" id="product_data">--}}
{{--                                <select class="form-control" name="profile_id" id="profile_id" required>--}}
{{--                                    <option value="">Select Profile</option>--}}
{{--                                    @foreach($onbuy_profile as $profile)--}}
{{--                                        <option value="{{$profile->id}}">{{$profile->id}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
                            </div>


                        </div> <!--//End card-box -->

                    </div><!--//End col-md-12 -->
                </div><!--//End row -->
            </div> <!-- // End Container-fluid -->
        </div> <!-- // End Content -->
    </div> <!-- // End Contact page -->

    <script>

        // Select option dropdown
        $('.select2').select2();



        $('#profile_id').on('change',function(){
            console.log({{$id}});
            var profile_id = $('#profile_id').val();
            var catalogue_id = {{$id}};
            $.ajax({
                type: "post",
                url: "{{url('onbuy/ajax-category-child-list')}}",
                data:{
                    "_token":"{{csrf_token()}}",
                    "profile_id" : profile_id,
                    "catalogue_id" : catalogue_id
                },
                beforeSend: function (){
                    $('#ajax_loader').show();
                },
                success: function (response) {
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
                         $('#product_data').append(response);
                    console.log(response);
                    },
                    complete: function (data) {
                        $('#ajax_loader').hide();
                    }
                })
        });

    </script>

@endsection
