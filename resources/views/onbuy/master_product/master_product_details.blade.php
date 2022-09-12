@extends('master')

@section('title')
    OnBuy | Active Product | Active Product Details | WMS360
@endsection


@section('content')


    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <div class="wms-breadcrumb">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">  Active Product  </li>
                            <li class="breadcrumb-item active" aria-current="page"> Active Product Details </li>
                        </ol>
                    </div>
                    <div class="breadcrumbRightSideBtn">
                        <a href="{{url('onbuy/edit-master-product/'.$single_master_product_details->id)}}"><button class="btn btn-default">Edit</button></a>
                    </div>
                </div>


                <!-- Page-Title -->
{{--                <div class="row">--}}
{{--                    <div class="col-md-12 text-center">--}}
{{--                        <div class="vendor-title">--}}
{{--                            <p>Master Product Details</p>--}}
{{--                            <a href="{{url('onbuy/edit-master-product/'.$single_master_product_details->id)}}"><button class="m-r-10 btn btn-success" style="float: right;margin-top: -40px;">Edit</button></a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="card-box m-t-20 shadow product-draft-details">

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
                                @if($single_master_product_details->additional_images != null)
{{--                                    <div class="col-md-2 col-sm-6">--}}
{{--                                        <div class="card m-b-10">--}}
{{--                                            <img class="card-img-top img-thumbnail" src="{{$single_master_product_details->default_image}}" alt="Product image">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    @if($single_master_product_details->additional_images != null)
                                        @foreach(json_decode($single_master_product_details->additional_images) as $image)
                                            <div class="col-md-2 col-sm-6">
                                                <div class="card m-b-10">
                                                    <img class="card-img-top img-thumbnail" src="{{$image}}" alt="Product image">
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
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
                                        <p><span class="font-weight-bold text-purple">Name : </span> &nbsp; {{$single_master_product_details->product_name}}</p>
                                    </div>
                                </div>
                            </div>

{{--                            <div class="card p-2 m-t-10 card_hover wow pulse">--}}
{{--                                <div class="row attribute">--}}
{{--                                    <div class="w-50">--}}
{{--                                        <h6>Attribute Name :</h6>--}}
{{--                                    </div>--}}
{{--                                    <div class="w-50">--}}
{{--                                        <h6>Attribute Terms Name :</h6>--}}
{{--                                    </div>--}}
{{--                                    @foreach($attribute_info[0]->product_draft_attribute as $attribute)--}}
{{--                                        <div class="w-50">--}}
{{--                                            <h6>{{$attribute->attribute_name}}</h6>--}}
{{--                                        </div>--}}
{{--                                        <div class="w-50">--}}
{{--                                            <h6>{{\App\AttributeTerm::find($attribute->pivot->attribute_term_id)->terms_name}}</h6>--}}
{{--                                        </div>--}}
{{--                                    @endforeach--}}
{{--                                </div>--}}
{{--                            </div>--}}


                                <div class="card m-t-10">
                                    <div class="product-description p-2" onclick="product_description(this)">
                                        <div> <p>Product Description</p> </div>
                                        <div>
                                            <i class="fa fa-arrow-down font-13" aria-hidden="true"></i>
                                            <i class="fa fa-arrow-up font-13 hide" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="product-description-content hide">
                                        {!! $single_master_product_details->description !!}
                                    </div>
                                </div>



                            {{-- <div id="accordion" class="m-t-10 card_hover wow pulse">
                                <div class="card">
                                    <div class="card-header">
                                        <a class="card-link" data-toggle="collapse" href="#collapseOne">
                                            Description
                                        </a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            {!! $single_master_product_details->description !!}
                                        </div>
                                    </div>
                                </div>
                            </div> <!--accordion--> --}}



                            <div class="card p-2 m-t-10">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex">
                                            <div class="w-50">
                                                <p>Sale Price :</p>
                                            </div>
                                            <div class="w-50">
                                                <p>{{$single_master_product_details->rrp}}</p>
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
                                                <p>Summary Points :</p>
                                            </div>
                                            <div class="w-50">
                                                <ul class="m-0 p-0">
                                                    @isset($single_master_product_details->summary_points)
                                                        @foreach(json_decode($single_master_product_details->summary_points) as $summary_point)
                                                            <li>{{$summary_point}}</li>
                                                        @endforeach
                                                    @endisset
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card p-2 m-t-10">
                                <div class="row attribute">
                                    <div class="w-50">
                                        <p><b>Label :</b></p>
                                    </div>
                                    <div class="w-50">
                                        <p><b>Value :</b></p>
                                    </div>
                                    @isset($single_master_product_details->product_data)
                                        @foreach(json_decode($single_master_product_details->product_data) as $product_data)
                                            <div class="w-50">
                                                <p>{{$product_data->label}}</p>
                                            </div>
                                            <div class="w-50">
                                                <p>{{$product_data->value}}</p>
                                            </div>
                                        @endforeach
                                    @endisset
                                </div>
                            </div>

                            <div class="card p-2 m-t-10">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex">
                                            <div class="w-50">
                                                <p>Features :</p>
                                            </div>
                                            <div class="w-50">
                                                <ul class="m-0 p-0">
                                                    @if(json_decode($single_master_product_details->features) != null)
                                                        @foreach(json_decode($single_master_product_details->features) as $features)
                                                            <li>{{explode('/',$features->option_id)[1]}} -> {{explode('/',$features->option_id)[2]}}</li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- end col-md-12 -->
                    </div> <!--end row-->

                    <div class="row m-t-40">
                        <div class="col-md-12">
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
                            <div class="table-responsive">
                                <table class="product-draft-table row-expand-table w-100">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">OPC</th>
                                        <th class="text-center">SKU</th>
                                        <th class="text-center">QR</th>
                                        <th class="text-center">Variation</th>
                                        <th style="text-align: center !important">Sales Price</th>
                                        <th style="text-align: center !important">Condition</th>
                                        <th style="text-align: center !important">Quantity</th>
                                        <th style="width: 10%">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($single_master_product_details->variation_product as $product_variation)
                                        @php
                                            $woo_variation_id = \App\ProductVariation::where('sku',$product_variation->sku)->first();
                                            $shelf_quantity = [];
                                            if($woo_variation_id){
                                                $shelf_quantity = \App\ShelfedProduct::with('shelf_info')->where('variation_id',$woo_variation_id->id)->get();
                                                $data = \App\ShelfedProduct::where('variation_id',$woo_variation_id->id)->sum('quantity');
                                            }
                                        @endphp
                                        {{--                                         @if($data != 0)--}}
                                        <tr>
                                            {{--                                             <td class="text-justify">{!! str_limit(strip_tags($product_variation->description),$limit = 10,$end='...') !!}</td>--}}
                                            @if($single_master_product_details->default_image != null)
                                                <td class="text-center">
                                                    <a href="{{$single_master_product_details->default_image}}"  title="Click to expand" target="_blank">
                                                        <img class="thumb-md" src="{{$single_master_product_details->default_image}}" height="60" width="60" alt="OnBuy image">
                                                    </a>
                                                </td>
                                            @else
                                                <td class="text-center">
                                                    <img class="thumb-md" src="{{asset('assets/images/users/no_image.jpg')}}" height="60" width="60" alt="OnBuy image">
                                                </td>
                                            @endif
                                            <td class="text-center">{{$product_variation->opc}}</td>
                                            <td class="text-center">{{$product_variation->sku}}@if($product_variation->updated_sku) <p>( Updated SKU: {{$product_variation->updated_sku}} )</p> @endif</td>
                                            <td class="text-center">
                                                <div class="py-2">
                                                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(60)->generate($product_variation->sku); !!}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if(isset($product_variation->attribute1_name))
                                                    <label><b style="color: #7e57c2">{{$product_variation->attribute1_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute1_value}}, </label>
                                                @endif
                                                @if(isset($product_variation->attribute2_name))
                                                    <label><b style="color: #7e57c2">{{$product_variation->attribute2_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute2_value}}, </label>
                                                @endif
                                            </td>
                                            <td style="text-align: center !important">{{$product_variation->price}}</td>
                                            <td style="text-align: center !important">{{$product_variation->condition}}</td>
                                            @if($product_variation->stock < $product_variation->low_quantity)
                                                <td style="text-align: center !important">{{$product_variation->stock}}<br><span class="label label-table label-danger">Low Quantity {{$product_variation->low_quantity}}</span></td>
                                            @else
                                                <td style="text-align: center !important">{{$product_variation->stock}}</td>
                                            @endif
                                            <td class="actions" style="width: 10%">
                                                <div class="btn-group dropup">
                                                    <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Manage
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <!-- Dropdown menu links -->
                                                        <div class="dropup-content onbuy-dropup-content">
                                                            <div class="action-1">
                                                                <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{url('onbuy/edit-variation-product/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                                <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{url('onbuy/variation-product-details/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                                                @if($shelf_ues == 1)
                                                                     <div class="align-items-center mr-2" data-toggle="tooltip" data-placement="top" title="Shelf View"><a class="btn-size shelf-btn" href="#" data-toggle="modal" data-target="#myModal{{$product_variation->sku}}"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a></div>
                                                                @endif
                                                                <div class="align-items-center mr-2"><a class="btn-size add-product-btn" href="{{url('onbuy/add-listing/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Add Listing"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></div>
                                                                <div class="align-items-center"><a class="btn-size delete-btn" href="{{url('onbuy/delete-listing/'.$single_master_product_details->id.'/'.$product_variation->id)}}" data-toggle="tooltip" data-placement="top" title="Delete Listing" onclick="return check_delete('listing');"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
            {{--                                                    <div class="align-items-center mr-2">--}}
            {{--                                                        <form action="" method="post">--}}
            {{--                                                            @csrf--}}
            {{--                                                            @method('DELETE')--}}
            {{--                                                            <button class="del-pub btn-danger" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('product');"><i class="fa fa-trash-o" aria-hidden="true"></i></button>--}}
            {{--                                                        </form>--}}
            {{--                                                    </div>--}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <div class="modal fade" id="myModal{{$product_variation->sku}}">
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
                                                                                <div class="col-6 text-center">
                                                                                    <h6> Shelf Name </h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                                <div class="col-6 text-center">
                                                                                    <h6>Quantity</h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                            </div>
                                                                            @php

                                                                            @endphp
                                                                            @if(count($shelf_quantity) > 0)
                                                                                @foreach($shelf_quantity as $shelf)
                                                                                    @if($shelf->quantity != 0)
                                                                                        <div class="row m-b-10">
                                                                                            <div class="col-6 text-center">
                                                                                                <h7> {{$shelf->shelf_info->shelf_name}} </h7>
                                                                                            </div>
                                                                                            <div class="col-6 text-center">
                                                                                                <h7> {{$shelf->quantity}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
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
                        </div>
                    </div> <!-- end row -->

                </div> <!-- end card box -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->


    <script type="text/javascript">
        $(document).ready(function() {

            // Default Datatable
            $('#datatable').DataTable();

        } );
    </script>


@endsection
