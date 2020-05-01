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
    <div class="row mt-3">
        @if (session('error'))
          <div class="alert alert-danger col-12" role="alert">
                {{ session('error')["error"] }}
          </div>
        @endif
    </div>
    <div class="row mt-3">
        <div data-link="/room/create" class="card new-room mt-2 text-center">
          <div class="container">
            <i class="fas fa-user-alt"></i>
            <h4><b>Host a New Room</b></h4>
          </div>
        </div>

        <div data-link="/room/join" class="card join-room mt-2 text-center">
          <div class="container">
            <i class="fas fa-user-friends"></i>
            <h4><b>Join an Existing Room</b></h4>
            <input type="text" class="form-control text-center" placeholder="Room #"id="room">
            <button type="button" onclick="join( $('#room').val() )" class="btn btn-success">Join</button>
          </div>
        </div>
    </div>
  </div>
@endsection
