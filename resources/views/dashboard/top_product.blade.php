@isset($data['top_product'])
    @foreach($data['top_product'] as $top_product)
        <li class="media">
            <img class="mr-3 rounded" width="55" src="{{$top_product['catalogue_image'] ? asset('/').$top_product['catalogue_image'] : asset('uploads/no_image.jpg')}}" alt="product">
            <div class="media-body">
                <div class="float-right">
                    <div class="font-weight-600 text-default label label-success">{{$top_product['total_order_product'] ?? 0}} Orders</div>
                </div>
                <div class="media-title">{{$top_product['catalogue_title'] ?? ''}}</div>
                <div class="mt-1">
                    <div id="sales-price">
                        <div class="sales-price-square bg-purple" style="width: 45%;"></div>
                        <div class="sales-price-label"><i class='fa fa-gbp mr-1'></i>{{number_format($top_product['total_order_price'],2)}}</div>
                    </div>
                    <div id="sales-price">
                        <div class="sales-price-square bg-danger" style="width: 30%;"></div>
                        <div class="sales-price-label"><i class='fa fa-gbp mr-1'></i>{{number_format($top_product['total_cost_price'],2)}}</div>
                    </div>
                </div>
            </div>
        </li>
    @endforeach
@endisset
