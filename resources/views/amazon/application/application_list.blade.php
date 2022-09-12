@extends('master')
@section('content')
<style>
    table thead {
        background-color: #1abc9c;
        height: 2.5rem;
        text-align: center;
    }
    table tbody tr {
        text-align-last: center;
    }
    .modal-body{
        word-break: break-all;
    }
    /* table tbody tr:nth-child(odd) {
        border-bottom: 1px solid #1abc9c;
    } */
</style>
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 card-box">
                    <div class="text-center">
                        <span>Application List</span>
                        <span>
                            <a href="{{url('amazon/add-application')}}" class="btn btn-primary add-amazon-application float-right mr-3">Add Application</a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row m-t-20">
                <div class="col-md-12 card-box shadow">
                    @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <h5>{{Session::get('success')}}</h5>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if(Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h5>{{Session::get('error')}}</h5>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <!-- <a href="{{url('https://sellercentral.amazon.co.uk/apps/authorize/consent?application_id=amzn1.sp.solution.ba5841a2-7340-493b-8f63-40c14542f2ee&state=abc&version=beta')}}" class="btn btn-info" target="_blank">Authorize WMS</a> -->
                    <table class="w-100 table-primary-btm amazon-account-table">
                        <thead>
                            <th>App Logo</th>
                            <th>App Name</th>
                            <th>Account</th>
                            <th>Application Status</th>
                            <th>Is Authorized</th>
                            <th>Authorization</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @isset($applicationsLists)
                                @foreach($applicationsLists as $application)
                                    <tr class="{{$application->id}}">
                                        <td><img src="{{$application->application_logo ? asset('/').$application->application_logo : asset('/').'assets/common-assets/no_image.jpg'}}" alt="{{$application->application_logo ? asset('/').$application->application_logo : ''}}" class="rounded-circle" width="40" height="40"></td>
                                        <td>{{$application->application_name ?? ''}}</td>
                                        <td>{{$application->accountInfo->account_name ?? ''}}</td>
                                        <td class="application_status">@if($application->application_status == 1) <label class="label label-success">Active</label> @else <label class="label label-danger">Inactive</label> @endif</td>
                                        <td>@if($application->is_authorize == 1) <label class="label label-success">Authorized</label> @else <label class="label label-warning">Pending Authorization</label> @endif</td>
                                        <td><button id="{{$application->marketPlace->marketplace_url.'/apps/authorize/consent?application_id='.$application->application_id.'&redirect_uri='.$application->oauth_redirect_url.'&version=beta'}}" class="btn btn-info btn-sm authorize-app">@if($application->is_authorize == 1) Reauthorize @else Authorize @endif</button></td>
                                        <td class="btn-group">
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#applicationId{{$application->id}}">View</button>
                                            <a href="{{asset('amazon/edit-application/'.$application->id)}}" class="btn btn-success btn-sm edit-amazon-application" target="_blank">Edit</a>
                                            <button class="btn btn-danger btn-sm delete-amazon-application">Delete</button>
                                        </td>
                                    </tr>

                                    <!-- <div class="modal fade" id="applicationAuthorizationId{{$application->id}}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="">Authorization</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action=""></form>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    
                                    <div class="modal fade" id="applicationId{{$application->id}}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="">Application Details</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Refresh Token</strong> : {{$application->token->refresh_token ?? ''}}</p>
                                                    <p><strong>Access Token</strong> : {{$application->token->access_token ?? ''}}</p>
                                                    <p><strong>LWA Client ID</strong> : {{$application->lwa_client_id ?? ''}}</p>
                                                    <p><strong>LWA Client Secret</strong>: {{$application->lwa_client_secret ?? ''}}</p>
                                                    <p><strong>Appliation Id</strong>: {{$application->application_id ?? ''}}</p>
                                                    <p><strong>IAM ARN</strong>: {{$application->iam_arn ?? ''}}</p>
                                                    <p><strong>AWS Access Key Id</strong>: {{$application->aws_access_key_id ?? ''}}</p>
                                                    <p><strong>AWS Secret Access Key</strong>: {{$application->aws_secret_access_key ?? ''}}</p>
                                                    <p><strong>MarketPlace</strong>: {{$application->marketPlace->marketplace ?? ''}} ({{$application->marketPlace->marketplace_id ?? ''}})</p>
                                                    <p><strong>OAuth Login Url</strong>: {{$application->oauth_login_url ?? ''}}</p>
                                                    <p><strong>OAuth Redirect Url</strong>: {{$application->oauth_redirect_url ?? ''}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
        $('button.authorize-app').click(function(){
            //console.log($(this).attr('id'))
            //localStorage.removeItem('appliationId')
            var applicationPrimaryId = $(this).closest('tr').attr('class')
            //localStorage.setItem('appliationId',applicationPrimaryId)
            var authorizationUrl = $(this).attr('id')
            var html = '<p>This Will Take You To Amazon Seller Central</p><a href="'+authorizationUrl+'" class="btn btn-info btn-sm mt-2" target="_blank">Click Here To Authorize Your Application</a>'
            var url = "{{asset('/amazon/set-application-session-value')}}"+'/'+applicationPrimaryId
            return fetch(url)
            .then(res => {
                if(!res.ok){
                    throw new Error(res.statusText) 
                }
                return res.json()
            })
            .then(result => {
                console.log(result)
                if(result.type == 'success'){
                    Swal.fire({
                        title: 'Authorize Your Application',
                        icon: 'info',
                        html: html,
                        showConfirmButton: false,
                        showCancelButton: true,
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Close',
                    })
                }else{
                    Swal.showValidationMessage(`Request Failed: ${result.msg}`)
                }
            })
            .catch(error => {
                Swal.showValidationMessage(`Request Failed: ${error}`)
            })
        })
        $('button.delete-amazon-application').click(function(){
            var applicationPrimaryId = $(this).closest('tr').attr('class')
            Swal.fire({
                title: 'Are you sure to delete this?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    var url = "{{asset('amazon/delete-application')}}"
                    var token = "{{csrf_token()}}"
                    var dataObj = {
                        amazon_application_pk_id: applicationPrimaryId,
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
                    $('table tbody tr.'+applicationPrimaryId).remove()
                    Swal.fire('Success',data.value.msg,'success')
                }
            })
        })
    })
    
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
