@extends('master')
@section('title')
    Search OnBuy Product | WMS360
@endsection
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Onbuy</li>
                            <li class="breadcrumb-item active" aria-current="page">Search OnBuy Product</li>
                        </ol>
                    </div>
                </div>
                <div id="Load" class="load" style="display: none;">
                    <div class="load__container">
                        <div class="load__animation"></div>
                        <div class="load__mask"></div>
                        <span class="load__title">Content is loading...</span>
                    </div>
                </div>
                <div class="row m-t-20 onbuy-product">
                    <div class="col-md-12">
                        <div class="card-box py-5 shadow">
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
                            <div class="container">
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-2">
                                        <label class="required">Search</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control serch-term" placeholder="Enter Search Term Here">
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control select2 search-field">
                                            <option value="">Select Search Type</option>
                                            <option value="name">Name</option>
                                            <option value="product_code">Product Code</option>
                                            <option value="opc">OPC</option>
                                            <option value="mpn">MPN</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-default search-button" onbuy-data="0">Search</button>
                                    </div>
                                </div>
                            </div>
                            <div id="product_data">

                            </div>
                        </div> <!--//End card-box -->
                    </div><!--//End col-md-12 -->
                </div><!--//End row -->
            </div> <!-- // End Container-fluid -->
        </div> <!-- // End Content -->
    </div> <!-- // End Contact page -->

    <script>
        $('.select2').select2();
        $('.onbuy-product').on('click','.search-button',function(){
            var searchTerm = $('input.serch-term').val()
            var searchField = $('select.search-field').val()
            if(searchTerm == '' || searchField == ''){
                Swal.fire('Oops!','Please Select Required Fields')
                return false
            }
            let page = $(this).attr('onbuy-data')
            $.ajax({
                type: "post",
                url: "{{url('onbuy/search-product-on-onbuy')}}",
                data:{
                    "_token":"{{csrf_token()}}",
                    "searchTerm" : searchTerm,
                    "searchField" : searchField,
                    "page" : page
                },
                beforeSend: function (){
                    $('#ajax_loader').show();
                },
                success: function (response) {
                    $('#product_data').html(response);
                    $('.onbuy-product .load-more').attr('onbuy-data',parseInt(page) + 1)
                    $('.onbuy-product .load-more').removeClass('d-none').addClass('d-block')
                },
                complete: function (data) {
                    $('#ajax_loader').hide();
                }
            })
        });

        $(document).ready(function(){
            $('.onbuy-product').on('click','.search_catalogue',function(){
                let searchTerm = $('.onbuy-product #catalogue_search_modal').val()
                let url = "{{url('/get-catalog')}}"
                let token = "{{csrf_token()}}"
                let loadData = $('')
                let page = $(this).attr('data');
                let dataObj = {
                    "page" : page,
                    "searchTerm" : searchTerm,
                    "_token" : token
                    }
                fetch(url, {
                    method: 'POST', // or 'PUT'
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(dataObj),
                    })
                    .then(response => response.json())
                    .then(data => {
                        var htmlData = ''
                        var opc = localStorage.getItem("onbuy_opc")
                        if(data.length > 0){
                            data.forEach((content) => {
                                let masterImage = content.image_url ? content.image_url : ''
                                htmlData += '<tr data-toggle="collapse" data-target="#accordion'+content.id+'" class="clickable">'
                                    +'<td><img src="'+masterImage+'" alt="" width="40" height="40"></td>'
                                    +'<td>'+content.name+'</td>'
                                +'</tr>'
                                +'<tr>'
                                    +'<td colspan="2">'
                                        +'<div id="accordion'+content.id+'" class="collapse">'
                                        content.products.forEach((product) => {
                                            var url = "{{url('/')}}"+'/onbuy/add-exist-ean-listing/?catalogue_id='+content.id+'&exist_ean='+product.ean_no+'&exist_opc='+opc+'&product_id='+product.id
                                            htmlData +='<div class="row m-t-5">'
                                                +'<div class="col-md-1">'+product.id+'</div>'
                                                +'<div class="col-md-1"><img src="'+product.image+'" alt="" width="40" height="40"></div>'
                                                +'<div class="col-md-3">'+product.variation+'</div>'
                                                +'<div class="col-md-3">'+product.sku+'</div>'
                                                +'<div class="col-md-2">'+product.ean_no+'</div>'
                                                +'<div class="col-md-2">'
                                                htmlData += '<a href="'+url+'" class="btn btn-info btn-sm" target="_blank">Click To List</a>'
                                                htmlData +='</div>'
                                            +'</div>'
                                        })
                                        htmlData +='</div>'
                                    +'</td>'
                                +'</tr>'
                            })
                            $('.catalogue-content .search_catalogue').removeClass('d-none').addClass('d-block')
                        }else{
                            htmlData = '<div class="alert alert-danger">No Product Found</div>'
                            $('.catalogue-content .search_catalogue').removeClass('d-block').addClass('d-none')
                        }
                        $('table tbody').html(htmlData)

                        $('.catalogue-content .search_catalogue').attr('data', parseInt(page) + 1)
                    })
                    .catch((error) => {
                    console.error('Error:', error);
                });
            })

            $('.onbuy-product').on('click','.add-listing',function(){
                let onbuyOpc = $(this).attr('id')
                localStorage.setItem("onbuy_opc",onbuyOpc)
            })
        })

    </script>

@endsection
