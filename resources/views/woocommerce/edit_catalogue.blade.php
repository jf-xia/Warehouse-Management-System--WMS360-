@extends('master')
@section('title')
    WooCommerce |  Active Product | Edit Active Product | WMS360
@endsection
@section('content')
    {{--    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.css')}}"  />--}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300' rel='stylesheet' type='text/css'>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">{{$status_type}} Product</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit {{$status_type}} Product</li>
                        </ol>
                    </div>
                </div>

                <div class="row m-t-20">
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

                            <form role="form" class="vendor-form mobile-responsive"
                                  action={{url('woocommerce/catalogue/update/'.$product_draft->id)}} method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label for="validationDefault01"
                                           class="col-md-2 col-form-label required">Title</label>
                                    <div class="col-md-10 wow pulse">
                                        <input id="name" type="text"
                                               class="form-control @error('name') is-invalid @enderror" name="name"
                                               maxlength="80" value="{{$product_draft->name}}" onkeyup="Count();"
                                               required autocomplete="name" autofocus>
                                        <span id="display" style="float: right;"></span>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-4 mb-4">
                                    <div class="col-md-4 form-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle form-control"
                                                data-toggle="dropdown"><span class="caret">Category</span>
                                        </button>
                                        <select id="category_id"
                                                class="form-control select2 @error('category') is-invalid @enderror"
                                                multiple="multiple" name="category_id[]"
                                                value="{{ old('category_id') }}" required autocomplete="category_id"
                                                autofocus>
                                            @foreach($categories as $category)
                                                <?php
                                                $temp = '';
                                                ?>
                                                @foreach($product_draft->all_category as $edit_category)
                                                    @if($category->id == $edit_category->id)
                                                        <option value="{{$edit_category->id}}"
                                                                selected="selected">{{$edit_category->category_name}}</option>
                                                        <?php
                                                        $temp = 1;
                                                        ?>
                                                    @endif
                                                @endforeach
                                                @if($temp == null)
                                                    <option
                                                        value="{{$category->id}}">{{$category->category_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                        @error('category')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror

                                    </div>
                                    @isset($not_variation_attribute)
                                        @foreach($not_variation_attribute as $not_variation)
                                            @if(array_key_exists($not_variation->id,($product_draft->not_attribute != null && is_array(unserialize($product_draft->not_attribute))) ? unserialize($product_draft->not_attribute) : []) == TRUE)
                                                <div class="col-md-4 form-group">
                                                    <button type="button"
                                                            class="btn btn-primary dropdown-toggle form-control"
                                                            data-toggle="dropdown"><span
                                                            class="caret">{{$not_variation->attribute_name}}</span>
                                                    </button>
                                                    <select id="brand_id"
                                                            class="form-control select2 @error('brand') is-invalid @enderror"
                                                            name="not_variation[{{$not_variation->id}}][]">
                                                        <option value="">
                                                            Select {{$not_variation->attribute_name}}</option>
                                                        @foreach($not_variation->woocommerce_attributes_terms as $terms)
                                                            @foreach(unserialize($product_draft->not_attribute) as $key => $value)
                                                                @if($key == $not_variation->id)
                                                                    @foreach($value as $ke => $val)
                                                                        @if($val[0]['attribute_term_name'] == $terms->terms_name)
                                                                            <option value="{{$terms->id}}"
                                                                                    selected>{{$terms->terms_name}} </option>
                                                                        @else
                                                                            <option
                                                                                value="{{$terms->id}}">{{$terms->terms_name}} </option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                    @error('role')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            @else
                                                <div class="col-md-4 form-group">
                                                    <button type="button"
                                                            class="btn btn-primary dropdown-toggle form-control"
                                                            data-toggle="dropdown"><span
                                                            class="caret">{{$not_variation->attribute_name}}</span>
                                                    </button>
                                                    <select id="brand_id"
                                                            class="form-control select2 @error('brand') is-invalid @enderror"
                                                            name="not_variation[{{$not_variation->id}}][]">
                                                        <option value="">
                                                            Select {{$not_variation->attribute_name}}</option>
                                                        @foreach($not_variation->woocommerce_attributes_terms as $terms)
                                                            <option
                                                                value="{{$terms->id}}">{{$terms->terms_name}} </option>
                                                        @endforeach
                                                    </select>
                                                    @error('role')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            @endif
                                        @endforeach
                                    @endisset
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row form-group">
                                            <div class="col-md-10">
                                                <label class="required_attributes">Description</label>
                                            </div>
                                        </div>
                                        <div class="form-group edit-draft-ckeditor">
                                            <div>
                                                <textarea
                                                    class="form-control @error('description') is-invalid @enderror"
                                                    id="messageArea" name="description" required
                                                    autocomplete="description"
                                                    autofocus>{!! $product_draft->description !!}</textarea>
                                            </div>
                                            @error('description')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header font-18">SKU</div>
                                    <div class="card-body">
                                        <div class="draft-wrap">
                                            <div class="wms-row">
                                                <div>
                                                    <label class="input-field-design" for="sku">Parent SKU</label>
                                                    <input type="text" data-parsley-maxlength="30" class="form-control @error('sku') is-invalid @enderror" name="sku" autocomplete="sku" autofocus id="sku" value="{{$product_draft->sku ?? ''}}" placeholder="">
                                                    @error('sku')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header font-18">Edit Price</div>
                                    <div class="card-body">
                                        <div class="draft-wrap">
                                            <div class="wms-row">

                                                <div class="">
                                                    <label class="draft-regular-price" for="regular_price">Regular
                                                        Price</label>
                                                    <input type="text" data-parsley-maxlength="30"
                                                           class="form-control @error('regular_price') is-invalid @enderror"
                                                           name="regular_price"
                                                           value="{{$product_draft->regular_price}}"
                                                           autocomplete="regular_price" autofocus id="regular_price"
                                                           placeholder="">
                                                    @error('regular_price')
                                                    <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>

                                                <div class="mt-xs-20">
                                                    <label class="draft-sales-price" for="sale_price">Sales
                                                        Price</label>
                                                    <input type="text" data-parsley-maxlength="30"
                                                           class="form-control @error('sale_price') is-invalid @enderror"
                                                           name="sale_price" value="{{$product_draft->sale_price}}"
                                                           autocomplete="sale_price" autofocus id="sale_price"
                                                           placeholder="">
                                                    @error('sale_price')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>

                                                <div class="mt-sm-20 mt-xs-20">
                                                    <label class="draft-cost-price" for="cost_price">Cost Price</label>
                                                    <input type="text" data-parsley-maxlength="30"
                                                           class="form-control @error('cost_price') is-invalid @enderror"
                                                           name="cost_price" value="{{$product_draft->cost_price}}"
                                                           autocomplete="cost_price" autofocus
                                                           id="cost_price" placeholder="">
                                                    @error('cost_price')
                                                    <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="wms-row">
                                                <div class="cat-device mt-sm-20 mt-xs-20">
                                                    <label class="draft-regular-price" for="rrp">RRP</label>
                                                    <input type="text" data-parsley-maxlength="30"
                                                           class="form-control @error('rrp') is-invalid @enderror"
                                                           name="rrp" value="{{$product_draft->rrp}}" autocomplete="rrp"
                                                           autofocus id="rrp" placeholder="">
                                                    @error('rrp')
                                                    <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mt-3">
                                    <div class="card-header font-18">Edit Item Specific</div>
                                    <div class="card-body">
                                        <div class="draft-wrap">
                                            <div class="wms-row">
                                                <div class="">
                                                    <label for="product_code" class="draft-product-code">Product
                                                        Code</label>
                                                    <input type="text" data-parsley-maxlength="30"
                                                           class="form-control @error('product_code') is-invalid @enderror"
                                                           name="product_code" value="{{$product_draft->product_code}}"
                                                           autocomplete="product_code" autofocus id="product_code"
                                                           placeholder="">
                                                    @error('product_code')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                                <div class="mt-xs-20">
                                                    <label for="color_code" class="draft-color-code">Color Code</label>
                                                    <input type="text" data-parsley-maxlength="30"
                                                           class="form-control @error('color_code') is-invalid @enderror"
                                                           name="color_code" value="{{$product_draft->color_code}}"
                                                           autocomplete="color_code" autofocus id="color_code"
                                                           placeholder="">
                                                    @error('color_code')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                                <div class="mt-sm-20 mt-xs-20">
                                                    <label for="low_quantity" class="draft-low-quantity">Low
                                                        Quantity</label>
                                                    <input type="text" data-parsley-maxlength="30"
                                                           class="form-control @error('low_quantity') is-invalid @enderror"
                                                           name="low_quantity" value="{{$product_draft->low_quantity}}"
                                                           autocomplete="low_quantity" autofocus id="low_quantity"
                                                           placeholder="">
                                                    @error('low_quantity')
                                                    <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                                <div class="cat-device mt-sm-20 mt-xs-20">
                                                    <label for="sku_short_code" class="draft-sku_short_code">SKU Short
                                                        Code</label>
                                                    <input type="text" data-parsley-maxlength="30" class="form-control"
                                                           name="sku_short_code" autocomplete="sku_short_code" autofocus
                                                           id="sku_short_code" placeholder="">
                                                </div>
                                                <div class="cat-device mt-sm-20 mt-xs-20">
                                                    <label for="color" class="draft-color">Color</label>
                                                    <input type="text" data-parsley-maxlength="30" class="form-control"
                                                           name="color" value="" autocomplete="color" autofocus
                                                           id="color" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mt-3">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" name="update_img_check" id="image_update_check"
                                                   value="1"> &nbsp; Do you want to update your image ?
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label for="image" class="col-form-label required"> Select
                                                    Image </label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="images"
                                                           name="images[]" onchange="preview_image();" multiple>
                                                    <input type="hidden" id="removeImageArray" name="removeImageArray[]"
                                                           value="">
                                                    <label class="custom-file-label" for="customFile">Choose
                                                        Image</label>
                                                </div>
                                                <div>
                                                    <div class="dragAndDropEditableImage">
                                                        <input type="hidden" id="existingImage" name="existingImage"
                                                               value="{{$image_as_string}}">
                                                        <input type="hidden" id="rmvExistingImage"
                                                               name="rmvExistingImage[]"
                                                               value="{{$product_draft->images}}">
                                                        <section>
                                                            <ul class="funcs sortable grid" id="image_preview">
                                                                @foreach(json_decode($product_draft->all_image_info) as $images)
                                                                    <span class="pip">
                                                                <span class="remove drag_drop_remove_btn"
                                                                      id="{{$images->image_url}}"
                                                                      onclick="removeExistingImage(this)">&#10060;</span>
                                                                <li id="{{$images->image_url}}">
                                                                    <img src="{{$images->image_url}}"
                                                                         id="{{$images->image_url}}"
                                                                         class="drag_drop_image">
                                                                </li>
                                                             </span>
                                                                @endforeach
                                                            </ul>
                                                        </section>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="sortable_image" id="sortable_image" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button id="submit" type="submit"
                                                class="btn btn-primary draft-add-btn waves-effect waves-light">
                                            <b> Update <i class=""></i></b>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>  <!-- card-box -->
                </div> <!-- end col -->
            </div><!-- end row -->
        </div> <!-- container -->
    </div> <!-- content page-->

    <!----- ckeditor summernote ------->
    <script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>

    <script>
        // Select Option Jquery
        $('.select2').select2();
        // placeholder label animation
        $('input').on('focusin', function () {
            $(this).parent().find('label').addClass('draft-active');
        });

        $('input').on('focusout', function () {
            if (!this.value) {
                $(this).parent().find('label').removeClass('draft-active');
            }
        });

        $(function () {
            var showClass = "draft-active";
            $("input").bind("checkval", function () {
                var label = $(this).prev("label");
                if (this.value !== "") {
                    label.addClass(showClass);
                } else {
                    label.removeClass(showClass);
                }
            }).trigger("checkval");
        });
        // placeholder label animation

        $(function () {
            $("#image_preview").sortable();
            $('button#sortimage').click(function () {
                console.log('found');
                // $("#image_preview").sortable('destroy');
            });
            $('input#image_update_check').click(function () {
                var h = [];
                $("#image_preview .pip").each(function () {
                    h.push($(this).find('img').attr('id'));
                });
                $('#sortable_image').val(h);
                console.log(h);
            })
        });

        function submitData() {
            var name = $('input[name=name]').val();
            var category_id = $('#category_id').val();
            var brand_id = $('select[name=brand_id]').val();
            var gender_id = $('select[name=gender_id]').val();
            var description = CKEDITOR.instances['messageArea'].getData();
            var short_description = $('textarea[name=short_description]').val();
            var regular_price = $('input[name=regular_price]').val();
            var sale_price = $('input[name=sale_price]').val();
            var cost_price = $('input[name=cost_price]').val();
            var product_code = $('input[name=product_code]').val();
            var color_code = $('input[name=color_code]').val();
            var low_quantity = $('input[name=low_quantity]').val();
            var update_img_check = 0;
            if ($('input#image_update_check').is(':checked')) {
                var update_img_check = $('input[name=image_update_check]').val();
            }

            sortArray = Zepto('.funcs').dragswap('toArray');
            $.ajax({
                type: 'POST',
                url: '{{url('woocommerce/catalogue/update/'.$product_draft->id).'?_token='.csrf_token()}}',
                data: {
                    '_method': 'POST',
                    'name': name,
                    'category_id': category_id,
                    'brand_id': brand_id,
                    'gender_id': gender_id,
                    'description': description,
                    'short_description': short_description,
                    'regular_price': regular_price,
                    'sale_price': sale_price,
                    'cost_price': cost_price,
                    'product_code': product_code,
                    'color_code': color_code,
                    'low_quantity': low_quantity,
                    'update_img_check': update_img_check,
                    'sortArray': sortArray
                },
                beforeSend: function () {
                    $('button i').addClass('fa fa-spinner fa-spin');
                },
                success: function (data) {
                    //window.location.href = "product-draft";
                    console.log(data);
                    console.log(data.valueOf());
                    $('button i').removeClass('fa fa-spinner fa-spin');
                    alert('Product updated successfully');
                },
                error: function (jqXHR, exception) {

                    console.log(data);
                }
            });
        }

        const toBase64 = files => new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(files);
            reader.onload = () => resolve(reader.result);
            reader.onerror = error => reject(error);
        });

        function preview_image() {
            var total_file = document.getElementById("images").files.length;
            var temp = '';
            for (var i = 0; i < total_file; i++) {
                console.log(event.target.files[i]);

                async function Main() {
                    const file = document.querySelector('#images').files[i];
                    console.log('******************' + await file.name);
                    temp = await toBase64(file);
                    $('#image_preview').append("<span class='pip'><span class='remove drag_drop_remove_btn'  onclick=removeImage(this)>&#10060;</span><li id='" + (await file.name).replace(/ /g, "-") + " " + await toBase64(file) + "' ><img src='" + await toBase64(file) + "' class='drag_drop_image'></li></span>");
                    sortArray = Zepto('.funcs').dragswap('toArray');
                    console.log(sortArray);
                    // $('#array').val(sortArray);
                    //document.getElementsByName("sortArray[]").val();
                }

                Main();
            }
            sortArray = Zepto('.funcs').dragswap('toArray');
            $('#array').val(sortArray);
        }

        var items = [];
        var rmvExistingImage = [];

        function removeImage(e) {
            items.push(e.id);
            console.log(items, items.length);
            $('#removeImageArray').val(items);
            $(e).parent('.pip').remove();
            sortArray = Zepto('.funcs').dragswap('toArray');
            //console.log(rmvExistingImage,rmvExistingImage.length);
            console.log(sortArray);
        }

        function removeExistingImage(e) {
            rmvExistingImage.push(e.id);
            $('#rmvExistingImage').val(rmvExistingImage);
            $(e).parent('.pip').remove();
            sortArray = Zepto('.funcs').dragswap('toArray');
            console.log(sortArray);
        }

        function Count() {
            var i = document.getElementById("name").value.length;
            document.getElementById("display").innerHTML = 'Character Remain: ' + (80 - i);
        }

    </script>
    <script src="{{asset('assets/js/zepto.min.js')}}"></script>
    <script src="{{asset('assets/js/zepto.dragswap.js')}}"></script>
    <script>
        // ckeditor summernote
        CKEDITOR.replace('messageArea',
            {
                customConfig: 'config.js',
                toolbar: 'simple'
            })

        $(document).on("click", ".copyTo", function () {
            let $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(this).text()).select();
            document.execCommand("copy");
            $temp.remove();
        });
        // End  ckeditor summernote

        window.onload = function () {
            var sortArray = [];
            // dropComplete();
            sortArray = Zepto('.funcs').dragswap('toArray');
            console.log(sortArray);
        };

        $(function () {

            Zepto('.sortable_exclude_dynamic').dragswap({
                element: 'li',
                dropAnimation: true,
                exclude: ['.correct', '.empty']
            });

            //      $('.sortable_exclude_dynamic').append(
            //          '<li id="item1">Item 1</li>'
            // +'<li id="item2">Item 2</li>'
            // +'<li id="item3" class="correct">Item 3</li>'
            //          +'<li id="item4">Item 4</li>'
            // +'<li id="item5" class="empty"></li>'
            // +'<li id="item6" class="correct">Item 6</li>'
            // +'<li id="item7" class="correct">Item 7</li>');

            Zepto('.sortable').dragswap({
                element: 'li',
                dropAnimation: true
            });

            Zepto('.funcs').dragswap({
                dropAnimation: false,
                dropComplete: function () {
                    sortArray = Zepto('.funcs').dragswap('toArray');
                    $('#arrayResults').html('[' + sortArray.join(',') + ']');
                    var sortJSON = Zepto('.funcs').dragswap('toJSON');
                    $('#jsonResults').html(sortJSON);
                    console.log(sortArray);
                }
            });
        });
    </script>


@endsection
