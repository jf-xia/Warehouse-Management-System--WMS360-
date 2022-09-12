@extends('master')

@section('title')
    OnBuy | Active Product | Edit OnBuy Product | WMS360
@endsection

@section('content')

    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.css')}}"  />
    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item" aria-current="page"> Active Product </li>
                            <li class="breadcrumb-item active" aria-current="page"> Edit OnBuy Product </li>
                        </ol>
                    </div>
                </div>


                <div class="row m-t-20 onbuy-product">
                    <div class="col-md-12">
                        <div class="card-box shadow">


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


                            <form class="mobile-responsive m-t-10" role="form" action= {{url('onbuy/update-master-product/'.$single_master_product_info->id)}} method="post">
                                @csrf
                                <div id="Load" class="load" style="display: none;">
                                    <div class="load__container">
                                        <div class="load__animation"></div>
                                        <div class="load__mask"></div>
                                        <span class="load__title">Content is loading...</span>
                                    </div>
                                </div>
                                <input type="hidden" name="master_opc" class="form-control" id="master_opc" value="{{$single_master_product_info->opc}}">
                                <div class="container">
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
                                                @if($single_master_product_info->additional_images != null)
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
                                                @else
                                                    <div class="col-md-4">
                                                        <h5>No image found.</h5>
                                                    </div>
                                                @endif
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
                                    <div class="row m-t-10 d-flex align-items-center">
                                        <div class="col-md-2">
                                            <label class="required">Master Base Price</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="base_price" value="{{$single_master_product_info->base_price ?? ''}}">
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

                                                                            @if(is_array(json_decode($single_master_product_info->features)) && count(json_decode($single_master_product_info->features)) > 0)
                                                                                @foreach(json_decode($single_master_product_info->features) as $features)
                                                                                    @if(explode('/',$features->option_id)[0] == $option->option_id)
                                                                                        <option value="{{$option->option_id}}/{{$data->name}}/{{$option->name}}" selected>{{$option->name}}</option>
                                                                                        @php
                                                                                            $temp = 1;
                                                                                        @endphp
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
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
                                    <div class="form-group row m-t-40">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary draft-add-btn waves-effect waves-light">
                                                <b>Update</b>
                                            </button>
                                        </div>
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
            var category_id = $('#child_cat_'+id).val();
            console.log(category_id);
            $.ajax({
                type: "post",
                url: "{{url('onbuy/ajax-category-child-list')}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    "category_id": category_id
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

        $(document).on("click",function () {
            $("#all_category_div").lastChild();
        });

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

@endsection
