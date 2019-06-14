@extends('layouts.material')
@section('title','Settings')


@section('content')
    <div class="row">
        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
        <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col s10 m6 l6">
                        <h5 class="breadcrumbs-title mt-0 mb-0">Transfers</h5>
                        <ol class="breadcrumbs mb-0">
                            <li class="breadcrumb-item"><a href="#!">Send Money</a></li>
                            <li class="breadcrumb-item active">Balance Topup</li>
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
                                Topup your Paystack balance below to transfer funds.
                            </p>
                        </div>
                    </div>

                    <!-- Page Length Options -->
                    <div class="row">
                        <div class="col s12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="row">
                                        <div id="topup" class="col s12 padding-2">

                                            @if($cards->isEmpty())
                                                <p class="center">To top up your Paystack balance, add a card below.</p>
                                                <div class="row">
                                                    <div class="col s12 m6 offset-m3">
                                                        <form >
                                                            <script src="https://js.paystack.co/v1/inline.js"></script>

                                                            <a href="#" onclick="payWithPaystack()">
                                                                <div class="card gradient-45deg-light-blue-cyan" style="height: 200px; border: 1px dashed rgba(0,0,0,0.3)">
                                                                    <div class="card-content white-text center">
                                                                        <h6 class="card-title font-weight-400"></h6>
                                                                        <p><strong></strong> <br /> <small></small></p>
                                                                    </div>

                                                                    <div class="card-action center">
                                                                        <p class="" style="margin-top: -20px;">
                                                                            <i class="material-icons" style="font-size: 50px; color: white;">add_circle_outline</i>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <small class="text-info center"><i class="fa fa-info"></i> Adding a card attracts a fee of {{currency()}}50. (Don't panic, the money goes to YOUR paystack balance ;))</small>
                                                        </form>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="row">
                                                    @foreach($cards as $card)
                                                        <div class="col s12 m4">
                                                            <div class="card gradient-45deg-light-blue-cyan" style="height: 200px; border: 1px dashed rgba(0,0,0,0.3)">
                                                                <div class="card-content white-text center">
                                                                    <h6 class="card-title font-weight-400"></h6>
                                                                    <p><strong></strong> <br /> <small></small></p>
                                                                </div>

                                                                <div class="card-action ">
                                                                    <h6 class="" style="margin-top: -15px;font-size: 20px;color: #ddd;letter-spacing: 5px;">{{$card->bin}}******{{ $card->last_4 }}</h6>
                                                                    <p><small style="color: #ccc; letter-spacing: 2px;">{{$card->exp_month}}/{{ substr($card->exp_year, -2) }}</small></p>
                                                                    @if (substr($card->bin,0,1) == 5)
                                                                        <div class="right" style="padding-top: 10px">
                                                                            <img src="{{ asset('images/icon/mc.png') }}">
                                                                        </div>
                                                                    @endif
                                                                    @if (substr($card->bin,0,1) == 4)
                                                                        <div class="right" style="padding-top: 30px">
                                                                            <img width="60px" src="{{ asset('images/icon/visa.png') }}">
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <form action="{{ route('card.remove') }}" method="post">
                                                                <input type="hidden" name="id" value="{{ $card->id }}">
                                                                @csrf
                                                                <button class="btn-small red waves-effect waves-light center">Remove</button>
                                                            </form>
                                                        </div>
                                                        <div class="col s12 m8">
                                                            <form class="col s12" action="{{ route('transfer.topup.charge') }}" method="post">
                                                                @csrf
                                                                <div class="row">

                                                                    <div class="input-field col m8 s12">
                                                                        <input type="hidden" name="card_id" value="{{ $card->id }}">
                                                                        <input id="amount" name="amount" type="number" required>
                                                                        <label for="amount">Enter topup amount ({{ currency() }})</label>
                                                                    </div>

                                                                    <div class="input-field col m6 s12">
                                                                        <button class="btn cyan waves-effect waves-light left" id="submit-account-button" type="submit">Top Up
                                                                            <i class="material-icons right">account_balance_wallet</i>
                                                                        </button>
                                                                    </div>

                                                                </div>
                                                            </form>
                                                        </div>
                                                    @endforeach

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