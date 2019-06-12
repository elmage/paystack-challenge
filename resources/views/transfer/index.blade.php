@extends('layouts.material')
@section('title','Transfers')

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
                        <h5 class="breadcrumbs-title mt-0 mb-0">Transfers</h5>
                        <ol class="breadcrumbs mb-0">
                            <li class="breadcrumb-item"><a href="#!">Send Money</a></li>
                            <li class="breadcrumb-item active">Transfers</li>
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
                                List of previous transfers made.
                            </p>
                        </div>
                    </div>

                    <!-- Page Length Options -->
                    <div class="row">
                        <div class="col s12">
                            <div class="card">
                                <div class="card-content">
                                    <h4 class="card-title">Transfers - {{ $transfers->total() }}</h4>
                                    <div class="row">
                                        <div class="col s12">
                                        </div>
                                        <div class="col s12">
                                            <table class="highlight">
                                                <thead>
                                                <tr>

                                                    <th data-field="details">Transfer Details</th>
                                                    <th data-field="recipient">Recipient Account</th>
                                                    <th data-field="status">Status</th>
                                                    <th data-field="date">Date</th>
                                                    <th data-field="action"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($transfers as $transfer)
                                                        <tr>
                                                            <td>
                                                                <strong>{{ currency().number_format($transfer->amount,2) }}</strong> to
                                                                <strong>{{ $transfer->supplier->name }}</strong> <br />
                                                                <small>Reason: {{ $transfer->reason }}</small>
                                                            </td>
                                                            <td>
                                                                <strong>{{ $transfer->account->number }}</strong>
                                                                {{ $transfer->account->bank_name }}<br />
                                                                <small>Transfer Code: {{ $transfer->transfer_code }}</small> <br />
                                                                <small>Reference: {{ $transfer->reference }}</small>
                                                            </td>

                                                            <td style="text-align: center">
                                                                @if($transfer->status === 'pending' || $transfer->status === 'otp')
                                                                    <small class="material-icons text-warning" style="color: orange">fiber_manual_record</small>
                                                                @elseif($transfer->status === 'success')
                                                                    <small class="material-icons" style="color: limegreen">fiber_manual_record</small>
                                                                @else
                                                                    <small class="material-icons" style="color: red">fiber_manual_record</small>
                                                                @endif
                                                                <br />
                                                                {{ ucfirst($transfer->status) }}
                                                            </td>

                                                            <td>{{ \Carbon\Carbon::parse($transfer->created_at)->toDayDateTimeString() }}</td>
                                                            <td>
                                                                @if($transfer->status === 'otp' && Carbon\Carbon::parse($transfer->created_at)->diffInMinutes(now()) < 30)
                                                                    <a href="{{ route('transfer.single.enter_otp', $transfer->id) }}" class="waves-effect waves-light btn-small">
                                                                        <i class="material-icons left">phone_iphone</i> Enter OTP
                                                                    </a>
                                                                @else
                                                                    <form action="{{ route('transfer.single.make') }}" method="post" onsubmit="return confirm('Are you sure you want to make this transfer?')">
                                                                        @csrf
                                                                        <input type="hidden" name="amount" value="{{ $transfer->amount }}">
                                                                        <input type="hidden" name="transfer_note" value="{{ $transfer->reason }}">
                                                                        <input type="hidden" name="supplier_id" value="{{ $transfer->supplier_id }}">
                                                                        <input type="hidden" name="supplier_account" value="{{ $transfer->account->recipient_code }}">
                                                                        <button class="waves-effect waves-light btn-small">
                                                                            <i class="material-icons left">repeat</i> Repeat Transfer
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div style="text-align: center">
                                                {{ $transfers->links() }}
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
    </div>
@endsection

@section('vendor_scripts')
    <script src="{{ asset('vendors/data-tables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/data-tables/js/dataTables.select.min.js') }}" type="text/javascript"></script>
@endsection