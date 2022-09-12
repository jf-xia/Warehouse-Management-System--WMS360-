@extends('master')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Page-Title -->
                <div class="card-box">
                    <div class="col-md-12 text-center">
                        <div class="">
                            <h4>Defected Reason List</h4>
                        </div>
                    </div>
                </div>

                <div class="card-box m-t-20 shadow">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item w-50 text-center">
                            <a class="nav-link active" data-toggle="tab" href="#defect_reason">Defect Reasons</a>
                        </li>
                        <li class="nav-item w-50 text-center">
                            <a class="nav-link" data-toggle="tab" href="#defect_product_action">Defect Product Action</a>
                        </li>
                    </ul>
                    <div class="tab-content p-0">
                        <div id="defect_reason" class="tab-pane active m-b-20"><br>
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
                                                            <button type="button" class="btn btn-primary edit" data-type="defectReason" action-id="{{$reason->id}}">Edit</button>
                                                            <button type="button" class="btn btn-danger delete" data-type="defectReason" action-id="{{$reason->id}}">Delete</button>
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

                        <div id="defect_product_action" class="tab-pane m-b-20"><br>
                            <div class="row">
                                <div class="col-md-12">
                                <button type="success" class="btn btn-primary m-b-10 add" data-type="defectAction">Add <i class="fa fa-plus"></i></button>
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
                                                            <button type="button" class="btn btn-primary edit" data-type="defectAction" action-id="{{$action->id}}">Edit</button>
                                                            <button type="button" class="btn btn-danger delete" data-type="defectAction" action-id="{{$action->id}}">Delete</button>
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
                </div> <!-- end card box -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->

    <script type="text/javascript">
        $(document).ready(function() {
            $('.add').on('click',function(){
                let actionType = $(this).attr('data-type')
                if(actionType == 'defectReason'){
                    var url = "{{asset('defect-reason/a/add')}}"
                    var title = 'Add Defect Reason'
                }else{
                    var url = "{{asset('defect-action/a/add')}}"
                    var title = 'Add Defect Action'
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
                                '<button type="button" class="btn btn-primary edit" data-type="'+actionType+'" action-id="'+responseData.id+'">Edit</button>'+
                                '<button type="button" class="btn btn-danger delete" data-type="'+actionType+'" action-id="'+responseData.id+'">Delete</button>'+
                            '</td>'+
                        '</tr>'
            $('table tbody#'+actionType).prepend(html);
        }
    </script>

@endsection
