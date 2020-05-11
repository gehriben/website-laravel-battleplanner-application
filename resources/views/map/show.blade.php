@extends('layouts.main')

@push('js')
@endpush

@push('css')
  <link rel="stylesheet" href="{{asset("css/admin/admin.css")}}">
  <style>
  .list-group-item:hover{
    background-color: rgba(255, 255, 255, 0.5);
    color: black;
  }
  </style>
@endpush

@section('content')
<div class="container">
  <div class="row mt-3">
    <div class="col-12 text-center">
      <h1>{{$map->name}}</h1>
    </div>
  </div>

  <div class="row mt-3 justify-content-center">
    <div class="list-group col-12 col-md-5">
      @foreach ($map->floors as $floor)
        <div class="list-group-item list-group-item-action flex-column align-items-start">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">{{$floor->name}}</h5>
            <img class="thumb" src="{{$floor->media->url()}}"></img>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  @if ($map->is_competitive)
  <div class="row mt-3 justify-content-center">
    <h5 style="color:white;">Competitive</h5>
  </div>
  @endif

  <div class="row mt-3 justify-content-center">
    <a type="button" href="/map/{{$map->id}}/edit" class="btn btn-success">Edit Map</a>
  </div>
</div>
@endsection
