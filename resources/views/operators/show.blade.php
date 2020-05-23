@extends('layouts.main')

@push('js')
@endpush

@push('css')
  <link rel="stylesheet" href="{{asset("css/admin/admin.css")}}">
@endpush

@section('content')
<div class="container">
  <div class="row mt-3">
    <div class="card mt-3 col-12">
      <div class="col-12 mt-3 text-center">
        <h1>{{$op->name}}</h1>
      </div>

      <div class="row mt-3 text-center">
        <div class="col-12">
          <h5 style="color:white;">Icon&nbsp;</h5>
          <img class="icon" src="{{$op->media->url()}}"></img>
        </div>
      </div>

      <div class="row mb-3 justify-content-center">
        <div class="col-4">
          <h5 style="color:white;">Colour&nbsp;</h5>
          <div class="color" style="background-color: {{$op->colour}};"></div>
        </div>

        <div class="col-4">
          <h5 style="color:white;">Attacker&nbsp;</h5>
          @if ($op->atk)
          <i class="fa fa-check"></i>
          @else
          <i class="fas fa-times"></i>
          @endif
        </div>
      </div>

    </div>
  </div>
  <div class="row mt-3 justify-content-center">
    <a type="button" href="/operators/{{$op->id}}/edit" class="btn btn-success">Edit Operator</a>
  </div>
</div>
@endsection
