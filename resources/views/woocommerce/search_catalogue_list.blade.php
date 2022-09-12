
    @foreach($woocommerce_list as $list)
        @if(is_numeric($date) == TRUE)
        <tr class="hide-after-complete-{{$list->id}}">
            @if($status == 'draft')
                <td><input type="checkbox" class="checkBoxClass" id="customCheck{{$list->id}}" value="{{$list->id}}"></td>
            @else
            <td></td>
            @endif
            <td class="image" style="width: 6%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">

                <!--Start each row loader-->
                <div id="product_variation_loading{{$list->id}}" class="variation_load" style="display: none;"></div>
                <!--End each row loader-->

                @if(isset($list->single_image_info->image_url))
                    <a href="{{$list->single_image_info->image_url}}"  title="Click to expand" target="_blank"><img src="{{$list->single_image_info->image_url}}" class="thumb-md zoom" alt="WooCommerce-active-image"></a>
                @else
                    <img src="{{asset('assets/common-assets/no_image.jpg')}}" class="thumb-md zoom" alt="WooCommerce-active-image">
                @endif

            </td>
{{--            <td class="id" style="width: 6%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">--}}
            <td class="id" style="width: 6%; text-align: center !important;">
                <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                    <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$list->id}}</span>
                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                </div>
            </td>
            <td class="catalogue-name" style="width: 30%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">
                <a class="catalogue-link" href="https://www.topbrandoutlet.co.uk/wp-admin/post.php?post={{$list->id}}&action=edit" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit On Woocommerce">
                    {!! Str::limit(strip_tags($list->name),$limit = 100, $end = '...') !!}
                </a>
            </td>
            <?php
            $data = '';
            foreach ($list->all_category as $category){
                $data .= $category->category_name.',';
            }
            $total_sold = 0;
            foreach ($list->sold_variations as $variations){
                foreach ($variations->order_products_without_cancel_and_return as $order_products){
                    $total_sold += $order_products->sold;
                }
            }
            ?>
            <td class="category" style="cursor: pointer; text-align: center !important;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{rtrim($data,',')}}</td>
            <td class="rrp" style="cursor: pointer; text-align: center !important;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$list->rrp ?? ''}}</td>
            <td class="sold" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$total_sold ?? 0}}</td>
            <td class="stock" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$list->variations[0]->stock ?? 0}}</td>
            <td class="product" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$list->variations_count ?? 0}}</td>
            <td class="creator" style="width: 10% !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">
                @if(isset($list->user_info->name))
                <div class="wms-name-creator">
                    <div data-tip="on {{date('d-m-Y', strtotime($list->created_at))}}">
                        <strong class="@if($list->user_info->deleted_at)text-danger @else text-success @endif">{{$list->user_info->name ?? ''}}</strong>
                    </div>
                </div>
                @endif
            </td>
            <td class="modifier" style="width: 10% !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">
                @if(isset($list->modifier_info->name))
                    <div class="wms-name-modifier1">
                        <div data-tip="on {{date('d-m-Y', strtotime($list->updated_at))}}">
                            <strong class="@if($list->modifier_info->deleted_at)text-danger @else text-success @endif">{{$list->modifier_info->name ?? ''}}</strong>
                        </div>
                    </div>
                @elseif(isset($list->user_info->name))
                    <div class="wms-name-modifier2">
                        <div data-tip="on {{date('d-m-Y', strtotime($list->created_at))}}">
                            <strong class="@if($list->user_info->deleted_at)text-danger @else text-success @endif">{{$list->user_info->name ?? ''}}</strong>
                        </div>
                    </div>
                @endif
            </td>
            <td class="actions" style="width: 6%">
                <!--start manage button area-->
                <div class="btn-group dropup">
                    <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Manage
                    </button>
                    <!--start dropup content-->
                    <div class="dropdown-menu">
                        <div class="dropup-content catalogue-dropup-content">
                            <div class="action-1">
                                <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{url('woocommerce/'.$status.'/catalogue/'.$list->id.'/edit')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{url('woocommerce/'.$status.'/catalogue/'.$list->id.'/show')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                <div class="align-items-center mr-2"> <a class="btn-size add-product-btn" href="{{url('woocommerce/catalogue/'.$list->id.'/variation')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Manage Variation"><i class="fa fa-chart-bar" aria-hidden="true"></i></a></div>
                                @if($list->status == 'draft')
                                    <div class="align-items-center mr-2">
                                        <form action="{{url('woocommerce/catalogue/publish/'.$list->id)}}" method="post">
                                            @csrf
                                            <button class="btn-size del-pub publish-btn" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Publish"><i class="fa fa-upload" aria-hidden="true"></i> </button>
                                        </form>
                                    </div>
                                @endif
                                <div class="align-items-center">
                                    <form action="{{url('woocommerce/catalogue/delete/'.$list->id)}}" method="post">
                                        @csrf
                                        <button class="btn-size del-pub delete-btn" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('catalogue');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End dropup content-->
                </div>
                <!--End manage button area-->
            </td>
        </tr>

        <!--hidden row -->
        <tr>
            <td colspan="13" class="hiddenRow" style="padding: 0; background-color: #ccc">
                <div class="accordian-body collapse" id="demo{{$list->id}}">

                </div>
            </td>
        </tr>
        <!--End hidden row -->



        @else
            @if(isset($list->variations[0]->stock))
                <tr class="hide-after-complete-{{$list->id}}">
                    @if($status == 'draft')
                        <td><input type="checkbox" class="checkBoxClass" id="customCheck{{$list->id}}" value="{{$list->id}}"></td>
                    @endif
                    <td class="image" style="width: 6%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">

                        <!--Start each row loader-->
                        <div id="product_variation_loading{{$list->id}}" class="variation_load" style="display: none;"></div>
                        <!--End each row loader-->

                         @if(isset($list->single_image_info->image_url))
                            <a href="{{$list->single_image_info->image_url}}"  title="Click to expand" target="_blank"><img src="{{$list->single_image_info->image_url}}" class="thumb-md zoom" alt="WooCommerce-active-image"></a>
                        @else
                            <img src="{{asset('assets/common-assets/no_image.jpg')}}" class="thumb-md zoom" alt="WooCommerce-active-image">
                        @endif

                    </td>
{{--                    <td class="id" style="width: 6%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">--}}
                    <td class="id" style="width: 6%; text-align: center !important;">
                        <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                            <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$list->id}}</span>
                            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                        </div>
                    </td>
                    <td class="catalogue-name" style="width: 30%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">
                        <a class="catalogue-link" href="https://www.topbrandoutlet.co.uk/wp-admin/post.php?post={{$list->id}}&action=edit" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit On Woocommerce">
                            {!! Str::limit(strip_tags($list->name),$limit = 100, $end = '...') !!}
                        </a>
                    </td>

                    <?php
                    $data = '';
                    foreach ($list->all_category as $category){
                        $data .= $category->category_name.',';
                    }
                    $total_sold = 0;
                    foreach ($list->sold_variations as $variations){
                        foreach ($variations->order_products_without_cancel_and_return as $order_products){
                            $total_sold += $order_products->sold;
                        }
                    }
                    ?>
                    <td class="category" style="cursor: pointer; text-align: center !important;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{rtrim($data,',')}}</td>
                    <td class="rrp" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-target="#demo{{$list->id}}" id="mtr-{{$list->id}}" class="accordion-toggle" onclick="getVariation(this)">{{$list->rrp ?? ''}}</td>
                    <td class="sold" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-target="#demo{{$list->id}}" id="mtr-{{$list->id}}" class="accordion-toggle" onclick="getVariation(this)">{{$total_sold ?? 0}}</td>
                    <td class="stock" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$list->variations[0]->stock ?? 0}}</td>
                    <td class="product" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-target="#demo{{$list->id}}" id="mtr-{{$list->id}}" class="accordion-toggle" onclick="getVariation(this)">{{$list->variations_count ?? 0}}</td>
                    <td class="creator" style="width: 10% !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" class="accordion-toggle" onclick="getVariation(this)">
                        <div class="wms-name-creator">
                            <div data-tip="on {{date('d-m-Y', strtotime($list->created_at))}}">
                                <strong class="text-success">{{$list->user_info->name ?? ''}}</strong>
                            </div>
                        </div>
                    </td>
                    <td class="modifier" style="width: 10% !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" class="accordion-toggle" onclick="getVariation(this)">
                        @if(isset($list->modifier_info->name))
                            <div class="wms-name-modifier1">
                                <div data-tip="on {{date('d-m-Y', strtotime($list->updated_at))}}">
                                    <strong class="text-success">{{$list->modifier_info->name ?? ''}}</strong>
                                </div>
                            </div>
                        @else
                            <div class="wms-name-modifier2">
                                <div data-tip="on {{date('d-m-Y', strtotime($list->created_at))}}">
                                    <strong class="text-success">{{$list->user_info->name ?? ''}}</strong>
                                </div>
                            </div>
                        @endif
                    </td>
                    <td class="actions" style="width: 6%">
                        <!--start manage button area-->
                        <div class="btn-group dropup">
                            <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Manage
                            </button>

                            <!--start dropup content-->
                            <div class="dropdown-menu">
                                <div class="dropup-content catalogue-dropup-content">
                                    <div class="action-1">
                                        <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{url('woocommerce/'.$status.'/catalogue/'.$list->id.'/edit')}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                        <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{url('woocommerce/'.$status.'/catalogue/'.$list->id.'/show')}}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                        <div class="align-items-center mr-2"> <a class="btn-size add-product-btn" href="{{url('woocommerce/catalogue/'.$list->id.'/variation')}}" data-toggle="tooltip" data-placement="top" title="Add Product"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></div>
                                        @if($list->status == 'draft')
                                            <div class="align-items-center mr-2">
                                                <form action="{{url('woocommerce/catalogue/publish/'.$list->id)}}" method="post">
                                                    @csrf
                                                    <button class="btn-size del-pub publish-btn" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Publish"><i class="fa fa-upload" aria-hidden="true"></i> </button>
                                                </form>
                                            </div>
                                        @endif
                                        <div class="align-items-center">
                                            <form action="{{url('woocommerce/catalogue/delete/'.$list->id)}}" method="post">
                                                @csrf
                                                <button class="btn-size del-pub delete-btn" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('catalogue');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End dropup content-->
                        </div>
                        <!--End manage button area-->
                    </td>
                </tr>

                <!--hidden row -->
                <tr>
                    <td colspan="13" class="hiddenRow" style="padding: 0; background-color: #ccc">
                        <div class="accordian-body collapse" id="demo{{$list->id}}">

                        </div>
                    </td>
                </tr>
                <!--End hidden row -->

                @endif
            @endif
    @endforeach



<script>

    // table column hide and show toggle checkbox
    $("input:checkbox").click(function(){
        let column = "."+$(this).attr("name");
        $(column).toggle();
    });


    // table column hide and show toggle checkbox
    $("input:checkbox").click(function(){
        let column = "."+$(this).attr("name");
        $(column).toggle();
    });

    //table column by default hide
    $("input:checkbox:not(:checked)").each(function() {
        var column = "table ." + $(this).attr("name");
        $(column).hide();
    });

    //prevent onclick dropdown menu close
    $('.filter-content').on('click', function(event){
        event.stopPropagation();
    });

    $(document).ready(function (){
        $(".checkBoxClass").change(function(){
            if (!$(this).prop("checked")){
                $("#ckbCheckAll").prop("checked",false);
            }
            var catalogueIds = catalogueIdArray();
        });
    });


</script>
