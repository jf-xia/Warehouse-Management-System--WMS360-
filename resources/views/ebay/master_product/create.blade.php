@extends('master')

@section('title')
    Catalogue | Active Catalogue | List On eBay | WMS360
@endsection


@section('content')
<style>
    .onoffswitch-switch{
        height: 20px;
    }
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

{{--    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.css')}}" />--}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


    <div class="content-page ebay">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <div class="screen-option">
                    <div class="d-flex justify-content-start align-items-center">
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Active Catalogue</li>
                            <li class="breadcrumb-item active" aria-current="page">List On eBay</li>
                        </ol>
                    </div>
                    <div id="secondary-input-field" onclick="secondaryInputField()" style="display: none">
                        Listing Options <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                </div>



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

                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box shadow creat-ebay-product">

                            <form role="form" target="_blank" action= {{URL::to('ebay-create-product')}} method="post" enctype="multipart/form-data">
                                @csrf
                                <div id="Load" class="load" style="display: none;">
                                    <div class="load__container">
                                        <div class="load__animation"></div>
                                        <div class="load__mask"></div>
                                        <span class="load__title">Content is loading...</span>
                                    </div>
                                </div>
                                <div class="row py-3">
                                    <div class="col-md-2 d-flex align-items-center">
                                        <div>
                                            <label for="profile" class="col-form-label required">Profile</label>
                                        </div>
                                        <div class="ml-1">
                                            <div id="wms-tooltip">
                                                <span id="wms-tooltip-text">Select the profile to list the item with predefined listing setting. You can select multiple profile to list on item in bulk.</span>
                                                <span><img style="width: 18px; height: 18px;" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: none" id="category_warning" class="alert alert-danger alert-block">
                                        <button type="button" class="close" data-dismiss="alert"></button>
                                        <strong>please select profile with same category</strong>
                                    </div>
                                    <input type="hidden" name="ebay_item_id" id="ebay_item_id" value="{{$item_id ?? ""}}">
                                    <div class="col-md-10 profileSelect2">
                                        <select id="profile_id" class="form-control select2" name="profile[]" onchange="getProfile(this.value)" multiple="multiple">
                                            <option value="-1">-</option>

                                            @if($profile_id != null)
                                                <option value="{{$profile_id}}" selected>{{$profile_N ?? ''}}</option>
                                                @foreach($same_profile_info as $single_p_name)
                                                    @if($single_p_name->id == $profile_id)

                                                    @else
                                                    <option value="{{$single_p_name->id}}" onclick="addProfileInfo()">{{$single_p_name->profile_name}}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                            @foreach($ebay_profiles as $ebay_profile)
                                                <option value="{{$ebay_profile->id}}" onclick="addProfileInfo()">{{$ebay_profile->profile_name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    {{-- <div class="col-md-1 d-flex justify-content-center align-items-center">
                                        <div id="secondary-input-field" onclick="secondaryInputField()" style="display: none">
                                            <i class="fas fa-arrow-right"></i>
                                        </div>
                                    </div> --}}
                                </div>
{{--                                <albel>Private Listing</albel>--}}
{{--                                <input type="checkbox" name="private_listing" >--}}
{{--                                <input type="hidden" name="p_id" value="{{$p_id}}">--}}
                                <input type="hidden" name="product_id" id="product_id" value="{{$id}}">
                                <input type="hidden" name="type" id="product_id" value="{{$result[0]->type}}">



                                {{--                                <div class="form-group row" id="all_category_div">--}}
                                {{--                                    <label for="Category" class="col-md-2 col-form-label required">Category</label>--}}
                                {{--                                    <div class="col-md-10 controls" id="category-level-1-group">--}}
                                {{--                                        <select class="form-control category_select select2 " name="child_cat[1]" id="child_cat_1" onchange="myFunction(1)">--}}
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

                                <div id="profile_data"></div>



                                {{--                                <div class="form-group row">--}}
                                {{--                                    <label for="description" class="col-md-2 col-form-label required">Description</label>--}}
                                {{--                                    <div class="col-md-10">--}}
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





                                {{--                                <div class="form-group row">--}}
                                {{--                                    <label for="item-description" class="col-md-2 col-form-label required">Item Description</label>--}}
                                {{--                                    <div class="col-md-10">--}}
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
                                {{--                                    <div class="col-md-10">--}}
                                {{--                                        <div class="fileupload btn btn-default waves-effect waves-light">--}}
                                {{--                                            <span><i class="ion-upload m-r-5"></i>Upload</span>--}}
                                {{--                                            <input type="file" id="imgInp" class="upload">--}}
                                {{--                                        </div>  <br>--}}
                                {{--                                        <img id="imageShow" class="img-thumbnail mt-3" src="#" alt="Images" width="150px" height="120px" style="display: none;">--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}









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
                                {{--                                                        <select class="form-control select2" name="terms[{{$attribute_term->id}}][]" multiple="multiple">--}}
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

                                <!-- <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button class="draft-pro-btn" type="submit" class="btn btn-primary waves-effect waves-light">
                                            <b> Add </b>
                                        </button>
                                    </div>
                                </div> -->

                            </form>
                            <!-- Modal HTML -->
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

                        </div>  <!-- card-box -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->





    <script>
        $('.select2').select2();
    </script>
    <!-- <script>
        $( function() {
            $( ".sortable" ).sortable({
                cursor: 'move'
            });
            $( ".sortable" ).disableSelection();
        } );
    </script> -->
    <script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
    <!--ckeditor summernote--->
    <script type="text/javascript">
        $(document).on("click", ".copyTo", function(){
            let $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(this).text()).select();
            document.execCommand("copy");
            $temp.remove();
        });
    </script>

    <script type="text/javascript">
        function Count() {
            var i = document.getElementById("name").value.length;
            document.getElementById("display").innerHTML = 'Character Remain: '+ (80 - i);
        }
    </script>


    <script>
        var counter = 0;
        var old_array = [];
        function getProfile() {

            var ebay_item_id = $('#ebay_item_id').val();
            var profile_id = $('#profile_id').val();
            if(profile_id.length !== 0){
                console.log(profile_id.length);
                var profile_array = $('#profile_id').val();
                var profile_id = profile_array[0];
                var product_id = $('#product_id').val();
                var list_array = $('#profile_id option:selected').val();
                var flag = '';
                var array3 = '';
                var grid_counter = 0;


            // var restGridDiv = $();
            // $("#profile_id option:selected").each(function (i) {
            //     var $this = $(this);
            //     if ($this.length) {
            //         var selText[i] = $this.val();
            //
            //     }
            // });

            if (profile_array.length > old_array.length){
                 array3 = profile_array.filter(function(obj) { return old_array.indexOf(obj) == -1; });
                flag = true;
                counter++;
            }else{
                console.log(array3);
                 array3 = old_array.filter(function(obj) { return profile_array.indexOf(obj) == -1; });
                flag = false;

                // $("#t"+array3[0]).remove();
                // $('#d'+array3[0]).remove();
                // $('#i'+array3[0]).remove();
                // $('#fq'+array3[0]).remove();
                // $('#sp'+array3[0]).remove();
                // $('#pName'+array3[0]).remove();
                $('.titleContent_'+array3[0]).remove();
                $('.subTitleContent_'+array3[0]).remove();
                $('.feederQtyContent_'+array3[0]).remove();
                $('.imgContent_'+array3[0]).remove();
                $('.desContent_'+array3[0]).remove();
                $('.shopCategoryContent_'+array3[0]).remove();
                $('.campaignContent_'+array3[0]).remove();
                $('.feeContent_'+array3[0]).remove();
                $('.privateListingContent_'+array3[0]).remove();
                $('.interNationalSiteVisibility_'+array3[0]).remove();
                verify(1)
                $('#imgTablist .nav-link:first, #desTablist .nav-link:first, #campTablist .nav-link:first, #feeTablist .nav-link:first, #quantityTabList .nav-link:first, #subTitleTabList .nav-link:first, #titleTabList .nav-link:first, #shopCatTablist .nav-link:first, #shopCatTablist_2 .nav-link:first, #privateTabList .nav-link:first, #internationalVisibilityTabList .nav-link:first').click();

                // console.log('remove');
                // counter--;

            }
            //console.log(array3);
            old_array = profile_array;
            //console.log($("#profile_id option:selected").val());
            // console.log(counter);
            //console.log(list_array);

        }else{
            console.log("not in");
        }

                $.ajax({
                    type: "post",
                    url: "{{url('get-profile-data')}}",
                    data: {
                        "_token": "{{csrf_token()}}",
                        "profile_id": array3[0],
                        "profile_array": profile_array,
                        "product_id": product_id,
                        "counter": counter,
                        "ebay_item_id": ebay_item_id

                    },
                    beforeSend: function (){
                        $('#ajax_loader').show();
                    },
                    success: function (response) {
                        console.log(response);

                        $('#secondary-input-field').show()

                        if (counter == 1){
                            $('#profile_data').html(response);
                        }

                        if (profile_array.length > 1 && flag && response['counter'] == 0){
                            var baseUrl = "{{asset('/')}}"
                            // console.log(response['profile'].id);
                            // console.log('flag');

                            // var nameTablist = '<li class="nav-item text-center">'+
                            //                         '<a class="nav-link" data-toggle="tab" href="#nameTabId'+response['profile'].id+'">('+response['profile'].profile_name+')</a>'+
                            //                     '</li>'
                            // var nameTab = '  <div id="nameTabId'+response['profile'].id+'" class="tab-pane active m-b-20">'+
                            //               '      <div class="onoffswitch my-3 mb-sm-10">'+
                            //               '          <input type="checkbox" value="1" name="title_flag'+response['profile'].id+'" class="onoffswitch-checkbox"  id="title_flag'+response['profile'].id+'" tabindex="1" checked>'+
                            //               '         <label class="onoffswitch-label" for="catalogue-name">'+
                            //               '              <span onclick="onOff(\'title_flag'+response['profile'].id+'\')" class="onoffswitch-inner"></span>'+
                            //               '              <span onclick="onOff(\'title_flag'+response['profile'].id+'\')" class="ebay-onoffswitch-switch"></span>'+
                            //               '          </label>'+
                            //               '      </div>'+
                            //               '      <input id="name'+response['profile'].id+'" type="text" class="form-control @error('name') is-invalid @enderror" name="name['+response['profile'].id+']" value="'+response['product_result'][0].name+'" maxlength="80" onkeyup="Count(\'name'+response['profile'].id+'\',\'display'+response['profile'].id+'\');" oninput="autoOff(\'title_flag'+response['profile'].id+'\','+response['profile'].id+');" required autocomplete="name" autofocus>'+
                            //               '      <span id="display'+response['profile'].id+'" class="float-right"></span>'+
                            //               '     @error('name')'+
                            //               '     <span class="invalid-feedback" role="alert">'+
                            //               '         <strong>{{ $message }}</strong>'+
                            //               '     </span>'+
                            //               '     @enderror'+
                            //               '  </div>'

                            // var subtitleTablist = '<li class="nav-item text-center">'+
                            //                         '<a class="nav-link" data-toggle="tab" href="#subtitleTabId'+response['profile'].id+'">('+response['profile'].profile_name+')</a>'+
                            //                       '</li>'

                            // var subtitleTab = '  <div id="subtitleTabId'+response['profile'].id+'" class="tab-pane active m-b-20">'+
                            //                   '     <input id="subtitle'+response['profile'].id+'" type="text" class="form-control @error("subtitle") is-invalid @enderror" name="subtitle['+response['profile'].id+']" value="" maxlength="80" onkeyup="verify('+response['profile'].id+')" autocomplete="name" autofocus>'+
                            //                   '     <span id="display'+response['profile'].id+'" class="float-right"></span>'+
                            //                   '     @error("subtitle")'+
                            //                   '      <span class="invalid-feedback" role="alert">'+
                            //                   '         <strong>{{ $message }}</strong>'+
                            //                   '      </span>'+
                            //                   '     @enderror'+
                            //                   ' </div>'

                            // var div_title = '<div class="form-group row" id="t'+response['profile'].id+'">'+'<label for="name" class="col-md-2 col-form-label required">Name ('+response['profile'].profile_name+')</label>\n' +
                            //     '   <div class="col-md-1">     <div class="onoffswitch">\n' +
                            //     '            <input type="checkbox" value="1" name="title_flag['+response['profile'].id+']" class="onoffswitch-checkbox" id="title_flag'+response['profile'].id+'" tabindex="1" checked>\n' +
                            //     '            <label class="onoffswitch-label" for="catalogue-name">\n' +
                            //     '                <span onclick="onOff(\'title_flag'+response['profile'].id+'\')" class="onoffswitch-inner"></span>\n' +
                            //     '                <span onclick="onOff(\'title_flag'+response['profile'].id+'\')" class="ebay-onoffswitch-switch"></span>\n' +
                            //     '            </label>\n' +
                            //     '        </div></div>'+'<div class="col-md-9">\n' +
                            //     '\n' +
                            //     '            <input id="name'+response['profile'].id+'" type="text" class="form-control @error("name") is-invalid @enderror" name="name['+response['profile'].id+']" value="'+response['product_result'][0].name+
                            //     '" maxlength="80" onkeyup="Count(\'name'+response['profile'].id+'\',\'display'+response['profile'].id+'\');" oninput="autoOff(\'title_flag'+response['profile'].id+'\','+response['profile'].id+');" required autocomplete="name" autofocus>'+
                            //     ' <span id="display'+response['profile'].id+'" class="float-right"></span>'+'@error("name")'+'<span class="invalid-feedback" role="alert">\n' +
                            //     '            <strong>{{ $message }}</strong>\n' +
                            //     '        </span>\n' +
                            //     '            @enderror\n' +
                            //     '        </div>\n' +
                            //     '    </div>'+'<div class="form-group row" id="sub'+response['profile'].id+'">\n' +
                            //     '        <label for="name"  class="col-md-2 col-form-label">Subtitle ('+response['profile'].profile_name+
                            // ') <label id="subl'+response['profile'].id+'"> </label></label><div class="col-md-9">\n' +
                            //     '\n' +
                            //     '            <input id="subtitle'+response['profile'].id+'" type="text" class="form-control"  name="subtitle['+response['profile'].id+']" value="" maxlength="80" onkeyup="verify('+response['profile'].id+')" autocomplete="name" autofocus>\n' +
                            //     '            <span id="display'+response['profile'].id+'" class="float-right"></span>\n' +
                            //     '            @error("subtitle")\n' +
                            //     '            <span class="invalid-feedback" role="alert">\n' +
                            //     '            <strong>{{ $message }}</strong>\n' +
                            //     '        </span>\n' +
                            //     '            @enderror\n' +
                            //     '        </div>\n' +
                            //     '    </div>';


                                var titleTabList = '<li class="nav-item text-center titleContent_'+response['profile'].id+'">'+
                                                    '<a class="nav-link" data-toggle="tab" href="#titleTab'+response['profile'].id+'">('+response['profile'].profile_name+')</a>'+
                                                '</li>'

                                var title_div = '<div id="titleTab'+response['profile'].id+'" class="tab-pane active titleContent_'+response['profile'].id+'">'+
                                '   <div class="row">'+
                                '        <div class="col-md-1">'+
                                '            <div class="onoffswitch my-3 mb-sm-10">'+
                                '               <input type="checkbox" value="1" name="title_flag['+response['profile'].id+']" class="onoffswitch-checkbox" id="title_flag'+response['profile'].id+'" tabindex="1" checked>' +
                                '                <label class="onoffswitch-label" for="catalogue-name">'+
                                '                <span onclick="onOff(\'title_flag'+response['profile'].id+'\')" class="onoffswitch-inner"></span>' +
                                '                <span onclick="onOff(\'title_flag'+response['profile'].id+'\')" class="ebay-onoffswitch-switch"></span>' +
                                '                </label>'+
                                '             </div>'+
                                '        </div>'+
                                '        <div class="col-md-11">'+
                                '            <div class="ml-3 my-3 ebay-title-res">'+
                                '               <input id="name'+response['profile'].id+'" type="text" class="form-control @error("name") is-invalid @enderror" name="name['+response['profile'].id+']" value="'+response['product_result'][0].name+'" maxlength="80" onkeyup="Count(\'name'+response['profile'].id+'\',\'display'+response['profile'].id+'\');" oninput="autoOff(\'title_flag'+response['profile'].id+'\','+response['profile'].id+');" required autocomplete="name" autofocus>'+
                                '               <span id="display'+response['profile'].id+'" class="float-right"></span>'+'@error("name")'+'<span class="invalid-feedback" role="alert">\n' +
                                '               <strong>{{ $message }}</strong>\n' +
                                '               </span>\n' +
                                '               @enderror\n' +
                                '           </div>'+
                                '        </div>'+
                                '    </div>'+
                                '</div>';

                                var subTitleTabList = '<li class="nav-item text-center subTitleContent_'+response['profile'].id+'">'+
                                                            '<a class="nav-link" data-toggle="tab" href="#subTitleTab'+response['profile'].id+'">('+response['profile'].profile_name+')<label id="subl'+response['profile'].id+'"></label></a>'+
                                                      '</li>'

                                var subTitleTab = '<div id="subTitleTab'+response['profile'].id+'" class="tab-pane active subTitleContent_'+response['profile'].id+'">'+
                                                  '     <input id="subtitle'+response['profile'].id+'" type="text" class="form-control"  name="subtitle['+response['profile'].id+']" value="" maxlength="80" autocomplete="name" autofocus>\n' +
                                                  '     <span id="display'+response['profile'].id+'" class="float-right"></span>\n' +
                                                  '      @error("subtitle")\n' +
                                                  '      <span class="invalid-feedback" role="alert">\n' +
                                                  '      <strong>{{ $message }}</strong>\n' +
                                                  '      </span>\n' +
                                                  '      @enderror\n' +
                                                  '  </div>';



                                var desTablist = '<li class="nav-item text-center desContent_'+response['profile'].id+'">'+
                                                    '<a class="nav-link" data-toggle="tab" href="#descriptionTab'+response['profile'].id+'">('+response['profile'].profile_name+')</a>'+
                                                '</li>'

                                var description_div = '       <div id="descriptionTab'+response['profile'].id+'" class="tab-pane active desContent_'+response['profile'].id+'">'+
                                    '            <div class="onoffswitch mb-3 mb-sm-10">\n' +
                                    '               <input type="checkbox" value="1" name="description_flag['+response['profile'].id+']" class="onoffswitch-checkbox" id="description_flag'+response['profile'].id+'" tabindex="1" checked>\n' +
                                    '               <label class="onoffswitch-label" for="description_flag">\n' +
                                    '                   <span onclick="onOff(\'description_flag'+response['profile'].id+'\')" class="onoffswitch-inner"></span>\n' +
                                    '                   <span onclick="onOff(\'description_flag'+response['profile'].id+'\')" class="ebay-onoffswitch-switch"></span>\n' +
                                    '               </label>\n' +
                                    '            </div>'+
                                    '            <textarea id="messageArea'+response['profile'].id+'"  name="description['+response['profile'].id+']" rows="10" cols="30" oninput="autoOff(\'description_flag'+response['profile'].id+'\','+response['profile'].id+');" required autofocus>'+response['product_result'][0].description+'</textarea>\n' +
                                    '            @error("description")\n' +
                                    '            <span class="invalid-feedback" role="alert">\n' +
                                    '               <strong>{{ $message }}</strong>\n' +
                                    '            </span>\n' +
                                    '            @enderror\n' +
                                    '        </div>'

                                    var quantityTabList =  '<li class="nav-item text-center feederQtyContent_'+response['profile'].id+'">'+
                                                                '<a class="nav-link" data-toggle="tab" href="#feederQuantityTab'+response['profile'].id+'">('+response['profile'].profile_name+')</a>'+
                                                            '</li>'

                                    var feeder_quantity = '  <div id="feederQuantityTab'+response['profile'].id+'" class="tab-pane active feederQtyContent_'+response['profile'].id+'">'+
                                            '           <div class="feederQtyDivInner">'+
                                            '               <div class="onoffswitch my-3 mb-sm-10">'+
                                            '                   <input type="checkbox" value="1" name="custom_feeder_flag['+response['profile'].id+']" class="onoffswitch-checkbox"  id="custom_feeder_flag'+response['profile'].id+'" tabindex="1" checked>'+
                                            '                   <label class="onoffswitch-label" for="catalogue-name">'+
                                            '                   <span onclick="onOff(\'custom_feeder_flag'+response['profile'].id+'\')" class="onoffswitch-inner"></span>'+
                                            '                   <span onclick="onOff(\'custom_feeder_flag'+response['profile'].id+'\')" class="ebay-onoffswitch-switch"></span>'+
                                            '                   </label>'+
                                            '               </div>'+
                                            '              <div class="ml-3 my-3 ebay-qty-input">'+
                                            // '                  <input id="custom_feeder_quantity'+response['profile'].id+'" type="number" class="form-control @error("feeder_quantity") is-invalid @enderror" name="custom_feeder_quantity['+response['profile'].id+']" value="'+(response['feeder_quantity'] = response['feeder_quantity'] || 0)+'" maxlength="80" oninput="autoOff(\'custom_feeder_flag'+response['profile'].id+'\','+response['profile'].id+');" required autocomplete="custom_feeder_quantity" autofocus>'+
                                            '                  <input id="custom_feeder_quantity'+response['profile'].id+'" type="number" class="form-control @error("feeder_quantity") is-invalid @enderror" name="custom_feeder_quantity['+response['profile'].id+']" value="'+(response['feeder_quantity'] = response['feeder_quantity'] || 0)+'" maxlength="80" oninput="feederQuantity('+response['profile'].id+');" required autocomplete="custom_feeder_quantity" autofocus>'+
                                            '                     <span id="custom_feeder_quantity'+response['profile'].id+'" class="float-right"></span>' +
                                            '                  @error("custom_feeder_quantity")'+
                                            '                 <span class="invalid-feedback" role="alert">'+
                                            '                     <strong>{{ $message }}</strong>'+
                                            '                 </span>'+
                                            '                 @enderror'+
                                            '              </div>'+
                                            '          </div>'+
                                            '      </div>';


                            // var private_listing = '<div class="form-group row"> <label for="condition" class="col-md-2 col-form-label">Private Listing ('+response['profile'].profile_name+')</label>' +
                            //     '<div class="col-md-10 wow pulse"><input type="checkbox" name="private_listing['+response['profile'].id+']" value="1">' +
                            //     '</div></div>'

                            var private_listing = '<div id="privateTab'+response['profile'].id+'" class="tab-pane active privateListingContent_'+response['profile'].id+'">'+
                                                  '     <div class="custom-control custom-checkbox">'+
                                                  '          <input type="checkbox" name="private_listing['+response['profile'].id+']" value="1" class="custom-control-input private_listing" id="private_listing'+response['profile'].id+'">'+
                                                  '          <label class="custom-control-label" for="private_listing'+response['profile'].id+'"> </label>'+
                                                  '      </div>'+
                                                  ' </div>'


                            //         var int_site_visibility = '<div class="form-group row"> <div class="col-md-2 d-flex align-items-center"> <div> <label for="condition_id" class="col-form-label">International Site Visibility ('+response['profile'].profile_name+
                            //             ')</label> </div> <div class="ml-1"> <div id="wms-tooltip"><span id="wms-tooltip-text">Select an additional eBay site where you\'d like this listing to appear</span><span><img style="width: 18px; height: 18px;" src="{{asset("assets/common-assets/tooltip_button.png")}}"></span> </div> </div> </div>'+
                            // '<div class="col-md-10 wow pulse"> <select name="cross_border_trade['+response['profile'].id+']" class="form-control" id="condition-select"> <option value="None" selected>-</option> <option value="North America" >eBay US and Canada</option> </select>'+
                            //             '</div> </div>'

                            var int_site_visibility = '<div id="internationalVisibilityTab'+response['profile'].id+'" class="tab-pane active interNationalSiteVisibility_'+response['profile'].id+'">'+
                                                      '     <select name="cross_border_trade['+response['profile'].id+']" class="form-control" id="condition-select">'+
                                                      '          <option value="None" selected>-</option>'+
                                                      '          <option value="North America" >eBay US and Canada</option>'+
                                                      '      </select>'+
                                                      '  </div>'


                            var image = '<ul class="d-flex flex-wrap sortable ebay-image-wrap create-ebay-image-wrap" id="sortableImageDiv'+response['profile'].id+'">';

                            response['product_result'][0].images.forEach(function (array, index) {
                                var projectUrl = array['image_url'].includes('https') ? '' : baseUrl
                                image += '<li class="drag-drop-image active" id="drag-drop-image'+response['profile'].id+'">\n' +
                                    '            <a class="cross-icon bg-white border-0 btn-outline-light" id="'+projectUrl+array['image_url']+'" onclick="removeLi(this)">&#10060;</a>\n'+
                                    '            <input type="hidden" id="image'+response['profile'].id+'" name="newUploadImage['+response['profile'].id+'][]" value="'+projectUrl+array['image_url']+'">\n'+
                                    '            <span class="main_photo"></span>\n'+
                                    '            <img class="create_drag_drop_image" id="drag_drop_image'+response['profile'].id+'" src="'+projectUrl+array['image_url']+'">\n'+
                                    '            <p class="drag_and_drop hide" id="drag_and_drop_'+response['profile'].id+'"></p>\n'+
                                    '      </li>';

                                    grid_counter++;

                            });

                            if(grid_counter < 12){
                                image += '<div class="drag-drop-image add-photos-content" id="addPhotosContent'+response['profile'].id+'">'+
                                    '   <p style="opacity: 100" class="inner-add-sign" id="innerAddSign'+response['profile'].id+'">&#43;</p>'+
                                    '   <input style="opacity: 100" type="file" title=" " name="uploadImage['+response['profile'].id+'][]" id="uploadImage'+response['profile'].id+'" class="form-control create-ebay-img-upload" accept="/image" onchange="preview_image('+response['profile'].id+');" multiple>'+
                                    '   <p style="opacity: 100" class="inner-add-photo" id="innerAddPhoto'+response['profile'].id+'">Add Photos</p>'+
                                    '</div>'
                            }


                            for(var i=0; i<(11-grid_counter); i++){
                                image += '<div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent'+response['profile'].id+'">'+
                                        '   <p class="inner-add-sign" id="innerAddSign'+response['profile'].id+'">&#43;</p>'+
                                        '   <input type="file" title=" " name="uploadImage['+response['profile'].id+'][]" id="uploadImage'+response['profile'].id+'" class="form-control create-ebay-img-upload" accept="/image" onchange="preview_image('+response['profile'].id+');" multiple disabled>'+
                                        '   <p class="inner-add-photo" id="innerAddPhoto'+response['profile'].id+'">Add Photos</p>'+
                                        '</div>'
                                }

                                image += '</ul>';
                                var projectUrl = response['product_result'][0].images[0]['image_url'].includes('https') ? '' : baseUrl
                                var image_div = '<div id="ebay_multiple_pro_up'+response['profile'].id+'" class="tab-pane active imgContent_'+response['profile'].id+'">\n'+
                                        '           <div class="d-flex mb-3">\n'+
                                        '               <div class="onoffswitch mb-sm-10">\n'+
                                        '                   <input type="checkbox" value="1" name="image_flag['+response['profile'].id+']" class="onoffswitch-checkbox" id="image_flag'+response['profile'].id+'" tabindex="1" checked>\n'+
                                        '                       <label class="onoffswitch-label" for="catalogue-name">\n'+
                                        '                       <span onclick="onOff(\'image_flag'+response['profile'].id+'\')" class="onoffswitch-inner"></span>\n'+
                                        '                       <span onclick="onOff(\'image_flag'+response['profile'].id+'\')" class="ebay-onoffswitch-switch"></span>\n'+
                                        '                   </label>\n'+
                                        '               </div>\n'+
                                        '           <div id="counter'+response['profile'].id+'" class="mt-2 ml-2 ajax_counter">'+(response['product_result'][0].images.length === 12 ? 'Photo limit reached' : '')+'</div>\n'+
                                        '           <div id="counter'+response['profile'].id+'" class="mt-2 ml-2 ajax_counter">'+(response['product_result'][0].images.length === 0 ? 'We recommend adding 3 more photos' : '')+'</div>\n'+
                                        '           <div id="counter'+response['profile'].id+'" class="mt-2 ml-2 ajax_counter">'+(response['product_result'][0].images.length === 1 ? 'We recommend adding 2 more photos' : '')+'</div>\n'+
                                        '           <div id="counter'+response['profile'].id+'" class="mt-2 ml-2 ajax_counter">'+(response['product_result'][0].images.length === 2 ? 'We recommend adding 1 more photo' : '')+'</div>\n'+
                                        '           <div id="counter'+response['profile'].id+'" class="mt-2 ml-2 ajax_counter">'+(response['product_result'][0].images.length === 3 ? 'Add up to 9 more photos' : '')+'</div>\n'+
                                        '           <div id="counter'+response['profile'].id+'" class="mt-2 ml-2 ajax_counter">'+(response['product_result'][0].images.length === 4 ? 'Add up to 8 more photos' : '')+'</div>\n'+
                                        '           <div id="counter'+response['profile'].id+'" class="mt-2 ml-2 ajax_counter">'+(response['product_result'][0].images.length === 5 ? 'Add up to 7 more photos' : '')+'</div>\n'+
                                        '           <div id="counter'+response['profile'].id+'" class="mt-2 ml-2 ajax_counter">'+(response['product_result'][0].images.length === 6 ? 'Add up to 6 more photos' : '')+'</div>\n'+
                                        '           <div id="counter'+response['profile'].id+'" class="mt-2 ml-2 ajax_counter">'+(response['product_result'][0].images.length === 7 ? 'Add up to 5 more photos' : '')+'</div>\n'+
                                        '           <div id="counter'+response['profile'].id+'" class="mt-2 ml-2 ajax_counter">'+(response['product_result'][0].images.length === 8 ? 'Add up to 4 more photos' : '')+'</div>\n'+
                                        '           <div id="counter'+response['profile'].id+'" class="mt-2 ml-2 ajax_counter">'+(response['product_result'][0].images.length === 9 ? 'Add up to 3 more photos' : '')+'</div>\n'+
                                        '           <div id="counter'+response['profile'].id+'" class="mt-2 ml-2 ajax_counter">'+(response['product_result'][0].images.length === 10 ? 'Add up to 2 more photos' : '')+'</div>\n'+
                                        '           <div id="counter'+response['profile'].id+'" class="mt-2 ml-2 ajax_counter">'+(response['product_result'][0].images.length === 11 ? 'Add up to 1 more photos' : '')+'</div>\n'+
                                        '        </div>\n'+

                                        '           <div class="row pl-2 ebay-glsm">\n'+
                                        '               <div class="col-md-6 main-lf-image-content">\n'+
                                        '                   <div class="main_image_show" id="main-lf-image-content_'+response['profile'].id+'">\n'+
                                        '                       <span class="prev hide">Prev</span>\n'+
                                        '                       <div class="md-trigger hide" data-modal="modal-12">Click to enlarge</div>\n'+
                                        '                       <div style="display: block !important;" class="showimagediv create-ebay-showimagediv" id="showimagediv'+response['profile'].id+'"><img src="'+projectUrl+response['product_result'][0].images[0]['image_url']+'" class="fullImage"></div>\n'+
                                        '                       <span class="next hide">Next</span>\n'+
                                        '                    </div>\n'+
                                        '                </div>\n'+
                                        '                <div class="col-md-6 master-pro-img" style="padding:0;" id="imageProId_'+response['profile'].id+'">'+image+'</div>\n'+
                                        '            </div>\n'+
                                        '            @error('ean')\n'+
                                        '            <span class="invalid-feedback" role="alert">\n'+
                                        '               <strong>{{ $message }}</strong>\n'+
                                        '            </span>\n'+
                                        '            @enderror\n'+
                                        '            <div class="row">\n'+
                                        '                <div class="col-md-10">'+
                                        '                   <div class="custom-control custom-checkbox d-flex align-items-center">'+
                                        '                       <input type="checkbox" class="custom-control-input galleryPlus" name="galleryPlus['+response['profile'].id+']" value="1" id="galleryPlus-'+response['profile'].id+'" '+( response['profile']['galleryPlus'] ? 'checked' : '')+'>'+
                                        '                       <strong>  Display a large photo in search results with Gallery Plus <span id="productImg'+response['profile'].id+'"></span> <span id="imgfees'+response['profile'].id+'">(fees may apply)</span></strong>'+
                                        '                       <label class="custom-control-label" for="galleryPlus-'+response['profile'].id+'"> </label>'+
                                        '                   </div>'+
                                        '                </div>'+
                                        // '                <div class="col-md-10">\n'+
                                        // '                <input type="checkbox" name="galleryPlus['+response['profile'].id+']" onclick="verify('+response['profile'].id+')" value="1"'+( response['profile']['galleryPlus'] ? 'checked' : '')+'><strong>  Display a large photo in search results with Gallery Plus(fees may apply)</strong>\n'+
                                        // '                </div>\n'
                                        '            </div>\n'+
                                        '\n' +
                                        '        </div>'


                                        var imgTablist =   '<li class="nav-item text-center imgContent_'+response['profile'].id+'">'+
                                                            '<a class="nav-link" data-toggle="tab" href="#ebay_multiple_pro_up'+response['profile'].id+'">'+response['profile'].profile_name+'<span class="ml-1" id="default_counter'+response['profile'].id+'">('+response['product_result'][0].images.length+')</span></a>'+
                                                        '</li>'




                            var profile_total = '       <div id="totalFee'+response['profile'].id+'" class="tab-pane active feeContent_'+response['profile'].id+'">'+
                                '           <div id="pName'+response['profile'].id+'" class="col-md-10 d-flex align-items-center">\n' +
                                '               <div class="mt-3 mb-3"><strong>Check Verify</strong></div>\n' +
                                '           </div>' +
                                '       </div>'

                            var feeTablist = '<li class="nav-item text-center feeContent_'+response['profile'].id+'">'+
                                                '<a class="nav-link" data-toggle="tab" href="#totalFee'+response['profile'].id+'">'+response['profile'].profile_name+'</a>'+
                                            '</li>'

                            var campaign = '        <div id="ebay_camp'+response['profile'].id+'" class="tab-pane active campaignContent_'+response['profile'].id+'">'+
                                '            <div class="card px-3 py-3">\n' +
                                '                <div class="d-flex">\n' +
                                '                    <div class="custom-control custom-checkbox">\n' +
                                '                        <input name="campaign_checkbox['+response['profile'].id+']" type="checkbox" class="custom-control-input campaign_checkbox"  id="campaign_checkbox'+response['profile'].id+'">\n' +
                                '                        <label class="custom-control-label" onclick="campaignChecked(this)" id="'+response['profile'].id+'" for="campaign_checkbox"> </label>\n' +
                                '                    </div>\n' +
                                '                    <div>\n' +
                                '                        <p class="font-16">Boost your item\'s visibility with premium placements on eBay and pay only if your item sells.<a href="#" class="ml-1 text-decoration">Learn more</a></p>\n' +
                                '                    </div>\n' +
                                '                </div>\n' +
                                '                <div class="d-flex align-items-center my-3">\n' +
                                '                    <div>\n' +
                                '                        <p class="font-16 mr-2">Set ad rate</p>\n' +
                                '                    </div>\n' +
                                '                    <div id="wms-tooltip">'+
                                '                        <span id="wms-tooltip-text">'+
                                '                            Ad rate is the percentage of your final sale price that you’ll pay if your item sells via promoted listings within 30 days of a click on your ad. <b>Suggested ad rates</b> are tailored to each of your listings and designed to help you find the balance between cost and performance.'+
                                '                        </span>'+
                                '                       <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>'+
                                '                   </div>'+
                                // '                    <div>\n' +
                                // '                        <a data-toggle="tooltip" data-placement="top" title="Set Ad Rate">\n' +
                                // '                            <img style="width: 25px; height: 25px;" src="{{asset("assets/common-assets/tooltip_button.png")}}">\n' +
                                // '                        </a>\n' +
                                // '                    </div>\n' +
                                '                </div>\n' +
                                '                <div class="row content_disabled" id="div_disable'+response['profile'].id+'">\n' +
                                '                    <div class="col-md-4">\n' +
                                '                        <div class="mb-3">'+
                                '                           <p class="'+response['profile'].id+'">\n' +
                                '                               <img style="cursor: pointer; width: 30px; height: 30px" src="{{asset("assets/common-assets/MINUS.png")}}" class="minus mb-1">\n' +
                                '                               <input type="text" size="3" name="bid_rate['+response['profile'].id+']" class="qty items_number" value="0.0"> %\n' +
                                '                               <img style="cursor: pointer; width: 30px; height: 30px" src="{{asset("assets/common-assets/PLUS.png")}}" class="plus mb-1">\n' +
                                '                           </p>\n'+
                                '                        </div>'

                                if (typeof response['campaigns']['campaigns'] !== 'undefined'){
                                    campaign += '<select name="campaign_id['+response['profile'].id+']" class="form-control select2 mt-2">'
                                    response['campaigns']['campaigns'].forEach(function (array, index) {
                                        if (array.campaignName == "Default campaign"){
                                            campaign += '<option value="'+array.campaignId+'" data-campaign="" selected>'+array.campaignName+'</option>'
                                        }else {
                                            campaign += '<option value="'+array.campaignId+'" data-campaign="">'+array.campaignName+'</option>'
                                        }

                                    });
                                    campaign += '</select>'
                                }


                                campaign +='                    </div>\n' +
                                    '                    <div class="col-md-1">\n' +
                                    '                        <div class="vl"></div>\n' +
                                    '                    </div>\n' +
                                    '                    <div class="col-md-7">\n' +
                                    '                        <p><b><span id="display_max_min_percentage'+response['profile'].id+'">£0.00 - £0.00</span></b></p>\n' +
                                    '                        <p>(<span id="display_max_min_vat_percentage'+response['profile'].id+'">£0.00 - £0.00</span> inclusive of VAT, if applicable)</p>\n' +
                                    '                        <p>Ad fee if this item sells through promoted listings</p>\n' +
                                    '                    </div>\n' +
                                    '                </div>\n' +
                                    '           </div>'
                                    // '            </div>\n'
                                    // '        </div>\n' +
                                    // '    </div>'


                            var campTablist = '     <li class="nav-item text-center campaignContent_'+response['profile'].id+'">'+
                                              '         <a class="nav-link" data-toggle="tab" href="#ebay_camp'+response['profile'].id+'">('+response['profile'].profile_name+')</a>'+
                                              '     </li>'

                            var shopCatTablist = '     <li class="nav-item text-center shopCategoryContent_'+response['profile'].id+'">'+
                                                 '         <a class="nav-link" data-toggle="tab" href="#shopCatTabId'+response['profile'].id+'">('+response['profile'].profile_name+')</a>'+
                                                 '     </li>'

                            var shopCatTablist_2 = '     <li class="nav-item text-center">'+
                                                   '         <a class="nav-link" data-toggle="tab" href="#shopCatTabId_2'+response['profile'].id+'">('+response['profile'].profile_name+')</a>'+
                                                   '     </li>'

                            var privateListingTabList = '<li class="nav-item text-center privateListingContent_'+response['profile'].id+'">'+
                                                        '    <a class="nav-link" data-toggle="tab" href="#privateTab'+response['profile'].id+'">('+response['profile'].profile_name+')<label id="privateListing'+response['profile'].id+'"></label></a>'+
                                                        '</li>'

                            var internationalVisibilityTabList = '<li class="nav-item text-center interNationalSiteVisibility_'+response['profile'].id+'">'+
                                                                '    <a class="nav-link" data-toggle="tab" href="#internationalVisibilityTab'+response['profile'].id+'">('+response['profile'].profile_name+')<label id="intSiteVisibility'+response['profile'].id+'"></label></a>'+
                                                                '</li>'

                            // $("#nameTablist").append(nameTablist);
                            // $("#nameTab").append(nameTab);
                            // $("#title_div").append(div_title);
                            // $("#subtitleTablist").append(subtitleTablist);
                            // $("#subtitleTab").append(subtitleTab);
                            $("#titleTabList").append(titleTabList);
                            $("#title_div").append(title_div);
                            $("#subTitleTabList").append(subTitleTabList);
                            $("#subtitle_div").append(subTitleTab);
                            $("#description_div").append(description_div);
                            $("#image_div").append(image_div);
                            $("#quantity_div").append(feeder_quantity);
                            $("#shopCatTablist").append(shopCatTablist);
                            $("#shopCatTablist_2").append(shopCatTablist_2);
                            $("#privateListingDiv").append(private_listing);
                            $("#internationalVisibilityDiv").append(int_site_visibility);
                            $("#shopCatTab").append(response['store_one']);
                            // $("#shopCatTab_2").append(response['store_two']);
                            $("#profile_total").append(profile_total);
                            $("#campaign").append(campaign);
                            $("#imgTablist").append(imgTablist);
                            $("#desTablist").append(desTablist);
                            $("#campTablist").append(campTablist);
                            $("#feeTablist").append(feeTablist);
                            $("#quantityTabList").append(quantityTabList);
                            $('#privateTabList').append(privateListingTabList);
                            $('#internationalVisibilityTabList').append(internationalVisibilityTabList);

                            $( ".creat-ebay-product .ebay-image-wrap" ).sortable({
                                revert: true,
                                update: function( event, ui ) {
                                    var id = $(this).closest('div').attr('id').split('_')[1]
                                    console.log(id)
                                    $('input#image_flag'+id).prop('checked', false)
                                    document.getElementById('image_flag'+id).value = 0;
                                }
                            });
                            $( ".creat-ebay-product .ebay-image-wrap" ).disableSelection();

                            $('#imgTablist .nav-link:last, #desTablist .nav-link:last, #campTablist .nav-link:last, #feeTablist .nav-link:last, #quantityTabList .nav-link:last, #subTitleTabList .nav-link:last, #titleTabList .nav-link:last, #shopCatTablist .nav-link:last, #shopCatTablist_2 .nav-link:last, #privateTabList .nav-link:last, #internationalVisibilityTabList .nav-link:last').click();
                            $('#imgTablist .nav-link:first, #desTablist .nav-link:first, #campTablist .nav-link:first, #feeTablist .nav-link:first, #quantityTabList .nav-link:first, #subTitleTabList .nav-link:first, #titleTabList .nav-link:first, #shopCatTablist .nav-link:first, #shopCatTablist_2 .nav-link:first, #privateTabList .nav-link:first, #internationalVisibilityTabList .nav-link:first').click();

                        }

                        if(response['counter'] > 0){
                            $("#category_warning").show();
                            setInterval(function (){
                                $("#category_warning").hide();
                            },5000);
                            $('#ajax_loader').hide();
                        }
                        $('.select2').select2();
                        // counter++;

                        $(".ebay-variation-card:last").removeClass('mb-3')

                    },
                    complete: function (data) {
                        profile_array.forEach(function (array,index) {
                            CKEDITOR.replace( 'messageArea'+array,
                                {
                                    customConfig : 'config.js',
                                    toolbar : 'simple'
                                })
                        })


                        $('#ajax_loader').hide();
                    }
                });



        }
        $('#profile_id').on('click',function (e){
            console.log('test');
        })
        function store(){

        }

        function verify(profileId){
            // console.log("console test")
            var profile_id = profileId
            var queryString = $('form').serialize();

            // console.log(queryString)

            $.ajax({
                url: "{{url("verify-ebay-product")}}"+'/'+profile_id,
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
                    console.log(response)
                    if(typeof response.fees !== 'undefined'){
                        for (const [key, value] of Object.entries(response.fees)) {
                            // document.getElementById("subl"+key).innerText = "fee("+value[0][19]['Fee']+")";
                            if(typeof value[0][19] !== 'undefined'){
                                $('#subl'+key).text("fee("+value[0][19]['Fee']+")")
                            }
                            if(typeof value[0][5] !== 'undefined'){
                                $('#productImg'+key).text("fee("+value[0][5]['Fee']+")")
                                $('#imgfees'+key).hide()
                            }
                            if(typeof value[0][27] !== 'undefined'){
                                $('#intSiteVisibility'+key).text("fee("+value[0][27]['Fee']+")")
                            }
                            if(typeof value[0][24] !== 'undefined'){
                                $('#privateListing'+key).text("fee("+value[0][24]['Fee']+")")
                            }
                            // $('#subl'+key).text("fee("+value[0][19]['Fee']+")")
                            // $('#productImg'+key).text("fee("+value[0][5]['Fee']+")")
                            // $('#intSiteVisibility'+key).text("fee("+value[0][27]['Fee']+")")
                            // $('#privateListing'+key).text("fee("+value[0][24]['Fee']+")")

                            // console.log("key"+key)


                            if(typeof value[0][14]['PromotionalDiscount'] !== 'undefined'){
                                total_fees += parseFloat(value[0][14]['Fee']).toPrecision(3) - parseFloat(value[0][14]['PromotionalDiscount']).toPrecision(3)
                                document.getElementById("pName"+key).innerText = (parseFloat(value[0][14]['Fee']) - parseFloat(value[0][14]['PromotionalDiscount'])).toPrecision(3);
                            }else{
                                total_fees += parseFloat(value[0][14]['Fee']).toPrecision(3)
                                document.getElementById("pName"+key).innerText = parseFloat(value[0][14]['Fee']).toPrecision(3)
                            }

                            // console.log(key, value[0][19]['Name']);

                            // for (const [key1, value1] of Object.entries(value[0])) {
                            //     // total_fees += value1['Fee']
                            //
                            //     // console.log(key1, value1);
                            //     //     // for (const [key2, value2] of Object.entries(value1)) {
                            //     //     //
                            //     //     //     if (value2['Name'] = 'SubtitleFee'){
                            //     //     //         console.log(key, value2);
                            //     //     //         document.getElementById("subl"+key).innerText = "("+value2.Fee+")";
                            //     //     //     }
                            //     //     //
                            //     //     // }
                            //     //
                            // }

                        }
                        // console.log(total_fees)
                        document.getElementById("totalFees").innerText = "£ "+ total_fees.toPrecision(3)
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

                    // console.log(key1, value1);

                    //response.fees.forEach(myFunction);

                    // function myFunction(item, index) {
                    //     // document.getElementById("demo").innerHTML += index + ":" + item + "<br>";
                    //     // console.log(index,item)
                    //     // console.log(item.Name)
                    //     item.forEach(myFunction2);
                    //
                    //     function myFunction2(item2, index2) {
                    //         // document.getElementById("demo").innerHTML += index + ":" + item + "<br>";
                    //         // console.log(index,item)
                    //         // console.log(item.Name)
                    //         total_fees +=  parseFloat(item2.Fee)
                    //         document.getElementById("subl"+index2).innerText = total_fees;
                    //
                    //
                    //     }
                    //
                    // }
                    // console.log(total_fees);
                    // document.getElementById("subl"+response.profile_id).innerText = "(2.4)";
                },
                complete: function (data){
                    $('#ajax_loader').hide();
                }
            })
        }

        function myFunction2(id,profileId,remove = 0) {
            console.log(profileId);

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
                    // verify(profileId)
                    if(response.data == 1) {
                        console.log(response.content);
                        console.log(response.lavel);
                        if (remove == 'remove'){
                            $('#category2-level-' + 0 + '-group').nextAll().remove();
                        }else{
                            $('#category2-level-' + response.lavel + '-group').nextAll().remove();
                        }
                        $('div.create-ebay-close-btn').show()
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
        //         verify(1)
        //     }
        // });

    </script>

    <script type="text/javascript">
        function addProfileInfo(){
            console.log('test');
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


        $(document).on("click", ".plus", function(){
            var qty = $(this).closest('p').find('.qty');
            var profileId = $(this).closest('p').attr('class');
            // console.log('2nd profile id '+profileId)
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
                $("#display_max_min_percentage"+profileId).text('£'+ lsum.toFixed(2) + ' - ' + '£' + hsum.toFixed(2));
                $('#display_max_min_vat_percentage'+profileId).text('£'+ (((lsum*20)/100)+lsum).toFixed(2) + ' - ' + '£' + (((hsum*20)/100)+hsum).toFixed(2));
            }
            if(currentVal >= 100){
               Swal.fire('Oops..','Do not type more than 100','warning')
                return false
            }
        });
        $(document).on("click", ".minus", function(){
            var qty = $(this).closest('p').find('.qty');
            var profileId = $(this).closest('p').attr('class');
            // console.log('2nd profile id '+profileId)
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
                $('#display_max_min_percentage'+profileId).text('£'+ lsum.toFixed(2) + ' - ' + '£' + hsum.toFixed(2));
                $('#display_max_min_vat_percentage'+profileId).text('£'+ (((lsum*20)/100)+lsum).toFixed(2) + ' - ' + '£' + (((hsum*20)/100)+hsum).toFixed(2));
            }
            if(currentVal <= 0){
                Swal.fire('Oops..','Do not type less than 0','warning')
                return false
            }
        });
        $(document).on("keyup", ".items_number", function(){
            var profileId = $(this).closest('p').attr('class')
            console.log('2nd profile id '+profileId)
            var on_input_value = $(this).closest('p').find('input.items_number').val();
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
            $('#display_max_min_percentage'+profileId).text('£'+ lsum.toFixed(2) + ' - ' + '£' + hsum.toFixed(2));
            $('#display_max_min_vat_percentage'+profileId).text('£'+ (((lsum*20)/100)+lsum).toFixed(2) + ' - ' + '£' + (((hsum*20)/100)+hsum).toFixed(2));
        });


        $(document).on('click', '.cross-icon', function(){
            $('div.ajax_counter:gt(0)').hide()
        })

        $(document).ready(function(){
            getProfile();
            var imgProId = $('.cross-icon').closest('div').attr('id').split('_')[1];
            $('#uploadImage'+imgProId).first().closest('div').removeClass('no-img-content');
        })

        function secondaryInputField(){
            $(".ebay-secondary-input-drawer-box").show(500)
        }

        function ebayDrawerBoxCloseBtn(){
            $('.ebay-secondary-input-drawer-box').hide(500)
        }

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

        $('.profileSelect2 .select2').select2({
            placeholder: {
                text: 'Select Profile'
            }
        })

    </script>


@endsection
