@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    <div class="row mb-2">
                        <div class="col-md-8 offset-md-4">
                            Oder mit anderer Plattform einloggen:
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-8 offset-md-4">
                            <div class="row my-8">
                                <div class="col-md-6">
                                    <a 
                                        title="Mit GitHub-Account einloggen!"
                                        href="{{ route('to_provider', ['provider'=> 'github']) }}">
                                    <img width="100" src="https://cdn1.vogel.de/unsafe/800x0/smart/images.vogel.de/vogelonline/bdb/1286800/1286845/original.jpg"></a>
                                   
                                </div>
    
                                <div class="col-md-6">
                                    <a 
                                        title="Mit GitLab-Account einloggen!"
                                        href="{{ route('to_provider', ['provider'=> 'gitlab']) }}">
                                    <img width="100" src="data:image/png;base64,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"></a>
                                   
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
