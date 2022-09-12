@extends('master')
@section('title')
Wms 360 | Order Cancel Reasons
@endsection
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <h5 class="text-center">Order Cancel Reason</h5>
            <div class="row">
                <button type="button" class="btn btn-success float-right mb-3 add-reason">Add Reason</button>
                <table class="table-hover w-100 bg-white">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Reason</th>
                            <th>Increment Quantity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @isset($allOrderCancelReason)
                        @foreach($allOrderCancelReason as $reason)
                            <tr class="text-center border">
                                <td class="text-center" id="reason-{{$reason->id}}">{{$reason->reason ?? ''}}</td>
                                <td class="text-center" id="quantity-{{$reason->id}}">{{($reason->increment_quantity == 1) ? 'Yes' : (($reason->increment_quantity == 0) ? 'No' : 'Nothing')}}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary edit-reason" id="{{$reason->id}}">Edit</button>
                                    <button type="button" class="btn btn-danger delete-reason" id="{{$reason->id}}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    @endisset
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.add-reason').click('on',function(){
            Swal.fire({
                title: 'Add Reason',
                html: '<input type="text" id="reason" class="form-control" value="" placeholder="Enter Reason"><p>Quantity increment</p><div class="form-check-inline">'
                +'<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="1" checked>Yes'
                +'<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="0">No'
                +'<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="2">No Action'
                +'</div>',
                showCancelButton: true,
                // confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Add',
                closeOnConfirm: true,
                showLoaderOnConfirm: true,
                focusConfirm: false,
                preConfirm: () => {
                    const reason = Swal.getPopup().querySelector('#reason').value
                    const incrementQuantity = Swal.getPopup().querySelector('input[name="increment_quantity"]:checked').value
                    if(!reason || !incrementQuantity){
                        Swal.showValidationMessage(`Invalid reason or increment quantity`)
                    }
                    let url = "{{asset('add-order-cancel-reason')}}"
                    let token = "{{csrf_token()}}"
                    return fetch(url, {
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json, text-plain, */*",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": token
                            },
                        method: 'post',
                        body: JSON.stringify({
                            reason: reason,
                            increment_quantity: incrementQuantity
                        })
                    })
                    .then((response) => {
                        if(!response.ok){
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(function(error) {
                        Swal.showValidationMessage(`Request failed: ${error}`)
                    });
                }               
            }).then(result => {
                if(result.isConfirmed){
                    Swal.fire({
                        title: `${result.value.msg}`,
                        icon: 'success'
                    })
                }
            })
        })

        $('.edit-reason').on('click',function(){
            let reasonId = $(this).attr('id')
            let reason = $('#reason-'+reasonId).text()
            let isQuantityIncrement = $('#quantity-'+reasonId).text()
            var htmlContent = '<input type="text" id="reason" class="form-control" value="'+reason+'" placeholder="Enter Reason"><p>Quantity increment</p><div class="form-check-inline">'
            if(isQuantityIncrement == 'Yes'){
                htmlContent += '<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="1" checked>Yes<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="0">No<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="2">No Action'
            }else if(isQuantityIncrement == 'No'){
                htmlContent += '<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="1">Yes<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="0" checked>No<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="2">No Action'
            }else{
                htmlContent += '<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="1">Yes<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="0">No<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="2" checked>No Action'
            }
            htmlContent += '</div>'
            Swal.fire({
                title: 'Edit Reason',
                html: htmlContent,
                showCancelButton: true,
                confirmButtonColor: '#81c868',
                confirmButtonText: 'Update',
                closeOnConfirm: true,
                showLoaderOnConfirm: true,
                focusConfirm: false,
                preConfirm: () => {
                    const reason = Swal.getPopup().querySelector('#reason').value
                    const incrementQuantity = Swal.getPopup().querySelector('input[name="increment_quantity"]:checked').value
                    if(!reason || !incrementQuantity){
                        Swal.showValidationMessage(`Invalid reason or increment quantity`)
                    }
                    let url = "{{asset('update-order-cancel-reason')}}"
                    let token = "{{csrf_token()}}"
                    return fetch(url,{
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json, text-plain, */*",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": token
                            },
                        method: 'post',
                        body: JSON.stringify({id: reasonId, reason: reason, incQuantity: incrementQuantity})
                    })
                    .then((response) => {
                        if(!response.ok){
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(function(error) {
                        Swal.showValidationMessage(`Request faliled: ${error}`)
                    })
                }
            })
            .then(result => {
                if(result.isConfirmed){
                    Swal.fire({
                        title: result.value.msg,
                        icon: 'success'
                    })
                }
            })
        })

        $('.delete-reason').click('on', function(){
            let id = $(this).attr('id')
            Swal.fire({
                title: 'Do you want to delete it ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Delete',
                closeOnConfirm: true,
                showLoaderOnConfirm: true,
                focusConfirm: false,
                preConfirm: () => {
                    let url = "{{asset('delete-order-cancel-reason')}}"
                    let token = "{{csrf_token()}}"
                    return fetch(url,{
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json, text-plain, */*",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": token
                            },
                        method: 'post',
                        body: JSON.stringify({id: id})
                    })
                    .then((response) => {
                        if(!response.ok){
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(function(error){
                        Swal.showValidationMessage(`Request failed: ${error}`)
                    })
                }
            })
            .then(result => {
                if(result.isConfirmed){
                    Swal.fire({
                        title: result.value.msg,
                        icon: 'success'
                    })
                }
            })
        })
    })
</script>
@endsection