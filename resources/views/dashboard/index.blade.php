@extends('layouts.material')

@section('title','Dashboard')

@section('vendor_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/animate-css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/chartist-js/chartist.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/chartist-js/chartist-plugin-tooltip.css') }}">
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/dashboard-modern.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
        <div class="col s12">
            <div class="container">
                <!-- Current balance & total transactions cards-->
                <div class="row mt-4">
                    <div class="col s12 m4 l4">
                        <!-- Current Balance -->
                        <div class="card animate fadeLeft">
                            <div class="card-content">
                                <h4 class="card-title mb-0">Current Balance <i class="material-icons float-right">more_vert</i></h4>
                                <p class="medium-small"></p>

                                <h5 class="center-align">{{ balance() }}</h5>
                                <p class="medium-small center-align"></p>
                            </div>
                        </div>

                        <div class="card padding-4 animate fadeLeft">
                            <div class="col s5 m5">
                                <h5 class="mb-0">{{ $total_suppliers }}</h5>
                                <p class="no-margin">Suppliers</p>
                                <p class="mb-0 pt-8">{{ $transfers_total }}</p>
                            </div>
                            <div class="col s7 m7 right-align">
                                <i class="material-icons background-round mt-5 mb-5 gradient-45deg-purple-amber gradient-shadow white-text">perm_identity</i>
                                <p class="mb-0">Total Transfers</p>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m8 l8 animate fadeRight">
                        <!-- Total Transaction -->
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title mb-0">Total Transaction <i class="material-icons float-right">more_vert</i></h4>
                                <p class="medium-small">This month transaction</p>
                                <div class="total-transaction-container">
                                    <div id="total-transaction-line-chart" class="total-transaction-shadow"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Current balance & total transactions cards-->

                <div class="row">
                    <div class="col s12">
                        <div class="card subscriber-list-card animate fadeRight">
                            <div class="card-content pb-1">
                                <h4 class="card-title mb-0">Subscriber List <i class="material-icons float-right">more_vert</i></h4>
                            </div>
                            <table class="subscription-table responsive-table highlight">
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
                                @foreach($recent_transfers as $transfer)
                                    <tr>
                                        <td>
                                            <strong>{{ currency().number_format($transfer->amount,2) }}</strong> to
                                            <strong>{{ $transfer->supplier->name }}</strong> <br />
                                            <small>{{ $transfer->reason }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $transfer->account->number }}</strong>
                                            {{ $transfer->account->bank_name }}<br />
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
                        </div>
                    </div>
                </div>

                {{--TODO intro--}}
            </div>
        </div>
    </div>
@endsection

@section('vendor_scripts')
    <script src="{{ asset('vendors/chartjs/chart.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/chartist-js/chartist.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/chartist-js/chartist-plugin-tooltip.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/chartist-js/chartist-plugin-fill-donut.min.js') }}" type="text/javascript"></script>
@endsection
@section('page_scripts')
    <script src="{{ asset('js/scripts/dashboard-modern.js') }}" type="text/javascript"></script>
@endsection

