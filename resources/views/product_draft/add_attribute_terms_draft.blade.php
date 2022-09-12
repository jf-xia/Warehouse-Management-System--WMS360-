@extends('master')

@section('title')
  Catalogue | Add Terms to Catalogue | WMS360
@endsection
@section('content')
    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.css')}}"  />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="wms-breadcrumb-middle">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">Active Catalogue</li>
                            <li class="breadcrumb-item active" aria-current="page">Add Terms to Catalogue</li>
                        </ol>
                    </div>
                </div>
                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box shadow">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                            <form role="form" class="vendor-form mobile-responsive" action= {{url('save-additional-terms-draft')}} method="post">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-2 d-flex align-items-center">
                                        <label for="low_quantity" class=" col-md-form-label required">Catalogue ID</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="product_draft_id" value="{{$id ? $id : old('product_draft_id')}}" id="product_draft_id" placeholder="" required readonly>
                                    </div>
                                </div>
                                <div class="row form-group select_variation_att">
                                    <div class="col-md-10">
                                        <h6 class="font-18 required_attributes"> Select variation from below attributes </h6>
                                    </div>
                                </div>
                                <div class="row form-group product-desn-top">

                                    <div class="col-md-12">
                                        <!-- test here start -->
                                        <div class="nicescroll">

                                            <div class="row" id="sortableAttribute" style="width:100%;">
                                            <div class="input-group col-md-12 col-sm-12 m-b-20 all-attribute-container">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle form-control" data-toggle="dropdown">  <span class="caret">Variation</span>
                                                    </button>
                                                    <!-- <div class="input-group-append">
                                                        <button class="btn btn-outline-info" type="button" onclick="addAttributeModal('attribute','')"><i class="fa fa-plus"></i></button>
                                                    </div> -->

                                                    @if($attribute_info != null && count($attribute_info) > 0)
                                                    <select class="form-control select2 select2-hidden-accessible" id="" multiple @if($productVariationExist) disabled @endif>

                                                            @if($attribute_terms != null && count($attribute_terms) > 0)
                                                                <option value="">Select Attribute</option>
                                                                @foreach($existAttr as $attr_id => $attr_name)
                                                                    <option value="{{$attr_id ?? ''}}" selected="selected">{{$attr_name ?? ''}}</option>
                                                                @endforeach
                                                                @if(!$productVariationExist)
                                                                    @foreach($attribute_terms as $attribute)
                                                                        @if(!isset($existAttr[$attribute->id]))
                                                                            <option value="{{$attribute->id ?? ''}}">{{$attribute->attribute_name ?? ''}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                                <!-- @foreach($attribute_terms as $attribute)
                                                                    @php
                                                                        $temp = null;
                                                                    @endphp
                                                                    @foreach($attribute_info as $attribute_id => $attribute_name_array)
                                                                        @foreach($attribute_name_array as $attribute_name => $attribute_terms_array)
                                                                            @if($attribute_id == $attribute->id)
                                                                                <option value="{{$attribute_id ?? ''}}" selected="selected">{{$attribute_name ?? ''}}</option>
                                                                                @php
                                                                                    $temp = 1;
                                                                                @endphp
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                    @if($temp == null)
                                                                        <option value="{{$attribute->id ?? ''}}">{{$attribute->attribute_name ?? ''}}</option>
                                                                    @endif
                                                                @endforeach -->

                                                                <!-- @foreach($attribute_terms as $attribute)
                                                                    @php
                                                                        $temp = null;
                                                                    @endphp
                                                                    @foreach($attribute_info as $attribute_id => $attribute_name_array)
                                                                        @foreach($attribute_name_array as $attribute_name => $attribute_terms_array)
                                                                            @if($attribute_id == $attribute->id)
                                                                                <option value="{{$attribute->id ?? ''}}" selected>{{$attribute->attribute_name ?? ''}}</option>
                                                                                @php
                                                                                    $temp = 1;
                                                                                @endphp
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                    @if($temp == null)
                                                                        <option value="{{$attribute->id ?? ''}}">{{$attribute->attribute_name ?? ''}}</option>
                                                                    @endif
                                                                @endforeach -->
                                                            @endif

                                                    @else
                                                    <select class="form-control select2 select2-hidden-accessible" id="" multiple>
                                                        @if($attribute_terms != null && count($attribute_terms) > 0)
                                                            <option value="">Select Attribute</option>
                                                            @foreach($attribute_terms as $attribute)
                                                                <option value="{{$attribute->id ?? ''}}">{{$attribute->attribute_name ?? ''}}</option>
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                    </select>
                                                </div>
                                            </div>
                                            @if($attribute_info != null && count($attribute_info) > 0)

                                                @foreach($attribute_info as $attribute_id => $attribute_name_array)
                                                    @foreach($attribute_name_array as $attribute_name => $attribute_terms_array)
                                                        <div class="input-group col-md-4 col-sm-6 m-b-20" id="attribute-terms-container-{{$attribute_id}}">
                                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle form-control" data-toggle="dropdown">
                                                                <span class="caret"> {{$attribute_name}}</span>
                                                            </button>
                                                            <select class="form-control variation-term-select2" name="terms[{{$attribute_id}}][]" id="attribute-terms-option-{{$attribute_id}}" multiple="multiple">
                                                                @if(count($attribute_terms) > 0)
                                                                    @foreach($attribute_terms as $all_terms)
                                                                        @if(($all_terms->attribute_name == $attribute_name)  && count($all_terms->attributes_terms) > 0)
                                                                            @if(is_array($attribute_terms_array))
                                                                                @foreach($attribute_terms_array as $attribute_term)
                                                                                    @foreach($all_terms->attributes_terms as $terms)
                                                                                        @if($terms->terms_name == $attribute_term['attribute_term_name'])
                                                                                            <option value="{{$terms->id ?? ''}}" selected="selected">{{$terms->terms_name ?? ''}}</option>
                                                                                        @else
                                                                                            <option value="{{$terms->id ?? ''}}">{{$terms->terms_name ?? ''}}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                @endforeach
                                                                                @else
                                                                                    @foreach($all_terms->attributes_terms as $terms)
                                                                                        @if($terms->terms_name == $attribute_terms_array)
                                                                                            <option value="{{$terms->id ?? ''}}" selected="selected">{{$terms->terms_name ?? ''}}</option>
                                                                                        @else
                                                                                            <option value="{{$terms->id ?? ''}}">{{$terms->terms_name ?? ''}}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                @endif
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    @endforeach
                                                @endforeach


                                                    @if(count($attribute_terms) > 0)
                                                        @foreach($attribute_terms as $all_terms)
                                                            @if(!isset($existAttr[$all_terms->id]))
                                                            <div class="input-group col-md-4 col-sm-6 m-b-20" id="attribute-terms-container-{{$all_terms->id}}" style='display:none;'>
                                                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle form-control" data-toggle="dropdown">
                                                                    <span class="caret"> {{$all_terms->attribute_name}}</span>
                                                                </button>
                                                                <select class="form-control select2" name="terms[{{$all_terms->id}}][]" id="attribute-terms-option-{{$all_terms->id}}" multiple="multiple">

                                                                    @foreach($all_terms->attributes_terms as $terms)

                                                                            <option value="{{$terms->id ?? ''}}">{{$terms->terms_name ?? ''}}</option>

                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                            @endif
                                                        @endforeach
                                                    @endif


                                            @else
                                                @if(count($attribute_terms) > 0)
                                                    @foreach($attribute_terms as $attribute_term)

                                                        @php
                                                            $at_id = $attribute_term->id;
                                                            $at_name = $attribute_term->attribute_name;
                                                        @endphp
                                                        @if(isset($attribute_info[$at_id][$at_name]))
                                                            <div class="input-group col-md-4 col-sm-6 m-b-20" id="attribute-terms-container-{{$attribute_term->id}}">
                                                        @else
                                                            <div class="input-group col-md-4 col-sm-6 m-b-20" id="attribute-terms-container-{{$attribute_term->id}}" style='display:none;'>
                                                        @endif
                                                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle form-control" data-toggle="dropdown">  <span class="caret"> {{$attribute_term->attribute_name}} ({{count($attribute_term->attributes_terms)}})</span>
                                                                </button>
                                                                <!-- <div class="input-group-append">
                                                                    <button class="btn btn-outline-primary" type="button" onclick="addAttributeModal('attribute_terms',{{$attribute_term->id}})"><i class="fa fa-plus"></i></button>
                                                                </div> -->
                                                                <select class="form-control select2" name="terms[{{$attribute_term->id}}][]" id="attribute-terms-option-{{$attribute_term->id}}" multiple="multiple">

                                                                        @foreach($attribute_term->attributes_terms as $terms)
                                                                            <?php
                                                                                $temp = '';
                                                                                ?>
                                                                                @isset($attribute_info[$terms->attribute_id][\App\Attribute::find($terms->attribute_id)->attribute_name])
                                                                                    @foreach($attribute_info[$terms->attribute_id][\App\Attribute::find($terms->attribute_id)->attribute_name] as $attributes)
                                                                                        @if($terms->id == $attributes["attribute_term_id"])
                                                                                            <option value="{{$terms->id ?? ''}}" selected="selected">{{$terms->terms_name ?? ''}}</option>

                                                                                                <?php
                                                                                                $temp = 1;
                                                                                                ?>
                                                                                        @endif
                                                                                @endforeach
                                                                                @endisset
                                                                                    @if($temp == null)
                                                                                        <option value="{{$terms->id ?? ''}}">{{$terms->terms_name ?? ''}}</option>
                                                                                    @endif
                                                                            @endforeach
                                                                </select>
                                                            </div>
                                                    @endforeach
                                                @endif
                                            @endif
                                            </div>
                                            <!-- test here end -->

                                           <!-- @if(count($attribute_terms) > 0)
                                                @foreach($attribute_terms as $attribute_term)
                                                    @if(!empty( $attribute_term->attributes_terms ))
                                                        <div class="button-group col-md-3 col-sm-6 m-b-20">
                                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle m-r-5 form-control" data-toggle="dropdown">  <span class="caret"> {{$attribute_term->attribute_name ?? ''}} ({{count($attribute_term->attributes_terms)}})</span>
                                                            </button>
                                                            <select class="form-control select2" name="terms[{{$attribute_term->id}}][]" multiple="multiple">
                                                                @foreach($attribute_term->attributes_terms as $terms)
                                                                    <?php
                                                                    $temp = '';
                                                                    ?>
                                                                    @isset($product_attribute[$terms->attribute_id][\App\Attribute::find($terms->attribute_id)->attribute_name])
                                                                        @foreach($product_attribute[$terms->attribute_id][\App\Attribute::find($terms->attribute_id)->attribute_name] as $attributes)
                                                                            @if($terms->id == $attributes["attribute_term_id"])
                                                                                <option value="{{$terms->id ?? ''}}" selected="selected">{{$terms->terms_name ?? ''}}</option>
                                                                                <h1>{{$terms->terms_name ?? ''}}</h1>
                                                                                    <?php
                                                                                    $temp = 1;
                                                                                    ?>
                                                                            @endif
                                                                       @endforeach
                                                                    @endisset
                                                                        @if($temp == null)
                                                                            <option value="{{$terms->id ?? ''}}">{{$terms->terms_name ?? ''}}</option>
                                                                        @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endif

                                                @endforeach
                                            @endif -->

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary draft-pro-btn waves-effect waves-light" style="margin-top:0px;">
                                            <b> Add </b>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>  <!-- card-box -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->

    <script>
        // $('.select2').select2();
        $("select").select2();
        $("select").on("select2:select", function (evt) {
        var element = evt.params.data.element;
        var $element = $(element);
        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
        });


        $(function(){
            var showClass = "draft-active";
            $("input").bind("checkval",function(){
                var label = $(this).prev("label");
                if(this.value !== ""){
                    label.addClass(showClass);
                } else {
                    label.removeClass(showClass);
                }
            }).trigger("checkval");

            $('#sortableAttribute').sortable({
                handle: 'button',
                cancel: ''
            }).disableSelection()
        });

        $('#sortableAttribute div.all-attribute-container .select2-hidden-accessible').select2({
            placeholder: 'Search for tags',
            // tags: true,
            multiple: true,
            tokenSeparators: [',', ' '],
            createTag: function (params) {
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                return {id: params.term, text: params.term, newTag: true};
            }
        })



        .on('change', function(e){
            // $(this).val() - array of tags in input

            var allTags = $(this).val();
            console.log(allTags)
            var newTags = [];
            $('#sortableAttribute > div').not('.all-attribute-container').each(function(){
                $(this).find('select.select2-hidden-accessible').attr('disabled', true)
                $(this).hide()
            })
            allTags.forEach(function (el) {
                console.log(allTags);
                $('#attribute-terms-container-'+el).find('select.select2-hidden-accessible').attr('disabled', false)
                $('#attribute-terms-container-'+el).show()
            });
        });
    </script>

@endsection
