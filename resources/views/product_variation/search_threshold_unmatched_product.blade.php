@isset($shelve_qnty_larger_than_available)
    @foreach($shelve_qnty_larger_than_available as $product_variation)
        <tr>
            <td>
                <a href="{{$product_variation['image'] ?? $product_variation['master_image']}}" target="_blank">
                    <img src="{{$product_variation['image'] ?? $product_variation['master_image']}}" height="50" width="50">
                </a>
            </td>
            <td>{{$product_variation['id']}}</td>
            <td>{{$product_variation['sku']}}</td>
            <td>{{$product_variation['actual_quantity']}}</td>
            <td>{{$product_variation['shelf_quantity']}}</td>
            <td><a href="{{asset('product-draft/'.$product_variation['master_catalogue_id'])}}" target="_blank">{{$product_variation['name']}}</a></td>
        </tr>
    @endforeach
@endisset
