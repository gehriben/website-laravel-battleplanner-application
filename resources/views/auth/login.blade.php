@extends('layouts.main-bootstrap')

@push('css')
  <link rel="stylesheet" href="{{asset("css/authentication/authentication.css")}}">
@endpush

@section('content')
<div class="container">
  <div class="row">
    <div class="form card col-12 col-xl-6">

      <!-- <div class="alert alert-warning text-left" role="alert">
        We seem to be encountering a problem with @yahoo, @aol, @web and a handfull of other smaller providers blocking our emails.
        Currently guaranteed supported are <strong>@gmail, @hotmail, @outlook and @windowslive</strong>.
        We apologize for the inconvinience and are actively looking into the problem.
      </div> -->


        {{-- Login --}}
        <form class="login-form col-12" method="POST" action="/login" >
          @csrf
          <input placeholder="Username" id="username" type="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }} padded" name="username" value="{{ old('username') }}" required>

          @if ($errors->has('username'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('username') }}</strong>
            </span>
          @endif

          <input  placeholder="Password" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} padded" name="password" required>

          @if ($errors->has('password'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('password') }}</strong>
              </span>
          @endif

          <button type="submit" class="btn btn-success">Login</button>
          <p class="message">Not registered? <a href="/register">Create an account</a></p>
          <p class="message">Forgot password? <a href="/password/reset">Reset password</a></p>
        </form>
    </div>
  </div>
</div>
@endsection
