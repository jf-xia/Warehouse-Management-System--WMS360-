<form class="mobile-responsive m-t-10" role="form" action= {{url('onbuy/save-onbuy-product')}} method="post">
    @csrf
    {{--                                        <div class="row">--}}
    {{--                                            <div class="col-md-12">--}}
    {{--                                                <div class="list-onbuy mb-3">--}}
    {{--                                                    <div class="custom-control custom-checkbox d-flex align-items-center">--}}
    {{--                                                        <input type="checkbox" name="select_onbuy_checkbox" class="custom-control-input" id="select_onbuy_checkbox" value="1">--}}
    {{--                                                        <label class="custom-control-label" for="select_onbuy_checkbox">List on Onbuy</label>--}}
    {{--                                                    </div>--}}
    {{--                                                </div>--}}
    {{--                                                <hr>--}}
    {{--                                            </div>--}}
    {{--                                        </div>--}}
    <input type="hidden" class="form-control" name="catalogue_id" id="catalogue_id" value="{{$catalogue_info->id}}">

    <div id="Load" class="load" style="display: none;">
        <div class="load__container">
            <div class="load__animation"></div>
            <div class="load__mask"></div>
            <span class="load__title">Content is loading...</span>
        </div>
    </div>
    <div class="container">
        <div class="row m-b-10 d-flex align-items-center">
            <div class="col-md-2">
                <label class="required">Brand</label>
            </div>
            <div class="col-md-10">
                <select class="form-control" name="brand_id" id="brand_id" required>
                    {{--                                                <option value="">Select Brand</option>--}}
                    @foreach($brand_info as $brand)
                        @if($brand->brand_id = $profile_result->brand)
                            <option value="{{$brand->brand_id}}" selected>{{$brand->name}}</option>
                        @else
                            <option value="{{$brand->brand_id}}" >{{$brand->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
{{--        <div class="row d-flex align-items-center pt-1" id="all_category_div">--}}
{{--            <div class="col-md-2">--}}
{{--                <label class="required">Category</label>--}}
{{--            </div>--}}
{{--            <div class="col-md-10 controls" id="category-level-1-group">--}}
{{--                @foreach(unserialize($profile_result->category_ids) as $categories)--}}
{{--                    /{{\App\OnbuyCategory::find($categories)->name }}--}}
{{--                @endforeach--}}
{{--                --}}{{--                                            <select class="form-control category_select" name="child_cat[1]" id="child_cat_1" onchange="myFunction(1)">--}}
{{--                --}}{{--                                                <option value="">Select Category</option>--}}
{{--                --}}{{--                                                @foreach($all_parent_category as $category)--}}
{{--                --}}{{--                                                    <option value="{{$category->category_id}}">{{$category->name}}</option>--}}
{{--                --}}{{--                                                @endforeach--}}
{{--                --}}{{--                                            </select>--}}

{{--            </div>--}}
{{--        </div>--}}
        <div class="row d-flex align-items-center pt-1">
            <div class="col-md-2">

            </div>
            <div class="col-md-10">
                {{--                                                    <button type="button" class="btn btn-primary m-t-10" id="list_button" style="display: none;">List</button>--}}
                <input type="text" class="form-control" name="last_cat_id" id="last_cat_id" style="display: none;" value="">
            </div>
        </div>
        <div class="row m-t-10 d-flex align-items-center">
            <div class="col-md-2">
                <label class="required">Master Product Name</label>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control" name="m_product_name" value="{{$catalogue_info->name}}" required>
            </div>
        </div>
        {{--                                            <div class="row m-t-10 d-flex align-items-center">--}}
        {{--                                                <div class="col-md-2">--}}
        {{--                                                    <label>Master Product Code</label>--}}
        {{--                                                </div>--}}
        {{--                                                <div class="col-md-10">--}}
        {{--                                                    <input type="text" class="form-control" name="m_product_codes">--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        <div class="row m-t-10">
            <div class="col-md-2">
                <label class="required">Default Image</label>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{$catalogue_info->images[0]->image_url ?? 'https://previews.123rf.com/images/pavelstasevich/pavelstasevich1811/pavelstasevich181101027/112815900-no-image-available-icon-flat-vector.jpg'}}" width="128" height="128" alt="IMAGE">
                        <input type="hidden" name="default_image" value="{{$catalogue_info->images[0]->image_url ?? 'https://previews.123rf.com/images/pavelstasevich/pavelstasevich1811/pavelstasevich181101027/112815900-no-image-available-icon-flat-vector.jpg'}}">
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
                            @if($i != 0)
                                <div class="col-md-2">
                                    <img src="{{$images->image_url}}" width="128" height="128" alt="IMAGE">
                                    <input type="hidden" name="images[]" value="{{$images->image_url}}">
                                </div>
                            @endif
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    @endisset
                    {{--                                                        <div class="col-md-2">--}}
                    {{--                                                            <img src="assets/images/avatar-1.jpg" alt="IMAGE">--}}
                    {{--                                                        </div>--}}
                    {{--                                                        <div class="col-md-2">--}}
                    {{--                                                            <img src="assets/images/avatar-1.jpg" alt="IMAGE">--}}
                    {{--                                                        </div>--}}
                    {{--                                                        <div class="col-md-2">--}}
                    {{--                                                            <img src="assets/images/avatar-1.jpg" alt="IMAGE">--}}
                    {{--                                                        </div>--}}
                    {{--                                                        <div class="col-md-2">--}}
                    {{--                                                            <img src="assets/images/avatar-1.jpg" alt="IMAGE">--}}
                    {{--                                                        </div>--}}
                    {{--                                                        <div class="col-md-2">--}}
                    {{--                                                            <img src="assets/images/avatar-1.jpg" alt="IMAGE">--}}
                    {{--                                                        </div>--}}
                </div>
            </div>
        </div>
        <div class="row m-t-10">
            <div class="col-md-2">
                <label class="required">Master Product Description</label>
            </div>
            <div class="col-md-10">
                <textarea class="form-control" id="messageArea" name="m_product_description" required>{!! $catalogue_info->description !!}</textarea>
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
                                <input type="text" class="form-control" name="m_summary_points[]" value="{{$summery_point}}">
                            </div>
                        </div>
                    @endforeach

                    {{--                                                <div class="d-flex pt-3">--}}
                    {{--                                                    <button type="button" class="m-summary-btn btn-success" id="add_m_summary_points"><i class="fa fa-plus-square"></i></button>--}}
                    {{--                                                    <button type="button" class="m-summary-btn btn-danger ml-2" id="remove_m_summary_points"><i class="fa fa-minus-square"></i></button>--}}
                    {{--                                                </div>--}}
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
                        <button type="button" class="m-summary-btn btn-success" id="add_m_product_data"><i class="fa fa-plus-square"></i></button>
                        <button type="button" class="m-summary-btn btn-danger ml-2" id="remove_m_product_data"><i class="fa fa-minus-square"></i></button>
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
                                                        <option value="{{$option->option_id}}/{{$data->name}}/{{$option->name}}" selected>{{$option->name}}</option>
                                                    @else
                                                        <option value="{{$option->option_id}}/{{$data->name}}/{{$option->name}}" >{{$option->name}}</option>
                                                    @endif
                                                @endforeach
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
                                @foreach($technical_data->results as $key => $data)
                                    <div class="col-md-12">
                                        <h5>{{$data->group_name}}</h5><span>(Write your value after the already inserted id and don't give '/' slash in your input value)</span><br>
                                    </div>
                                    @isset($data->options)
                                        @foreach($data->options as $option)
                                            <div class="col-md-6 m-t-15">
                                                <button class="btn btn-primary w-100">{{$option->name}}</button>
                                                @if(isset($technical_details[$key]))
                                                    <input type="text" class="form-control" name="m_tectnical_details[]" value="{{$technical_details[$key]}}">
                                                @else
                                                    <input type="text" class="form-control" name="m_tectnical_details[]" value="{{$option->detail_id}}/">
                                                @endif
                                            </div>
                                        @endforeach
                                    @endisset
                                @endforeach
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row vendor-btn-top">
                <div class="col-md-12 text-center">
                    <button class="vendor-btn" type="submit" class="btn btn-primary waves-effect waves-light">
                        <b>update</b>
                    </button>
                </div>
            </div>
        </div>


    </div>
</form> <!--//End form -->

<script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'messageArea',
        {
            customConfig : 'config.js',
            toolbar : 'simple'
        })

</script>

<script>

    function myFunction(id) {
        // console.log('found');

        // Category choose
        // $(document).ready(function () {
        //     $('select').on("change",function(){
        var catalogue_id = $('#catalogue_id').val();
        var category_id = $('#child_cat_'+id).val();
        console.log(category_id);
        $.ajax({
            type: "post",
            url: "{{url('onbuy/ajax-category-child-list')}}",
            data: {
                "_token": "{{csrf_token()}}",
                "category_id": category_id,
                "catalogue_id": catalogue_id
            },
            beforeSend: function (){
                $('#ajax_loader').show();
            },
            success: function (response) {
                if(response.data == 1) {
                    console.log(response.content);
                    console.log(response.lavel);
                    $('#category-level-' + response.lavel + '-group').nextAll().remove();
                    $('#last_cat_id').val('');
                    $('#last_cat_id').hide();
                    $('#all_category_div').append(response.content);

                }else{
                    $('#last_cat_id').show();
                    $('#last_cat_id').val(category_id);
                    console.log(response);
                    $('#add_variant_product').html(response);
                }
            },
            complete: function (data) {
                $('#ajax_loader').hide();
            }
        });
        //     });
        // });
    }

    // $(document).on("click",function () {
    //     $("#all_category_div").lastChild();
    // });

    // Master summery points
    $(document).ready(function(){
        $("#add_m_summary_points").click(function(){
            $("#m_summary_points").append("<div id=\"remove_text_field\" class=\"col-md-2 p-2\">\n" + "<input type=\"text\" class=\"form-control\" name=\"m_summary_points[]\">\n" + "</div>");
        });
        $("#remove_m_summary_points").click(function(){
            $("#remove_text_field").remove();
        });
    });
    // Master Product data
    $(document).ready(function(){
        $("#add_m_product_data").click(function(){
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
        $("#remove_m_product_data").click(function(){
            $("#remove_m_product_data_field").remove();
        });
    });
</script>


