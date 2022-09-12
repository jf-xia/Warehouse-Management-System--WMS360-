
@extends('master')
@section('content')
    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">


    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <!--screen option-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box screen-option-content" style="display: none">

                            <div class="d-flex justify-content-between content-inner mt-2 mb-2">
                                <div class="d-block">
                                    <div class="d-flex align-items-center">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="image" class="onoffswitch-checkbox" id="image" tabindex="0" checked>
                                            <label class="onoffswitch-label" for="image">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Image</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="id" class="onoffswitch-checkbox" id="id" tabindex="0" checked>
                                            <label class="onoffswitch-label" for="id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>ID</p></div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center mt-xs-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="catalogue-name" class="onoffswitch-checkbox" id="catalogue-name" tabindex="0" checked>
                                            <label class="onoffswitch-label" for="catalogue-name">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Title</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="category" class="onoffswitch-checkbox" id="category" tabindex="0">
                                            <label class="onoffswitch-label" for="category">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Category</p></div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center mt-xs-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sold" class="onoffswitch-checkbox" id="sold" tabindex="0" checked>
                                            <label class="onoffswitch-label" for="sold">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sold</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="stock" class="onoffswitch-checkbox" id="stock" tabindex="0" checked>
                                            <label class="onoffswitch-label" for="stock">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Stock</p></div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="product" class="onoffswitch-checkbox" id="product" tabindex="0" checked>
                                            <label class="onoffswitch-label" for="product">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Product</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="creator" class="onoffswitch-checkbox" id="creator" tabindex="0" checked>
                                            <label class="onoffswitch-label" for="creator">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Creator</p></div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center modify-device-view">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="modifier" class="onoffswitch-checkbox" id="modifier" tabindex="0" >
                                            <label class="onoffswitch-label" for="modifier">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Modifier</p></div>
                                    </div>
                                </div>
                            </div>


                            <div><p class="pagination"><b>Pagination</b></p></div>
                            <div class="d-flex justify-content-between align-items-center pagination-content">
                                <div>
                                    <ul class="column-display d-flex align-items-center">
                                        <li>Number of items per page</li>
                                        <li><input type="number" class="pagination-count" value="{{$pagination}}"></li>
                                    </ul>
                                    <span class="pagination-mgs-show text-success"></span>
                                </div>
                                <div class="d-flex align-items-center select-catalogue">
                                    <select class="form-control catalogue-form-con" name="catalogue_search_by_date" id="catalogue_search_by_date">
                                        <option value="">Catalogue By Date Or Stock</option>
                                        <option value="1">Today</option>
                                        <option value="7">Last 7 Days</option>
                                        <option value="15">Last 15 Days</option>
                                        <option value="30">Last 30 Days</option>
                                        <option value="instock">In Stock</option>
                                        <option value="outofstock">Out Of Stock</option>
                                    </select>
                                    <input type="hidden" name="status" id="status" value="publish">
                                </div>
                            </div>

                            <div class="submit">
                                <input type="submit" class="btn submit-btn pagination-apply" value="Apply">
                            </div>

                        </div>
                    </div>
                </div>
                <!--//screen option-->


                <div class="screen-option">
                    <div class="d-flex justify-content-start align-items-center">
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Catalogue</li>
                            <li class="breadcrumb-item active" aria-current="page">Published Catalogue List</li>
                        </ol>
                    </div>
                    <div class="screen-option-btn">
                        <button class="btn btn-link waves-effect waves-light" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Screen Options &nbsp; <i class="fa" aria-hidden="true"></i>
                        </button>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion"></div>
                    </div>
                </div>
                <div class="col-4">
                    <form action="{{URL::to('download-product-csv')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-9">
                                <input type="text" name="catalogue_id"  class="form-control" placeholder="catalogue id Exmp: 7821,98214,54878" required>
                            </div>
                            <div class="col-3">
                                <button  class="button-success"type="submit">csv</button>
                            </div>
                        </div>

                    </form>
                </div>

                {{--                <!-- Page-Title -->--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-12 text-center">--}}
{{--                        <div class="vendor-title">--}}
{{--                            <p>Published Catalogue List <span class="font-weight-bold" style="color: #81c868;">({{$total_published_product}})</span></p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box catalogue table-responsive shadow">

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


                                <div class="m-b-20 m-t-10">

                                    <div class="product-inner">
                                        <div class="draft-search-form">
                                            <form class="d-flex" action="Javascript:void(0);" method="post">
                                                <div class="p-text-area">
                                                    <input type="text" name="name" id="name" class="form-control" placeholder="Search by ID or Catalogue Name...." required>
                                                </div>
                                                <div class="submit-btn">
                                                    <button class="search-btn waves-effect waves-light" type="submit" onclick="publish_catalogue_search();">Search</button>
                                                </div>
        {{--                                        <div class="submit-btn">--}}
        {{--                                            <button class="search-btn" type="submit" onclick="publish_catalogue_search();"><i class="fa fa-search"></i></button>--}}
        {{--                                        </div>--}}
                                            </form>
                                        </div>
{{--                                        <div class="product-draft-empty"></div>--}}
                                        <div class="pagination-area">
                                            <form action="{{url('pagination-all')}}" method="post">
                                                @csrf
                                                <div class="datatable-pages d-flex align-items-center">
                                                    <span class="displaying-num">{{$total_published_product}} items</span>
                                                    <span class="pagination-links d-flex">
                                                        <a class="first-page btn" href="{{$published_product_info->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                            <span class="screen-reader-text d-none">First page</span>
                                                            <span aria-hidden="true">«</span>
                                                        </a>
                                                        <a class="prev-page btn" href="{{$published_product_info->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                            <span class="screen-reader-text d-none">Previous page</span>
                                                            <span aria-hidden="true">‹</span>
                                                        </a>
                                                        <span class="paging-input d-flex align-items-center">
                                                            <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                            <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$published_product_info->current_page}}" size="3" aria-describedby="table-paging">
                                                            <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$published_product_info->last_page}}</span></span>
                                                            <input type="hidden" name="route_name" value="published-product">
                                                        </span>
                                                        <a class="next-page btn" href="{{$published_product_info->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                            <span class="screen-reader-text d-none">Next page</span>
                                                            <span aria-hidden="true">›</span>
                                                        </a>
                                                        <a class="last-page btn" href="{{$published_product_info->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                            <span class="screen-reader-text d-none">Last page</span>
                                                            <span aria-hidden="true">»</span>
                                                        </a>
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

{{--                            <div class="row">--}}
{{--                                <div class="col-md-9">--}}
{{--                                    <div class="pagination">--}}
{{--                                        {{$published_product->links()}}--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-3">--}}
{{--                                    <input class="form-control mb-1" id="row-wise-search" type="text" placeholder="Row Wise Search....">--}}
{{--                                    <div class="total-d-o">--}}
{{--                                        <span class="font-bold" style="color: #81c868;"> You are seeing : {{$published_product_info->from}}-{{$published_product_info->to}}</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <div id="Load" class="load" style="display: none;">
                                <div class="load__container">
                                    <div class="load__animation"></div>
                                    <div class="load__mask"></div>
                                    <span class="load__title">Content is loading...</span>
                                </div>
                            </div>


                            <table class="publish_search_result product-draft-table">
                                <thead style="background-color: {{$setting->master_publish_catalogue->table_header_color ?? '#f9f5f5'}};
                                    color: {{$setting->master_publish_catalogue->table_header_text_color ?? '#f9f5f5'}}">
                                <tr>
                                    <th class="image" style="width: 10%; text-align: center !important;">Image</th>
                                    <th class="id" style="width: 10%; text-align: center !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <form>
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out1" type="checkbox" name="opt-out1" ><label for="opt-out1">Opt Out</label>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div>ID</div>
                                        </div>
                                    </th>
                                    <th class="catalogue-name" style="width: 30%;">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
                                                <form>
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out2" type="checkbox" name="opt-out2" ><label for="opt-out2">Opt Out</label>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div> Title</div>
                                        </div>
                                    </th>
                                    <th class="category">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
                                                <form>
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out3" type="checkbox" name="opt-out3" checked><label for="opt-out3">Opt Out</label>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div>Category</div>
                                        </div>
                                    </th>
                                    {{--                                    <th>Description</th>--}}
                                    {{--                                    <th>Regular Price</th>--}}
                                    {{--                                    <th>Sales Price</th>--}}
                                    {{--                                    <th>Low Quantity</th>--}}
                                    <th class="sold filter-symbol" style="width: 10% !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <form>
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <div class="d-flex">
                                                            <div>
                                                                <select class="form-control select2">
                                                                    <option value="">=</option>
                                                                    <option value=""><</option>
                                                                    <option value="">></option>
                                                                    <option value="">≤</option>
                                                                    <option value="">≥</option>
                                                                </select>
                                                            </div>
                                                            <div class="ml-2">
                                                                <input type="text" class="form-control input-text symbol-filter-input-text" checked>
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out4" type="checkbox" name="opt-out4" ><label for="opt-out4">Opt Out</label>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div>Sold</div>
                                        </div>
                                    </th>
                                    <th class="stock filter-symbol" style="width: 10% !important; text-align: center !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <form>
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <div class="d-flex">
                                                            <div>
                                                                <select class="form-control select2">
                                                                    <option value="">=</option>
                                                                    <option value=""><</option>
                                                                    <option value="">></option>
                                                                    <option value="">≤</option>
                                                                    <option value="">≥</option>
                                                                </select>
                                                            </div>
                                                            <div class="ml-2">
                                                                <input type="text" class="form-control input-text symbol-filter-input-text">
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out5" type="checkbox" name="opt-out5" ><label for="opt-out5">Opt Out</label>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div>Stock</div>
                                        </div>
                                    </th>
                                    <th class="product filter-symbol" style="width: 10% !important; text-align: center !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <form>
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <div class="d-flex">
                                                            <div>
                                                                <select class="form-control select2">
                                                                    <option value="">=</option>
                                                                    <option value=""><</option>
                                                                    <option value="">></option>
                                                                    <option value="">≤</option>
                                                                    <option value="">≥</option>
                                                                </select>
                                                            </div>
                                                            <div class="ml-2">
                                                                <input type="text" class="form-control input-text symbol-filter-input-text">
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out6" type="checkbox" name="opt-out6" ><label for="opt-out6">Opt Out</label>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div>Product</div>
                                        </div>
                                    </th>
                                    <th class="creator filter-symbol" style="width: 15% !important; text-align: center !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <form>
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <select class="form-control select2">
                                                            <option value="">AB</option>
                                                            <option value="">BC</option>
                                                            <option value="">CD</option>
                                                        </select>
                                                        {{--                                                        <input type="text" class="form-control input-text">--}}
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out7" type="checkbox" name="opt-out7" ><label for="opt-out7">Opt Out</label>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div>Creator</div>
                                        </div>
                                    </th>
                                    <th class="modifier filter-symbol" style="width: 15% !important; text-align: center !important;">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
                                                <form>
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <select class="form-control select2">
                                                            <option value="">AB</option>
                                                            <option value="">BC</option>
                                                            <option value="">CD</option>
                                                        </select>
                                                        {{--                                                        <input type="text" class="form-control input-text">--}}
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out8" type="checkbox" name="opt-out8" ><label for="opt-out8">Opt Out</label>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div>Modifier</div>
                                        </div>
                                    </th>
                                    <th class="actions">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($published_product as $published_product)
                                    <tr>
                                        <td class="image" style="width: 10%; text-align: center !important;">
                                            @isset($published_product->single_image_info->image_url)
                                                <a href="{{$published_product->single_image_info->image_url}}"  title="Click to expand" target="_blank"><img src="{{$published_product->single_image_info->image_url}}" class="rounded-circle thumb-md" alt="catalogue-image"></a>
                                            @endisset
                                        </td>
                                        <td class="id" style="width: 10%; text-align: center !important;">{{$published_product->id}}</td>
                                        <td class="catalogue-name" style="width: 30%;">
                                            <a href="https://www.topbrandoutlet.co.uk/wp-admin/post.php?post={{$published_product->id}}&action=edit" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit On Woocommerce">
                                                {!! Str::limit(strip_tags($published_product->name),$limit = 100, $end = '...') !!}
                                            </a>
                                        </td>
                                        <?php
                                        $data = '';
                                        foreach ($published_product->all_category as $category){
                                            $data .= $category->category_name.',';
                                        }
                                        ?>
                                        <td class="category"> {{rtrim($data,',')}} </td>
                                        {{--                                        <td class="text-justify">{!! str_limit(strip_tags($published_product-> description),$limit = 10, $end = '...') !!}</td>--}}
                                        {{--                                        <td>{{$published_product->regular_price}}</td>--}}
                                        {{--                                        <td>{{$published_product->sale_price}}</td>--}}
                                        {{--                                        <td>{{$published_product->low_quantity}}</td>--}}
                                        <td class="sold" style="width: 10% !important; text-align: center !important;">{{$total_sold ?? 0}}</td>
                                        <td class="stock" style="width: 10% !important; text-align: center !important;">{{$published_product->ProductVariations[0]->stock ?? 0}}</td>
                                        <td class="product" style="width: 10% !important; text-align: center !important;">{{$published_product->product_variations_count ?? 0}}</td>
                                        <td class="creator" style="width: 15% !important; text-align: center !important;">
                                            <span class="shown"> <strong class="text-custom"> {{$published_product->user_info->name}}</strong><br> <span class="hover-shown"> on {{date('d-m-Y', strtotime($published_product->created_at))}} </span> </span>
                                        </td>
                                        <td class="modifier" style="width: 15% !important; text-align: center !important;">
                                            @if(isset($published_product->modifier_info->name))
                                               <span class="shown"> <strong class="text-custom">{{$published_product->modifier_info->name}}</strong><br> <span class="hover-shown">on {{date('d-m-Y', strtotime($published_product->updated_at))}}</span> </span>
                                            @else
                                               <span class="shown"> <strong class="text-custom">{{$published_product->user_info->name}}</strong><br> <span class="hover-shown"> on {{date('d-m-Y', strtotime($published_product->created_at))}} </span> </span>
                                            @endif
                                        </td>
                                        <td class="actions">

                                            <div class="btn-group dropup">
                                                <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Manage
                                                </button>
                                                <div class="dropdown-menu">
                                                    <!-- Dropdown menu links -->
                                                    <div class="dropup-content">
                                                        <div class="draft-action-1">
                                                            <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{route('product-draft.edit',$published_product->id)}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                            <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{route('product-draft.show',$published_product->id)}}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                                            @if(!isset($published_product->onbuy_product_info->id))
                                                                <div class="align-items-center mr-2"> <a class="btn-size list-onbuy-btn" href="{{url('onbuy/create-product/'.$published_product->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List On Onbuy"><i class="fa fa-product-hunt" aria-hidden="true"></i></a></div>
                                                            @endif
                                                            <div class="align-items-center"><a class="btn-size catalogue-btn-size add-terms-catalogue-btn" href="{{url('add-additional-terms-draft/'.$published_product->id)}}" data-toggle="tooltip" data-placement="top" title="Add Terms to Catalogue"><img src="{{asset('assets/images/terms-catalogue.png')}}" alt="Add Terms To Catalogue" width="30" height="30" class="filter"></a></div>
                                                        </div>
                                                        <div class="draft-action-2">
                                                            <div class="align-items-center mr-2"><a class="btn-size invoice-btn invoice-btn-size" href="{{url('catalogue-product-invoice-receive/'.$published_product->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Receive Invoice"><img src="{{asset('assets/images/receive-invoice.png')}}" alt="Receive Invoice" width="30" height="30" class="filter"></a></div>
                                                            <div class="align-items-center mr-2"> <a class="btn-size add-product-btn" href="{{url('catalogue/'.$published_product->id.'/product')}}" data-toggle="tooltip" data-placement="top" title="Add Product"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></div>
                                                            <div class="align-items-center mr-2"><a class="btn-size duplicate-btn" href="{{url('duplicate-draft-catalogue/'.$published_product->id)}}" data-toggle="tooltip" data-placement="top" title="Duplicate"><i class="fa fa-clone" aria-hidden="true"></i></a></div>


                                                            <div class="align-items-center">
                                                                <form action="{{route('product-draft.destroy',$published_product->id)}}" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="del-pub delete-btn" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('catalogue');"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                                </form>
                                                            </div>
                                                            <div class="align-items-center">
                                                                @if($published_product->status == 'draft')
                                                                    <form action="{{route('product-draft.publish',$published_product->id)}}" method="post">
                                                                        @csrf
                                                                        <button class="del-pub delete-btn" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Publish"><i class="fa fa-upload" aria-hidden="true"></i></button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>


                            <!--table below pagination sec-->
                            <div class="row table-foo-sec">
                                <div class="col-md-6 d-flex justify-content-md-start align-items-center">
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end align-items-center py-2">
                                        <div class="pagination-area">
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">Published Catalogue list {{$total_published_product}} items</span>
                                                <span class="pagination-links d-flex">
                                                    <a class="first-page btn" href="{{$published_product_info->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn" href="{{$published_product_info->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text  d-flex"> {{$published_product_info->current_page}} of <span class="total-pages">{{$published_product_info->last_page}}</span></span>
                                                    </span>
                                                    <a class="next-page btn" href="{{$published_product_info->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$published_product_info->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                        <span class="screen-reader-text d-none">Last page</span>
                                                        <span aria-hidden="true">»</span>
                                                    </a>
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
    </div>  <!-- content page-->

    <script type="text/javascript">

        function publish_catalogue_search(){
            var name = $('#name').val();
            // if(name == '' ){
            //     alert('Please type catalogue name in the search field.');
            //     return false;
            // }
            var status = $('#status').val();
            console.log(status);
            $.ajax({
                type: 'POST',
                url: '{{url('/search-product-list').'?_token='.csrf_token()}}',
                data: {
                    "name": name,
                    "status":status,
                },
                beforeSend: function(){
                    // Show image container
                    console.log(name);
                    $("#ajax_loader").show();
                },
                success: function(response){

                    $('.product-content ul.pagination').hide();
                    $('.total-d-o span').hide();
                    $('.publish_search_result').html(response);

                },
                complete:function(data){
                    // Hide image container
                    $("#ajax_loader").hide();
                }
            });
        }

        $(document).ready(function() {

            // Default Datatable
            // $('#datatable').DataTable();

            $('#catalogue_search_by_date').on('change',function () {
                var date_value = $(this).val();
                if(date_value == ''){
                    date_value = 15;
                }
                console.log(date_value);
                var status = $('#status').val();
                $.ajax({
                    type: "post",
                    url: "{{url('search-catalogue-by-date')}}",
                    data: {
                        "_token" : "{{csrf_token()}}",
                        "search_date" : date_value,
                        "status" : status
                    },
                    beforeSend: function () {
                        $('#ajax_loader').show();
                    },
                    success: function (response) {
                        // $('#datatable_wrapper div:first').hide();
                        // $('#datatable_wrapper div:last').hide();
                        $('.product-content ul.pagination').hide();
                        $('.total-d-o span').hide();
                        $('.publish_search_result').html(response.data);
                    },
                    complete: function () {
                        $('#ajax_loader').hide();
                    }
                })
            })

        } );





        //Datatable row-wise searchable option
        // $(document).ready(function(){
        //     $("#row-wise-search").on("keyup", function() {
        //         let value = $(this).val().toLowerCase();
        //         $("#table-body tr").filter(function() {
        //             $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        //         });
        //
        //     });
        // });

        //table header-search option toggle
        // $(document).ready(function(){
        //     $(".header-search").click(function(){
        //         $(".header-search-content").toggle();
        //     });
        // });

        //screen option toggle
        $(document).ready(function(){
            $(".screen-option-btn").click(function(){
                $(".screen-option-content").slideToggle(500);
            });
        });

        // table column hide and show toggle checkbox
        $("input:checkbox").click(function(){
            let column = "."+$(this).attr("name");
            $(column).toggle();
        });

        //table column by default hide
        $("input:checkbox:not(:checked)").each(function() {
            var column = "table ." + $(this).attr("name");
            $(column).hide();
        });


        // Entire table row column display
        // $("#display-all").click(function(){
        //     $("table tr th, table tr td").show();
        //     $(".column-display .checkbox input[type=checkbox]").prop("checked", "true");
        // });


        // After unchecked any column display all checkbox will be unchecked
        // $(".column-display .checkbox input[type=checkbox]").change(function(){
        //     if (!$(this).prop("checked")){
        //         $("#display-all").prop("checked",false);
        //     }
        // });

        //prevent onclick dropdown menu close
        $('.filter-content').on('click', function(event){
            event.stopPropagation();
        });

        //text hover shown
        $('.shown').on('hover', function(){
            var target = $(this).attr('hover-target');
            $(body).append(target);
            $('.'+target).display('toggle');
        });



    </script>


{{--    <script>--}}

{{--        //Datatable row-wise searchable option--}}
{{--        $(document).ready(function(){--}}
{{--            $("#row-wise-search").on("keyup", function() {--}}
{{--                let value = $(this).val().toLowerCase();--}}
{{--                $("#table-body tr").filter(function() {--}}
{{--                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)--}}
{{--                });--}}

{{--            });--}}
{{--        });--}}

{{--        //sort ascending and descending table rows js--}}
{{--        function sortTable(n) {--}}
{{--            let table,--}}
{{--                rows,--}}
{{--                switching,--}}
{{--                i,--}}
{{--                x,--}}
{{--                y,--}}
{{--                shouldSwitch,--}}
{{--                dir,--}}
{{--                switchcount = 0;--}}
{{--            table = document.getElementById("published-product-list");--}}
{{--            switching = true;--}}
{{--            //Set the sorting direction to ascending:--}}
{{--            dir = "asc";--}}
{{--            /*Make a loop that will continue until--}}
{{--            no switching has been done:*/--}}
{{--            while (switching) {--}}
{{--                //start by saying: no switching is done:--}}
{{--                switching = false;--}}
{{--                rows = table.getElementsByTagName("TR");--}}
{{--                /*Loop through all table rows (except the--}}
{{--                first, which contains table headers):*/--}}
{{--                for (i = 1; i < rows.length - 1; i++) { //Change i=0 if you have the header th a separate table.--}}
{{--                    //start by saying there should be no switching:--}}
{{--                    shouldSwitch = false;--}}
{{--                    /*Get the two elements you want to compare,--}}
{{--                    one from current row and one from the next:*/--}}
{{--                    x = rows[i].getElementsByTagName("TD")[n];--}}
{{--                    y = rows[i + 1].getElementsByTagName("TD")[n];--}}
{{--                    /*check if the two rows should switch place,--}}
{{--                    based on the direction, asc or desc:*/--}}
{{--                    if (dir == "asc") {--}}
{{--                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {--}}
{{--                            //if so, mark as a switch and break the loop:--}}
{{--                            shouldSwitch = true;--}}
{{--                            break;--}}
{{--                        }--}}
{{--                    } else if (dir == "desc") {--}}
{{--                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {--}}
{{--                            //if so, mark as a switch and break the loop:--}}
{{--                            shouldSwitch = true;--}}
{{--                            break;--}}
{{--                        }--}}
{{--                    }--}}
{{--                }--}}
{{--                if (shouldSwitch) {--}}
{{--                    /*If a switch has been marked, make the switch--}}
{{--                    and mark that a switch has been done:*/--}}
{{--                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);--}}
{{--                    switching = true;--}}
{{--                    //Each time a switch is done, increase this count by 1:--}}
{{--                    switchcount++;--}}
{{--                } else {--}}
{{--                    /*If no switching has been done AND the direction is "asc",--}}
{{--                    set the direction to "desc" and run the while loop again.*/--}}
{{--                    if (switchcount == 0 && dir == "asc") {--}}
{{--                        dir = "desc";--}}
{{--                        switching = true;--}}
{{--                    }--}}
{{--                }--}}
{{--            }--}}
{{--        }--}}


{{--        // sort ascending descending icon active and active-remove js--}}
{{--        $('.header-cell').click(function() {--}}
{{--            let isSortedAsc  = $(this).hasClass('sort-asc');--}}
{{--            let isSortedDesc = $(this).hasClass('sort-desc');--}}
{{--            let isUnsorted = !isSortedAsc && !isSortedDesc;--}}

{{--            $('.header-cell').removeClass('sort-asc sort-desc');--}}

{{--            if (isUnsorted || isSortedDesc) {--}}
{{--                $(this).addClass('sort-asc');--}}
{{--            } else if (isSortedAsc) {--}}
{{--                $(this).addClass('sort-desc');--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}


@endsection
