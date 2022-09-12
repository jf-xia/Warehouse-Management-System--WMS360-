@extends('master')

@section('title')
   Shipping Setting | WMS360
@endsection

@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content" >
            <div class="container-fluid">

                <div class="d-flex justify-content-start align-items-center">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item"> Setting </li>
                            <li class="breadcrumb-item active" aria-current="page">Shipping Setting</li>
                        </ol>
                    </div>
                </div>


                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box shadow">
                            <div class="d-flex justify-content-center align-items-center py-3">
                                <div><p><b class="add-shipping-fee">Add shipping fee</b></p></div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center pb-2">
                                <div>
                                    <select class="shipping-aggregate" name="aggregate_condition">
                                        <option value=""></option>
                                        @isset($shipping_fee)
                                            @if($shipping_fee->aggregate_value == '=')
                                                <option value="=" selected>=</option>
                                            @else
                                                <option value="=">=</option>
                                            @endif
                                            @if($shipping_fee->aggregate_value == '<')
                                                <option value="<" selected><</option>
                                            @else
                                                <option value="<"><</option>
                                            @endif
                                            @if($shipping_fee->aggregate_value == '>')
                                                <option value=">" selected>></option>
                                            @else
                                                <option value=">">></option>
                                            @endif
                                            @if($shipping_fee->aggregate_value == '<=')
                                                <option value="<=" selected><=</option>
                                            @else
                                                <option value="<="><=</option>
                                            @endif
                                            @if($shipping_fee->aggregate_value == '>=')
                                                <option value=">=" selected>>=</option>
                                            @else
                                                <option value=">=">>=</option>
                                            @endif
                                        @endisset
                                    </select>
                                </div>
                                <div><input type="text" name="shipping_fee" class="form-control shipping-fee-input" value="{{$shipping_fee->shipping_fee}}"></div>
                            </div>
                            <div class="d-flex justify-content-center mt-3"><button type="button" class="btn btn-primary vendor-btn waves-effect waves-light" onclick="shipping_fee(this)">Submit</button></div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>


    <script>

        $(document).ready(function(){
            var aggregate_value = $('.shipping-aggregate').val()
            var shipping_fee = $('.shipping-fee-input').val()
            if(aggregate_value || shipping_fee){
                $('.add-shipping-fee').text('Update shipping fee')
            }
        })

        function shipping_fee(e){
            var aggregate_value = $('.shipping-aggregate').val()
            var shipping_fee = $('.shipping-fee-input').val()
            // console.log('aggregate_value ' + aggregate_value)
            // console.log('shipping_fee ' + shipping_fee)
            $.ajax({
                type: "POST",
                url: "{{url('shipping-data-input')}}",
                data: {
                    _token: "{{csrf_token()}}",
                    aggregate_value: aggregate_value,
                    shipping_fee: shipping_fee
                },
                success: function(response){
                    // console.log(response)
                    if(response.data == "Shipping fee added successfully"){
                        Swal.fire({
                            icon: 'success',
                            text: 'Shipping fee added successfully!',
                        })
                    }else{
                        Swal.fire({
                            icon: 'success',
                            text: 'Shipping fee updated successfully!',
                        })
                    }
                }
            });
        }

    </script>

@endsection
