
@extends('master')

@section('title')
    Catalogue | Defected Product | WMS360
@endsection

@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- <div class="d-flex justify-content-center align-items-center">
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item">Catalogue</li>
                        <li class="breadcrumb-item active" aria-current="page">Defected Product</li>
                    </ol>
                </div> -->

                <div class="wms-breadcrumb wms-breadcrumb-flex-wrap">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Inventory</li>
                            <li class="breadcrumb-item active" aria-current="page">Defected Product</li>
                        </ol>
                    </div>
                    <div class="btn-group inner-flex-wrap" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-default waves-effect waves-light" id="defectReasonBtn">Defect Reasons</a>
                        <button type="button" class="btn btn-default waves-effect waves-light" id="defectProductBtn">Defect Product Action</a>
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
                        <div class="shadow">
                            <ul class="nav nav-tabs sorted-order-navs" role="tablist">
                                <li class="nav-item w-50 text-center">
                                    <a class="nav-link active" data-toggle="tab" href="#receive_defect_product">Receive Defect Product</a>
                                </li>
                                <li class="nav-item w-50 text-center">
                                    <a class="nav-link" data-toggle="tab" href="#declare_defect_product">Declare Defect Product</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="receive_defect_product" class="tab-pane active m-b-20"><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="defected-product-table w-100">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Image</th>
                                                            <th class="text-center">Product Name</th>
                                                            <th class="text-center">Quantity</th>
                                                            <th class="text-center">SKU</th>
                                                            <th class="text-center">EAN</th>
                                                            <th class="text-center">Total Price</th>
                                                            <th class="text-center">Invoice No.</th>
                                                            <th class="text-center">Received</th>
                                                            <th class="text-center">Vendor</th>
                                                            <th class="text-center">Received By</th>
                                                            <th class="text-center">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($all_defected_product_list as $defected_product)
                                                        <tr>
                                                            @if(isset($defected_product->product_variation_info->image))
                                                                <td class="text-center"><a href="{{$defected_product->product_variation_info->image}}" target="_blank"><img class="rounded" src="{{$defected_product->product_variation_info->image}}" height="60" width="60" alt="Defected Product Image"></a></td>
                                                            @else
                                                                <td class="text-center"><img class="rounded" src="{{asset('assets/images/users/no_image.jpg')}}" height="60" width="60" alt="Defected Product Image"></td>
                                                            @endif
                                                            <td class="text-center">@isset($defected_product->product_variation_info->product_draft_id){{$defected_product->product_variation_info->product_draft->name ?? ''}}@endisset</td>
                                                            <td class="text-center">{{$defected_product->quantity ?? ''}}</td>
                                                            <td class="text-center">{{$defected_product->product_variation_info->sku ?? ''}}</td>
                                                            <td class="text-center">{{$defected_product->product_variation_info->ean_no ?? ''}}</td>
                                                            <td class="text-center">{{$defected_product->total_price ?? ''}}</td>
                                                            <td class="text-center">{{$defected_product->product_invoice_info->invoice_number ?? ''}}</td>
                                                            <td class="text-center">{{$defected_product->product_invoice_info->receive_date ?? ''}}</td>
                                                            <td class="text-center">{{$defected_product->product_invoice_info->vendor_info->company_name ?? ''}}</td>
                                                            <td class="text-center">{{$defected_product->product_invoice_info->user_info->name ?? ''}}</td>
                                                            <td class="text-center">
                                                                @if($defected_product->product_type == 0)
                                                                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Make sell"><button class="btn btn-primary" id="sell{{$defected_product->id}}" onclick="sell_defected_product({{$defected_product->id}});">Sell</button></a>
                                                                @else
                                                                        <button class="btn btn-success">Sold</button>
                                                                @endif
                                                                <button class="btn btn-success" id="sold{{$defected_product->id}}" style="display: none;">Sold</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div> <!-- end row -->
                                </div>
                                <div id="declare_defect_product" class="tab-pane m-b-20"><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                        <form action="{{url('download-declare-defect-csv')}}" method="post">
                                            @csrf
                                            <div class="col-md-6 float-right input-group mb-2">
                                                
                                                    <input type="date" name="start_date" class="form-control start-date mr-2">
                                                    <input type="date" name="end_date" class="form-control end-date mr-2">
                                                    <select name="action" id="action" class="form-control mr-2">
                                                        <option value="">Select Action</option>
                                                        @if(isset($defectActionList))
                                                            @foreach($defectActionList as $action)
                                                                <option value="{{$action->id}}">{{$action->action}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <button type="submit" class="btn btn-primary export ">Export CSV</button>
                                                
                                            </div>
                                        </form>
                                            <div class="table-responsive">
                                                <table class="defected-product-table w-100">
                                                    <thead>
                                                    <tr class="bg-info">
                                                        <th class="text-center">Image</th>
                                                        <th class="text-center">Product Name</th>
                                                        <th class="text-center">SKU</th>
                                                        <th class="text-center">Variation</th>
                                                        <th class="text-center">Quantity</th>
                                                        <th class="text-center">Reason</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($declareDefectProductList as $declare_defected_product)
                                                        <tr id="action-row-{{$declare_defected_product->id}}">
                                                            <td class="text-center">
                                                                <a href="{{$declare_defected_product->variationInfo->image ?? ((filter_var($declare_defected_product->variationInfo->product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$declare_defected_product->variationInfo->product_draft->single_image_info->image_url : $declare_defected_product->variationInfo->product_draft->single_image_info->image_url)}}" target="_blank">
                                                                    <img class="rounded" src="{{$declare_defected_product->variationInfo->image ?? ((filter_var($declare_defected_product->variationInfo->product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$declare_defected_product->variationInfo->product_draft->single_image_info->image_url : $declare_defected_product->variationInfo->product_draft->single_image_info->image_url)}}" height="60" width="60" alt="Defected Product Image">
                                                                </a>
                                                            </td>
                                                            <td class="text-center">{{$declare_defected_product->variationInfo->product_draft->name}}</td>
                                                            <td class="text-center">{{$declare_defected_product->variationInfo->sku ?? ''}}</td>
                                                            @php
                                                                $attributeArr = unserialize($declare_defected_product->variationInfo->attribute);
                                                                $attribute = '';
                                                                if(is_array($attributeArr)){
                                                                    foreach($attributeArr as $attr){
                                                                        $attribute .= $attr['terms_name'].',';
                                                                    }
                                                                }
                                                                $attribute = rtrim($attribute,',');
                                                            @endphp
                                                            <td class="text-center">{{$attribute}}</td>
                                                            <td class="text-center">{{$declare_defected_product->defected_product ?? ''}}</td>
                                                            <td class="text-center reason">{{$declare_defected_product->defectReason->reason ?? ''}}</td>
                                                            <td class="text-center">
                                                            <select name="defect_action" class="defect_action form-control" id="defect_action">
                                                                    <option value="">Select Action</option>
                                                                    @if(isset($defectActionList))
                                                                        @foreach($defectActionList as $action)
                                                                            <option value="{{$declare_defected_product->id}}/{{$action->id}}">{{$action->action}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                    
                                                            </select>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div> <!-- end row -->
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- end card box -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->



    <!---- Defect Reason Modal---------
    ------------------------------------->
    <div id="defectReasonModal" class="defect-reason-modal">
        <!-- Modal content -->
        <div class="defect-reason-modal-content">
            <div class="defect-reason-modal-header">
                <div class="row" style="width: -webkit-fill-available;">
                    <div class="col-md-6 d-flex align-items-center">Defect Reasons</div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <div class="defect-reason-close">×</div>
                    </div>
                </div>
            </div>
            <div class="defect-reason-modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <button type="success" class="btn btn-success m-b-10 add" data-type="defectReason">Add <i class="fa fa-plus"></i></button>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Reason</th>
                                        <th>Create Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="defectReason">
                                @if(isset($allDefectReasons))
                                    @foreach($allDefectReasons as $reason)
                                        <tr>
                                            <td> {{$reason->reason ?? ''}} </td>
                                            <td> {{date('d-m-Y', strtotime($reason->created_at))}}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <button type="button" class="btn-size edit-btn edit mr-1" style="cursor: pointer" data-type="defectReason" action-id="{{$reason->id}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></button>
                                                    <button type="button" class="btn-size delete-btn delete" style="cursor: pointer" data-type="defectReason" action-id="{{$reason->id}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div>
        </div>
    </div>  
    
    

    <!---- Defect Product Action Modal---------
    ------------------------------------->
    <div id="defectProductModal" class="defect-product-modal">
        <!-- Modal content -->
        <div class="defect-product-modal-content">
            <div class="defect-product-modal-header">
                <div class="row" style="width: -webkit-fill-available;">
                    <div class="col-md-6 d-flex align-items-center">Defect Product Action</div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <div class="defect-product-close">×</div>
                    </div>
                </div>
            </div>
            <div class="defect-product-modal-body">
                <div class="row">
                    <div class="col-md-12">
                    <button type="success" class="btn btn-success m-b-10 add" data-type="defectAction">Add <i class="fa fa-plus"></i></button>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Reason</th>
                                        <th>Create Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="defectAction">
                                @if(isset($allDefectActions))
                                    @foreach($allDefectActions as $action)
                                        <tr>
                                            <td> {{$action->action ?? ''}} </td>
                                            <td> {{date('d-m-Y', strtotime($action->created_at))}}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <button type="button" class="btn-size edit-btn edit mr-1" style="cursor: pointer" data-type="defectAction" action-id="{{$action->id}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></button>
                                                    <button type="button" class="btn-size delete-btn delete" style="cursor: pointer" data-type="defectAction" action-id="{{$action->id}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>   
                </div>                                    
            </div>
        </div>
    </div>  



    <script type="text/javascript">

        //Defect Reason, Defect Product Modal   
        var defectReasonModal = document.getElementById("defectReasonModal");
        var defectProductModal = document.getElementById("defectProductModal");
        var defectReasonBtn = document.getElementById("defectReasonBtn");
        var defectProductBtn = document.getElementById("defectProductBtn");
        var defectReasonClose = document.getElementsByClassName("defect-reason-close")[0];
        var defectProductClose = document.getElementsByClassName("defect-product-close")[0];
        defectReasonBtn.onclick = function() {
            defectReasonModal.style.display = "block";
        }
        defectProductBtn.onclick = function() {
            defectProductModal.style.display = "block";
        }
        defectReasonClose.onclick = function() {
            defectReasonModal.style.display = "none";
        }
        defectProductClose.onclick = function() {
            defectProductModal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == defectReasonModal) {
                defectReasonModal.style.display = "none";
            }
        }
        window.onclick = function(event) {
            if (event.target == defectProductModal) {
                defectProductModal.style.display = "none";
            }
        }
        //End Defect Reason, Defect Product Modal
    
        $(document).ready(function() {
            $('select#defect_action').change(function(){
                let id = $(this).val().split('/')
                if(id == ''){
                    return false
                }
                fetch("{{asset('change-defect-product-status')}}"+"/"+id[0]+"/"+id[1])
                .then(res => {
                    return res.json()
                })
                .then(data => {
                    if(data.type == 'success'){
                        $('div#declare_defect_product tbody tr#action-row-'+id[0]).remove();
                        Swal.fire({
                            position: 'top-end',
                            title: 'Success',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                })
                .catch(error => {
                    Swal.fire('Oops!',error,'error')
                })
            })
        } );


        function sell_defected_product(id) {
            console.log(id);
            $.ajax({
                type:'POST',
                url:'{{url('/sell-defected-product-ajax')}}',
                data:{
                    "_token":"{{csrf_token()}}",
                    "id":id,
                },
                success:function (response) {
                    console.log(response.data);
                    document.getElementById('sell'+id).style.display="none";
                    document.getElementById('sold'+id).style.display="block";

                }
            });
        }




        $(document).ready(function() {
            $('.add').on('click',function(){
                let actionType = $(this).attr('data-type')
                if(actionType == 'defectReason'){
                    var url = "{{asset('defect-reason/a/add')}}"
                    var title = 'Add Defect Reason'
                }else{
                    var url = "{{asset('defect-action/a/add')}}"
                    var title = 'Add Defect Product Action'
                }
                Swal.fire({
                    title: title,
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Add',
                    confirmButtonColor: '#3085d6',
                    showLoaderOnConfirm: true,
                    preConfirm: (value) => {
                        if(value == ''){
                            Swal.showValidationMessage(`Please Enter Value`)
                            return false
                        }
                        return fetch(url,{
                            method: 'POST',
                            headers: {
                                "Content-Type": "application/json",
                                'X-CSRF-TOKEN': "{{csrf_token()}}"
                            },
                            body: JSON.stringify({input_value: value})
                        })
                        .then(res => {
                            return res.json()
                        })
                        .then((result) => {
                            if(result.type == 'success'){
                                defectReasonAction(result.response_data, actionType)
                                Swal.fire('Success',result.msg,'success')
                            }else{
                                Swal.showValidationMessage(`${result.msg}`)
                                //Swal.fire('Oops!',result.msg,'error')
                            }
                        })
                        .catch(error => {
                            Swal.showValidationMessage(`Something Went Wrong: ${error}`)
                        })
                    }
                })
            })
        });

        $(document).on('click','.edit',function(){
            let actionType = $(this).attr('data-type')
            if(actionType == 'defectReason'){
                var url = "{{asset('defect-reason/a/edit')}}"
                var title = 'Edit Defect Reason'
            }else{
                var url = "{{asset('defect-action/a/edit')}}"
                var title = 'Edit Defect Action'
            }
            let action_value = $(this).parent().siblings(':first').text()
            let actionId = $(this).attr('action-id')
            let html = '<input type="text" class="form-control" name="input_value" id="input_value" value="'+action_value+'">'
            Swal.fire({
                title: title,
                html: html,
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: 'Update',
                confirmButtonColor: '#3085d6',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    let value = Swal.getPopup().querySelector('#input_value').value
                    if(value == ''){
                        Swal.showValidationMessage(`Please Enter Vlaue`)
                        return false
                    }
                    return fetch(url+"/"+actionId,{
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            'X-CSRF-TOKEN': "{{csrf_token()}}"
                        },
                        body: JSON.stringify({input_value: value, action_id: actionId})
                    })
                    .then(res => {
                        return res.json()
                    })
                    .then((result) => {
                        if(result.type == 'success'){
                            $(this).parent().siblings(":first").text(value)
                            Swal.fire('Success',result.msg,'success')
                        }else{
                            Swal.showValidationMessage(`${result.msg}`)
                            //Swal.fire('Oops!',result.msg,'error')
                        }
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Something Went Wrong: ${error}`)
                    })
                }
            })
        })

        $(document).on('click','.delete',function(){
            let actionType = $(this).attr('data-type')
            if(actionType == 'defectReason'){
                var url = "{{asset('defect-reason/a/delete')}}"
            }else{
                var url = "{{asset('defect-action/a/delete')}}"
            }
            let actionId = $(this).attr('action-id')
            Swal.fire({
                title: 'Are You Sure To Delete This?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete',
                confirmButtonColor: '#3085d6',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch(url+"/"+actionId)
                    .then(res => {
                        return res.json()
                    })
                    .then((result) => {
                        if(result.type == 'success'){
                            $(this).closest('tr').remove()
                            Swal.fire('Success',result.msg,'success')
                        }else{
                            Swal.fire('Oops!',result.msg,'error')
                        }
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Something Went Wrong: ${error}`)
                    })
                }
            })
        })
        
        function defectReasonAction(responseData, actionType){
            let date = new Date(responseData.created_at)
            let dataValue = responseData.reason ?? responseData.action
            var html = '<tr>'+
                            '<td>'+dataValue+'</td>'+
                            '<td>'+date.getDate()+'-'+(date.getMonth()+1)+'-'+date.getFullYear()+'</td>'+
                            '<td>'+
                                '<button type="button" class="btn-size edit-btn edit mr-1" style="cursor: pointer" data-type="'+actionType+'" action-id="'+responseData.id+'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></button>'+
                                '<button type="button" class="btn-size delete-btn delete" style="cursor: pointer" data-type="'+actionType+'" action-id="'+responseData.id+'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>'+
                            '</td>'+
                        '</tr>'
            $('table tbody#'+actionType).prepend(html);
        }

    </script>


@endsection
