@extends('master')
@section('content')

<style>
    .customSwalBtn{
        background-color: var(--wms-primary-color)!important;
        border-left-color: var(--wms-primary-color)!important;
        border-right-color: var(--wms-primary-color)!important;
        border: 0;
        border-radius: 3px;
        box-shadow: none;
        color: #fff;
        cursor: pointer;
        font-size: 17px;
        font-weight: 500;
        margin: 30px 5px 0px 5px;
        padding: 10px 32px;
    }
    html.swal2-shown,body.swal2-shown {
        overflow-y: hidden !important;
        height: auto!important;
    }

</style>

<script>
    $(function(){
        $( ".sortable" ).sortable({
            cursor: 'move'
        });
        $( ".sortable" ).disableSelection();
    });

        @if($listingLimitAllChannelActiveProduct >= $clientListingLimit)
            $(window).on('load',function(){
                Swal.fire({
                    icon: 'error',
                    title: 'You have reached your listing limit!',
                    showConfirmButton: false,
                    width: 800,
                    height: 600,
                    overFlow: false,
                    padding: '3em',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    html: '<div>'+
                          '    (Listing limit = '+{!! json_encode($clientListingLimit) !!}+','+
                          '    Listed product = '+{!! json_encode($listingLimitInfo['subTotalActiveProduct'] ?? 0) !!}+')'+
                          '<br>'+
                          '    (Active catalogue product = '+{!! json_encode($listingLimitInfo['activeCatalogueCount'] ?? 0) !!}+','+
                          '    WoCommerce active product = '+{!! json_encode($listingLimitInfo['wooActiveProductCount'] ?? 0) !!}+','+
                          '    OnBuy active product = '+{!! json_encode($listingLimitInfo['onbuyActiveProductCount'] ?? 0) !!}+','+
                          '    eBay active product = '+{!! json_encode($listingLimitInfo['ebayActiveProductCount'] ?? 0) !!}+','+
                          '    Amazon active product = '+{!! json_encode($listingLimitInfo['amazonActiveProductCount'] ?? 0) !!}+','+
                          '    Shopify active product = '+{!! json_encode($listingLimitInfo['shopifyActiveProductCount'] ?? 0) !!}+')'+
                          ' </div>'+
                          '<div class="d-flex justify-content-center">'+
                          '      <div>'+
                          '         <a class="btn btn-custom customSwalBtn" href="https://www.wms360.co.uk/my-account/">Upgrade</a>'+
                          '      </div>'+
                          '      <div>'+
                          '          <a class="btn btn-custom customSwalBtn" href="{{url('dashboard')}}">Dashboard</a>'+
                          '      </div>'+
                          '</div>'
                })
            });
        @endif

</script>

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="card-box">
                <form action="{{asset(url('amazon/save-amazon-product'))}}" method="post">
                @csrf
                <h5 class="text-center">Create Product In Amazon</h5><hr>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-danger">
                        {{Session::get('error')}}
                    </div>
                @endif
                    <div class="row m-t-30">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="amazon_application_id" class="col-md-2 col-form-label required">Amazon Application</label>
                                <div class="col-md-6 wow pulse">
                                    <select class="form-control" name="amazon_application_id" id="amazon_application_id" required>
                                        @if(isset($amazonApplicationInfo) && (count($amazonApplicationInfo) > 0))
                                            <option value="">Select Site</option>
                                            @foreach($amazonApplicationInfo as $application)
                                                <option value="{{$application->id ?? ''}}">{{$application->application_name ?? ''}}({{$application->accountInfo->account_name ?? ''}}/{{$application->marketPlace->marketplace ?? ''}})</option>
                                            @endforeach
                                        @endif
                                   </select>
                                </div>
                                @if(isset($amazonApplicationInfo) && (count($amazonApplicationInfo) == 0))
                                    <a href="{{url('amazon/add-application')}}" class="btn btn-info btn-xs">Create Here</a>
                                @endif
                            </div>
                            <input type="hidden" name="master_catalogue_id" id="master_catalogue_id" value="{{$masterCatalogueInfo->id}}">
                            <div class="card card-box amazon-exist-product-div loading">
                            <div id='loader' style='display: none;justify-content: center'>
                                <img src='https://www.istitutomarangoni.com/fe-web/img/marangoni/loader.gif'>
                            </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('select#amazon_application_id').on('change',function(){
            var applicationId = $(this).val()
            if(applicationId == ''){
                return false
            }
            var masterCatalogueId = $('#master_catalogue_id').val()
            var url = "{{asset('amazon/exist-product-check')}}"
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    "_token": "{{csrf_token()}}",
                    "masterCatalogueId": masterCatalogueId,
                    "applicationId": applicationId
                },
                beforeSend: function(){
                    $("#ajax_loader").addClass('d-flex').show()
                },
                success: function(response){
                    $('div.amazon-exist-product-div').html(response.html)
                    $("#ajax_loader").hide()
                }

            })
        })

        $('.amazon-exist-product-div').on('click','.remove-amazon-ajax-product-div',function(){
            $(this).closest('div.amazon-exist-product-container').remove()
        })

        $('.amazon-exist-product-div').on('click','.list-product-indivisually',function(){
            let selector = $(this).closest('div.amazon-exist-product-container')
            let id = selector.find('#master_variation_id').val()
            let ean = selector.find('#master_variation_ean').val()
            let asin = selector.find('#amazon_variation_asin').val()
            let attribute = selector.find('#master_variation_attribute').val()
            let sku = selector.find('#sku').val()
            let salePrice = selector.find('#sale_price').val()
            let quantity = selector.find('#quantity').val()
            let isMasterEditable = selector.find('#isMasterEditable').val()
            let itemCondition = $('select[name="item_condition"]').val()
            let productType = $('select[name="product_type"]').val()
            if(productType == ''){
                Swal.fire('Oops!','Please Select Product Type','warning')
                return false
            }
            let existMasterCatalogueId = $('input[name="exists_master_catalogue_id"]').val()
            Swal.fire({
                title:'Are You Sure To List This Product ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    let url = "{{asset('amazon/save-single-amazon-product')}}"
                    let token = "{{csrf_token()}}"
                    let dataObj = {
                        variationId: id,
                        ean: ean,
                        asin: asin,
                        attribute: attribute,
                        sku: sku,
                        salePrice: salePrice,
                        quantity: quantity,
                        isMasterEditable: isMasterEditable,
                        itemCondition: itemCondition,
                        productType: productType,
                        existMasterCatalogueId: existMasterCatalogueId
                    }
                    return fetch(url, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': token
                        },
                        method: 'post',
                        body: JSON.stringify(dataObj)
                    })
                    .then(response => {
                        if(!response.ok){
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Request Failed: ${error}`)
                    })
                }
            })
            .then(result => {
                if(result.isConfirmed){
                    if(result.value.type == 'success'){
                        Swal.fire('Success',result.value.msg,'success')
                        $('.show-success-icon-'+id).removeClass('d-none')
                    }else{
                        Swal.fire('Oops!',result.value.msg,'error')
                    }
                }
            })
        })

        $('.amazon-exist-product-div').on('click','.migrate-amazon-product-type',function(){
            var applicatinId = $('select[name="amazon_application_id"]').val()
            console.log(applicatinId)
            Swal.fire({
                title:'Are You Sure ?',
                text: 'Product Type Will Migrate Depending On Your Above Application Or Market Place',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    let url = "{{asset('amazon/migrate-product-type')}}"
                    let token = "{{csrf_token()}}"
                    let dataObj = {
                        applicationId: applicatinId,
                    }
                    return fetch(url, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': token
                        },
                        method: 'post',
                        body: JSON.stringify(dataObj)
                    })
                    .then(response => {
                        if(!response.ok){
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Request Failed: ${error}`)
                    })
                }
            })
            .then(result => {
                if(result.isConfirmed){
                    console.log(result.value)
                    if(result.value.type == 'success'){
                        if(result.value.data.length == 0){
                            Swal.fire('Oops!',result.value.msg,'error')
                        }else{
                            var option = '<option value="">Select Product Type</option>'
                            result.value.data.forEach(function(type){
                                option += '<option value="'+type.name+'">'+type.name+'</option>'
                            })
                            $('.amazon-exist-product-div .amazon-product-type-option').html(option)
                            $('.amazon-exist-product-div .migrate-amazon-product-type').remove()
                            Swal.fire('Success',result.value.msg,'success')
                        }
                    }else{
                        Swal.fire('Oops!',result.value.msg,'error')
                    }
                }
            })
        })
        $('.amazon-exist-product-div').on('click','.switch-editable-option',function (){
            isMasterEditable = $(this).is(':checked') == true ? 1 : 0;
            $(this).val(isMasterEditable)
        })
    })
</script>
@endsection
