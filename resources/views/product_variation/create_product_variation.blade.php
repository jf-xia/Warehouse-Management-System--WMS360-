@extends('master')
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="vendor-title">
                            <p>Add Product</p>
                        </div>
                    </div>
                </div>


                <div class="row m-t-20 product-variation">
                    <div class="col-md-12">
                        <div class="card-box shadow">


                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

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



                            <form class="m-t-40 mobile-responsive" role="form" action="{{route('product-variation.store')}}"  method="post">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6">
                                        <div class="text-center"> <label class="required">Catalogue</label></div>
                                        <div>
                                            <select name="product_draft_id" id="product-dropdown" class="form-control select2" onchange="get_attribute_list();"  required >
                                                <option>Select Catalogue</option>
                                            @foreach($products as $products)

                                                <option value="{{$products->id}}">{{$products->name}}/{{$products->id}}</option>

                                            @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div> <!--form-group end-->

                                <div id="content" class="form-group row m-t-40"></div> <!--form-group end-->


                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button class="vendor-btn" id="sendBtn" type="submit" class="btn btn-primary waves-effect waves-light" onclick="attribute_check();" disabled>
                                            <b> Send </b>
                                        </button>
                                    </div>
                                </div> <!--form-group end-->

                            </form> <!--END FORM-->

                        </div>  <!-- card-box -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->
    <script>
        $('.select2').select2();
    </script>
    <script>
        // $(document).ready(function() {
        //     $("#product-dropdown").on('change', function () {
        function get_attribute_list() {
            console.log("list item selected");
            document.getElementById("sendBtn").disabled = false;
            var id = document.getElementById("product-dropdown").value;

            $.ajax({
                type: 'GET',
                url: '{{url('/get-variation-attributes')}}',
                data: {
                    "_token ": "{{csrf_token()}}",
                    "id": id,
                },
                success: function (data) {
                    //$("#msg").html(data.msg);
                    $("#content").html(data);
                    // Object.keys(data).forEach(function (key) {
                    //     console.log('key: ' + key + '<br>');
                    //
                    //     Object.keys(data[key]).forEach(function (key){
                    //         console.log('key: ' + key + ', value: ' + data1[key][key] + '<br>');
                    //     });
                    // });
                    // var res='';
                    // var counter= 0;
                    //
                    // for (const [key, value] of Object.entries(data)) {
                    //      res +='<div  class="col-md-2"> <div class="text-center"> <label>'+ key + '</label></div><div><select name="attribute'+ counter +'" class="form-control" required >';
                    //     for (const [key, value1] of Object.entries(value)){
                    //         res += '<option value="'+value1['id'] +'">'+ value1['name'] + '</option>';
                    //     }
                    //     res += '</select>\n' +
                    //         '                                        </div>\n' +
                    //         '                                    </div>'
                    //     counter++;
                    // }
                    // $("#content").html(res);
                    // //console.log(data);
                    // for (const [key, value] of Object.entries(data)) {
                    //     //console.log(key) ;
                    //     //console.log(value);
                    //         for (const [key1, value1] of Object.entries(value)){
                    //                 //console.log(value1[name]) ;
                    //             for (const [key2, value2] of Object.entries(value1)){
                    //                 console.log(value1['id']) ;
                    //             }
                    //         }
                    //     }
                    //console.log(data);
                }

            });

            // console.log(data);
            //     });
            // });
        }
    </script>


@endsection


