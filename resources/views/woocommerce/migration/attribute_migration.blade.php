@extends('master')
@section('title')
    Woocommerce Attribute | WMS360
@endsection
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content" >
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">WooCommerce</li>
                            <li class="breadcrumb-item active" aria-current="page">Attribute</li>
                        </ol>
                    </div>
                </div>

                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box shadow">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif

                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                            @if (count($allAttributes) == 0)
                            <ul class="nav nav-tabs" role="tablist" id="attributeTab">
                                <li class="nav-item text-center" style="width: 50%">
                                    <a class="nav-link active" data-toggle="tab" href="#master_attribute_migrate">
                                        Master Attribute Migrate
                                    </a>
                                </li>
                                <li class="nav-item text-center" style="width: 50%">
                                    <a class="nav-link" data-toggle="tab" href="#woocommerce_attribute_migrate">
                                        Woocommerce Attribute Migrate
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content p-50 product-content">
                                <div id="master_attribute_migrate" class="tab-pane active m-b-20">
                                    <div class="m-t-10">
                                        <button type="button" class="btn btn-primary btn-sm migrate-master-attribute">Migrate Attribute From Master</button>
                                    </div>
                                </div>
                                <div id="woocommerce_attribute_migrate" class="tab-pane m-b-20">
                                    <form id="chargeForm" class="m-t-40 mobile-responsive" role="form" action="Javascript:void(0)"  method="post">
                                        <div class="container" >
                                            <div class="card p-20 m-t-10 variation-card">
                                                <button type="button" class="btn btn-primary woocommerceFetchAttribute float-left">Fetch Attribute</button>
                                                <div class="attribute-container attribute-list mt-2">

                                                </div>
                                            </div>
                                        </div>
                                    </form> <!--END FORM-->
                                </div>
                            </div>
                            @endif
                            <button class="btn btn-primary btn-sm add-attribute-term">Add New</button>
                            @if (count($allAttributes) > 0)
                                <h5 class="text-center">Attribute List</h5><hr>
                                <div class="row m-t-10">
                                    <div class="col-md-2"><h5 class="text-center">Attribute</h5></div>
                                    <div class="col-md-10"><h5 class="text-center">Attribute Terms</h5></div>
                                </div>
                                @foreach ($allAttributes as $attribute)
                                <div class="row m-t-10">
                                    <div class="col-md-2 border border-info">
                                        <h6 class="text-center">{{$attribute->attribute_name ?? ''}}</h6>
                                    </div>
                                    <div class="col-md-10 border border-info text-justify">
                                        @if (count($attribute->attributesTerms) > 0)
                                            @foreach ($attribute->attributesTerms as $term)
                                                <div class="border border-info d-inline-block card">
                                                    <div class="mx-2">
                                                        <div class="justify-content-center">{{$term->terms_name}}</div>
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <a href="javascript::void(0)" class="attribute-terms rounded" data="edit/{{$attribute->id}}/{{$term->id}}/{{$term->terms_name}}"><i class="fa fa-edit text-primary"></i></a>
                                                            <a href="javascript::void(0)" class="attribute-terms rounded ml-1" data="delete/{{$attribute->id}}/{{$term->id}}/{{$term->terms_name}}"><i class="fa fa-trash text-danger"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <a id="tooltip_{{$term->id}}" href="#" class="attribute-terms border border-default rounded" data="{{$term->id}}">{{$term->terms_name}},</a> -->
                                                <!-- <button type="button" class="btn btn-outline-info" data-toggle="tooltip" data-html="true" title="<button type='button' class='btn btn-success btn-sm modify-attribute' data='edit/{{$term->id}}'>Edit</button><button type='button' class='btn btn-danger btn-sm modify-attribute ml-2' data='delete/{{$term->id}}'>Delete</button>">
                                                {{$term->terms_name}}
                                                </button> -->
                                                @endforeach
                                        @else
                                            <p>No Terms</p>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            @endif

                        </div>  <!-- card-box -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->
<script>
    $(document).ready(function(){
        $('.woocommerceFetchAttribute').click(function(){
            $.ajax({
                type: "get",
                url: "{{url('woocommerce-attribute-list')}}",
                beforeSend: function(){
                    $('#ajax_loader').show();
                },
                success: function(response){
                    if(response.type == 'success'){
                        var attributeData = '<div class="ml-2"><label for="" class="mb-2">Use as woocommerce variation ? </label> <input type="radio" name="not_variation" id="not_variation" value="1"> Yes <input type="radio" name="not_variation" id="not_variation" value="0"> No</div>'

                        response.data.forEach(function(attribute){
                            attributeData += ''
                            +'<input type="checkbox" class="singleCheckbox ml-2 mr-2" value="'+attribute.id+'/'+attribute.name+'">'+attribute.name+''
                        })
                        attributeData += '<div class="mt-2"><button type="button" class="btn btn-success woocommerceSaveAttribute float-left">Save Attribute</button></div>'
                        $('.attribute-list').html(attributeData)

                    }else if(response.type == 'warning'){
                        Swal.fire({
                            title: response.msg,
                            icon: 'warning'
                        })
                    }else{
                        Swal.fire({
                            title: response.msg,
                            icon: 'error'
                        })
                    }
                    $('#ajax_loader').hide()
                }
            })
        })

        $(document).on('click','.woocommerceSaveAttribute ',function(){
            var attributeIds = [];
            $('div.attribute-list :checkbox:checked').each(function(i){
                attributeIds[i] = $(this).val()
            })
            var useAsVariation = $('input[name="not_variation"]:checked').val()
            if(typeof(useAsVariation) === 'undefined' || attributeIds.length == 0){
                swal.fire({
                    text: 'Please select use as woocommerce variation of Attribute ',
                    icon: 'warning'
                })
                return false
            }
            $.ajax({
                type: "post",
                url: "{{url('woocommerce-save-attribute-migration')}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    "attributeIds": attributeIds,
                    "useAsVariation": useAsVariation
                },
                beforeSend: function(){
                    $('#ajax_loader').show()
                },
                success: function(response){
                    if(response.type == 'success'){
                        Swal.fire({
                            title: response.msg,
                            icon: 'success'
                        })
                    }else if(response.type == 'warning'){
                        Swal.fire({
                            title: response.msg,
                            icon: 'warning'
                        })
                    }else{
                        Swal.fire({
                            title: response.msg,
                            icon: 'error'
                        })
                    }
                    $('#ajax_loader').hide()
                    setTimeout(() => {
                        window.location.reload()
                    }, 3000);
                }
            })
        })

        $('.migrate-master-attribute').click(function(){

            Swal.fire({
            title: 'Are You Sure?',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                let url = "{{asset('master-attribute-migrate-to-woocommerce')}}"
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
                Swal.fire({
                    title: 'Successfully Migrated',
                    icon: 'success'
                })
                setTimeout(() => {
                    window.location.reload()
                }, 3000);
            }
            })
        })

        $('a.attribute-terms').click(function(){
            var explodeVal = $(this).attr('data').split('/')
            var actionType = explodeVal[0]
            var attributeId = explodeVal[1]
            var attributeTermId = explodeVal[2]
            var attributeVal = explodeVal[3]
            if(actionType == 'edit'){
                Swal.fire({
                title: 'Edit Attribute Term',
                input: 'text',
                inputValue: attributeVal,
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                showLoaderOnConfirm: true,
                preConfirm: (inputVal) => {
                    var url = "{{asset('woocommerce/update-attribute-term')}}"
                    var token = "{{csrf_token()}}"
                    var dataObj = {
                        "attribute_id" : attributeId,
                        "attribute_term_id" : attributeTermId,
                        "attribute_term" : inputVal,
                        "_token" : token
                    }
                    return fetch(url,{
                        method: "POST",
                        headers: {
                            "Content-Type" : "application/json"
                        },
                        body: JSON.stringify(dataObj)
                    })
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
                        if(result.value.type == 'success'){
                            Swal.fire({
                                title: "Success",
                                text: result.value.msg,
                                icon: "success"
                            })
                        }else{
                            Swal.fire({
                                title: "Oops!",
                                text: result.value.msg,
                                icon: "error"
                            })
                        }
                        setTimeout(() => {
                            window.location.reload()
                        }, 2000);
                    }
                })
            }else{
                Swal.fire({
                title: 'Are You Sure To Delete This',
                text:'This Will Delete From Woocommerce Also',
                icon:'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    var url = "{{asset('woocommerce/delete-attribute-term')}}"
                    var token = "{{csrf_token()}}"
                    var dataObj = {
                        "attribute_id" : attributeId,
                        "attribute_term_id" : attributeTermId,
                        "_token" : token
                    }
                    return fetch(url,{
                        method: "POST",
                        headers: {
                            "Content-Type" : "application/json"
                        },
                        body: JSON.stringify(dataObj)
                    })
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
                        if(result.value.type == 'success'){
                            Swal.fire({
                                title: "Success",
                                text: result.value.msg,
                                icon: "success"
                            })
                        }else{
                            Swal.fire({
                                title: "Oops!",
                                text: result.value.msg,
                                icon: "error"
                            })
                        }
                        setTimeout(() => {
                            window.location.reload()
                        }, 2000);
                    }
                })
            }
        })

        $('.add-attribute-term').click(function(){
            var url = "{{asset('woocommerce/add-attribute-term')}}"
            var token = "{{csrf_token()}}"
            var dataObj = {
                "action_type" : "get-attribute",
                "_token" : token
            }
            return fetch(url,{
                method: "POST",
                headers: {
                    "Content-Type" : "application/json"
                },
                body: JSON.stringify(dataObj)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json()
            })
            .then(data => {
                var html = '<div class="form-group">'
                +'<label for="attribute">Attribute</label>'
                +'<select class="form-control" name="woo_term" id="woo_term" required>'
                if(data.all_attributes.length > 0){
                    html += '<option value="">Select Variation</option>'
                    data.all_attributes.forEach(function(attribute){
                        html += '<option value="'+attribute.id+'">'+attribute.attribute_name+'</option>'
                    })
                }
                html += '</select></div>'

                Swal.fire({
                    title: 'Add Attribute Term',
                    icon:'warning',
                    html: html,
                    input:'text',
                    inputAttributes: {
                        placeholder: 'Enter Attribute Term',
                        required: true
                    },
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    showLoaderOnConfirm: true,
                    preConfirm: (inputVal) => {
                        var url = "{{asset('woocommerce/add-attribute-term')}}"
                        var token = "{{csrf_token()}}"
                        var attributeId = Swal.getPopup().querySelector('#woo_term').value
                        if (attributeId == '') {
                            Swal.showValidationMessage(`Select Attribute`)
                        }
                        var dataObj = {
                            "action_type" : "add-attribute-term",
                            "attribute_id" : attributeId,
                            "term_value" : inputVal,
                            "_token" : token
                        }
                        return fetch(url,{
                            method: "POST",
                            headers: {
                                "Content-Type" : "application/json"
                            },
                            body: JSON.stringify(dataObj)
                        })
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
                        if(result.value.type == 'success'){
                            Swal.fire({
                                title: "Success",
                                text: result.value.msg,
                                icon: "success"
                            })
                        }else{
                            Swal.fire({
                                title: "Oops!",
                                text: result.value.msg,
                                icon: "error"
                            })
                        }
                        setTimeout(() => {
                            window.location.reload()
                        }, 2000);
                    }
                })
            })
            .catch(error => {
                Swal.showValidationMessage(
                `Request failed: ${error}`
                )
            })
        })


    })
</script>
@endsection

