
@extends('master')
@section('content')



    <link href="{{asset('assets/css/select2.min.css')}}" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <!-- Custombox -->
    <link href="{{asset('assets/plugins/custombox/css/custombox.css')}}" rel="stylesheet">

    <!-- Modal-Effect -->
    <script src="{{asset('assets/plugins/custombox/js/custombox.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custombox/js/legacy.min.js')}}"></script>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <div class="wms-breadcrumb">
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item">eBay</li>
                        <li class="breadcrumb-item active" aria-current="page">eBay Migration</li>
                    </ol>

                    <!-- <div id="migration_number"> -->
                        <!-- <a href="{{url('ebay-migration-cat-page')}}" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a">You have to create {{$category_count}} profile before migration</a> -->
                        <!-- <a target="_blank" href="{{url('ebay-migration-cat-page/ac_id/'.$acId)}}">You have to create {{$category_count}} profile before migration</a> -->
                    <!-- </div> -->
                    <!-- <div id="migration_number_reset" style="display:none;"> -->
                        <!-- <a href="{{url('ebay-migration-cat-page')}}" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a">You have to create {{$category_count_reset}} profile before migration</a> -->
                        <!-- <a target="_blank" href="{{url('ebay-migration-cat-page/ac_id/')}}">You have to create {{$category_count_reset}} profile before migration</a> -->
                    <!-- </div> -->
                    <div id="bulk_migration" class="">
                        <form action="{{url('ebay-migration-cat-page/ac_id/')}}" method="post">
                        @csrf
                            <input type="hidden" name="migration_category" class="migration_category" value="">
                            <input type="hidden" name="account_id" class="account_id" value="{{$acId ?? ''}}">
                            <input type="hidden" name="reset_category_count" class="reset_category_count" value="{{$category_count_reset ?? ''}}">
                            <button type="submit" class="btn btn-success">You have to create <span class="profile_count badge badge-dark">{{$category_count}}</span> profile before migration</button>
                        </form>
                    </div>


{{--                    <div>--}}
{{--                        @foreach($category_name as $name)--}}
{{--                            {{$name->category_name}}*--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                    @if($category_count == 0)--}}

                <div id="eBay-migration-without-variation" style="display: none;">
                    <form action="{{URL::to('ebay-migration-started/old')}}">
                        @csrf
                        <input type="hidden" id="catalogue_id" name="catalogue_id" value="">
                        <button type="submit" id="migrationSubmit" class="btn btn-default open-authorization-btn" target="_blank">Start Migration</button>
                    </form>
                </div>
{{--                    <a class="btn btn-default open-authorization-btn" href="{{url('ebay-migration-started')}}" target="_blank"> Start Migration</a>--}}

                    <!-- <div id="eBay-migration-without-variation" style="display: none;">
                        <a class="btn btn-default open-authorization-btn" href="{{url('ebay-migration-without-variation-started')}}" target="_blank"> Start Migration Without Variation</a>
                    </div> -->

{{--                    @endif--}}
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
                                    <!-- <div data-tip="ID, Url, Action Name, Action Name, Account ID, Request Data,Response Data,Action By,Last Quantity,Updated Quantity,Action Date,Solve Status,Action Status,Created At,Updated At,Deleted At">
                                        <input type="text" class="form-control log-search dispatch-oninput-search" name="search_oninput" id="search_oninput" placeholder="Search..." required>
                                        <input type="hidden" name="log_search_status" id="log_search_status" value="processing">
                                    </div> -->
                                </div>
                                <!--End Awaiting dispatch search area-->

                                <!--Pagination area-->
                                <div class="pagination-area">
                                    <form action="{{url('pagination-all')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="route_name" value="ebay-migration-list">
                                    </form>
                                </div>

                                <!--End Pagination area-->
                                </div>

                            <table class="ebay-table ebay-table-n w-100" style="border-bottom: 1px solid #1ABC9C">
                                <thead class="text-center">
                                <form action="{{url('all-column-search')}}" method="post" id="reset-column-data">
                                @csrf
                                <input type="hidden" name="search_route" value="ebay-migration-list">
                                <input type="hidden" name="status" value="publish">
                                <tr>
                                    <th style="width: 6%; text-align: center"><input type="checkbox" class="form-control allCheckbox" onclick="migrationAllCheckbox();">Select All</th>
{{--                                    <th style="width: 6% !important;text-align:center!important">Image</th>--}}
                                    <th class="title" style="width: 10%;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['title'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="title" value="{{$allCondition['title'] ?? ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="title_optout" type="checkbox" name="title_optout" value="1" @isset($allCondition['title_optout']) checked @endisset><label for="title_optout">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['title']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="title" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                            </div>
                                            <div>Title</div>
                                        </div>
                                    </th>
                                    <th class="category_id" style="width: 10%;">
                                        <div class="d-flex justify-content-center">
                                            <!-- <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['category_id'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="category_id" value="{{$allCondition['category_id'] ?? ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="category_id_optout" type="checkbox" name="category_id_optout" value="1" @isset($allCondition['category_id_optout']) checked @endisset><label for="category_id_optout">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['category_id']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="category_id" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                            </div> -->
                                            <div>Category</div>
                                        </div>
                                    </th>
                                    <th class="condition_name" style="width: 10%;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['condition_name'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="condition_name" value="{{$allCondition['condition_name'] ?? ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="condition_name_optout" type="checkbox" name="condition_name_optout" value="1" @isset($allCondition['condition_name_optout']) checked @endisset><label for="condition_name_optout">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['condition_name']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="condition_name" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                            </div>
                                            <div>Condition</div>
                                        </div>
                                    </th>
                                    <th class="account_id" style="width: 10%;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                            <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                <i class="fa @isset($allCondition['account_id'])text-warning @endisset" aria-hidden="true"></i>
                                            </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        @php
                                                            $all_ebay_account = \App\EbayAccount::get();
                                                        @endphp
                                                        <select class="form-control select2" name="account_id" id="account_id">
                                                        <!-- <select class="form-control b-r-0" name="search_value"> -->
                                                            @if(isset($all_ebay_account))
                                                                @if($all_ebay_account->count() == 1)
                                                                    @foreach($all_ebay_account as $ebay_account)
                                                                        <option value="{{$ebay_account->id}}">{{$ebay_account->account_name}}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="">Select Account</option>
                                                                    @foreach($all_ebay_account as $ebay_account)
                                                                    @if(isset($allCondition['account_id']) && ($allCondition['account_id'] == $ebay_account->id))
                                                                            <option value="{{$ebay_account->id}}" selected>{{$ebay_account->account_name}}</option>
                                                                        @else
                                                                            <option value="{{$ebay_account->id}}">{{$ebay_account->account_name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        </select>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="account_name_opt_out" type="checkbox" name="account_name_opt_out" value="1" @isset($allCondition['account_name_opt_out']) checked @endisset><label for="account_name_opt_out">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['account_id']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="account_id" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                            </div>
                                            <div>Account</div>
                                        </div>
                                    </th>
                                    <th class="item_id" style="width: 10%;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['item_id'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="item_id" value="{{$allCondition['item_id'] ?? ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="item_id_optout" type="checkbox" name="item_id_optout" value="1" @isset($allCondition['item_id_optout']) checked @endisset><label for="item_id_optout">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['item_id']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="item_id" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                            </div>
                                            <div>Item Number</div>
                                        </div>
                                    </th>
                                    <th style="width: 10%;">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <div>Status</div> &nbsp; &nbsp;
                                            @if(count($allCondition) > 0)
                                                <div><a title="Clear filters" id="clear_all" class='btn btn-outline-info clear-params'><img src="{{asset('assets/common-assets/25.png')}}"></a></div>
                                            @endif
                                        </div>
                                    </th>
                                </tr>
                                </form>
                                </thead>
                                <tbody>
                                @isset($ebay_migration_result)
                                    @foreach($ebay_migration_result as $product)

                                        <tr>
                                            @if($product->status == 0)
                                            <td style="width: 6%; text-align: center !important;"><input id="catalogue_id_array" name="id[]" type="checkbox" class="form-control categoryCheckbox" onclick="migrationCheckBox();" value="{{$product->account_id}}/{{$product->category_id}}/{{$product->condition_id}}/{{$product->item_id}}"></td>
                                            @else
                                            <td style="width: 6%; text-align: center !important;"></td>
                                            @endif
{{--                                            <td class="image" style="cursor: pointer; width: 6% !important;text-align:center!important" data-toggle="collapse" data-target="#demo{{$product->id}}" class="accordion-toggle">--}}
{{--                                                @isset($product->imgae)--}}
{{--                                                    <a href="{{$product->imgae}}"  title="Click to expand" target="_blank"><img src="{{$product->imgae}}" class="ebay-image" alt="ebay-catalogue-image"></a>--}}
{{--                                                @endisset--}}
{{--                                            </td>--}}

                                            <td class="w-30">
                                                <a class="text-custom" href="{{$product->url}}">{{$product->title}}</a>
                                            </td>

                                            <td style="cursor: pointer; width: 10%; text-align: center !important;">
                                                <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$product->category_name}}</span>
                                                    <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                </div>
                                            </td>
                                            <td style="cursor: pointer; width: 10%; text-align: center !important;">
                                                <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$product->condition_name}}</span>
                                                    <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                </div>
                                            </td>
                                            @php
                                                $account_name = \App\EbayAccount::select('account_name')->where('id',$product->account_id)->first();
                                            @endphp
                                            <td style="text-align:center !important;">
                                                @isset($account_name)
                                                        {{$account_name->account_name}}
                                                @endisset
                                            </td>
                                            <td style="cursor: pointer; width: 10%; text-align: center !important;">
                                                <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$product->item_id}}</span>
                                                    <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if($product->status == 0)
                                                    <div class="text-center"><a class="btn-size btn-danger" style="cursor: pointer"  target="_blank" data-toggle="tooltip" data-placement="top" title="Pending"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></a></div>
                                                @else
                                                    <div class="text-center"><a class="btn-size btn-success" style="cursor: pointer"  target="_blank" data-toggle="tooltip" data-placement="top" title="Migrated"><i class="fa fa-check" aria-hidden="true"></i></a></div>
                                                @endif
                                            </td>

                                        </tr>

                                        <!-- Edit eBay account Modal -->

                                        <!--End Edit eBay account Modal -->




                                    @endforeach
                                @endisset
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

        function migrationCheckBox(){
            // console.log('test1')
            var getNum = $('span.profile_count').text().replace(/[^0-9.]/gi, '')
            //console.log('profileNumber '+ getNum)
            if($('.categoryCheckbox:checked').length > 0 && getNum == 0) {
                $("#eBay-migration-without-variation").show({duration: 800,specialEasing: {width: "linear",}});
            }else{
                $('#eBay-migration-without-variation').hide(1000);
            }
        }

        function migrationAllCheckbox(){
            // console.log('test2')
            var getNum = $('span.profile_count').text().replace(/[^0-9.]/gi, '')
            //console.log('profileNumber '+ getNum)
            if($('.allCheckbox:checked').length > 0 && getNum == 0) {
                $("#eBay-migration-without-variation").show({duration: 800,specialEasing: { width: "linear",}})
            }else{
                $('#eBay-migration-without-variation').hide(1000);
            }
        }

        $(document).ready(function(){
            $('.allCheckbox').click(function(){
                $('.categoryCheckbox').prop('checked',$(this).prop('checked'))
                checkedProduct()
            })

            $('.categoryCheckbox').click(function(){
                if(!$(this).prop("checked")){
                    $(".allCheckbox").prop("checked",false);
                }
                $(this).prop('checked',$(this).prop('checked'));
                checkedProduct()
            })
        })
        // function getId(e){
        //     var catalogue_id = [];
        //     // $("#migrationSubmit").click(function (event) {
        //     //     event.preventDefault()
        //     // })
        //     $('table tbody tr td :checkbox:checked').each(function (i) {
        //         catalogue_id[i] = $(this).val();
        //
        //         // console.log(catalogue_id)
        //     });
        //     // catalogue_id
        //     document.getElementById("catalogue_id").value = catalogue_id
        //     // console.log(catalogue_id)
        //     console.log(document.getElementById("catalogue_id").value);
        // }
        function checkedProduct(){

            var productArr = []
            $('tbody tr td  :checkbox:checked').each(function(){
                productArr.push($(this).val())
            })
            document.getElementById("catalogue_id").value = productArr;
            console.log(document.getElementById("catalogue_id").value)
                fetch("{{url('ebay-migration-profile-count')}}",{
                method: 'post',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    "X-CSRF-TOKEN": "{{csrf_token()}}"
                },
                body: JSON.stringify({product_arr: productArr})
            })
            .then(response => {
                return response.json()
            })
            .then(data => {
                $('span.profile_count').text(data.profile_count)
                //console.log(data.profile_count)
                if(data.profile_count == 0){
                    $("#eBay-migration-without-variation").show({duration: 800,specialEasing: { width: "linear",}})
                }
                $('.migration_category').val(productArr)
            })
            .catch(error => {
                Swal.fire('Oops!','Something Went Wrong','error')
            })
        }

        // const targetDiv = document.getElementById("migration_number");
        // const targetDivReset = document.getElementById("migration_number_reset");
        const btn = document.getElementById("clear_all");
        btn.onclick = function () {
            $('span.profile_count').text($('.reset_category_count').val())
            if (targetDiv.style.display !== "none") {
                targetDiv.style.display = "none";
                targetDivReset.style.display = "block";
            } else {
                targetDiv.style.display = "block";
                targetDivReset.style.display = "none";
            }
        };
    </script>



@endsection
