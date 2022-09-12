
    @foreach($ebay_migration_result as $product)

        <tr>
            <td><input type="checkbox" class="form-control categoryCheckbox" value="{{$product->account_id}}/{{$product->category_id}}"></td>
            <td class="image" style="width:6%; cursor: pointer; text-align: center" data-toggle="collapse" data-target="#demo{{$product->id}}" class="accordion-toggle">
                @isset($product->imgae)
                    <a href="{{$product->imgae}}"  title="Click to expand" target="_blank"><img src="{{$product->imgae}}" class="ebay-image" alt="ebay-catalogue-image"></a>
                @endisset
            </td>

            <td class="w-30">
                <a href="{{$product->url}}">{{$product->title}}</a>
            </td>

            <td>{{$product->category_name}}</td>
            <td>{{$product->condition_name}}</td>
            @php
                $account_name = \App\EbayAccount::select('account_name')->where('id',$product->account_id)->first();
            @endphp
            <td style="text-align:center !important;">
                @isset($account_name)
                        {{$account_name->account_name}}
                @endisset
            </td>
            <td>
                {{$product->item_id}}
            </td>
            <td>
                @if($product->status == 0)
                    <div class="align-items-center mr-2"><a class="btn-size btn-danger" style="cursor: pointer"  target="_blank" data-toggle="tooltip" data-placement="top" title="pending"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></a></div>
                @else
                    <div class="align-items-center mr-2"><a class="btn-size btn-success" style="cursor: pointer"  target="_blank" data-toggle="tooltip" data-placement="top" title="Migrated"><i class="fa fa-check" aria-hidden="true"></i></a></div>
                @endif
            </td>

        </tr>

        <!-- Edit eBay account Modal -->

        <!--End Edit eBay account Modal -->




    @endforeach