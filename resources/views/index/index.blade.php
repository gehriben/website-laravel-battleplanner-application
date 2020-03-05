@extends('layouts.main')

@push('js')
  <!-- <script src="{{asset("js/index/index.js")}}"></script> -->
@endpush

@push('css')
  <link href="https://fonts.googleapis.com/css?family=Fredoka+One&display=swap" rel="stylesheet">
  <!-- <link rel="stylesheet" href="{{asset("css/index/index.css")}}"> -->
  <style>
      body{
        background-color: black;
        background-image: url("https://battleplanner-production.s3.ca-central-1.amazonaws.com/static/R6S.jpg");
      }
      .card{
        max-height: 400px;
        margin:10px;
        background-color:grey;
        cursor: pointer;
      }
      
      .card:hover{
        background-color: lightgrey;
      }

      .card-text{
        color: #36ff36;
        -webkit-text-stroke: 1px black;
        font-size: 2em;
        font-family: 'Fredoka One', cursive;
      }


  </style>
@endpush

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md">

            <div class="card">
                <img src="https://via.placeholder.com/150x70" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text text-center">Profile</p>
                </div>
            </div>

        </div>

        <div class="col-md">

            <div class="card">
                <img src="https://via.placeholder.com/150x70" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text text-center">Start Creating</p>
                </div>
            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md">

            <div class="card">
                <img src="https://via.placeholder.com/150x70" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text text-center">Rooms</p>
                </div>
            </div>

        </div>

        <div class="col-md">

            <div class="card">
                <img src="https://via.placeholder.com/150x70" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text text-center">Public Plans</p>
                </div>
            </div>

        </div>

    </div>
</div>


@endsection
