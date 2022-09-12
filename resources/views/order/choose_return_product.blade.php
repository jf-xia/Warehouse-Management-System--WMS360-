@extends('master')

@section('title')
    Dispatched Order | Return Order | WMS360
@endsection

@section('content')


    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <div class="wms-breadcrumb">
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item">Dispatched Order</li>
                        <li class="breadcrumb-item active" aria-current="page"> Return Order </li>
                    </ol>

                    <div class="breadcrumbRightSideBtn mt-xs-15">
                        <button class="btn btn-default" data-toggle="modal" data-target="#addModal">Add / Show Reason</button>&nbsp;
                    </div>
                </div>


                <!--Reason add modal start-->
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">Return reason information</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="reason" class="col-form-label">Reason:</label>
                                        <input type="text" class="form-control" id="reason" name="reason" placeholder="Enter return reason...">
                                        <input type="hidden" name="update_reason" id="update_reason" value="">
                                    </div>
                                </form>
                                <div class="modal-footer border-top-0">
                                    <button type="button" class="btn btn-primary add_reason">Add</button>
                                </div>
                                <h5>All Reason</h5>
                                <p class="text-success" style="display: none;">Added successfully</p>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Reason</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @isset($return_reason)
                                        @foreach($return_reason as $reason)
                                            <tr id="row_id_{{$reason->id}}">
                                                <td>{{$reason->reason}}</td>
                                                <td>
                                                    <div class="d-flex justify-content-start">
                                                        <a class="btn-size edit-btn btn-sm mr-2" style="cursor: pointer; color: #ffffff;" id="{{$reason->id}}"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                                        <a class="btn-size delete-btn btn-sm" style="cursor: pointer; color: #ffffff;" id="{{$reason->id}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </div>
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
                <!--End Reason add modal start-->


                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box shadow">

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(Session::has('return_order_success_msg'))
                                <div class="alert alert-success">
                                    {!! Session::get('return_order_success_msg') !!}
                                </div>
                            @endif

                            <form action="{{url('save-return-order')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <h5>Order Number : {{$single_order_product->order_number}}</h5>
                                        <div class="card p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                                            <h5>Product Details</h5>
                                            <div class="border table-responsive p-2">
                                                <table class="w-100">
                                                    <thead>
                                                    <tr>
                                                        <th style="width: 5%"></th>
                                                        <th class="text-center" style="width: 30%">Name</th>
                                                        <th class="text-center" style="width: 20%">SKU</th>
                                                        <th class="text-center" style="width: 5%">Quantity</th>
                                                        <th class="text-center" style="width: 20%">Return Quantity</th>
                                                        <th class="text-center" style="width: 20%"><div class="chose-retn-pro-price text-center">Price</div></th>
                                                    </tr>

                                                    </thead>
{{--                                                    <div class="row">--}}
{{--                                                        <div class="col-1 text-center">--}}

{{--                                                        </div>--}}
{{--                                                        <div class="col-3 text-center">--}}
{{--                                                            <h6> Name </h6>--}}
{{--                                                            <hr width="90%">--}}
{{--                                                        </div>--}}
{{--                                                        <div class="col-2 text-center">--}}
{{--                                                            <h6>SKU</h6>--}}
{{--                                                            <hr width="60%">--}}
{{--                                                        </div>--}}
{{--                                                        <div class="col-2 text-center">--}}
{{--                                                            <h6> Quantity </h6>--}}
{{--                                                            <hr width="60%">--}}
{{--                                                        </div>--}}
{{--                                                        <div class="col-2 text-center">--}}
{{--                                                            <h6> Return Quantity </h6>--}}
{{--                                                            <hr width="60%">--}}
{{--                                                        </div>--}}
{{--                                                        <div class="col-2 text-center">--}}
{{--                                                            <h6> Price </h6>--}}
{{--                                                            <hr width="60%">--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
                                                    <input type="hidden" name="return_order" value="{{$single_order_product->id}}">
                                                    @php
                                                        $counter =0;
                                                    @endphp
                                                    @foreach($single_order_product->product_variations as $product)
                                                        <tbody>
                                                        <tr>
                                                            <td class="text-center" style="width: 5%">
                                                                <input type="checkbox" checked name="return_product_info[{{$counter}}][product_id]" id="return_product{{$product->id}}" onclick="select_product(this.value);" value="{{$product->id}}">
                                                            </td>
                                                            <td class="text-center" style="width: 30%">
                                                                <h7>{{$product->pivot->name}}</h7>
                                                                <input type="hidden" name="return_product_info[{{$counter}}][product_name]" id="return_product_name{{$product->id}}" value="{{$product->pivot->name}}">
                                                            </td>
                                                            <td class="text-center" style="width: 20%">
                                                                <h7>{{$product->sku}}</h7>
                                                            </td>
                                                            <td class="text-center" style="width: 5%">
                                                                <h7>{{$product->pivot->quantity}}</h7>
                                                                <input type="hidden" name="return_product_info{{$product->id}}" id="quantity{{$product->id}}" value="{{$product->pivot->quantity}}">
                                                            </td>
                                                            <td class="text-center" style="width: 20%">
                                                                <input type="number" name="return_product_info[{{$counter}}][return_quantity]" id="return_quantity{{$product->id}}" oninput="return_qtn_check({{$product->id}})" class="form-control text-center" value="1">
                                                                <div id="err_return_qtn{{$product->id}}" style="color: red;"></div>
                                                            </td>
                                                            <td class="text-center" style="width: 20%">
                                                                <div class="chose-retn-pro-price text-center">
                                                                    <input type="text" class="form-control text-center" name="return_product_info[{{$counter}}][product_price]" id="return_product_price{{$product->id}}" value="0">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </tbody>
{{--                                                        <div class="row">--}}
{{--                                                            <div class="col-1 text-center">--}}
{{--                                                                <input type="checkbox" checked name="return_product_info[{{$counter}}][product_id]" id="return_product{{$product->id}}" onclick="select_product(this.value);" value="{{$product->id}}">--}}
{{--                                                            </div>--}}
{{--                                                            <div class="col-3 text-center">--}}
{{--                                                                <h7> {{$product->pivot->name}} </h7>--}}
{{--                                                                <input type="hidden" name="return_product_info[{{$counter}}][product_name]" id="return_product_name{{$product->id}}" value="{{$product->pivot->name}}">--}}
{{--                                                            </div>--}}
{{--                                                            <div class="col-2 text-center">--}}
{{--                                                                <h7> {{$product->sku}} </h7>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="col-2 text-center">--}}
{{--                                                                <h7> {{$product->pivot->quantity}} </h7>--}}
{{--                                                                <input type="hidden" name="return_product_info{{$product->id}}" id="quantity{{$product->id}}" value="{{$product->pivot->quantity}}">--}}
{{--                                                            </div>--}}
{{--                                                            <div class="col-2 text-center">--}}
{{--                                                                <input type="number" name="return_product_info[{{$counter}}][return_quantity]" id="return_quantity{{$product->id}}" oninput="return_qtn_check({{$product->id}})" class="form-control text-center" value="1">--}}
{{--                                                                <div id="err_return_qtn{{$product->id}}" style="color: red;"></div>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="col-2 text-center">--}}
{{--                                                                --}}{{--                                                            <h7> {{$product->pivot->price}} </h7>--}}
{{--                                                                <input type="text" class="form-control text-center" name="return_product_info[{{$counter}}][product_price]" id="return_product_price{{$product->id}}" value="0">--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
                                                        @php
                                                            $counter++;
                                                        @endphp
                                                    @endforeach
                                                </table>

{{--                                                <div class="row m-b-20">--}}
{{--                                                    <div class="col-8 text-center"> </div>--}}
{{--                                                    <div class="col-2 text-center">--}}
{{--                                                        <h7 class="float-right font-weight-bold"> Total Price</h7>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-2 text-center">--}}
{{--                                                        <h7 class="font-weight-bold"> {{$single_order_product->total_price}} </h7>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mt-4">
                                                    <lebel>Return Reason</lebel>
                                                    {{--                                                <textarea class="form-control" name="return_reasone"></textarea>--}}
                                                    <select class="form-control" name="return_reasone" required>
                                                        @isset($return_reason)
                                                            @if($return_reason->count() == 1)
                                                                @foreach($return_reason as $reason)
                                                                    <option value="{{$reason->reason}}">{{$reason->reason}}</option>
                                                                @endforeach
                                                            @else
                                                                <option hidden>Select Return Reason</option>
                                                                @foreach($return_reason as $reason)
                                                                    <option value="{{$reason->reason}}">{{$reason->reason}}</option>
                                                                @endforeach
                                                            @endif
                                                        @endisset
                                                    </select>
                                                </div>

                                                <br>

                                                <div>
                                                    <lebel>Return Cost</lebel>
                                                    <input type="number"name="return_cost" class="form-control">
                                                    <div class="mt-4">
                                                        <button type="submit" id="submit_button" class="btn btn-success">Submit</button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div> <!-- end card -->

                                    </div> <!-- end col-12 -->
                                </div> <!-- end row -->
                            </form>

                    </div> <!-- // col-12 -->
                </div> <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div> <!-- content page -->


    <!-----multiple select checkbox----->
    <script>
        // for quantity and return quantity check start
        function return_qtn_check(id){
            var quantity = $('#quantity'+id).val();
            var return_quantity = $('#return_quantity'+id).val();

            if(Number(return_quantity) > Number(quantity)){
                console.log(return_quantity);
                console.log(quantity);
                document.getElementById('err_return_qtn'+id).innerHTML = 'Invalid input';
                document.getElementById("submit_button").disabled = true;
            }else{
                document.getElementById('err_return_qtn'+id).innerHTML = '';
                document.getElementById("submit_button").disabled = false;
            }
        }
        // for quantity and return quantity check end

        // for enabled and disabled input field using checkbox start
        function select_product(id){
            document.getElementById('return_product'+id).onchange = function() {
                document.getElementById('return_quantity'+id).disabled = !this.checked;
            };
        }
        // for enabled and disabled input field using checkbox end


        $(document).ready(function () {
            $("#ckbCheckAll").click(function () {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });

            $(".checkBoxClass").change(function(){
                if (!$(this).prop("checked")){
                    $("#ckbCheckAll").prop("checked",false);
                }
            });
        });

        $(document).ready(function () {
            $('.modal .modal-footer button').on('click',function () {
                var reason = $('#reason').val();
                var button_name = $('.modal .modal-footer button').text();
                if(button_name == 'Add'){
                    var method = "POST";
                    var url = "{{url('return-reason')}}";
                }else if(button_name == 'Update'){
                    var method = "PUT";
                    var id = $('#update_reason').val();
                    var url = "{{url('return-reason')}}"+'/'+id;
                }
                console.log(url);
                $.ajax({
                    type: method,
                    url: url,
                    data: {
                        "_token": "{{csrf_token()}}",
                        "reason": reason
                    },
                    success: function (response) {
                        console.log(response.data);
                        if(button_name == 'Add') {
                            $('.modal-body table tbody').prepend('<tr id="row_id_'+response.data.id+'">' +
                                '<td>' + response.data.reason + '</td>' +
                                '<td>' +
                                '<a class="btn-size edit-btn btn-sm mr-2" style="cursor: pointer; color: #ffffff;" id="'+response.data.id+'"><i class="fa fa-edit" aria-hidden="true"></i></a>' +
                                '<a class="btn-size delete-btn btn-sm" style="cursor: pointer; color: #ffffff;" id="'+response.data.id+'"><i class="fa fa-trash" aria-hidden="true"></i></a>' +
                                '</td>' +
                                '</tr>');
                            $('.modal-body p').show();
                            $('#reason').val('');
                        }else if(button_name == 'Update'){
                            $('p.text-success').show().html('Updated successfully');
                            $('#row_id_'+id).children('td').first().html(reason);
                            $('#reason').val('');
                            $('.modal .modal-footer button').removeClass('update_reason');
                            $('.modal .modal-footer button').addClass('add_reason');
                            $('.modal .modal-footer button').text('Add');
                            console.log(response.data);
                        }
                    }
                });
            });

            $('.modal-body table tbody tr td a.edit-btn').on('click',function () {
                var id = $(this).attr('id');
                var text = $(this).closest('tr').children('td').first().html();
                $('#reason').val(text);
                $('.modal .modal-footer button').removeClass('add_reason');
                $('.modal .modal-footer button').addClass('update_reason');
                $('.modal .modal-footer button').text('Update');
                $('#update_reason').val(id);
                console.log(text);
            });

            $('.modal-body table tbody tr td a.delete-btn').on('click',function () {
                var check = confirm('Are you sure to delete this ?');
                if(check){
                    console.log('execute');
                    var id = $(this).attr('id');
                    $.ajax({
                        type: "DELETE",
                        url: "{{url('return-reason')}}"+'/'+id,
                        data: {
                            "_token": "{{csrf_token()}}",
                        },
                        success: function (response) {
                            $('tr#row_id_'+id).remove();
                            $('p.text-success').show().html('Deleted successfully');
                            console.log(response.data);
                        }
                    });
                }else{
                    return false;
                }
            });
        });

    </script>

@endsection




