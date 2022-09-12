
@extends('master')
@section('title')
    Onbuy | Brand List | WMS360
@endsection
@section('content')
    <!-- Custombox -->
    <link href="{{asset('assets/plugins/custombox/css/custombox.css')}}" rel="stylesheet">
    <!-- Modal-Effect -->
    <script src="{{asset('assets/plugins/custombox/js/custombox.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custombox/js/legacy.min.js')}}"></script>
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                <input type="hidden" id="firstKey" value="onbuy">
                <input type="hidden" id="secondKey" value="onbuy_brand_list">
                <!----END ON OFF SWITCH ARRAY KEY DECLARATION---->


                <!--screen option-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box screen-option-content" style="display: none">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div><p class="pagination"><b>Pagination</b></p></div>
                                    <ul class="column-display d-flex align-items-center">
                                        <li>Number of items per page</li>
                                        <li><input type="number" class="pagination-count" value="{{$pagination ?? 0}}"></li>
                                    </ul>
                                    <span class="pagination-mgs-show text-success"></span>
                                    <div class="submit">
                                        <input type="submit" class="btn submit-btn attr-cat-btn pagination-apply" value="Apply">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--//screen option-->


                <div class="screen-option">
                    <div class="d-flex justify-content-start align-items-center">
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item"> Onbuy </li>
                            <li class="breadcrumb-item active" aria-current="page"> Brand List</li>
                        </ol>
                    </div>
                    <div class="screen-option-btn">
                        <button class="btn btn-link waves-effect waves-light" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Screen Options &nbsp; <i class="fa" aria-hidden="true"></i>
                        </button>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion"></div>
                    </div>
                </div>

                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box table-responsive shadow">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {!! Session::get('success') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (Session::has('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {!! Session::get('error') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between product-inner p-b-10">
                                <div class="row-wise-search search-terms">
                                    <input class="form-control mb-1" id="row-wise-search" type="text" placeholder="Search....">
                                    <span id="pagination-area"></span>
                                    <button class="brand-field-show btn btn-success" type="button">Add Brand</button>
                                </div>
                                <div class="pagination-area mt-xs-10 mb-xs-5">
                                    <form action="{{url('pagination-all')}}" method="post">
                                        @csrf
                                        <div class="datatable-pages d-flex align-items-center">
                                            <span class="displaying-num">{{$brands->total()}} items</span>
                                            <span class="pagination-links d-flex">
                                                @if($brands->currentPage() > 1)
                                                <a class="first-page btn {{$brands->currentPage() > 1 ? '' : 'disable'}}" href="{{$decodeBrand->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                    <span class="screen-reader-text d-none">First page</span>
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                                <a class="prev-page btn {{$brands->currentPage() > 1 ? '' : 'disable'}}" href="{{$decodeBrand->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                    <span class="screen-reader-text d-none">Previous page</span>
                                                    <span aria-hidden="true">‹</span>
                                                </a>
                                                @endif
                                                <span class="paging-input d-flex align-items-center">
                                                    <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                    <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$decodeBrand->current_page}}" size="3" aria-describedby="table-paging">
                                                    <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$decodeBrand->last_page}}</span></span>
                                                    <input type="hidden" name="route_name" value="onbuy/brand">
                                                </span>
                                                @if($brands->currentPage() !== $brands->lastPage())
                                                <a class="next-page btn" href="{{$decodeBrand->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                    <span class="screen-reader-text d-none">Next page</span>
                                                    <span aria-hidden="true">›</span>
                                                </a>
                                                <a class="last-page btn" href="{{$decodeBrand->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                    <span class="screen-reader-text d-none">Last page</span>
                                                    <span aria-hidden="true">»</span>
                                                </a>
                                                @endif
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>

                                <div class="row brand-upload-div" style="display: none">
                                    <div class="col-12">
                                        <form action="#" method="post">
                                            @csrf
                                            <div class="form-group input-group col-md-6">
                                                <input type="text" name="brand_search" class="form-control brand-value" placeholder="Give your desire brand">
                                                <button type="button" class="btn btn-primary check-onbuy-brand" data="1">Check Onbuy Brand</button>
                                            </div>
                                        </form>
                                        <span class="onbuyBrandSave"></span>
{{--                                        <form action="{{url('onbuy/save-brand')}}" method="post" id="onbuyBrandSave">--}}
{{--                                            @csrf--}}
{{--                                            <div class="" style="border: 1px solid #d5c9c9 ;padding: 10px">--}}
{{--                                                <h3>Choose your brand</h3>--}}
{{--                                                <input type="checkbox" class="input-brand-value" name="onbuy_brand_name[]" value="" style="margin: 5px">fdgfdg<br>--}}
{{--                                                <button type="submit" class="btn btn-primary brand-append">Add</button>--}}
{{--                                            </div>--}}
{{--                                        </form>--}}
                                    </div>
                                </div>


                            <table id="table-sort-list" class="category-table w-100">
                                <thead>
                                <tr>
                                    <th>Brand Name</th>
                                </tr>
                                </thead>
                                <tbody id="table-body">
                                @isset($brands)
                                    @foreach($brands as $brand)
                                        <tr>
                                            <td>{{$brand->name}}</td>
                                        </tr>
                                    @endforeach
                                @endisset
                                </tbody>
                            </table>

                            <!--table below pagination sec-->
                            <div class="row table-foo-sec">
                                <div class="col-md-6 d-flex justify-content-md-start align-items-center"> </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end align-items-center py-2">
                                        <div class="pagination-area">
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num"> {{$brands->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($brands->currentPage() > 1)
                                                    <a class="first-page btn {{$brands->currentPage() > 1 ? '' : 'disable'}}" href="{{$decodeBrand->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$brands->currentPage() > 1 ? '' : 'disable'}}" href="{{$decodeBrand->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text d-flex pl-1"> {{$decodeBrand->current_page}} of <span class="total-pages"> {{$decodeBrand->last_page}} </span></span>
                                                    </span>
                                                    @if($brands->currentPage() !== $brands->lastPage())
                                                    <a class="next-page btn" href="{{$decodeBrand->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$decodeBrand->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                        <span class="screen-reader-text d-none">Last page</span>
                                                        <span aria-hidden="true">»</span>
                                                    </a>
                                                    @endif
                                               </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End table below pagination sec-->

                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>

    <script>

        //Datatable row-wise searchable option
        $(document).ready(function(){
            $("#row-wise-search").on("keyup", function() {
                let value = $(this).val().toLowerCase();
                $("#table-body tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });

            });
        });


        //screen option toggle
        $(document).ready(function(){
            $(".screen-option-btn").click(function(){
                $(".screen-option-content").slideToggle(500);
            });
            $('.brand-upload-div').on('click','.check-onbuy-brand',function (){
                var currentPage = $(this).attr('data')
                var brandSearchValue = $('.brand-value').val();
                if(brandSearchValue == ''){
                    alert('please give your brand name');
                    return false;
                }
                $.ajax({
                    type: 'post',
                    url: '{{url("onbuy/pull-matched-brand")}}',
                    data: {
                        '_token': '{{csrf_token()}}',
                        'brandSearchValue': brandSearchValue,
                        'currentPage': currentPage
                    },
                    beforeSend: function (){
                        $('#ajax_loader').show();
                    },
                    success: function (response){
                        if(response.results.length != 0) {
                            var html = '<form action="{{url('onbuy/save-brand')}}" method="post" id="onbuyBrandSave">\n' +
                                '@csrf\n' +
                                '<div class="" style="border: 1px solid #d5c9c9 ;padding: 10px">\n' +
                                '<h3>Choose your brand</h3><div class="row">';
                            response.results.forEach(function (brand,index) {
                                html += '<div class="col-md-4"><input type="checkbox" class="input-brand-value" name="onbuy_brand_name[]" value="' + brand.brand_id + '/' + brand.brand_type_id + '/' + brand.name + '/' + brand.type + '" style="margin: 5px">' + brand.name + ' (<span class="text-success">' + brand.type + '</span>)</div>';
                            });
                            html += '</div>'
                            var pageCount = Math.ceil(response.metadata.total_rows / 100)
                            if(pageCount > 1) {
                                var pageNumberBox = ''
                                for(var i = 1; i <= pageCount; i++) {
                                    var isCurrent = currentPage == i ? 'disabled' : ''
                                    pageNumberBox += '<li class="page-item"><a class="page-link check-onbuy-brand '+isCurrent+'" href="javascript:void(0)" data="'+i+'">'+i+'</a></li>'
                                }
                                html += '<nav>'
                                    +'<ul class="pagination pagination-sm">'
                                    +pageNumberBox
                                    +'</ul>'
                                +'</nav>'
                            }
                            html += '<button type="submit" class="btn btn-primary brand-append">Add</button></div>';
                            $('.onbuyBrandSave').html(html);
                        }else{
                            $('.onbuyBrandSave').html('<div class="" style="border: 1px solid #d5c9c9 ;padding: 10px"><h3 class="text-danger">No brand found</h3></div>');
                        }
                        $('#ajax_loader').hide();
                    }
                })
            });
            $('.brand-field-show').click(function () {
                $('.brand-upload-div').slideToggle();
            });

            $('.brand-append').click(function (){
                var allBrand = {};
                $('.input-brand-value').each(function (){
                    var brandName = $(this).val();
                    allBrand[brandName] = brandName;
                });
                console.log(allBrand);
            });


        });

    </script>


@endsection
