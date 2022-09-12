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
                            <p>Add Variation</p>
                        </div>
                    </div>
                </div>


                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box">


                            <form role="form" class="vendor-form">
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="variation_product" class="col-md-2 col-form-label">Product</label>
                                    <div class="col-md-8">
                                        <select class="form-control" required >
                                            <option>Xxx</option>
                                            <option>Yyy</option>
                                            <option>Zzz</option>
                                            <option>Aaa</option>
                                            <option>Bbb</option>
                                            <option>Ccc</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>


                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        Dropdown button
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Link 1</a>
                                        <a class="dropdown-item" href="#">Link 2</a>
                                        <a class="dropdown-item" href="#">Link 3</a>
                                    </div>
                                </div>

                                <div class="row form-group product-desn-top">

                                    <div class=col-md-1></div>
                                    <div class="col-md-1">
                                        <div class="button-group">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">  <span class="caret"></span> 1.Size
                                            </button>
                                            <ul class="dropdown-menu checkbox-hight">
                                                <li>
                                                    <a href="#" class="small" data-value="option1" tabIndex="-1">
                                                        <input type="checkbox" />&nbsp;XXL</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="small" data-value="option2" tabIndex="-1">
                                                        <input type="checkbox" />&nbsp;XL</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="small" data-value="option3" tabIndex="-1">
                                                        <input type="checkbox" />&nbsp;L</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="small" data-value="option4" tabIndex="-1">
                                                        <input type="checkbox" />&nbsp;M</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="small" data-value="option5" tabIndex="-1">
                                                        <input type="checkbox" />&nbsp;S</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="small" data-value="option6" tabIndex="-1">
                                                        <input type="checkbox" />&nbsp;Option 6</a>
                                                </li>
                                            </ul>
                                        </div> <!--buttongroup close-->

                                    </div>  <!--end column-->



                                    <div class="col-md-1">

                                        <div class="button-group">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">  <span class="caret"></span>
                                                2.Color
                                            </button>
                                            <ul class="dropdown-menu checkbox-hight">
                                                <li>
                                                    <a href="#" class="small" data-value="option1" tabIndex="-1">
                                                        <input type="checkbox" />&nbsp;Brown</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="small" data-value="option2" tabIndex="-1">
                                                        <input type="checkbox" />&nbsp;Green</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="small" data-value="option3" tabIndex="-1">
                                                        <input type="checkbox" />&nbsp;Red</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="small" data-value="option4" tabIndex="-1">
                                                        <input type="checkbox" />&nbsp;M</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="small" data-value="option5" tabIndex="-1">
                                                        <input type="checkbox" />&nbsp;S</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="small" data-value="option6" tabIndex="-1">
                                                        <input type="checkbox" />&nbsp;Option 6</a>
                                                </li>
                                            </ul>
                                        </div> <!--buttongroup close-->

                                    </div>  <!--end column-->

                                    <!--

                                   <div class="col-md-1 draft-border">
                                       <h5>3.Style</h5>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                            <label class="custom-control-label" for="defaultUnchecked">General</label>
                                        </div>
                                   </div>
                                   <div class="col-md-1 draft-border">
                                       <h5>4.Fabric</h5>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                            <label class="custom-control-label" for="defaultUnchecked">General</label>
                                        </div>
                                   </div>
                                   <div class="col-md-1 draft-border">
                                        <h5>1.Size</h5>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                            <label class="custom-control-label" for="defaultUnchecked">General</label>
                                        </div>
                                   </div>
                                   <div class="col-md-1 draft-border">
                                        <h5>1.Size</h5>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                            <label class="custom-control-label" for="defaultUnchecked">General</label>
                                        </div>
                                   </div>

                                   <div class="col-md-1 draft-border">
                                        <h5>1.Size</h5>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                            <label class="custom-control-label" for="defaultUnchecked">XXL</label>
                                        </div>
                                   </div>
                                   <div class="col-md-1 draft-border">
                                        <h5>1.Size</h5>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                            <label class="custom-control-label" for="defaultUnchecked">XXL</label>
                                        </div>
                                   </div>
                                   <div class="col-md-1 draft-border">
                                        <h5>1.Size</h5>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                            <label class="custom-control-label" for="defaultUnchecked">XXL</label>
                                        </div>
                                   </div>
                                   <div class="col-md-1 draft-border">
                                        <h5>1.Size</h5>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                            <label class="custom-control-label" for="defaultUnchecked">XXL</label>
                                        </div>
                                   </div>

                                   <div class=col-md-1></div>  -->

                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="validationDefault04" class="col-md-2 col-form-label">Description</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control" name="" id="" cols="94" rows="5" required></textarea>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>



                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button class="vendor-btn" type="submit" class="btn btn-primary waves-effect waves-light">
                                            <b> Send </b>
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

@endsection
