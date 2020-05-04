@extends('layouts.main')

@push('js')

@endpush

@push('css')
  <link rel="stylesheet" href="{{asset("css/account/account.css")}}">
@endpush

@section('content')
<div class="container">
  <div class="row mt-3">
    <div class="col-12 text-center">
      <h1>Account</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-6 col-md-2 padded">
      <img id="profile-pic" src="https://via.placeholder.com/150?text=PFP">
    </div>
    <div class="col-6 col-md-2 padded">
      <h2 id="username">Username</h2>
      <h2 id="email">Email</h2>
    </div>
    <div id="battleplan-list" class="list-group col-12 col-md-8 padded">
      <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1">Placeholder Name</h5>
        </div>
        <p class="mb-1">Placeholder description</p>
      </a>
    </div>
  </div>
</div>
@endsection
