@extends('master')

@section('title')
    WooCommerce | Active Product Details | Product Variation Details | WMS360
@endsection

@section('content')


    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <div class="wms-breadcrumb-middle">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">Active Product Details</li>
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
                                        <h6> {{$single_variation_info->master_catalogue->name}} </h6>
                                    </div>
                                </div>
                            </div>

                            <form class="m-t-20" action="#">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="custom-control custom-checkbox mb-3 wow pulse d-flex align-items-center">
                                            <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
                                            <label class="custom-control-label" for="customCheck">Manage Stock</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="custom-control custom-checkbox mb-3 wow pulse d-flex align-items-center">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1" name="example1">
                                            <label class="custom-control-label" for="customCheck1">Notification Status</label>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div id="accordion" class="m-t-10">

                                <div class="card card_hover wow pulse">

                                    <div class="card-header">
                                        <a class="card-link" data-toggle="collapse" href="#collapseOne">
                                            Description
                                        </a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            {!! $single_variation_info->description !!}
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
                                        @isset($single_variation_info->attribute)
                                            @foreach(\Opis\Closure\unserialize($single_variation_info->attribute) as $attribute)
                                                <div class="d-flex">
                                                    <div class="align-items-center"><b style="color: #7e57c2">{{$attribute['attribute_name']}}</b> <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{$attribute['terms_name']}} &nbsp; &nbsp;</div>
                                                </div>
                                            @endforeach
                                        @endisset
                                    </div>
                                </div>
                            </div>

                            <div class="card p-2 m-t-10 card_hover wow pulse">

                                <div class="d-flex justify-content-around">
                                    <div class="w-50">
                                        <h6>SKU :</h6>
                                    </div>
                                    <div class="w-50">
                                        <h6>{{$single_variation_info->sku}}</h6>
                                    </div>
                                </div>
                            </div>

                            <div class="card p-2 m-t-10 card_hover wow pulse">

                                <div class="d-flex justify-content-around">
                                    <div class="w-50">
                                        <h6>EAN :</h6>
                                    </div>
                                    <div class="w-50">
                                        <h6>{{$single_variation_info->ean_no}}</h6>
                                    </div>
                                </div>
                            </div>

                            <div class="card p-2 m-t-10 card_hover wow pulse">

                                <div class="d-flex justify-content-around">
                                    <div class="w-50">
                                        <h6>Regular Price :</h6>
                                    </div>
                                    <div class="w-50">
                                        <h6>{{$single_variation_info->regular_price}}</h6>
                                    </div>
                                </div>
                            </div>


                            <div class="card p-2 m-t-10 card_hover wow pulse">

                                <div class="d-flex justify-content-around">
                                    <div class="w-50">
                                        <h6>Sale Price :</h6>
                                    </div>
                                    <div class="w-50">
                                        <h6>{{$single_variation_info->sale_price}}</h6>
                                    </div>
                                </div>
                            </div>


                            <div class="card p-2 m-t-10 m-b-30 card_hover wow pulse">

                                <div class="d-flex justify-content-around">
                                    <div class="w-50">
                                        <h6>Low Quantity :</h6>
                                    </div>
                                    <div class="w-50">
                                        <h6>{{$single_variation_info->low_quantity}}</h6>
                                    </div>
                                </div>
                            </div>


                        </div> <!-- end col-md-7 -->


                        <div class="col-md-5 m-t-30">
                            <div class="d-flex justify-content-center">
                                <div class="card">
                                    @if($single_variation_info->image != null)
                                        <img class="card-img-top img-thumbnail wow pulse" src="{{$single_variation_info->image}}" alt="Product image" width="100%" height="auto">
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
