
@extends('master')
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="vendor-title">
                            <p>{{$category_name}} Category Product List</p>
                        </div>
                    </div>
                </div>

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

                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box table-responsive shadow">

                            <div class="product-inner p-b-10">
                                <div class="table-list"></div>
                                <div class="row-wise-search table-terms">
                                    <input class="form-control mb-1" id="row-wise-search" type="text" placeholder="Search....">
                                </div>
                            </div>

                            <table id="table-sort-list" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="header-cell" onclick="sortTable(0)">Product Name</th>
                                    <th class="header-cell" onclick="sortTable(0)">Type</th>
                                    <th class="header-cell" onclick="sortTable(0)">Description</th>
                                    <th class="header-cell" onclick="sortTable(0)">Short Desc</th>
                                    <th class="header-cell" onclick="sortTable(0)">Regular Price</th>
                                    <th class="header-cell" onclick="sortTable(0)">Sales Price</th>
                                    <th class="header-cell" onclick="sortTable(0)">Low Quantity</th>
                                    <th class="header-cell" onclick="sortTable(0)">Creator</th>
                                    <th class="header-cell" onclick="sortTable(0)">Actions</th>
                                </tr>
                                </thead>
                                <tbody id="table-body">
                                @foreach($all_category_product as $product)
                                    <tr>

                                        <td class="text-center">
                                            {{$product->name}}
                                            {{--                                        <img src="{{asset('assets/images/users/avatar-2.jpg')}}" alt="contact-img" title="contact-img" class="rounded-circle thumb-sm" />--}}
                                        </td>
                                        <td>{{$product->type}}</td>
                                        <td>{!! Str::limit(strip_tags($product-> description),$limit = 150, $end = '...') !!}</td>
                                        <td>{!! Str::limit(strip_tags($product-> short_description),$limit = 150, $end = '...') !!}</td>
                                        <td>{{$product->regular_price}}</td>
                                        <td>{{$product->sale_price}}</td>
                                        <td>{{$product->low_quantity}}</td>
                                        <td>{{$product->user_info->name}}</td>
                                        <td class="actions form_action">

                                            <a href="{{route('product-draft.edit',$product->id)}}" data-toggle="tooltip" data-placement="top" title="Edit"><button class=" btn-primary" style="cursor: pointer;"><i class="fa fa-edit" aria-hidden="true"></i></button></a>&nbsp;
                                            <a href="{{route('product-draft.show',$product->id)}}" data-toggle="tooltip" data-placement="top" title="View"><button class=" btn-success" style="cursor: pointer;"><i class="fa fa-eye" aria-hidden="true"></i></button></a>&nbsp;
                                            <form action="{{route('product-draft.destroy',$product->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a href="#" class="on-default remove-row" data-toggle="tooltip" data-placement="top" title="Delete"><button class=" btn-danger" onclick="" style="cursor: pointer;"><i class="fa fa-trash" aria-hidden="true"></i></button>  </a>
                                            </form>
                                            @if($product->status == 'draft')
                                                <form action="{{route('product-draft.publish',$product->id)}}" method="post">
                                                    @csrf
                                                    <a href="#" class="on-default remove-row" data-toggle="tooltip" data-placement="top" title="Publish"><button class=" btn-info" onclick="" style="cursor: pointer;"><i class="fa fa-product-hunt" aria-hidden="true"></i></button>  </a>
                                                </form>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page-->

{{--    <script type="text/javascript">--}}
{{--        $(document).ready(function() {--}}

{{--            // Default Datatable--}}
{{--            $('#datatable').DataTable();--}}

{{--        } );--}}
{{--    </script>--}}


    <script>

        //Datatable row-wise searchable option
        $(document).ready(function(){
            $("#row-wise-search").on("keyup", function() {
                let value = $(this).val().toLowerCase();
                $("#table-body tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });

            });
        });


        //sort ascending and descending table rows js
        function sortTable(n) {
            let table,
                rows,
                switching,
                i,
                x,
                y,
                shouldSwitch,
                dir,
                switchcount = 0;
            table = document.getElementById("table-sort-list");
            switching = true;
            //Set the sorting direction to ascending:
            dir = "asc";
            /*Make a loop that will continue until
            no switching has been done:*/
            while (switching) {
                //start by saying: no switching is done:
                switching = false;
                rows = table.getElementsByTagName("TR");
                /*Loop through all table rows (except the
                first, which contains table headers):*/
                for (i = 1; i < rows.length - 1; i++) { //Change i=0 if you have the header th a separate table.
                    //start by saying there should be no switching:
                    shouldSwitch = false;
                    /*Get the two elements you want to compare,
                    one from current row and one from the next:*/
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    /*check if the two rows should switch place,
                    based on the direction, asc or desc:*/
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            //if so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            //if so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    /*If a switch has been marked, make the switch
                    and mark that a switch has been done:*/
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    //Each time a switch is done, increase this count by 1:
                    switchcount++;
                } else {
                    /*If no switching has been done AND the direction is "asc",
                    set the direction to "desc" and run the while loop again.*/
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }


        // sort ascending descending icon active and active-remove js
        $('.header-cell').click(function() {
            let isSortedAsc  = $(this).hasClass('sort-asc');
            let isSortedDesc = $(this).hasClass('sort-desc');
            let isUnsorted = !isSortedAsc && !isSortedDesc;

            $('.header-cell').removeClass('sort-asc sort-desc');

            if (isUnsorted || isSortedDesc) {
                $(this).addClass('sort-asc');
            } else if (isSortedAsc) {
                $(this).addClass('sort-desc');
            }
        });

    </script>


@endsection
