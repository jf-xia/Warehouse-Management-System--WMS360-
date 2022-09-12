@extends('master')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<div class="content-page draft-page">
    <div class="content">
        <div class="container-fluid">
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
            <ul class="nav nav-tabs" role="tablist" id="ItemAttributeTab">
                <li class="nav-item text-center" style="width: 50%">
                    <a class="nav-link active" data-toggle="tab" href="#all_item_attribute">
                        All Attribute
                    </a>
                </li>
                <li class="nav-item text-center" style="width: 50%">
                    <a class="nav-link" data-toggle="tab" href="#map_item_term">
                        Map Attribute
                    </a>
                </li>
            </ul>
            <div class="tab-content p-50">
                <div id="all_item_attribute" class="tab-pane active m-b-20">
                    <div class="row">
                        <div class="col-md-2">
                            <h5 class="text-center">Attribute</h5>
                        </div>
                        <div class="col-md-10">
                            <h5 class="text-center">Attribute Term</h5>
                        </div>
                    </div><hr>
                    @if(count($itemAttribute) > 0)
                        @foreach ($itemAttribute as $value)
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="card">
                                        <h5 class="text-center">{{$value->item_attribute ?? ''}}</h5>
                                        <!-- <a href="javascript::void(0)" class="text-center edit-item-attribute" data="edit/{{$value->id}}/{{$value->item_attribute}}" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a> -->
                                        <a href="javascript::void(0)" class="text-center" data-toggle="modal" data-target="#categoryModal{{$value->id}}" title="Edit/Show Category"><i class="fa fa-edit"></i></a>
                                        
                                        <div class="modal fade" id="categoryModal{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="categoryModalTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="categoryModalTitle">Categories for {{$value->item_attribute ?? ''}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body edit-item-attribute-div">
                                                        <form action="{{url('save-item-attribute')}}" method="post">
                                                        @csrf
                                                            <input type="hidden" name="action_type" value="edit">
                                                            <input type="hidden" name="item_type" value="attribute">
                                                            <input type="hidden" name="item_attribute_id" value="{{$value->id}}">
                                                            <div class="form-group form-check m-l-5">
                                                                <input type="checkbox" class="form-check-input all-item-attribute-category" data-id="{{$value->id}}">
                                                                <label class="form-check-label" for="category">Select All Category</label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="item_attribute">Item Attribute</label>
                                                                <input type="text" class="form-control" name="item_attribute" value="{{$value->item_attribute ?? ''}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="category_id">Category</label>
                                                                <select name="category_id[]" id="category_id_{{$value->id}}" class="form-control select2" multiple required>
                                                                    @if (count($categories) > 0)
                                                                        @foreach ($categories as $cat)
                                                                            @if (count($value->categories) > 0)
                                                                                @php
                                                                                    $selected = null;
                                                                                @endphp
                                                                                @foreach ($value->categories as $category)
                                                                                    @if (($cat->id == $category->id))
                                                                                        <option value="{{$category->id}}" selected>{{$category->category_name}}</option>
                                                                                        @php
                                                                                            $selected = 'not null';
                                                                                        @endphp
                                                                                    @endif
                                                                                @endforeach
                                                                                <!-- <div class="row">
                                                                                    @foreach ($value->categories as $category)
                                                                                        <div class="col-md-4 border border-secondary">{{$category->category_name ?? ''}}</div>
                                                                                    @endforeach
                                                                                </div> -->
                                                                            @endif
                                                                            @if ($selected == null)
                                                                                <option value="{{$cat->id}}">{{$cat->category_name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <button type="submit" class="btn btn-success btn-sm">Update</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-2">
                                        <button class="btn btn-outline-default" data-toggle="modal" data-target="#itemProfileModal{{$value->id}}">Add Profile</button>
                                        <div class="modal fade" id="itemProfileModal{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="itemProfileLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="itemProfileLabel">Add Item Attribute Profile</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{url('save-item-attribute-profile')}}" method="post">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="item-profile-info-container">
                                                                <div class="form-group">
                                                                    <label for="profile_name" class="col-form-label required">Profile Name</label>
                                                                    <input type="text" class="form-control" name="profile_name" id="profile_name">
                                                                </div>
                                                                <div class="card mb-2 p-2">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="item_attribute" class="col-form-label required">Item Attribute</label>
                                                                        <select class="form-control item-attribute-select" name="item_attribute">
                                                                            <option value="{{$value->id}}">{{$value->item_attribute}}</option>
                                                                        </select>
                                                                    </div>
                                                                    <h6>Item Attribute Terms</h6>
                                                                    <div class="form-group row">
                                                                        @if(count($value->itemAttributeTerms) > 0)
                                                                            @foreach ($value->itemAttributeTerms as $term)
                                                                            <div class="col-md-4">
                                                                                <label for="{{$term->item_attribute_term_slug}}" class="col-form-label">{{$term->item_attribute_term}}</label>
                                                                                <input type="text" class="form-control" name="attribute_term[{{$term->id}}]">
                                                                            </div>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="card p-3">
                                        <div class="row">
                                            @if(count($value->itemAttributeTerms) > 0)
                                                @foreach ($value->itemAttributeTerms as $term)
                                                    <div class="card col-md-4 d-inline mb-1 attr-term-div pb-1 mr-1">
                                                        <div class="align-item-center">
                                                    <div class="float-left">
                                                            <P>{{$term->item_attribute_term}}</P>
                                                        </div>
                                                        <div class="float-right attr-term-div-action hide">
                                                            <button class="btn btn-success btn-sm edit-term" data="{{$term->id}}/{{$term->item_attribute_term}}"><i class="fa fa-edit"></i></button>
                                                            <button class="btn btn-danger btn-sm remove-term" data="{{$term->id}}"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-outline-info btn-sm add-tab-title-term float-right" data="{{$value->id}}" data-toggle="modal" data-target="#tabTitleTermModal">
                                                Add Attribute Term
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div><br><hr>
                        @endforeach
                        <!-- <button class="btn btn-primary add-attribute">Add Title</button> -->
                        
                    @endif
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tabTitleModal">
                        Add Attribute
                    </button>
                </div>
                <div id="map_item_term" class="tab-pane m-b-20">
                    <form action="{{url('save-mapping-item-term')}}" method="post">
                    @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <h5 class="text-center">Map Attribute</h5>
                                    <div class="p-10 item-term-mapping-div">
                                        <div class="mb-2">
                                            <select name="channel" id="channel" class="form-control" required>
                                                <option value="">Select Channel</option>
                                                @if (count($channels) > 0)
                                                    @foreach ($channels as $channel)
                                                        <option value="{{$channel->id}}">{{$channel->channel}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <select name="map_item_attribute" id="map_item_attribute" class="form-control" required>
                                                <option value="">Select Item Attribute</option>
                                                @if(count($itemAttribute) > 0)
                                                    @foreach ($itemAttribute as $value)
                                                        <option value="{{$value->id}}">{{$value->item_attribute}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="text-danger text-center exist-attr-message"></div>
                                        </div>
                                        <div class="d-flex justify-content-around bg-primary text-white">
                                            <h7>Master Attribute</h7>
                                            <h7>Channel Field</h7>
                                        </div>
                                        <hr>
                                        <div class="item_attribute_channel_field_div" style="max-height: 400px; overflow-x: auto"></div>
                                        <!-- <div class="input-group mb-3 attribute-channel-field-div">
                                            <select name="master_terms[]" id="master_terms" class="form-control">
                                                @if(count($itemAttributeTerms) > 0)
                                                    @foreach ($itemAttributeTerms as $value)
                                                        <option value="{{$value->id}}">{{$value->item_attribute_term ?? ''}} ({{$value->itemAttribute->item_attribute ?? ''}})</option>
                                                    @endforeach()
                                                @endif
                                            </select>
                                            <input type="text" name="channel_field[]" class="form-control" placeholder="Enter Channel Field Value">
                                            <button type="button" class="btn btn-danger btn-sm remove-more-item-mapping-term"><i class="fa fa-remove"></i></button>
                                        </div> -->
                                    </div>
                                    <!-- <div class="w-25 mb-3">
                                        <button type="button" class="btn btn-primary btn-sm add-more-item-term-mapping">Add More</button>
                                    </div> -->
                                    <button type="submit" class="btn btn-success map-field-submit-btn btn-sm d-none">Submit</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card table-responsive" style="max-height: 400px;">
                                    <h5 class="text-center">Channel Mapping Field Info</h5>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Channel Field</th>
                                                <th>Master Field</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="channel-map-field-div">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="tabTitleModal" tabindex="-1" role="dialog" aria-labelledby="tabTitleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tabTitleModalLabel">Tab Title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body tab-title-div">
        <form action="{{url('save-item-attribute')}}" method="post">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card p-2">
                        <input type="hidden" name="action_type" value="add">
                        <div class="form-group form-check m-l-5">
                            <input type="checkbox" class="form-check-input" id="checkbox">
                            <label class="form-check-label" for="category">Select All Category</label>
                        </div>
                        <div class="mb-2">
                            <select name="category_id[]" id="category_id" class="form-control select2" multiple required>
                                @if (count($categories) > 0)
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="p-10 item-attribute-div">
                            <div class="input-group mb-3">
                                <input type="text" name="item_attribute[]" class="form-control" placeholder="Tab Title" required>
                                <!-- <select name="item_status[]" id="item_status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">InActive</option>
                                </select> -->
                                <button type="button" class="btn btn-danger btn-sm remove-more-item-attribute" disabled><i class="fa fa-remove"></i></button>
                            </div>
                        </div>
                        <div class="w-25 mb-3">
                            <button type="button" class="btn btn-primary btn-sm add-more-item-attribute">Add More</button>
                        </div>
                        <input type="hidden" name="item_type" value="attribute">
                        <button type="submit" class="btn btn-success btn-sm">Save</button>
                    </div>
                </div>
            </div>
        </form>
      </div>
      
    </div>
  </div>
</div>
<div class="modal fade" id="tabTitleTermModal" tabindex="-1" role="dialog" aria-labelledby="tabTitleTermModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tabTitleModalLabel">Add Attribute Term</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body tab-title-term-div">
        <form action="{{url('save-item-attribute')}}" method="post">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card p-2">
                        <div class="item-attribute-term-div">
                            <!-- <div class="input-group mb-3">
                                <select name="item_attribute" class="form-control" id="item_attribute" required>
                                    @if(count($itemAttribute) > 0)
                                        <option value="">Select Attribute</option>
                                        @foreach ($itemAttribute as $value)
                                            <option value="{{$value->id}}">{{$value->item_attribute ?? ''}}
                                            </option>
                                        @endforeach()
                                    @endif
                                </select>
                            </div>   -->
                            <input type="hidden" class="item_attribute" name="item_attribute" value="">
                            <div class="input-group mb-3">
                                <input type="text" name="item_attribute_term[]" class="form-control" placeholder="Enter Attribute Term" required>
                                <!-- <select name="item_status[]" id="item_status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">InActive</option>
                                </select> -->
                                <button type="button" class="btn btn-danger btn-sm remove-more-item-attribute-term" disabled><i class="fa fa-remove"></i></button>
                            </div>
                        </div>
                        <div class="w-25 mb-3">
                            <button type="button" class="btn btn-primary btn-sm add-more-item-attribute-term">Add More</button>
                        </div>
                        <input type="hidden" name="item_type" value="attribute-term">
                        <button type="submit" class="btn btn-success btn-sm">Submit</button>
                    </div>
                </div>
            </div>
        </form>
      </div>
      
    </div>
  </div>
</div>
<script>
    $(".select2").select2();
    $(".tab-title-div #category_id").select2({
        placeholder: 'Select Cateogory',
    });
    
    $(document).ready(function(){
        $(".tab-title-div #checkbox").click(function(){
            if($(this).is(':checked') ){
                $(".tab-title-div #category_id > option").prop("selected","selected");// Select All Options
                $(".tab-title-div #category_id").trigger("change");// Trigger change to select 2
            }else{
                $('.tab-title-div #category_id').val(null).trigger('change');
                // $("#category_id > option").removeAttr("selected");
                // $("#category_id").trigger("change");// Trigger change to select 2
            }
        });

        $(".all-item-attribute-category").click(function(){
            var itemAttributeId = $(this).attr('data-id')
            console.log(itemAttributeId)
            if($(this).is(':checked') ){
                $(".edit-item-attribute-div #category_id_"+itemAttributeId+" > option").prop("selected","selected");// Select All Options
                $(".edit-item-attribute-div #category_id_"+itemAttributeId).trigger("change");// Trigger change to select 2
            }else{
                $('.edit-item-attribute-div #category_id_'+itemAttributeId).val(null).trigger('change');
            }
        });

        $('select#channel').on('change',function(){
            let channelId = $(this).val()
            let url = "{{asset('channel-map-field')}}"
            let token = "{{csrf_token()}}"
            let data = {
                'channel_id': channelId,
                '_token': token
            }
            return fetch(url,{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                var content = ''
                if(data.length > 0){
                    data.forEach(function(field){
                        content += '<tr>'
                                        +'<td>'+field.mapping_field+'</td>'
                                        +'<td>'+field.attribute_terms.item_attribute_term+' ('+field.attribute_terms.item_attribute.item_attribute+')'+'</td>'
                                        +'<td class="d-flex">'
                                            +'<button type="button" class="btn btn-success modify-mapping-field" data="edit/'+field.id+'"><i class="fa fa-edit"></i></button>'
                                            +'<button type="button" class="btn btn-danger modify-mapping-field ml-1" data="delete/'+field.id+'"><i class="fa fa-trash"></i></button>'
                                        +'</td>'
                                    +'</tr>'
                    });
                }else{
                    content += '<tr><td colspan="4" class="alert alert-danger text-center">No Mapping Field Found</td></tr>'
                }
                $('tbody.channel-map-field-div').html(content)
            })
            .catch(error => console.log(error))
        })
        $(".add-more-item-term-mapping").click(function(){
            $(".attribute-channel-field-div").eq(0).clone().find('input').val('').end().show().insertAfter(".attribute-channel-field-div:last");
        });
        $('#map_item_term').on('click','.remove-more-item-mapping-term',function(){
            $(this).closest('div').remove()
            var totalTerms = $('.item_attribute_channel_field_div').find('select').length
            if(totalTerms > 0){
                $('#map_item_term').find('.map-field-submit-btn').removeClass('d-none').addClass('d-block')
            }else{
                $('#map_item_term').find('.map-field-submit-btn').removeClass('d-block').addClass('d-none')
            }
        })
        $('.add-more-item-attribute').click(function(){
            let itemAttrContainer = '<div class="input-group mb-3">'
                                    +'<input type="text" name="item_attribute[]" class="form-control" placeholder="Tab Title" required>'
                                    // +'<select name="item_status[]" id="item_status" class="form-control">'
                                    //     +'<option value="1">Active</option>'
                                    //     +'<option value="0">InActive</option>'
                                    // +'</select>'
                                    +'<button type="button" class="btn btn-danger btn-sm remove-more-item-attribute"><i class="fa fa-remove"></i></button>'
                                +'</div>'
            $('.item-attribute-div').append(itemAttrContainer)
        })

        $('.item-attribute-div').on('click','.remove-more-item-attribute',function(){
            $(this).closest('div').remove()
        })

        $('.add-more-item-attribute-term').click(function(){
            let itemAttrTermContainer = '<div class="input-group mb-3">'
                                    +'<input type="text" name="item_attribute_term[]" class="form-control" placeholder="Enter Attribute Term" required>'
                                    // +'<select name="item_status[]" id="item_status" class="form-control">'
                                    //     +'<option value="1">Active</option>'
                                    //     +'<option value="0">InActive</option>'
                                    // +'</select>'
                                    +'<button type="button" class="btn btn-danger btn-sm remove-more-item-attribute-term"><i class="fa fa-remove"></i></button>'
                                +'</div>'
            $('.item-attribute-term-div').append(itemAttrTermContainer)
        })

        $('.item-attribute-term-div').on('click','.remove-more-item-attribute-term',function(){
            $(this).closest('div').remove()
        })

        $('button.edit-term').click(function(){
            var inputVal = $(this).attr('data').split('/')
            Swal.fire({
            title: 'Edit Attribute',
            input: 'text',
            inputValue: inputVal[1],
            showCancelButton: true,
            confirmButtonText: 'Update',
            showLoaderOnConfirm: true,
            preConfirm: (value) => {
                let url = "{{url('/edit-item-term')}}"
                let token = "{{csrf_token()}}"
                let dataObj = {
                    "id" : inputVal[0],
                    "term" : value,
                    "_token" : token
                }
                    //return false
                return fetch(url, {
                    method: 'POST', // or 'PUT'
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
                    }else{
                        Swal.fire({
                            title: result.value.msg,
                            icon: 'error'
                        })
                    }
                    // setTimeout(() => {
                    //     window.location.reload()
                    // }, 2000);
                }
            })
        })
        
        $('button.remove-term').click(function(){
            var termId = $(this).attr('data')
            Swal.fire({
            title: 'Are You Sure To Delete It?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            showLoaderOnConfirm: true,
            preConfirm: (value) => {
                let url = "{{url('/delete-item-term')}}"
                let token = "{{csrf_token()}}"
                let dataObj = {
                    "id" : termId,
                    "_token" : token
                    }
                    //return false
                return fetch(url, {
                    method: 'POST', // or 'PUT'
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
                    }else{
                        Swal.fire({
                            title: result.value.msg,
                            icon: 'error'
                        })
                    }
                    // setTimeout(() => {
                    //     window.location.reload()
                    // }, 2000);
                }
            })
        })

        $('.channel-map-field-div').on('click','.modify-mapping-field',function(){
            var dataVal = $(this).attr('data').split('/')
            var mapId = dataVal[1]
            var actionType = dataVal[0]
            var channelId = $('#channel').val()
            var url = ''
            var token = "{{csrf_token()}}"
            var dataObj = {
                "map_id" : mapId,
                "type" : "delete",
                "_token" : token
            }
            if(actionType == 'delete'){
                Swal.fire({
                    title: 'Are You Sure To Delete This ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        var url = "{{url('modify-mapping-field')}}"
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
                        }else{
                            Swal.fire({
                                title: result.value.msg,
                                icon: 'error'
                            })
                        }
                        // setTimeout(() => {
                        //     window.location.reload()
                        // }, 2000);
                    }
                })
                return false
            }else{
                var url = "{{url('/get-mapping-field')}}"
            }
            return fetch(url, {
                method: 'POST', // or 'PUT'
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
            .then(data => {
                var html = '<div class="form-group">'
                +'<label for="master_attribute">Master Attribute</label>'
                +'<select class="form-control" name="master_terms" id="master_terms">'
                if(data.all_field.length > 0){
                    data.all_field.forEach(function(field){
                        var selectOption = field.id == data.map_info.attribute_term_id ? 'selected' : ''
                        html += '<option value="'+field.id+'" '+selectOption+'>'+field.item_attribute_term+'</option>'
                    })
                }
                html += '</select></div>'
                +'<div class="form-group">'
                +'<label for="channel_field">Channel Field</label>'
                +'<input type="text" class="form-control" name="channel_field" id="channel_field" value="'+data.map_info.mapping_field+'" placeholder="Enter Channel Field Value">'
                +'</div>'

                Swal.fire({
                    title: 'Edit Mapping Info',
                    icon: 'info',
                    html: html,
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    showLoaderOnConfirm: true,
                    preConfirm: (value) => {
                        let newAttributeTerm = Swal.getPopup().querySelector('#master_terms').value
                        let newMappingField = Swal.getPopup().querySelector('#channel_field').value
                        let url = "{{url('modify-mapping-field')}}"
                        let token = "{{csrf_token()}}"
                        let formObj = {
                            "map_id" : mapId,
                            "attribute_term" : newAttributeTerm,
                            "mapping_field" : newMappingField,
                            "channel_id" : channelId,
                            "type" : "edit",
                            "_token" : token
                        }
                        return fetch(url, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(formObj),
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
                        }else{
                            Swal.fire({
                                title: result.value.msg,
                                icon: 'error'
                            })
                        }
                        // setTimeout(() => {
                        //     window.location.reload()
                        // }, 2000);
                    }
                })
            })
            .catch(error => {
                Swal.showValidationMessage(
                `Request failed: ${error}`
                )
            })
            
        })
        $('.add-tab-title-term').click(function(){
            var tabTitleId = $(this).attr('data')
            $('.item-attribute-term-div .item_attribute').val(tabTitleId)
            // $('.item-attribute-term-div select#item_attribute > option').each(function(){
            //     if((this.value == tabTitleId) && (this.value != '')){
            //         $(this).attr('selected',true)
            //     }else{
            //         $(this).attr('selected',false)
            //     }
            // })
        })
        $(".attr-term-div").hover(function(){
            $(this).find(".attr-term-div-action").fadeIn();
        }
        ,function(){
            $(this).find(".attr-term-div-action").fadeOut();
        }
        );

        $('a.edit-item-attribute').on('click',function(e){
            e.preventDefault();
            var itemAttributeSplit = $(this).attr('data').split('/')
            var actionType = itemAttributeSplit[0]
            var itemAttributeId = itemAttributeSplit[1]
            var itemAttribute = itemAttributeSplit[2]
            Swal.fire({
                title: 'Edit Attribute',
                input: 'text',
                inputValue: itemAttribute,
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: 'Update',
                showLoaderOnConfirm: true,
                preConfirm: (inputValue) => {
                    if(inputValue == ''){
                        Swal.showValidationMessage('Enter Attribute')
                        return false
                    }
                    var url = "{{url('update-item-attribute')}}"
                    var token = "{{csrf_token()}}"
                    var dataObj = {
                        "_token": token,
                        "attribute_id": itemAttributeId,
                        "item_attribute": inputValue
                    }
                    return fetch(url,{
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(dataObj)
                    })
                    .then(response => {
                        console.log(response)
                        return response.json()
                    })
                    .then(data => {
                        console.log(data)
                        if(data.type == 'success'){
                            Swal.fire('Success',data.msg,'success')
                        }else{
                            Swal.fire('Oops!',data.msg,'error')
                        }
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Request Failed: ${error}`)
                    })
                }
            })
        })

        $('select#map_item_attribute').on('change',function(){
            var attrId = $(this).val()
            if(attrId == '') {
                return false
            }
            var existDiv = $('.item_attribute_channel_field_div').find('.attr-div-'+attrId).length
            if(existDiv > 0) {
                $('.exist-attr-message').html('Already Chosen')
                return false
            }else{
                $('.exist-attr-message').html('')
            }
            var url = "{{url('get-item-attribute-term')}}"+"/"+attrId
            return fetch(url)
            .then(response => {
                if (!response.ok) {
                    Swal.fire('Oops!','Something Went Wrong','error')
                    return false
                }
                return response.json()
            })
            .then(data => {
                if(data.type == 'success'){
                    var html = ''
                    if(data.attribute.item_attribute_terms.length > 0){
                        data.attribute.item_attribute_terms.forEach(function(attr){
                            html += '<div class="input-group mb-3 attribute-channel-field-div attr-div-'+data.attribute.id+'"><select name="master_terms[]" id="master_terms" class="form-control">'
                                    + '<option value="'+attr.id+'">'+attr.item_attribute_term+' ('+data.attribute.item_attribute+')</option>'
                                +'</select>'
                                +'<input type="text" name="channel_field[]" class="form-control" placeholder="Enter Channel Field Value" required>'
                                +'<button type="button" class="btn btn-danger btn-sm remove-more-item-mapping-term"><i class="fa fa-remove"></i></button></div>'
                            
                        })
                        $('div.item_attribute_channel_field_div').append(html)
                        var totalTerms = $('.item_attribute_channel_field_div').find('select').length
                        if(totalTerms > 0){
                            $('#map_item_term').find('.map-field-submit-btn').removeClass('d-none').addClass('d-block')
                        }
                    }else{
                        //$('#map_item_term').find('.map-field-submit-btn').removeClass('d-block').addClass('d-none')
                        Swal.fire('Oops!','No Data Found','warning')
                        return false
                    }
                    
                }else{
                    Swal.fire('Oops!',data.msg,'error')
                }
            })
            .catch(error => {
                Swal.fire('Oops!','Something Went Wrong','error')
            })
        })
    })
</script>
@endsection
