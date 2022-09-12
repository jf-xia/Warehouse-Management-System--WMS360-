<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header" role="tab" id="headingTwo" style="padding: 0;">
                <h6 class="mb-0 mt-0">
                    <a style="padding: 5%; display:block; width:530px;" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#catalogue_date_option" aria-expanded="false" aria-controls="collapseTwo">
                        Select Date
                    </a>
                </h6>
            </div>
            <div id="catalogue_date_option" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                <div class="card-body">
                    {{-- <div class="form-group m-b-20">
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
                    </div> --}}
                    <h6>Catalogue Create Date</h6>
                    <div class="form-group m-b-20" class="custom_date">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control cus_start_date mb-1">
                    </div>
                    <div class="form-group m-b-20" class="custom_date">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control cus_start_date mb-1">
                    </div>
                    <h6>Unsold Date</h6>
                    <div class="form-group m-b-20" class="custom_date">
                        <label>Start Date</label>
                        <input type="date" name="unsold_start_date" class="form-control cus_start_date mb-1">
                    </div>
                    <div class="form-group m-b-20" class="custom_date">
                        <label>End Date</label>
                        <input type="date" name="unsold_end_date" class="form-control cus_start_date mb-1">
                    </div>
                </div>
                <div class="form-group m-b-20 submit_unsold_cat">
                    <label>If no Date are select then it will show which catalogue are not sold for all time</label><br>
                    <button type="submit" class="btn btn-primary">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-md-6">
        <div class="form-group m-b-20">
            <label>Reports Start Date</label>
            <input type="date" name="start_date" class="form-control cus_start_date mb-1">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group m-b-20">
            <label>Reports End Date</label>
            <input type="date" name="end_date" class="form-control cus_start_date mb-1">
        </div>
    </div> --}}
    <div class="col-md-6">
        {{-- <div class="form-group m-b-20">
            <label>If no Date are select then it will show which catalogue are not sold for all time</label><br>
            <button type="submit" class="btn btn-primary">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
        </div> --}}
    </div>


</div>
