@extends('layouts.main')

@push('js')
  <script src="{{asset("js/room/index.js")}}"></script>
  <script src="{{asset("js/room/join.js")}}"></script>
  <script>
    $(".new-room").click(function(dom){
      window.location.href = $(this).data("link");
    })
  </script>
@endpush

@push('css')
  <link rel="stylesheet" href="{{asset("css/room/index.css")}}">
@endpush

@section('content')
  <div class="container">
    @if (session('error'))
      <div class="row mt-3">
        <div class="alert alert-danger col-12" role="alert">
              {{ session('error')["error"] }}
        </div>
      </div>
    @endif
    <div class="row mt-3">
      <div data-link="/room/create" class="card new-room col-12 col-md-4 mt-2 text-center">
        <div class="container">
          <i class="fas fa-user-alt"></i>
          <h4><b>Host a New Room</b></h4>
        </div>
      </div>

      <div data-link="/room/join" class="card join-room col-12 col-md-4 mt-2 text-center">
        <div class="container">
          <i class="fas fa-user-friends"></i>
          <h4><b>Join an Existing Room</b></h4>
          <div class="row form-inline">
            <div class="form-group col-12">
              <input type="text" class="form-control text-center col-12 col-md-9" placeholder="Room #"id="room">
              <button type="button" onclick="join( $('#room').val() )" class="btn btn-success col-12 col-md-3">Join</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
