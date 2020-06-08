@extends('layouts.main')

@push('js')
  <!-- <script src="{{asset("js/index/index.js")}}"></script> -->
@endpush

@push('css')
  <link href="https://fonts.googleapis.com/css?family=Fredoka+One&display=swap" rel="stylesheet">
  <style>
    .shadow{
      background: -webkit-linear-gradient(top, rgba(0,0,0,.25), rgba(0,0,0, 1));

      height: 100%;
      width: 100%;
      position: fixed;
      bottom: 0px;
      top: 60px;
    }
    
    .message-screen{
      /* display: none; */
      position: absolute;
      /* height:100%; */
      width:100%;
      color: black;
      z-index: 10;
      font-size: 120px;
      /* margin-top:50%; */
      font-family: Anton;
      font-weight: bold;
    }

    .message-text{
      -webkit-text-stroke: 5px gold; /* width and color */
    }
    .call-to-action{
      color: black;
      -webkit-text-stroke: 1px gold; /* width and color */
      border-radius: 25px;
      margin: auto;
      font-size: 40px;
    }
  </style>
@endpush

@section('content')
<div class="bg"></div>
<div class="shadow"></div>

<div class="message-screen">
    <div class="container h-100">
        <div class="row h-100 justify-content-center text-center align-items-center">
          <div class='col-12'>

            <div class="row">
                <p class='col-12 message-text'>
                    Plan Your victory!
                </p>
            </div>
            <div class="row">
              <a type="button" href='/battleplan/new' class="col-6 call-to-action btn btn-primary">Start!</a>
            </div>
          </div>
        </div>
    </div>
</div>

@endsection
