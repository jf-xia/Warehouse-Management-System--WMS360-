@extends('master')
@section('title')
    Shopify |  Active Product | Edit Active Product | WMS360
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
                <div class="wms-breadcrumb-middle">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">Active Product</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Shopify Product</li>
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
                                  action={{url('shopify/catalogue/update/'.$product_draft->id)}} method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label for="validationDefault01"
                                           class="col-md-2 col-form-label required">Title</label>
                                    <div class="col-md-10 wow pulse">
                                        <input id="title" type="text"
                                               class="form-control @error('name') is-invalid @enderror" name="title"
                                               maxlength="80" value="{{$product_draft->title}}" onkeyup="Count();"
                                               required autocomplete="name" autofocus>
                                        <span id="display" style="float: right;"></span>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="category" class="col-md-2 col-form-label required">Select Account</label>
                                    <div class="col-md-10">
                                        <select id="account_name" class="form-control select2 @error('account_name') is-invalid @enderror" multiple="multiple" name="account_name[]" value="{{ old('account_name') }}" required autocomplete="account_name" autofocus>
                                            @if(isset($select_account))
                                                <option selected value="{{$select_account->id}}">{{$select_account->account_name}}</option>
                                            @endif
                                        </select>
                                        @error('account_name')
                                        <span class="invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 row">
                                    <div class="button-group col-md-4 m-b-20">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle m-r-5 form-control" data-toggle="dropdown"><span class="caret">Collection</span>
                                        </button>
                                        <select class="form-control select2" name="collections[]" multiple>
                                            @if(sizeof($all_collection) != 0)
                                            @foreach($all_collection as $collection)
                                                <?php
                                                $temp = '';
                                                ?>
                                                @if(!empty($collection_id))
                                                @foreach($collection_id as $selected_collection)
                                                    @php
                                                        $selected_collection_info = explode('/',$selected_collection);
                                                    @endphp
                                                    @if($collection->shopify_collection_id == $selected_collection_info[1])
                                                        <option value="{{$collection->shopify_collection_id}}" selected>{{$collection->category_name}}</option>
{{--                                                    @else--}}
{{--                                                        <option value="{{$collection->shopify_collection_id}}">{{$collection->category_name}}</option>--}}
                                                        <?php
                                                        $temp = 1;
                                                        ?>
                                                    @endif
                                                @endforeach
                                                    @endif
                                                    @if($temp == null)
                                                        <option value="{{$collection->shopify_collection_id}}">{{$collection->category_name}}</option>
                                                    @endif
                                            @endforeach
                                            @endif

                                        </select>
                                    </div>
                                    <div class="button-group col-md-4 m-b-20">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle m-r-5 form-control" data-toggle="dropdown"><span class="caret">Product Status</span>
                                        </button>
                                        <select class="form-control select2" name="status">
                                            @if($product_draft->status == 'active')
                                                <option value="active"selected="selected">Active</option>
                                                <option value="draft">Draft</option>
                                            @else
                                                <option value="active">Active</option>
                                                <option value="draft" selected="selected">Draft</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="button-group col-md-4 m-b-20">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle m-r-5 form-control" data-toggle="dropdown"><span class="caret">Tags</span>
                                        </button>
                                        <select class="form-control select2 js-example-tokenizer" multiple="multiple" name="tags[]">

                                            @foreach($all_tags as $tag)
                                                <?php
                                                $temp = 0;
                                                ?>
                                                @foreach($tags as $single_tag)
                                                    @if($tag->tag_name == $single_tag)
                                                        <option value="{{$tag->tag_name}}" selected>{{$tag->tag_name}}</option>
                                                    <?php
                                                    $temp = 1;
                                                    ?>
                                                    @endif
                                                @endforeach
                                                    @if($temp == null)
                                                        <option value="{{$tag->tag_name}}">{{$tag->tag_name}}</option>
                                                    @endif
                                            @endforeach
                                        </select>
                                    </div>
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
                                                               value="">
                                                        <section>
                                                            <ul class="funcs sortable grid" id="image_preview">
                                                                @foreach($product_image as $images)
                                                                    <span class="pip">
                                                                <span class="remove drag_drop_remove_btn"
                                                                      id="{{$images['src']}}"
                                                                      onclick="removeExistingImage(this)">&#10060;</span>
                                                                <li id="{{$images['src']}}">
                                                                    <img src="{{$images['src']}}"
                                                                         id="{{$images['src']}}"
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
        $(".js-example-tokenizer").select2({
            tags: true,
            tokenSeparators: [',', ' ']
        });

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




        // image function here start---------------

        function imageDraggable() {
            // $('input#image_update_check').prop('checked',true);
            var h = [];
            $(".ebay-image-wrap li").each(function() {  h.push($(this).find('img').attr('id'));  });
            $('#sortable_image').val(h);
            var check = confirm('Are you sure to update ?');
            if(check){
                return true;
            }else{
                return false;
            }
        }
        //12 variation Drag drop image
        //Click to enlarge image modal preview
        $(function () {
            $('.md-trigger').on('click', function() {
                $('.md-modal').addClass('md-show');
            });
            $('.md-close').on('click', function() {
                $('.md-modal').removeClass('md-show');
            });
        });

        $('div.drag-drop-image:first').on('click', function(){
            if($(this).is(':first-child')) {
                $('.addPhotoBtnDiv input').remove();
            }
        })

        var notexistfirstDefaultImage = $('<div class="img-upload-main-content">'+
            '<div class="img-content-wrap">'+
            '<div class="addPhotoBtnDiv">'+
            '<p class="btn-text">Add photos</p>'+
            '<input type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control" accept="/image" onchange="preview_image();" multiple>'+
            '</div>'+
            '<p class="photo-req-txt">Add up to 12 photos. We do not allow photos with extra borders, text or artwork.</p>'+
            '</div>'+
            '</div>');

        var imageList = $('ul.ebay-image-wrap li.drag-drop-image').length;
        if(imageList == 0){
            $('#counter').text('We recommend adding 3 more photos');
            $('.showimagediv').html(notexistfirstDefaultImage).show();
            $('.md-trigger, .prev, .next').hide();
            $('.main_image_show').hover(function(){
                $('.md-trigger, .prev, .next').hide();
            });
        }else{
            var firstDefaultImageSrc = $('li .drag_drop_image:first').attr('src');
            var firstDefaultImage = $('<img />', {src : firstDefaultImageSrc,'class': 'fullImage'});
            $('.showimagediv').html(firstDefaultImage).show();
        }

        if(imageList == 1){
            $('#counter').text('We recommend adding 2 more photos');
        }else if(imageList == 2){
            $('#counter').text('We recommend adding 1 more photo');
        }else if(imageList == 3){
            $('#counter').text('Add up to 9 more photos');
        }else if(imageList == 4){
            $('#counter').text('Add up to 8 more photos');
        }else if(imageList == 5){
            $('#counter').text('Add up to 7 more photos');
        }else if(imageList == 6){
            $('#counter').text('Add up to 6 more photos');
        }else if(imageList == 7){
            $('#counter').text('Add up to 5 more photos');
        }else if(imageList == 8){
            $('#counter').text('Add up to 4 more photos');
        }else if(imageList == 9){
            $('#counter').text('Add up to 3 more photos');
        }else if(imageList == 10){
            $('#counter').text('Add up to 2 more photos');
        }else if(imageList == 11){
            $('#counter').text('Add up to 1 more photo');
        }else if(imageList == 12){
            $('#counter').text('Photo limit reached');
        }
        $('#default_counter').text(' (' + imageList + ')');
        $('#modal_counter').text(imageList + (imageList === 1 ? ' image':' images'));// Modal inside image counter
        // Set starting index.
        // var index = imageList.index($('.active'));
        // $('#counter').text((index + 1) + ' of ' + imageList.length);
        // console.log($('#counter').text((index + 1) + ' of ' + imageList.length));
        // $('.after').on('click', function () {
        //     var currentImg = $('.active');
        //     var nextImg = currentImg.next();
        //     if (nextImg.length) {
        //         currentImg.removeClass('active').css('z-index', -10);
        //         nextImg.addClass('active').css('z-index', 10);
        //         // Find the index of the image.
        //         var index = imageList.index(nextImg);
        //         $('#counter').text((index + 1) + ' of ' + imageList.length);
        //         console.log($('#counter').text((index + 1) + ' of ' + imageList.length));
        //     }
        // });

        // $('.before').on('click', function () {
        //     var currentImg = $('.active');
        //     var prevImg = currentImg.prev();
        //     if (prevImg.length) {
        //         currentImg.removeClass('active').css('z-index', -10);
        //         prevImg.addClass('active').css('z-index', 10);
        //         // Find the index of the image.
        //         var index = imageList.index(prevImg);
        //         $('#counter').text((index + 1) + ' of ' + imageList.length);
        //     }
        // });

        //Small image on text show
        $(".drag_drop_image").hover(function () {
            $(this).next().removeClass('hide');
        }, function () {
            $(this).next().addClass('hide');
        });

        //Next and Prev button show on Big image
        $('.main_image_show').hover(function(){
            $('.prev, .next, .md-trigger').removeClass('hide');
        },  function () {
            $('.prev, .next, .md-trigger').addClass('hide');
        });

        //If keep cursor on next and previous button then click to enlarge button will disappear
        $('.prev, .next').hover(function(){
            $('.md-trigger').addClass('hide');
        }, function(){
            $('.md-trigger').removeClass('hide');
        });


        // By default first image show left side image content
        // var firstDefaultImageSrc = $('li .drag_drop_image:first').attr('src');
        // var firstDefaultImage = $('<img />', {src : firstDefaultImageSrc,'class': 'fullImage'});
        // $('.showimagediv').html(firstDefaultImage).show();

        $('.drag_drop_image').click(function(){
            $('.drag_drop_image').removeClass('clicked');
            $(this).addClass('clicked');
            var img = $('<img />', {src : this.src,'class': 'fullImage'});
            $('.showimagediv').html(img).show();
        });

        $('.next,.then').click(function(){
            if(!$(".clicked").is(".drag_drop_image:last")){
                var $first = $('li.drag-drop-image:first', 'ul.ebay-image-wrap'),
                    $last = $('li.drag-drop-image:last', 'ul.ebay-image-wrap');
                var $next, $selected = $(".clicked");
                $next = $selected.next('li.drag-drop-image').length ? $selected.next('li.drag-drop-image') : $first;

                $selected.removeClass("clicked");
                $next.addClass('clicked');

                var imgSrc = $next.find('img').attr('src');
                var img = $next.find('img');
                var img = $('<img />', {src : imgSrc,'class': 'fullImage'});
                console.log($next.find('img').attr('src'));
                $('.showimagediv').html(img).show();
            }
        });
        $('.prev,.previous').click(function(){
            if(!$(".clicked").is(".drag_drop_image:first")){
                var $first = $('li.drag-drop-image:first', 'ul.ebay-image-wrap'),
                    $last = $('li.drag-drop-image:last', 'ul.ebay-image-wrap');
                var $prev, $selected = $(".clicked");

                $prev = $selected.prev('li.drag-drop-image').length ? $selected.prev('li.drag-drop-image') : $last;
                $selected.removeClass("clicked");
                $prev.addClass('clicked');

                var imgSrc = $prev.find('img').attr('src');
                var img = $prev.find('img');
                var img = $('<img />', {src : imgSrc,'class': 'fullImage'});
                console.log($prev.find('img').attr('src'));
                $('.showimagediv').html(img).show();
            }
        });


        $('.ebay-image-upload:first').closest('div').removeClass('no-img-content');
        $('li.drag-drop-image img:first').addClass('clicked');
        $('li.drag-drop-image p').text('Drag to rearrange');
        // $('li.drag-drop-image span.main_photo:first').text('Main Photo');
        //$('li.drag-drop-image span.main_photo:gt(0)').hide();
        var imgList = $('li.drag-drop-image').length;
        console.log(imgList + ' Image list');
        //By default remove attribute disabled
        var firstRemoveAttribute = $('.add-photos-content input:first').attr('disabled');
        $('.add-photos-content input:first').removeAttr(firstRemoveAttribute);
        $('.add-photos-content .inner-add-sign:first,input:first,.inner-add-photo:first').css('opacity', '100');


        // Remove image list
        function removeLi(elem){
            $(elem).parent('li').remove();
            console.log($(elem).parent('li').remove());
            $('input#image_update_check').prop('checked', true);
            $("ul.ebay-image-wrap:last").append('<div class="drag-drop-image add-photos-content no-img-content">'+
                '<p class="inner-add-sign">&#43;</p>'+
                '<input type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control ebay-image-upload" accept="/image" onchange="preview_image();" multiple disabled>'+
                '<p class="inner-add-photo">Add Photos</p>'+
                '</div>');
            $('.add-photos-content input:first').removeAttr('disabled');
            $('p.inner-add-sign:first').css('opacity', '100');
            $('p.inner-add-photo:first').css('opacity', '100');

            $('li.drag-drop-image img:first').addClass('clicked');
            $('li.drag-drop-image p').text('Drag to rearrange');
            // $('li.drag-drop-image span.main_photo:first').text('Main Photo');
            //$('li.drag-drop-image span.main_photo:gt(0)').hide();

            var firstDefaultImageSrc = $('li .drag_drop_image:first').attr('src');
            var firstDefaultImage = $('<img />', {src : firstDefaultImageSrc,'class': 'fullImage'});
            var notexistfirstDefaultImage = $('<div class="img-upload-main-content">'+
                '<div class="img-content-wrap">'+
                '<div class="addPhotoBtnDiv">'+
                '<p class="btn-text">Add photos</p>'+
                '<input type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control" accept="/image" onchange="preview_image();" multiple>'+
                '</div>'+
                '<p class="photo-req-txt">Add up to 12 photos. We do not allow photos with extra borders, text or artwork.</p>'+
                '</div>'+
                '</div>');
            $('.showimagediv').html(firstDefaultImage).show();

            if(firstDefaultImageSrc == null){
                $('.showimagediv').html(notexistfirstDefaultImage).show();
                $('.md-trigger, .prev, .next').hide();
                $('.main_image_show').hover(function(){
                    $('.md-trigger, .prev, .next').hide();
                });
            }else{
                $('.showimagediv').html(firstDefaultImage).show();
            }

            $('div.drag-drop-image:first').on('click', function(){
                if($(this).is(':first-child')) {
                    $('.addPhotoBtnDiv input').remove();
                }
            })

            $('.ebay-image-upload:first').closest('div').removeClass('no-img-content');

            // $(function(){
            //     $('div.drag-drop-image:first').on("click", function () {
            //         $('.addPhotoBtnDiv input').addClass('hide');
            //         setTimeout(RemoveClass, 25000);
            //     });
            //     function RemoveClass() {
            //         $('.addPhotoBtnDiv input').RemoveClass('hide');
            //     }
            // });

            var imageList = $('ul.ebay-image-wrap li.drag-drop-image').length;
            if(imageList == 0){
                $('#counter').text('We recommend adding 3 more photos');
            }else if(imageList == 1){
                $('#counter').text('We recommend adding 2 more photos');
            }else if(imageList == 2){
                $('#counter').text('We recommend adding 1 more photo');
            }else if(imageList == 3){
                $('#counter').text('Add up to 9 more photos');
            }else if(imageList == 4){
                $('#counter').text('Add up to 8 more photos');
            }else if(imageList == 5){
                $('#counter').text('Add up to 7 more photos');
            }else if(imageList == 6){
                $('#counter').text('Add up to 6 more photos');
            }else if(imageList == 7){
                $('#counter').text('Add up to 5 more photos');
            }else if(imageList == 8){
                $('#counter').text('Add up to 4 more photos');
            }else if(imageList == 9){
                $('#counter').text('Add up to 3 more photos');
            }else if(imageList == 10){
                $('#counter').text('Add up to 2 more photos');
            }else if(imageList == 11){
                $('#counter').text('Add up to 1 more photo');
            }else if(imageList == 12){
                $('#counter').text('Photo limit reached');
            }
            $('#default_counter').text(' (' + imageList + ')');
            $('#modal_counter').text(imageList + (imageList === 1 ? ' image':' images'));

            if(imageList == 1){
                $('.prev, .next, .previous, .then').hide();
            }

            var errorIcon = $('a.image_dimension').length;
            if(errorIcon == 0){
                $('button.draftEdit').attr('disabled', false);
            }

        }


        function preview_image(profileId){
            var total_file=document.getElementById("uploadImage").files.length;
            var file_name = document.getElementById("uploadImage").files;
            var fileUpload = document.getElementById("uploadImage");
            var imageList = $('ul.ebay-image-wrap li.drag-drop-image').length;
            $('input#image_update_check').prop('checked', true);
            if(total_file+imageList >= 13){
                Swal.fire('Oops.. Photo limit exceeded','You have exceeded the total amount of photos allowed. Only the first 12 photos have been uploaded','warning');
            }
            var temp = '';
            for(var i=0;i<total_file;i++){
                var reader = new FileReader();
                var file = file_name[i];
                (function(file){
                    console.log(file);
                    reader.onload = function(event) {
                        var image = new Image();
                        image.src = event.target.result;
                        image.onload = function (i) {
                            var height = this.height;
                            var width = this.width;
                            var t = file.type;
                            var n = file.name;
                            var s = ~~(file.size/1024) +'KB';
                            var errorIcon = '';
                            if(height < 500){
                                errorIcon += '<a class="image_dimension" title="error"></a>'+
                                    '<div class="image_dimension_error_show hide">'+
                                    '<span><b>Photo quality issues :</b></span><br>'+
                                    '<span>"Upload high resolution photos that are at least 500 pixels on the longest side. If you are uploading a photo from your smartphone, select the medium or large photo size option."</span>'+
                                    '</div>'
                                $('button.draftEdit').click(function(){
                                    var iconError = $('a.image_dimension').length;
                                    if(iconError > 0){
                                        $(this).attr('disabled','disabled');
                                        Swal.fire('Oops.. Photo quality error issue!!','Upload high resolution photos that are at least 500 pixels on the longest side. If you are uploading a photo from your smartphone, select the medium or large photo size option. It looks like there is a problem with this listing.','warning');
                                    }
                                });
                            } // if close height

                            $('a.image_dimension').hover(function(){ //each error button hover
                                $(this).next().removeClass('hide');
                            }, function(){
                                $(this).next().addClass('hide');
                            });

                            $('<li class="drag-drop-image">'+ // After uploading image
                                '<a class="cross-icon bg-white border-0 btn-outline-light" id="'+file.name+'" onclick="removeLi(this)">&#10060;</a>'+
                                '<input type="hidden" id="image" name="image[]" value="'+file.name+'">'+
                                '<span class="main_photo"></span>'+
                                '<img class="drag_drop_image" src="'+event.target.result+'"  alt="">'+
                                '<p class="drag_and_drop hide"></p>'+
                                errorIcon+
                                '<input type="hidden" name="newUploadImage['+file.name+']" value="'+event.target.result+'">'+
                                '</li>').insertBefore('.add-photos-content:first');

                            $('div.add-photos-content:last').remove(); // Removing last div

                            var imageList = $('ul.ebay-image-wrap li.drag-drop-image').length;
                            console.log('After uploading image = ' +imageList + ' images');
                            if(imageList == 0){
                                $('#counter').text('We recommend adding 3 more photos');
                            }else if(imageList == 1){
                                $('#counter').text('We recommend adding 2 more photos');
                            }else if(imageList == 2){
                                $('#counter').text('We recommend adding 1 more photo');
                            }else if(imageList == 3){
                                $('#counter').text('Add up to 9 more photos');
                            }else if(imageList == 4){
                                $('#counter').text('Add up to 8 more photos');
                            }else if(imageList == 5){
                                $('#counter').text('Add up to 7 more photos');
                            }else if(imageList == 6){
                                $('#counter').text('Add up to 6 more photos');
                            }else if(imageList == 7){
                                $('#counter').text('Add up to 5 more photos');
                            }else if(imageList == 8){
                                $('#counter').text('Add up to 4 more photos');
                            }else if(imageList == 9){
                                $('#counter').text('Add up to 3 more photos');
                            }else if(imageList == 10){
                                $('#counter').text('Add up to 2 more photos');
                            }else if(imageList == 11){
                                $('#counter').text('Add up to 1 more photo');
                            }else if(imageList == 12){
                                $('#counter').text('Photo limit reached');
                            }
                            $('#default_counter').text(' (' + imageList + ')');
                            $('#modal_counter').text(imageList + (imageList === 1 ? ' image':' images'));

                            // if(imageList >= 13){
                            //     Swal.fire('Oops.. Photo limit reached','You have uploaded 12 photos, now you are not allowed to upload more than 12 photos','warning');
                            // }

                            $('li.drag-drop-image p:last').text('Drag to rearrange');
                            // $('li.drag-drop-image span.main_photo:first').text('Main Photo');

                            // $('img.drag_drop_image:last').addClass('clicked'); //By default last image active show

                            var $afterUploadLastImgView = $('img.drag_drop_image:last').attr('src');
                            var $img = $('<img />', {src : $afterUploadLastImgView,'class': 'fullImage'});
                            $('.showimagediv').html($img).show();

                            $('.drag_drop_image').click(function(){
                                $('.drag_drop_image').removeClass('clicked');
                                $(this).addClass('clicked');
                                var img = $('<img />', {src : this.src,'class': 'fullImage'});
                                $('.showimagediv').html(img).show();
                            });

                            $(".drag_drop_image").hover(function () {
                                $(this).next().removeClass('hide');
                            }, function () {
                                $(this).next().addClass('hide');
                            });

                            $('.prev, .next').hover(function(){

                                $('.md-trigger').addClass('hide');
                            }, function(){
                                $('.md-trigger').removeClass('hide');
                            });

                            $('.main_image_show').hover(function(){
                                $('.prev,.next,.md-trigger,.before,.after,.then,.previous').removeAttr('style');
                            });

                        };



                    } // function file close

                    reader.readAsDataURL(file);
                })(file);

            } // for loop close

        } // preview_image close

        //End 12 variation Drag drop image

    </script>


@endsection
