@extends('layouts.material')
@section('title','Transfer Schedules')

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
                        <h5 class="breadcrumbs-title mt-0 mb-0">Transfer Schedules</h5>
                        <ol class="breadcrumbs mb-0">
                            <li class="breadcrumb-item"><a href="#!">Send Money</a></li>
                            <li class="breadcrumb-item">Transfers</li>
                            <li class="breadcrumb-item active">Schedules</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <div class="col s12">
            <div class="container">
                <div class="section section-data-tables">


                    <!-- Page Length Options -->
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div id="Form-advance" class="card card card-default scrollspy" style="height: 400px;">
                                <div class="card-content">
                                    <h4 class="card-title"></h4>
                                    <form class="col s12" action="{{ route('transfer.schedule.create') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="input-field col m6 s12">
                                                <input id="transfer_amount" name="amount" value="" min="100" type="number" required>
                                                <label for="transfer_amount">Amount ({{ currency() }})</label>
                                            </div>
                                            <div class="input-field col m6 s12">
                                                <input id="transfer_note" name="reason" value="" type="text">
                                                <label for="transfer_note">Transfer Note (optional)</label>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="input-field col m6 s12">
                                                <select id="select-supplier-id" name="supplier_id" required>
                                                    <option value="" disabled selected>Select Supplier</option>
                                                    @foreach($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="select-supplier-id">Select Supplier</label>
                                            </div>

                                            <div class="input-field col m6 s12">
                                                <select id="select-frequency" name="frequency" required>
                                                    <option value="" disabled selected>Select Frequency</option>
                                                    {{--<option value="once">Once</option>--}}
                                                    <option value="daily">Daily</option>
                                                    <option value="weekly">Weekly</option>
                                                    <option value="fortnightly">Fortnightly</option>
                                                    <option value="monthly">Monthly</option>
                                                </select>
                                                <label for="select-frequency">Select Frequency</label>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="input-field col m4 s12">
                                                <label for="start-date">Start Date</label>
                                                <input type="text" name="start" class="datepicker" id="start-date">
                                            </div>

                                            <div class="input-field col m4 s12">
                                                <label for="end-date">Stop Date</label>
                                                <input type="text" name="end" class="datepicker2" id="end-date">
                                            </div>

                                            <div class="input-field col s12 m4">
                                                <div class="input-field col s12">
                                                    <select id="select-status" name="status" required>
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                    <label for="select-status">Select Status</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="input-field col s12">
                                                <small class="text-muted left">Note: Transfers will be made to the primary account of the supplier.</small>
                                                <button class="btn cyan waves-effect waves-light right" id="submit-account-button" type="submit">Schedule Transfer
                                                    <i class="material-icons right">send</i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col s12">
                            <div class="card">
                                <div class="card-content">
                                    <h4 class="card-title">Schedules - {{ $schedules->total() }}</h4>
                                    <div class="row">
                                        <div class="col s12">

                                        </div>
                                        <div class="col s12">
                                            @if(cache('otp_status') == 0)
                                                <table class="highlight">
                                                    <thead>
                                                    <tr>
                                                        <th data-field="details">Transfer Details</th>
                                                        <th data-field="start-date">Start</th>
                                                        <th data-field="end-date">End</th>
                                                        <th data-field="frequency">Frequency</th>
                                                        <th data-field="status">Status</th>
                                                        <th data-field="action"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($schedules as $schedule)
                                                            <tr>
                                                                <td>
                                                                    <strong>{{ currency().number_format($schedule->amount,2) }}</strong> to
                                                                    <strong>{{ $schedule->supplier->name }}</strong> <br/>
                                                                    @if($schedule->reason) <small>Reason: {{ $schedule->reason }}</small> @endif
                                                                </td>
                                                                <td>
                                                                    {{ \Carbon\Carbon::parse($schedule->start)->toFormattedDateString() }}
                                                                </td>
                                                                <td>
                                                                    {{ \Carbon\Carbon::parse($schedule->end)->toFormattedDateString() }}
                                                                </td>
                                                                <td>
                                                                    {{ ucfirst($schedule->frequency) }}
                                                                </td>
                                                                <td>
                                                                    {{ $schedule->status ? 'Active':'Inactive' }}
                                                                </td>
                                                                <td>
                                                                    <form action="{{ route('transfer.schedule.delete') }}" method="post" id="delete-schedule-{{$schedule->id}}">
                                                                        @method('delete')
                                                                        @csrf
                                                                        <input type="hidden" name="id" value="{{ $schedule->id }}">
                                                                    </form>
                                                                    <form action="{{ route('transfer.schedule.toggle') }}" method="post" id="toggle-schedule-{{$schedule->id}}">
                                                                        @method('patch')
                                                                        @csrf
                                                                        <input type="hidden" name="id" value="{{ $schedule->id }}">
                                                                    </form>
                                                                    <button class="btn-small red waves-effect waves-light right" form="delete-schedule-{{$schedule->id}}" type="submit">
                                                                        Delete
                                                                    </button>
                                                                    @if($schedule->status)
                                                                        <button class="btn-small lime waves-effect waves-light right" form="toggle-schedule-{{$schedule->id}}" type="submit">
                                                                            <i class="material-icons">pause</i>
                                                                        </button>
                                                                    @else
                                                                        <button class="btn-small green waves-effect waves-light right" form="toggle-schedule-{{$schedule->id}}" type="submit">
                                                                            <i class="material-icons">play_arrow</i>
                                                                        </button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div style="text-align: center">
                                                    {{ $schedules->links() }}
                                                </div>
                                            @else
                                                <div class="center">
                                                    <p>Disable transfer OTP to use this functionality.</p> <br />
                                                    <a href="{{ route('settings') }}" class="btn cyan waves-effect waves-light">Go To Settings</a>
                                                </div>
                                            @endif
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
@section('page_scripts')
    <script>
        $('.datepicker').datepicker();
        $('.datepicker2').datepicker();
    </script>
@endsection