<tr id='addr0' data-id="0" class="hidden">
    <td data-name="sel">


        <select class="form-control" name="data[{{$index}}][product_variation_id]">

            <option value="">Select SKU</option>
            @foreach($product_variations as $product_variation)
                <option value="{{$product_variation->id}}">{{$product_variation->sku}}</option>
            @endforeach
        </select>
    </td>
    <td data-name="quantity">
        <input type="number" name='data[1][quantity]' placeholder='' class="form-control" >
    </td>
    <td data-name="price">
        <input type="text" name='data[1][price]' placeholder='' class="form-control">
    </td>
    <td data-name="sel">
        <select class="form-control" name="data[1][product_type]">
            <option value="1">Non Defected</option>
            <option value="0">Defected</option>
        </select>
    </td>
    <td data-name="sel">

        <select class="form-control" name="data[{{$index}}][shelver_user_id]">

            <option value="1">Shelvin</option>
            <option value="2">Shelvin2</option>
        </select>
    </td>
    <td data-name="total">

        <input type="text" name='data[{{$index}}][price]' placeholder='' class="form-control">

    </td>
</tr>
