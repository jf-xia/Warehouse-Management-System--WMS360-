@extends('master')

@section('title')
    Update | WMS360
@endsection

@section('content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <!-- Custombox -->
    <link href="{{asset('assets/plugins/custombox/css/custombox.css')}}" rel="stylesheet">

    <!-- Modal-Effect -->
    <script src="{{asset('assets/plugins/custombox/js/custombox.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custombox/js/legacy.min.js')}}"></script>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        /* Float four columns side by side */
        .column {
            float: left;
            width: 50%;
            padding: 0 10px;
        }

        /* Remove extra left and right margins, due to padding */
        .row {margin: 0 -5px;}

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Responsive columns */
        @media screen and (max-width: 600px) {
            .column {
                width: 100%;
                display: block;
                margin-bottom: 20px;
            }
        }

        /* Style the counter cards */
        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            padding: 16px;
            text-align: center;
            background-color: #f1f1f1;

        }
    </style>
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <div class="row m-t-20">
                    <div class="col-md-12">

                        <div class="card-box table-responsive shadow shelf-card" style="max-height: 550px;">
                            {{--                            <div class="row col-lg-12">--}}
                            {{--                                <div class="col-6" style="border: 1px solid;padding: 5px;">--}}
                            {{--                                    Current Version: {{$current_version}}--}}
                            {{--                                </div>--}}
                            {{--                                <div class="col-6" style="">--}}
                            {{--                                    <div class="row" style="border: 1px solid;padding: 5px;">--}}
                            {{--                                        Stable Version: {{$stable_version}}--}}
                            {{--                                        @if($stable_version != "")--}}
                            {{--                                            <form class="float-left" action="{{URL::to('update/latest')}}" method="POST">--}}
                            {{--                                                @csrf--}}
                            {{--                                                <input type="hidden" name="new_version" value="{{$stable_version}}">--}}
                            {{--                                                <button class="btn-lg btn-success" type="submit">Revert</button>--}}
                            {{--                                            </form>--}}
                            {{--                                        @endif--}}
                            {{--                                    </div>--}}
                            {{--                                    <div class="row" style="border: 1px solid;padding: 5px;">--}}
                            {{--                                        Latest Version: {{$latest_version}}--}}
                            {{--                                        @if($latest_version != "")--}}
                            {{--                                            <form class="float-left" action="{{URL::to('update/latest')}}" method="POST">--}}
                            {{--                                                @csrf--}}
                            {{--                                                <input type="hidden" name="new_version" value="{{$latest_version}}">--}}
                            {{--                                                <button class="btn-lg btn-success" type="submit">Update</button>--}}
                            {{--                                            </form>--}}
                            {{--                                        @endif--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            <div class="row">
                                <div class="column" >
                                    <div class="card" style="height: 415px;">
                                        <h3>Current Version: {{$current_version}} <i class="fa fa-check"></i><i class="fa fa-check"></i></h3>
                                        <div style="text-align: left">
                                            <li> Order ID linked with eBay order search page</li>
                                            <li> Ended product check new condition added for eBay deleted product</li>
                                            <li> Add Product Multiple Image (upto 12 image)</li>
                                            <li> Order ID linked with eBay order search page</li>
                                            <li> Ended product check new condition added for eBay deleted product</li>
                                        </div>


                                    </div>
                                </div>

                                <div class="column">
                                    <div class="card" style="height: 200px;margin-bottom: 15px;">
                                        <h3>Available Versions: {{$stable_version}}</h3>

                                        {{--                                        <p>Some text</p>--}}
                                        {{--                                        <p>Some text</p>--}}
                                        @if($stable_version != "")
                                            <div class="row">
                                                <div class="col-6">


                                                    @for($i=0; $i <= 5;$i++)

                                                        @if($i == 3)
                                                            </div>
                                                            <div class="col-6">
                                                        @endif
                                                                <form action="{{URL::to('update/latest')}}" method="POST" style="margin-top: 2%;padding-left: 5%;padding-right: 7%;">
                                                                    @csrf
                                                                    <input type="hidden" name="new_version" value="{{$tags[$i]}}">
                                                                    <button class="btn btn-small btn-success" type="submit">Revert {{$tags[$i]}} <i class="fa fa-arrow-left"></i></button>
                                                                </form>

                                                    @endfor

                                                </div>
                                            </div>

                                        @endif

                                    </div>
                                    <div class="card" style="height: 200px;margin-top: 15px;">
                                        <h3>Latest Version: {{$latest_version}}

                                        </h3>
                                        {{--                                        <p>Some text</p>--}}
                                        {{--                                        <p>Some text</p>--}}
                                        @if($latest_version != "")
                                            <form action="{{URL::to('update/latest')}}" method="POST" style="margin-top: 5%;padding-left: 20px;padding-right: 20px;">
                                                @csrf
                                                <input type="hidden" name="new_version" value="{{$latest_version}}">
                                                <button class="btn btn-success" type="submit">Update <i class="fa fa-arrow-right"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{--                            @if($latest_version != $current_version)--}}

                            {{--                                <div class="row">--}}
                            {{--                                    <h5 class="float-left" style="margin-right: 5px">Update Available: {{$stable_version}} </h5>--}}

                            {{--                                    <h5 class="float-left" style="margin-right: 5px">Update Available: {{$latest_version}} </h5>--}}

                            {{--                                </div>--}}
                            {{--                                <div class="row">--}}
                            {{--                                    <h5>Current Version: {{$current_version}} </h5>--}}
                            {{--                                </div>--}}

                            {{--                            @elseif($latest_version == $current_version)--}}
                            {{--                                <div class="row">--}}
                            {{--                                    <h5 class="float-left" style="margin-right: 5px">Stable Version Available: {{$stable_version}} </h5>--}}
                            {{--                                    <form class="float-left" action="{{URL::to('update/revert')}}" method="POST">--}}
                            {{--                                        @csrf--}}
                            {{--                                        <input type="hidden" name="new_version" value="{{$stable_version}}">--}}
                            {{--                                        <button class="btn-lg btn-success" type="submit">Revert</button>--}}
                            {{--                                    </form>--}}
                            {{--                                </div>--}}

                            {{--                                <div class="row">--}}
                            {{--                                    <label>Current Version: {{$current_version}} <i class="fa-light fa-check-double"></i></label>--}}
                            {{--                                </div>--}}

                            {{--                            @endif--}}

                        </div>
                    </div>
                </div> <!-- end row -->

            </div> <!-- container -->
        </div> <!-- content -->
    </div>


    <!--Add Role Modal -->
    <div id="addShelf" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add Shelf</h4>
        {{--                                <div class="modal-body">--}}

        <form role="form" class="vendor-form mobile-responsive" action="{{url('shelf')}}" method="post">
            @csrf
            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="name" class="col-md-2 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Shelf Name</label>
                <div class="col-md-8 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input type="text" name="shelf_name" class="form-control" id="shelf_name" value="{{ old('shelf_name') }}" placeholder="Enter shelf name" required>
                </div> <div class="col-md-1"></div>

            </div>

            <div class="form-group row">
                <div class="col-md-12 text-center mb-5 mt-3">
                    <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                        <b>Submit</b>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!--End Role Modal -->



    <script>

        //Datatable row-wise searchable option
        $(document).ready(function(){
            $("#in-row-id-name-wise-search").on("keyup", function() {
                let search_value = $(this).val();
                if(search_value == ''){
                    return false;
                }
                console.log(search_value);
                // $("#table-body tr").filter(function() {
                //     $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                // });
                $.ajax({
                    type: "post",
                    url: "{{url('shelf-search')}}",
                    data: {
                        "_token": "{{csrf_token()}}",
                        "search_value": search_value
                    },
                    beforeSend: function(){
                        $("#product_variation_loading").show()
                    },
                    success: function (response) {
                        console.log(response);
                        if(response.data != 'error'){
                            $('tbody').html(response.data);
                        }
                        $('span.search_result_show').addClass('text-success').html(response.total_row+' result found');
                        $("#product_variation_loading").hide()
                    },
                    completle: function () {
                        $("#product_variation_loading").hide()

                    }
                });

            });
        });

        //screen option toggle
        $(document).ready(function(){
            $(".screen-option-btn").click(function(){
                $(".screen-option-content").slideToggle(500);
            });
        });

        //prevent onclick dropdown menu close
        $('.filter-content').on('click', function(event){
            event.stopPropagation();
        });

        //Select 2 dropdown
        $('.select2').select2();

        //sort ascending and descending table rows js
        // function sortTable(n) {
        //     let table,
        //         rows,
        //         switching,
        //         i,
        //         x,
        //         y,
        //         shouldSwitch,
        //         dir,
        //         switchcount = 0;
        //     table = document.getElementById("table-sort-list");
        //     switching = true;
        //     //Set the sorting direction to ascending:
        //     dir = "asc";
        //     /*Make a loop that will continue until
        //     no switching has been done:*/
        //     while (switching) {
        //         //start by saying: no switching is done:
        //         switching = false;
        //         rows = table.getElementsByTagName("TR");
        //         /*Loop through all table rows (except the
        //         first, which contains table headers):*/
        //         for (i = 1; i < rows.length - 1; i++) { //Change i=0 if you have the header th a separate table.
        //             //start by saying there should be no switching:
        //             shouldSwitch = false;
        //             /*Get the two elements you want to compare,
        //             one from current row and one from the next:*/
        //             x = rows[i].getElementsByTagName("TD")[n];
        //             y = rows[i + 1].getElementsByTagName("TD")[n];
        //             /*check if the two rows should switch place,
        //             based on the direction, asc or desc:*/
        //             if (dir == "asc") {
        //                 if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        //                     //if so, mark as a switch and break the loop:
        //                     shouldSwitch = true;
        //                     break;
        //                 }
        //             } else if (dir == "desc") {
        //                 if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
        //                     //if so, mark as a switch and break the loop:
        //                     shouldSwitch = true;
        //                     break;
        //                 }
        //             }
        //         }
        //         if (shouldSwitch) {
        //             /*If a switch has been marked, make the switch
        //             and mark that a switch has been done:*/
        //             rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        //             switching = true;
        //             //Each time a switch is done, increase this count by 1:
        //             switchcount++;
        //         } else {
        //             /*If no switching has been done AND the direction is "asc",
        //             set the direction to "desc" and run the while loop again.*/
        //             if (switchcount == 0 && dir == "asc") {
        //                 dir = "desc";
        //                 switching = true;
        //             }
        //         }
        //     }
        // }


        // sort ascending descending icon active and active-remove js
        // $('.header-cell').click(function() {
        //     let isSortedAsc  = $(this).hasClass('sort-asc');
        //     let isSortedDesc = $(this).hasClass('sort-desc');
        //     let isUnsorted = !isSortedAsc && !isSortedDesc;
        //
        //     $('.header-cell').removeClass('sort-asc sort-desc');
        //
        //     if (isUnsorted || isSortedDesc) {
        //         $(this).addClass('sort-asc');
        //     } else if (isSortedAsc) {
        //         $(this).addClass('sort-desc');
        //     }
        // });


    </script>


@endsection
