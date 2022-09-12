

                @if (Session::has('attribute_delete_success_msg'))
                    <div class="alert alert-danger">
                        {!! Session::get('attribute_delete_success_msg') !!}
                    </div>
                @endif
                        

{{--                            <div class="m-b-10 m-t-10">--}}
{{--                                <div class="product-inner">--}}
{{--                                    <div class="table-list"></div>--}}
{{--                                    <div class="row-wise-search table-terms">--}}
{{--                                        <input class="form-control mb-1" id="row-wise-search" type="text" placeholder="Row Wise Search....">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}


                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if (Session::has('attribute_edit_success_msg'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {!! Session::get('attribute_edit_success_msg') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif



                            <table id="" class="attribute-table w-100">
                                <thead>
                                <tr>
                                    <th class="text-center w-33">Variation Name</th>
                                    <th class="text-center w-33">Use As Variation</th>
                                    <th class="text-center w-33">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($all_attribute)
                                    @foreach($all_attribute as $attribute)
                                        <tr>
                                            <td class="text-center w-33">{{$attribute->attribute_name}}</td>
                                            <td class="text-center w-33 choice-attribute-id-{{$attribute->id}}"><span>{{($attribute->use_variation == 1) ? 'Yes' : 'No'}}</span><button class="btn btn-success btn-sm ml-2" onclick="useAttributeAsVariationModify({{$attribute->id}},{{$attribute->use_variation}})">Change</button></td>
                                            <td class="text-center w-33 actions">
{{--                                                <a href="{{url('attribute/'.$attribute->id.'/edit')}}" ><button class="vendor_btn_edit btn-primary">Edit</button></a>&nbsp;--}}
                                                <a href="#editAttributeList{{$attribute->id}}" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn-size edit-btn" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></button></a>&nbsp;
{{--                                                <a href="{{url('attribute/'.$attribute->id)}}" ><button class="vendor_btn_view btn-success">View</button></a>&nbsp;--}}
{{--                                                <form action="{{url('attribute/'.$attribute->id)}}" method="post">--}}
{{--                                                    @method('DELETE')--}}
{{--                                                    @csrf--}}
{{--                                                    <a href="#" class="on-default remove-row" ><button class="vendor_btn_delete btn-danger" onclick="return check_delete('attribute');">Delete</button>  </a>--}}
{{--                                                </form>--}}

                                                <!-- Modal -->
                                                <div id="editAttributeList{{$attribute->id}}" class="modal-demo">
                                                    <button type="button" class="close" onclick="Custombox.close();">
                                                        <span>&times;</span><span class="sr-only">Close</span>
                                                    </button>
                                                    <h4 class="custom-modal-title">Edit Attribute Name</h4>
                                                    <form role="form" class="vendor-form mobile-responsive" action="{{url('attribute/'.$attribute->id)}}" method="post">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="form-group c_attribute_terms row">
                                                            <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Attribute Name</label>
                                                            <div class="col-md-9 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                                <input type="text" name="attribute_name" class="form-control" id="attribute_name" value="{{ $attribute->attribute_name ? $attribute->attribute_name:old('attribute_name') }}" placeholder="Enter attribute name" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-12 text-center mb-5 mt-3">
                                                                <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                                                                    <b>Update</b>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                                <!-- Modal -->

                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset
                                </tbody>
                            </table>

<script>
    function useAttributeAsVariationModify(attributeId,value){
        event.preventDefault();
        var url = "{{url('attribute-as-variation-modify')}}"+'/'+attributeId+'/'+value
        Swal.fire({
            title: 'This will change you variation choice for woocommerce',
            showCancelButton: true,
            confirmButtonText: 'Change',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch(url)
                .then(response => {
                    if (!response.ok) {
                    throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                    `Request failed: ${error}`
                    )
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                $('tr td.choice-attribute-id-'+attributeId+' span').text(value == 1 ? 'No' : 'Yes');
                Swal.fire('Success','Variation choice changed successfully','success')
            }
        })
    }
</script>
