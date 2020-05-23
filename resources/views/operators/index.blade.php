@extends('layouts.main')

@push('js')

@endpush

@push('css')
  <link rel="stylesheet" href="{{asset("css/admin/admin.css")}}">
@endpush

@section('content')

<div class="container">
  <div class="row mt-3">
    <div class="col-12 text-center">
      <h1>Operators - Admin View</h1>
    </div>
  </div>

  <div class="row mt-3 justify-content-center">
    <div class="list-group col-12">
        @foreach ($ops as $op)
        <a href="operators/{{$op->id}}" class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">{{$op->name}}</h5>
            </div>
            <p class="mb-1">Click to view in detail</p>
        </a>
        @endforeach
    </div>
  </div>

  <div class="row mt-3 mb-3 justify-content-center">
    <a type="button" href="/operators/new" class="btn btn-success">Create new</a>
  </div>
</div>

@endsection
