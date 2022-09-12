<div class="row m-t-10">
    <div class="col-md-2">
        <label>Features </label>
    </div>
    <div class="col-md-10">
        <div class="card">
            <div class="row px-2 py-3">
                @isset($category_data->results)
                    @foreach($category_data->results as $data)
                        <div class="col-md-4">
                            <div class="btn btn-primary w-100">{{$data->name}}</div>
                            <select class="form-control" name="m_feature[]">
                                @isset($data->options)
                                    @if(count($data->options) == 1)
                                        @foreach($data->options as $option)
                                            <option value="{{$option->option_id}}/{{$data->name}}/{{$option->name}}">{{$option->name}}</option>
                                        @endforeach
                                    @else
                                        <option hidden>Select Option</option>
                                        @foreach($data->options as $option)
                                            <option value="{{$option->option_id}}/{{$data->name}}/{{$option->name}}">{{$option->name}}</option>
                                        @endforeach
                                    @endif
                                @endisset
                            </select>
                        </div>
                    @endforeach
                @endisset
                {{--                <div class="col-md-2">--}}
                {{--                    <label>Custom Name</label>--}}
                {{--                </div>--}}
                {{--                <div class="col-md-4 m-t-5">--}}
                {{--                    <input type="text" class="form-control" name="m_custom_feature">--}}
                {{--                </div>--}}

            </div>
        </div>
    </div>
</div>
<div class="row m-t-10">
    <div class="col-md-2">
        <label class="required">Technical Details </label>
    </div>
    <div class="col-md-10">
        <div class="card">
            <div class="row px-2 py-3">
                @isset($technical_data->results)
                    @foreach($technical_data->results as $data)
                        <div class="col-md-12">
                            <h5>{{$data->group_name}}</h5><span>(Write your value after the already inserted id and don't give '/' slash in your input value)</span><br>
                        </div>
                        @isset($data->options)
                            @foreach($data->options as $option)
                                <div class="col-md-6 m-t-15">
                                    <button class="btn btn-primary w-100">{{$option->name}}</button>
                                    <input type="text" class="form-control" name="m_tectnical_details[]" value="{{$option->detail_id}}/">
                                </div>
                            @endforeach
                        @endisset
                    @endforeach
                @endisset
            </div>
        </div>
    </div>
</div>
{{--<div class="row m-t-10">--}}
{{--    <div class="col-md-2">--}}
{{--        <label class="required">Parent Attribute (Maximum : 2) </label>--}}
{{--    </div>--}}
{{--    <div class="col-md-10">--}}
{{--        <div class="card">--}}
{{--            <div class="row px-2 py-3">--}}
{{--                @isset($category_data->results)--}}
{{--                    @foreach($category_data->results as $data)--}}
{{--                    <div class="col-md-4">--}}
{{--    --}}{{--                    <label>Variant 1</label>--}}
{{--                            <select class="form-control parent_attribute" name="m_variant[]" id="parent_attr_{{$data->feature_id}}">--}}
{{--                                <option value="">Select Attribute</option>--}}
{{--                                <option value="{{$data->feature_id}}/{{$data->name}}">{{$data->name}}</option>--}}
{{--                            </select>--}}
{{--    --}}{{--                    <input type="text" class="form-control" name="m_variant[]">--}}
{{--                    </div>--}}
{{--                    @endforeach--}}
{{--                @endisset--}}
{{--                    <div class="col-md-2">--}}
{{--                        <label>Custom Name</label>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-4 m-t-5">--}}
{{--                        <input type="text" class="form-control" name="m_custom_variant">--}}
{{--                    </div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<div class="row m-t-10">--}}
{{--    <div class="col-md-2">--}}
{{--        <label class="required">Variants </label>--}}
{{--    </div>--}}
{{--    <div class="col-md-10">--}}
{{--        <div class="card">--}}
{{--            <div class="row px-2 py-2">--}}
{{--                <div class="col-md-12 append_listing">--}}
{{--                    <label>Multiple Variant (Choose variant according to parent attribute)</label>--}}
{{--                    <div class="card m-t-10 card_container" id="card_container_0">--}}
{{--                        @isset($category_data->results)--}}
{{--                            @foreach($category_data->results as $data)--}}
{{--                                <div class="row px-1 py-2">--}}
{{--                                    <div class="col-md-2">--}}
{{--                                        <label>{{$data->name}}</label>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-10">--}}
{{--                                        <select class="form-control child_attr_{{$data->feature_id}}" name="product_variant_option[0][]" id="product_variant_option_0" disabled>--}}
{{--                                            <option value="">Select Option</option>--}}
{{--                                            @foreach($data->options as $option)--}}
{{--                                                <option value="{{$option->option_id}}/{{$option->name}}">{{$option->name}}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        @endisset--}}
{{--                            <div class="row px-1 py-2">--}}
{{--                                <div class="col-md-2">--}}
{{--                                    <label>Custom Name</label>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-10">--}}
{{--                                    <input type="text" class="form-control" name="custom_variant[]">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        <div class="row px-1 py-2">--}}
{{--                            <div class="col-md-2">--}}
{{--                                <label class="required">Product Code</label>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-10">--}}
{{--                                <input type="text" class="form-control" name="product_codes[]" required>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row px-1 py-2">--}}
{{--                            <div class="col-md-2">--}}
{{--                                <label class="required">SKU</label>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-10">--}}
{{--                                <input type="text" class="form-control" name="sku[]" id="sku" required>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row px-1 py-2">--}}
{{--                            <div class="col-md-2">--}}
{{--                                <label>Group SKU</label>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-10">--}}
{{--                                <input type="text" class="form-control" name="gro_sku[]" id="grp_sku">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        --}}{{--                                        <div class="row m-t-10">--}}
{{--                        --}}{{--                                            <div class="col-md-2">--}}
{{--                        --}}{{--                                                <label>Price</label>--}}
{{--                        --}}{{--                                            </div>--}}
{{--                        --}}{{--                                            <div class="col-md-10">--}}
{{--                        --}}{{--                                                <input type="text" class="form-control" name="price[]" id="price">--}}
{{--                        --}}{{--                                            </div>--}}
{{--                        --}}{{--                                        </div>--}}
{{--                        <div class="row px-1 py-2">--}}
{{--                            <div class="col-md-2">--}}
{{--                                <label>Stock</label>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-10">--}}
{{--                                <input type="text" class="form-control" name="stock[]" id="stock">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row px-1 py-2">--}}
{{--                            <div class="col-md-2">--}}
{{--                                <label>Handling Time</label>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-10">--}}
{{--                                <input type="text" class="form-control" name="h_time[]" id="h_time">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            --}}{{--                                                        <div class="row px-2 py-2">--}}
{{--            --}}{{--                                                            <div class="col-md-12">--}}
{{--            --}}{{--                                                                <label>Variant 2</label>--}}
{{--            --}}{{--                                                                <div class="card">--}}
{{--            --}}{{--                                                                    <div class="row px-1 py-2">--}}
{{--            --}}{{--                                                                        <div class="col-md-2">--}}
{{--            --}}{{--                                                                            <label>Product Variant Option</label>--}}
{{--            --}}{{--                                                                        </div>--}}
{{--            --}}{{--                                                                        <div class="col-md-10">--}}
{{--            --}}{{--                                                                            <input type="text" class="form-control" name="product_variant_option[]">--}}
{{--            --}}{{--                                                                        </div>--}}
{{--            --}}{{--                                                                    </div>--}}
{{--            --}}{{--                                                                    <div class="row px-1 py-2">--}}
{{--            --}}{{--                                                                        <div class="col-md-2">--}}
{{--            --}}{{--                                                                            <label>Product Code</label>--}}
{{--            --}}{{--                                                                        </div>--}}
{{--            --}}{{--                                                                        <div class="col-md-10">--}}
{{--            --}}{{--                                                                            <input type="text" class="form-control" name="product_codes[]">--}}
{{--            --}}{{--                                                                        </div>--}}
{{--            --}}{{--                                                                    </div>--}}
{{--            --}}{{--                                                                    <div class="row px-1 py-2">--}}
{{--            --}}{{--                                                                        <div class="col-md-2">--}}
{{--            --}}{{--                                                                            <label>SKU</label>--}}
{{--            --}}{{--                                                                        </div>--}}
{{--            --}}{{--                                                                        <div class="col-md-10">--}}
{{--            --}}{{--                                                                            <input type="text" class="form-control" name="sku[]" id="sku">--}}
{{--            --}}{{--                                                                        </div>--}}
{{--            --}}{{--                                                                    </div>--}}
{{--            --}}{{--                                                                    <div class="row px-1 py-2">--}}
{{--            --}}{{--                                                                        <div class="col-md-2">--}}
{{--            --}}{{--                                                                            <label>Group SKU</label>--}}
{{--            --}}{{--                                                                        </div>--}}
{{--            --}}{{--                                                                        <div class="col-md-10">--}}
{{--            --}}{{--                                                                            <input type="text" class="form-control" name="gro_sku[]" id="grp_sku">--}}
{{--            --}}{{--                                                                        </div>--}}
{{--            --}}{{--                                                                    </div>--}}
{{--            --}}{{--                                                                    --}}{{----}}{{--                                    <div class="row m-t-10">--}}
{{--            --}}{{--                                                                    --}}{{----}}{{--                                        <div class="col-md-2">--}}
{{--            --}}{{--                                                                    --}}{{----}}{{--                                            <label>Price</label>--}}
{{--            --}}{{--                                                                    --}}{{----}}{{--                                        </div>--}}
{{--            --}}{{--                                                                    --}}{{----}}{{--                                        <div class="col-md-10">--}}
{{--            --}}{{--                                                                    --}}{{----}}{{--                                            <input type="text" class="form-control" name="price" id="price">--}}
{{--            --}}{{--                                                                    --}}{{----}}{{--                                        </div>--}}
{{--            --}}{{--                                                                    --}}{{----}}{{--                                    </div>--}}
{{--            --}}{{--                                                                    <div class="row px-1 py-2">--}}
{{--            --}}{{--                                                                        <div class="col-md-2">--}}
{{--            --}}{{--                                                                            <label>Stock</label>--}}
{{--            --}}{{--                                                                        </div>--}}
{{--            --}}{{--                                                                        <div class="col-md-10">--}}
{{--            --}}{{--                                                                            <input type="text" class="form-control" name="stock[]" id="stock">--}}
{{--            --}}{{--                                                                        </div>--}}
{{--            --}}{{--                                                                    </div>--}}
{{--            --}}{{--                                                                    <div class="row px-1 py-2">--}}
{{--            --}}{{--                                                                        <div class="col-md-2">--}}
{{--            --}}{{--                                                                            <label>Handling Time</label>--}}
{{--            --}}{{--                                                                        </div>--}}
{{--            --}}{{--                                                                        <div class="col-md-10">--}}
{{--            --}}{{--                                                                            <input type="text" class="form-control" name="h_time[]" id="h_time">--}}
{{--            --}}{{--                                                                        </div>--}}
{{--            --}}{{--                                                                    </div>--}}
{{--            --}}{{--                                                                </div>--}}
{{--            --}}{{--                                                            </div>--}}
{{--            --}}{{--                                                        </div>--}}
{{--        </div>--}}
{{--        <button type="button" class="btn btn-primary add_more">Add More</button>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="form-group row vendor-btn-top">
    <div class="col-md-12 text-center">
        <button class="vendor-btn" type="submit" class="btn btn-primary waves-effect waves-light">
            <b>Add</b>
        </button>
    </div>
</div>

<script>
    // $(document).ready(function () {
    //     $('.add_more').on('click',function () {
    //         var card_count = $('.card_container').length;
    //         $('.card_container').clone().first().appendTo('.append_listing').attr("id","card_container"+card_count).each(function () {
    //             $(this).find("select").attr("name","product_variant_option["+card_count+"][]");
    //             $(this).find("select").attr("id","product_variant_option_" + card_count);
    //         });
    //
    //         // $('.card_container select').attr({
    //         //     "name" : "product_variant_option["+card_count+"][]",
    //         //     "id" : "product_variant_option_"+card_count,
    //         // });
    //         console.log(card_count);
    //     });
    //     $('.parent_attribute').on('change',function () {
    //         var parent_id = $(this).attr('id');
    //         var parent_value = $(this).val();
    //         var id = parent_id.split('parent_attr_');
    //         if(parent_value != '') {
    //             $(".child_attr_"+id[1]).prop('disabled', false);
    //         }else{
    //             $(".child_attr_"+id[1]).prop('disabled', true);
    //             $(".child_attr_"+id[1]).val('');
    //         }
    //     });
    // });
</script>
