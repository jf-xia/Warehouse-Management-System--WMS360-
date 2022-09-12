@foreach($master_product_list as $index => $product_list)
    <tr>
        <td style="width: 6%; text-align: center !important;">

                {{--                                                    <input type="checkbox" class="checkBoxClass" id="customCheck{{$pending->id}}" name="multiple_order[]" value="{{$pending->id}}">--}}
            <input type="checkbox" class="checkBoxClass" id="checkItem{{$index}}" name="masterProduct[{{$index}}]" value="{{$product_list->id}}">

        </td>
        <td class="image" style="text-align: center !important;">
            @if(isset( \Opis\Closure\unserialize($product_list->master_images)[0]))
                <a href=""  title="Click to expand" target="_blank"><img src="{{\Opis\Closure\unserialize($product_list->master_images)[0]}}" class="ebay-image" alt="revise-image"></a>
            @else
                <img src="{{asset('assets/common-assets/no_image.jpg')}}" class="ebay-image" alt="revise-image">
            @endif
        </td>
        <td class="item-id" style="text-align: center !important;"><span id="master_opc_{{$product_list->item_id}}">{{$product_list->item_id}}</span></td>
        <td class="catalogue-id" style="text-align: center !important;">
            <div class="id_tooltip_container d-flex justify-content-center align-items-start">
                <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_list->master_product_id}}</span>
                <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
            </div>
        </td>
        <td class="product-name">
            <a class="ebay-product-name" class="ebay-product-name" href="https://www.ebay.co.uk/itm/{{$product_list->item_id}}" target="_blank">
                {!! Str::limit(strip_tags($product_list->title),$limit = 100, $end = '...') !!}
            </a>
        </td>
        <td class="category" style="text-align: center !important;">{{$product_list->master_product_id}}</td>
        <td class="profile" style="text-align: center !important;">
            @isset(\App\EbayProfile::find($product_list->profile_id)->profile_name)
                {{\App\EbayProfile::find($product_list->profile_id)->profile_name}}
            @endisset
        </td>
        <td class="account" style="text-align: center !important;">
            @isset(\App\EbayAccount::find($product_list->account_id)->account_name)
                {{\App\EbayAccount::find($product_list->account_id)->account_name}}
            @endisset
        </td>
        <td class="revise-status" style="text-align: center !important;">
            @if($product_list->profile_status == 0)
                <div class="align-items-center mr-2"><a class="btn-size btn-danger" style="cursor: pointer"  target="_blank" data-toggle="tooltip" data-placement="top" title="Profile changed"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></a></div>
            @else
                <div class="align-items-center mr-2"><a class="btn-size btn-success" style="cursor: pointer" href="" target="_blank" data-toggle="tooltip" data-placement="top" title="No Changes"><i class="fa fa-check" aria-hidden="true"></i></a></div>
            @endif
        </td>
        <td>
            <div class="btn-group dropup">
                <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Manage
                </button>
                <div class="dropdown-menu">
                    <div class="ebay-dropup-content">
                        <div class="d-flex justify-content-start align-items-center">
                            <div class="align-items-center mr-2"><a class="btn-size edit-btn" style="cursor: pointer" href="{{url('ebay-master-product/'.$product_list->id.'/edit')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                            <div class="align-items-center mr-2"><a class="btn-size view-btn" style="cursor: pointer" href="{{url('ebay-master-product/'.$product_list->id).'/view'}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                            <div class="align-items-center"> <a class="btn-size delete-btn" href="{{url('ebay-delete-listing/'.$product_list->id.'/'.$product_list->item_id)}}" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('Master Product');"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
@endforeach