

@foreach($search_result as $product_list)
    <tr>
        <td class="text-center">
            @if($product_list->status == 'success')
                <input type="checkbox" class="checkBoxClass" value="{{$product_list->id}}">
            @endif
        </td>
        <td class="image" style="cursor: pointer; text-align: center !important; width: 6% !important;" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">

            <!--Start each row loader-->
            <div id="product_variation_loading{{$product_list->id}}" class="variation_load" style="display: none;"></div>
            <!--End each row loader-->

            @if(isset($product_list->default_image))
                <a href="{{$product_list->default_image}}"  title="Click to expand" target="_blank"><img src="{{$product_list->default_image}}" class="onbuy-image zoom" alt="master-image"></a>
            @else
                <img src="{{asset('assets/common-assets/no_image.jpg')}}" class="onbuy-image zoom" alt="master-image">
            @endif

        </td>

{{--                                        <td class="opc" style="text-align: center !important; width: 10%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">--}}
        <td class="opc" style="text-align: center !important; width: 10%;">
            <span id="master_opc_{{$product_list->queue_id}}">
                <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                    <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_list->opc}}</span>
                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                </div>
            </span>
        </td>

        <td class="catalogue-id text-center" style="width: 12%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
            <span id="master_opc_{{$product_list->queue_id}}">
                <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                    <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_list->woo_catalogue_id}}</span>
                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                </div>
            </span>
        </td>
        <td class="title" style="cursor: pointer; width: 26%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
            <a class="catalogue-name" href="https://seller.onbuy.com/inventory/edit-product-basic-details/{{$product_list->product_id}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Show Details">
                {!! Str::limit(strip_tags($product_list->product_name),$limit = 100, $end = '...') !!}
            </a>
        </td>
        <td class="category" style="cursor: pointer; width: 14%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">{{$product_list->category_info->name}}(<small>{{$product_list->category_info->category_tree}}</small>)</td>
        <td class="master_base_price" style="cursor: pointer; width: 14%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">{{$product_list->base_price ?? ''}}</td>
        <td class="product text-center" style="cursor: pointer; width: 10%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">{{$product_list->variation_product_count}}</td>
        <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle"><span class="label label-status label-@if($product_list->status == 'success')success @elseif($product_list->status == 'pending')warning @elseif($product_list->status == 'failed')danger @endif">{{$product_list->status}}</span></td>
{{--                                        <td class="queue-id" style="width: 10%">--}}
{{--                                            <div class="d-block">--}}
{{--                                                <div data-tip="{{$product_list->queue_id}}">--}}
{{--                                                    <button type="button" style="cursor: pointer" class="btn btn-success btn-sm" onclick="check_queue_id('{{$product_list->queue_id}}')">Check Status</button>--}}
{{--                                                </div>--}}
{{--                                                <div>--}}
{{--                                                    <span id="status_show_{{$product_list->queue_id}}" class="label label-default label-status"></span><br>--}}
{{--                                                    <span id="error_show_{{$product_list->queue_id}}" class="label label-danger label-status"></span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}
        <td class="queue-id" style="width: 10%;">
            <div class="d-block">
                <div data-tip="{{$product_list->queue_id}}">
                    <button type="button" style="cursor: pointer" class="btn btn-success btn-sm" onclick="check_queue_id('{{$product_list->queue_id}}')">Check Status</button>
                </div>
                <div>
                    <span id="status_show_{{$product_list->queue_id}}" class="label label-default label-status"></span>
                    <span id="error_show_{{$product_list->queue_id}}" class="label label-danger label-status"></span>
                </div>
            </div>
        </td>
        <td class="actions" style="width: 6%">
            <!--start manage button area-->
            <div class="btn-group dropup">
                <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Manage
                </button>
                <!--start dropup content-->
                <div class="dropdown-menu">
                    <div class="dropup-content onbuy-dropup-content">
                        <div class="action-1">
                            <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{url('onbuy/edit-master-product/'.$product_list->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                            <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{url('onbuy/master-product-details/'.$product_list->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                            <div class="align-items-center"> <a class="btn-size delete-btn" href="{{url('onbuy/delete-listing/'.$product_list->id)}}" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('Master Product');"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
                        </div>
                    </div>
                </div>
                <!--End dropup content-->
            </div>
            <!--End manage button area-->

        </td>
    </tr>



    <!--hidden row -->
    <tr>
        <td colspan="13" class="hiddenRow" style="padding: 0; background-color: #ccc">
            <div class="accordian-body collapse" id="demo{{$product_list->id}}">

            </div> <!-- end accordion body -->
        </td> <!-- hide expand td-->
    </tr> <!-- hide expand row-->

    
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
    $(document).ready(function (){
        $(".checkBoxClass").change(function(){
            if (!$(this).prop("checked")){
                $("#selectAllCheckbox").prop("checked",false);
            }
            var catalogueIds = catalogueIdArray();
        });
    });

</script>








