@extends('master')
@section('content')

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="card-box">
                <form action="{{asset(url('amazon/save-application'))}}" method="post" enctype="multipart/form-data">
                @csrf
                <h5 class="text-center">Add Application</h5><hr>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                @endif
                    <div class="row m-t-30">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <div class="col-md-1"></div>
                                <label for="amazon_account_id" class="col-md-3 col-form-label required">Amazon Account</label>
                                <div class="col-md-7 wow pulse">
                                    <select class="form-control" name="amazon_account_id" id="amazon_account_id" required>
                                        @if(isset($allAccounts) && (count($allAccounts) > 1))
                                            <option value="">Select Account</option>
                                            @foreach($allAccounts as $account)
                                                <option value="{{$account->id ?? ''}}">{{$account->account_name ?? ''}}</option>
                                            @endforeach
                                        @else
                                            @foreach($allAccounts as $account)
                                                <option value="{{$account->id ?? ''}}" selected>{{$account->account_name ?? ''}}</option>
                                            @endforeach
                                        @endif
                                   </select>
                                </div>
                                <div class="col-md-1">
                                    @if(isset($allAccounts) && (count($allAccounts) == 0))
                                        <a href="{{url('amazon/accounts')}}" class="btn btn-info xs">Create Here</a>
                                    @endisset
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-1"></div>
                                <label for="application_name" class="col-md-3 col-form-label required">Application Name</label>
                                <div class="col-md-7 wow pulse">
                                    <input type="text" name="application_name" value="{{old('application_name')}}" class="form-control"
                                        id="application_name" placeholder="Enter Application Name" required>
                                </div>
                                <div class="col-md-1"></div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-1"></div>
                                <label for="application_id" class="col-md-3 col-form-label required">Application Id</label>
                                <div class="col-md-7 wow pulse">
                                    <input type="text" name="application_id" value="{{old('application_id')}}" class="form-control"
                                        id="application_id" placeholder="Enter Application Id" required>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-1"></div>
                                <label for="iam_arn" class="col-md-3 col-form-label required">IAM ARN</label>
                                <div class="col-md-7 wow pulse">
                                    <input type="text" name="iam_arn" value="{{old('iam_arn')}}" class="form-control"
                                        id="iam_arn" placeholder="Enter IAM ARN" required>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-1"></div>
                                <label for="lwa_client_id" class="col-md-3 col-form-label required">LWA Client Id</label>
                                <div class="col-md-7 wow pulse">
                                    <input type="text" name="lwa_client_id" value="{{old('lwa_client_id')}}" class="form-control"
                                        id="lwa_client_id" placeholder="Enter LWA Client Id" required>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="form-group row m-t-20">
                                <div class="col-md-1"></div>
                                <label for="lwa_client_secret" class="col-md-3 col-form-label required">LWA Client Secret</label>
                                <div class="col-md-7 wow pulse">
                                    <input type="text" name="lwa_client_secret" value="{{old('lwa_client_secret')}}" class="form-control"
                                        id="lwa_client_secret" placeholder="Enter LWA Client Secret" required>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-1"></div>
                                <label for="aws_access_key_id" class="col-md-3 col-form-label required">AWS Access Key Id</label>
                                <div class="col-md-7 wow pulse">
                                    <input type="text" name="aws_access_key_id" value="{{old('aws_access_key_id')}}" class="form-control"
                                        id="aws_access_key_id" placeholder="Enter AWS Access Key Id" required>
                                </div>
                                <div class="col-md-1"></div>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <div class="col-md-1"></div>
                                <label for="aws_secret_access_key" class="col-md-3 col-form-label required">AWS Secret Access Key</label>
                                <div class="col-md-7 wow pulse">
                                    <input type="text" name="aws_secret_access_key" value="{{old('aws_secret_access_key')}}" class="form-control"
                                        id="aws_secret_access_key" placeholder="Enter AWS Secret Access Key" required>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-1"></div>
                                <label for="amazon_marketplace_fk_id" class="col-md-3 col-form-label required">Amazon Market Place</label>
                                <div class="col-md-7 wow pulse">
                                    <select class="form-control" name="amazon_marketplace_fk_id" id="amazon_marketplace_fk_id" required>
                                        @if(isset($allMarketPlaces) && (count($allMarketPlaces) > 1))
                                            <option value="">Select Market Place</option>
                                            @foreach($allMarketPlaces as $marketplace)
                                                <option value="{{$marketplace->id ?? ''}}">{{$marketplace->marketplace ?? ''}}</option>
                                            @endforeach
                                        @else
                                            @foreach($allMarketPlaces as $marketplace)
                                                <option value="{{$marketplace->id ?? ''}}" selected>{{$marketplace->marketplace ?? ''}}</option>
                                            @endforeach
                                        @endif
                                   </select>
                                </div>
                                <div class="col-md-1"></div>
                            </div>

                            <div class="form-group row m-t-20">
                                <div class="col-md-1"></div>
                                <label for="oauth_login_url" class="col-md-3 col-form-label ">Amazon OAuth Login Url</label>
                                <div class="col-md-7 wow pulse">
                                <input type="text" name="oauth_login_url" value="{{old('oauth_login_url')}}" class="form-control"
                                        id="oauth_login_url" placeholder="Enter OAuth Login Url" >
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-1"></div>
                                <label for="oauth_redirect_url" class="col-md-3 col-form-label required">Amazon OAuth Redirect Url</label>
                                <div class="col-md-7 wow pulse">
                                    <input type="text" name="oauth_redirect_url" value="{{old('oauth_redirect_url')}}" class="form-control"
                                        id="oauth_redirect_url" placeholder="Enter OAuth Redirect Url" required>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-1"></div>
                                <label for="application_status " class="col-md-3 col-form-label required">Application Status</label>
                                <div class="col-md-7 wow pulse">
                                    <select class="form-control" name="application_status" id="application_status" required>
                                        <option value="">Application Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                   </select>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="form-group row m-t-20">
                                <div class="col-md-1"></div>
                                <label for="application_logo" class="col-md-3 col-form-label ">Application Logo</label>
                                <div class="col-md-7 wow pulse">
                                <input type="file" name="application_logo" value="{{old('application_logo')}}" class="form-control"
                                        id="application_logo" onchange="previewImage()">
                                <span class="d-none application-logo-show-span"><img src="" alt="" width="60" height="60"></span>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            
                            <button type="submit" class="btn btn-success">Save</button>
                        </div> 
                    </div>
                </form>
            </div>
        </div> 
    </div> 
</div>
<script>
    // $(document).ready(function(){
        
    // })
    
    function previewImage(){
        var imageInfo = document.getElementById("application_logo")
        if (imageInfo.files && imageInfo.files[0]) {
            var reader = new FileReader();
            var file = imageInfo.files[0]
            reader.onload = function(e) {
                $('.application-logo-show-span').removeClass('d-none').addClass('d-block').find('img').attr('src', e.target.result)
            }
            reader.readAsDataURL(imageInfo.files[0]);
        }
    }
</script>
@endsection
