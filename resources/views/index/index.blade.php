@extends('layouts.main-bootstrap')

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
      /* position: fixed; */
      bottom: 0px;
      /* top: 60px; */
    }

    .message-screen{
      /* display: none; */
      position: absolute;
      /* height:100%; */
      width:100%;
      color: white;
      z-index: 10;
      font-size: 120px;
      /* margin-top:50%; */
      /* font-family: Anton; */
      font-weight: bold;
    }

    .message-text{
      -webkit-text-stroke: 3px black; /* width and color */
    }
    .call-to-action{
      color: white;
      -webkit-text-stroke: 1px black; /* width and color */
      border-radius: 25px;
      margin: auto;
      font-size: 40px;
    }


    #nav-patreon {
      animation: color 7s linear infinite;
      /* animation-duration: 7s;
      animation-iteration-count: infinite; */
    }

    @keyframes color {
      0% {
        color: #757008;
      }
      50% {
        color: #f7ed11;
      }
      100% {
        color: #757008;
      }
    }

  </style>
@endpush

@section('content')
<div class="bg">
  <div class="shadow"></div>
</div>

<div class="content">

  <div class='col-12'>
    <div class="alert alert-danger text-left col-12 col-md-6" role="alert" style="margin:auto">
      Hey there, looks like you found the <strong>Beta</strong> version of our website! Keep in mind that anything you create on this version of the site may be <strong>deleted at anytime</strong> and will not be imported to the live production site. <br>
      The goal of this beta is to <strong>test features and stability</strong> of the platform. Thank you! <br>
      You will need to <strong>create new accounts for the Beta</strong>, if they stop working you may need to create them again.
    </div>
  </div>

  <div class="shadow"></div>

  <div class="message-screen">
      <div class="container h-100">
          <div class="row h-100 justify-content-center text-center align-items-center">
            <div class='col-12'>

              <div class="row">
                  <p class='col-12 message-text'>
                      Plan Your Victory
                  </p>
              </div>
              <div class="row">
                <a type="button" href='/battleplan/new' class="col-6 call-to-action btn btn-primary">Start!</a>
              </div>
            </div>
          </div>
      </div>
  </div>

</div>


@endsection
