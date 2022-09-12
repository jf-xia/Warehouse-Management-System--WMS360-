@if($status == 'draft' || $status == 'publish')
    @if(isset($search_result))
        @foreach($search_result as $search_result_single)
            @if(is_numeric($date) == TRUE)
                <tr class="variation_load_tr">
                {{--                                <td style="width: 6%; text-align: center !important;">--}}
                {{--                                    <input type="checkbox" class="checkBoxClass" id="checkItem{{$index}}" name="masterProduct[{{$index}}]" value="{{$product_list->id}}">--}}
                {{--                                </td>--}}
                <td class="image" style="cursor: pointer; width: 6% !important;" data-toggle="collapse" id="mtr-{{$search_result_single->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result_single->id}}" class="accordion-toggle">
                    <!--Start each row loader-->
                    <div id="product_variation_loading{{$search_result_single->id}}" class="variation_load" style="display: none;"></div>
                    <!--End each row loader-->

                    @if(isset( \Opis\Closure\unserialize($search_result_single->image)[0]['src']))
                        <a href=""  title="Click to expand" target="_blank"><img src="{{\Opis\Closure\unserialize($search_result_single->image)[0]['src']}}" class="ebay-image zoom" alt="ebay-master-image"></a>
                    @else
                        <img src="{{asset('assets/common-assets/no_image.jpg')}}" class="ebay-image zoom" alt="ebay-master-image">
                    @endif

                </td>
                <td class="item-id" style="width: 8%">
                        <span id="master_opc_{{$search_result_single->id}}">
                                <div class="id_tooltip_container d-flex justify-content-start align-items-center">
                                <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$search_result_single->id}}</span>
                                <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                </div>
                        </span>
                </td>
                <td class="item-id" style="width: 20%">
                    <span id="master_opc_{{$search_result_single->product_type}}">
                         <div class="id_tooltip_container d-flex justify-content-start align-items-center">
                            <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">
                                @php
                                  $collection_list = \Opis\Closure\unserialize($search_result_single->product_type);
                                    $collection_list = is_array($collection_list) ? $collection_list : array($collection_list);
                                @endphp
                                @foreach($collection_list as $single_collection)
                                    @if(!empty($single_collection))
                                        @php
                                            $collections = explode('/', $single_collection);
                                            $collection_name = \App\shopify\ShopifyCollection::where('shopify_collection_id',$collections[1])->first();
                                        @endphp
                                        @isset($collection_name->category_name)
                                        {{$collection_name->category_name}},
                                        @endisset
                                    @endif
                                @endforeach
                            </span>
                            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                         </div>
                    </span>
                </td>
                {{--                                <td class="product-type">--}}
                {{--                                    <div style="text-align: center;">--}}
                {{--                                        @if($product_list->type == 'simple')--}}
                {{--                                            Simple--}}
                {{--                                        @else--}}
                {{--                                            Variation--}}
                {{--                                        @endif--}}
                {{--                                    </div>--}}
                {{--                                </td>--}}
                {{--                                        <td class="catalogue-id" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">--}}
                <td class="catalogue-id" style="width: 8%; text-align: center !important;">
                    <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                        <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$search_result_single->master_catalogue_id}}</span>
                        <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                    </div>
                </td>
                <td class="account" style="cursor: pointer; text-align: center !important; width: 8%" data-toggle="collapse" id="mtr-{{$search_result_single->account_id}}" onclick="getVariation(this)" data-target="#demo{{$search_result_single->account_id}}" class="accordion-toggle">
                    @isset(\App\shopify\ShopifyAccount::find($search_result_single->account_id)->account_name)
                        {{\App\shopify\ShopifyAccount::find($search_result_single->account_id)->account_name}}
                    @endisset
                </td>
                <td class="product-name" style="cursor: pointer; width: 20%" data-toggle="collapse" id="mtr-{{$search_result_single->id}}" data-target="#demo{{$search_result_single->id}}" onclick="getVariation(this)" class="accordion-toggle" data-toggle="tooltip" data-placement="top" title="{{$search_result_single->title}}">
                    <a class="ebay-product-name" href="" target="_blank">
                        {!! Str::limit(strip_tags($search_result_single->title),$limit = 45, $end = '...') !!}
                    </a>
                </td>
                @php
                    $total_quantity = 0;
                    foreach ($search_result_single->variationProducts as $variation){
                        $total_quantity += $variation->stock;
                    }
                    $creatorInfo = \App\User::withTrashed()->find($search_result_single->creator_id);
                    $modifierInfo = \App\User::withTrashed()->find($search_result_single->modifier_id);
                @endphp
                <td class="stock" style="cursor: pointer; text-align: center !important; width: 5%" data-toggle="collapse" data-target="#demo{{$search_result_single->id}}" id="mtr-{{$search_result_single->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$total_quantity}}
                </td>
                <td class="status" style="cursor: pointer; width: 8%" data-toggle="collapse" id="mtr-{{$search_result_single->id}}" data-target="#demo{{$search_result_single->id}}" onclick="getVariation(this)" class="accordion-toggle" data-toggle="tooltip" data-placement="top">
                    {{$search_result_single->status}}
                </td>
                {{--                                <td class="category" style="cursor: pointer; width: 20%" data-toggle="collapse" data-target="#demo{{$product_list->id}}" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$product_list->category_name}}</td>--}}
                {{--                                <td class="stock" style="cursor: pointer; text-align: center !important; width: 5%" data-toggle="collapse" data-target="#demo{{$product_list->id}}" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$total_quantity}}</td>--}}

                {{--                                <td class="status" style="cursor: pointer; text-align: center !important; width: 8%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">--}}
                {{--                                    @if($product_list->product_status == "Active")--}}
                {{--                                        Active--}}
                {{--                                    @elseif($product_list->product_status == "Completed")--}}
                {{--                                        @php--}}
                {{--                                            $total_quantity = 0;--}}
                {{--                                            foreach ($product_list->variationProducts as $variation){--}}
                {{--                                                $total_quantity += $variation->quantity;--}}
                {{--                                            }--}}
                {{--                                            if ($total_quantity == 0){--}}
                {{--                                                echo "Sold Out";--}}
                {{--                                            }elseif ($total_quantity > 0){--}}
                {{--                                                echo "Ended";--}}
                {{--                                            }--}}
                {{--                                        @endphp--}}

                {{--                                    @endif--}}
                {{--                                </td>--}}


                <td class="creator" style="cursor: pointer; text-align: center !important; width: 8%" data-toggle="collapse" id="mtr-{{$search_result_single->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result_single->id}}" class="accordion-toggle">
                    @if(isset($creatorInfo->name))
                    <div class="wms-name-creator">
                        <div data-tip="on {{date('d-m-Y', strtotime($search_result_single->created_at))}}">
                            <strong class="@if($creatorInfo->deleted_at) text-danger @else text-success @endif">{{$creatorInfo->name ?? ''}}</strong>
                        </div>
                    </div>
                    @endif
                </td>
                <td class="modifier" style="cursor: pointer; text-align: center !important; width: 8%" data-toggle="collapse" id="mtr-{{$search_result_single->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result_single->id}}" class="accordion-toggle">
                    @if(isset($modifierInfo->name))
                        <div class="wms-name-modifier1">
                            <div data-tip="on {{date('d-m-Y', strtotime($search_result_single->updated_at))}}">
                                <strong class="@if($modifierInfo->deleted_at) text-danger @else text-success @endif">{{$modifierInfo->name ?? ''}}</strong>
                            </div>
                        </div>
                    @elseif(isset($creatorInfo->name))
                        <div class="wms-name-modifier2">
                            <div data-tip="on {{date('d-m-Y', strtotime($search_result_single->created_at))}}">
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
                            <div class="dropup-content ebay-dropup-content" style="padding: 14px 20px 8px 20px !important;">
                                <div class="action-1">
                                    {{--                                                    @if($product_list->product_status == 'Completed' && $total_quantity !=0)--}}
                                    {{--                                                        <div class="align-items-center mr-2"><a class="btn-size btn-dark" style="cursor: pointer" href="{{url('relist-end-listing/'.$product_list->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Relist"><i class="fa fa-registered" aria-hidden="true"></i></a></div>--}}
                                    {{--                                                    @endif--}}
                                    <div class="align-items-center mr-2"><a class="btn-size edit-btn" style="cursor: pointer" href="{{url('shopify/catalogue/'.$search_result_single->id.'/edit')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                    <div class="align-items-center mr-2"><a class="btn-size view-btn" style="cursor: pointer" href="{{url('shopify/show/'.$search_result_single->id).'/view'}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                    <div class="align-items-center"> <a class="btn-size delete-btn" href="{{url('shopify/product-delete/'.$search_result_single->id)}}" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('Master Product');"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
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
                    <div class="accordian-body collapse" id="demo{{$search_result_single->id}}">

                    </div> <!-- end accordion body -->
                </td> <!-- hide expand td-->
            </tr> <!-- hide expand row-->
           @endif
        @endforeach
    @endif
@endif
