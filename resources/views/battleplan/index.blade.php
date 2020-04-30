@extends('layouts.main')

@push('js')
  <script src="{{asset("js/battleplan/index.js")}}"></script>
  <!-- <script>
    $.ajax({
      method: "POST",
      url: "/battleplan/create",
      data: {

      }
    })
  </script> -->
  
@endpush

@push('css')
  <!-- <link rel="stylesheet" href="{{asset("css/battleplan/index.css")}}"> -->
  <style media="screen">
      body{
        background-color: black;
        background-image: url("https://battleplanner-production.s3.ca-central-1.amazonaws.com/static/R6S.jpg");
      }
  </style>
@endpush

@section('content')
<div class="row">
  <div class="col-12 text-center">
    <h1>Battleplans</h1>
  <div>
</div>

<div class="row">
  <div class="col-12 text-center">
    <a type="button" href="/battleplan/new" class="col-5 btn btn-primary">Create</a>
  <div>
</div>



<hr>

<div class="list-group">
  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">List group item heading</h5>
      <small>3 days ago</small>
    </div>
    <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
    <small>Donec id elit non mi porta.</small>
  </a>
  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">List group item heading</h5>
      <small class="text-muted">3 days ago</small>
    </div>
    <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
    <small class="text-muted">Donec id elit non mi porta.</small>
  </a>
  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">List group item heading</h5>
      <small class="text-muted">3 days ago</small>
    </div>
    <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
    <small class="text-muted">Donec id elit non mi porta.</small>
  </a>
</div>

@endsection

@push('modals')

<div class="modal" id="copy" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Copy Battleplan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="copy-id">
                <h2>Save battleplan as</h2>
                <input class="col-4 form-control inline col-12" id="battleplan_name" value="" type="text">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" name="button" class="btn btn-success" onclick="copy()">Copy</button>
            </div>
        </div>
    </div>
</div>

@endpush
