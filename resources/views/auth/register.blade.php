@extends('layouts.main-bootstrap')

@push('css')
  <link rel="stylesheet" href="{{asset("css/authentication/authentication.css")}}">
@endpush

@section('content')
<div class="container">
  <div class="row">
      <div class="form card col-12 col-xl-4 text-center">
        <div class="alert alert-warning text-left" role="alert">
          We seem to be encountering a problem with @yahoo, @aol, @web and a handfull of other smaller providers blocking our emails.
          Currently guaranteed supported are <strong>@gmail, @hotmail, @outlook and @windowslive</strong>.
          We apologize for the inconvinience and are actively looking into the problem.
        </div>
        
        {{-- Login --}}
        <form class="login-form col-12" method="post" action="/register" >
          @csrf
          <input placeholder="Username" id="username" type="username" class="padded form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required>

          @if ($errors->has('username'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('username') }}</strong>
            </span>
          @endif

          <input placeholder="Email" id="email" type="email" class="padded form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

          @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
          @endif

          <input placeholder="Password" id="password"  type="password" class="padded form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

          @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
          @endif

          <input placeholder="Confirm Password" id="password-confirm" type="password" class="padded form-control" name="password_confirmation" required>

          <button type="submit" class="btn btn-success">Register</button>
          <p class="message">Already registered? <a href="/login">Sign In</a></p>
          <p class="message">Forgot password? <a href="/password/reset">Reset password</a></p>
      </form>
    </div>
  </div>
</div>
@endsection
