<style>
    .background_image{
        opacity:0.5;
        background: black;
    }
    .modal .modal-body {
        max-height: 500px;
        overflow-y: auto;
    }
</style>
<form class="mobile-responsive m-t-10" role="form" action={{url('onbuy/save-onbuy-product')}} method="post" target="_blank">
    @csrf

    @if (count($exits_ean_product_info) > 0)
        <div class="card m-t-10">
            <h5 class="text-center">Total Results Found: {{$totalRow}}</h5>
            <div class="row">
                @foreach ($exits_ean_product_info as $opc => $product)
                    <div class="col-md-6 m-t-10">
                        <div class="card">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="{{$product['image_url']}}" alt="Product Image" class="card-image-top w-75">
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body float-right">
                                        <h6>Title: {{$product['name']}}</h6>
                                        <p>EAN No: <span class="text-success">{{$product['ean_no']}}</span></p>
                                        <p>OPC: {{$opc}}</p>
                                        <div class="d-inline-block">
                                            <a href="{{$product['product_url']}}" class="btn btn-success" target="_blank">See On Onbuy</a>
                                            <!-- <a href="{{url('onbuy/add-exist-ean-listing/?catalogue_id='.'95826'.'&exist_ean='.$opc.'&exist_opc='.$product['opc'].'&product_id='.$product['product_id'].'&profile_id=1')}}"
                                            class="btn btn-primary change_status">Add Listing</a> -->
                                            <button type="button" class="btn btn-primary add-listing" id="{{$opc}}" data-toggle="modal" data-target=".bd-example-modal-xl">
                                                Add Listing
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-info text-center d-none load-more search-button" onbuy-data="0">Load More Product</button>
        </div>
    @else
        <div class="alert alert-danger text-center"><h5>No Product Found</h5</div>
    @endif
</form> <!--//End form -->
<div class="modal fade bd-example-modal-xl" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Calalogue List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex">
            <input type="text" class="form-control" name="catalogue_search_modal" id="catalogue_search_modal" placeholder="Search Catalogue By Title,SKU,EAN">
            <button type="button" class="btn btn-info search_catalogue" data="0">Search</button>
        </div>
        <div class="catalogue-content table-responsive">
            <table class="table table-hover">
                <thead>
                    <th></th><th></th>
                </thead>
                
                <tbody>
                    
                </tbody>
            </table>
            <button type="button" class="btn btn-info search_catalogue d-none" data="0">Load More</button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript">
    CKEDITOR.replace('messageArea',
        {
            customConfig: 'config.js',
            toolbar: 'simple'
        })

</script>

