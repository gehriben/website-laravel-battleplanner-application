@extends('layouts.main')

@push('js')
  <script src="{{asset("js/battleplan/index.js")}}"></script>
@endpush

@push('css')
  <link rel="stylesheet" href="{{asset("css/battleplan/index.css")}}">
@endpush

@section('content')
<div class="container">
  <div class="row mt-3">
    <div class="col-12 text-center">
      <h1>Public Plans</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-12 text-center">
      <a type="button" href="/battleplan/new" class="col-12 btn btn-success">Create New</a>
    </div>
  </div>

  <hr>

  <div class="row">
    <div id="public-list" class="list-group col-12">
      <a ref="#" class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
          <h5 id="plan-title" class="mb-1">List group item heading</h5>
          <small id="plan-date">3 days ago</small>
        </div>
        <div class="d-flex w-100 justify-content-between">
          <p id="plan-description" class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
        </div>
      </a>
    </div>
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
</div>
@endpush
