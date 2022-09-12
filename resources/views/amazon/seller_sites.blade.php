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
                        <span>Seller Sites List</span>
                        <span>
                            <button type="button" class="btn btn-primary migrate-seller-sites float-right mr-3">Migrate Seller Sites</button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row m-t-20">
                <div class="col-md-12 card-box shadow">
                    <!-- <a href="{{url('https://sellercentral.amazon.co.uk/apps/authorize/consent?application_id=amzn1.sp.solution.ba5841a2-7340-493b-8f63-40c14542f2ee&state=abc&version=beta')}}" class="btn btn-info" target="_blank">Authorize WMS</a> -->
                    <table class="w-100 table-primary-btm amazon-account-table">
                        <thead>
                            <th>Account Name</th>
                            <th>Site Details</th>
                        </thead>
                        <tbody>
                            @isset($allAccountInfo)
                                @foreach($allAccountInfo as $account)
                                    <tr class="{{$account->id}}" style="border-bottom: 1px solid #1abc9c">
                                        <td>
                                            <div class="card card-box">
                                                {{$account->account_name ?? ''}}
                                            </div>
                                        </td>
                                        <td>
                                            @isset($account->sellerSites)
                                                <div class="card card-box">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="w-100">
                                                            <thead>
                                                                <th>Name</th>
                                                                <th>Id</th>
                                                                <th>Country Code</th>
                                                                <th>Default Currency Code</th>
                                                                <th>Default Language Code</th>
                                                                <th>Domain</th>
                                                            </thead>
                                                                <tbody>
                                                                @foreach($account->sellerSites as $site)
                                                                    <tr>
                                                                        <td>{{$site->name}}</td>
                                                                        <td>{{$site->marketplace_id}}</td>
                                                                        <td>{{$site->country_code}}</td>
                                                                        <td>{{$site->default_currency_code}}</td>
                                                                        <td>{{$site->default_language_code}}</td>
                                                                        <td>{{$site->domain_name}}</td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endisset
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
        $('button.migrate-seller-sites').click(function(){
            var route = "{{asset('amazon/all-account-info')}}"
            return fetch(route)
            .then(res => {
                if(!res.ok){
                    throw new Error(res.statusText)
                }
                return res.json()
            })
            .then(result => {
                console.log('in the result')
                console.log(result)
                var option = ''
                result.forEach(function(account){
                    option += '<option value="'+account.id+'">'+account.account_name+'</option>'
                })
                var html = '<div class="form-group">'
                        +'<select class="form-control mb-2 amazon-account">'
                        +  '<option value="">Select Account</option>'
                        +option
                        +'</select>'
                        +'</div>'
                Swal.fire({
                    title: 'Are You Sure To Migrate Seller Site ?',
                    html:html,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    showLoaderOnConfirm: true,
                    preConfirm: function(){
                        var accountId = Swal.getPopup().querySelector('.amazon-account').value
                        console.log(accountId)
                        if(accountId == ''){
                            Swal.showValidationMessage(`Please Select Account`)
                            return false
                        }
                        var url = "{{asset('amazon/migrate-seller-sites')}}"
                        var dataObj = {
                            accountId: accountId,
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
                        console.log(result.value)
                        if(result.value.type == 'success'){
                            Swal.fire('Success',result.value.msg,'success')
                        }else{
                            Swal.fire('Oops!',result.value.msg,'error')
                        }
                    }
                })
            })
            
        }) 
    })
</script>
@endsection
