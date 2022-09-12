@extends('master')
@section('title')
    Item Profile | WMS360
@endsection
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <!--screen option-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box screen-option-content" style="display: none">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div><p class="pagination"><b>Pagination</b></p></div>
                                    <ul class="column-display d-flex align-items-center">
                                        <li>Number of items per page</li>
                                        <li><input type="number" class="pagination-count" value="{{$pagination ?? 0}}"></li>
                                    </ul>
                                    <input type="hidden" id="firstKey" value="profile">
                                    <input type="hidden" id="secondKey" value="item_attribute">
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
                            <li class="breadcrumb-item">Item</li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </div>
                    <div class="screen-option-btn">
                        <button class="btn btn-link waves-effect waves-light" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Screen Options &nbsp; <i class="fa" aria-hidden="true"></i>
                        </button>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion"></div>
                    </div>
                </div>

                <div class="row m-t-20 order-content">
                    <div class="col-md-12">
                        <div class="card-box onbuy table-responsive shadow">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(Session::has('success'))
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    {!! Session::get('success') !!}
                                </div>
                            @endif
                            @if(Session::has('error'))
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    {!! Session::get('error') !!}
                                </div>
                            @endif
                            <div class="m-b-20 m-t-10">
                                <div class="product-inner">
                                    <div class="item-profile-search-form draft-search-form w-100">
                                        <form class="d-flex" action="{{asset('search-item-profile')}}" method="post">
                                            @csrf
                                            <div class="p-text-area">
                                                <input type="text" class="form-control @isset($allCondition['search_value']) border border-success @endisset" placeholder="Search by profile, attribute, term name or value" name="search_value" id="search_value" value="{{$allCondition['search_value'] ?? ''}}">
                                            </div>
                                            <input type="hidden" name="route_name" value="item-profiles">
                                            <div class="submit-btn">
                                                <button id="search-btn" type="submit" class="search-profile-btn waves-effect waves-light">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!--start pagination area-->
                                    <div class="pagination-area">
                                        <form action="{{url('pagination-all')}}" method="post">
                                            @csrf
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">{{count($profile_lists)}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($profile_lists->currentPage() > 1)
                                                    <a class="first-page btn {{$profile_lists->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_profile_list->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$profile_lists->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_profile_list->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="paging-input d-flex align-items-center">
                                                        <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$all_decode_profile_list->current_page}}" size="3" aria-describedby="table-paging">
                                                        <span class="datatable-paging-text d-flex">of<span class="total-pages">{{$all_decode_profile_list->last_page}}</span></span>
                                                        <input type="hidden" name="route_name" value="item-profiles">
                                                    </span>
                                                    @if($profile_lists->currentPage() !== $profile_lists->lastPage())
                                                    <a class="next-page btn" href="{{$all_decode_profile_list->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$all_decode_profile_list->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                        <span class="screen-reader-text d-none">Last page</span>
                                                        <span aria-hidden="true">»</span>
                                                    </a>
                                                    @endif
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <!--End pagination area-->
                                </div>
                            </div>
                                    <div class="alert alert-danger alert-dismissible" style="display: none;">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>No profile found by this search value. Please try agian.</strong>
                                    </div>
                                    <table class="item-profile-table onbuy-table w-100" style="border-collapse:collapse;">
                                        <thead>
                                        <tr>
                                        <form action="{{asset('search-item-profile')}}" method="post" id="itemProfileList">
                                            @csrf
                                            <input type="hidden" name="route_name" value="item-profiles">
                                            <th class="profile-name" style="width: 40%">
                                                <div class="d-flex justify-content-center">
                                                    <div class="btn-group">
                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa @isset($allCondition['profile_name'])text-warning @endisset" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <input type="text" class="form-control input-text" name="profile_name" value="{{$allCondition['profile_name'] ?? ''}}">
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="opt-out1" type="checkbox" name="profile_name_opt_out" value="1" @isset($allCondition['profile_name_opt_out']) checked @endisset><label for="opt-out1">Opt Out</label>
                                                            </div>
                                                            @if(isset($allCondition['profile_name']))
                                                                <div class="individual_clr">
                                                                    <button title="Clear filters" type="button" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </div>
                                                    <div>Profile Name</div>
                                                </div>
                                            </th>
                                            <th class="item-attribute" style="width: 40%">
                                                <div class="d-flex justify-content-center">
                                                    <div class="btn-group">
                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa @isset($allCondition['item_attribute'])text-warning @endisset" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <input type="text" class="form-control input-text" name="item_attribute" value="{{$allCondition['item_attribute'] ?? ''}}">
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="opt-out2" type="checkbox" name="item_attribute_opt_out" value="1" @isset($allCondition['item_attribute_opt_out']) checked @endisset><label for="opt-out2">Opt Out</label>
                                                            </div>
                                                            @if(isset($allCondition['item_attribute']))
                                                                <div class="individual_clr">
                                                                    <button title="Clear filters" type="button" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </div>
                                                    <div>Item Attribute</div>
                                                </div>
                                            </th>
                                        </form>
                                        <th style="width: 20%;text-align:center">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div>Actions</div> &nbsp; &nbsp;
                                                @if(!isset($allCondition['search_value']) && count($allCondition) > 0)
                                                    <div><a title="Clear filters" href="{{asset('item-profiles')}}" class='btn btn-outline-info'><img src="{{asset('assets/common-assets/25.png')}}"></a></div>
                                                @endif
                                            </div>
                                        </th>
                                        </tr>
                                        </thead>
                                        <tbody id="append_profile_info" class="table-body">
                                        @if(isset($profile_lists) && count($profile_lists) > 0)
                                            @foreach($profile_lists as $key => $profile)
                                                <tr>
                                                    <td class="profile-name text-center" style="cursor: pointer; width: 40%" data-toggle="collapse" data-target="#demo{{$profile->id}}" class="accordion-toggle">
                                                       {{$profile->profile_name ?? ''}}
                                                    </td>
                                                    <td class="item-attribute text-center" style="cursor: pointer; width: 40%" data-toggle="collapse" data-target="#demo{{$profile->id}}" class="accordion-toggle">
                                                        {{$profile->profileTerm->item_attribute ?? ''}}
                                                    </td>
                                                    <td style="width: 20%">
                                                        <div class="btn-group dropup d-flex justify-content-center">
                                                            <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Manage
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <div class="dropup-content catalogue-dropup-content">
                                                                    <div class="action-1">
                                                                        <div class="mr-2"><a class="btn-size edit-btn modify-item-profile" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" data-profile="{{$profile->id}}/{{$profile->item_attribute_id}}" mode="edit" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                                        <div class="mr-2"><a class="btn-size duplicate-btn modify-item-profile" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" data-profile="{{$profile->id}}/{{$profile->item_attribute_id}}" mode="duplicate" title="Duplicate Profile"><i class="fa fa-clone" aria-hidden="true"></i></a></div>
                                                                        <div class="mr-2"><a class="btn-size delete-item-profile delete-btn" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" data-profile="{{$profile->id}}" title="Delete Profile"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="hiddenRow">
                                                        <div class="accordian-body collapse" id="demo{{$profile->id}}">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="card p-2 d-flex justify-content-center">
                                                                        @if (count($profile->itemAttributeProfileTerm) > 0)
                                                                            <h5>Item Attribute Term Value</h5>
                                                                            <div class="card col-md-3">
                                                                                @foreach ($profile->itemAttributeProfileTerm as $profileTerm)
                                                                                    <div class="d-flex d-inline-block justify-content-between">
                                                                                        <strong>{{$profileTerm->itemAttributeTerm->item_attribute_term}}</strong> <p>{{$profileTerm->item_attribute_term_value}}</p>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        @endif
                                                                    </div> <!-- end card -->
                                                                </div> <!-- end col-12 -->
                                                            </div> <!-- end row -->
                                                        </div> <!-- end accordion body -->
                                                    </td> <!-- hide expand td-->
                                                </tr> <!-- hide expand row-->
                                            @endforeach
                                        @else
                                            <tr class="alert alert-danger">
                                                <td colspan="3" class="text-center">
                                                    No Item Profile Found
                                                </td>
                                            </tr>
                                        @endif

                                        </tbody>
                                    </table>
                                    <!--table below pagination sec-->
                                    <div class="row table-foo-sec">
                                        <div class="col-md-6 d-flex justify-content-md-start align-items-center"></div>
                                        <div class="col-md-6">
                                            <div class="d-flex justify-content-md-end align-items-center py-2">
                                                <div class="pagination-area">
                                                    <div class="datatable-pages d-flex align-items-center">
                                                        <span class="displaying-num">{{count($profile_lists)}} items</span>
                                                        <span class="pagination-links d-flex">
                                                            @if($profile_lists->currentPage() > 1)
                                                            <a class="first-page btn {{$profile_lists->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_profile_list->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                                <span class="screen-reader-text d-none">First page</span>
                                                                <span aria-hidden="true">«</span>
                                                            </a>
                                                            <a class="prev-page btn {{$profile_lists->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_profile_list->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                                <span class="screen-reader-text d-none">Previous page</span>
                                                                <span aria-hidden="true">‹</span>
                                                            </a>
                                                            @endif
                                                            <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                            <span class="paging-input d-flex align-items-center">
                                                                <span class="datatable-paging-text d-flex pl-1">{{$all_decode_profile_list->current_page}} of <span class="total-pages">{{$all_decode_profile_list->last_page}}</span></span>
                                                            </span>
                                                            @if($profile_lists->currentPage() !== $profile_lists->lastPage())
                                                            <a class="next-page btn" href="{{$all_decode_profile_list->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                                <span class="screen-reader-text d-none">Next page</span>
                                                                <span aria-hidden="true">›</span>
                                                            </a>
                                                            <a class="last-page btn" href="{{$all_decode_profile_list->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
                        </div> <!--//END card box--->
                    </div> <!-- // col-md-12 -->
                </div> <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div> <!-- content page -->


<div class="modal fade" id="itemProfileModal" tabindex="-1" role="dialog" aria-labelledby="itemProfileLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="itemProfileLabel">Modify Item Attribute Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('save-item-attribute-profile')}}" method="post" id="modify-item-attribute-url">
                @csrf
                <div class="modal-body">
                    <div class="item-profile-info-container">
                        <input type="hidden" name="action_mode" value="" id="item-attribute-action-mode">
                        <input type="hidden" name="item_attribute_profile_id" value="" id="item-attribute-profile-id">
                        <div class="form-group">
                            <label for="profile_name" class="col-form-label required">Profile Name</label>
                            <input type="text" class="form-control" name="profile_name" id="profile_name">
                        </div>
                        <div class="card mb-2 p-2">
                            <div class="form-group col-md-6">
                                <label for="item_attribute" class="col-form-label required">Item Attribute</label>
                                <select class="form-control item-attribute-select" name="item_attribute" id="item_attribute">
                                    
                                </select>
                            </div>
                            <h6>Item Attribute Terms</h6>
                            <div class="form-group row" id="item_attribute_all_term">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
   

    <script>
        // table row expand and collapse
        $('.accordian-body').on('show.bs.collapse', function () {
            $(this).closest("table")
                .find(".collapse.in")
                .not(this)
                .collapse('toggle')
        })
        //End table row expand and collapse
        $(document).ready(function () {
            $('#append_profile_info').on('click','.modify-item-profile',function(){
                var profileId = $(this).attr('data-profile')
                var actionMode = $(this).attr('mode')
                var extractedId = profileId.split('/')
                console.log(extractedId)
                console.log(extractedId[0])
                var url = "{{asset('get-item-profile')}}"+"/"+extractedId[0]+"/"+extractedId[1]
                return fetch(url)
                .then(response => {
                    return response.json()
                })
                .then(data => {
                    console.log(data)
                    if(data.type == 'success'){
                        $('#itemProfileModal #profile_name').val(data.profile.profile_name)
                        $('#itemProfileModal #item_attribute').html('<option value="'+data.profile.profile_term.id+'">'+data.profile.profile_term.item_attribute+'</option>')
                        var itemAttributeTerm = ''
                        if(data.profile.profile_term.item_attribute_terms.length > 0){
                            data.profile.profile_term.item_attribute_terms.forEach(function(pro){
                                var val = pro.item_profile_attribute_term_value ? pro.item_profile_attribute_term_value.item_attribute_term_value : ''
                                itemAttributeTerm += '<div class="col-md-4">'
                                        +'<label for="'+pro.item_attribute_term_slug+'" class="col-form-label">'+pro.item_attribute_term+'</label>'
                                        +'<input type="text" class="form-control" name="attribute_term['+pro.id+']" value="'+val+'">'
                                    +'</div>'
                            })
                        }
                        $('#item-attribute-action-mode').val(actionMode)
                        $('#item-attribute-profile-id').val(profileId)
                        $('#item_attribute_all_term').html(itemAttributeTerm)
                        $('#itemProfileModal').modal('show')
                    }else{
                        Swal.fire('Oops!',data.msg,'error')
                    }
                })
                .catch(error => {
                    console.log(error)
                    Swal.fire('Oops!','Something Went Wrong','error')
                })
            })

            $('#append_profile_info').on('click','.delete-item-profile',function(){
                var profileId = $(this).attr('data-profile')
                var token = "{{csrf_token()}}"
                var dataObj = {
                    "profile_id" : profileId,
                    "_token" : token
                }
                
                Swal.fire({
                    title: 'Are you sure ?',
                    text: 'This will delete all the term value belongs to this profile',
                    icon: 'warning',
                    confirmButtonText: 'Yes',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        var url = "{{url('delete-item-profile')}}"
                        var token = "{{csrf_token()}}"
                        return fetch(url, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(dataObj),
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(error => {
                            Swal.showValidationMessage(
                            `Request failed: ${error}`
                            )
                        })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        if(result.value.type == 'success'){
                            Swal.fire({
                                title: result.value.msg,
                                icon: 'success'
                            })
                            $(this).closest('tr').remove()
                        }else{
                            Swal.fire({
                                title: result.value.msg,
                                icon: 'error'
                            })
                        }
                    }
                })
            })
            $('.individual_clr .clear-params').click(function(){
                $(this).closest('.filter-content').each(function(){
                    $(this).find('input,select').val('')
                    $(this).find('input').prop('checked',false)
                    $('#itemProfileList').submit()
                })
            })
        });
        
        //screen option toggle
        $(document).ready(function(){
            $(".screen-option-btn").click(function(){
                $(".screen-option-content").slideToggle(500);
            });
        });
        
    </script>



@endsection
