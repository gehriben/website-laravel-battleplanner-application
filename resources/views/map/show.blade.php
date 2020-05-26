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
  label {
    color: white;
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
    <img class="thumb" src="{{($map->thumbnail) ? $map->thumbnail->url() : 'https://via.placeholder.com/150'}}"></img>
  </div>

  <div class="row mt-3 justify-content-center">
    <div class="list-group col-12 col-md-5">
      @foreach ($map->floors as $floor)
        <div class="list-group-item list-group-item-action flex-column align-items-start">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">{{$floor->name}}</h5>
            <img class="thumb" src="{{ ($floor->source) ? $floor->source->url() : 'https://via.placeholder.com/150'}}"></img>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <div class="row mt-3 justify-content-center">
    <h5 style="color:white;">Competitive&nbsp;</h5>
    @if ($map->competitive)
    <i class="fa fa-check"></i>
    @else
    <i class="fas fa-times"></i>
    @endif
  </div>

  <div class="row mt-3 justify-content-center">
    <a type="button" href="/map/{{$map->id}}/edit" class="btn btn-success">Edit Map</a>
  </div>
</div>
@endsection
