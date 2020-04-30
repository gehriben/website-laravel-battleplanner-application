@extends('layouts.main')

@push('js')

@endpush

@push('css')

@endpush

@section('content')
<h1 class="text-center">Admin Section</h1>
<div class="list-group">

  <a href="/map" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Maps</h5>
      <!-- <small>3 days ago</small> -->
    </div>
    <p class="mb-1">Customize available Maps</p>
    <!-- <small>Donec id elit non mi porta.</small> -->
  </a>

  <a href="/admin/operator" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Operators</h5>
      <!-- <small>3 days ago</small> -->
    </div>
    <p class="mb-1">Customize available Operators and their gadgets</p>
    <!-- <small>Donec id elit non mi porta.</small> -->
  </a>

    <a href="/admin/gadget" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">General Gadgets</h5>
        <!-- <small>3 days ago</small> -->
    </div>
    <p class="mb-1">Customize available General Gadgets</p>
    <!-- <small>Donec id elit non mi porta.</small> -->
    </a>

</div>

@endsection
