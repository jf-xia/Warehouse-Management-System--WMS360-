

        <!-- Modal body -->
        <div class="modal-body">
            <h6> Invoice No:
                @if(isset($request->invoice_number))
                    {{$request->invoice_number}}
                @endif
            </h6>
            <h5 class="text-danger"> Vendor:
                @if(isset(\App\Vendor::find($request->vendor_id)->name))
                {{\App\Vendor::find($request->vendor_id)->name}}
                @endif
            </h5>
            <h6> Receive date: {{$request->receive_date}} </h6>
            <h6> Order Type:  {{isset($request->order_id) ? "Return order" : "New Receive"}}</h6>
            <h6> Product Information:  <br> <img height="20%" width="20%" class="m-t-5" src="{{isset(\App\ProductVariation::find($request->product_variation_id)->image) ? \App\ProductVariation::find($request->product_variation_id)->image : asset('assets/images/users/no_image.jpg')}}" alt="IMAGE"> </h6>

            <h5 class="text-danger"> SKU: {{\App\ProductVariation::find($request->product_variation_id)->sku}} </h5>
            <h6> Quantity: {{$request->quantity}} </h6>
            <h6> Price: {{$request->price}} </h6>
            <h6> Product Type: <?php
                if ($request->product_type == 1){
                    echo "New";
                } else{
                    echo "Defected";
                }
                ?> </h6>
            <h6> Shelver: {{isset($request->shelver_user_id) ? \App\User::find($request->shelver_user_id)->name : '' }} </h6>
            <h6> Total Price:  {{isset($request->total_price) ? $request->total_price : null}} </h6>
            <h5 class="text-danger"><b> [Note:] </b> Please double check the above information specially SKU. Once you receive it, you can't be edited. </h5>
        </div>

        <!-- Modal footer -->

