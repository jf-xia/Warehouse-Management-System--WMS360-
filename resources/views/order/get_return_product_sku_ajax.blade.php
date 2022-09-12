{{--<select class="form-control" name="product_variation_id" id="product_variation_id">--}}
{{--    <option value="">Select SKU</option>--}}
{{--    @if($id_value != null)--}}
{{--        @foreach($all_return_product_sku->is_return_product_shelved as $product_sku)--}}
{{--            <option value="{{$product_sku->pivot->variation_id}}">{{$product_sku->sku}}</option>--}}
{{--        @endforeach--}}
{{--    @else--}}
{{--        @foreach($all_return_product_sku as $variation_sku)--}}
{{--            <option value="{{$variation_sku->id}}">{{$variation_sku->sku}}</option>--}}
{{--        @endforeach--}}
{{--    @endif--}}
{{--</select>--}}
@if($id_value != null)
<td class="col-2">

    <select class="form-control select2" name="product_variation_id" id="product_variation_id" required>
        <option value="">Select SKU</option>
        @foreach($all_return_product_sku->is_return_product_shelved as $product_sku)
            <option value="{{$product_sku->pivot->variation_id}}">{{$product_sku->sku}}</option>
        @endforeach
    </select>

</td>
<td class="col-2">
    <span id="variation-show">No Variation</span>
</td>
<td class="col-1">
    <input type="number" id="quantity" name='quantity' placeholder='' class="form-control" required disabled>
</td>
<td class="col-1">
    <input type="text" id="price" name='price' placeholder='' class="form-control" required>
</td>
<td class="col-2">
    <select onchange="productType()" class="form-control" name="product_type" required>
        <option value="1">Non Defected</option>
        <option value="0">Defected</option>
    </select>
</td>
<td class="col-2" id="shelver_td">
    <select id="shelver_user_id" class="form-control select2" name="shelver_user_id" required>
        <option value="">Select Shelver</option>
        @foreach($all_shelver->users_list as $shelver)
            <option value="{{$shelver->id}}">{{$shelver->name}}</option>
        @endforeach
    </select>
</td>
<td class="col-2">
    <input type="text" value="0" id="total_price"  name='total_price' placeholder='' class="form-control" required>
</td>
@else
    <td class="col-2">

        <select class="form-control select2" name="product_variation_id" id="product_variation_id" required>
            <option value="">Select SKU</option>
            @foreach($all_return_product_sku as $variation_sku)
                <option value="{{$variation_sku->id}}">{{$variation_sku->sku}}</option>
            @endforeach
        </select>

    </td>
    <td class="col-2">
        <input type="number" id="quantity" name='quantity' placeholder='' class="form-control" required disabled>
    </td>
    <td class="col-2">
        <input type="text" id="price" name='price' placeholder='' class="form-control" required>
    </td>
    <td class="col-2">
        <select onchange="productType()" class="form-control" name="product_type" required>
            <option value="1">Non Defected</option>
            <option value="0">Defected</option>
        </select>
    </td>
    <td class="col-2" id="shelver_td">
        <select id="shelver_user_id" class="form-control select2" name="shelver_user_id" required>
            <option value="">Select Shelver</option>
            @foreach($all_shelver->users_list as $shelver)
                <option value="{{$shelver->id}}">{{$shelver->name}}</option>
            @endforeach
        </select>
    </td>
    <td class="col-2">
        <input type="text" value="0" id="total_price"  name='total_price' placeholder='' class="form-control" required>
    </td>
    @endif
