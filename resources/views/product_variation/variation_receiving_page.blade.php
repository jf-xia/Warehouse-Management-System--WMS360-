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
                            <p>Variation Receiving Page</p>
                        </div>
                    </div>
                </div>


                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box">


                            <form role="form" class="m-t-40">

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="invoice" class="col-md-2 col-form-label">Invoice</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="text" required data-parsley-maxlength="30" class="form-control"
                                               id="invoice" placeholder="">
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="variation" class="col-md-2 col-form-label">Variation</label>
                                    <div class="col-md-8 wow pulse">
                                        <select class="form-control" required >
                                            <option>Select Variation</option>
                                            <option>Admin</option>
                                            <option>Manager</option>
                                            <option>Receiver</option>
                                            <option>Shelver</option>
                                            <option>Picker</option>
                                            <option>Packer</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="quantity" class="col-md-2 col-form-label">Quantity</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="text" required data-parsley-maxlength="30" class="form-control"
                                               id="quantity" placeholder="">
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="shelving" class="col-md-2 col-form-label">Shelving</label>
                                    <div class="col-md-8 wow pulse">
                                        <select class="form-control" required>
                                            <option>Select Shelving</option>
                                            <option>Admin</option>
                                            <option>Manager</option>
                                            <option>Receiver</option>
                                            <option>Shelver</option>
                                            <option>Picker</option>
                                            <option>Packer</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="validationDefault05" class="col-md-2 col-form-label">Price</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="text" required data-parsley-maxlength="30" class="form-control"
                                               id="validationDefault05" placeholder="">
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                        <label for="date" class="col-md-2 col-form-label">Date</label>
                                        <div class="col-md-8 wow pulse">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclose">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="md md-event-note"></i></span>
                                                </div>
                                            </div><!-- input-group -->
                                        </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button class="vendor-btn" type="submit" class="btn btn-primary waves-effect waves-light">
                                            <b>Add</b>
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
    </div>  <!-- content-page-->

@endsection
