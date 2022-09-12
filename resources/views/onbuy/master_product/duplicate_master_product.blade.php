@extends('master')
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="vendor-title">
                            <p>Duplicate Master Product</p>
                        </div>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif


                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

                <div class="row m-t-20 onbuy-product">
                    <div class="col-md-12">
                        <div class="card-box shadow">
                            <form class="mobile-responsive m-t-10" role="form" action= {{url('onbuy/save-duplicate-master-product/'.$single_master_product_info->id)}} method="post">
                                @csrf
                                <div class="row m-b-10 d-flex align-items-center">
                                    <div class="col-md-2">
                                        <label class="required">Brand</label>
                                    </div>
                                    <div class="col-md-10">
                                        <select class="form-control" name="brand_id" id="brand_id">
                                            <option value="{{$single_master_product_info->brand_info->brand_id}}">{{$single_master_product_info->brand_info->name}}</option>
                                        </select>
                                        {{--                                            <input type="text" name="brand_id" class="form-control" id="brand_id" value="{{$single_master_product_info->brand_info->name}}">--}}
                                        {{--                                            <select class="form-control" name="brand_id" id="brand_id" required>--}}
                                        {{--                                                <option value="">Select Brand</option>--}}
                                        {{--                                                @foreach($brand_info as $brand)--}}
                                        {{--                                                    <option value="{{$brand->brand_id}}">{{$brand->name}}</option>--}}
                                        {{--                                                @endforeach--}}
                                        {{--                                            </select>--}}
                                    </div>
                                </div>
                                <input type="hidden" name="catalogue_id" value="{{$single_master_product_info->woo_catalogue_id}}">
                                <input type="hidden" name="master_opc" value="{{$single_master_product_info->opc}}">
                                <div class="row d-flex align-items-center pt-1" id="all_category_div">
                                    <div class="col-md-2">
                                        <label class="required">Category</label>
                                    </div>
                                    <div class="col-md-10 controls" id="category-level-1-group">
                                        <select class="form-control" name="last_cat_id" id="last_cat_id">
                                            <option value="{{$single_master_product_info->category_info->category_id}}">{{$single_master_product_info->category_info->name}}</option>
                                        </select>
                                        {{--                                            <input type="text" name="last_cat_id" class="form-control" id="last_cat_id" value="{{$single_master_product_info->category_info->name}}">--}}
                                        {{--                                            <select class="form-control category_select" name="child_cat[1]" id="child_cat_1" onchange="myFunction(1)">--}}
                                        {{--                                                <option value="">Select Category</option>--}}
                                        {{--                                                @foreach($all_parent_category as $category)--}}
                                        {{--                                                    <option value="{{$category->category_id}}">{{$category->name}}</option>--}}
                                        {{--                                                @endforeach--}}
                                        {{--                                            </select>--}}
                                    </div>
                                </div>
                                {{--                                    <div class="row d-flex align-items-center pt-1">--}}
                                {{--                                        <div class="col-md-2">--}}

                                {{--                                        </div>--}}
                                {{--                                        <div class="col-md-10">--}}
                                {{--                                            --}}{{--                                                    <button type="button" class="btn btn-primary m-t-10" id="list_button" style="display: none;">List</button>--}}
                                {{--                                            <input type="text" class="form-control" name="last_cat_id" id="last_cat_id" style="display: none;" value="">--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                <div class="row m-t-10 d-flex align-items-center">
                                    <div class="col-md-2">
                                        <label class="required">Master Product Name</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="m_product_name" value="{{$single_master_product_info->product_name}}">
                                    </div>
                                </div>
                                <div class="row m-t-10">
                                    <div class="col-md-2">
                                        <label class="required">Default Image</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img src="{{$single_master_product_info->default_image}}" width="128" height="128" alt="IMAGE">
                                                <input type="hidden" name="default_image" value="{{$single_master_product_info->default_image}}">
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
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach(json_decode($single_master_product_info->additional_images) as $images)
                                                @if($i != 0)
                                                    <div class="col-md-2">
                                                        <img src="{{$images}}" width="128" height="128" alt="IMAGE">
                                                        <input type="hidden" name="images[]" value="{{$images}}">
                                                    </div>
                                                @endif
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-10">
                                    <div class="col-md-2">
                                        <label class="required">Master Product Description</label>
                                    </div>
                                    <div class="col-md-10">
                                        <textarea class="form-control" id="messageArea" name="m_product_description">{!! $single_master_product_info->description !!}</textarea>
                                    </div>
                                </div>
                                <div class="row m-t-10">
                                    <div class="col-md-2">
                                        <label class="required">Master Summary Point (max : 5)</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card py-3 px-2">
                                            <div class="row d-flex align-items-center" id="m_summary_points">
                                                @isset($single_master_product_info->summary_points)
                                                    @foreach(json_decode($single_master_product_info->summary_points) as $summary_points)
                                                        <div id="remove_text_field" class="col-md-2">
                                                            <input type="text" class="form-control" name="m_summary_points[]" value="{{$summary_points}}">
                                                        </div>
                                                    @endforeach
                                                @endisset
                                            </div>
                                            <div class="d-flex pt-3">
                                                <button type="button" class="m-summary-btn btn-success" id="add_m_summary_points"><i class="fa fa-plus-square"></i></button>
                                                <button type="button" class="m-summary-btn btn-danger ml-2" id="remove_m_summary_points"><i class="fa fa-minus-square"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-10 d-flex align-items-center">
                                    <div class="col-md-2">
                                        <label class="required">Master Product Price</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="m_rrp" value="{{$single_master_product_info->rrp}}">
                                    </div>
                                </div>
                                <div class="row m-t-10">
                                    <div class="col-md-2">
                                        <label class="required">Master product Data</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card py-4 px-2">
                                            <div class="row" id="m_product_data">
                                                @isset($single_master_product_info->product_data)
                                                    @foreach(json_decode($single_master_product_info->product_data) as $product_data)
                                                        <div id="remove_m_product_data_field" class="col-md-6 d-flex align-items-center py-2">
                                                            <div>
                                                                <div class="text-center"><label>Label</label></div>
                                                                <input type="text" class="form-control" name="m_label[]" value="{{$product_data->label}}">
                                                            </div>
                                                            <div class="pl-1">
                                                                <div class="text-center"><label>Value</label></div>
                                                                <input type="text" class="form-control" name="m_value[]" value="{{$product_data->value}}">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endisset
                                            </div>
                                            <div class="d-flex pt-3">
                                                <button type="button" class="m-summary-btn btn-success" id="add_m_product_data"><i class="fa fa-plus-square"></i></button>
                                                <button type="button" class="m-summary-btn btn-danger ml-2" id="remove_m_product_data"><i class="fa fa-minus-square"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-10">
                                    <div class="col-md-2">
                                        <label class="required">Features </label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card">
                                            <div class="row px-2 py-3">
                                                @isset($category_data->results)
                                                    @foreach($category_data->results as $data)
                                                        <div class="col-md-4">
                                                            <button class="btn btn-primary w-100">{{$data->name}}</button>
                                                            <select class="form-control" name="m_feature[]">
                                                                <option value="">Select Option</option>
                                                                @isset($data->options)
                                                                    @foreach($data->options as $option)
                                                                        @php
                                                                            $temp = '';
                                                                        @endphp
                                                                        @foreach(json_decode($single_master_product_info->features) as $features)
                                                                            @if(explode('/',$features->option_id)[0] == $option->option_id)
                                                                                <option value="{{$option->option_id}}/{{$data->name}}/{{$option->name}}" selected>{{$option->name}}</option>
                                                                                @php
                                                                                    $temp = 1;
                                                                                @endphp
                                                                            @endif
                                                                        @endforeach
                                                                        @if($temp == null)
                                                                            <option value="{{$option->option_id}}/{{$data->name}}/{{$option->name}}">{{$option->name}}</option>
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

                                <div class="row m-t-10">
                                    <div class="col-md-2">
                                        <label class="required">Parent Attribute (Maximum : 2) </label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card">
                                            <div class="row px-2 py-3">
                                                @isset($category_data->results)
                                                    @foreach($category_data->results as $data)
                                                        <div class="col-md-4">
                                                            {{--                    <label>Variant 1</label>--}}
                                                            <select class="form-control parent_attribute" name="m_variant[]" id="parent_attr_{{$data->feature_id}}">
                                                                <option value="">Select Attribute</option>
                                                                <option value="{{$data->feature_id}}/{{$data->name}}">{{$data->name}}</option>
                                                            </select>
                                                            {{--                    <input type="text" class="form-control" name="m_variant[]">--}}
                                                        </div>
                                                    @endforeach
                                                @endisset
                                                <div class="col-md-2">
                                                    <label>Custom Name</label>
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
                                                    <div class="card m-t-10 card_container" id="card_container_0">
                                                        @isset($category_data->results)
                                                            @foreach($category_data->results as $data)
                                                                <div class="row px-1 py-2">
                                                                    <div class="col-md-2">
                                                                        <label>{{$data->name}}</label>
                                                                    </div>
                                                                    <div class="col-md-10">
                                                                        <select class="form-control child_attr_{{$data->feature_id}}" name="product_variant_option[0][]" id="product_variant_option_0" disabled>
                                                                            <option value="">Select Option</option>
                                                                            @foreach($data->options as $option)
                                                                                <option value="{{$option->option_id}}/{{$option->name}}">{{$option->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endisset
                                                        <div class="row px-1 py-2">
                                                            <div class="col-md-2">
                                                                <label>Custom Name</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="custom_variant[]">
                                                            </div>
                                                        </div>
                                                        <div class="row px-1 py-2">
                                                            <div class="col-md-2">
                                                                <label class="required">Product Code</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="product_codes[]" required>
                                                            </div>
                                                        </div>
                                                        <div class="row px-1 py-2">
                                                            <div class="col-md-2">
                                                                <label class="required">SKU</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="sku[]" id="sku" required>
                                                            </div>
                                                        </div>
                                                        <div class="row px-1 py-2">
                                                            <div class="col-md-2">
                                                                <label>Group SKU</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="gro_sku[]" id="grp_sku">
                                                            </div>
                                                        </div>
                                                        <div class="row px-1 py-2">
                                                            <div class="col-md-2">
                                                                <label>Stock</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="stock[]" id="stock">
                                                            </div>
                                                        </div>
                                                        <div class="row px-1 py-2">
                                                            <div class="col-md-2">
                                                                <label>Handling Time</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="h_time[]" id="h_time">
                                                            </div>
                                                        </div>
                                                    </div>
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
                            </form> <!--//End form -->
                        </div> <!--//End card-box -->
                    </div><!--//End col-md-12 -->
                </div><!--//End row -->
            </div> <!-- // End Container-fluid -->
        </div> <!-- // End Content -->
    </div> <!-- // End Contact page -->
    <script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.add_more').on('click',function () {
                var card_count = $('.card_container').length;
                $('.card_container').clone().first().appendTo('.append_listing').attr("id","card_container"+card_count).each(function () {
                    $(this).find("select").attr("name","product_variant_option["+card_count+"][]");
                    $(this).find("select").attr("id","product_variant_option_" + card_count);
                });

                // $('.card_container select').attr({
                //     "name" : "product_variant_option["+card_count+"][]",
                //     "id" : "product_variant_option_"+card_count,
                // });
                console.log(card_count);
            });

            $('.parent_attribute').on('change',function () {
                var parent_id = $(this).attr('id');
                var parent_value = $(this).val();
                var id = parent_id.split('parent_attr_');
                if(parent_value != '') {
                    $(".child_attr_"+id[1]).prop('disabled', false);
                }else{
                    $(".child_attr_"+id[1]).prop('disabled', true);
                    $(".child_attr_"+id[1]).val('');
                }
            });
        });
    </script>
    <script type="text/javascript">
        CKEDITOR.replace( 'messageArea',
            {
                customConfig : 'config.js',
                toolbar : 'simple'
            })

    </script>

@endsection
