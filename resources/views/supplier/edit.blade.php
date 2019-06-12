@extends('layouts.material')
@section('title','Edit Supplier Detail')

@section('content')
    <div class="row">
        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
        <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
            <!-- Search for small screen-->
            <div class="container">
                <div class="row">
                    <div class="col s10 m6 l6">
                        <h5 class="breadcrumbs-title mt-0 mb-0">Edit Supplier Info</h5>
                        <ol class="breadcrumbs mb-0">
                            <li class="breadcrumb-item"><a href="#!">Manage Suppliers</a></li>
                            <li class="breadcrumb-item active">Edit Supplier Info</li>
                        </ol>
                    </div>
                    <div class="col s2 m6 l6">
                        <a class="btn waves-effect waves-light breadcrumbs-btn right" href="{{ route('suppliers') }}">
                            <i class="material-icons hide-on-med-and-up">people</i>
                            <span class="hide-on-small-onl">Back to Suppliers &nbsp;&nbsp;</span>
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
                                Edit supplier below.
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div id="Form-advance" class="card card card-default scrollspy">
                                <div class="card-content">
                                    <h4 class="card-title">Supplier Info</h4>
                                    <form class="col s12" action="{{ route('supplier.update') }}" method="post">
                                        @csrf
                                        @method('put')
                                        <input type="hidden" name="id" value="{{ $supplier->id }}">
                                        <div class="row">
                                            <div class="input-field col m7 s12">
                                                <input id="supplier_name" name="name" value="{{ $supplier->name }}" type="text" required>
                                                <label for="supplier_name">Supplier Name *</label>
                                            </div>
                                            <div class="input-field col m5 s12">
                                                <input id="supplier_contact_name" name="contact_name" value="{{ $supplier->contact_name }}" type="text">
                                                <label for="supplier_contact_name">Contact Person Name</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col m6 s12">
                                                <input id="supplier_email" name="email" value="{{ $supplier->email }}" type="email">
                                                <label for="supplier_email">Supplier Email</label>
                                            </div>
                                            <div class="input-field col m6 s12">
                                                <input id="supplier_tel" name="tel" value="{{ $supplier->contact_tel }}" type="tel">
                                                <label for="supplier_tel">Supplier Contact Number</label>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <button class="btn cyan waves-effect waves-light right" type="submit">Update
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
        <div class="col s12">
            <div class="container">
                <!--Gradient Card-->
                <div id="cards-extended">

                    <div class="divider mt-2"></div>

                    <!--E-commerce Card-->
                    <div id="image-card" class="section">
                        <h4 class="header">Supplier Account Info</h4>
                        <p></p>
                        <div class="row">
                            @foreach($supplier->accounts as $account)
                            <div class="col s12 m4">
                                <div class="card gradient-45deg-light-blue-cyan">
                                    <div class="card-content white-text center">
                                        <h6 class="card-title font-weight-400">{{ $account->bank_name }}</h6>
                                        <p><strong>{{ $account->number }}</strong> <br /> <small>{{ $account->currency }}</small></p>
                                    </div>

                                    <div class="card-action border-non center">
                                        @if($account->primary)
                                            <a class="waves-effect waves-notransition">Primary Account</a>
                                        @else
                                            <form action="{{ route('supplier.account.primary') }}" method="post" id="make-primary-{{$account->id}}">
                                                @csrf
                                                @method('patch')
                                                <input type="hidden" name="id" value="{{ $account->id }}">
                                            </form>
                                            <form action="{{ route('supplier.account.delete') }}" method="post" id="delete-account-{{$account->id}}" onsubmit="return confirmDelete();">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="recipient_code" value="{{ $account->recipient_code }}">
                                                <input type="hidden" name="id" value="{{ $account->id }}">
                                            </form>
                                        <button type="submit" form="make-primary-{{$account->id}}"  class="waves-effect waves-light btn gradient-45deg-green-teal box-shadow">Primary</button>
                                        <button type="submit" form="delete-account-{{$account->id}}" class="waves-effect waves-light btn gradient-45deg-red-pink box-shadow">Delete</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="col s12 m12 l12">
            <div id="Form-advance" class="card card card-default scrollspy" style="overflow: visible; height: 330px;">
                <div class="card-content">
                    <h4 class="card-title">Add account</h4>
                    <form class="col s12" action="{{ route('supplier.account.create') }}" method="post">
                        @csrf
                        <input type="hidden" name="supplier_id" value="{{ $supplier->id }}">
                        <div class="row">
                            <div class="input-field col m6 s12">
                                <select class="resolve_account" id="supplier_bank" name="bank_code" required>
                                    <option value="" disabled selected>Select Supplier Bank</option>
                                    @foreach($banks as $bank)
                                        <option value="{{ $bank['code'] }}">{{ $bank['name'] }}</option>
                                    @endforeach
                                </select>
                                <label for="supplier_bank">Select Supplier Bank</label>
                            </div>
                            <div class="input-field col m6 s12">
                                <input class="resolve_account" id="supplier_account_no" name="account_no" pattern="[0-9]{10}" value="{{ old('account_no') }}" type="text" required>
                                <label for="supplier_account_no">Supplier Account Number (10 digits)</label>
                            </div>
                        </div>

                        <div class="row">

                            <div class="row">
                                <div class="input-field col s6">
                                    <input id="resolved_account_name" placeholder="Account Name" type="text" disabled>
                                </div>

                                <input type="hidden" id="supplier_account_name" value="" name="account_name">

                                <div class="input-field col s12">
                                    <button class="btn cyan waves-effect waves-light right" id="submit-account-button" type="submit" disabled>Submit
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

@endsection

@section('page_scripts')
    <script src="{{ asset('js/scripts/form-layouts.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        function confirmDelete() {
            return confirm('Are you sure you want to delete this account?');
        }
    </script>
@endsection

