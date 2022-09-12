
    @foreach($allActivityLogs as $activity_log)
    <tr class="activity_log-{{$activity_log->id}} activity_log_border">
        <td class="id" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo" class="accordion-toggle">
            <span onclick="textCopiedID(this);" class="">{{$activity_log->id ?? ''}}</span>
            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
        </td>
        <td class="action_name" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo" class="accordion-toggle">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".error_log_popup-{{$activity_log->id}}">{{$activity_log->action_name ?? ''}}</button>

                <div class="modal fade error_log_popup-{{$activity_log->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{$activity_log->action_name ?? ''}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="activity-log modal-body">
                                <div class="text-left">
                                    <h5>Action URL</h5>
                                    <div class="url-sec">
                                        <p style="word-break:break-all;">{{$activity_log->action_url ?? ''}}</p>
                                    </div>
                                </div>
                                <div class="text-left">
                                    <h5>Request Data</h5>
                                    <div class="url-sec">
                                        <p style="word-break:break-all;">{{ $activity_log->request_data ?? ''}}</p>
                                    </div>
                                </div>
                                <div class="text-left">
                                    <h5>Response Data</h5>
                                    <div class="url-sec">
                                        <p style="word-break:break-all;">{{ $activity_log->response_data ?? ''}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </td>
        <td class="account_name" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo" class="accordion-toggle">
        <span onclick="textCopiedID(this);" class="">{{$activity_log->account_name ?? ''}}</span>
            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
        </td>
        <td class="account_id" style="text-align: center !important; width: 10%">
            @if(isset($activity_log->account_name))
            @if($activity_log->account_name == 'Ebay')
            <a title="ebay({{\App\EbayAccount::find($activity_log->account_id)->account_name ?? ''}})" style="float:right; display:block; margin-right:10px;">
                @if(!empty(\App\EbayAccount::find($activity_log->account_id)->logo))
                <img style="height: 30px; width: 30px;" src="{{\App\EbayAccount::find($activity_log->account_id)->logo ?? ''}}">
                @else
                <span class="account_trim_name">
                    @php
                        $ac = \App\EbayAccount::find($activity_log->account_id)->account_name;
                        echo implode('', array_map(function($name)
                        { return $name[0];
                        },
                        explode(' ', $ac)));
                    @endphp
                    </span>
                @endif
            </a>
            @elseif($activity_log->account_name == 'Woocommerce')
            <a title="woocommerce({{\App\WoocommerceAccount::find($activity_log->account_id)->account_name ?? ''}})" target="_blank" style="float:right; display:block; margin-right:10px;">
                <img style="height: 30px; width: 30px;" src="https://www.pngitem.com/pimgs/m/533-5339688_icons-for-work-experience-png-download-logo-woocommerce.png">
            </a>
            @elseif($activity_log->account_name == 'Onbuy')
            <a title="onbuy({{\App\OnbuyAccount::find($activity_log->account_id)->account_name ?? ''}})" target="_blank" style="float:right; display:block; margin-right:10px;">
            <img style="height: 30px; width: 30px;" src="https://www.onbuy.com/files/default/product/large/default.jpg">
            </a>
            @endif
            @endif
        </td>
        <td class="sku" style="text-align: center !important; width: 10%">
        <span onclick="textCopiedID(this);" class="">{{$activity_log->sku ?? ''}}</span>
            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
        </td>
        <td class="action_by" style="text-align: center !important; width: 10%">
            {{$activity_log->action_by ?? ''}}
        </td>
        <td class="last_quantity" style="text-align: center !important; width: 10%">
        <span onclick="textCopiedID(this);" class="">{{$activity_log->last_quantity ?? ''}}</span>
            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
        </td>
        <td class="updated_quantity" style="text-align: center !important; width: 10%">
        <span onclick="textCopiedID(this);" class="">{{$activity_log->updated_quantity ?? ''}}</span>
            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
        </td>
        <td class="action_date" style="text-align: center !important; width: 10%">
            <span onclick="textCopiedID(this);" class="">{{$activity_log->action_date ?? ''}}</span>
            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
        </td>
        <td class="solve_status" style="text-align: center !important; width: 10%">
            {{-- {{$activity_log->solve_status ?? ''}} --}}
            @if(isset($activity_log->solve_status))
                @if($activity_log->solve_status == 1)
                    <span class="label label-table label-status label-success">Solved</span>
                @elseif($activity_log->solve_status == 0)
                    <span class="label label-table label-status label-warning">Unsolved</span>
                @endif
            @endif
        </td>
        <td class="action_status" style="text-align: center !important; width: 10%">
            {{-- {{$activity_log->action_status ?? ''}} --}}
            @if(isset($activity_log->action_status))
                @if($activity_log->action_status == 1)
                    <span class="label label-table label-status label-success">Successful</span>
                @elseif($activity_log->action_status == 0)
                    <span class="label label-table label-status label-warning">Unsuccessful</span>
                @endif
            @endif
        </td>
        <td class="created_at" style="text-align: center !important; width: 10%">
        <span onclick="textCopiedID(this);" class="">{{$activity_log->created_at ?? ''}}</span>
            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
        </td>
        <td class="updated_at" style="text-align: center !important; width: 10%">
        <span onclick="textCopiedID(this);" class="">{{$activity_log->updated_at ?? ''}}</span>
            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
        </td>
        <td class="deleted_at" style="text-align: center !important; width: 10%">
        <span onclick="textCopiedID(this);" class="">{{$activity_log->deleted_at ?? ''}}</span>
            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
        </td>

        <!--Action Button-->
        <td style="width: 8%">
        <form action="{{url('activity-log/edit/'.$activity_log->id)}}" method="PUT">
            @csrf
            @if($activity_log->solve_status == 1)
            <button type="submit" name="solve_status" value="0" style="background-color:#5cb85c; color:#fff;" class="btn m-b-5 w-100 text-center order-complete" onclick="changeButtonColor()" data-placement="left" title="Make Complete">Complete</button>

            @else
            <button type="submit" name="solve_status" value="1" style="background-color:#ac2925; color:#fff;" class="btn m-b-5 w-100 text-center order-complete" onclick="changeButtonColor()" data-placement="left" title="Complete">Incomplete</button>

            @endif
        </form>
        </td>
    </tr>
    @endforeach

