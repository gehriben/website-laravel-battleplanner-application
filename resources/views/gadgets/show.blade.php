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
        <h1>{{$gadget->name}}</h1>
      </div>

      <div class="row text-center">
        <div class="col-12 mt-3 col-xl-4 align-self-start">
          <h5 class="labeling">Icon&nbsp;</h5>
          <img class="icon" src="{{($gadget->icon) ? $gadget->icon->url() : 'https://via.placeholder.com/150'}}"></img>
        </div>
        @if(count($operators) != 0)
        <div class="col-12 mt-3 col-xl-8">
          <h5 class="labeling">Operators</h5>
          <div class="list-group">
            @foreach ($operators as $op)
            <a href="/operators/{{$op->id}}" class="list-group-item list-group-item-action flex-column align-items-start">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">{{$op->name}}</h5>
              </div>
              <p class="mb-1 text-left">Click to view in detail</p>
            </a>
            @endforeach
          </div>
        </div>
        @else
        <div class="col-12 d-none d-xl-block mt-3 col-xl-8">
          <h5 class="labeling">Operators</h5>
        </div>
        @endif
      </div>

      <div class="row mt-3 text-center">
      </div>

      <div class="row mb-3 justify-content-center">
      </div>

    </div>
  </div>
  <div class="row mt-3 justify-content-center">
    <a type="button" href="/gadgets/{{$gadget->id}}/edit" class="btn btn-success">Edit Gadget</a>
  </div>
</div>
@endsection
