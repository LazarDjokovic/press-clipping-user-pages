@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-6">
                                <h3 style="text-align: center; color:white;">PRIJAVI SE</h3>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <p style="text-align: center;"><img src="/images/logo.png" width="100px" style="max-width:100%;max-height:100%;" id="img-logo"></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label style="color:white;">Email: </label>
                                <input placeholder="Email" style="border: none; border-bottom: 2px solid gray; border-radius: 0px !important;" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label style="color:white;">Lozinka: </label>
                                <input placeholder="Lozinka" style="border: none; border-bottom: 2px solid gray; border-radius: 0px !important;" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6">
                                <button style="width: 100%; background-color: #00aced" type="submit" class="btn btn-primary">
                                    PRIJAVI SE
                                </button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                @if (Route::has('password.request'))
                                    <a style="float:right; color:white !important;" class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember" style="color:white;">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
