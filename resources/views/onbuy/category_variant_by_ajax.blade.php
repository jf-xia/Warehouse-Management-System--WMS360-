<style>
    .background_image{
        opacity:0.5;
        background: black;
    }
</style>
<form class="mobile-responsive m-t-10" role="form" action={{url('onbuy/save-onbuy-product')}} method="post" target="_blank">
    @csrf
    <input type="hidden" class="form-control" name="catalogue_id" id="catalogue_id" value="{{$catalogue_info->id}}">

    <div id="Load" class="load" style="display: none;">
        <div class="load__container">
            <div class="load__animation"></div>
            <div class="load__mask"></div>
            <span class="load__title">Content is loading...</span>
        </div>
    </div>


    
        <div class="row m-b-10 d-flex align-items-center">
            <div class="col-md-2">
                <label class="required">Brand</label>
            </div>
            <div class="col-md-10">
                <select class="form-control" name="brand_id" id="brand_id" required>
                    {{--                                                <option value="">Select Brand</option>--}}
                    <option value="">Select Brand</option>
                    @foreach($brand_info as $brand)
                        @if($brand->brand_id == $profile_result->brand)
                            <option value="{{$brand->brand_id}}" selected>{{$brand->name}}</option>
                        @else
                            <option value="{{$brand->brand_id}}">{{$brand->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row d-flex align-items-center pt-1">
            <div class="col-md-2">

            </div>
            <div class="col-md-10">
                {{--                                                    <button type="button" class="btn btn-primary m-t-10" id="list_button" style="display: none;">List</button>--}}
                <input type="text" class="form-control" name="last_cat_id" id="last_cat_id" style="display: none;"
                       value="{{$profile_result->last_category_id}}">
            </div>
        </div>
        <div class="row m-t-10 d-flex align-items-center">
            <div class="col-md-2">
                <label class="required">Master Product Name</label>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control" name="m_product_name" id="m_product_name" onkeyup="Count();" value="{{$catalogue_info->name}}"
                       required>
                <span id="display" class="float-right"></span>
            </div>
        </div>
        <div class="row m-t-10">
            <div class="col-md-2">
                <label class="required">Default Image</label>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-success">If you want to change your default image, please select your desired image from additional images below.</p>
                        <img id="default_image_show"
                            src="{{(filter_var($catalogue_info->images[0]->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$catalogue_info->images[0]->image_url : 'https://previews.123rf.com/images/pavelstasevich/pavelstasevich1811/pavelstasevich181101027/112815900-no-image-available-icon-flat-vector.jpg'}}"
                            width="128" height="128" alt="IMAGE">
                        <input type="hidden" name="default_image" id="default_image_value"
                               value="{{(filter_var($catalogue_info->images[0]->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$catalogue_info->images[0]->image_url : 'https://previews.123rf.com/images/pavelstasevich/pavelstasevich1811/pavelstasevich181101027/112815900-no-image-available-icon-flat-vector.jpg'}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-t-10">
            <div class="col-md-2">
                <label class="required">Additional Image</label>
            </div>
            <div class="col-md-10">
                <div class="row">
                    @isset($catalogue_info->images)
                        @php
                            $i = 0;
                        @endphp
                        @foreach($catalogue_info->images as $images)
{{--                            @if($i != 0)--}}
                                <div class="col-md-2">
                                    <img src="{{(filter_var($images->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$images->image_url : $images->image_url}}" class="card-img-top img-thumbnail" width="128" height="128" alt="IMAGE">
                                    <input type="hidden" name="images[]" value="{{(filter_var($images->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$images->image_url : $images->image_url}}">
                                </div>
{{--                            @endif--}}
{{--                            @php--}}
{{--                                $i++;--}}
{{--                            @endphp--}}
                        @endforeach
                    @endisset
                </div>
            </div>
        </div>
        <div class="row m-t-10">
            <div class="col-md-2">
                <label class="required">Master Product Description</label>
            </div>
            <div class="col-md-10">
                <textarea class="form-control" id="messageArea" name="m_product_description"
                          required>{!! $catalogue_info->description !!}</textarea>
            </div>
        </div>
        <div class="row m-t-10">
            <div class="col-md-2">
                <label class="required">Master Summary Point (max : 5)</label>
            </div>
            <div class="col-md-10">
                <div class="card py-3 px-2">
                    @foreach(unserialize($profile_result->summery_points) as $key => $summery_point)

                        <div class="row d-flex m-t-10 align-items-center" id="m_summary_points">
                            <span class="m-l-10">{{$key+1}}</span>
                            <div id="remove_text_field" class="col-md-6">
                                <input type="text" class="form-control" name="m_summary_points[]"
                                       value="{{$summery_point}}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row m-t-10 d-flex align-items-center">
            <div class="col-md-2">
                <label class="required">Master Product Price</label>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control" name="m_rrp" value="{{$catalogue_info->sale_price}}" required>
            </div>
        </div>
        <div class="row m-t-10">
            <div class="col-md-2">
                <label class="required">Master product Data</label>
            </div>
            <div class="col-md-10">
                <div class="card py-4 px-2">
                    @foreach(\Opis\Closure\unserialize($profile_result->master_product_data) as $key => $value)
                        <div class="row" id="m_product_data">
                            <div id="remove_m_product_data_field" class="col-md-4 d-flex align-items-center py-2">
                                <div>
                                    <div class="text-center"><label>Label</label></div>
                                    <input type="text" class="form-control" name="m_label[]" value="{{$key}}">
                                </div>
                                <div class="pl-1">
                                    <div class="text-center"><label>Value</label></div>
                                    <input type="text" class="form-control" name="m_value[]" value="{{$value}}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="d-flex pt-3">
                        <button type="button" class="m-summary-btn btn-success" id="add_m_product_data"><i
                                class="fa fa-plus-square"></i></button>
                        <button type="button" class="m-summary-btn btn-danger ml-2" id="remove_m_product_data"><i
                                class="fa fa-minus-square"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div id="add_variant_product">
            <div class="row m-t-10">
                <div class="col-md-2">
                    <label class="required">Features </label>
                </div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="row px-2 py-3">
                            @isset($category_data->results)
                                @foreach($category_data->results as $key =>$data)
                                    <div class="col-md-4">
                                        <div class="btn btn-primary w-100">{{$data->name}}</div>
                                        <select class="form-control" name="m_feature[]">
                                            <option value="">Select Option</option>
                                            @isset($data->options)
                                                @foreach($data->options as $option)
                                                    @if(explode('/',$feature_array[$key])[0] == $option->option_id)
                                                        <option
                                                            value="{{$option->option_id}}/{{$data->name}}/{{$option->name}}"
                                                            selected>{{$option->name}}</option>
                                                    @else
                                                        <option
                                                            value="{{$option->option_id}}/{{$data->name}}/{{$option->name}}">{{$option->name}}</option>
                                                    @endif
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                @endforeach
                            @endisset

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
                            @php
                                $i = 0;
                            @endphp
                                @foreach($technical_data->results as $key => $data)
                                    <div class="col-md-12">
                                        <h5>{{$data->group_name}}</h5><span>(Write your value after the already inserted id and don't give '/' slash in your input value)</span><br>
                                    </div>
                                    @isset($data->options)
                                        @foreach($data->options as $option)
                                            <div class="col-md-6 m-t-15">
                                                <button class="btn btn-primary w-100">{{$option->name}}</button>
                                                @if(isset($technical_details[$i]))
                                                    <input type="text" class="form-control" name="m_tectnical_details[]"
                                                           value="{{$technical_details[$i]}}">
                                                @else
                                                    <input type="text" class="form-control" name="m_tectnical_details[]"
                                                           value="{{$option->detail_id}}/">
                                                @endif
                                            </div>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    @endisset
                                @endforeach
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-t-10">
                <div class="col-md-2">
                    <label class="required">Parent Attribute (Maximum : 2) </label>
                </div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="row px-2 py-3">
                            @isset($category_data->results)
                                @foreach($category_data->results as $data)
                                    @foreach($p_v as $pv)
                                        @if($data->name == $pv)
                                            <div class="col-md-4">
                                                {{--                    <label>Variant 1</label>--}}
                                                <select class="form-control parent_attribute" name="m_variant[]"
                                                        id="parent_attr_{{$data->feature_id}}">
                                                    <option value="">Select Attribute</option>
                                                    <option value="{{$data->feature_id}}/{{$data->name}}"
                                                            selected>{{$data->name}}</option>
                                                </select>
                                                {{--                            @if($temp == null)--}}
                                                {{--                                <option value="{{$data->feature_id}}/{{$data->name}}">{{$data->name}}</option>--}}
                                                {{--                            @endif--}}
                                                {{--                    <input type="text" class="form-control" name="m_variant[]">--}}
                                            </div>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endisset
                            <div class="col-md-2">
                                <label>Custom Arrtribute</label>
                            </div>
                            <div class="col-md-4 m-t-5">
                                <input type="text" class="form-control" name="m_custom_variant">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-t-10">
                <div class="col-md-2">
                    <label class="required">Variants </label>
                </div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="row px-2 py-2">
                            <div class="col-md-12 append_listing">
                                <label>Multiple Variant (Choose variant according to parent attribute)</label>
                                @isset($catalogue_info->product_variations)
                                    @php
                                        $count = 0;
                                    @endphp
                                    @foreach($catalogue_info->product_variations as $variant)
                                        @php
                                            $string = '';
                                            //if($variant->attribute1){
                                                //$string .= $variant->attribute1.',';
                                            //}
                                            //if($variant->attribute2){
                                               //$string .= $variant->attribute2.',';
                                            //}
                                            //if($variant->attribute3){
                                               // $string .= $variant->attribute3.',';
                                           // }
                                            //if($variant->attribute4){
                                                //$string .= $variant->attribute4.',';
                                            //}
                                            //if($variant->attribute5){
                                                //$string .= $variant->attribute5.',';
                                            //}
                                            if($variant->attribute != null){
                                                    foreach (\Opis\Closure\unserialize($variant->attribute) as $attribute){
                                                    $string .= $attribute['terms_name'].',';
                                                }
                                            }
                                            $variation = rtrim($string,',');
                                        @endphp
                                        @if(array_search($variant->ean_no,array_column($exits_ean,'ean_no')) === FALSE)
                                            <div class="card m-t-10 card_container" id="card_container_0">
                                                <div class="row px-1 py-2">
                                                    <div class="col-md-2">
                                                        <label class="required">Variation</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="variation"
                                                               value="{{$variation}}" required>
                                                    </div>
                                                </div>
                                                @isset($category_data->results)
                                                    @foreach($category_data->results as $data)
                                                        @if(in_array($data->name,$p_v))
                                                            <div class="row px-1 py-2">
                                                                <div class="col-md-2">
                                                                    <label class="required">{{$data->name}}</label>
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <select
                                                                        class="form-control child_attr_{{$data->feature_id}}"
                                                                        name="product_variant_option[{{$count}}][]"
                                                                        id="product_variant_option_{{$count}}" required>
                                                                        <option value="">Select Option</option>
                                                                        @php
                                                                            $temp = '';
                                                                        @endphp
                                                                        @foreach($data->options as $option)
                                                                            @foreach(\Opis\Closure\unserialize($variant->attribute) as $attribute)
{{--                                                                                @if($option->name == $variant->attribute1 || $option->name == $variant->attribute2 || $option->name == $variant->attribute3 || $option->name == $variant->attribute4 || $option->name == $variant->attribute5)--}}
                                                                                @if($data->name == $attribute['attribute_name'])
                                                                                     @if($option->name == $attribute['terms_name'])
                                                                                    <option
                                                                                            value="{{$option->option_id}}/{{$option->name}}"
                                                                                            selected>{{$option->name}}</option>
                                                                                        @php
                                                                                            $temp = 1;
                                                                                        @endphp
                                                                                    @elseif($temp == null && $data->name == 'Size' && $option->option_id == '53889')
                                                                                        <option value="{{$option->option_id}}/{{$option->name}}" selected>{{$option->name}}</option>
                                                                                    @else
                                                                                        <option
                                                                                            value="{{$option->option_id}}/{{$option->name}}">{{$option->name}}</option>
                                                                                        @php
                                                                                            $cus_variation = $attribute['terms_name'];
                                                                                        @endphp
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                        @endforeach
                                                                    </select>
                                                                    @if($temp == null)
                                                                        <input type="text" class="form-control m-t-5"
                                                                               name="product_variant_custom_option[{{$count}}][]"
                                                                               value="{{$cus_variation}}"
                                                                               placeholder="Please give custom name if you do not find variation in above select option">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endisset
                                                <div class="row px-1 py-2">
                                                    <div class="col-md-2">
                                                        <label class="{{$catalogue_info->type != 'variable' ? 'required': ''}}">Custom Attr terms</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="custom_variant[]"
                                                               placeholder="If you choose parent custom attribute, then enter terms here." @if($catalogue_info->type != 'variable') required @endif>
                                                    </div>
                                                </div>
                                                <div class="row px-1 py-2">
                                                    <div class="col-md-2">
                                                        <label class="required">EAN/UPC/ISBN</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="product_codes[]"
                                                               value="{{$variant->ean_no}}" required>
                                                    </div>
                                                </div>
                                                <div class="row px-1 py-2">
                                                    <div class="col-md-2">
                                                        <label class="required">SKU</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="sku[]" id="sku"
                                                               value="{{$variant->sku}}" required>
                                                    </div>
                                                </div>
                                                <div class="row px-1 py-2">
                                                    <div class="col-md-2">
                                                        <label>Group SKU</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="gro_sku[]"
                                                               id="grp_sku">
                                                    </div>
                                                </div>
                                                <div class="row px-1 py-2">
                                                    <div class="col-md-2">
                                                        <label>Stock</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="stock[]"
                                                               id="stock" value="{{$variant->actual_quantity}}">
                                                    </div>
                                                </div>
                                                <div class="row px-1 py-2">
                                                    <div class="col-md-2">
                                                        <label>Sale Price</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="sale_price[]"
                                                               id="sale_price">
                                                    </div>
                                                </div>
                                                <div class="row px-1 py-2">
                                                    <div class="col-md-2">
                                                        <label>Sale Price Start Date</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="date" class="form-control" name="sale_start_date[]"
                                                               id="sale_end_date">
                                                    </div>
                                                </div>
                                                <div class="row px-1 py-2">
                                                    <div class="col-md-2">
                                                        <label>Sale Price End Date</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="date" class="form-control" name="sale_end_date[]"
                                                               id="sale_end_date">
                                                    </div>
                                                </div>
                                                <div class="row px-1 py-2">
                                                    <div class="col-md-2">
                                                        <label>Boost Commission</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="boost_commission[]"
                                                               id="boost_commission">
                                                    </div>
                                                </div>
                                                <div class="row px-1 py-2">
                                                    <div class="col-md-2">
                                                        <label>Handling Time</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="h_time[]"
                                                               id="h_time">
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                $count++;
                                            @endphp
                                        @else
                                            <div class="card m-t-10 card_container">
                                                <div class="row px-1 py-2">
                                                    <div class="col-md-10">
                                                        <!-- <div class="card"> -->
                                                            <img src="{{$exits_ean_product_info[$variant->ean_no]['image_url']}}" alt="Product Image" class="card-image-top w-25">
                                                            <div class="card-body float-right">
                                                                <h5>Title: {{$exits_ean_product_info[$variant->ean_no]['name']}}</h5>
                                                                <a href="{{$exits_ean_product_info[$variant->ean_no]['product_url']}}" class="btn btn-success" target="_blank">See On Onbuy</a>
                                                                <h5>
                                                                    EAN no <span class="text-success">{{$variant->ean_no}}</span> is assigend under variation 
                                                                    <span class="text-success">{{$variation}}</span>
                                                                </h5>
                                                                @php
                                                                    $key = array_search($variant->ean_no,array_column($exits_ean,'ean_no'));
                                                                @endphp
                                                                <a href="{{url('onbuy/add-exist-ean-listing/?catalogue_id='.$catalogue_id.'&exist_ean='.$variant->ean_no.'&exist_opc='.$exits_ean[$key]['opc'].'&product_id='.$exits_ean[$key]['product_id'].'&profile_id='.$profile_result->id)}}"
                                                                class="btn btn-primary change_status">Add Listing</a>
        {{--                                                        <a href="{{url('onbuy/add-listing/'.$catalogue_id.'/exist-ean/'.$variant->ean_no.'/opc/'.$exits_ean[$key]['opc'].'/product-id/'.$exits_ean[$key]['product_id'])}}"--}}
        {{--                                                           class="btn btn-primary">Add Listing</a>--}}
                                                            </div>
                                                        <!-- </div> -->
                                                    
                                                    </div>
                                                    <div class="col-md-10 added-content-{{$variant->ean_no}}"></div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endisset
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary add_more">Add More</button>
                </div>
            </div>

            <div class="form-group row vendor-btn-top">
                <div class="col-md-12 text-center">
                    <button class="vendor-btn" type="submit" class="btn btn-primary waves-effect waves-light">
                        <b>Add</b>
                    </button>
                </div>
            </div>
        </div>


    </div>
</form> <!--//End form -->

<script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript">
    CKEDITOR.replace('messageArea',
        {
            customConfig: 'config.js',
            toolbar: 'simple'
        })

</script>

<script>
    $(document).ready(function () {
        $('.add_more').on('click', function () {
            var card_count = $('.card_container').length;
            $('.card_container').clone().first().appendTo('.append_listing').attr("id", "card_container" + card_count).each(function () {
                $(this).find("select").attr("name", "product_variant_option[" + card_count + "][]");
                $(this).find("select").attr("id", "product_variant_option_" + card_count);
            });

            // $('.card_container select').attr({
            //     "name" : "product_variant_option["+card_count+"][]",
            //     "id" : "product_variant_option_"+card_count,
            // });
            console.log(card_count);
        });
        $('.parent_attribute').on('change', function () {
            var parent_id = $(this).attr('id');
            var parent_value = $(this).val();
            var id = parent_id.split('parent_attr_');
            if (parent_value != '') {
                $(".child_attr_" + id[1]).prop('disabled', false);
            } else {
                $(".child_attr_" + id[1]).prop('disabled', true);
                $(".child_attr_" + id[1]).val('');
            }
        });

        $('.card-img-top').on('click',function () {
            var image_url = $(this).attr('src');
            var default_image = $('#default_image_value').val();
            // console.log(image_url);
            // console.log(default_image);
            var default_image_append = $('#default_image_value').val(image_url);
            $('#default_image_show').attr('src',image_url);
            var defaul_image_append_url = $('#default_image_value').val();
            console.log(defaul_image_append_url);
            $('.card-img-top').removeClass('background_image');
            $(this).addClass('background_image');
        });
    });

    $(document).ready(function () {
        $("#add_m_product_data").click(function () {
            $("#m_product_data").append("<div id=\"remove_m_product_data_field\" class=\"col-md-4 d-flex align-items-center py-2\">\n" +
                "<div>\n" +
                "<div class=\"text-center\"><label>Label</label></div>\n" +
                "<input type=\"text\" class=\"form-control\" name=\"m_label[]\">\n" +
                "</div>\n" +
                "<div class=\"pl-1\">\n" +
                "<div class=\"text-center\"><label>Value</label></div>\n" +
                "<input type=\"text\" class=\"form-control\" name=\"m_value[]\">\n" +
                "</div>\n" +
                "</div>");
        });
        $("#remove_m_product_data").click(function () {
            $("#remove_m_product_data_field").remove();
        });

        $('button').click(function () {
            if($('input[name=m_product_name]').val().length > 50){
                var check = confirm('Product name exceeds 50 characters. Do you want to continue?');
                if(check){
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
        });
        var i = document.getElementById("m_product_name").value.length;
        document.getElementById("display").innerHTML = (i > 50) ? '<p class="text-danger">Product character: ' + i + '</p>' : 'Product character: ' + i;
        $("a.change_status").click(function(){
           var url = $(this).attr('href');
           event.preventDefault();
           console.log(url);
           $.ajax({
               type: "GET",
               url: url,
               beforeSend: function(){
                   console.log('before send')
               },
               success: function(response){
                   console.log(response)
                   $('.added-content-'+response.exist_ean).html(response.content)
               }
           });
        });
    });
    function existEanFormSubmit(formId){
        var dataArra = [];
        var arrayVal = {};
        // var serializeDataArra = $('div#exist-ean-form-'+formId+' :input').serializeArray()
        // var dataObject = {};
        // serializeDataArra.forEach(function (data){
        //         var fieldName = data.name;
        //         dataObject[fieldName] = data.value;
        //     })
        var serializeTermsArra = [];
        var serializeTermsArra = $('div#exist-ean-form-'+formId+' select.variation-terms').serializeArray()
        var i = 0;
        serializeTermsArra.forEach(function (data){
            console.log(data.name.split("variation_terms[][")[1])
            console.log(data.value)
            // var arrayVal[] = [
            //     data.name.split("variation_terms[]")[1] => data.value
            // ];
            arrayVal[data.name.split("variation_terms[][")[1].slice(0,-1)] = data.value
            dataArra.push(arrayVal)
            // dataArra[i] = {data.name.split("variation_terms[][")[1].slice(0,-1) : data.value}
            arrayVal[] = '';
            // var arrayVal = {};
        
                // var fieldName = data.name;
                // dataArra[fieldName] = data.value;
            })
            console.log(dataArra)
            console.log(serializeTermsArra)
        var brandId = $('div#exist-ean-form-'+formId).find('select[name="brand_id"]').val()
        var condition = $('div#exist-ean-form-'+formId).find('select[name="condition"]').val()
        var masterCatalogue = $('div#exist-ean-form-'+formId).find('input[name="condition"]').val()
        var existOpc = $('div#exist-ean-form-'+formId).find('input[name="exist_opc"]').val()
        var existEan = $('div#exist-ean-form-'+formId).find('input[name="exist_ean"]').val()
        var productId = $('div#exist-ean-form-'+formId).find('input[name="productId"]').val()
        var profileId = $('div#exist-ean-form-'+formId).find('input[name="profileId"]').val()
        var sku = $('div#exist-ean-form-'+formId).find('input[name="sku"]').val()
        var groupSku = $('div#exist-ean-form-'+formId).find('input[name="group_sku"]').val()
        var price = $('div#exist-ean-form-'+formId).find('input[name="price"]').val()
        var stock = $('div#exist-ean-form-'+formId).find('input[name="stock"]').val()
        console.log(condition)
        // return 
        $.ajax({
            type: "POST",
            url: "{{asset('onbuy/save-exist-ean-listings')}}",
            data: {
                "_token": "{{csrf_token()}}",
                "newArr": dataArra,
                "variation_terms": serializeTermsArra,
                "brand_id": brandId,
                "condition": condition,
                "master_catalogue": masterCatalogue,
                "exist_opc": existOpc,
                "exist_ean": existEan,
                "productId": productId,
                "profileId": profileId,
                "sku": sku,
                "group_sku": groupSku,
                "price": price,
                "stock": stock
            },
            beforeSend: function(){
                console.log('before send')
            },
            success: function(response){
                console.log(response)
            }
        })
         
    }
    function Count() {
        var i = document.getElementById("m_product_name").value.length;
        if(i <= 50) {
            document.getElementById("display").innerHTML = 'Character Remain for (50): ' + (50 - i);
        }else{
            document.getElementById("display").innerHTML = '<p class="text-danger">Exceeds character: ' + (i - 50) + ' for (50)</p>';
        }
    }
</script>
