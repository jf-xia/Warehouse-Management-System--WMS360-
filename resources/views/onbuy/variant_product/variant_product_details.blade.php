
@extends('master')

@section('title')
    OnBuy | Active Product Details | Product Variation Details | WMS360
@endsection

@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <div class="wms-breadcrumb-middle">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Active Product Details</li>
                            <li class="breadcrumb-item active" aria-current="page">Product Variation Details</li>
                        </ol>
                    </div>
                </div>


                <div class="card-box m-t-20 shadow">
                    <div class="row v-details">
                        <div class="col-md-7 m-t-20">
                            <div class="card p-2 m-t-10 card_hover wow pulse">
                                <div class="d-flex justify-content-around">
                                    <div class="w-25">
                                        <h6> Product Name : </h6>
                                    </div>
                                    <div class="w-75">
                                        <h6> {{$variation_product_info->name}} </h6>
                                    </div>
                                </div>
                            </div>
                            <div id="accordion" class="m-t-10">
                                <div class="card card_hover wow pulse">
                                    <div class="card-header">
                                        <a class="card-link" data-toggle="collapse" href="#collapseOne">
                                            Description
                                        </a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            {!! $variation_product_info->master_product_info->description !!}
                                        </div>
                                    </div>
                                </div>
                            </div> <!--accordion-->
                            <div class="card p-2 m-t-10 card_hover wow pulse">
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="mr-5">
                                        <h6>Variation : </h6>
                                    </div>
                                    <div class="ml-5 d-flex">
                                        @if(isset($variation_product_info->attribute1_name))
                                            <div class="d-flex">
                                                <div class="align-items-center"><b style="color: #7e57c2">{{$variation_product_info->attribute1_name}}</b> <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{$variation_product_info->attribute1_value}}, &nbsp; &nbsp;</div>
                                            </div>
                                        @endif
                                        @if(isset($variation_product_info->attribute2_name))
                                            <div class="d-flex">
                                                <div class="align-items-center"><b style="color: #7e57c2">{{$variation_product_info->attribute2_name}}</b> <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{$variation_product_info->attribute2_value}}, &nbsp; &nbsp;</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card p-2 m-t-10 card_hover wow pulse">
                                <div class="d-flex justify-content-around">
                                    <div class="w-50">
                                        <h6>OPC :</h6>
                                    </div>
                                    <div class="w-50">
                                        <h6>{{$variation_product_info->opc}}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card p-2 m-t-10 card_hover wow pulse">
                                <div class="d-flex justify-content-around">
                                    <div class="w-50">
                                        <h6>SKU :</h6>
                                    </div>
                                    <div class="w-50">
                                        <h6>{{$variation_product_info->sku}} @if($variation_product_info->updated_sku) ( Updated SKU: {{$variation_product_info->updated_sku}} ) @endif</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card p-2 m-t-10 card_hover wow pulse">
                                <div class="d-flex justify-content-around">
                                    <div class="w-50">
                                        <h6>GROUP SKU :</h6>
                                    </div>
                                    <div class="w-50">
                                        <h6>{{$variation_product_info->group_sku}}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card p-2 m-t-10 card_hover wow pulse">
                                <div class="d-flex justify-content-around">
                                    <div class="w-50">
                                        <h6>EAN :</h6>
                                    </div>
                                    <div class="w-50">
                                        <h6>{{$variation_product_info->ean_no}}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card p-2 m-t-10 card_hover wow pulse">
                                <div class="d-flex justify-content-around">
                                    <div class="w-50">
                                        <h6>Sale Price :</h6>
                                    </div>
                                    <div class="w-50">
                                        <h6>{{$variation_product_info->price}}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card p-2 m-t-10 card_hover wow pulse">
                                <div class="d-flex justify-content-around">
                                    <div class="w-50">
                                        <h6>Low Quantity :</h6>
                                    </div>
                                    <div class="w-50">
                                        <h6>{{$variation_product_info->low_quantity}}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card p-2 m-t-10 m-b-30 card_hover wow pulse">
                                <h5>Technical Details: </h5>
                                <div class="d-flex justify-content-around">
                                    <div class="w-50">
                                        <h6>Grop Name</h6>
                                    </div>
                                    <div class="w-50">
                                        <h6>Value</h6>
                                    </div>
                                </div>
                                @isset($variation_product_info->technical_detail)
                                    @foreach(json_decode($variation_product_info->technical_detail) as $technical_detail)
                                        <div class="d-flex justify-content-around">
                                            <div class="w-50">
                                                <h6>{{$technical_detail->detail_id}}</h6>
                                            </div>
                                            <div class="w-50">
                                                <h6>{{$technical_detail->value}}</h6>
                                            </div>
                                        </div>
                                    @endforeach
                                @endisset
                            </div>
                        </div> <!-- end col-md-7 -->
                        <div class="col-md-5 m-t-30">
                            <div class="d-flex justify-content-center">
                                <div class="card">
                                    @if($variation_product_info->master_product_info->default_image != null)
                                        <img class="card-img-top img-thumbnail wow pulse" src="{{$variation_product_info->master_product_info->default_image}}" alt="Product image" width="100%" height="auto">
                                    @else
                                        <img class="card-img-top img-thumbnail wow pulse" src="{{asset('assets/images/users/no_image.jpg')}}" alt="Product image" width="100%" height="auto">
                                    @endif
                                </div>
                            </div>
                            {{-- <div class="row">
                                 <div class="col-md-10">
                                     <h3>No Product image for show</h3>
                                 </div>
                             </div> --}}
                        </div> <!-- end col-md-5 -->
                    </div> <!--end row-->
                </div> <!-- end card box -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->
@endsection
