
@extends('master')
@section('content')



    <link href="{{asset('assets/css/select2.min.css')}}" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <div class="wms-breadcrumb">
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item">eBay</li>
                        <li class="breadcrumb-item active" aria-current="page">eBay Migration Category List</li>
                    </ol>
                </div>

                
                <div class="row m-t-20">
                   
                    <div class="col-md-12">
                        <div class="card-box ebay ebay-card-box table-responsive shadow">

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

                            <!--start table upper side content-->
                            <div class="product-inner dispatched-order">

                                <!--Awaiting dispatch search area-->
                                <div class="dispatched-search-area">
                                   
                                </div>
                                <!--End Awaiting dispatch search area-->

                                <!--Pagination area-->

                                <!--End Pagination area-->
                                </div>
                            <h5>Total Category {{count($category_sorting)}}</h5>
                            <table class="ebay-table ebay-table-n w-100" style="border-bottom: 1px solid #1ABC9C">
                                <thead>
                                <form action="" method="post" id="reset-column-data">
                                @csrf
                                <input type="hidden" name="search_route" value="ebay-migration-list">
                                <input type="hidden" name="status" value="publish">

                                <tr>
                                    <th style="width: 60%;">Category</th>
                                    <th class="" style="width: 20%;">
                                        Condition
                                    </th>
                                    <th class="" style="width: 20%;">
                                        Account
                                    </th>
                                    <th class="" style="width: 20%;">
                                        Action
                                    </th>
                                </tr>

                            </form>
                                </thead>
                                <tbody>
                                @isset($category_sorting)
                                    @foreach($category_sorting as $category)
                                        <tr>
                                            <td>
                                                <p>{{$category->category_name}}</p>
                                            </td>
                                            <td>
                                                <p>{{$category->condition_name}}</p>
                                            </td>
                                            <td>
                                                <p><img src="{{$category->accountInfo->logo}}" width="30" height="30"></p>
                                            </td>

                                            <td>
                                                <a href="{{url('create-ebay-profile/'.$category->site_id.'/'.$category->account_id.'/'.$category->category_id)}}" class="btn btn-outline-info" target="_blank">Add Profile</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset    
                                        <!-- Edit eBay account Modal -->

                                        <!--End Edit eBay account Modal -->



                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->

    </div>   <!-- content page -->



    <script>
        $('.select2').select2();


    </script>



@endsection
