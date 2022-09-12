@extends('master')

@section('title')
    Manual Order | WMS360
@endsection

@section('content')

    <!-- Custombox -->
    <link href="{{asset('assets/plugins/custombox/css/custombox.css')}}" rel="stylesheet">

    <!-- Modal-Effect -->
    <script src="{{asset('assets/plugins/custombox/js/custombox.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custombox/js/legacy.min.js')}}"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Page-Title -->



                <!-- Edit Role Modal -->
                <!-- <div id="csvSubmitModal" class="modal-demo">
                                <button type="button" class="close" onclick="Custombox.close();">
                                    <span>&times;</span><span class="sr-only">Close</span>
                                </button>
                                <h4 class="custom-modal-title">Product List</h4>
                                <div class="table-responsive">
                                    <h5 class="ml-1">1. Missmatch Product</h5>
                                    <div class=" ml-1 mr-1" style="border: 1px solid #cccccc;">
                                        <table class="w-100" style="margin: 20px 0;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">SKU</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-center">Reason</th>
                                                </tr>
                                            </thead>
                                            <tbody id="mismatch-product">
                                                <tr>
                                                    <td class="text-center">T-DIEGO_QA_XXL_Grey</td>
                                                    <td class="text-center">10</td>
                                                    <td class="text-center">Customer Cancellation</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <form action="">
                                    <div class="table-responsive">
                                        <h5 class="ml-1">2.Orderable Product</h5>
                                        <table class="w-100">
                                            <thead>
                                                <tr style="background-color: #5d9cec91">
                                                    <th class="text-center p-2">SKU</th>
                                                    <th class="text-center p-2">Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody id="orderable-product">
                                                <tr>
                                                    <td class="text-center p-2">
                                                        <input type="text" id="sku" name="sku[]" class="form-control" value="faddsg_asdegb" required>
                                                    </td>
                                                    <td class="text-center p-2">
                                                        <input  name="quantity[]" id="quantity" type="number" value="2" class="form-control" required>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="float-right mr-2 mb-3">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                            <button class="btn btn-danger">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div> -->
                            <!--End Edit Role Modal -->


                <div class="card-box card-box b-r-0 shadow" style="padding-bottom: 50px">

                    <div class="screen-option">
                        <div class="d-flex justify-content-start align-items-center">
                            <ol class="breadcrumb page-breadcrumb">
                                <li class="breadcrumb-item">Order</li>
                                <li class="breadcrumb-item active" aria-current="page">Manual Order</li>
                            </ol>
                        </div>
                        <form id="upload_csv" method="post" enctype="multipart/from-data">
                             @csrf
                            <div class="custom-file create-order-csv">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="required">Create Order via CSV</div>
                                    </div>
                                    <div class="ml-1">
                                        <div id="wms-tooltip">
                                            <span id="wms-tooltip-text" class="csv-text">You can create order via CSV. Here is the <a href="{{asset('assets/common-assets/sample.csv')}}">sample template</a></span>
                                            <span><img class="wms-tooltip-image" src="https://www.woowms.com/wms-1004/assets/common-assets/tooltip_button.png"></span>
                                        </div>
                                    </div>
                                </div>
                                <input type="file" class="custom-file-input" name="csvFile" id="csvFile" accept=".csv" required>
                                <label class="custom-file-label" for="validatedCustomFile" style="margin-top:26px;">Upload file...</label>
                                <button type="submit" class="btn btn-default manual-btn-csv">Submit</button>
                            </div>
                            {{-- </div> --}}
                                {{-- <div class="col-md-4 mb-3">
                                    <label for="validationDefault01"></label>
                                    <!-- <a class="btn btn-default manual-btn-csv" href="#csvSubmitModal" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" data-placement="top">Submit</a> -->
                                    <button type="submit" class="btn btn-default manual-btn-csv">Submit</button>
                                </div> --}}
                            {{-- </div> --}}
                            {{-- <a href="{{asset('assets/common-assets/sample.csv')}}" class="float-right" style="margin-right:20px; margin-bottom:20px;">Download the sample csv file</a> --}}
                        </form>
                    </div>


                    <!-- Order Product Modal Start -->
                    <div class="modal fade" id="csvOrderableModal" tabindex="-1" role="dialog" aria-labelledby="csvOrderableModal" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                            <div class="modal-header custom-modal-title">
                            <h4 class="">Product List</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                                </div>
                                <h3 class="ml-1 text-center">Customer: <span class="csv-customer-name"></span></h3>
                                <div class="table-responsive" id="mismatch-product-container">
                                    <h5 class="ml-1 text-center">Missmatch Product</h5>
                                    <a href="#" class="btn btn-outline-info btn-group download-csv">Download CSV</a>
                                    <div class=" ml-1 mr-1" style="border: 1px solid #cccccc;">
                                        <table class="w-100" style="margin: 20px 0;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">SKU</th>
                                                    <th class="text-center">Order Quantity</th>
                                                    <th class="text-center">Reason</th>
                                                </tr>
                                            </thead>
                                            <tbody id="mismatch-product">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <form action="{{url('manual-order-save-ajax')}}" method="post" id="orderable-product-container">
                                @csrf
                                    <div class="append-customer-information" style="display: none"></div>
                                    <input type="hidden" name="customer_name" id="csv_customer_name" value="">
                                    <div class="table-responsive">
                                        <h5 class="ml-1 text-center">Ordered Product</h5>
                                        <table class="w-100">
                                            <thead>
                                                <tr style="background-color: #5d9cec91">
                                                    <th class="text-center p-2">SKU</th>
                                                    <th class="text-center p-2">Quantity</th>
                                                    <th class="text-center p-2">Price</th>
                                                </tr>
                                            </thead>
                                            <tbody id="orderable-product">
                                            </tbody>
                                        </table>
                                        <div class="float-right mr-2 mb-3">
                                            <button type="submit" class="btn btn-success form-submit-button-div">Submit</button>
                                            <button type ="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Order Product Modal End -->

{{--
                    @if (Session::has('order_success_message'))
                        <div class="alert alert-success">
                            {!! Session::get('order_success_message') !!}
                        </div>
                    @endif

                    @if (Session::has('error'))
                        <div class="alert alert-danger">
                            {!! Session::get('error') !!}
                        </div>
                    @endif --}}

                    @if (Session::has('quantityMismatch'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach(Session::get('quantityMismatch') as $quantity)
                                    <li>{{$quantity}}</li>
                                @endforeach
                            </ul>
                            Please check valid quantity for above sku
                        </div>
                    @endif

                    <!-- POS UI Form -->
                    <form class="pos-ui-form" role="form" action="{{url('manual-order-save-ajax')}}" method="post">

                        {{csrf_field()}}

                         <div class="row">
                            <div class="col-md-6">

                                <div class="sku-field">
                                    <input type="text" class="form-control" id="read-sku" placeholder="Click here & scan product barcode" autofocus>
                                </div>

                                <!--Product order field section -->
                                <div class="product-order-field">
                                    <!-- Qty table-->
                                    {{-- <div class="table-responsive" style="overflow-x: visible !important;"> --}}
                                        <table class="table qty-table qty-tbottom">
                                            <thead>
                                                <tr id="th_tr">
                                                    <th class="text-center valign-middle w-td-40">Items</th>
                                                    <th class="text-center valign-middle w-td-10">Qty</th>
                                                    <th class="text-center valign-middle w-td-20">Unit Price</th>
                                                    <th class="text-center valign-middle w-td-20">Total</th>
                                                    <th class="text-center valign-middle w-td-10">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="qty-tbody">
                                                <!-- Without Scan Product!! -->
                                                <div class="without-scan-product">
                                                    <h3>No Item Found</h3>
                                                    <div class="font-16">Please scan a product!</div>
                                                </div>
                                            </tbody>
                                        </table>
                                    {{-- </div> --}}


                                    <!--Sub total table-->
                                    <div class="table-responsive" style="overflow-x: inherit;">
                                        <table class="w-100 sub-total-table">
                                            <tbody>
                                                <tr>
                                                    <td class="text-left sub-total">Sub Total</td>
                                                    <td>
                                                        <div class="subtotal-left">
                                                            <div>
                                                                <span>£</span>
                                                            </div>
                                                            <div class="sub-price ml-1">0.00</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div>Discount</div>
                                                            <div class="discount-in-percen">
                                                                <p>Discount in percentage</p>
                                                                <input type="text" id="percentInput" class="text-center">
                                                            </div>
                                                            <div class="discount-in-amount dia">
                                                                <p>Discount in amount</p>
                                                                <input type="text" id="defaultInput" class="text-center">
                                                            </div>
                                                            <div class="ml-2 pr-1 w-100px">
                                                                <a class="btn p-1 p-value d-block" id="percentVal"><i class="fa fa-percent" aria-hidden="true"></i></a>
                                                            </div>
                                                            <div class="w-100px">
                                                                <a class="btn p-1 d-value d-block" id="defaultVal"><i class="fa fa-gbp" aria-hidden="true"></i></a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="subtotal-left">
                                                            <div>
                                                                <span class="pound">£</span>
                                                            </div>
                                                            <div class="discount-input discountInput ml-1" id="discount-input">0.00</div>
                                                            <input type="hidden" class="discount-input discountInput" id="discount-input" value="0.00">
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- <tr>
                                                    <td>Vat</td>
                                                    <td>
                                                        <div class="subtotal-left">
                                                            <div>
                                                                <span>%</span>
                                                            </div>
                                                            <div>
                                                                <input type="text" class="vat-input" value="0.00">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr> --}}
                                                <tr>
                                                    <td><b>Grand Total</b></td>
                                                    <td>
                                                        <div class="subtotal-left">
                                                            <div><b>£</b></div>
                                                            <div class="grand-total-price ml-1"><b>0.00</b></div>
                                                        </div>
                                                        <input type="text" id="total_price" name="total_price" style="display: none">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Order status table -->
                                    <table class="order-status">
                                        <tbody class="w-100">
                                            <tr>
                                                <td class="w-td-10 cursor-pointer">
                                                    <div class="item-hover">Total item list</div>
                                                    <div class="item-list">
                                                        <i class="fa fa-list" aria-hidden="true"></i>
                                                        <div class="item-badge"><span class="badge badge-success">0</span></div>
                                                    </div>
                                                </td>
                                                <td class="w-td-45 text-center p-0">
                                                    <div class="cancel-order-div" onclick="removeAllItem()">Remove All Item</div>
                                                </td>
                                                <td class="w-td-45">
                                                    <select class="form-control select-status" name="status" id="status" required>
                                                        @if($orderId && $orderType)
                                                        <option value="processing" selected>Processing</option>
                                                        @elseif($orderId && !$orderType)
                                                            <option value="exchange-hold" selected>Exchange Hold</option>
                                                        @else
                                                            <option value="processing">Processing</option>
                                                        @endif
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                            <input type="hidden" name="orderId" value="{{$orderId ?? null}}">
                            <input type="hidden" name="orderType" value="{{$orderType ?? null}}">

                            <!-- Customer info section -->
                            <div class="col-md-6" style="padding-left: 0">
                                <div class="customer-info">
                                    <b>Customer Information</b>
                                </div>
                                <!-- Customer info table -->
                                <div class="cus-rs-div">
                                    <div class="table-responsive">
                                        <table class="customer-info-table w-100">
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="zzz">
                                                            <div>
                                                                <input type="text" name="customer_name" value="{{$decodeExchanegableOrderInfo->shipping_user_name ?? ''}}" class="form-control label-pad" placeholder="Name">
                                                            </div>
                                                            <div class="abc">Name &nbsp;<span class="text-success"><i class="fa fa-check" aria-hidden="true"></i></span></div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="zzz">
                                                            <div>
                                                                <input type="text" name="customer_city" value="{{$decodeExchanegableOrderInfo->shipping_city ?? ''}}" class="form-control label-pad" placeholder="City">
                                                            </div>
                                                            <div class="abc">City &nbsp;<span class="text-success"><i class="fa fa-check" aria-hidden="true"></i></span></div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="zzz">
                                                            <div>
                                                                <input type="text" name="customer_country" value="{{$decodeExchanegableOrderInfo->shipping_country ?? ''}}" class="form-control label-pad" placeholder="Country">
                                                            </div>
                                                            <div class="abc">Country &nbsp;<span class="text-success"><i class="fa fa-check" aria-hidden="true"></i></span></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="zzz">
                                                            <div>
                                                                <input type="text" name="address" value="{{ $decodeExchanegableOrderInfo->shipping_address_line_1 ?? '' }}" class="form-control label-pad" placeholder="Address 1">
                                                                {{-- <input type="text" name="address" value="{{ $decodeExchanegableOrderInfo->shipping ?? '' }}" class="form-control label-pad" placeholder="Address 1"> --}}
                                                            </div>
                                                            <div class="abc">Address 1 &nbsp;<span class="text-success"><i class="fa fa-check" aria-hidden="true"></i></span></div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="zzz">
                                                            <div>
                                                                <input type="text" name="customer_zip_code" value="{{$decodeExchanegableOrderInfo->shipping_post_code ?? ''}}" class="form-control label-pad" placeholder="Postcode">
                                                            </div>
                                                            <div class="abc">Postcode &nbsp;<span class="text-success"><i class="fa fa-check" aria-hidden="true"></i></span></div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="zzz">
                                                            <div>
                                                                <input type="number" name="customer_phone" value="{{$decodeExchanegableOrderInfo->shipping_phone ?? ''}}" class="form-control label-pad" placeholder="Phone">
                                                            </div>
                                                            <div class="abc">Phone &nbsp;<span class="text-success"><i class="fa fa-check" aria-hidden="true"></i></span></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="zzz">
                                                            <div>
                                                                <input type="text" name="address_two" class="form-control label-pad" value="{{ $decodeExchanegableOrderInfo->shipping_address_line_2 ?? ''}}" placeholder="Address 2">
                                                            </div>
                                                            <div class="abc">Address 2 &nbsp;<span class="text-success"><i class="fa fa-check" aria-hidden="true"></i></span></div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="zzz">
                                                            <div>
                                                                <input type="text" name="customer_state" value="{{$decodeExchanegableOrderInfo->shipping_county ?? ''}}" class="form-control label-pad" placeholder="County">
                                                            </div>
                                                            <div class="abc">County &nbsp;<span class="text-success"><i class="fa fa-check" aria-hidden="true"></i></span></div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="zzz">
                                                            <div class="position-relative">
                                                                <input type="email" name="customer_email" value="{{$decodeExchanegableOrderInfo->customer_email ?? ''}}" class="form-control label-pad" id="email" placeholder="Email">
                                                                <div class="email-error" style="display: none"></div>
                                                            </div>
                                                            <div class="abc">Email &nbsp;<span class="text-success"><i class="fa fa-check" aria-hidden="true"></i></span></div>
                                                        </div>
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!--Customer payment table section -->
                                    <div class="table-responsive">
                                        <table class="payment-table w-100">
                                            <tbody>
                                                <tr>
                                                    <td class="text-center" style="width: 39%">
                                                        <div class="zzz">
                                                            <div class="display-operations">
                                                                <input type="text" name="payment" id="display-operations" class="form-control label-pad pay-input" oninput="cusPayment()" placeholder="Payment">
                                                            </div>
                                                            <div class="abc acl">Payment &nbsp;<span class="text-success"><i class="fa fa-check" aria-hidden="true"></i></span></div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center" style="width: 39%">
                                                        <div class="zzz no-pointer-events">
                                                            <div>
                                                                <input type="text" name="change" id="changeAmount" class="form-control label-pad pay-input" placeholder="Change Amount">
                                                            </div>
                                                            <div class="abc acl c-amount">Change Amount &nbsp;<span class="text-success"><i class="fa fa-check" aria-hidden="true"></i></span></div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center" style="width: 21%">
                                                        <div class="clear-payment cursor-pointer ac">Clear</div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>



                                    <div class="row" style="margin-right: -15px">
                                        <div class="col-md-7">
                                            <div class="table-responsive">
                                                <table class="keyboard-table w-100">
                                                    <tbody>
                                                        <tr>
                                                            <td class="w-td-20">
                                                                <div class="seven default-no">7</div>
                                                            </td>
                                                            <td class="w-td-20">
                                                                <div class="eight default-no">8</div>
                                                            </td>
                                                            <td class="w-td-20">
                                                                <div class="nine default-no">9</div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="w-td-20">
                                                                <div class="four default-no">4</div>
                                                            </td>
                                                            <td class="w-td-20">
                                                                <div class="five default-no">5</div>
                                                            </td>
                                                            <td class="w-td-20">
                                                                <div class="six default-no">6</div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="w-td-20">
                                                                <div class="one default-no">1</div>
                                                            </td>
                                                            <td class="w-td-20">
                                                                <div class="two default-no">2</div>
                                                            </td>
                                                            <td class="w-td-20">
                                                                <div class="three default-no">3</div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="w-td-20">
                                                                <div class="dzero default-no">00</div>
                                                            </td>
                                                            <td class="w-td-20">
                                                                <div class="zero default-no">0</div>
                                                            </td>
                                                            <td class="w-td-20">
                                                                <div class="dot default-no">.</div>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-5" style="padding-left: inherit">
                                            <div class="table-responsive">
                                                <table class="default-money-table w-100">
                                                    <tbody>
                                                        <tr>
                                                            <td class="w-td-20 d-key">
                                                                <div class="default-money twenty default-no">
                                                                    <div>£</div>
                                                                    <div class="">20</div>
                                                                </div>
                                                            </td>
                                                            <td class="w-td-20" style="padding-left: 1px">
                                                                <div class="default-money fifty default-no">
                                                                    <div>£</div>
                                                                    <div>50</div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-td-20 d-key">
                                                                <div class="default-money dFive default-no">
                                                                    <div>£</div>
                                                                    <div>5</div>
                                                                </div>
                                                            </td>
                                                            <td class="w-td-20" style="padding-left: 1px">
                                                                <div class="default-money ten default-no">
                                                                    <div>£</div>
                                                                    <div>10</div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            {{-- payment method cash --}}
                                            <input type="hidden" id="cash" name="payment_method" value="cash">

                                            <table class="w-100">
                                                <tbody>
                                                    <tr>
                                                        <td class="d-key">
                                                            <div class="key-card credit-card">
                                                                Credit Card
                                                                {{-- payment method Credit Card --}}
                                                                <input type="hidden" id="CreditCard" name="payment_method" value="CreditCard">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="d-key">
                                                            <div class="exact-amount">Exact Amount</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>

                                        <div class="col-md-12" style="padding-right: 16px;">
                                            <button class="key-submit k-s">Submit</button>
                                        </div>

                                    </div>
                                </div>

                            </div>
                         </div>
                    </form>




                    {{-- <form class="" role="form" action="{{url('manual-order-save-ajax')}}" method="post">

                        {{csrf_field()}}

                        @if (Session::has('order_success_message'))
                            <div class="alert alert-success">
                                {!! Session::get('order_success_message') !!}
                            </div>
                        @endif

                        @if (Session::has('error'))
                            <div class="alert alert-danger">
                                {!! Session::get('error') !!}
                            </div>
                        @endif

                        @if (Session::has('quantityMismatch'))
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach(Session::get('quantityMismatch') as $quantity)
                                        <li>{{$quantity}}</li>
                                    @endforeach
                                </ul>
                                Please check valid quantity for above sku
                            </div>
                        @endif

                        <div class="row m-t-30 customer-information-form">

                            <div class="col-md-6">
                                <input type="hidden" name="orderId" value="{{$orderId ?? null}}">
                                <input type="hidden" name="orderType" value="{{$orderType ?? null}}">
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="customer_name" class="col-md-3 col-form-label ">Name</label>
                                    <div class="col-md-7 wow pulse">
                                        <input type="text" name="customer_name" data-parsley-maxlength="30" value="{{$decodeExchanegableOrderInfo->customer_name ?? ''}}" class="form-control"
                                               id="customer_name" placeholder="Enter customer name" >
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="customer_email" class="col-md-3 col-form-label ">Email</label>
                                    <div class="col-md-7 wow pulse">
                                        <input type="email" name="customer_email" data-parsley-maxlength="30" value="{{$decodeExchanegableOrderInfo->customer_email ?? ''}}" class="form-control"
                                               id="customer_email" placeholder="Enter customer email" >
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="phone" class="col-md-3 col-form-label ">Phone</label>
                                    <div class="col-md-7 wow pulse">
                                        <input type="number" name="customer_phone" data-parsley-maxlength="30" value="{{$decodeExchanegableOrderInfo->customer_phone ?? ''}}" class="form-control"
                                               id="customer_phone" placeholder="Enter customer phone" >
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="country" class="col-md-3 col-form-label ">Country</label>
                                    <div class="col-md-7 wow pulse">
                                        <input type="text" name="customer_country" data-parsley-maxlength="30" value="{{$decodeExchanegableOrderInfo->customer_country ?? ''}}" class="form-control"
                                               id="customer_country" placeholder="Enter customer country" >
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="form-group row m-t-20">
                                    <div class="col-md-1"></div>
                                    <label for="state" class="col-md-3 col-form-label ">State</label>
                                    <div class="col-md-7 wow pulse">
                                        <input type="text" name="customer_state" data-parsley-maxlength="30" value="{{$decodeExchanegableOrderInfo->customer_state ?? ''}}" class="form-control"
                                               id="customer_state" placeholder="Enter customer state" >
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="city" class="col-md-3 col-form-label ">City</label>
                                    <div class="col-md-7 wow pulse">
                                        <input type="text" name="customer_city" data-parsley-maxlength="30" value="{{$decodeExchanegableOrderInfo->customer_city ?? ''}}" class="form-control"
                                               id="customer_city" placeholder="Enter customer city" >
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                            </div> <!--// col-md-6 end -->

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="post_code" class="col-md-3 col-form-label ">Post Code</label>
                                    <div class="col-md-7 wow pulse">
                                        <input type="text" name="customer_zip_code" data-parsley-maxlength="30" value="{{$decodeExchanegableOrderInfo->shipping_post_code ?? ''}}" class="form-control"
                                               id="customer_zip_code" placeholder="Enter customer post code" >
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row m-t-20">
                                    <div class="col-md-1"></div>
                                    <label for="shipping" class="col-md-3 col-form-label ">Shipping Address</label>
                                    <div class="col-md-7 wow pulse">
                                        <textarea class="form-control" name="address" id="shippingArea" placeholder="Enter your shipping address ..." data-parsley-maxlength="" >{!! $decodeExchanegableOrderInfo->shipping ?? '' !!}</textarea>

                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="total_price" class="col-md-3 col-form-label">Total Price</label>
                                    <div class="col-md-7 wow pulse">
                                        <input type="text" name="total_price" data-parsley-maxlength="30" value="{{$decodeExchanegableOrderInfo->total_price ?? ''}}" class="form-control"
                                               id="total_price" placeholder="Enter total price">
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="status" class="col-md-3 col-form-label required">Status</label>
                                    <div class="col-md-7 wow pulse">
                                        <select class="form-control" name="status" id="status" required>
                                            @if($orderId && $orderType)
                                            <option value="processing" selected>Processing</option>
                                            @elseif($orderId && !$orderType)
                                                <option value="exchange-hold" selected>Exchange Hold</option>
                                            @else
                                                <option value="processing">Processing</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="status" class="col-md-3 col-form-label">Payment Method</label>
                                    <div class="col-md-7 wow pulse">
                                        <select class="form-control" name="payment_method" id="payment_method" required>
                                            <option value="cash" selected>Cash</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="CreditCard">Credit Card</option>
                                            <option value="paypal">Paypal</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                            </div> <!--// end col-md-6 -->
                        </div> <!-- // end row -->

                        <div class="row">
                            <div class="col-md-12">
                                <fieldset style="margin: 50px 20px 40px 20px" class="scheduler-border">
                                    <legend class="scheduler-border required">Select Order Product</legend>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="" class="table table-bordered">
                                                    <thead>
                                                    <tr style="background-color: #5d9cec91">
                                                        <th class="text-center w-50">Product</th>
                                                        <th class="text-center w-50">Quantity</th>
                                                        <th class="text-center w-50">Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="test-body">
                                                    <tr id="row0">
                                                        <td class="w-50">
                                                            <input type="text" id="sku" name="sku[]" class="form-control" required>
    {{--                                                        <select name="variation_id[]" id="variation_id" class="form-control select2" multiple="multiple" required>--}}
    {{--                                                            <option value="">Select product SKU</option>--}}
    {{--                                                            @foreach($all_product_sku as $product)--}}
    {{--                                                                <option value="{{$product->id}}">{{$product->sku}}</option>--}}
    {{--                                                            @endforeach--}}
    {{--                                                        </select>--}}
                                                        {{-- </td>
                                                        <td class="w-50">
                                                            <input  name="quantity[]" id="quantity" type="number" value="" class="form-control" required>
                                                        </td>
                                                        <td class="w-50">
                                                            <button type="button" class="btn btn-danger remove-more-sku">Remove</button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <div>
                                                    <button type="button" class="btn btn-success add-more-row">Add More</button>
                                                </div>
                                                {{--                                                    <input id='add-row' onclick="" class='btn btn-success' type='button' value='Add' />--}}
                                            {{--</div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>  --}}


                        {{-- <div class="form-group row m-t-40">
                            <div class="col-md-12 text-center">
                                <button class="btn btn-default vendor-btn waves-effect waves-light m-b-30" type="submit" >
                                    <b>Submit</b>
                                </button>
                            </div>
                        </div> --}}

                    </form>
                </div>

            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->

    {{-- <script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script> --}}

    {{-- <script>
        $('.select2').select2();
        CKEDITOR.replace( 'shippingArea',
            {
                customConfig : 'config.js',
                height: 200,
                toolbar : []
            })
    </script> --}}

    <script>

        $(document).ready(function () {
            $('.add-more-row').on('click', function () {

                var html_row = '<tr id="row0">\n' +
                    '<td class="w-50">\n' +
                    '   <input type="text" id="sku" name="sku[]" class="form-control" required>\n' +
                    '</td>\n' +
                    '<td class="w-50">\n' +
                    '   <input  name="quantity[]" id="quantity" type="number" value="" class="form-control" required>\n' +
                    '</td>\n' +
                    '<td class="w-50">\n' +
                    '    <button type="button" class="btn btn-danger remove-more-sku">Remove</button>\n' +
                    '</td>\n' +
                    '</tr>';
                $('tbody').append(html_row);
            })

            $('#upload_csv').on('submit', function(event){
                event.preventDefault();
                var submitLoadingButton = $('button.manual-btn-csv')
                submitLoadingButton.html('<i class="fa fa-circle-o-notch fa-spin"></i> Submitting...')
                var fileName = $('#csvFile')[0].files[0].name
                var extension = fileName.substr(fileName.lastIndexOf('.') + 1);
                var fileSize = ($('#csvFile')[0].files[0].size / (1024 * 1024)).toFixed(2)
                console.log(fileSize)
                if(fileSize > 2){
                    Swal.fire('Oops!','Maximum 2 MB file size allowed','error')
                    submitLoadingButton.html('Submit');
                    return false
                }
                if(extension != 'csv'){
                    Swal.fire('Oops!','Only CSV file allowed','error')
                    submitLoadingButton.html('Submit');
                    return false
                }
                $.ajax({
                    url: "{{url('validate-upload-order-product-csv')}}",
                    method:"POST",
                    data:new FormData(this),
                    dataType:'json',
                    contentType:false,
                    cache:false,
                    processData:false,
                    success: function(response){
                        if(response.type == 'success'){
                            $('a.download-csv').attr('href', '#')
                            $('table tbody#mismatch-product').html('')
                            $('table tbody#orderable-product').html('')
                            if(response.result.mismatch_products.length > 0){
                                var mismatchProduct = ''
                                response.result.mismatch_products.forEach((item) => {
                                    mismatchProduct += '<tr>'
                                                +'<td class="text-center">'+item.sku+'</td>'
                                                +'<td class="text-center">'+item.quantity+'</td>'
                                                +'<td class="text-center">'+item.reason+'</td>'
                                            +'</tr>'
                                })
                                $('div#mismatch-product-container').show()
                                $('a.download-csv').attr('href', response.result.csv_link)
                                $('table tbody#mismatch-product').html(mismatchProduct)
                            }else{
                                $('div#mismatch-product-container').hide()
                            }
                            if(response.result.orderable_products.length > 0){
                                var orderableProducts = ''
                                response.result.orderable_products.forEach((item) => {
                                    var itemPrice = ((item.price != '') && (item.price != 'null')) ? item.price : 0;
                                    orderableProducts += '<tr>'
                                                    +'<td class="text-center p-2">'
                                                        +'<input type="text" id="sku" name="sku[]" class="form-control" value="'+item.sku+'" required>'
                                                    +'</td>'
                                                    +'<td class="text-center p-2">'
                                                        +'<input  name="quantity[]" id="quantity" type="number" value="'+item.quantity+'" class="form-control" required>'
                                                    +'</td>'
                                                    +'<td class="text-center p-2">'
                                                        +'<input  name="price[]" id="price" type="number" value="'+itemPrice+'" class="form-control" required>'
                                                    +'</td>'
                                                +'</tr>'
                                })
                                $('table tbody#orderable-product').html(orderableProducts)
                                $('#csv_customer_name').val(response.result.customer)
                                var customerInfo = $('div.customer-information-form').html()
                                var formData = $('form.pos-ui-form').serializeArray()
                                var orderFormData = '<input type="text" name="orderId" value="'+formData[3].value+'">'
                                +'<input type="text" name="orderType" value="'+formData[4].value+'">'
                                +'<input type="text" name="customer_name" value="'+formData[5].value+'">'
                                +'<input type="text" name="customer_email" value="'+formData[13].value+'">'
                                +'<input type="text" name="customer_phone" value="'+formData[10].value+'">'
                                +'<input type="text" name="customer_country" value="'+formData[7].value+'">'
                                +'<input type="text" name="customer_state" value="'+formData[12].value+'">'
                                +'<input type="text" name="customer_city" value="'+formData[6].value+'">'
                                +'<input type="text" name="customer_zip_code" value="'+formData[9].value+'">'
                                +'<input type="text" name="address" value="'+formData[8].value+'">'
                                +'<input type="text" name="address_two" value="'+formData[11].value+'">'
                                //+'<textarea name="address">'+CKEDITOR.instances['shippingArea'].getData()+'</textarea>'
                                +'<input type="text" name="total_price" value="'+formData[1].value+'">'
                                +'<input type="text" name="status" value="'+formData[2].value+'">'
                                +'<input type="text" name="payment_method" value="'+formData[16].value+'">'
                                $('div.append-customer-information').html(orderFormData)
                                $('div button.form-submit-button-div').show()
                                $('form#orderable-product-container').show()
                            }else{
                                $('form#orderable-product-container').hide()
                                //$('div button.form-submit-button-div').hide()
                            }
                            $('h3 span.csv-customer-name').text(response.result.customer)
                            $('input[name="customer_name"]').val(response.result.customer)
                            $('input[name="total_price"]').val(response.result.total_price)
                            $('#csvOrderableModal').modal('show')

                            // $('button.manual-btn-csv').html(
                            //     `Submit`
                            // );
                        }else{
                            Swal.fire('Oops!',response.msg,'error')
                        }
                        submitLoadingButton.html('Submit');
                    }
                })

            })
        });

        function bytesToSize(bytes) {
            var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            if (bytes == 0) return '0 Byte';
            var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
            return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
        }



        $('tbody').on('click','.remove-more-sku', function (e) {
            e.preventDefault();
            let value = $('tbody tr').length;
            console.log(value);
            if(value > 1) {
                $(this).closest('tr').remove();
            }else{
                return false;
            }
        });

        {{--function get_variation_by_draft_product() {--}}
        {{--    // console.log('found');--}}
        {{--    var product_draft_id = $('#draft_product_id').val();--}}
        {{--    console.log(product_draft_id);--}}
        {{--    $.ajax({--}}
        {{--       type:'POST',--}}
        {{--       url:'{{url('get-all-variation-by-product-draft-ajax')}}',--}}
        {{--        data:{--}}
        {{--           "_token": "{{csrf_token()}}",--}}
        {{--            "id": product_draft_id,--}}
        {{--        },--}}
        {{--        success:function(response){--}}
        {{--            $('#variation_id').html(response);--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}


        // Add row

        // var row=1;
        // $(document).on("click", "#add-row", function () {
        //     var new_row = '<tr id="row' + row + '">' +
        //         '<td><select name="select_product_draft' + row + '" value="" class="form-control"><option>Select product draft</option><option>ABC</option><option>CDF</option><option>EFG</option></select></td>' +
        //         '<td><select name="select_product_variation' + row + '" value="" class="form-control"><option>Select product variation</option><option>ABC</option><option>CDF</option><option>EFG</option></select></td>' +
        //         '<td><input name="quantity' + row + '" type="number" class="form-control" /></td>' +
        //         // '<td><input name="price' + row + '" type="number" class="form-control" /></td>' +
        //         '<td><input  style="margin-left: 30px; margin-right: 30px;" class="delete-row btn btn-danger" type="button" value="Delete" /></td>' +
        //         '</tr>';
        //     // alert(new_row);
        //     $('#test-body').append(new_row);
        //     row++;
        //     return false;
        // });

        // Remove criterion
        // $(document).on("click", ".delete-row", function () {
        //     //  alert("deleting row#"+row);
        //     if(row>1) {
        //         $(this).closest('tr').remove();
        //         row--;
        //     }
        //     return false;
        // });

        // input file name show

            $('#csvFile').change(function (e) {
        if (e.target.files.length) {
            $(this).next('.custom-file-label').html(e.target.files[0].name);
        }
    });



        //Pos UI Script start
        var typingTimer;
        var doneTypingInterval = 100;
        var element = document.getElementById("read-sku");
        element.addEventListener("click", function(){
            element.addEventListener("keyup", function(){
                clearTimeout(typingTimer);
                typingTimer = setTimeout(pasteSkuOrScanBarcode, doneTypingInterval);
            })
            element.addEventListener("keydown", function(){
                clearTimeout(typingTimer);
            })
            function pasteSkuOrScanBarcode() {
                var sku = element.value;
                console.log("Before ajax sku " + sku)
                $.ajax({
                    type: "POST",
                    url: "{{url('get-scanning-sku-result')}}",
                    data: {
                        "_token" : "{{csrf_token()}}",
                        "sku" : sku,
                    },
                    success: function(response){
                        // console.log(response)
                        if(response.data == 'Invalid sku'){
                            Swal.fire({
                                icon: 'error',
                                title: 'No Item Found!'
                            })
                        }else{
                            var id = response.product_id;
                            var verify_qty = response.actual_qty;
                            var verify_qty_sku = response.sku;
                            var shelvProductCount = response.shelv_product;

                            var storedNames = JSON.parse(localStorage.getItem("names"));
                            // console.log("Get stored name " + storedNames)
                            if(sku != ''){
                                if(storedNames == null){
                                    storedNames = [];
                                    storedNames.push(sku);
                                    console.log("storedNames " + storedNames)
                                    localStorage.setItem("names", JSON.stringify(storedNames));
                                }else{
                                    if(verify_qty != 0){

                                        var minifiedTitle = response.item_name.substring(0, 15)+"...";

                                        var attribute_1 = '';

                                        if(response.attribute[0]){
                                            attribute_1 += '   <div class="d-flex align-items-center py-1">'+
                                                        '       <div><b>'+response.attribute[0]['attribute_name']+':</b></div>'+
                                                        '       <div class="ml-2">'+response.attribute[0]['terms_name']+'</div>'+
                                                        '   </div>'

                                        }

                                        var attribute_2 = '';
                                        var item_details_1 = '';
                                        var item_details_2 = '';
                                        if(response.attribute[1]){
                                            attribute_2 += '    <div class="d-flex align-items-center pt-1">'+
                                                        '         <div><b>'+response.attribute[1]['attribute_name']+':</b></div>'+
                                                        '         <div class="ml-2">'+response.attribute[1]['terms_name']+'</div>'+
                                                        '    </div>'
                                            item_details_2 += '<div class="item-details item-detail_'+id+'" style="top: -164px;">'
                                        }else{
                                            item_details_1 += '<div class="item-details item-detail_'+id+'">'
                                        }



                                        var tableRow =  '   <tr id="tr_'+id+'">'+
                                                        '     <input type="hidden" name="sku[]" value="'+response.sku+'">'+
                                                        '     <td id="td_'+id+'" class="text-center valign-middle item-name item-nam_'+id+' w-td-40">'+
                                                        '         <div class="five_chars scan cursor-pointer" id="scan_'+id+'">'+minifiedTitle+'</div>'+

                                                        item_details_1+

                                                        item_details_2+

                                                        '             <div class="actual_qty_'+id+'" style="display: none;">'+response.actual_qty+'</div>'+
                                                        '             <div class="d-flex align-items-center py-1">'+
                                                        '                 <div><b>Item Name:</b></div>'+
                                                        '                <div class="ml-2">'+response.item_name+'</div>'+
                                                        '             </div>'+
                                                        '            <div class="d-flex align-items-center py-1">'+
                                                        '                 <div><b>SKU:</b></div>'+
                                                        '                 <div class="ml-2 res-sku">'+response.sku+'</div>'+
                                                        '             </div>'+
                                                        '             <div class="d-flex align-items-center py-1">'+
                                                        '                 <div><b>Available Quantity:</b></div>'+
                                                        '                 <div class="ml-2">'+response.actual_qty+'</div>'+
                                                        '             </div>'+

                                                        attribute_1+

                                                        attribute_2+

                                                        '         </div>'+
                                                        '     </td>'+
                                                        '     <td id="td_'+id+'" class="text-center valign-middle td-qty_'+id+' w-td-10">'+
                                                        '         <input type="text" name="quantity[]" id="quantity" class="button cursor-pointer qty-show quantity_index_'+id+'" readonly required>'+
                                                        '         <div class="popup popup_'+id+'">'+
                                                        '             <div class="d-flex align-items-center">'+
                                                        '                 <div class="font-10">'+
                                                        '                     <input type="text" class="input-text qty-incre-decre qid_'+id+'">'+
                                                        '                 </div>'+
                                                        '                 <div class="px-2 font-10">'+
                                                        '                     <span class="qty-plus_'+id+' cursor-pointer"><i class="fa fa-plus"></i></span>'+
                                                        '                 </div>'+
                                                        '                 <div class="px-2 font-10">'+
                                                        '                     <span class="qty-minus_'+id+' cursor-pointer"><i class="fa fa-minus"></i></span>'+
                                                        '                 </div>'+
                                                        '             </div>'+
                                                        '         </div>'+
                                                        '         <div class="storeQty_'+id+'">'+
                                                        '             <div class="d-flex align-items-center justify-content-between">'+
                                                        '                <div><b>Available Quantity '+response.actual_qty+'</b></div>'+
                                                        '                <div id="qtyInfo-close_'+id+'" class="qty-close"><i class="fa fa-close"></i></div>'+
                                                        '            </div>'+
                                                        // '            <div class="mt-2 text-highlight">You are not allowed to increase your quantity more than '+response.actual_qty+'</div>'+
                                                        '         </div>'+
                                                        '     </td>'+

                                                        '     <td id="td_'+id+'" class="text-center valign-middle w-td-30">'+
                                                        '         <input type="text" class="form-control text-center productPrice_'+id+'" id="price" value="'+response.sale_price+'" required  readonly>'+
                                                        '     </td>'+
                                                        '     <td id="td_'+id+'" class="text-center valign-middle w-td-20 td_price_'+id+'">'+
                                                        '         <input type="text" class="t-price total'+id+'" name="price[]" value="'+response.sale_price+'" readonly>'+
                                                        // '         <span class="item-close item-close_'+id+'" onclick="removeItem(this);"><i class="fa fa-close"></i></span>'+
                                                        '     </td>'+
                                                        '     <td id="td_'+id+'" class="text-center valign-middle w-td-10">'+
                                                        '         <span class="item-close" onclick="removeItem(this);"><i class="fa fa-trash"></i></span>'+
                                                        '     </td>'+
                                                        ' </tr>';


                                            var tRowCount = $('#qty-tbody tr').length;
                                            // var shelvProductCount = response.shelv_product;
                                            if(response){
                                                if(response.actual_qty <= shelvProductCount && response.actual_qty > 0){
                                                    if(storedNames.indexOf(sku) !== -1){
                                                        var existQnty = $('input.quantity_index_'+id).val()
                                                        var existPrice = $('input.productPrice_'+id).val()
                                                        console.log('existQnty ' + existQnty)
                                                        console.log('existPrice ' + existPrice)
                                                        var newQty = parseInt(existQnty) + 1
                                                        if(newQty > verify_qty){
                                                            Swal.fire({
                                                                icon: 'error',
                                                                title: 'Oops...',
                                                                text: 'Available quantity is '+verify_qty+' for this product('+verify_qty_sku+')'
                                                            })
                                                            return false
                                                        }
                                                        var newPrice =parseFloat(existPrice) * newQty
                                                        $('input.quantity_index_'+id).val(newQty)
                                                        $('input.qid_'+id).val(newQty)
                                                        $('input.total'+id).val(newPrice.toFixed(2))

                                                        var priceList = $('tbody').find('.t-price');
                                                        var totalPrice = 0;
                                                        $.each(priceList, function(i, price){
                                                            totalPrice += parseFloat($(price).val())
                                                        });
                                                        $('div.sub-price').text(parseFloat(totalPrice).toFixed(2));
                                                        $('div.grand-total-price').find('b').text(parseFloat(totalPrice).toFixed(2))
                                                        return false
                                                    }
                                                    if(tRowCount == ''){
                                                        $("#qty-tbody").append(tableRow);
                                                        $("div.without-scan-product").hide()
                                                    }else{
                                                        $(tableRow).insertBefore('#qty-tbody tr:first')
                                                    }
                                                }else{
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Oops...',
                                                        text: 'This product available quantity is '+response.actual_qty+' and shelv quantity is '+shelvProductCount+'',
                                                    })
                                                    return false
                                                }
                                            }



                                    }else{
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Available quantity is '+verify_qty+' for this product('+verify_qty_sku+')'
                                        })
                                        return false
                                    }

                                    storedNames.push(sku);
                                    localStorage.setItem("names", JSON.stringify(storedNames));
                                }
                            }else{
                                return false
                            }








                            var tRowCount = $('#qty-tbody tr').length;
                            // console.log('tRowCount ' + tRowCount)
                            $('span.badge').text(tRowCount)

                            if(tRowCount == 1){
                                $('table.qty-table').removeClass('qty-tbottom')
                                $('table.qty-table').addClass('one-item')
                            }
                            else if(tRowCount == 2){
                                $('table.qty-table').removeClass('one-item')
                                $('table.qty-table').addClass('two-item')
                            }
                            else if(tRowCount == 3){
                                $('table.qty-table').removeClass('two-item')
                                $('table.qty-table').addClass('three-item')
                            }
                            else if(tRowCount == 4){
                                $('table.qty-table').removeClass('three-item')
                                $('table.qty-table').addClass('four-item')
                            }
                            else if(tRowCount == 5){
                                $('table.qty-table').removeClass('four-item')
                                $('table.qty-table').addClass('five-item')
                            }

                            $('input.quantity_index_'+id).val(parseInt(1))
                            $('input.qid_'+id).val(parseInt(1))


                            // $('#tr_'+id).css('position', 'relative')
                            $('div.storeQty_'+id).css({
                                'position' : 'absolute',
                                'display' : 'none',
                                'padding' : '12px',
                                'transform' : 'scale(2.1)',
                                'transition' : 'transform .2s',
                                'top' : '50%',
                                'left' : '50%',
                                'transform' : 'translate(-50%, -50%)',
                                'width' : 'max-content',
                                'background-color' : '#ffffff',
                                'z-index' : '99999',
                                'box-shadow' : 'rgba(17, 17, 26, 0.1) 0px 4px 16px, rgba(17, 17, 26, 0.1) 0px 8px 24px, rgba(17, 17, 26, 0.1) 0px 16px 56px'
                            })
                            $('div#qtyInfo-close_'+id).click(function(){
                                $(this).closest('div.storeQty_'+id).hide()
                                $('#tr_'+id).css('background-color', 'inherit')
                                $('#qty-tbody tr #td_'+id).removeClass('qty-valid-pop')
                            })


                            var incrementPlus;
                            var incrementMinus;

                            var buttonPlus  = $(".qty-plus_"+id);
                            var buttonMinus = $(".qty-minus_"+id);

                            var incrementPlus = buttonPlus.click(function() {
                                // var parentTr = $(this).closest('tr')
                                var n = $(this).parent().prev().find(".qid_"+id);
                                var m = $('input.quantity_index_'+id)
                                var existQty = Number(n.val());
                                console.log("existQty is " + existQty)
                                var storeQty = $('div.actual_qty_'+id).text()
                                console.log('storeQty ' + storeQty)
                                var existQty = existQty + 1
                                if(existQty > storeQty){
                                    $('div.storeQty_'+id).show()
                                    $('#tr_'+id).css('background-color', 'rgb(238, 238, 238)')
                                    $('#qty-tbody tr #td_'+id).addClass('qty-valid-pop')
                                    return false
                                }
                                n.val(Number(n.val())+1)
                                m.val(Number(m.val())+1);
                                var existPrice = parseFloat($('input.productPrice_'+id).val())
                                var newPrice = existPrice * existQty
                                $('input.total'+id).val(newPrice.toFixed(2))
                                var priceList = $('tbody').find('.t-price');
                                var totalPrice = 0;
                                $.each(priceList, function(i, price){
                                    totalPrice += parseFloat($(price).val())
                                });
                                $('div.sub-price').text(parseFloat(totalPrice).toFixed(2));
                                $('div.grand-total-price').find('b').text(parseFloat(totalPrice).toFixed(2))
                                $('input#total_price').val(parseFloat(totalPrice).toFixed(2))
                                // $('input.discount-input').val(parseFloat(0).toFixed(2))

                                $(".discountInput").keyup(function(){
                                    // console.log('text')
                                    var getSubprice = $('div.sub-price').text()
                                    // console.log("getSubprice "+getSubprice)
                                    var disPrice = parseFloat($(this).val())
                                    var grandPay = getSubprice - disPrice
                                    // console.log("grandPay "+grandPay)
                                    $('div.grand-total-price').find('b').text(parseFloat(grandPay).toFixed(2))
                                })

                                // console.log("newPrice= " + newPrice)
                                if(existQty == 1){
                                    $('.qty-minus'+id).parent().show()
                                    $('input.quantity_index_'+id).val(1)
                                }


                            });

                            var incrementMinus = buttonMinus.click(function() {
                                // var parentTr = $(this).closest('tr')
                                var n = $(this).parent().prev().prev().find(".qid_"+id);
                                var m = $('input.quantity_index_'+id)
                                var amount = Number(n.val());
                                m.val(Number(m.val())-1);
                                if(amount > 1) {
                                    n.val(amount-1);
                                    var dQty = $('input.qid_'+id).val()
                                    // console.log("dQty "+dQty)
                                    var existPrice = parseFloat($('input.productPrice_'+id).val())
                                    // console.log("existPrice "+existPrice)
                                    var newPrice = existPrice * dQty
                                    // console.log("newPrice "+newPrice)
                                    $('input.total'+id).val(newPrice)

                                    var priceList = $('tbody').find('.t-price');
                                    var totalPrice = 0;
                                    $.each(priceList, function(i, price){
                                        totalPrice += parseFloat($(price).val())
                                    });
                                    $('div.sub-price').text(parseFloat(totalPrice).toFixed(2));
                                    $('div.grand-total-price').find('b').text(parseFloat(totalPrice).toFixed(2))
                                    $('input#total_price').val(parseFloat(totalPrice).toFixed(2))
                                    // $('input.discount-input').val(parseFloat(0).toFixed(2))


                                    $(".discountInput").keyup(function(){
                                        // console.log('text')
                                        var getSubprice = $('div.sub-price').text()
                                        // console.log("getSubprice "+getSubprice)
                                        var disPrice = parseFloat($(this).val())
                                        var grandPay = getSubprice - disPrice
                                        // console.log("grandPay "+grandPay)
                                        $('div.grand-total-price').find('b').text(parseFloat(grandPay).toFixed(2))
                                    })


                                }else{
                                    $('div.popup_'+id).hide()
                                    $('input.quantity_index_'+id).val(1)
                                }
                            });


                            // Custom quantity input field
                            $('.qid_'+id).on('input', function(){
                                var currentQty = this.value
                                if(currentQty > verify_qty){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Available quantity is '+verify_qty+' for this product('+verify_qty_sku+')'
                                    })
                                    this.value = verify_qty
                                    $('.quantity_index_'+id).val(verify_qty)
                                    var existPrice = parseFloat($('input.productPrice_'+id).val())
                                    var newPrice = existPrice * verify_qty
                                    $('input.total'+id).val(newPrice)
                                    var priceList = $('tbody').find('.t-price');
                                    var totalPrice = 0;
                                    $.each(priceList, function(i, price){
                                        totalPrice += parseFloat($(price).val())
                                    });
                                    $('div.sub-price').text(parseFloat(totalPrice).toFixed(2));
                                    $('div.grand-total-price').find('b').text(parseFloat(totalPrice).toFixed(2))
                                    $('input#total_price').val(parseFloat(totalPrice).toFixed(2))
                                    return false
                                }
                                $('.quantity_index_'+id).val(currentQty)
                                var existPrice = parseFloat($('input.productPrice_'+id).val())
                                var newPrice = existPrice * currentQty
                                $('input.total'+id).val(newPrice)
                                var priceList = $('tbody').find('.t-price');
                                var totalPrice = 0;
                                $.each(priceList, function(i, price){
                                    totalPrice += parseFloat($(price).val())
                                });
                                $('div.sub-price').text(parseFloat(totalPrice).toFixed(2));
                                $('div.grand-total-price').find('b').text(parseFloat(totalPrice).toFixed(2))
                                $('input#total_price').val(parseFloat(totalPrice).toFixed(2))
                            })



                            var priceList = $('tbody').find('.t-price');
                            var totalPrice = 0;
                            $.each(priceList, function(i, price){
                                totalPrice += parseFloat($(price).val())
                            });
                            $('div.sub-price').text(parseFloat(totalPrice).toFixed(2));
                            $('div.grand-total-price').find('b').text(parseFloat(totalPrice).toFixed(2))
                            $('input#total_price').val(parseFloat(totalPrice).toFixed(2))


                            $('.cancel-order-div').on('click', function(){
                                $('.qty-table tbody').hide()
                            })

                            $('td.td-qty_'+id).hover(function(){
                                // var parentTr = $(this).closest('tr')
                                $('div.popup_'+id).show()
                            },function(){
                                // var parentTr = $(this).closest('tr')
                                $('div.popup_'+id).hide()
                            })

                            $('td.item-nam_'+id).hover(function(){
                                // var parentTr = $(this).closest('tr')
                                $('div.item-detail_'+id).show()
                                $(this).closest('tr').css("background-color", "rgb(238 238 238)")
                                $('input.total'+id).css('background-color', 'inherit')
                                $('input.productPrice_'+id).css('background-color', 'inherit')
                                $('input.quantity_index_'+id).css('background-color', 'inherit')
                                $(this).siblings().add('td.item-nam_'+id).css({
                                    "border-top-right-radius" : "0",
                                    "border-top-left-radius" : "0",
                                    "border-bottom-right-radius" : "0",
                                    "border-bottom-left-radius" : "0"
                                })
                            },function(){
                                // var parentTr = $(this).closest('tr')
                                $('div.item-detail_'+id).hide()
                                $(this).closest('tr').css("background", "inherit")
                            })

                            // $('.td_price_'+id).hover(function(){
                            //     $('span.item-close_'+id).show()
                            // },function(){
                            //     $('span.item-close_'+id).hide()
                            // })

                            // $('span.item-close_'+id).hover(function(){
                            //     $(this).closest('tr').css('background-color', 'rgb(238, 238, 238)')
                            //     $('input.total'+id).css('background-color', 'inherit')
                            //     $('input.productPrice_'+id).css('background-color', 'inherit')
                            //     $('input.quantity_index_'+id).css('background-color', 'inherit')
                            // },function(){
                            //     $(this).closest('tr').css('background-color', 'inherit')
                            // })


                            //if u keep cursor outside from div it will hide
                            $(document).mouseup(function(e){
                                var container = $("div.popup");
                                if(!container.is(e.target) && container.has(e.target).length === 0) {
                                    container.hide();
                                }
                            });


                            var qtyRowCount = $('.qty-table tbody tr').length
                            if(qtyRowCount != ''){
                                $('button.key-submit').removeAttr('disabled','disabled');
                            }
                        }

                    }

                })

                // After scanning value will auto remove
                element.value = null;

                document.getElementById("qty-tbody").removeAttribute("style");

            }
        })



        $(".discountInput").on('input', function(){
            // console.log('text')
            var getSubprice = $('div.sub-price').text()
            // console.log("getSubprice "+getSubprice)
            var disPrice = parseFloat($(this).val())
            // console.log('disPrice '+disPrice)
            var grandPay = getSubprice - disPrice
            // console.log("grandPay "+grandPay)
            $('div.grand-total-price').find('b').text(parseFloat(grandPay).toFixed(2))
        })


        // $('#percentVal').click(function(){
        //     $(this).addClass('click-p-value')
        //     $('#defaultVal').removeClass('d-value').addClass('d-value-border')
        //     var getSubprice = $('div.sub-price').text()
        //     // console.log("getSubprice "+getSubprice)
        //     var disPrice = parseFloat($('input#discount-input').val())
        //     // console.log('disPrice '+disPrice)
        //     var percentPay = (getSubprice * disPrice) / 100
        //     // console.log('percentPay '+ percentPay)
        //     var grandPay = getSubprice - percentPay
        //     // console.log('grandPay '+ grandPay)
        //     $('div.grand-total-price').find('b').text(parseFloat(grandPay).toFixed(2))
        //     // $('input.vat-input').val(parseFloat(0).toFixed(2))
        //     $('span.pound').text('%')
        // })

        $(document).ready(function(){
            $('input#discount-input').click(function(){
                $('#percentVal').removeClass('click-p-value')
                $('#defaultVal').addClass('d-value').removeClass('d-value-border')
                // $('input.vat-input').val(parseFloat(0).toFixed(2))
                $(this).val(parseFloat(0).toFixed(2))
                var getSubPrice = parseFloat($('div.sub-price').text())
                // console.log('getSubPrice ' + getSubPrice)
                $('div.grand-total-price').find('b').text(parseFloat(getSubPrice).toFixed(2))
                $('span.pound').text('£')
            })
        })



        // $(document).ready(function(){
        //     $('#defaultVal').click(function(){
        //         $(this).addClass('d-value').removeClass('d-value-border')
        //         $('#percentVal').removeClass('click-p-value')
        //         $('input#discount-input').val(parseFloat(0).toFixed(2))
        //         var getSubPrice = parseFloat($('div.sub-price').text())
        //         // console.log('getSubPrice ' + getSubPrice)
        //         // $('input.vat-input').val(parseFloat(0).toFixed(2))
        //         $('div.grand-total-price').find('b').text(parseFloat(getSubPrice).toFixed(2))
        //         $('span.pound').text('£')
        //     })
        // })



        // $(document).ready(function(){
        //     $('input.vat-input').on('input', function(){
        //         var getGrandPay = parseFloat($('div.grand-total-price').find('b').text())
        //         // console.log('getGrandPay ' +getGrandPay)
        //         var vatInput = parseFloat($(this).val())
        //         // console.log('vatInput '+ vatInput)
        //         var discountVal = (getGrandPay * vatInput) / 100
        //         // console.log('discountVal '+ parseFloat(discountVal).toFixed(2))
        //         var grandTotalValue = getGrandPay - discountVal
        //         // console.log('grandTotalValue ' + grandTotalValue)
        //         $('div.grand-total-price').find('b').text(parseFloat(grandTotalValue).toFixed(2))
        //     })
        // })



        $('#percentVal').on('click', function(){
            $('div.discount-in-percen').show()
            $('input#percentInput').focus()
            $(this).css('border-inline', '2px solid var(--cyan)')
        })
        $('#defaultVal').on('click', function(){
            $('div.discount-in-amount').show()
            $('input#defaultInput').focus()
            $(this).css('border-inline', '2px solid var(--cyan)')
        })
        $(document).mouseup(function(e){
            var perTarget = $("div.discount-in-percen");
            var defTarget = $('div.discount-in-amount');
            if(!perTarget.is(e.target) && perTarget.has(e.target).length === 0) {
                perTarget.hide();
                $('#percentVal').css('border-inline', 'inherit')
            }
            if(!defTarget.is(e.target) && defTarget.has(e.target).length === 0){
                defTarget.hide();
                $('#defaultVal').css('border-inline', 'inherit')
            }
        });
        $('#percentInput').on('keyup', function(){
            var subPrice = $('div.sub-price').text()
            console.log('subPrice ' + subPrice)
            var percentVal = $('input#percentInput').val()
            console.log('percentVal ' + percentVal)
            var getPercentValue = parseFloat((subPrice * percentVal) /100)
            console.log('getValue ' + getPercentValue)
            var getValue = subPrice - getPercentValue
            console.log('getValue ' + getValue)
            $('div.discount-input').text(getPercentValue.toFixed(2))
            $('div.grand-total-price b').text(getValue.toFixed(2))
            $('input#total_price').val(parseFloat(getValue).toFixed(2))
        })
        $('#defaultInput').on('keyup', function(){
            var subPrice = $('div.sub-price').text()
            console.log('subPrice ' + subPrice)
            var defaultVal = $('input#defaultInput').val()
            console.log('defaultVal ' + defaultVal)
            var getValue = subPrice - defaultVal
            console.log('getValue ' + getValue)
            if(defaultVal == ''){
                $('div.discount-input').text(parseFloat(0).toFixed(2))
            }else{
                $('div.discount-input').text(parseFloat(defaultVal).toFixed(2))
            }
            $('div.grand-total-price b').text(parseFloat(getValue).toFixed(2))
            $('input#total_price').val(parseFloat(getValue).toFixed(2))
        })


        function removeItem(elem){
            $(elem).closest('tr').remove()
            // $('.qty-table th.action').remove()
            // $(elem).find('.remove-item').remove()
            var storedNamesArray = JSON.parse(localStorage.getItem("names"));
            // console.log("Get stored name " + storedNamesArray)
            var sku = $(elem).closest('tr').find('div.res-sku').text()
            // console.log("delete sku " + sku)
            var index = storedNamesArray.indexOf(sku)
            if(index > -1){
                storedNamesArray.splice(index, 1)
                localStorage.setItem("names", JSON.stringify(storedNamesArray));
            }
            // console.log("Get storedNamesArray " + storedNamesArray)
            var getSubPrice = parseFloat($('div.sub-price').text())
            // console.log('getSubPrice ' + getSubPrice)
            var trTotalPrice = parseFloat($(elem).closest('tr').find('input.t-price').val())
            // console.log('trTotalPrice ' + trTotalPrice)
            var subTotal = getSubPrice - trTotalPrice
            // console.log('subTotal ' + subTotal)
            $('div.sub-price').text(parseFloat(subTotal).toFixed(2))
            $('div.grand-total-price').find('b').text(parseFloat(subTotal).toFixed(2))
            $('input#total_price').val(parseFloat(subTotal).toFixed(2))
            $('.payment-table input').removeClass('p-bottom').val(null)
            $('div.acl').hide()
            var tRowCount = $('#qty-tbody tr').length;
            $('span.badge').text(tRowCount)
            $('input#discount-input').val(parseFloat(0).toFixed(2))
            $('div.discount-input').text(parseFloat(0).toFixed(2))
            // $('input.vat-input').val(parseFloat(0).toFixed(2))
            // $(elem).closest('tr').find('input.productPrice_'+id).addClass('inherit')
            var tRowCount = $('#qty-tbody tr').length;
            // console.log('tRowCount ' + tRowCount)
            if(tRowCount == ''){
                $('div.without-scan-product').show()
                $('table.qty-table').addClass('qty-tbottom')
                $('table.qty-table').removeClass('five-item four-item three-item two-item one-item')
            }
            if(tRowCount == 1){
                $('table.qty-table').removeClass('two-item three-item four-item five-item')
                $('table.qty-table').addClass('one-item')
            }
            else if(tRowCount == 2){
                $('table.qty-table').removeClass('one-item three-item four-item five-item')
                $('table.qty-table').addClass('two-item')
            }
            else if(tRowCount == 3){
                $('table.qty-table').removeClass('one-item two-item four-item five-item')
                $('table.qty-table').addClass('three-item')
            }
            else if(tRowCount == 4){
                $('table.qty-table').removeClass('one-item two-item three-item five-item')
                $('table.qty-table').addClass('four-item')
            }
            else if(tRowCount == 5){
                $('table.qty-table').removeClass('one-item two-item three-item four-item')
                $('table.qty-table').addClass('five-item')
            }

        }



        function removeAllItem(){
            var names = [];
            localStorage.setItem("names", JSON.stringify(names));
            var storedNames = JSON.parse(localStorage.getItem("names"));
            console.log("storedNames is = " + storedNames)
            $('tbody#qty-tbody').find('tr').remove();
            $('div.sub-price').text(parseFloat(0).toFixed(2))
            $('div.grand-total-price').find('b').text(parseFloat(0).toFixed(2))
            $('input#total_price').val(parseFloat(0).toFixed(2))
            $('div.discount-input').text(parseFloat(0).toFixed(2))
            // $('input.discount-input').val(parseFloat(0).toFixed(2))
            // $('input.vat-input').val(parseFloat(0).toFixed(2))
            $('span.badge').text(0)
            $('.payment-table input').removeClass('p-bottom').val(null)
            $('div.acl').hide()
            $('div.without-scan-product').show()
            $('table.qty-table').removeClass('one-item two-item three-item four-item five-item')
            $('table.qty-table').addClass('qty-tbottom')
        }

        // $('span.item-close:eq(1)').click(function(){
        //     console.log('test')
        //     $('table.qty-table').addClass('two-item')
        // })

        //Window load localstorage will empty.
        var names = []
        window.localStorage.setItem("names", JSON.stringify(names));

        //After form submitting localstorage will empty
        $('button.key-submit').click(function(){
            var names = []
            window.localStorage.setItem("names", JSON.stringify(names));
            // var storedNames = JSON.parse(localStorage.getItem("names"));
            // console.log("storedNames = " + storedNames)
        })

        window.onload = function(){
            document.getElementById('read-sku').click();
        }

        // $('#percentVal').hover(function(){
        //     $('div.discount-in-percen').show()
        // },function(){
        //     $('div.discount-in-percen').hide()
        // })

        // $('#defaultVal').hover(function(){
        //     $('div.discount-in-amount').show()
        // },function(){
        //     $('div.discount-in-amount').hide()
        // })

        $('div.item-list').hover(function(){
            $('div.item-hover').show()
        },function(){
            $('div.item-hover').hide()
        })


        $(window).on("load", function() {
            $('input#CreditCard').removeAttr('name', 'payment_method')
        });

        $('div.credit-card').on('click', function(){
            $('input#cash').removeAttr('name')
            $('input#CreditCard').attr('name', 'payment_method')
            $(this).css('background-color', 'blue')
            var getGrandTotal = $('div.grand-total-price b').text()
            $('input#display-operations').val(getGrandTotal)
            $('input#changeAmount').val(parseFloat(0).toFixed(2))
            $("div.acl").show(300)
            $('input.pay-input').addClass('p-bottom')
        })

        $(document).mouseup(function(e){
            var creditCardDiv = $("div.credit-card")
            var button = $('button.key-submit')
            var exactAmountDiv = $('div.exact-amount')
            if(!creditCardDiv.is(e.target) && creditCardDiv.has(e.target).length === 0 && !button.is(e.target)) {
                creditCardDiv.find('input#CreditCard').removeAttr('name')
                $('input#cash').attr('name', 'payment_method')
                $('div.credit-card').removeAttr('style')
            }
            if(!exactAmountDiv.is(e.target) && exactAmountDiv.has(e.target).length === 0){
                $('div.exact-amount').css('background-color', 'rgb(0, 128, 0)')
            }
        })


        $('div.exact-amount').on('click', function(){
            var getGrandTotal = $('div.grand-total-price b').text()
            $('input#display-operations').val(getGrandTotal)
            $('input#changeAmount').val(parseFloat(0).toFixed(2))
            $("div.acl").show(300)
            $('input.pay-input').addClass('p-bottom')
            $('div.exact-amount').css('background-color', 'darkblue')
        })


        //Email validation
        $(document).mouseup(function(e){
            var emailSelector = $('input#email')
            var email = $("input#email").val()
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!emailSelector.is(e.target) && emailSelector.has(e.target).length === 0){
                if($('input#email').val() != ''){
                    if (!filter.test(email)) {
                        $("div.email-error").show().text(email+" is not a valid email")
                        $("div.email-error").css({'border' : '1px solid red', 'color' : 'red'})
                        $('button.key-submit').attr('disabled', 'disabled')
                        email.focus;
                    }
                }
            }
        })

        //Email validation
        $('input#email').keyup(function(e){
            var email = $("input#email").val()
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(filter.test(email)) {
                $("div.email-error").css({'border' : '1px solid green', 'color' : 'green'})
                $("div.email-error").text(email + ' is valid email')
                setTimeout(function(){
                    $("div.email-error").fadeOut("fast")
                }, 1500);
                $('button.key-submit').removeAttr('disabled', 'disabled')
            }
        })


        var vars = {

            displayInfo: document.getElementsByClassName("display-operations")[0],
            ac: document.getElementsByClassName("ac")[0],
            dot: document.getElementsByClassName("dot")[0],
            zero: document.getElementsByClassName("zero")[0],
            dzero: document.getElementsByClassName("dzero")[0],
            one: document.getElementsByClassName("one")[0],
            two: document.getElementsByClassName("two")[0],
            three: document.getElementsByClassName("three")[0],
            four: document.getElementsByClassName("four")[0],
            five: document.getElementsByClassName("five")[0],
            six: document.getElementsByClassName("six")[0],
            seven: document.getElementsByClassName("seven")[0],
            eight: document.getElementsByClassName("eight")[0],
            nine: document.getElementsByClassName("nine")[0],
            dFive: document.getElementsByClassName("dFive")[0],
            ten: document.getElementsByClassName("ten")[0],
            twenty: document.getElementsByClassName("twenty")[0],
            fifty: document.getElementsByClassName("fifty")[0]

        }

        for (var key in vars) {

            if (key === "displayInfo") continue;
            (function(button) {
                // vars[button].addEventListener("click", function() {
                //     console.log(button)
                // calculate(button);
                // });
                $(vars[button]).on("click", function(){
                    console.log("button name " + button)
                    calculate(button);
                })
            })(key);

        }

        function toStr(btn) {
            var btns = {
                one: "1",
                two: "2",
                three: "3",
                four: "4",
                five: "5",
                six: "6",
                seven: "7",
                eight: "8",
                nine: "9",
                zero: "0",
                dzero: "00",
                dFive: "5",
                ten: "10",
                twenty: "20",
                fifty: "50",
                dot: "."
            }
            return btns[btn];
        }

        function removeZero(str) {
            var result = str;

            var dotCond, firstZero;

            for (var i = 0; i < result.length - 1; i++) {

                dotCond = (result[i + 1] !== ".");
                firstZero = (i === 0) && (result[i] === "0") && dotCond;

                if (firstZero) {
                result = result.slice(0, i) + result.slice(i + 1);
                ++i;
                }
            }

            return result

        }


        function calculate(btn) {

            if (btn === "ac") {
            var clearVal = vars.displayInfo.querySelector("#display-operations").value = "0";
            if(clearVal == 0){
                $('div.acl').hide(300)
                $('input.pay-input').removeClass('p-bottom').val(null)
            }
            return;
            }

            var operations = vars.displayInfo.querySelector("#display-operations").value;

            if (operations.length < 15) {
                operations += toStr(btn);
                // console.log('Clicking no ' + operations)
            }

            operations = removeZero(operations);
            var paymentVal = vars.displayInfo.querySelector("#display-operations").value = operations;
            if(paymentVal != ''){
                document.getElementById("display-operations").value = paymentVal
                var payValue = parseFloat(document.getElementById("display-operations").value).toFixed(2)
                var grandPay = parseFloat($("div.grand-total-price").find("b").text()).toFixed(2);
                var changeAmount = payValue - grandPay;
                $("#changeAmount").val(parseFloat(changeAmount).toFixed(2))
                $("div.acl").show(300)
                $('input.pay-input').addClass('p-bottom')
            }

            // console.log('Get no ' + operations)

        }



        function cusPayment(){
            var payValue = parseFloat(document.getElementById("display-operations").value).toFixed(2)
            var grandPay = parseFloat($("div.grand-total-price").find("b").text()).toFixed(2);
            var changeAmount = payValue - grandPay;
            console.log("Change " + changeAmount)
            $("#changeAmount").val(parseFloat(changeAmount).toFixed(2))
            if($('.payment-table input').val() != ''){
                $('div.c-amount').show(300)
                $('input#changeAmount').addClass('p-bottom')
            }else{
                $('div.c-amount').hide(300)
                $('input#changeAmount').removeClass('p-bottom')
            }
        }

        $('.customer-info-table input, .payment-table input').keyup(function(){
            var parentTd = $(this).closest('td')
            if($(this).val() != ''){
                $('div.abc', parentTd).show(300)
                $('input.label-pad', parentTd).addClass('p-bottom')
            }else{
                $('div.abc', parentTd).hide(300)
                $('input.label-pad', parentTd).removeClass('p-bottom')
                $('div.email-error').hide()
            }
        })

        $(document).ready(function(){
            $('.customer-info-table input').each(function(i, obj){
                if(obj.value != ''){
                    $(obj).addClass('p-bottom')
                    $(obj).closest('div.zzz').find('div.abc').show(300)
                }else{
                    $(obj).addClass('customer-info-input-without-val')
                }
                $(obj).keyup(function(){
                    if(obj.value == ''){
                        $(obj).addClass('customer-info-input-without-val')
                    }
                })
            })
        })


        if($('.customer-info-table input, .payment-table input').val() == ''){
            $('input.label-pad').addClass('customer-info-input-without-val')
            $('input.label-pad').removeClass('.label-pad')
        }



        var spinIcon = '<i class="fas fa-spinner fa-pulse ml-2"></i>'
        $('button.key-submit').on('click', function(){
            var qtyRowCount = $('.qty-table tbody tr').length
            if(qtyRowCount == ''){
                $(this).attr('disabled','disabled');
                Swal.fire('Oops.. No Product Found!!','Please scan a product!','warning');
            }
            $(this).append(spinIcon)
            setTimeout(function() {
                $('i.fa-spinner').remove()
            }, 2000);
        })


        //Success Message Show
        @if ($message = Session::get('order_success_message'))
            swal("{{ $message }}", "", "success");
        @endif

        //Error Message Show
        @if ($message = Session::get('error'))
            swal("{{ $message }}", "", "error");
        @endif



    </script>

@endsection
