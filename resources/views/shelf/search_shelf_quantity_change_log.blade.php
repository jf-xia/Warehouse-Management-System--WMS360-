

@isset($search_shelf_quantity_change_log)
    @foreach($search_shelf_quantity_change_log as $change_log_result)
        <tr>
            <td class="Shelf_name text-center" style="width: 10%">{{$change_log_result->shelf_info->shelf_name ?? ''}}</td>
            <td class="previous_quantity text-center" style="width: 15%">{{$change_log_result->previous_quantity}}</td>
            <td class="updated_quantity text-center" style="width: 15%">{{$change_log_result->update_quantity}}</td>
            <td class="title" style="width: 30%">{{$change_log_result->variation_info->product_draft->name ?? ''}}</td>
            <td class="modifier text-center">{{$change_log_result->user_info->name ?? ''}}</td>
            <td class="date text-center">{{date('d-m-Y H:i:s',strtotime($change_log_result->updated_at))}}</td>
            <td class="reason text-center">{!! $change_log_result->reason !!}</td>
            <td class="actions" style="width: 8%">
                <div class="d-flex justify-content-start">
                    <div class="align-items-center mr-2">
                        <a class="btn-size del-pub delete-btn" style="cursor: pointer" href="{{url('delete-change-shelf-quantity-log/'.$change_log_result->id)}}" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('log');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
@endisset
