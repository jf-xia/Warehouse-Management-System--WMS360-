
@isset($search_reshelved_product)
    @foreach($search_reshelved_product as $reshelved_product)
        <tr>
            <td class="text-center">{{$reshelved_product->shelf_info->shelf_name ?? ''}}</td>
            <td class="text-center">{{$reshelved_product->variation_info->sku ?? null}}</td>
            <td class="text-center">{{$reshelved_product->quantity}}</td>
            <td class="text-center">{{$reshelved_product->user_info->name ?? ''}}</td>
            @if($reshelved_product->status == 1)
                <td class="text-center"><span class="label label-table label-success label-status">Shelved</span></td>
            @else
                <td class="text-center"><span class="label label-table label-danger label-status">Not Shelved</span></td>
            @endif
        </tr>
    @endforeach
@endisset
