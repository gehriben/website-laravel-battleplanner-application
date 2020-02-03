@extends('layouts.main')

@push('js')
  <script src="{{asset("js/room/join.js")}}"></script>
@endpush

@push('css')
  <link rel="stylesheet" href="{{asset("css/room/join.css")}}">
@endpush

@section('content')
    <div class="jumbotron text-center">
      <h1 class="display-4">Join a room</h1>
        <div class="col-12 text-center">
          <div class="row text-center">
            <div class="col-3"></div>
            <input type="text" class="col-6 form-control text-center" placeholder="room #"id="room">
            <div class="col-3"></div>
          </div>

          @if (session('error'))
            <div class="row text-center">
              <div class="col-3"></div>

              <div class="col-6" role="alert">
                {{ session('error')["error"] }}
              </div>

              <div class="col-3"></div>
            </div>
          @endif

          <button type="button" onclick="join( $('#room').val() )" class="mt-3 btn btn-success">Join</button>
        </div>
    </div>
@endsection
