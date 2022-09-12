@foreach($search_result as $catalogue)
    @if(isset($catalogue->ProductVariations[0]->stock) && $catalogue->ProductVariations[0]->stock > 0)
    <tr>
        <td class="image" style="width: 6%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">
            <!--Start each row loader-->
            <div id="product_variation_loading{{$catalogue->id}}" class="variation_load" style="display: none;"></div>
            <!--End each row loader-->
            @isset($catalogue->single_image_info->image_url)
            <a href="{{$catalogue->single_image_info->image_url}}"  title="Click to expand" target="_blank"><img src="{{$catalogue->single_image_info->image_url}}" class="amazon-image zoom" alt="catalogue-image"></a>
            @endisset
        </td>
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
            <a href="{{url('amazon/create-amazon-product/'.$catalogue->id)}}" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="List On Amazon" target="_blank">
                <i class="fa fa-amazon"></i>
            </a>
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