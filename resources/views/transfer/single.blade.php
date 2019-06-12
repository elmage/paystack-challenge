@extends('layouts.material')
@section('title','Single Transfer')


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
                        <h5 class="breadcrumbs-title mt-0 mb-0">Single Transfer</h5>
                        <ol class="breadcrumbs mb-0">
                            <li class="breadcrumb-item"><a href="#!">Send Money</a></li>
                            <li class="breadcrumb-item active">Single Transfer</li>
                        </ol>
                    </div>
                    @include('fragments.transfer_button')
                </div>
            </div>
        </div>
        <div class="col s12">
            <div class="container">
                <div class="section section-data-tables">
                    <div class="card">
                        <div class="card-content">
                            <p class="caption mb-0">
                                Enter the details of the transaction below.
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div id="Form-advance" class="card card card-default scrollspy" style="height: 350px;">
                                <div class="card-content">
                                    <h4 class="card-title"></h4>
                                    <form class="col s12" action="{{ route('transfer.single.make') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="input-field col m6 s12">
                                                <input id="transfer_amount" name="amount" value="" min="100" type="number" required>
                                                <label for="transfer_amount">Amount ({{ currency() }})</label>
                                            </div>
                                            <div class="input-field col m6 s12">
                                                <input id="transfer_note" name="transfer_note" value="" type="text" required>
                                                <label for="transfer_note">Transfer Note (optional)</label>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="input-field col m6 s12">
                                                <select id="select-supplier" name="supplier_id" required>
                                                    <option value="" disabled selected>Select Supplier</option>
                                                    @foreach($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="supplier_id">Select Supplier</label>
                                            </div>
                                            <div class="input-field col m6 s12">
                                                <label for="select-supplier-bank"></label>
                                                <select class="browser-default" id="select-supplier-bank" name="supplier_account" required>
                                                    <option value="" disabled selected>Select Account</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <small class="text-muted">You will be charged NGN 50 for this transfer</small>
                                                    <button class="btn cyan waves-effect waves-light right" id="submit-account-button" type="submit">Transfer
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

