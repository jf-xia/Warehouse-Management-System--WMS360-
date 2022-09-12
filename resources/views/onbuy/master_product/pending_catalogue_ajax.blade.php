@foreach($search_result as $catalogue)
    @if(isset($catalogue->ProductVariations[0]->stock) && $catalogue->ProductVariations[0]->stock > 0)
    <tr>
        <td class="image" style="width: 6%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">

            <!--Start each row loader-->
            <div id="product_variation_loading{{$catalogue->id}}" class="variation_load" style="display: none;"></div>
            <!--End each row loader-->

                @isset($catalogue->single_image_info->image_url)
                <a href="{{$catalogue->single_image_info->image_url}}"  title="Click to expand" target="_blank"><img src="{{$catalogue->single_image_info->image_url}}" class="onbuy-image zoom" alt="catalogue-image"></a>
                @endisset

        </td>
{{--                                        <td class="id" style="width: 7%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">--}}
        <td class="id" style="width: 7%; text-align: center !important;">
            <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$catalogue->id}}</span>
                <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
            </div>
        </td>
        <td class="catalogue-name" style="width: 30%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">
            <a class="catalogue-name" href="{{route('product-draft.show',$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Show Details">
                {!! Str::limit(strip_tags($catalogue->name),$limit = 100, $end = '...') !!}
            </a>
        </td>
        
        <td class="category" style="text-align: center !important; cursor: pointer; width: 10%" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle"> {{$catalogue->WooWmsCategory->category_name ?? ''}} </td>
        <td class="status text-center" style="cursor: pointer; width: 10%" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">{{$catalogue->status ?? ''}}</td>
        <td class="stock text-center" style="cursor: pointer; width: 8%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">{{$catalogue->ProductVariations[0]->stock ?? 0}}</td>
        <td class="product text-center" style="cursor: pointer; width: 8%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">{{$catalogue->product_variations_count ?? 0}}</td>
        <td class="creator" style="cursor: pointer; width: 8%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">
            <div class="wms-name-creator">
                <div data-tip="on {{date('d-m-Y', strtotime($catalogue->created_at))}}">
                    <strong class="text-success">{{$catalogue->user_info->name ?? ''}}</strong>
                </div>
            </div>
        </td>
        <td class="modifier" style="cursor: pointer; width: 8%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">
            @if(isset($catalogue->modifier_info->name))
                <div class="wms-name-modifier1">
                    <div data-tip="on {{date('d-m-Y', strtotime($catalogue->updated_at))}}">
                        <strong class="text-success">{{$catalogue->modifier_info->name ?? ''}}</strong>
                    </div>
                </div>
            @else
                <div class="wms-name-modifier2">
                    <div data-tip="on {{date('d-m-Y', strtotime($catalogue->updated_at))}}">
                        <strong class="text-success">{{$catalogue->user_info->name ?? ''}}</strong>
                    </div>
                </div>
            @endif
        </td>
        <td class="actions" style="width: 6%;">

            <div class="btn-group dropup">
                <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Manage
                </button>
                <div class="dropdown-menu">
                    <div class="dropup-content catalogue-dropup-content">
                        <div class="action-1">
                            <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{route('product-draft.edit',$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                            <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{route('product-draft.show',$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                            @if(!isset($catalogue->onbuy_product_info->id))
                                <div class="align-items-center mr-2"> <a class="list-onbuy-btn btn-size" href="{{url('onbuy/create-product/'.$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List On Onbuy"><i class="fab fa-product-hunt" aria-hidden="true"></i></a></div>
                            @endif
                            <div class="align-items-center"> <a class="btn-size add-terms-catalogue-btn" href="{{url('add-additional-terms-draft/'.$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Add Terms to Catalogue"><i class="fas fa-list"></i></a></div>
                        </div>
                        <div class="action-2">
                            <div class="align-items-center mr-2"><a class="btn-size catalogue-invoice-btn invoice-btn" href="{{url('catalogue-product-invoice-receive/'.$catalogue->id)}}" target="_blank" target="_blank" data-toggle="tooltip" data-placement="top" title="Receive Invoice"><i class='fa fa-book'></i></a></div>
                            <div class="align-items-center mr-2"> <a class="btn-size add-product-btn" href="{{url('catalogue/'.$catalogue->id.'/product')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Add Product"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></div>
                            <div class="align-items-center mr-2"><a class="btn-size duplicate-btn" href="{{url('duplicate-draft-catalogue/'.$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Duplicate"><i class="fa fa-clone" aria-hidden="true"></i></a></div>
                            <div class="align-items-center">
                                <form action="{{route('product-draft.destroy',$catalogue->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="del-pub delete-btn" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('catalogue');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>

    <!--hidden row -->
    <tr>
        <td colspan="13" class="hiddenRow" style="padding: 0; background-color: #ccc">
            <div class="accordian-body collapse" id="demo{{$catalogue->id}}">

            </div> <!-- end accordion body -->
        </td> <!-- hide expand td-->
    </tr> <!-- hide expand row-->

    @endif
@endforeach