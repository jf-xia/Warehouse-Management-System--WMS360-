
@if(isset($amazonSearchResult['items']) && is_array($amazonSearchResult['items']) && count($amazonSearchResult['items']) > 0)
    <div class="row border-bottom mb-2">
        <div class="col-md-3">
            <h5>Market Place: {{$amazonSearchResult['marketplace'] ?? ''}}</h5>
        </div>
        <div class="col-md-3">
            <h6>Master ASIN: {{$amazonSearchResult['master_asin'] ?? ''}}</h6>
        </div>
        <div class="col-md-3 form-row">
            <div class="form-group" required>
                <label for="item_condition">Item Condition <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="This field cannot be changed once it is submitted. To edit, delete this listing and create a new listing."></i></label>
                <select name="item_condition" class="form-control">
                    @if(isset($amazonSearchResult['item_condition']))
                        @foreach($amazonSearchResult['item_condition'] as $condition)
                            <option value="{{$condition->id}}/{{$condition->condition_slug}}" @if($condition->condition_slug == 'new_new') selected @else disabled @endif>{{$condition->condition_name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-md-3 form-row">
            <label for="product_type">Product Type <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="This field cannot be changed once it is submitted. To edit, delete this listing and create a new listing."></i></label>
            @if((count($amazonSearchResult['product_type']->productType) == 0) || ($amazonSearchResult['product_type']->productType == null))
                <button type="button" class="btn btn-info migrate-amazon-product-type">Migrate Type</button>
            @endif
            <select name="product_type" class="form-control amazon-product-type-option" required>
                @if(isset($amazonSearchResult['product_type']->productType))
                    <option value="">Select Product Type</option>
                    @foreach($amazonSearchResult['product_type']->productType as $type)
                        <option value="{{$type->product_type}}" @if($type->product_type == 'PRODUCT') selected @endif>{{$type->product_type ?? ''}}</option>
                    @endforeach
                @endif
            </select>
            <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="If You Don't Find Your Desired Type, Please Select 'PRODUCT' From List"></i>
        </div>

    </div>
    <input type="hidden" name="exists_master_catalogue_id" value="{{$amazonSearchResult['exist_master_catalogue_id'] ?? ''}}">
    <input type="hidden" name="master_image" value="{{$amazonSearchResult['master_image']}}">
    <input type="hidden" name="master_asin" value="{{$amazonSearchResult['master_asin']}}">
    <input type="hidden" name="master_title" value="{{$amazonSearchResult['master_title']}}">
    <input type="hidden" name="master_sale_price" value="{{$amazonSearchResult['master_sale_price']}}">
    @foreach($amazonSearchResult['items'] as $result)
    <div class="card card-box amazon-exist-product-container">
        <div class="row border-bottom">
            <div class="col-md-2">
                <p>Main Picture</p>
                <img src="{{$result['main_picture'] ?? ''}}" height="100" width="100" alt="">
            </div>
            <div class="col-md-4">
                <h6 class="text-center">Amazon Info</h6><hr>
                <strong>{{$result['title'] ?? ''}}</strong><br>
                <p><strong>ASIN :</strong> {{$result['asin'] ?? ''}}</p>
                <p><strong>EAN :</strong> {{$result['ean_no'] ?? ''}}</p>
                @if((isset($result['brand_name']) === true) && (empty($result['brand_name']) === false))
                    <p><strong>Brand :</strong> {{$result['brand_name'] ?? ''}}</p>
                @endif
                @if((isset($result['product_type']) === true) && (empty($result['product_type']) === false))
                    <p><strong>Product Type :</strong> {{$result['product_type'] ?? ''}}</p>
                @endif
                @if((isset($result['manufacturer']) === true) && (empty($result['manufacturer']) === false))
                    <p><strong>Manufacturer :</strong> {{$result['manufacturer'] ?? ''}}</p>
                @endif
                @if((isset($result['model_number']) === true) && (empty($result['model_number']) === false))
                    <p><strong>Model Number :</strong> {{$result['model_number'] ?? ''}}</p>
                @endif
                @if((isset($result['color_name']) === true) && (empty($result['color_name']) === false))
                    <p><strong>Color :</strong> {{$result['color_name'] ?? ''}}</p>
                @endif
                @if((isset($result['size_name']) === true) && (empty($result['size_name']) === false))
                    <p><strong>Size :</strong> {{$result['size_name'] ?? ''}}</p>
                @endif
                @if((isset($result['style_name']) === true) && (empty($result['style_name']) === false))
                    <p><strong>Style :</strong> {{$result['style_name'] ?? ''}}</p>
                @endif
            </div>
            <div class="col-md-4">
                <h6 class="text-center">WMS Info</h6><hr>
                <div class="form-row">
                    <input type="hidden" name="master_variation_id[]" id="master_variation_id" value="{{$result['variation_info']['variation_id'] ?? ''}}">
                    <input type="hidden" name="master_variation_ean[]" id="master_variation_ean" value="{{$result['ean_no'] ?? ''}}">
                    <input type="hidden" name="amazon_variation_asin[]" id="amazon_variation_asin" value="{{$result['asin'] ?? ''}}">
                    <input type="hidden" name="master_variation_attribute[]" id="master_variation_attribute" value="{{$result['variation_info']['attribute'] ?? ''}}">
                    <div class="form-group col-md-12">
                        <label for="variation">Variation: </label>
                        @if($result['variation_info']['attribute'])
                            @foreach(\Opis\Closure\unserialize($result['variation_info']['attribute']) as $attribute_info_value)
                             {{$attribute_info_value['attribute_name'] ?? ''}}->{{$attribute_info_value['terms_name'] ?? ''}},
                            @endforeach
                        @endif
                    </div>
                    <div class="form-group col-md-6">
                        <label for="sku">Sku <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="This field cannot be changed once it is submitted. To edit, delete this listing and create a new listing."></i></label>
                        <input type="text" class="form-control" name="sku[]" id="sku" value="{{$result['variation_info']['sku'] ?? ''}}" placeholder="Enter SKU" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="sale_price">Sale Price <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="The price at which the product is offered for sale, in the local currency."></i></label>
                        <input type="text" class="form-control" name="sale_price[]" id="sale_price" value="{{$result['variation_info']['sale_price'] ?? ''}}" placeholder="Enter Sale Price" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="quantity">Quantity <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="A whole number."></i></label>
                        <input type="number" class="form-control" name="quantity[]" id="quantity" value="{{$result['variation_info']['quantity'] ?? ''}}" placeholder="Enter Quantity" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="is_master_editable">Is Editable <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="Amazon Variation Edit When Master Edit"></i></label>
                        <select name="is_master_editable[]" class="form-control" id="isMasterEditable">
                            <option value="1">ON</option>
                            <option value="0">OFF</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-2 text-center my-auto">
                @if(isset($amazonSearchResult['is_master_catalogue_exit']) && $amazonSearchResult['is_master_catalogue_exit'])
                    <button type="button" class="btn btn-info btn-block list-product-indivisually mb-1" id="{{$result['variation_info']['variation_id']}}">List This Product</button>
                @endif
                <button type="button" class="btn btn-danger btn-block remove-amazon-ajax-product-div">Remove</button>
            </div>
        </div>

        <div class="row">
            <div class="text-center bg-success col-md-12">Offer Details</div>
            @if($result['all_offers'] != null)
                <div class="col-md-3">
                    <h5>Basic Offer Info</h5><hr>
                    <p><strong>Total Seller Offers :</strong> {{$result['all_offers']['total_offer_count'] ?? ''}}</p>
                    <p><strong>Lowest Price :</strong> {{$result['all_offers']['lowest_prices'] ?? ''}}</p>
                    <p><strong>Buy Box Price :</strong> {{$result['all_offers']['buy_box_prices'] ?? ''}}</p>
                </div>
                @if(count($result['all_offers']['offers']) > 0)
                    @php
                        $i = 1;
                    @endphp
                    @foreach($result['all_offers']['offers'] as $offer)
                        <div class="col-md-3">
                            <h5>Seller {{$i}} Details</h5><hr>
                            <p><strong>Feedback Ratings:</strong> {{$offer['seller_feedback_rating']['feedback_count'] ?? 0}}</p>
                            <p><strong>Seller Positive Feedback :</strong> {{$offer['seller_feedback_rating']['seller_positive_feedback_rating'] ?? 0}}%</p>
                            <p><strong>Listing Price :</strong> {{$offer['listing_price'] ?? 0}}</p>
                            <p><strong>Shipping Price :</strong> {{$offer['shipping'] ?? 0}}</p>
                            <p><strong>Buy Box Winner :</strong> {{$offer['is_buy_box_winner'] == true ? 'Yes' : 'No'}}</p>
                            @php
                                $i++;
                            @endphp
                        </div>
                    @endforeach
                @endif
            @else
                <div class="alert alert-danger text-center col-md-12">No Offer Found</div>
            @endif
        </div>
        <div class="border border-success bg-success d-none text-center show-success-icon-{{$result['variation_info']['variation_id']}}">
            Success! <i class="fas fa-check-circle" aria-hidden="true"></i>
        </div>
        <hr>
    </div>
    @endforeach
    <div class="row mt-2">
        <div class="col-md-5"></div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-success">List All</button>
        </div>
        <div class="col-md-5"></div>
    </div>
@else
    <div class="alert alert-danger text-center">
        <h5>No Match Product Found In The Amazon Or Product Already Listed</h5>
    </div>
@endif
