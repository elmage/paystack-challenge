@extends('layouts.material')
@section('title','Enter OTP')

@section('content')
    <div class="row">
        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
        <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
            <!-- Search for small screen-->
            <div class="container">
                <div class="row">
                    <div class="col s10 m6 l6">
                        <h5 class="breadcrumbs-title mt-0 mb-0">Enter OTP</h5>
                        <ol class="breadcrumbs mb-0">
                            <li class="breadcrumb-item"><a href="#!">Send Money</a></li>
                            <li class="breadcrumb-item"><a href="#!">Single Transfer</a></li>
                            <li class="breadcrumb-item active">Enter OTP</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m8 offset-m2">
            <div class="container">
                <div class="section section-data-tables">
                    <div class="card">
                        <div class="card-content">
                            <p class="caption mb-0">
                                Enter the otp sent to your phone/email.
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div id="Form-advance" class="card card card-default scrollspy">
                                <div class="card-content">
                                    <h4 class="card-title"></h4>
                                    <form class="col s12" action="{{ route('transfer.single.send_otp') }}" method="post">
                                        @csrf
                                        <div class="row">

                                            <div class="input-field col m6 s12">
                                                <input type="hidden" name="transfer_code" value="{{ $transfer->transfer_code }}">
                                                <input id="otp" name="otp" type="number" required>
                                                <label for="otp">Enter the otp sent to your phone/email.</label>
                                                <a href="javascript:void(0)" onclick="resendOtp('{{$transfer->transfer_code}}')">Resend OTP</a>
                                            </div>

                                            <div class="input-field col m6 s12">
                                                <button class="btn cyan waves-effect waves-light right" id="submit-account-button" type="submit">Send OTP
                                                    <i class="material-icons right">phone_iphone</i>
                                                </button>
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
    <script type="text/javascript">
        function resendOtp(code) {
            $.post('/transfer/single/resend-otp', {transfer_code: code,reason:'transfer',_token:'{{csrf_token()}}'}, function (response) {
                ///swal('Success!', response.message, 'success');
                M.toast({
                    html: response.message
                })
            });
        }
    </script>
@endsection

