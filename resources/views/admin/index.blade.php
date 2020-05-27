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
      <h1>Admin Section</h1>
    </div>
  </div>

  <div class="row mt-3">
    <div class="list-group col-12">
      <a href="/map" class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1">Maps</h5>
        </div>
        <p class="mb-1">Customize available Maps</p>
      </a>

      <a href="/operators" class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1">Operators</h5>
        </div>
        <p class="mb-1">Customize available Operators</p>
      </a>

        <a href="/gadgets" class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">Gadgets</h5>
        </div>
        <p class="mb-1">Customize available Gadgets</p>
        </a>

    </div>
  </div>
</div>
@endsection
