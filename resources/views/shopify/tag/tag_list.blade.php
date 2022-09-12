
@extends('master')

@section('title')
    WooCommerce | Tags | WMS360
@endsection

@section('content')

    <!-- Custombox -->
    <link href="{{asset('assets/plugins/custombox/css/custombox.css')}}" rel="stylesheet">

    <!-- Modal-Effect -->
    <script src="{{asset('assets/plugins/custombox/js/custombox.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custombox/js/legacy.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.css')}}"  />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <style>
        .not_allowed {
            cursor: not-allowed !important;
        }
    </style>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                <input type="hidden" id="firstKey" value="shopify">
                <input type="hidden" id="secondKey" value="shopify_tag_list">
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
                                <div>
                                    <a href="#addAttributeTerms" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn btn-default">Add Tag</button></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--//screen option-->



                <div class="screen-option">
                    <div class="d-flex justify-content-start align-items-center">
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Shopify</li>
                            <li class="breadcrumb-item active" aria-current="page">Tags</li>
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
                        <div class="card-box table-responsive shadow category-card">


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
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Collection successfully added</strong>
                                </div>
                            @endif


                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>This Collection already added</strong>
                                </div>
                            @endif

                            @if (Session::has('tag_edit_success_msg'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {!! Session::get('tag_edit_success_msg') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (Session::has('tag_delete_success_msg'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {!! Session::get('tag_delete_success_msg') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between product-inner p-b-10">
                                <div class="row-wise-search search-terms">
                                    <input class="form-control mb-1" id="row-wise-search" type="text" placeholder="Search....">
                                </div>
                                <div class="pagination-area mt-xs-10 mb-xs-5">
                                    <form action="" method="post">
                                        <div class="datatable-pages d-flex align-items-center">

                                        </div>
                                    </form>
                                </div>
                            </div>


                            <table id="table-sort-list" class="category-table w-100">
                                <thead>
                                    <tr>
                                        <th>Tag Name</th>
                                        <th style="width: 15%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                @isset($all_tags)
                                    @foreach($all_tags as $tag)
                                        <tr>
                                            <td>{{$tag->tag_name}}</td>
                                            <td class="actions" style="width: 15%">
                                                <div class="d-flex justify-content-start">
                                                    {{--                                                <a href="{{url('category/'.$category->id.'/edit')}}" ><button class="vendor_btn_edit btn-primary">Edit</button></a>&nbsp;--}}
                                                    <a class="mr-2" href="#custom-modal{{$tag->id}}" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn-size edit-btn" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></button></a>&nbsp;
                                                    {{--                                                <a href="{{url('category/'.$category->id)}}" ><button class="vendor_btn_view btn-success">View</button></a>&nbsp;--}}
                                                    <form action="{{url('shopify/tag/delete/'.$tag->id)}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="tag_delete_id" value="{{$tag->id}}">
                                                        <a href="#" class="on-default remove-row"><button class="btn-size delete-btn" style="cursor: pointer" onclick="return check_delete('category');" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button></a>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit Category Modal -->
                                        <div id="custom-modal{{$tag->id}}" class="modal-demo">
                                            <button type="button" class="close" onclick="Custombox.close();">
                                                <span>&times;</span><span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="custom-modal-title">Edit Tag</h4>
                                            <form role="form" class="vendor-form mobile-responsive" action="{{url('shopify/tag/edit/'.$tag->id)}}" method="post">
                                                @csrf
                                                <div class="form-group w_category_name row">
                                                    <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Tag</label>
                                                    <div class="col-md-9 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input type="hidden" name="shopify_tag_id" value="{{$tag->id}}">
                                                        <input type="text" name="tag" class="form-control" id="tag" value="{{ $tag->tag_name ? $tag->tag_name :old('tag') }}" placeholder="Enter Tag" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-12 text-center mb-5 mt-3">
                                                        <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                                                            <b>Update</b>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!--End Edit Category Modal -->

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
                                                    <span class="displaying-num"> {{$all_tags->total()}} items</span>
                                                    <span class="pagination-links d-flex">
                                                    @if($all_tags->currentPage() > 1)
                                                            <a class="first-page btn {{$all_tags->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_tag->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                            <a class="prev-page btn {{$all_tags->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_tag->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                        @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text d-flex pl-1"> {{$all_decode_tag->current_page}} of <span class="total-pages"> {{$all_decode_tag->last_page}} </span></span>
                                                    </span>
                                                    @if($all_tags->currentPage() !== $all_tags->lastPage())
                                                            <a class="next-page btn" href="{{$all_decode_tag->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                            <a class="last-page btn" href="{{$all_decode_tag->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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





    <!-- Add Category Modal -->

    <!--End Add Category Modal-->

    <!-- Migration Category Modal -->
    <div id="addAttributeTerms" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add Tags</h4>

        <form role="form" class="vendor-form mobile-responsive" action="<?php echo e(url('shopify/tag/add')); ?>" method="post">
            <?php echo csrf_field(); ?>

            <div class="form-group c_attribute_terms row">
                <label for="name" class="col-md-4 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Add Tag</label>
                <div class="col-md-8 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 more-terms-append-div">
                    <div class="input-group">
                        <input type="text" name="tag[]" class="form-control mb-2" id="tag" value="<?php echo e(old('tag')); ?>" placeholder="Enter Tag" required>
                        <!-- <span class="input-group-btn">
                            <button class="btn btn-info add-more-terms-field"><i class="fa fa-plus"></i></button>
                        </span> -->
                    </div>
                </div>

            </div>
            <div class="form-group row c_attribute_terms">
                <div class="col-md-8 offset-md-4">
                    <span class="float-right">
                        <button class="btn btn-info add-more-terms-field"><i class="fa fa-plus"></i></button>
                    </span>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12 text-center mb-5 mt-3">
                    <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                        <b>Submit</b>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!--End Migration Category Modal-->




    <script type="text/javascript">
        $('.select2').select2();

        $(".js-example-tokenizer").select2({
            tags: true,
            tokenSeparators: [',', ' ']
        })

        $('#account_name').select2({
            dropdownParent: $('#addCategory')
        });

        $('#migration_account').select2({
            dropdownParent: $('#migrationCategory')
        });

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
        });

        $('.add-more-terms-field').click(function(event){
            event.preventDefault()
            var html = '<div class="input-group">'
                +'<input type="text" name="tag[]" class="form-control mb-2" id="tag" value="<?php echo e(old('tag')); ?>" placeholder="Enter Tag" required>'
                +'<span class="input-group-btn">'
                +    '<button class="btn btn-danger remove-more-terms-field"><i class="fa fa-remove"></i></button>'
                +'</span>'
                +'</div>'
            $('.more-terms-append-div').append(html)
            console.log('found')
        })
        $('.form-group').on('click','.remove-more-terms-field',function(event){
            event.preventDefault()
            console.log('remove found')
            $(this).closest('div').remove()
        })



    </script>


@endsection
