@extends('master')
@section('title')
    Channels | WMS360
@endsection
@section('content')

<style>
    .circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex; /* or inline-flex */
        align-items: center;
        justify-content: center;
    }
</style>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="d-flex justify-content-start align-items-center">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Channels</li>
                            <li class="breadcrumb-item active" aria-current="page">Available Channel</li>
                        </ol>
                    </div>
                </div>

                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box shadow add-draft">
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

                            @if ($message = Session::get('warning'))
                                <div class="alert alert-warning alert-block">
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
                            <h5 class="text-center">Channel List</h5>
                            <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">Channel</th>
                                <th scope="col">Logo</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($allChannel) > 0)
                                    @foreach ($allChannel as $channel)
                                        <tr>
                                            <td>{{$channel->channel}}</td>
                                            <td>
                                                <img src="{{$channel->logo ?? asset('assets/common-assets/no_image.jpg')}}" class="rounded-circle" alt="" style="width:50px; height: 50px" />
                                            </td>
                                            @if ($channel->is_active == 1)
                                                <td><span class="circle bg-success" title="Linked"><i class="fas fa-link"></i></span></td>
                                            @else
                                                <td><span class="circle bg-danger" title="Unliked"><i class="fas fa-link"></i></span></td>
                                            @endif
                                            <td>
                                                <button type="button" class="btn btn-primary set-connectoin" data="change/{{$channel->id}}/{{$channel->channel}}/{{$channel->is_active}}" title="Edit Info"><i class="fa fa-edit"></i></button>
                                                <!-- <button type="button" class="btn btn-primary modify-channel" data="edit/{{$channel->id}}/{{$channel->channel}}"><i class="fa fa-edit"></i></button>
                                                <button type="button" class="btn btn-danger modify-channel" data="delete/{{$channel->id}}/{{$channel->channel}}"><i class="fa fa-trash"></i></button> -->
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            </table>
                            <div class="modal fade" id="channelInfoModal" tabindex="-1" role="dialog" aria-labelledby="channelInfoModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5>Update Channel Info</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{asset('channels/change-channel-statue')}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="container" id="channel-info">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  <!-- card-box -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->
    <!----- ckeditor summernote ------->
    <script>
        $(document).ready(function(){
            $('.modify-channel').click(function(){
                var splitVal = $(this).attr('data').split('/')
                var actionType = splitVal[0]
                var channelId = splitVal[1]
                var channel = splitVal[2]
                console.log(splitVal)
                if(actionType == 'edit'){
                    Swal.fire({
                        title: 'Edit Channel',
                        input: 'text',
                        inputValue: channel,
                        showCancelButton: true,
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        showLoaderOnConfirm: true,
                        preConfirm: (inputVal) => {
                            console.log(inputVal)
                            var url = "{{asset('channels')}}"+'/'+channelId
                            var token = "{{csrf_token()}}"
                            var dataObj = {
                                "channel": inputVal,
                                "_token": token
                            }
                            return fetch(url,{
                                method: "PUT",
                                headers: {
                                    "Content-Type": "application/json",
                                },
                                body: JSON.stringify(dataObj)
                            })
                            .then(response => {
                                return response.json()
                            })
                            .then(data => {
                                console.log(data)
                                if(data.type == 'success'){
                                    Swal.fire('Success',data.msg,'success')
                                }else{
                                    Swal.fire('Oops!',data.msg,'error')
                                }
                            })
                            .catch(error => console.log(error))
                        }
                    })
                }
            })

            $('.set-connectoin').click(function(){
                var imageUrl = $(this).closest('tr').find('img').attr('src')
                console.log(imageUrl)
                //return false
                var splitVal = $(this).attr('data').split('/')
                var actionType = splitVal[0]
                var channelId = splitVal[1]
                var channel = splitVal[2]
                var currentStatus = splitVal[3] == 1 ? 'Inactive' : 'Active'
                var isActive = splitVal[3] == 1 ? 'selected' : ''
                var isInactive = splitVal[3] == 0 ? 'selected' : ''
                var html = '<label for="logo" class="mb-2">Channel Logo</label>'
                        +'<div class="form-group d-flex">'
                        +'<img src="'+imageUrl+'" class="rounded-3" id="newImage" style="width: 150px">'
                        +'<input type="file" name="logo" class="form-control" id="inputImage">'
                        +'</div>'
                        +'<input type="checkbox" name="is_logo_remove" class="mb-2">&nbsp;Remove this logo'
                        +'<div class="form-group">'
                        +'<label for="status" class="mb-2">Channel Status</label>'
                        +'<select name="status" class="form-control"><option value="1" '+isActive+'>Active</option><option value="0" '+isInactive+'>Inactive</option></select>'
                        +'</div>'
                        +'<input type="hidden" name="channel_id" value="'+channelId+'">'
                        +'<button type="submit" class="btn btn-success">Submit</button>'
                        
                
                if(actionType == 'change'){
                    $('#channel-info').html(html)
                    $('#channelInfoModal').modal('show');
                    // Swal.fire({
                    //     title: 'Are You Sure ?',
                    //     text: 'This Will '+ currentStatus +' The Current ' +channel+' Connection',
                    //     showCancelButton: true,
                    //     cancelButtonColor: '#d33',
                    //     confirmButtonText: 'Yes',
                    //     showLoaderOnConfirm: true,
                    //     preConfirm: () => {
                    //         var url = "{{url('channels/change-channel-statue')}}"
                    //         var token = "{{csrf_token()}}"
                    //         var dataObj = {
                    //             "_token": token,
                    //             "channelId": channelId,
                    //             "currentStatus": splitVal[3]
                    //         }
                    //         return fetch(url,{
                    //             method: "POST",
                    //             headers: {
                    //                 "Content-Type": "application/json",
                    //             },
                    //             body: JSON.stringify(dataObj)
                    //         })
                    //         .then(response => {
                    //             return response.json()
                    //         })
                    //         .then(data => {
                    //             console.log(data)
                    //             if(data.type == 'success'){
                    //                 Swal.fire('Success',data.msg,'success')
                    //             }else{
                    //                 Swal.fire('Oops!',data.msg,'error')
                    //             }
                    //             setTimeout(() => {
                    //                 window.location.reload()
                    //             }, 2000);
                    //         })
                    //         .catch(error => console.log(error))
                    //     }
                    // })
                }
            })

            $('.modal').on('change','#inputImage',function(){
                const [file] = document.getElementById('inputImage').files
                if (file) {
                    document.getElementById('newImage').src = URL.createObjectURL(file)
                }
            })
        })
    </script>
@endsection
