@extends('layouts.material')
@section('title','Supplier List')

@section('vendor_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/select.dataTables.min.css') }}">
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/data-tables.css') }}">
@endsection


@section('content')
    <div class="row">
        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
        <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
            <!-- Search for small screen-->
            <div class="container">
                <div class="row">
                    <div class="col s10 m6 l6">
                        <h5 class="breadcrumbs-title mt-0 mb-0">Supplier List</h5>
                        <ol class="breadcrumbs mb-0">
                            <li class="breadcrumb-item"><a href="#!">Manage Suppliers</a></li>
                            <li class="breadcrumb-item active">Supplier List</li>
                        </ol>
                    </div>
                    <div class="col s2 m6 l6">
                        <a class="btn waves-effect waves-light breadcrumbs-btn right" href="{{ route('supplier.create') }}">
                            <i class="material-icons hide-on-med-and-up">person_add</i>
                            <span class="hide-on-small-onl">Add Supplier &nbsp;&nbsp;</span>
                            <i class="material-icons hide-on-small-onl right">person_add</i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12">
            <div class="container">
                <div class="section section-data-tables">
                    <div class="card">
                        <div class="card-content">
                            <p class="caption mb-0">
                                List of suppliers added to your business. This list is synchronized with your recipient list on paystack.
                            </p>
                        </div>
                    </div>

                    <!-- Page Length Options -->
                    <div class="row">
                        <div class="col s12">
                            <div class="card">
                                <div class="card-content">
                                    <h4 class="card-title"></h4>
                                    <div class="row">
                                        <div class="col s12">
                                            <table id="supplier-list" class="display">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Contact No.</th>
                                                    <th>Email</th>
                                                    <th>Account No.</th>
                                                    <th>Bank Name</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Office</th>
                                                    <th>Age</th>
                                                    <th>Start date</th>
                                                    <th>Salary</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor_scripts')
    <script src="{{ asset('vendors/data-tables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/data-tables/js/dataTables.select.min.js') }}" type="text/javascript"></script>
@endsection