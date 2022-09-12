
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
                            <p>Defected Product List</p>
                        </div>
                    </div>
                </div>

                <div class="card-box m-t-20 shadow">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">

                                <table id="datatable" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>SKU</th>
                                        <th>Barcode</th>
                                        <th>Total Qty</th>
                                        <th>Catalogue</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td> sfsdh </td>
                                        <td> sfg </td>
                                        <td> sfdg </td>
                                        <td> reyrry </td>
                                        <td> yghfd </td>
                                        <td> fedgty </td>
                                        <td> fegtder </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end row -->
                </div> <!-- end card box -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->



    <script type="text/javascript">
        $(document).ready(function() {

            // Default Datatable
            $('#datatable').DataTable();

        } );
    </script>

@endsection
