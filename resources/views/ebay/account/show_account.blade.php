@extends('master')
@section('content')


    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Page-Title -->

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

                <div class="card-box m-t-20 shadow product-draft-details">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card p-2">
                                    <div class="d-flex justify-content-around">
                                        <div class="w-25">
                                            <h6> Account Name : </h6>
                                        </div>
                                        <div class="w-50">
                                            <h6> {{$result->account_name}} </h6>
                                        </div>
                                        <div class="w-25">
                                            <h6><a onclick="showButton()" target="_blank" href="{{$developer_accounts[0]->sign_in_link}}" class="waves-effect"><i class="ti-link"></i><span> Authorize </span></a></h6>
                                        </div>
                                    </div>
                            </div>
                        </div> <!-- end col-md-12 -->
                    </div> <!--end row-->
                    <div id="Load" class="load" style="display: none;">
                        <div class="load__container">
                            <div class="load__animation"></div>
                            <div class="load__mask"></div>
                            <span class="load__title">Content id loading...</span>
                        </div>
                    </div>
                        <input type="hidden" name="account_id" value="{{$account_id}}">
                        <input type="hidden" name="site_id" value="{{$site_id}}">

                    <button id="tokenButton" onclick="checkCookie()">Get token and Complete !</button>

                </div> <!-- end card box -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->
    <script>
        window.onload = function (){
            document.getElementById('tokenButton').setAttribute("disabled","disabled");
        }
        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for(var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function showButton(){
            document.getElementById('tokenButton').removeAttribute("disabled","disabled");
        }
        function checkCookie() {
            var  account_id = document.querySelector('input[name=account_id]').value;
            var site_id = document.querySelector('input[name=site_id]').value;

            var token = getCookie('token_auth');
            //console.log(account_id + site_id + token);
            if (token != "") {
                $.ajax({
                    type : "post",
                    url : "{{URL::to('set-authorization')}}",
                    data : {
                        "_token" : "{{csrf_token()}}",
                        "account_id":account_id,
                        "site_id" : site_id,
                        "token" : token
                    },
                    beforeSend: function (){
                        $("#ajax_loader").show();
                    },
                    success : function (){
                        alert("Authorization complete! ");
                        var d = new Date();
                        d.setTime(d.getTime() + (30*24*60*60*1000));
                        var expires = "expires=" + d.toGMTString();
                        document.cookie = "token_auth=" + ";" + expires + ";path=/";

                    },
                    complete:function(data){
                        // Hide image container
                        $("#ajax_loader").hide();
                    }
                })

            } else {
                alert("Authorization empty ");
                // user = prompt("please authorize ebay first", "");
                // if (user != "" && user != null) {
                //     setCookie("username", user, 365);
                // }
            }
        }
    </script>

@endsection
