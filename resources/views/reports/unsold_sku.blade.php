        <div class="row">
            <div class="col-md-4">
                <label></label>
                <div class="card">
                    <div class="card-header" role="tab" id="headingTwo" style="padding: 0;">
                        <h6 class="mb-0 mt-0">
                            <a style="padding: 5%; display:block;" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#sku_date_option" aria-expanded="false" aria-controls="collapseTwo">
                                Select Date
                            </a>
                        </h6>
                    </div>
                    <div id="sku_date_option" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="card-body">
                            <div class="form-group m-b-20">
                                <label>Predefine Date</label>
                                <select class="form-control" name="predefine_date">
                                    <option value="">Select one</option>
                                    <option value="0" class="predefine_date">Today</option>
                                    <option value="1" class="predefine_date">Yesterday</option>
                                    <option value="2" class="predefine_date">Last 7 days</option>
                                    <option value="3" class="predefine_date">Last 30 days</option>
                                    <option value="4" class="predefine_date">Last 60 days</option>
                                    <option value="5" class="predefine_date">Last 90 days</option>
                                </select>
                            </div>
                            <div class="form-group m-b-20" class="custom_date">
                                <label>Start Date</label>
                                <input type="date" name="end_date" class="form-control cus_start_date mb-1">
                            </div>
                            <div class="form-group m-b-20" class="custom_date">
                                <label>End Date</label>
                                <input type="date" name="start_date" class="form-control cus_start_date mb-1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="col-md-4">
                <div class="form-group m-b-20">
                    <label>SKU</label>
                    <input type="text" name="sku" class="form-control cus_start_date mb-1">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group m-b-20">
                    <label>Accounts</label>
                    <select class="form-control select2 js-states unsold_cat_sku_account" name="accounts">
                        <option value="">select one</option>
                        @foreach($channels as $key=> $channel)
                            @if($key == "ebay")
                                @foreach($channel as $key=> $ebay)
                                    <option value="Ebay/{{$key}}">{{$ebay}}</option>
                                @endforeach
                            @elseif($key == "shopify")
                                @foreach($channel as $key=> $shop)
                                    <option value="shopify/{{$key}}">{{$shop}}</option>
                                @endforeach
                            @elseif($key == "woocommerce")
                                @foreach($channel as $key=> $woo)
                                    <option value="woocommerce/{{$key}}">{{$woo}}</option>
                                @endforeach
                            @elseif($key == "onbuy")
                                @foreach($channel as $key=> $onb)
                                    <option value="onbuy/{{$key}}">{{$onb}}</option>
                                @endforeach
                            @elseif($key == "amazon")
                                @foreach($channel as $key=> $amz)
                                    <option value="amazon/{{$key}}">{{$amz}}</option>
                                @endforeach
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group m-b-20">
                    <label></label><br>
                    <button type="submit" class="btn btn-primary">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                </div>
            </div>
        </div>

