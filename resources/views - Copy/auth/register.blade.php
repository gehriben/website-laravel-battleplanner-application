@extends('layouts.main')

@push('css')
  <link rel="stylesheet" href="{{asset("css/register/register.css")}}">
@endpush

@section('content')

  <div class="form">

    {{-- Login --}}
    <form class="login-form" method="post" action="{{ route('register') }}" >
    @csrf
      <input placeholder="username" id="username" type="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required>

      @if ($errors->has('username'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('username') }}</strong>
        </span>
      @endif

      <input placeholder="email" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

      @if ($errors->has('email'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('email') }}</strong>
          </span>
      @endif

      <input placeholder="password" id="password"  type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

      @if ($errors->has('password'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('password') }}</strong>
          </span>
      @endif

      <input placeholder="password confirm" id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

      <button>Register</button>
      <p class="message">Already registered? <a href="/login">Sign In</a></p>
    </form>
    <p class="message">Forgot password? <a href="/password/reset">reset password</a></p>

  </div>

@endsection
