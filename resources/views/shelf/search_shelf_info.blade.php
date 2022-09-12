

@isset($search_shelf_info)
    @foreach($search_shelf_info as $index => $shelf)
        <tr>
            <td style="width: 6%; text-align: center !important;">
                {{--                                                    <input type="checkbox" class="checkBoxClass" id="customCheck{{$pending->id}}" name="multiple_order[]" value="{{$pending->id}}">--}}
                <input type="checkbox" class="checkBoxClass" id="checkItem{{$index}}" name="masterProduct[{{$index}}]" value="{{$shelf->id}}">
            </td>
            <td style="text-align: center !important;">{{$shelf->id}}</td>
            <td style="text-align: center !important;">{{$shelf->shelf_name}}</td>
            @php
                $data = 0;
            @endphp
            @foreach($shelf->total_product as $total)
                @php
                    $data += $total->pivot->quantity;
                @endphp
            @endforeach
            <td style="text-align: center !important;">{{$data}}</td>
            <td style="text-align: center !important;">
                <span class="d-flex justify-content-center align-items-center">
                    <span class="d-flex justify-content-center align-items-center mr-2"> {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(60)->generate($shelf->id); !!} </span>
                    <span class="d-flex justify-content-center align-items-center"><a href="{{url('print-shelf-barcode/'.$shelf->id)}}" class="btn btn-success print-barcode-btn" target="_blank">Print Qrcode</a></span>
                </span>
            </td>
            <td style="text-align: center !important;">{{$shelf->user->name}}</td>
            <td class="shelf-action" style="width: 10% !important;">

                <!--action button-->
                <div class="action-1">

                    @if (Auth::check() && in_array('1',explode(',',Auth::user()->role)) || in_array('2',explode(',',Auth::user()->role)))
                        <a class="btn-size edit-btn mr-2" href="#editShelfList{{$shelf->id}}" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"  data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                        <a class="btn-size view-btn mr-2" href="{{url('shelf/'.Crypt::encrypt($shelf->id))}}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    @else
                        <a class="btn-size view-btn mr-2" href="{{url('shelf/'.Crypt::encrypt($shelf->id))}}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    @endif

                    <a class="btn-size migrate-btn dropdown-toggle" data-toggle="dropdown" href="" data-placement="top" title="Migrate"><i class="fas fa-exchange-alt"></i></a>
                    <div class="dropdown-menu filter-content shadow" role="menu">
                        <form action="{{url('shelf-migration')}}" method="post">
                            @csrf
                            <p class="mb-1">Migrate To</p>
                            <select class="form-control select2" name="to_id">
                                <option value="">Select Shelf</option>
                                @foreach($shelfs as $migrate_shelf)
                                    @if($migrate_shelf->id != $shelf->id)
                                        <option value="{{$migrate_shelf->id}}">{{$migrate_shelf->shelf_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <input type="hidden" name="from_id" value="{{$shelf->id}}">
                            <button type="submit" class="btn btn-primary filter-apply-btn float-right mt-2">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                        </form>
                    </div>
                </div>


                <!-- Edit Shelf Modal -->
                <div id="editShelfList{{$shelf->id}}" class="modal-demo">
                    <button type="button" class="close" onclick="Custombox.close();">
                        <span>&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h4 class="custom-modal-title">Change Shelf Name</h4>
                    <form role="form" class="vendor-form mobile-responsive" action="{{url('shelf/'.$shelf->id)}}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <label for="name" class="col-md-2 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Shelf Name</label>
                            <div class="col-md-8 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                <input type="text" name="shelf_name" class="form-control" id="shelf_name" value="{{ $shelf->shelf_name ? $shelf->shelf_name : old('shelf_name') }}" placeholder="Enter Shelf Name" required>
                            </div>
                            <div class="col-md-1"></div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 text-center  mb-5 mt-3">
                                <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                                    <b>Update</b>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!--End Edit Shelf Modal -->
            </td>
        </tr>
    @endforeach
@endisset


<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>



    <!-- Custombox -->
    <link href="{{asset('assets/plugins/custombox/css/custombox.css')}}" rel="stylesheet">

    <!-- Modal-Effect -->
    <script src="{{asset('assets/plugins/custombox/js/custombox.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custombox/js/legacy.min.js')}}"></script>



<script>

    //Select 2 dropdown
    $('.select2').select2();

    //prevent onclick dropdown menu close
    $('.filter-content').on('click', function(event){
        event.stopPropagation();
    });


</script>
