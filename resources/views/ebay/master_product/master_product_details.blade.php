@extends('master')

@section('title')
    eBay | Active Product | Product Details | WMS360
@endsection

@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <ol class="breadcrumb page-breadcrumb" style="margin-bottom: 0 !important;">
                            <li class="breadcrumb-item" aria-current="page">Active Product</li>
                            <li class="breadcrumb-item active" aria-current="page">Active Product Details</li>
                        </ol>
                    </div>
                </div>



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
                                @if(unserialize($single_master_product_details->master_images) != null)
{{--                                    <div class="col-md-2 col-sm-6">--}}
{{--                                        <div class="card m-b-10">--}}
{{--                                            <img class="card-img-top img-thumbnail" src="{{$single_master_product_details->default_image}}" alt="Product image">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    @foreach(unserialize($single_master_product_details->master_images) as $image)
                                        <div class="col-md-2 col-sm-6">
                                            <div class="card m-b-10">
                                                <img class="card-img-top img-thumbnail" src="{{$image}}" alt="Product image">
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
                                        <p><span class="font-weight-bold text-purple">Name : </span> &nbsp; {{$single_master_product_details->title}}</p>
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
                                <div class="product-description p-2" onclick="ebay_product_description(this)">
                                    <div> <p>Template Description</p> </div>
                                    <div>
                                        <i class="fa fa-arrow-down font-13" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-up font-13 hide" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="product-description-content hide">
                                    {!! $single_master_product_details->item_description !!}
                                </div>
                            </div>

                            {{-- <div class="card m-t-10">
                                <a href="#product-description-hide" id="product-description-hide">Expand Template Description <i class="fa fa-arrow-down"></i></a>
                                <a href="#/" id="product-description-show">Collapse Template Description &nbsp; <i class="fa fa-arrow-up"></i></a>
                                <div id="description-content">
                                    <div class="template-description-content">
                                        <div id="ebay-master-product-des" class="collapse show mas-pro-ebay-template-view nicescroll" data-parent="#ebay-product-des">
                                            <div class="card-body">
                                                {!! $single_master_product_details->item_description !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="card m-t-10">
                                <div class="product-description p-2" onclick="ebay_product_description(this)">
                                    <div> <p>Product Content</p> </div>
                                    <div>
                                        <i class="fa fa-arrow-down font-13" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-up font-13 hide" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="product-description-content hide">
                                    <div class="wms-row">
                                        @foreach(unserialize($single_master_product_details->item_specifics) as $key => $value)
                                            <div class="wms-col-4">
                                                <div class="card pl-2 mt-2 mb-2">
                                                    {{$key}} : {{$value}}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                            {{-- <div class="card m-t-10 card_hover">
                                <a href="#product-content-hide" id="product-content-hide">Expand Product Content <i class="fa fa-arrow-down"></i></a>
                                <a href="#/" id="product-content-show">Collapse Product Content &nbsp; <i class="fa fa-arrow-up"></i></a>
                                <div id="product-content">
                                    <div class="ebay-details-product-content">
                                        <div class="wms-row">
                                            @foreach(unserialize($single_master_product_details->item_specifics) as $key => $value)
                                                <div class="wms-col-4">
                                                    <div class="card pl-2 mt-2 mb-2">
                                                        {{$key}} : {{$value}}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div> --}}


                            <div class="card p-2 m-t-10">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex">
                                            <div class="w-50">
                                                <p>Sale Price :</p>
                                            </div>
                                            <div class="w-50">
                                                <p>{{$single_master_product_details->start_price}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> <!--end row-->

                    <div class="row m-t-10">
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
                                <table class="product-draft-table row-expand-table card_table w-100">
                                    <thead>
                                    <tr>
                                        <th style="width: 8%; text-align: center !important;">Image</th>
                                        <th style="text-align: center !important;">SKU</th>
                                        <th style="text-align: center !important;">QR</th>
                                        <th style="text-align: center !important;">Variation</th>
                                        <th style="text-align: center !important;">start Price</th>
{{--                                        <th>Condition</th>--}}
                                        <th style="text-align: center !important;">Quantity</th>
                                        <th style="width: 10%">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($single_master_product_details->variationProducts as $product_variation)
                                        @php
                                        if($shelfUse == 1){
                                                $woo_variation_id = \App\ProductVariation::where('sku',$product_variation->sku)->first();
                                                if ($woo_variation_id){
                                                    $shelf_quantity = \App\ShelfedProduct::with('shelf_info')->where('variation_id',$woo_variation_id->id)->get();
                                                $data = \App\ShelfedProduct::where('variation_id',$woo_variation_id->id)->sum('quantity');
                                                }
                                            }

                                        @endphp
                                        {{--                                         @if($data != 0)--}}
                                        <tr>
                                            {{--                                             <td class="text-justify">{!! str_limit(strip_tags($product_variation->description),$limit = 10,$end='...') !!}</td>--}}
                                            @if(unserialize($single_master_product_details->master_images) != null)
                                                <td style="width: 8%; text-align: center !important;">
                                                    <a href="{{unserialize($single_master_product_details->master_images)[0]}}"  title="Click to expand" target="_blank">
                                                        <img class="thumb-md" src="{{unserialize($single_master_product_details->master_images)[0]}}" height="60" width="60" alt="Responsive image">
                                                    </a>
                                                </td>
                                            @else
                                                <td>
                                                    <img class="thumb-md" src="{{asset('assets/images/users/no_image.jpg')}}" height="60" width="60" alt="Responsive image"></td>
                                            @endif

                                            <td style="text-align: center !important">{{$product_variation->sku}}</td>
                                            <td style="text-align: center !important;">
                                                <div class="py-2">
                                                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(60)->generate($product_variation->sku); !!}
                                                </div>
                                            </td>
                                            <td style="text-align: center !important;">
                                                @if(isset($product_variation->variation_specifics))
<?php
//                                                    echo "<pre>";
//                                                    print_r(\Opis\Closure\unserialize($product_variation->variation_specifics));
//
//
//                                                    ?>
                                                    @if(is_array(unserialize($product_variation->variation_specifics)))
                                                        @foreach(unserialize($product_variation->variation_specifics) as $key => $value)
                                                            <label><b style="color: #7e57c2">{{$key}}</b> <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{$value}}, </label>
                                                        @endforeach
                                                    @endif
                                                    @if(isset($product_variation->attribute2_name))
                                                        <label><b style="color: #7e57c2">{{$product_variation->attribute2_name}}</b> <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{$product_variation->attribute2_value}}, </label>
                                                    @endif
                                                @endif

                                            </td>
                                            <td style="text-align: center !important">{{$product_variation->start_price}}</td>
{{--                                            <td>{{$product_variation->condition}}</td>--}}
{{--                                            @if($product_variation->stock < $product_variation->low_quantity)--}}
{{--                                                <td>{{$product_variation->stock}}<br><span class="label label-table label-danger">Low Quantity {{$product_variation->low_quantity}}</span></td>--}}
{{--                                            @else--}}
{{--                                                <td>{{$product_variation->quantity}}</td>--}}
{{--                                            @endif--}}
                                            <td style="text-align: center !important">{{$product_variation->quantity}}</td>
                                            <td style="width: 10%">
                                                <div class="action-1">
                                                    <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{url('ebay-master-product/'.$single_master_product_details->id.'/edit')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                    <div class="align-items-center mr-2"><a class="btn-size delete-btn" href="{{url('ebay-variation-product-delete/'.$single_master_product_details->id.'/'.$product_variation->sku)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Delete variation"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
{{--                                                    <div class="align-items-center mr-2"><a class="btn-size btn-success" href="{{url('onbuy/variation-product-details/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>--}}
                                                    @if($shelfUse == 1)
                                                        <div class="align-items-center mr-2" data-toggle="tooltip" data-placement="top" title="Shelf View"><a class="btn-size shelf-btn" href="#" data-toggle="modal" data-target="#myModal{{$product_variation->sku}}"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a></div>
                                                    @endif
{{--                                                    <div class="align-items-center mr-2"><a class="btn-size btn-success" href="{{url('onbuy/add-listing/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Add Listing"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></div>--}}
{{--                                                    <div class="align-items-center mr-2"><a class="btn-size btn-danger" href="{{url('onbuy/delete-listing/'.$single_master_product_details->id.'/'.$product_variation->id)}}" data-toggle="tooltip" data-placement="top" title="Delete Listing" onclick="return check_delete('listing');"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div>--}}
{{--                                                    start--}}
{{--                                                                                                        <div class="align-items-center mr-2">--}}
{{--                                                                                                            <form action="" method="post">--}}
{{--                                                                                                                @csrf--}}
{{--                                                                                                                @method('DELETE')--}}
{{--                                                                                                                <button class="del-pub btn-danger" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('product');"><i class="fa fa-trash-o" aria-hidden="true"></i></button>--}}
{{--                                                                                                            </form>--}}
{{--                                                                                                        </div>--}}
{{--                                                    end--}}
                                                </div>
                                            </td>
{{--                                            modal start--}}
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
                                                                            @isset($shelf_quantity)
                                                                                @foreach($shelf_quantity as $shelf)
                                                                                    @if($shelf->quantity != 0)
                                                                                        <div class="row">
                                                                                            <div class="col-6 text-center">
                                                                                                <h7> {{$shelf->shelf_info->shelf_name}} </h7>
                                                                                            </div>
                                                                                            <div class="col-6 text-center">
                                                                                                <h7> {{$shelf->quantity}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endisset
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
                        </div> <!-- end col 12 -->
                    </div> <!-- end row -->
                </div> <!-- end card box -->
            </div> <!-- container -->
        </div>

    </div>  <!-- content page -->



@endsection



