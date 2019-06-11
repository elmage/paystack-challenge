@extends('layouts.material')
@section('title','Add Supplier')


@section('css')
    <style>
        .dropdown-content
        {
            height: 200px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
        <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
            <!-- Search for small screen-->
            <div class="container">
                <div class="row">
                    <div class="col s10 m6 l6">
                        <h5 class="breadcrumbs-title mt-0 mb-0">Add Supplier</h5>
                        <ol class="breadcrumbs mb-0">
                            <li class="breadcrumb-item"><a href="#!">Manage Suppliers</a></li>
                            <li class="breadcrumb-item active">Add Supplier</li>
                        </ol>
                    </div>
                    <div class="col s2 m6 l6">
                        <a class="btn waves-effect waves-light breadcrumbs-btn right" href="{{ route('suppliers') }}">
                            <i class="material-icons hide-on-med-and-up">people</i>
                            <span class="hide-on-small-onl">View Suppliers &nbsp;&nbsp;</span>
                            <i class="material-icons hide-on-small-onl right">people</i>
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
                                Add a supplier below.
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div id="Form-advance" class="card card card-default scrollspy">
                                <div class="card-content">
                                    <h4 class="card-title"></h4>
                                    <form class="col s12" action="{{ route('supplier.store') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="input-field col m7 s12">
                                                <input id="supplier_name" name="name" value="{{ old('name') }}" type="text" required>
                                                <label for="supplier_name">Supplier Name *</label>
                                            </div>
                                            <div class="input-field col m5 s12">
                                                <input id="supplier_contact_name" name="contact_name" value="{{ old('contact_name') }}" type="text">
                                                <label for="supplier_contact_name">Contact Person Name</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col m6 s12">
                                                <input id="supplier_email" name="email" value="{{ old('email') }}" type="email">
                                                <label for="supplier_email">Supplier Email</label>
                                            </div>
                                            <div class="input-field col m6 s12">
                                                <input id="supplier_tel" name="tel" value="{{ old('tel') }}" type="tel">
                                                <label for="supplier_tel">Supplier Contact Number</label>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="input-field col m6 s12">
                                                <select id="supplier_bank" name="bank_code" required>
                                                    <option value="" disabled selected>Select Supplier Bank</option>
                                                    @foreach($banks as $bank)
                                                        <option value="{{ $bank['code'] }}">{{ $bank['name'] }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="supplier_bank">Select Supplier Bank</label>
                                            </div>
                                            <div class="input-field col m6 s12">
                                                <input id="supplier_account_no" name="account_no" pattern="[0-9]{10}" value="{{ old('account_no') }}" type="text" required>
                                                <label for="supplier_account_no">Supplier Account Number (10 digits)</label>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <button class="btn cyan waves-effect waves-light right" type="submit">Submit
                                                        <i class="material-icons right">send</i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_scripts')
    <script src="{{ asset('js/scripts/form-layouts.js') }}" type="text/javascript"></script>
@endsection

