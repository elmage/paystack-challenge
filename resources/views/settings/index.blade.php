@extends('layouts.material')
@section('title','Settings')


@section('content')
    <div class="row">
        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
        <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
            <!-- Search for small screen-->
            <div class="container">
                <div class="row">
                    <div class="col s10 m6 l6">
                        <h5 class="breadcrumbs-title mt-0 mb-0">Settings</h5>
                        <ol class="breadcrumbs mb-0">
                            <li class="breadcrumb-item active"></li>
                        </ol>
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
                                Modify settings below
                            </p>
                        </div>
                    </div>

                    <!-- Page Length Options -->
                    <div class="row">
                        <div class="col s12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col s12">
                                            <ul class="tabs" id="settings-tab">
                                                <li class="tab col m3"><a href="#profile">Profile</a></li>
                                                <li class="tab col m3"><a href="#preferences" class="{{ session('finalize_otp') || session('preference') ? 'active':'' }}">Preferences</a></li>
                                                <li class="tab col m3"><a href="#password">Change Password</a></li>
                                            </ul>
                                        </div>
                                        <div id="profile" class="col s12 m8 offset-m2 padding-2">
                                            <form class="col s12 m10 offset-m1" action="{{ route('profile.update') }}" method="post">
                                                @csrf
                                                @method('patch')
                                                <div class="row">
                                                    <div class="input-field col s12">
                                                        <input type="text" id="fn" name="name" value="{{ Auth::user()->name }}" required>
                                                        <label for="fn">Name</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="input-field col s12">
                                                        <input id="email" type="email" name="email" value="{{ Auth::user()->email }}" required>
                                                        <label for="email">Email</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="row">
                                                        <div class="input-field col s12">
                                                            <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Submit
                                                                <i class="material-icons right">send</i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="preferences" class="col s12 m8 offset-m2 padding-2">
                                            <div class="row">
                                                <div class="col s4">
                                                    <p><strong>Transfer Confirmation (OTP)</strong></p>
                                                </div>
                                                <div class="col s8 center">
                                                    @if(session('finalize_otp') )
                                                        <form class="col s12 m10 offset-m1" action="{{ route('otp.disable.finalize') }}" method="post">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="input-field col s8">
                                                                    <input id="otp-input" type="number" name="otp" value="" required>
                                                                    <label for="otp-input">Enter Otp</label>
                                                                </div>
                                                                <div class="input-field col s4">
                                                                    <button class="btn-small cyan waves-effect waves-light right" type="submit" name="action">Submit
                                                                        <i class="material-icons right">send</i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    @else
                                                        @if(cache('otp_status') == 1)
                                                            <form action="{{ route('otp.disable') }}" method="post">
                                                                @csrf
                                                                <button type="submit" class="btn-small red waves-effect waves-light">Disable</button>
                                                            </form>
                                                        @else
                                                            <form action="{{ route('otp.enable') }}" method="post">
                                                                @csrf
                                                                <button type="submit" class="btn-small green waves-effect waves-light">Enable</button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row" style="margin-top: 20px;">
                                                <div class="col s4">
                                                    <p><strong>Allow automatic topups when your balance is insufficient for a scheduled transfer?</strong></p>
                                                </div>
                                                <div class="col s8 center">
                                                    <div class="switch">
                                                        <label>
                                                            Off
                                                            <input id="auto-topup-switch" type="checkbox"{{ auto_topup() ? ' checked':'' }}>
                                                            <span class="lever"></span>
                                                            On
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="password" class="col s12 m8 offset-m2 padding-2">
                                            <form class="col s12 m10 offset-m1" action="{{ route('password.update') }}" method="post">
                                                @csrf
                                                @method('patch')
                                                <div class="row">
                                                    <div class="input-field col s12">
                                                        <input type="password" id="fn" name="current_password" value="" required>
                                                        <label for="fn">Current Password</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="input-field col s12">
                                                        <input id="pass" type="password" name="password" value="" required>
                                                        <label for="pass">New Password</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="input-field col s12">
                                                        <input id="pass-confirm" type="password" name="password_confirmation" value="" required>
                                                        <label for="pass-confirm">Confirm Password</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="row">
                                                        <div class="input-field col s12">
                                                            <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Update
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
        </div>
    </div>
@endsection


@section('page_scripts')
    <script>
        function payWithPaystack() {
            var handler = PaystackPop.setup({
                key: '{{ env('PAYSTACK_PK') }}',
                email: '{{ Auth::user()->email  }}',
                amount: {{ 5000 }},
                currency: "NGN",
                metadata: {
                    custom_fields: [
                        {
                            display_name: "{{ Auth::user()->name  }}",
                        }
                    ]
                },
                callback: function(response) {
                    console.log(response);
                    if ("success" === response.status)
                    {
                        $.post('/card/add/' + response.reference, {_token:'{{csrf_token()}}'}, function (response) {
                            if (response.state==='success') {
                                window.location.reload(true);
                            }
                            else { swal('Error!', response.msg, 'error'); }
                        });
                    } else {
                        swal('Error!', 'Failed to add card!', 'error');
                    }

                },
                onClose: function(){
                    //showToast('Transaction ended');
                }
            });
            handler.openIframe();
        }
    </script>
@endsection