@extends('layouts.app')

@section('content')
<div class="container">
    @if(Session::has('page_expired_error'))
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
          <strong>Page Expired!</strong> Please login to continue.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card login-page">
                <h2 class="title">{{ __('Log In') }}</h2>
                <p class="desc">Please enter your correct details for signing-in on "BorrowMe"</p>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right" style="display:none;">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-12">
                                <input id="email" type="email" placeholder="Email address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right" style="display:none;">{{ __('Password') }}</label>

                            <div class="col-md-12">
                                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link forgot-password" href="{{ route('password.request') }}">
                               <i class="fas fa-question-circle"></i> {{ __('Forgot Your Password?') }}
                            </a>
                        @endif

                        <div class="form-group row mt-2">
                            <div class="col-md-12">
                                <div class="form-check pl-0">
                                    <div class="checkbox">
                                      <label class="container form-check-label" for="remember">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class="checkmark"></span><span class="checkmark-title ml-3">{{ __('Remember Me') }}</span>
                                      </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-5 text-center">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary custom-button-padding btn-login-mobile">
                                    {{ __('Log In') }}
                                </button>
                            </div>
                        </div>

                        <div class="text-center social-login">
                            <a href="{{route('google_login')}}">
                                <button type="button" class="btn btn-outline-secondary mb-3 google-button">
                                <img src="{{ asset('/images/google-icon.png') }}" class="google-icon" />Continue with Google
                                </button>
                            </a>
                            <a href="{{route('facebook_login')}}">
                                <button type="button" class="btn btn-primary facebook-login">
                                <i class="fab fa-facebook-f"></i>Continue with Facebook
                                </button>
                            </a>
                        </div>
                        <div class="text-center mt-4">
                            <small>No account yet? <a href="/register">Sign up</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
