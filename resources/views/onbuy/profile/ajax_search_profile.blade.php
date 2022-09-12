
@isset($profile_lists)
    @foreach($profile_lists as $key => $profile)
        <tr>
            {{--                                            <td>--}}
            {{--                                                <input type="checkbox" class=" checkBoxClass" id="customCheck{{$profile->id}}" name="multiple_checkbox[]" value="{{$profile->id}}">--}}
            {{--                                            </td>--}}
            <td style="text-align: center !important; cursor: pointer" data-toggle="collapse" data-target="#demo{{$profile->id}}" class="accordion-toggle">{{$profile->last_category_id}}</td>
            <td style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$profile->id}}" class="accordion-toggle">{{$profile->name}}</td>
            <td style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$profile->id}}" class="accordion-toggle">
                @foreach(unserialize($profile->category_ids) as $category)
                    / {{\App\OnbuyCategory::find($category)->name}}
                @endforeach
            </td>
            <td style="cursor: pointer; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$profile->id}}" class="accordion-toggle">
                {{\App\OnbuyBrand::find($profile->brand)->name}}</td>
            <td>
                <div class="btn-group dropup">
                    <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Manage
                    </button>
                    <div class="dropdown-menu">
                        <!-- Dropdown menu links -->
                        <div class="dropup-content onbuy-dropup-content">
                            <div class="d-flex justify-content-start align-items-center">
{{--                                <a href="{{url('onbuy/edit-profile/'.$profile->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit Profile">Edit</a>--}}
                                <div class="mr-2"><a class="btn-size edit-btn" href="{{url('onbuy/edit-profile/'.$profile->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit Profile"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                <div>
                                    <form action="{{url('onbuy/delete-onbuy-profile/'.$profile->id)}}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        {{--                                    <a href="#" class="on-default remove-row" data-toggle="tooltip" data-placement="top" title="Delete Profile">--}}
                                        {{--                                        <button class="btn btn-danger btn-sm"--}}
                                        {{--                                                onclick="return check_delete('profile');">Delete--}}
                                        {{--                                        </button>--}}
                                        {{--                                    </a>--}}
                                        <button class="del-pub delete-btn mt-0 on-default remove-row" style="cursor: pointer" href="#" onclick="return check_delete('profile');" data-toggle="tooltip" data-placement="top" title="Delete Profile"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="5" class="hiddenRow">
                <div class="accordian-body collapse" id="demo{{$profile->id}}">
                    <div class="row">
                        <div class="col-12">
                            <div class="card p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                                <!--- Shipping Billing --->
                                <div style="border: 1px solid #ccc"
                                     class="m-t-20">
                                    <div class="row px-4 py-3">
                                        <div class="col-md-6">
                                            <div class="d-block mb-5">
                                                <h6> Summary Points </h6>
                                                <hr class="m-t-5 float-left"
                                                    width="50%">
                                            </div>
                                            <div class="row">
                                                <div class="d-flex justify-content-start mb-1">
                                                    <div class="content-right">
                                                        @isset($profile->summery_points)
                                                            <ol>
                                                                @foreach(unserialize($profile->summery_points) as $summary)
                                                                    <li>{{$summary}}</li>
                                                                @endforeach
                                                            </ol>
                                                        @endisset
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-block mb-5">
                                                <h6> Product Data </h6>
                                                <hr class="m-t-5 float-left"
                                                    width="50%">
                                            </div>
                                            @isset($profile->master_product_data)
                                                @foreach(unserialize($profile->master_product_data) as $key => $value)
                                                    <div class="row">
                                                        <div class="col-md-3 m-b-5">{{$key}}</div>
                                                        <div class="col-md-9 m-b-5">{{$value}}</div>
                                                    </div>
                                                @endforeach
                                            @endisset
                                        </div>
                                    </div>
                                    <div class="row px-4 py-3">
                                        <div class="col-md-6">
                                            <div class="d-block mb-5">
                                                <h6> Features </h6>
                                                <hr class="m-t-5 float-left"
                                                    width="50%">
                                            </div>
                                            @isset($profile->features)
                                                @foreach(unserialize($profile->features) as $value)
                                                    <div class="row">
                                                        <div class="col-md-3 m-b-5">{{$value ? explode('/',$value)[1] : ''}}</div>
                                                        <div class="col-md-9 m-b-5">{{$value ? explode('/',$value)[2] : ''}}</div>
                                                    </div>
                                                @endforeach
                                            @endisset
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-block mb-5">
                                                <h6> Technical Details </h6>
                                                <hr class="m-t-5 float-left"
                                                    width="50%">
                                            </div>
                                            @isset($profile->technical_details)
                                                @foreach(unserialize($profile->technical_details) as $value)
                                                    <div class="row">
                                                        <div class="col-md-3 m-b-5">{{$value ? explode('/',$value)[0] : ''}}</div>
                                                        <div class="col-md-9 m-b-5">{{$value ? explode('/',$value)[1] : ''}}</div>
                                                    </div>
                                                @endforeach
                                            @endisset
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col-12 -->
                    </div> <!-- end row -->
                </div> <!-- end accordion body -->
            </td> <!-- hide expand td-->
        </tr> <!-- hide expand row-->
    @endforeach
@endisset

