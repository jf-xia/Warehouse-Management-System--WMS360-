@extends('master')
@section('content')
<style>
    table thead {
        background-color: #1abc9c;
        height: 2.5rem;
        text-align: center;
    }
    table tbody tr {
        border-bottom: 1px solid #1abc9c;
        text-align-last: center;
    }
</style>
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 card-box">
                    <div class="text-center">
                        <span>Account List</span>
                        <span>
                            <button type="button" class="btn btn-primary add-amazon-account float-right mr-3">Add Account</button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row m-t-20">
                <div class="col-md-12 card-box shadow">
                    <!-- <a href="{{url('https://sellercentral.amazon.co.uk/apps/authorize/consent?application_id=amzn1.sp.solution.ba5841a2-7340-493b-8f63-40c14542f2ee&state=abc&version=beta')}}" class="btn btn-info" target="_blank">Authorize WMS</a> -->
                    <table class="w-100 table-primary-btm amazon-account-table">
                        <thead>
                            <th>Logo</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @isset($accountLists)
                                @foreach($accountLists as $account)
                                    <tr class="{{$account->id}}" style="border-bottom: 1px solid #1abc9c">
                                        <td><img src="{{$account->account_logo ? asset('/').$account->account_logo : asset('/').'assets/common-assets/no_image.jpg'}}" alt="{{$account->account_logo ? asset('/').$account->account_logo : ''}}" class="rounded-circle" width="40" height="40"></td>
                                        <td>{{$account->account_name ?? ''}}</td>
                                        <td class="account_status">@if($account->account_status == 1) <label class="label label-success">Active</label> @else <label class="label label-danger">Inactive</label> @endif</td>
                                        <td>
                                            <button class="btn btn-success edit-amazon-account">Edit</button>
                                            <button class="btn btn-danger delete-amazon-account">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div> 
            </div>
        </div> 
    </div> 
</div>
<script>
    $(document).ready(function(){
        $('button.add-amazon-account').click(function(){
            var html = '<div class="form-group"><input type="text" class="form-control mb-2 amazon-account-name" placeholder="Enter Amazon Account Name">'
                        +'<input type="file" class="form-control mb-2 amazon-account-logo" id="amazon-account-logo" onchange="previewImage()">'
                        +'<img src="" id="amz-account-logo" class="float-left mb-2 d-none" width="40px" height="40px">'
                        +'<input type="hidden" id="amazon-base64-logo" value="">'
                        +'<input type="hidden" id="amazon-logo-name" value="">'
                        +'<select class="form-control mb-2 amazon-account-status">'
                        +  '<option value="1">Active</option>'
                        +  '<option value="0">Inactive</option>'
                        +'</select>'
                        +'</div>'
            Swal.fire({
                title: 'Add Amazon Account',
                html:html,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Save',
                showLoaderOnConfirm: true,
                preConfirm: function(){
                    var accountName = Swal.getPopup().querySelector('.amazon-account-name').value
                    var accountLogo = Swal.getPopup().querySelector('#amazon-base64-logo').value
                    var logoName = Swal.getPopup().querySelector('#amazon-logo-name').value
                    var accountStatus = Swal.getPopup().querySelector('.amazon-account-status').value
                    if(accountName == '' || accountStatus == ''){
                        Swal.showValidationMessage(`Please Select Account Name And Status`)
                        return false
                    }
                    var url = "{{asset('amazon/save-account')}}"
                    var dataObj = {
                        amazon_account_name: accountName,
                        amazon_account_logo: accountLogo ?? null,
                        amazon_logo_name: logoName ?? null,
                        amazon_account_status: accountStatus,
                    }
                    let token = "{{csrf_token()}}"
                    return fetch(url, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': token
                        },
                        method: 'post',
                        body: JSON.stringify(dataObj)
                    })
                    .then(response => {
                        if(!response.ok){
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Request Failed: ${error}`)
                    })
                }
            })
            .then(result => {
                if(result.isConfirmed){
                    if(result.value.data.account_logo){
                        var url = "{{asset('/')}}"+result.value.data.account_logo
                    }else{
                        var url = "{{asset('/')}}"+'assets/common-assets/no_image.jpg'
                    }
                    var status = result.value.data.account_status == 1 ? '<label class="label label-success">Active</label>' : '<label class="label label-danger">Inactive</label>'
                    var html = '<tr class="'+result.value.data.id+'">'
                                    +'<td><img src="'+url+'" alt="" class="rounded-circle" width="40" height="40"></td>'
                                    +'<td>'+result.value.data.account_name+'</td>'
                                    +'<td>'+status+'</td>'
                                    +'<td>'
                                    +    '<button class="btn btn-success edit-amazon-account">Edit</button>'
                                    +    '<button class="btn btn-danger delete-amazon-account">Delete</button>'
                                    +'</td>'
                                +'</tr>'
                    $('table tbody').append(html)
                    Swal.fire('Success',result.value.msg,'success')
                }
            })
        })

        $('.amazon-account-table').on('click','.edit-amazon-account',function(){
            var accountPrimaryId = $(this).closest('tr').attr('class')
            editAccountSwal(accountPrimaryId)
        })

        $('.amazon-account-table').on('click','.delete-amazon-account',function(){
            var accountPrimaryId = $(this).closest('tr').attr('class')
            Swal.fire({
                title: 'Are you sure to delete this?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    var url = "{{asset('amazon/delete-account')}}"
                    var token = "{{csrf_token()}}"
                    var dataObj = {
                        amazon_account_pk_id: accountPrimaryId,
                    }
                    return fetch(url,{
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': token
                        },
                        method: 'post',
                        body: JSON.stringify(dataObj)
                    })
                    .then(response => {
                        if(!response.ok){
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Request Failed: ${error}`)
                    })
                }
            })
            .then(data => {
                if(data.isConfirmed){
                    $('table tbody tr.'+accountPrimaryId).remove()
                    Swal.fire('Success',data.value.msg,'success')
                }
            })
        })
    })
    function editAccountSwal(accountId){
        var route = "{{asset('amazon/single-account-info')}}"+'/'+accountId
        return fetch(route)
        .then(res => {
            if(!res.ok){
                throw new Error(res.statusText)
            }
            return res.json()
        })
        .then(result => {
            if(result.type == 'error'){
                Swal.fire('Oops',result.msg,'error')
                return false
            }
            if(result.data.account_logo){
                var url = "{{asset('/')}}"+result.data.account_logo
            }else{
                var url = "{{asset('/')}}"+'assets/common-assets/no_image.jpg'
            }
            var html = '<div class="form-group"><input type="text" class="form-control mb-2 amazon-account-name" placeholder="Enter Amazon Account Name" value="'+result.data.account_name+'">'
                        +'<input type="file" class="form-control mb-2 amazon-account-logo" id="amazon-account-logo" onchange="previewImage()">'
                        +'<img src="'+url+'" id="amz-account-logo" class="float-left mb-2 d-block" width="40px" height="40px">'
                        +'<input type="hidden" id="amazon-base64-logo" value="">'
                        +'<input type="hidden" id="amazon-logo-name" value="">'
                        +'<select class="form-control mb-2 amazon-account-status">'
                        +  '<option value="1" '+(result.data.account_status == 1 ? 'selected' : '')+'>Active</option>'
                        +  '<option value="0" '+(result.data.account_status == 0 ? 'selected' : '')+'>Inactive</option>'
                        +'</select>'
                        +'</div>'
            Swal.fire({
                title: 'Edit Amazon Account',
                html: html,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Update',
                showLoaderOnConfirm: true,
                preConfirm: function(){
                    var accountName = Swal.getPopup().querySelector('.amazon-account-name').value
                    var accountLogo = Swal.getPopup().querySelector('#amazon-base64-logo').value
                    var logoName = Swal.getPopup().querySelector('#amazon-logo-name').value
                    var accountStatus = Swal.getPopup().querySelector('.amazon-account-status').value
                    if(accountName == '' || accountStatus == ''){
                        Swal.showValidationMessage(`Please Select Account Name And Status`)
                        return false
                    }
                    var url = "{{asset('amazon/update-account')}}"
                    var dataObj = {
                        amazon_account_name: accountName,
                        amazon_account_logo: accountLogo ?? null,
                        amazon_logo_name: logoName ?? null,
                        amazon_account_status: accountStatus,
                        amazon_account_primary_id: accountId
                    }
                    let token = "{{csrf_token()}}"
                    return fetch(url, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': token
                        },
                        method: 'post',
                        body: JSON.stringify(dataObj)
                    })
                    .then(response => {
                        if(!response.ok){
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Request Failed: ${error}`)
                    })
                }
            })
            .then(res => {
                if(res.isConfirmed){
                    Swal.fire('Great',res.value.msg,'success')
                }
            })
        })
        .catch(error => {
            Swal.fire('Oops','Something Went Wrong. Please Try Again','error')
            return false
        })
    }
    function previewImage(event){
        var imageInfo = document.getElementById("amazon-account-logo")
        if (imageInfo.files && imageInfo.files[0]) {
            var reader = new FileReader();
            var file = imageInfo.files[0]
            reader.onload = function(e) {
                $('#amz-account-logo').removeClass('d-none').addClass('d-block')
                $('#amz-account-logo').attr('src', e.target.result)
                $('#amazon-base64-logo').val(e.target.result)
                $('#amazon-logo-name').val(file.name)
            }
            reader.readAsDataURL(imageInfo.files[0]);
        }
    }
</script>
@endsection
