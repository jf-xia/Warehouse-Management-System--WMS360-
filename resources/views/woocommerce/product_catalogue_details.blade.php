@extends('master')

@section('title')
    WooCommerce | {{$product_draft_variation_results == 'product-draft' ? 'Pending Product' : 'Active Product'}} | Edit {{$product_draft_variation_results == 'product-draft' ? 'Pending Product' : 'Active Product'}} | WMS360
@endsection

@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <div class="wms-breadcrumb">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item" aria-current="page"> {{$product_draft_variation_results == 'product-draft' ? 'Pending Product' : 'Active Product'}}</li>
                            <li class="breadcrumb-item active" aria-current="page">{{$product_draft_variation_results == 'product-draft' ? 'Pending Product Details' : 'Active Product Details'}}</li>
                        </ol>
                    </div>
                    <div class="breadcrumbRightSideBtn">
                        <a href=""><button class="btn btn-default">Edit</button></a>
{{--                        <a href="{{url('woocommerce/'.$status_type.'/catalogue/'.$product_draft_variation_results->id.'/edit')}}"><button class="btn btn-default" style="padding: 4px 20px;">Edit</button></a>--}}
                    </div>
                </div>


                <div class="card-box m-t-20 shadow product-draft-details table-responsive">

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

                    <div class="row">
                        <div class="col-md-12 m-t-30">
                            <div class="row">
                                @if(count($product_draft_variation_results->all_image_info) > 0)
                                    @foreach($product_draft_variation_results->all_image_info as $image)
                                        <div class="col-md-2 col-sm-6">
                                            <div class="card m-b-10">
                                                <img class="card-img-top img-thumbnail" src="{{$image->image_url}}" alt="Product image">
                                                {{--                                            <img class="card-img-top img-thumbnail" src="{{asset('assets/images/avatar-1.jpg')}}" alt="Product image">--}}
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-md-12">
                                        <h3>No Product image for show</h3>
                                    </div>
                                @endif
                            </div> <!--end row-->
                        </div> <!-- end col-md-12 -->

                        <div class="col-md-12 m-t-20">

                            <div class="card p-2 m-t-10">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><span class="font-weight-bold text-purple">Name : </span> &nbsp; {{$product_draft_variation_results->name}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card p-2 m-t-10">
                                <div class="row attribute">
                                    <div class="w-25 mb-1">
                                        <p><b>Attribute Name :</b></p>
                                    </div>
                                    <div class="w-75 mb-1">
                                        <p><b>Attribute Terms Name :</b></p>
                                    </div>
                                    @isset($product_draft_variation_results->attribute)
                                        @foreach(\Opis\Closure\unserialize($product_draft_variation_results->attribute) as $attribute_info_key => $attribute_info_value)
                                            @foreach($attribute_info_value as $attribute_key => $attribute_val)
                                                <div class="w-25">
                                                    <p>
                                                        {{$attribute_key}}
                                                        <i class="fa fa-arrow-right font-13" aria-hidden="true"></i>
                                                    </p>
                                                </div>
                                                <div class="w-75">
                                                    <p>
                                                        @foreach($attribute_val as $key => $val)
                                                            {{$val['attribute_term_name']}},
                                                        @endforeach
                                                    </p>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    @endisset
                                </div>
                            </div>

                            <div class="card m-t-10">
                                <div class="product-description p-2" onclick="product_description(this)">
                                    <div> <p>Product Description</p> </div>
                                    <div>
                                        <i class="fa fa-arrow-down font-13" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-up font-13 hide" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="product-description-content hide">
                                    {!! $product_draft_variation_results->description !!}
                                </div>
                            </div>

                            @if(isset($product_draft_variation_results->short_description))
                            <div class="card m-t-10">
                                <div class="product-description p-2" onclick="product_description(this)">
                                    <div> <p>Product Short Description</p> </div>
                                    <div>
                                        <i class="fa fa-arrow-down font-13" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-up font-13 hide" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="product-description-content hide">
                                    {!! $product_draft_variation_results->short_description !!}
                                </div>
                            </div>
                            @endisset

                            {{-- <div id="accordion" class="m-t-10 card_hover wow pulse">
                                <div class="card">
                                    <div class="card-header">
                                        <a class="card-link" data-toggle="collapse" href="#collapseOne">
                                            Description
                                        </a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            {!! $product_draft_variation_results-> description !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                                            Short Description
                                        </a>
                                    </div>
                                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            {!! $product_draft_variation_results-> short_description !!}
                                        </div>
                                    </div>
                                </div>
                            </div> <!--accordion--> --}}

                            <div class="card p-2 m-t-10">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex">
                                            <div class="w-50">
                                                <p>Regular Price :</p>
                                            </div>
                                            <div class="w-50">
                                                <p>{{$product_draft_variation_results->regular_price}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card p-2 m-t-10">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex">
                                            <div class="w-50">
                                                <p>Sale Price :</p>
                                            </div>
                                            <div class="w-50">
                                                <p>{{$product_draft_variation_results->sale_price}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card p-2 m-t-10">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex">
                                            <div class="w-50">
                                                <p>Cost Price :</p>
                                            </div>
                                            <div class="w-50">
                                                <p>{{$product_draft_variation_results->cost_price}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- end col-md-12 -->
                    </div> <!--end row-->

                    <div class="row m-t-40">
                        <div class="col-md-12">
                            <table id="" class="product-draft-table row-expand-table card_table w-100">
                                <thead>
                                <tr>
                                    {{--                                             <th>Description</th>--}}
                                    <th style="width: 5%; text-align: center !important;">Image</th>
                                    <th style="width: 5%; text-align: center !important;">ID</th>
                                    <th style="width: 10%">SKU</th>
                                    <th style="width: 7%">Qr</th>
                                    <th style="width: 10%">Variation</th>
                                    <th style="width: 10%">EAN</th>
                                    <th style="width: 10%; text-align: center !important;">Regular Price</th>
                                    <th style="width: 10%; text-align: center !important;">Sales Price</th>
                                    <th style="width: 10%; text-align: center !important;">Costs Price</th>
                                    <th style="width: 5%; text-align: center !important;">Sold</th>
                                    <th style="width: 5%; text-align: center !important;">Available Qty</th>
                                    @if($shelf_use == 1)
                                        <th style="width: 8%; text-align: center !important;">Shelf Qty</th>
                                    @endif
                                    <th style="width: 5%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($product_draft_variation_results->variations as $product_variation)
                                    @php
                                        $data = \App\ShelfedProduct::where('variation_id',$product_variation->woocom_variation_id)->sum('quantity');
                                        $total_sold = 0;
                                        if(isset($product_variation->master_variation->order_products)){
                                            foreach ($product_variation->master_variation->order_products as $product){
                                                $total_sold += $product->sold;
                                            }
                                        }
                                        $images = $product_draft_variation_results->images;
                                    @endphp
                                    {{--                                         @if($data != 0)--}}
                                    <tr>
                                        {{--                                             <td class="text-justify">{!! str_limit(strip_tags($product_variation->description),$limit = 10,$end='...') !!}</td>--}}
                                        @if($product_variation->image != null)
                                            <td style="width: 5%; text-align: center !important;">
                                                <a href="{{$product_variation->image}}"  title="Click to expand" target="_blank">
                                                    <img class="thumb-md" src="{{$product_variation->image}}" height="60" width="60" alt="WooCommerce Details Image">
                                                </a>
                                            </td>
                                        @elseif(isset($product_draft_variation_results->all_image_info[0]->image_url))
                                            <td style="width: 5%; text-align: center !important;">
                                                <img class="thumb-md" src="{{$product_draft_variation_results->all_image_info[0]->image_url}}" height="60" width="60" alt="WooCommerce Details Image">
                                            </td>
                                        @else
                                            <td style="width: 5%; text-align: center !important;">
                                                <img class="thumb-md" src="{{asset('assets/images/users/no_image.jpg')}}" height="60" width="60" alt="WooCommerce Details Image">
                                            </td>
                                        @endif
                                        <td style="width: 5%; text-align: center !important;">{{$product_variation->id}}</td>
                                        <td style="width: 10%">{{$product_variation->sku}}</td>
                                        <td style="width: 10%">
                                            <div class="pt-2 pb-2">
                                                 {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(60)->generate($product_variation->sku); !!}
                                            </div>
                                        </td>
                                        {{--                                             @if($product_variation->barcode)--}}

                                        {{--                                                <td><a href="{{asset('barcode/'.$product_variation->barcode)}}" download="" title="click to dowmload"><img src="{{asset('barcode/'.$product_variation->barcode)}}"  width="100" height="100" alt="sku barcode"></a>--}}
                                        {{--                                                    <span style="position: absolute;"><a href="{{url('print-barcode/'.$product_variation->id)}}" target="_blank"><i class="fa fa-print"></i></a></span></td>--}}

                                        {{--                                             @else--}}
                                        {{--                                                 <td>Barcode not generated</td>--}}
                                        {{--                                             @endif--}}
                                        <td style="width: 10%">
                                            @isset($product_variation->attribute)
                                                @foreach(\Opis\Closure\unserialize($product_variation->attribute) as $attribute_value)
                                                <label><b style="color: #7e57c2">{{$attribute_value['attribute_name']}}</b> <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{$attribute_value['terms_name']}}, </label>
                                                @endforeach
                                            @endisset
                                        </td>
                                        <td style="width: 10%">{{$product_variation->ean_no}}</td>
                                        <td style="width: 10%; text-align: center !important;">{{$product_variation->regular_price}}</td>
                                        <td style="width: 10%; text-align: center !important;">{{$product_variation->sale_price}}</td>
                                        <td style="width: 10%; text-align: center !important;">{{$product_variation->cost_price}}</td>
                                        <td style="width: 5%; text-align: center !important;">{{$total_sold ?? 0}}</td>
                                        <td style="width: 10%; text-align: center !important;">{{$product_variation->actual_quantity}}</td>
                                        @if($shelf_use == 1)
                                            @if($product_variation->notification_status == 1 && $data < $product_variation->low_quantity)
                                                <td style="width: 5%; text-align: center !important;">{{$data}}<br><span class="label label-table label-danger">Low Quantity {{$product_variation->low_quantity}}</span></td>
                                            @else
                                                <td style="width: 5%; text-align: center !important;">{{$data}}</td>
                                            @endif
                                        @endif
                                        {{--                                             <td>{{$product_variation->low_quantity}}</td>--}}
                                        <td class="actions" style="width: 5%">
                                            <div class="btn-group dropup">
                                                <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Manage
                                                </button>
                                                <div class="dropdown-menu">
                                                    <!-- Dropdown menu links -->
                                                    <div class="dropup-content catalogue-dropup-content">
                                                        <div class="action-1">
                                                            <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{url('woocommerce/variation/'.$product_variation->id.'/edit')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                            <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{url('woocommerce/variation/details/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                                            @if($shelf_use == 1)
                                                                <div class="align-items-center mr-2" data-toggle="tooltip" data-placement="top" title="Shelf View"><a class="btn-size shelf-btn" href="#" target="_blank" data-toggle="modal" data-target="#myModal{{$product_variation->id}}"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a></div>
                                                            @endif
        {{--                                                    <div class="align-items-center mr-2"><a class="btn-success btn-size" href="{{url('catalogue-product-invoice-receive/'.$product_draft_variation_results->id.'/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Receive Invoice"><i class="fa fa-book" aria-hidden="true"></i></a></div>--}}
        {{--                                                    <div class="align-items-center mr-2"><a class="btn-size btn-success" href="{{url('print-barcode/'.$product_variation->id)}}" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print" aria-hidden="true"></i></a></div>--}}
                                                            <div class="align-items-center">
                                                                <form action="{{url('woocommerce/variation/delete/'.$product_variation->id)}}" method="post">
                                                                    @csrf
                                                                    <button class="del-pub delete-btn" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('product');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <div class="modal fade" id="myModal{{$product_variation->id}}">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Shelf Product</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                                                                    <div style="border: 1px solid #ccc;">
                                                                        <div class="row m-t-10">
                                                                            <div class="col-4 text-center">
                                                                                <h6> Shelf Name </h6>
                                                                                <hr width="60%">
                                                                            </div>
                                                                            <div class="col-4 text-center">
                                                                                <h6>Quantity</h6>
                                                                                <hr width="60%">
                                                                            </div>
                                                                            <!-- <div class="col-4 text-center">
                                                                                <h6>Action</h6>
                                                                                <hr width="60%">
                                                                            </div> -->
                                                                        </div>
                                                                        @isset($product_variation->master_variation->shelf_quantity)
                                                                        @foreach($product_variation->master_variation->shelf_quantity as $shelf)
                                                                            @if($shelf->pivot->quantity != 0)
                                                                                <div class="row">
                                                                                    <div class="col-4 text-center m-b-10">
                                                                                        <h7> {{$shelf->shelf_name}} </h7>
                                                                                    </div>
                                                                                    <div class="col-4 text-center m-b-10">
                                                                                        <h7 class="qnty_{{$product_variation->id}}_{{$shelf->pivot->id}}"> {{$shelf->pivot->quantity}} </h7>
                                                                                    </div>
                                                                                    <!-- <div class="col-4 text-center m-b-10">
                                                                                        <button type="button" class="btn btn-primary btn-sm change_quantity" id="{{$product_variation->id}}_{{$shelf->pivot->id}}">Change Quantity</button>
                                                                                    </div> -->
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                        @endisset
                                                                        <div class="row p-20 change_quantity_div" style="display: none;">
                                                                            <div class="col-12">
                                                                                {{--                                                                                     <form action="Javascript:void(0);">--}}
                                                                                <h3>Change Info:</h3><span></span>
                                                                                <hr>
                                                                                <div class="form-group">
                                                                                    <label class="required">Quantity</label>
                                                                                    <input type="text" class="form-control c_quantity_{{$product_variation->id}}" name="c_quantity" id="">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="">Reason</label>
                                                                                    <textarea class="form-control" name="c_reason" id="c_reason" cols="5" rows="3"></textarea>
                                                                                </div>

                                                                                <button type="button" class="btn btn-success">Add</button>
                                                                                {{--                                                                                     </form>--}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> <!-- end card -->
                                                            </div> <!-- end col-12 -->
                                                        </div> <!-- end row -->
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger shadow" data-dismiss="modal">Close</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>  <!-- // The Modal -->
                                    </tr>
                                    {{--                                         @endif--}}
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end row -->

                </div> <!-- end card box -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->


    <script type="text/javascript">
        $(document).ready(function() {

            // Default Datatable
            // $('#datatable').DataTable();

            $('button.change_quantity').on('click',function () {
                var id = $(this).attr('id');
                var id_split = id.split('_');
                $('#myModal'+id_split[0]+' .change_quantity_div input.c_quantity_'+id_split[0]).attr('id','c_quantity_'+id);
                $('#myModal'+id_split[0]+' .change_quantity_div button').attr('id',id);
                $('#myModal'+id_split[0]+' .change_quantity_div span').attr('id',id);
                console.log(id);
                $('#myModal'+id_split[0]+' .change_quantity_div').slideToggle();
            });

            $('.change_quantity_div button').on('click',function () {
                var full_id = $(this).attr('id');
                var id = full_id.split('_');
                var variation_id = id[0];
                var product_shelf_id = id[1];
                var quantity = $('#myModal'+variation_id+' .change_quantity_div input#c_quantity_'+full_id).val();
                if(quantity == ''){
                    alert('Please give change quantity.');
                    return false;
                }
                var reason = $('#myModal'+variation_id+' .change_quantity_div textarea#c_reason').val();
                console.log(variation_id+'/'+quantity+'/'+reason);

                $.ajax({
                    type: "POST",
                    url: "{{url('shelf_quantity_update')}}",
                    data: {
                        "_token" : "{{csrf_token()}}",
                        "product_shelf_id" : product_shelf_id,
                        "quantity" : quantity,
                        "reason" : reason
                    },
                    success: function (response) {
                        if(response.data == true){
                            console.log(response.data);
                            $('.qnty_'+full_id).text(quantity);
                            $('#myModal'+variation_id+' .change_quantity_div span#'+full_id).addClass('text-success').html('Quantity updated successfully.')
                            $('#myModal'+variation_id+' .change_quantity_div input#c_quantity_'+full_id).val('');
                            $('#myModal'+variation_id+' .change_quantity_div textarea#c_reason').val('');
                        }
                    }
                });
            });

        } );
    </script>


@endsection
