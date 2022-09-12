
@foreach($search_result as $index => $product_list)
    <tr>
        <td style="width: 6%; text-align: center !important;">

            {{--                                                    <input type="checkbox" class="checkBoxClass" id="customCheck{{$pending->id}}" name="multiple_order[]" value="{{$pending->id}}">--}}
            <input type="checkbox" class="checkBoxClass" id="checkItem{{$index}}" name="masterProduct[{{$index}}]" value="{{$product_list->id}}">

        </td>
        <td class="image" style="cursor: pointer; width: 6%;" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">

            <!--Start each row loader-->
            <div id="product_variation_loading{{$product_list->id}}" class="variation_load" style="display: none;"></div>
            <!--End each row loader-->

            @if(isset( \Opis\Closure\unserialize($product_list->master_images)[0]))
                <a href="{{\Opis\Closure\unserialize($product_list->master_images)[0]}}"  title="Click to expand" target="_blank"><img src="{{\Opis\Closure\unserialize($product_list->master_images)[0]}}" class="ebay-image zoom" alt="ebay-master-image"></a>
            @else
                <img src="{{asset('assets/images/users/no_image.jpg')}}" class="ebay-image zoom" alt="ebay-master-image">
            @endif

        </td>
{{--        <td class="item-id" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">--}}
        <td class="item-id" style="text-align: center !important; width: 8%">
            <span id="master_opc_{{$product_list->item_id}}">
                 <div class="id_tooltip_container d-flex justify-content-start align-items-center">
                    <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_list->item_id}}</span>
                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                </div>
            </span>
        </td>
        <td class="product-type">
            <div style="text-align: center;">
                @if($product_list->type == 'simple')
                    Simple
                @else
                    Variation
                @endif
            </div>
        </td>
{{--        <td class="catalogue-id" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">--}}
        <td class="catalogue-id" style="width: 8%; text-align: center !important;">
            <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_list->master_product_id}}</span>
                <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
            </div>
        </td>
        <td class="account" style="cursor: pointer; text-align: center !important; width: 8%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
            @isset(\App\EbayAccount::find($product_list->account_id)->account_name)
                {{\App\EbayAccount::find($product_list->account_id)->account_name}}
            @endisset
        </td>
        <td class="product-name" style="cursor: pointer; width: 20%" data-toggle="collapse" id="mtr-{{$product_list->id}}" data-target="#demo{{$product_list->id}}" onclick="getVariation(this)" class="accordion-toggle" data-toggle="tooltip" data-placement="top" title="Show Details">
            <a class="ebay-product-name" href="https://www.ebay.co.uk/itm/{{$product_list->item_id}}" target="_blank">
                {!! Str::limit(strip_tags($product_list->title),$limit = 100, $end = '...') !!}
            </a>
        </td>
        <td class="category" style="cursor: pointer; width: 20%;" data-toggle="collapse" data-target="#demo{{$product_list->id}}" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$product_list->category_name}}</td>
        @php
            $total_quantity = 0;
            foreach ($product_list->variationProducts as $variation){
                $total_quantity += $variation->quantity;
            }
        @endphp
        <td class="stock" style="cursor: pointer; text-align: center !important; width: 5%" data-toggle="collapse" data-target="#demo{{$product_list->id}}" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$total_quantity}}</td>
        <td class="profile" style="cursor: pointer; text-align: center !important; width: 8%" data-toggle="collapse" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
            @isset(\App\EbayProfile::find($product_list->profile_id)->profile_name)
                {{\App\EbayProfile::find($product_list->profile_id)->profile_name}}
            @endisset
        </td>
        {{-- <td class="status" style="cursor: pointer; text-align: center !important; width: 8%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
            @if($product_list->product_status == "Active")
                Active
            @elseif($product_list->product_status == "Completed")
                @php
                    $total_quantity = 0;
                    foreach ($product_list->variationProducts as $variation){
                        $total_quantity += $variation->quantity;
                    }
                    if ($total_quantity == 0){
                        echo "Sold Out";
                    }elseif ($total_quantity > 0){
                        echo "Ended";
                    }
                @endphp

            @endif
        </td> --}}
        <td class="promoted-listings" style="cursor: pointer; text-align: center !important; width: 8%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
            <?php

            $campaign_array = \Opis\Closure\unserialize($product_list->campaign_data) ?? '';
            $creatorInfo = \App\User::withTrashed()->find($product_list->creator_id);
            $modifierInfo = \App\User::withTrashed()->find($product_list->modifier_id);
            ?>
            @if(isset($campaign_array['bidPercentage']) && isset($campaign_array['suggestedRate']))
                Promoted
            @elseif(isset($campaign_array['suggestedRate']))
                Eligible to promote
            @endif
            @if(isset($campaign_array['bidPercentage']))
                Your ad rate {{$campaign_array['bidPercentage']}}%
            @endif
            @if(isset($campaign_array['suggestedRate']))
                Suggested ad rate {{$campaign_array['suggestedRate']}}%
            @endif

        </td>
        <td class="creator" style="cursor: pointer; text-align: center !important; width: 8%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
            @if(isset($creatorInfo->name))
            <div class="wms-name-creator">
                <div data-tip="on {{date('d-m-Y', strtotime($product_list->created_at))}}">
                    <strong class="@if($creatorInfo->deleted_at) text-danger @else text-success @endif">{{$creatorInfo->name ?? ''}}</strong>
                </div>
            </div>
            @endif
        </td>
        <td class="modifier" style="cursor: pointer; text-align: center !important; width: 8%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
            @if(isset($modifierInfo->name))
                <div class="wms-name-modifier1">
                    <div data-tip="on {{date('d-m-Y', strtotime($product_list->updated_at))}}">
                        <strong class="@if($modifierInfo->deleted_at) text-danger @else text-success @endif">{{$modifierInfo->name ?? ''}}</strong>
                    </div>
                </div>
            @elseif(isset($creatorInfo->name))
                <div class="wms-name-modifier2">
                    <div data-tip="on {{date('d-m-Y', strtotime($product_list->created_at))}}">
                        <strong class="@if($creatorInfo->deleted_at) text-danger @else text-success @endif">{{$creatorInfo->name ?? ''}}</strong>
                    </div>
                </div>
            @endif
        </td>
        <td class="actions" style="width: 6%">
            <!--start manage button area-->
            <div class="btn-group dropup">
                <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Manage
                </button>
                <!--start dropup content-->
                <div class="dropdown-menu">
                    <div class="dropup-content ebay-dropup-content">
                        <div class="action-1">
                            @if($product_list->product_status == 'Completed')
                                @if(!isset($defaultEditAdd))
                                <div class="align-items-center mr-2"><a class="btn-size btn-dark" style="cursor: pointer" href="{{url('relist-end-listing/'.$product_list->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Relist"><i class="fa fa-registered" aria-hidden="true"></i></a></div>
                                @endif
                            @endif
                            @if(isset($defaultEditAdd))
                                <div class="align-items-center mr-2"><a class="btn-size edit-btn" style="cursor: pointer" href="{{url('create-ebay-product/'.$product_list->master_product_id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit & Relist"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                            @else
                                <div class="align-items-center mr-2"><a class="btn-size edit-btn" style="cursor: pointer" href="{{url('ebay-master-product/'.$product_list->id.'/edit')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                            @endif
                            @if(!isset($defaultEditAdd))
                            <div class="align-items-center mr-2"><a class="btn-size view-btn" style="cursor: pointer" href="{{url('ebay-master-product/'.$product_list->id).'/view'}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                            @endif
                                <div class="align-items-center mr-2">
                                    <form action="{{url('ebay-ended-product-check/page')}}" method="POST" >
                                        @csrf
                                        <input type="hidden" name="products[]" value="{{$product_list->id}}">
                                        @if(!isset($defaultEditAdd))
                                        <button type="submit" class="btn-size btn-dark check-status-btn" style="cursor: pointer" target="_blank" data-toggle="tooltip" data-placement="top" title="Check Status"><i class="fa fa-hourglass-end" aria-hidden="true"></i></button>
                                        @endif
                                    </form>
                                </div>
                            <div class="align-items-center"> <a class="btn-size delete-btn" href="{{url('ebay-delete-listing/'.$product_list->id.'/'.$product_list->item_id)}}" data-toggle="tooltip" data-placement="top" title="End Product" onclick="return check_delete('Master Product');"><i class="fas fa-gavel" aria-hidden="true"></i></a></div>
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
        <td colspan="15" class="hiddenRow" style="padding: 0; background-color: #ccc">

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



</script>
