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

  <style>
    .jumbotron{
      margin: auto;
      margin-top: 15px;
    }

    .fas{
      font-size: 100px;
    }

    .card {
      margin: auto;
      box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
      transition: 0.3s;
      width: 40%;
      height:300px;
      border-radius: 25px;
    }

    .alert{
      border-radius: 25px;
    }

    .new-room:hover {
      background-color: #dee0de;
    }

    .new-room .fas{
      color: green;
    }

    .new-room .container{
      margin-top: 15%;
    }

    .join-room .fas{
      color: blue;
    }

    .new-room{
      cursor: pointer;
    }

    .new-room:hover {
      box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }
    .head{
      background-color: white;
      border-radius: 25px;
    }
  </style>
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

      <div class="head text-center">
          <div class="text-center">
            <h1>Room Options</h1>
            <h5>Rooms are used to create battleplans. Any number of people can
                be connected to a single Room and any changes the Room's owner
                makes will appear for everyone else, allowing fluid planning and
                easy switching between all of your saved battleplans.
            </h5>
          </div>
        </div>
        
        <div data-link="/room/create" class="card new-room mt-2 text-center">
          <div class="container">
            <i class="fas fa-user-alt"></i>
            <h4><b>New Room</b></h4> 
            <p>Host your own room</p> 
          </div>
        </div>


        <div data-link="/room/join" class="card join-room mt-2 text-center">
          <div class="container">
            <i class="fas fa-user-friends"></i>
            <h4><b>Join Room</b></h4> 
            <p>Join existing room</p> 
            <input type="text" class="form-control text-center" placeholder="room #"id="room">
            <button type="button" onclick="join( $('#room').val() )" class="col-12 btn btn-success">Join</button>
          </div>
        </div>

      
    </div>
  </div>
@endsection
