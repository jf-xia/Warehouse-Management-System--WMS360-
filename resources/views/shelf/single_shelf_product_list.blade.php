
@extends('master')

@section('title')
    Shelf List | {{$single_shelf_product->shelf_name}} Shelf Product List | WMS360
@endsection

@section('content')


    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">



                <div class="d-flex justify-content-between align-items-center">
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="{{url('shelf')}}">Shelf List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$single_shelf_product->shelf_name}} Shelf Product List</li>
                    </ol>
                </div>



                <div class="card-box m-t-20 shadow table-responsive">

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


                    <div class="row m-t-20">
                        <div class="col-md-12">
                            <table class="shelf-table w-100">
                                    <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">SKU</th>
                                        <th class="text-center">Variation</th>
                                        <th class="text-center">EAN</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">R Price</th>
                                        <th class="text-center">S Price</th>
                                        <th class="text-center">L Quantity</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($single_shelf_product->total_product as $product_variation)
                                        @if($product_variation->pivot->quantity != 0)
                                            <tr>
                                                <td class="text-center">{{$product_variation->id}}</td>
                                                @if($product_variation->image != null)
                                                    <td class="text-center"><a href="{{$product_variation->image}}" target="_blank"><img class="rounded" src="{{$product_variation->image}}" height="60" width="60" alt="Responsive image"></a></td>
                                                @else
                                                    <td class="text-center"><img class="rounded" src="{{asset('assets/images/users/no_image.jpg')}}" height="60" width="60" alt="Responsive image"></td>
                                                @endif
                                                <td class="text-center">{{$product_variation->sku}}</td>
{{--                                                @if($product_variation->barcode)--}}
{{--                                                    <td><a href="{{asset('barcode/'.$product_variation->barcode)}}" download="" title="click to dowmload"><img src="{{asset('barcode/'.$product_variation->barcode)}}" alt="sku barcode"></a></td>--}}
{{--                                                @else--}}
{{--                                                    <td>Barcode not generated</td>--}}
{{--                                                @endif--}}
                                                <td class="text-center">
                                                    @isset($product_variation->attribute)
                                                        @foreach(\Opis\Closure\unserialize($product_variation->attribute) as $attribute)
                                                            <label><b style="color: #7e57c2">{{$attribute["attribute_name"]}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$attribute["terms_name"]}}, </label>
                                                        @endforeach
                                                    @endisset
{{--                                                        <label><b style="color: #7e57c2">{{\App\Attribute::find(5)->attribute_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute1}}, </label>--}}
{{--                                                    @endif--}}
{{--                                                    @if(isset($product_variation->attribute2))--}}
{{--                                                        <label><b style="color: #7e57c2">{{\App\Attribute::find(6)->attribute_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute2}},</label>--}}
{{--                                                    @endif--}}

{{--                                                    @if(isset($product_variation->attribute3))--}}
{{--                                                        <label><b style="color: #7e57c2">{{\App\Attribute::find(7)->attribute_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute3}}, </label>--}}
{{--                                                    @endif--}}

{{--                                                    @if(isset($product_variation->attribute4))--}}
{{--                                                        <label><b style="color: #7e57c2">{{\App\Attribute::find(8)->attribute_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute4}}, </label>--}}
{{--                                                    @endif--}}

{{--                                                    @if(isset($product_variation->attribute5))--}}
{{--                                                        <label><b style="color: #7e57c2">{{\App\Attribute::find(9)->attribute_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute5}}, </label>--}}
{{--                                                    @endif--}}

{{--                                                    @if(isset($product_variation->attribute6))--}}
{{--                                                        <label><b style="color: #7e57c2">{{\App\Attribute::find(10)->attribute_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute6}}, </label>--}}
{{--                                                    @endif--}}

{{--                                                    @if(isset($product_variation->attribute7))--}}
{{--                                                        <label><b style="color: #7e57c2">{{\App\Attribute::find(11)->attribute_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute7}}, </label>--}}
{{--                                                    @endif--}}

{{--                                                    @if(isset($product_variation->attribute8))--}}
{{--                                                        <label><b style="color: #7e57c2">{{\App\Attribute::find(12)->attribute_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute8}}, </label>--}}
{{--                                                    @endif--}}

{{--                                                    @if(isset($product_variation->attribute9))--}}
{{--                                                        <label><b style="color: #7e57c2">{{\App\Attribute::find(13)->attribute_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute9}}, </label>--}}
{{--                                                    @endif--}}

{{--                                                    @if(isset($product_variation->attribute10))--}}
{{--                                                        <label><b style="color: #7e57c2">{{\App\Attribute::find(14)->attribute_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute10}}, </label>--}}
{{--                                                    @endif--}}
                                                </td>
                                                <td class="text-center">{{$product_variation->ean_no}}</td>
                                                <td class="text-center">{{$product_variation->pivot->quantity}}</td>
                                                <td class="text-center">{{$product_variation->regular_price}}</td>
                                                <td class="text-center">{{$product_variation->sale_price}}</td>
                                                <td class="text-center">{{$product_variation->low_quantity}}</td>
                                                <td class="text-center">
                                                    <div class="btn-group dropup">
                                                        <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Manage
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <!-- Dropdown menu links -->
                                                            <div class="dropup-content">
                                                                <div class="action-1">
                                                                    @if (Auth::check() && in_array('1',explode(',',Auth::user()->role)) || in_array('2',explode(',',Auth::user()->role)))
                                                                        <a class="mr-2" href="{{route('product-variation.edit',$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><button class="btn-size edit-btn" style="cursor: pointer;"><i class="fa fa-edit" aria-hidden="true"></i></button></a>&nbsp;
                                                                        <a class="mr-2" href="{{url('variation-details/'.Crypt::encrypt($product_variation->id))}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><button class="btn-size view-btn" style="cursor: pointer;"><i class="fa fa-eye" aria-hidden="true"></i></button></a>&nbsp;
                                                                        <a class="mr-2" href="#" data-toggle="modal" data-placement="top" title="Shelf View" data-target="#myModal{{$product_variation->id}}"><button class="btn-size shelf-btn" style="cursor: pointer;"><i class="fa fa-shopping-basket" aria-hidden="true"></i></button></a>
                                                                        <a class="mr-2" href="{{url('print-barcode/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Click to print" target="_blank"><button class="btn-size print-btn" style="cursor: pointer;"><i class="fa fa-print"></i></button></a>
                                                                        <form action="{{route('product-variation.destroy',$product_variation->id)}}" method="post">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <a href="" class="on-default remove-row"data-toggle="tooltip" data-placement="top" title="Delete"><button class="btn-size delete-btn" onclick="" style="cursor: pointer;"><i class="fa fa-trash" aria-hidden="true"></i></button> </a>
                                                                        </form>
                                                                    @else
                                                                        <a href="{{url('variation-details/'.Crypt::encrypt($product_variation->id))}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><button class="btn-size view-btn" style="cursor: pointer;"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                                                    @endif
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
                                                                                    <div class="col-6 text-center">
                                                                                        <h6> Shelf Name </h6>
                                                                                        <hr width="60%">
                                                                                    </div>
                                                                                    <div class="col-6 text-center">
                                                                                        <h6>Quantity</h6>
                                                                                        <hr width="60%">
                                                                                    </div>
                                                                                </div>
                                                                                @foreach($product_variation->shelf_quantity as $shelf)
                                                                                    @if($shelf->pivot->quantity != 0)
                                                                                        <div class="row m-b-10">
                                                                                            <div class="col-6 text-center">
                                                                                                <h7> {{$shelf->shelf_name}} </h7>
                                                                                            </div>
                                                                                            <div class="col-6 text-center">
                                                                                                <h7> {{$shelf->pivot->quantity}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                @endforeach
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
                                        @endif
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
            $('#datatable').DataTable();

        } );
    </script>

@endsection
