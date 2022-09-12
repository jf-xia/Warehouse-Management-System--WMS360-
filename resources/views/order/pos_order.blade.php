@extends('master')
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="vendor-title">
                            <p>Manual Order</p>
                        </div>
                    </div>
                </div>

                <form class="card m-t-20 b-r-0 shadow" role="form" action="{{url('create-pos-order')}}" method="post">
                    @csrf

                    <div class="row m-t-20">
                        <div class="col-md-12">
                            <div class="card-box shadow">
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="first_name" class="col-md-1 col-form-label required">EAN</label>
                                    <div class="col-md-9 wow pulse">
                                        <input type="text" name="ean" class="form-control" id="ean" oninput="exist_ean_no_check(this.value);">
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="first_name" class="col-md-1 col-form-label">Total Price</label>
                                    <div class="col-md-9 wow pulse">
                                        <input type="text" name="total_price"  class="form-control" id="total_price">
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="first_name" class="col-md-1 col-form-label">Pos Details</label>
                                    <div class="col-md-9 wow pulse">
                                        <div>
                                            <table id="pos_table_id" class="table-bordered" style="width : 100%;">
                                                <thead>
                                                <th class="text-center" style="width: 40%;">Product Name</th>
                                                <th class="text-center" style="width: 10%;">product ID</th>
                                                <th class="text-center" style="width: 15%;">SKU</th>
                                                <th class="text-center" style="width: 10%;">Quantity</th>
                                                <th class="text-center" style="width: 15%;">Price</th>
                                                <th class="text-center" style="width: 10%;">Action</th>
                                                </thead>
                                                <tbody id="pos_result">
                                                {{--                                                <tr>--}}
                                                {{--                                                    <td>Test1</td>--}}
                                                {{--                                                    <td><input class="form-control text-center" type="text" name="qty[]" value="1"></td>--}}
                                                {{--                                                    <td>50</td>--}}
                                                {{--                                                </tr>--}}
                                                {{--                                                <tr>--}}
                                                {{--                                                    <td>Test2</td>--}}
                                                {{--                                                    <td><input class="form-control text-center" type="text" name="qty[]" value="2"></td>--}}
                                                {{--                                                    <td>100</td>--}}
                                                {{--                                                </tr>--}}
                                                {{--                                            <tr id="no_result_msg" style="display: none;"><td colspan="3">No result found</td></tr>--}}
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-danger m-t-10" id="no_result_msg" style="display: none;"><strong>No product found</strong></div>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row m-t-40">
                                    <div class="col-md-12 text-center">
                                        <button class="vendor-btn m-b-30" type="submit" >
                                            <b>Place Order</b>
                                        </button>
                                    </div>
                                </div>

                            </div>  <!-- card-box -->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->
                </form>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content-page-->

    <script type="text/javascript">

        $(document).ready(function() {
            $('.remove-products').on('click', function () {
                console.log('found');
                $(this).closest("tr").remove();
            });
        });

        function custom_qty_input(id, sale_price){
            var qty = $('#qty_id_' + id).val();
            if(qty == ''){
                return false;
            }
            var total_price = qty * parseFloat(sale_price);
            var table = $("#pos_table_id");
            table.find("#price_id_" + id).val(total_price.toFixed(2));

            var t_price = 0;
            table.find("tbody tr td input.price_id").each(function () {
                t_price += parseFloat($(this).val());
                console.log(t_price);

            });
            var final_price = t_price.toFixed(2);
            $('#total_price').val(final_price);
        }

        function remove_tr(id){
            console.log(id);
            var price = $("#price_id_"+id).val();
            console.log(price);
            var total_price = $('#total_price').val();
            console.log(total_price);
            var result = total_price - price;
            console.log(result);
            $('#total_price').val(result.toFixed(2));
            $('#tr_id_'+id).remove();
        }

        function exist_ean_no_check(ean_no) {
            if(ean_no.length === 0){
                return false;
            }
            $.ajax({
                type:"POST",
                url: "{{url('pos-order-product-search')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "ean_no" : ean_no
                },
                success: function (response) {
                    if(response.data === 1){
                        $('#no_result_msg').hide();
                        $('#ean').val('');
                        var table = $("#pos_table_id");
                        var tbody = table.find("#product_id_"+response.product_id).val();
                        // console.log(tbody);
                        if(!isNaN(tbody)) {
                            // tbody.each(function () {
                            // var id = $(this).find("#p"+response.product_id).val();
                            // console.log(id);
                            // if(!isNaN(id)) {
                            var qty = table.find("#qty_id_" + response.product_id).val();
                            var price = table.find("#price_id_" + response.product_id).val();
                            var unit_price = price / qty;
                            // console.log(id);
                            // console.log(qty);
                            // if (parseInt(response.product_id) == parseInt(id)) {
                            //     console.log('found');
                            table.find("#qty_id_" + response.product_id).val((parseInt(qty) + 1));
                            table.find("#price_id_" + response.product_id).val((parseFloat(unit_price) + parseFloat(price)).toFixed(2));
                            var t_price = 0;
                            table.find("tbody tr td input.price_id").each(function () {
                                t_price += parseFloat($(this).val());
                                console.log(t_price);

                            });
                            var final_price = t_price.toFixed(2);
                            $('#total_price').val(final_price);


                            // }
                            // else {
                            //     console.log('else found');
                            //     $('#pos_result').append(response.content);
                            // }
                            // }else{
                            //     console.log('p found');
                            //     $('#pos_result').append(response.content);
                            // }
                            // });

                            // var m_table = $("#pos_table_id");
                            // var m_tbody = m_table.find("tbody tr");
                            // var t_price = 0;
                            // m_tbody.each(function () {
                            //         var t_price = $(this).find("input.price_id").val();
                            //     });
                            // $('#total_price').val(t_price);

                        }else{
                            console.log('f found');
                            $('#pos_result').append(response.content);
                            var t_price = 0;
                            table.find("tbody tr td input.price_id").each(function () {
                                t_price += parseFloat($(this).val());
                                console.log(t_price);

                            });
                            $('#total_price').val(t_price.toFixed(2));
                        }

                    }else{
                        $('#no_result_msg').show();
                        // $('#pos_result').html(response.content);
                    }
                }

            });
        }

    </script>

@endsection
