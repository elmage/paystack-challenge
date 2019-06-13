@extends('layouts.auth')

@section('content')

    <div id="login-page" class="row">
        <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
            <form class="login-form" action="{{ route('login') }}" method="post">
                @csrf
                <div class="row">
                    <div class="input-field col s12">
                        <h5 class="ml-4">{{ __('Login') }}</h5>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-2">mail</i>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <label for="username" class="center-align">{{ __('E-Mail Address') }}</label>
                    </div>
                </div>

                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-2">lock_outline</i>
                        <input id="password" type="password" name="password" required autocomplete="current-password">
                        <label for="password">{{ __('Password') }}</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m12 l12 ml-2 mt-1">
                        <p>
                            <label>
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span>Remember Me</span>
                            </label>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <button type="submit" class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">Login</button>
                    </div>
                </div>
                <div class="row">
                    @if (Route::has('password.request'))
                        <div class="input-field col s6 m6 l6">
                            <p class="margin right-align medium-small">
                                <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                            </p>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
