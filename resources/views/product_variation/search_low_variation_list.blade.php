

    @foreach($search_result as $search_result)
        <tr>
            @if($search_result->image != null)
                <td class="image text-center"><img class="product-img" src="{{$search_result->image}}" height="60" width="60" alt="Responsive image"></td>
            @elseif(isset($search_result->product_draft->product_catalogue_image->image_url))
                <td class="image text-center"><a href="{{$search_result->product_draft->product_catalogue_image->image_url}}" target="_blank"><img class="product-img" src="{{$search_result->product_draft->product_catalogue_image->image_url}}" height="60" width="60" alt="Responsive image"></a></td>
            @else
                <td class="image text-center"><img class="product-img" src="{{asset('assets/images/users/no_image.jpg')}}" height="60" width="60" alt="Responsive image"></td>
            @endif
            <td class="id" style="width: 7%; text-align: center !important;">
                <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                    <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$search_result->id}}</span>
                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                </div>
            </td>
            <td class="title" style="width: 40%; !important;"><a href="{{route('product-draft.show',$search_result->product_draft->id)}}" title="View Details" target="_blank">{{$search_result->product_draft->name}}</a></td>
            <td class="sku">{{$search_result->sku}}</td>
            @php
                $data = 0;
            @endphp
            @foreach($search_result->shelf_quantity as $total)
                @php
                    $data += $total->pivot->quantity;
                @endphp
            @endforeach
            @if($search_result->notification_status == 1 && $data < $search_result->low_quantity)
                <td class="total-qty" style="width: 10% !important; text-align: center !important;">{{$data}}<br><span class="label label-table label-danger">Low Quantity {{$search_result->low_quantity}}</span></td>
            @else
                <td class="total-qty" style="width: 10% !important; text-align: center !important;">{{$data}}</td>
            @endif
            <td class="low-qty" style="width: 15% !important; text-align: center !important;">{{$search_result->low_quantity}}</td>
            <td class="variation">
                @isset($search_result->attribute)
                    @foreach(\Opis\Closure\unserialize($search_result->attribute) as $attribute)
                    <label><b style="color: #7e57c2">{{$attribute['attribute_name']}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$attribute['terms_name']}}, </label>
                    @endforeach
                @endisset
            </td>
            @php
                $total_sold = 0;
                 foreach ($search_result->order_products as $product){
                     $total_sold += $product->sold;
                 }
            @endphp
            <td class="ean">{{$search_result->ean_no}}</td>
            <td class="actions">
                <!--start manage button area-->
                <div class="btn-group dropup">
                    <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Manage
                    </button>
                    <!--start dropup content-->
                    <div class="dropdown-menu">
                        <div class="dropup-content catalogue-dropup-content">
                            <div class="d-flex justify-content-start">
                                <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{route('product-variation.edit',$search_result->id)}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{url('variation-details/'.Crypt::encrypt($search_result->id))}}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                <div class="align-items-center mr-2" data-toggle="tooltip" data-placement="top" title="Shelf View"><a class="btn-size shelf-btn" href="#" data-toggle="modal" data-target="#myModal{{$search_result->id}}"><i class="fa fa-shopping-basket"></i></a></div>
                                <div class="align-items-center mr-2"><a class="btn-size print-btn" href="{{url('print-barcode/'.$search_result->id)}}" data-toggle="tooltip" data-placement="top" title="Click to print" target="_blank"><i class="fa fa-print"></i></a></div>
                                <div class="align-items-center">
                                    <form action="{{route('product-variation.destroy',$search_result->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="del-pub delete-btn on-default remove-row" style="cursor: pointer" onclick="return check_delete('product');" href="" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i> </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End dropup content-->
                </div>
                <!--End manage button area-->
            </td>

            <!--start modal-->
            <div class="modal fade" id="myModal{{$search_result->id}}">
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
                                <div class="col-md-12">
                                    <div class="p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                                        <div class="border">
                                            <div class="row m-t-10">
                                                <div class="col-md-6 col-sm-6 text-center">
                                                    <h6> Shelf Name </h6>
                                                    <hr width="60%">
                                                </div>
                                                <div class="col-md-6 col-sm-6 text-center">
                                                    <h6>Quantity</h6>
                                                    <hr width="60%">
                                                </div>
                                            </div>
                                            @foreach($search_result->shelf_quantity as $shelf)
                                                @if($shelf->pivot->quantity != 0)
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6 text-center">
                                                            <h7> {{$shelf->shelf_name}} </h7>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 text-center">
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
            </div>
            <!--End modal-->
        </tr>
    @endforeach



<script>

    // table column hide and show toggle checkbox
    $("input:checkbox").click(function(){
        let column = "."+$(this).attr("name");
        $(column).toggle();
    });


    // table column hide and show toggle checkbox
    $("input:checkbox").click(function(){
        let column = "."+$(this).attr("name");
        $(column).toggle();
    });

    //table column by default hide
    $("input:checkbox:not(:checked)").each(function() {
        var column = "table ." + $(this).attr("name");
        $(column).hide();
    });

    //prevent onclick dropdown menu close
    $('.filter-content').on('click', function(event){
        event.stopPropagation();
    });

</script>

