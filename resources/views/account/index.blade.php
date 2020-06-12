@extends('layouts.main-bootstrap')

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

    <!-- <div class="col-12 col-xl-6 padded align-content-center">
      <img id="profile-pic" src="https://via.placeholder.com/150?text=PFP">
    </div> -->

    <div class="col-12 col-xl- padded">
      <div class='row'>
        <div class="label col-6">Username:</div>
        <div id="username" class='label col-6'>{{$user->username}}</div>
      </div>
      <div class='row'>
        <div class="label col-6">Email:</div>
        <div id="email" class='label col-6'>{{$user->email}}</div>
      </div>
    </div>
  </div>

  <hr>
  
  <div class="row text-center">
    <h2 class="col-12">My Battleplans</h2>
  </div>

  <div class="row">
    <div id="battleplan-list" class="list-group col-12 col-xl-12 padded">

    @foreach($battleplans as $battleplan)
      <a href="/battleplan/{{$battleplan->id}}" class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
          <h5 id="plan-title" class="mb-1">{{$battleplan->name}}</h5>
          <small id="plan-date">{{$battleplan->updated_at}}</small>
        </div>
        <div class="d-flex w-100 justify-content-between">
          <p id="plan-description" class="mb-1">&nbsp{{$battleplan->description}}</p>
          <small id="plan-map">{{$battleplan->map->name}}</small>
        </div>
      </a>
    @endforeach

    </div>
  </div>
</div>
@endsection
